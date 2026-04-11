{{-- Modal: Tambah Pengguna --}}
<div class="mo" id="mUser">
  <div class="md mmd">
    <div class="mh">
      <div><div class="mt2">Tambah Pengguna</div></div>
      <button class="mc">✕</button>
    </div>
    <div class="mb">
      <div class="fr c2">
        <div class="ff"><label>Nama Lengkap</label><input placeholder="Nama lengkap"/></div>
        <div class="ff"><label>Username</label><input placeholder="username"/></div>
      </div>
      <div class="fr c2">
        <div class="ff"><label>Password</label><input type="password" placeholder="Password"/></div>
        <div class="ff"><label>Role</label>
          <select>
            <option value="guru">Guru</option>
            <option value="ortu">Orang Tua</option>
          </select>
        </div>
      </div>
      <div class="fr c2">
        <div class="ff"><label>Kelas</label>
          <select>
            <option value="A">Kelas A</option>
            <option value="B">Kelas B</option>
          </select>
        </div>
        <div class="ff"><label>No. HP</label><input placeholder="08xx"/></div>
      </div>
    </div>
    <div class="mf">
      <button class="btn bo">Batal</button>
      <button class="btn bp">💾 Simpan</button>
    </div>
  </div>
</div>

{{-- Modal: Tambah Siswa --}}
<div class="mo" id="mSiswa">
  <div class="md mmd">
    <div class="mh">
      <div><div class="mt2">Tambah Siswa</div></div>
      <button class="mc">✕</button>
    </div>
    <div class="mb">
      <div class="fr c2">
        <div class="ff"><label>Nama Siswa</label><input placeholder="Nama lengkap"/></div>
        <div class="ff"><label>Kelas</label>
          <select>
            <option value="A">Kelas A</option>
            <option value="B">Kelas B</option>
          </select>
        </div>
      </div>
      <div class="fr c2">
        <div class="ff"><label>Tanggal Lahir</label><input type="date"/></div>
        <div class="ff"><label>Jenis Kelamin</label>
          <select>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
        </div>
      </div>
    </div>
    <div class="mf">
      <button class="btn bo">Batal</button>
      <button class="btn bp">💾 Simpan</button>
    </div>
  </div>
</div>

{{-- Modal: Tambah Tema --}}
<div class="mo" id="mTema">
  <div class="md mmd">
    <div class="mh">
      <div><div class="mt2">Tambah Tema</div></div>
      <button class="mc">✕</button>
    </div>
    <div class="mb">
      <div class="fr c2">
        <div class="ff"><label>Nama Tema</label><input placeholder="Nama tema..."/></div>
        <div class="ff"><label>Semester</label>
          <select>
            <option value="1">Semester 1</option>
            <option value="2">Semester 2</option>
          </select>
        </div>
      </div>
      <div class="ff mb16">
        <label>Sub Tema (satu per baris)</label>
        <textarea rows="5" placeholder="Sub Tema 1&#10;Sub Tema 2"></textarea>
      </div>
    </div>
    <div class="mf">
      <button class="btn bo">Batal</button>
      <button class="btn bp">💾 Simpan</button>
    </div>
  </div>
</div>

{{-- Modal: Tambah Bentuk Kegiatan --}}
<div class="mo" id="mBentuk">
  <div class="md msm">
    <div class="mh">
      <div><div class="mt2">Tambah Bentuk Kegiatan</div></div>
      <button class="mc">✕</button>
    </div>
    <div class="mb">
      <div class="ff">
        <label>Nama Bentuk Kegiatan</label>
        <input placeholder="Contoh: Mewarnai, Kolase..."/>
      </div>
    </div>
    <div class="mf">
      <button class="btn bo">Batal</button>
      <button class="btn bp">💾 Simpan</button>
    </div>
  </div>
</div>

{{-- Modal: Tambah Alat Bahan --}}
<div class="mo" id="mAlat">
  <div class="md msm">
    <div class="mh">
      <div><div class="mt2">Tambah Alat & Bahan</div></div>
      <button class="mc">✕</button>
    </div>
    <div class="mb">
      <div class="ff">
        <label>Nama Alat / Bahan</label>
        <input placeholder="Contoh: Crayon, HVS..."/>
      </div>
    </div>
    <div class="mf">
      <button class="btn bo">Batal</button>
      <button class="btn bp">💾 Simpan</button>
    </div>
  </div>
</div>

