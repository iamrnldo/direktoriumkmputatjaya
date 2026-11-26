<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
@include('auth.partials.auth-head', ['title' => 'Lupa Password'])
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
                <h2 class="text-[1.875rem] font-bold text-slate-900 leading-tight">Lupa Password?</h2>
                <p class="text-slate-500 mt-2 text-sm leading-6">Masukkan email akun Anda. Kami akan mengirim tautan untuk membuat password baru.</p>
            </div>

            @if(session('status'))
            <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start space-x-3" role="status">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-emerald-700 font-medium">{{ session('status') }}</p>
            </div>
            @endif
            @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl" role="alert">
                @foreach($errors->all() as $error)<p class="text-sm text-red-700">{{ $error }}</p>@endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                        class="input-field @error('email') error @enderror" placeholder="nama@email.com">
                </div>
                <button type="submit" class="btn-primary">Kirim tautan reset password</button>
            </form>
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-slate-600 transition-colors inline-flex items-center space-x-1.5">
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
