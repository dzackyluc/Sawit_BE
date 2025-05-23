<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'azhura',
                'email' => 'azhurasutetsu@gmail.com',
                'no_phone' => '0811111111',
                'password' => Hash::make('admin123'),
                'role' => 'manager',
            ],
            [
                'name' => 'Petani Adam',
                'email' => 'muhnaufal229@gmail.com',
                'no_phone' => '0822222222',
                'password' => Hash::make('admin123'),
                'role' => 'petani',
            ],
            [
                'name' => 'Pengepul Satu',
                'email' => 'sp@gmail.com',
                'no_phone' => '0833333333',
                'password' => Hash::make('admin123'),
                'role' => 'pengepul',
            ],
            [
                'name' => 'Pengepul Dua',
                'email' => 'nn@gmail.com',
                'no_phone' => '0833333333',
                'password' => Hash::make('admin123'),
                'role' => 'pengepul',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
