@extends('layouts.dashboard')
@section('title', 'Status Verifikasi')
@section('page-title', 'Status Verifikasi')

@section('content')
<div class="max-w-2xl">
    @if(!$umkm)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
        <div class="text-4xl mb-3">📝</div>
        <h3 class="text-lg font-semibold text-gray-800">Profil Usaha Belum Dibuat</h3>
        <p class="text-gray-500 mt-2 mb-5">Silakan buat profil usaha Anda terlebih dahulu sebelum mengajukan verifikasi.</p>
        <a href="{{ route('dashboard.profil-usaha') }}" class="px-6 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-700">Buat Profil Usaha</a>
    </div>
    @else

    {{-- Status Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-5">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="font-semibold text-gray-800 mb-1">{{ $umkm->name }}</h3>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                    @if($umkm->verification_status === 'aktif') bg-emerald-100 text-emerald-700
                    @elseif($umkm->verification_status === 'draft') bg-gray-100 text-gray-600
                    @elseif($umkm->verification_status === 'diajukan') bg-amber-100 text-amber-700
                    @elseif($umkm->verification_status === 'perlu_revisi') bg-orange-100 text-orange-700
                    @elseif($umkm->verification_status === 'ditolak') bg-red-100 text-red-700
                    @else bg-gray-100 text-gray-600 @endif">
                    {{ $umkm->status_label }}
                </span>
            </div>
            @if($umkm->is_featured)
            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">⭐ Unggulan</span>
            @endif
        </div>

        @if($umkm->verification_notes)
        <div class="mt-4 p-3 bg-orange-50 rounded-lg border border-orange-100">
            <p class="text-xs font-medium text-orange-700 mb-1">Catatan Admin:</p>
            <p class="text-sm text-orange-800">{{ $umkm->verification_notes }}</p>
        </div>
        @endif

        @if($umkm->verified_at)
        <p class="text-xs text-gray-400 mt-3">Terverifikasi: {{ $umkm->verified_at->isoFormat('D MMMM Y') }}</p>
        @endif
    </div>

    {{-- Submit button --}}
    @if(in_array($umkm->verification_status, ['draft', 'perlu_revisi', 'ditolak']))
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-5" x-data="{ showConfirm: false }">
        <h3 class="font-semibold text-gray-800 mb-2">Ajukan Verifikasi</h3>
        <p class="text-sm text-gray-500 mb-4">Pastikan data profil usaha Anda sudah lengkap sebelum mengajukan. Admin kelurahan akan meninjau pengajuan Anda.</p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5 text-center">
            <div class="p-3 rounded-lg {{ $umkm->name && $umkm->address ? 'bg-emerald-50 border border-emerald-200' : 'bg-gray-50 border border-gray-200' }}">
                <div class="text-xl">{{ $umkm->name && $umkm->address ? '✅' : '❌' }}</div>
                <p class="text-xs mt-1 text-gray-600">Data Dasar</p>
            </div>
            <div class="p-3 rounded-lg {{ $umkm->images?->count() ? 'bg-emerald-50 border border-emerald-200' : 'bg-gray-50 border border-gray-200' }}">
                <div class="text-xl">{{ $umkm->images?->count() ? '✅' : '❌' }}</div>
                <p class="text-xs mt-1 text-gray-600">Foto Usaha</p>
            </div>
            <div class="p-3 rounded-lg {{ $umkm->latitude ? 'bg-emerald-50 border border-emerald-200' : 'bg-amber-50 border border-amber-200' }}">
                <div class="text-xl">{{ $umkm->latitude ? '✅' : '⚠️' }}</div>
                <p class="text-xs mt-1 text-gray-600">Lokasi Peta</p>
            </div>
        </div>

        {{-- Trigger Button --}}
        <button type="button" @click="showConfirm = true"
            class="w-full py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Ajukan Verifikasi Sekarang</span>
        </button>

        {{-- Hidden Form --}}
        <form id="form-ajukan-verifikasi" method="POST" action="{{ route('dashboard.ajukan-verifikasi') }}">
            @csrf
        </form>

        {{-- Confirm Modal --}}
        <div x-show="showConfirm" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showConfirm = false"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 z-10"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 text-center mb-2">Ajukan Verifikasi?</h3>
                <p class="text-sm text-slate-500 text-center mb-1">
                    Profil usaha <strong class="text-slate-700">{{ $umkm->name }}</strong> akan dikirimkan ke admin kelurahan untuk ditinjau.
                </p>
                <p class="text-xs text-slate-400 text-center mb-6">
                    Pastikan semua data sudah benar sebelum mengajukan. Proses verifikasi biasanya memakan waktu 1–3 hari kerja.
                </p>
                <div class="flex space-x-3">
                    <button @click="showConfirm = false"
                        class="flex-1 py-2.5 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-colors">
                        Cek Dulu
                    </button>
                    <button @click="document.getElementById('form-ajukan-verifikasi').submit()"
                        class="flex-1 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors">
                        Ya, Ajukan
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Verification history --}}
    @if($umkm->verifications->count())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Riwayat Verifikasi</h3>
        <div class="space-y-4">
            @foreach($umkm->verifications as $ver)
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                    {{ $ver->status === 'approved' ? 'bg-emerald-100' : '' }}
                    {{ $ver->status === 'rejected' ? 'bg-red-100' : '' }}
                    {{ $ver->status === 'revision_requested' ? 'bg-orange-100' : '' }}">
                    <span class="text-sm">{{ $ver->status === 'approved' ? '✅' : ($ver->status === 'rejected' ? '❌' : '⚠️') }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">{{ $ver->status === 'approved' ? 'Disetujui' : ($ver->status === 'rejected' ? 'Ditolak' : 'Diminta Revisi') }}</p>
                    @if($ver->notes)<p class="text-sm text-gray-500 mt-0.5">{{ $ver->notes }}</p>@endif
                    <p class="text-xs text-gray-400 mt-0.5">{{ $ver->created_at->isoFormat('D MMMM Y, HH:mm') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endif
</div>
@endsection
