<?php

namespace App\Mail;

use App\Models\ReviewMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class EditorialTeam extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $journal;
    public $category;
    public $review_message;

    /**
     * Create a new message instance.
     */
    public function __construct($journal, $user, $category)
    {
        $this->user     = $user;
        $this->journal  = $journal;
        $this->category = $category;
        $this->review_message = ReviewMessage::where('category', $category)->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Journal Editorial Team',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.editorial_team',
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
