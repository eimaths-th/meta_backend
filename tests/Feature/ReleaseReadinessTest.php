<?php

namespace Tests\Feature;

use App\Mail\ContactMail;
use App\Models\FormManage;
use App\Models\OpeningClosingTime;
use App\Models\ReceiptForm;
use App\Models\ReferentCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Release acceptance checks. All records are synthetic and rolled back.
 * Mail is faked; these tests never deliver messages to an external address.
 */
class ReleaseReadinessTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        config(['logging.default' => 'null']);
        Mail::fake();
        Carbon::setTestNow(Carbon::parse('2032-02-10 12:00:00'));
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_admin_can_create_a_form_and_reopen_its_editor_without_losing_the_draft(): void
    {
        $this->actingAs($this->user(1));
        $slug = uniqid('release-create-');
        $this->postJson('/create-form', ['form_name' => 'Release QA', 'slug' => $slug])
            ->assertOk()->assertJsonPath('status', 'success');
        $form = FormManage::where('slug', $slug)->firstOrFail();
        $this->assertSame((string) $form->id, (string) $form->sfield);
        $this->assertSame('auto', $form->banner_display['fit']);
        $this->get('/create-form?id='.$form->id)->assertOk()
            ->assertSee('id="banner-editor"', false)
            ->assertSee('name="footer_facebook"', false)
            ->assertDontSee('class="meta-footer', false);
        $this->get('/form-manage')->assertOk();
        $this->assertNotNull($form->fresh());
        $this->postJson('/create-form', ['form_name' => 'Duplicate', 'slug' => $slug])
            ->assertStatus(422)->assertJsonValidationErrors('slug');
    }

    public function test_report_shows_full_url_english_labels_and_thai_explanations(): void
    {
        $this->actingAs($this->user(1));
        $form = $this->form();
        $this->schedule($form, '2032-02-01 00:00:00', '2032-02-28 23:59:00');
        $url = route('form.show', ['slug' => $form->slug]);
        $page = $this->get('/forms-control')->assertOk()
            ->assertSee('SetTime Forms log')->assertSee('Opens at')->assertSee('Closes at')
            ->assertSee('ลิงก์ลงทะเบียน')->assertSee('lang="th"', false);
        $document = new \DOMDocument;
        @$document->loadHTML('<?xml encoding="UTF-8">'.$page->getContent());
        $xpath = new \DOMXPath($document);
        $link = $xpath->query('//a[@class="forms-control-public-link" and @href="'.$url.'"]')->item(0);
        $this->assertNotNull($link);
        $this->assertSame($url, trim($link->textContent));
    }

    public function test_unlinked_legacy_schedule_does_not_produce_a_broken_public_link(): void
    {
        $this->actingAs($this->user(1));
        $form = $this->form();
        $this->schedule($form, '2032-02-01 00:00:00', '2032-02-28 23:59:00');
        $form->delete();
        $page = $this->get('/forms-control')->assertOk()->assertSee('Not linked');
        $this->assertNull($page->viewData('entries')->firstWhere('route', $form->slug)['public_url']);
    }

    public function test_guest_can_submit_an_open_form_and_duplicate_submission_is_rejected(): void
    {
        $form = $this->form();
        $this->schedule($form, '2032-02-01 00:00:00', '2032-02-28 23:59:00');
        $payload = $this->registration($form);
        $this->get('/form/'.$form->slug)->assertOk();
        $this->post('/form/storeFormManage', $payload)
            ->assertRedirect(route('form.completed', ['sfield' => $form->slug]));
        $this->assertSame(1, ReceiptForm::where('sfield', $form->sfield)->count());
        Mail::assertSent(ContactMail::class, 1);
        $this->get(route('form.completed', ['sfield' => $form->slug]))->assertOk();
        $this->withHeader('X-Requested-With', 'XMLHttpRequest')
            ->postJson('/form/storeFormManage', $payload)->assertStatus(422);
        $this->assertSame(1, ReceiptForm::where('sfield', $form->sfield)->count());
    }

    /** @dataProvider closedPeriods */
    public function test_registration_cannot_be_submitted_outside_the_open_period(?array $period): void
    {
        $form = $this->form();
        if ($period) {
            $this->schedule($form, $period[0], $period[1]);
        }
        $this->get('/form/'.$form->slug)->assertStatus(504);
        $response = $this->withHeader('X-Requested-With', 'XMLHttpRequest')
            ->postJson('/form/storeFormManage', $this->registration($form));
        $this->assertSame(0, ReceiptForm::where('sfield', $form->sfield)->count(),
            'A registration was saved outside the open period; response '.$response->status());
        $this->assertContains($response->status(), [403, 409, 422, 504]);
        Mail::assertNothingSent();
    }

    public static function closedPeriods(): array
    {
        return [
            'before opening' => [['2032-02-11 00:00:00', '2032-02-28 23:59:00']],
            'after closing' => [['2032-02-01 00:00:00', '2032-02-09 23:59:00']],
            'no schedule' => [null],
        ];
    }

    public function test_a_page_opened_before_closing_cannot_submit_after_closing(): void
    {
        $form = $this->form();
        $this->schedule($form, '2032-02-01 00:00:00', '2032-02-10 12:00:00');
        $this->get('/form/'.$form->slug)->assertOk();

        Carbon::setTestNow(now()->addSecond());
        $this->postJson('/form/storeFormManage', $this->registration($form))
            ->assertStatus(422)->assertJsonValidationErrors('registration_period');
        $this->assertSame(0, ReceiptForm::where('sfield', $form->sfield)->count());
        Mail::assertNothingSent();
    }

    public function test_closed_registration_preserves_input_for_a_normal_browser_post(): void
    {
        $form = $this->form();
        $this->from('/form/'.$form->slug)
            ->post('/form/storeFormManage', $this->registration($form))
            ->assertRedirect('/form/'.$form->slug)
            ->assertSessionHas('error', 'Registration is currently closed. กรุณาตรวจสอบช่วงเวลาเปิดรับสมัคร')
            ->assertSessionHasInput('firstname', 'Release');
        $this->assertSame(0, ReceiptForm::where('sfield', $form->sfield)->count());
        Mail::assertNothingSent();
    }

    /** @dataProvider registrationBoundaries */
    public function test_registration_is_allowed_at_the_exact_opening_and_closing_times(string $time): void
    {
        $form = $this->form();
        $this->schedule($form, '2032-02-01 00:00:00', '2032-02-28 23:59:00');
        Carbon::setTestNow(Carbon::parse($time));
        $this->get('/form/'.$form->slug)->assertOk();
        $this->post('/form/storeFormManage', $this->registration($form))
            ->assertRedirect(route('form.completed', ['sfield' => $form->slug]));
        $this->assertSame(1, ReceiptForm::where('sfield', $form->sfield)->count());
        Mail::assertSent(ContactMail::class, 1);
    }

    public static function registrationBoundaries(): array
    {
        return ['opening' => ['2032-02-01 00:00:00'], 'closing' => ['2032-02-28 23:59:00']];
    }

    /** @dataProvider schedulePrecedence */
    public function test_report_page_and_submission_use_the_same_latest_schedule(bool $backdated, bool $expectedOpen): void
    {
        $form = $this->form();
        $this->schedule($form, '2032-02-01 00:00:00', '2032-02-28 23:59:00');
        $closed = $this->schedule($form, '2032-02-01 00:00:00', '2032-02-09 23:59:00');
        if ($backdated) {
            $closed->update(['created_at' => now()->subDay()]);
        }

        $this->get('/form/'.$form->slug)->assertStatus($expectedOpen ? 200 : 504);
        $response = $this->postJson('/form/storeFormManage', $this->registration($form));
        $response->assertStatus($expectedOpen ? 302 : 422);
        $this->assertSame($expectedOpen ? 1 : 0, ReceiptForm::where('sfield', $form->sfield)->count());
        $this->actingAs($this->user(1));
        $report = $this->get('/forms-control')->assertOk();
        $this->assertSame($expectedOpen ? 'open' : 'closed', $report->viewData('entries')->firstWhere('route', $form->slug)['state']);
        if ($expectedOpen) {
            Mail::assertSent(ContactMail::class, 1);
        } else {
            Mail::assertNothingSent();
        }
    }

    public static function schedulePrecedence(): array
    {
        return ['ID breaks tied timestamps' => [false, false], 'created time takes precedence over ID' => [true, true]];
    }

    /** @dataProvider publicSlugSchedules */
    public function test_public_slug_controls_registration_when_the_legacy_route_differs(bool $publicOpen): void
    {
        $form = $this->form();
        $form->update(['form_route' => uniqid('legacy-')]);
        $legacy = $this->schedule($form, '2032-02-01 00:00:00', $publicOpen ? '2032-02-09 23:59:00' : '2032-02-28 23:59:00');
        $legacy->update(['route' => $form->form_route]);
        $this->schedule($form, '2032-02-01 00:00:00', $publicOpen ? '2032-02-28 23:59:00' : '2032-02-09 23:59:00');

        $this->get('/form/'.$form->slug)->assertStatus($publicOpen ? 200 : 504);
        $this->postJson('/form/storeFormManage', $this->registration($form))
            ->assertStatus($publicOpen ? 302 : 422);
        $this->assertSame($publicOpen ? 1 : 0, ReceiptForm::where('sfield', $form->sfield)->count());
        if ($publicOpen) {
            $this->withHeader('X-Requested-With', 'XMLHttpRequest')
                ->postJson('/form/storeFormManage', $this->registration($form))
                ->assertStatus(422)->assertJsonPath('duplicate_field', 'name');
            Mail::assertSent(ContactMail::class, 1);
        } else {
            Mail::assertNothingSent();
        }
    }

    public static function publicSlugSchedules(): array
    {
        return ['public closed, legacy open' => [false], 'public open, legacy closed' => [true]];
    }

    /** @dataProvider readOnlyRoles */
    public function test_read_only_role_cannot_save_a_schedule_through_a_direct_request(int $level): void
    {
        $user = $this->user($level);
        $this->actingAs($user);
        $this->assertFalse($user->canManageForms());
        $form = $this->form();
        $response = $this->postJson('/save_times', [
            'route' => $form->slug, 'user_id' => $user->id,
            'opening_time' => '2032-02-01 00:00:00', 'closing_time' => '2032-02-28 23:59:00',
        ]);
        $this->assertSame(0, OpeningClosingTime::where('route', $form->slug)->count(),
            'A read-only role saved a schedule; response '.$response->status());
        $response->assertForbidden();
    }

    /** @dataProvider readOnlyRoles */
    public function test_read_only_role_cannot_open_the_form_editor_directly(int $level): void
    {
        $this->actingAs($this->user($level));
        $form = $this->form();
        $this->get('/create-form?id='.$form->id)->assertForbidden();
    }

    public static function readOnlyRoles(): array
    {
        return ['level 2' => [2], 'level 4' => [4], 'level 5' => [5], 'unknown role' => [9]];
    }

    /** @dataProvider readOnlyRoles */
    public function test_read_only_roles_cannot_bypass_other_form_management_endpoints(int $level): void
    {
        $this->actingAs($this->user($level));
        $form = $this->form();
        $schedule = $this->schedule($form, '2032-02-01 00:00:00', '2032-02-28 23:59:00');
        $original = $form->fresh()->getAttributes();
        $formCount = FormManage::count();

        foreach ([
            '/form-manage', '/form-manage/'.$form->id, '/select_route', '/forms-time',
            '/get-form-grades', '/get-packages-exam-mode', '/get-package-linked-grades',
        ] as $url) {
            $this->getJson($url)->assertForbidden();
        }
        foreach ([
            '/create-form', '/form-manage/store', '/form-manage/destroy', '/form-manage/duplicate',
            '/create-option-grade', '/create-bulk-grades', '/edit-option-grade',
            '/delete-option-grade', '/delete-all-grades', '/create-option-package',
            '/edit-option-package', '/delete-option-package', '/delete-all-packages',
            '/update-package-exam-mode', '/link-package-grades',
        ] as $url) {
            $this->postJson($url, ['id' => $form->id, 'form_id' => $form->id])->assertForbidden();
        }
        $this->deleteJson('/delete_control/'.$schedule->id)->assertForbidden();
        $this->assertSame($original, $form->fresh()->getAttributes());
        $this->assertSame($formCount, FormManage::count());
        $this->assertNotNull($schedule->fresh());
        $this->get('/forms-control')->assertOk()->assertDontSee('>Set Time<', false);
    }

    /** @dataProvider managingRoles */
    public function test_managing_roles_can_create_and_delete_schedules_and_cannot_spoof_the_author(int $level): void
    {
        $actor = $this->user($level);
        $otherUser = $this->user(2);
        $this->actingAs($actor);
        $form = $this->form();
        $this->get('/create-form?id='.$form->id)->assertOk();
        $this->get('/forms-time')->assertOk()->assertSee('data-schedule-form', false)
            ->assertSee('Closing Time')->assertSee('ต้องไม่อยู่ก่อนเวลาเปิด');
        $this->postJson('/save_times', [
            'route' => $form->slug, 'user_id' => $otherUser->id,
            'opening_time' => '2032-02-01T00:00', 'closing_time' => '2032-02-28T23:59',
        ])->assertOk()->assertJsonPath('redirect', route('formsControl'));
        $schedule = OpeningClosingTime::where('route', $form->slug)->sole();
        $this->assertSame((string) $actor->id, (string) $schedule->user_id);
        $this->assertSame('2032-02-01 00:00:00', $schedule->opening_time);
        $this->assertSame('2032-02-28 23:59:00', $schedule->closing_time);
        $this->delete('/delete_control/'.$schedule->id)->assertRedirect();
        $this->assertNull($schedule->fresh());
    }

    public static function managingRoles(): array
    {
        return ['level 0' => [0], 'level 1' => [1], 'level 3' => [3]];
    }

    public function test_guests_cannot_manage_forms_or_schedules(): void
    {
        $form = $this->form();
        $schedule = $this->schedule($form, '2032-02-01 00:00:00', '2032-02-28 23:59:00');
        $this->get('/create-form?id='.$form->id)->assertRedirect(route('login'));
        $this->getJson('/forms-time')->assertUnauthorized();
        $this->postJson('/save_times', [])->assertUnauthorized();
        $this->postJson('/form-manage/destroy', ['id' => $form->id])->assertUnauthorized();
        $this->deleteJson('/delete_control/'.$schedule->id)->assertUnauthorized();
        $this->assertNotNull($form->fresh());
        $this->assertNotNull($schedule->fresh());
    }

    public function test_schedule_end_must_not_precede_its_start(): void
    {
        $user = $this->user(1);
        $this->actingAs($user);
        $form = $this->form();
        $response = $this->postJson('/save_times', [
            'route' => $form->slug, 'user_id' => $user->id,
            'opening_time' => '2032-02-28 23:59:00', 'closing_time' => '2032-02-01 00:00:00',
        ]);
        $this->assertSame(0, OpeningClosingTime::where('route', $form->slug)->count(),
            'An inverted schedule was saved; response '.$response->status());
        $response->assertStatus(422)->assertJsonValidationErrors('closing_time');
    }

    /** @dataProvider invalidScheduleDates */
    public function test_invalid_schedule_dates_are_rejected_without_creating_a_record(string $field, ?string $value): void
    {
        $this->actingAs($this->user(1));
        $form = $this->form();
        $payload = [
            'route' => $form->slug,
            'opening_time' => '2032-02-01T00:00', 'closing_time' => '2032-02-28T23:59',
        ];
        $payload[$field] = $value;
        $this->postJson('/save_times', $payload)->assertStatus(422)->assertJsonValidationErrors($field);
        $this->assertSame(0, OpeningClosingTime::where('route', $form->slug)->count());
    }

    public static function invalidScheduleDates(): array
    {
        return [
            'invalid opening' => ['opening_time', 'not-a-date'],
            'invalid closing' => ['closing_time', '2032-02-31T23:59'],
            'missing opening' => ['opening_time', null],
            'missing closing' => ['closing_time', null],
        ];
    }

    public function test_invalid_schedule_from_a_normal_post_displays_validation_errors_on_the_report(): void
    {
        $this->actingAs($this->user(1));
        $form = $this->form();
        $this->from('/forms-control')->post('/save_times', [
            'route' => $form->slug,
            'opening_time' => '2032-02-28T23:59', 'closing_time' => '2032-02-01T00:00',
        ])->assertRedirect('/forms-control')->assertSessionHasErrors('closing_time')
            ->assertSessionHasInput('opening_time', '2032-02-28T23:59');
        $this->get('/forms-control')->assertOk()->assertSee('Closing time must be on or after opening time.')
            ->assertSee('ยังไม่ได้บันทึก');
        $this->assertSame(0, OpeningClosingTime::where('route', $form->slug)->count());
    }

    public function test_schedule_can_save_equal_boundaries_without_a_client_user_id(): void
    {
        $this->actingAs($this->user(1));
        $form = $this->form();
        $this->post('/save_times', [
            'route' => $form->slug,
            'opening_time' => '2032-02-10T12:00', 'closing_time' => '2032-02-10T12:00',
        ])->assertRedirect(route('formsControl'))->assertSessionHas('success');
        $schedule = OpeningClosingTime::where('route', $form->slug)->sole();
        $this->assertSame((string) auth()->id(), (string) $schedule->user_id);
        $this->get('/form/'.$form->slug)->assertOk();
    }

    public function test_schedule_dates_with_offsets_are_stored_in_application_timezone(): void
    {
        $this->actingAs($this->user(1));
        $form = $this->form();
        $this->postJson('/save_times', [
            'route' => $form->slug,
            'opening_time' => '2032-02-10T12:00:00+07:00',
            'closing_time' => '2032-02-10T06:00:00+00:00',
        ])->assertOk();
        $schedule = OpeningClosingTime::where('route', $form->slug)->sole();
        $this->assertSame('2032-02-10 12:00:00', $schedule->opening_time);
        $this->assertSame('2032-02-10 13:00:00', $schedule->closing_time);
        $this->get('/form/'.$form->slug)->assertOk();
    }

    public function test_referent_code_edit_changes_only_the_selected_record_and_keeps_its_code(): void
    {
        $this->actingAs($this->user(1));
        $firstCode = $this->postJson('/referent_code', ['referent_name' => 'Release QA First'])
            ->assertOk()->assertJsonPath('success', true)->json('code');
        $secondCode = $this->postJson('/referent_code', ['referent_name' => 'Release QA Second'])
            ->assertOk()->assertJsonPath('success', true)->json('code');
        $first = ReferentCode::where('referent_code', $firstCode)->firstOrFail();
        $second = ReferentCode::where('referent_code', $secondCode)->firstOrFail();
        $this->getJson('/referent_code/edit?id='.$second->id)
            ->assertOk()->assertJsonPath('referent_code.id', $second->id);
        $this->postJson('/referent_code/edit', [
            'id' => $second->id, 'referent_name' => 'Release QA Updated', 'comments' => 'Synthetic test',
        ])->assertOk()->assertJsonPath('success', true);
        $this->assertSame('Release QA First', $first->fresh()->referent_name);
        $this->assertSame('Release QA Updated', $second->fresh()->referent_name);
        $this->assertSame($secondCode, $second->fresh()->referent_code);
    }

    private function user(int $level): User
    {
        return User::create([
            'name' => 'Release QA', 'email' => uniqid('release-qa-').'@example.com',
            'password' => bcrypt('test-password'), 'level' => $level,
        ]);
    }

    private function form(): FormManage
    {
        $slug = uniqid('release-qa-');
        $settings = array_fill_keys(array_keys(config('form_fields')), ['enabled' => false, 'required' => false]);
        foreach (['student_first_name', 'student_last_name', 'contact_email'] as $key) {
            $settings[$key] = ['enabled' => true, 'required' => true];
        }
        $form = FormManage::create([
            'form_name' => 'Release QA', 'form_route' => $slug, 'slug' => $slug,
            'title' => 'Registration', 'field_settings' => $settings,
            'show_footer' => true, 'enable_exam_mode' => false,
        ]);
        $form->update(['sfield' => (string) $form->id]);
        return $form;
    }

    private function schedule(FormManage $form, string $opening, string $closing): OpeningClosingTime
    {
        return OpeningClosingTime::create([
            'route' => $form->slug, 'opening_time' => $opening, 'closing_time' => $closing,
            'user_id' => auth()->id() ?? $this->user(1)->id, 'status' => 'Online',
        ]);
    }

    private function registration(FormManage $form): array
    {
        return [
            'sfield' => (string) $form->id, 'routeName' => $form->form_route,
            'firstname' => 'Release', 'lastname' => 'Customer',
            'email' => 'release-customer@example.com',
        ];
    }
}
