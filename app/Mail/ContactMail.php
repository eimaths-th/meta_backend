<?php

namespace App\Mail;

use App\Models\FormManage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public $url1;

    public $url2;

    public $check;

    public $head_title;

    public $news_title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
        // Keep raw filenames for the view to handle embedding
        $this->url1 = $data->photo_att;
        $this->url2 = $data->file_att;

        Log::info('ContactMail Constructor:', [
            'url1_raw' => $this->url1,
            'url2_raw' => $this->url2,
            'public_path' => public_path('receipt_form_images/'),
        ]);

        $sfield = $data->sfield;
        $formManage = FormManage::where('sfield', $sfield)->first();

        if ($formManage) {

            $this->check = true;
            $this->head_title = ($formManage->head_title) ?? 'Contact Mail';
            $this->news_title = ($formManage->form_name) ?? 'Contact Mail'.' '.date('Y');
        } else {
            $this->check = false;
        }
        $this->subject($this->buildRegistrationSubject($data, $formManage));
    }

    /**
     * Build a recognizable subject without exposing the generic "Contact Mail" label.
     */
    protected function buildRegistrationSubject($data, ?FormManage $formManage): string
    {
        $headTitle = $this->normalizeSubjectPart($formManage->head_title ?? null);
        $formName = $this->normalizeSubjectPart($formManage->form_name ?? null);

        if ($headTitle !== '' && strcasecmp($headTitle, 'Contact Mail') !== 0) {
            $registrationTitle = $headTitle;
        } elseif ($formName !== '' && strcasecmp($formName, 'Contact Mail') !== 0) {
            $registrationTitle = $formName.' Registration Confirmation';
        } elseif ((string) ($data->sfield ?? '') === '17') {
            $registrationTitle = 'Math League Registration Confirmation';
        } else {
            $registrationTitle = 'Registration Confirmation';
        }

        $studentName = implode(' ', array_filter([
            $this->normalizeSubjectPart($data->first_name ?? null),
            $this->normalizeSubjectPart($data->middle_name ?? null),
            $this->normalizeSubjectPart($data->last_name ?? null),
        ], static function (string $name): bool {
            return $name !== '' && $name !== '-';
        }));

        $subject = '[Metaknowledge] '.$registrationTitle;

        return $studentName !== '' ? $subject.' - '.$studentName : $subject;
    }

    private function normalizeSubjectPart($value): string
    {
        return trim((string) preg_replace('/\s+/', ' ', (string) $value));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // ตรวจสอบ data consistency — log ข้อมูล email ที่ใช้ render template
        Log::info('ContactMail building email', [
            'data_id' => $this->data->id ?? 'N/A',
            'data_email' => $this->data->email ?? 'N/A',
            'data_first_name' => $this->data->first_name ?? 'N/A',
            'data_last_name' => $this->data->last_name ?? 'N/A',
            'sfield' => $this->data->sfield ?? 'N/A',
        ]);

        return $this->view('emails.contact');
    }
}
