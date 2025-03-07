<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MailLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'article_id',
        'article_status_id'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function article_status()
    {
        return $this->belongsTo(ArticleStatus::class);
    }
    
}
