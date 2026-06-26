<?php

namespace Tests\Feature;

use App\Mail\ContactMail2;
use Tests\TestCase;

class MailTest extends TestCase
{
    public function test_contact_mail_two_uses_expected_subject_view_and_no_attachments(): void
    {
        $mail = new ContactMail2((object) ['first_name' => 'Ada'], 'extra');

        $this->assertSame('Contact Mail', $mail->envelope()->subject);
        $this->assertSame('emails.contact2', $mail->content()->view);
        $this->assertSame([], $mail->attachments());
        $this->assertSame('extra', $mail->aaa);
    }
}
