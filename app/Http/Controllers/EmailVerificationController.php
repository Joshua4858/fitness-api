<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verifyEmail(Request $request, $id, $hash)
    {
        // Find the user by ID from the URL
        $user = User::findOrFail($id);

        // Check if the hash matches the hashed email
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
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

    public function resendEmail(Request $request): JsonResponse
    {
        // Check if user hasVerifedEmail
        if ($request->user()->hasVerifiedEmail()) {
            return $this->errorResponse('Email already verified', 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->successResponse(null, 'Verification link sent', 200);
    }
}
