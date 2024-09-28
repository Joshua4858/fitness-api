<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthService 
{
    /**
     * Register a new user with a 'client' role
     * @param array $data
     * @return User
     */
    public function registerUser(array $validatedData): User
    {
        // Create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);

        $clientRole = Role::where('name','client')->first();
        $user->roles()->attach($clientRole->id);

        // Fire the registered event
        event(new Registered($user));

        return $user;
    }
}