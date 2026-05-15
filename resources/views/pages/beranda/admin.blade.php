@extends('layout.app')

@section('page-title', 'Beranda')
@section('page-subtitle', ($sekolah->name ?? '-') . ' - ' . ($taAktif?->name ?? '-'))

@section('content')

    {{-- Stats --}}
    <div class="sg mb16">
        <div class="sc">
            <div class="sico gr">🧑‍🏫</div>
            <div>
                <div class="sv">{{ $stats['guru_aktif'] }}</div>
                <div class="sl">Guru Aktif</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico or">👶</div>
            <div>
                <div class="sv">{{ $stats['total_siswa'] }}</div>
                <div class="sl">Total Siswa</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico bl">📝</div>
            <div>
                <div class="sv">{{ $stats['rppm_disetujui'] }}</div>
                <div class="sl">RPPM Disetujui</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico pu">📸</div>
            <div>
                <div class="sv">{{ $stats['total_porto'] }}</div>
                <div class="sl">Entri Portofolio</div>
            </div>
        </div>
    </div>

    <div class="g2" style="gap:14px">

        {{-- Data Sekolah --}}
        <div class="card">
            <div class="ch">
                <div class="ct">🏫 Data Sekolah</div>
                <a href="{{ route('data_sekolah') }}" class="btn bp bsm">Kelola</a>
            </div>
            <div class="ig">
                <div class="ib">
                    <div class="ik">Nama</div>
                    <div class="iv">{{ $sekolah->name }}</div>
                </div>
                <div class="ib">
                    <div class="ik">NPSN</div>
                    <div class="iv">{{ $sekolah->npsn }}</div>
                </div>
                <div class="ib">
                    <div class="ik">Kepala</div>
                    <div class="iv">{{ $sekolah->kepala }}</div>
                </div>
                <div class="ib">
                    <div class="ik">Tahun Ajaran</div>
                    <div class="iv">{{ $sekolah->ta }}</div>
                </div>
                <div class="ib">
                    <div class="ik">Semester Aktif</div>
                    <div class="iv">Semester {{ $sekolah->semester }}</div>
                </div>
            </div>
        </div>

        {{-- Pengguna --}}
        <div class="card">
            <div class="ch">
                <div class="ct">👥 Pengguna</div>
                <a href="{{ route('kelola_pengguna') }}" class="btn bp bsm">Kelola</a>
            </div>
            <div class="fl ic g8 mb8">
                <span style="font-size:20px">⚙️</span>
                <span class="fw7">Admin</span>
                <span class="fs11 tc2">({{ $penggunaSummary['admin'] }} akun)</span>
            </div>
            <div class="fl ic g8 mb8">
                <span style="font-size:20px">👑</span>
                <span class="fw7">Kepala Sekolah</span>
                <span class="fs11 tc2">({{ $penggunaSummary['kepala'] }} akun)</span>
            </div>
            <div class="fl ic g8 mb8">
                <span style="font-size:20px">🧑‍🏫</span>
                <span class="fw7">Guru</span>
                <span class="fs11 tc2">({{ $penggunaSummary['guru'] }} akun)</span>
            </div>
            <div class="fl ic g8">
                <span style="font-size:20px">👨‍👩‍👧</span>
                <span class="fw7">Orang Tua</span>
                <span class="fs11 tc2">({{ $penggunaSummary['ortu'] }} akun)</span>
            </div>
        </div>

    </div>

@endsection
