@extends('layout.app')

@section('page-title', 'Analisis Aspek Perkembangan')
@section('page-subtitle', $taAktif?->name ?? '-')

@section('content')
    <div class="card mb16">
        <div class="ch">
            <div>
                <div class="ct">📊 Distribusi Aspek - {{ $kelas->name }}</div>
                <div class="cs">Dari {{ $ringkasan['rppm_disetujui'] }} RPPM disetujui - {{ $totalKegiatan }} slot
                    kegiatan</div>
            </div>
        </div>
        @foreach ($aspekData as $aspek)
            <div class="graf-bar">
                <div class="graf-label">
                    <span class="ap {{ $aspek['warna'] }}">
                        {{ $aspek['emote'] }} {{ $aspek['name'] }}
                    </span>
                </div>
                <div class="graf-wrap">
                    @if ($aspek['jumlah'] > 0)
                        <div class="graf-fill pb {{ $aspek['warna'] === 'a1'
                            ? 'pu'
                            : ($aspek['warna'] === 'a2'
                                ? 'bl'
                                : ($aspek['warna'] === 'a3'
                                    ? 'ye'
                                    : ($aspek['warna'] === 'a4'
                                        ? 'gr'
                                        : ($aspek['warna'] === 'a5'
                                            ? 'pk'
                                            : 'or')))) }}"
                            style="width:{{ $aspek['persentase'] }}%">
                            <span class="graf-val">{{ $aspek['jumlah'] }}</span>
                        </div>
                    @else
                        <div
                            style="height:100%;display:flex;align-items:center;
                                        padding-left:8px">
                            <span style="font-size:11px;color:var(--red);font-weight:700">
                                ⚠️ Belum ada
                            </span>
                        </div>
                    @endif
                </div>
                <div class="graf-pct">{{ $aspek['persentase'] }}%</div>
            </div>
        @endforeach
    </div>

    <div class="card">
            <div class="ch">
                <div class="ct">💡 Rekomendasi Keseimbangan</div>
            </div>
            @foreach ($aspekData as $aspek)
                <div class="fl ic g12 mb12">
                    <span class="ap {{ $aspek['warna'] }}" style="min-width:165px;flex-shrink:0">
                        {{ $aspek['emote'] }} {{ $aspek['name'] }}
                    </span>
                    <div class="fl ic g8">
                        @if ($aspek['jumlah'] === 0)
                            <span class="bdg brj">⚠️ Belum ada</span>
                        @elseif ($aspek['persentase'] < 10)
                            <span class="bdg bpnd">📌 Perlu ditingkatkan.</span>
                        @elseif ($aspek['persentase'] < 20)
                            <span class="bdg" style="background:#fef9c3;color:#854d0e">
                                👍 Cukup seimbang.
                            </span>
                        @else
                            <span class="bdg bok">✅ Sangat baik!</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
@endsection
