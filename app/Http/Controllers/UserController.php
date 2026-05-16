<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   
    public function index()
    {
        $users = User::paginate(10);
        return response()->json(['users' => $users , 'message' => 'Users retrieved successfully']);
    }

   
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        return response()->json(['user' => $user , 'message' => 'User created successfully']);
    }

    
    public function show(User $user)
    {
        return response()->json(['user' => $user]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json(['user'=>$user , 'message' => 'User updated successfully']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
