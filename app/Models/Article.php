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

    public function article_users()
    {
        return $this->belongsToMany(User::class, 'article_user', 'article_id', 'user_id')->withPivot('id', 'role', 'number')->withTimestamps();
    }

    public function coauthors()
    {
        return $this->belongsToMany(User::class, 'article_user', 'article_id', 'user_id')->wherePivot('role', 'author')->withPivot('role')->withTimestamps();
    }

    public function editors()
    {
        return $this->belongsToMany(User::class, 'article_user', 'article_id', 'user_id')->wherePivot('role', 'editor')->withPivot('role')->withTimestamps();
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'article_user', 'article_id', 'user_id')->wherePivot('role', 'reviewer')->withPivot('role')->withTimestamps();
    }

    public function status()
    {
        return $this->belongsTo(ArticleStatus::class);
    }
}
