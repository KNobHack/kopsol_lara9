<?php

namespace Database\Seeders;

use App\Models\Central\Role as RoleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoleModel::create([
            'role' => 'Admin'
        ]);

        RoleModel::create([
            'role' => 'User'
        ]);
    }
}
