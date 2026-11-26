<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Direktori UMKM Putat Jaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.14); }
        .input-field {
            width: 100%; padding: 0.8125rem 1rem; border-radius: 0.75rem;
            border: 1.5px solid #e2e8f0; background: #fff;
            color: #0f172a; font-size: 0.9375rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-field:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }
        .input-field.error { border-color: #ef4444; background: #fef2f2; }
        .btn-primary {
            width: 100%; padding: 0.875rem; border-radius: 0.75rem; font-weight: 700;
            font-size: 0.9375rem; color: white; cursor: pointer; transition: all 0.2s; border: none;
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            box-shadow: 0 2px 12px rgba(37,99,235,0.3);
        }
        .btn-primary:hover { box-shadow: 0 6px 20px rgba(37,99,235,0.4); transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .orb { position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none; }
    </style>
</head>
<body class="antialiased">

<div class="min-h-screen flex">

    {{-- ====== LEFT PANEL ====== --}}
    <div class="hidden lg:flex lg:w-[52%] relative overflow-hidden flex-col" style="background: linear-gradient(145deg, #0f172a 0%, #1e1b4b 45%, #1e3a8a 100%);">
        <div class="orb" style="width:480px;height:480px;background:rgba(99,102,241,0.25);top:-120px;left:-120px;"></div>
        <div class="orb" style="width:380px;height:380px;background:rgba(37,99,235,0.2);bottom:-40px;right:-80px;"></div>
        <div class="orb" style="width:260px;height:260px;background:rgba(139,92,246,0.15);top:45%;left:35%;"></div>

        {{-- Subtle radial pattern --}}
        <div class="absolute inset-0 opacity-[0.06]" style="background: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.15) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 0%, transparent 50%);"></div>

        <div class="relative z-10 flex flex-col h-full px-12 py-10">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 glass rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <span class="font-bold text-white text-[15px] block leading-tight">Direktori UMKM</span>
                    <span class="text-blue-300 text-xs font-medium">Putat Jaya · Surabaya</span>
                </div>
            </a>

            {{-- Main Content --}}
            <div class="flex-1 flex flex-col justify-center max-w-sm">
                <div class="inline-flex items-center space-x-2 glass rounded-full px-4 py-1.5 mb-8 w-fit">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></div>
                    <span class="text-xs font-medium text-slate-300">Portal Resmi Kelurahan Putat Jaya</span>
                </div>

                <h1 class="text-5xl font-extrabold text-white leading-[1.1] mb-5">
                    Selamat<br>Datang<br>
                    <span style="background: linear-gradient(135deg, #60a5fa, #a78bfa); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">Kembali</span>
                </h1>
                <p class="text-slate-400 text-base leading-relaxed mb-10">
                    Platform digital resmi untuk mendata dan mempromosikan UMKM lokal Putat Jaya kepada masyarakat luas.
                </p>

                {{-- Live database statistics --}}
                @include('auth.partials.auth-stats')

            </div>

            <p class="text-slate-700 text-xs">© {{ date('Y') }} Direktori UMKM Putat Jaya</p>
        </div>
    </div>

    {{-- ====== RIGHT PANEL (Form) ====== --}}
    <div class="flex-1 flex items-center justify-center px-6 py-12 bg-slate-50">
        <div class="w-full max-w-[400px]">

            {{-- Mobile logo --}}
            <div class="lg:hidden flex flex-col items-center mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 mb-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <span class="font-bold text-slate-900 text-lg">Direktori UMKM</span>
                <span class="text-blue-600 text-sm font-medium">Putat Jaya · Surabaya</span>
            </div>

            {{-- Heading --}}
            <div class="mb-8">
                <h2 class="text-[1.875rem] font-bold text-slate-900 leading-tight">Masuk ke Akun</h2>
                <p class="text-slate-500 mt-2 text-sm">Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-700 transition-colors">Daftar gratis</a>
                </p>
            </div>

            {{-- Session status --}}
            <x-auth-session-status class="mb-5" :status="session('status')" />

            @if(session('account_pending'))
            <div class="mb-5 p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-start space-x-3" role="status">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-amber-800 font-medium">{{ session('account_pending') }}</p>
            </div>
            @endif

            @if(session('success'))
            <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start space-x-3">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
            </div>
            @endif

            {{-- Login Error Alert --}}
            @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl" role="alert">
                <div class="flex items-start space-x-3">
                    <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-red-800">Login Gagal</p>
                        @foreach($errors->all() as $error)
                        <p class="text-sm text-red-600 mt-1">{{ $error }}</p>
                        @endforeach
                        @if(str_contains($errors->first('email'), 'belum terverifikasi'))
                        <a href="{{ route('otp.notice', ['email' => old('email')]) }}" class="inline-block mt-2 text-sm font-semibold text-blue-700 hover:underline">Masukkan kode OTP / verifikasi email</a>
                        @endif
                        <p class="text-xs text-red-400 mt-2">Pastikan email dan password yang Anda masukkan sudah benar. Jika lupa password, klik "Lupa password?" di bawah.</p>
                    </div>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-4.5 h-4.5" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                            class="input-field @error('email') error @enderror"
                            style="padding-left: 2.75rem;"
                            placeholder="nama@email.com">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="input-field @error('password') error @enderror"
                            style="padding-left: 2.75rem; padding-right: 3rem;"
                            placeholder="••••••••">
                        <button type="button" onclick="const f=document.getElementById('password'); f.type=f.type==='password'?'text':'password'"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-slate-600">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">Lupa password?</a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary">
                    Masuk
                </button>
            </form>

            {{-- Divider --}}
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center"><span class="px-4 bg-slate-50 text-xs text-slate-400">atau</span></div>
            </div>

            {{-- Register CTA --}}
            <a href="{{ route('register') }}"
               class="flex items-center justify-center w-full py-3 px-6 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-slate-700 font-semibold text-sm transition-all">
                Daftarkan Usaha Anda — Gratis
            </a>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-slate-600 transition-colors inline-flex items-center space-x-1.5">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>

</div>
</body>
</html>
