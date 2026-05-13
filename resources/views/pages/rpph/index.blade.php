@extends('layout.app')

@section('page-title', 'Buat & Kelola RPPH')
@section('page-subtitle', $taAktif?->name ?? '-')

@section('content')

    @forelse ($rppms as $rppm)
        <div class="card mb16">

            {{-- Header RPPM --}}
            <div class="ch mb12">
                <div>
                    <div class="fs11 tc2">
                        Minggu ke-{{ $rppm->minggu_ke }} •
                        {{ $rppm->periode ?? '-' }}
                    </div>
                    <div class="ct">{{ $rppm->subTema->tema->name }}</div>
                    <div class="rs">{{ $rppm->subTema->name }}</div>
                </div>
                <div class="fl ic g8">
                    <span class="bdg bok">RPPM Disetujui</span>
                    @if ($rppm->rpphs->isEmpty())
                        <button type="button" class="btn bp bsm btn-generate-rpph" data-id="{{ $rppm->id }}">
                            ⚡ Generate RPPH
                        </button>
                    @else
                        <button type="button" class="btn bo bsm btn-generate-rpph" data-id="{{ $rppm->id }}">
                            Refresh
                        </button>
                    @endif
                </div>
            </div>

            {{-- Status & kalender tanggal per hari --}}
            @php
                $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                $bulanNama = $rppm->bulan_nama;
                $tahun = $rppm->tahun;
            @endphp

            @foreach ($hariList as $hari)
                @php
                    $kegiatanHari = $rppm->rppmKegiatans->where('hari', $hari);
                    $rpph = $rppm->rpphs->where('hari', $hari)->first();
                @endphp

                @if ($kegiatanHari->isNotEmpty())
                    <div class="ds mb8">
                        <div class="dsh">
                            <div class="fl ic g8">
                                <span class="dn">📅 {{ $hari }}</span>
                                @if ($rpph?->tanggal)
                                    <span class="bdg bok" style="font-size:10.5px">
                                        {{ $rpph->tanggal->locale('id')->translatedFormat('d M Y') }}
                                    </span>
                                @else
                                    <span class="bdg bpnd" style="font-size:10.5px">
                                        ⚠️ Belum ada tanggal
                                    </span>
                                @endif
                            </div>

                            <div class="fl ic g8">
                                @if ($rpph)
                                    <span class="bdg {{ $rpph->status_badge_class }}">
                                        {{ $rpph->status_label }}
                                    </span>

                                    @if (in_array($rpph->status, ['draft', 'dikembalikan']))
                                        <button type="button" class="btn bp bxs btn-edit-rpph"
                                            data-id="{{ $rpph->id }}" data-rppm-id="{{ $rppm->id }}"
                                            data-hari="{{ $hari }}" data-subtema="{{ $rppm->subTema->name }}"
                                            data-sub-sub-tema="{{ $rpph->sub_sub_tema }}"
                                            data-tanggal="{{ $rpph->tanggal?->format('Y-m-d') }}"
                                            data-kelas-id="{{ $rpph->kelas_id }}" data-pembuka="{{ $rpph->pembuka }}"
                                            data-inti="{{ $rpph->inti }}" data-recalling="{{ $rpph->recalling }}"
                                            data-penutup="{{ $rpph->penutup }}">
                                            Edit
                                        </button>
                                        <button type="button" class="btn ba bxs btn-ajukan-rpph"
                                            data-id="{{ $rpph->id }}" data-hari="{{ $hari }}">
                                            📤 Ajukan
                                        </button>
                                    @endif

                                    @if ($rpph->status === 'dikembalikan' && $rpph->catatan_kepala)
                                        {{-- catatan ditampilkan di bawah --}}
                                    @endif
                                @else
                                    <span class="fs11 tc2">Belum di-generate</span>
                                @endif
                            </div>
                        </div>

                        {{-- Kegiatan hari ini --}}
                        @foreach ($kegiatanHari as $rk)
                            <div class="dki">
                                <div>
                                    <span style="font-weight:700;font-size:12.5px">
                                        {{ $rk->kegiatan->foto_icon }}
                                        {{ $rk->kegiatan->name }}
                                    </span>
                                    <span class="fs11 tc2">
                                        ({{ $rk->kegiatan->bentukKegiatan->name }})
                                    </span>
                                    <div class="fl fw g8 mt4">
                                        @foreach ($rk->kegiatan->aspeks as $aspek)
                                            <span class="ap {{ $aspek->warna }}">
                                                {{ $aspek->emote }} {{ $aspek->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Catatan kepala jika dikembalikan --}}
                        @if ($rpph && $rpph->status === 'dikembalikan' && $rpph->catatan_kepala)
                            <div class="al ale mt8" style="font-size:11.5px">
                                📝 Catatan Kepala Sekolah: {{ $rpph->catatan_kepala }}
                            </div>
                        @endif

                        {{-- Sub-sub tema & penilaian jika sudah diisi --}}
                        @if ($rpph && ($rpph->sub_sub_tema || $rpph->penilaians->isNotEmpty()))
                            <div class="mt8 fl fw g8">
                                @if ($rpph->sub_sub_tema)
                                    <span class="bdg bdr">
                                        📌 {{ $rpph->sub_sub_tema }}
                                    </span>
                                @endif
                                @if ($rpph->penilaians->isNotEmpty())
                                    <span class="bdg bsk">
                                        📋 {{ $rpph->penilaians->count() }} sub bab penilaian
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach

            {{-- Progress tanggal di bulan ini --}}
            @if ($rppm->bulan)
                @php
                    $rpphDenganTanggal = $rppm->rpphs->whereNotNull('tanggal')->count();
                    $totalRpph = $rppm->rpphs->count();
                @endphp
                <div class="fl ic g8 mt8">
                    <span class="fs11 tc2">
                        📅 {{ $bulanNama }} {{ $tahun }} -
                        {{ $rpphDenganTanggal }}/{{ $totalRpph }} RPPH sudah punya tanggal
                    </span>
                    @if ($rpphDenganTanggal === $totalRpph && $totalRpph > 0)
                        <span class="bdg bok" style="font-size:10.5px">Lengkap</span>
                    @endif
                </div>
            @endif

        </div>
    @empty
        <div class="emp">
            <div class="ei">📅</div>
            <h3>Belum ada RPPH</h3>
            <p>RPPH dibuat dari RPPM yang sudah disetujui.
                Pastikan RPPM sudah disetujui lalu klik Generate RPPH.</p>
            <a href="{{ route('rppm') }}" class="btn bp" style="margin-top:12px">
                ← Ke Halaman RPPM
            </a>
        </div>
    @endforelse

    {{-- Modal: Edit Detail RPPH --}}
    <div class="mo" id="mEditRpph">
        <div class="md mxl">
            <form id="formEditRpph">
                <input type="hidden" id="inputRpphId" />
                <input type="hidden" id="inputRppmId" />
                <div class="mh">
                    <div>
                        <div class="mt2">Edit RPPH</div>
                        <div class="mst" id="labelSubTemaRpph" style="color:var(--txt3)"></div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">

                    {{-- Baris 1: Hari, Tanggal, Kelas --}}
                    <div class="fr c3 mb12">
                        <div class="ib">
                            <div class="ik">Hari</div>
                            <div class="iv" id="displayHariRpph">-</div>
                        </div>
                        <div class="ff">
                            <label>
                                Tanggal Pelaksanaan
                                <span class="fs11" style="color:var(--red)">*</span>
                            </label>
                            <input type="date" id="inputTanggalRpph" name="tanggal" />
                            <div class="fs11 tc2 mt4" id="infoBulanRpph"></div>
                            <div class="fs11 mt4" style="color:var(--red);display:none" id="errorTanggalRpph"></div>
                        </div>
                        <div class="ff">
                            <label>Kelas</label>
                            <select id="inputKelasRpph" name="kelas_id">
                                <option value="">-- Pilih --</option>
                                @foreach (\App\Models\Kelas::all() as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Sub Tema (readonly) --}}
                    <div class="ib mb12"
                        style="background:var(--g0);border-radius:var(--r2);
                            padding:12px 15px;border-left:4px solid var(--g4)">
                        <div class="ik">Sub Tema</div>
                        <div class="iv" id="displaySubTemaRpph">-</div>
                    </div>

                    {{-- Sub-Sub Tema --}}
                    <div class="ff mb12">
                        <label>Sub-Sub Tema</label>
                        <input id="inputSubSubTema" name="sub_sub_tema"
                            placeholder="Contoh: Aku Bersyukur kepada Allah..." />
                    </div>

                    {{-- A. Pembuka --}}
                    <div class="ff mb12">
                        <label>A. Kegiatan Pembuka</label>
                        <textarea id="inputPembukaRpph" name="pembuka" rows="4"
                            placeholder="1. Penerapan SOP pembukaan&#10;2. Berdiskusi tentang...&#10;3. Mengenalkan kegiatan"></textarea>
                    </div>

                    {{-- B. Inti --}}
                    <div class="ff mb12">
                        <label>B. Kegiatan Inti</label>
                        <textarea id="inputIntiRpph" name="inti" rows="4"
                            placeholder="1. Guru menjelaskan...&#10;2. Anak melakukan...&#10;3. Anak menunjukkan hasil"></textarea>
                    </div>

                    {{-- C. Recalling --}}
                    <div class="ff mb12">
                        <label>C. Recalling</label>
                        <textarea id="inputRecallingRpph" name="recalling" rows="3"
                            placeholder="1. Merapikan alat-alat yang telah digunakan&#10;2. Diskusi tentang perasaan...&#10;3. Menceritakan kembali kegiatan yang telah dilakukan"></textarea>
                    </div>

                    {{-- D. Penutup --}}
                    <div class="ff mb12">
                        <label>D. Kegiatan Penutup</label>
                        <textarea id="inputPenutupRpph" name="penutup" rows="3"
                            placeholder="1. Menanyakan perasaannya&#10;2. Berdiskusi kegiatan hari ini&#10;3. Penerapan SOP penutup"></textarea>
                    </div>

                    {{-- E. Rencana Penilaian --}}
                    <div class="mb12">
                        <div class="fl jb ic mb8">
                            <label style="margin-bottom:0">E. Rencana Penilaian</label>
                            <button type="button" class="btn bp bxs" id="btnTambahSubBabPenilaian">
                                + Tambah Sub Bab
                            </button>
                        </div>

                        <div id="containerPenilaian">
                            {{-- Sub bab penilaian di-render oleh JS --}}
                        </div>
                    </div>
                </div>
                <div class="mf">
                    <button type="submit" class="btn bp btn-submit-form">💾 Simpan RPPH</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).on('click', '.btn-generate-rpph', function() {
            var id = $(this).data('id');
            $.post('/rppm/' + id + '/generate-rpph', {
                    _token: '{{ csrf_token() }}'
                })
                .done(function(res) {
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 800);
                })
                .fail(function(xhr) {
                    showToast('❌ ' + xhr.responseJSON.message);
                });
        });

        $(document).on('click', '.btn-edit-rpph', function() {
            penilaianIndex = 0;

            var $btn = $(this);
            var rpphId = $btn.data('id');
            var rppmId = $btn.data('rppm-id');
            var hari = $btn.data('hari');
            var subTema = $btn.data('subtema');

            $('#inputRpphId').val(rpphId);
            $('#inputRppmId').val(rppmId);
            $('#displayHariRpph').text(hari);
            $('#displaySubTemaRpph').text(subTema);
            $('#labelSubTemaRpph').text(hari + ' - ' + subTema);

            $('#inputSubSubTema').val($btn.data('sub-sub-tema') || '');
            $('#inputPembukaRpph').val($btn.data('pembuka') || '');
            $('#inputIntiRpph').val($btn.data('inti') || '');
            $('#inputRecallingRpph').val($btn.data('recalling') || '');
            $('#inputPenutupRpph').val($btn.data('penutup') || '');
            $('#inputKelasRpph').val($btn.data('kelas-id') || '');

            $('#errorTanggalRpph').hide().text('');
            $('#containerPenilaian').empty();

            $.get('/rpph/tanggal-terpakai/' + rppmId)
                .done(function(res) {
                    $('#inputTanggalRpph')
                        .attr('min', res.min_date)
                        .attr('max', res.max_date)
                        .val($btn.data('tanggal') || '');

                    $('#infoBulanRpph').text(
                        '📅 Harus di bulan ' + res.bulan_nama + ' ' + res.tahun
                    );

                    if (res.tanggal_terpakai.length > 0) {
                        $('#infoBulanRpph').append(
                            ' · Sudah terpakai: ' + res.tanggal_terpakai.join(', ')
                        );
                    }
                });

            loadPenilaianExisting(rpphId);

            $('#mEditRpph').addClass('on');
        });

        function loadPenilaianExisting(rpphId) {
            $.get('/rpph/' + rpphId + '/penilaian')
                .done(function(res) {
                    $('#containerPenilaian').empty();
                    if (res.data && res.data.length > 0) {
                        $.each(res.data, function(i, p) {
                            tambahSubBabPenilaian(p.nama, p.poins);
                        });
                    }
                })
                .fail(function() {
                    $('#containerPenilaian').empty();
                });
        }

        var penilaianIndex = 0;

        function tambahSubBabPenilaian(namaDefault, poinsDefault) {
            namaDefault = namaDefault || '';
            poinsDefault = poinsDefault || [];

            var idx = penilaianIndex++;
            var html = '<div class="penilaian-subbab mb12" data-idx="' + idx + '"' +
                ' style="border:2px solid var(--g2);border-radius:var(--r2);padding:13px">'

                +
                '<div class="fl jb ic mb8">' +
                '<input type="text" name="penilaians[' + idx + '][nama]"' +
                '       class="input-subbab-nama"' +
                '       value="' + esc(namaDefault) + '"' +
                '       placeholder="Nama sub bab, contoh: Sikap"' +
                '       style="flex:1;padding:7px 10px;border:2px solid var(--g1);' +
                '              border-radius:var(--r2);font-size:12.5px;margin-right:8px;"/>' +
                '<button type="button" class="btn bd bxs btn-hapus-subbab" data-idx="' + idx + '">✕</button>' +
                '</div>'

                +
                '<div class="container-poins" id="poins-' + idx + '">';

            if (poinsDefault.length > 0) {
                $.each(poinsDefault, function(j, poin) {
                    html += renderPoinRow(idx, j, typeof poin === 'object' ? poin.poin : poin);
                });
            } else {
                html += renderPoinRow(idx, 0, '');
            }

            html += '</div>' +
                '<button type="button" class="btn bo bxs mt8 btn-tambah-poin" data-idx="' + idx + '">' +
                '+ Tambah Poin' +
                '</button>' +
                '</div>';

            $('#containerPenilaian').append(html);
        }

        function esc(str) {
            return $('<div>').text(str || '').html();
        }

        function renderPoinRow(subIdx, poinIdx, value) {
            return '<div class="fl ic g8 mb6 poin-row">' +
                '<span class="fs11 tc2" style="width:18px;text-align:right;flex-shrink:0">' +
                (poinIdx + 1) + '.</span>' +
                '<input type="text"' +
                '       name="penilaians[' + subIdx + '][poins][' + poinIdx + ']"' +
                '       class="poin-input"' +
                '       value="' + (value || '') + '"' +
                '       placeholder="Poin penilaian..."' +
                '       style="flex:1;padding:6px 10px;border:2px solid var(--g1);' +
                '              border-radius:var(--r2);font-size:12px;margin-bottom:5px;"/>' +
                '<button type="button" class="btn bd bxs btn-hapus-poin">X</button>' +
                '</div>';
        }

        $('#btnTambahSubBabPenilaian').on('click', function() {
            tambahSubBabPenilaian();
        });

        $(document).on('click', '.btn-hapus-subbab', function() {
            $(this).closest('.penilaian-subbab').remove();
        });

        $(document).on('click', '.btn-tambah-poin', function() {
            var idx = $(this).data('idx');
            var $cont = $('#poins-' + idx);
            var count = $cont.find('.poin-row').length;
            $cont.append(renderPoinRow(idx, count, ''));
            renumberPoins($cont);
        });

        $(document).on('click', '.btn-hapus-poin', function() {
            var $cont = $(this).closest('.container-poins');
            $(this).closest('.poin-row').remove();
            renumberPoins($cont);
        });

        function renumberPoins($cont) {
            $cont.find('.poin-row').each(function(i) {
                $(this).find('span.fs11').text((i + 1) + '.');
            });
        }

        $('#mEditRpph').on('click', '.mc', function() {
            $('#mEditRpph').removeClass('on');
            $('#formEditRpph')[0].reset();
            $('#containerPenilaian').empty();
            $('#errorTanggalRpph').hide().text('');
            $('#infoBulanRpph').text('');
            penilaianIndex = 0;
        });

        $('#inputTanggalRpph').on('change', function() {
            var min = $(this).attr('min');
            var max = $(this).attr('max');
            var val = $(this).val();

            if (val && ((min && val < min) || (max && val > max))) {
                $('#errorTanggalRpph').text('Tanggal di luar bulan pelaksanaan RPPM.').show();
            } else {
                $('#errorTanggalRpph').hide().text('');
            }
        });

        $('#formEditRpph').on('submit', function(e) {
            e.preventDefault();

            var id = $('#inputRpphId').val();

            // Kumpulkan data penilaian dari DOM
            var penilaians = [];
            $('.penilaian-subbab').each(function() {
                var idx = $(this).data('idx');
                var nama = $(this).find('.input-subbab-nama').val().trim();
                if (!nama) return;

                var poins = [];
                $(this).find('.poin-input').each(function() {
                    var p = $(this).val().trim();
                    if (p) poins.push(p);
                });

                penilaians.push({
                    nama: nama,
                    poins: poins
                });
            });

            // Build payload
            var payload = {
                tanggal: $('#inputTanggalRpph').val(),
                kelas_id: $('#inputKelasRpph').val(),
                sub_sub_tema: $('#inputSubSubTema').val(),
                pembuka: $('#inputPembukaRpph').val(),
                inti: $('#inputIntiRpph').val(),
                recalling: $('#inputRecallingRpph').val(),
                penutup: $('#inputPenutupRpph').val(),
                _token: '{{ csrf_token() }}',
            };

            $.each(penilaians, function(i, p) {
                payload['penilaians[' + i + '][nama]'] = p.nama;
                $.each(p.poins, function(j, poin) {
                    payload['penilaians[' + i + '][poins][' + j + ']'] = poin;
                });
            });

            $.ajax({
                    url: '/rpph/' + id,
                    type: 'PUT',
                    data: payload,
                })
                .done(function(res) {
                    $('#mEditRpph').removeClass('on');
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 700);
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON?.errors;
                    if (errors?.tanggal) {
                        $('#errorTanggalRpph').text(errors.tanggal[0]).show();
                    }
                    var pesan = Object.values(errors || {}).flat().join('<br>');
                    if (pesan) showToast('❌ ' + Object.values(errors || {}).flat()[0]);
                });
        });

        $(document).on('click', '.btn-ajukan-rpph', function() {
            var id = $(this).data('id');
            var hari = $(this).data('hari');

            if (!confirm('Ajukan RPPH hari ' + hari + '?')) return;

            $.ajax({
                    url: '/rpph/' + id + '/ajukan',
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                })
                .done(function(res) {
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 800);
                })
                .fail(function(xhr) {
                    showToast('❌ ' + xhr.responseJSON.message);
                });
        });
    </script>
@endpush
