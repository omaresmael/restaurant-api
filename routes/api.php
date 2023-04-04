<?php

use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;


Route::get('/tables/{table}/availability', [TableController::class, 'checkAvailability'])
    ->name('table.availability');

Route::post('/tables/customer/{customer}/reserve', [TableController::class, 'reserve'])
    ->name('table.reserve')
    ->withoutScopedBindings();

Route::get('/meals', [MealController::class, 'index'])
    ->name('meal.index');

Route::post('/orders/place', [OrderController::class, 'placeOrder'])
    ->name('order.place');
