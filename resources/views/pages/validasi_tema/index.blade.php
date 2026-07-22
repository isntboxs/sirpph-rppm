@extends('layout.app')

@section('page-title', 'Validasi Tema & Subtema')
@section('page-subtitle', 'Tahun Akademik : ' . ($taAktif?->name ?? '-') . ' - ' . ucfirst($taAktif?->semester ?? '-'))

@section('content')

    <div class="card mb16" style="border-radius: 0;">
        <div class="ch" style="border-bottom: 2px solid var(--g2); padding: 15px 20px;">
            <div class="ct" style="font-weight: 700; font-size: 14px;">Daftar Pengajuan Tema Utama</div>
        </div>
        
        <div class="tw">
            <table style="border-collapse: collapse; width: 100%;">
                <thead style="background: var(--white); border-bottom: 1px solid var(--g2);">
                    <tr>
                        <th style="padding: 15px; text-align: left; font-size:11px; text-transform:uppercase; color:var(--txt2); width: 5%;"></th>
                        <th style="padding: 15px; text-align: left; font-size:11px; text-transform:uppercase; color:var(--txt2); width: 45%;">Tema Utama</th>
                        <th style="padding: 15px; text-align: center; font-size:11px; text-transform:uppercase; color:var(--txt2); width: 20%;">Submitter</th>
                        <th style="padding: 15px; text-align: center; font-size:11px; text-transform:uppercase; color:var(--txt2); width: 30%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($temaPending as $tema)
                        <!-- TEMA UTAMA ROW -->
                        <tr id="tema-row-{{ $tema->id }}" style="border-bottom: 1px solid var(--g1); cursor:pointer;" onclick="toggleSubTema({{ $tema->id }}, this)">
                            <td style="padding: 20px 15px; text-align: center;">
                                <span class="arrow-icon" style="display:inline-block; transition:0.3s;">▶</span>
                            </td>
                            <td style="padding: 20px 15px;">
                                <div style="font-size: 16px; font-weight: 700; color: var(--txt);">{{ $tema->name }}</div>
                                @if($tema->alasan_edit && $tema->status === 'pending')
                                    <div style="font-size: 12px; color: #d97706; font-style: italic; margin-top: 5px;">Alasan Pengajuan Edit: {{ $tema->alasan_edit }}</div>
                                @endif
                                <div style="margin-top:5px; display:flex; gap:5px; flex-wrap:wrap;">
                                    @foreach($tema->subTemas as $st)
                                        <span style="font-size:10px; padding:2px 6px; border-radius:4px; background:var(--g1); border:1px solid var(--g2);">{{ $st->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <div style="display:flex; flex-direction:column; align-items:center; gap:5px;">
                                    <div style="display:flex; align-items:center; gap:5px;">
                                        <span>👤</span>
                                        <span style="font-weight: 600; font-size: 13px;">{{ $tema->user->name ?? 'Admin' }}</span>
                                    </div>
                                    <div style="font-size: 11px; color: var(--txt2);">{{ $tema->created_at->translatedFormat('d F Y, H:i') }}</div>
                                </div>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 5px; justify-content: center;">
                                    @if($tema->status === 'pending')
                                        <button type="button" class="btn-setujui-tema" data-id="{{ $tema->id }}" style="background:#000; color:#fff; border:none; padding:8px 16px; font-size:12px; font-weight:600; cursor:pointer;">✔ Setujui</button>
                                        <button type="button" class="btn-kembalikan-tema" data-id="{{ $tema->id }}" style="background:#fff; color:var(--txt); border:1px solid var(--g3); padding:8px 16px; font-size:12px; font-weight:600; cursor:pointer;">✖ Kembalikan</button>
                                    @elseif($tema->status === 'disetujui')
                                        <span style="color:var(--txt2); font-weight:600; font-size:12px;">Tervalidasi</span>
                                    @elseif($tema->status === 'dikembalikan')
                                        <span style="color:#ef4444; font-weight:600; font-size:12px;">Dikembalikan</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <!-- SUB TEMA ROW (HIDDEN BY DEFAULT) -->
                        <tr id="subtema-tr-{{ $tema->id }}" class="subtema-row-hidden" style="background: var(--g0);">
                            <td colspan="4" style="padding: 0;">
                                <div id="subtema-div-{{ $tema->id }}" style="display:none;">
                                    <table style="width: 100%; border-collapse: collapse; margin:0;">
                                        <tbody>
                                        @foreach($tema->subTemas as $subTema)
                                        <tr style="border-bottom: 1px dashed var(--g2);">
                                            <td style="padding: 10px 15px 10px 50px; width:50%;">
                                                <div style="font-weight:600; font-size:13px; color:var(--txt);">↳ {{ $subTema->name }}</div>
                                                @if($subTema->alasan_edit && $subTema->status === 'pending')
                                                    <div style="font-size: 11px; color: #d97706; font-style: italic; margin-top: 3px; margin-left: 15px;">Alasan Pengajuan Edit: {{ $subTema->alasan_edit }}</div>
                                                @endif
                                            </td>
                                            <td style="padding: 10px 15px; text-align:center; width:20%;">
                                                <div style="font-size:11px; color:var(--txt2);">👤 {{ $subTema->user->name ?? 'Admin' }}</div>
                                            </td>
                                            <td style="padding: 10px 15px; text-align:center; width:30%;">
                                                <div style="display: flex; gap: 5px; justify-content: center;">
                                                    @if($subTema->status === 'pending')
                                                        @if($tema->status !== 'disetujui')
                                                            <span style="font-size:11px; color:var(--txt2); font-style:italic;">Validasi Tema Utama dahulu</span>
                                                        @else
                                                            <button type="button" class="btn-setujui-subtema" data-id="{{ $subTema->id }}" style="background:#000; color:#fff; border:none; padding:6px 12px; font-size:11px; font-weight:600; cursor:pointer;">✔ Setujui</button>
                                                            <button type="button" class="btn-kembalikan-subtema" data-id="{{ $subTema->id }}" style="background:#fff; color:var(--txt); border:1px solid var(--g3); padding:6px 12px; font-size:11px; font-weight:600; cursor:pointer;">✖ Kembalikan</button>
                                                        @endif
                                                    @elseif($subTema->status === 'disetujui')
                                                        <span style="color:var(--txt2); font-weight:600; font-size:12px;">Tervalidasi</span>
                                                    @elseif($subTema->status === 'dikembalikan')
                                                        <span style="color:#ef4444; font-weight:600; font-size:12px;">Dikembalikan</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @if($tema->subTemas->isEmpty())
                                        <tr>
                                            <td colspan="3" style="padding: 15px 50px; font-size:12px; color:var(--txt3);">Tidak ada sub-tema.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 30px;">Belum ada pengajuan Tema.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if ($temaPending->hasPages())
            <div style="padding: 15px; border-top: 1px solid var(--g2); text-align: center;">
                {{ $temaPending->links() }}
            </div>
        @endif
    </div>

    <div class="card mb16" style="border-radius: 0;">
        <div class="ch" style="border-bottom: 2px solid var(--g2); padding: 15px 20px;">
            <div class="ct" style="font-weight: 700; font-size: 14px;">Riwayat Validasi Tema & Subtema (Disetujui)</div>
        </div>
        
        <div class="tw">
            <table style="border-collapse: collapse; width: 100%;">
                <thead style="background: var(--white); border-bottom: 1px solid var(--g2);">
                    <tr>
                        <th style="padding: 15px; text-align: left; font-size:11px; text-transform:uppercase; color:var(--txt2); width: 5%;"></th>
                        <th style="padding: 15px; text-align: left; font-size:11px; text-transform:uppercase; color:var(--txt2); width: 45%;">Tema Utama</th>
                        <th style="padding: 15px; text-align: center; font-size:11px; text-transform:uppercase; color:var(--txt2); width: 20%;">Submitter</th>
                        <th style="padding: 15px; text-align: center; font-size:11px; text-transform:uppercase; color:var(--txt2); width: 30%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($temaHistory as $tema)
                        <tr id="tema-history-row-{{ $tema->id }}" style="border-bottom: 1px solid var(--g1); cursor:pointer;" onclick="toggleSubTema('history_{{ $tema->id }}', this)">
                            <td style="padding: 20px 15px; text-align: center;">
                                <span class="arrow-icon" style="display:inline-block; transition:0.3s;">▶</span>
                            </td>
                            <td style="padding: 20px 15px;">
                                <div style="font-size: 16px; font-weight: 700; color: var(--txt);">{{ $tema->name }}</div>
                                <div style="margin-top:5px; display:flex; gap:5px; flex-wrap:wrap;">
                                    @foreach($tema->subTemas as $st)
                                        @if($st->status === 'disetujui')
                                            <span style="font-size:10px; padding:2px 6px; border-radius:4px; background:var(--g1); border:1px solid var(--g2);">{{ $st->name }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <div style="display:flex; flex-direction:column; align-items:center; gap:5px;">
                                    <div style="display:flex; align-items:center; gap:5px;">
                                        <span>👤</span>
                                        <span style="font-weight: 600; font-size: 13px;">{{ $tema->user->name ?? 'Admin' }}</span>
                                    </div>
                                    <div style="font-size: 11px; color: var(--txt2);">{{ $tema->created_at->translatedFormat('d F Y, H:i') }}</div>
                                </div>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                @if($tema->status === 'disetujui')
                                    <span style="color:var(--txt2); font-weight:600; font-size:12px;">Tervalidasi</span>
                                @else
                                    <span style="color:var(--txt2); font-weight:600; font-size:12px; font-style:italic;">Draft (Ada Subtema Tervalidasi)</span>
                                @endif
                            </td>
                        </tr>
                        <tr id="subtema-tr-history_{{ $tema->id }}" class="subtema-row-hidden" style="background: var(--g0);">
                            <td colspan="4" style="padding: 0;">
                                <div id="subtema-div-history_{{ $tema->id }}" style="display:none;">
                                    <table style="width: 100%; border-collapse: collapse; margin:0;">
                                        <tbody>
                                        @php
                                            $approvedSubTemas = $tema->subTemas->where('status', 'disetujui');
                                        @endphp
                                        @forelse($approvedSubTemas as $subTema)
                                        <tr style="border-bottom: 1px dashed var(--g2);">
                                            <td style="padding: 10px 15px 10px 50px; width:50%;">
                                                <div style="font-weight:600; font-size:13px; color:var(--txt);">↳ {{ $subTema->name }}</div>
                                            </td>
                                            <td style="padding: 10px 15px; text-align:center; width:20%;">
                                                <div style="font-size:11px; color:var(--txt2);">👤 {{ $subTema->user->name ?? 'Admin' }}</div>
                                            </td>
                                            <td style="padding: 10px 15px; text-align:center; width:30%;">
                                                <span style="color:var(--txt2); font-weight:600; font-size:12px;">Tervalidasi</span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" style="padding: 15px 50px; font-size:12px; color:var(--txt3);">Tidak ada sub-tema yang tervalidasi.</td>
                                        </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 30px;">Belum ada Riwayat Validasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if ($temaHistory->hasPages())
            <div style="padding: 15px; border-top: 1px solid var(--g2); text-align: center;">
                {{ $temaHistory->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Kembalikan Tema/SubTema --}}
    <div class="mo" id="mKembalikanData">
        <div class="md msm">
            <input type="hidden" id="kembalikanId">
            <input type="hidden" id="kembalikanType">
            <div class="mh">
                <div>
                    <div class="mt2" id="modalTitle">Kembalikan Data</div>
                </div>
                <button type="button" class="mc" onclick="$('#mKembalikanData').removeClass('on')">✕</button>
            </div>
            <div class="mb">
                <div class="ff">
                    <label>Catatan Revisi / Alasan Pengembalian</label>
                    <textarea id="catatanKembalikanData" rows="4" placeholder="Masukkan alasan kenapa data ini dikembalikan..."></textarea>
                    <button type="button" id="btn-submit-kembalikan" class="btn bo" style="background:#000; color:#fff; border:none; width: 100%; margin-top: 10px;">Kirim Catatan & Kembalikan</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<style>
    .rotate {
        transform: rotate(90deg);
    }
    .subtema-row-hidden {
        display: none !important;
    }
</style>
<script>
    $(function() {
        window.toggleSubTema = function(id, rowElement) {
            var $subtr = $('#subtema-tr-' + id);
            var $subdiv = $('#subtema-div-' + id);
            var $icon = $(rowElement).find('.arrow-icon');
            
            if ($subtr.hasClass('subtema-row-hidden')) {
                $subtr.removeClass('subtema-row-hidden');
                $subdiv.slideDown(200);
                $icon.css('transform', 'rotate(90deg)');
            } else {
                $subdiv.slideUp(200, function() {
                    $subtr.addClass('subtema-row-hidden');
                });
                $icon.css('transform', 'rotate(0deg)');
            }
        }

        $(document).ready(function() {
            var highlightId = '{{ request("highlight_tema") }}';
            if (highlightId) {
                var targetRow = $('#tema-row-' + highlightId);
                if (targetRow.length) {
                    // Scroll to row
                    $('html, body').animate({
                        scrollTop: targetRow.offset().top - 100
                    }, 500);
                    // Add highlight animation class
                    targetRow.css('background-color', '#fff9c4');
                    setTimeout(function() {
                        targetRow.css('transition', 'background-color 1.5s');
                        targetRow.css('background-color', 'transparent');
                    }, 2000);
                    // Toggle the row
                    targetRow.click();
                }
            }
        });

        var $targetContainer = null;

        // TEMA
        $('.btn-setujui-tema').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var btn = $(this);
            var id = btn.data('id');
            window.confirmAction('Setujui Tema ini?', function() {
                $.ajax({
                    url: '/validasi-tema/tema/' + id + '/setujui',
                    type: 'PUT',
                    data: { _token: '{{ csrf_token() }}' }
                }).done(function(res) {
                    showToast(res.message);
                    btn.parent().html('<span style="color:var(--txt2); font-weight:600;">Tervalidasi</span>');
                    setTimeout(() => location.reload(), 1000); // Reload so the subtema buttons can appear!
                }).fail(function() {
                    showToast('❌ Gagal');
                });
            });
        });

        $('.btn-kembalikan-tema').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#kembalikanId').val($(this).data('id'));
            $('#kembalikanType').val('tema');
            $targetContainer = $(this).parent();
            $('#modalTitle').text('Kembalikan Tema');
            $('#catatanKembalikanData').val('');
            $('#mKembalikanData').addClass('on');
        });

        // SUBTEMA
        $('.btn-setujui-subtema').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var btn = $(this);
            var id = btn.data('id');
            window.confirmAction('Setujui Sub Tema ini?', function() {
                $.ajax({
                    url: '/validasi-tema/sub-tema/' + id + '/setujui',
                    type: 'PUT',
                    data: { _token: '{{ csrf_token() }}' }
                }).done(function(res) {
                    showToast(res.message);
                    btn.parent().html('<span style="color:var(--txt2); font-weight:600; font-size:12px;">Tervalidasi</span>');
                }).fail(function() {
                    showToast('❌ Gagal');
                });
            });
        });

        $('.btn-kembalikan-subtema').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#kembalikanId').val($(this).data('id'));
            $('#kembalikanType').val('subtema');
            $targetContainer = $(this).parent();
            $('#modalTitle').text('Kembalikan Sub Tema');
            $('#catatanKembalikanData').val('');
            $('#mKembalikanData').addClass('on');
        });

        // SUBMIT KEMBALIKAN
        $('#btn-submit-kembalikan').on('click', function() {
            var id = $('#kembalikanId').val();
            var type = $('#kembalikanType').val();
            var catatan = $('#catatanKembalikanData').val();
            
            if (!catatan) {
                Swal.fire('Peringatan', 'Catatan revisi wajib diisi!', 'warning');
                return;
            }

            var url = type === 'tema' 
                ? '/validasi-tema/tema/' + id + '/kembalikan'
                : '/validasi-tema/sub-tema/' + id + '/kembalikan';

            var $btn = $(this);
            $btn.text('...').prop('disabled', true);

            $.ajax({
                url: url,
                type: 'PUT',
                data: { 
                    _token: '{{ csrf_token() }}',
                    catatan: catatan
                }
            }).done(function(res) {
                $('#mKembalikanData').removeClass('on');
                showToast(res.message);
                if ($targetContainer) {
                    $targetContainer.html('<span style="color:#ef4444; font-weight:600; font-size:12px;">Dikembalikan</span>');
                }
                $btn.text('Kirim Catatan & Kembalikan').prop('disabled', false);
            }).fail(function(xhr) {
                showToast('❌ Gagal mengembalikan data');
                $btn.text('Kirim Catatan & Kembalikan').prop('disabled', false);
            });
        });
    });
</script>
@endpush
