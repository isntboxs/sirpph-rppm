@extends('layout.app')

@section('page-title', 'Validasi Kegiatan')
@section('page-subtitle', $taAktif?->name ?? '-')

@section('content')
    <div class="al ali mb16">
        ℹ️ Kegiatan terkunci setelah digunakan di <strong>3 tahun ajaran berbeda</strong>. Guru perlu mengusulkan kegiatan
        baru.
    </div>

    {{-- Menunggu Validasi --}}
    <div class="card mb16">
        <div class="tabs">
            <button class="tbn on" data-tab="tab-semua">
                🗂️ Semua Kegiatan ({{ $kegiatans->total() }})
            </button>
            <button class="tbn" data-tab="tab-pending">
                ⏳ Menunggu
                @if ($pending->count() > 0)
                    <span class="nbg" style="margin-left:4px">{{ $pending->count() }}</span>
                @endif
            </button>
        </div>

        {{-- <div class="ch">
            <div class="ct">🕐 Menunggu Validasi (1)</div>
        </div>
        <div class="kc">
            <div class="fl jb ic mb8">
                <div class="kn">Melukis Masjid Sederhana dengan Cat Air</div>
                <span class="bdg bpnd">⏳ Pending</span>
            </div>
            <div class="kd">Anak melukis gambar masjid menggunakan cat air di atas kertas HVS dengan bimbingan guru.
            </div>
            <div class="fl fw g8 mb8">
                <span class="ap a1">🕌 Nilai Agama</span>
                <span class="ap a6">🎨 Seni</span>
                <span class="ap a2">🏃 Fisik Motorik</span>
            </div>
            <div class="fs11 tc2 mb8">🎭 Bentuk: Melukis | 🔧 Alat: Cat Air, Kuas, Kertas HVS</div>
            <div class="fs11 tc2 mb8">Diusulkan: Ustadzah Siti Rahmah</div>
            <div class="fl g8 mt8">
                <button class="btn bp bsm" onclick="showToast('✅ Kegiatan disetujui & ditambahkan ke kumpulan')">✅ Setujui &
                    Tambah ke Kumpulan</button>
                <button class="btn bd bsm" onclick="showToast('❌ Kegiatan ditolak')">❌ Tolak</button>
            </div>
        </div> --}}

        <div id="tab-pending" class="tab-content" style="display:none">
            @forelse ($pending as $kegiatan)
                <div class="kc" id="row-kegiatan-{{ $kegiatan->id }}">
                    <div class="fl jb ic mb8">
                        <div class="fl ic g8">
                            <span style="font-size:24px">{{ $kegiatan->foto_icon }}</span>
                            <div>
                                <div class="kn">{{ $kegiatan->name }}</div>
                                <div class="fs11 tc2">
                                    👤 {{ $kegiatan->diusulkanOleh->name }}
                                    · 🕐 {{ $kegiatan->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <span class="bdg bpnd">⏳ Pending</span>
                    </div>

                    <div class="ig mb8">
                        <div class="ib">
                            <div class="ik">Tema</div>
                            <div class="iv">{{ $kegiatan->tema->name }}</div>
                        </div>
                        <div class="ib">
                            <div class="ik">Bentuk</div>
                            <div class="iv">{{ $kegiatan->bentukKegiatan->name }}</div>
                        </div>
                        @if ($kegiatan->alatBahans->isNotEmpty())
                            <div class="ib">
                                <div class="ik">Alat & Bahan</div>
                                <div class="iv">{{ $kegiatan->alatBahans->pluck('name')->join(', ') }}</div>
                            </div>
                        @endif
                    </div>

                    @if ($kegiatan->deskripsi)
                        <div class="kd mb8">{{ $kegiatan->deskripsi }}</div>
                    @endif

                    <div class="fl fw g8 mb12">
                        @foreach ($kegiatan->aspeks as $aspek)
                            <span class="ap {{ $aspek->warna }}">
                                {{ $aspek->emote }} {{ $aspek->name }}
                            </span>
                        @endforeach
                    </div>

                    <div class="fl g8">
                        <button type="button" class="btn bp bsm btn-setujui" data-id="{{ $kegiatan->id }}">
                            ✅ Setujui
                        </button>
                        <button type="button" class="btn bd bsm btn-tolak" data-id="{{ $kegiatan->id }}"
                            data-nama="{{ $kegiatan->name }}">
                            ❌ Tolak
                        </button>
                    </div>
                </div>
            @empty
                <div class="emp">
                    <div class="ei">🎉</div>
                    <h3>Semua kegiatan sudah divalidasi</h3>
                </div>
            @endforelse
        </div>

        <div id="tab-semua" class="tab-content">
            {{-- Filter --}}
            {{-- class="card mb16" --}}
            <form>
                <div class="fl fw g8 ic fb">
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="🔍 Cari kegiatan..." />
                    <select name="tema_id">
                        <option value="">Semua Tema</option>
                        @foreach ($temas as $tema)
                            <option value="{{ $tema->id }}" {{ request('tema_id') == $tema->id ? 'selected' : '' }}>
                                {{ $tema->name }}
                            </option>
                        @endforeach
                    </select>
                    <select name="status_kunci">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status_kunci') === 'aktif' ? 'selected' : '' }}>
                            ✅ Aktif
                        </option>
                        <option value="terkunci" {{ request('status_kunci') === 'terkunci' ? 'selected' : '' }}>
                            🔒 Terkunci
                        </option>
                    </select>
                    <button type="submit" class="btn bp bsm">🔍 Filter</button>
                    <a href="{{ route('validasi_kegiatan') }}" class="btn bo bsm">Reset</a>
                </div>
            </form>

            @if ($kegiatans->isEmpty())
                <div class="emp">
                    <div class="ei">🗂️</div>
                    <h3>Tidak ada kegiatan</h3>
                </div>
            @else
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:12px">
                    @foreach ($kegiatans as $kegiatan)
                        @php $terkunci = $kegiatan->isTerkunci(); @endphp

                        <div class="kc {{ $terkunci ? 'lck' : '' }}">
                            <div class="fl jb ic mb8">
                                <div class="fl ic g8">
                                    <span style="font-size:20px">{{ $kegiatan->foto_icon }}</span>
                                    <div>
                                        <div class="kn">
                                            @if ($terkunci)
                                                🔒
                                            @endif {{ $kegiatan->name }}
                                        </div>
                                        <div class="fs11 tc2">{{ $kegiatan->tema->name }}</div>
                                    </div>
                                </div>
                                <span class="bdg {{ $terkunci ? 'blk' : 'bok' }}">
                                    {{ $terkunci ? '🔒 Terkunci' : '✅ Aktif' }}
                                </span>
                            </div>

                            <div class="fl fw g8 mb8">
                                @foreach ($kegiatan->aspeks as $aspek)
                                    <span class="ap {{ $aspek->warna }}">
                                        {{ $aspek->emote }} {{ $aspek->name }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="fs11 tc2 mb4">
                                📅 {{ $kegiatan->label_pemakaian }}
                            </div>
                            <div class="pw mb4">
                                <div class="pb {{ $kegiatan->warna_progress }}"
                                    style="width:{{ $kegiatan->presentase_pemakaian }}%">
                                </div>
                            </div>

                            {{-- @if ($terkunci)
                                <div class="al alw mt8" style="font-size:11.5px">
                                    🔒 Guru perlu usulkan kegiatan baru untuk tema ini.
                                </div>
                            @elseif ($kegiatan->jumlah_tahun_dipakai >= 2)
                                <div class="al ali mt8" style="font-size:11.5px">
                                    ⚠️ Satu tahun ajaran lagi akan terkunci.
                                </div>
                            @endif --}}
                            @if ($terkunci)
                                <div class="al alw mt8" style="font-size:11.5px">
                                    Kegiatan ini terkunci. Anda dapat meng-extend batas pemakaiannya.
                                </div>
                                <div class="mt8">
                                    <button type="button" class="btn bpu bsm btn-extend-kegiatan"
                                        data-id="{{ $kegiatan->id }}" data-nama="{{ $kegiatan->name }}"
                                        data-jumlah="{{ $kegiatan->jumlah_tahun_dipakai }}"
                                        data-maks="{{ $kegiatan->maks_pemakaian }}">
                                        Extend Pemakaian
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                {{ $kegiatans->links() }}
            @endif
        </div>
    </div>

    {{-- Kegiatan Terkunci --}}
    {{-- <div class="card mb16">
        <div class="ch">
            <div class="ct">🔒 Kegiatan Terkunci (2)</div>
        </div>
        <div class="kc lck">
            <div class="fl jb ic mb8">
                <div class="kn">🔒 Kolase Tulisan "Terima Kasih Ya Allah"</div>
                <span class="bdg blk">Terkunci</span>
            </div>
            <div class="fs11 tc2 mb4">🎭 Kolase | Tema: Aku, Makhluq Allah</div>
            <div class="fs11" style="color:var(--red)">Dipakai di: 2022/2023 → 2023/2024 → 2024/2025</div>
            <div class="al alw mt8">🔒 Sudah digunakan di <strong>3 tahun ajaran</strong> dan terkunci permanen.</div>
        </div>
        <div class="kc lck mt8">
            <div class="fl jb ic mb8">
                <div class="kn">🔒 Mewarnai Tulisan "Allah"</div>
                <span class="bdg blk">Terkunci</span>
            </div>
            <div class="fs11 tc2 mb4">🎭 Mewarnai | Tema: Aku, Makhluq Allah</div>
            <div class="fs11" style="color:var(--red)">Dipakai di: 2022/2023 → 2023/2024 → 2024/2025</div>
            <div class="al alw mt8">🔒 Sudah digunakan di <strong>3 tahun ajaran</strong> dan terkunci permanen.</div>
        </div>
    </div> --}}



    {{-- Kegiatan Terkunci --}}
    {{-- @if ($kegiatanTerkunci->isNotEmpty())
        <div class="card mb16" style="border-color:#fecaca">
            <div class="ch mb12">
                <div>
                    <div class="ct">🔒 Kegiatan Terkunci ({{ $kegiatanTerkunci->count() }})</div>
                    <div class="cs" style="color:var(--red)">
                        Guru perlu mengusulkan kegiatan baru untuk menggantikan ini.
                    </div>
                </div>
            </div>

            @foreach ($kegiatanTerkunci as $kegiatan)
                <div class="kc lck {{ $loop->first ? '' : 'mt8' }}">
                    <div class="fl jb ic mb8">
                        <div class="fl ic g8">
                            <span style="font-size:18px">{{ $kegiatan->foto_icon }}</span>
                            <div class="kn">🔒 {{ $kegiatan->name }}</div>
                        </div>
                        <span class="bdg blk">Terkunci</span>
                    </div>

                    <div class="fs11 tc2 mb8">
                        🎭 {{ $kegiatan->bentukKegiatan->name }}
                        &nbsp;|&nbsp;
                        📚 {{ $kegiatan->tema->name }}
                    </div>

                    <div class="fl fw g8 mb8">
                        @foreach ($kegiatan->aspeks as $aspek)
                            <span class="ap {{ $aspek->warna }}">
                                {{ $aspek->emote }} {{ $aspek->name }}
                            </span>
                        @endforeach
                    </div>

                    <div class="fs11 mb8" style="color:var(--red)">
                        📅 Dipakai di:
                        {{ ($tahunPerKegiatan[$kegiatan->id] ?? collect())->join(' → ') }}
                    </div>

                    <div class="pw mb4">
                        <div class="pb pk" style="width:100%"></div>
                    </div>

                    <div class="al alw" style="font-size:11.5px">
                        🔒 Sudah digunakan di <strong>3 tahun ajaran</strong> dan terkunci permanen.
                        Guru perlu mengusulkan kegiatan baru di tema
                        <strong>{{ $kegiatan->tema->name }}</strong>.
                    </div>
                </div>
            @endforeach
        </div>
    @endif --}}




    {{-- Modal Tolak untuk catatan penolakan jika perlu --}}
    {{-- <div class="mo" id="mTolakKegiatan">
    <div class="md msm">
        <form id="formTolakKegiatan">
            <input type="hidden" id="inputTolakId"/>
            <div class="mh">
                <div>
                    <div class="mt2">❌ Tolak Kegiatan</div>
                    <div class="mst" id="labelNamaTolak" style="color:var(--txt3)"></div>
                </div>
                <button type="button" class="mc">✕</button>
            </div>
            <div class="mb">
                <div class="al alw mb12">
                    ⚠️ Guru akan menerima catatan ini sebagai alasan penolakan.
                </div>
                <div class="ff">
                    <label>Catatan untuk Guru</label>
                    <textarea id="inputCatatanTolak" name="catatan" rows="4"
                        placeholder="Jelaskan alasan penolakan agar guru bisa memperbaiki..."></textarea>
                </div>
                <div id="errorTolak" class="al ale mt8" style="display:none"></div>
            </div>
            <div class="mf">
                <button type="button" class="btn bo">Batal</button>
                <button type="submit" class="btn bd btn-submit-form">❌ Tolak</button>
            </div>
        </form>
    </div>
</div> --}}

    {{-- Semua Kumpulan Kegiatan --}}
    {{-- <div class="card">
        <div class="ch">
            <div class="ct">✅ Semua Kumpulan Kegiatan (15)</div>
        </div>
        <div class="tw">
            <table>
                <thead>
                    <tr>
                        <th>Nama Kegiatan</th>
                        <th>Bentuk</th>
                        <th>Aspek</th>
                        <th>Dipakai di Tahun</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Kolase Tulisan "Terima Kasih Ya Allah"</strong></td>
                        <td>Kolase</td>
                        <td><span class="ap a1">🕌</span> <span class="ap a6">🎨</span></td>
                        <td>
                            2022/2023, 2023/2024, 2024/2025
                            <div class="pw mt8">
                                <div class="pb pk" style="width:100%"></div>
                            </div>
                            <div class="fs11">3/3 - TERKUNCI</div>
                        </td>
                        <td><span class="bdg blk">🔒 Terkunci</span></td>
                    </tr>
                    <tr>
                        <td><strong>Menebalkan Nama Sendiri</strong></td>
                        <td>Menggambar</td>
                        <td><span class="ap a3">🧠</span> <span class="ap a4">💬</span></td>
                        <td>
                            2023/2024, 2024/2025
                            <div class="pw mt8">
                                <div class="pb or" style="width:66%"></div>
                            </div>
                            <div class="fs11 tc2">2/3 tahun ajaran</div>
                        </td>
                        <td><span class="bdg bok">✅</span></td>
                    </tr>
                    <tr>
                        <td><strong>Finger Painting Anggota Tubuh</strong></td>
                        <td>Finger Painting</td>
                        <td><span class="ap a2">🏃</span> <span class="ap a6">🎨</span></td>
                        <td>
                            2023/2024
                            <div class="pw mt8">
                                <div class="pb gr" style="width:33%"></div>
                            </div>
                            <div class="fs11 tc2">1/3 tahun ajaran</div>
                        </td>
                        <td><span class="bdg bok">✅</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> --}}

    {{-- Modal: Extend Kegiatan --}}
    <div class="mo" id="mExtendKegiatan">
        <div class="md mmd">
            <form id="formExtendKegiatan">
                <input type="hidden" id="inputExtendId" />
                <div class="mh">
                    <div>
                        <div class="mt2">🔓 Extend Pemakaian Kegiatan</div>
                        <div class="mst" id="labelExtendNama" style="color:var(--txt3)"></div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">

                    <div class="ig mb16">
                        <div class="ib">
                            <div class="ik">Pemakaian Saat Ini</div>
                            <div class="iv" id="labelExtendJumlah">—</div>
                        </div>
                        <div class="ib">
                            <div class="ik">Batas Saat Ini</div>
                            <div class="iv" id="labelExtendMaks">—</div>
                        </div>
                        <div class="ib">
                            <div class="ik">Setelah Extend</div>
                            <div class="iv" id="labelExtendSetelah" style="color:var(--g6);font-weight:800">—
                            </div>
                        </div>
                    </div>

                    <div class="pw mb16">
                        <div class="pb pk" id="progressExtend" style="width:100%"></div>
                    </div>

                    <div class="al alw mb16" style="font-size:11.5px">
                        ⚠️ Kegiatan yang sudah di-extend akan bisa dipakai kembali oleh guru.
                        Pastikan kegiatan ini masih relevan sebelum meng-extend.
                    </div>

                    <div class="ff">
                        <label>Tambah Berapa Semester?</label>

                        <div class="fl g8 mt8" id="pilihanExtend">
                            @foreach ([1, 2, 3] as $n)
                                <div class="extend-option" data-nilai="{{ $n }}"
                                    style="flex:1;border:2px solid var(--g2);border-radius:var(--r2);
                                        padding:12px;text-align:center;cursor:pointer;transition:.18s">
                                    <div style="font-size:20px;font-weight:800;color:var(--g6)">
                                        +{{ $n }}
                                    </div>
                                    <div class="fs11 tc2">
                                        semester
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" id="inputTambahSemester" name="tambah_semester" value="1" />
                    </div>

                    <div id="errorExtend" class="al ale mt8" style="display:none"></div>
                </div>
                <div class="mf">
                    <button type="submit" class="btn bp btn-submit-form">🔓 Extend</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '[data-tab]', function() {
            var target = $(this).data('tab');
            $(this).closest('.tabs').find('.tbn').removeClass('on');
            $(this).addClass('on');
            $('.tab-content').hide();
            $('#' + target).show();
        });

        $(document).on('click', '.btn-setujui', function() {
            var id = $(this).data('id');
            var $row = $('#row-kegiatan-' + id);

            // if (!confirm('Setujui kegiatan ini?')) return;

            $.ajax({
                    url: '/validasi-kegiatan/' + id + '/setujui',
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                })
                .done(function(res) {
                    $('#row-kegiatan-' + id).fadeOut(150, function() {
                        $(this).remove();
                    });

                    showToast(res.message);

                    // setTimeout(function() {
                    //     window.location.href = '{{ route('validasi_kegiatan') }}';
                    // }, 800);
                    decrementBadgeCount('bdg-cnt-validasi-kegiatan');

                    var $badge = $('.tabs .nbg').first();
                    var count = parseInt($badge.text()) - 1;
                    count <= 0 ? $badge.remove() : $badge.text(count);
                })
                .fail(function(xhr) {
                    showToast('❌ ' + xhr.responseJSON.message);
                });
        });

        // $(document).on('click', '.btn-buka-tolak', function() {
        //     $('#inputTolakId').val($(this).data('id'));
        //     $('#labelNamaTolak').text($(this).data('nama'));
        //     $('#errorTolak').hide();
        //     $('#mTolakKegiatan').addClass('on');
        // });

        // $('#mTolakKegiatan').on('click', '.mc, .btn.bo', function() {
        //     $('#formTolakKegiatan')[0].reset();
        //     $('#errorTolak').hide();
        // });

        $(document).on('click', '.btn-tolak', function() {
            var id = $(this).data('id');

            $.ajax({
                    url: '/validasi-kegiatan/' + id + '/tolak',
                    type: 'PUT',
                    data: {
                        // catatan: $('#inputCatatanTolak').val(),
                        _token: '{{ csrf_token() }}',
                    },
                })
                .done(function(res) {
                    $('#row-kegiatan-' + id).fadeOut(150, function() {
                        $(this).remove();
                    });

                    showToast(res.message);

                    setTimeout(function() {
                        window.location.href = '{{ route('validasi_kegiatan') }}';
                    }, 800);
                    decrementBadgeCount('bdg-cnt-validasi-kegiatan');

                    var $badge = $('.tabs .nbg').first();
                    var count = parseInt($badge.text()) - 1;
                    count <= 0 ? $badge.remove() : $badge.text(count);
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('#errorTolak').text(errors.catatan[0]).show();
                });
        });

        $(document).on('click', '.btn-extend-kegiatan', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var jumlah = parseInt($(this).data('jumlah'));
            var maks = parseInt($(this).data('maks'));

            $('#inputExtendId').val(id);
            $('#labelExtendNama').text(nama);
            $('#labelExtendJumlah').text(jumlah + ' semester');
            $('#labelExtendMaks').text(maks + ' semester');
            $('#errorExtend').hide();

            $('#inputTambahSemester').val(1);
            updateExtendPreview(jumlah, maks, 1);

            $('.extend-option').css({
                'border-color': 'var(--g2)',
                'background': 'var(--white)'
            });
            $('.extend-option[data-nilai="1"]').css({
                'border-color': 'var(--g5)',
                'background': 'var(--g0)'
            });

            $('#mExtendKegiatan').addClass('on');
        });

        $(document).on('click', '.extend-option', function() {
            var nilai = parseInt($(this).data('nilai'));
            var jumlah = parseInt($('#labelExtendJumlah').text());
            var maks = parseInt($('#labelExtendMaks').text());

            $('.extend-option').css({
                'border-color': 'var(--g2)',
                'background': 'var(--white)'
            });
            $(this).css({
                'border-color': 'var(--g5)',
                'background': 'var(--g0)'
            });

            $('#inputTambahSemester').val(nilai);
            updateExtendPreview(jumlah, maks, nilai);
        });

        function updateExtendPreview(jumlah, maks, tambah) {
            var maksBaru = maks + tambah;
            var persen = Math.min(100, Math.round((jumlah / maksBaru) * 100));
            var warna = persen >= 100 ? 'pk' : (persen >= 50 ? 'or' : 'gr');

            $('#labelExtendSetelah').text(maksBaru + ' semester');

            var colorMap = {
                gr: 'var(--g5)',
                or: 'var(--acc)',
                pk: 'var(--red)'
            };
            $('#progressExtend')
                .css('width', persen + '%')
                .css('background', colorMap[warna]);
        }

        $('#mExtendKegiatan').on('click', '.mc, .btn.bo', function() {
            $('#formExtendKegiatan')[0].reset();
            $('#errorExtend').hide();
        });

        $('#formExtendKegiatan').on('submit', function(e) {
            e.preventDefault();

            var id = $('#inputExtendId').val();

            $.ajax({
                    url: '/validasi-kegiatan/' + id + '/extend',
                    type: 'PUT',
                    data: {
                        tambah_semester: $('#inputTambahSemester').val(),
                        _token: '{{ csrf_token() }}',
                    },
                })
                .done(function(res) {
                    $('#mExtendKegiatan').removeClass('on');
                    showToast(res.message);
                    var d = res.data;
                    var colorMap = {
                        gr: 'var(--g5)',
                        or: 'var(--acc)',
                        pk: 'var(--red)'
                    };
                    var $card = $('[data-id="' + id + '"]').closest('.kc');

                    $card.find('.pb').css({
                        'width': d.presentase + '%',
                        'background': colorMap[d.warna],
                    });

                    $card.find('.fs11.tc2').filter(':contains("semester")').text(d.label_pemakaian);

                    if (!d.is_terkunci) {
                        $card.removeClass('lck');
                        $card.find('.bdg.blk').removeClass('blk').addClass('bok').text('✅ Aktif');
                        $card.find('.btn-extend-kegiatan').remove();
                        $card.find('.al.alw').remove();
                    }

                    $card.find('.btn-extend-kegiatan')
                        .data('maks', d.maks_pemakaian);
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON?.errors;
                    var msg = xhr.responseJSON?.message ||
                        Object.values(errors || {}).flat()[0] ||
                        'Gagal meng-extend kegiatan.';
                    $('#errorExtend').text(msg).show();
                });
        });
    </script>
@endpush
