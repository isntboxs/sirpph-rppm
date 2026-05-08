@extends('layout.app')

@section('page-title', 'Lihat RPPM')
@section('page-subtitle', 'Rencana Pembelajaran Mingguan Kelas Anak - ' . $taAktif->name)

@section('content')

    @if ($siswas->isEmpty())
        <div class="card emp">
            <div class="ei">👶</div>
            <h3>Data anak belum terdaftar</h3>
            <p>Hubungi pihak sekolah untuk mendaftarkan anak Anda ke sistem.</p>
        </div>
    @else
        <div class="card mb16">
            <div class="ct mb8">Anak Terdaftar</div>
            <div class="fl fw g8">
                @foreach ($siswas as $siswa)
                    <div class="fl ic g8"
                        style="padding:8px 14px;background:var(--g0);border:1px solid var(--g2);
                        border-radius:20px">
                        <span>{{ $siswa->jenis_kelamin === 'L' ? '👦' : '👧' }}</span>
                        <div>
                            <div class="fw7" style="font-size:12.5px">{{ $siswa->name }}</div>
                            <div class="fs11 tc2">{{ $siswa->kelas?->name ?? '-' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Filter --}}
        <div class="fb mb16">
            <form class="fl fw g8 ic" id="formFilterRppm">
                <select name="tema_id" onchange="this.form.submit()">
                    <option value="">Semua Tema</option>
                    @foreach ($temas as $tema)
                        <option value="{{ $tema->id }}" {{ request('tema_id') == $tema->id ? 'selected' : '' }}>
                            {{ $tema->name }}
                        </option>
                    @endforeach
                </select>
                @if (request('tema_id'))
                    <a href="{{ route('ortu_rppm') }}" class="btn bo bsm">Reset</a>
                @endif
            </form>
        </div>

        {{-- List RPPM --}}
        @forelse ($rppms as $rppm)
            <div class="rc2">
                <div class="rh">
                    <div>
                        <div class="rw">
                            Minggu ke-{{ $rppm->minggu_ke }} •
                            {{ $rppm->guru->name }} •
                            {{ $rppm->tahunAjaran->name }}
                        </div>
                        <div class="rn">{{ $rppm->subTema->tema->name }}</div>
                        <div class="rs">{{ $rppm->subTema->name }}</div>
                    </div>
                    <span class="bdg bok">✅ Disetujui</span>
                </div>

                {{-- Aspek yang distimulasi minggu ini --}}
                @php
                    $aspekMingguIni = $rppm->rppmKegiatans->flatMap(fn($rk) => $rk->kegiatan->aspeks)->unique('id');
                @endphp
                @if ($aspekMingguIni->isNotEmpty())
                    <div class="fl fw g8 mt8 mb8">
                        @foreach ($aspekMingguIni as $aspek)
                            <span class="ap {{ $aspek->warna }}">
                                {{ $aspek->emote }} {{ $aspek->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Kegiatan per hari ringkas --}}
                <div class="fl fw g8 mt4 mb8">
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                        @php $count = $rppm->rppmKegiatans->where('hari', $hari)->count(); @endphp
                        <div
                            style="padding:4px 10px;border-radius:6px;font-size:11px;font-weight:700;
                    background:{{ $count > 0 ? 'var(--g1)' : 'var(--g0)' }};
                    border:1px solid {{ $count > 0 ? 'var(--g4)' : 'var(--g2)' }};
                    color:{{ $count > 0 ? 'var(--g7)' : 'var(--txt3)' }}">
                            {{ $hari }} {{ $count > 0 ? '(' . $count . ')' : '-' }}
                        </div>
                    @endforeach
                </div>

                <div class="ract">
                    <button type="button" class="btn bp bsm btn-detail-rppm" data-id="{{ $rppm->id }}">
                        🔍 Lihat Detail
                    </button>
                </div>
            </div>
        @empty
            <div class="card emp">
                <div class="ei">📋</div>
                <h3>Belum ada RPPM yang tersedia</h3>
                <p>RPPM akan muncul setelah disetujui oleh Kepala Sekolah.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        {{ $rppms->links() }}
    @endif

    {{-- Modal Detail RPPM --}}
    <div class="mo" id="mDetailRppmOrtu">
        <div class="md mlg">
            <div class="mh">
                <div>
                    <div class="mt2" id="mDetailRppmTitle">📋 Detail RPPM</div>
                    <div class="mst" id="mDetailRppmSubtitle" style="color:var(--txt3)"></div>
                </div>
                <button type="button" class="mc">✕</button>
            </div>
            <div class="mb">

                {{-- Loading --}}
                <div id="mDetailRppmLoading" style="text-align:center;padding:40px;color:var(--txt3)">
                    ⏳ Memuat...
                </div>

                <div id="mDetailRppmContent" style="display:none">
                    <div class="ig mb16" id="mDetailRppmInfo"></div>
                    <div class="g2 mb16" id="mDetailRppmTujuan"></div>
                    <div id="mDetailRppmKegiatan"></div>
                </div>
            </div>
            <div class="mf">
                <button type="button" class="btn bp" id="btnCetakRppmOrtu">
                    🖨️ Cetak
                </button>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var activeRppmId = null;

        $(document).on('click', '.btn-detail-rppm', function() {
            activeRppmId = $(this).data('id');

            $('#mDetailRppmLoading').show();
            $('#mDetailRppmContent').hide();
            $('#mDetailRppmInfo, #mDetailRppmTujuan, #mDetailRppmKegiatan').empty();
            $('#mDetailRppmOrtu').addClass('on');

            $.get('/lihat-rppm/' + activeRppmId + '/detail')
                .done(function(res) {
                    var d = res.data;

                    $('#mDetailRppmTitle').text('📋 RPPM - ' + d.tema);
                    $('#mDetailRppmSubtitle').text(d.sub_tema + ' • Mgg ke-' + d.minggu_ke);

                    $('#mDetailRppmInfo').html(
                        '<div class="ib"><div class="ik">Tema</div><div class="iv">' + d.tema +
                        '</div></div>' +
                        '<div class="ib"><div class="ik">Sub Tema</div><div class="iv">' + d.sub_tema +
                        '</div></div>' +
                        '<div class="ib"><div class="ik">Minggu Ke</div><div class="iv">' + d.minggu_ke +
                        '</div></div>' +
                        '<div class="ib"><div class="ik">Guru</div><div class="iv">' + d.guru +
                        '</div></div>' +
                        '<div class="ib"><div class="ik">Model</div><div class="iv">' + d.model +
                        '</div></div>'
                    );

                    var tujuanHtml = '';
                    if (d.tujuan && d.tujuan !== '-') {
                        tujuanHtml += '<div class="ib"><div class="ik">Tujuan</div>' +
                            '<div class="iv" style="font-size:12px;font-weight:400;line-height:1.5">' +
                            d.tujuan + '</div></div>';
                    }
                    if (d.capaian && d.capaian !== '-') {
                        tujuanHtml += '<div class="ib"><div class="ik">Capaian</div>' +
                            '<div class="iv" style="font-size:12px;font-weight:400;line-height:1.5">' +
                            d.capaian + '</div></div>';
                    }
                    $('#mDetailRppmTujuan').html(tujuanHtml);

                    var hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                    var kegHtml = '';

                    $.each(hariList, function(i, hari) {
                        var kegiatanHari = d.kegiatan[hari];
                        if (!kegiatanHari || kegiatanHari.length === 0) return;

                        kegHtml += '<div class="ds mb8">' +
                            '<div class="dsh"><span class="dn">📅 ' + hari + '</span>' +
                            '<span class="fs11 tc2">' + kegiatanHari.length + ' kegiatan</span></div>';

                        $.each(kegiatanHari, function(j, keg) {
                            kegHtml += '<div class="dki">' +
                                '<div>' +
                                '<div style="font-weight:700;font-size:12.5px">' +
                                keg.icon + ' ' + keg.name + '</div>' +
                                '<div class="fs11 tc2 mt4">🎭 ' + keg.bentuk;

                            if (keg.alat) {
                                kegHtml += ' &nbsp;|&nbsp; 🔧 ' + keg.alat;
                            }

                            kegHtml += '</div><div class="fl fw g8 mt4">';

                            $.each(keg.aspeks, function(k, aspek) {
                                kegHtml += '<span class="ap ' + aspek.warna + '">' +
                                    aspek.emote + ' ' + aspek.name + '</span>';
                            });

                            kegHtml += '</div></div></div>';
                        });

                        kegHtml += '</div>';
                    });

                    $('#mDetailRppmKegiatan').html(kegHtml);

                    $('#mDetailRppmLoading').hide();
                    $('#mDetailRppmContent').show();
                })
                .fail(function() {
                    $('#mDetailRppmLoading').text('❌ Gagal memuat data.');
                });
        });

        $('#btnCetakRppmOrtu').on('click', function() {
            if (!activeRppmId) return;
            window.open('/lihat-rppm/' + activeRppmId + '/cetak', '_blank');
        });
    </script>
@endpush
