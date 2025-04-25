<?php

namespace App\Mail;

use App\Models\ReviewMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class JournalAccount extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $journal;
    public $review_message;

    /**
     * Create a new message instance.
     */
    public function __construct($journal, $user)
    {
        $this->user    = $user;
        $this->journal = $journal;
        $this->review_message = ReviewMessage::where('category', 'Journal Account')->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Creation for Manuscript Submission',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.journal_account',
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
