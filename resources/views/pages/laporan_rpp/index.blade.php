@extends('layout.app')

@section('page-title', 'Laporan RPP')
@section('page-subtitle', 'Daftar Dokumentasi Kegiatan Mingguan')

@section('content')

    <div class="card mb20">
        <div class="cb" style="display:flex; justify-content:space-between; align-items:center;">
            <div style="display:flex; gap:20px;">
                <div style="text-align:center;">
                    <div style="font-size:24px; font-weight:700; color:var(--txt);">{{ $stats['total'] }}</div>
                    <div style="font-size:12px; color:var(--txt2);">Total Laporan</div>
                </div>
                <div style="width:1px; background:var(--g2);"></div>
                <div style="text-align:center;">
                    <div style="font-size:24px; font-weight:700; color:var(--green);">{{ $stats['disetujui'] }}</div>
                    <div style="font-size:12px; color:var(--txt2);">Disetujui</div>
                </div>
                <div style="width:1px; background:var(--g2);"></div>
                <div style="text-align:center;">
                    <div style="font-size:24px; font-weight:700; color:var(--orange);">{{ $stats['menunggu'] }}</div>
                    <div style="font-size:12px; color:var(--txt2);">Menunggu Validasi</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card lr-main-card" style="margin-bottom: 20px;">
        <div class="cb lr-index-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div class="ct" style="font-size: 16px; font-weight: 700;">Semua Laporan (Tahun Ajaran {{ $taAktif->name ?? '-' }})</div>
            
            <form action="{{ route('laporan_rpp') }}" method="GET" class="lr-index-filter" style="display:flex; gap:10px;">
                <input type="text" name="search" class="in" placeholder="Cari Tema/Subtema..." value="{{ request('search') }}" style="width:200px; padding:6px 12px; border-radius:4px; border:1px solid var(--g2);">
                <select name="status" class="in" style="width:150px; padding:6px 12px; border-radius:4px; border:1px solid var(--g2);">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Terkirim / Menunggu</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
                <button type="submit" class="btn bo">Filter</button>
            </form>
        </div>
    </div>
    
    <div style="display:flex; flex-direction:column; gap:15px; width:100%;">
        @php
            // Use items() if paginator, otherwise use as collection
            $items = $laporans instanceof \Illuminate\Pagination\LengthAwarePaginator ? $laporans->items() : $laporans;
            $groupedLaporans = collect($items)->groupBy(function($l) {
                return $l->rppm->subTema->tema->nama ?? $l->rppm->subTema->tema->name ?? 'Belum ada tema';
            });
        @endphp
        
        @forelse ($groupedLaporans as $temaName => $laporansInTema)
            <div class="card" style="margin-bottom:0;">
                <div class="ch" style="cursor:pointer; display:flex; justify-content:space-between; align-items:center;" onclick="toggleLaporanAccordion('tema_{{ \Illuminate\Support\Str::slug($temaName) }}', this)">
                    <div class="ct" style="font-size:16px;">
                        Tema: {{ $temaName }}
                    </div>
                    <div class="accordion-icon" style="transition: transform 0.3s; transform: rotate(-90deg);">▼</div>
                </div>
                <div id="laporan-tema_{{ \Illuminate\Support\Str::slug($temaName) }}" class="tw" style="display: none;">
                    <table style="width:100%; border-top:1px solid #eee;">
                        <thead>
                            <tr>
                                <th>Minggu</th>
                                <th>Tema & Sub Tema</th>
                                <th>Tanggal Dibuat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporansInTema as $laporan)
                                <tr>
                                    <td>Minggu ke-{{ $laporan->rppm->minggu_ke ?? '-' }}</td>
                                    <td>
                                        <div><strong>{{ $laporan->rppm->subTema->tema->nama ?? $laporan->rppm->subTema->tema->name ?? '-' }}</strong></div>
                                        <div style="font-size:12px; color:var(--txt2);">{{ $laporan->rppm->subTema->nama ?? $laporan->rppm->subTema->name ?? '-' }}</div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                                    <td>
                                        <span class="bdg {{ $laporan->status_badge_class }} {{ $laporan->status === 'dikembalikan' ? 'blink-warning' : '' }}" {!! $laporan->status === 'dikembalikan' ? 'style="background: #fef3c7; color: #b45309;"' : '' !!}>
                                            {!! $laporan->status === 'dikembalikan' ? '⚠️ ' : '' !!}{{ $laporan->status_label }}
                                        </span>
                                    </td>
                                    <td style="display:flex; gap:5px;">
                                        @if (in_array($laporan->status, ['draft', 'dikembalikan']))
                                            <a href="{{ route('laporan_rpp.show', $laporan->id) }}" class="btn bp bsm">✏️ Edit</a>
                                        @else
                                            <a href="{{ route('laporan_rpp.show', $laporan->id) }}" class="btn bo bsm">👁️ Lihat</a>
                                        @endif
                                        @if ($laporan->status === 'disetujui')
                                            <button class="btn bo bsm" onclick="window.print()">🖨️ Cetak</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="card" style="margin-bottom:0;">
                <div class="cb" style="text-align: center; color: var(--txt3); padding: 20px;">
                    Belum ada laporan yang dibuat.
                </div>
            </div>
        @endforelse
        
        @if($laporans instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div style="margin-top:15px;">
                {{ $laporans->links() }}
            </div>
        @endif
    </div>

@endsection

@push('scripts')
<style>
    .blink-warning {
        animation: blinker 1.5s linear infinite;
    }
    @keyframes blinker {
        50% { opacity: 0.3; }
    }
    
    @media (max-width: 768px) {
        .lr-index-header {
            flex-direction: column;
            align-items: stretch !important;
            gap: 15px;
        }
        .lr-index-filter {
            flex-direction: column;
            width: 100%;
        }
        .lr-index-filter input, .lr-index-filter select, .lr-index-filter button {
            width: 100% !important;
        }
        .lr-main-card {
            padding: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
        }
    }
</style>
<script>
    function toggleLaporanAccordion(id, el) {
        var target = $('#laporan-' + id);
        var icon = $(el).find('.accordion-icon');
        
        target.slideToggle(300, function() {
            if(target.is(':visible')) {
                icon.css('transform', 'rotate(0deg)');
            } else {
                icon.css('transform', 'rotate(-90deg)');
            }
        });
    }

    // Buka accordion pertama secara default
    $(document).ready(function() {
        var firstAccordion = $('.tw').first();
        if(firstAccordion.length > 0 && firstAccordion.attr('id') && firstAccordion.attr('id').startsWith('laporan-tema_')) {
            firstAccordion.show();
            firstAccordion.prev('.ch').find('.accordion-icon').css('transform', 'rotate(0deg)');
        }
    });
</script>
@endpush
