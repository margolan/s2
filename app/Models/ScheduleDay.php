<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDay extends Model
{

    protected $fillable = [
        'date_id',
        'day',
        'status'
    ];

    public function date()
    {
        return $this->belongsTo(ScheduleDate::class, 'date_id');
    }
}
