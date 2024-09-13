<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


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

        event(new Registered($user));
    
        return $this->successResponse($user, 'Successfully registered user!', 201);
    }

    public function login(Request $request) : JsonResponse
    {
        $credentials = $request->only('email', 'password');

        // Check credentials in database

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                return $this->errorResponse('Please verify you email address.', 403);
            }

            $token = $user->createToken('fitness-api')->plainTextToken;

            $data = ["user" => $user, "token" => $token];

            return $this->successResponse($data, 'Successfully logged in.', 200);
        }

        return $this->errorResponse('Invalid credentials', 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, "Successfully logged out.");
    }

    // TODO: Reset Password functionality

    // TODO: Refresh Token functionality

    public function verifyEmail(Request $request, $id, $hash)
    {
        // Find the user by ID from the URL
        $user = User::findOrFail($id);
    
        // Check if the hash matches the hashed email
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return $this->errorResponse('Invalid verification link.', 403);
        }
    
        // Check if the user has already verified their email
        if ($user->hasVerifiedEmail()) {
            return $this->errorResponse('Email already verified.', 400);
        }
    
        // Mark the email as verified
        $user->markEmailAsVerified();
    
        // Generate token after email verification
        $token = $user->createToken('fitness-api')->plainTextToken;
    
        return $this->successResponse(['user' => $user, 'token' => $token], 'Email successfully verified.');
    }
    

    public function resendEmail(Request $request) : JsonResponse {
        // Check if user hasVerifedEmail
        if($request->user()->hasVerifiedEmail()){
            return $this->errorResponse('Email already verified', 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->successResponse(null,"Verification link sent",200);
    }
}
