<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubmissionConfirmation extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'description',
        'code',
        'status'
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

    public function status()
    {
        return ($this->status === 1) ? 'Active' : 'Inactive';
    }
}
