<?php

use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;

it('create a new user', function () {
    $response = (new UserService())->create([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'email' => fake()->unique()->email(),
        'password' => fake()->password(),
    ]);

    $this->assertTrue($response instanceof User);
});

it('update a user', function () {
    $response = (new UserService())->update(
        User::factory()->create(),
        [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->email(),
            'password' => fake()->password(),
        ]
    );

    $this->assertTrue($response);
});

it('delete a user', function () {
    $response = (new UserService())->delete(User::factory()->create());

    $this->assertTrue($response);
});

it('list users', function () {
    $response = (new UserService())->list();

    $this->assertTrue($response instanceof LengthAwarePaginator);
});

it('can add a role to user', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();
    (new UserService())->addRole($user, $role);

    $this->assertTrue($user->hasAnyRole($role->name));
});

it('can remove a role to user', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();

    (new UserService())->addRole($user, $role);
    $this->assertTrue($user->hasAnyRole($role->name));

    (new UserService())->removeRole($user, $role);
    $this->assertFalse($user->hasAnyRole($role->name));
});
