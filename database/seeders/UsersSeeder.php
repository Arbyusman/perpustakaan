<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $demoUser = User::create([
            'name'              => "admin",
            'email'             => 'admin@gmail.com',
            'nik'             => '11223344',
            'password'          => Hash::make('admin'),
            'role_id'          => 1,
            'email_verified_at' => now(),
        ]);

    }
}
