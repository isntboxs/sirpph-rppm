@extends('layout.app')

@section('page-title', 'Bentuk & Alat')
@section('page-subtitle', \App\Models\DataSekolah::getData()?->name  . ' - ' . \App\Models\TahunAjaran::getActive()?->name)

@section('content')
    <div class="g2" style="gap:14px">

        {{-- Bentuk Kegiatan --}}
        <div class="card">
            <div class="ch">
                <div>
                    <div class="ct">🎭 Bentuk Kegiatan</div>
                    <div class="cs">Template pilihan guru saat buat RPPH</div>
                </div>
                <button class="btn bp bsm" id="btnTambahBentuk">+ Tambah</button>
            </div>
            <div class="fl fw g8" id="listBentuk">
                @foreach ($bentuk as $item)
                    <div class="fl ic g8"
                        style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px">
                        <span style="font-size:12px;font-weight:600">{{ $item->name }}</span>
                        <button class="btn-hapus-bentuk" data-id="{{ $item->id }}"
                            style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Alat & Bahan --}}
        <div class="card">
            <div class="ch">
                <div>
                    <div class="ct">🔧 Alat & Bahan</div>
                    <div class="cs">Alat yang tersedia di sekolah</div>
                </div>
                <button class="btn bp bsm" id="btnTambahAlat">+ Tambah</button>
            </div>
            <div class="al alw mb16">⚠️ Hapus alat/bahan jika tidak tersedia di sekolah.</div>
            <div class="fl fw g8" id="listAlat">
                @foreach ($alat as $item)
                    <div class="fl ic g8"
                        style="padding:7px 12px;background:var(--g0);border:1px solid var(--g2);border-radius:20px">
                        <span style="font-size:12px;font-weight:600">{{ $item->name }}</span>
                        <button class="btn-hapus-alat" data-id="{{ $item->id }}"
                            style="background:none;color:var(--red);font-size:12px;cursor:pointer;border:none">✕</button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Modal: Tambah Bentuk Kegiatan --}}
    <div class="mo" id="mBentuk">
        <div class="md msm">
            <form id="formTambahBentuk">
                <div class="mh">
                    <div>
                        <div class="mt2">Tambah Bentuk Kegiatan</div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">
                    <div class="ff">
                        <label>Nama Bentuk Kegiatan</label>
                        <input id="inputBentuk" name="name" placeholder="Contoh: Mewarnai, Kolase..." />
                    </div>
                </div>
                <div class="mf">
                    <button type="submit" class="btn bp btn-submit-form">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Tambah Alat Bahan --}}
    <div class="mo" id="mAlat">
        <div class="md msm">
            <form id="formTambahAlat">
                <div class="mh">
                    <div>
                        <div class="mt2">Tambah Alat & Bahan</div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">
                    <div class="ff">
                        <label>Nama Alat / Bahan</label>
                        <input id="inputAlat" name="name" placeholder="Contoh: Crayon, HVS..." />
                    </div>
                </div>
                <div class="mf">
                    <button type="submit" class="btn bp btn-submit-form">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#mBentuk').on('click', '.mc, .btn.bo', function() {
                $('#formTambahBentuk')[0].reset();
            });

            $('#mAlat').on('click', '.mc, .btn.bo', function() {
                $('#formTambahAlat')[0].reset();
            });
 
            $('#btnTambahBentuk').on('click', function() {
                $('#mBentuk').addClass('on');
            });

            $('#formTambahBentuk').on('submit', function(e) {
                e.preventDefault();
                if($('#inputBentuk').val() === '') {
                    showToast('Nama Kegiatan Wajib Di isi');
                    return;
                }
                $.post('{{ route('master_bentuk_alat.bentuk.store') }}', {
                        name: $('#inputBentuk').val(),
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(res) {
                        $('#mBentuk').removeClass('on');
                        showToast('✅ Bentuk kegiatan berhasil ditambahkan');
                        location.reload();
                    })
                    .fail(function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        alert(errors.name[0]);
                    });
            });

            $(document).on('click', '.btn-hapus-bentuk', function() {
                var id = $(this).data('id');
                var $chip = $(this).closest('div.fl');

                if (!confirm('Hapus bentuk kegiatan ini?')) return;

                $.ajax({
                        url: '/master-bentuk-alat/bentuk/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                    })
                    .done(function() {
                        $chip.remove();
                        showToast('🗑️ Bentuk kegiatan dihapus');
                    });
            });

            $('#btnTambahAlat').on('click', function() {
                $('#mAlat').addClass('on');
            });

            $('#formTambahAlat').on('submit', function(e) {
                e.preventDefault();
                if($('#inputAlat').val() === '') {
                    showToast('Nama Alat Wajib Di isi');
                    return;
                }
                $.post('{{ route('master_bentuk_alat.alat.store') }}', {
                        name: $('#inputAlat').val(),
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(res) {
                        $('#mAlat').removeClass('on');
                        showToast('✅ Alat/bahan berhasil ditambahkan');
                        location.reload();
                    })
                    .fail(function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        alert(errors.name[0]);
                    });
            });

            $(document).on('click', '.btn-hapus-alat', function() {
                var id = $(this).data('id');
                var $chip = $(this).closest('div.fl');

                if (!confirm('Hapus alat/bahan ini?')) return;

                $.ajax({
                        url: '/master-bentuk-alat/alat/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                    })
                    .done(function() {
                        $chip.remove();
                        showToast('🗑️ Alat/bahan dihapus');
                    });
            });
        })
    </script>
@endpush
