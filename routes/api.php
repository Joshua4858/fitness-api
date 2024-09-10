<?php

use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('workouts')->group(function () {
    Route::get('/', [WorkoutController::class, 'index'])->name('workouts.index');
    Route::post('/', [WorkoutController::class, 'store'])->name('workouts.store');
    Route::get('/{id}', [WorkoutController::class, 'show'])->name('workouts.show');
    Route::put('/{workout}', [WorkoutController::class, 'update'])->name('workouts.update');
    Route::delete('/{workout}', [WorkoutController::class, 'destroy'])->name('workouts.destroy');
});


Route::post('/register',[AuthController::class, 'register'])->name('auth.register');
Route::post('/login',[AuthController::class,'login'])->name('auth.login');


// Public routes
// Route::controller(AuthController::class)->group(function() {
//     Route::post('/register','register');
//     Route::post('/login','login');
// });
