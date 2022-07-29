<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use App\Helpers\CustomResponse;
class UserService extends Service implements UserServiceInterface
{
    /**
     * Constructor function.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * get all users
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }
    /**
     * get user by is
     *
     * @param integer $id
     * @return User
     */
    public function getById(int $id): User
    {
        return $this->repository->getById($id);
    }

    /**
     * Delete user
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteById(int $id): bool
    {
        return $this->repository->deleteById($id);
    }

    /**
     * Create new user
     *
     * @param StoreUserRequest $request
     * @return User
     */
    public function create(StoreUserRequest $request): User
    {
        $request->validated();
        $attributes = $request->all();
        $attributes['password'] = Hash::make($attributes['password']);

        return $this->repository->create($attributes);
    }
    /**
     * update user fields
     *
     * @param User $user
     * @param UpdateUserRequest $request
     * @return User
     */
    public function update(User $user, UpdateUserRequest $request): User
    {
        $request->validated();
        $attributes = $request->only(['name']);

        return $this->repository->update($user->id, [
            'name'=>$attributes['name']
        ]);
    }
    /**
     * update user Password
     *
     * @param User $user
     * @param UpdatePasswordUserRequest $request
     * @return User
     */
    public function updatePassword(User $user, UpdatePasswordUserRequest $request): User
    {
        $request->validated();
        $attributes = $request->only(['password', 'old_password']);
        abort_unless(Hash::check($attributes['old_password'], $user->password), CustomResponse::createError('10002'));
        return $this->repository->update($user->id, [
            'password'=>Hash::make($attributes['password'])
        ]);
    }
    /**
     * login new user
     *
     * @param LoginUserRequest $request
     * @return User
     */
    public function login(LoginUserRequest $request): User
    {
        $request->validated();
        $attributes = $request->only(['email', 'password']);
        $user = $this->repository->getByEmail($attributes['email']);
        abort_unless($user, CustomResponse::createError('10001') );
        abort_unless(Hash::check($attributes['password'], $user->password), CustomResponse::createError('10002') );

        return $user;
    }
}
