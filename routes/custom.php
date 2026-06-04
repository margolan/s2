<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CassetteController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

// ====================== INDEX  ======================

Route::get('', [IndexController::class, 'index'])->name('index');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/help', [IndexController::class, 'help'])->name('help');

// ====================== ADMIN DASHBOARD ======================

Route::middleware('auth')->group(function () {
  Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('admin-index');
});

// ====================== SCHEDULES PROJECT ======================

Route::get('/grafik', [ScheduleController::class, 'index'])->name('schedule-index');
Route::post('/grafik', [ScheduleController::class, 'settings'])->name('schedule-settings');

Route::middleware('auth')->group(function () {
  Route::get('/dashboard/schedule', [ScheduleController::class, 'dashboard'])->name('schedule-dashboard');
  Route::post('/dashboard/schedule/store', [ScheduleController::class, 'store'])->name('schedule-store');
  Route::put('/dashboard/schedule/activate', [ScheduleController::class, 'activate'])->name('schedule-activate');
  Route::delete('/dashboard/schedule/delete', [ScheduleController::class, 'delete'])->name('schedule-delete');
});

// ====================== KEYS PROJECT ======================

Route::match(['get', 'post'], '/dashboard/key/pincode', [KeyController::class, 'pincode'])->name('key-pincode');

Route::middleware('check.pin')->group(function () { // Middleware : Check pincode && depart 'ter'
  Route::get('/dashboard/key', [KeyController::class, 'dashboard'])->name('key-dashboard');
  Route::post('/dashboard/key/store', [KeyController::class, 'store'])->name('key-store');
  Route::match(['get', 'put'], '/dashboard/key/edit', [KeyController::class, 'edit'])->name('key-edit');
});


// ====================== CASSETTE PROJECT ======================

Route::match(['get', 'post'], '/cassette', [CassetteController::class, 'index'])->name('cassette-index');
Route::delete('/cassette/delete', [CassetteController::class, 'delete'])->name('cassette-delete');
