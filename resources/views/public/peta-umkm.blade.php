@extends('layouts.app')

@section('title', 'Peta UMKM')
@section('meta_description', 'Peta interaktif UMKM Kelurahan Putat Jaya. Temukan lokasi usaha terdekat.')
@section('needs_leaflet', true)

@push('head')
<style>
#map { height: calc(100vh - 200px); min-height: 500px; }
.leaflet-popup-content-wrapper { border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); }
.umkm-popup img { border-radius: 8px; }
</style>
@endpush

@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-bold text-gray-900">Peta UMKM Putat Jaya</h1>
        <p class="text-gray-500 mt-1">Temukan lokasi UMKM secara visual menggunakan peta interaktif</p>
    </div>
</div>

{{-- Category filter bar --}}
<div class="bg-white border-b border-gray-100 px-4 py-3">
    <div class="max-w-7xl mx-auto flex items-center space-x-2 overflow-x-auto pb-1">
        <button class="filter-cat-btn flex-shrink-0 px-3 py-1.5 rounded-full text-sm font-medium bg-blue-600 text-white transition-colors" data-cat="all">Semua</button>
        @if(isset($categories))
        @foreach($categories as $cat)
        <button class="filter-cat-btn flex-shrink-0 px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition-colors" data-cat="{{ $cat->slug }}">
            {{ $cat->icon ?? '' }} {{ $cat->name }}
        </button>
        @endforeach
        @endif
    </div>
</div>

{{-- Map container --}}
<div id="map"></div>

@endsection

@push('scripts')
<script>
const mapCenter = [{{ $center['lat'] ?? -7.285 }}, {{ $center['lng'] ?? 112.715 }}];
const mapZoom = {{ $center['zoom'] ?? 15 }};

const map = L.map('map').setView(mapCenter, mapZoom);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

let allMarkers = [];
let markerData = [];

function createColoredIcon(color) {
    return L.divIcon({
        html: `<div style="background:${color || '#2563eb'};width:28px;height:28px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>`,
        className: '',
        iconSize: [28, 28],
        iconAnchor: [14, 28],
        popupAnchor: [0, -30]
    });
}

const colorMap = {
    'blue': '#2563eb', 'green': '#16a34a', 'red': '#dc2626',
    'orange': '#ea580c', 'purple': '#9333ea', 'teal': '#2563eb',
    'yellow': '#d97706', 'pink': '#db2777', 'gray': '#4b5563'
};

async function loadMarkers() {
    try {
        const res = await fetch('/api/map/umkm');
        const data = await res.json();

        data.features.forEach(feature => {
            const { coordinates } = feature.geometry;
            const p = feature.properties;
            const color = colorMap[p.marker_color] || '#2563eb';

            const marker = L.marker([coordinates[1], coordinates[0]], {
                icon: createColoredIcon(color)
            });

            const popupContent = `
                <div class="umkm-popup" style="min-width:200px;max-width:260px;">
                    ${p.cover_image ? `<img src="${p.cover_image}" style="width:100%;height:120px;object-fit:cover;border-radius:8px;margin-bottom:8px;">` : ''}
                    <div style="padding:4px 0;">
                        <div style="font-size:11px;color:#2563eb;font-weight:600;margin-bottom:2px;">${p.category || 'UMKM'}</div>
                        <h4 style="font-weight:700;font-size:14px;margin:0 0 4px;">${p.name}</h4>
                        <p style="font-size:12px;color:#6b7280;margin:0 0 8px;">${p.address}</p>
                        <div style="display:flex;gap:6px;">
                            <a href="${p.profile_url}" style="flex:1;text-align:center;padding:6px;background:#2563eb;color:white;border-radius:8px;text-decoration:none;font-size:12px;font-weight:600;">Lihat Profil</a>
                            <a href="${p.whatsapp_link}" target="_blank" style="flex:1;text-align:center;padding:6px;background:#16a34a;color:white;border-radius:8px;text-decoration:none;font-size:12px;font-weight:600;">WhatsApp</a>
                        </div>
                    </div>
                </div>`;

            marker.bindPopup(popupContent);
            marker._categorySlug = p.category_slug;
            marker._isOpen = p.is_open;
            markerData.push({ marker, props: p });
            allMarkers.push(marker);
            marker.addTo(map);
        });
    } catch(e) {
        console.error('Failed to load markers', e);
    }
}

loadMarkers();

// Category filter
document.querySelectorAll('.filter-cat-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-cat-btn').forEach(b => {
            b.classList.remove('bg-blue-600', 'text-white');
            b.classList.add('bg-gray-100', 'text-gray-700');
        });
        this.classList.add('bg-blue-600', 'text-white');
        this.classList.remove('bg-gray-100', 'text-gray-700');

        const cat = this.dataset.cat;
        allMarkers.forEach(m => map.removeLayer(m));

        markerData.forEach(({ marker, props }) => {
            if (cat === 'all' || props.category_slug === cat) {
                marker.addTo(map);
            }
        });
    });
});
</script>
@endpush
