<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UnitCategorySeeder::class);
        $this->call(PostCategorySeeder::class);
        $this->call(AdminSeeder::class);
        
        $this->call(UnitSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(TopicSeeder::class);
        
        $this->call(FaqSeeder::class);
        // $this->call(TicketSeeder::class);
    }
}