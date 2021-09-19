<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Feedback;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public Feedback $feedback;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function build()
    {
        return $this->view('emails.feedback')
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Обратная связь')
            ->with('feedback', $this->feedback);
    }
}
