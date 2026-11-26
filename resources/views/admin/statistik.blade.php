@extends('layouts.admin')

@section('title', 'Statistik')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <h3 class="text-3xl font-medium text-gray-700">Statistik UMKM</h3>
    
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Sebaran Kategori UMKM</h4>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Pertumbuhan UMKM</h4>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="pertumbuhanChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctxKategori = document.getElementById('kategoriChart').getContext('2d');
            new Chart(ctxKategori, {
                type: 'doughnut',
                data: {
                    labels: ['Kuliner', 'Kerajinan', 'Jasa', 'Lainnya'],
                    datasets: [{
                        data: [65, 25, 20, 10],
                        backgroundColor: ['#14b8a6', '#f59e0b', '#3b82f6', '#6b7280']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            const ctxPertumbuhan = document.getElementById('pertumbuhanChart').getContext('2d');
            new Chart(ctxPertumbuhan, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'UMKM Baru',
                        data: [5, 10, 8, 15, 12, 20],
                        backgroundColor: '#14b8a6'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
@endsection
