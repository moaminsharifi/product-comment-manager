<?php

namespace App\Contracts;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

interface UserServiceInterface
{
    public function create(StoreUserRequest $request): User;

    public function update(User $user, UpdateUserRequest $request): User;

    public function updatePassword(User $user, UpdatePasswordUserRequest $request): User;

    public function login(LoginUserRequest $request): User;
}
