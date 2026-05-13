@extends('layout.app')

@section('page-title', 'Detail RPPM')
@section('page-subtitle', $rppm->subTema->tema->name . ' - ' . $rppm->subTema->name)

@section('content')
    <div class="card mb16">
        <div class="fl jb ic">
            <div>
                <div class="fs11 tc2">
                    Minggi Ke-{{ $rppm->minggu_ke }} •
                    {{ $rppm->guru->name }} •
                    {{ $rppm->tahunAjaran->name }} Semester {{ $rppm->tahunAjaran->semester }}
                </div>
                <h3 style="font-size:17px;font-weight:800;margin:4px 0">
                    {{ $rppm->subTema->tema->name }}
                </h3>
                <div style="color:var(--g6);font-weight:600">{{ $rppm->subTema->name }}</div>
                @if ($rppm->model_pembelajaran)
                    <div class="fs11 tc2 mt4" style="margin-bottom: 10px">
                        📐 Model: {{ $rppm->model_pembelajaran }}
                    </div>
                @endif
            </div>
            <div class="fl ic g8">
                <span class="bdg {{ $rppm->status_badge_class }}">
                    {{ $rppm->status_label }}
                </span>
                <a href="{{ route('validasi_rppm') }}" class="btn bo bsm">← Kembali</a>
            </div>
        </div>

        @if ($rppm->tujuan || $rppm->capaian)
            <div class="g2 mt12" style="gap:10px">
                @if ($rppm->tujuan)
                    <div class="ib">
                        <div class="ik">Tujuan Pembelajaran</div>
                        <div class="iv" style="font-size:12px;font-weight:400;line-height:1.5">
                            <spans style="white-space:pre-line"></span>{{ $rppm->tujuan }}
                        </div>
                    </div>
                @endif
                @if ($rppm->capaian)
                    <div class="ib">
                        <div class="ik">Capaian Pembelajaran</div>
                        <div class="iv" style="font-size:12px;font-weight:400;line-height:1.5">
                            <spans style="white-space:pre-line"></span>{{ $rppm->capaian }}
                        </div>
                    </div>
                @endif
                @if ($rppm->guru->kelas)
                    <div class="ib">
                        <div class="ik">Kelas</div>
                        <div class="iv" style="font-size:12px;font-weight:400;line-height:1.5">
                            {{ $rppm->guru->kelas->name }}
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <div class="g2" style="gap:14px">
        <div>
            <div class="card">
                <div class="ct mb12">📅 Kegiatan Per Hari</div>
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                    @php
                        $kegiatanHari = $rppm->rppmKegiatans->where('hari', $hari);
                    @endphp
                    <div class="ds mb8">
                        <div class="dsh">
                            <span class="dn">{{ $hari }}</span>
                            <span class="fs11 tc2">
                                {{ $kegiatanHari->count() }} kegiatan
                            </span>
                        </div>
                        @forelse ($kegiatanHari as $rk)
                            <div class="dki">
                                <div>
                                    <div style="font-weight:700;font-size:12.5px">
                                        {{ $rk->kegiatan->foto_icon }}
                                        {{ $rk->kegiatan->name }}
                                    </div>
                                    <div class="fs11 tc2 mt4">
                                        🎭 {{ $rk->kegiatan->bentukKegiatan->name }}
                                        @if ($rk->kegiatan->alatBahans->isNotEmpty())
                                            &nbsp;|&nbsp;
                                            🔧 {{ $rk->kegiatan->alatBahans->pluck('name')->join(', ') }}
                                        @endif
                                    </div>
                                    <div class="fl fw g8 mt4">
                                        @foreach ($rk->kegiatan->aspeks as $aspek)
                                            <span class="ap {{ $aspek->warna }}">
                                                {{ $aspek->emote }} {{ $aspek->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div style="font-size:12px;color:var(--txt3);padding:8px 0">
                                Tidak ada kegiatan
                            </div>
                        @endforelse
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <div class="card" style="position:sticky;top:80px">
                <div class="ct mb12">📊 Analisis Aspek</div>

                @foreach ($aspekTerstimulasi as $aspek)
                    <div class="card mb8"
                        style="padding:10px 13px;
                    border-color:{{ $aspek->dipakai > 0 ? 'var(--g2)' : '#fecaca' }}">
                        <div class="fl jb ic">
                            <span class="ap {{ $aspek->warna }}">
                                {{ $aspek->emote }} {{ $aspek->name }}
                            </span>
                            @if ($aspek->dipakai > 0)
                                <span style="color:var(--g6);font-weight:700;font-size:12px">
                                    ✅ Ada
                                </span>
                            @else
                                <span style="color:var(--red);font-weight:700;font-size:12px">
                                    ⚠️ Belum
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach

                @php $belumCount = $aspekTerstimulasi->where('dipakai', 0)->count(); @endphp
                @if ($belumCount > 0)
                    <div class="al alw mt8" style="font-size:11.5px">
                        ⚠️ {{ $belumCount }} aspek belum terstimulasi.
                        Pertimbangkan untuk dikembalikan agar guru menambah kegiatan.
                    </div>
                @endif

                {{-- Tombol aksi --}}
                @if ($rppm->status === 'pending')
                    <div class="dv"></div>
                    <button type="button" class="btn bp wf mb8 btn-setujui-rppm-show" data-id="{{ $rppm->id }}">
                        ✅ Setujui RPPM
                    </button>
                    <button type="button" class="btn bd wf btn-buka-kembalikan-show" data-id="{{ $rppm->id }}"
                        data-info="Mgg {{ $rppm->minggu_ke }} - {{ $rppm->subTema->name }}">
                        ↩️ Kembalikan ke Guru
                    </button>
                @endif
            </div>
        </div>

    </div>

    {{-- Modal Kembalikan --}}
    <div class="mo" id="mKembalikanShow">
        <div class="md mmd">
            <form id="formKembalikanShow">
                <input type="hidden" id="inputKembalikanShowId" />
                <div class="mh">
                    <div>
                        <div class="mt2">↩️ Kembalikan RPPM</div>
                        <div class="mst" id="labelInfoKembalikanShow" style="color:var(--txt3)"></div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">
                    <div class="al alw mb12">
                        ⚠️ Guru harus memperbaiki RPPM sebelum bisa mengajukan kembali.
                    </div>
                    <div class="ff">
                        <label>Catatan untuk Guru</label>
                        <textarea id="inputCatatanShow" rows="4" placeholder="Jelaskan apa yang perlu diperbaiki..."></textarea>
                    </div>
                    <div id="errorKembalikanShow" class="al ale mt8" style="display:none"></div>
                </div>
                <div class="mf">
                    <button type="button" class="btn bo">Batal</button>
                    <button type="submit" class="btn bd btn-submit-form">↩️ Kembalikan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $('.btn-setujui-rppm-show').on('click', function() {
            var id = $(this).data('id');
            if (!confirm('Setujui RPPM ini?')) return;

            $.ajax({
                    url: '/validasi-rppm/' + id + '/setujui',
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                })
                .done(function(res) {
                    showToast(res.message);
                    setTimeout(function() {
                        window.location.href = '{{ route('validasi_rppm') }}';
                    }, 800);
                })
                .fail(function(xhr) {
                    showToast('❌ ' + xhr.responseJSON.message);
                });
        });

        $('.btn-buka-kembalikan-show').on('click', function() {
            $('#inputKembalikanShowId').val($(this).data('id'));
            $('#labelInfoKembalikanShow').text($(this).data('info'));
            $('#mKembalikanShow').addClass('on');
        });

        $('#mKembalikanShow').on('click', '.mc, .btn.bo', function() {
            $('#formKembalikanShow')[0].reset();
            $('#errorKembalikanShow').hide();
        });

        $('#formKembalikanShow').on('submit', function(e) {
            e.preventDefault();

            var id = $('#inputKembalikanShowId').val();

            $.ajax({
                    url: '/validasi-rppm/' + id + '/kembalikan',
                    type: 'PUT',
                    data: {
                        catatan: $('#inputCatatanShow').val(),
                        _token: '{{ csrf_token() }}',
                    },
                })
                .done(function(res) {
                    showToast(res.message);
                    setTimeout(function() {
                        window.location.href = '{{ route('validasi_rppm') }}';
                    }, 800);
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('#errorKembalikanShow').text(errors.catatan[0]).show();
                });
        });
    </script>
@endpush
