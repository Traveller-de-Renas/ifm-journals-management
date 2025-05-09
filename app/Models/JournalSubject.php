<?php

namespace App\Models;

use App\Traits\Uuid;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournalSubject extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, Uuid;

    protected $fillable = [
        'name',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll();
    }

    public function categories()
    {
        return $this->hasMany(JournalCategory::class);
    }

    public function status()
    {
        return ($this->status === 1) ? 'Active' : 'Inactive';
    }
}
