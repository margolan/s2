<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cassette extends Model
{
    
    protected $fillable = [
        'number',
        'type',
        'var1',
        'var2',
        'var3',
    ];
}
