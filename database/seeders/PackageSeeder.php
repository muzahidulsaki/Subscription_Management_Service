<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // আগে কোনো ডাটা থাকলে মুছে ফেলি (যাতে ডুপ্লিকেট না হয়)
        // Package::truncate(); // যদি ফরেইন কি এরর দেয় তবে এটা বাদ দিতে পারেন

        $packages = [
            [
                'name' => 'Trial',
                'price' => 0.00,
                'duration_days' => 30,
                'type' => 'trial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gold',
                'price' => 3000.00,
                'duration_days' => 30,
                'type' => 'monthly',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Platinum',
                'price' => 5000.00,
                'duration_days' => 30,
                'type' => 'monthly',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Diamond',
                'price' => 8000.00,
                'duration_days' => 30,
                'type' => 'monthly',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Package::truncate();
        Package::insert($packages);
    }
}
