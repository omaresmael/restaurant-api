<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOrderRequest;
use App\Models\Order;
use App\Services\Invoicable;
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

        return jsonResponse('Order placed successfully');

    }

    public function checkout(Order $order, Invoicable $invoiceService): JsonResponse
    {
        [$total, $paid] = $order->calculateTotalAndPaidPrices();

        $this->updateOrder($order, $total, $paid);

        $invoice = $invoiceService->createInvoice($order);

        return jsonResponse('Order checked out successfully', ['invoice_url' => $invoice->path]);
    }

    private function createNewOrder(int $reservationId, int $waiterId)
    {
        return Order::create([
            'reservation_id' => $reservationId,
            'waiter_id' => $waiterId,
        ]);
    }


    private function updateOrder(Order $order, float $total, float $paid): void
    {
        $order->update([
            'total' => $total,
            'paid' => $paid,
            'paid_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
