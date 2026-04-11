@extends('layout.app')

@section('page-title', 'Buat & Kelola RPPM')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="tabs">
  <button class="tbn on" id="tab-btn-daftar" onclick="switchRppmTab('daftar')">📋 Daftar RPPM (6)</button>
  <button class="tbn" id="tab-btn-baru" onclick="switchRppmTab('baru')">+ Buat RPPM Baru</button>
</div>

{{-- Panel: Daftar RPPM --}}
<div id="panel-daftar">
  <div class="rc2">
    <div class="rh">
      <div>
        <div class="rw">Mgg ke-1 — Sem 1 — 2024/2025</div>
        <div class="rn">Aku, Makhluq Allah</div>
        <div class="rs">Allah Tuhanku</div>
      </div>
      <span class="bdg bok">✅ Disetujui</span>
    </div>
    <div class="ract">
      <button class="btn bo bsm">👁️ Detail</button>
      <button class="btn bp bsm">⚡ Generate RPPH</button>
      <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
    </div>
  </div>
  <div class="rc2">
    <div class="rh">
      <div>
        <div class="rw">Mgg ke-2 — Sem 1 — 2024/2025</div>
        <div class="rn">Tanah Airku</div>
        <div class="rs">Identitas Negara</div>
      </div>
      <span class="bdg bpnd">⏳ Pending</span>
    </div>
    <div class="ract">
      <button class="btn bo bsm">👁️ Detail</button>
      <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
    </div>
  </div>
  <div class="rc2">
    <div class="rh">
      <div>
        <div class="rw">Mgg ke-3 — Sem 1 — 2024/2025</div>
        <div class="rn">Lingkunganku</div>
        <div class="rs">Rumahku</div>
      </div>
      <span class="bdg bdr">📝 Draft</span>
    </div>
    <div class="al ale mt8">📝 Perlu ditambahkan kegiatan aspek Seni</div>
    <div class="ract">
      <button class="btn bo bsm">👁️ Detail</button>
      <button class="btn ba bsm" onclick="showToast('📤 RPPM diajukan ke Kepala Sekolah')">📤 Ajukan ke Kepala</button>
      <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
    </div>
  </div>
</div>

