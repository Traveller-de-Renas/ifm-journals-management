<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EditorChecklist extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'description',
        'code',
        'editorial_process_id',
        'status'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll();
    }
    
    public function status()
    {
        return ($this->status === 1) ? 'Active' : 'Inactive';
    }

    public function editorialProcess()
    {
        return $this->belongsTo(EditorialProcess::class);
    }
}
