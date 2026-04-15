<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'can:view-users'])->group(function () {
    Route::get('/schedule', [ScheduleController::class, 'store'])->name('schedule-store');
});

Route::middleware(['auth', 'can:create-schedule'])->group(function () {
  Route::get('/schedule/create', [ScheduleController::class, 'create'])->name('schedule-create');
  Route::get('/schedule/check', [ScheduleController::class, 'check'])->name('schedule-check');
  Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule-store');
});

