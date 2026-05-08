@extends('layout.app')

@section('page-title', 'Portofolio Anak')
@section('page-subtitle', 'Pantau perkembangan anak Anda')

@section('content')
    <div class="card">
        @if ($siswas->isEmpty())
            <div class="card emp">
                <div class="ei">👶</div>
                <h3>Data anak belum terdaftar</h3>
                <p>Hubungi pihak sekolah untuk mendaftarkan anak Anda ke sistem.</p>
            </div>
        @else
            {{-- Pilih Siswa & Filter --}}
            <div class="mb16">
                <div class="card fb mt12">
                    {{-- Pilih Anak --}}
                    <select id="selectSiswaOrtu" onchange="window.location.href=this.value" style="min-width:180px">
                        @foreach ($siswas as $siswa)
                            <option
                                value="{{ route('ortu_porto', ['siswa_id' => $siswa->id, 'aspek_id' => request('aspek_id')]) }}"
                                {{ $siswaAktif?->id === $siswa->id ? 'selected' : '' }}>
                                {{ $siswa->jenis_kelamin === 'L' ? '👦' : '👧' }}
                                {{ $siswa->name }} - {{ $siswa->kelas?->name ?? '-' }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Filter Aspek --}}
                    <select id="selectAspekOrtu" onchange="window.location.href=this.value" style="min-width:180px">
                        <option value="{{ route('ortu_porto', ['siswa_id' => $siswaAktif?->id]) }}">
                            Semua Aspek
                        </option>
                        @foreach ($aspeks as $aspek)
                            <option
                                value="{{ route('ortu_porto', ['siswa_id' => $siswaAktif?->id, 'aspek_id' => $aspek->id]) }}"
                                {{ request('aspek_id') == $aspek->id ? 'selected' : '' }}>
                                {{ $aspek->emote }} {{ $aspek->name }}
                            </option>
                        @endforeach
                    </select>

                    <span class="fs11 tc2">{{ $portofolios->total() }} entri</span>
                </div>
            </div>

            @if ($siswaAktif)
                {{-- Header Anak --}}
                <div class="fl ic g12 mb16">
                    <div
                        style="width:50px;height:50px;border-radius:50%;background:linear-gradient(135deg,var(--g4),var(--g3));display:flex;align-items:center;justify-content:center;font-size:22px">
                        {{ $siswaAktif->jenis_kelamin === 'L' ? '👦' : '👧' }}</div>
                    <div>
                        <h3 style="font-size:16px;font-weight:800">{{ $siswaAktif->name }}</h3>
                        <p class="fs11 tc2">{{ $siswaAktif->kelas->name }} - {{ $totalEntri }} entri portofolio</p>
                    </div>
                    <button class="btn bp bsm" style="margin-left:auto">🖨️ Cetak Laporan</button>
                </div>

                {{-- Grafik Aspek --}}
                <div class="card mb16" style="border-color:var(--g2)">
                    <div class="fw7 fs11 mb12">📊 Grafik Aspek Perkembangan Zaid</div>
                    @foreach ($aspekData as $aspek)
                        <div class="graf-bar">
                            <div class="graf-label">
                                <span class="ap {{ $aspek['warna'] }}">
                                    {{ $aspek['emote'] }} {{ $aspek['name'] }}
                                </span>
                            </div>
                            <div class="graf-wrap">
                                @if ($aspek['jumlah'] > 0)
                                    <div class="graf-fill pb {{ $aspek['warna'] === 'a1'
                                        ? 'pk'
                                        : ($aspek['warna'] === 'a2'
                                            ? 'bl'
                                            : ($aspek['warna'] === 'a3'
                                                ? 'ye'
                                                : ($aspek['warna'] === 'a4'
                                                    ? 'gr'
                                                    : ($aspek['warna'] === 'a5'
                                                        ? 'pk'
                                                        : 'or')))) }}"
                                        style="width:{{ $aspek['persentase'] }}%">
                                        <span class="graf-val">{{ $aspek['jumlah'] }}</span>
                                    </div>
                                @else
                                    <div
                                        style="height:100%;display:flex;align-items:center;
                                            padding-left:8px">
                                        <span style="font-size:11px;color:var(--txt3)">0</span>
                                    </div>
                                @endif
                            </div>
                            <div class="graf-pct"
                                style="color:{{ $aspek['jumlah'] === 0 ? 'var(--txt3)' : 'var(--txt2)' }}">
                                {{ $aspek['persentase'] }}%
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Grid Portofolio --}}
                <div class="g4">
                    @forelse ($portofolios as $porto)
                        <div class="pfc" style="cursor: pointer" data-porto-id="{{ $porto->id }}">
                            <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">
                                <span style="font-size:52px">{{ $porto->foto_icon }}</span>
                            </div>
                            <div class="pfb">
                                <div class="pfd">📅 {{ $porto->tanggal_format }}</div>

                                @if ($porto->kegiatan)
                                    <div class="fs11 tc2 mt4">
                                        🎭 {{ $porto->kegiatan->name }}
                                    </div>
                                @endif

                                <div class="pfnt mt8">{{ Str::limit($porto->catatan, 100) }}</div>

                                <div class="fl fw g8 mt8">
                                    @foreach ($porto->aspeks as $aspek)
                                        <span class="ap {{ $aspek->warna }}">
                                            {{ $aspek->emote }} {{ $aspek->name }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="fl ic jb mt8">
                                    <div class="fs11 tc2">
                                        💬 {{ $porto->komentars_count }} komentar
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pagination --}}
                        {{ $portofolios->links() }}
                    @empty
                        <div class="emp">
                            <div class="ei">📭</div>
                            <h3>Belum ada entri portofolio</h3>
                            <p>Portofolio akan muncul setelah guru menginput
                                dokumentasi kegiatan {{ $siswaAktif->name }}.</p>
                        </div>
                    @endforelse
                </div>
            @endif
        @endif
    </div>

    {{-- Modal: Detail Portofolio --}}
    <div class="mo" id="mDetailPortoOrtu">
        <div class="md mlg">
            <div class="mh">
                <div>
                    <div class="mt2" id="mDetailOrtuTitle">📸 Portofolio</div>
                    <div class="mst" id="mDetailOrtuSubtitle" style="color:var(--txt3)"></div>
                </div>
                <button type="button" class="mc">✕</button>
            </div>
            <div class="mb">

                {{-- Loading --}}
                <div id="mDetailOrtuLoading" style="text-align:center;padding:40px;color:var(--txt3)">
                    ⏳ Memuat...
                </div>

                <div id="mDetailOrtuContent" style="display:none">
                    <div id="mDetailOrtuHero"
                        style="height:180px;border-radius:var(--r);
                            background:linear-gradient(135deg,var(--g1),var(--g2));
                            display:flex;align-items:center;justify-content:center;
                            font-size:80px;margin-bottom:16px">
                    </div>
                    <div class="fr c3 mb16">
                        <div class="ib">
                            <div class="ik">Nama Siswa</div>
                            <div class="iv" id="mDetailOrtuNama">-</div>
                        </div>
                        <div class="ib">
                            <div class="ik">Tanggal</div>
                            <div class="iv" id="mDetailOrtuTanggal">-</div>
                        </div>
                        <div class="ib">
                            <div class="ik">Kegiatan</div>
                            <div class="iv" id="mDetailOrtuKegiatan">-</div>
                        </div>
                    </div>

                    <div
                        style="background:var(--g0);border-radius:var(--r2);
                            padding:16px;border:1px solid var(--g1);margin-bottom:16px">
                        <div class="fw7 mb8">📝 Catatan Perkembangan Guru</div>
                        <div id="mDetailOrtuCatatan" style="font-size:13px;color:var(--txt2);line-height:1.7">
                        </div>
                    </div>

                    <div class="mb16">
                        <div class="fw7 mb8">✅ Aspek yang Dicapai</div>
                        <div id="mDetailOrtuAspek" class="fl fw g8"></div>
                    </div>

                    {{-- Komentar --}}
                    <div>
                        <div class="fw7 mb8" id="mDetailOrtuKomentarTitle">
                            💬 Komentar (0)
                        </div>
                        <div id="mDetailOrtuKomentars"></div>

                        {{-- Input komentar ortu --}}
                        <div class="mt12"
                            style="background:var(--g0);border-radius:var(--r2);
                                             padding:12px;border:1px solid var(--g1)">
                            <div class="fs11 tc2 mb8" style="font-weight:700">
                                💬 Tulis Komentar
                            </div>
                            <div class="fl g8">
                                <input type="text" id="mDetailOrtuInputKomentar"
                                    placeholder="Contoh: Terima kasih Bu Guru, anak saya senang bercerita tentang kegiatan ini..."
                                    style="flex:1;padding:9px 12px;border:2px solid var(--g1);
                                          border-radius:var(--r2);font-size:13px" />
                                <button type="button" class="btn bp bsm" id="mDetailOrtuBtnKomentar">
                                    Kirim
                                </button>
                            </div>
                            <div id="errorKomentarOrtu" class="al ale mt8" style="display:none"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="mf">
                <button type="button" class="btn bp" id="mDetailOrtuBtnCetak">
                    🖨️ Cetak Laporan
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var activePortoOrtuId = null;

        $(document).on('click', '.pfc[data-porto-id]', function() {
            activePortoOrtuId = $(this).data('porto-id');
            bukaDetailPortoOrtu(activePortoOrtuId);
        });

        function bukaDetailPortoOrtu(id) {
            $('#mDetailOrtuLoading').show();
            $('#mDetailOrtuContent').hide();
            $('#mDetailOrtuTitle').text('📸 Portofolio');
            $('#mDetailOrtuSubtitle').text('');
            $('#mDetailOrtuHero').text('');
            $('#mDetailOrtuNama, #mDetailOrtuTanggal, #mDetailOrtuKegiatan').text('-');
            $('#mDetailOrtuCatatan').text('');
            $('#mDetailOrtuAspek, #mDetailOrtuKomentars').empty();
            $('#mDetailOrtuInputKomentar').val('');
            $('#errorKomentarOrtu').hide();

            $('#mDetailPortoOrtu').addClass('on');

            $.get('/portofolio-anak/' + id + '/detail')
                .done(function(res) {
                    var d = res.data;

                    $('#mDetailOrtuTitle').text('📸 Portofolio - ' + d.nama_siswa);
                    $('#mDetailOrtuSubtitle').text(d.tanggal_raw);
                    $('#mDetailOrtuHero').text(d.foto_icon);
                    $('#mDetailOrtuNama').text((d.jk === 'L' ? '👦 ' : '👧 ') + d.nama_siswa);
                    $('#mDetailOrtuTanggal').text(d.tanggal_raw);
                    $('#mDetailOrtuKegiatan').text(d.kegiatan || d.sub_tema || '-');
                    $('#mDetailOrtuCatatan').text(d.catatan);

                    var aspekHtml = '';
                    $.each(d.aspeks, function(i, a) {
                        aspekHtml += '<span class="ap ' + a.warna + '">' +
                            a.emote + ' ' + a.name + '</span>';
                    });
                    $('#mDetailOrtuAspek').html(aspekHtml || '<span class="fs11 tc2">-</span>');

                    renderKomentarOrtu(d.komentars);

                    $('#mDetailOrtuLoading').hide();
                    $('#mDetailOrtuContent').show();
                })
                .fail(function() {
                    $('#mDetailOrtuLoading').text('❌ Gagal memuat data.');
                });
        }

        $('#mDetailOrtuBtnKomentar').on('click', function() {
            var komentar = $('#mDetailOrtuInputKomentar').val().trim();
            if (!komentar || !activePortoOrtuId) return;

            $.post('/portofolio-anak/' + activePortoOrtuId + '/komentar', {
                    komentar: komentar,
                    _token: '{{ csrf_token() }}',
                })
                .done(function(res) {
                    var d = res.data;
                    var icon = d.role === 'ortu' ? '👨‍👩‍👧' : '🧑‍🏫';
                    var html = '<div class="kom-item">' +
                        '<div class="kom-author">' + icon + ' ' + d.author + '</div>' +
                        '<div class="kom-text">' + d.komentar + '</div>' +
                        '<div class="kom-time">🕐 ' + d.waktu + '</div>' +
                        '</div>';

                    $('#mDetailOrtuKomentars').append(html);
                    $('#mDetailOrtuInputKomentar').val('');
                    $('#errorKomentarOrtu').hide();

                    var current = parseInt(
                        $('#mDetailOrtuKomentarTitle').text().match(/\d+/)?.[0] || 0
                    ) + 1;
                    $('#mDetailOrtuKomentarTitle').text('💬 Komentar (' + current + ')');

                    var $card = $('#porto-ortu-' + activePortoOrtuId);
                    var $count = $card.find('.fs11.tc2');
                    $count.first().text('💬 ' + current + ' komentar');
                })
                .fail(function(xhr) {
                    var msg = xhr.responseJSON?.errors?.komentar?.[0] ||
                        'Gagal mengirim komentar.';
                    $('#errorKomentarOrtu').text(msg).show();
                });
        });

        $('#mDetailOrtuInputKomentar').on('keypress', function(e) {
            if (e.which === 13) {
                $('#mDetailOrtuBtnKomentar').trigger('click');
            }
        });

        $('#mDetailOrtuBtnCetak').on('click', function() {
            if (!activePortoOrtuId) return;
            window.open('/portofolio-siswa/' + activePortoOrtuId + '/cetak', '_blank');
        });

        function renderKomentarOrtu(komentars) {
            $('#mDetailOrtuKomentarTitle').text('💬 Komentar (' + komentars.length + ')');

            if (komentars.length === 0) {
                $('#mDetailOrtuKomentars').html(
                    '<div class="fs11 tc2" style="padding:8px 0">Belum ada komentar.</div>'
                );
                return;
            }

            var html = '';
            $.each(komentars, function(i, k) {
                var icon = k.role === 'ortu' ? '👨‍👩‍👧' : '🧑‍🏫';
                html += '<div class="kom-item">' +
                    '<div class="kom-author">' + icon + ' ' + k.author + '</div>' +
                    '<div class="kom-text">' + k.teks + '</div>' +
                    '<div class="kom-time">🕐 ' + k.waktu + '</div>' +
                    '</div>';
            });

            $('#mDetailOrtuKomentars').html(html);
        }
    </script>
@endpush
