<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MailResetPasswordToken extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $FRONT_URL = url(isset($_SERVER['FRONT_URL'])?$_SERVER['FRONT_URL']. 'auth/reset-password?token=' . $this->token:env('FRONT_URL' . 'auth/reset-password', 'http://lahmp.s3-website.eu-west-2.amazonaws.com/#/auth/reset-password') . '?token=' . $this->token);
        return (new MailMessage)
            ->subject("Resetea tu contraseña")
            ->line("¿Te has olvidado tu contraseña? Pulsa el botón para resetearla.")
            ->action('Reseta la contraseña', $FRONT_URL)
            ->line('Gracias');
    }

}