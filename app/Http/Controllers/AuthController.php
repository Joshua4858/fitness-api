<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class AuthController extends Controller
{
    public function register (UserRequest $request): JsonResponse {

        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Trigger email verification before token issuance

        // $user->sendEmailVerificationNotification();

        return $this->successResponse($user, 'Successfully registered user!',201);
    }

    public function login (Request $request) {
        // Authenticate using request email and password
        // return 200 login else 401 Unauthorised.
        $credentials = $request->only('email','password');

        // Check credentials in database
        if(Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if email is verified
            if(!user->hasVerifedEmail()) {
                return $this->errorResponse('Please verify you email address.',403);
            }

            $token = $user->createToken('fitness-api')->planTextToken;

            return $this->successResponse([
                'user' => $user,
                'token' => $token,

            ],'Successfully logged in.',200);
        }

        return $this->errorResponse('Invalid credentials',401);

    }

    public function logout (Request $request) {
        // Logs user out by revoking the token
        // Or invalidating the session if this is session-based authentication
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, "Successfully logged out.");
    }
}
