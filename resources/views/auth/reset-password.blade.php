<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
@include('auth.partials.auth-head', ['title' => 'Reset Password'])
<body class="antialiased">
<div class="min-h-screen flex">
    @include('auth.partials.brand-left-panel')
    <div class="flex-1 flex items-center justify-center px-6 py-12 bg-slate-50">
        <div class="w-full max-w-[400px]">
            @include('auth.partials.mobile-logo')
            <div class="mb-8">
                <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 text-sm font-medium text-blue-600 hover:text-blue-700 mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke login</span>
                </a>
                <h2 class="text-[1.875rem] font-bold text-slate-900 leading-tight">Buat Password Baru</h2>
                <p class="text-slate-500 mt-2 text-sm">Buat password baru untuk akun Direktori UMKM Anda.</p>
            </div>

            @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl" role="alert">
                @foreach($errors->all() as $error)<p class="text-sm text-red-700">{{ $error }}</p>@endforeach
                @if($errors->has('email') && str_contains($errors->first('email'), 'Tautan reset'))
                    <a href="{{ route('password.request') }}" class="inline-block mt-2 text-sm font-semibold text-blue-700 hover:underline">Minta tautan reset baru</a>
                @endif
            </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->query('email')) }}" required autofocus autocomplete="username"
                        class="input-field @error('email') error @enderror" placeholder="nama@email.com">
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password Baru</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="input-field @error('password') error @enderror" placeholder="Masukkan password baru">
                    @error('password')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="input-field" placeholder="Ulangi password baru">
                </div>
                <button type="submit" class="btn-primary">Simpan Password Baru</button>
            </form>
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-slate-600 transition-colors">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
