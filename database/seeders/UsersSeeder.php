<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // Seed the admin user
        User::create([
            'name'              => 'admin',
            'email'             => 'admin@gmail.com',
            'identification_number' => '11223344',
            'password'          => Hash::make('admin'),
            'role_id'           => 1,
            'email_verified_at' => now(),
        ]);

        $users = [
            ['22315022', 'La Ode Nazar Darwis'],
            ['22315023', 'Yunita Dwi Rahmayana Suseno'],
            ['22315025', 'Muhammad Abdillah Sahma'],
            ['22315026', 'Muhammad Azahri Saputra'],
            ['22315027', 'Ilham Almer Dzaky'],
            ['22315030', 'Fauzil Ahmad Fitrah'],
            ['22315031', 'Kameria'],
            ['22315033', 'Rahma Nur Alisa'],
            ['22315034', 'Arsan'],
            ['22315035', 'Eka Satya Budjana'],
            ['22315036', 'Aulia Ramadhani'],
            ['22315037', 'Muh Alim Al-awwalu Misbah'],
            ['22315038', 'Muhammad Al Farid'],
            ['22315039', 'Muhamad Tauhid'],
            ['22315041', 'Anas Firdaus Habibi'],
            ['22315042', 'Adya Aisya Zara'],
            ['22315043', 'Nur Aisyah'],
        ];

        foreach ($users as $index => $user) {
            User::create([
                'name'                  => $user[1],
                'email'                 => str_replace(' ', '_', $user[1]) . "@gmail.com",
                'identification_number' => $user[0],
                'password'              => Hash::make($user[0]),
                'role_id'               => 3, 
                'finger_id'               => $index + 1, 
                'email_verified_at'     => now(),
            ]);
        }
    }
}
