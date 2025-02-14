<?php

namespace App\Mail;

use App\Models\ReviewMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountActivation extends Mailable
{
    use Queueable, SerializesModels;

    public $journal;
    public $user;

    public $review_message;

    /**
     * Create a new message instance.
     */
    public function __construct($journal, $user)
    {
        $this->journal = $journal;
        $this->user    = $user;

        $this->review_message = ReviewMessage::where('category', 'Account Activation')->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to '.$this->journal->title.' Activate Your Account',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.account_activation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
