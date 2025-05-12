<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedJob extends Model
{
    protected $table = 'failed_jobs';

    public $timestamps = false;

    protected $casts = [
        'failed_at' => 'datetime',
        'payload' => 'array',
        'exception' => 'string',
    ];

    public function getCreatedAtColumn()
    {
        return 'failed_at';
    }
}
