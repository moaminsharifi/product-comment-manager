<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService extends Service
{
    public function getAll(): Collection
    {
    }

    public function getById(int $id): User
    {
    }

    public function deleteById(int $id): bool
    {
    }

    public function create(array $attributes): User
    {
    }

    public function update(int $id, array $attributes): User
    {
    }
}
