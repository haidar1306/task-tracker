<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Doctrine\DBAL\Driver\OCI8\Exception\Error;
use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;


class AuthApiController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|digits_between:10,15',
        'password' => 'required|confirmed|min:8',
    ]);

    $user = $this->userService->registerUser($validated);

    return response()->json([
        'success' => true,
        'message' => 'User registered successfully',
        'user' => $user,
    ], 201);
}

public function users()
{
    $users = User::all();

    return response()->json([
        'success' => true,
        'data' => $users
    ]);
}
public function show($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'User retrieved successfully',
        'data' => $user
    ]);
}

}