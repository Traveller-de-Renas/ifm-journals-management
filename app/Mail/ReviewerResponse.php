<?php

namespace App\Mail;

use App\Models\ReviewMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewerResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $record;
    public $comments;
    public $sections;
    public $reviewers;

    public $review_message;
    public $subject = 'Reviewer Response';
    public $journal_user, $article_journal_user, $remarks;

    /**
     * Create a new message instance.
     */
    public function __construct($record, $journal_user, $remarks)
    {
        $this->remarks              = $remarks;
        $this->article_journal_user = $record->article_journal_users()->wherePivot('journal_user_id', $journal_user->id)->first();
        $this->record               = $record;
        $this->journal_user         = $journal_user;
        $this->review_message       = ReviewMessage::where('category', 'Reviewer Response')->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reviewer Response',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.reviewer_response',
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
