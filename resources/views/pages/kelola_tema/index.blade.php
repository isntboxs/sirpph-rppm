@extends('layout.app')

@section('page-title', 'Kelola Tema')
@section('page-subtitle', \App\Models\DataSekolah::getData()?->name  . ' - ' . \App\Models\TahunAjaran::getActive()?->name)

@section('content')
    <div class="card">
        <div class="ch" style="margin-bottom:16px">
            <div></div>
            @if(Auth::user()->role === 'admin')
                <button type="button" class="btn bp bsm" id="btnTambahTema">+ Tambah Tema</button>
            @endif
        </div>
        <div class="g2" style="gap:12px" id="listTema">
            @forelse ($temas as $tema)
                <div class="card" style="border-color:var(--g2)" data-tema-id="{{ $tema->id }}">
                    <div class="ch">
                        <div>
                            <div class="ct">{{ $tema->name }} 
                                {!! $tema->status === 'disetujui' ? '<span class="bdg blink-green" style="font-size:10px; background:var(--green); color:#fff; border:none; margin-left:5px;">Di Validasi</span>' : '' !!}
                                {!! $tema->status === 'pending' ? '<span class="bdg blink-red" style="font-size:10px; background:var(--red); color:#fff; border:none; margin-left:5px;">Diajukan</span>' : '' !!}
                                {!! $tema->status === 'draft' ? '<span class="bdg blink-yellow" style="font-size:10px; background:#ffc107; color:#000; border-radius:20px; border:none; margin-left:5px;">Draft (Perlu dicek)</span>' : '' !!}
                                {!! $tema->status === 'dikembalikan' ? '<span class="bdg blink-red" style="font-size:10px; background:#ef4444; color:#fff; border:none; margin-left:5px;">Di Kembalikan</span>' : '' !!}
                            </div>
                            <div class="cs">{{ $tema->semester_label }} - {{ $tema->subTemas->count() }} Sub Tema</div>
                            @if($tema->alasan_edit && $tema->status === 'dikembalikan')
                                <div class="cs" style="color:#ef4444; font-weight:500; font-style:italic; font-size:11px;">Alasan Pengembalian: {{ $tema->alasan_edit }}</div>
                            @endif
                        </div>
                        <div style="display:flex; gap:5px;">
                            @if(Auth::user()->role === 'guru')
                                @if(in_array($tema->status, ['draft', 'dikembalikan']) || $tema->subTemas->whereIn('status', ['draft', 'dikembalikan'])->count() > 0)
                                    <button type="button" class="btn bp bxs btn-ajukan-tema" data-id="{{ $tema->id }}">📤 Ajukan</button>
                                @endif
                                <button type="button" class="btn bo bxs btn-edit-tema" data-id="{{ $tema->id }}" data-name="{{ $tema->name }}">✏️ Edit</button>
                                @if($tema->status === 'draft')
                                    <button type="button" class="btn bd bxs btn-hapus-tema" data-id="{{ $tema->id }}">🗑️ Hapus</button>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="fl fw g8">
                        @foreach ($tema->subTemas as $sub)
                            <span class="chip-sub-tema" data-id="{{ $sub->id }}"
                                style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">
                                <span>{{ $sub->name }} (Mg {{ $sub->minggu_ke }}) 
                                    {!! $sub->status === 'disetujui' ? '<span class="blink-green" style="color:var(--green); font-size:10px; font-weight:bold; margin-left:3px;">(Di Validasi)</span>' : '' !!}
                                    {!! $sub->status === 'pending' ? '<span class="blink-red" style="color:var(--red); font-size:10px; font-weight:bold; margin-left:3px;">(Diajukan)</span>' : '' !!}
                                    {!! $sub->status === 'draft' ? '<span class="blink-yellow" style="background:#ffc107; color:#000; font-size:10px; padding:2px 6px; border-radius:10px; font-weight:bold; margin-left:3px;">Draft</span>' : '' !!}
                                    {!! $sub->status === 'dikembalikan' ? '<span class="blink-red" style="color:#ef4444; font-size:10px; font-weight:bold; margin-left:3px;">(Di Kembalikan)</span>' : '' !!}
                                </span>
                                @if(Auth::user()->role === 'guru')
                                    @if($sub->status === 'dikembalikan')
                                        <button type="button" class="btn-lihat-alasan blink-red" data-alasan="{{ $sub->alasan_edit }}"
                                            style="background:var(--red);color:#fff;border-radius:50%;width:18px;height:18px;font-size:10px;cursor:pointer;border:none;line-height:1;display:flex;align-items:center;justify-content:center;font-weight:bold;">!</button>
                                    @endif
                                    <button type="button" class="btn-edit-sub-tema" data-id="{{ $sub->id }}" data-name="{{ $sub->name }}" data-minggu="{{ $sub->minggu_ke }}"
                                        style="background:none;color:var(--primary);font-size:11px;cursor:pointer;border:none;line-height:1">✏️</button>
                                    @if($sub->status === 'draft')
                                        <button type="button" class="btn-hapus-sub-tema" data-id="{{ $sub->id }}"
                                            style="background:none;color:var(--red);font-size:11px;cursor:pointer;border:none;line-height:1">✕</button>
                                    @endif
                                @endif
                            </span>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="emp" style="grid-column:span 2">
                    <div class="ei">📚</div>
                    <h3>Belum ada tema</h3>
                    <p>Klik tombol Tambah Tema untuk mulai.</p>
                </div>
            @endforelse
        </div>

        {{-- Modal: Tambah Tema --}}
        <div class="mo" id="mTema">
            <div class="md mmd">
                <form id="formTambahTema">
                    <div class="mh">
                        <div>
                            <div class="mt2">Tambah Tema</div>
                        </div>
                        <button type="button" class="mc">✕</button>
                    </div>
                    <div class="mb">
                        <div class="fr c2">
                            <div class="ff">
                                <label>Nama Tema</label>
                                <input id="inputNamaTema" name="name" placeholder="Nama tema..." />
                            </div>
                            <div class="ff">
                                <label>Semester</label>
                                <select id="inputSemesterTema" name="semester">
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="ff">
                            <label>Sub Tema</label>
                            <div id="subTemaList" style="display:flex; flex-direction:column; gap:8px;">
                                <div style="display:flex; gap:10px;">
                                    <input type="number" name="sub_tema_minggu[]" placeholder="Mg Ke" style="width:80px" required min="1" max="50">
                                    <input type="text" name="sub_tema_name[]" placeholder="Nama sub tema..." style="flex:1" required>
                                    <button type="button" class="btn bd bxs btn-remove-subtema-row" style="padding:0 10px;">✕</button>
                                </div>
                            </div>
                            <button type="button" class="btn bxs" id="btnAddSubTemaRow" style="margin-top:10px; background:var(--g1); border:1px solid var(--g3); color:var(--txt);">+ Tambah Sub Tema</button>
                        </div>
                        <div id="errorTema" class="al ale" style="display:none"></div>
                    </div>
                    <div class="mf">
                        <button type="submit" class="btn bp btn-submit-form">💾 Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal: Tambah Sub Tema --}}
        <div class="mo" id="mSubTema">
            <div class="md msm">
                <form id="formTambahSubTema">
                    <input type="hidden" id="inputSubTemaTemaId" />
                    <div class="mh">
                        <div>
                            <div class="mt2">Tambah Sub Tema</div>
                            <div class="mst" id="labelNamaTemaSubTema"></div>
                        </div>
                        <button type="button" class="mc">✕</button>
                    </div>
                    <div class="mb">
                        <div class="fr c2">
                            <div class="ff">
                                <label>Minggu Ke-</label>
                                <input type="number" id="inputMingguKeSubTema" name="minggu_ke" placeholder="Misal: 1" required min="1" max="50" />
                            </div>
                            <div class="ff">
                                <label>Nama Sub Tema</label>
                                <input id="inputNamaSubTema" name="name" placeholder="Nama sub tema..." required />
                            </div>
                        </div>
                        <div id="errorSubTema" class="al ale" style="display:none"></div>
                    </div>
                    <div class="mf">
                        <button type="submit" class="btn bp btn-submit-form">💾 Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- Modal: Edit Tema --}}
        <div class="mo" id="mEditTema">
            <div class="md mmd">
                <form id="formEditTema">
                    <input type="hidden" id="editTemaId">
                    <div class="mh">
                        <div>
                            <div class="mt2">Edit Tema</div>
                        </div>
                        <button type="button" class="mc">✕</button>
                    </div>
                    <div class="mb">
                        <div class="ff">
                            <label>Nama Tema</label>
                            <input id="editNamaTema" name="name" placeholder="Nama tema..." required />
                        </div>
                        <div id="errorEditTema" class="al ale" style="display:none"></div>
                    </div>
                    <div class="mf">
                        <button type="button" class="btn btn-save-edit-tema bp" style="width:100%; justify-content:center;">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal: Edit Sub Tema --}}
        <div class="mo" id="mEditSubTema">
            <div class="md msm">
                <form id="formEditSubTema">
                    <input type="hidden" id="editSubTemaId">
                    <div class="mh">
                        <div>
                            <div class="mt2">Edit Sub Tema</div>
                        </div>
                        <button type="button" class="mc">✕</button>
                    </div>
                    <div class="mb">
                        <div class="fr c2">
                            <div class="ff">
                                <label>Minggu Ke-</label>
                                <input type="number" id="editMingguKeSubTema" name="minggu_ke" placeholder="Misal: 1" required min="1" max="50" />
                            </div>
                            <div class="ff">
                                <label>Nama Sub Tema</label>
                                <input id="editNamaSubTema" name="name" placeholder="Nama sub tema..." required />
                            </div>
                        </div>
                        <div id="errorEditSubTema" class="al ale" style="display:none"></div>
                    </div>
                    <div class="mf">
                        <button type="button" class="btn bp btn-save-edit-subtema" style="width:100%; justify-content:center;">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <style>
        @keyframes blinkRed {
            0% { opacity: 1; }
            50% { opacity: 0.3; }
            100% { opacity: 1; }
        }
        .blink-red {
            animation: blinkRed 1.5s infinite;
        }
        @keyframes blinkYellow {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        .blink-yellow {
            animation: blinkYellow 1.5s infinite;
        }
        @keyframes blinkGreen {
            0% { opacity: 1; }
            50% { opacity: 0.3; }
            100% { opacity: 1; }
        }
        .blink-green {
            animation: blinkGreen 1.5s infinite;
        }
    </style>
    <script>
        $(function() {
            $('#btnTambahTema').on('click', function() {
                $('#mTema').addClass('on');
            });

            $('#mTema').on('click', '.mc, .btn.bo', function() {
                $('#formTambahTema')[0].reset();
                $('#subTemaList > div:not(:first)').remove();
                $('#errorTema').hide().text('');
            });

            $('#mSubTema').on('click', '.mc, .btn.bo', function() {
                $('#formTambahSubTema')[0].reset();
                $('#errorSubTema').hide().text('');
            });

            $('#btnAddSubTemaRow').on('click', function() {
                var row = `
                    <div style="display:flex; gap:10px;">
                        <input type="number" name="sub_tema_minggu[]" placeholder="Mg Ke" style="width:80px" required min="1" max="50">
                        <input type="text" name="sub_tema_name[]" placeholder="Nama sub tema..." style="flex:1" required>
                        <button type="button" class="btn bd bxs btn-remove-subtema-row" style="padding:0 10px;">✕</button>
                    </div>
                `;
                $('#subTemaList').append(row);
            });

            $(document).on('click', '.btn-remove-subtema-row', function() {
                if ($('#subTemaList > div').length > 1) {
                    $(this).parent().remove();
                } else {
                    showToast('⚠️ Minimal harus ada 1 sub tema', 'error');
                }
            });

            $(document).on('submit', '#formTambahTema', function(e) {
                e.preventDefault();

                var subTemaArray = [];
                $('#subTemaList > div').each(function() {
                    var mg = $(this).find('input[name="sub_tema_minggu[]"]').val();
                    var nm = $(this).find('input[name="sub_tema_name[]"]').val();
                    if (mg && nm) {
                        subTemaArray.push({ minggu_ke: mg, name: nm });
                    }
                });

                var $btn = $(this).find('button[type="submit"]');
                var originalText = $btn.text();
                $btn.prop('disabled', true).text('Menyimpan...');

                var payload = {
                    name: $('#inputNamaTema').val(),
                    semester: $('#inputSemesterTema').val(),
                    sub_tema: subTemaArray,
                    _token: '{{ csrf_token() }}',
                };

                $.post('{{ route('kelola_tema.store') }}', payload)
                    .done(function() {
                        $('#mTema').removeClass('on');
                        $('#formTambahTema')[0].reset();
                        showToast('✅ Tema berhasil ditambahkan');
                        location.reload();
                    })
                    .fail(function(xhr) {
                        $btn.prop('disabled', false).text(originalText);
                        var pesan = 'Gagal menyimpan tema.';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                pesan = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                            } else if (xhr.responseJSON.message) {
                                pesan = xhr.responseJSON.message;
                            }
                        }
                        $('#errorTema').html(pesan).show();
                    });
            });

        $(document).on('click', '.btn-lihat-alasan', function() {
            var alasan = $(this).data('alasan');
            Swal.fire({
                title: 'Alasan Pengembalian',
                text: alasan,
                icon: 'warning',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#000',
                customClass: {
                    container: 'swal-chat-style'
                }
            });
        });

        $(document).on('click', '.btn-hapus-tema', function() {
            var id = $(this).data('id');
            window.confirmAction('Hapus Tema ini beserta semua Sub Temanya?', function() {
                $.ajax({
                    url: '/kelola-tema/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                }).done(function() {
                    $('[data-tema-id="' + id + '"]').remove();
                    showToast('🗑️ Tema berhasil dihapus');
                }).fail(function() {
                    showToast('❌ Gagal menghapus Tema');
                });
            });
        });

        $(document).on('click', '.btn-hapus-sub-tema', function() {
            var id = $(this).data('id');
            var $chip = $(this).closest('.chip-sub-tema');
            window.confirmAction('Hapus Sub Tema ini?', function() {
                $.ajax({
                    url: '/kelola-tema/sub-tema/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                }).done(function() {
                    $chip.remove();
                    showToast('🗑️ Sub Tema berhasil dihapus');
                }).fail(function() {
                    showToast('❌ Gagal menghapus Sub Tema');
                });
            });
        });

        $(document).on('click', '.btn-ajukan-tema', function() {
            var id = $(this).data('id');
            window.confirmAction('Ajukan Tema ini ke Kepala Sekolah?', function() {
                $.post('/kelola-tema/' + id + '/ajukan', { _token: '{{ csrf_token() }}' })
                    .done(function(res) {
                        showToast('✅ Berhasil diajukan');
                        setTimeout(function() { location.reload(); }, 500);
                    })
                    .fail(function(xhr) {
                        showToast('❌ Gagal mengajukan');
                    });
            });
        });

        // Edit Tema
        $(document).on('click', '.btn-edit-tema', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#editTemaId').val(id);
            $('#editNamaTema').val(name);
            $('#mEditTema').addClass('on');
        });

        $('#mEditTema').on('click', '.mc', function() {
            $('#mEditTema').removeClass('on');
        });

            $('.btn-save-edit-tema').on('click', function(e) {
                e.preventDefault();
                var btn = $(this);
                btn.prop('disabled', true).text('Menyimpan...');

                var id = $('#editTemaId').val();
                
                if (!$('#editNamaTema').val()) {
                    btn.prop('disabled', false).text('💾 Simpan Perubahan');
                    $('#errorEditTema').html('Nama tema wajib diisi').show();
                    return;
                }

                var payload = {
                    name: $('#editNamaTema').val(),
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT'
                };

                $.post('/kelola-tema/' + id, payload)
                    .done(function(res) {
                        $('#mEditTema').removeClass('on');
                        showToast(res.message);
                        setTimeout(function() { location.reload(); }, 500);
                    })
                    .fail(function(xhr) {
                        var errors = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors : {name: ['Gagal menyimpan']};
                        $('#errorEditTema').html(Object.values(errors).map(e => e[0]).join('<br>')).show();
                        btn.prop('disabled', false).text('💾 Simpan Perubahan');
                    });
            });

        // Edit Sub Tema
        $(document).on('click', '.btn-edit-sub-tema', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var minggu = $(this).data('minggu');
            $('#editSubTemaId').val(id);
            $('#editNamaSubTema').val(name);
            $('#editMingguKeSubTema').val(minggu);
            $('#mEditSubTema').addClass('on');
        });

        $('#mEditSubTema').on('click', '.mc', function() {
            $('#mEditSubTema').removeClass('on');
        });

            $('.btn-save-edit-subtema').on('click', function(e) {
                e.preventDefault();
                var btn = $(this);
                btn.prop('disabled', true).text('Menyimpan...');

                var id = $('#editSubTemaId').val();
                
                if (!$('#editNamaSubTema').val()) {
                    btn.prop('disabled', false).text('💾 Simpan Perubahan');
                    $('#errorEditSubTema').html('Nama sub tema wajib diisi').show();
                    return;
                }

                var payload = {
                    minggu_ke: $('#editMingguKeSubTema').val(),
                    name: $('#editNamaSubTema').val(),
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT'
                };

                $.post('/kelola-tema/sub-tema/' + id, payload)
                    .done(function(res) {
                        $('#mEditSubTema').removeClass('on');
                        showToast(res.message);
                        setTimeout(function() { location.reload(); }, 500);
                    })
                    .fail(function(xhr) {
                        btn.prop('disabled', false).text('💾 Simpan Perubahan');
                        var errors = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors : {name: ['Gagal menyimpan']};
                        var pesan = Object.values(errors).flat().join('<br>');
                        $('#errorEditSubTema').html(pesan).show();
                    });
            });
        });
    </script>
@endpush
