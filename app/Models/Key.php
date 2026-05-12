<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    protected $fillable = [
        'device_serial',
        'reg_number',
        'device_id',
        'device_address',
        'district',
        'color',
        'model_name',
        'os_version',
        'ip_address',
        'sim_number',
        'note',
        'is_active',
        'batch_id',
    ];
}
