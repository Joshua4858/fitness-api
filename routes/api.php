<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::prefix('workouts')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', [WorkoutController::class, 'index'])->name('workouts.index');
    Route::post('/', [WorkoutController::class, 'store'])->name('workouts.store');
    Route::get('/{id}', [WorkoutController::class, 'show'])->name('workouts.show');
    Route::put('/{workout}', [WorkoutController::class, 'update'])->name('workouts.update');
    Route::delete('/{workout}', [WorkoutController::class, 'destroy'])->name('workouts.destroy');
});

// Only admins can manage roles
Route::prefix('roles')->middleware(['auth:sanctum', 'verified', 'can:manage-roles'])->group(function () {
    Route::get('/',[RoleController::class,'index'])->name('roles.index');
    Route::post('/',[RoleController::class,'store'])->name('roles.store');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

// IMPORTANT! - due to defining this manually as Headless API ensure to use correct route names as VerifyEmail uses particular names like 'verification.verify'
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify');
Route::post('/email/resend', [EmailVerificationController::class, 'resendEmail'])->name('resendEmail');

// Routes to implement proper email verification with Sanctum
// 1.) Route to display a notice to the user that they should click the email verification link in the verification email that Laravel sent to email
// 2.) Route to hanlde requests generated when the user clicks the email verification link in the email ( Need this for Sanctum )
// 3.) Route to resend link to verify email ( Need this for Sanctum )
