@extends('layouts.app')

@section('title', $event->title . ' — Acara & Kegiatan')
@section('meta_description', Str::limit(strip_tags($event->description), 160))

@section('content')
{{-- Hero Image --}}
<div class="relative">
    @if($event->cover_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->cover_image))
        <div class="w-full h-72 md:h-96 relative overflow-hidden">
            <img src="{{ Storage::disk('public')->url($event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10">
                <div class="max-w-4xl mx-auto">
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full uppercase tracking-wider">Acara</span>
                        @if(\Carbon\Carbon::parse($event->event_date)->isFuture())
                            <span class="inline-block px-3 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full">Mendatang</span>
                        @endif
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">{{ $event->title }}</h1>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 py-14">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center space-x-2 mb-3">
                    <span class="inline-block px-3 py-1 bg-white/20 text-white text-xs font-bold rounded-full">Acara</span>
                    @if(\Carbon\Carbon::parse($event->event_date)->isFuture())
                        <span class="inline-block px-3 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full">Mendatang</span>
                    @endif
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">{{ $event->title }}</h1>
            </div>
        </div>
    @endif
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Breadcrumb --}}
    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('event.index') }}" class="hover:text-blue-600 transition-colors">Acara &amp; Kegiatan</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-700 font-medium truncate">{{ Str::limit($event->title, 40) }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <div class="prose prose-blue max-w-none text-gray-700 leading-relaxed">
                    {!! $event->description !!}
                </div>
            </div>

            {{-- Back Link --}}
            <div class="mt-6">
                <a href="{{ route('event.index') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 font-semibold transition-colors text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Acara
                </a>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="space-y-4">
            {{-- Date & Time --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center"><svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Tanggal</p>
                        <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
                @if($event->start_time)
                <div class="flex items-center space-x-3 pt-4 border-t border-gray-50">
                    <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center"><svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Waktu</p>
                        <p class="text-sm font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                            {{ $event->end_time ? '– ' . \Carbon\Carbon::parse($event->end_time)->format('H:i') : '' }} WIB
                        </p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Location --}}
            @if($event->location_name || $event->address)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">Lokasi</p>
                        @if($event->location_name)<p class="text-sm font-bold text-gray-900">{{ $event->location_name }}</p>@endif
                        @if($event->address)<p class="text-xs text-gray-500 mt-0.5">{{ $event->address }}</p>@endif
                    </div>
                </div>
            </div>
            @endif

            {{-- CTA --}}
            @if($event->cta_url)
            <a href="{{ $event->cta_url }}" target="_blank" rel="noopener"
               class="block w-full text-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3.5 rounded-2xl transition-all shadow-md shadow-blue-200">
                Info Lebih Lanjut
            </a>
            @endif

            {{-- Share --}}
            <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-2xl border border-blue-100 p-5">
                <p class="text-xs font-bold text-gray-600 uppercase tracking-wide mb-3">Bagikan Acara</p>
                <div class="flex space-x-2">
                    <a href="https://wa.me/?text={{ urlencode($event->title . ' — ' . url()->current()) }}" target="_blank"
                       class="flex-1 flex items-center justify-center p-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition-colors">
                        WhatsApp
                    </a>
                    <button onclick="navigator.clipboard.writeText('{{ url()->current() }}').then(() => this.textContent = '✓ Disalin!')"
                            class="flex-1 flex items-center justify-center p-2.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl text-xs font-bold transition-colors">
                        Salin Link
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
