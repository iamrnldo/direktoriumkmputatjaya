@extends('layouts.admin')
@section('title', 'Ekspor Data')
@section('page-title', 'Ekspor Data')

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- Header Info --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white">
        <div class="flex items-center space-x-4">
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold">Ekspor Data</h2>
                <p class="text-blue-100 text-sm mt-1">Unduh data UMKM dan produk dalam format Excel atau CSV</p>
            </div>
        </div>
    </div>

    {{-- UMKM Export --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center space-x-3 mb-5">
            <div class="w-10 h-10 bg-teal-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Data UMKM</h3>
                <p class="text-sm text-gray-500">Ekspor seluruh data profil UMKM terdaftar</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ route('admin.ekspor.umkm-excel') }}"
               class="flex items-center justify-center p-4 bg-teal-50 border-2 border-teal-200 rounded-xl hover:bg-teal-600 hover:border-teal-600 hover:text-white text-teal-700 transition-all duration-200 group font-semibold text-sm">
                <svg class="w-5 h-5 mr-2.5 group-hover:text-white text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Unduh Excel (.xlsx)
            </a>
            <a href="{{ route('admin.ekspor.umkm-csv') }}"
               class="flex items-center justify-center p-4 bg-emerald-50 border-2 border-emerald-200 rounded-xl hover:bg-emerald-600 hover:border-emerald-600 hover:text-white text-emerald-700 transition-all duration-200 group font-semibold text-sm">
                <svg class="w-5 h-5 mr-2.5 group-hover:text-white text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Unduh CSV (.csv)
            </a>
        </div>
    </div>

    {{-- Products Export --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center space-x-3 mb-5">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Data Produk</h3>
                <p class="text-sm text-gray-500">Ekspor seluruh data produk UMKM</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ route('admin.ekspor.produk-excel') }}"
               class="flex items-center justify-center p-4 bg-blue-50 border-2 border-blue-200 rounded-xl hover:bg-blue-600 hover:border-blue-600 hover:text-white text-blue-700 transition-all duration-200 group font-semibold text-sm">
                <svg class="w-5 h-5 mr-2.5 group-hover:text-white text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Unduh Excel (.xlsx)
            </a>
            <a href="{{ route('admin.ekspor.produk-csv') }}"
               class="flex items-center justify-center p-4 bg-indigo-50 border-2 border-indigo-200 rounded-xl hover:bg-indigo-600 hover:border-indigo-600 hover:text-white text-indigo-700 transition-all duration-200 group font-semibold text-sm">
                <svg class="w-5 h-5 mr-2.5 group-hover:text-white text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Unduh CSV (.csv)
            </a>
        </div>
    </div>

    {{-- Info Box --}}
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-start space-x-3">
        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-amber-800">Catatan</p>
            <p class="text-xs text-amber-700 mt-1">File Excel (.xlsx) kompatibel dengan Microsoft Excel, Google Sheets, dan LibreOffice Calc. File CSV dapat dibuka di semua aplikasi spreadsheet.</p>
        </div>
    </div>

</div>
@endsection
