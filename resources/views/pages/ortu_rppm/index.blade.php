@extends('layout.app')

@section('page-title', 'Lihat RPPM')
@section('page-subtitle', 'Kelas Anak — 2024/2025')

@section('content')
    <div class="card">
        <div class="ch">
            <div class="ct">📝 RPPM Kelas Anak</div>
            <div class="cs">Hanya RPPM yang telah disetujui Kepala Sekolah</div>
        </div>

        <div class="rc2">
            <div class="rh">
                <div>
                    <div class="rw">Mgg ke-1 • Kelas A • 2024/2025</div>
                    <div class="rn">Aku, Makhluq Allah</div>
                    <div class="rs">Allah Tuhanku</div>
                </div>
                <span class="bdg bok">✅ Disetujui</span>
            </div>
            <div class="ig mt8">
                <div class="ib">
                    <div class="ik">Model</div>
                    <div class="iv">Berbasis Proyek</div>
                </div>
                <div class="ib">
                    <div class="ik">Tujuan</div>
                    <div class="iv" style="font-size:11.5px">Anak dapat mengenal Allah sebagai Tuhan melalui kegiatan
                        kreatif...</div>
                </div>
            </div>
            <div class="ract">
                <button class="btn bo bsm">👁️ Lihat Detail</button>
                <button class="btn bo bsm" id="btn-cetak">🖨️ Cetak</button>
            </div>
        </div>

        <div class="rc2">
            <div class="rh">
                <div>
                    <div class="rw">Mgg ke-4 • Kelas A • 2024/2025</div>
                    <div class="rn">Lingkunganku</div>
                    <div class="rs">Sekolahku</div>
                </div>
                <span class="bdg bok">✅ Disetujui</span>
            </div>
            <div class="ig mt8">
                <div class="ib">
                    <div class="ik">Model</div>
                    <div class="iv">Kelompok dengan Sudut</div>
                </div>
                <div class="ib">
                    <div class="ik">Tujuan</div>
                    <div class="iv" style="font-size:11.5px">Anak mengenal lingkungan sekolah dan merasa nyaman
                        belajar...</div>
                </div>
            </div>
            <div class="ract">
                <button class="btn bo bsm">👁️ Lihat Detail</button>
                <button class="btn bo bsm" id="btn-cetak">🖨️ Cetak</button>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#btn-cetak').on('click', function() {
                $('#mCRP').addClass('on');
            });
        });
    </script>
@endpush
