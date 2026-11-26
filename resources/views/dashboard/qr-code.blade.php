@extends('layouts.dashboard')
@section('title', 'QR Code Usaha')
@section('page-title', 'QR Code Usaha')

@section('content')
<div class="max-w-2xl space-y-5">

    {{-- Main Card --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Gradient Header --}}
        <div class="relative overflow-hidden p-8 text-white" style="background: linear-gradient(135deg, #1e40af 0%, #4f46e5 60%, #7c3aed 100%);">
            <div class="absolute top-0 right-0 w-64 h-64 rounded-full opacity-20" style="background:radial-gradient(circle,#fff,transparent);transform:translate(30%,-30%);"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full opacity-10" style="background:radial-gradient(circle,#fff,transparent);transform:translate(-30%,30%);"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-3xl border border-white/30">
                        📱
                    </div>
                    <div>
                        <h2 class="text-xl font-black">QR Code Usaha</h2>
                        <p class="text-blue-200 text-sm mt-0.5 font-medium">{{ $umkm->name }}</p>
                    </div>
                </div>
                <div class="hidden sm:block text-right">
                    <p class="text-xs text-blue-300 font-semibold uppercase tracking-wider">Status</p>
                    <span class="inline-flex items-center space-x-1 mt-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-sm font-bold">Aktif</span>
                    </span>
                </div>
            </div>
        </div>

        <div class="p-8">
            {{-- QR Code Display --}}
            <div class="flex flex-col items-center">

                {{-- QR Card --}}
                <div class="relative group mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-indigo-500/20 rounded-3xl blur-xl group-hover:opacity-70 opacity-0 transition-opacity"></div>
                    <div id="qr-wrapper" class="relative bg-white rounded-3xl p-6 shadow-xl border-2 border-slate-100 inline-block">
                        {{-- Corner decorations --}}
                        <div class="absolute top-3 left-3 w-5 h-5 border-t-2 border-l-2 border-blue-500 rounded-tl-lg"></div>
                        <div class="absolute top-3 right-3 w-5 h-5 border-t-2 border-r-2 border-blue-500 rounded-tr-lg"></div>
                        <div class="absolute bottom-3 left-3 w-5 h-5 border-b-2 border-l-2 border-blue-500 rounded-bl-lg"></div>
                        <div class="absolute bottom-3 right-3 w-5 h-5 border-b-2 border-r-2 border-blue-500 rounded-br-lg"></div>

                        {!! $qrCode !!}

                        {{-- Center logo badge --}}
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- URL display --}}
                <div class="w-full bg-slate-50 rounded-2xl p-4 mb-6 flex items-center justify-between space-x-3">
                    <div class="min-w-0">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">URL Profil Anda</p>
                        <p class="text-sm text-blue-600 font-semibold truncate">{{ $profileUrl }}</p>
                    </div>
                    <button onclick="copyUrl()" id="copy-btn"
                        class="flex-shrink-0 flex items-center space-x-1.5 px-4 py-2 bg-white border border-slate-200 hover:border-blue-300 rounded-xl text-sm font-bold text-slate-700 hover:text-blue-600 transition-all">
                        <svg id="copy-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                        <span id="copy-text">Salin</span>
                    </button>
                </div>

                {{-- Action Buttons --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full">
                    <a href="{{ route('dashboard.qr-code.download') }}"
                       class="flex items-center justify-center space-x-2 px-4 py-3 text-white font-bold rounded-2xl text-sm transition-all hover:-translate-y-0.5"
                       style="background:linear-gradient(135deg,#2563eb,#4f46e5);box-shadow:0 4px 14px rgba(37,99,235,0.3)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Download PNG</span>
                    </a>
                    <a href="{{ route('dashboard.qr-code.download-svg') }}"
                       class="flex items-center justify-center space-x-2 px-4 py-3 bg-white border-2 border-slate-200 hover:border-indigo-300 hover:bg-indigo-50 text-slate-700 hover:text-indigo-700 font-bold rounded-2xl text-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Download SVG</span>
                    </a>
                    <button onclick="printQr()"
                        class="flex items-center justify-center space-x-2 px-4 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-2xl text-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Print</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Tips --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <div class="flex items-center space-x-2 mb-4">
            <div class="w-8 h-8 bg-amber-100 rounded-xl flex items-center justify-center text-base">💡</div>
            <h3 class="font-black text-slate-900">Tips Penggunaan QR Code</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach([
                ['🏪', 'Print & Tempel', 'Tempelkan di etalase, meja kasir, atau pintu masuk toko'],
                ['📇', 'Kartu Nama', 'Tambahkan ke kartu nama atau brosur promosi usaha Anda'],
                ['📱', 'Story WA & IG', 'Screenshot dan share ke story WhatsApp atau Instagram'],
                ['🎁', 'Kemasan Produk', 'Cetak di kemasan produk untuk membangun kepercayaan pelanggan'],
            ] as [$icon, $title, $desc])
            <div class="flex items-start space-x-3 p-3 bg-slate-50 rounded-2xl">
                <div class="w-9 h-9 bg-white rounded-xl flex items-center justify-center text-lg shadow-sm flex-shrink-0">{{ $icon }}</div>
                <div>
                    <p class="text-sm font-bold text-slate-800">{{ $title }}</p>
                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Info --}}
    <div class="bg-blue-50 border border-blue-100 rounded-3xl p-5 flex items-start space-x-4">
        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-sm font-black text-blue-900">Tentang QR Code Ini</p>
            <p class="text-xs text-blue-700 mt-1 leading-relaxed">QR code ini mengarah langsung ke halaman profil usaha Anda di direktori. QR code akan terus berfungsi selama profil Anda aktif. Jika URL berubah, unduh QR Code terbaru dari halaman ini.</p>
        </div>
    </div>

</div>

@push('scripts')
<style>
@media print {
    body * { visibility: hidden !important; }
    #print-area, #print-area * { visibility: visible !important; }
    #print-area { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); }
}
</style>

{{-- Hidden print area --}}
<div id="print-area" class="hidden">
    <div style="text-align:center;font-family:'Plus Jakarta Sans',sans-serif;padding:2rem;">
        <div style="font-size:1.5rem;font-weight:900;color:#1e40af;margin-bottom:0.5rem;">{{ $umkm->name }}</div>
        <div id="qr-print-container" style="margin:1rem auto;display:inline-block;">{!! $qrCode !!}</div>
        <div style="font-size:0.75rem;color:#64748b;margin-top:0.5rem;">{{ $profileUrl }}</div>
        <div style="font-size:0.7rem;color:#94a3b8;margin-top:0.25rem;">Direktori UMKM Putat Jaya</div>
    </div>
</div>

<script>
function copyUrl() {
    navigator.clipboard.writeText('{{ $profileUrl }}').then(() => {
        document.getElementById('copy-text').textContent = 'Tersalin!';
        document.getElementById('copy-icon').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
        document.getElementById('copy-btn').classList.add('border-emerald-300', 'bg-emerald-50', 'text-emerald-700');
        setTimeout(() => {
            document.getElementById('copy-text').textContent = 'Salin';
            document.getElementById('copy-icon').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>';
            document.getElementById('copy-btn').classList.remove('border-emerald-300', 'bg-emerald-50', 'text-emerald-700');
        }, 2000);
    });
}

function printQr() {
    document.getElementById('print-area').classList.remove('hidden');
    window.print();
    setTimeout(() => document.getElementById('print-area').classList.add('hidden'), 500);
}
</script>
@endpush
@endsection
