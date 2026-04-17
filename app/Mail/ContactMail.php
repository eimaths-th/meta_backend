<?php

namespace App\Mail;

use App\Models\FormManage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
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
            'public_path' => public_path('receipt_form_images/')
        ]);

        $sfield = $data->sfield;
        $formManage = FormManage::where('sfield', $sfield)->first();

        if ($formManage) {

            $this->check = true;
            $this->head_title = ($formManage->head_title) ?? 'Contact Mail';
            $this->news_title = ($formManage->form_name) ?? 'Contact Mail' . ' ' . date('Y');
        } else {
            $this->check = false;
        }
        // dd($this->message);
        if ($data->sfield == '17') {
            $this->subject('Math League');
        } else {
            $this->subject('Contact Mail');
        }
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
