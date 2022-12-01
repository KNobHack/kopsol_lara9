<?php

namespace Database\Seeders;

use App\Models\Role as RoleModel;
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
        RoleModel::factory()->create([
            'role' => 'Admin'
        ]);
    }
}
