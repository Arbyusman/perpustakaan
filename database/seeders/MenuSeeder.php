<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            // 1
            [
                'name' => 'Pengaturan',
                'attribute' => 'flaticon2-gear icon-lg text-primary',
                'link' => "#",
                'position' => 1,
                'category' => 1,
            ],

        ];

        Menu::insert($data);
    }
}
