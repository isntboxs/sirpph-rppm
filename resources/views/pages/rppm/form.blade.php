@extends('layout.app')

@section('page-title', 'Buat RPP')
@section('page-subtitle', 'Rencana Pelaksanaan Pembelajaran')

@section('content')
@php
    $isAdmin = Auth::user()->isAdmin();
    $guruId = old('guru_id', $rppm->guru_id ?? ($isAdmin ? '' : Auth::id()));
    $kelasNama = '-';
    $semester = $taAktif->semester == 1 ? 'Ganjil' : 'Genap';
    $isEditableStatus = !$rppm->id || in_array($rppm->status, ['draft', 'dikembalikan']);
    $canEdit = $isAdmin || (Auth::user()->role === 'guru' && $isEditableStatus && (!$rppm->id || $rppm->guru_id === Auth::id()));
    
    if (!$isAdmin) {
        $kelasNama = Auth::user()->kelas->name ?? '-';
    } else {
        if ($guruId) {
            $selectedGuru = $gurus->firstWhere('id', $guruId);
            $kelasNama = $selectedGuru->kelas->name ?? '-';
        }
    }
@endphp

<style>
    /* Reset and override container styles to match the plain look in the screenshot */
    .rpp-container {
        background-color: #ffffff;
        padding: 40px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
        margin: -24px; /* offset the .ca padding if any */
        min-height: 100vh;
    }
    .rpp-section-title {
        font-size: 14px;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 25px;
        margin-top: 35px;
        text-transform: uppercase;
    }
    .rpp-section-title:first-child {
        margin-top: 0;
    }
    .rpp-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        column-gap: 80px;
        row-gap: 20px;
    }
    .rpp-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 5px;
    }
    .rpp-group.full {
        grid-column: 1 / -1;
    }
    .rpp-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
    }
    .rpp-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #9ca3af;
        border-radius: 2px;
        font-size: 13px;
        color: #374151;
        background-color: #fff;
        outline: none;
    }
    .rpp-input:focus {
        border-color: #4b5563;
    }
    .rpp-input[disabled], .rpp-input.readonly {
        background-color: #dcfce7; /* Greenish background as seen in the picture */
        color: #4b5563;
        border-color: #9ca3af;
    }
    textarea.rpp-input {
        resize: vertical;
        min-height: 80px;
    }
    
    .rpp-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 50px;
        padding-top: 20px;
    }
    .rpp-footer-left {
        display: flex;
        gap: 15px;
    }
    .rpp-btn {
        padding: 8px 16px;
        font-size: 13px;
        font-weight: normal;
        border-radius: 4px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }
    .rpp-btn-outline {
        background-color: #fff;
        border: 1px solid #d1d5db;
        color: #374151;
    }
    .rpp-btn-outline:hover {
        background-color: #f9fafb;
    }
    .rpp-btn-dark {
        background-color: #1f2937;
        border: 1px solid #1f2937;
        color: #fff;
    }
    .rpp-btn-dark:hover {
        background-color: #111827;
    }
    .rpp-btn-greyed {
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        color: #9ca3af;
        cursor: not-allowed;
    }
    .blink-warning {
        animation: blinker 1.5s linear infinite;
    }
    @keyframes blinker {
        50% { opacity: 0.3; }
    }
    
    @media (max-width: 768px) {
        .rpp-container {
            padding: 20px;
            margin: -16px;
        }
        .rpp-grid {
            grid-template-columns: 1fr;
            column-gap: 0;
            row-gap: 15px;
        }
        .rpp-footer {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
            margin-top: 30px;
        }
        .rpp-footer-left {
            flex-direction: column;
            width: 100%;
        }
        .rpp-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="rpp-container">
    <form action="{{ $rppm->id ? route('rppm.update', $rppm->id) : route('rppm.store') }}" method="POST">
        @csrf
        @if ($rppm->id)
            @method('PUT')
        @endif
        
        @if ($errors->any())
            <div style="background-color: #fee2e2; border: 1px solid #f87171; color: #b91c1c; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <strong style="display: block; margin-bottom: 5px;">Terjadi Kesalahan!</strong>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <input type="hidden" name="tahun_ajaran_id" value="{{ $taAktif->id }}">
        
        <div class="rpp-section-title">IDENTITAS RPP</div>
        
        @if($rppm->status === 'dikembalikan' && $rppm->catatan_kepala)
            <div style="background-color: #fef3c7; border: 1px solid #f59e0b; color: #b45309; padding: 15px; border-radius: 4px; margin-bottom: 25px; display: flex; align-items: flex-start; gap: 10px;">
                <span class="blink-warning" style="font-size: 20px;">⚠️</span>
                <div>
                    <strong style="display: block; font-size: 14px; margin-bottom: 4px;">RPP Dikembalikan oleh Kepala Sekolah</strong>
                    <div style="font-size: 13px;">{{ $rppm->catatan_kepala }}</div>
                </div>
            </div>
        @endif
        
        <div class="rpp-grid">
            <!-- Row 1 -->
            <div class="rpp-group">
                <label class="rpp-label">Nama Guru</label>
                <input type="text" class="rpp-input readonly" value="{{ $rppm->guru->name ?? Auth::user()->name }}" readonly>
                <input type="hidden" name="guru_id" value="{{ $rppm->guru_id }}">
            </div>
            <div class="rpp-group">
                <label class="rpp-label">Kelas</label>
                <input type="text" class="rpp-input readonly" id="kelas_nama" value="{{ $kelasNama }}" readonly>
            </div>
            
            <!-- Row 2 -->
            <div class="rpp-group">
                <label class="rpp-label">Tema</label>
                <input type="text" class="rpp-input readonly" value="{{ $rppm->subTema->tema->name ?? '-' }}" readonly>
                <input type="hidden" name="tema_id" value="{{ $rppm->subTema->tema_id ?? '' }}">
            </div>
            <div class="rpp-group">
                <label class="rpp-label">Sub Tema</label>
                <input type="text" class="rpp-input readonly" value="{{ $rppm->subTema->name ?? '-' }}" readonly>
                <input type="hidden" name="sub_tema_id" value="{{ $rppm->sub_tema_id }}">
            </div>
            
            <!-- Row 3 -->
            <div class="rpp-group">
                <label class="rpp-label">Minggu Ke</label>
                <input type="number" class="rpp-input readonly" name="minggu_ke" value="{{ $rppm->minggu_ke }}" readonly>
            </div>
            <div class="rpp-group">
                <label class="rpp-label">Tahun Ajaran</label>
                <input type="text" class="rpp-input readonly" value="{{ $taAktif->name }}" readonly>
            </div>
            
            <!-- Row 4 -->
            <div class="rpp-group">
                <label class="rpp-label">Hari/Tanggal</label>
                <input type="date" class="rpp-input" name="tanggal_dibuat" value="{{ $rppm->tanggal_dibuat ? \Carbon\Carbon::parse($rppm->tanggal_dibuat)->format('Y-m-d') : date('Y-m-d') }}" required {{ $canEdit ? '' : 'disabled' }}>
            </div>
            <div class="rpp-group">
                <label class="rpp-label">Semester</label>
                <input type="text" class="rpp-input readonly" value="{{ $semester }}" readonly>
            </div>
            
            <!-- Row 5 -->
            <div class="rpp-group">
                <label class="rpp-label">Tujuan Pembelajaran</label>
                <textarea class="rpp-input" name="tujuan" {{ $canEdit ? '' : 'disabled' }}>{{ old('tujuan', $rppm->tujuan) }}</textarea>
            </div>
            <div class="rpp-group">
                <label class="rpp-label">Capaian Pembelajaran</label>
                <textarea class="rpp-input" name="capaian" {{ $canEdit ? '' : 'disabled' }}>{{ old('capaian', $rppm->capaian) }}</textarea>
            </div>
        </div>
        
        <div class="rpp-section-title">ISI KEGIATAN</div>
        
        <div style="display:flex; flex-direction:column; gap:25px;">
            <div class="rpp-group full">
                <label class="rpp-label">A. Kegiatan Pembuka (SOP Pembukaan, Doa)</label>
                <textarea class="rpp-input" name="kegiatan_pembuka" {{ $canEdit ? '' : 'disabled' }}>{{ old('kegiatan_pembuka', $rppm->kegiatan_pembuka) }}</textarea>
            </div>
            <div class="rpp-group full">
                <label class="rpp-label">B. Kegiatan Inti</label>
                <textarea class="rpp-input" name="kegiatan_inti" {{ $canEdit ? '' : 'disabled' }}>{{ old('kegiatan_inti', $rppm->kegiatan_inti) }}</textarea>
            </div>
            <div class="rpp-group full">
                <label class="rpp-label">C. Recalling</label>
                <textarea class="rpp-input" name="recalling" {{ $canEdit ? '' : 'disabled' }}>{{ old('recalling', $rppm->recalling) }}</textarea>
            </div>
            <div class="rpp-group full">
                <label class="rpp-label">D. Kegiatan Penutup</label>
                <textarea class="rpp-input" name="kegiatan_penutup" {{ $canEdit ? '' : 'disabled' }}>{{ old('kegiatan_penutup', $rppm->kegiatan_penutup) }}</textarea>
            </div>
            <div class="rpp-group full">
                <label class="rpp-label">E. Rencana Penilaian</label>
                <textarea class="rpp-input" name="rencana_penilaian" {{ $canEdit ? '' : 'disabled' }}>{{ old('rencana_penilaian', $rppm->rencana_penilaian) }}</textarea>
            </div>
        </div>
        
        <div class="rpp-footer">
            <div class="rpp-footer-left">
                <button type="button" class="rpp-btn rpp-btn-outline" onclick="history.back()">Kembali</button>
                @if ($canEdit && $isEditableStatus)
                    <button type="submit" name="action" value="draft" class="rpp-btn rpp-btn-outline">Simpan Draft</button>
                    <button type="button" value="ajukan" data-confirm-msg="Simpan dan langsung ajukan RPP ini ke Kepala Sekolah?" class="rpp-btn rpp-btn-dark btn-confirm-submit">Ajukan ke Kepala Sekolah</button>
                @endif
            </div>
            
            <div>
                @if ($rppm->id && $rppm->status === 'disetujui')
                    <a href="{{ route('cetak.rppm', $rppm->id) }}" target="_blank" class="rpp-btn rpp-btn-outline">
                        <span style="display:inline-block; width:12px; height:12px; background:#374151; margin-right:6px;"></span> Cetak RPP
                    </a>
                @else
                    <button type="button" class="rpp-btn rpp-btn-greyed" disabled>
                        <span style="display:inline-block; width:12px; height:12px; background:#9ca3af; margin-right:6px;"></span> Cetak RPP
                    </button>
                @endif
            </div>
        </div>
    </form>
</div>

</script>
@endsection
