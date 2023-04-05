<?php

use App\Models\Customer;
use App\Models\Table;

beforeEach(function () {
    $this->table = Table::factory()->create([
        'capacity' => 4,
    ]);
    $this->customer = Customer::factory()->create();

    $this->table->customers()->attach($this->customer, [
        'from_time' => '2023-04-03 10:00:00',
        'to_time' => '2023-04-03 12:00:00',
    ]);

});

it('check if a table is reserved for a duration in time', function () {

    $from = '2023-04-03 10:00:00';
    $to = '2023-04-03 12:00:00';

    $this->assertTrue($this->table->isReserved($from, $to));

    $from = '2023-04-03 10:30:00';
    $to = '2023-04-03 14:00:00';

    $this->assertTrue($this->table->isReserved($from, $to));

    $from = '2023-04-03 09:30:00';
    $to = '2023-04-03 11:00:00';

    $this->assertTrue($this->table->isReserved($from, $to));

    $from = '2023-04-03 11:00:00';
    $to = '2023-04-03 11:30:00';

    $this->assertTrue($this->table->isReserved($from, $to));

    $from = '2023-04-03 15:30:00';
    $to = '2023-04-03 16:00:00';

    $this->assertFalse($this->table->isReserved($from, $to));
});
