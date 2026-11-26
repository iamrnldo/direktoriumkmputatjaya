@extends('layouts.admin')
@section('title', 'Banner / Slider')
@section('page-title', 'Banner & Slider')

@section('content')
<div class="mb-5 flex flex-wrap gap-3 justify-between items-center">
    <div>
        <h2 class="text-lg font-bold text-slate-800">Manajemen Banner / Slider</h2>
        <p class="text-sm text-slate-500">Kelola gambar promosi dan pengumuman di halaman utama</p>
    </div>
    <a href="{{ route('admin.banner.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Banner
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Banner</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Urutan</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Tautan (CTA)</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($banners as $banner)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($banner->image_path)
                            <img src="{{ Storage::disk('public')->url($banner->image_path) }}" alt="{{ $banner->title }}" class="w-20 h-12 rounded-lg object-cover flex-shrink-0 border border-gray-100">
                            @else
                            <div class="w-20 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs">No image</div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-800">{{ $banner->title }}</p>
                                <p class="text-xs text-gray-400">{{ Str::limit($banner->description, 40) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-600 font-medium">{{ $banner->sort_order ?? 0 }}</td>
                    <td class="px-4 py-3 text-gray-600 text-xs">
                        @if($banner->cta_url)
                        <a href="{{ $banner->cta_url }}" target="_blank" class="text-blue-600 hover:underline">{{ $banner->cta_label ?? 'Buka Link' }}</a>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <form action="{{ route('admin.banner.toggle-aktif', $banner) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-2.5 py-1 rounded-full text-xs font-semibold cursor-pointer transition-colors {{ $banner->is_active ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.banner.edit', $banner) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">Edit</a>
                            <form action="{{ route('admin.banner.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-gray-400">Belum ada banner / slider terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($banners->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $banners->links('components.pagination') }}
    </div>
    @endif
</div>
@endsection
