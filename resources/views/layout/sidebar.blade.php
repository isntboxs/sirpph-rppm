<aside class="sb">
    <div class="sbh">
        <div class="sbb">
            <div class="bi">📚</div>
            <div>
                <h2>SiRPPH</h2>
                <p>PAUDQu AL-AULIA</p>
            </div>
        </div>
    </div>
    <div class="sbu">
        <div class="sbur">
            <div class="sbav" style="background:var(--g5)">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="sbun">{{ Auth::user()->name }}</div>
                <div class="sbrl">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
        </div>
    </div>
    <nav class="sbn">
        <div class="sns">Menu Utama</div>
        <a class="ni" href="{{ route('beranda') }}"><span class="nic">🏠</span> Beranda</a>

        {{-- Admin --}}
        @if (Auth::user()->isAdmin())
            <a class="ni" href="{{ route('kelola_pengguna') }}"><span class="nic">👥</span> Kelola Pengguna</a>
            <a class="ni" href="{{ route('data_siswa') }}"><span class="nic">👶</span> Data Siswa</a>
            <a class="ni" href="{{ route('tahun_ajaran') }}"><span class="nic">📅</span> Tahun Ajaran</a>
            <a class="ni" href="{{ route('data_sekolah') }}"><span class="nic">🏫</span> Data Sekolah</a>
        @endif

        {{-- Kepala Sekolah --}}
        @if (Auth::user()->isKepalaSekolah())
            <div class="sns">Kepala Sekolah</div>
            <a class="ni" href="{{ route('prosem') }}"><span class="nic">📊</span> PROSEM</a>
            <a class="ni" href="{{ route('kelola_tema') }}"><span class="nic">📚</span> Kelola Tema</a>
            <a class="ni" href="{{ route('master_bentuk_alat') }}"><span class="nic">🔧</span> Bentuk &
                Alat</a>
            <a class="ni" href="{{ route('validasi_rppm') }}"><span class="nic">✅</span> Validasi RPPM <span
                    class="nbg">3</span></a>
            <a class="ni" href="{{ route('validasi_rpph') }}"><span class="nic">📄</span> Validasi RPPH <span
                    class="nbg">2</span></a>
            <a class="ni" href="{{ route('validasi_kegiatan') }}"><span class="nic">🗂️</span> Validasi Kegiatan
                <span class="nbg">1</span></a>
            <a class="ni" href="{{ route('monitoring_guru') }}"><span class="nic">📈</span> Monitoring Guru</a>
        @endif

        {{-- Guru --}}
        @if (Auth::user()->isGuru())
            <div class="sns">Guru</div>
            <a class="ni" href="{{ route('kumpulan_kegiatan') }}"><span class="nic">🗂️</span> Kumpulan
                Kegiatan</a>
            <a class="ni" href="{{ route('rppm') }}"><span class="nic">📋</span> Buat & Kelola RPPM</a>
            <a class="ni" href="{{ route('rpph') }}"><span class="nic">📅</span> Buat & Kelola RPPH</a>
            <a class="ni" href="{{ route('portofolio_siswa') }}"><span class="nic">📸</span> Portofolio
                Siswa</a>
            <a class="ni" href="{{ route('analisis_aspek') }}"><span class="nic">📊</span> Analisis Aspek</a>
        @endif

        {{-- Orang Tua --}}
        @if (Auth::user()->isOrtu())
            <div class="sns">Orang Tua</div>
            <a class="ni" href="{{ route('ortu_rppm') }}"><span class="nic">📝</span> Lihat RPPM</a>
            <a class="ni" href="{{ route('ortu_rpph') }}"><span class="nic">📄</span> Lihat RPPH</a>
            <a class="ni" href="{{ route('ortu_porto') }}"><span class="nic">📸</span> Portofolio Anak</a>
        @endif
    </nav>
    <div class="sbf">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="blo">🚪 Keluar</button>
        </form>
    </div>
</aside>
