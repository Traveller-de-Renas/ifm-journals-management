<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'article_id',
        'file_category_id',
        'file_description',
        'file_path',
        'file_type',
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

    public function file_category()
    {
        return $this->belongsTo(FileCategory::class);
    }
}
