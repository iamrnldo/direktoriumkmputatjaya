@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . auth()->user()->name)

@section('content')

{{-- Stats Row --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    @php
        $statCards = [
            ['label' => 'Total UMKM', 'value' => $stats['total_umkm'], 'sub' => $stats['umkm_aktif'] . ' aktif', 'color' => 'blue', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>'],
            ['label' => 'Menunggu Verifikasi', 'value' => $stats['pending_verifikasi'], 'sub' => 'perlu ditinjau', 'color' => 'amber', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
            ['label' => 'Total Produk', 'value' => $stats['total_produk'], 'sub' => $stats['produk_aktif'] . ' aktif', 'color' => 'emerald', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>'],
            ['label' => 'Total Pengguna', 'value' => $stats['total_pengguna'], 'sub' => 'terdaftar', 'color' => 'violet', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'],
        ];
        $colorMap = [
            'blue' => ['bg' => 'bg-blue-50', 'icon' => 'bg-blue-600', 'sub' => 'text-blue-600'],
            'amber' => ['bg' => 'bg-amber-50', 'icon' => 'bg-amber-500', 'sub' => 'text-amber-600'],
            'emerald' => ['bg' => 'bg-emerald-50', 'icon' => 'bg-emerald-600', 'sub' => 'text-emerald-600'],
            'violet' => ['bg' => 'bg-violet-50', 'icon' => 'bg-violet-600', 'sub' => 'text-violet-600'],
        ];
    @endphp

    @foreach($statCards as $card)
    @php $c = $colorMap[$card['color']]; @endphp
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">{{ $card['label'] }}</p>
                <p class="text-3xl font-extrabold text-slate-900">{{ number_format($card['value']) }}</p>
                <p class="text-xs font-semibold mt-1 {{ $c['sub'] }}">{{ $card['sub'] }}</p>
            </div>
            <div class="w-11 h-11 rounded-2xl {{ $c['icon'] }} flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $card['icon'] !!}</svg>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Main Content Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Pending Verifications --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900">Antrian Verifikasi UMKM</h3>
                <p class="text-xs text-slate-500 mt-0.5">UMKM yang perlu ditinjau dan diverifikasi</p>
            </div>
            <a href="{{ route('admin.verifikasi-umkm.index') }}"
               class="text-xs font-bold text-blue-600 hover:text-blue-700 px-3 py-1.5 rounded-lg hover:bg-blue-50 transition-colors">
               Lihat Semua →
            </a>
        </div>
        <div class="p-6">
            @if($pendingVerifications->count())
            <div class="space-y-3">
                @foreach($pendingVerifications->take(5) as $umkm)
                <div class="flex items-center justify-between p-4 rounded-xl bg-amber-50 border border-amber-100 hover:bg-amber-100/60 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-white border border-amber-200 flex items-center justify-center text-base flex-shrink-0">
                            {{ $umkm->category?->icon ?? '🏪' }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">{{ $umkm->name }}</p>
                            <p class="text-xs text-slate-500">{{ $umkm->owner_name }} &bull; {{ $umkm->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.verifikasi-umkm.show', $umkm->id) }}"
                       class="px-3 py-1.5 bg-white border border-amber-200 text-amber-700 text-xs font-bold rounded-lg hover:bg-amber-600 hover:text-white hover:border-amber-600 transition-all">
                        Tinjau
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-10">
                <div class="w-14 h-14 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="font-bold text-slate-700">Semua Terproses</p>
                <p class="text-sm text-slate-400 mt-1">Tidak ada UMKM yang perlu diverifikasi</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Recent UMKM --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900">UMKM Terbaru</h3>
                <p class="text-xs text-slate-500 mt-0.5">Baru saja mendaftar</p>
            </div>
            <a href="{{ route('admin.umkm.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 px-3 py-1.5 rounded-lg hover:bg-blue-50 transition-colors">Semua →</a>
        </div>
        <div class="p-4 space-y-2">
            @foreach($recentUmkm as $umkm)
            <div class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-sm flex-shrink-0">{{ $umkm->category?->icon ?? '🏪' }}</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate">{{ $umkm->name }}</p>
                    <p class="text-xs text-slate-400">{{ $umkm->created_at->diffForHumans() }}</p>
                </div>
                @php
                    $statusColor = match($umkm->verification_status) {
                        'aktif' => 'bg-emerald-100 text-emerald-700',
                        'terverifikasi' => 'bg-blue-100 text-blue-700',
                        'diajukan' => 'bg-amber-100 text-amber-700',
                        'ditolak' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-600',
                    };
                @endphp
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $statusColor }}">{{ ucfirst($umkm->verification_status) }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Sebaran per Kategori --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900">Sebaran per Kategori</h3>
                <p class="text-xs text-slate-500 mt-0.5">Distribusi UMKM aktif berdasarkan kategori usaha</p>
            </div>
            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg border border-blue-100">{{ $categoryStats->sum('umkm_profiles_count') }} UMKM</span>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-center mb-5" style="height: 220px;">
                <canvas id="categoryChart"></canvas>
            </div>
            {{-- Legend as cards --}}
            <div class="grid grid-cols-2 gap-2 mt-4">
                @php
                    $catColors = ['#2563eb','#7c3aed','#059669','#d97706','#dc2626','#0891b2','#9333ea','#16a34a','#e11d48','#0d9488'];
                    $totalCat = $categoryStats->sum('umkm_profiles_count') ?: 1;
                @endphp
                @foreach($categoryStats as $i => $cat)
                <div class="flex items-center space-x-2.5 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $catColors[$i % count($catColors)] }}"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-slate-700 truncate">{{ $cat->icon ?? '' }} {{ $cat->name }}</p>
                        <p class="text-[10px] text-slate-400">{{ $cat->umkm_profiles_count }} UMKM · {{ number_format($cat->umkm_profiles_count / $totalCat * 100, 0) }}%</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Tren Pendaftaran --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900">Tren Pendaftaran</h3>
                <p class="text-xs text-slate-500 mt-0.5">Pendaftaran UMKM baru dalam 30 hari terakhir</p>
            </div>
            @php $trendTotal = array_sum($registrationTrend); @endphp
            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">{{ $trendTotal }} pendaftaran</span>
        </div>
        <div class="p-6">
            {{-- Summary mini stats --}}
            <div class="grid grid-cols-3 gap-3 mb-5">
                @php
                    $trendValues = array_values($registrationTrend);
                    $trendMax = count($trendValues) ? max($trendValues) : 0;
                    $trendAvg = count($trendValues) ? round(array_sum($trendValues) / count($trendValues), 1) : 0;
                    $last7 = array_sum(array_slice($trendValues, -7));
                @endphp
                <div class="text-center p-3 bg-blue-50 rounded-xl border border-blue-100">
                    <p class="text-lg font-extrabold text-blue-700">{{ $last7 }}</p>
                    <p class="text-[10px] font-semibold text-blue-500 mt-0.5">7 Hari Terakhir</p>
                </div>
                <div class="text-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-lg font-extrabold text-slate-700">{{ $trendAvg }}</p>
                    <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Rata-rata / Hari</p>
                </div>
                <div class="text-center p-3 bg-amber-50 rounded-xl border border-amber-100">
                    <p class="text-lg font-extrabold text-amber-700">{{ $trendMax }}</p>
                    <p class="text-[10px] font-semibold text-amber-500 mt-0.5">Hari Tertinggi</p>
                </div>
            </div>
            <div style="height: 220px;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// --- Sebaran per Kategori (Doughnut) ---
const catColors = ['#2563eb','#7c3aed','#059669','#d97706','#dc2626','#0891b2','#9333ea','#16a34a','#e11d48','#0d9488'];
const catLabels = @json($categoryStats->pluck('name'));
const catData = @json($categoryStats->pluck('umkm_profiles_count'));
const catTotal = catData.reduce((a, b) => a + b, 0) || 1;

new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: catLabels,
        datasets: [{
            data: catData,
            backgroundColor: catColors.slice(0, catLabels.length),
            borderWidth: 3,
            borderColor: '#ffffff',
            hoverOffset: 12,
            hoverBorderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '68%',
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1e293b',
                titleFont: { family: "'Plus Jakarta Sans'", size: 13, weight: '700' },
                bodyFont: { family: "'Plus Jakarta Sans'", size: 12 },
                padding: 12,
                cornerRadius: 10,
                displayColors: true,
                boxWidth: 10,
                boxHeight: 10,
                boxPadding: 4,
                callbacks: {
                    label: function(ctx) {
                        const pct = ((ctx.raw / catTotal) * 100).toFixed(1);
                        return ' ' + ctx.raw + ' UMKM (' + pct + '%)';
                    }
                }
            }
        }
    },
    plugins: [{
        id: 'centerText',
        beforeDraw(chart) {
            const { ctx, width, height } = chart;
            ctx.save();
            ctx.font = "800 28px 'Plus Jakarta Sans'";
            ctx.fillStyle = '#1e293b';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(catTotal, width / 2, height / 2 - 8);
            ctx.font = "600 11px 'Plus Jakarta Sans'";
            ctx.fillStyle = '#94a3b8';
            ctx.fillText('Total UMKM', width / 2, height / 2 + 14);
            ctx.restore();
        }
    }]
});

// --- Tren Pendaftaran (Area/Line Chart) ---
const trendData = @json($registrationTrend);
const trendLabels = Object.keys(trendData).map(d => {
    const dt = new Date(d);
    return dt.getDate() + '/' + (dt.getMonth() + 1);
});

new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: trendLabels,
        datasets: [{
            label: 'Pendaftaran',
            data: Object.values(trendData),
            borderColor: '#2563eb',
            backgroundColor: function(ctx) {
                const chart = ctx.chart;
                const { ctx: c, chartArea } = chart;
                if (!chartArea) return 'rgba(37,99,235,0.1)';
                const g = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                g.addColorStop(0, 'rgba(37,99,235,0.18)');
                g.addColorStop(1, 'rgba(37,99,235,0.01)');
                return g;
            },
            borderWidth: 2.5,
            pointBackgroundColor: '#2563eb',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 0,
            pointHoverRadius: 6,
            pointHoverBorderWidth: 2,
            tension: 0.35,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1e293b',
                titleFont: { family: "'Plus Jakarta Sans'", size: 12, weight: '700' },
                bodyFont: { family: "'Plus Jakarta Sans'", size: 12 },
                padding: 10,
                cornerRadius: 10,
                callbacks: {
                    title: function(items) {
                        const idx = items[0].dataIndex;
                        const d = new Date(Object.keys(trendData)[idx]);
                        return d.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                    },
                    label: function(ctx) { return ' ' + ctx.raw + ' pendaftaran'; }
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: {
                    font: { family: "'Plus Jakarta Sans'", size: 10, weight: '500' },
                    color: '#94a3b8',
                    maxRotation: 0,
                    maxTicksLimit: 10,
                }
            },
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                border: { display: false },
                ticks: {
                    font: { family: "'Plus Jakarta Sans'", size: 11, weight: '500' },
                    color: '#94a3b8',
                    stepSize: 1,
                    padding: 8,
                }
            }
        }
    }
});
</script>
@endpush
