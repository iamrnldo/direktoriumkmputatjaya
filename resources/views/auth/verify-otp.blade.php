<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email — Direktori UMKM Putat Jaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 antialiased">
    <main class="min-h-screen flex items-center justify-center px-5 py-12">
        <section class="w-full max-w-md bg-white border border-slate-200 rounded-2xl shadow-xl shadow-slate-200/60 p-7 sm:p-9">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-blue-700">Direktori UMKM <span class="text-slate-400 font-normal">· Putat Jaya</span></a>
            <div class="mt-8 mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Verifikasi email Anda</h1>
            <p class="mt-2 text-sm leading-6 text-slate-600">Masukkan kode OTP 6 digit yang kami kirim ke email. Kode berlaku selama 10 menit. Setelah verifikasi berhasil, akun Anda dapat digunakan untuk login.</p>
            <div class="mt-6"><span class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Direktori UMKM Putat Jaya</span>@include('auth.partials.auth-stats', ['compact' => true, 'light' => true])</div>

            @if(session('success'))
                <div class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-800" role="status">{{ session('success') }}</div>
            @endif
            @if(session('mail_error'))
                <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-3 text-sm text-amber-800" role="alert">{{ session('mail_error') }}</div>
            @endif
            @if($errors->any())
                <div class="mt-5 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700" role="alert">
                    @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('otp.verify') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email terdaftar</label>
                    <input id="email" name="email" type="email" required autocomplete="email" value="{{ old('email', $email) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100" placeholder="nama@email.com">
                </div>
                <div>
                    <label for="code" class="mb-1.5 block text-sm font-semibold text-slate-700">Kode OTP</label>
                    <input id="code" name="code" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" minlength="6" required autocomplete="one-time-code" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-center font-mono text-2xl tracking-[0.45em] text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100" placeholder="••••••" aria-describedby="otp-help">
                    <p id="otp-help" class="mt-1.5 text-xs text-slate-500">Periksa kotak masuk dan folder spam.</p>
                </div>
                <button type="submit" class="w-full rounded-xl bg-blue-700 px-4 py-3 text-sm font-bold text-white transition hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-200">Verifikasi dan aktifkan akun</button>
            </form>

            <form method="POST" action="{{ route('otp.resend') }}" class="mt-4 text-center">
                @csrf
                <input type="hidden" name="email" value="{{ old('email', $email) }}">
                <button type="submit" class="text-sm font-semibold text-blue-700 hover:text-blue-900">Kirim ulang kode OTP</button>
            </form>
            <div class="mt-7 border-t border-slate-100 pt-5 text-center text-sm text-slate-500">
                Sudah diverifikasi? <a href="{{ route('login') }}" class="font-semibold text-blue-700 hover:underline">Masuk ke akun</a>
            </div>
        </section>
    </main>
</body>
</html>
