@extends('layout.app')

@section('page-title', 'Validasi Kegiatan')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="al ali mb16">
  ℹ️ Kegiatan terkunci setelah digunakan di <strong>3 tahun ajaran berbeda</strong>. Guru perlu mengusulkan kegiatan baru.
</div>

{{-- Menunggu Validasi --}}
<div class="card mb16">
  <div class="ch">
    <div class="ct">🕐 Menunggu Validasi (1)</div>
  </div>
  <div class="kc">
    <div class="fl jb ic mb8">
      <div class="kn">Melukis Masjid Sederhana dengan Cat Air</div>
      <span class="bdg bpnd">⏳ Pending</span>
    </div>
    <div class="kd">Anak melukis gambar masjid menggunakan cat air di atas kertas HVS dengan bimbingan guru.</div>
    <div class="fl fw g8 mb8">
      <span class="ap a1">🕌 Nilai Agama</span>
      <span class="ap a6">🎨 Seni</span>
      <span class="ap a2">🏃 Fisik Motorik</span>
    </div>
    <div class="fs11 tc2 mb8">🎭 Bentuk: Melukis | 🔧 Alat: Cat Air, Kuas, Kertas HVS</div>
    <div class="fs11 tc2 mb8">Diusulkan: Ustadzah Siti Rahmah</div>
    <div class="fl g8 mt8">
      <button class="btn bp bsm" onclick="showToast('✅ Kegiatan disetujui & ditambahkan ke kumpulan')">✅ Setujui & Tambah ke Kumpulan</button>
      <button class="btn bd bsm" onclick="showToast('❌ Kegiatan ditolak')">❌ Tolak</button>
    </div>
  </div>
</div>

{{-- Kegiatan Terkunci --}}
<div class="card mb16">
  <div class="ch">
    <div class="ct">🔒 Kegiatan Terkunci (2)</div>
  </div>
  <div class="kc lck">
    <div class="fl jb ic mb8">
      <div class="kn">🔒 Kolase Tulisan "Terima Kasih Ya Allah"</div>
      <span class="bdg blk">Terkunci</span>
    </div>
    <div class="fs11 tc2 mb4">🎭 Kolase | Tema: Aku, Makhluq Allah</div>
    <div class="fs11" style="color:var(--red)">Dipakai di: 2022/2023 → 2023/2024 → 2024/2025</div>
    <div class="al alw mt8">🔒 Sudah digunakan di <strong>3 tahun ajaran</strong> dan terkunci permanen.</div>
  </div>
  <div class="kc lck mt8">
    <div class="fl jb ic mb8">
      <div class="kn">🔒 Mewarnai Tulisan "Allah"</div>
      <span class="bdg blk">Terkunci</span>
    </div>
    <div class="fs11 tc2 mb4">🎭 Mewarnai | Tema: Aku, Makhluq Allah</div>
    <div class="fs11" style="color:var(--red)">Dipakai di: 2022/2023 → 2023/2024 → 2024/2025</div>
    <div class="al alw mt8">🔒 Sudah digunakan di <strong>3 tahun ajaran</strong> dan terkunci permanen.</div>
  </div>
</div>

{{-- Semua Kumpulan Kegiatan --}}
<div class="card">
  <div class="ch">
    <div class="ct">✅ Semua Kumpulan Kegiatan (15)</div>
  </div>
  <div class="tw">
    <table>
      <thead>
        <tr>
          <th>Nama Kegiatan</th>
          <th>Bentuk</th>
          <th>Aspek</th>
          <th>Dipakai di Tahun</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><strong>Kolase Tulisan "Terima Kasih Ya Allah"</strong></td>
          <td>Kolase</td>
          <td><span class="ap a1">🕌</span> <span class="ap a6">🎨</span></td>
          <td>
            2022/2023, 2023/2024, 2024/2025
            <div class="pw mt8"><div class="pb pk" style="width:100%"></div></div>
            <div class="fs11">3/3 — TERKUNCI</div>
          </td>
          <td><span class="bdg blk">🔒 Terkunci</span></td>
        </tr>
        <tr>
          <td><strong>Menebalkan Nama Sendiri</strong></td>
          <td>Menggambar</td>
          <td><span class="ap a3">🧠</span> <span class="ap a4">💬</span></td>
          <td>
            2023/2024, 2024/2025
            <div class="pw mt8"><div class="pb or" style="width:66%"></div></div>
            <div class="fs11 tc2">2/3 tahun ajaran</div>
          </td>
          <td><span class="bdg bok">✅</span></td>
        </tr>
        <tr>
          <td><strong>Finger Painting Anggota Tubuh</strong></td>
          <td>Finger Painting</td>
          <td><span class="ap a2">🏃</span> <span class="ap a6">🎨</span></td>
          <td>
            2023/2024
            <div class="pw mt8"><div class="pb gr" style="width:33%"></div></div>
            <div class="fs11 tc2">1/3 tahun ajaran</div>
          </td>
          <td><span class="bdg bok">✅</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
