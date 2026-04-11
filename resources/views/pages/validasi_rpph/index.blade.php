@extends('layout.app')

@section('page-title', 'Validasi RPPH')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="card">
  <div class="ch">
    <div class="ct">📄 Validasi RPPH</div>
  </div>

  <div class="tabs">
    <button class="tbn on" data-tab="vtab-menunggu">⏳ Menunggu (2)</button>
    <button class="tbn" data-tab="vtab-disetujui">✅ Disetujui (10)</button>
  </div>

  {{-- Tab: Menunggu --}}
  <div id="vtab-menunggu" class="tab-content">
    <div class="rc2">
      <div class="rh">
        <div>
          <div class="rw">Senin, 14 Juli 2025 • Kelas A</div>
          <div class="rn">Aku, Makhluq Allah</div>
          <div class="rs">Allah Tuhanku — Aku Bersyukur kepada Allah</div>
        </div>
        <span class="bdg bpnd">⏳ Pending</span>
      </div>
      <div class="ract">
        <button class="btn bo bsm">🔍 Detail</button>
        <button class="btn bp bsm" onclick="showToast('✅ RPPH berhasil disetujui')">✅ Setujui</button>
        <button class="btn bd bsm">↩️</button>
        <button class="btn bo bsm">🖨️</button>
      </div>
    </div>
    <div class="rc2">
      <div class="rh">
        <div>
          <div class="rw">Selasa, 15 Juli 2025 • Kelas B</div>
          <div class="rn">Tanah Airku</div>
          <div class="rs">Identitas Negara — Bendera Merah Putih</div>
        </div>
        <span class="bdg bpnd">⏳ Pending</span>
      </div>
      <div class="ract">
        <button class="btn bo bsm">🔍 Detail</button>
        <button class="btn bp bsm" onclick="showToast('✅ RPPH berhasil disetujui')">✅ Setujui</button>
        <button class="btn bd bsm">↩️</button>
        <button class="btn bo bsm">🖨️</button>
      </div>
    </div>
  </div>

  {{-- Tab: Disetujui --}}
  <div id="vtab-disetujui" class="tab-content" style="display:none">
    <div class="rc2">
      <div class="rh">
        <div>
          <div class="rw">Senin, 7 Juli 2025 • Kelas A</div>
          <div class="rn">Aku, Makhluq Allah</div>
          <div class="rs">Identitasku — Mengenal Nama Sendiri</div>
        </div>
        <span class="bdg bok">✅ Disetujui</span>
      </div>
      <div class="ract">
        <button class="btn bo bsm">🔍 Detail</button>
        <button class="btn bo bsm">🖨️</button>
      </div>
    </div>
    <div class="rc2">
      <div class="rh">
        <div>
          <div class="rw">Selasa, 8 Juli 2025 • Kelas B</div>
          <div class="rn">Tanah Airku</div>
          <div class="rs">Hari Besar Nasional — Upacara Sederhana</div>
        </div>
        <span class="bdg bok">✅ Disetujui</span>
      </div>
      <div class="ract">
        <button class="btn bo bsm">🔍 Detail</button>
        <button class="btn bo bsm">🖨️</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-tab]').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var target = this.getAttribute('data-tab');
    this.closest('.tabs').querySelectorAll('.tbn').forEach(function(b){ b.classList.remove('on'); });
    this.classList.add('on');
    document.querySelectorAll('.tab-content').forEach(function(p){ p.style.display = 'none'; });
    var panel = document.getElementById(target);
    if (panel) panel.style.display = 'block';
  });
});
</script>
@endpush
