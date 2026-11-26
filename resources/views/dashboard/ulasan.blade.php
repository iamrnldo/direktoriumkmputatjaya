@extends('layouts.dashboard')
@section('title', 'Ulasan Pelanggan')
@section('page-title', 'Ulasan Pelanggan')

@section('content')
{{-- Stats Summary --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
        <p class="text-4xl font-extrabold text-slate-900">{{ $stats['total'] }}</p>
        <p class="text-sm text-slate-500 mt-1 font-medium">Total Ulasan</p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
        <div class="flex items-center justify-center gap-2">
            <p class="text-4xl font-extrabold text-amber-500">{{ $stats['average'] }}</p>
            <svg class="w-7 h-7 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        </div>
        <p class="text-sm text-slate-500 mt-1 font-medium">Rating Rata-rata</p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="space-y-2">
            @foreach($stats['distribution'] as $star => $data)
            <div class="flex items-center gap-2 text-sm">
                <span class="w-4 font-semibold text-slate-600">{{ $star }}</span>
                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-amber-400 rounded-full" style="width: {{ $data['percent'] }}%"></div>
                </div>
                <span class="text-xs text-slate-400 w-8 text-right">{{ $data['count'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Reviews List --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    @if($reviews->count() > 0)
    <div class="divide-y divide-gray-50">
        @foreach($reviews as $review)
        <div class="p-5 hover:bg-gray-50/50 transition-colors">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                    {{ strtoupper(substr($review->user->name ?? '?', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $review->user->name ?? 'Pengguna' }}</p>
                            <div class="flex items-center gap-1 mt-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </div>
                        <span class="text-xs text-slate-400">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    @if($review->comment)
                    <p class="text-sm text-slate-600 mt-2 leading-relaxed">{{ $review->comment }}</p>
                    @endif
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $review->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($review->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                            {{ $review->status === 'approved' ? '✓ Disetujui' : ($review->status === 'pending' ? '⏳ Menunggu' : '✕ Ditolak') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $reviews->links() }}
    </div>
    @else
    <div class="text-center py-16">
        <div class="text-5xl mb-3">💬</div>
        <h3 class="font-bold text-slate-700 mb-2">Belum Ada Ulasan</h3>
        <p class="text-sm text-slate-400">Ulasan dari pelanggan akan muncul di sini.</p>
    </div>
    @endif
</div>
@endsection
