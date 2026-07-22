@extends('layout.app')

@section('page-title', 'VALIDASI LAPORAN RPP')
@section('page-subtitle', 'Tahun Akademik ' . ($taAktif?->name ?? '-') . ' • ' . ucfirst($taAktif?->semester ?? '-'))

@section('content')

    <div class="g4 mb16" style="display: flex; gap: 16px;">
        <div style="border: 1px solid var(--g2); padding: 20px; border-radius: 8px; flex: 1; background: var(--white);">
            <div style="font-size: 12px; font-weight: 600; color: var(--txt2); margin-bottom: 10px; text-transform: uppercase;">Menunggu Validasi</div>
            <div style="font-size: 36px; font-weight: 800;">{{ $stats['pending'] }} <span style="font-size:14px; font-weight:500; color:var(--txt2);">Laporan</span></div>
        </div>
        <div style="border: 1px solid var(--g2); padding: 20px; border-radius: 8px; flex: 1; background: var(--g0);">
            <div style="font-size: 12px; font-weight: 600; color: var(--txt2); margin-bottom: 10px; text-transform: uppercase;">Disetujui</div>
            <div style="font-size: 36px; font-weight: 800;">{{ $stats['disetujui'] }} <span style="font-size:14px; font-weight:500; color:var(--txt2);">Laporan</span></div>
        </div>
        <div style="flex: 2;"></div>
    </div>

    <div class="card" style="margin-bottom: 20px; border-radius: 0;">
        <div class="tw">
            <table style="border-collapse: collapse; width: 100%;">
                <thead style="background: var(--g0); border-bottom: 2px solid var(--g2);">
                    <tr>
                        <th style="padding: 15px; text-align: left; font-size:11px; text-transform:uppercase;">Nama Guru</th>
                        <th style="padding: 15px; text-align: center; font-size:11px; text-transform:uppercase;">Minggu</th>
                        <th style="padding: 15px; text-align: left; font-size:11px; text-transform:uppercase;">Tema / Sub-Tema</th>
                        <th style="padding: 15px; text-align: left; font-size:11px; text-transform:uppercase;">Tanggal</th>
                        <th style="padding: 15px; text-align: center; font-size:11px; text-transform:uppercase;">Status</th>
                        <th style="padding: 15px; text-align: center; font-size:11px; text-transform:uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporanPending as $laporan)
                        <tr style="border-bottom: 1px solid var(--g1);">
                            <td style="padding: 15px;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div style="width:30px; height:30px; background:var(--g1); border:1px solid var(--g2); display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:12px;">
                                        G
                                    </div>
                                    <div style="font-weight: 600;">{{ $laporan->guru->name }}</div>
                                </div>
                            </td>
                            <td style="padding: 15px; text-align: center;">{{ $laporan->rppm->minggu_ke ?? '-' }}</td>
                            <td style="padding: 15px;">
                                <div style="font-weight: 500;">{{ $laporan->rppm->subTema->tema->name ?? '-' }}</div>
                                <div style="font-size: 12px; color: var(--txt2);">{{ $laporan->rppm->subTema->name ?? '-' }}</div>
                            </td>
                            <td style="padding: 15px; font-size:13px;">{{ $laporan->created_at->translatedFormat('d F Y') }}</td>
                            <td style="padding: 15px; text-align: center;">
                                @if($laporan->status === 'pending')
                                    <span style="background: var(--g2); padding: 4px 10px; font-size: 10px; font-weight: bold; text-transform: uppercase;">Menunggu</span>
                                @elseif($laporan->status === 'dikembalikan')
                                    <span style="background: #fca5a5; padding: 4px 10px; font-size: 10px; font-weight: bold; text-transform: uppercase; color: #7f1d1d;">Dikembalikan</span>
                                @elseif($laporan->status === 'disetujui')
                                    <span style="background: #6b7280; padding: 4px 10px; font-size: 10px; font-weight: bold; text-transform: uppercase; color: #fff;">Tervalidasi</span>
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 5px; justify-content: center; align-items:center;">
                                    <a href="{{ route('laporan_rpp.show', $laporan->id) }}" style="border:1px solid var(--g3); padding:4px 12px; font-size:11px; color:var(--txt); text-decoration:none;">DETAIL</a>
                                    
                                    @if($laporan->status === 'pending')
                                        <button type="button" class="btn-validasi" data-id="{{ $laporan->id }}" style="background:#000; color:#fff; border:none; padding:4px 12px; font-size:11px; cursor:pointer;">VALIDASI</button>
                                    @elseif($laporan->status === 'dikembalikan')
                                        <button type="button" style="background:#f3f4f6; color:#9ca3af; border:1px solid #d1d5db; padding:4px 12px; font-size:11px; cursor:not-allowed;" disabled>VALIDASI</button>
                                    @elseif($laporan->status === 'disetujui')
                                        <span style="color:var(--txt2); font-size:14px;">✔</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px;">Belum ada Laporan RPP yang diajukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="padding: 15px; border-top: 1px solid var(--g2); display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 11px; color: var(--txt2);">
                Menampilkan {{ $laporanPending->firstItem() ?? 0 }}-{{ $laporanPending->lastItem() ?? 0 }} dari {{ $laporanPending->total() }} laporan
            </div>
            @if ($laporanPending->hasPages())
                <div>
                    {{ $laporanPending->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Validasi Laporan --}}
    <div class="mo" id="mValidasiLaporan">
        <div class="md msm">
            <input type="hidden" id="laporanId">
            <div class="mh">
                <div>
                    <div class="mt2">Validasi Laporan RPP</div>
                </div>
                <button type="button" class="mc" onclick="$('#mValidasiLaporan').removeClass('on')">✕</button>
            </div>
            <div class="mb">
                <div class="ff mb16">
                    <label>Aksi Validasi</label>
                    <div style="display: flex; gap: 10px;">
                        <button type="button" id="btn-setujui-laporan" class="btn bo" style="background:var(--blue); color:#fff; border:none; flex:1;">Setujui Laporan</button>
                    </div>
                </div>
                <div class="ff">
                    <label>Kembalikan Laporan (Catatan Revisi)</label>
                    <textarea id="catatanKembalikanLaporan" rows="4" placeholder="Masukkan alasan kenapa Laporan ini dikembalikan..."></textarea>
                    <button type="button" id="btn-kembalikan-laporan" class="btn bo" style="background:#000; color:#fff; border:none; width: 100%; margin-top: 10px;">Kembalikan dengan Catatan</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).on('click', '.btn-validasi', function() {
        var id = $(this).data('id');
        $('#laporanId').val(id);
        $('#catatanKembalikanLaporan').val('');
        $('#mValidasiLaporan').addClass('on');
    });

    $('#btn-setujui-laporan').on('click', function() {
        var id = $('#laporanId').val();
        var $btn = $(this);
        
        window.confirmAction('Apakah Anda yakin ingin menyetujui Laporan ini?', function() {
            $btn.text('...').prop('disabled', true);

            $.ajax({
                url: '/validasi-laporan/' + id + '/setujui',
                type: 'PUT',
                data: { _token: '{{ csrf_token() }}' }
            }).done(function(res) {
                $('#mValidasiLaporan').removeClass('on');
                showToast(res.message);
                location.reload();
            }).fail(function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal menyetujui';
                showToast('❌ ' + msg);
                $btn.text('Setujui Laporan').prop('disabled', false);
            });
        });
    });

    $('#btn-kembalikan-laporan').on('click', function() {
        var id = $('#laporanId').val();
        var catatan = $('#catatanKembalikanLaporan').val();
        
        if (!catatan) {
            alert('Catatan revisi wajib diisi!');
            return;
        }

        var $btn = $(this);
        $btn.text('...').prop('disabled', true);

        $.ajax({
            url: '/validasi-laporan/' + id + '/kembalikan',
            type: 'PUT',
            data: { 
                _token: '{{ csrf_token() }}',
                catatan: catatan
            }
        }).done(function(res) {
            $('#mValidasiLaporan').removeClass('on');
            showToast(res.message);
            location.reload();
        }).fail(function(xhr) {
            showToast('❌ Gagal mengembalikan laporan');
            $btn.text('Kembalikan dengan Catatan').prop('disabled', false);
        });
    });
</script>
@endpush
