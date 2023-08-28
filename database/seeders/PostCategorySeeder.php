<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostCategory::create([
            'name' => 'Aplikasi',
            'slug' => 'aplikasi',
        ]);

        PostCategory::create([
            'name' => 'Jaringan',
            'slug' => 'jaringan',
        ]);

        PostCategory::create([
            'name' => 'Keamanan',
            'slug' => 'keamanan',
        ]);
    }
}