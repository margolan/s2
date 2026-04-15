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
    ];

    protected $casts = [
        'schedule_data' => 'array',
    ];
}
