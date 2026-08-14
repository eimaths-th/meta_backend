<?php

namespace Tests\Unit;

use App\Http\Controllers\ReceiptFormController;
use App\Models\FormManage;
use Closure;
use ReflectionMethod;
use Tests\TestCase;

class RegistrationValidationRulesTest extends TestCase
{
    public function test_partial_field_settings_keep_defaults_and_honor_disabled_or_optional_fields(): void
    {
        $form = new FormManage([
            'form_route' => 'compatibility-test',
            'package_multiselect' => false,
            'field_settings' => [
                'contact_email' => ['enabled' => 'false', 'required' => 'false'],
                'student_photo' => ['enabled' => 'true', 'required' => 'false'],
            ],
        ]);

        $validation = $this->rules($form);

        $this->assertArrayHasKey('firstname', $validation['rules']);
        $this->assertArrayHasKey('middlename', $validation['rules']);
        $this->assertArrayNotHasKey('email', $validation['rules']);
        $this->assertSame(['nullable', 'array'], $validation['rules']['imgFiles']);
        $this->assertSame(['required', 'array', 'min:1'], $validation['rules']['imgFiles2']);
        $this->assertContains('exists:file_uploads,oldname', $validation['rules']['imgFiles.*']);
    }

    public function test_email_tld_validation_is_case_insensitive(): void
    {
        $form = new FormManage([
            'form_route' => 'compatibility-test',
            'field_settings' => [
                'contact_email' => ['enabled' => true, 'required' => true],
            ],
        ]);
        $emailRules = $this->rules($form)['rules']['email'];
        $tldRule = collect($emailRules)->first(fn ($rule) => $rule instanceof Closure);
        $failure = null;

        $tldRule('email', 'Student@Example.COM', function ($message) use (&$failure) {
            $failure = $message;
        });

        $this->assertNull($failure);
    }

    private function rules(FormManage $form): array
    {
        $method = new ReflectionMethod(ReceiptFormController::class, 'buildDynamicValidationRules');
        $method->setAccessible(true);

        return $method->invoke(
            new ReceiptFormController,
            $form->form_route,
            ['.com', '.net', '.co.th', '.ac.th', '.or.th', '.go.th', '.edu', '.org'],
            $form,
        );
    }
}
