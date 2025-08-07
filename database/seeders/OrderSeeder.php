<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\StatusOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        StatusOrder::truncate();
        DB::table('order_items')->truncate();
        Order::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'user_name' => 'Ng Van A',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'login_name' => 'nguyenvana',
                'role_id' => 2
            ]);
        }

        $adminUser = User::where('role_id', 1)->first();
        if (!$adminUser) {
            $adminUser = User::first(); // fallback to any user
        }

        $ordersData = [
            [
                'user_id' => $user->id,
                'order_date' => '2025-08-05',
                'total_amount' => 12500000.00
            ],
            [
                'user_id' => $user->id,
                'order_date' => '2025-08-04',
                'total_amount' => 8900000.00
            ],
            [
                'user_id' => $user->id,
                'order_date' => '2025-08-03',
                'total_amount' => 6200000.00
            ],
            [
                'user_id' => $user->id,
                'order_date' => '2025-08-06',
                'total_amount' => 15300000.00
            ],
            [
                'user_id' => $user->id,
                'order_date' => '2025-08-02',
                'total_amount' => 9600000.00
            ]
        ];

        foreach ($ordersData as $orderData) {
            $order = Order::create([
                'user_id' => $orderData['user_id'],
                'order_date' => $orderData['order_date'],
                'total_amount' => $orderData['total_amount']
            ]);

            StatusOrder::create([
                'action_type' => 'pending',
                'date' => $orderData['order_date'],
                'admin_id' => $adminUser->id,
                'order_id' => $order->order_id,
            ]);
        }
    }
}
