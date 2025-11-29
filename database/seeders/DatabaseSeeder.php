<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // CategorySeeder::class, // Uncomment jika ada
            // ProductSeeder::class,  // Uncomment jika ada
            // OrderSeeder::class,    // Uncomment jika ada
            TestimonialSeeder::class, // ⭐ Seeder untuk testimonials
        ]);
    }
}
