<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class RegisterController extends Controller
{
    public function register (UserRequest $request) {

        // Validate the request
        // Once validated we need to create a user using the credentials in request
        // generate token for new user and store in table
        // Return json response with status code 201
    }

    public function login () {
        // Authenticate using request email and password
        // return 200 login

    }
}
