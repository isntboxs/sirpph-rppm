@extends('layout.app')

@section('page-title', 'Validasi RPP')
@section('page-subtitle', 'Tinjau dan setujui RPP yang diajukan guru')

@section('content')

    <div class="card" style="margin-bottom: 20px;">
        <div class="cb" style="padding: 20px; background-color: var(--g0);">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <h3 style="margin:0; font-size:14px; text-transform:uppercase; font-weight:700;">Daftar RPP Menunggu</h3>
                </div>
            </div>
        </div>
        
        <div class="tw">
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">Guru</th>
                        <th>Tema / Sub Tema</th>
                        <th style="text-align: center;">Kelas</th>
                        <th style="text-align: center;">Diajukan</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rppmPending as $rppm)
                        <tr>
                            <td style="text-align: center;">
                                <div style="font-weight: 600;">{{ $rppm->guru->name }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $rppm->subTema->tema->name ?? '-' }}</div>
                                <div style="font-size: 12px; color: var(--txt2);">{{ $rppm->subTema->name ?? '-' }}</div>
                            </td>
                            <td style="text-align: center;">{{ $rppm->guru->kelas->name ?? '-' }}</td>
                            <td style="text-align: center;">
                                <div>{{ $rppm->updated_at->translatedFormat('d F Y') }}</div>
                                <div style="font-size:11px; color:var(--txt3);">{{ $rppm->updated_at->format('H:i') }}</div>
                            </td>
                            <td style="text-align: center;">
                                @if($rppm->status === 'pending')
                                    <span class="bdg bpnd">Menunggu</span>
                                @elseif($rppm->status === 'dikembalikan')
                                    <span class="bdg bdr">Dikembalikan</span>
                                @elseif($rppm->status === 'disetujui')
                                    <span class="bdg bok">Disetujui</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 5px; justify-content: center;">
                                    <a href="{{ route('rppm.show', $rppm->id) }}" class="btn bd bxs" style="background:#000; color:#fff; border:none;">Detail</a>
                                    
                                    @if($rppm->status === 'pending')
                                        <button type="button" class="btn bo bxs btn-setujui" data-id="{{ $rppm->id }}">Setujui</button>
                                        <button type="button" class="btn bo bxs btn-kembalikan" data-id="{{ $rppm->id }}">Kembalikan</button>
                                    @else
                                        <button type="button" class="btn bxs" style="background:#f3f4f6; color:#9ca3af; border:1px solid #d1d5db; cursor:not-allowed;" disabled>Setujui</button>
                                        <button type="button" class="btn bxs" style="background:#f3f4f6; color:#9ca3af; border:1px solid #d1d5db; cursor:not-allowed;" disabled>Kembalikan</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px;">Belum ada RPP yang diajukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if ($rppmPending->hasPages())
            <div style="padding: 15px;">
                {{ $rppmPending->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Kembalikan RPP --}}
    <div class="mo" id="mKembalikanRppm">
        <div class="md msm">
            <form id="formKembalikanRppm">
                <input type="hidden" id="kembalikanId">
                <div class="mh">
                    <div>
                        <div class="mt2">Kembalikan RPP</div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">
                    <div class="ff">
                        <label>Catatan Revisi</label>
                        <textarea id="catatanKembalikan" rows="4" placeholder="Masukkan alasan kenapa RPP ini dikembalikan..." required></textarea>
                    </div>
                </div>
                <div class="mf">
                    <button type="submit" class="btn bo btn-submit-form" style="background:#000; color:#fff; border:none;">Submit Catatan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).on('click', '.btn-setujui', function() {
        var id = $(this).data('id');
        var $btn = $(this);
        
        window.confirmAction('Apakah Anda yakin ingin menyetujui RPP ini?', function() {
            $btn.text('...').prop('disabled', true);

            $.ajax({
                url: '/validasi-rppm/' + id + '/setujui',
                type: 'PUT',
                data: { _token: '{{ csrf_token() }}' }
            }).done(function(res) {
                showToast(res.message);
                location.reload();
            }).fail(function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal menyetujui';
                showToast('❌ ' + msg);
                $btn.text('Setujui').prop('disabled', false);
            });
        });
    });

    $(document).on('click', '.btn-kembalikan', function() {
        var id = $(this).data('id');
        $('#kembalikanId').val(id);
        $('#catatanKembalikan').val('');
        $('#mKembalikanRppm').addClass('on');
    });

    $('#formKembalikanRppm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#kembalikanId').val();
        var catatan = $('#catatanKembalikan').val();
        
        var $btn = $(this).find('.btn-submit-form');
        $btn.text('...').prop('disabled', true);

        $.ajax({
            url: '/validasi-rppm/' + id + '/kembalikan',
            type: 'PUT',
            data: { 
                _token: '{{ csrf_token() }}',
                catatan: catatan
            }
        }).done(function(res) {
            $('#mKembalikanRppm').removeClass('on');
            showToast(res.message);
            location.reload();
        }).fail(function(xhr) {
            showToast('❌ Gagal mengembalikan RPP');
            $btn.text('Submit Catatan').prop('disabled', false);
        });
    });
</script>
@endpush
