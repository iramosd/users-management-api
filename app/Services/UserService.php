<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as BaseRole;

class UserService implements UserServiceInterface
{

    public function list(): LengthAwarePaginator
    {
        return User::paginate();
    }

    public function create(array $userData): User
    {
        $userData['password'] = Hash::make($userData['password']);
        $userData['email_verified_at'] = now();
        $userData['remember_token'] = Str::random(10);

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

    public function addRole(User $user, BaseRole | array $roles): User
    {
        return $user->assignRole($roles);
    }

    public function removeRole(User $user, BaseRole $role): User
    {
        return $user->removeRole($role);
    }
}
