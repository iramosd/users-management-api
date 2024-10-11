<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function list(): LengthAwarePaginator;
    public function create(array $userData): User;
    public function update(User $user, array $userData): bool;
    public function delete(User $user): bool;
    public function restore(int $userId): bool;
}
