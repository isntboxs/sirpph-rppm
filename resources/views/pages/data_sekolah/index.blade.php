@extends('layout.app')

@section('page-title', 'Data Sekolah')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="card">
  <div class="ch">
    <div class="ct">🏫 Data Sekolah</div>
    <button class="btn bp bsm" onclick="document.getElementById('mSek').classList.add('on')">✏️ Edit</button>
  </div>
  <div class="ig">
    <div class="ib"><div class="ik">Nama Sekolah</div><div class="iv">PAUDQu AL-AULIA</div></div>
    <div class="ib"><div class="ik">NPSN</div><div class="iv">69990123</div></div>
    <div class="ib"><div class="ik">Kepala Sekolah</div><div class="iv">Ustadzah Aminah, S.Pd.</div></div>
    <div class="ib"><div class="ik">Telepon</div><div class="iv">0812-3456-7890</div></div>
    <div class="ib"><div class="ik">Tahun Ajaran</div><div class="iv">2024/2025</div></div>
    <div class="ib"><div class="ik">Semester Aktif</div><div class="iv">Semester 1</div></div>
  </div>
  <div class="ib mt16" style="border-left-color:var(--acc)">
    <div class="ik">Alamat</div>
    <div class="iv">Jl. Al-Quran No.12, Serang, Banten</div>
  </div>
</div>
@endsection
