@php($compact = $compact ?? false)
@php($light = $light ?? false)
<div class="grid grid-cols-3 {{ $compact ? 'gap-2' : 'gap-3 mb-8' }}">
    @foreach([
        [number_format($authStats['umkmRegistered'] ?? 0, 0, ',', '.'), 'UMKM Terdaftar'],
        [number_format($authStats['activeProducts'] ?? 0, 0, ',', '.'), 'Produk Aktif'],
        [($authStats['verificationRate'] ?? 0) . '%', 'Terverifikasi'],
    ] as [$num, $label])
    <div class="{{ $light ? 'rounded-xl border border-slate-200 bg-slate-50' : 'glass rounded-xl' }} {{ $compact ? 'p-2.5' : 'p-4' }} text-center">
        <p class="{{ $compact ? 'text-base' : 'text-xl' }} font-bold {{ $light ? 'text-slate-900' : 'text-white' }}">{{ $num }}</p>
        <p class="{{ $light ? 'text-slate-500' : 'text-slate-400' }} {{ $compact ? 'text-[10px]' : 'text-xs' }} mt-1">{{ $label }}</p>
    </div>
    @endforeach
</div>
