<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'journal_user_id',
        'article_id',
        'status'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function journalUser()
    {
        return $this->belongsTo(JournalUser::class);
    }
}
