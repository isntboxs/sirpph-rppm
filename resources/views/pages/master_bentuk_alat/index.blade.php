@extends('layout.app')

@section('page-title', 'Master Bentuk & Alat')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
    <div class="g2" style="gap:14px">

        {{-- Bentuk Kegiatan --}}
        <div class="card">
            <div class="ch">
                <div>
                    <div class="ct">🎭 Bentuk Kegiatan</div>
                    <div class="cs">Template pilihan guru saat buat RPPH</div>
                </div>
                <button class="btn bp bsm" id="btn-tambah-bentuk">+ Tambah</button>
            </div>
            <div class="fl fw g8" id="listBentuk">
                {{-- Dirender oleh JS --}}
            </div>
        </div>

        {{-- Alat & Bahan --}}
        <div class="card">
            <div class="ch">
                <div>
                    <div class="ct">🔧 Alat & Bahan</div>
                    <div class="cs">Alat yang tersedia di sekolah</div>
                </div>
                <button class="btn bp bsm" id="btn-tambah-alat">+ Tambah</button>
            </div>
            <div class="al alw mb16">⚠️ Hapus alat/bahan jika tidak tersedia di sekolah.</div>
            <div class="fl fw g8" id="listAlat">
                {{-- Dirender oleh JS --}}
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(function() {

            var bentukData = [
                'Mewarnai', 'Menggambar', 'Melukis', 'Menggunting', 'Menempel',
                'Kolase', 'Finger Painting', 'Praktek Ibadah', 'Senam / Olah Raga',
                'Bercerita', 'Bermain Peran', 'Playdough'
            ];

            var alatData = [
                'Crayon', 'Spidol', 'Pensil', 'Kertas HVS', 'Kertas Origami',
                'Gunting', 'Lem', 'Cat Air', 'Kuas', 'LKA', 'Sajadah'
            ];

            function buildChips(data, containerId) {
                var $container = $('#' + containerId).empty();

                $.each(data, function(i, item) {
                    var $chip = $('<div>', {
                        class: 'fl ic g8',
                        css: {
                            padding: '7px 12px',
                            background: 'var(--g0)',
                            border: '1px solid var(--g2)',
                            borderRadius: '20px'
                        }
                    });

                    var $label = $('<span>', {
                        text: item,
                        css: {
                            fontSize: '12px',
                            fontWeight: '600'
                        }
                    });

                    var $removeBtn = $('<button>', {
                        text: '✕',
                        css: {
                            background: 'none',
                            color: 'var(--red)',
                            fontSize: '12px',
                            cursor: 'pointer',
                            border: 'none'
                        }
                    });

                    $chip.append($label, $removeBtn);
                    $container.append($chip);
                });
            }

            $(document).on('click', '#listBentuk button, #listAlat button', function() {
                $(this).closest('div.fl').remove();
            });

            $('#btn-tambah-bentuk').on('click', function() {
                $('#mBentuk').addClass('on');
            });

            $('#btn-tambah-alat').on('click', function() {
                $('#mAlat').addClass('on');
            });

            buildChips(bentukData, 'listBentuk');
            buildChips(alatData, 'listAlat');

        });
    </script>
@endpush
