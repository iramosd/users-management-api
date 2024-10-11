<?php

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
