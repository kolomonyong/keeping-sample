<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        if (\App\Models\Rack::count() == 0 || \App\Models\ProductType::count() == 0) {
            $this->command->info('Tabel Rack atau ProductType kosong. Mohon jalankan seeder yang relevan terlebih dahulu.');
            return;
        }
        Stock::factory()->count(1000)->create();
    }
}
