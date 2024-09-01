<?php

use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::prefix('workouts')->group(function () {
    Route::get('/', [WorkoutController::class, 'index'])->name('workouts.index');
    Route::post('/', [WorkoutController::class, 'store'])->name('workouts.store');
    Route::get('/{id}', [WorkoutController::class, 'show'])->name('workouts.show');
    Route::put('/{workout}', [WorkoutController::class, 'update'])->name('workouts.update');
    Route::delete('/{workout}', [WorkoutController::class, 'destroy'])->name('workouts.destroy');
});

// Public routes
Route::controller(RegisterController::class)->group(function() {
    Route::post('register','register');
    Route::post('login','login');
});
