<?php

use App\Http\Controllers\TableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/table/{table}/availability', [TableController::class, 'checkAvailability'])
    ->name('table.availability');

Route::post('/table/{table}/customer/{customer}/reserve', [TableController::class, 'reserve'])
    ->name('table.reserve')
    ->withoutScopedBindings();
