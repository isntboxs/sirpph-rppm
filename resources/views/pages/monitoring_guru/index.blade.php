@extends('layout.app')

@section('page-title', 'Monitoring Guru')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="card">
  <div class="ch">
    <div class="ct">📈 Monitoring Semua Guru</div>
  </div>

  {{-- Guru 1 --}}
  <div class="card mb16" style="border-color:var(--g2)">
    <div class="fl ic g12 mb16">
      <div style="width:50px;height:50px;background:var(--g6);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:20px">S</div>
      <div>
        <div class="fw7">Ustadzah Siti Rahmah</div>
        <div class="fs11 tc2">Kelas A • 0812-1111-2222</div>
      </div>
    </div>
    <div class="g3 mb16">
      <div class="ib"><div class="ik">Total RPPM</div><div class="iv">6</div></div>
      <div class="ib"><div class="ik">RPPM Disetujui</div><div class="iv" style="color:var(--g6)">4</div></div>
      <div class="ib"><div class="ik">Total RPPH</div><div class="iv">18</div></div>
      <div class="ib"><div class="ik">Portofolio</div><div class="iv">24 entri</div></div>
      <div class="ib"><div class="ik">RPPM Pending</div><div class="iv" style="color:var(--acc2)">2</div></div>
      <div class="ib"><div class="ik">Progress</div><div class="iv">67%</div></div>
    </div>
    <div class="pw"><div class="pb gr" style="width:67%"></div></div>
  </div>

  {{-- Guru 2 --}}
  <div class="card mb16" style="border-color:var(--g2)">
    <div class="fl ic g12 mb16">
      <div style="width:50px;height:50px;background:var(--g6);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:20px">D</div>
      <div>
        <div class="fw7">Ustadzah Dewi Nursanti</div>
        <div class="fs11 tc2">Kelas B • 0813-3333-4444</div>
      </div>
    </div>
    <div class="g3 mb16">
      <div class="ib"><div class="ik">Total RPPM</div><div class="iv">5</div></div>
      <div class="ib"><div class="ik">RPPM Disetujui</div><div class="iv" style="color:var(--g6)">4</div></div>
      <div class="ib"><div class="ik">Total RPPH</div><div class="iv">15</div></div>
      <div class="ib"><div class="ik">Portofolio</div><div class="iv">20 entri</div></div>
      <div class="ib"><div class="ik">RPPM Pending</div><div class="iv" style="color:var(--acc2)">1</div></div>
      <div class="ib"><div class="ik">Progress</div><div class="iv">80%</div></div>
    </div>
    <div class="pw"><div class="pb gr" style="width:80%"></div></div>
  </div>

</div>
@endsection
