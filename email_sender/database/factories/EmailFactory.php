<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Email>
 */
class EmailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 1000),
            'product_id' => $this->faker->numberBetween(1, 1000),
            'product_name' => $this->faker->words(3, true),
            'user_email' => $this->faker->email(),
            'details' => $this->faker->sentences(3, true),
            'price' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
