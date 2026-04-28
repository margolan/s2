<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'worker_name',
        'schedule_data',
        'month',
        'year',
        'city',
        'depart',
        'is_active',
        'batch_id',
    ];

    protected $casts = [
        'schedule_data' => 'array',
    ];
}
