@extends('layout.app')

@section('page-title', 'Kumpulan Kegiatan')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="card mb16">
  <div class="ch">
    <div>
      <div class="ct">🗂️ Kumpulan Kegiatan</div>
      <div class="cs">Terkunci otomatis setelah dipakai di 3 tahun ajaran berbeda.</div>
    </div>
    <button class="btn bp bsm" onclick="document.getElementById('mKeg').classList.add('on')">+ Usulkan Kegiatan Baru</button>
  </div>

  <div class="al ali mb16">
    ℹ️ <strong>Cara kerja penguncian:</strong> Jika kegiatan <em>sama persis</em> sudah digunakan di
    <strong>3 tahun ajaran berbeda</strong>, kegiatan terkunci permanen.
  </div>

  <div class="fb">
    <input type="text" placeholder="🔍 Cari kegiatan..."/>
    <select>
      <option>Semua Tema</option>
      <option>Aku, Makhluq Allah</option>
      <option>Tanah Airku</option>
    </select>
    <select>
      <option>Semua Bentuk</option>
      <option>Mewarnai</option>
      <option>Kolase</option>
    </select>
    <select>
      <option>Semua Status</option>
      <option>✅ Aktif</option>
      <option>🔒 Terkunci</option>
    </select>
  </div>

  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:12px">

    {{-- Kegiatan Aktif --}}
    <div class="kc">
      <div class="fl jb ic mb8">
        <div class="kn">Menebalkan Nama Sendiri</div>
        <span class="bdg bok">✅</span>
      </div>
      <div class="kd">Anak menebalkan huruf nama sendiri pada lembar kerja yang tersedia guru.</div>
      <div class="fl fw g8 mb8">
        <span class="ap a3">🧠 Kognitif</span>
        <span class="ap a4">💬 Bahasa</span>
        <span class="ap a2">🏃 Fisik Motorik</span>
      </div>
      <div class="fs11 tc2 mb8">🎭 Menggambar | 🔧 LKA, Pensil</div>
      <div class="fs11 tc2 mb4">📅 Dipakai di: 2023/2024, 2024/2025</div>
      <div class="pw mb4"><div class="pb or" style="width:66%"></div></div>
      <div class="fs11 tc2">2/3 tahun ajaran</div>
    </div>

    {{-- Kegiatan Terkunci --}}
    <div class="kc lck">
      <div class="fl jb ic mb8">
        <div class="kn">🔒 Kolase Tulisan "Terima Kasih Ya Allah"</div>
        <span class="bdg blk">Terkunci</span>
      </div>
      <div class="kd">Anak menempel potongan kertas origami pada pola tulisan yang disediakan guru.</div>
      <div class="fl fw g8 mb8">
        <span class="ap a1">🕌 Nilai Agama</span>
        <span class="ap a6">🎨 Seni</span>
      </div>
      <div class="fs11 tc2 mb8">🎭 Kolase | 🔧 Kertas Origami, Lem, Gunting</div>
      <div class="fs11 tc2 mb4">📅 Dipakai di: 2022/2023, 2023/2024, 2024/2025</div>
      <div class="pw mb4"><div class="pb pk" style="width:100%"></div></div>
      <div class="fs11" style="color:var(--red)">3/3 tahun ajaran — TERKUNCI PERMANEN</div>
      <div class="al ale mt8">🔒 Kegiatan ini sudah terkunci. Anda perlu membuat kegiatan baru.</div>
      <div class="rek-box">
        <div class="rek-title">💡 Rekomendasi Kegiatan Lain di Tema yang Sama:</div>
        <div class="rek-item">
          <strong>Finger Painting Anggota Tubuh</strong><br>
          <span class="fs11 tc2">Finger Painting — 1/3 tahun</span>
        </div>
        <div class="rek-item">
          <strong>Mewarnai Gambar Anggota Tubuh</strong><br>
          <span class="fs11 tc2">Mewarnai — 2/3 tahun</span>
        </div>
      </div>
    </div>

    {{-- Kegiatan Aktif 2 --}}
    <div class="kc">
      <div class="fl jb ic mb8">
        <div class="kn">Finger Painting Anggota Tubuh</div>
        <span class="bdg bok">✅</span>
      </div>
      <div class="kd">Anak membuat jejak tangan dan kaki menggunakan cat air di kertas HVS.</div>
      <div class="fl fw g8 mb8">
        <span class="ap a2">🏃 Fisik Motorik</span>
        <span class="ap a6">🎨 Seni</span>
        <span class="ap a5">❤️ Sosial Emosional</span>
      </div>
      <div class="fs11 tc2 mb8">🎭 Finger Painting | 🔧 Cat Air, Kertas HVS</div>
      <div class="fs11 tc2 mb4">📅 Dipakai di: 2023/2024</div>
      <div class="pw mb4"><div class="pb gr" style="width:33%"></div></div>
      <div class="fs11 tc2">1/3 tahun ajaran</div>
    </div>

  </div>
</div>
@endsection
