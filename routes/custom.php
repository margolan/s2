<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CassetteController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;


Route::get('/test', [ServiceController::class, 'test']);



// ================================================================
// 
//        Domain 0x0.kz
// 
// ================================================================



// Route::domain('0x0.kz')->group(function () {

  // ====================== COMMON  ======================

  Route::get('', [IndexController::class, 'index'])->name('index');
  Route::get('/about', [IndexController::class, 'about'])->name('about');
  Route::get('/help', [IndexController::class, 'help'])->name('help');



  // ====================== ADMIN DASHBOARD ======================

  Route::middleware('CheckUser:admin')->group(function () {
    Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.user.edit');
    Route::put('/dashboard/admin/{id}', [AdminController::class, 'update'])->name('admin.user.update');
  });



  // ====================== SCHEDULES PROJECT ======================

  Route::get('/grafik', [ScheduleController::class, 'index'])->name('schedule.index');
  Route::post('/grafik', [ScheduleController::class, 'settings'])->name('schedule.settings');

  Route::middleware('CheckUser:ter,pos')->group(function () {
    Route::get('/dashboard/schedule', [ScheduleController::class, 'dashboard'])->name('schedule.dashboard');
    Route::post('/dashboard/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::put('/dashboard/schedule/activate', [ScheduleController::class, 'activate'])->name('schedule.activate');
    Route::delete('/dashboard/schedule/delete', [ScheduleController::class, 'delete'])->name('schedule.delete');
  });



  // ====================== KEYS PROJECT ======================

  // Route::match(['get', 'post'], '/dashboard/key/pincode', [KeyController::class, 'pincode'])->name('key-pincode');

  Route::middleware('CheckUser:ter')->group(function () {
    Route::get('/dashboard/key', [KeyController::class, 'dashboard'])->name('key.dashboard');
    Route::post('/dashboard/key/store', [KeyController::class, 'store'])->name('key.store');
    Route::match(['get', 'put'], '/dashboard/key/edit', [KeyController::class, 'edit'])->name('key.edit');
    Route::delete('/dashboard/key/delete', [KeyController::class, 'delete'])->name('key.delete');
  });



  // ====================== CASSETTE PROJECT ======================

  Route::middleware('CheckUser:upr')->group(function () {
    Route::match(['get', 'post'], '/dashboard/cassette', [CassetteController::class, 'dashboard'])->name('cassette.dashboard');
    Route::get('/cassette/{id}/edit', [CassetteController::class, 'edit'])->name('cassette.edit');
    Route::put('/cassette/{id}', [CassetteController::class, 'update'])->name('cassette.update');
    // Route::delete('/cassette/delete', [CassetteController::class, 'delete'])->name('cassette.delete');
  });




  // ====================== SERVICE ROUTES ======================


  // Route::get('/test', [ServiceController::class, 'test']);
// });



// ================================================================
// 
//        Domain aper.kz
// 
// ================================================================


Route::domain('aper.kz')->group(function () {

  Route::get('/', function () {

    return view('aperkz.index');
  });
});
