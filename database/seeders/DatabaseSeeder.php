<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RackSeeder::class,
            ProductTypeSeeder::class,
            StockSeeder::class,
        ]);
    }

    // public function run(): void
    // {
    //     $this->call([
    //         UserSeeder::class,
    //         RackSeeder::class,
    //         ProductTypeSeeder::class,
    //         // StockSeeder::class, // Dinonaktifkan secara default untuk mencegah penambahan data tidak sengaja
    //     ]);
    // }
}
