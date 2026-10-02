<?php

namespace Tests\Feature;

use App\Models\FormManage;
use App\Models\OpeningClosingTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class FormsControlHomeTest extends TestCase
{
    use DatabaseTransactions;

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_both_login_flows_and_old_home_links_land_on_the_correct_work_area(): void
    {
        Event::fake([Login::class]);
        foreach ([0, 1, 2, 3, 4, 5] as $level) {
            $user = $this->user($level);
            $expected = '/forms-control';

            foreach (['/custom-login', '/login'] as $loginUrl) {
                Auth::logout();
                $this->flushSession();
                $this->post($loginUrl, ['email' => $user->email, 'password' => 'test-password'])
                    ->assertRedirect($expected);
                $this->assertAuthenticatedAs($user);
                $this->get('/')->assertRedirect($expected);
                $this->get('/home')->assertRedirect($expected);
                $this->get('/Home')->assertRedirect($expected);
                $this->get('http://form.infinitebrain.co.th/')->assertRedirect($expected);
            }

            $header = view('layouts.header')->render();
            $document = new \DOMDocument;
            @$document->loadHTML('<?xml encoding="UTF-8">' . $header);
            $xpath = new \DOMXPath($document);
            $logo = $xpath->query('//div[contains(@class,"app-header__logo")]/a')->item(0);
            $this->assertSame(url($expected), $logo->getAttribute('href'));
        }
    }

    public function test_home_and_forms_control_still_require_login(): void
    {
        foreach (['/', '/home', '/Home', '/forms-control'] as $url) {
            $this->get($url)->assertRedirect(route('login'));
        }
    }

    public function test_latest_schedules_show_three_states_and_open_forms_first_without_writing_records(): void
    {
        Carbon::setTestNow(Carbon::parse('2032-02-10 12:00:00'));
        $this->actingAs($this->user(1));
        $closed = $this->form('ปิดแล้ว');
        $upcoming = $this->form('รอเปิด');
        $open = $this->form('เปิดรับสมัคร');
        $this->schedule($closed, '2032-02-01 09:00:00', '2032-02-09 18:00:00');
        $old = $this->schedule($upcoming, '2032-02-01 09:00:00', '2032-02-28 18:00:00');
        $current = $this->schedule($upcoming, '2032-02-11 09:00:00', '2032-02-28 18:00:00');
        $this->schedule($open, '2032-02-01 09:00:00', '2032-02-28 18:00:00');
        $before = OpeningClosingTime::get()->map->getAttributes()->all();

        $response = $this->get('/forms-control')->assertOk();
        $entries = $response->viewData('entries')->whereIn('route', [$open->slug, $upcoming->slug, $closed->slug])->values();
        $this->assertSame(['open', 'upcoming', 'closed'], $entries->pluck('state')->all());
        $this->assertSame([$open->form_name, $upcoming->form_name, $closed->form_name], $entries->pluck('name')->all());
        $this->assertSame([$old->id], $entries[1]['history']->pluck('id')->all());
        $this->assertSame($before, OpeningClosingTime::get()->map->getAttributes()->all());

        $response->assertSee(route('create-form', ['id' => $open->id]), false)
            ->assertSee(route('receipts_form', ['sfield' => $open->sfield]), false)
            ->assertSee(route('receipts', ['sfield' => $open->sfield]), false)
            ->assertSee(route('form.show', ['slug' => $open->slug]), false)
            ->assertDontSee('META Knowledge Dashboard');

        // A newer schedule wins even when both were created in the same second.
        $this->get('/form/' . $upcoming->slug)->assertStatus(504);
        $this->assertSame('Offline', $current->fresh()->status);
    }

    public function test_opening_and_closing_boundaries_match_public_registration(): void
    {
        $this->actingAs($this->user(3));
        $form = $this->form('Boundary');
        $this->schedule($form, '2032-02-10 09:00:00', '2032-02-10 18:00:00');
        foreach (['08:59:59' => 'upcoming', '09:00:00' => 'open', '18:00:00' => 'open', '18:00:01' => 'closed'] as $time => $state) {
            Carbon::setTestNow(Carbon::parse('2032-02-10 ' . $time));
            $response = $this->get('/forms-control')->assertOk();
            $this->assertSame($state, $response->viewData('entries')->firstWhere('route', $form->slug)['state']);
        }
    }

    public function test_form_shortcuts_keep_existing_roles_and_the_staff_report_is_removed(): void
    {
        $form = $this->form('Permissions');
        $this->actingAs($this->user(1));
        $this->schedule($form, now()->subDay()->toDateTimeString(), now()->addDay()->toDateTimeString());
        foreach ([0, 1, 2, 3, 4, 5] as $level) {
            $this->actingAs($this->user($level));
            $response = $this->get('/forms-control')->assertOk()
                ->assertDontSee('รายงานการทำงาน')
                ->assertDontSee('href="' . route('home2') . '"', false);
            if (in_array($level, [0, 1, 3], true)) {
                $response->assertSee(route('create-form', ['id' => $form->id]), false);
            } else {
                $response->assertDontSee(route('create-form', ['id' => $form->id]), false)
                    ->assertDontSee('forms-control-heading-actions');
                $this->get('/Home')->assertRedirect('/forms-control');
            }
        }
    }

    public function test_form_list_shortcut_does_not_delete_unfinished_forms(): void
    {
        $this->actingAs($this->user(1));
        $draft = FormManage::create(['form_name' => 'Unfinished form', 'form_route' => null]);
        $this->get(route('form-manage.index'))->assertOk();
        $this->assertNotNull($draft->fresh());
    }

    private function user(int $level): User
    {
        return User::create(['name' => 'Forms home test', 'email' => uniqid('forms-home-') . '@example.com', 'password' => bcrypt('test-password'), 'level' => $level]);
    }

    private function form(string $name): FormManage
    {
        $slug = uniqid('home-test-');
        $form = FormManage::create(['form_name' => $name, 'slug' => $slug, 'form_route' => $slug]);
        $form->update(['sfield' => (string) $form->id]);
        return $form;
    }

    private function schedule(FormManage $form, string $opening, string $closing): OpeningClosingTime
    {
        return OpeningClosingTime::create(['route' => $form->slug, 'opening_time' => $opening, 'closing_time' => $closing, 'user_id' => auth()->id(), 'status' => 'Online']);
    }
}
