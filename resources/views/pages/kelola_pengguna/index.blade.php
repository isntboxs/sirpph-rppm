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
                    @foreach ($users as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>

                            <td>
                                <code style="background:var(--g0);padding:2px 7px;border-radius:4px;font-size:11px">
                                    {{ $user->username }}
                                </code>
                            </td>

                            <td>
                                @if ($user->role == 'admin')
                                    ⚙️ Admin
                                @elseif($user->role == 'kepala')
                                    👑 Kepala
                                @elseif($user->role == 'guru')
                                    🧑‍🏫 Guru
                                @elseif($user->role == 'ortu')
                                    👨‍👩‍👧 Orang Tua
                                @endif
                            </td>

                            <td>
                                @if ($user->isGuru())
                                    {{ $user->kelas->name ?? '-' }}
                                @elseif($user->isOrtu())
                                    {{ $user->siswas->pluck('name')->join(', ') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if ($user->isActive())
                                    <span class="bdg bok">✅ Aktif</span>
                                @else
                                    <span class="bdg bdg-danger">❌ Nonaktif</span>
                                @endif
                            </td>

                            <td class="fl g8">
                                <button class="btn bo bxs btn-edit" data-id="{{ $user->id }}">✏️</button>

                                @if (!$user->isAdmin())
                                    @if ($user->isActive())
                                        <button class="btn bd bxs btn-active" data-id="{{ $user->id }}"
                                            data-com="del">🚫</button>
                                    @else
                                        <button class="btn bd bxs btn-active" data-id="{{ $user->id }}"
                                            data-com="act">✅</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal: Tambah Pengguna --}}
    <div class="mo" id="mUser">
        <div class="md mmd">
            <div class="mh">
                <div>
                    <div class="mt2">Tambah Pengguna</div>
                </div>
                <button class="mc">X</button>
            </div>
            <div class="mb">
                <div class="fr c2">
                    <div class="ff"><label>Nama Lengkap</label><input id="name" name="name"
                            placeholder="Nama lengkap" required /></div>
                    <div class="ff"><label>Username</label><input id="username" name="username" placeholder="username"
                            required /></div>
                </div>
                <div class="fr c2">
                    <div class="ff"><label>Password</label><input id="password" name="password" type="password"
                            placeholder="Password" required /></div>
                    <div class="ff"><label>Role</label>
                        <select id="role" name="role" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="guru">Guru</option>
                            <option value="ortu">Orang Tua</option>
                        </select>
                    </div>
                </div>
                <div class="fr c2" style="display: none">
                    <div class="ff"><label>Kelas</label>
                        <select id="kelas" name="kelas">
                        </select>
                    </div>
                    <div class="ff"><label>No. HP</label><input id="no_telp" name="no_telp" placeholder="08xx" />
                    </div>
                </div>
                <div class="fr" style="display: none">
                    <div class="ff"><label>Anak Yang Dipantau</label>
                        <select id="siswa_dipantau" name="siswa_dipantau[]" multiple>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mf">
                <button id="btn-save" class="btn bp">💾 Simpan</button>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#btn-tambah-user').on('click', function() {
                $('#mUser').addClass('on');
                $('#role').trigger('change');
                $('#btn-save').removeData('id');
                $('#btn-save').text('Simpan');

                $('#role').val('').trigger('change');
            });

            $('.btn-edit').on('click', function() {
                let id = $(this).data('id');

                $('#mUser').addClass('on');
                $('#btn-save').text('Update');

                loadUser(id);
            });

            $('.btn-active').on('click', function() {
                let id = $(this).data('id');
                let command = $(this).data('com');

                $.ajax({
                    url: `/kelola-pengguna/${id}`,
                    type: 'DELETE',
                    data: {
                        command: command
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        location.reload();
                        showToast(res.msg);
                    },
                    error: function() {
                        showToast("Gagal Menonaktifkan User");
                    }
                })
            })

            // Trigger on role change different field
            $('#role').on('change', function() {
                let roleVal = $(this).val();
                if (roleVal === 'guru') {
                    loadKelas();
                    $('#siswa_dipantau').closest('.fr').hide();
                    $('#kelas').closest('.fr').show();
                } else if (roleVal === 'ortu') {
                    loadSiswa();
                    $('#siswa_dipantau').closest('.fr').show();
                    $('#kelas').closest('.fr').hide();
                }
            })

            // Reset All data on Close Modal
            $('.mc').on('click', function() {
                $('#name').val('');
                $('#username').val('');
                $('#password').val('');
                $('#role').val('').trigger('change');
                $('#kelas').val('').trigger('change');
                $('#no_telp').val('');

                $('#siswa_dipantau').val([]).trigger('change');

                $('#btn-save').removeData('id');

                $('#kelas').closest('.fr').hide();
                $('#siswa_dipantau').closest('.fr').hide();
            });

            $('#btn-save').on('click', function() {
                const id = $(this).data('id');

                let url = id ? `/kelola-pengguna/${id}` : `/kelola-pengguna`;

                let data = {
                    name: $('#name').val(),
                    username: $('#username').val(),
                    role: $('#role').val(),
                    kelas: $('#kelas').val(),
                    no_telp: $('#no_telp').val(),
                    siswa_dipantau: $('#siswa_dipantau').val() || [],
                };

                if ($('#password').val()) {
                    data.password = $('#password').val();
                }

                if (id) {
                    data._method = 'PUT';
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        showToast(res.msg);
                        location.reload();
                    },
                    error: function() {
                        showToast(id ? "Gagal Update User" : "Gagal Menambahkan User");
                    }
                })
            })
        });
    </script>

    <script>
        function loadKelas(user = null) {
            $.ajax({
                url: '{{ route('kelas.data') }}',
                type: 'GET',
                success: function(res) {
                    let select = $('#kelas');
                    select.empty();

                    select.append('<option value="">-- Pilih Kelas --</option>');

                    res.forEach(kelas => {
                        let isSelected = user && user.kelas_id == kelas.id ? 'selected' : '';
                        select.append(
                            `<option value="${kelas.id}" ${isSelected}>${kelas.name}</option>`)
                    });
                },
                error: function() {
                    showToast("Gagal mendapatkan Data Kelas");
                }
            })
        }

        function loadSiswa(user = null) {
            $.ajax({
                url: '{{ route('siswa.data') }}',
                type: 'GET',
                data: {
                    user_id: user ? user.id : null,
                },
                success: function(res) {
                    let select = $('#siswa_dipantau');
                    select.empty();

                    select.append('<option value="">-- Pilih Siswa --</option>');

                    res.forEach(siswa => {
                        let isSelected = user && siswa.ortu_id == user.id ? 'selected' : '';
                        select.append(
                            `<option value="${siswa.id}" ${isSelected}>${siswa.name}</option>`)
                    });
                },
                error: function() {
                    showToast("Gagal mendapatkan Data Siswa");
                }
            })
        }

        function loadUser(id) {
            $.ajax({
                url: `/kelola-pengguna/edit/${id}`,
                type: 'GET',
                success: function(res) {

                    let user = res.user;

                    $('#name').val(user.name);
                    $('#username').val(user.username);
                    $('#no_telp').val(user.no_telp);

                    $('#role').val(user.role);

                    if (user.role === 'guru') {
                        $('#kelas').closest('.fr').show();
                        $('#no_telp').closest('.fr').show();

                        $('#no_telp').empty();
                        $('#no_telp').val(user.no_telp);

                        loadKelas(user)
                    }

                    if (user.role === 'ortu') {
                        $('#siswa_dipantau').closest('.fr').show();
                        $('#siswa_dipantau').empty();

                        loadSiswa(user);
                    }

                    $('#btn-save').data('id', user.id);
                    $('#btn-save').text('Update');
                }
            });
        }
    </script>
@endpush
