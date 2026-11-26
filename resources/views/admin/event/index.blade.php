@extends('layouts.admin')
@section('title', 'Event & Acara')
@section('page-title', 'Event & Acara')

@section('content')
<div class="mb-5 flex flex-wrap gap-3 justify-between items-center">
    <div>
        <h2 class="text-lg font-bold text-slate-800">Daftar Event & Kegiatan</h2>
        <p class="text-sm text-slate-500">Kelola agenda dan acara seputar UMKM Kelurahan Putat Jaya</p>
    </div>
    <a href="{{ route('admin.event.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Event
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Event</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Lokasi</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($events as $event)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($event->cover_image)
                            <img src="{{ Storage::disk('public')->url($event->cover_image) }}" alt="{{ $event->title }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                            @else
                            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg flex-shrink-0">📅</div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-800">{{ Str::limit($event->title, 40) }}</p>
                                <p class="text-xs text-gray-400">{{ Str::limit($event->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ \Carbon\Carbon::parse($event->event_date)->isoFormat('D MMMM Y') }}
                        @if($event->start_time)
                        <div class="text-xs text-gray-400">{{ substr($event->start_time, 0, 5) }} {{ $event->end_time ? '- ' . substr($event->end_time, 0, 5) : '' }} WIB</div>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-xs">{{ $event->location_name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $event->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.event.edit', $event) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">Edit</a>
                            <form action="{{ route('admin.event.destroy', $event) }}" method="POST" onsubmit="return confirm('Hapus acara ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-gray-400">Belum ada acara atau event terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($events->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $events->links('components.pagination') }}
    </div>
    @endif
</div>
@endsection
