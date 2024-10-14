<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CredentialsNotification extends Notification
{
    use Queueable;

    private User $user;
    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
                    ->line("Hola {$this->user->full_name}")
                    ->line("se ha creado una nueva cuenta con las siguientes credenciales.")
                    ->line("Correo: {$this->user->email}")
                    ->line("Contraseña: {$this->user->password}")
                    ->line("Puedes iniciar sesión en el dando click en el botón")
                    ->action('Ingresar a mi cuenta', url(env('FRONTEND_URL')));
    }
}
