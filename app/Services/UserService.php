<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{

    public function list(): LengthAwarePaginator
    {
        return User::paginate();
    }

    public function create(array $userData): User
    {
        $userData['password'] = Hash::make($userData['password']);

        return User::create($userData);
    }

    public function update(User $user, array $userData): bool
    {
        return $user->update($userData);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function restore(int $userId): bool
    {
        return User::withTrashed()->find($userId)->restore();
    }
}
