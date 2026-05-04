@extends('layout.app')

@section('page-title', 'Buat & Kelola RPPH')
@section('page-subtitle', $taAktif?->name ?? '-')

@section('content')

    @forelse ($rppms as $rppm)
        <div class="card mb16">

            {{-- Header RPPM --}}
            <div class="ch mb12">
                <div>
                    <div class="fs11 tc2">Mgg ke-{{ $rppm->minggu_ke }}</div>
                    <div class="ct">{{ $rppm->subTema->tema->name }}</div>
                    <div class="rs">{{ $rppm->subTema->name }}</div>
                </div>
                <div class="fl ic g8">
                    <span class="bdg bok">✅ RPPM Disetujui</span>
                    @if ($rppm->rpphs->isEmpty())
                        <button type="button" class="btn bp bsm btn-generate-rpph" data-id="{{ $rppm->id }}">
                            ⚡ Generate RPPH
                        </button>
                    @else
                        <button type="button" class="btn bo bsm btn-generate-rpph" data-id="{{ $rppm->id }}">
                            🔄 Refresh RPPH
                        </button>
                    @endif
                </div>
            </div>

            {{-- Panel per hari --}}
            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                @php
                    $kegiatanHari = $rppm->rppmKegiatans->where('hari', $hari);
                    $rpph = $rppm->rpphs->where('hari', $hari)->first();
                @endphp

                @if ($kegiatanHari->isNotEmpty())
                    <div class="ds mb8">
                        <div class="dsh">
                            <span class="dn">📅 {{ $hari }}</span>
                            <div class="fl ic g8">
                                @if ($rpph)
                                    <span class="bdg {{ $rpph->status_badge_class }}">
                                        {{ $rpph->status_label }}
                                    </span>
                                    @if (in_array($rpph->status, ['draft', 'dikembalikan']))
                                        <button type="button" class="btn bp bxs btn-edit-rpph"
                                            data-id="{{ $rpph->id }}" data-hari="{{ $hari }}"
                                            data-pembuka="{{ $rpph->pembuka }}" data-inti="{{ $rpph->inti }}" data-penutup="{{ $rpph->penutup }}">
                                            ✏️ Edit
                                        </button>
                                        <button type="button" class="btn ba bxs btn-ajukan-rpph"
                                            data-id="{{ $rpph->id }}" data-hari="{{ $hari }}">
                                            📤 Ajukan
                                        </button>
                                    @endif
                                @else
                                    <span class="fs11 tc2">Belum di-generate</span>
                                @endif
                            </div>
                        </div>

                        {{-- List kegiatan hari ini --}}
                        @foreach ($kegiatanHari as $rk)
                            <div class="dki">
                                <div>
                                    <span style="font-weight:700">
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

                        {{-- Catatan RPPH jika sudah dikembalikan --}}
                        @if ($rpph && $rpph->status === 'dikembalikan' && $rpph->catatan_kepala)
                            <div class="al ale mt8">
                                📝 Catatan Kepala: {{ $rpph->catatan_kepala }}
                            </div>
                        @endif

                    </div>
                @endif
            @endforeach

        </div>
    @empty
        <div class="emp">
            <div class="ei">📅</div>
            <h3>Belum ada RPPH</h3>
            <p>RPPH dibuat dari RPPM yang sudah disetujui. Pastikan RPPM kamu sudah disetujui Kepala Sekolah, lalu klik
                Generate RPPH.</p>
            <a href="{{ route('rppm') }}" class="btn bp" style="margin-top:12px">← Ke Halaman RPPM</a>
        </div>
    @endforelse

    {{-- Modal: Edit Detail RPPH --}}
    <div class="mo" id="mEditRpph">
        <div class="md mmd">
            <form id="formEditRpph">
                <input type="hidden" id="inputRpphId" />
                <div class="mh">
                    <div>
                        <div class="mt2">✏️ Edit RPPH</div>
                        <div class="mst" id="labelHariRpph"></div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">
                    <div class="ff mb12">
                        <label>Pembuka</label>
                        <textarea id="inputPembuka" name="pembuka" rows="3"
                            placeholder="Pembuka kegiatan hari ini secara spesifik..."></textarea>
                    </div>
                    <div class="ff mb12">
                        <label>Inti</label>
                        <textarea id="inputInti" name="inti" rows="3"
                            placeholder="Inti kegiatan hari ini secara spesifik..."></textarea>
                    </div>
                    <div class="ff">
                        <label>Penutup</label>
                        <textarea id="inputPenutup" name="penutup" rows="3"
                            placeholder="Penutup kegiatan hari ini secara spesifik..."></textarea>
                    </div>
                </div>
                <div class="mf">
                    <button type="submit" class="btn bp btn-submit-form">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).on('click', '.btn-generate-rpph', function() {
            var id = $(this).data('id');

            $.post('/rppm/' + id + '/generate-rpph', {
                    _token: '{{ csrf_token() }}'
                })
                .done(function(res) {
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 800);
                })
                .fail(function(xhr) {
                    showToast('❌ ' + xhr.responseJSON.message);
                });
        });

        $(document).on('click', '.btn-edit-rpph', function() {
            $('#inputRpphId').val($(this).data('id'));
            $('#labelHariRpph').text('Hari: ' + $(this).data('hari'));
            $('#inputPembuka').val($(this).data('pembuka'));
            $('#inputInti').val($(this).data('inti'));
            $('#inputPenutup').val($(this).data('penutup'));
            $('#mEditRpph').addClass('on');
        });

        $('#mEditRpph').on('click', '.mc, .btn.bo', function() {
            $('#formEditRpph')[0].reset();
        });

        $('#formEditRpph').on('submit', function(e) {
            e.preventDefault();

            var id = $('#inputRpphId').val();

            $.ajax({
                    url: '/rpph/' + id,
                    type: 'PUT',
                    data: {
                        pembuka: $('#inputPembuka').val(),
                        inti: $('#inputInti').val(),
                        penutup: $('#inputPenutup').val(),
                        _token: '{{ csrf_token() }}',
                    },
                })
                .done(function(res) {
                    $('#mEditRpph').removeClass('on');
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 800);
                });
        });

        $(document).on('click', '.btn-ajukan-rpph', function() {
            var id = $(this).data('id');
            var hari = $(this).data('hari');

            if (!confirm('Ajukan RPPH hari ' + hari + ' ke Kepala Sekolah?')) return;

            $.ajax({
                    url: '/rpph/' + id + '/ajukan',
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                })
                .done(function(res) {
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 800);
                })
                .fail(function(xhr) {
                    showToast('❌ ' + xhr.responseJSON.message);
                });
        });
    </script>
@endpush
