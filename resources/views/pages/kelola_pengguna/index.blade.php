@extends('layout.app')

@section('page-title', 'Kelola Pengguna')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
<div class="card">
  <div class="ch">
    <div class="ct">👥 Daftar Pengguna</div>
    <button class="btn bp bsm" id="btn-tambah-user">+ Tambah</button>
  </div>
  <div class="tw">
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Username</th>
          <th>Role</th>
          <th>Detail</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><strong>Administrator</strong></td>
          <td><code style="background:var(--g0);padding:2px 7px;border-radius:4px;font-size:11px">admin</code></td>
          <td>⚙️ Admin</td>
          <td>—</td>
          <td><span class="bdg bok">✅ Aktif</span></td>
          <td class="fl g8"><button class="btn bo bxs">✏️</button></td>
        </tr>
        <tr>
          <td><strong>Ustadzah Aminah, S.Pd.</strong></td>
          <td><code style="background:var(--g0);padding:2px 7px;border-radius:4px;font-size:11px">kepala</code></td>
          <td>👑 Kepala</td>
          <td>—</td>
          <td><span class="bdg bok">✅ Aktif</span></td>
          <td class="fl g8">
            <button class="btn bo bxs">✏️</button>
            <button class="btn bd bxs">🚫</button>
          </td>
        </tr>
        <tr>
          <td><strong>Ustadzah Siti Rahmah</strong></td>
          <td><code style="background:var(--g0);padding:2px 7px;border-radius:4px;font-size:11px">guru_a</code></td>
          <td>🧑‍🏫 Guru</td>
          <td>Kelas A</td>
          <td><span class="bdg bok">✅ Aktif</span></td>
          <td class="fl g8">
            <button class="btn bo bxs">✏️</button>
            <button class="btn bd bxs">🚫</button>
          </td>
        </tr>
        <tr>
          <td><strong>Ustadzah Dewi Nursanti</strong></td>
          <td><code style="background:var(--g0);padding:2px 7px;border-radius:4px;font-size:11px">guru_b</code></td>
          <td>🧑‍🏫 Guru</td>
          <td>Kelas B</td>
          <td><span class="bdg bok">✅ Aktif</span></td>
          <td class="fl g8">
            <button class="btn bo bxs">✏️</button>
            <button class="btn bd bxs">🚫</button>
          </td>
        </tr>
        <tr>
          <td><strong>Bapak Ahmad Yusuf</strong></td>
          <td><code style="background:var(--g0);padding:2px 7px;border-radius:4px;font-size:11px">ortu1</code></td>
          <td>👨‍👩‍👧 Orang Tua</td>
          <td>Zaid Al-Fatih</td>
          <td><span class="bdg bok">✅ Aktif</span></td>
          <td class="fl g8">
            <button class="btn bo bxs">✏️</button>
            <button class="btn bd bxs">🚫</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#btn-tambah-user').on('click', function() {
                $('#mUser').addClass('on');
            });
        });
    </script>
@endpush
