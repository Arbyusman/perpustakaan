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
            // ['22315022', 'La Ode Nazar Darwis'],
            // ['22315023', 'Yunita Dwi Rahmayana Suseno'],
            // ['22315025', 'Muhammad Abdillah Sahma'],
            // ['22315026', 'Muhammad Azahri Saputra'],
            // ['22315027', 'Ilham Almer Dzaky'],
            // ['22315030', 'Fauzil Ahmad Fitrah'],
            // ['22315031', 'Kameria'],
            // ['22315033', 'Rahma Nur Alisa'],
            // ['22315034', 'Arsan'],
            // ['22315035', 'Eka Satya Budjana'],
            // ['22315036', 'Aulia Ramadhani'],
            // ['22315037', 'Muh Alim Al-awwalu Misbah'],
            // ['22315038', 'Muhammad Al Farid'],
            // ['22315039', 'Muhamad Tauhid'],
            // ['22315041', 'Anas Firdaus Habibi'],
            // ['22315042', 'Adya Aisya Zara'],
            // ['22315043', 'Nur Aisyah'],
            ['22016076', 'Naya Insiani'],
            ['22375001', 'Endang Sukmawati'],
            ['22375002', 'Sulwan'],
            ['22375003', 'Anugrah Fernanda'],
            ['22375004', 'Sulis Usman'],
            ['22375005', 'Gusmar Susanto'],
            ['22375006', 'Lili Mahdaniati'],
            ['22375008', 'Reni Rusman'],
            ['22375009', 'Muhammad Nurdiansyah Sea'],
            ['22375010', 'Zarmin Muamala Naana'],
            ['22375011', 'Muh. Izhul Islam Samaga'],
            ['22375012', 'Siti Nurhanisa Sesar'],
            ['22375013', 'Deka Adinda Putri Rahayu'],
            ['22375014', 'Zahriani'],
            ['22375016', 'Azizah Ainiyah'],
            ['22375017', 'Reva Andriyani'],
            ['22375018', 'Salwa Suhirman'],
            ['22375020', 'Ismayanti'],
            ['22375021', 'Nelda Faudiah'],
            ['22375022', 'Sahrani Arifin'],
            ['22375023', 'Sri Wahyuni.a'],
            ['22375024', 'Sumarlin.a'],
            ['22375025', 'Hikmad Almaqiah'],
            ['22375026', 'Aswinda'],
            ['22375027', 'Umi'],
            ['22375028', 'Endang'],
            ['22375029', 'Elsa'],
            ['22375030', 'Nur Fadilah'],
            ['22375031', 'Nasraeni'],
            ['22375042', 'Putrasyam'],
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
