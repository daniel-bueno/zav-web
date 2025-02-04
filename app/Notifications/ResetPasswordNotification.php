<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Redefinição de Senha')
            ->greeting('Olá ' . $notifiable->name . '!')
            ->line('Você está recebendo este email porque recebemos uma solicitação de redefinição de senha.')
            ->action('Redefinir Senha', url('password/reset', $this->token))
            ->line('Este link expirará em ' . config('auth.passwords.users.expire') . ' minutos.')
            ->salutation('Atenciosamente,');
    }
}
