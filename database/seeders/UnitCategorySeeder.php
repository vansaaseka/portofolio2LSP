<?php

namespace Database\Seeders;

use App\Models\UnitCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UnitCategory::create([
            'name' => 'Badan dan Dinas',
            'slug' => 'badan-dan-dinas',
        ]);

        UnitCategory::create([
            'name' => 'Kantor, Bagian, dan Instansi Lain',
            'slug' => 'kantor-bagian-dan-intansi-lain',
        ]);

        UnitCategory::create([
            'name' => 'Kecamatan',
            'slug' => 'kecamatan',
        ]);
    }
}