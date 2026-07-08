<aside class="sb">
    <div class="sbh">
        <div class="sbb">
            <div class="bi">
                <img src="{{ asset('logo.jpeg') }}" alt="Logo" style="width:40px; height:40px; object-fit:cover;">
            </div>
            <div>
                <h2>SIPENAQI</h2>
                <p>{{ \App\Models\DataSekolah::getData()?->name }}</p>
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
        <div class="sns">Navigasi Utama</div>
        <a class="ni" href="{{ route('beranda') }}">Beranda</a>
        @if (Auth::user()->isAdmin())
            <a class="ni" href="{{ route('kelola_pengguna') }}">Kelola Pengguna</a>
        @endif

        {{-- Admin --}}
        @if (Auth::user()->isAdmin())
            <div class="sns">Konten Sistem</div>
            <a class="ni" href="{{ route('kelola_tema') }}">Tema & Subtema</a>
            <a class="ni" href="{{ route('rppm') }}">Input RPP</a>

            <div class="sns">Administrasi Sekolah</div>
            <a class="ni" href="{{ route('tahun_ajaran') }}">Tahun Ajaran</a>
            <a class="ni" href="{{ route('data_sekolah') }}">Data Sekolah</a>
        @endif

        {{-- Kepala Sekolah --}}
        @if (Auth::user()->isKepalaSekolah())
            <div class="sns">Validasi Dokumen</div>
            <a class="ni" href="{{ route('validasi_rppm') }}">Validasi RPP</a>
            <a class="ni" href="{{ route('validasi_laporan') }}">Validasi Laporan RPP</a>
            <a class="ni" href="{{ route('validasi_tema') }}">Validasi Tema & Subtema</a>
        @endif

        {{-- Guru --}}
        @if (Auth::user()->isGuru())
            <div class="sns">Pembelajaran</div>
            <a class="ni" href="{{ route('rppm') }}">Buat RPP</a>
            <a class="ni" href="{{ route('laporan_rpp') }}">Laporan RPP</a>
            <a class="ni" href="{{ route('kelola_tema') }}">Tema & Subtema</a>
        @endif
    </nav>
    <div class="sbf">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="blo">Keluar</button>
        </form>
    </div>
</aside>
