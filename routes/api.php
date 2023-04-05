<?php

use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

Route::prefix('tables')->name('table.')->group(function () {
    Route::get('/{table}/availability', [TableController::class, 'checkAvailability'])
        ->name('availability');

    Route::post('/customer/{customer}/reserve', [TableController::class, 'reserve'])
        ->name('reserve')
        ->withoutScopedBindings();
});

Route::get('/meals', [MealController::class, 'index'])
    ->name('meal.index');

Route::prefix('orders')->name('order.')->group(function () {
    Route::post('/place', [OrderController::class, 'placeOrder'])
        ->name('place');

    Route::put('/{order}/checkout', [OrderController::class, 'checkout'])
        ->name('checkout');
});
