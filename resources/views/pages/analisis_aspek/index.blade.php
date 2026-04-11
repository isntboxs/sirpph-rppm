@extends('layout.app')

@section('page-title', 'Analisis Aspek Perkembangan')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="card mb16">
  <div class="ch">
    <div>
      <div class="ct">📊 Distribusi Aspek — Kelas A</div>
      <div class="cs">Dari 4 RPPM disetujui — 32 slot kegiatan</div>
    </div>
  </div>

  <div class="graf-bar">
    <div class="graf-label"><span class="ap a1">🕌 Nilai Agama</span></div>
    <div class="graf-wrap"><div class="graf-fill pb gr" style="width:28%"><span class="graf-val">9</span></div></div>
    <div class="graf-pct">28%</div>
  </div>
  <div class="graf-bar">
    <div class="graf-label"><span class="ap a2">🏃 Fisik Motorik</span></div>
    <div class="graf-wrap"><div class="graf-fill pb bl" style="width:22%"><span class="graf-val">7</span></div></div>
    <div class="graf-pct">22%</div>
  </div>
  <div class="graf-bar">
    <div class="graf-label"><span class="ap a3">🧠 Kognitif</span></div>
    <div class="graf-wrap"><div class="graf-fill pb ye" style="width:19%"><span class="graf-val">6</span></div></div>
    <div class="graf-pct">19%</div>
  </div>
  <div class="graf-bar">
    <div class="graf-label"><span class="ap a4">💬 Bahasa</span></div>
    <div class="graf-wrap"><div class="graf-fill pb gr" style="width:16%"><span class="graf-val">5</span></div></div>
    <div class="graf-pct">16%</div>
  </div>
  <div class="graf-bar">
    <div class="graf-label"><span class="ap a5">❤️ Sosial Emosional</span></div>
    <div class="graf-wrap"><div class="graf-fill pb pk" style="width:9%"><span class="graf-val">3</span></div></div>
    <div class="graf-pct">9%</div>
  </div>
  <div class="graf-bar">
    <div class="graf-label"><span class="ap a6">🎨 Seni</span></div>
    <div class="graf-wrap"><div class="graf-fill pb or" style="width:6%"><span class="graf-val">2</span></div></div>
    <div class="graf-pct">6%</div>
  </div>
</div>

<div class="card">
  <div class="ch">
    <div class="ct">💡 Rekomendasi Keseimbangan</div>
  </div>
  <div class="fl ic g12 mb12">
    <span class="ap a1" style="min-width:165px;flex-shrink:0">🕌 Nilai Agama</span>
    <span class="fs11" style="color:var(--g6)">✅ Sangat baik!</span>
  </div>
  <div class="fl ic g12 mb12">
    <span class="ap a2" style="min-width:165px;flex-shrink:0">🏃 Fisik Motorik</span>
    <span class="fs11" style="color:var(--g5)">👍 Cukup seimbang.</span>
  </div>
  <div class="fl ic g12 mb12">
    <span class="ap a3" style="min-width:165px;flex-shrink:0">🧠 Kognitif</span>
    <span class="fs11" style="color:var(--g5)">👍 Cukup seimbang.</span>
  </div>
  <div class="fl ic g12 mb12">
    <span class="ap a4" style="min-width:165px;flex-shrink:0">💬 Bahasa</span>
    <span class="fs11" style="color:var(--g5)">👍 Cukup seimbang.</span>
  </div>
  <div class="fl ic g12 mb12">
    <span class="ap a5" style="min-width:165px;flex-shrink:0">❤️ Sosial Emosional</span>
    <span class="fs11" style="color:var(--acc2)">📌 Perlu ditingkatkan.</span>
  </div>
  <div class="fl ic g12 mb12">
    <span class="ap a6" style="min-width:165px;flex-shrink:0">🎨 Seni</span>
    <span class="fs11" style="color:var(--acc2)">📌 Perlu ditingkatkan.</span>
  </div>
</div>
@endsection
