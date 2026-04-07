<?php

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\StatusHistory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Uses seeders for known/required records and factories for bulk test data.
     */
    public function run()
    {
        // Known records via seeders
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(OrderSeeder::class);

        // Additional bulk test data via factories
        $extraOrders = factory(Order::class, 10)->create();

        foreach ($extraOrders as $order) {
            StatusHistory::log($order->id, null, $order->status, $order->created_by);
        }
    }
}
