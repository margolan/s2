<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'can:view-users'])->group(function () {
  Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('admin-index');
});

Route::middleware(['auth', 'can:view-schedule'])->group(function () {
  Route::get('/dashboard/schedule', [ScheduleController::class, 'dashboard'])->name('schedule-dashboard');
  Route::post('/dashboard/schedule/store', [ScheduleController::class, 'store'])->name('schedule-store');
  Route::put('/dashboard/schedule/activate', [ScheduleController::class, 'activate'])->name('schedule-activate');
  Route::delete('/dashboard/schedule/delete', [ScheduleController::class, 'delete'])->name('schedule-delete');
});

Route::get('/grafik', [ScheduleController::class, 'index'])->name('schedule-index');
Route::post('/grafik', [ScheduleController::class, 'settings'])->name('schedule-settings');
