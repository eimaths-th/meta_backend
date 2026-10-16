<?php

namespace Tests\Feature;

use App\Models\FormManage;
use App\Models\OpeningClosingTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class FormScheduleDisplayTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('These isolated form tests require pdo_sqlite.');
        }

        // Never run these regression tests against the configured application database.
        config([
            'database.default' => 'form_dates_test',
            'database.connections.form_dates_test' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
            'session.driver' => 'array',
            'logging.default' => 'null',
        ]);
        $this->travelTo(Carbon::parse('2026-10-16 12:00:00', 'Asia/Bangkok'));

        Schema::create('forms_manage', function (Blueprint $table) {
            $table->id();
            $table->string('form_name');
            $table->string('form_route');
            $table->string('slug')->nullable();
            $table->string('registration_date_label');
            $table->string('contest_date_label');
            $table->string('contest_date');
            $table->timestamps();
        });
        Schema::create('opening_closing_times', function (Blueprint $table) {
            $table->id();
            $table->string('route');
            $table->string('status')->default('Offline');
            $table->dateTime('opening_time')->nullable();
            $table->dateTime('closing_time')->nullable();
            $table->timestamps();
        });
        foreach (['forms_grades', 'forms_pakages'] as $tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('form_id');
            });
        }

        $this->actingAs((new User(['name' => 'Form test admin', 'level' => 1]))
            ->forceFill(['id' => 1]));
    }

    public function test_preview_and_public_page_show_the_same_saved_dates_using_the_public_slug(): void
    {
        $form = $this->form();
        $this->schedule($form->form_route, [
            'opening_time' => '2024-09-20 00:00:00',
            'closing_time' => '2024-10-25 00:00:00',
        ]);
        $this->schedule($form->slug);

        foreach (["/form/{$form->slug}", "/form-manage/{$form->id}"] as $url) {
            $this->get($url)->assertOk()
                ->assertSee('20 September 2026 - 21 November 2026')
                ->assertSee('11/28/2026 - 11/28/2026')
                ->assertDontSee('Today - 25 October 2024');
        }
    }

    public function test_preview_displays_a_closed_schedule_without_changing_its_status(): void
    {
        $form = $this->form();
        $schedule = $this->schedule($form->slug, [
            'opening_time' => '2025-09-20 00:00:00',
            'closing_time' => '2025-11-21 00:00:00',
            'status' => 'Offline',
        ]);

        $this->get("/form-manage/{$form->id}")->assertOk()
            ->assertSee('20 September 2025 - 21 November 2025')
            ->assertDontSee('null date');

        $this->assertSame('Offline', $schedule->fresh()->status);
        $this->get("/form/{$form->slug}")->assertStatus(504);
    }

    /** @dataProvider unavailableScheduleProvider */
    public function test_preview_shows_an_unavailable_message_instead_of_inventing_a_date(?array $schedule): void
    {
        $form = $this->form();
        if ($schedule !== null) {
            $this->schedule($form->slug, $schedule);
        }

        $this->get("/form-manage/{$form->id}")->assertOk()
            ->assertSee('Registration schedule unavailable')
            ->assertDontSee('Today - 25 October 2024');
    }

    public static function unavailableScheduleProvider(): array
    {
        return [
            'no schedule' => [null],
            'missing opening time' => [['opening_time' => null]],
            'missing closing time' => [['closing_time' => null]],
        ];
    }

    public function test_legacy_form_preview_uses_the_internal_route_when_no_slug_exists(): void
    {
        $form = $this->form(['slug' => null]);
        $this->schedule($form->form_route);

        $this->get("/form-manage/{$form->id}")->assertOk()
            ->assertSee('20 September 2026 - 21 November 2026');
    }

    public function test_public_availability_and_display_select_the_same_latest_schedule(): void
    {
        $form = $this->form();
        $this->schedule($form->slug, [
            'opening_time' => '2024-09-20 00:00:00',
            'closing_time' => '2024-10-25 00:00:00',
            'created_at' => '2026-10-16 09:00:00',
        ]);
        // Historical imports can make created_at order differ from ID order.
        $this->schedule($form->slug, ['created_at' => '2026-09-15 09:00:00']);

        $this->get("/form/{$form->slug}")->assertOk()
            ->assertSee('20 September 2026 - 21 November 2026');
        $this->get("/form-manage/{$form->id}")->assertOk()
            ->assertSee('20 September 2026 - 21 November 2026');
    }

    public function test_view_without_a_date_variable_never_falls_back_to_a_hard_coded_year(): void
    {
        $html = view('forms_manage.view', [
            'form' => $this->form(),
            'errors' => new ViewErrorBag,
        ])->render();

        $this->assertStringContainsString('Registration schedule unavailable', $html);
        $this->assertStringNotContainsString('Today - 25 October 2024', $html);
    }

    private function form(array $attributes = []): FormManage
    {
        return FormManage::create(array_merge([
            'form_name' => 'Spelling Bee 2026',
            'form_route' => 'internal-spelling-bee',
            'slug' => 'spelling-bee-2026',
            'registration_date_label' => 'Registration Date',
            'contest_date_label' => 'Exam Date',
            'contest_date' => '11/28/2026 - 11/28/2026',
        ], $attributes));
    }

    private function schedule(string $route, array $attributes = []): OpeningClosingTime
    {
        return OpeningClosingTime::create(array_merge([
            'route' => $route,
            'opening_time' => '2026-09-20 00:00:00',
            'closing_time' => '2026-11-21 00:00:00',
            'status' => 'Online',
        ], $attributes));
    }
}
