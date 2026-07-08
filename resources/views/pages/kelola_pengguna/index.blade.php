@extends('layout.app')

@section('page-title', 'Kelola Pengguna')
@section('page-subtitle', \App\Models\DataSekolah::getData()?->name  . ' - ' . \App\Models\TahunAjaran::getActive()?->name)

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
                                    Admin
                                @elseif($user->role == 'kepala')
                                    Kepala Sekolah
                                @elseif($user->role == 'guru')
                                    Guru
                                @endif
                            </td>

                            <td>
                                @if ($user->isGuru())
                                    {{ $user->kelas?->name ?? '-' }}

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
                                <button class="btn bo bxs btn-edit" data-id="{{ $user->id }}">Edit</button>

                                @if (!$user->isAdmin())
                                    @if ($user->isActive())
                                        <button class="btn bd bxs btn-delete" data-id="{{ $user->id }}" data-com="del">Hapus Pengguna</button>
                                    @else
                                        <button class="btn bp bxs btn-delete" data-id="{{ $user->id }}" data-com="act">Aktifkan</button>
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
                            @foreach($roles as $r)
                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="fr c2" style="display: none">
                    <div class="ff"><label>Kelas</label>
                        <select id="kelas" name="kelas">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ff"><label>No. HP</label><input id="no_telp" name="no_telp" placeholder="08xx" />
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
                $('#mUser .mt2').text('Tambah Pengguna');

                $('#role').val('').trigger('change');
            });

            $('.btn-edit').on('click', function() {
                let id = $(this).data('id');

                $('#mUser').addClass('on');
                $('#btn-save').text('Update');
                $('#mUser .mt2').text('Edit Pengguna');

                loadUser(id);
            });

            $('.btn-delete').on('click', function() {
                let id = $(this).data('id');
                let command = $(this).data('com');
                let actionText = command === 'del' ? 'menghapus' : 'mengaktifkan';

                window.confirmAction(`Anda yakin untuk ${actionText} Pengguna ini?`, function() {
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
                            showToast(res.message || 'Berhasil diproses');
                            setTimeout(() => location.reload(), 1000);
                        },
                        error: function() {
                            showToast(`Gagal ${actionText} User`);
                        }
                    });
                });
            });

            // Trigger on role change different field
            $('#role').on('change', function() {
                let roleVal = $(this).val();
                if (roleVal === 'guru') {
                    $('#kelas').closest('.fr').show();
                } else {
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



                $('#btn-save').removeData('id');

                $('#kelas').closest('.fr').hide();

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
                    error: function(xhr) {
                        let errorMsg = id ? "Gagal Update User" : "Gagal Menambahkan User";
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = Object.values(xhr.responseJSON.errors).flat();
                            errorMsg = errors[0];
                        }
                        showToast(errorMsg);
                    }
                })
            })
        });
    </script>

    <script>
        function loadUser(id) {
            $.ajax({
                url: `/kelola-pengguna/edit/${id}`,
                type: 'GET',
                success: function(res) {
                    let user = res.user;
                    $('#name').val(user.name);
                    $('#username').val(user.username);
                    $('#role').val(user.role).trigger('change');
                    $('#no_telp').val(user.no_telp);
                    
                    if (user.role === 'guru') {
                        $('#kelas').val(user.kelas_id);
                        $('#kelas').closest('.fr').show();
                        $('#siswa_dipantau').closest('.fr').hide();
                    }
                    
                    $('#btn-save').data('id', user.id);
                },
                error: function() {
                    showToast("Gagal mengambil data user");
                }
            })
        }
    </script>
@endpush
