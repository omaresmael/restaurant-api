<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $total  = $this->faker->randomFloat(4, 0, 1000);
        return [
            'reservation_id' => Reservation::factory(),
            'waiter_id' => 1,
            'total' => $this->faker->randomFloat(4, 0, 1000),
            'paid' => $this->faker->randomFloat(4, 0, $total),
            'paid_at' => null,
        ];
    }
}
