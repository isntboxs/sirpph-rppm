<aside class="sb">
  <div class="sbh">
    <div class="sbb">
      <div class="bi">📚</div>
      <div><h2>SiRPPH</h2><p>PAUDQu AL-AULIA</p></div>
    </div>
  </div>
  <div class="sbu">
    <div class="sbur">
      <div class="sbav" style="background:var(--g5)">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
      <div>
        <div class="sbun">{{ auth()->user()->name ?? 'Admin' }}</div>
        <div class="sbrl">{{ auth()->user()->role ?? 'Operator' }}</div>
      </div>
    </div>
  </div>
  <nav class="sbn">
    <div class="sns">Menu Utama</div>
    <a class="ni {{ request()->routeIs('beranda') ? 'on' : '' }}" href="{{ route('beranda') }}">
      <span class="nic">🏠</span> Beranda
    </a>
    <a class="ni {{ request()->routeIs('kelola_pengguna') ? 'on' : '' }}" href="{{ route('kelola_pengguna') }}">
      <span class="nic">👥</span> Kelola Pengguna
    </a>
    <a class="ni {{ request()->routeIs('data_siswa') ? 'on' : '' }}" href="{{ route('data_siswa') }}">
      <span class="nic">👶</span> Data Siswa
    </a>
    <a class="ni {{ request()->routeIs('tahun_ajaran') ? 'on' : '' }}" href="{{ route('tahun_ajaran') }}">
      <span class="nic">📅</span> Tahun Ajaran
    </a>
    <a class="ni {{ request()->routeIs('data_sekolah') ? 'on' : '' }}" href="{{ route('data_sekolah') }}">
      <span class="nic">🏫</span> Data Sekolah
    </a>

    <div class="sns">Kepala Sekolah</div>
    <a class="ni {{ request()->routeIs('prosem') ? 'on' : '' }}" href="{{ route('prosem') }}">
      <span class="nic">📊</span> PROSEM
    </a>
    <a class="ni {{ request()->routeIs('kelola_tema') ? 'on' : '' }}" href="{{ route('kelola_tema') }}">
      <span class="nic">📚</span> Kelola Tema
    </a>
    <a class="ni {{ request()->routeIs('master_bentuk_alat') ? 'on' : '' }}" href="{{ route('master_bentuk_alat') }}">
      <span class="nic">🔧</span> Master Bentuk & Alat
    </a>
    <a class="ni {{ request()->routeIs('validasi_rppm') ? 'on' : '' }}" href="{{ route('validasi_rppm') }}">
      <span class="nic">✅</span> Validasi RPPM <span class="nbg">3</span>
    </a>
    <a class="ni {{ request()->routeIs('validasi_rpph') ? 'on' : '' }}" href="{{ route('validasi_rpph') }}">
      <span class="nic">📄</span> Validasi RPPH <span class="nbg">2</span>
    </a>
    <a class="ni {{ request()->routeIs('validasi_kegiatan') ? 'on' : '' }}" href="{{ route('validasi_kegiatan') }}">
      <span class="nic">🗂️</span> Validasi Kegiatan <span class="nbg">1</span>
    </a>
    <a class="ni {{ request()->routeIs('monitoring_guru') ? 'on' : '' }}" href="{{ route('monitoring_guru') }}">
      <span class="nic">📈</span> Monitoring Guru
    </a>

    <div class="sns">Guru</div>
    <a class="ni {{ request()->routeIs('kumpulan_kegiatan') ? 'on' : '' }}" href="{{ route('kumpulan_kegiatan') }}">
      <span class="nic">🗂️</span> Kumpulan Kegiatan
    </a>
    <a class="ni {{ request()->routeIs('rppm') ? 'on' : '' }}" href="{{ route('rppm') }}">
      <span class="nic">📋</span> Buat & Kelola RPPM
    </a>
    <a class="ni {{ request()->routeIs('rpph') ? 'on' : '' }}" href="{{ route('rpph') }}">
      <span class="nic">📅</span> Buat & Kelola RPPH
    </a>
    <a class="ni {{ request()->routeIs('portofolio_siswa') ? 'on' : '' }}" href="{{ route('portofolio_siswa') }}">
      <span class="nic">📸</span> Portofolio Siswa
    </a>
    <a class="ni {{ request()->routeIs('analisis_aspek') ? 'on' : '' }}" href="{{ route('analisis_aspek') }}">
      <span class="nic">📊</span> Analisis Aspek
    </a>

    <div class="sns">Orang Tua</div>
    <a class="ni {{ request()->routeIs('ortu_rppm') ? 'on' : '' }}" href="{{ route('ortu_rppm') }}">
      <span class="nic">📝</span> Lihat RPPM
    </a>
    <a class="ni {{ request()->routeIs('ortu_rpph') ? 'on' : '' }}" href="{{ route('ortu_rpph') }}">
      <span class="nic">📄</span> Lihat RPPH
    </a>
    <a class="ni {{ request()->routeIs('ortu_porto') ? 'on' : '' }}" href="{{ route('ortu_porto') }}">
      <span class="nic">📸</span> Portofolio Anak
    </a>
  </nav>
  <div class="sbf">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="blo">🚪 Keluar</button>
    </form>
  </div>
</aside>
