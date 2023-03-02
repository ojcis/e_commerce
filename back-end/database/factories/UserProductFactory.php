<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProductFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(0,20),
            'product_id' => $this->faker->numberBetween(0,100),
            'amount' => $this->faker->numberBetween(0,20),
        ];
    }
}
