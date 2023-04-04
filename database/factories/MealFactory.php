<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MealFactory extends Factory
{

    public function definition(): array
    {
        $initialQuantity = $this->faker->numberBetween(1, 100);
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'initial_quantity' => $initialQuantity,
            'available_quantity' => $this->faker->numberBetween(1, $initialQuantity),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'discount' => $this->faker->randomFloat(2, 0, 70),
        ];
    }
}
