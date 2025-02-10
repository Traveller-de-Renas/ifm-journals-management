<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class JournalUser extends Model
{
    use HasRoles;

    protected $guard_name = 'web';

    protected $fillable = [
        'journal_id',
        'user_id',
        'can_review'
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article_journal_users()
    {
        return $this->belongsToMany(Article::class)->withPivot('review_start_date', 'review_end_date', 'review_status', 'number')->withTimestamps();;
    }
}
