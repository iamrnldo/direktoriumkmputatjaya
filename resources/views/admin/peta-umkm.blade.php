@extends('layouts.admin')

@section('title', 'Peta Persebaran UMKM')

@push('scripts')
    <!-- Include Leaflet CSS/JS here if needed -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-3xl font-medium text-gray-700">Peta Persebaran UMKM</h3>
    </div>

    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
        <div id="map" class="w-full h-96 bg-gray-200 rounded z-0"></div>
    </div>
    
    <div class="mt-6 bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Keterangan</h4>
        <div class="flex space-x-6">
            <div class="flex items-center">
                <span class="w-4 h-4 rounded-full bg-blue-500 mr-2"></span>
                <span class="text-gray-700">Kuliner</span>
            </div>
            <div class="flex items-center">
                <span class="w-4 h-4 rounded-full bg-green-500 mr-2"></span>
                <span class="text-gray-700">Kerajinan</span>
            </div>
            <div class="flex items-center">
                <span class="w-4 h-4 rounded-full bg-yellow-500 mr-2"></span>
                <span class="text-gray-700">Jasa</span>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map centered on Putat Jaya, Surabaya
            var map = L.map('map').setView([-7.2833, 112.7167], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Example marker
            L.marker([-7.2833, 112.7167]).addTo(map)
                .bindPopup('Kelurahan Putat Jaya');
        });
    </script>
@endsection
