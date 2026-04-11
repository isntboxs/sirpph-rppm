@extends('layout.app')

@section('page-title', 'Validasi RPPM')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="card">
  <div class="ch">
    <div class="ct">✅ Validasi RPPM</div>
  </div>

  <div class="tabs">
    <button class="tbn on" data-tab="tab-menunggu">⏳ Menunggu (3)</button>
    <button class="tbn" data-tab="tab-disetujui">✅ Disetujui (8)</button>
    <button class="tbn" data-tab="tab-dikembalikan">↩️ Dikembalikan</button>
  </div>

  {{-- Tab: Menunggu --}}
  <div id="tab-menunggu" class="tab-content">
    <div class="rc2">
      <div class="rh">
        <div>
          <div class="rw">Mgg ke-1 • Ustadzah Siti Rahmah • Kelas A • 2024/2025</div>
          <div class="rn">Aku, Makhluq Allah</div>
          <div class="rs">Allah Tuhanku</div>
        </div>
        <span class="bdg bpnd">⏳ Pending</span>
      </div>
      <div class="ract">
        <button class="btn bo bsm">🔍 Detail</button>
        <button class="btn bp bsm" onclick="showToast('✅ RPPM berhasil disetujui')">✅ Setujui</button>
        <button class="btn bd bsm">↩️ Kembalikan</button>
        <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
      </div>
    </div>
    <div class="rc2">
      <div class="rh">
        <div>
          <div class="rw">Mgg ke-2 • Ustadzah Dewi Nursanti • Kelas B • 2024/2025</div>
          <div class="rn">Tanah Airku</div>
          <div class="rs">Identitas Negara</div>
        </div>
        <span class="bdg bpnd">⏳ Pending</span>
      </div>
      <div class="ract">
        <button class="btn bo bsm">🔍 Detail</button>
        <button class="btn bp bsm" onclick="showToast('✅ RPPM berhasil disetujui')">✅ Setujui</button>
        <button class="btn bd bsm">↩️ Kembalikan</button>
        <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
      </div>
    </div>
    <div class="rc2">
      <div class="rh">
        <div>
          <div class="rw">Mgg ke-3 • Ustadzah Siti Rahmah • Kelas A • 2024/2025</div>
          <div class="rn">Lingkunganku</div>
          <div class="rs">Rumahku</div>
        </div>
        <span class="bdg bpnd">⏳ Pending</span>
      </div>
      <div class="al ale mt8">📝 Perlu ditambahkan kegiatan aspek Seni</div>
      <div class="ract">
        <button class="btn bo bsm">🔍 Detail</button>
        <button class="btn bp bsm" onclick="showToast('✅ RPPM berhasil disetujui')">✅ Setujui</button>
        <button class="btn bd bsm">↩️ Kembalikan</button>
        <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
      </div>
    </div>
  </div>

  {{-- Tab: Disetujui --}}
  <div id="tab-disetujui" class="tab-content" style="display:none">
    <div class="rc2">
      <div class="rh">
        <div>
          <div class="rw">Mgg ke-4 • Ustadzah Siti Rahmah • Kelas A • 2024/2025</div>
          <div class="rn">Aku, Makhluq Allah</div>
          <div class="rs">Panca Indra</div>
        </div>
        <span class="bdg bok">✅ Disetujui</span>
      </div>
      <div class="ract">
        <button class="btn bo bsm">🔍 Detail</button>
        <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
      </div>
    </div>
    <div class="rc2">
      <div class="rh">
        <div>
          <div class="rw">Mgg ke-5 • Ustadzah Dewi Nursanti • Kelas B • 2024/2025</div>
          <div class="rn">Tanah Airku</div>
          <div class="rs">Lambang Negara</div>
        </div>
        <span class="bdg bok">✅ Disetujui</span>
      </div>
      <div class="ract">
        <button class="btn bo bsm">🔍 Detail</button>
        <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
      </div>
    </div>
  </div>

  {{-- Tab: Dikembalikan --}}
  <div id="tab-dikembalikan" class="tab-content" style="display:none">
    <div class="emp">
      <div class="ei">↩️</div>
      <h3>Tidak ada RPPM yang dikembalikan</h3>
      <p>RPPM yang dikembalikan untuk diperbaiki akan muncul di sini.</p>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-tab]').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var target = this.getAttribute('data-tab');
    // Toggle tabs
    this.closest('.tabs').querySelectorAll('.tbn').forEach(function(b){ b.classList.remove('on'); });
    this.classList.add('on');
    // Toggle panels
    document.querySelectorAll('.tab-content').forEach(function(p){ p.style.display = 'none'; });
    var panel = document.getElementById(target);
    if (panel) panel.style.display = 'block';
  });
});
</script>
@endpush
