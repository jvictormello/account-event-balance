<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ResetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

# AccountController
Route::get('/balance', [AccountController::class, 'show']);

# EventController
Route::post('/event', [EventController::class, 'store']);

# ResettController
Route::post('/reset', [ResetController::class, 'index']);
