<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $data['email'] = mb_strtolower(trim($data['email']));

        $status = Password::reset(
            $data,
            function (User $user) use ($request): void {
                $user->forceFill([
                    'password' => Hash::make($request->input('password')),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password berhasil diperbarui. Silakan masuk menggunakan password baru.');
        }

        $message = match ($status) {
            Password::INVALID_TOKEN => 'Tautan reset tidak valid atau sudah kedaluwarsa. Minta tautan reset yang baru.',
            Password::RESET_THROTTLED => 'Anda baru saja menggunakan tautan reset. Tunggu beberapa saat sebelum meminta tautan baru.',
            default => 'Email tidak ditemukan atau tautan reset tidak cocok dengan email tersebut.',
        };

        return back()->withInput($request->only('email'))->withErrors(['email' => $message]);
    }
}
