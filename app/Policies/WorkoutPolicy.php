<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workout;

class WorkoutPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole("admin") || $user->hasRole('trainer');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Workout $workout): bool
    {
        // Clients can view their own workout, trainers and admins can view any workout

        return $user->id === $workout->user_id || $user->hasRole("admin") || $user->hasRole('trainer');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    { 
        // Only the admin and the trainers can create workouts
        return $user->hasRole('admin') || $user->hasRole('trainer');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Workout $workout): bool
    {
        // Only the admin and the trainers can update workouts
        return $user->hasRole('admin') || $user->hasRole('trainer');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Workout $workout): bool
    {
        // Only admins can delete
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Workout $workout): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Workout $workout): bool
    {
        //
    }
}
