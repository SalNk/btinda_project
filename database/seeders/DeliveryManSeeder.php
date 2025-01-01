<?php

namespace Database\Seeders;

use App\Models\DeliveryMan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryManSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryMan::factory(10)->create();
    }
}
