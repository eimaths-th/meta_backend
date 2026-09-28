<?php

namespace Tests\Feature;

use App\Mail\ContactMail;
use App\Models\EmailAuditLog;
use App\Models\FormManage;
use App\Models\Receipt;
use App\Models\ReceiptForm;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Mail\PendingMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Tests\TestCase;

class EmailAuditResendTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('These isolated email tests require pdo_sqlite.');
        }

        // Never use the application's configured database or SMTP account.
        config([
            'database.default' => 'email_audit_test',
            'database.connections.email_audit_test' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
            'logging.default' => 'null',
            'session.driver' => 'array',
        ]);
        $this->withoutVite();
        Mail::fake();

        Schema::create('receipt_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rec_id')->nullable();
            $table->string('sfield');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->timestamps();
        });
        Schema::create('forms_manage', function (Blueprint $table) {
            $table->id();
            $table->string('sfield');
            $table->string('form_name');
            $table->timestamps();
        });
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->boolean('cancle')->default(false);
            $table->timestamps();
        });
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action');
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('model_type')->nullable();
            $table->string('model_id')->nullable();
            $table->json('data_before')->nullable();
            $table->json('data_after')->nullable();
            $table->timestamps();
        });
        (require database_path('migrations/2026_04_17_155000_create_email_audit_logs_table.php'))->up();

        $this->actingAs((new User([
            'name' => 'Email test admin',
            'email' => 'admin@example.com',
            'level' => 1,
        ]))->forceFill(['id' => 1]));

        FormManage::forceCreate(['id' => 65, 'sfield' => '65', 'form_name' => 'Spelling Bee Test']);
    }

    /** @dataProvider previousSendProvider */
    public function test_audit_page_can_resend_with_or_without_a_previous_send(bool $previouslySent): void
    {
        $this->travelTo(now()->startOfSecond());
        $form = $this->registration();
        if ($previouslySent) {
            EmailAuditLog::LogEmailAction($form->id, null, $form->email, 'send');
        }

        $page = $this->get(route('email-audit-logs.index'))->assertOk();
        $button = $this->resendButton($page->getContent(), $form->id);
        $this->assertFalse($button->hasAttribute('disabled'));
        $this->assertSame($previouslySent ? '1' : '0', $button->getAttribute('data-has-sent'));

        // Submit to the exact URL rendered on the audit page.
        $this->postJson($button->getAttribute('data-url'))
            ->assertOk()
            ->assertJsonPath('status', 'success');

        Mail::assertSent(ContactMail::class, function (ContactMail $mail) use ($form) {
            return $mail->hasTo($form->email) && $mail->data->id === $form->id;
        });
        Mail::assertSent(ContactMail::class, 1);
        $this->assertDatabaseHas('email_audit_logs', [
            'receipt_form_id' => $form->id,
            'old_email' => $form->email,
            'new_email' => $form->email,
            'action' => 'resend',
            'changed_by' => 1,
        ]);
        $this->assertDatabaseCount('email_audit_logs', $previouslySent ? 2 : 1);

        $this->get(route('email-audit-logs.index'))
            ->assertOk()
            ->assertViewHas('forms', function ($forms) {
                return $forms->first()->last_email_send_audit->action === 'resend';
            });
    }

    public static function previousSendProvider(): array
    {
        return ['never sent' => [false], 'already sent' => [true]];
    }

    /** @dataProvider unavailableRegistrationProvider */
    public function test_unavailable_registration_is_disabled_and_cannot_be_sent(array $attributes, bool $cancelled): void
    {
        if ($cancelled) {
            $attributes['rec_id'] = Receipt::create(['cancle' => true])->id;
        }
        $form = $this->registration($attributes);
        $page = $this->get(route('email-audit-logs.index'))->assertOk();
        $this->assertTrue($this->resendButton($page->getContent(), $form->id)->hasAttribute('disabled'));

        $this->postJson(route('receipts_form.resend_mail', $form->id))->assertStatus(422);
        Mail::assertNothingSent();
        $this->assertDatabaseCount('email_audit_logs', 0);
    }

    public static function unavailableRegistrationProvider(): array
    {
        return [
            'missing email' => [['email' => null], false],
            'invalid email' => [['email' => 'invalid-address'], false],
            'excluded field zero as string' => [['sfield' => '0'], false],
            'excluded field seventeen as string' => [['sfield' => '17'], false],
            'cancelled receipt' => [[], true],
        ];
    }

    public function test_user_without_send_permission_cannot_resend(): void
    {
        $form = $this->registration();
        $this->actingAs((new User(['level' => 4]))->forceFill(['id' => 2]));

        $page = $this->get(route('email-audit-logs.index'))->assertOk();
        $this->assertTrue($this->resendButton($page->getContent(), $form->id)->hasAttribute('disabled'));
        $this->postJson(route('receipts_form.resend_mail', $form->id))->assertForbidden();
        Mail::assertNothingSent();
        $this->assertDatabaseCount('email_audit_logs', 0);
    }

    public function test_smtp_failure_does_not_create_a_success_audit(): void
    {
        $form = $this->registration();
        $pendingMail = Mockery::mock(PendingMail::class);
        $pendingMail->shouldReceive('send')->once()->andThrow(new \RuntimeException('SMTP authentication failed'));
        Mail::shouldReceive('to')->once()->with($form->email)->andReturn($pendingMail);

        $this->postJson(route('receipts_form.resend_mail', $form->id))
            ->assertStatus(500)
            ->assertJsonPath('status', 'error');
        $this->assertDatabaseCount('email_audit_logs', 0);
    }

    private function registration(array $attributes = []): ReceiptForm
    {
        return ReceiptForm::create(array_merge([
            'sfield' => '65',
            'first_name' => 'Test',
            'last_name' => 'Applicant',
            'email' => 'applicant@example.com',
        ], $attributes));
    }

    private function resendButton(string $html, int $formId): \DOMElement
    {
        $document = new \DOMDocument;
        @$document->loadHTML('<?xml encoding="utf-8" ?>'.$html);
        $button = (new \DOMXPath($document))->query('//button[@data-form-id="'.$formId.'"]')->item(0);
        $this->assertInstanceOf(\DOMElement::class, $button);

        return $button;
    }
}
