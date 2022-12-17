<?php

namespace Database\Seeders;

use App\Models\Central\Role;
use App\Models\Central\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => Role::ROLE['admin'],
            'email' => 'admin@kopsol.id',
            'password' => Hash::make('OnlyAdminShouldKnowThat'),
        ]);
    }
}
