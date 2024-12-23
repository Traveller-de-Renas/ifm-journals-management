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
		'category_id',
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
        return $this->belongsTo(Category::class);
    }

    public function instructions()
    {
        return $this->hasMany(JournalInstruction::class);
    }

    public function indecies()
    {
        return $this->hasMany(JournalIndex::class);
    }

    public function article_types()
    {
        return $this->hasMany(ArticleType::class);
    }

    public function file_categories()
    {
        return $this->hasMany(FileCategory::class);
    }

    public function journal_users()
    {
        return $this->belongsToMany(User::class, 'journal_user', 'journal_id', 'user_id')->withPivot('role');
    }


    public function chief_editor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editors()
    {
        return $this->belongsToMany(User::class, 'journal_user', 'journal_id', 'user_id')->wherePivot('role', 'editor')->withPivot('role');
    }

    public function authors()
    {
        return $this->belongsToMany(User::class, 'journal_user', 'journal_id', 'user_id')->wherePivot('role', 'author')->withPivot('role');
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
}
