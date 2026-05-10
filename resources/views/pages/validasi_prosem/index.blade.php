@extends('layout.app')

@section('page-title', 'Validasi PROSEM')
@section('page-subtitle', $taAktif?->name ?? '-')

@section('content')

    <div class="card">
        <div class="ch mb16">
            <div>
                <div class="ct">✅ Validasi Program Semester</div>
                <div class="cs">
                    @php
                        $flat = $prosems->flatten();
                        $totalMenunggu = $flat->where('status', 'menunggu')->count();
                    @endphp
                </div>
            </div>
            @if ($totalMenunggu > 0)
                <button type="button" class="btn bp bsm" id="btnValidasiSemua">
                    Validasi Semua ({{ $totalMenunggu }})
                </button>
            @else
                <span class="bdg bok">Sudah Divalidasi</span>
            @endif
        </div>

        <div class="tw">
            <table>
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:22%">Tema</th>
                        <th style="width:25%">Sub Tema</th>
                        <th style="width:10%">Minggu Ke</th>
                        <th style="width:10%">Alokasi</th>
                        <th style="width:12%">Status</th>
                        <th style="width:16%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse ($prosems as $temaId => $items)
                        @foreach ($items as $i => $prosem)
                            <tr id="row-vprosem-{{ $prosem->id }}">
                                @if ($i === 0)
                                    <td rowspan="{{ $items->count() }}"
                                        style="text-align:center;font-weight:700;
                                           background:var(--g0);vertical-align:middle">
                                        {{ $no++ }}
                                    </td>
                                    <td rowspan="{{ $items->count() }}"
                                        style="font-weight:700;background:var(--g0);
                                           vertical-align:middle">
                                        {{ $prosem->tema->name }}
                                    </td>
                                @endif

                                <td>{{ $prosem->subTema->name }}</td>

                                <td style="text-align:center">
                                    <div
                                        style="width:32px;height:32px;background:var(--g6);
                                            color:white;border-radius:50%;display:flex;
                                            align-items:center;justify-content:center;
                                            font-size:12px;font-weight:700;margin:0 auto">
                                        {{ $prosem->minggu_ke }}
                                    </div>
                                </td>

                                <td style="text-align:center">1 Minggu</td>

                                <td>
                                    <span class="bdg {{ $prosem->status_badge_class }}"
                                        id="badge-vprosem-{{ $prosem->id }}">
                                        {{ $prosem->status_label }}
                                    </span>
                                    @if ($prosem->status === 'invalid' && $prosem->catatan)
                                        <div class="fs11 mt4" style="color:var(--red);line-height:1.4">
                                            📝 {{ $prosem->catatan }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    @if ($prosem->status === 'menunggu')
                                        <div class="fl g8">
                                            <button type="button" class="btn bp bxs btn-valid-prosem"
                                                data-id="{{ $prosem->id }}" data-minggu="{{ $prosem->minggu_ke }}">
                                                ✅ Valid
                                            </button>
                                            <button type="button" class="btn bd bxs btn-buka-invalid-prosem"
                                                data-id="{{ $prosem->id }}"
                                                data-info="Minggu {{ $prosem->minggu_ke }} - {{ $prosem->subTema->name }}">
                                                ❌
                                            </button>
                                        </div>
                                    @elseif ($prosem->status === 'valid')
                                        <span class="fs11 tc2">Sudah Valid</span>
                                    @else
                                        <span class="fs11" style="color:var(--red)">
                                            Menunggu revisi admin
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:32px;color:var(--txt3)">
                                Belum ada data PROSEM yang diinput admin.
                            </td>
                        </tr>
                    @endforelse

                    @if ($prosems->isNotEmpty())
                        <tr style="background:var(--g1)">
                            <td colspan="4" style="text-align:center;font-weight:700;padding:8px">
                                JUMLAH
                            </td>
                            <td style="text-align:center;font-weight:700">
                                {{ $prosems->flatten()->count() }} Minggu
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal: Invalid PROSEM --}}
    <div class="mo" id="mInvalidProsem">
        <div class="md mmd">
            <form id="formInvalidProsem">
                <input type="hidden" id="inputInvalidProsemId" />
                <div class="mh">
                    <div>
                        <div class="mt2">❌ Tandai Invalid</div>
                        <div class="mst" id="labelInvalidProsem" style="color:var(--txt3)"></div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">
                    <div class="al alw mb12">
                        ⚠️ Admin akan melihat catatan ini untuk memperbaiki PROSEM.
                    </div>
                    <div class="ff">
                        <label>Catatan untuk Admin</label>
                        <textarea id="inputCatatanInvalid" rows="4"
                            placeholder="Contoh: Sub tema ini sebaiknya dipindah ke minggu 3 karena berkaitan dengan tema sebelumnya..."></textarea>
                    </div>
                    <div id="errorInvalidProsem" class="al ale mt8" style="display:none"></div>
                </div>
                <div class="mf">
                    <button type="button" class="btn bo">Batal</button>
                    <button type="submit" class="btn bd btn-submit-form">❌ Tandai Invalid</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).on('click', '.btn-valid-prosem', function() {
            var id = $(this).data('id');
            var minggu = $(this).data('minggu');

            if (!confirm('Validasi PROSEM minggu ke-' + minggu + '?')) return;

            $.ajax({
                    url: '/validasi-prosem/' + id,
                    type: 'PUT',
                    data: {
                        status: 'valid',
                        _token: '{{ csrf_token() }}',
                    },
                })
                .done(function(res) {
                    var $badge = $('#badge-vprosem-' + id);
                    $badge.attr('class', 'bdg bok').text('✅ Valid');

                    $badge.closest('tr').find('.fl.g8').html('<span class="fs11 tc2">Sudah Valid</span>');

                    showToast(res.message);
                    window.decrementBadge('validasi-prosem');
                })
                .fail(function(xhr) {
                    showToast('❌ ' + xhr.responseJSON.message);
                });
        });

        $(document).on('click', '.btn-buka-invalid-prosem', function() {
            $('#inputInvalidProsemId').val($(this).data('id'));
            $('#labelInvalidProsem').text($(this).data('info'));
            $('#errorInvalidProsem').hide();
            $('#inputCatatanInvalid').val('');
            $('#mInvalidProsem').addClass('on');
        });

        $('#mInvalidProsem').on('click', '.mc, .btn.bo', function() {
            $('#formInvalidProsem')[0].reset();
            $('#errorInvalidProsem').hide();
        });

        $('#formInvalidProsem').on('submit', function(e) {
            e.preventDefault();

            var id = $('#inputInvalidProsemId').val();

            $.ajax({
                    url: '/validasi-prosem/' + id,
                    type: 'PUT',
                    data: {
                        status: 'invalid',
                        catatan: $('#inputCatatanInvalid').val(),
                        _token: '{{ csrf_token() }}',
                    },
                })
                .done(function(res) {
                    $('#mInvalidProsem').removeClass('on');
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 700);
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('#errorInvalidProsem').text(errors.catatan?.[0] || 'Gagal.').show();
                });
        });

        $('#btnValidasiSemua').on('click', function() {
            if (!confirm('Validasi semua baris PROSEM yang menunggu?')) return;

            $.ajax({
                    url: '/validasi-prosem/semua/validasi',
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                })
                .done(function(res) {
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 700);
                });
        });
    </script>
@endpush
