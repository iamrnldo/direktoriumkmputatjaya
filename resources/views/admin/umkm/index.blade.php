@extends('layouts.admin')
@section('title', 'Data UMKM')
@section('page-title', 'Data UMKM')

@section('content')
<div class="flex flex-wrap gap-3 mb-5 justify-between items-center">
    <form method="GET" action="{{ route('admin.umkm.index') }}" class="flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama UMKM..." class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 outline-none w-52">
        <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm outline-none">
            <option value="">Semua Status</option>
            <option value="draft" {{ request('status')=='draft'?'selected':'' }}>Draft</option>
            <option value="diajukan" {{ request('status')=='diajukan'?'selected':'' }}>Diajukan</option>
            <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
            <option value="ditolak" {{ request('status')=='ditolak'?'selected':'' }}>Ditolak</option>
            <option value="nonaktif" {{ request('status')=='nonaktif'?'selected':'' }}>Nonaktif</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg text-sm hover:bg-teal-700">Filter</button>
    </form>
    <a href="{{ route('admin.ekspor') }}" class="flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm hover:bg-emerald-700">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        Ekspor Excel
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Usaha</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Kategori</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Unggulan</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($umkmList as $umkm)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-800">{{ $umkm->name }}</p>
                        <p class="text-xs text-gray-400">{{ $umkm->owner_name }}</p>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $umkm->category?->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $umkm->verification_status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : '' }}
                            {{ $umkm->verification_status === 'draft' ? 'bg-gray-100 text-gray-600' : '' }}
                            {{ $umkm->verification_status === 'diajukan' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $umkm->verification_status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $umkm->verification_status === 'nonaktif' ? 'bg-gray-100 text-gray-500' : '' }}
                        ">{{ $umkm->status_label }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @if($umkm->is_featured)
                        <span class="text-amber-500 font-bold">⭐</span>
                        @else
                        <span class="text-gray-300">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('umkm.show', $umkm->slug) }}" target="_blank" class="text-teal-600 hover:text-teal-800 text-xs">Lihat</a>
                            <a href="{{ route('admin.umkm.edit', $umkm->id) }}" class="text-blue-600 hover:text-blue-800 text-xs">Edit</a>
                            @if($umkm->verification_status === 'diajukan')
                            <a href="{{ route('admin.verifikasi-umkm.show', $umkm->id) }}" class="text-amber-600 hover:text-amber-800 text-xs">Verifikasi</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-gray-400">Belum ada data UMKM</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $umkmList->links('components.pagination') }}
    </div>
</div>
@endsection