{{-- Panel: Form Buat RPPM Baru --}}
<div id="panel-baru" style="display:none">
  <div class="card">
    <div class="ch">
      <div class="ct">📝 Form RPPM Baru</div>
    </div>

    <div class="fs11 tc2 mb16" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">A. Identitas</div>

    <div class="fr c3">
      <div class="ff">
        <label>Tema</label>
        <select id="selectTema" onchange="updateSubTema()">
          <option value="">-- Pilih --</option>
          <option value="aku">Aku, Makhluq Allah</option>
          <option value="tanah">Tanah Airku</option>
          <option value="lingkungan">Lingkunganku</option>
          <option value="binatang">Binatang Ciptaan Allah</option>
        </select>
      </div>
      <div class="ff">
        <label>Sub Tema</label>
        <select id="selectSubTema"><option>Pilih tema dulu</option></select>
      </div>
      <div class="ff">
        <label>Minggu Ke</label>
        <input type="number" min="1" max="17" placeholder="1-17"/>
      </div>
    </div>
    <div class="fr c2">
      <div class="ff">
        <label>Model Pembelajaran</label>
        <select>
          <option>Berbasis Proyek</option>
          <option>Kelompok dengan Sudut</option>
          <option>Sentra</option>
          <option>Area</option>
          <option>STEM</option>
        </select>
      </div>
      <div class="ff">
        <label>Tahun Ajaran</label>
        <input value="2024/2025" disabled/>
      </div>
    </div>
    <div class="fr">
      <div class="ff">
        <label>Tujuan Pembelajaran</label>
        <textarea rows="2" placeholder="Tujuan pembelajaran minggu ini..."></textarea>
      </div>
    </div>
    <div class="fr">
      <div class="ff">
        <label>Capaian Pembelajaran</label>
        <textarea rows="2" placeholder="Capaian yang diharapkan..."></textarea>
      </div>
    </div>

    <div class="dv"></div>
    <div class="fs11 tc2 mb16" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">B. Kegiatan Per Hari</div>
    <div class="al alw mb16">⚠️ Aspek belum terstimulasi: <strong>🎨 Seni</strong>, <strong>❤️ Sosial Emosional</strong></div>

    <div class="dt">
      <div class="dtb on">Senin (2)</div>
      <div class="dtb fl">Selasa (1)</div>
      <div class="dtb">Rabu (0)</div>
      <div class="dtb fl">Kamis (2)</div>
      <div class="dtb">Jumat (0)</div>
    </div>

    <div class="ds">
      <div class="dsh">
        <span class="dn">📅 Senin</span>
        <button class="btn bp bxs" onclick="document.getElementById('mPilihKeg').classList.add('on')">+ Pilih Kegiatan</button>
      </div>
      <div class="dki">
        <div>
          <strong>Menebalkan Nama Sendiri</strong> <span class="fs11 tc2">(Menggambar)</span>
          <div class="mt8"><span class="ap a3">🧠 Kognitif</span> <span class="ap a4">💬 Bahasa</span></div>
        </div>
        <button class="btn bd bxs">✕</button>
      </div>
      <div class="dki">
        <div>
          <strong>Finger Painting Anggota Tubuh</strong> <span class="fs11 tc2">(Finger Painting)</span>
          <div class="mt8"><span class="ap a2">🏃 Fisik Motorik</span> <span class="ap a6">🎨 Seni</span></div>
        </div>
        <button class="btn bd bxs">✕</button>
      </div>
    </div>

    <div class="dv"></div>
    <div class="fs11 tc2 mb16" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">C. Analisis Aspek Real-time</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:10px">
      <div class="card" style="padding:12px">
        <div class="fl jb ic mb8"><span class="ap a1">🕌 Nilai Agama</span><strong style="font-size:18px;color:var(--g6)">2</strong></div>
        <div class="pw"><div class="pb gr" style="width:80%"></div></div>
      </div>
      <div class="card" style="padding:12px">
        <div class="fl jb ic mb8"><span class="ap a2">🏃 Fisik Motorik</span><strong style="font-size:18px;color:var(--g6)">3</strong></div>
        <div class="pw"><div class="pb bl" style="width:100%"></div></div>
      </div>
      <div class="card" style="padding:12px">
        <div class="fl jb ic mb8"><span class="ap a3">🧠 Kognitif</span><strong style="font-size:18px;color:var(--g6)">2</strong></div>
        <div class="pw"><div class="pb ye" style="width:60%"></div></div>
      </div>
      <div class="card" style="padding:12px">
        <div class="fl jb ic mb8"><span class="ap a4">💬 Bahasa</span><strong style="font-size:18px;color:var(--g6)">1</strong></div>
        <div class="pw"><div class="pb gr" style="width:40%"></div></div>
      </div>
      <div class="card" style="padding:12px;border-color:#fecaca">
        <div class="fl jb ic mb8"><span class="ap a5">❤️ Sosial Emosional</span><strong style="font-size:18px;color:var(--red)">0</strong></div>
        <div class="pw"><div class="pb pk" style="width:0%"></div></div>
        <div class="fs11 mt8" style="color:var(--red)">⚠️ Belum ada</div>
      </div>
      <div class="card" style="padding:12px;border-color:#fecaca">
        <div class="fl jb ic mb8"><span class="ap a6">🎨 Seni</span><strong style="font-size:18px;color:var(--red)">0</strong></div>
        <div class="pw"><div class="pb or" style="width:0%"></div></div>
        <div class="fs11 mt8" style="color:var(--red)">⚠️ Belum ada</div>
      </div>
    </div>

    <div class="dv"></div>
    <div class="fl jb g12">
      <button class="btn bo">🔄 Reset</button>
      <div class="fl g12">
        <button class="btn bo" onclick="showToast('💾 Draft tersimpan')">💾 Simpan Draft</button>
        <button class="btn ba" onclick="showToast('📤 RPPM diajukan ke Kepala Sekolah')">📤 Ajukan ke Kepala Sekolah</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
var subTemaData = {
  aku: ['Allah Tuhanku', 'Identitasku', 'Tubuhku / Aurat', 'Panca Indra'],
  tanah: ['Identitas Negara', 'Hari Besar Nasional', 'Lambang Negara', 'Elemen Bangsa / Budaya'],
  lingkungan: ['Rumahku', 'Keluargaku', 'Masjidku', 'Sekolahku'],
  binatang: ['Binatang Halal/Haram', 'Binatang Qurban', 'Binatang Buas', 'Serangga', 'Binatang Air & Udara']
};

function updateSubTema() {
  var val = document.getElementById('selectTema').value;
  var sel = document.getElementById('selectSubTema');
  sel.innerHTML = '';
  if (!val) { sel.innerHTML = '<option>Pilih tema dulu</option>'; return; }
  (subTemaData[val] || []).forEach(function(st) {
    var opt = document.createElement('option');
    opt.textContent = st;
    sel.appendChild(opt);
  });
}

function switchRppmTab(tab) {
  document.getElementById('panel-daftar').style.display = tab === 'daftar' ? 'block' : 'none';
  document.getElementById('panel-baru').style.display = tab === 'baru' ? 'block' : 'none';
  document.getElementById('tab-btn-daftar').classList.toggle('on', tab === 'daftar');
  document.getElementById('tab-btn-baru').classList.toggle('on', tab === 'baru');
}

// Day tabs
document.querySelectorAll('.dt .dtb').forEach(function(btn) {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.dt .dtb').forEach(function(b){ b.classList.remove('on'); });
    this.classList.add('on');
  });
});
</script>
@endpush
