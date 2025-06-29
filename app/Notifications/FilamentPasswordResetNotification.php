<?php

namespace App\Notifications; // Or wherever your custom notification resides

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Filament\Facades\Filament; // Make sure this is imported

class FilamentPasswordResetNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly string $token)
    {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
            ->greeting(Lang::get('Hello') . " {$notifiable->name},")
            ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
            ->action(Lang::get('Reset Password'), $this->resetUrl($notifiable))
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }

    protected function resetUrl(mixed $notifiable): string
    {
        // This is the key! Filament provides a dedicated method for this.
        return Filament::getResetPasswordUrl($this->token, $notifiable);
    }
}