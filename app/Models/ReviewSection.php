<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewSection extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'title',
        'category',
        'review_sections_group_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll();
    }

    public function reviewSectionOption()
    {
        return $this->hasMany(ReviewSectionOption::class);
    }

    public function reviewSectionQuery()
    {
        return $this->hasMany(ReviewSectionQuery::class);
    }

    public function reviewSectionsGroup()
    {
        return $this->belongsTo(ReviewSectionsGroup::class);
    }

    public function reviewSectionsComment()
    {
        return $this->hasMany(ReviewSectionsComment::class);
    }
}
