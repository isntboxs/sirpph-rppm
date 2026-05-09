@extends('layout.app')

@section('page-title', 'Buat & Kelola RPPM')
@section('page-subtitle', $taAktif?->name ?? '-')

@section('content')
    <div class="tabs">
        <button class="tbn on" id="tab-btn-daftar">📋 Daftar RPPM ({{ $rppms->count() }})</button>
        <button class="tbn" id="tab-btn-baru">+ Buat RPPM Baru</button>
    </div>

    {{-- Panel: Daftar RPPM --}}
    {{-- <div id="panel-daftar">
        <div class="rc2">
            <div class="rh">
                <div>
                    <div class="rw">Mgg ke-1 — Sem 1 — 2024/2025</div>
                    <div class="rn">Aku, Makhluq Allah</div>
                    <div class="rs">Allah Tuhanku</div>
                </div>
                <span class="bdg bok">✅ Disetujui</span>
            </div>
            <div class="ract">
                <button class="btn bo bsm">👁️ Detail</button>
                <button class="btn bp bsm">⚡ Generate RPPH</button>
                <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
            </div>
        </div>
        <div class="rc2">
            <div class="rh">
                <div>
                    <div class="rw">Mgg ke-2 — Sem 1 — 2024/2025</div>
                    <div class="rn">Tanah Airku</div>
                    <div class="rs">Identitas Negara</div>
                </div>
                <span class="bdg bpnd">⏳ Pending</span>
            </div>
            <div class="ract">
                <button class="btn bo bsm">👁️ Detail</button>
                <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
            </div>
        </div>
        <div class="rc2">
            <div class="rh">
                <div>
                    <div class="rw">Mgg ke-3 — Sem 1 — 2024/2025</div>
                    <div class="rn">Lingkunganku</div>
                    <div class="rs">Rumahku</div>
                </div>
                <span class="bdg bdr">📝 Draft</span>
            </div>
            <div class="al ale mt8">📝 Perlu ditambahkan kegiatan aspek Seni</div>
            <div class="ract">
                <button class="btn bo bsm">👁️ Detail</button>
                <button class="btn ba bsm" onclick="showToast('📤 RPPM diajukan ke Kepala Sekolah')">📤 Ajukan ke
                    Kepala</button>
                <button class="btn bo bsm" onclick="document.getElementById('mCRP').classList.add('on')">🖨️</button>
            </div>
        </div>
    </div> --}}

    <div id="panel-daftar">
        @forelse ($rppms as $rppm)
            <div class="rc2">
                <div class="rh">
                    <div>
                        <div class="rw">
                            Mgg ke-{{ $rppm->minggu_ke }} •
                            {{ $rppm->tahunAjaran->name }}
                        </div>
                        <div class="rn">{{ $rppm->subTema->tema->name }}</div>
                        <div class="rs">{{ $rppm->subTema->name }}</div>
                        @if ($rppm->status === 'dikembalikan' && $rppm->catatan_kepala)
                            <div class="al ale mt8">
                                📝 Catatan Kepala: {{ $rppm->catatan_kepala }}
                            </div>
                        @endif
                    </div>
                    <span class="bdg {{ $rppm->status_badge_class }}">
                        {{ $rppm->status_label }}
                    </span>
                </div>

                {{-- Progress kegiatan per hari --}}
                <div class="fl fw g8 mt8 mb8">
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                        @php
                            $adaKegiatan = $rppm->rppmKegiatans->where('hari', $hari)->isNotEmpty();
                            $rpph = $rppm->rpphs->where('hari', $hari)->first();
                        @endphp
                        <div
                            style="
                        padding:5px 11px;
                        border-radius:7px;
                        font-size:11.5px;
                        font-weight:700;
                        background:{{ $adaKegiatan ? 'var(--g1)' : 'var(--g0)' }};
                        border:2px solid {{ $adaKegiatan ? 'var(--g4)' : 'var(--g1)' }};
                        color:{{ $adaKegiatan ? 'var(--g7)' : 'var(--txt3)' }}
                    ">
                            {{ $hari }}
                            @if ($adaKegiatan)
                                @if ($rpph)
                                    <span style="color:var(--g5)">
                                        {{ $rpph->status === 'disetujui' ? '✅' : ($rpph->status === 'pending' ? '⏳' : '📝') }}
                                    </span>
                                @else
                                    ✓
                                @endif
                            @else
                                ⚪
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Aspek yang belum terstimulasi --}}
                @php $belum = $rppm->aspekBelumTerstimulasi(); @endphp
                @if ($belum->isNotEmpty() && in_array($rppm->status, ['draft', 'dikembalikan']))
                    <div class="al alw mb8">
                        ⚠️ Aspek belum ada:
                        @foreach ($belum as $aspek)
                            <span class="ap {{ $aspek->warna }}">{{ $aspek->emote }} {{ $aspek->name }}</span>
                        @endforeach
                    </div>
                @endif

                {{-- Tombol aksi --}}
                <div class="ract">
                    <a href="{{ route('rppm.show', $rppm->id) }}" class="btn bo bsm">
                        ✏️ {{ in_array($rppm->status, ['draft', 'dikembalikan']) ? 'Edit Kegiatan' : 'Lihat Detail' }}
                    </a>

                    @if (in_array($rppm->status, ['draft', 'dikembalikan']))
                        <button type="button" class="btn ba bsm btn-ajukan-rppm" data-id="{{ $rppm->id }}">
                            📤 Ajukan ke Kepala
                        </button>
                    @endif

                    @if ($rppm->status === 'disetujui')
                        <button type="button" class="btn bp bsm btn-generate-rpph" data-id="{{ $rppm->id }}">
                            ⚡ Generate RPPH
                        </button>
                        <a href="{{ route('rpph') }}" class="btn bo bsm">📅 Lihat RPPH</a>
                    @endif

                    <button type="button" class="btn bo bsm"
                        onclick="window.open('/rppm/{{ $rppm->id }}/cetak', '_blank')">
                        🖨️
                    </button>
                </div>
            </div>
        @empty
            <div class="emp">
                <div class="ei">📋</div>
                <h3>Belum ada RPPM</h3>
                <p>Klik tab "+ Buat RPPM Baru" untuk mulai membuat RPPM.</p>
            </div>
        @endforelse
    </div>

    {{-- Panel: Form Buat RPPM Baru --}}
    {{-- <div id="panel-baru" style="display:none">
        <div class="card">
            <div class="ch">
                <div class="ct">📝 Form RPPM Baru</div>
            </div>

            <div class="fs11 tc2 mb16" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">A. Identitas
            </div>

            <div class="fr c3">
                <div class="ff">
                    <label>Tema</label>
                    <select id="selectTema" onchange="updateSubTema()">
                        <option value="">-- Pilih --</option>
                        <option value="aku">Aku, Makhluq Allah</option>
                        <option value="tanah">Tanah Airku</option>
                        <option value="lingkungan">Lingkunganku</option>
                        <option value="binatang">Binatang Ciptaan Allah</option>
                    </select>
                </div>
                <div class="ff">
                    <label>Sub Tema</label>
                    <select id="selectSubTema">
                        <option>Pilih tema dulu</option>
                    </select>
                </div>
                <div class="ff">
                    <label>Minggu Ke</label>
                    <input type="number" min="1" max="17" placeholder="1-17" />
                </div>
            </div>
            <div class="fr c2">
                <div class="ff">
                    <label>Model Pembelajaran</label>
                    <select>
                        <option>Berbasis Proyek</option>
                        <option>Kelompok dengan Sudut</option>
                        <option>Sentra</option>
                        <option>Area</option>
                        <option>STEM</option>
                    </select>
                </div>
                <div class="ff">
                    <label>Tahun Ajaran</label>
                    <input value="2024/2025" disabled />
                </div>
            </div>
            <div class="fr">
                <div class="ff">
                    <label>Tujuan Pembelajaran</label>
                    <textarea rows="2" placeholder="Tujuan pembelajaran minggu ini..."></textarea>
                </div>
            </div>
            <div class="fr">
                <div class="ff">
                    <label>Capaian Pembelajaran</label>
                    <textarea rows="2" placeholder="Capaian yang diharapkan..."></textarea>
                </div>
            </div>

            <div class="dv"></div>
            <div class="fs11 tc2 mb16" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">B. Kegiatan Per
                Hari</div>
            <div class="al alw mb16">⚠️ Aspek belum terstimulasi: <strong>🎨 Seni</strong>, <strong>❤️ Sosial
                    Emosional</strong></div>

            <div class="dt">
                <div class="dtb on">Senin (2)</div>
                <div class="dtb fl">Selasa (1)</div>
                <div class="dtb">Rabu (0)</div>
                <div class="dtb fl">Kamis (2)</div>
                <div class="dtb">Jumat (0)</div>
            </div>

            <div class="ds">
                <div class="dsh">
                    <span class="dn">📅 Senin</span>
                    <button class="btn bp bxs" onclick="document.getElementById('mPilihKeg').classList.add('on')">+ Pilih
                        Kegiatan</button>
                </div>
                <div class="dki">
                    <div>
                        <strong>Menebalkan Nama Sendiri</strong> <span class="fs11 tc2">(Menggambar)</span>
                        <div class="mt8"><span class="ap a3">🧠 Kognitif</span> <span class="ap a4">💬 Bahasa</span>
                        </div>
                    </div>
                    <button class="btn bd bxs">✕</button>
                </div>
                <div class="dki">
                    <div>
                        <strong>Finger Painting Anggota Tubuh</strong> <span class="fs11 tc2">(Finger Painting)</span>
                        <div class="mt8"><span class="ap a2">🏃 Fisik Motorik</span> <span class="ap a6">🎨
                                Seni</span></div>
                    </div>
                    <button class="btn bd bxs">✕</button>
                </div>
            </div>

            <div class="dv"></div>
            <div class="fs11 tc2 mb16" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">C. Analisis
                Aspek Real-time</div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:10px">
                <div class="card" style="padding:12px">
                    <div class="fl jb ic mb8"><span class="ap a1">🕌 Nilai Agama</span><strong
                            style="font-size:18px;color:var(--g6)">2</strong></div>
                    <div class="pw">
                        <div class="pb gr" style="width:80%"></div>
                    </div>
                </div>
                <div class="card" style="padding:12px">
                    <div class="fl jb ic mb8"><span class="ap a2">🏃 Fisik Motorik</span><strong
                            style="font-size:18px;color:var(--g6)">3</strong></div>
                    <div class="pw">
                        <div class="pb bl" style="width:100%"></div>
                    </div>
                </div>
                <div class="card" style="padding:12px">
                    <div class="fl jb ic mb8"><span class="ap a3">🧠 Kognitif</span><strong
                            style="font-size:18px;color:var(--g6)">2</strong></div>
                    <div class="pw">
                        <div class="pb ye" style="width:60%"></div>
                    </div>
                </div>
                <div class="card" style="padding:12px">
                    <div class="fl jb ic mb8"><span class="ap a4">💬 Bahasa</span><strong
                            style="font-size:18px;color:var(--g6)">1</strong></div>
                    <div class="pw">
                        <div class="pb gr" style="width:40%"></div>
                    </div>
                </div>
                <div class="card" style="padding:12px;border-color:#fecaca">
                    <div class="fl jb ic mb8"><span class="ap a5">❤️ Sosial Emosional</span><strong
                            style="font-size:18px;color:var(--red)">0</strong></div>
                    <div class="pw">
                        <div class="pb pk" style="width:0%"></div>
                    </div>
                    <div class="fs11 mt8" style="color:var(--red)">⚠️ Belum ada</div>
                </div>
                <div class="card" style="padding:12px;border-color:#fecaca">
                    <div class="fl jb ic mb8"><span class="ap a6">🎨 Seni</span><strong
                            style="font-size:18px;color:var(--red)">0</strong></div>
                    <div class="pw">
                        <div class="pb or" style="width:0%"></div>
                    </div>
                    <div class="fs11 mt8" style="color:var(--red)">⚠️ Belum ada</div>
                </div>
            </div>

            <div class="dv"></div>
            <div class="fl jb g12">
                <button class="btn bo">🔄 Reset</button>
                <div class="fl g12">
                    <button class="btn bo" onclick="showToast('💾 Draft tersimpan')">💾 Simpan Draft</button>
                    <button class="btn ba" onclick="showToast('📤 RPPM diajukan ke Kepala Sekolah')">📤 Ajukan ke Kepala
                        Sekolah</button>
                </div>
            </div>
        </div>
    </div> --}}

    <div id="panel-baru" style="display:none">
        <div class="card">
            <div class="ch mb16">
                <div class="ct">📝 Form RPPM Baru</div>
            </div>

            <form id="formBuatRppm">

                {{-- A. Identitas --}}
                <div class="fs11 tc2 mb12" style="text-transform:uppercase;letter-spacing:1px;font-weight:700">
                    A. Identitas
                </div>

                <div class="fr c3">
                    <div class="ff">
                        <label>Tahun Ajaran</label>
                        <select id="inputTaRppm" name="tahun_ajaran_id">
                            @foreach ($taList as $ta)
                                <option value="{{ $ta->id }}" {{ $ta->active ? 'selected' : '' }}>
                                    {{ $ta->name }} - Sem {{ $ta->semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ff">
                        <label>Tema</label>
                        <select id="inputTemaRppm">
                            <option value="">-- Pilih Tema --</option>
                            @foreach ($temas as $tema)
                                <option value="{{ $tema->id }}">
                                    {{ $tema->name }} (Sem {{ $tema->semester }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ff">
                        <label>Sub Tema</label>
                        <select id="inputSubTemaRppm" name="sub_tema_id" disabled>
                            <option value="">-- Pilih Tema Dulu --</option>
                        </select>
                    </div>
                </div>

                <div class="fr c2">
                    <div class="ff">
                        <label>Model Pembelajaran</label>
                        <select id="inputModelRppm" name="model_pembelajaran">
                            <option value="">-- Pilih Model --</option>
                            @foreach ($modelList as $model)
                                <option value="{{ $model }}">{{ $model }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ff">
                        <label>Minggu Ke</label>
                        <input id="inputMingguRppm" name="minggu_ke" type="number" min="1" max="34"
                            placeholder="1 – 34" />
                    </div>
                </div>

                <div class="fr">
                    <div class="ff">
                        <label>Tujuan Pembelajaran</label>
                        <textarea id="inputTujuanRppm" name="tujuan" rows="2" placeholder="Anak dapat mengenal... melalui kegiatan..."></textarea>
                    </div>
                </div>

                <div class="fr">
                    <div class="ff">
                        <label>Capaian Pembelajaran</label>
                        <textarea id="inputCapaianRppm" name="capaian" rows="2" placeholder="Anak mampu..."></textarea>
                    </div>
                </div>

                <div id="errorBuatRppm" class="al ale" style="display:none"></div>

                <div class="dv"></div>
                <div class="fl jb">
                    <button type="button" class="btn bo" id="btnResetRppm">🔄 Reset</button>
                    <button type="submit" class="btn bp">💾 Simpan sebagai Draft</button>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- @push('scripts')
    <script>
        $(function() {
            var subTemaData = {
                aku: ['Allah Tuhanku', 'Identitasku', 'Tubuhku / Aurat', 'Panca Indra'],
                tanah: ['Identitas Negara', 'Hari Besar Nasional', 'Lambang Negara', 'Elemen Bangsa / Budaya'],
                lingkungan: ['Rumahku', 'Keluargaku', 'Masjidku', 'Sekolahku'],
                binatang: ['Binatang Halal/Haram', 'Binatang Qurban', 'Binatang Buas', 'Serangga',
                    'Binatang Air & Udara'
                ]
            };

            $('#selectTema').on('change', function() {
                var val = $(this).val();
                var $sel = $('#selectSubTema').empty();

                if (!val) {
                    $sel.append($('<option>').text('Pilih tema dulu'));
                    return;
                }

                $.each(subTemaData[val] || [], function(i, st) {
                    $sel.append($('<option>').text(st));
                });
            });

            function switchRppmTab(tab) {
                $('#panel-daftar').toggle(tab === 'daftar');
                $('#panel-baru').toggle(tab === 'baru');
                $('#tab-btn-daftar').toggleClass('on', tab === 'daftar');
                $('#tab-btn-baru').toggleClass('on', tab === 'baru');
            }

            $('#tab-btn-daftar').on('click', function() {
                switchRppmTab('daftar');
            });
            $('#tab-btn-baru').on('click', function() {
                switchRppmTab('baru');
            });

            $(document).on('click', '.dt .dtb', function() {
                $('.dt .dtb').removeClass('on');
                $(this).addClass('on');
            });

        });
    </script>
@endpush --}}

@push('scripts')
    <script>
        function switchTab(tab) {
            $('#panel-daftar').toggle(tab === 'daftar');
            $('#panel-baru').toggle(tab === 'baru');
            $('#tab-btn-daftar').toggleClass('on', tab === 'daftar');
            $('#tab-btn-baru').toggleClass('on', tab === 'baru');
        }

        $('#tab-btn-daftar').on('click', function() {
            switchTab('daftar');
        });
        $('#tab-btn-baru').on('click', function() {
            switchTab('baru');
        });

        var temaData = {
            @foreach ($temas as $tema)
                {{ $tema->id }}: [
                    @foreach ($tema->subTemas as $sub)
                        {
                            id: {{ $sub->id }},
                            name: "{{ $sub->name }}"
                        },
                    @endforeach
                ],
            @endforeach
        };

        $('#inputTemaRppm').on('change', function() {
            var temaId = $(this).val();
            var $sub = $('#inputSubTemaRppm');

            if (!temaId) {
                $sub.html('<option value="">-- Pilih Tema Dulu --</option>').prop('disabled', true);
                return;
            }

            var subs = temaData[temaId] || [];
            var options = '<option value="">-- Pilih Sub Tema --</option>';
            $.each(subs, function(i, s) {
                options += '<option value="' + s.id + '">' + s.name + '</option>';
            });
            $sub.html(options).prop('disabled', false);
        });

        $('#btnResetRppm').on('click', function() {
            $('#formBuatRppm')[0].reset();
            $('#inputSubTemaRppm').html('<option value="">-- Pilih Tema Dulu --</option>').prop('disabled', true);
            $('#errorBuatRppm').hide().text('');
        });

        $('#formBuatRppm').on('submit', function(e) {
            e.preventDefault();

            $.post('{{ route('rppm.store') }}', {
                    tahun_ajaran_id: $('#inputTaRppm').val(),
                    sub_tema_id: $('#inputSubTemaRppm').val(),
                    minggu_ke: $('#inputMingguRppm').val(),
                    model_pembelajaran: $('#inputModelRppm').val(),
                    tujuan: $('#inputTujuanRppm').val(),
                    capaian: $('#inputCapaianRppm').val(),
                    _token: '{{ csrf_token() }}',
                })
                .done(function(res) {
                    showToast('💾 RPPM berhasil dibuat sebagai draft');
                    // Langsung arahkan ke halaman edit kegiatan RPPM
                    setTimeout(function() {
                        window.location.href = '/rppm/' + res.rppm_id;
                    }, 600);
                })
                .fail(function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var pesan = Object.values(errors).flat().join('<br>');
                    $('#errorBuatRppm').html(pesan).show();
                });
        });

        $(document).on('click', '.btn-ajukan-rppm', function() {
            var id = $(this).data('id');
            if (!confirm('Ajukan RPPM ini ke Kepala Sekolah?')) return;

            $.ajax({
                    url: '/rppm/' + id + '/ajukan',
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
    </script>
@endpush
