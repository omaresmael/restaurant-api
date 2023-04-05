<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        $fromTime = $this->faker->dateTime();

        return [
            'table_id' => Table::factory(),
            'customer_id' => Customer::factory(),
            'from_time' => $fromTime,
            'to_time' => $this->faker->dateTimeBetween($fromTime, '+1 hour'),
        ];
    }
}
