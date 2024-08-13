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
        'issn',
        'eissn',
        'publisher',
        'email',
        'website',
		'year',
		'guidlines',
		'category_id',
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

    public function journal_instructions()
    {
        return $this->hasMany(JournalInstruction::class);
    }

    public function journal_indices()
    {
        return $this->hasMany(JournalIndex::class);
    }

    public function journal_users()
    {
        return $this->belongsToMany(User::class, 'journal_user', 'journal_id', 'user_id');
    }

    public function submission_confirmations()
    {
        return $this->hasMany(SubmissionConfirmation::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
