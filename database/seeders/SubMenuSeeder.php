<?php

namespace Database\Seeders;

use App\Models\SubMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // 1
            [
                'menu_id' => 1,
                'name' => 'User',
                'link' => '/admin/users',
                'attribute' => "text-primary flaticon-users icon-lg",
                'position' => 1,
            ],
            // 2
            [
                'menu_id' => 1,
                'name' => 'Role',
                'link' => '/admin/roles',
                'attribute' => "text-primary flaticon2-group icon-lg",
                'position' => 1,
            ],
            // 3
            [
                'menu_id' => 1,
                'name' => 'Menu',
                'link' => '/admin/menus',
                'attribute' => "text-primary flaticon2-menu-3",
                'position' => 1,
            ],
            // 4
            [
                'menu_id' => 1,
                'name' => "Pengaturan Aplikasi",
                'link' => "/admin/settings",
                'attribute' => "text-primary flaticon-presentation icon-lg",
                'position' => 4,
            ]

        ];

        SubMenu::insert($data);
    }
}
