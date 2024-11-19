<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadResignation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->request_data = $data;  
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Acknowledgment of Resignation - '.$this->request_data['employee_info']->first_name.' '.$this->request_data['employee_info']->last_name)
        ->view('emails.upload_resignation')
        ->with([
            'data'  =>  $this->request_data
        ])
        ->attach(public_path($this->request_data['last_employment']->acceptance_letter), [
            'as' => 'acceptance-letter.pdf', // Optional: Set custom file name
        ])
        ->attach(public_path($this->request_data['last_employment']->resignation_letter), [
            'as' => 'resignation-letter.pdf', // Optional: Set custom file name
        ]);
    }
}
