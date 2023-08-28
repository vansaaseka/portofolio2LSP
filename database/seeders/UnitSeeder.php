<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            'name' => 'Dinas Pendidikan dan Kebudayaan',
            'slug' => 'dinas-pendidikan-dan-kebudayaan',
            'phone_number' => '02710929292',
            'address' => 'Jl. Wandyopranoto, Mandan, Sukoharjo',
            'category_id' => '1',
        ]);

        Unit::create([
            'name' => 'Dinas Kesehatan',
            'slug' => 'dinas-kesehatan',
            'phone_number' => '0271593015',
            'address' => 'Jalan Dr. Muwardi No. 56 Sukoharjo',
            'category_id' => '1',
        ]);

        Unit::create([
            'name' => 'Sekretariat Dewan Perwakilan Rakyat Daerah',
            'slug' => 'sekretariat-dewan-perwakilan-rakyat-daerah',
            'phone_number' => '0272593059',
            'address' => 'Jl. Veteran No. 6 Sukoharjo',
            'category_id' => '2',
        ]);

        Unit::create([
            'name' => 'Inspektorat',
            'slug' => 'inspektorat',
            'phone_number' => '0271593068',
            'address' => 'Gedung Menara Wijaya Lantai. 7, Jl. Jenderal Sudirman No. 199 Sukoharjo',
            'category_id' => '2',
        ]);

        Unit::create([
            'name' => 'Kecamatan Weru',
            'slug' => 'kecamatan-weru',
            'phone_number' => '0272881005',
            'address' => 'Jl. Kapten Pattimura No.6, Ngreco, Weru Sukoharjo, 57562',
            'category_id' => '3',
        ]);

        Unit::create([
            'name' => 'Kecamatan Tawangsari',
            'slug' => 'kecamatan-tawangsari',
            'phone_number' => '0272881284',
            'address' => 'Jl. Laksamana Yos Sudarso No.17 Tawangsari kodepos 57561',
            'category_id' => '3',
        ]);
    }
}