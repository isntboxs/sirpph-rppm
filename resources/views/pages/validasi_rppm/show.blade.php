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
                <div class="ct mb16">📝 Isi Kegiatan Pembelajaran</div>
                
                <div class="g2 mt12" style="gap:20px; grid-template-columns: 1fr;">
                    <div class="ib">
                        <div class="ik" style="font-weight:bold; color:var(--g6); font-size:14px; margin-bottom: 6px;">A. Kegiatan Pembuka (SOP Pembukaan, Doa)</div>
                        <div class="iv" style="font-size:13px; font-weight:400; line-height:1.6; background: #f9fafb; padding: 15px; border-radius: 6px; border: 1px solid #e5e7eb; white-space: pre-line;">
                            {{ $rppm->kegiatan_pembuka ?? '-' }}
                        </div>
                    </div>
                    
                    <div class="ib">
                        <div class="ik" style="font-weight:bold; color:var(--g6); font-size:14px; margin-bottom: 6px;">B. Kegiatan Inti</div>
                        <div class="iv" style="font-size:13px; font-weight:400; line-height:1.6; background: #f9fafb; padding: 15px; border-radius: 6px; border: 1px solid #e5e7eb; white-space: pre-line;">
                            {{ $rppm->kegiatan_inti ?? '-' }}
                        </div>
                    </div>
                    
                    <div class="ib">
                        <div class="ik" style="font-weight:bold; color:var(--g6); font-size:14px; margin-bottom: 6px;">C. Recalling</div>
                        <div class="iv" style="font-size:13px; font-weight:400; line-height:1.6; background: #f9fafb; padding: 15px; border-radius: 6px; border: 1px solid #e5e7eb; white-space: pre-line;">
                            {{ $rppm->recalling ?? '-' }}
                        </div>
                    </div>
                    
                    <div class="ib">
                        <div class="ik" style="font-weight:bold; color:var(--g6); font-size:14px; margin-bottom: 6px;">D. Kegiatan Penutup</div>
                        <div class="iv" style="font-size:13px; font-weight:400; line-height:1.6; background: #f9fafb; padding: 15px; border-radius: 6px; border: 1px solid #e5e7eb; white-space: pre-line;">
                            {{ $rppm->kegiatan_penutup ?? '-' }}
                        </div>
                    </div>
                    
                    <div class="ib">
                        <div class="ik" style="font-weight:bold; color:var(--g6); font-size:14px; margin-bottom: 6px;">E. Rencana Penilaian</div>
                        <div class="iv" style="font-size:13px; font-weight:400; line-height:1.6; background: #f9fafb; padding: 15px; border-radius: 6px; border: 1px solid #e5e7eb; white-space: pre-line;">
                            {{ $rppm->rencana_penilaian ?? '-' }}
                        </div>
                    </div>
                </div>

                @if ($rppm->status === 'pending')
                    <div class="dv mt16"></div>
                    <div class="fl jb ic mt16">
                        <button type="button" class="btn bo btn-buka-kembalikan-show"
                            data-id="{{ $rppm->id }}"
                            data-info="RPPM {{ $rppm->subTema->tema->name }} - {{ $rppm->subTema->name }}">
                            ↩️ Kembalikan (Revisi)
                        </button>
                        <button type="button" class="btn bd btn-setujui-rppm-show" data-id="{{ $rppm->id }}">
                            ✅ Setujui RPPM
                        </button>
                    </div>
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
