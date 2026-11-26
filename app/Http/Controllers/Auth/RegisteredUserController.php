<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailOtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request, EmailOtpService $otpService): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'              => $request->name,
            'phone'             => $request->phone,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'email_verified_at' => null,
            'is_active'          => false,
            'account_status'     => 'pending',
        ]);

        $user->assignRole('umkm_owner');

        try {
            $otpService->send($user);
            return redirect()->route('otp.notice', ['email' => $user->email])
                ->with('success', 'Pendaftaran berhasil. Kami mengirim kode OTP ke email Anda.');
        } catch (\Throwable $exception) {
            report($exception);

            // Account remains pending; user can use the resend action after SMTP is configured.
            return redirect()->route('otp.notice', ['email' => $user->email])
                ->with('mail_error', 'Akun berhasil dibuat, tetapi email OTP belum terkirim. Periksa pengaturan email atau coba kirim ulang.');
        }
    }
}
