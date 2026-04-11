@extends('layout.app')

@section('page-title', 'Master Bentuk & Alat')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="g2" style="gap:14px">

  {{-- Bentuk Kegiatan --}}
  <div class="card">
    <div class="ch">
      <div>
        <div class="ct">🎭 Bentuk Kegiatan</div>
        <div class="cs">Template pilihan guru saat buat RPPH</div>
      </div>
      <button class="btn bp bsm" onclick="document.getElementById('mBentuk').classList.add('on')">+ Tambah</button>
    </div>
    <div class="fl fw g8" id="listBentuk">
      {{-- Dirender oleh JS --}}
    </div>
  </div>

  {{-- Alat & Bahan --}}
  <div class="card">
    <div class="ch">
      <div>
        <div class="ct">🔧 Alat & Bahan</div>
        <div class="cs">Alat yang tersedia di sekolah</div>
      </div>
      <button class="btn bp bsm" onclick="document.getElementById('mAlat').classList.add('on')">+ Tambah</button>
    </div>
    <div class="al alw mb16">⚠️ Hapus alat/bahan jika tidak tersedia di sekolah.</div>
    <div class="fl fw g8" id="listAlat">
      {{-- Dirender oleh JS --}}
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
var bentukData = [
  'Mewarnai','Menggambar','Melukis','Menggunting','Menempel',
  'Kolase','Finger Painting','Praktek Ibadah','Senam / Olah Raga',
  'Bercerita','Bermain Peran','Playdough'
];
var alatData = [
  'Crayon','Spidol','Pensil','Kertas HVS','Kertas Origami',
  'Gunting','Lem','Cat Air','Kuas','LKA','Sajadah'
];

function buildChips(data, containerId) {
  var container = document.getElementById(containerId);
  container.innerHTML = '';
  data.forEach(function(item) {
    var div = document.createElement('div');
    div.className = 'fl ic g8';
    div.style = 'padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px';
    div.innerHTML = '<span style="font-size:12px;font-weight:600">' + item + '</span>'
      + '<button style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none" onclick="removeChip(this, \'' + containerId + '\')">✕</button>';
    container.appendChild(div);
  });
}

function removeChip(btn, containerId) {
  btn.closest('div.fl').remove();
}

buildChips(bentukData, 'listBentuk');
buildChips(alatData, 'listAlat');
</script>
@endpush
