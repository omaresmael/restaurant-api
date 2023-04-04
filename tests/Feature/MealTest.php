<?php

use App\Models\Meal;
use App\Models\Order;

beforeEach(function () {
    $this->meal = Meal::factory()->create([
        'name' => 'meal 1',
        'price' => 10,
        'available_quantity' => 10,
        'initial_quantity' => 10,
    ]);
    Meal::factory()->count(10)->create();
});

it('gets all meals with pagination', function () {
    $response = $this->getJson(route('meal.index'));

    $response->assertJson([
        'message' => 'meals retrieved',
    ]);
    $this->assertCount(10, $response->json('data'));
    $this->assertTrue(array_key_exists('links', $response->json()));
    $this->assertTrue(array_key_exists('meta', $response->json()));
    $this->assertEquals(Meal::PAGINATION_COUNT, $response->json('meta.per_page'));
});

it('calculates discounted price', function () {
    $dicountedPrice = $this->meal->price - round(($this->meal->price * ($this->meal->discount / 100)));

    $this->assertEquals($dicountedPrice, $this->meal->discounted_price);
});

it('decrements the available quantity of a meal after being added to an order', function () {
    $secondMeal = Meal::factory()->create([
        'name' => 'second',
        'price' => 10,
        'available_quantity' => 8,
        'initial_quantity' => 10,
    ]);
    $order = Order::factory()->create();
    $meals = [
        [
            'meal_id' => $this->meal->id,
            'amount_to_pay' => $this->meal->discounted_price,
        ],
        [
            'meal_id' => $secondMeal->id,
            'amount_to_pay' => $secondMeal->discounted_price,
        ],
    ];
    $order->meals()->attach($meals);
    $this->assertDatabaseHas('order_details',[
        'order_id' => $order->id,
        'meal_id' => $this->meal->id,
        'amount_to_pay' => $this->meal->discounted_price,
    ]);

    $this->assertDatabaseHas('meals',[
        'id' => $this->meal->id,
        'available_quantity' => $this->meal->available_quantity - 1,
    ]);
    $this->assertDatabaseHas('meals',[
        'id' => $secondMeal->id,
        'available_quantity' => $secondMeal->available_quantity - 1,
    ]);

});
