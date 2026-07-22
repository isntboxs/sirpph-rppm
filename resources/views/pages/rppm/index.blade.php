@extends('layout.app')

@section('page-title', Auth::user()->isAdmin() ? 'Administrasi RPP' : 'Buat RPP')
@section('page-subtitle', 'Daftar RPP Mingguan')

@section('content')

    <div class="card" style="margin-bottom: 20px;">
        <div class="cb" style="padding: 20px;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <h3 style="margin:0; font-size:18px; color:var(--txt)">Daftar RPP Semester {{ $semesterLabel }} {{ $taAktif?->name ?? '-' }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="rpp-index-layout" style="display: flex; gap: 20px; align-items: flex-start;">
        @if (Auth::user()->isAdmin())
            <div class="main-rpp-container" style="flex: 1; display:flex; flex-direction:column; gap:15px; width: 100%;">
                @foreach($gurus as $guru)
                    @php
                        $rppms = $rppmsGrouped[$guru->id] ?? collect();
                    @endphp
                    <div class="card" style="margin-bottom:0;">
                        <div class="ch" style="cursor:pointer; display:flex; justify-content:space-between; align-items:center;" onclick="toggleRppmAccordion({{ $guru->id }}, this)">
                            <div class="ct" style="font-size:16px;">
                                {{ $guru->name }} - {{ $guru->kelas->name ?? 'Belum ada kelas' }}
                            </div>
                            <div class="accordion-icon" style="transition: transform 0.3s; transform: rotate(-90deg);">▼</div>
                        </div>
                        <div id="rppm-guru-{{ $guru->id }}" class="tw" style="display: none;">
                            <table style="width:100%; border-top:1px solid #eee;">
                                <thead>
                                    <tr>
                                        <th>Minggu</th>
                                        <th>Tema Utama</th>
                                        <th>Sub-Tema</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sortedRppms = $rppmsGrouped[$guru->id]->sortBy(function($r) {
                                            return $r->subTema ? $r->subTema->tema_id . '-' . str_pad($r->subTema->minggu_ke, 3, '0', STR_PAD_LEFT) : '999';
                                        })->values();
                                    @endphp
                                    @forelse ($sortedRppms as $index => $rppm)
                                        <tr>
                                            <td style="font-weight:600">Minggu {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $rppm->subTema && $rppm->subTema->tema ? $rppm->subTema->tema->name : 'Belum diatur' }}</td>
                                            <td>{{ $rppm->subTema ? $rppm->subTema->name : '-' }}</td>
                                            <td>
                                                <span class="bdg {{ $rppm->status_badge_class }}">
                                                    {{ $rppm->status_label }}
                                                </span>
                                                @if ($rppm->status === 'dikembalikan')
                                                    <span class="btn-catatan-kepala blink-warning" data-catatan="{{ $rppm->catatan_kepala }}" title="Lihat Alasan Revisi">⚠️</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('rppm.show', $rppm->id) }}" class="btn bo bsm">👁️ Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" style="text-align: center; color: var(--txt3); padding: 20px;">Belum ada RPP yang dibuat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
            
        @else
            <div class="main-rpp-container" style="flex: 1; display:flex; flex-direction:column; gap:15px; width: 100%;">
                @php
                    $sortedRppms = $rppms->sortBy(function($r) {
                        return $r->subTema ? $r->subTema->tema_id . '-' . str_pad($r->subTema->minggu_ke, 3, '0', STR_PAD_LEFT) : '999';
                    })->values();
                    
                    $groupedRppms = $sortedRppms->groupBy(function($r) {
                        return $r->subTema && $r->subTema->tema ? $r->subTema->tema->name : 'Belum diatur';
                    });
                @endphp
                
                @forelse($groupedRppms as $temaName => $rppmsInTema)
                    <div class="card" style="margin-bottom:0;">
                        <div class="ch" style="cursor:pointer; display:flex; justify-content:space-between; align-items:center;" onclick="toggleRppmAccordion('tema_{{ \Illuminate\Support\Str::slug($temaName) }}', this)">
                            <div class="ct" style="font-size:16px;">
                                Tema: {{ $temaName }}
                            </div>
                            <div class="accordion-icon" style="transition: transform 0.3s; transform: rotate(-90deg);">▼</div>
                        </div>
                        <div id="rppm-guru-tema_{{ \Illuminate\Support\Str::slug($temaName) }}" class="tw" style="display: none;">
                            <table style="width:100%; border-top:1px solid #eee;">
                                <thead>
                                    <tr>
                                        <th>Minggu</th>
                                        <th>Tema Utama</th>
                                        <th>Sub-Tema</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rppmsInTema as $index => $rppm)
                                        <tr>
                                            <td style="font-weight:600">Minggu {{ str_pad($rppm->subTema ? $rppm->subTema->minggu_ke : ($index+1), 2, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $temaName }}</td>
                                            <td>{{ $rppm->subTema ? $rppm->subTema->name : '-' }}</td>
                                            <td>
                                                <span class="bdg {{ $rppm->status_badge_class }}">
                                                    {{ $rppm->status_label }}
                                                </span>
                                                @if ($rppm->status === 'dikembalikan')
                                                    <span class="btn-catatan-kepala blink-warning" data-catatan="{{ $rppm->catatan_kepala }}" title="Lihat Alasan Revisi">⚠️</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (in_array($rppm->status, ['draft', 'dikembalikan']))
                                                    <a href="{{ route('rppm.show', $rppm->id) }}" class="btn bp bsm">✏️ Isi RPP</a>
                                                @else
                                                    <a href="{{ route('rppm.show', $rppm->id) }}" class="btn bo bsm">👁️ Detail</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="card" style="margin-bottom:0;">
                        <div class="cb" style="text-align: center; color: var(--txt3); padding: 20px;">
                            Belum ada RPP yang dibuat.
                        </div>
                    </div>
                @endforelse
            </div>
            
        @endif
        <style>
            .blink-warning {
                    display: inline-block;
                    cursor: pointer;
                    animation: blinker 1.5s linear infinite;
                    font-size: 16px;
                    margin-left: 5px;
                }
                @keyframes blinker {
                    50% { opacity: 0.3; }
                }
                @media (max-width: 768px) {
                    .rpp-index-layout {
                        flex-direction: column-reverse; /* Move sidebar to top */
                    }
                    .rpp-index-sidebar {
                        width: 100% !important;
                        flex-direction: row !important;
                        flex-wrap: wrap;
                        gap: 10px !important;
                    }
                    .rpp-index-sidebar > .card {
                        width: calc(50% - 5px) !important;
                        margin-bottom: 0 !important;
                    }
                    .rpp-index-sidebar > .card .cb {
                        font-size: 11px !important;
                    }
                    .rpp-index-sidebar > button {
                        width: 100% !important;
                    }
                    .main-rpp-container > .card {
                        padding: 0 !important;
                        background: transparent !important;
                        box-shadow: none !important;
                    }
                }
            </style>
        
        <div class="rpp-index-sidebar" style="width: 280px; flex-shrink: 0; display:flex; flex-direction:column; gap:20px;">
            <div class="card">
                <div class="ch mb12">
                    <div class="ct">Panduan Pengisian</div>
                </div>
                <div class="cb" style="font-size:13px; color:var(--txt2); line-height:1.5;">
                    Silakan isi RPP sesuai dengan panduan mingguan yang ada. Pastikan semua kegiatan relevan dengan tema dan disetujui Kepala Sekolah.
                </div>
            </div>
            
            @if(!Auth::user()->isAdmin())
            <div class="card">
                <div class="ch mb12">
                    <div class="ct">Status Progres</div>
                </div>
                <div class="cb">
                    <div style="font-size:12px; color:var(--txt2); margin-bottom:5px;">RPP Selesai ({{ $rppmTerisi ?? 0 }} dari 17)</div>
                    <div style="width:100%; height:10px; background:var(--g1); border-radius:5px; overflow:hidden;">
                        <div style="width: {{ (($rppmTerisi ?? 0) / 17) * 100 }}%; height:100%; background:var(--primary);"></div>
                    </div>
                </div>
            </div>
            @endif
            
            <button class="btn bo" style="width:100%; justify-content:center;" onclick="window.print()">Cetak Semua RPP</button>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).on('click', '.btn-catatan-kepala', function() {
        var catatan = $(this).data('catatan');
        Swal.fire({
            title: 'Catatan Revisi dari Kepala Sekolah',
            text: catatan,
            icon: 'warning',
            confirmButtonColor: '#1f2937'
        });
    });

    $(document).on('click', '.btn-hapus-rppm', function() {
        var id = $(this).data('id');
        var info = $(this).data('info');

        window.confirmAction('Hapus RPP ini?\n\n' + info + '\n\nSemua detail akan terhapus.', function() {
            $.ajax({
                    url: '/rppm/' + id,
                    type: 'DELETE',
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
    });

    // Make the first accordion open by default
    $(document).ready(function() {
        var firstAccordion = $('.tw').first();
        if(firstAccordion.length > 0 && firstAccordion.attr('id') && firstAccordion.attr('id').startsWith('rppm-guru-')) {
            firstAccordion.show();
            firstAccordion.prev('.ch').find('.accordion-icon').css('transform', 'rotate(0deg)');
        }
    });

    function toggleRppmAccordion(id, el) {
        var target = $('#rppm-guru-' + id);
        var icon = $(el).find('.accordion-icon');
        
        target.slideToggle(300, function() {
            if(target.is(':visible')) {
                icon.css('transform', 'rotate(0deg)');
            } else {
                icon.css('transform', 'rotate(-90deg)');
            }
        });
    }
</script>
@endpush
