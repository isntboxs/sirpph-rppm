@extends('layout.app')

@section('page-title', 'Beranda')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
    <div class="sg">
        <div class="sc">
            <div class="sico gr">🧑‍🏫</div>
            <div>
                <div class="sv">4</div>
                <div class="sl">Guru Aktif</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico or">👶</div>
            <div>
                <div class="sv">24</div>
                <div class="sl">Total Siswa</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico bl">📝</div>
            <div>
                <div class="sv">12</div>
                <div class="sl">Total RPPM</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico pu">📸</div>
            <div>
                <div class="sv">48</div>
                <div class="sl">Entri Portofolio</div>
            </div>
        </div>
    </div>
    <div class="g2" style="gap:14px">
        <div class="card">
            <div class="ch">
                <div class="ct">🏫 Data Sekolah</div>
                <button class="btn bp bsm" id="btn-edit-sekolah">Kelola</button>
            </div>
            <div class="ig">
                <div class="ib">
                    <div class="ik">Nama</div>
                    <div class="iv">PAUDQu AL-AULIA</div>
                </div>
                <div class="ib">
                    <div class="ik">NPSN</div>
                    <div class="iv">69990123</div>
                </div>
                <div class="ib">
                    <div class="ik">Kepala</div>
                    <div class="iv">Ustadzah Aminah, S.Pd.</div>
                </div>
                <div class="ib">
                    <div class="ik">Tahun Ajaran</div>
                    <div class="iv">2024/2025</div>
                </div>
                <div class="ib">
                    <div class="ik">Semester Aktif</div>
                    <div class="iv">Semester 1</div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="ch">
                <div class="ct">👥 Pengguna</div>
                <a href="{{ route('kelola_pengguna') }}" class="btn bp bsm">Kelola</a>
            </div>
            <div class="fl ic g8 mb8"><span style="font-size:20px">⚙️</span><span class="fw7">Admin</span><span
                    class="fs11 tc2">(1 akun)</span></div>
            <div class="fl ic g8 mb8"><span style="font-size:20px">👑</span><span class="fw7">Kepala Sekolah</span><span
                    class="fs11 tc2">(1 akun)</span></div>
            <div class="fl ic g8 mb8"><span style="font-size:20px">🧑‍🏫</span><span class="fw7">Guru</span><span
                    class="fs11 tc2">(2 akun)</span></div>
            <div class="fl ic g8 mb8"><span style="font-size:20px">👨‍👩‍👧</span><span class="fw7">Orang Tua</span><span
                    class="fs11 tc2">(4 akun)</span></div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#btn-edit-sekolah').on('click', function() {
                $('#mSek').addClass('on');
            });
        });
    </script>
@endpush
