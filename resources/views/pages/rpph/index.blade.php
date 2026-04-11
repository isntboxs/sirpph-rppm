@extends('layout.app')

@section('page-title', 'Buat & Kelola RPPH')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="card mb16">
  <div class="ch">
    <div class="ct">📄 RPPH dari RPPM Disetujui</div>
  </div>

  <div class="rc2">
    <div class="rh">
      <div>
        <div class="rw">Mgg ke-1 • 2024/2025</div>
        <div class="rn">Aku, Makhluq Allah</div>
        <div class="rs">Allah Tuhanku</div>
      </div>
      <span class="bdg bok">✅ RPPM Disetujui</span>
    </div>

    {{-- Status per hari --}}
    <div class="fl fw g8 mt8 mb8">
      <div style="padding:6px 12px;background:var(--g1);border:2px solid var(--g4);border-radius:7px;font-size:11.5px;font-weight:700">Senin ✅</div>
      <div style="padding:6px 12px;background:#eff6ff;border:2px solid #bfdbfe;border-radius:7px;font-size:11.5px;font-weight:700">Selasa 📝</div>
      <div style="padding:6px 12px;background:var(--g0);border:2px solid var(--g1);border-radius:7px;font-size:11.5px;font-weight:700">Rabu ⚪</div>
      <div style="padding:6px 12px;background:var(--g1);border:2px solid var(--g4);border-radius:7px;font-size:11.5px;font-weight:700">Kamis ✅</div>
      <div style="padding:6px 12px;background:var(--g0);border:2px solid var(--g1);border-radius:7px;font-size:11.5px;font-weight:700">Jumat ⚪</div>
    </div>

    <div class="ract">
      <button class="btn bp bsm" onclick="showToast('⚡ RPPH di-generate ulang')">⚡ Generate/Refresh RPPH</button>
      <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️ RPPM</button>
    </div>

    {{-- Senin --}}
    <div class="ds mt8">
      <div class="dsh">
        <span class="dn">📅 Senin</span>
        <div class="fl g8">
          <button class="btn bp bxs">✏️ Edit</button>
          <button class="btn bo bxs">🖨️</button>
        </div>
      </div>
      <div class="dki">
        <strong>Kolase Tulisan "Terima Kasih Ya Allah"</strong>
        <span class="fs11 tc2">(Kolase)</span>
      </div>
      <div class="al als mt8">✅ Disetujui Kepala Sekolah</div>
    </div>

    {{-- Selasa --}}
    <div class="ds mt8">
      <div class="dsh">
        <span class="dn">📅 Selasa</span>
        <div class="fl g8">
          <button class="btn bp bxs">✏️ Edit</button>
          <button class="btn bo bxs">🖨️</button>
          <button class="btn ba bxs" onclick="showToast('📤 RPPH Selasa diajukan')">📤</button>
        </div>
      </div>
      <div class="dki">
        <strong>Menebalkan Nama Sendiri</strong>
        <span class="fs11 tc2">(Menggambar)</span>
      </div>
      <div class="al ali mt8">📝 Sudah diisi — klik 📤 untuk ajukan ke Kepala</div>
    </div>

    {{-- Rabu --}}
    <div class="ds mt8">
      <div class="dsh">
        <span class="dn">📅 Rabu</span>
        <div class="fl g8">
          <button class="btn bp bxs" onclick="document.getElementById('mPilihKeg').classList.add('on')">+ Pilih Kegiatan</button>
        </div>
      </div>
      <div class="emp" style="padding:16px 0">
        <div class="ei" style="font-size:24px">📭</div>
        <div style="font-size:12px;color:var(--txt3)">Belum ada kegiatan untuk hari Rabu</div>
      </div>
    </div>

  </div>
</div>
@endsection
