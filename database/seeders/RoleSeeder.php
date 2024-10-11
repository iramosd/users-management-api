<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'administrador',
                'guard_name' => 'web'
            ],
            [
                'name' => 'revisor',
                'guard_name' => 'web'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
