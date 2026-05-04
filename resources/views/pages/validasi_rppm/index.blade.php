@extends('layout.app')

@section('page-title', 'Validasi RPPM')
@section('page-subtitle', $taAktif?->name ?? '-')

@section('content')
    <div class="card">
        <div class="ch">
            <div class="ct">✅ Validasi RPPM</div>
        </div>

        {{-- <div class="tabs">
            <button class="tbn on" data-tab="tab-menunggu">⏳ Menunggu (3)</button>
            <button class="tbn" data-tab="tab-disetujui">✅ Disetujui (8)</button>
            <button class="tbn" data-tab="tab-dikembalikan">↩️ Dikembalikan</button>
        </div> --}}

        <div class="tabs">
            <button class="tbn on" data-tab="tab-pending">
                ⏳ Menunggu
                @if ($pending->count() > 0)
                    <span class="nbg" style="margin-left:4px">{{ $pending->count() }}</span>
                @endif
            </button>
            <button class="tbn" data-tab="tab-riwayat">📋 Riwayat</button>
        </div>

        {{-- Tab: Menunggu --}}
        {{-- <div id="tab-menunggu" class="tab-content">
            <div class="rc2">
                <div class="rh">
                    <div>
                        <div class="rw">Mgg ke-1 • Ustadzah Siti Rahmah • Kelas A • 2024/2025</div>
                        <div class="rn">Aku, Makhluq Allah</div>
                        <div class="rs">Allah Tuhanku</div>
                    </div>
                    <span class="bdg bpnd">⏳ Pending</span>
                </div>
                <div class="ract">
                    <button class="btn bo bsm">🔍 Detail</button>
                    <button class="btn bp bsm" onclick="showToast('✅ RPPM berhasil disetujui')">✅ Setujui</button>
                    <button class="btn bd bsm">↩️ Kembalikan</button>
                    <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
                </div>
            </div>
            <div class="rc2">
                <div class="rh">
                    <div>
                        <div class="rw">Mgg ke-2 • Ustadzah Dewi Nursanti • Kelas B • 2024/2025</div>
                        <div class="rn">Tanah Airku</div>
                        <div class="rs">Identitas Negara</div>
                    </div>
                    <span class="bdg bpnd">⏳ Pending</span>
                </div>
                <div class="ract">
                    <button class="btn bo bsm">🔍 Detail</button>
                    <button class="btn bp bsm" onclick="showToast('✅ RPPM berhasil disetujui')">✅ Setujui</button>
                    <button class="btn bd bsm">↩️ Kembalikan</button>
                    <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
                </div>
            </div>
            <div class="rc2">
                <div class="rh">
                    <div>
                        <div class="rw">Mgg ke-3 • Ustadzah Siti Rahmah • Kelas A • 2024/2025</div>
                        <div class="rn">Lingkunganku</div>
                        <div class="rs">Rumahku</div>
                    </div>
                    <span class="bdg bpnd">⏳ Pending</span>
                </div>
                <div class="al ale mt8">📝 Perlu ditambahkan kegiatan aspek Seni</div>
                <div class="ract">
                    <button class="btn bo bsm">🔍 Detail</button>
                    <button class="btn bp bsm" onclick="showToast('✅ RPPM berhasil disetujui')">✅ Setujui</button>
                    <button class="btn bd bsm">↩️ Kembalikan</button>
                    <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
                </div>
            </div>
        </div> --}}

        <div id="tab-pending" class="tab-content">
            @forelse ($pending as $rppm)
                <div class="rc2" id="row-rppm-{{ $rppm->id }}">
                    <div class="rh">
                        <div>
                            <div class="rw">
                                Minguu ke-{{ $rppm->minggu_ke }} •
                                {{ $rppm->guru->name }} •
                                {{ $rppm->tahunAjaran->name }}
                            </div>
                            <div class="rn">{{ $rppm->subTema->tema->name }}</div>
                            <div class="rs">{{ $rppm->subTema->name }}</div>
                        </div>
                        <span class="bdg bpnd">⏳ Pending</span>
                    </div>

                    {{-- Ringkasan kegiatan per hari --}}
                    <div class="fl fw g8 mt8 mb8">
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                            @php
                                $count = $rppm->rppmKegiatans->where('hari', $hari)->count();
                            @endphp
                            <div
                                style="
                                    padding:4px 10px;border-radius:6px;font-size:11px;font-weight:700;
                                    background:{{ $count > 0 ? 'var(--g1)' : 'var(--g0)' }};
                                    border:1px solid {{ $count > 0 ? 'var(--g4)' : 'var(--g2)' }};
                                    color:{{ $count > 0 ? 'var(--g7)' : 'var(--txt3)' }}
                                ">
                                {{ $hari }}
                                {{ $count > 0 ? '(' . $count . ')' : '-' }}
                            </div>
                        @endforeach
                    </div>

                    {{-- Aspek yang terstimulasi --}}
                    @php
                        $aspekAda = $rppm->rppmKegiatans->flatMap(fn($rk) => $rk->kegiatan->aspeks)->unique('id');
                    @endphp
                    <div class="fl fw g8 mb8">
                        @foreach ($aspekAda as $aspek)
                            <span class="ap {{ $aspek->warna }}">
                                {{ $aspek->emote }} {{ $aspek->name }}
                            </span>
                        @endforeach
                    </div>

                    {{-- Info tambahan --}}
                    @if ($rppm->model_pembelajaran)
                        <div class="fs11 tc2 mb8">
                            📐 Model: {{ $rppm->model_pembelajaran }}
                        </div>
                    @endif

                    <div class="ract">
                        <a href="{{ route('validasi_rppm.show', $rppm->id) }}" class="btn bo bsm">🔍 Lihat Detail</a>
                        <button type="button" class="btn bp bsm btn-setujui-rppm" data-id="{{ $rppm->id }}">
                            ✅ Setujui
                        </button>
                        <button type="button" class="btn bd bsm btn-buka-kembalikan-rppm" data-id="{{ $rppm->id }}"
                            data-info="Minggu {{ $rppm->minggu_ke }} - {{ $rppm->subTema->name }}">
                            ↩️ Kembalikan
                        </button>
                    </div>
                </div>
            @empty
                <div class="emp">
                    <div class="ei">✅</div>
                    <h3>Tidak ada RPPM yang menunggu</h3>
                    <p>Semua RPPM sudah divalidasi.</p>
                </div>
            @endforelse
        </div>

        {{-- Tab: Riwayat --}}
        <div id="tab-riwayat" class="tab-content" style="display:none">

            {{-- Filter --}}
            <form>
                <div class="fl fw g8 ic fb">
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>
                            ✅ Disetujui
                        </option>
                        <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>
                            ↩️ Dikembalikan
                        </option>
                    </select>
                    <select name="guru_id">
                        <option value="">Semua Guru</option>
                        @foreach ($guruList as $guru)
                            <option value="{{ $guru->id }}" {{ request('guru_id') == $guru->id ? 'selected' : '' }}>
                                {{ $guru->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn bp bsm">🔍 Filter</button>
                    <a href="{{ route('validasi_rppm') }}" class="btn bo bsm">Reset</a>
                </div>
            </form>

            @forelse ($riwayat as $rppm)
                <div class="rc2">
                    <div class="rh">
                        <div>
                            <div class="rw">
                                Minggu ke-{{ $rppm->minggu_ke }} •
                                {{ $rppm->guru->name }} •
                                {{ $rppm->tahunAjaran->name }}
                            </div>
                            <div class="rn">{{ $rppm->subTema->tema->name }}</div>
                            <div class="rs">{{ $rppm->subTema->name }}</div>
                            @if ($rppm->status === 'dikembalikan' && $rppm->catatan_kepala)
                                <div class="al ale mt8" style="font-size:11.5px">
                                    📝 {{ $rppm->catatan_kepala }}
                                </div>
                            @endif
                        </div>
                        <span class="bdg {{ $rppm->status_badge_class }}">
                            {{ $rppm->status_label }}
                        </span>
                    </div>
                    <div class="ract">
                        <a href="{{ route('validasi_rppm.show', $rppm->id) }}" class="btn bo bsm">🔍 Detail</a>
                    </div>
                </div>
            @empty
                <div class="emp">
                    <div class="ei">📋</div>
                    <h3>Belum ada riwayat</h3>
                </div>
            @endforelse

            {{ $riwayat->links() }}
        </div>

        {{-- Modal Kembalikan Rppm --}}
        <div class="mo" id="mKembalikanRppm">
            <div class="md mmd">
                <form id="formKembalikanRppm">
                    <input type="hidden" id="inputKembalikanRppmId" />
                    <div class="mh">
                        <div>
                            <div class="mt2">↩️ Kembalikan RPPM</div>
                            <div class="mst" id="labelInfoKembalikanRppm" style="color:var(--txt3)"></div>
                        </div>
                        <button type="button" class="mc">✕</button>
                    </div>
                    <div class="mb">
                        <div class="ff">
                            <label>Catatan perbaikan</label>
                            <textarea id="inputCatatanKembalikanRppm" rows="4"
                                placeholder="Contoh: Aspek Seni belum ada, mohon ditambahkan kegiatan mewarnai atau melukis..."></textarea>
                        </div>
                        <div id="errorKembalikanRppm" class="al ale mt8" style="display:none"></div>
                    </div>
                    <div class="mf">
                        <button type="submit" class="btn bd btn-submit-form">↩️ Kembalikan</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            $(document).on('click', '[data-tab]', function() {
                var target = $(this).data('tab');
                $(this).closest('.tabs').find('.tbn').removeClass('on');
                $(this).addClass('on');
                $('.tab-content').hide();
                $('#' + target).show();
            });

            $(document).on('click', '.btn-setujui-rppm', function() {
                var id = $(this).data('id');
                var $row = $('#row-rppm-' + id);

                if (!confirm('Setujui RPPM ini?')) return;

                $.ajax({
                        url: '/validasi-rppm/' + id + '/setujui',
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                    })
                    .done(function(res) {
                        $row.fadeOut(300, function() {
                            $(this).remove();
                        });
                        showToast(res.message);
                        updateBadgeCount();
                    })
                    .fail(function(xhr) {
                        showToast('❌ ' + xhr.responseJSON.message);
                    });
            });

            $(document).on('click', '.btn-buka-kembalikan-rppm', function() {
                $('#inputKembalikanRppmId').val($(this).data('id'));
                $('#labelInfoKembalikanRppm').text($(this).data('info'));
                $('#errorKembalikanRppm').hide();
                $('#mKembalikanRppm').addClass('on');
            });

            $('#mKembalikanRppm').on('click', '.mc, .btn.bo', function() {
                $('#formKembalikanRppm')[0].reset();
                $('#errorKembalikanRppm').hide();
            });

            $('#formKembalikanRppm').on('submit', function(e) {
                e.preventDefault();

                var id = $('#inputKembalikanRppmId').val();

                $.ajax({
                        url: '/validasi-rppm/' + id + '/kembalikan',
                        type: 'PUT',
                        data: {
                            catatan: $('#inputCatatanKembalikanRppm').val(),
                            _token: '{{ csrf_token() }}',
                        },
                    })
                    .done(function(res) {
                        $('#mKembalikanRppm').removeClass('on');
                        $('#row-rppm-' + id).fadeOut(300, function() {
                            $(this).remove();
                        });
                        showToast(res.message);
                        updateBadgeCount();
                    })
                    .fail(function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        $('#errorKembalikanRppm').text(errors.catatan[0]).show();
                    });
            });

            function updateBadgeCount() {
                var $badge = $('.tabs .nbg').first();
                var count = parseInt($badge.text()) - 1;
                count <= 0 ? $badge.remove() : $badge.text(count);
            }
        </script>
    @endpush
