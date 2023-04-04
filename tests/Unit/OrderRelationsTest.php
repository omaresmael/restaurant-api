<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Table;

beforeEach(function () {
    $this->table1 = Table::factory()->create();
    $this->table2 = Table::factory()->create();

    $this->customer1 = Customer::factory()->create();
    $this->customer2 = Customer::factory()->create();

    $reservation1 = Reservation::insertGetId([
        'table_id' => $this->table1->id,
        'customer_id' => $this->customer1->id,
        'from_time' => '2023-04-03 10:00:00',
        'to_time' => '2023-04-03 12:00:00',
    ]);

    $reservation2 = Reservation::insertGetId([
        'table_id' => $this->table2->id,
        'customer_id' => $this->customer2->id,
        'from_time' => '2023-04-03 14:00:00',
        'to_time' => '2023-04-03 16:00:00',
    ]);

    $this->order1 = Order::factory()->create([
        'reservation_id' => $reservation1,
    ]);
    $this->order2 = Order::factory()->create([
        'reservation_id' => $reservation2,
    ]);
});

it('gets orders on the table', function (){
   $orders = $this->table1->orders;
    $this->assertCount(1, $orders);
    $this->assertEquals($this->order1->id, $orders->first()->id);
});

it('gets orders for the customer', function (){
    $orders = $this->customer1->orders;
    $this->assertCount(1, $orders);
    $this->assertEquals($this->order1->id, $orders->first()->id);
});

it('gets the table of order', function (){
    $table = $this->order1->table;
    $this->assertEquals($this->table1->id, $table->id);
});

it('gets the customer of order', function (){
    $customer = $this->order1->customer;
    $this->assertEquals($this->customer1->id, $customer->id);
});
