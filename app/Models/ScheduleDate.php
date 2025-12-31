<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDate extends Model
{
    protected $fillable = [
        'worker_id',
        'year',
        'month'
    ];

    public function worker()
    {
        return $this->belongsTo(ScheduleWorker::class, 'worker_id');
    }

    public function schedules()
    {
        return $this->hasMany(ScheduleDay::class, 'date_id');
    }
}
