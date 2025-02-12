<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoAuthor extends Model
{
    protected $fillable = [
    'first_name',
    'middle_name',
    'last_name',
    'affiliation',
    'salutation_id',
    'article_id'
    ];

    
}
