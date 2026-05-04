@extends('layout.app')

@section('page-title', 'Validasi RPPH')
@section('page-subtitle', $taAktif?->name ?? '-')

@section('content')
    <div class="card">
        <div class="ch">
            <div class="ct">📄 Validasi RPPH</div>
        </div>

        <div class="tabs">
            <button class="tbn on" data-tab="tab-pending-rpph">
                ⏳ Menunggu
                @if ($pending->count() > 0)
                    <span class="nbg" style="margin-left:4px">{{ $pending->count() }}</span>
                @endif
            </button>
            <button class="tbn" data-tab="tab-riwayat-rpph">📋 Riwayat</button>
        </div>

        {{-- Tab: Menunggu --}}
        {{-- <div id="vtab-menunggu" class="tab-content">
            <div class="rc2">
                <div class="rh">
                    <div>
                        <div class="rw">Senin, 14 Juli 2025 • Kelas A</div>
                        <div class="rn">Aku, Makhluq Allah</div>
                        <div class="rs">Allah Tuhanku — Aku Bersyukur kepada Allah</div>
                    </div>
                    <span class="bdg bpnd">⏳ Pending</span>
                </div>
                <div class="ract">
                    <button class="btn bo bsm">🔍 Detail</button>
                    <button class="btn bp bsm" onclick="showToast('✅ RPPH berhasil disetujui')">✅ Setujui</button>
                    <button class="btn bd bsm">↩️</button>
                    <button class="btn bo bsm">🖨️</button>
                </div>
            </div>
            <div class="rc2">
                <div class="rh">
                    <div>
                        <div class="rw">Selasa, 15 Juli 2025 • Kelas B</div>
                        <div class="rn">Tanah Airku</div>
                        <div class="rs">Identitas Negara — Bendera Merah Putih</div>
                    </div>
                    <span class="bdg bpnd">⏳ Pending</span>
                </div>
                <div class="ract">
                    <button class="btn bo bsm">🔍 Detail</button>
                    <button class="btn bp bsm" onclick="showToast('✅ RPPH berhasil disetujui')">✅ Setujui</button>
                    <button class="btn bd bsm">↩️</button>
                    <button class="btn bo bsm">🖨️</button>
                </div>
            </div>
        </div> --}}

        <div id="tab-pending-rpph" class="tab-content">
            @forelse ($pending as $rpph)
                <div class="rc2" id="row-rpph-{{ $rpph->id }}">
                    <div class="rh">
                        <div>
                            <div class="rw">
                                📅 {{ $rpph->hari }} •
                                {{ $rpph->rppm->guru->name }} •
                                {{ $rpph->rppm->tahunAjaran->name }}
                            </div>
                            <div class="rn">{{ $rpph->rppm->subTema->tema->name }}</div>
                            <div class="rs">{{ $rpph->rppm->subTema->name }}</div>
                        </div>
                        <span class="bdg bpnd">⏳ Pending</span>
                    </div>

                    {{-- @php
                        $kegiatanHari = $rpph->rppm->rppmKegiatans->where('hari', $rpph->hari);
                    @endphp
                    <div class="mt8 mb8">
                        @foreach ($kegiatanHari as $rk)
                            <div class="dki mb4">
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
                    </div>

                    @if ($rpph->pembuka)
                        <div class="ib mb8">
                            <div class="ik">Pembuka</div>
                            <div style="font-size:12px;color:var(--txt2);margin-top:3px;line-height:1.5">
                                {{ $rpph->pembuka }}
                            </div>
                        </div>
                    @endif

                    @if ($rpph->inti)
                        <div class="ib mb8">
                            <div class="ik">Inti</div>
                            <div style="font-size:12px;color:var(--txt2);margin-top:3px">
                                {{ $rpph->inti }}
                            </div>
                        </div>
                    @endif

                    @if ($rpph->penutup)
                        <div class="ib mb8">
                            <div class="ik">Penutup</div>
                            <div style="font-size:12px;color:var(--txt2);margin-top:3px">
                                {{ $rpph->penutup }}
                            </div>
                        </div>
                    @endif --}}

                    <div class="ract">
                        <button type="button" class="btn bo bsm btn-detail-rpph" data-id="{{ $rpph->id }}"
                            data-hari="{{ $rpph->hari }}" data-pending="true">
                            🔍 Detail
                        </button>
                        <button type="button" class="btn bp bsm btn-setujui-rpph" data-id="{{ $rpph->id }}"
                            data-hari="{{ $rpph->hari }}">
                            ✅ Setujui
                        </button>
                        <button type="button" class="btn bd bsm btn-buka-kembalikan-rpph" data-id="{{ $rpph->id }}"
                            data-info="{{ $rpph->hari }} - {{ $rpph->rppm->subTema->name }}">
                            ↩️ Kembalikan
                        </button>
                        <button type="button" class="btn bo bsm"
                            onclick="window.open('/rpph/{{ $rpph->id }}/cetak', '_blank')">
                            🖨️
                        </button>
                    </div>
                </div>
            @empty
                <div class="emp">
                    <div class="ei">✅</div>
                    <h3>Tidak ada RPPH yang menunggu</h3>
                    <p>Semua RPPH sudah divalidasi.</p>
                </div>
            @endforelse
        </div>

        {{-- Tab: Disetujui --}}
        <div id="tab-riwayat-rpph" class="tab-content" style="display:none">
            <form class="card mb16">
                <div class="fl fw g8 ic">
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>
                            ✅ Disetujui
                        </option>
                        <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>
                            ↩️ Dikembalikan
                        </option>
                    </select>
                    <select name="guru_id">
                        <option value="">Semua Guru</option>
                        @foreach ($guruList as $guru)
                            <option value="{{ $guru->id }}" {{ request('guru_id') == $guru->id ? 'selected' : '' }}>
                                {{ $guru->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn bp bsm">🔍 Filter</button>
                    <a href="{{ route('validasi_rpph') }}" class="btn bo bsm">Reset</a>
                </div>
            </form>

            @forelse ($riwayat as $rpph)
                <div class="rc2">
                    <div class="rh">
                        <div>
                            <div class="rw">
                                📅 {{ $rpph->hari }} •
                                {{ $rpph->rppm->guru->name }}
                            </div>
                            <div class="rn">{{ $rpph->rppm->subTema->tema->name }}</div>
                            <div class="rs">{{ $rpph->rppm->subTema->name }}</div>
                            @if ($rpph->status === 'dikembalikan' && $rpph->catatan_kepala)
                                <div class="al ale mt8" style="font-size:11.5px">
                                    📝 {{ $rpph->catatan_kepala }}
                                </div>
                            @endif
                        </div>
                        <span class="bdg {{ $rpph->status_badge_class }}">
                            {{ $rpph->status_label }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="emp">
                    <div class="ei">📋</div>
                    <h3>Belum ada riwayat</h3>
                </div>
            @endforelse

            {{ $riwayat->links() }}
        </div>

        {{-- Modal Kembalikan --}}
        <div class="mo" id="mKembalikanRpph">
            <div class="md mmd">
                <form id="formKembalikanRpph">
                    <input type="hidden" id="inputKembalikanRpphId" />
                    <div class="mh">
                        <div>
                            <div class="mt2">↩️ Kembalikan RPPH</div>
                            <div class="mst" id="labelInfoKembalikanRpph" style="color:var(--txt3)"></div>
                        </div>
                        <button type="button" class="mc">✕</button>
                    </div>
                    <div class="mb">
                        <div class="ff">
                            <label>Catatan untuk Guru</label>
                            <textarea id="inputCatatanKembalikanRpph" rows="4"
                                placeholder="Penjelasan apa yang perlu diperbaiki..."></textarea>
                        </div>
                        <div id="errorKembalikanRpph" class="al ale mt8" style="display:none"></div>
                    </div>
                    <div class="mf">
                        <button type="button" class="btn bo">Batal</button>
                        <button type="submit" class="btn bd btn-submit-form">↩️ Kembalikan</button>
                    </div>
                </form>
            </div>
        </div>

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
                        <div
                            style="background:var(--g0);border-radius:var(--r2);padding:14px 16px;border:1px solid var(--g1)">
                            <div class="fs11 tc2 mb4"
                                style="font-weight:700;letter-spacing:.5px;text-transform:uppercase">
                                Pembuka
                            </div>
                            <div id="mDetailPembuka" style="font-size:13px;color:var(--txt2);line-height:1.6"></div>
                        </div>
                    </div>

                    <div class="mb12" id="mDetailIntiWrap" style="display:none">
                        <div
                            style="background:var(--g0);border-radius:var(--r2);padding:14px 16px;border:1px solid var(--g1)">
                            <div class="fs11 tc2 mb4"
                                style="font-weight:700;letter-spacing:.5px;text-transform:uppercase">
                                Inti
                            </div>
                            <div id="mDetailInti"
                                style="font-size:13px;color:var(--txt2);line-height:1.6;white-space:pre-line"></div>
                        </div>
                    </div>

                    <div class="mb12" id="mDetailPenutupWrap" style="display:none">
                        <div
                            style="background:var(--g0);border-radius:var(--r2);padding:14px 16px;border:1px solid var(--g1)">
                            <div class="fs11 tc2 mb4"
                                style="font-weight:700;letter-spacing:.5px;text-transform:uppercase">
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
            $(document).on('click', '[data-tab]', function() {
                var target = $(this).data('tab');
                $(this).closest('.tabs').find('.tbn').removeClass('on');
                $(this).addClass('on');
                $('.tab-content').hide();
                $('#' + target).show();
            });

            $(document).on('click', '.btn-setujui-rpph', function() {
                var id = $(this).data('id');
                var hari = $(this).data('hari');
                var $row = $('#row-rpph-' + id);

                if (!confirm('Setujui RPPH hari ' + hari + ' ini?')) return;

                $.ajax({
                        url: '/validasi-rpph/' + id + '/setujui',
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                    })
                    .done(function(res) {
                        $row.fadeOut(300, function() {
                            $(this).remove();
                        });
                        showToast(res.message);
                        updateBadgeRpph();
                    })
                    .fail(function(xhr) {
                        showToast('❌ ' + xhr.responseJSON.message);
                    });
            });

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

                $.get('/validasi-rpph/' + activeRpphId + '/detail')
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

            $(document).on('click', '.btn-buka-kembalikan-rpph', function() {
                $('#inputKembalikanRpphId').val($(this).data('id'));
                $('#labelInfoKembalikanRpph').text($(this).data('info'));
                $('#errorKembalikanRpph').hide();
                $('#mKembalikanRpph').addClass('on');
            });

            $('#mKembalikanRpph').on('click', '.mc, .btn.bo', function() {
                $('#formKembalikanRpph')[0].reset();
                $('#errorKembalikanRpph').hide();
            });

            $('#formKembalikanRpph').on('submit', function(e) {
                e.preventDefault();

                var id = $('#inputKembalikanRpphId').val();

                $.ajax({
                        url: '/validasi-rpph/' + id + '/kembalikan',
                        type: 'PUT',
                        data: {
                            catatan: $('#inputCatatanKembalikanRpph').val(),
                            _token: '{{ csrf_token() }}',
                        },
                    })
                    .done(function(res) {
                        $('#mKembalikanRpph').removeClass('on');
                        $('#row-rpph-' + id).fadeOut(300, function() {
                            $(this).remove();
                        });
                        showToast(res.message);
                        updateBadgeRpph();
                    })
                    .fail(function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        $('#errorKembalikanRpph').text(errors.catatan[0]).show();
                    });
            });

            function updateBadgeRpph() {
                var $badge = $('.tabs .nbg').first();
                var count = parseInt($badge.text()) - 1;
                count <= 0 ? $badge.remove() : $badge.text(count);
            }
        </script>
    @endpush
