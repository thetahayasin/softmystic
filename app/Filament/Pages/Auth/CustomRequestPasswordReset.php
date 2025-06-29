<?php

namespace App\Filament\Pages\Auth;

use App\Notifications\FilamentPasswordResetNotification; // Use your new ResetPasswordNotification
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\PasswordReset\RequestPasswordReset as BaseRequestPasswordReset;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use BezhanSalleh\FilamentShield\Models\Role;
use Illuminate\Cache\RateLimiter; // Import the RateLimiter

class CustomRequestPasswordReset extends BaseRequestPasswordReset
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
            ]);
    }

    public function request(): void
    {
        // --- REVISED SECTION FOR RATE LIMITING ---
        $limiter = app(RateLimiter::class);
        $throttleKey = $this->throttleKey();
        $decaySeconds = $this->getRateLimitDecaySeconds(); // Now 10 seconds

        // Check if too many attempts have already been made
        // This means: if the count is 1 or more (after the very first attempt), it's too many.
        if ($limiter->tooManyAttempts($throttleKey, 1)) {
            $seconds = $limiter->availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            Notification::make()
                ->title(__('Too many attempts. Please wait :seconds seconds.', [
                    'seconds' => $seconds,
                    'minutes' => $minutes,
                ])) // Clarified message for seconds
                ->danger()
                ->send();

            $this->form->fill();
            return; // Stop execution
        }

        // If not too many attempts, record this attempt
        $limiter->hit($throttleKey, $decaySeconds);
        // --- END REVISED SECTION ---

        $data = $this->form->getState();

        // Find the user by email
        $user = Filament::auth()->getProvider()->retrieveByCredentials(['email' => $data['email']]);

        // IMPORTANT: Check if the user exists AND has the 'super_admin' role
        if (!$user || ! $user->hasRole('super_admin')) {
            Notification::make()
                ->title(__('You cannot reset your password')) // This message is for unauthorized users
                ->danger()
                ->send();
            $this->form->fill();
            return;
        }

        $status = Password::broker(Filament::getAuthPasswordBroker())->sendResetLink(
            $data,
            function (CanResetPassword $user, string $token): void {
                if (! method_exists($user, 'notify')) {
                    $userClass = $user::class;
                    throw new \Exception("Model [{$userClass}] does not have a [notify()] method.");
                }

                $user->notify(new FilamentPasswordResetNotification($token));
            },
        );

        if ($status !== Password::RESET_LINK_SENT) {
            Notification::make()
                ->title(__($status))
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title(__($status))
            ->success()
            ->send();

        $this->form->fill();
    }

    protected function getRateLimitDecaySeconds(): int
    {
        return 10; // Still 10 seconds as you prefer
    }

    protected function throttleKey(): string
    {
        return \Illuminate\Support\Str::lower(request()->input('data.email')).'|'.request()->ip();
    }
}