{{-- Modal: Usulkan Kegiatan Baru --}}
<div class="mo" id="mKeg">
  <div class="md mlg">
    <div class="mh">
      <div>
        <div class="mt2">Usulkan Kegiatan Baru</div>
        <div class="mst">Kegiatan yang diusulkan harus disetujui Kepala Sekolah sebelum bisa dipakai.</div>
      </div>
      <button class="mc">✕</button>
    </div>
    <div class="mb">
      <div class="fr c2">
        <div class="ff"><label>Nama Kegiatan</label><input placeholder="Nama kegiatan..."/></div>
        <div class="ff"><label>Tema</label>
          <select>
            <option>-- Pilih Tema --</option>
            <option>Aku, Makhluq Allah</option>
            <option>Tanah Airku</option>
            <option>Lingkunganku</option>
          </select>
        </div>
      </div>
      <div class="fr c2">
        <div class="ff"><label>Bentuk Kegiatan</label>
          <select>
            <option>-- Pilih Bentuk --</option>
            <option>Mewarnai</option>
            <option>Kolase</option>
            <option>Finger Painting</option>
            <option>Melukis</option>
          </select>
        </div>
        <div class="ff"><label>Alat & Bahan</label><input placeholder="Crayon, Kertas HVS..."/></div>
      </div>
      <div class="fr"><div class="ff"><label>Deskripsi Kegiatan</label><textarea rows="3" placeholder="Deskripsi lengkap kegiatan..."></textarea></div></div>
      <div class="ff mb16">
        <label>Aspek Perkembangan yang Distimulasi</label>
        <div class="cbg mt8">
          <label class="cbi"><input type="checkbox"> 🕌 Nilai Agama</label>
          <label class="cbi"><input type="checkbox"> 🏃 Fisik Motorik</label>
          <label class="cbi"><input type="checkbox"> 🧠 Kognitif</label>
          <label class="cbi"><input type="checkbox"> 💬 Bahasa</label>
          <label class="cbi"><input type="checkbox"> ❤️ Sosial Emosional</label>
          <label class="cbi"><input type="checkbox"> 🎨 Seni</label>
        </div>
      </div>
      <div class="ff">
        <label>Foto Kegiatan (Pilih Ikon)</label>
        <div style="display:flex;flex-wrap:wrap;gap:7px;margin-top:6px">
          <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">🎨</div>
          <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">📸</div>
          <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">✏️</div>
          <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">🧩</div>
          <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">📚</div>
          <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">🌱</div>
          <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">🕌</div>
          <div style="width:46px;height:46px;border-radius:9px;border:2px solid var(--g2);display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer">🏃</div>
        </div>
      </div>
    </div>
    <div class="mf">
      <button class="btn bo">Batal</button>
      <button class="btn bp">💾 Simpan</button>
    </div>
  </div>
</div>

{{-- Modal: Cetak RPPM --}}
<div class="mo" id="mCRP">
  <div class="md mxl">
    <div class="mh">
      <div><div class="mt2">🖨️ Preview Cetak RPPM</div></div>
      <button class="mc">✕</button>
    </div>
    <div class="mb">
      <div class="pra">
        <div style="text-align:center;border-bottom:3px double #000;padding-bottom:10px;margin-bottom:14px">
          <div style="font-size:14px;font-weight:bold;text-transform:uppercase">PAUDQu AL-AULIA</div>
          <div style="font-size:11px">NPSN: 69990123 | Jl. Al-Quran No.12, Serang, Banten</div>
          <div style="font-size:16px;font-weight:bold;margin-top:7px;text-transform:uppercase">RENCANA PELAKSANAAN PEMBELAJARAN MINGGUAN (RPPM)</div>
          <div>Tahun Ajaran 2024/2025 — Semester 1</div>
        </div>
        <table class="prt" style="margin-bottom:14px">
          <tr><td style="width:22%;font-weight:bold">Satuan PAUD</td><td>PAUDQu AL-AULIA</td><td style="width:22%;font-weight:bold">Semester/Minggu</td><td>1/1</td></tr>
          <tr><td style="font-weight:bold">Nama Guru</td><td>Ustadzah Siti Rahmah</td><td style="font-weight:bold">Kelas/Usia</td><td>A / 5-6 Tahun</td></tr>
          <tr><td style="font-weight:bold">Tema</td><td>Aku, Makhluq Allah</td><td style="font-weight:bold">Sub Tema</td><td>Allah Tuhanku</td></tr>
          <tr><td style="font-weight:bold">Model</td><td colspan="3">Berbasis Proyek</td></tr>
          <tr><td style="font-weight:bold">Tujuan</td><td colspan="3">Anak dapat mengenal Allah sebagai Tuhan melalui kegiatan kreatif</td></tr>
          <tr><td style="font-weight:bold">Capaian</td><td colspan="3">Anak mampu menyebut nama Allah dan memahami ciptaan-Nya</td></tr>
        </table>
        <table class="prt">
          <thead><tr><th>Hari</th><th>Kegiatan</th><th>Bentuk</th><th>Aspek</th><th>Alat & Bahan</th></tr></thead>
          <tbody>
            <tr><td style="text-align:center;font-weight:bold">Senin</td><td>Kolase Tulisan "Terima Kasih Ya Allah"</td><td>Kolase</td><td>Nilai Agama, Seni</td><td>Kertas Origami, Lem, Gunting</td></tr>
            <tr><td style="text-align:center;font-weight:bold">Selasa</td><td>Menebalkan Nama Sendiri</td><td>Menggambar</td><td>Kognitif, Bahasa, Fisik Motorik</td><td>LKA, Pensil</td></tr>
          </tbody>
        </table>
        <div class="sgn">
          <div><div>Mengetahui,<br><strong>Kepala Sekolah</strong></div><div class="sn">Ustadzah Aminah, S.Pd.</div></div>
          <div><div>Serang, ___________<br><strong>Guru Kelas A</strong></div><div class="sn">Ustadzah Siti Rahmah</div></div>
        </div>
      </div>
    </div>
    <div class="mf">
      <button class="btn bo">Tutup</button>
      <button class="btn bp" onclick="window.print()">🖨️ Cetak</button>
    </div>
  </div>
