<?php

use App\Models\Meal;

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
    $this->assertEquals('meals retrieved', $response->json('message'));

    $this->assertCount(10, $response->json('data'));
    $this->assertTrue(array_key_exists('links', $response->json()));
    $this->assertTrue(array_key_exists('meta', $response->json()));
    $this->assertEquals(Meal::PAGINATION_COUNT, $response->json('meta.per_page'));
});

it('calcutates discounted price', function () {
    $dicountedPrice = $this->meal->price - ($this->meal->price * ($this->meal->discount / 100));
    $response = $this->getJson(route('meal.index'));

    $this->assertEquals($dicountedPrice, $this->meal->discounted_price);
});

it('resets available quantity to initial quantity at the end of the day', function () {

})->todo();
