@extends('layout.app')

@section('page-title', 'Edit Kegiatan RPPM')
@section('page-subtitle', $rppm->subTema->tema->name . ' - ' . $rppm->subTema->name)

@section('content')

    {{-- Header Info RPPM --}}
    <div class="card mb16">
        <div class="fl jb ic">
            <div>
                <div class="fs11 tc2">Minggu ke-{{ $rppm->minggu_ke }} • {{ $rppm->tahunAjaran->name }}</div>
                <h3 style="font-size:16px;font-weight:800;margin:4px 0">
                    {{ $rppm->subTema->tema->name }}
                </h3>
                <div style="color:var(--g6);font-weight:600">{{ $rppm->subTema->name }}</div>
            </div>
            <div class="fl ic g8">
                <span class="bdg {{ $rppm->status_badge_class }}">{{ $rppm->status_label }}</span>
                @if(in_array($rppm->status, ['disetujui']))
                    <a href="{{ route('rppm.cetak_pdf', $rppm->id) }}" target="_blank" class="btn bp bsm">🖨️ Cetak PDF</a>
                @endif
                <a href="{{ route('rppm') }}" class="btn bo bsm">← Kembali</a>
            </div>
        </div>

        @if ($rppm->status === 'dikembalikan' && $rppm->catatan_kepala)
            <div class="al ale mt12">
                📝 <strong>Catatan Kepala Sekolah:</strong> {{ $rppm->catatan_kepala }}
            </div>
        @endif
    </div>

    <div class="g2" style="gap:14px">

        {{-- Kolom Kiri: Kegiatan Per Hari --}}
        <div style="grid-column: span 1">

            {{-- Day Tabs --}}
            <div class="dt mb4">
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                    @php
                        $count = collect($rppm->kegiatanPerHari()[$hari] ?? [])->count();
                    @endphp
                    <div class="dtb {{ $loop->first ? 'on' : '' }} {{ $count > 0 ? 'fl' : '' }}"
                        data-hari="{{ $hari }}">
                        {{ $hari }}
                        @if ($count > 0)
                            <span
                                style="background:var(--g6);color:white;border-radius:10px;
                                     font-size:10px;padding:1px 5px;margin-left:3px">
                                {{ $count }}
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Panel per hari --}}
            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                @php $kegiatanHari = $rppm->kegiatanPerHari()[$hari]; @endphp
                <div class="ds hari-panel" id="panel-{{ $hari }}"
                    style="{{ $loop->first ? '' : 'display:none' }}">

                    <div class="dsh">
                        <span class="dn">📅 {{ $hari }}</span>
                        @if (in_array($rppm->status, ['draft', 'dikembalikan']))
                            <button type="button" class="btn bp bxs btn-buka-pilih-kegiatan"
                                data-hari="{{ $hari }}">
                                + Pilih Kegiatan
                            </button>
                        @endif
                    </div>

                    @if ($kegiatanHari->isEmpty())
                        <div style="text-align:center;padding:20px;color:var(--txt3);font-size:12px">
                            📭 Belum ada kegiatan untuk hari ini
                        </div>
                    @else
                        <div id="list-kegiatan-{{ $hari }}">
                            @foreach ($kegiatanHari as $rk)
                                <div class="dki" id="rk-{{ $rk->id }}">
                                    <div>
                                        <div style="font-weight:700;font-size:12.5px">
                                            {{ $rk->kegiatan->foto_icon }}
                                            {{ $rk->kegiatan->name }}
                                        </div>
                                        <div class="fs11 tc2 mt4">
                                            🎭 {{ $rk->kegiatan->bentukKegiatan->name }}
                                        </div>
                                        <div class="fl fw g8 mt4">
                                            @foreach ($rk->kegiatan->aspeks as $aspek)
                                                <span class="ap {{ $aspek->warna }}">
                                                    {{ $aspek->emote }} {{ $aspek->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if (in_array($rppm->status, ['draft', 'dikembalikan']))
                                        <button type="button" class="btn bd bxs btn-hapus-rk"
                                            data-id="{{ $rk->id }}">✕</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

        </div>

        {{-- Kolom Kanan: Analisis Aspek Real-time --}}
        <div>
            <div class="card" style="position:sticky;top:80px">
                <div class="ct mb16">📊 Analisis Aspek</div>

                @php
                    $aspekTerstimulasi = $rppm->aspekTerstimulasi();
                    $aspekBelum = $rppm->aspekBelumTerstimulasi();
                @endphp

                @foreach ($aspeks as $aspek)
                    @php
                        $count = $aspekTerstimulasi->where('id', $aspek->id)->count();
                        $ada = $count > 0;
                    @endphp
                    <div class="card mb8"
                        style="padding:10px 13px;
                    border-color:{{ $ada ? 'var(--g2)' : '#fecaca' }}">
                        <div class="fl jb ic mb6">
                            <span class="ap {{ $aspek->warna }}">
                                {{ $aspek->emote }} {{ $aspek->name }}
                            </span>
                            @if ($ada)
                                <span style="font-size:18px;font-weight:800;color:var(--g6)">
                                    ✅
                                </span>
                            @else
                                <span style="font-size:12px;color:var(--red);font-weight:700">
                                    ⚠️ Belum
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach

                @if ($aspekBelum->isNotEmpty())
                    <div class="al alw mt8">
                        ⚠️ {{ $aspekBelum->count() }} aspek belum terstimulasi.
                        Tambahkan kegiatan yang mencakup aspek tersebut.
                    </div>
                @endif

                @if (in_array($rppm->status, ['draft', 'dikembalikan']))
                    <div class="dv"></div>
                    <button type="button" class="btn ba wf btn-ajukan-dari-show" data-id="{{ $rppm->id }}">
                        📤 Ajukan ke Kepala Sekolah
                    </button>
                @endif
            </div>
        </div>

    </div>

    {{-- Modal: Pilih Kegiatan --}}
    <div class="mo" id="mPilihKegiatan">
        <div class="md mlg">
            <div class="mh">
                <div>
                    <div class="mt2">🗂️ Pilih Kegiatan</div>
                    <div class="mst" id="labelHariPilih"></div>
                </div>
                <button type="button" class="mc">✕</button>
            </div>
            <div class="mb">
                {{-- Filter cepat --}}
                <div class="fl fw g8 mb12 fb">
                    <input type="text" id="filterNamaKegiatan" placeholder="🔍 Cari kegiatan..."
                        style="min-width:180px" />
                    <select id="filterAspekKegiatan">
                        <option value="">Semua Aspek</option>
                        @foreach ($aspeks as $aspek)
                            <option value="{{ $aspek->id }}">
                                {{ $aspek->emote }} {{ $aspek->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- List kegiatan tersedia --}}
                <div id="listKegiatanPilih" style="max-height:380px;overflow-y:auto">
                    @forelse ($kegiatanTersedia as $kegiatan)
                        <div class="kc kegiatan-item mb8" data-id="{{ $kegiatan->id }}"
                            data-nama="{{ strtolower($kegiatan->name) }}"
                            data-aspek="{{ $kegiatan->aspeks->pluck('id')->join(',') }}">

                            <div class="fl jb ic mb6">
                                <div class="fl ic g8">
                                    <span style="font-size:20px">{{ $kegiatan->foto_icon }}</span>
                                    <div class="kn">{{ $kegiatan->name }}</div>
                                </div>
                                <button type="button" class="btn bp bxs btn-pilih-kegiatan" data-id="{{ $kegiatan->id }}">
                                    + Pilih
                                </button>
                            </div>

                            <div class="fs11 tc2 mb6">
                                🎭 {{ $kegiatan->bentukKegiatan->name }}
                            </div>

                            <div class="fl fw g8">
                                @foreach ($kegiatan->aspeks as $aspek)
                                    <span class="ap {{ $aspek->warna }}">
                                        {{ $aspek->emote }} {{ $aspek->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="emp">
                            <div class="ei">🗂️</div>
                            <h3>Belum ada kegiatan tersedia</h3>
                            <p>Usulkan kegiatan baru di menu Kumpulan Kegiatan.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        var rppmId = {{ $rppm->id }};
        var hariAktif = 'Senin';

        $(document).on('click', '.dt .dtb', function() {
            $('.dt .dtb').removeClass('on');
            $(this).addClass('on');
            hariAktif = $(this).data('hari');
            $('.hari-panel').hide();
            $('#panel-' + hariAktif).show();
        });

        $(document).on('click', '.btn-buka-pilih-kegiatan', function() {
            hariAktif = $(this).data('hari');
            $('#labelHariPilih').text('Menambahkan ke hari: ' + hariAktif);
            $('#filterNamaKegiatan').val('');
            $('#filterAspekKegiatan').val('');
            $('.kegiatan-item').show(); // reset filter
            $('#mPilihKegiatan').addClass('on');
        });

        $('#filterNamaKegiatan').on('input', function() {
            var keyword = $(this).val().toLowerCase();
            filterKegiatanModal();
        });

        $('#filterAspekKegiatan').on('change', function() {
            filterKegiatanModal();
        });

        function filterKegiatanModal() {
            var keyword = $('#filterNamaKegiatan').val().toLowerCase();
            var aspekId = $('#filterAspekKegiatan').val();

            $('.kegiatan-item').each(function() {
                var nama = $(this).data('nama');
                var aspeks = String($(this).data('aspek'));

                var namaOk = !keyword || nama.includes(keyword);
                var aspekOk = !aspekId || aspeks.split(',').includes(aspekId);

                $(this).toggle(namaOk && aspekOk);
            });
        }

        $(document).on('click', '.btn-pilih-kegiatan', function() {
            var kegiatanId = $(this).data('id');

            $.post('/rppm/' + rppmId + '/kegiatan', {
                    kegiatan_id: kegiatanId,
                    hari: hariAktif,
                    _token: '{{ csrf_token() }}',
                })
                .done(function() {
                    $('#mPilihKegiatan').removeClass('on');
                    showToast('✅ Kegiatan ditambahkan ke hari ' + hariAktif);
                    setTimeout(function() {
                        location.reload();
                    }, 600);
                })
                .fail(function(xhr) {
                    showToast('❌ ' + xhr.responseJSON.message);
                });
        });

        $(document).on('click', '.btn-hapus-rk', function() {
            var id = $(this).data('id');
            var $el = $('#rk-' + id);

            if (!confirm('Hapus kegiatan ini dari RPPM?')) return;

            $.ajax({
                    url: '/rppm/kegiatan/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                })
                .done(function() {
                    $el.fadeOut(300, function() {
                        $(this).remove();
                    });
                    showToast('🗑️ Kegiatan dihapus');
                    setTimeout(function() {
                        location.reload();
                    }, 800);
                });
        });

        $(document).on('click', '.btn-ajukan-dari-show', function() {
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
                        window.location.href = '{{ route('rppm') }}';
                    }, 800);
                })
                .fail(function(xhr) {
                    showToast('❌ ' + xhr.responseJSON.message);
                });
        });
    </script>
@endpush
