@extends('layout.app')

@section('page-title', 'Portofolio Siswa')
@section('page-subtitle', $kelas ? 'Kelas ' . $kelas->name : 'Belum ada kelas')

@section('content')
    <div class="card mb16">
        @if (!$kelas)
            <div class="emp">
                <div class="ei">🏫</div>
                <h3>Belum terdaftar di kelas manapun</h3>
                <p>Silahkan Hubungi Admin.</p>
            </div>
        @else
            <div class="ch">
                <div>
                    <div class="ct">📸 Portofolio Siswa {{ $kelas->name }}</div>
                </div>
                <button type="button" class="btn bp bsm" id="btnTambahPorto">
                    + Input Portofolio
                </button>
            </div>

            {{-- <div class="tabs">
                @foreach ($siswas as $siswa)
                    <a style="text-decoration: none;" href="{{ route('portofolio_siswa', ['siswa_id' => $siswa->id]) }}"
                        class="tbn {{ $siswaAktif?->id === $siswa->id ? 'on' : '' }}">
                        {{ $siswa->jenis_kelamin === 'L' ? '👦' : '👧' }}
                        {{ $siswa->name }}
                    </a>
                @endforeach
            </div> --}}
            <div class="fb mb16">
                <select id="selectSiswa" onchange="window.location.href=this.value">
                    @foreach ($siswas as $siswa)
                        <option
                            value="{{ route('portofolio_siswa', ['siswa_id' => $siswa->id, 'aspek_id' => request('aspek_id')]) }}"
                            {{ $siswaAktif?->id === $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->jenis_kelamin === 'L' ? '👦' : '👧' }}
                            {{ $siswa->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter aspek --}}
                <select id="selectAspek" onchange="window.location.href=this.value">
                    <option value="{{ route('portofolio_siswa', ['siswa_id' => $siswaAktif?->id]) }}">
                        Semua Aspek
                    </option>
                    @foreach ($aspeks as $aspek)
                        <option
                            value="{{ route('portofolio_siswa', ['siswa_id' => $siswaAktif?->id, 'aspek_id' => $aspek->id]) }}"
                            {{ request('aspek_id') == $aspek->id ? 'selected' : '' }}>
                            {{ $aspek->emote }} {{ $aspek->name }}
                        </option>
                    @endforeach
                </select>

                <a href="{{ route('portofolio_siswa') }}" class="btn bo bsm">Reset</a>
            </div>

            @if (!$portofolios->isEmpty())
                <div class="g4 mt16">
                    @foreach ($portofolios as $porto)
                        <div id="porto-card-{{ $porto->id }}" style="cursor:pointer">
                            <div class="pfc" data-porto-id="{{ $porto->id }}">
                                <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">
                                    {{ $porto->foto_icon }}</div>
                                <div class="pfb">
                                    <div class="pfn">{{ $siswaAktif->name }}</div>
                                    <div class="pfd">📅 {{ $porto->tanggal_format }} @if ($porto->kegiatan)
                                            - {{ $porto->kegiatan->name }}
                                        @endif
                                    </div>
                                    <div class="pfnt">{{ $porto->catatan }}</div>
                                    <div class="fl fw g8 mt8">
                                        @foreach ($porto->aspeks as $aspek)
                                            <span class="ap {{ $aspek->warna }}">
                                                {{ $aspek->emote }} {{ $aspek->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <div class="fs11 tc2 mt8">
                                        💬 {{ $porto->komentars->count() }} komentar
                                    </div>
                                    {{-- Hapus --}}
                                    <div class="mt8">
                                        <button type="button" class="btn bd bxs btn-hapus-porto"
                                            data-id="{{ $porto->id }}">
                                            🗑️ Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $portofolios->links() }}
            @else
                <div class="card emp">
                    <div class="ei">🗂️</div>
                    <h3>Tidak ada Portofolio Untuk Anak</h3>
                    <p>Coba ubah filter atau tambahkan portofolio siswa.</p>
                </div>
            @endif
        @endif
    </div>

    {{-- Modal Tambah Porto --}}
    <div class="mo" id="mTambahPorto">
        <div class="md mlg">
            <form id="formTambahPorto">
                <div class="mh">
                    <div>
                        <div class="mt2">📸 Input Portofolio</div>
                        <div class="mst">Dokumentasi perkembangan siswa</div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">

                    {{-- Pilih siswa --}}
                    <div class="fr c2">
                        <div class="ff">
                            <label>Siswa</label>
                            <select id="inputPortoSiswa" name="siswa_id">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($siswas as $siswa)
                                    <option value="{{ $siswa->id }}"
                                        {{ $siswaAktif?->id === $siswa->id ? 'selected' : '' }}>
                                        {{ $siswa->jenis_kelamin === 'L' ? '👦' : '👧' }}
                                        {{ $siswa->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ff">
                            <label>Pilih Ikon Karya</label>
                            <div class="fl fw g8 mt4">
                                @foreach (['📸', '🎨', '✏️', '🧩', '📚', '🌱', '🕌', '🏃', '🎵', '🖌️', '✂️', '🧸'] as $ikon)
                                    <div class="ikon-porto" data-ikon="{{ $ikon }}"
                                        style="width:38px;height:38px;border-radius:8px;
                                           border:2px solid var(--g2);display:flex;
                                           align-items:center;justify-content:center;
                                           font-size:18px;cursor:pointer;transition:.15s">
                                        {{ $ikon }}
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" id="inputPortoIkon" name="foto_icon" value="📸" />
                        </div>
                    </div>

                    {{-- Pilih dari RPPH (opsional) --}}
                    @if ($rpphList->isNotEmpty())
                        <div class="ff mb12">
                            <label>
                                Kegiatan dari RPPH
                                <span class="fs11 tc2">(opsional)</span>
                            </label>
                            <select id="inputPortoRpph" name="rpph_id">
                                <option value="">-- Tanpa RPPH --</option>
                                @foreach ($rpphList as $rpph)
                                    @php
                                        $kegiatan = $rpph->rppm->rppmKegiatans
                                            ->where('hari', $rpph->hari)
                                            ->map(function ($rk) {
                                                return [
                                                    'id' => $rk->kegiatan->id,
                                                    'name' => $rk->kegiatan->foto_icon . ' ' . $rk->kegiatan->name,
                                                ];
                                            })
                                            ->values();
                                    @endphp

                                    <option value="{{ $rpph->id }}" data-kegiatan='@json($kegiatan)'>
                                        {{ $rpph->hari }},
                                        {{ $rpph->tanggal_format }} -
                                        {{ $rpph->rppm->subTema->tema->name }}
                                        | {{ $rpph->rppm->subTema->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Kegiatan (Optional) --}}
                        <div class="ff mb12">
                            <label>
                                Kegiatan yang Dilakukan
                                <span class="fs11 tc2">(opsional)</span>
                            </label>
                            <select id="inputPortoKegiatan" name="kegiatan_id">
                                <option value="">-- Pilih RPPH dulu --</option>
                            </select>
                        </div>
                    @endif


                    {{-- Catatan observasi --}}
                    <div class="ff mb12">
                        <label>Catatan Observasi Guru</label>
                        <textarea id="inputPortoCatatan" name="catatan" rows="4"
                            placeholder="Contoh: Anak sangat antusias saat mewarnai. Mampu menyelesaikan tugas secara mandiri. Warna yang dipilih beragam dan rapi..."></textarea>
                    </div>

                    {{-- Aspek perkembangan --}}
                    <div class="ff">
                        <label>Aspek Perkembangan yang Terobservasi</label>
                        <div class="fl fw g8 mt8">
                            @foreach ($aspeks as $aspek)
                                <label class="cbi" style="cursor:pointer">
                                    <input hidden type="checkbox" name="aspek_ids[]" value="{{ $aspek->id }}"
                                        class="checkbox-aspek-porto" />
                                    <span class="ap {{ $aspek->warna }}">
                                        {{ $aspek->emote }} {{ $aspek->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div id="errorPorto" class="al ale mt12" style="display:none"></div>
                </div>
                <div class="mf">
                    <button type="submit" class="btn bp btn-submit-form">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Detail Portofolio --}}
    <div class="mo" id="mDetailPorto">
        <div class="md mlg">
            <div class="mh">
                <div class="mt2" id="mDetailPortoTitle">📸 Portofolio</div>
                <button type="button" class="mc">X</button>
            </div>
            <div class="mb">
                <div id="mDetailPortoLoading" style="text-align:center;padding:40px;color:var(--txt3)">
                    ⏳ Memuat...
                </div>
                <div id="mDetailPortoContent" style="display:none">
                    <div id="mDetailPortoHero"
                        style="height:200px;border-radius:var(--r);background:linear-gradient(135deg,var(--g1),var(--g2));
                            display:flex;align-items:center;justify-content:center;
                            font-size:80px;margin-bottom:16px">
                    </div>
                    <div class="fr c3 mb16">
                        <div class="ib">
                            <div class="ik">Nama Siswa</div>
                            <div class="iv" id="mDetailPortoNama">-</div>
                        </div>
                        <div class="ib">
                            <div class="ik">Tanggal</div>
                            <div class="iv" id="mDetailPortoTanggal">-</div>
                        </div>
                        <div class="ib">
                            <div class="ik">Kegiatan</div>
                            <div class="iv" id="mDetailPortoKegiatan">-</div>
                        </div>
                    </div>
                    <div
                        style="background:var(--g0);border-radius:var(--r2);
                            padding:16px;border:1px solid var(--g1);margin-bottom:16px">
                        <div class="fw7 mb8">
                            📝 Catatan Perkembangan Guru
                        </div>
                        <div id="mDetailPortoCatatan" style="font-size:13px;color:var(--txt2);line-height:1.7">
                        </div>
                    </div>

                    <div class="mb16">
                        <div class="fw7 mb8">✅ Aspek yang Dicapai</div>
                        <div id="mDetailPortoAspek" class="fl fw g8"></div>
                    </div>

                    <div>
                        <div class="fw7 mb8" id="mDetailPortoKomentarTitle">
                            💬 Komentar (0)
                        </div>
                        <div id="mDetailPortoKomentars"></div>
                        {{-- <div class="fl g8 mt8">
                            <input type="text" id="mDetailPortoInputKomentar" placeholder="Tulis komentar..."
                                style="flex:1;padding:9px 12px;border:2px solid var(--g1);
                                      border-radius:var(--r2);font-size:13px" />
                            <button type="button" class="btn bp bsm" id="mDetailPortoBtnKomentar">
                                Kirim
                            </button>
                        </div> --}}
                    </div>

                </div>
            </div>

            <div class="mf">
                <button type="button" class="btn bp" id="mDetailPortoBtnCetak">
                    🖨️ Cetak Laporan
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#btnTambahPorto').on('click', function() {
            $('#mTambahPorto').addClass('on');
        });

        $('#mTambahPorto').on('click', '.mc, .btn.bo', function() {
            $('#formTambahPorto')[0].reset();
            $('#errorPorto').hide();
            $('.ikon-porto').css({
                'border-color': 'var(--g2)',
                'background': 'transparent'
            });
            $('.ikon-porto[data-ikon="📸"]')
                .css({
                    'border-color': 'var(--g5)',
                    'background': 'var(--g1)'
                });
            $('#inputPortoIkon').val('📸');
        });

        $(document).on('click', '.ikon-porto', function() {
            $('.ikon-porto').css({
                'border-color': 'var(--g2)',
                'background': 'transparent'
            });
            $(this).css({
                'border-color': 'var(--g5)',
                'background': 'var(--g1)'
            });
            $('#inputPortoIkon').val($(this).data('ikon'));
        });

        $('.ikon-porto[data-ikon="📸"]')
            .css({
                'border-color': 'var(--g5)',
                'background': 'var(--g1)'
            });

        $('#formTambahPorto').on('submit', function(e) {
            e.preventDefault();

            var aspekIds = [];
            $('input.checkbox-aspek-porto:checked').each(function() {
                aspekIds.push($(this).val());
            });

            $.post('{{ route('portofolio_siswa.store') }}', {
                    siswa_id: $('#inputPortoSiswa').val(),
                    rpph_id: $('#inputPortoRpph').val() || null,
                    foto_icon: $('#inputPortoIkon').val(),
                    catatan: $('#inputPortoCatatan').val(),
                    kegiatan_id: $('#inputPortoKegiatan').val() || null,
                    'aspek_ids[]': aspekIds,
                    _token: '{{ csrf_token() }}',
                })
                .done(function() {
                    $('#mTambahPorto').removeClass('on');
                    showToast('📸 Portofolio berhasil ditambahkan');
                    setTimeout(function() {
                        location.reload();
                    }, 700);
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var pesan = Object.values(errors).flat().join('<br>');
                    $('#errorPorto').html(pesan).show();
                });
        });

        $(document).on('click', '.btn-hapus-porto', function() {
            var id = $(this).data('id');
            var $card = $('#porto-card-' + id);

            if (!confirm('Hapus entri portofolio ini?')) return;

            $.ajax({
                    url: '/portofolio-siswa/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                })
                .done(function() {
                    $card.fadeOut(300, function() {
                        $(this).remove();
                    });
                    showToast('🗑️ Entri portofolio dihapus');
                });
        });

        $('#inputPortoRpph').on('change', function() {
            var $kegiatanSelect = $('#inputPortoKegiatan');
            var $selected = $(this).find('option:selected');
            var kegiatanData = $selected.data('kegiatan');

            $kegiatanSelect.empty();

            if (!$(this).val() || !kegiatanData || kegiatanData.length === 0) {
                $kegiatanSelect.append(
                    '<option value="">-- Tidak ada / tanpa kegiatan --</option>'
                );
                return;
            }

            $kegiatanSelect.append('<option value="">-- Pilih Kegiatan --</option>');

            $.each(kegiatanData, function(i, keg) {
                $kegiatanSelect.append(
                    '<option value="' + keg.id + '">' + keg.name + '</option>'
                );
            });
        });

        $(document).on('click', '.btn-kirim-komentar', function() {
            var portoId = $(this).data('porto-id');
            var $input = $('.input-komentar[data-porto-id="' + portoId + '"]');
            var komentar = $input.val().trim();

            if (!komentar) return;

            $.post('/portofolio-siswa/' + portoId + '/komentar', {
                    komentar: komentar,
                    _token: '{{ csrf_token() }}',
                })
                .done(function(res) {
                    var d = res.data;
                    var role = d.role === 'ortu' ? '👨‍👩‍👧' : '🧑‍🏫';
                    var html = '<div class="kom-item">' +
                        '<div class="kom-author">' + role + ' ' + d.author + '</div>' +
                        '<div class="kom-text">' + d.komentar + '</div>' +
                        '<div class="kom-time">' + d.waktu + '</div>' +
                        '</div>';

                    // Sisipkan komentar baru sebelum input
                    $input.closest('.fl').before(html);
                    $input.val('');
                })
                .fail(function() {
                    showToast('❌ Gagal mengirim komentar');
                });
        });

        var activePortoId = null;

        $(document).on('click', '.pfc', function(e) {
            if ($(e.target).closest('.btn-hapus-porto, .input-komentar, .btn-kirim-komentar').length) {
                return;
            }

            activePortoId = $(this).data('porto-id');
            bukaDetailPorto(activePortoId);
        });

        function bukaDetailPorto(id) {
            $('#mDetailPortoLoading').show();
            $('#mDetailPortoContent').hide();
            $('#mDetailPortoTitle').text('📸 Portofolio');
            $('#mDetailPortoHero').text('');
            $('#mDetailPortoAspek, #mDetailPortoKomentars').empty();
            $('#mDetailPortoInputKomentar').val('');

            $('#mDetailPorto').addClass('on');

            $.get('/portofolio-siswa/' + id + '/detail')
                .done(function(res) {
                    var d = res.data;

                    $('#mDetailPortoTitle').text('📸 Portofolio - ' + d.nama_siswa);
                    $('#mDetailPortoHero').text(d.foto_icon);
                    $('#mDetailPortoNama').text((d.jk === 'L' ? '👦 ' : '👧 ') + d.nama_siswa);
                    $('#mDetailPortoTanggal').text(d.tanggal_raw);
                    $('#mDetailPortoKegiatan').text(d.kegiatan || (d.sub_tema || '-'));
                    $('#mDetailPortoCatatan').text(d.catatan);

                    var aspekHtml = '';
                    $.each(d.aspeks, function(i, a) {
                        aspekHtml += '<span class="ap ' + a.warna + '">' +
                            a.emote + ' ' + a.name + '</span>';
                    });
                    $('#mDetailPortoAspek').html(aspekHtml);

                    renderKomentars(d.komentars);

                    $('#mDetailPortoLoading').hide();
                    $('#mDetailPortoContent').show();
                })
                .fail(function() {
                    $('#mDetailPortoLoading').text('❌ Gagal memuat data.');
                });
        }

        function renderKomentars(komentars) {
            $('#mDetailPortoKomentarTitle').text('💬 Komentar (' + komentars.length + ')');

            var html = '';
            if (komentars.length === 0) {
                html = '<div class="fs11 tc2" style="padding:8px 0">Belum ada komentar.</div>';
            } else {
                $.each(komentars, function(i, k) {
                    var icon = k.role === 'ortu' ? '👨‍👩‍👧' : '🧑‍🏫';
                    html += '<div class="kom-item">' +
                        '<div class="kom-author">' + icon + ' ' + k.author + '</div>' +
                        '<div class="kom-text">' + k.teks + '</div>' +
                        '<div class="kom-time">🕐 ' + k.waktu + '</div>' +
                        '</div>';
                });
            }
            $('#mDetailPortoKomentars').html(html);
        }

        $(document).on('keypress', '.input-komentar', function(e) {
            if (e.which === 13) {
                $(this).siblings('.btn-kirim-komentar').trigger('click');
            }
        });

        $('#mDetailPortoBtnCetak').on('click', function() {
            if (!activePortoId) return;
            window.open('/portofolio-siswa/' + activePortoId + '/cetak', '_blank');
        });
    </script>
@endpush
