@extends('layouts.dashboard')
@section('title', 'Galeri Foto')
@section('page-title', 'Galeri Foto')

@section('content')
<div class="max-w-5xl space-y-6">

    {{-- Upload Card --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-7 py-5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div>
                    <h3 class="font-black text-gray-900">Tambah Foto</h3>
                    <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, WEBP · Maks. 5 MB per foto · Hingga 10 foto sekaligus</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center space-x-1.5 text-xs font-semibold text-slate-500 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ $umkm->images->count() }}/∞ foto</span>
            </div>
        </div>

        <div class="p-7">
            <form action="{{ route('dashboard.galeri-usaha.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf

                {{-- Drop Zone --}}
                <div id="drop-zone"
                     class="border-2 border-dashed border-gray-200 rounded-2xl p-12 text-center cursor-pointer transition-all duration-200"
                     style="background: linear-gradient(135deg, #f8fafc 0%, #f0f4ff 100%);"
                     onclick="document.getElementById('photoInput').click()"
                     ondragover="event.preventDefault(); this.style.borderColor='#3b82f6'; this.style.background='linear-gradient(135deg,#eff6ff,#eef2ff)'"
                     ondragleave="this.style.borderColor=''; this.style.background='linear-gradient(135deg,#f8fafc,#f0f4ff)'"
                     ondrop="handleDrop(event)">

                    <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 border border-blue-100">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="font-bold text-gray-700 mb-1">Klik atau drag & drop foto di sini</p>
                    <p class="text-sm text-gray-400">Format: JPG, PNG, WEBP · Maks. 5 MB per foto</p>

                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                           class="hidden" id="photoInput" onchange="previewFiles(this)">
                </div>

                {{-- Preview Area --}}
                <div id="preview-container" class="hidden mt-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-bold text-gray-700">Preview foto yang akan diunggah</p>
                        <button type="button" onclick="clearFiles()" class="text-xs text-red-500 hover:text-red-700 font-semibold">Batal semua</button>
                    </div>
                    <div id="preview-grid" class="grid grid-cols-3 sm:grid-cols-5 md:grid-cols-6 gap-2"></div>
                </div>

                {{-- Upload Footer --}}
                <div class="mt-5 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div id="file-count-badge" class="hidden items-center space-x-1.5 px-3 py-1.5 bg-blue-50 border border-blue-100 rounded-xl">
                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span id="file-label" class="text-xs font-semibold text-blue-700">0 foto dipilih</span>
                        </div>
                        <span id="empty-label" class="text-sm text-gray-400">Belum ada foto dipilih</span>
                    </div>
                    <button type="submit" id="upload-btn"
                        class="flex items-center space-x-2 px-6 py-2.5 font-bold text-sm rounded-2xl text-white transition-all disabled:opacity-40 disabled:cursor-not-allowed"
                        style="background:linear-gradient(135deg,#2563eb,#4f46e5);box-shadow:0 4px 14px rgba(37,99,235,0.25)"
                        disabled>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span>Unggah Foto</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Gallery Grid --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-7 py-5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-slate-50 rounded-2xl flex items-center justify-center text-xl">🖼️</div>
                <div>
                    <h3 class="font-black text-gray-900">Foto Galeri</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $umkm->images->count() }} foto tersimpan</p>
                </div>
            </div>
            @if($umkm->images->count() > 0)
            <span class="text-xs text-slate-400 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">Hover untuk opsi</span>
            @endif
        </div>

        <div class="p-7">
            @if($umkm->images->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($umkm->images->sortByDesc('is_cover') as $image)
                <div class="relative group rounded-2xl overflow-hidden bg-gray-100 transition-all duration-200
                    {{ $image->is_cover ? 'ring-2 ring-amber-400 ring-offset-2 shadow-lg shadow-amber-100' : 'hover:shadow-md' }}"
                    style="aspect-ratio:1">

                    {{-- Image --}}
                    @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($image->image_path))
                    <img src="{{ Storage::disk('public')->url($image->image_path) }}" alt="Foto galeri"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-3xl">📷</div>
                    @endif

                    {{-- Cover badge --}}
                    @if($image->is_cover)
                    <div class="absolute top-2 left-2 bg-amber-400 text-amber-900 text-[10px] font-black px-2 py-0.5 rounded-full shadow flex items-center space-x-0.5">
                        <span>⭐</span><span>Cover</span>
                    </div>
                    @endif

                    {{-- Hover overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-200 flex flex-col justify-end p-2.5 space-y-1.5">
                        @if(!$image->is_cover)
                        <form action="{{ route('dashboard.galeri-usaha.cover', $image->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="w-full py-1.5 bg-amber-400 hover:bg-amber-500 text-amber-900 text-xs font-black rounded-xl transition-colors">
                                ⭐ Jadikan Cover
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('dashboard.galeri-usaha.destroy', $image->id) }}" method="POST" id="delete-foto-{{ $image->id }}">
                            @csrf @method('DELETE')
                            <button type="button" onclick="window.dispatchEvent(new CustomEvent('confirm-delete', {detail: {form: 'delete-foto-{{ $image->id }}', message: 'Foto ini akan dihapus permanen dan tidak bisa dikembalikan.'}}))"
                                class="w-full py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-black rounded-xl transition-colors">
                                🗑 Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach

                {{-- Add more placeholder --}}
                <div class="rounded-2xl border-2 border-dashed border-gray-200 hover:border-blue-300 hover:bg-blue-50/50 flex flex-col items-center justify-center cursor-pointer transition-all duration-200 group"
                     style="aspect-ratio:1"
                     onclick="document.getElementById('photoInput').click()">
                    <div class="w-10 h-10 bg-blue-50 group-hover:bg-blue-100 rounded-xl flex items-center justify-center mb-2 transition-colors">
                        <svg class="w-5 h-5 text-blue-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-400 group-hover:text-blue-600 transition-colors">Tambah Foto</span>
                </div>
            </div>
            @else
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl flex items-center justify-center mx-auto mb-5 text-5xl shadow-sm border border-blue-100">
                    📷
                </div>
                <h4 class="font-black text-gray-700 text-lg mb-2">Belum Ada Foto Galeri</h4>
                <p class="text-sm text-gray-400 max-w-xs mx-auto leading-relaxed">
                    Foto galeri membantu pelanggan mengenal usaha Anda. Upload sekarang!
                </p>
                <button onclick="document.getElementById('drop-zone').scrollIntoView({behavior:'smooth'})"
                    class="mt-5 inline-flex items-center space-x-2 px-6 py-2.5 text-white font-bold text-sm rounded-2xl transition-all hover:-translate-y-0.5"
                    style="background:linear-gradient(135deg,#2563eb,#4f46e5);box-shadow:0 4px 14px rgba(37,99,235,0.3)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Upload Foto Pertama</span>
                </button>
            </div>
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
function previewFiles(input) {
    const files = Array.from(input.files);
    const container = document.getElementById('preview-container');
    const grid = document.getElementById('preview-grid');
    const btn = document.getElementById('upload-btn');
    const badge = document.getElementById('file-count-badge');
    const label = document.getElementById('file-label');
    const empty = document.getElementById('empty-label');

    if (files.length > 0) {
        label.textContent = files.length + ' foto dipilih';
        badge.classList.remove('hidden');
        badge.classList.add('flex');
        empty.classList.add('hidden');
        btn.disabled = false;

        grid.innerHTML = '';
        container.classList.remove('hidden');

        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'relative rounded-xl overflow-hidden border border-gray-200 bg-gray-100';
                div.style.aspectRatio = '1';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 inset-x-0 bg-black/40 px-1.5 py-1 text-white text-[9px] font-semibold truncate">${file.name}</div>
                `;
                grid.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    } else {
        clearFiles();
    }
}

function clearFiles() {
    const input = document.getElementById('photoInput');
    input.value = '';
    document.getElementById('preview-container').classList.add('hidden');
    document.getElementById('preview-grid').innerHTML = '';
    document.getElementById('upload-btn').disabled = true;
    document.getElementById('file-count-badge').classList.add('hidden');
    document.getElementById('file-count-badge').classList.remove('flex');
    document.getElementById('empty-label').classList.remove('hidden');
}

function handleDrop(event) {
    event.preventDefault();
    const zone = document.getElementById('drop-zone');
    zone.style.borderColor = '';
    zone.style.background = 'linear-gradient(135deg, #f8fafc 0%, #f0f4ff 100%)';

    const input = document.getElementById('photoInput');
    const dt = new DataTransfer();
    Array.from(event.dataTransfer.files)
        .filter(f => f.type.startsWith('image/'))
        .slice(0, 10)
        .forEach(f => dt.items.add(f));

    input.files = dt.files;
    previewFiles(input);
}

// Loading state on submit
document.getElementById('upload-form').addEventListener('submit', function() {
    const btn = document.getElementById('upload-btn');
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        <span>Mengunggah...</span>
    `;
});
</script>
@endpush
@endsection
