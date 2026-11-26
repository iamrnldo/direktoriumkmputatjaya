<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['email' => ['required', 'email', 'max:255']]);
        $email = mb_strtolower(trim($data['email']));

        try {
            $status = Password::sendResetLink(['email' => $email]);
        } catch (\Throwable $exception) {
            report($exception);
            return back()->withInput(['email' => $email])
                ->withErrors(['email' => 'Email reset belum dapat dikirim. Coba lagi beberapa saat.']);
        }

        if ($status === Password::RESET_THROTTLED) {
            return back()->withInput(['email' => $email])
                ->withErrors(['email' => 'Permintaan reset terlalu sering. Tunggu satu menit sebelum mencoba lagi.']);
        }

        // Same response for registered and unregistered emails to prevent account enumeration.
        return back()->with('status', 'Jika email terdaftar, tautan reset password akan dikirim. Periksa inbox dan folder spam.');
    }
}
