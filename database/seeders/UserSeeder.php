<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersData = [
            [
                'first_name' => 'Usuario',
                'last_name' => 'Administrador',
                'email' => 'ramosdumas_ismael@hotmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('UsersManagement2024!'),
                'remember_token' => Str::random(10),
                'role_name' => RoleEnum::ADMINISTRADOR->value,
            ], [
                'first_name' => 'Usuario',
                'last_name' => 'Revisor',
                'email' => 'revisor@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('UsersManagement2024!'),
                'remember_token' => Str::random(10),
                'role_name' => RoleEnum::REVISOR->value,
            ]
        ];

        foreach($usersData as $userData) {
            $roleName = $userData['role_name'];
            unset($userData['role_name']);

            $user = User::create($userData);
            $user->assignRole($roleName);
        }

        for($cont = 0; $cont < 100; $cont++) {
            $user = User::factory()->create();

            $user->assignRole(
                fake()->randomElement([RoleEnum::ADMINISTRADOR->value, RoleEnum::REVISOR->value])
            );
        }

    }
}
