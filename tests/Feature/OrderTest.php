<?php

use App\Models\Meal;
use App\Models\Reservation;


beforeEach(function () {
    $this->meal1 = Meal::factory()->create();
    $this->meal2 = Meal::factory()->create();
    $this->reservation = Reservation::factory()->create([
        'from_time' => '2023-04-03 10:00:00',
        'to_time' => '2023-04-03 12:00:00',
    ]);

});
it('places an order',function (){
    $response = $this->postJson(route('order.place'),[
        'reservation_id' => $this->reservation->id,
        'waiter_id' => 1,
        'meals' => [
            [
                'meal_id' => $this->meal1->id,
                'amount_to_pay' => $this->meal1->discounted_price,
            ],
            [
                'meal_id' => $this->meal2->id,
                'amount_to_pay' => $this->meal2->discounted_price,
            ],
        ],
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Order placed successfully',
    ]);
    $this->assertDatabaseHas('orders',[
        'reservation_id' => $this->reservation->id,
        'waiter_id' => 1,
    ]);
    $this->assertDatabaseHas('order_details',[
        'meal_id' => $this->meal1->id,
        'amount_to_pay' => $this->meal1->discounted_price,
    ]);
    $this->assertDatabaseHas('order_details',[
        'meal_id' => $this->meal2->id,
        'amount_to_pay' => $this->meal2->discounted_price,
    ]);
});
