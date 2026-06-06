<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::post('tg', [ScheduleController::class, 'tgTest']);
