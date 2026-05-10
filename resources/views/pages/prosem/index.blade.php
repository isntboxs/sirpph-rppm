@extends('layout.app')

@section('page-title', 'Program Semester (PROSEM)')
@section('page-subtitle', $taAktif?->name ?? '-')

@section('content')

    <div class="card">
        <div class="ch mb16">
            <div>
                <div class="ct">📊 Input Program Semester</div>
            </div>
            <div class="fl g8 fb">
                <button type="button" class="btn bp bsm" id="btnTambahProsem">
                    + Tambah Baris
                </button>
            </div>
        </div>

        <div class="tw">
            <table>
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:22%">Tema</th>
                        <th style="width:25%">Sub Tema</th>
                        <th style="width:10%; text-align:center;">Minggu Ke</th>
                        <th style="width:10%; text-align:center;">Alokasi</th>
                        <th style="width:12%; text-align:center;">Status</th>
                        <th style="width:16%; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse ($prosems as $temaId => $items)
                        @foreach ($items as $i => $prosem)
                            <tr id="row-prosem-{{ $prosem->id }}">
                                @if ($i === 0)
                                    <td rowspan="{{ $items->count() }}"
                                        style="text-align:center;font-weight:700;
                                           background:var(--g0);vertical-align:middle">
                                        {{ $no++ }}
                                    </td>
                                    <td rowspan="{{ $items->count() }}"
                                        style="font-weight:700;background:var(--g0);
                                           vertical-align:middle">
                                        {{ $prosem->tema->name }}
                                    </td>
                                @endif

                                <td>{{ $prosem->subTema->name }}</td>

                                <td style="text-align:center">
                                    <div
                                        style="width:32px;height:32px;background:var(--g6);
                                            color:white;border-radius:50%;display:flex;
                                            align-items:center;justify-content:center;
                                            font-size:12px;font-weight:700;margin:0 auto">
                                        {{ $prosem->minggu_ke }}
                                    </div>
                                </td>

                                <td style="text-align:center">1 Minggu</td>

                                <td style="justify-content:center; align-items:center; text-align:center; vertical-align:middle;">
                                    <span class="bdg {{ $prosem->status_badge_class }}">
                                        {{ $prosem->status_label }}
                                    </span>
                                    @if ($prosem->status === 'invalid' && $prosem->catatan)
                                        <div class="fs11 mt4" style="color:var(--red);line-height:1.4">
                                            📝 {{ $prosem->catatan }}
                                        </div>
                                    @endif
                                </td>

                                <td style="text-align:center; vertical-align:middle;">
                                    <div class="fl g8" style="justify-content:center; align-items:center;">
                                        @if ($prosem->status !== 'valid')
                                            <button type="button" class="btn bp bxs btn-edit-prosem"
                                                data-id="{{ $prosem->id }}" data-tema-id="{{ $prosem->tema_id }}"
                                                data-tema-name="{{ $prosem->tema->name }}"
                                                data-sub-tema-id="{{ $prosem->sub_tema_id }}"
                                                data-sub-tema-name="{{ $prosem->subTema->name }}"
                                                data-minggu="{{ $prosem->minggu_ke }}"
                                                data-ta-id="{{ $prosem->tahun_ajaran_id }}">
                                                ✏️ Edit
                                            </button>
                                            <button type="button" class="btn bd bxs btn-hapus-prosem"
                                                data-id="{{ $prosem->id }}">
                                                🗑️
                                            </button>
                                        @else
                                            <span class="fs11 tc2">Sudah Divalidasi</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:32px;color:var(--txt3)">
                                Belum ada data PROSEM. Klik "+ Tambah Baris" untuk mulai.
                            </td>
                        </tr>
                    @endforelse

                    @if ($prosems->isNotEmpty())
                        <tr style="background:var(--g1)">
                            <td colspan="4" style="text-align:center;font-weight:700;padding:8px">
                                JUMLAH
                            </td>
                            <td style="text-align:center;font-weight:700">
                                {{ $prosems->flatten()->count() }} Minggu
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal: Tambah Baris PROSEM --}}
    <div class="mo" id="mTambahProsem">
        <div class="md mmd">
            <form id="formTambahProsem">
                <div class="mh">
                    <div>
                        <div class="mt2">+ Tambah Baris PROSEM</div>
                        <div class="mst" style="color:var(--txt3)">
                            Sub tema hanya bisa dipakai 1 minggu per semester
                        </div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">
                    <div class="fr c2">
                        <div class="ff">
                            <label>Tema</label>
                            <select id="inputTambahTema" name="tema_id">
                                <option value="">-- Pilih Tema --</option>
                                @foreach ($temas as $tema)
                                    <option value="{{ $tema->id }}">
                                        {{ $tema->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ff">
                            <label>Sub Tema</label>
                            <select id="inputTambahSubTema" name="sub_tema_id" disabled>
                                <option value="">-- Pilih Tema Dulu --</option>
                            </select>
                        </div>
                    </div>
                    <div class="ff">
                        <label>Minggu Ke</label>
                        <input id="inputTambahMinggu" name="minggu_ke" type="number" min="1" max="34"
                            placeholder="Contoh: 1" />
                    </div>
                    <div id="errorTambahProsem" class="al ale mt8" style="display:none"></div>
                </div>
                <div class="mf">
                    <button type="submit" class="btn bp btn-submit-form">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Edit Baris PROSEM --}}
    <div class="mo" id="mEditProsem">
        <div class="md mmd">
            <form id="formEditProsem">
                <input type="hidden" id="inputEditProsemId" />
                <input type="hidden" id="inputEditProsemTaId" />
                <div class="mh">
                    <div>
                        <div class="mt2">✏️ Edit Baris PROSEM</div>
                        <div class="mst" id="labelEditProsem" style="color:var(--txt3)"></div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">
                    <div class="fr c2">
                        <div class="ff">
                            <label>Tema</label>
                            <select id="inputEditTema" name="tema_id">
                                <option value="">-- Pilih Tema --</option>
                                @foreach ($temas as $tema)
                                    <option value="{{ $tema->id }}">
                                        {{ $tema->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ff">
                            <label>Sub Tema</label>
                            <select id="inputEditSubTema" name="sub_tema_id" disabled>
                                <option value="">-- Pilih Tema Dulu --</option>
                            </select>
                        </div>
                    </div>
                    <div class="ff">
                        <label>Minggu Ke</label>
                        <input id="inputEditMinggu" name="minggu_ke" type="number" min="1" max="34" />
                    </div>
                    <div id="errorEditProsem" class="al ale mt8" style="display:none"></div>
                </div>
                <div class="mf">
                    <button type="button" class="btn bo">Batal</button>
                    <button type="submit" class="btn bp btn-submit-form">💾 Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        var taAktifId = {{ $taAktif?->id ?? 'null' }};

        $('#btnTambahProsem').on('click', function() {
            $('#formTambahProsem')[0].reset();
            $('#inputTambahSubTema').html('<option value="">-- Pilih Tema Dulu --</option>').prop('disabled', true);
            $('#errorTambahProsem').hide();
            $('#mTambahProsem').addClass('on');
        });

        $('#mTambahProsem').on('click', '.mc, .btn.bo', function() {
            $('#formTambahProsem')[0].reset();
            $('#errorTambahProsem').hide();
        });

        $('#inputTambahTema').on('change', function() {
            loadSubTema($(this).val(), '#inputTambahSubTema', taAktifId, null);
        });

        $('#inputEditTema').on('change', function() {
            var excludeId = $('#inputEditProsemId').val();
            loadSubTema($(this).val(), '#inputEditSubTema', $('#inputEditProsemTaId').val(), excludeId);
        });

        function loadSubTema(temaId, targetSelector, taId, excludeId) {
            var $sel = $(targetSelector);

            if (!temaId) {
                $sel.html('<option value="">-- Pilih Tema Dulu --</option>').prop('disabled', true);
                return;
            }

            $sel.html('<option>Memuat...</option>').prop('disabled', true);

            var url = '/prosem/sub-tema/' + temaId + '?ta_id=' + taId;
            if (excludeId) url += '&exclude_id=' + excludeId;

            $.get(url, function(data) {
                var options = '<option value="">-- Pilih Sub Tema --</option>';
                $.each(data, function(i, s) {
                    var disabled = s.terpakai ? 'disabled' : '';
                    var label = s.terpakai ? s.name + ' (sudah dipakai)' : s.name;
                    options += '<option value="' + s.id + '" ' + disabled + '>' + label + '</option>';
                });
                $sel.html(options).prop('disabled', false);
            });
        }

        $('#formTambahProsem').on('submit', function(e) {
            e.preventDefault();

            $.post('{{ route('prosem.store') }}', {
                    tahun_ajaran_id: taAktifId,
                    tema_id: $('#inputTambahTema').val(),
                    sub_tema_id: $('#inputTambahSubTema').val(),
                    minggu_ke: $('#inputTambahMinggu').val(),
                    _token: '{{ csrf_token() }}',
                })
                .done(function() {
                    $('#mTambahProsem').removeClass('on');
                    showToast('✅ Baris PROSEM berhasil ditambahkan');
                    setTimeout(function() {
                        location.reload();
                    }, 700);
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var pesan = Object.values(errors).flat().join('<br>');
                    $('#errorTambahProsem').html(pesan).show();
                });
        });

        $(document).on('click', '.btn-edit-prosem', function() {
            var $btn = $(this);
            var id = $btn.data('id');
            var temaId = $btn.data('tema-id');
            var subTemaId = $btn.data('sub-tema-id');
            var minggu = $btn.data('minggu');
            var taId = $btn.data('ta-id');

            $('#inputEditProsemId').val(id);
            $('#inputEditProsemTaId').val(taId);
            $('#labelEditProsem').text($btn.data('tema-name') + ' - ' + $btn.data('sub-tema-name'));
            $('#inputEditMinggu').val(minggu);
            $('#errorEditProsem').hide();

            $('#inputEditTema').val(temaId);

            loadSubTema(temaId, '#inputEditSubTema', taId, id);

            setTimeout(function() {
                $('#inputEditSubTema').val(subTemaId);
            }, 600);

            $('#mEditProsem').addClass('on');
        });

        $('#mEditProsem').on('click', '.mc, .btn.bo', function() {
            $('#formEditProsem')[0].reset();
            $('#errorEditProsem').hide();
        });

        $('#formEditProsem').on('submit', function(e) {
            e.preventDefault();

            var id = $('#inputEditProsemId').val();

            $.ajax({
                    url: '/prosem/' + id,
                    type: 'PUT',
                    data: {
                        tema_id: $('#inputEditTema').val(),
                        sub_tema_id: $('#inputEditSubTema').val(),
                        minggu_ke: $('#inputEditMinggu').val(),
                        _token: '{{ csrf_token() }}',
                    },
                })
                .done(function() {
                    $('#mEditProsem').removeClass('on');
                    showToast('✅ Baris PROSEM berhasil diupdate');
                    setTimeout(function() {
                        location.reload();
                    }, 700);
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var pesan = Object.values(errors).flat().join('<br>');
                    $('#errorEditProsem').html(pesan).show();
                });
        });

        $(document).on('click', '.btn-hapus-prosem', function() {
            var id = $(this).data('id');
            if (!confirm('Hapus baris PROSEM ini?')) return;

            $.ajax({
                    url: '/prosem/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                })
                .done(function() {
                    showToast('🗑️ Baris PROSEM dihapus');
                    setTimeout(function() {
                        location.reload();
                    }, 700);
                })
                .fail(function(xhr) {
                    showToast('❌ ' + xhr.responseJSON.message);
                });
        });
    </script>
@endpush
