<?php

use App\Models\Meal;
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Support\Facades\Storage;


beforeEach(function () {
    $this->meal1 = Meal::factory()->create([
        'price' => 500,
        'discount' => 10,
    ]);
    $this->meal2 = Meal::factory()->create([
        'price' => 1000,
        'discount' => 8,
    ]);
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

    $this->assertDatabaseHas('meals',[
        'id' => $this->meal1->id,
        'available_quantity' => $this->meal1->available_quantity - 1,
    ]);
    $this->assertDatabaseHas('meals',[
        'id' => $this->meal2->id,
        'available_quantity' => $this->meal2->available_quantity - 1,
    ]);

});

it('checkouts an order', function() {
    $this->freezeTime();

    $order = Order::factory()->create([
        'reservation_id' => $this->reservation->id,
        'waiter_id' => 1,
    ]);
    $order->meals()->attach([
        [
            'meal_id' => $this->meal1->id,
            'amount_to_pay' => $this->meal1->discounted_price,
        ],
        [
            'meal_id' => $this->meal2->id,
            'amount_to_pay' => $this->meal2->discounted_price,
        ],
    ]);
    [$fileName , $fileUrl] = getFileInfo($order->id);

    $response = $this->json('put',route('order.checkout',[
        'order' => $order->id,
    ]));

    $response->assertJson([
        'message' => 'Order checked out successfully',
        'data' => [
            'invoice_url' => $fileUrl,
        ]
    ]);
    $this->assertDatabaseHas('orders',[
        'id' => $order->id,
        'total' => $this->meal1->price + $this->meal2->price,
        'paid' => $this->meal1->discounted_price + $this->meal2->discounted_price,
    ]);
    $this->assertDatabaseHas('invoices',[
        'order_id' => $order->id,
        'path' => $fileUrl,
    ]);
    Storage::disk('public')->assertExists($fileName);
    Storage::disk('public')->delete($fileName);
});
function getFileInfo(int $orderId): array
{
    $fileName = 'invoice_' . $orderId . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
    $fileUrl = env('APP_URL') . '/storage/' . $fileName;
    return [$fileName, $fileUrl];
}
