<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topic::create([
            'title' => 'Data Pokok Pendidikan (Dapodik)',
            'slug' => 'data-pokok-pendidikan',
            'unit_id' => '1',
        ]);

        Topic::create([
            'title' => 'Pendidikan Dalam Aplikasi (PEPAK)',
            'slug' => 'pendidikan-dalam-aplikasi',
            'unit_id' => '1',
        ]);

        Topic::create([
            'title' => 'SIMPEG: Sistem Informasi Kepegawaian',
            'slug' => 'sistem-informasi-kepegawaian',
            'unit_id' => '1',
        ]);

        Topic::create([
            'title' => 'SIMPATIKA: Sistem Informasi Manajemen Keuangan',
            'slug' => 'sistem-informasi-manajemen-keuangan',
            'unit_id' => '1',
        ]);

        Topic::create([
            'title' => 'SISKOMINFO: Sistem Informasi Komunikasi dan Informatika',
            'slug' => 'sistem-informasi-komunikasi-dan-informatika',
            'unit_id' => '1',
        ]);
    }
}