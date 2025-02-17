<?php

namespace App\Models;

use App\Traits\Uuid;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordChangeRequest extends Model
{
    use SoftDeletes, LogsActivity, Uuid;

    protected $fillable = [
        'user_id',
        'journal',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function journal()
    {
        // return $this->belongsTo(Journal::class);
    }

    public function status()
    {
        return ($this->status == 1)? 'Active' : 'Inactive';
    }
}
