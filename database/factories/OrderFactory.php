<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\DeliveryMan;
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
        return [
            'name' => fake()->name(),
            'delivery_date' => fake()->date(),
            'delivery_time' => fake()->time(),
            'delivery_address' => fake()->address(),
            'delivery_price' => fake()->randomFloat(2, 5, 50),
            'item_price' => fake()->randomFloat(2, 10, 500),
            'notes' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['new', 'processing', 'delivered', 'cancelled']),
            'seller_id' => Seller::all()->random()->id,
            'delivery_man_id' => DeliveryMan::all()->random()->id,
        ];
    }
}
