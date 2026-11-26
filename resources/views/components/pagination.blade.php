@if ($paginator->hasPages())
<nav class="flex items-center justify-center space-x-1 mt-8" aria-label="Paginasi">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-2 text-gray-300 rounded-lg cursor-not-allowed">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-gray-500 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="px-3 py-2 text-gray-500">...</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-3.5 py-2 bg-teal-600 text-white rounded-lg font-medium text-sm">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3.5 py-2 text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-lg text-sm transition-colors">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-gray-500 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    @else
        <span class="px-3 py-2 text-gray-300 rounded-lg cursor-not-allowed">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </span>
    @endif
</nav>
<p class="text-center text-sm text-gray-500 mt-3">Menampilkan {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} dari {{ $paginator->total() }} hasil</p>
@endif
