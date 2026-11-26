<?php

namespace App\Notifications;

use App\Models\UmkmProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UmkmApproved extends Notification
{
    use Queueable;

    public function __construct(public UmkmProfile $umkm, public ?string $notes = null) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎉 Selamat! Usaha Anda Telah Diverifikasi — ' . $this->umkm->name)
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kabar gembira! Pengajuan verifikasi usaha **' . $this->umkm->name . '** telah **disetujui** oleh admin Kelurahan Putat Jaya.')
            ->line('Usaha Anda kini sudah aktif dan dapat ditemukan oleh ribuan pengunjung di Direktori UMKM Putat Jaya.')
            ->when($this->notes, fn($mail) => $mail->line('**Catatan dari admin:** ' . $this->notes))
            ->action('Lihat Profil Usaha Saya', route('umkm.show', $this->umkm->slug))
            ->line('Segera lengkapi foto galeri dan produk Anda agar semakin menarik perhatian pelanggan!')
            ->salutation('Salam sukses, Tim Direktori UMKM Putat Jaya');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'     => 'umkm_approved',
            'title'    => '🎉 Usaha Anda Telah Diverifikasi!',
            'message'  => 'Usaha "' . $this->umkm->name . '" telah disetujui oleh admin dan kini aktif di direktori.',
            'umkm_id'  => $this->umkm->id,
            'url'      => route('umkm.show', $this->umkm->slug),
        ];
    }
}
