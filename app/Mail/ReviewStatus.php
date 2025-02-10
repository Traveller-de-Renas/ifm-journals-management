<?php

namespace App\Mail;

use App\Models\ReviewMessage;
use App\Models\ReviewSection;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $record;
    public $comments;
    public $sections;
    public $reviewers;

    public $review_message;
    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct($record, $comments, $journal_users)
    {
        $this->record    = $record;
        $this->comments  = $comments;

        $this->sections  = ReviewSection::where('category', 'comments')->get();
        $this->reviewers = $this->record->article_journal_users()->whereIn('journal_user_id', $journal_users)->where('review_status', 'completed')->whereHas('roles', function ($query) {
            $query->where('name', 'Reviewer');
        })->get();

        if(in_array($record->article_status->code, ['019','020'])){
            $this->review_message = ReviewMessage::where('category', 'Article Revisions')->first();
            $this->subject = 'Article Revisions';
        }

        if($record->article_status->code == '015'){
            $this->review_message = ReviewMessage::where('category', 'Article Rejection')->first();
            $this->subject = 'Decision on Manuscript Submitted to Journal';
        }

        if($record->article_status->code == '018'){
            $this->review_message = ReviewMessage::where('category', 'Acceptance Letter')->first();
            $this->subject = 'Manuscript Acceptance Notification';
        }
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.review_status',
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
