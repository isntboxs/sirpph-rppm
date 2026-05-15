@extends('layout.app')

@section('page-title', 'Beranda')
@section('page-subtitle', ($sekolah->name ?? '-') . ' - ' . ($taAktif?->name ?? '-'))

@section('content')

    <div
        style="background:linear-gradient(135deg,var(--g8),var(--g6));
            border-radius:var(--r);padding:24px;margin-bottom:20px;
            display:flex;align-items:center;gap:16px">
        <div
            style="width:56px;height:56px;background:rgba(255,255,255,.15);
                border-radius:50%;display:flex;align-items:center;
                justify-content:center;font-size:26px;flex-shrink:0">
            👨‍👩‍👧
        </div>
        <div>
            <div style="font-size:20px;font-weight:800;color:white">
                Halo, {{ Auth::user()->name }}!
            </div>
            <div style="font-size:13px;color:rgba(255,255,255,.7);margin-top:3px">
                Pantau perkembangan anak Anda di {{ $sekolah->name ?? '-' }}
            </div>
        </div>
    </div>

    @forelse ($dataAnak as $item)
        @php $siswa = $item['siswa']; @endphp
        <div class="card mb16">
            <div class="fl ic g12 mb16">
                <div
                    style="width:48px;height:48px;border-radius:50%;
                        background:linear-gradient(135deg,var(--g4),var(--g3));
                        display:flex;align-items:center;justify-content:center;
                        font-size:22px;flex-shrink:0">
                    {{ $siswa->jenis_kelamin === 'L' ? '👦' : '👧' }}
                </div>
                <div>
                    <div class="fw7" style="font-size:15px">{{ $siswa->name }}</div>
                    <div class="fs11 tc2 mt2">
                        {{ $siswa->kelas?->name ?? '-' }} •
                        {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </div>
                </div>
            </div>

            <div class="ig mb16">
                <div class="ib">
                    <div class="ik">Portofolio</div>
                    <div class="iv">{{ $item['porto_count'] }} Entri</div>
                </div>
                <div class="ib">
                    <div class="ik">RPPM Aktif</div>
                    <div class="iv">{{ $item['rppm_aktif'] }}</div>
                </div>
                <div class="ib">
                    <div class="ik">Komentar Saya</div>
                    <div class="iv">{{ $item['komentar_saya'] }}</div>
                </div>
            </div>

            <div class="fl g8">
                <button type="button" class="btn bp bsm"
                    onclick="window.open('/portofolio-anak/cetak/{{ $siswa->id }}', '_blank')">
                    🖨️ Cetak Laporan
                </button>
            </div>
        </div>
    @empty
        <div class="card emp">
            <div class="ei">👶</div>
            <h3>Data anak belum terdaftar</h3>
            <p>Hubungi pihak sekolah untuk mendaftarkan anak Anda.</p>
        </div>
    @endforelse

@endsection
