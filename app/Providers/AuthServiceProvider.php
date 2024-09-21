<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Workout;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        Gate::define('update-workout', function (User $user, Workout $workout) {
            return $user->id === $workout->user_id;
        });

        Gate::define('manage-roles', function (User $user) {
            // dd($user->roles->pluck('name')); // This will output the roles of the current user

            return $user->hasRole('admin');
        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            // Generate the signed URL with expiration (default: 60 minutes)
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $notifiable->id, 'hash' => sha1($notifiable->getEmailForVerification())]
            );

            return (new MailMessage)
                ->subject('Verify Your Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $verificationUrl);
        });
    }
}
