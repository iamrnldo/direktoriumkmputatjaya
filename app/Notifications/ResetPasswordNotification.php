<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly string $token) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $email = $notifiable->getEmailForPasswordReset();
        $url = route('password.reset', ['token' => $this->token, 'email' => $email]);
        $expires = (int) config('auth.passwords.users.expire', 60);

        return (new MailMessage)
            ->subject('Permintaan Reset Password — Direktori UMKM Putat Jaya')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Kami menerima permintaan untuk mengatur ulang password akun Direktori UMKM Putat Jaya Anda.')
            ->action('Atur Ulang Password', $url)
            ->line('Tautan ini berlaku selama ' . $expires . ' menit dan hanya dapat digunakan satu kali.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini. Password Anda tidak akan berubah.');
    }
}
