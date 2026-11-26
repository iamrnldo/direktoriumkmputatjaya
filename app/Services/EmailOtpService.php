<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmailOtpService
{
    public function send(User $user): void
    {
        $code = (string) random_int(100000, 999999);

        $user->forceFill([
            'email_otp_hash' => Hash::make($code),
            'email_otp_expires_at' => now()->addMinutes(10),
            'account_status' => 'pending',
            'is_active' => false,
        ])->save();

        Mail::raw(
            "Kode verifikasi Direktori UMKM Putat Jaya Anda adalah: {$code}\n\nKode berlaku selama 10 menit. Jangan bagikan kode ini kepada siapa pun. Jika Anda tidak merasa mendaftar, abaikan email ini.",
            function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Kode Verifikasi Akun UMKM Putat Jaya');
            }
        );
    }
}
