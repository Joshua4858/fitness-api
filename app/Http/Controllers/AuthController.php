<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class AuthController extends Controller
{
    public function register (UserRequest $request) {

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

    public function login () {
        // Authenticate using request email and password
        // return 200 login

    }

    public function logout () {
        // Logs user out by revoking the token
        // Or invalidating the session if this is session-based authentication
    }
}
