<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ticket::factory(5)->create();

        Ticket::create([
            'title' => 'Judul 1',
            'slug' => 'judul-1',
            'excerpt' => 'judul1',
            'body' => 'judul1',
            'user_id' => 11,
            'unit_id' => 1,
            'category_id' => 1,
            'created_at' => '2023-06-20'
        ]);

        Ticket::create([
            'title' => 'Judul 2',
            'slug' => 'judul-2',
            'excerpt' => 'judul1',
            'body' => 'judul1',
            'user_id' => 11,
            'unit_id' => 1,
            'category_id' => 1,
            'created_at' => '2023-06-18'
        ]);
        
        Ticket::create([
            'title' => 'Judul 3',
            'slug' => 'judul-3',
            'excerpt' => 'judul1',
            'body' => 'judul1',
            'user_id' => 11,
            'unit_id' => 1,
            'category_id' => 1,
            'created_at' => '2023-06-16'
        ]);
    }
}