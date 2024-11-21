<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Signatory extends Mailable
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
        return $this->subject('For Clearance - '.$this->request_data['resignee_info']->first_name.' '.$this->request_data['resignee_info']->last_name)
        ->view('emails.signatories')
        ->with([
            'data'  =>  $this->request_data
        ]);
    }
}
