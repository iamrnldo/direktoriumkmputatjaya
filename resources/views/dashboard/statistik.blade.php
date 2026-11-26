@extends('layouts.dashboard')
@section('title', 'Statistik Usaha')
@section('page-title', 'Statistik Usaha')
@section('needs_chartjs', true)

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-5 text-white shadow-md shadow-blue-200">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <span class="text-xs text-blue-100 font-medium bg-white/10 px-2 py-0.5 rounded-full">Total</span>
        </div>
        <p class="text-3xl font-extrabold">{{ number_format($stats['profile_views']) }}</p>
        <p class="text-sm text-blue-100 mt-1 font-medium">Total Dilihat</p>
    </div>

    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-5 text-white shadow-md shadow-emerald-200">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <span class="text-xs text-emerald-100 font-medium bg-white/10 px-2 py-0.5 rounded-full">Klik</span>
        </div>
        <p class="text-3xl font-extrabold">{{ number_format($stats['whatsapp_clicks']) }}</p>
        <p class="text-sm text-emerald-100 mt-1 font-medium">WhatsApp Klik</p>
    </div>

    <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-2xl p-5 text-white shadow-md shadow-violet-200">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <span class="text-xs text-violet-100 font-medium bg-white/10 px-2 py-0.5 rounded-full">Produk</span>
        </div>
        <p class="text-3xl font-extrabold">{{ number_format($stats['product_views']) }}</p>
        <p class="text-sm text-violet-100 mt-1 font-medium">Produk Dilihat</p>
    </div>

    <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl p-5 text-white shadow-md shadow-amber-200">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <span class="text-xs text-amber-100 font-medium bg-white/10 px-2 py-0.5 rounded-full">30 Hari</span>
        </div>
        <p class="text-3xl font-extrabold">{{ number_format($stats['views_last_30_days']) }}</p>
        <p class="text-sm text-amber-100 mt-1 font-medium">Kunjungan 30 Hari</p>
    </div>
</div>

{{-- Trend Chart --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="font-bold text-gray-900">Tren Kunjungan</h3>
            <p class="text-sm text-gray-500 mt-0.5">30 hari terakhir</p>
        </div>
        <div class="flex items-center space-x-2 bg-blue-50 px-3 py-1.5 rounded-xl">
            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            <span class="text-xs font-semibold text-blue-700">Kunjungan Profil</span>
        </div>
    </div>
    <div style="position: relative; height: 220px;">
        <canvas id="viewsChart"></canvas>
    </div>
</div>

{{-- Top Products --}}
@if($topProducts->count())
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="font-bold text-gray-900">Produk Terpopuler</h3>
            <p class="text-sm text-gray-500 mt-0.5">Berdasarkan jumlah tampilan</p>
        </div>
        <div class="w-8 h-8 bg-amber-50 rounded-xl flex items-center justify-center text-lg">🏆</div>
    </div>
    <div class="space-y-3">
        @foreach($topProducts as $index => $product)
        <div class="flex items-center space-x-3 p-3 rounded-xl {{ $index === 0 ? 'bg-amber-50 border border-amber-100' : 'hover:bg-gray-50' }} transition-colors">
            <div class="w-8 h-8 flex items-center justify-center rounded-xl text-sm font-bold {{ $index === 0 ? 'bg-amber-400 text-amber-900' : ($index === 1 ? 'bg-slate-200 text-slate-600' : ($index === 2 ? 'bg-orange-200 text-orange-700' : 'bg-gray-100 text-gray-500')) }} flex-shrink-0">
                {{ $index + 1 }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ number_format($product->view_count) }} tampilan</p>
            </div>
            <div class="text-right flex-shrink-0">
                <div class="h-1.5 bg-gray-100 rounded-full w-20 overflow-hidden">
                    <div class="h-full rounded-full {{ $index === 0 ? 'bg-amber-400' : 'bg-blue-400' }}"
                         style="width: {{ $topProducts->max('view_count') > 0 ? min(100, round($product->view_count / $topProducts->max('view_count') * 100)) : 0 }}%">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">
    <div class="text-4xl mb-3">📦</div>
    <p class="text-gray-500 text-sm">Belum ada produk yang dilihat.</p>
</div>
@endif

@endsection

@push('scripts')
<script>
const datesData = @json($dates);
const labels = Object.keys(datesData);
const values = Object.values(datesData);

new Chart(document.getElementById('viewsChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Kunjungan',
            data: values,
            borderColor: '#3b82f6',
            backgroundColor: function(context) {
                const chart = context.chart;
                const {ctx, chartArea} = chart;
                if (!chartArea) return 'rgba(59,130,246,0.1)';
                const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                gradient.addColorStop(0, 'rgba(59,130,246,0.25)');
                gradient.addColorStop(1, 'rgba(59,130,246,0.01)');
                return gradient;
            },
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointRadius: 3,
            pointBackgroundColor: '#3b82f6',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointHoverRadius: 5,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1e293b',
                titleFont: { size: 12 },
                bodyFont: { size: 13, weight: 'bold' },
                padding: 10,
                cornerRadius: 8,
                callbacks: {
                    label: function(ctx) {
                        return ' ' + ctx.parsed.y + ' kunjungan';
                    }
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 },
                    color: '#94a3b8',
                    maxTicksLimit: 8,
                    callback: function(value, index) {
                        const label = labels[index];
                        const d = new Date(label);
                        return d.getDate() + '/' + (d.getMonth() + 1);
                    }
                },
                border: { display: false }
            },
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(148,163,184,0.15)', drawBorder: false },
                ticks: { font: { size: 11 }, color: '#94a3b8', precision: 0 },
                border: { display: false }
            }
        }
    }
});
</script>
@endpush
