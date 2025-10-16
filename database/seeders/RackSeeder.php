<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rack;

class RackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $racks = [
            // ['code' => 'F2-1'],
            // ['code' => 'F2-2'],
            // ['code' => 'F2-3'],
            // ['code' => 'F2-4'],
            // ['code' => 'F2-5'],
            // ['code' => 'F2-6'],
            // ['code' => 'F2-7'],
            // ['code' => 'F2-8'],
            // ['code' => 'G1-1'],
            // ['code' => 'G1-2'],
            // ['code' => 'G1-3'],
            // ['code' => 'G1-4'],
            // ['code' => 'G1-5'],
            // ['code' => 'G1-6'],
            // ['code' => 'G1-7'],
            // ['code' => 'G1-8'],
            // ['code' => 'G1-9'],
            ['code' => 'F2-9'],
            ['code' => 'F2-10'],
            ['code' => 'F2-11'],
            ['code' => 'F2-12'],
            ['code' => 'F2-13'],
            ['code' => 'F2-14'],
            ['code' => 'F2-15'],
            ['code' => 'F2-16'],
            ['code' => 'F2-17'],
            ['code' => 'F2-18'],
            ['code' => 'F2-19'], 
            ['code' => 'F2-20'],
            ['code' => 'F2-21'],
            ['code' => 'F2-22'],
            ['code' => 'F2-23'],
            ['code' => 'F2-24'],

        ];

        foreach ($racks as $rack) {
            Rack::firstOrCreate($rack);
        }
    }
}
