<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Jayusman',
            'email' => 'owner@sijaya.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@sijaya.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@sijaya.com',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Cashier',
            'email' => 'cashier@sijaya.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Warehouse',
            'email' => 'warehouse@sijaya.com',
            'password' => Hash::make('password'),
            'role' => 'warehouse',
            'branch_id' => 1,
        ]);
    }

}
