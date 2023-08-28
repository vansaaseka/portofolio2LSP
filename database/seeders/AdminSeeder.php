<?php

namespace Database\Seeders;

use App\Models\AdminCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminCategory::create([
            'name' =>'aplikasi'
        ]);

        AdminCategory::create([
            'name' =>'jaringan'
        ]);

        AdminCategory::create([
            'name' =>'keamanan'
        ]);

    }
}