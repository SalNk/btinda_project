<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Seller;
use App\Models\DeliveryMan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'seller_id' => Seller::factory(),
            'delivery_man_id' => DeliveryMan::all()->random()->id,
            'delivery_date' => $this->faker->dateTimeBetween('+1 days', '+1 week'),
        ];
    }
}
