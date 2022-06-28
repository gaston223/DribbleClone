<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;


class ResetPassword extends Notification
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //$url = url(config('app.client_url').'/password/reset/'.$this->token).'?email='.urlencode($notifiable->email);
        $url = url(config('app.client_url').'/password/reset/'.$this->token).
            '?email='.urlencode($notifiable->email);
        return (new MailMessage)
                    ->line('Veuillez réinitialiser le mot de passe de votre compte')
                    ->action('Notification Action', $url)
                    ->line("Si vous n'êtes pas à l'origine de cette requete, ne rien faire");
    }

}
