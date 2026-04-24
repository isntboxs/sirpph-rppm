@extends('layout.app')

@section('page-title', 'Kumpulan Kegiatan')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')

    {{-- Filter Bar --}}
    <div class="card mb16">
        <form id="formFilter" class="fl fw g8 ic">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="🔍 Cari kegiatan..."
                style="min-width:200px" />

            <select name="tema_id">
                <option value="">Semua Tema</option>
                @foreach ($temas as $tema)
                    <option value="{{ $tema->id }}" {{ request('tema_id') == $tema->id ? 'selected' : '' }}>
                        {{ $tema->name }}
                    </option>
                @endforeach
            </select>

            <select name="bentuk_id">
                <option value="">Semua Bentuk</option>
                @foreach ($bentuk as $b)
                    <option value="{{ $b->id }}" {{ request('bentuk_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->name }}
                    </option>
                @endforeach
            </select>

            <select name="aspek_id">
                <option value="">Semua Aspek</option>
                @foreach ($aspeks as $aspek)
                    <option value="{{ $aspek->id }}" {{ request('aspek_id') == $aspek->id ? 'selected' : '' }}>
                        {{ $aspek->emote }} {{ $aspek->name }}
                    </option>
                @endforeach
            </select>

            {{-- <select name="status">
                <option value="">Semua status</option>
                <option value="disetujui">Disetujui</option>
                <option value="ditolak">Ditolak</option>
                <option value="pending">Pending</option>
            </select> --}}

            <select name="status">
                <option value="">Semua Status</option>
                @foreach ($status as $key => $label)
                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn bp bsm">🔍 Filter</button>
            <a href="{{ route('kumpulan_kegiatan') }}" class="btn bo bsm">Reset</a>
        </form>
    </div>

    {{-- Header --}}
    <div class="fl jb ic mb16">
        <div class="fs11 tc2">
            {{ $kegiatans->total() }} kegiatan ditemukan
        </div>
        <button type="button" class="btn bp bsm" id="btnUsulkanKegiatan">
            + Usulkan Kegiatan Baru
        </button>
    </div>

    {{-- Grid Kegiatan --}}
    @if ($kegiatans->isEmpty())
        <div class="card emp">
            <div class="ei">🗂️</div>
            <h3>Tidak ada kegiatan ditemukan</h3>
            <p>Coba ubah filter atau usulkan kegiatan baru.</p>
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:12px">
            @foreach ($kegiatans as $kegiatan)
                <div class="kc">
                    {{-- Header card --}}
                    <div class="fl jb ic mb8">
                        <div class="fl ic g8">
                            <span style="font-size:24px">{{ $kegiatan->foto_icon }}</span>
                            <div class="kn">{{ $kegiatan->name }}</div>
                        </div>
                        <span class="bdg {{ $kegiatan->status_badge_class }}">{{ $kegiatan->status_label }}</span>
                    </div>

                    {{-- Tema & Bentuk --}}
                    <div class="fs11 tc2 mb8">
                        📚 {{ $kegiatan->tema->name }} &nbsp;|&nbsp;
                        🎭 {{ $kegiatan->bentukKegiatan->name }}
                    </div>

                    {{-- Deskripsi --}}
                    @if ($kegiatan->deskripsi)
                        <div class="kd">{{ Str::limit($kegiatan->deskripsi, 100) }}</div>
                    @endif

                    {{-- Aspek Perkembangan --}}
                    <div class="fl fw g8 mb8">
                        @foreach ($kegiatan->aspeks as $aspek)
                            <span class="ap {{ $aspek->warna }}">
                                {{ $aspek->emote }} {{ $aspek->name }}
                            </span>
                        @endforeach
                    </div>

                    {{-- Alat Bahan --}}
                    @if ($kegiatan->alatBahans->isNotEmpty())
                        <div class="fs11 tc2">
                            🔧 {{ $kegiatan->alatBahans->pluck('name')->join(', ') }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        {{ $kegiatans->links() }}
    @endif

    {{-- Modal: Usulkan Kegiatan Baru --}}
    <div class="mo" id="mUsulkanKegiatan">
        <div class="md mlg">
            <form id="formUsulkanKegiatan">
                <div class="mh">
                    <div>
                        <div class="mt2">Usulkan Kegiatan Baru</div>
                        <div class="mst">Kegiatan perlu disetujui Kepala Sekolah sebelum bisa dipakai.</div>
                    </div>
                    <button type="button" class="mc">✕</button>
                </div>
                <div class="mb">
                    <div class="fr c2">
                        <div class="ff">
                            <label>Nama Kegiatan</label>
                            <input id="inputNamaKegiatan" name="name" placeholder="Nama kegiatan..." />
                        </div>
                        <div class="ff">
                            <label>Tema</label>
                            <select id="inputTemaKegiatan" name="tema_id">
                                <option value="">-- Pilih Tema --</option>
                                @foreach ($temas as $tema)
                                    <option value="{{ $tema->id }}">{{ $tema->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="fr c2">
                        <div class="ff">
                            <label>Bentuk Kegiatan</label>
                            <select id="inputBentukKegiatan" name="bentuk_kegiatan_id">
                                <option value="">-- Pilih Bentuk --</option>
                                @foreach ($bentuk as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ff">
                            <label>Ikon Kegiatan</label>
                            <div class="fl fw g8 mt4" id="pilihanIkon">
                                @foreach (['🎨', '✏️', '📸', '🧩', '📚', '🌱', '🕌', '🏃', '🎵', '🧸', '🖌️', '✂️'] as $ikon)
                                    <div class="ikon-option" data-ikon="{{ $ikon }}"
                                        style="width:40px;height:40px;border-radius:9px;border:2px solid var(--g2);
                                           display:flex;align-items:center;justify-content:center;
                                           font-size:20px;cursor:pointer;transition:.15s">
                                        {{ $ikon }}
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" id="inputFotoIkon" name="foto_icon" value="🎨" />
                        </div>
                    </div>
                    <div class="fr">
                        <div class="ff">
                            <label>Deskripsi Kegiatan</label>
                            <textarea id="inputDeskripsiKegiatan" name="deskripsi" rows="3"
                                placeholder="Jelaskan langkah-langkah kegiatan ini..."></textarea>
                        </div>
                    </div>

                    {{-- Aspek Perkembangan --}}
                    <div class="ff mb16">
                        <label>Aspek Perkembangan yang Distimulasi</label>
                        <div class="fl fw g8 mt8">
                            @foreach ($aspeks as $aspek)
                                <label class="cbi" style="cursor:pointer">
                                    <input hidden type="checkbox" name="aspek_ids[]" value="{{ $aspek->id }}"
                                        class="checkbox-aspek" />
                                    <span class="ap {{ $aspek->warna }}">
                                        {{ $aspek->emote }} {{ $aspek->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Alat Bahan --}}
                    <div class="ff">
                        <label>Alat & Bahan</label>
                        <div class="fl fw g8 mt8">
                            @foreach ($alats as $alat)
                                <label class="cbi" style="cursor:pointer">
                                    <input hidden type="checkbox" name="alat_ids[]" value="{{ $alat->id }}"
                                        class="checkbox-alat" />
                                    {{ $alat->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div id="errorKegiatan" class="al ale mt16" style="display:none"></div>
                </div>
                <div class="mf">
                    <button type="submit" class="btn bp btn-submit-form">📤 Usulkan ke Kepala</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $('#btnUsulkanKegiatan').on('click', function() {
            $('#mUsulkanKegiatan').addClass('on');
        });

        $('#mUsulkanKegiatan').on('click', '.mc, .btn.bo', function() {
            $('#formUsulkanKegiatan')[0].reset();
            $('#errorKegiatan').hide().text('');
            $('.ikon-option').css('border-color', 'var(--g2)').css('background', 'transparent');
            $('.ikon-option[data-ikon="🎨"]').css('border-color', 'var(--g5)').css('background', 'var(--g1)');
            $('#inputFotoIkon').val('🎨');
        });

        $(document).on('click', '.ikon-option', function() {
            $('.ikon-option').css('border-color', 'var(--g2)').css('background', 'transparent');
            $(this).css('border-color', 'var(--g5)').css('background', 'var(--g1)');
            $('#inputFotoIkon').val($(this).data('ikon'));
        });

        $('.ikon-option[data-ikon="🎨"]').css('border-color', 'var(--g5)').css('background', 'var(--g1)');

        $('#formUsulkanKegiatan').on('submit', function(e) {
            e.preventDefault();

            var aspekIds = [];
            $('input.checkbox-aspek:checked').each(function() {
                aspekIds.push($(this).val());
            });

            var alatIds = [];
            $('input.checkbox-alat:checked').each(function() {
                alatIds.push($(this).val());
            });

            var payload = {
                name: $('#inputNamaKegiatan').val(),
                tema_id: $('#inputTemaKegiatan').val(),
                bentuk_kegiatan_id: $('#inputBentukKegiatan').val(),
                deskripsi: $('#inputDeskripsiKegiatan').val(),
                foto_icon: $('#inputFotoIkon').val(),
                'aspek_ids[]': aspekIds,
                'alat_ids[]': alatIds,
                _token: '{{ csrf_token() }}',
            };

            $.post('{{ route('kumpulan_kegiatan.store') }}', payload)
                .done(function() {
                    $('#mUsulkanKegiatan').removeClass('on');
                    showToast('📤 Kegiatan berhasil diusulkan, menunggu persetujuan Kepala');
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var pesan = Object.values(errors).flat().join('<br>');
                    $('#errorKegiatan').html(pesan).show();
                });
        });

        // Submit filter dengan AJAX
        // Kita biarkan filter pakai full page reload karena URL perlu berubah
        // agar pagination bekerja dengan benar (link pagination sudah mengandung query string)
    </script>
@endpush
