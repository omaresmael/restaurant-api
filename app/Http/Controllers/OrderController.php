<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;


class OrderController extends Controller
{
    public function placeOrder(PlaceOrderRequest $request): JsonResponse
    {
        $meals = $request->input('meals');
        $reservationId = $request->input('reservation_id');
        $waiterId = $request->input('waiter_id');

        $order = $this->createNewOrder($reservationId, $waiterId);

        $order->meals()->attach($meals);

        return response()->json([
            'message' => 'Order placed successfully',
        ]);


    }

    public function checkout()
    {

    }

    private function createNewOrder(int $reservationId, int $waiterId)
    {
        return Order::create([
            'reservation_id' => $reservationId,
            'waiter_id' => $waiterId,
        ]);
    }
}
