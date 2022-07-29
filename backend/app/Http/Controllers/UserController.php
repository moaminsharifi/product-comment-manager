<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdatePasswordUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Helpers\CustomResponse;
class UserController extends Controller
{
    protected $service;
    /**
     * Contractor function
     *
     * @param UserService $service
     */
    public function __construct(UserService $service) {
        $this->service = $service;
    }
    


    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return UserResource
     */
    public function signup(StoreUserRequest $request)
    {
        $user = $this->service->create($request);
        return new UserResource($user);
    }

    /**
     * Display User Info
     *
     * @param  User  $user
     * @return UserResource
     */
    public function show()
    {
        $user = auth()->user();
        return new UserResource($user);
    }


    /**
     * Update fields of User
     *
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $this->service->update($user , $request);
        return new UserResource($user);
    }


     /**
     * Update Password of user
     *
     * @param  UpdatePasswordUserRequest  $request
     * @param  User  $user
     * @return UserResource
     */
    public function updatePassword(UpdatePasswordUserRequest $request, User $user)
    {
        $user = $this->service->updatePassword($user , $request);
        return new UserResource($user);
    }

    /**
     * Login User
     *
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
