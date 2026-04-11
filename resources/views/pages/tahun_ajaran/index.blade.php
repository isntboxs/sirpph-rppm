@extends('layout.app')

@section('page-title', 'Tahun Ajaran')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="card">
  <div class="ch">
    <div class="ct">📅 Tahun Ajaran</div>
    <button class="btn bp bsm">+ Tambah</button>
  </div>
  <div class="tw">
    <table>
      <thead>
        <tr>
          <th>Tahun Ajaran</th>
          <th>Semester</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><strong>2024/2025</strong></td>
          <td>Semester 1</td>
          <td><span class="bdg bok">🟢 Aktif</span></td>
          <td><span class="fs11 tc2">Aktif</span></td>
        </tr>
        <tr>
          <td><strong>2023/2024</strong></td>
          <td>Semester 2</td>
          <td><span class="bdg bdr">⚪ Arsip</span></td>
          <td><button class="btn bp bxs">Set Aktif</button></td>
        </tr>
        <tr>
          <td><strong>2022/2023</strong></td>
          <td>Semester 2</td>
          <td><span class="bdg bdr">⚪ Arsip</span></td>
          <td><button class="btn bp bxs">Set Aktif</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
