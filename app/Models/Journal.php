<?php

namespace App\Models;

use App\Traits\Uuid;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journal extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, Uuid;

    protected $fillable = [
        'title',
        'image',
        'description',
        'code',
        'scope',
        'doi',
        'issn',
        'eissn',
        'publisher',
        'email',
        'website',
		'year',
		'guidlines',
		'journal_category_id',
		'subject_id',
        'user_id',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll();
    }

    public function category()
    {
        return $this->belongsTo(JournalCategory::class);
    }

    public function author_guidelines()
    {
        return $this->hasMany(AuthorGuideline::class);
    }

    public function article_types()
    {
        return $this->hasMany(ArticleType::class);
    }

    public function chief_editor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function confirmations()
    {
        return $this->hasMany(SubmissionConfirmation::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function volumes()
    {
        return $this->hasMany(Volume::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function volume()
    {
        return $this->belongsTo(Volume::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function call_for_papers()
    {
        return $this->hasMany(CallForPaper::class);
    }

    public function status()
    {
        return ($this->status == 1)? 'Active' : 'Inactive';
    }

    public function journal_us()
    {
        return $this->hasMany(JournalUser::class);
    }
}
