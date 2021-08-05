<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItems;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderItems::factory(20)->create();
    }
}
