<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo customer mẫu
        $customers = [
            [
                'name' => 'John Customer',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // Customer role
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@gmail.com', 
                'password' => Hash::make('password'),
                'role_id' => 2, // Customer role
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // Customer role  
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah.wilson@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // Customer role
                'email_verified_at' => now(),
            ],
            [
                'name' => 'David Brown',
                'email' => 'david.brown@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // Customer role
                'email_verified_at' => now(),
            ]
        ];

        foreach ($customers as $customer) {
            User::create($customer);
        }
    }
}
