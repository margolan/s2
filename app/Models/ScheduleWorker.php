<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleWorker extends Model
{
    protected $fillable = [
        'full_name',
        'city',
        'depart'
    ];

    public function dates()
    {
        return $this->hasMany(ScheduleDate::class, 'worker_id');
    }
}
