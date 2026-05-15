@extends('layout.app')

@section('page-title', 'Beranda')
@section('page-subtitle', ($sekolah->name ?? '-') . ' - ' . ($taAktif?->name ?? '-'))

@section('content')

    <div class="sg mb16">
        <div class="sc">
            <div class="sico or">⏳</div>
            <div>
                <div class="sv">{{ $stats['rppm_menunggu'] }}</div>
                <div class="sl">RPPM Menunggu</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico bl">📄</div>
            <div>
                <div class="sv">{{ $stats['rpph_menunggu'] }}</div>
                <div class="sl">RPPH Menunggu</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico pu">🗂️</div>
            <div>
                <div class="sv">{{ $stats['kegiatan_menunggu'] }}</div>
                <div class="sl">Kegiatan Menunggu</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico pk" style="background:#fce7f3">🔒</div>
            <div>
                <div class="sv">{{ $stats['kegiatan_terkunci'] }}</div>
                <div class="sl">Kegiatan Terkunci</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico gr">✅</div>
            <div>
                <div class="sv">{{ $stats['rppm_disetujui'] }}</div>
                <div class="sl">RPPM Disetujui</div>
            </div>
        </div>
    </div>

    <div class="g2" style="gap:14px;align-items:start">

        {{-- RPPM Perlu Validasi --}}
        <div class="card">
            <div class="ch mb12">
                <div class="ct">📋 RPPM Perlu Validasi</div>
                <a href="{{ route('validasi_rppm') }}" class="btn bp bsm">Lihat Semua</a>
            </div>

            @forelse ($rppmMenunggu as $rppm)
                <div class="rc2 mb8">
                    <div class="rh">
                        <div>
                            <div class="rw">
                                Mgg ke-{{ $rppm->minggu_ke }} • {{ $rppm->guru->name }}
                            </div>
                            <div class="rn">{{ $rppm->subTema->tema->name }}</div>
                            <div class="rs">{{ $rppm->subTema->name }}</div>
                        </div>
                        <span class="bdg bpnd">⏳ Menunggu</span>
                    </div>
                </div>
            @empty
                <div class="emp" style="padding:24px 0">
                    <div class="ei" style="font-size:28px">✅</div>
                    <div class="fs11 tc2">Tidak ada RPPM yang menunggu</div>
                </div>
            @endforelse

            @if ($rppmMenunggu->hasPages())
                {{ $rppmMenunggu->links() }}
            @endif
        </div>

        <div class="card">
            <div class="ch mb12">
                <div class="ct">🔒 Kegiatan Terkunci ({{ $kegiatanTerkunci->count() }})</div>
                <a href="{{ route('validasi_kegiatan') }}" class="btn bp bsm">Lihat Semua</a>
            </div>

            @forelse ($kegiatanTerkunci as $kegiatan)
                <div class="kc lck mb8">
                    <div class="fl jb ic mb4">
                        <div class="kn" style="font-size:12.5px">
                            🔒 {{ $kegiatan->name }}
                        </div>
                        <span class="bdg blk">Terkunci</span>
                    </div>
                    <div class="fs11 tc2 mb4">
                        📚 {{ $kegiatan->tema->name }}
                    </div>
                    <div class="fs11 mb4" style="color:var(--red)">
                        📅 Dipakai di: {{ ($tahunPerKegiatan[$kegiatan->id] ?? collect())->join(', ') }}
                    </div>
                    <div class="al ali" style="font-size:11px;padding:6px 10px">
                        ℹ️ Kegiatan terkunci karena sudah dipakai di
                        <strong>{{ $kegiatan->jumlah_tahun_dipakai }} tahun ajaran berbeda</strong>.
                        Guru perlu membuat kegiatan baru.
                    </div>
                </div>
            @empty
                <div class="emp" style="padding:24px 0">
                    <div class="ei" style="font-size:28px">🎉</div>
                    <div class="fs11 tc2">Tidak ada kegiatan yang terkunci</div>
                </div>
            @endforelse
        </div>

    </div>

@endsection
