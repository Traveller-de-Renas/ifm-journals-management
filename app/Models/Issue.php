<?php

namespace App\Models;

use App\Traits\Uuid;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Issue extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, Uuid;

    protected $fillable = [
        'number',
        'description',
		'journal_id',
		'volume_id',
        'editorial',
        'editorial_file',
        'editorial_downloads',
        'status',
        'publication_date'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll();
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function volume()
    {
        return $this->belongsTo(Volume::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
