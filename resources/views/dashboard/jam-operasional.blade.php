@extends('layouts.dashboard')
@section('title', 'Jam Operasional')
@section('page-title', 'Jam Operasional')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="mb-5">
            <h3 class="font-bold text-slate-800 text-lg">Jam Operasional Usaha</h3>
            <p class="text-slate-500 text-sm mt-1">Atur jam buka dan tutup usaha Anda setiap hari.</p>
        </div>

        <form action="{{ route('dashboard.jam-operasional.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-3">
                @foreach($days as $index => $day)
                <div class="flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
                    <div class="w-28 text-sm font-semibold text-slate-700">{{ $day['name'] }}</div>

                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="hidden" name="hours[{{ $index }}][day_of_week]" value="{{ $index }}">
                        <input type="checkbox" name="hours[{{ $index }}][is_closed]" value="1"
                            {{ $day['is_closed'] ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-gray-300 text-red-500 focus:ring-red-400"
                            onchange="toggleDay(this, {{ $index }})">
                        <span class="text-sm text-slate-500">Tutup</span>
                    </label>

                    <div class="flex items-center gap-2 flex-1" id="time-row-{{ $index }}" {{ $day['is_closed'] ? 'style=opacity:0.3;pointer-events:none' : '' }}>
                        <input type="time" name="hours[{{ $index }}][open_time]" value="{{ $day['open_time'] }}"
                            class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <span class="text-slate-400 text-sm">s/d</span>
                        <input type="time" name="hours[{{ $index }}][close_time]" value="{{ $day['close_time'] }}"
                            class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    Simpan Jam Operasional
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function toggleDay(checkbox, index) {
    const row = document.getElementById('time-row-' + index);
    row.style.opacity = checkbox.checked ? '0.3' : '1';
    row.style.pointerEvents = checkbox.checked ? 'none' : 'auto';
}
</script>
@endpush
@endsection
