<?php

namespace App\Models;

use App\Traits\Uuid;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffList extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, Uuid;

    protected $fillable = [
        'salutation_id',
        'first_name',
        'middle_name',
        'last_name',
        'full_name',
        'picture',
        'gender',
        'nationality',
        'email',
        'phone',
        'box',
        'bio',
        'ems_id',
        'faculty_id',
        'campus_id',
        'designations',
        'office',
        'social_media',
        'academics',
        'status',
        'pf_number',
        'password',
        'uuid'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll();
    }

    public function salutation()
    {
        return $this->belongsTo(Salutation::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

}
