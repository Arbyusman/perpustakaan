<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Absen UMK',
                'short_name' => 'Absen UMK',
                'small_icon' => 'default_logo.png',
                'large_icon' => 'default_logo.png',
                'background_login' => 'default_background.jpg',
            ],
        ];

        Setting::insert($data);
    }
}
