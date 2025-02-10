<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleStatus extends Model
{
    use HasFactory;

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
