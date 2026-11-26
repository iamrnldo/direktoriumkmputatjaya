@extends('layouts.dashboard')
@section('title', 'Lokasi Usaha')
@section('page-title', 'Lokasi Usaha')
@section('needs_leaflet', true)

@push('head')
<style>#location-map { height: 450px; border-radius: 12px; }</style>
@endpush

@section('content')
<div class="max-w-2xl" x-data="locationPicker()">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-5">

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row gap-3 mb-4">
            <button @click="useMyLocation()" :disabled="geoLoading" type="button"
                class="flex-1 flex items-center justify-center px-4 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-60 disabled:cursor-wait">
                <template x-if="geoLoading">
                    <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                </template>
                <template x-if="!geoLoading">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </template>
                <span x-text="geoLoading ? 'Mencari lokasi...' : '📍 Gunakan Lokasi Saya'"></span>
            </button>
        </div>

        {{-- Address Search --}}
        <div class="relative mb-4">
            <div class="flex gap-2">
                <div class="flex-1 relative">
                    <input type="text" x-model="searchQuery" @keydown.enter.prevent="searchAddress()" placeholder="Cari alamat, nama jalan, atau tempat..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button @click="searchAddress()" type="button" :disabled="searching" class="px-4 py-2.5 bg-slate-700 text-white text-sm font-semibold rounded-xl hover:bg-slate-800 transition-colors disabled:opacity-60">
                    <span x-show="!searching">Cari</span>
                    <svg x-show="searching" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24" style="display:none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                </button>
            </div>

            {{-- Search Results Dropdown --}}
            <div x-show="searchResults.length > 0" @click.outside="searchResults = []" class="absolute z-20 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden" style="display:none;">
                <template x-for="(result, idx) in searchResults" :key="idx">
                    <button @click="selectSearchResult(result)" type="button" class="w-full text-left px-4 py-3 hover:bg-blue-50 border-b border-gray-50 last:border-0 transition-colors">
                        <p class="text-sm font-medium text-gray-800" x-text="result.display_name.split(',').slice(0,3).join(',')"></p>
                        <p class="text-xs text-gray-400 mt-0.5" x-text="result.display_name"></p>
                    </button>
                </template>
            </div>
        </div>

        {{-- Geo Error Message --}}
        <div x-show="geoError" x-transition class="mb-4 flex items-center bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm" style="display:none;">
            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/></svg>
            <span x-text="geoError"></span>
            <button @click="geoError = ''" class="ml-auto text-red-400 hover:text-red-600">&times;</button>
        </div>

        {{-- Instruction --}}
        <p class="text-xs text-gray-400 mb-3">💡 Klik pada peta atau geser marker untuk menentukan lokasi usaha Anda.</p>

        {{-- Map --}}
        <div id="location-map" class="mb-4 border border-gray-100"></div>

        {{-- Address Display --}}
        <div x-show="addressText" x-transition class="mb-4 flex items-start bg-blue-50 border border-blue-100 text-blue-800 px-4 py-3 rounded-xl text-sm" style="display:none;">
            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span x-text="addressText"></span>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('dashboard.lokasi.update') }}" id="location-form">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                    <input type="number" name="latitude" id="lat-input" step="any" x-model="lat" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="-7.280..." readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                    <input type="number" name="longitude" id="lng-input" step="any" x-model="lng" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="112.70..." readonly>
                </div>
            </div>
            <button type="submit" class="w-full py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">Simpan Lokasi</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function locationPicker() {
    const defaultLat = {{ $umkm->latitude ?? $center['lat'] }};
    const defaultLng = {{ $umkm->longitude ?? $center['lng'] }};
    const hasLocation = {{ $umkm->latitude ? 'true' : 'false' }};

    return {
        lat: hasLocation ? defaultLat : '',
        lng: hasLocation ? defaultLng : '',
        geoLoading: false,
        geoError: '',
        searchQuery: '',
        searchResults: [],
        searching: false,
        addressText: '',
        map: null,
        marker: null,

        init() {
            this.map = L.map('location-map').setView([defaultLat, defaultLng], hasLocation ? 17 : 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap', maxZoom: 19 }).addTo(this.map);

            if (hasLocation) {
                this.marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(this.map);
                this.marker.on('dragend', e => {
                    const ll = e.target.getLatLng();
                    this.setPosition(ll.lat, ll.lng);
                });
                this.reverseGeocode(defaultLat, defaultLng);
            }

            this.map.on('click', e => {
                this.setPosition(e.latlng.lat, e.latlng.lng);
            });
        },

        setPosition(lat, lng) {
            this.lat = parseFloat(lat).toFixed(8);
            this.lng = parseFloat(lng).toFixed(8);

            if (this.marker) {
                this.marker.setLatLng([lat, lng]);
            } else {
                this.marker = L.marker([lat, lng], { draggable: true }).addTo(this.map);
                this.marker.on('dragend', e => {
                    const ll = e.target.getLatLng();
                    this.setPosition(ll.lat, ll.lng);
                });
            }
            this.map.setView([lat, lng], 17);
            this.reverseGeocode(lat, lng);
        },

        useMyLocation() {
            if (!navigator.geolocation) {
                this.geoError = 'Browser Anda tidak mendukung geolokasi.';
                return;
            }
            this.geoLoading = true;
            this.geoError = '';

            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    this.geoLoading = false;
                    this.setPosition(pos.coords.latitude, pos.coords.longitude);
                },
                (err) => {
                    this.geoLoading = false;
                    const messages = {
                        1: 'Izin lokasi ditolak. Silakan aktifkan izin lokasi di pengaturan browser Anda.',
                        2: 'Lokasi tidak tersedia. Pastikan GPS/lokasi di perangkat Anda aktif.',
                        3: 'Waktu pencarian lokasi habis. Silakan coba lagi.'
                    };
                    this.geoError = messages[err.code] || 'Gagal mendapatkan lokasi.';
                },
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
            );
        },

        async searchAddress() {
            if (!this.searchQuery.trim()) return;
            this.searching = true;
            this.searchResults = [];
            try {
                const q = encodeURIComponent(this.searchQuery);
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${q}&countrycodes=id&limit=5&addressdetails=1`, {
                    headers: { 'Accept-Language': 'id' }
                });
                this.searchResults = await res.json();
                if (this.searchResults.length === 0) {
                    this.geoError = 'Alamat tidak ditemukan. Coba kata kunci lain.';
                }
            } catch (e) {
                this.geoError = 'Gagal mencari alamat. Periksa koneksi internet.';
            }
            this.searching = false;
        },

        selectSearchResult(result) {
            this.searchResults = [];
            this.searchQuery = result.display_name.split(',').slice(0, 3).join(',');
            this.setPosition(parseFloat(result.lat), parseFloat(result.lon));
        },

        async reverseGeocode(lat, lng) {
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                    headers: { 'Accept-Language': 'id' }
                });
                const data = await res.json();
                this.addressText = data.display_name || '';
            } catch (e) {
                this.addressText = '';
            }
        }
    };
}
</script>
@endpush
