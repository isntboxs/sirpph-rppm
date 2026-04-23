@extends('layout.app')

@section('page-title', 'Kelola Tema')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
    <div class="card">
        <div class="ch" style="margin-bottom:16px">
            <div></div>
            <button type="button" class="btn bp bsm" id="btnTambahTema">+ Tambah Tema</button>
        </div>
        <div class="g2" style="gap:12px" id="listTema">
            @forelse ($temas as $tema)
                <div class="card" style="border-color:var(--g2)" data-tema-id="{{ $tema->id }}">
                    <div class="ch">
                        <div>
                            <div class="ct">{{ $tema->name }}</div>
                            <div class="cs">{{ $tema->semester_label }} — {{ $tema->subTemas->count() }} Sub Tema</div>
                        </div>
                        <button type="button" class="btn bd bxs btn-hapus-tema" data-id="{{ $tema->id }}">🗑️</button>
                    </div>
                    <div class="fl fw g8">
                        @foreach ($tema->subTemas as $sub)
                            <span class="chip-sub-tema" data-id="{{ $sub->id }}"
                                style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">
                                {{ $sub->name }}
                                <button type="button" class="btn-hapus-sub-tema" data-id="{{ $sub->id }}"
                                    style="background:none;color:var(--red);font-size:11px;cursor:pointer;border:none;line-height:1">✕</button>
                            </span>
                        @endforeach
                        <button type="button" class="btn-tambah-sub-tema" data-tema-id="{{ $tema->id }}"
                            data-tema-name="{{ $tema->name }}"
                            style="padding:4px 10px;background:var(--g1);border:1px dashed var(--g4);border-radius:20px;font-size:11.5px;cursor:pointer;color:var(--g7)">
                            + Sub Tema
                        </button>
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
                            <label>Sub Tema (satu per baris)</label>
                            <textarea id="inputSubTema" name="sub_tema" rows="5"
                                placeholder="Allah Tuhanku&#10;Identitasku&#10;Tubuhku / Aurat"></textarea>
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
                        <div class="ff">
                            <label>Nama Sub Tema</label>
                            <input id="inputNamaSubTema" name="name" placeholder="Nama sub tema..." />
                        </div>
                        <div id="errorSubTema" class="al ale" style="display:none"></div>
                    </div>
                    <div class="mf">
                        <button type="submit" class="btn bp btn-submit-form">💾 Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#btnTambahTema').on('click', function() {
            $('#mTema').addClass('on');
        });

        $('#mTema').on('click', '.mc, .btn.bo', function() {
            $('#formTambahTema')[0].reset();
            $('#errorTema').hide().text('');
        });

        $('#mSubTema').on('click', '.mc, .btn.bo', function() {
            $('#formTambahSubTema')[0].reset();
            $('#errorSubTema').hide().text('');
        });

        $('#formTambahTema').on('submit', function(e) {
            e.preventDefault();

            var subTemaLines = $('#inputSubTema').val()
                .split('\n')
                .map(function(s) {
                    return s.trim();
                })
                .filter(function(s) {
                    return s !== '';
                });

            var payload = {
                name: $('#inputNamaTema').val(),
                semester: $('#inputSemesterTema').val(),
                sub_tema: subTemaLines,
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
                    var errors = xhr.responseJSON.errors;
                    var pesan = Object.values(errors).flat().join('<br>');
                    $('#errorTema').html(pesan).show();
                });
        });

        $(document).on('click', '.btn-hapus-tema', function() {
            var id = $(this).data('id');

            if (!confirm('Hapus tema ini beserta semua sub temanya?')) return;

            $.ajax({
                    url: '/kelola-tema/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                })
                .done(function() {
                    $('[data-tema-id="' + id + '"]').remove();
                    showToast('🗑️ Tema berhasil dihapus');
                });
        });

        $(document).on('click', '.btn-tambah-sub-tema', function() {
            var temaId = $(this).data('tema-id');
            var temaNama = $(this).data('tema-name');

            $('#inputSubTemaTemaId').val(temaId);
            $('#labelNamaTemaSubTema').text('Tema: ' + temaNama);
            $('#mSubTema').addClass('on');
        });

        $('#formTambahSubTema').on('submit', function(e) {
            e.preventDefault();

            var temaId = $('#inputSubTemaTemaId').val();

            $.post('/kelola-tema/' + temaId + '/sub-tema', {
                    name: $('#inputNamaSubTema').val(),
                    _token: '{{ csrf_token() }}',
                })
                .done(function(res) {
                    $('#mSubTema').removeClass('on');
                    $('#formTambahSubTema')[0].reset();
                    showToast('✅ Sub tema berhasil ditambahkan');
                    location.reload();
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('#errorSubTema').text(errors.name[0]).show();
                });
        });

        $(document).on('click', '.btn-hapus-sub-tema', function() {
            var id = $(this).data('id');
            var $chip = $(this).closest('.chip-sub-tema');

            if (!confirm('Hapus sub tema ini?')) return;

            $.ajax({
                    url: '/kelola-tema/sub-tema/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                })
                .done(function() {
                    $chip.remove();
                    showToast('🗑️ Sub tema berhasil dihapus');
                });
        });
    </script>
@endpush
