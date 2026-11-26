<div class="hidden lg:flex lg:w-[52%] relative overflow-hidden flex-col" style="background: linear-gradient(145deg, #0f172a 0%, #1e1b4b 45%, #1e3a8a 100%);">
    <div class="orb" style="width:480px;height:480px;background:rgba(99,102,241,0.25);top:-120px;left:-120px;"></div>
    <div class="orb" style="width:380px;height:380px;background:rgba(37,99,235,0.2);bottom:-40px;right:-80px;"></div>
    <div class="orb" style="width:260px;height:260px;background:rgba(139,92,246,0.15);top:45%;left:35%;"></div>
    <div class="absolute inset-0 opacity-[0.06]" style="background: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.15) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 0%, transparent 50%);"></div>
    <div class="relative z-10 flex flex-col h-full px-12 py-10">
        <a href="{{ route('home') }}" class="flex items-center space-x-3">
            <div class="w-10 h-10 glass rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div><span class="font-bold text-white text-[15px] block leading-tight">Direktori UMKM</span><span class="text-blue-300 text-xs font-medium">Putat Jaya · Surabaya</span></div>
        </a>
        <div class="flex-1 flex flex-col justify-center max-w-sm">
            <div class="inline-flex items-center space-x-2 glass rounded-full px-4 py-1.5 mb-8 w-fit"><div class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></div><span class="text-xs font-medium text-slate-300">Portal Resmi Kelurahan Putat Jaya</span></div>
            <h1 class="text-5xl font-extrabold text-white leading-[1.1] mb-5">Selamat<br>Datang<br><span style="background:linear-gradient(135deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Kembali</span></h1>
            <p class="text-slate-400 text-base leading-relaxed mb-10">Platform digital resmi untuk mendata dan mempromosikan UMKM lokal Putat Jaya kepada masyarakat luas.</p>
            @include('auth.partials.auth-stats')
        </div>
        <p class="text-slate-700 text-xs">© {{ date('Y') }} Direktori UMKM Putat Jaya</p>
    </div>
</div>
