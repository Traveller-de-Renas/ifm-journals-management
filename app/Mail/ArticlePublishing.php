<?php

namespace App\Mail;

use App\Models\ReviewMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticlePublishing extends Mailable
{
    use Queueable, SerializesModels;

    public $record;
    public $review_message;

    /**
     * Create a new message instance.
     */
    public function __construct($record)
    {
        $this->record = $record;
        $this->review_message = ReviewMessage::where('category', 'Article Returns')->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Article Publishing',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.article_returns',
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
