<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'title' => 'Bagaimana cara membuat tiket aduan?',
            'slug' => 'bagaimana-cara-membuat-tiket-aduan',
            'answer' => 'User dapat memilih menu "Tiket Aduan" lalu bisa memasukkan judul aduan, kategori aduan, dan isi aduan. User juga bisa mem filter aduan sesuai yang di ingin kan.',
        ]);
        
        Faq::create([
            'title' => 'Bagaimana jika aduan tidak kunjung selesai?',
            'slug' => 'bagaimana-jika-aduan-tidak-kunjung-selesai',
            'answer' => 'User bisa dapat langsung melapor kepada admin OPD atau ke pihak Diskominfo',
        ]);

        Faq::create([
            'title' => 'Bagaimana cara mendaftarkan akun pada website SOLUTIF ?',
            'slug' => 'Bagaimana-cara-mendaftarkan-akun-pada-website-solutif',
            'answer' => 'Seluruh akun Staff OPD sudah di daftarkan sendiri oleh Admin OPD nya masing-masing. Jika Akun Admin OPD sudah di tambahkan oleh pihak Kominfo.',
        ]);
    }
}