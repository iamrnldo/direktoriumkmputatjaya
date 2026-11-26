@extends('layouts.admin')

@section('title', 'Peta Persebaran UMKM')
@section('page-title', 'Peta Persebaran UMKM')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
<style>
    #admin-umkm-map { height: min(68vh, 720px); min-height: 480px; }
    .leaflet-popup-content-wrapper { border-radius: 12px; }
</style>
@endpush

@section('content')
<div class="space-y-5">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Peta Persebaran UMKM</h2>
            <p class="mt-1 text-sm text-slate-500">Menampilkan UMKM yang memiliki koordinat lokasi, termasuk yang belum aktif dan masih menunggu verifikasi.</p>
        </div>
        <div class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-800">
            <span id="map-result-count">0</span> lokasi
        </div>
    </div>

    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
        <div class="mb-4 flex flex-wrap items-center gap-2" aria-label="Filter kategori peta">
            <button type="button" class="admin-map-filter rounded-full bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white" data-category="all">Semua kategori</button>
            @foreach($categories as $category)
            <button type="button" class="admin-map-filter rounded-full bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-blue-50" data-category="{{ $category->slug }}">
                {{ $category->icon }} {{ $category->name }}
            </button>
            @endforeach
        </div>

        <div class="mb-4 flex flex-wrap items-center gap-x-5 gap-y-2 border-y border-slate-100 py-3" aria-label="Legenda warna kategori">
            <span class="text-xs font-bold text-slate-500">Legenda warna:</span>
            @foreach($categories as $category)
            <span class="inline-flex items-center gap-2 text-xs text-slate-700">
                <span class="h-3 w-3 rounded-full border-2 border-white shadow ring-1 ring-slate-200" style="background-color: {{ match($category->marker_color) {
                    'red' => '#dc2626', 'green' => '#16a34a', 'orange' => '#ea580c',
                    'purple' => '#9333ea', 'teal' => '#0f766e', 'yellow' => '#d97706',
                    'pink' => '#db2777', 'gray' => '#4b5563', 'cyan' => '#0891b2',
                    'darkgreen' => '#15803d', 'blue' => '#2563eb',
                    default => preg_match('/^#[0-9a-fA-F]{6}$/', $category->marker_color ?? '') ? $category->marker_color : '#2563eb',
                } }}"></span>
                {{ $category->icon }} {{ $category->name }}
            </span>
            @endforeach
        </div>

        <div id="admin-umkm-map" class="z-0 overflow-hidden rounded-xl bg-slate-100" role="application" aria-label="Peta lokasi UMKM"></div>
        <p id="map-empty-message" class="hidden mt-4 rounded-xl bg-amber-50 p-4 text-sm text-amber-800">Belum ada data UMKM dengan koordinat lokasi.</p>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const center = [{{ $center['lat'] }}, {{ $center['lng'] }}];
    const map = L.map('admin-umkm-map').setView(center, {{ $center['zoom'] }});
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const geoJson = @json($geoJson);
    const colorMap = {
        blue: '#2563eb', green: '#16a34a', red: '#dc2626', orange: '#ea580c',
        purple: '#9333ea', teal: '#0f766e', yellow: '#d97706', pink: '#db2777',
        gray: '#4b5563', cyan: '#0891b2', darkgreen: '#15803d'
    };
    const resolveColor = value => colorMap[value] || (/^#[0-9a-f]{6}$/i.test(value || '') ? value : '#2563eb');
    const escapeHtml = value => String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
    }[char]));

    const markers = [];
    geoJson.features.forEach(feature => {
        const [lng, lat] = feature.geometry.coordinates;
        const info = feature.properties;
        const color = resolveColor(info.marker_color);
        const marker = L.marker([lat, lng], {
            icon: L.divIcon({
                html: `<div style="background:${color};width:28px;height:28px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,.3)"></div>`,
                className: '', iconSize: [28, 28], iconAnchor: [14, 28], popupAnchor: [0, -30]
            })
        });
        const popup = `
            <div style="min-width:190px;max-width:260px">
                <div style="display:flex;align-items:center;gap:7px;margin-bottom:6px">
                    <span style="width:10px;height:10px;background:${color};border-radius:50%;display:inline-block"></span>
                    <span style="font-size:11px;color:#475569;font-weight:600">${escapeHtml(info.category || 'Tanpa kategori')}</span>
                </div>
                <strong style="font-size:14px">${escapeHtml(info.name)}</strong>
                <p style="font-size:12px;color:#64748b;margin:5px 0">${escapeHtml(info.address)}</p>
                <p style="font-size:11px;color:#64748b;margin:0 0 9px">Status: ${escapeHtml(info.verification_status || '—')}</p>
                <a href="${escapeHtml(info.profile_url)}" style="display:block;text-align:center;padding:7px;background:#2563eb;color:#fff;border-radius:7px;text-decoration:none;font-size:12px;font-weight:600">Lihat data UMKM</a>
            </div>`;
        marker.bindPopup(popup);
        marker.categorySlug = info.category_slug || '';
        markers.push(marker);
    });

    function applyFilter(category) {
        markers.forEach(marker => {
            if (map.hasLayer(marker)) map.removeLayer(marker);
            if (category === 'all' || marker.categorySlug === category) marker.addTo(map);
        });
        document.getElementById('map-result-count').textContent = markers.filter(marker =>
            category === 'all' || marker.categorySlug === category
        ).length;
    }

    document.querySelectorAll('.admin-map-filter').forEach(button => {
        button.addEventListener('click', function () {
            document.querySelectorAll('.admin-map-filter').forEach(item => {
                item.classList.remove('bg-blue-600', 'text-white');
                item.classList.add('bg-slate-100', 'text-slate-700');
            });
            this.classList.add('bg-blue-600', 'text-white');
            this.classList.remove('bg-slate-100', 'text-slate-700');
            applyFilter(this.dataset.category);
        });
    });

    applyFilter('all');
    document.getElementById('map-empty-message').classList.toggle('hidden', markers.length > 0);
    if (markers.length) {
        const bounds = L.featureGroup(markers).getBounds();
        if (bounds.isValid()) map.fitBounds(bounds.pad(0.12), { maxZoom: 16 });
    }
});
</script>
@endpush
