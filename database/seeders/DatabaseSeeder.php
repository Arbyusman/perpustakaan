<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Airport;
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
        $this->call([
            // USERS
            RoleSeeder::class,
            UsersSeeder::class,
            
            // WEB
            MenuSeeder::class,
            SubMenuSeeder::class,
            MenuAccessSeeder::class,
            SubMenuAccessSeeder::class,
            SettingSeeder::class,

        ]);

      
    }
}
