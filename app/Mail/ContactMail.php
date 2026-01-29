<?php

namespace App\Mail;

use App\Models\FormManage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $url1;
    public $url2;
    public $head_title;
    public $news_title;
    public $check;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
        // Helper function to generate image HTML
        $generateImageHtml = function ($files, $path, $height = '200px') {
            if (!$files) return '';
            $html = '';
            $filesArray = explode('|', $files);
            foreach ($filesArray as $file) {
                if (!empty($file)) {
                    $html .= '<img height="' . $height . '" src="' . asset($path . '/' . $file) . '" alt="..." style="vertical-align: middle; margin-right: 5px;"> ';
                }
            }
            return $html;
        };

        $this->url1 = $generateImageHtml($data->photo_att, 'receipt_form_images');
        $this->url2 = $generateImageHtml($data->file_att, 'receipt_form_images');
        // $this->url2 = asset('receipt_form_images/' . $data->file_att);

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
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: 'Contact Mail',
    //     );
    // }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.contact',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
