<?php

use App\Http\Controllers\TgController;
use Illuminate\Support\Facades\Route;

Route::post('tg', [TgController::class, 'tgTest']);
