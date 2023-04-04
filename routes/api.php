<?php

use App\Http\Controllers\MealController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;


Route::get('/table/{table}/availability', [TableController::class, 'checkAvailability'])
    ->name('table.availability');

Route::post('/table/customer/{customer}/reserve', [TableController::class, 'reserve'])
    ->name('table.reserve')
    ->withoutScopedBindings();

Route::get('/meal', [MealController::class, 'index'])
    ->name('meal.index');
