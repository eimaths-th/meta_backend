<?php

namespace Tests\Unit;

use App\Mail\ContactMail;
use App\Models\FormManage;
use PHPUnit\Framework\TestCase;

class ContactMailSubjectTest extends TestCase
{
    public function test_it_uses_the_registration_title_and_student_name(): void
    {
        $formManage = new FormManage([
            'head_title' => 'IMOCSEA 2026 Registration Form',
            'form_name' => 'IMOCSEA 2026',
        ]);
        $registration = (object) [
            'sfield' => '63',
            'first_name' => 'Ada',
            'middle_name' => '-',
            'last_name' => 'Lovelace',
        ];

        $subject = (new TestableContactMail)->subjectFor($registration, $formManage);

        $this->assertSame(
            '[Metaknowledge] IMOCSEA 2026 Registration Form - Ada Lovelace',
            $subject,
        );
        $this->assertStringNotContainsString('Contact Mail', $subject);
    }

    public function test_it_falls_back_to_a_registration_confirmation_subject(): void
    {
        $registration = (object) [
            'sfield' => '999',
            'first_name' => 'Grace',
            'last_name' => 'Hopper',
        ];

        $subject = (new TestableContactMail)->subjectFor($registration, null);

        $this->assertSame(
            '[Metaknowledge] Registration Confirmation - Grace Hopper',
            $subject,
        );
    }
}

class TestableContactMail extends ContactMail
{
    public function __construct() {}

    public function subjectFor($data, ?FormManage $formManage): string
    {
        return $this->buildRegistrationSubject($data, $formManage);
    }
}
