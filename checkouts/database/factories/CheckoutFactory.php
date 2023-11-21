<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Checkout>
 */
class CheckoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cart = [
            'product_id' => $this->faker->numberBetween(1, 1000),
            'user_id' => $this->faker->numberBetween(1, 1000),
            'user_email' => $this->faker->email(),
            'product_name' => $this->faker->words(4, true),
            'product_description' => $this->faker->sentence(5, true),
            'product_price' => $this->faker->numberBetween(1, 1000),
        ];

        return [
            'user_id' => $this->faker->numberBetween(1, 100),
            'cart' => json_encode($cart),
        ];
    }
}
