<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleReview extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'article_id',
        'review_section_query_id',
        'review_section_option_id',
        'comment',
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

    public function review_section_query()
    {
        return $this->belongsTo(ReviewSectionQuery::class);
    }

    public function review_section()
    {
        return $this->belongsTo(ReviewSection::class);
    }

    public function review_section_option()
    {
        return $this->belongsTo(ReviewSectionOption::class);
    }
}
