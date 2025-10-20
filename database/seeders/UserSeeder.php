<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Toko Roti',
            'email' => 'admin@shinta.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@shinta.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
        ]);
    }
}
