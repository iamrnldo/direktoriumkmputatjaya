<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Direktori UMKM Putat Jaya</title>
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
        .step-num {
            display: inline-flex; align-items: center; justify-content: center;
            width: 1.75rem; height: 1.75rem; border-radius: 50%;
            background: rgba(255,255,255,0.12); color: white;
            font-size: 0.75rem; font-weight: 700; flex-shrink: 0;
        }
    </style>
</head>
<body class="antialiased">

<div class="min-h-screen flex">

    {{-- ====== LEFT PANEL ====== --}}
    <div class="hidden xl:flex xl:w-[46%] relative overflow-hidden flex-col" style="background: linear-gradient(145deg, #0f172a 0%, #1e3a5f 50%, #1e40af 100%);">
        <div class="orb" style="width:460px;height:460px;background:rgba(37,99,235,0.25);top:-120px;right:-100px;"></div>
        <div class="orb" style="width:380px;height:380px;background:rgba(99,102,241,0.2);bottom:-40px;left:-80px;"></div>

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

            <div class="flex-1 flex flex-col justify-center max-w-sm">
                <div class="inline-flex items-center space-x-2 glass rounded-full px-4 py-1.5 mb-8 w-fit">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></div>
                    <span class="text-xs font-medium text-slate-300">Pendaftaran Gratis</span>
                </div>

                <h1 class="text-5xl font-extrabold text-white leading-[1.1] mb-5">
                    Bergabung &<br>Kembangkan<br>
                    <span style="background:linear-gradient(135deg,#60a5fa,#34d399);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Usaha Anda</span>
                </h1>
                <p class="text-slate-400 text-base leading-relaxed mb-10">
                    Daftarkan usaha dan verifikasi alamat email dengan kode OTP. Setelah email terverifikasi, akun Anda bisa digunakan.
                </p>

                {{-- Live database statistics --}}
                @include('auth.partials.auth-stats', ['compact' => true])

                {{-- Step guide --}}
                <div class="space-y-4">
                    @foreach([
                        ['1', 'Buat Akun', 'Isi nama, email, dan password'],
                        ['2', 'Verifikasi Email', 'Masukkan kode OTP yang dikirim ke email Anda'],
                        ['3', 'Lengkapi Profil Usaha', 'Tambahkan foto, produk & lokasi'],
                        ['4', 'Ajukan Verifikasi Usaha', 'Admin meninjau profil sebelum tampil di direktori'],
                    ] as [$step, $title, $desc])
                    <div class="flex items-start space-x-3.5">
                        <div class="step-num mt-0.5">{{ $step }}</div>
                        <div>
                            <p class="font-semibold text-white text-sm">{{ $title }}</p>
                            <p class="text-slate-400 text-xs mt-0.5">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Trust badges (SVG icons, no emoji) --}}
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span class="text-slate-500 text-xs">Data Aman</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-slate-500 text-xs">Terverifikasi Resmi</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-slate-500 text-xs">Gratis</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ====== RIGHT PANEL (Form) ====== --}}
    <div class="flex-1 flex items-start justify-center px-6 py-10 bg-slate-50 overflow-y-auto">
        <div class="w-full max-w-[440px] py-4">

            {{-- Mobile logo --}}
            <div class="xl:hidden flex flex-col items-center mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 mb-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                </div>
                <span class="font-bold text-slate-900 text-lg">Direktori UMKM</span>
                <span class="text-blue-600 text-sm font-medium">Putat Jaya · Surabaya</span>
            </div>

            <div class="mb-7">
                <h2 class="text-[1.875rem] font-bold text-slate-900 leading-tight">Buat Akun Baru</h2>
                <p class="text-slate-500 mt-2 text-sm">Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-700 transition-colors">Masuk di sini</a>
                </p>
            </div>

            {{-- Info box --}}
            <div class="mb-6 p-4 rounded-xl border border-blue-100 bg-blue-50 flex items-start space-x-3">
                <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Langsung aktif setelah mendaftar</p>
                    <p class="text-xs text-blue-700 mt-0.5">Tidak perlu verifikasi email. Anda bisa langsung masuk dan melengkapi profil usaha.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="input-field @error('name') error @enderror"
                            style="padding-left: 2.75rem;"
                            placeholder="Nama lengkap pemilik usaha">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Nomor WhatsApp <span class="text-slate-400 font-normal text-xs">(opsional)</span>
                    </label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                            class="input-field @error('phone') error @enderror"
                            style="padding-left: 2.75rem;"
                            placeholder="08xxxxxxxxxx">
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="input-field @error('email') error @enderror"
                            style="padding-left: 2.75rem;"
                            placeholder="Untuk login dan notifikasi verifikasi">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                {{-- Password row --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="input-field @error('password') error @enderror"
                                style="padding-left: 2.75rem;"
                                placeholder="Min. 8 karakter">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Konfirmasi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="input-field"
                                style="padding-left: 2.75rem;"
                                placeholder="Ulangi password">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
                    </div>
                </div>

                {{-- Password strength indicator --}}
                <div id="strength-bar" class="hidden">
                    <div class="flex space-x-1 mb-1">
                        <div id="s1" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors"></div>
                        <div id="s2" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors"></div>
                        <div id="s3" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors"></div>
                        <div id="s4" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors"></div>
                    </div>
                    <p id="strength-text" class="text-xs text-slate-400"></p>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary mt-2">
                    Buat Akun
                </button>

                <p class="text-xs text-center text-slate-400">
                    Dengan mendaftar, Anda menyetujui
                    <a href="{{ route('syarat-ketentuan') }}" class="text-blue-600 hover:underline">Syarat &amp; Ketentuan</a>
                    dan <a href="{{ route('kebijakan-privasi') }}" class="text-blue-600 hover:underline">Kebijakan Privasi</a>
                </p>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-slate-600 transition-colors inline-flex items-center space-x-1.5">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>

</div>

<script>
// Password strength indicator
const pwInput = document.getElementById('password');
const bar = document.getElementById('strength-bar');
const segments = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
const strengthText = document.getElementById('strength-text');

pwInput.addEventListener('input', () => {
    const val = pwInput.value;
    if (!val) { bar.classList.add('hidden'); return; }
    bar.classList.remove('hidden');

    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const colors = ['bg-red-400','bg-orange-400','bg-yellow-400','bg-emerald-400'];
    const labels = ['Sangat lemah','Lemah','Cukup kuat','Kuat'];
    segments.forEach((s, i) => {
        s.className = 'h-1 flex-1 rounded-full transition-colors ' + (i < score ? colors[score-1] : 'bg-slate-200');
    });
    strengthText.textContent = labels[score-1] || '';
    strengthText.className = 'text-xs ' + (['text-red-500','text-orange-500','text-yellow-600','text-emerald-600'][score-1] || 'text-slate-400');
});
</script>

</body>
</html>
