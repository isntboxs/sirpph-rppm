@extends('layout.app')

@section('page-title', 'Buat & Kelola RPPM')
@section('page-subtitle', $taAktif?->name ?? '-')

@section('content')
    <div class="tabs">
        <button class="tbn on" id="tab-btn-daftar">📋 Daftar RPPM ({{ $rppms->count() }})</button>
        <button class="tbn" id="tab-btn-baru">+ Buat RPPM Baru</button>
    </div>

    <div id="panel-daftar">
        @forelse ($rppms as $rppm)
            <div class="rc2">
                <div class="rh">
                    <div>
                        <div class="rw">
                            Minggu ke-{{ $rppm->minggu_ke }} •
                            {{ $rppm->tahunAjaran->name }}
                        </div>
                        <div class="rn">{{ $rppm->subTema->tema->name }}</div>
                        <div class="rs">{{ $rppm->subTema->name }}</div>
                        @if ($rppm->status === 'dikembalikan' && $rppm->catatan_kepala)
                            <div class="al ale mt8">
                                📝 Catatan Kepala: {{ $rppm->catatan_kepala }}
                            </div>
                        @endif
                    </div>
                    <span class="bdg {{ $rppm->status_badge_class }}">
                        {{ $rppm->status_label }}
                    </span>
                </div>

                {{-- Progress kegiatan per hari --}}
                <div class="fl fw g8 mt8 mb8">
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                        @php
                            $adaKegiatan = $rppm->rppmKegiatans->where('hari', $hari)->isNotEmpty();
                            $rpph = $rppm->rpphs->where('hari', $hari)->first();
                        @endphp
                        <div
                            style="
                        padding:5px 11px;
                        border-radius:7px;
                        font-size:11.5px;
                        font-weight:700;
                        background:{{ $adaKegiatan ? 'var(--g1)' : 'var(--g0)' }};
                        border:2px solid {{ $adaKegiatan ? 'var(--g4)' : 'var(--g1)' }};
                        color:{{ $adaKegiatan ? 'var(--g7)' : 'var(--txt3)' }}
                    ">
                            {{ $hari }}
                            @if ($adaKegiatan)
                                @if ($rpph)
                                    <span style="color:var(--g5)">
                                        {{ $rpph->status === 'disetujui' ? '✅' : ($rpph->status === 'pending' ? '⏳' : '📝') }}
                                    </span>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Aspek yang belum terstimulasi --}}
                @php $belum = $rppm->aspekBelumTerstimulasi(); @endphp
                @if ($belum->isNotEmpty() && in_array($rppm->status, ['draft', 'dikembalikan']))
                    <div class="al alw mb8">
                        ⚠️ Aspek belum ada:
                        @foreach ($belum as $aspek)
                            <span class="ap {{ $aspek->warna }}">{{ $aspek->emote }} {{ $aspek->name }}</span>
                        @endforeach
                    </div>
                @endif

                {{-- Tombol aksi --}}
                <div class="ract">
                    <a href="{{ route('rppm.show', $rppm->id) }}" class="btn bo bsm">
                        {{ in_array($rppm->status, ['draft', 'dikembalikan']) ? 'Edit Kegiatan' : 'Detail' }}
                    </a>

                    @if (in_array($rppm->status, ['draft', 'dikembalikan']))
                        <button type="button" class="btn ba bsm btn-ajukan-rppm" data-id="{{ $rppm->id }}">
                            📤 Ajukan ke Kepala
                        </button>
                    @endif

                    @if ($rppm->status === 'disetujui')
                        <button type="button" class="btn bp bsm btn-generate-rpph" data-id="{{ $rppm->id }}">
                            Generate RPPH
                        </button>
                        <a href="{{ route('rpph') }}" class="btn bo bsm">Lihat RPPH</a>
                    @endif

                    @if ($rppm->status !== 'disetujui')
                        <button type="button" class="btn bd bsm btn-hapus-rppm" data-id="{{ $rppm->id }}"
                            data-info="Minggu ke-{{ $rppm->minggu_ke }} - {{ $rppm->subTema->tema->name }} | {{ $rppm->subTema->name }}">
                            Hapus
                        </button>
                    @endif

                    <button type="button" class="btn bo bsm"
                        onclick="window.open('/rppm/{{ $rppm->id }}/cetak', '_blank')">
                        🖨️
                    </button>
                </div>
            </div>
        @empty
            <div class="emp">
                <div class="ei">📋</div>
                <h3>Belum ada RPPM</h3>
                <p>Klik tab "+ Buat RPPM Baru" untuk mulai membuat RPPM.</p>
            </div>
        @endforelse
    </div>

    {{-- Panel: Form Buat RPPM Baru --}}
    <div id="panel-baru" style="display:none">
        <div class="card">
            <div class="ch mb16">
                <div class="ct">📝 Form RPPM Baru</div>
                <div class="cs">Tahun Ajaran: {{ $taAktif?->name }} Semester {{ $taAktif?->semester }}</div>
            </div>

            <form id="formBuatRppm">

                {{-- A. Identitas --}}
                <div class="fs11 tc2 mb12" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">
                    A. Identitas
                </div>

                @if ($prosemValid->isEmpty())
                    <div class="al alw mb16">
                        Belum ada PROSEM yang divalidasi kepala sekolah.
                        RPPM tidak bisa dibuat sebelum PROSEM divalidasi.
                    </div>
                @else
                    {{-- Grid pilihan minggu --}}
                    <div
                        style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
                            gap:10px;margin-bottom:20px">
                        @foreach ($prosemValid as $prosem)
                            @php $sudahBuat = in_array($prosem->minggu_ke, $mingguSudahAda); @endphp
                            <div class="minggu-option {{ $sudahBuat ? 'disabled' : '' }}"
                                data-minggu="{{ $prosem->minggu_ke }}" data-tema="{{ $prosem->tema->name }}"
                                data-sub-tema="{{ $prosem->subTema->name }}"
                                style="border:2px solid {{ $sudahBuat ? '#e2e8f0' : 'var(--g2)' }};
                                    border-radius:var(--r2);padding:12px 14px;
                                    cursor:{{ $sudahBuat ? 'not-allowed' : 'pointer' }};
                                    background:{{ $sudahBuat ? '#f8fafc' : 'var(--white)' }};
                                    opacity:{{ $sudahBuat ? '0.5' : '1' }};
                                    transition:.18s;position:relative"
                                onmouseover="if(!{{ $sudahBuat ? 'true' : 'false' }}) {
                                        this.style.borderColor='var(--primary)';
                                        this.style.background='#f1f5f9';
                                        this.style.transform='translateY(-2px)';
                                    }"
                                onmouseout="if(!{{ $sudahBuat ? 'true' : 'false' }}) {
                                        this.style.borderColor='var(--g2)';
                                        this.style.background='var(--white)';
                                        this.style.transform='translateY(0)';
                                    }">
                                <div class="fl ic jb mb4">
                                    <div>Minggu ke- </div>
                                    <div
                                        style="width:28px;height:28px;background:{{ $sudahBuat ? '#94a3b8' : 'var(--g6)' }};
                                            color:white;border-radius:50%;display:flex;
                                            align-items:center;justify-content:center;
                                            font-size:11px;font-weight:800;flex-shrink:0">
                                        {{ $prosem->minggu_ke }}
                                    </div>
                                    @if ($sudahBuat)
                                        <span class="bdg bok" style="font-size:10px">Dibuat</span>
                                    @endif
                                </div>
                                <div
                                    style="font-size:12px;font-weight:700;color:{{ $sudahBuat ? '#94a3b8' : 'var(--txt)' }};
                                        margin-bottom:2px;line-height:1.3">
                                    {{ $prosem->subTema->tema->name }}
                                </div>
                                <div
                                    style="font-size:11px;color:{{ $sudahBuat ? '#94a3b8' : 'var(--g6)' }};
                                        font-weight:600">
                                    {{ $prosem->subTema->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Info minggu yang dipilih --}}
                    <input type="hidden" id="inputMingguRppm" name="minggu_ke" />
                    <div id="infoMingguDipilih" style="display:none" class="al als mb16">
                        Minggu ke-<span id="labelMingguDipilih"></span> dipilih:
                        <strong id="labelTemaDipilih"></strong> -
                        <strong id="labelSubTemaDipilih"></strong>
                    </div>
                    <div id="infoMingguBelum" class="al alw mb16">
                        Pilih minggu pelaksanaan dari daftar di atas.
                    </div>

                    {{-- B. Pilih Bulan --}}
                    <div class="fs11 tc2 mb12" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">
                        B. Bulan Pelaksanaan
                    </div>

                    @php
                        $bulanPenuh = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember',
                        ];
                        $tahunSekarang = now()->year;
                    @endphp

                    <input type="hidden" id="inputBulanRppm" name="bulan" />
                    <input type="hidden" id="inputTahunRppm" name="tahun" value="{{ $tahunSekarang }}" />

                    {{-- Grid bulan --}}
                    <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:8px;margin-bottom:8px">
                        @foreach ($bulanPenuh as $num => $label)
                            <div class="bulan-option" data-bulan="{{ $num }}" data-nama="{{ $bulanPenuh[$num] }}"
                                style="border:2px solid var(--g2);border-radius:var(--r2);
                                    padding:10px 6px;text-align:center;cursor:pointer;
                                    transition:.18s;background:var(--white)"
                                onmouseover="
                                        this.style.borderColor='var(--primary)';
                                        this.style.background='#f1f5f9';
                                        this.style.transform='translateY(-2px)';
                                    "
                                onmouseout="
                                        this.style.borderColor='var(--g2)';
                                        this.style.background='var(--white)';
                                        this.style.transform='translateY(0)';
                                    ">
                                <div style="font-size:12px;font-weight:700;color:var(--txt)">
                                    {{ $label }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Toggle tahun --}}
                    <div class="fl ic g8 mb12" style="justify-content: center; align-item: center;">
                        <span class="fs11 tc2">Tahun:</span>
                        <button type="button" class="btn bo bxs" id="btnTahunMin">−</button>
                        <span id="labelTahunRppm" class="fw7" style="min-width:50px;text-align:center">
                            {{ $tahunSekarang }}
                        </span>
                        <button type="button" class="btn bo bxs" id="btnTahunPlus">+</button>
                    </div>

                    {{-- C. Detail tambahan --}}
                    <div class="fs11 tc2 mb12" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">
                        C. Detail Pembelajaran
                    </div>

                    <div class="fr c2">
                        <div class="ff">
                            <label>Model Pembelajaran</label>
                            <select id="inputModelRppm" name="model_pembelajaran">
                                <option value="">-- Pilih Model --</option>
                                @foreach ($modelList as $model)
                                    <option value="{{ $model }}">{{ $model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ff">
                            <label>Info Periode</label>
                            <input disabled id="displayPeriode" placeholder="Pilih minggu & bulan dulu"
                                style="background:var(--g0)" />
                        </div>
                    </div>

                    <div class="fr">
                        <div class="ff">
                            <label>Tujuan Pembelajaran</label>
                            <textarea id="inputTujuanRppm" name="tujuan" rows="2"
                                placeholder="Anak dapat mengenal... melalui kegiatan..."></textarea>
                        </div>
                    </div>

                    <div class="fr">
                        <div class="ff">
                            <label>Capaian Pembelajaran</label>
                            <textarea id="inputCapaianRppm" name="capaian" rows="2" placeholder="Anak mampu..."></textarea>
                        </div>
                    </div>

                    <div id="errorBuatRppm" class="al ale" style="display:none"></div>

                    <div class="dv"></div>
                    <div class="fl jb">
                        <button type="button" class="btn bo" id="btnResetRppm">
                            Reset
                        </button>
                        <button type="submit" class="btn bp" id="btnSimpanRppm">
                            Simpan sebagai Draft
                        </button>
                    </div>
                @endif

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var tahunRppm = {{ now()->year }};
        var bulanRppm = null;
        var mingguRppm = null;

        function switchTab(tab) {
            $('#panel-daftar').toggle(tab === 'daftar');
            $('#panel-baru').toggle(tab === 'baru');
            $('#tab-btn-daftar').toggleClass('on', tab === 'daftar');
            $('#tab-btn-baru').toggleClass('on', tab === 'baru');
        }

        $('#tab-btn-daftar').on('click', function() {
            switchTab('daftar');
        });
        $('#tab-btn-baru').on('click', function() {
            switchTab('baru');
        });

        $('#btnResetRppm').on('click', function() {
            $('#formBuatRppm')[0].reset();
            $('#inputMingguRppm, #inputBulanRppm').val('');
            $('#inputTahunRppm').val({{ now()->year }});
            mingguRppm = null;
            bulanRppm = null;
            tahunRppm = {{ now()->year }};

            $('.minggu-option').css({
                'border-color': 'var(--g2)',
                'background': 'var(--white)'
            });
            $('.bulan-option').css({
                'border-color': 'var(--g2)',
                'background': 'var(--white)'
            });
            $('.bulan-option div').css('color', 'var(--txt)');
            $('#labelTahunRppm').text({{ now()->year }});
            $('#infoMingguDipilih').hide();
            $('#infoMingguBelum').show();
            $('#displayPeriode').val('');
            $('#errorBuatRppm').hide();
        });

        $(document).on('click', '.minggu-option:not(.disabled)', function() {
            $('.minggu-option').css({
                'border-color': 'var(--g2)',
                'background': 'var(--white)',
            });

            $(this).css({
                'border-color': 'var(--g5)',
                'background': 'var(--g0)',
            });

            mingguRppm = $(this).data('minggu');
            var tema = $(this).data('tema');
            var subTema = $(this).data('sub-tema');

            $('#inputMingguRppm').val(mingguRppm);
            $('#labelMingguDipilih').text(mingguRppm);
            $('#labelTemaDipilih').text(tema);
            $('#labelSubTemaDipilih').text(subTema);
            $('#infoMingguDipilih').show();
            $('#infoMingguBelum').hide();

            updateDisplayPeriode();
        });

        $(document).on('click', '.btn-hapus-rppm', function() {
            var id = $(this).data('id');
            var info = $(this).data('info');

            if (!confirm(
                    'Hapus RPPM ini?\n\n' + info + '\n\n' +
                    'Semua kegiatan dan RPPH yang terhubung juga akan ikut terhapus.\n' +
                    'Kamu bisa membuat RPPM baru untuk minggu yang sama.'
                )) return;

            $.ajax({
                    url: '/rppm/' + id,
                    type: 'DELETE',
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

        $(document).on('click', '.bulan-option', function() {
            $('.bulan-option').css({
                'border-color': 'var(--g2)',
                'background': 'var(--white)',
                'color': 'var(--txt)',
            });
            $('.bulan-option div').css('color', 'var(--txt)');

            $(this).css({
                'border-color': 'var(--g5)',
                'background': 'var(--g6)',
            });
            $(this).find('div').css('color', 'white');

            bulanRppm = $(this).data('bulan');
            var nama = $(this).data('nama');

            $('#inputBulanRppm').val(bulanRppm);

            updateDisplayPeriode();
        });

        $('#btnTahunMin').on('click', function() {
            tahunRppm--;
            $('#labelTahunRppm').text(tahunRppm);
            $('#inputTahunRppm').val(tahunRppm);
            updateDisplayPeriode();
        });

        $('#btnTahunPlus').on('click', function() {
            tahunRppm++;
            $('#labelTahunRppm').text(tahunRppm);
            $('#inputTahunRppm').val(tahunRppm);
            updateDisplayPeriode();
        });

        function updateDisplayPeriode() {
            var bulanNama = {
                1: 'Januari',
                2: 'Februari',
                3: 'Maret',
                4: 'April',
                5: 'Mei',
                6: 'Juni',
                7: 'Juli',
                8: 'Agustus',
                9: 'September',
                10: 'Oktober',
                11: 'November',
                12: 'Desember'
            };

            if (mingguRppm && bulanRppm) {
                $('#displayPeriode').val(
                    'Minggu ke-' + mingguRppm + ' / ' + bulanNama[bulanRppm] + ' ' + tahunRppm
                );
            }
        }

        $('#formBuatRppm').on('submit', function(e) {
            e.preventDefault();

            if (!mingguRppm) {
                $('#errorBuatRppm').text('Pilih minggu pelaksanaan terlebih dahulu.').show();
                return;
            }
            if (!bulanRppm) {
                $('#errorBuatRppm').text('Pilih bulan pelaksanaan terlebih dahulu.').show();
                return;
            }

            $.post('{{ route('rppm.store') }}', {
                    tahun_ajaran_id: $('#inputTaRppm').val(),
                    minggu_ke: $('#inputMingguRppm').val(),
                    bulan: bulanRppm,
                    tahun: tahunRppm,
                    model_pembelajaran: $('#inputModelRppm').val(),
                    tujuan: $('#inputTujuanRppm').val(),
                    capaian: $('#inputCapaianRppm').val(),
                    _token: '{{ csrf_token() }}',
                })
                .done(function(res) {
                    showToast('RPPM berhasil dibuat sebagai draft');
                    setTimeout(function() {
                        window.location.href = '/rppm/' + res.rppm_id;
                    }, 600);
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var pesan = Object.values(errors).flat().join('<br>');
                    $('#errorBuatRppm').html(pesan).show();
                });
        });

        $(document).on('click', '.btn-ajukan-rppm', function() {
            var id = $(this).data('id');
            if (!confirm('Ajukan RPPM ini ke Kepala Sekolah?')) return;

            $.ajax({
                    url: '/rppm/' + id + '/ajukan',
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
    </script>
@endpush
