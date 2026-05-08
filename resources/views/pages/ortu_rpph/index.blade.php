@extends('layout.app')

@section('page-title', 'Lihat RPPH')
@section('page-subtitle', 'Rencana Pembelajaran Harian Kelas Anak - ' . $taAktif->name)

@section('content')
    <div class="card">
        <div class="ch">
            <div class="ct">📄 RPPH Kelas Anak</div>
            <div class="cs">Hanya RPPH yang telah disetujui</div>
        </div>

        @if ($siswas->isEmpty())
            <div class="card emp">
                <div class="ei">👶</div>
                <h3>Data anak belum terdaftar</h3>
                <p>Hubungi pihak sekolah untuk mendaftarkan anak Anda.</p>
            </div>
        @else
            {{-- Filter --}}
            <div class="fb mb16">
                <form class="fl fw g8 ic">
                    <select name="hari" onchange="this.form.submit()">
                        <option value="">Semua Hari</option>
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                            <option value="{{ $hari }}" {{ request('hari') === $hari ? 'selected' : '' }}>
                                {{ $hari }}
                            </option>
                        @endforeach
                    </select>
                    @if (request('hari'))
                        <a href="{{ route('ortu_rpph') }}" class="btn bo bsm">Reset</a>
                    @endif
                </form>
            </div>

            @forelse ($rpphs as $rpph)
                <div class="rc2">
                    <div class="rh">
                        <div>
                            <div class="rw">{{ $rpph->hari }}, {{ $rpph->tanggal_format }} •
                                {{ $rpph->rppm->guru->name }}
                            </div>
                            <div class="rn">{{ $rpph->rppm->subTema->tema->name }}</div>
                            <div class="rs">{{ $rpph->rppm->subTema->name }}</div>
                        </div>
                    </div>
                    <div class="ract">
                        <button class="btn bo bsm btn-detail-rpph" data-id="{{ $rpph->id }}"
                            data-hari="{{ $rpph->hari }}" data-pending="true">🔍 Detail</button>
                        <button class="btn bo bsm">🖨️</button>
                    </div>
                </div>
            @empty
                <div class="emp">
                    <div class="ei">📅</div>
                    <h3>Belum ada RPPH yang tersedia</h3>
                    <p>RPPH akan muncul setelah disetujui oleh Kepala Sekolah.</p>
                </div>
            @endforelse
        @endif
    </div>


    {{-- Detail RPPH --}}
    <div class="mo" id="mDetailRpph">
        <div class="md mlg">
            <div class="mh">
                <div>
                    <div class="mt2" id="mDetailRpphTitle">✏️ Detail RPPH</div>
                    <div class="mst" id="mDetailRpphSubtitle" style="color:var(--txt3)"></div>
                </div>
                <button type="button" class="mc">✕</button>
            </div>
            <div class="mb">
                <div class="fr c3 mb16">
                    <div class="ib">
                        <div class="ik">Hari</div>
                        <div class="iv" id="mDetailHari">-</div>
                    </div>
                    <div class="ib">
                        <div class="ik">Tanggal</div>
                        <div class="iv" id="mDetailTanggal">-</div>
                    </div>
                    <div class="ib">
                        <div class="ik">Kelas</div>
                        <div class="iv" id="mDetailKelas">-</div>
                    </div>
                </div>

                <div class="ib mb16">
                    <div class="ik">Sub-Sub Tema</div>
                    <div class="iv" id="mDetailSubTema">-</div>
                </div>

                <div id="mDetailKegiatan" class="mb16"></div>

                <div class="mb12" id="mDetailPembukaWrap" style="display:none">
                    <div style="background:var(--g0);border-radius:var(--r2);padding:14px 16px;border:1px solid var(--g1)">
                        <div class="fs11 tc2 mb4" style="font-weight:700;letter-spacing:.5px;text-transform:uppercase">
                            Pembuka
                        </div>
                        <div id="mDetailPembuka" style="font-size:13px;color:var(--txt2);line-height:1.6"></div>
                    </div>
                </div>

                <div class="mb12" id="mDetailIntiWrap" style="display:none">
                    <div style="background:var(--g0);border-radius:var(--r2);padding:14px 16px;border:1px solid var(--g1)">
                        <div class="fs11 tc2 mb4" style="font-weight:700;letter-spacing:.5px;text-transform:uppercase">
                            Inti
                        </div>
                        <div id="mDetailInti" style="font-size:13px;color:var(--txt2);line-height:1.6;white-space:pre-line">
                        </div>
                    </div>
                </div>

                <div class="mb12" id="mDetailPenutupWrap" style="display:none">
                    <div style="background:var(--g0);border-radius:var(--r2);padding:14px 16px;border:1px solid var(--g1)">
                        <div class="fs11 tc2 mb4" style="font-weight:700;letter-spacing:.5px;text-transform:uppercase">
                            Penutup
                        </div>
                        <div id="mDetailPenutup" style="font-size:13px;color:var(--txt2);line-height:1.6"></div>
                    </div>
                </div>

                <div id="mDetailLoading" style="text-align:center;padding:32px;color:var(--txt3)">
                    ⏳ Memuat data...
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var activeRpphId = null;
        var activeRpphHari = null;

        $(document).on('click', '.btn-detail-rpph', function() {
            activeRpphId = $(this).data('id');
            activeRpphHari = $(this).data('hari');
            var isPending = $(this).data('pending') === true;

            $('#mDetailLoading').show();
            $('#mDetailPembukaWrap, #mDetailIntiWrap, #mDetailPenutupWrap').hide();
            $('#mDetailFooter').hide();
            $('#mDetailKegiatan').empty();
            $('#mDetailRpphTitle').text('✏️ Detail RPPH');
            $('#mDetailRpphSubtitle').text('');
            $('#mDetailHari, #mDetailTanggal, #mDetailKelas, #mDetailSubTema').text('-');

            $('#mDetailRpph').addClass('on');

            $.get('/lihat-rpph/' + activeRpphId + '/detail')
                .done(function(res) {
                    var d = res.data;

                    $('#mDetailLoading').hide();

                    $('#mDetailRpphTitle').text('✏️ RPPH - ' + d.hari);
                    $('#mDetailRpphSubtitle').text(d.hari + ' - ' + d.tema + ' | ' + d.sub_tema);
                    $('#mDetailHari').text(d.hari);
                    $('#mDetailTanggal').text(d.tanggal || '-');
                    $('#mDetailKelas').text(d.kelas || '-');
                    $('#mDetailSubTema').text(d.sub_tema);

                    if (d.kegiatan.length > 0) {
                        var kegHtml = '<div class="ib mb8"><div class="ik">Kegiatan</div></div>';
                        $.each(d.kegiatan, function(i, keg) {
                            kegHtml += '<div class="dki mb4">' +
                                '<div>' +
                                '<span style="font-weight:700;font-size:12.5px">' +
                                keg.icon + ' ' + keg.name + '</span>' +
                                ' <span class="fs11 tc2">(' + keg.bentuk + ')</span>' +
                                '<div class="fl fw g8 mt4">';
                            $.each(keg.aspeks, function(j, aspek) {
                                kegHtml += '<span class="ap ' + aspek.warna + '">' +
                                    aspek.emote + ' ' + aspek.name + '</span>';
                            });
                            kegHtml += '</div></div></div>';
                        });
                        $('#mDetailKegiatan').html(kegHtml);
                    }

                    if (d.pembuka) {
                        $('#mDetailPembuka').text(d.pembuka);
                        $('#mDetailPembukaWrap').show();
                    }
                    if (d.inti) {
                        $('#mDetailInti').text(d.inti);
                        $('#mDetailIntiWrap').show();
                    }
                    if (d.penutup) {
                        $('#mDetailPenutup').text(d.penutup);
                        $('#mDetailPenutupWrap').show();
                    }

                    if (isPending && d.status === 'pending') {
                        $('#mDetailFooter').show();
                    }
                })
                .fail(function() {
                    $('#mDetailLoading').text('❌ Gagal memuat data.');
                });
        });
    </script>
@endpush
