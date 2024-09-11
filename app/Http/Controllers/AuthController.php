<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRequest $request): JsonResponse
    {

        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);

        return $this->successResponse($user, 'Successfully registered user!', 201);
    }

    public function login(Request $request) : JsonResponse
    {
        $credentials = $request->only('email', 'password');

        // Check credentials in database

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // // Check if email is verified
            // if (!$user->hasVerifiedEmail()) {
            //     return $this->errorResponse('Please verify you email address.', 403);
            // }

            $token = $user->createToken('fitness-api')->plainTextToken;

            $data = ["user" => $user, "token" => $token];

            return $this->successResponse($data, 'Successfully logged in.', 200);
        }

        return $this->errorResponse('Invalid credentials', 401);
    }

    public function logout(Request $request)
    {
        // Logs user out by revoking the token
        // Or invalidating the session if this is session-based authentication
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, "Successfully logged out.");
    }

    // TODO: Reset Password functionality

    // TODO: Refresh Token functionality
}
