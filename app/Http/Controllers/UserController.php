<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Users\UserCreateRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $users = User::paginate(10);
        return ApiResponse::success(
            'Users retrieved successfully',
            ['users' => UserResource::collection($users)]
        );
    }



    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->validated());
        return ApiResponse::success(
            'User created successfully',
            ['user' => new UserResource($user)]
        );
    }



    public function show(User $user)
    {
        return ApiResponse::success(
            'User show successfully',
            ['user' => new UserResource($user)]
        );
    }



    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());
        return ApiResponse::success(
            'User updated successfully',
            ['user' => new UserResource($user)]
        );
    }



    public function destroy(User $user)
    {
        $user->delete();
        return ApiResponse::success('User deleted successfully');
    }
}
