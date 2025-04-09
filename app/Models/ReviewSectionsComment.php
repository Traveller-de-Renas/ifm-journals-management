<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewSectionsComment extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'comment',
        'article_id',
        'review_section_id',
        'user_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll();
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function reviewSection()
    {
        return $this->belongsTo(ReviewSection::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
