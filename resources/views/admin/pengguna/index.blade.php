@extends('layouts.admin')
@section('title', 'Data Pengguna')
@section('page-title', 'Data Pengguna')

@section('content')
<div class="mb-5 flex flex-wrap gap-3 justify-between items-center">
    <form method="GET" action="{{ route('admin.pengguna.index') }}" class="flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..." class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none w-52">
        <select name="role" class="px-3 py-2 border border-gray-200 rounded-lg text-sm outline-none">
            <option value="">Semua Peran</option>
            @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $role->name)) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Filter</button>
    </form>
    <a href="{{ route('admin.pengguna.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Pengguna</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Email</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Nomor HP</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Peran</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center flex-shrink-0 text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $user->phone ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @foreach($user->roles as $role)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $role->name === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </span>
                        @endforeach
                    </td>
                    <td class="px-4 py-3">
                        @if($user->hasRole('umkm_owner'))
                            @php
                                $approvalStyle = match($user->account_status) {
                                    'approved' => 'bg-emerald-100 text-emerald-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                    default => 'bg-amber-100 text-amber-700',
                                };
                                $approvalLabel = match($user->account_status) {
                                    'approved' => 'Email terverifikasi', 'rejected' => 'Tidak disetujui', default => 'Menunggu OTP email',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $approvalStyle }}">{{ $approvalLabel }}</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $user->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.pengguna.edit', $user) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">Edit</a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.pengguna.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-gray-400">Belum ada data pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $users->links('components.pagination') }}
    </div>
    @endif
</div>
@endsection
