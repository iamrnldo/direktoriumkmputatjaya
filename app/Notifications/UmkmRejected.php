<?php

namespace App\Notifications;

use App\Models\UmkmProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UmkmRejected extends Notification
{
    use Queueable;

    public function __construct(public UmkmProfile $umkm, public string $notes) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Informasi Pengajuan Verifikasi — ' . $this->umkm->name)
            ->greeting('Halo, ' . $notifiable->name . '.')
            ->line('Kami telah meninjau pengajuan verifikasi usaha **' . $this->umkm->name . '** Anda.')
            ->line('Sayangnya, pengajuan ini **belum dapat kami setujui** dengan alasan berikut:')
            ->line('> ' . $this->notes)
            ->action('Perbaiki & Ajukan Ulang', route('dashboard.profil-usaha'))
            ->line('Silakan perbaiki data usaha Anda sesuai catatan di atas, lalu ajukan kembali untuk diverifikasi.')
            ->salutation('Terima kasih, Tim Direktori UMKM Putat Jaya');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'umkm_rejected',
            'title'   => 'Pengajuan Verifikasi Perlu Diperbaiki',
            'message' => 'Pengajuan usaha "' . $this->umkm->name . '" belum disetujui. Silakan cek catatan admin.',
            'umkm_id' => $this->umkm->id,
            'url'     => route('dashboard.profil-usaha'),
        ];
    }
}
