<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailOtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class EmailOtpController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.verify-otp', ['email' => $request->query('email', old('email', ''))]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'code' => ['required', 'digits:6'],
        ]);

        $user = User::whereRaw('LOWER(email) = ?', [mb_strtolower($data['email'])])->first();
        if (! $user || ! $user->hasRole('umkm_owner')) {
            return back()->withErrors(['email' => 'Email atau kode verifikasi tidak valid.'])->withInput($request->only('email'));
        }

        if ($user->account_status === 'approved' && $user->email_verified_at) {
            return redirect()->route('login')->with('success', 'Email akun Anda sudah terverifikasi. Silakan login.');
        }

        if (! $user->email_otp_hash || ! $user->email_otp_expires_at || $user->email_otp_expires_at->isPast()) {
            return back()->withErrors(['code' => 'Kode sudah kedaluwarsa. Minta kode baru lalu coba lagi.'])->withInput($request->only('email'));
        }

        if (! Hash::check($data['code'], $user->email_otp_hash)) {
            return back()->withErrors(['code' => 'Kode verifikasi tidak sesuai. Periksa email Anda dan coba lagi.'])->withInput($request->only('email'));
        }

        $user->forceFill([
            'account_status' => 'approved',
            'is_active' => true,
            'email_verified_at' => now(),
            'email_otp_hash' => null,
            'email_otp_expires_at' => null,
        ])->save();

        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi. Akun Anda aktif—silakan login.');
    }

    public function resend(Request $request, EmailOtpService $otpService): RedirectResponse
    {
        $data = $request->validate(['email' => ['required', 'email', 'max:255']]);
        $user = User::whereRaw('LOWER(email) = ?', [mb_strtolower($data['email'])])
            ->whereHas('roles', fn ($query) => $query->where('name', 'umkm_owner'))
            ->first();

        if (! $user || $user->account_status === 'approved') {
            return redirect()->route('login')->with('success', 'Jika akun memerlukan verifikasi, kode baru akan dikirim ke email terdaftar.');
        }

        try {
            $otpService->send($user);
            return redirect()->route('otp.notice', ['email' => $user->email])
                ->with('success', 'Kode verifikasi baru telah dikirim. Periksa kotak masuk atau folder spam.');
        } catch (\Throwable $exception) {
            report($exception);
            return redirect()->route('otp.notice', ['email' => $user->email])
                ->with('mail_error', 'Kode belum dapat dikirim. Periksa konfigurasi SMTP Gmail lalu coba lagi.');
        }
    }
}
