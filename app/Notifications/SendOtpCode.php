<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpCode extends Notification implements ShouldQueue
{
    use Queueable;

    protected $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Validation Code')
            ->line('Here is your 6-digit verification code:')
            ->line($this->code)
            ->line('This code will expire in 60 minutes.')
            ->line('If you did not request this code, no further action is required.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
