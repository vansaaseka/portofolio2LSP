<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kominfo Sukoharjo',
            'email' => 'diskominfo@sukoharjokab.go.id',
            'password' => bcrypt('123'),
            'unit_id' => null,
            'role_id' => '1',
        ]);

        User::create([
            'name' => 'Admin Aplikasi',
            'email' => 'aplikasi@gmail.com',
            'password' => bcrypt('123'),
            'unit_id' => null,
            'role_id' => '4',
            'admin_category_id' => '1',
        ]);

        User::create([
            'name' => 'Admin Jaringan',
            'email' => 'jaringan@gmail.com',
            'password' => bcrypt('123'),
            'unit_id' => null,
            'role_id' => '4',
            'admin_category_id' => '2',
        ]);

        User::create([
            'name' => 'Admin Keamanan',
            'email' => 'keamanan@gmail.com',
            'password' => bcrypt('123'),
            'unit_id' => null,
            'role_id' => '4',
            'admin_category_id' => '3',
        ]);

        User::create([
            'name' => 'Dinas Pendidikan dan Kebudayaan',
            'email' => 'dikbud@sukoharjokab.go.id',
            'password' => bcrypt('123'),
            'unit_id' => 1,
            'role_id' => '2',
        ]);

        User::create([
            'name' => 'Dinas Kesehatan',
            'email' => 'dkk@sukoharjokab.go.id',
            'password' => bcrypt('123'),
            'unit_id' => 2,
            'role_id' => '2',
        ]);

        User::create([
            'name' => 'Sekretariat Dewan Perwakilan Rakyat Daerah',
            'email' => 'setdprd@sukoharjokab.go.id',
            'password' => bcrypt('123'),
            'unit_id' => 3,
            'role_id' => '2',
        ]);

        User::create([
            'name' => 'Inspektorat',
            'email' => 'inspektorat@sukoharjokab.go.id',
            'password' => bcrypt('123'),
            'unit_id' => 4,
            'role_id' => '2',
        ]);

        User::create([
            'name' => 'Kecamatan Weru',
            'email' => 'kecweru@sukoharjokab.go.id',
            'password' => bcrypt('123'),
            'unit_id' => 5,
            'role_id' => '2',
        ]);

        User::create([
            'name' => 'Kecamatan Tawangsari',
            'email' => 'kectawangsari@sukoharjokab.go.id',
            'password' => bcrypt('123'),
            'unit_id' => 6,
            'role_id' => '2',
        ]);

        User::create([
            'name' => 'Reyhan Naufal Hakim',
            'email' => 'reyhannaufal19@gmail.com',
            'password' => bcrypt('password'),
            'unit_id' => 1,
            'role_id' => '3',
        ]);

        User::create([
            'name' => 'Yusuf',
            'email' => 'yusuf@gmail.com',
            'password' => bcrypt('123'),
            'unit_id' => 2,
            'role_id' => '3',
        ]);

        User::create([
            'name' => 'Nela',
            'email' => 'nela@gmail.com',
            'password' => bcrypt('123'),
            'unit_id' => 2,
            'role_id' => '3',
        ]);

        User::create([
            'name' => 'Vansa',
            'email' => 'vansa@gmail.com',
            'password' => bcrypt('123'),
            'unit_id' => 2,
            'role_id' => '3',
        ]);

        User::create([
            'name' => 'Tyo Aditya',
            'email' => 'tyo@gmail.com',
            'password' => bcrypt('123'),
            'unit_id' => 1,
            'role_id' => '3',
        ]);
    }
}