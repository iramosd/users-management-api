<?php

use App\Enum\RoleEnum;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

it('list all users ', function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
    $this->seed(UserSeeder::class);

    $adminUser = User::role(RoleEnum::ADMINISTRADOR->value)->first();
    $this->actingAs($adminUser)->get('/api/users')
        ->assertOk();

    $reviewerUser = User::role(RoleEnum::REVISOR->value)->first();
    $this->actingAs($reviewerUser)->get('/api/users')
        ->assertOk();
});

it('Check endpoint for create new user', function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
    $this->seed(UserSeeder::class);
    $adminUser = User::role(RoleEnum::ADMINISTRADOR->value)->first();

    $password = fake()->password(8, 12) . '@123Password';

    $this->actingAs($adminUser)->post('/api/users',
        [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
        ]
    )->assertStatus(201);
});

it('Check endpoint for failed on create new user', function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
    $this->seed(UserSeeder::class);
    $adminUser = User::role(RoleEnum::ADMINISTRADOR->value)->first();
    $reviewerUser = User::role(RoleEnum::REVISOR->value)->first();

    $password = fake()->password(8, 12) . '@123Password';

    $this->actingAs($adminUser)->post('/api/users',
        [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '12345',
        ]
    )->assertStatus(302);

    $this->actingAs($reviewerUser)->post('/api/users',
        [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
        ]
    )->assertStatus(403);
});

it('Check endpoint for update user', function () {

    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
    $this->seed(UserSeeder::class);
    $adminUser = User::role(RoleEnum::ADMINISTRADOR->value)->first();
    $reviewerUser = User::role(RoleEnum::REVISOR->value)->first();

    $this->actingAs($adminUser)->patch('/api/users/'.User::factory()->create()->id, [
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'email' => fake()->unique()->safeEmail(),
    ])->assertOk();

    $this->actingAs($reviewerUser)->patch('/api/users/'.User::factory()->create()->id, [
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'email' => fake()->unique()->safeEmail(),
    ])->assertStatus(403);
});

it('Check endpoint for show user', function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
    $this->seed(UserSeeder::class);
    $adminUser = User::role(RoleEnum::ADMINISTRADOR->value)->first();
    $reviewerUser = User::role(RoleEnum::REVISOR->value)->first();

    $this->actingAs($adminUser)->get('/api/users/'.User::factory()->create()->id)
        ->assertOk();

    $this->actingAs($reviewerUser)->get('/api/users/'.User::factory()->create()->id)
        ->assertOk();

    $this->actingAs($reviewerUser)->get('/api/users/1555151515151515151515151515')
        ->assertStatus(404);
});

it('Check endpoint for delete user', function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
    $this->seed(UserSeeder::class);
    $adminUser = User::role(RoleEnum::ADMINISTRADOR->value)->first();
    $reviewerUser = User::role(RoleEnum::REVISOR->value)->first();

    $this->actingAs($adminUser)->delete('/api/users/'.User::factory()->create()->id)
        ->assertStatus(204);

    $this->actingAs($reviewerUser)->delete('/api/users/'.User::factory()->create()->id)
        ->assertStatus(403);
});
