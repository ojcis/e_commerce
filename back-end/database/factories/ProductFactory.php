<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2,true),
            'available' => $this->faker->numberBetween(0,100),
            'price' => $this->faker->numberBetween(100,10000),
        ];
    }
}
