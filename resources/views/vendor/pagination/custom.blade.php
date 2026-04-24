@if ($paginator->hasPages())
    <div class="fl ic jb mt16" style="flex-wrap:wrap;gap:8px">

        <div class="fs11 tc2">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}
            dari {{ $paginator->total() }} kegiatan
        </div>

        <div class="fl ic g8">

            @if ($paginator->onFirstPage())
                <button class="btn bo bsm" disabled style="opacity:0.4;cursor:not-allowed">← Sebelumnya</button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn bo bsm">← Sebelumnya</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span style="color:var(--txt3);padding:0 4px">...</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- Halaman aktif --}}
                            <span class="btn bp bsm"
                                style="min-width:34px;justify-content:center">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="btn bo bsm"
                                style="min-width:34px;justify-content:center">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn bo bsm">Berikutnya →</a>
            @else
                <button class="btn bo bsm" disabled style="opacity:0.4;cursor:not-allowed">Berikutnya →</button>
            @endif
        </div>
    </div>
@endif
