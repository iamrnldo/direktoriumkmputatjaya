@extends('layouts.app')

@section('title', 'Acara & Kegiatan')
@section('meta_description', 'Ikuti berbagai acara, pameran, dan bazar yang diadakan oleh UMKM Kelurahan Putat Jaya.')

@section('content')
<div class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-white/15 backdrop-blur-sm text-white mb-5 border border-white/20">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-300 mr-2 animate-pulse"></span>
            Agenda Terbaru
        </div>
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-4 tracking-tight">Acara <span class="text-blue-200">&amp; Kegiatan</span></h1>
        <p class="text-lg text-blue-100 max-w-2xl mx-auto">Ikuti berbagai acara, pameran, dan bazar yang diadakan oleh UMKM Kelurahan Putat Jaya.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $event)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                    <div class="relative h-56 overflow-hidden">
                        @if($event->cover_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->cover_image))
                            <img src="{{ Storage::disk('public')->url($event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-sm">
                            <span class="text-xs font-bold text-blue-700">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d M Y') }}</span>
                        </div>
                        @if(\Carbon\Carbon::parse($event->event_date)->isFuture())
                        <div class="absolute bottom-4 left-4 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                            Mendatang
                        </div>
                        @elseif(\Carbon\Carbon::parse($event->event_date)->isToday())
                        <div class="absolute bottom-4 left-4 bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                            Hari Ini
                        </div>
                        @endif
                    </div>
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">{{ $event->title }}</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-3">{{ Str::limit(strip_tags($event->description), 120) }}</p>

                        <div class="mt-auto pt-4 border-t border-gray-100 space-y-2">
                            @if($event->start_time)
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}{{ $event->end_time ? ' - ' . \Carbon\Carbon::parse($event->end_time)->format('H:i') . ' WIB' : ' WIB' }}
                            </div>
                            @endif
                            @if($event->location_name ?? $event->address)
                            <div class="flex items-start text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="line-clamp-1">{{ $event->location_name ?? $event->address }}</span>
                            </div>
                            @endif
                        </div>
                        <a href="{{ route('event.show', $event->slug) }}" class="mt-5 w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition-all duration-300 text-sm">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-12">
            {{ $events->links('components.pagination') }}
        </div>
    @else
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-16 text-center max-w-2xl mx-auto">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-50 mb-6">
                <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Acara</h3>
            <p class="text-gray-500 mb-6">Saat ini belum ada acara atau kegiatan mendatang yang dijadwalkan. Silakan periksa kembali nanti.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    @endif
</div>
@endsection
