<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:rg'])->group(function () {
  Route::get('/schedule/create', [ScheduleController::class, 'create'])->name('schedule-create');
  Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule-store');
});
