<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * get All users.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * Get user by id.
     *
     * @param int $id
     * @return User
     */
    public function getById(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Delete user by id.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        User::destroy($id);

        return true;
    }

    /**
     * create user by attributes.
     *
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes): User
    {
        return User::create($attributes);
    }

    /**
     * update existent user with attributes.
     *
     * @param int $id
     * @param array $attributes
     * @return User
     */
    public function update(int $id, array $attributes): User
    {
        return User::findOrFail($id)->update($attributes);
    }

    /**
     * Get user by ed.
     *
     * @param string $email
     * @return User
     */
    public function getByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }
}
