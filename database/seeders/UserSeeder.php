<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Menggunakan firstOrCreate untuk menghindari duplikasi
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['username' => 'user'],
            [
                'name' => 'User Biasa',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        User::firstOrCreate(
            ['username' => 'wawan123'],
            [
                'name' => 'wawan',
                'password' => Hash::make('wawan'),
                'role' => 'admin',
            ]
        );
        User::firstOrCreate(
            ['username' => 'irfan'],
            [
                'name' => 'Irfan Ganteng',
                'password' => Hash::make('irfan'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['username' => 'yaya'],
            [
                'name' => 'Yaya ISS',
                'password' => Hash::make('yaya155'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['username' => 'george'],
            [
                'name' => 'George',
                'password' => Hash::make('josgandos'),
                'role' => 'admin',
            ]
        );
        User::firstOrCreate(
            ['username' => 'suparni'],
            [
                'name' => 'Suparni',
                'password' => Hash::make('sni'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['username' => 'dodi'],
            [
                'name' => 'Dodi Hadi P',
                'password' => Hash::make('1'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['username' => 'yuki'],
            [
                'name' => 'Yuki',
                'password' => Hash::make('123'),
                'role' => 'admin',
            ]
        );
        User::firstOrCreate(
            ['username' => '5011147'],
            [
                'name' => 'Dede Sulaiman',
                'password' => Hash::make('1'),
                'role' => 'admin',
            ]
        );

        // User::firstOrCreate(
        //     ['username' => 'hariyadi'],
        //     [
        //         'name' => 'Hariyadi',
        //         'password' => Hash::make('123'),
        //         'role' => 'admin',
        //     ]
        // );
    }
}
