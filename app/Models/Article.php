<?php

namespace App\Models;

use App\Traits\Uuid;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, Uuid;

    protected $fillable = [
        'title',
        'paper_id',
        'abstract',
        'keywords',
        'areas',
        'pages',
        'words',
        'tables',
        'figures',
        'issue_id',
        'volume_id',
        'journal_id',
        'article_type_id',
        'country_id',
        'user_id',
        'article_status_id',
        'editorial',
        'type_setting',
        'downloads',
        'start_page',
        'end_page',
        'manuscript_file',
        'submission_date',
        'publication_date',

        'deadline',
        'scope',
        'methodology',
        'tech_complete',
        'noverity',
        'prior_publication',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll();
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    } 

    public function volume()
    {
        return $this->belongsTo(Volume::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function articleType()
    {
        return $this->belongsTo(ArticleType::class);
    } 

    public function country()
    {
        return $this->belongsTo(Country::class);
    } 

    public function files()
    {
        return $this->hasMany(File::class);
    } 

    public function submission_confirmations()
    {
        return $this->belongsToMany(SubmissionConfirmation::class)->withTimestamps();;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function article_journal_users()
    {
        return $this->belongsToMany(JournalUser::class, 'article_journal_user', 'article_id', 'journal_user_id')->withPivot('review_start_date', 'review_end_date', 'review_status', 'number')->withTimestamps();
    } 


    public function article_status()
    {
        return $this->belongsTo(ArticleStatus::class);
    }

    public function article_reviews()
    {
        return $this->hasMany(ArticleReview::class);
    }

    public function review_attachments()
    {
        return $this->hasMany(ReviewAttachment::class);
    }

    public function article_comments()
    {
        return $this->hasMany(ArticleComment::class);
    }


    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
