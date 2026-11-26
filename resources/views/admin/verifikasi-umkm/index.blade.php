@extends('layouts.admin')
@section('title', 'Verifikasi UMKM')
@section('page-title', 'Verifikasi UMKM')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Usaha</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Pemilik</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Kategori</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Diajukan</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pendingList as $umkm)
                <tr class="hover:bg-amber-50">
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $umkm->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $umkm->owner_name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $umkm->category?->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $umkm->updated_at->diffForHumans() }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.verifikasi-umkm.show', $umkm->id) }}" class="px-3 py-1.5 bg-teal-600 text-white text-xs font-medium rounded-lg hover:bg-teal-700">Tinjau & Verifikasi</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-10 text-center">
                    <div class="text-4xl mb-2">✅</div>
                    <p class="text-gray-400">Tidak ada pengajuan verifikasi yang menunggu</p>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pendingList instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="px-4 py-3 border-t border-gray-100">{{ $pendingList->links('components.pagination') }}</div>
    @endif
</div>
@endsection
