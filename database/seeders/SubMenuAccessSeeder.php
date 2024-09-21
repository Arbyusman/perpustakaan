<?php

namespace Database\Seeders;

use App\Models\SubMenuAccess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubMenuAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // 1
            [
                'role_id' => 1,
                'menu_id' => 1,
                'sub_menu_id' => 1,
                'create' => 1,
                'read' => 1,
                'update' => 1,
                'delete' => 1,
            ],
            // 2
            [
                'role_id' => 1,
                'menu_id' => 1,
                'sub_menu_id' => 2,
                'create' => 1,
                'read' => 1,
                'update' => 1,
                'delete' => 1,
            ],
            // 3
            [
                'role_id' => 1,
                'menu_id' => 1,
                'sub_menu_id' => 3,
                'create' => 1,
                'read' => 1,
                'update' => 1,
                'delete' => 1,
            ],
            // 4
            [
                'role_id' => 1,
                'menu_id' => 1,
                'sub_menu_id' => 4,
                'create' => 1,
                'read' => 1,
                'update' => 1,
                'delete' => 1,
            ]

        ];
        SubMenuAccess::insert($data);
    }
}
