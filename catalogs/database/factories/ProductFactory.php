<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(4, true),
            'user_id' => User::factory()->create(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(1, 1000),
            'created_at' => $this->faker->dateTimeBetween('-30 days', now()),
        ];
    }
}
