<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;

    /**
     * Contractor function.
     *
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Store User.
     *
     *  This endpoint Sing up new user and return token.
     *
     * @responseFile status=200 docs/responses/user/data.success.json
     * @responseFile status=422 scenario="Invalid Name"  docs/responses/user/singup.invalid.name.json
     * @responseFile status=422 scenario="Invalid Email"  docs/responses/user/singup.invalid.email.json
     * @responseFile status=422 scenario="Invalid Email (exist in database)"  docs/responses/user/singup.invalid_exist.email.json
     * @responseFile status=422 scenario="Invalid Password"  docs/responses/user/singup.invalid.password.json
     * @responseFile status=422 scenario="Invalid Password (miss match with password_confirm)"  docs/responses/user/singup.invalid_miss_match.password.json
     * @param  StoreUserRequest  $request
     * @return UserResource
     */
    public function signup(StoreUserRequest $request)
    {
        $user = $this->service->create($request);

        return new UserResource($user);
    }

    /**
     * Display User Info.
     *
     * This endpoint Get (logged) user with new token.
     *
     *
     * @authenticated
     * @responseFile status=200 docs/responses/user/data.success.json
     * @param  User  $user
     * @return UserResource
     */
    public function show()
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    /**
     * Update fields of User.
     * @hideFromAPIDocumentation
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $this->service->update($user, $request);

        return new UserResource($user);
    }

    /**
     * Update Password of user.
     * @hideFromAPIDocumentation
     * @param  UpdatePasswordUserRequest  $request
     * @param  User  $user
     * @return UserResource
     */
    public function updatePassword(UpdatePasswordUserRequest $request, User $user)
    {
        $user = $this->service->updatePassword($user, $request);

        return new UserResource($user);
    }

    /**
     * Login User.
     *
     *  This endpoint Log user and return token.
     *
     * @responseFile status=200 docs/responses/user/data.success.json
     * @responseFile status=422 scenario="Invalid Email"  docs/responses/user/login.invalid_email.json
     * @responseFile status=422 scenario="Invalid Password"  docs/responses/user/login.invalid_password.json
     * @param  LoginUserRequest  $request
     * @param  User  $user
     * @return UserResource
     */
    public function login(LoginUserRequest $request)
    {
        $user = $this->service->login($request);

        return new UserResource($user);
    }
}