</div>

{{-- Modal: Edit Data Sekolah --}}
<div class="mo" id="mSek">
  <div class="md mmd">
    <div class="mh">
      <div><div class="mt2">🏫 Edit Data Sekolah</div></div>
      <button class="mc">✕</button>
    </div>
    <div class="mb">
      <div class="fr c2">
        <div class="ff"><label>Nama Sekolah</label><input value="PAUDQu AL-AULIA"/></div>
        <div class="ff"><label>NPSN</label><input value="69990123"/></div>
      </div>
      <div class="ff mb16"><label>Alamat</label><textarea rows="2">Jl. Al-Quran No.12, Serang, Banten</textarea></div>
      <div class="fr c2">
        <div class="ff"><label>Kepala Sekolah</label><input value="Ustadzah Aminah, S.Pd."/></div>
        <div class="ff"><label>Telepon</label><input value="0812-3456-7890"/></div>
      </div>
      <div class="fr c2">
        <div class="ff"><label>Tahun Ajaran</label><input value="2024/2025"/></div>
        <div class="ff"><label>Semester Aktif</label>
          <select>
            <option value="1">Semester 1</option>
            <option value="2">Semester 2</option>
          </select>
        </div>
      </div>
    </div>
    <div class="mf">
      <button class="btn bo">Batal</button>
      <button class="btn bp">💾 Simpan</button>
    </div>
  </div>
</div>

{{-- Modal: Pilih Kegiatan untuk RPPM --}}
<div class="mo" id="mPilihKeg">
  <div class="md mlg">
    <div class="mh">
      <div><div class="mt2">🗂️ Pilih Kegiatan</div><div class="mst">Pilih kegiatan dari kumpulan kegiatan yang tersedia</div></div>
      <button class="mc">✕</button>
    </div>
    <div class="mb">
      <div class="fb" style="margin-bottom:14px">
        <input type="text" placeholder="🔍 Cari kegiatan..."/>
        <select><option>Semua Aspek</option><option>Nilai Agama</option><option>Fisik Motorik</option><option>Kognitif</option><option>Bahasa</option><option>Sosial Emosional</option><option>Seni</option></select>
      </div>
      <div class="kc sel">
        <div class="fl jb ic mb8"><div class="kn">Menebalkan Nama Sendiri</div><span class="bdg bok">✅ Tersedia</span></div>
        <div class="kd">Anak menebalkan huruf nama sendiri pada lembar kerja yang tersedia guru.</div>
        <div class="fl fw g8"><span class="ap a3">🧠 Kognitif</span><span class="ap a4">💬 Bahasa</span><span class="ap a2">🏃 Fisik Motorik</span></div>
      </div>
      <div class="kc">
        <div class="fl jb ic mb8"><div class="kn">Finger Painting Anggota Tubuh</div><span class="bdg bok">✅ Tersedia</span></div>
        <div class="kd">Anak membuat jejak tangan dan kaki menggunakan cat air di kertas HVS.</div>
        <div class="fl fw g8"><span class="ap a2">🏃 Fisik Motorik</span><span class="ap a6">🎨 Seni</span></div>
      </div>
    </div>
    <div class="mf">
      <button class="btn bo">Batal</button>
      <button class="btn bp">✅ Tambahkan ke Hari Ini</button>
    </div>
  </div>
</div>
