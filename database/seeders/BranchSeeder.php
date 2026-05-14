<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'SIJAYA Bandung',
            'city' => 'Bandung',
            'address' => 'Jl. Asia Afrika No. 10',
        ]);

        Branch::create([
            'name' => 'SIJAYA Jakarta',
            'city' => 'Jakarta',
            'address' => 'Jl. Sudirman No. 20',
        ]);

        Branch::create([
            'name' => 'SIJAYA Surabaya',
            'city' => 'Surabaya',
            'address' => 'Jl. Pemuda No. 15',
        ]);

        Branch::create([
            'name' => 'SIJAYA Yogyakarta',
            'city' => 'Yogyakarta',
            'address' => 'Jl. Malioboro No. 8',
        ]);

        Branch::create([
            'name' => 'SIJAYA Medan',
            'city' => 'Medan',
            'address' => 'Jl. Gatot Subroto No. 5',
        ]);
    }
}