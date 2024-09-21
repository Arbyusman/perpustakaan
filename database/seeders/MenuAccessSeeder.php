<?php

namespace Database\Seeders;

use App\Models\MenuAccess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuAccessSeeder extends Seeder
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
                'create' => 1,
                'read' => 1,
                'update' => 1,
                'delete' => 1,
            ],

        ];

        MenuAccess::insert($data);
    }
}
