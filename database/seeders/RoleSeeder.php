<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => RoleEnum::ADMINISTRADOR->value,
                'guard_name' => 'web'
            ],
            [
                'name' => RoleEnum::REVISOR->value,
                'guard_name' => 'web'
            ]
        ];

        foreach ($roles as $role) {
            $newRole = Role::create($role);

            if($newRole === RoleEnum::ADMINISTRADOR->value)
                $newRole->givePermissionTo(Permission::all()->pluck('name'));

            if($newRole === RoleEnum::REVISOR->value)
                $newRole->givePermissionTo('list-users');
        }
    }
}
