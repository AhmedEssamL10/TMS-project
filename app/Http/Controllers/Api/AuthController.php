<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->success(['user' => $user, 'token' => $token], 'User registered successfully', 201);
    }
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('Invalid credentials', 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->success(['user' => $user, 'token' => $token], 'User logged in successfully', 200);
    }
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return $this->success([], 'Logged out successfully', 200);
    }
}
