<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->line('Your verification code is: ' . $this->token)
            ->line('If you did not request a password reset, no further action is required.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
  // Add the 'via' method
    public function via($notifiable)
    {
        return ['mail']; // This indicates that the notification should be sent via the 'mail' channel.
    }
}
