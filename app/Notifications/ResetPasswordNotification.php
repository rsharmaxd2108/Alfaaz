<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     */
    public string $token;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        $email = method_exists($notifiable, 'getEmailForPasswordReset')
            ? $notifiable->getEmailForPasswordReset()
            : ($notifiable->email ?? '');

        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $email,
        ], false));

        $count = config('auth.passwords.users.expire', 60);
        $name = !empty($notifiable->name) ? $notifiable->name : 'Poet';

        return (new MailMessage)
            ->subject('Reset Your Alfaaz Password')
            ->greeting("Assalam-o-Alaikum, {$name}")
            ->line('You are receiving this email because we received a password reset request for your Alfaaz account.')
            ->action('Reset Password', $resetUrl)
            ->line("This password reset link will expire in {$count} minutes.")
            ->line('If you did not request a password reset, no further action is required; your account remains completely safe.')
            ->salutation("With warmth & poetry,\nThe Alfaaz Team");
    }
}
