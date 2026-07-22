@extends('layout.app')

@section('page-title', 'Laporan RPP')
@section('page-subtitle', 'Dokumentasi Rencana Pelaksanaan Pembelajaran')

@section('content')
<style>
    .lr-container {
        background-color: #ffffff;
        padding: 40px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
        margin: -24px;
        min-height: 100vh;
    }
    
    .lr-header {
        border-left: 4px solid #111;
        padding-left: 15px;
        margin-bottom: 30px;
    }
    .lr-title {
        font-size: 24px;
        font-weight: bold;
        color: #111;
        margin: 0 0 5px 0;
    }
    .lr-subtitle {
        font-size: 13px;
        color: #666;
        margin: 0;
    }
    
    .lr-select-box {
        margin-bottom: 20px;
    }
    .lr-select-box select {
        width: 100%;
        max-width: 400px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .lr-info-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        border: 1px solid #111;
        margin-bottom: 40px;
    }
    .lr-info-cell {
        padding: 15px;
        border-right: 1px solid #111;
    }
    .lr-info-cell:last-child {
        border-right: none;
    }
    .lr-info-label {
        font-size: 10px;
        font-weight: bold;
        color: #666;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .lr-info-val {
        font-size: 14px;
        font-weight: bold;
        color: #111;
    }
    
    .lr-section-title {
        font-size: 18px;
        font-weight: bold;
        color: #111;
        margin-bottom: 20px;
    }
    
    .lr-content-box {
        border: 1px solid #ccc;
        padding: 25px;
        margin-bottom: 30px;
    }
    
    .lr-photo-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }
    .lr-photo-upload {
        border: 2px dashed #333;
        height: 220px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .lr-photo-upload:hover {
        background: #f9f9f9;
    }
    .lr-photo-upload input[type="file"] {
        display: none;
    }
    .lr-upload-placeholder {
        text-align: center;
        pointer-events: none;
    }
    .lr-photo-icon {
        font-size: 32px;
        margin-bottom: 15px;
        color: #333;
    }
    .lr-photo-text {
        font-size: 12px;
        color: #666;
    }
    .lr-photo-title {
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #111;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .lr-add-more-btn {
        font-size: 11px;
        background: #f4f4f4;
        border: 1px solid #ccc;
        padding: 4px 8px;
        cursor: pointer;
        border-radius: 4px;
    }
    
    .blink-warning {
        animation: blinker 1.5s linear infinite;
    }
    @keyframes blinker {
        50% { opacity: 0.3; }
    }

    /* Slider Styles */
    .lr-slider {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: #000;
        z-index: 5;
    }
    .lr-slider-images {
        display: flex;
        width: 100%;
        height: 100%;
        transition: transform 0.3s ease;
    }
    .lr-slider-images img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        flex-shrink: 0;
    }
    .lr-slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.6);
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 20;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    .lr-slider-btn:hover {
        background: rgba(0,0,0,0.8);
    }
    .lr-slider-prev { left: 10px; }
    .lr-slider-next { right: 10px; }
    
    .lr-slider-dots {
        position: absolute;
        bottom: 10px;
        left: 0; width: 100%;
        display: flex;
        justify-content: center;
        gap: 6px;
        z-index: 20;
    }
    .lr-slider-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: rgba(255,255,255,0.4);
        transition: background 0.3s;
    }
    .lr-slider-dot.active {
        background: #fff;
    }
    
    .lr-form-group {
        margin-bottom: 25px;
    }
    .lr-label {
        font-size: 13px;
        font-weight: bold;
        color: #111;
        margin-bottom: 10px;
        display: block;
    }
    .lr-textarea {
        width: 100%;
        padding: 15px;
        border: 1px solid #ccc;
        min-height: 120px;
        resize: vertical;
        font-size: 13px;
        font-family: inherit;
        outline: none;
    }
    .lr-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ccc;
        font-size: 13px;
        font-family: inherit;
        outline: none;
    }
    
    .lr-footer {
        background: #f4f4f4;
        border: 1px solid #ddd;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .lr-footer-info {
        font-size: 12px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .lr-footer-actions {
        display: flex;
        gap: 15px;
    }
    .lr-btn {
        padding: 10px 25px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
    }
    .lr-btn-outline {
        background: #fff;
        border: 1px solid #333;
        color: #111;
    }
    .lr-btn-outline:hover {
        background: #f9f9f9;
    }
    .lr-btn-dark {
        background: #000;
        border: 1px solid #000;
        color: #fff;
    }
    .lr-btn-dark:hover {
        background: #222;
    }
    
    .lr-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    .lr-preview-item {
        position: relative;
        border: 1px solid #ccc;
        padding: 5px;
        background: #fff;
    }
    .lr-preview-item img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }
    .lr-preview-action {
        text-align: center;
        padding-top: 5px;
        font-size: 11px;
    }
    
    @media (max-width: 768px) {
        .lr-container {
            padding: 20px;
            margin: -16px;
        }
        .lr-info-grid {
            grid-template-columns: 1fr;
            border-bottom: none;
        }
        .lr-info-cell {
            border-right: none;
            border-bottom: 1px solid #111;
        }
        .lr-info-cell:last-child {
            border-bottom: 1px solid #111; /* Keep bottom border for the last cell if it's stacked */
        }
        .lr-photo-grid {
            grid-template-columns: 1fr;
        }
        .lr-footer {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }
        .lr-footer-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .lr-btn {
            width: 100%;
            justify-content: center;
        }
        .lr-select-box select {
            max-width: 100%;
        }
    }
</style>

<div class="lr-container">
    <form action="{{ $laporan->id ? route('laporan_rpp.update', $laporan->id) : route('laporan_rpp.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($laporan->id)
            @method('POST')
        @endif
        
        <div class="lr-header">
            <h1 class="lr-title">Laporan RPP</h1>
            <p class="lr-subtitle">Dokumentasi Rencana Pelaksanaan Pembelajaran</p>
        </div>
        
        @if ($laporan->status === 'dikembalikan')
            <div style="background-color: #fef3c7; border: 1px solid #f59e0b; color: #b45309; padding: 15px; border-radius: 4px; margin-bottom: 25px; display: flex; align-items: flex-start; gap: 10px;">
                <span class="blink-warning" style="font-size: 20px;">⚠️</span>
                <div>
                    <strong style="display: block; font-size: 14px; margin-bottom: 4px;">Laporan Dikembalikan oleh Kepala Sekolah</strong>
                    <div style="font-size: 13px;">{{ $laporan->catatan_kepala }}</div>
                </div>
            </div>
        @endif

        @if ($laporan->rppm && $laporan->rppm->status !== 'disetujui')
            <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 15px; border-radius: 4px; margin-bottom: 25px; display: flex; align-items: flex-start; gap: 10px;">
                <span style="font-size: 20px;">🚫</span>
                <div>
                    <strong style="display: block; font-size: 14px; margin-bottom: 4px;">Status: RPP Belum Disetujui</strong>
                    <div style="font-size: 13px;">Laporan ini tidak dapat diisi atau diedit karena RPP Mingguan (RPP) terkait belum divalidasi dan disetujui oleh Kepala Sekolah.</div>
                </div>
            </div>
        @endif

        <div class="lr-select-box">
            @if(!$laporan->id)
                <select name="rppm_id" id="rppm_id" required>
                    <option value="">-- Pilih RPP Mingguan --</option>
                    @foreach ($rppms as $rppm)
                        <option value="{{ $rppm->id }}" 
                            data-tema="{{ $rppm->subTema->tema->nama ?? $rppm->subTema->tema->name ?? '-' }}"
                            data-subtema="{{ $rppm->subTema->nama ?? $rppm->subTema->name ?? '-' }}"
                            data-kelompok="{{ Auth::user()->kelas->name ?? '-' }}"
                            data-semester="{{ $rppm->tahunAjaran->semester == 1 ? '1 (Ganjil)' : '2 (Genap)' }}"
                            data-ta="{{ $rppm->tahunAjaran->name ?? '-' }}"
                            {{ $laporan->rppm_id == $rppm->id ? 'selected' : '' }}
                        >
                            Minggu ke-{{ $rppm->minggu_ke }} - {{ $rppm->subTema->tema->nama ?? $rppm->subTema->tema->name ?? '-' }} ({{ $rppm->subTema->nama ?? $rppm->subTema->name ?? '-' }})
                        </option>
                    @endforeach
                </select>
            @else
                <input type="hidden" name="rppm_id" value="{{ $laporan->rppm_id }}">
                <div style="font-size:13px; color:#666; font-style:italic;">Sedang mengedit laporan untuk RPP Minggu ke-{{ $laporan->rppm->minggu_ke }}</div>
            @endif
        </div>

        <div class="lr-info-grid">
            <div class="lr-info-cell">
                <div class="lr-info-label">Tema</div>
                <div class="lr-info-val" id="val-tema">{{ $laporan->id ? ($laporan->rppm->subTema->tema->nama ?? $laporan->rppm->subTema->tema->name ?? '-') : '-' }}</div>
            </div>
            <div class="lr-info-cell">
                <div class="lr-info-label">Sub-Tema</div>
                <div class="lr-info-val" id="val-subtema">{{ $laporan->id ? ($laporan->rppm->subTema->nama ?? $laporan->rppm->subTema->name ?? '-') : '-' }}</div>
            </div>
            <div class="lr-info-cell">
                <div class="lr-info-label">Kelompok</div>
                <div class="lr-info-val" id="val-kelompok">{{ Auth::user()->kelas->name ?? '-' }}</div>
            </div>
            <div class="lr-info-cell">
                <div class="lr-info-label">Semester</div>
                <div class="lr-info-val" id="val-semester">{{ $laporan->id ? ($laporan->rppm->tahunAjaran->semester == 1 ? '1 (Ganjil)' : '2 (Genap)') : '-' }}</div>
            </div>
            <div class="lr-info-cell">
                <div class="lr-info-label">Tahun Ajaran</div>
                <div class="lr-info-val" id="val-ta">{{ $laporan->id ? ($laporan->rppm->tahunAjaran->name ?? '-') : '-' }}</div>
            </div>
        </div>

        <div class="lr-section-title">Dokumentasi Kegiatan Mingguan</div>

        <div class="lr-content-box">
            @if (in_array($laporan->status, ['draft', 'dikembalikan']) || !$laporan->id)
                <!-- Tampilan Upload (Mode Edit) -->
                <div class="lr-photo-grid">
                    <div>
                        <div class="lr-photo-title">
                            <span>Foto Bersama Anak</span>
                            @if ($laporan->rppm && $laporan->rppm->status === 'disetujui')
                                <button type="button" class="lr-add-more-btn" onclick="document.getElementById('input-bersama').click()" style="display:none;" id="add-more-bersama">+ Ganti / Tambah</button>
                            @endif
                        </div>
                        <div class="lr-photo-upload" id="upload-bersama" onclick="if(!this.classList.contains('has-files') && {{ $laporan->rppm && $laporan->rppm->status === 'disetujui' ? 'true' : 'false' }}) document.getElementById('input-bersama').click()" style="{{ $laporan->rppm && $laporan->rppm->status !== 'disetujui' ? 'cursor:not-allowed; opacity:0.6;' : '' }}">
                            <input type="file" name="foto_bersama[]" multiple accept="image/*" class="photo-input" id="input-bersama" {{ $laporan->rppm && $laporan->rppm->status !== 'disetujui' ? 'disabled' : '' }}>
                            <div class="lr-upload-placeholder">
                                <div class="lr-photo-icon">📷</div>
                                <div class="lr-photo-text">Klik untuk upload dokumentasi kegiatan</div>
                            </div>
                            <div class="lr-slider" style="display:none;">
                                <div class="lr-slider-images"></div>
                                <button type="button" class="lr-slider-btn lr-slider-prev">❮</button>
                                <button type="button" class="lr-slider-btn lr-slider-next">❯</button>
                                <div class="lr-slider-dots"></div>
                            </div>
                        </div>
                        
                        <!-- Foto Tersimpan untuk Edit -->
                        @php
                            $fotoBersama = $laporan->fotos->filter(function($f) {
                                return in_array($f->jenis, ['bersama', null, '']);
                            });
                        @endphp
                        @if ($laporan->id && $fotoBersama->count() > 0)
                            <div style="margin-top:15px;">
                                <div class="lr-label" style="font-size:11px;">Tersimpan:</div>
                                <div class="lr-preview-grid">
                                    @foreach ($fotoBersama as $foto)
                                        <div class="lr-preview-item">
                                            <img src="{{ asset('storage/' . $foto->path) }}" style="height: 80px;">
                                            <div class="lr-preview-action">
                                                <label style="cursor:pointer; display:flex; align-items:center; justify-content:center; gap:5px; color:#d32f2f; font-weight:bold;">
                                                    <input type="checkbox" name="hapus_foto[]" value="{{ $foto->id }}"> Hapus
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="lr-photo-title">
                            <span>Foto Hasil Karya</span>
                            @if ($laporan->rppm && $laporan->rppm->status === 'disetujui')
                                <button type="button" class="lr-add-more-btn" onclick="document.getElementById('input-karya').click()" style="display:none;" id="add-more-karya">+ Ganti / Tambah</button>
                            @endif
                        </div>
                        <div class="lr-photo-upload" id="upload-karya" onclick="if(!this.classList.contains('has-files') && {{ $laporan->rppm && $laporan->rppm->status === 'disetujui' ? 'true' : 'false' }}) document.getElementById('input-karya').click()" style="{{ $laporan->rppm && $laporan->rppm->status !== 'disetujui' ? 'cursor:not-allowed; opacity:0.6;' : '' }}">
                            <input type="file" name="foto_karya[]" multiple accept="image/*" class="photo-input" id="input-karya" {{ $laporan->rppm && $laporan->rppm->status !== 'disetujui' ? 'disabled' : '' }}>
                            <div class="lr-upload-placeholder">
                                <div class="lr-photo-icon">🖌️</div>
                                <div class="lr-photo-text">Klik untuk upload hasil karya siswa</div>
                            </div>
                            <div class="lr-slider" style="display:none;">
                                <div class="lr-slider-images"></div>
                                <button type="button" class="lr-slider-btn lr-slider-prev">❮</button>
                                <button type="button" class="lr-slider-btn lr-slider-next">❯</button>
                                <div class="lr-slider-dots"></div>
                            </div>
                        </div>

                        <!-- Foto Tersimpan untuk Edit -->
                        @if ($laporan->id && $laporan->fotos->where('jenis', 'karya')->count() > 0)
                            <div style="margin-top:15px;">
                                <div class="lr-label" style="font-size:11px;">Tersimpan:</div>
                                <div class="lr-preview-grid">
                                    @foreach ($laporan->fotos->where('jenis', 'karya') as $foto)
                                        <div class="lr-preview-item">
                                            <img src="{{ asset('storage/' . $foto->path) }}" style="height: 80px;">
                                            <div class="lr-preview-action">
                                                <label style="cursor:pointer; display:flex; align-items:center; justify-content:center; gap:5px; color:#d32f2f; font-weight:bold;">
                                                    <input type="checkbox" name="hapus_foto[]" value="{{ $foto->id }}"> Hapus
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <!-- Tampilan Hanya Baca (Dipisah Kategori) -->
                @if ($laporan->fotos->count() > 0)
                    <div class="lr-photo-grid" style="margin-bottom:30px;">
                        <!-- Foto Bersama -->
                        <div>
                            <div class="lr-photo-title">Foto Bersama Anak</div>
                            @php
                                $fotoBersama = $laporan->fotos->filter(function($f) {
                                    return in_array($f->jenis, ['bersama', null, '']);
                                });
                            @endphp
                            @if ($fotoBersama->count() > 0)
                                <div class="lr-preview-grid" style="grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px;">
                                    @foreach ($fotoBersama as $foto)
                                        <div class="lr-preview-item" style="padding: 10px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer;"
                                             onclick="openLightbox('{{ asset('storage/' . $foto->path) }}')" title="Klik untuk memperbesar">
                                            <img src="{{ asset('storage/' . $foto->path) }}" style="height: 150px; border-radius: 4px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div style="padding: 20px; border: 1px dashed #ccc; text-align: center; color: #999; font-size: 13px;">Tidak ada foto.</div>
                            @endif
                        </div>
                        
                        <!-- Foto Karya -->
                        <div>
                            <div class="lr-photo-title">Foto Hasil Karya</div>
                            @if ($laporan->fotos->where('jenis', 'karya')->count() > 0)
                                <div class="lr-preview-grid" style="grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px;">
                                    @foreach ($laporan->fotos->where('jenis', 'karya') as $foto)
                                        <div class="lr-preview-item" style="padding: 10px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer;"
                                             onclick="openLightbox('{{ asset('storage/' . $foto->path) }}')" title="Klik untuk memperbesar">
                                            <img src="{{ asset('storage/' . $foto->path) }}" style="height: 150px; border-radius: 4px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div style="padding: 20px; border: 1px dashed #ccc; text-align: center; color: #999; font-size: 13px;">Tidak ada foto.</div>
                            @endif
                        </div>
                    </div>
                @endif
            @endif

            <div class="lr-form-group">
                <label class="lr-label">Keterangan Singkat</label>
                <textarea class="lr-textarea" name="keterangan_singkat" required placeholder="Tuliskan ringkasan singkat pelaksanaan kegiatan minggu ini..." {{ in_array($laporan->status, ['pending', 'disetujui']) || ($laporan->rppm && $laporan->rppm->status !== 'disetujui') ? 'disabled' : '' }}>{{ old('keterangan_singkat', $laporan->keterangan_singkat) }}</textarea>
            </div>

            <div class="lr-form-group">
                <label class="lr-label">Hari/Tanggal</label>
                <input type="date" class="lr-input" name="tanggal" value="{{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('Y-m-d') : date('Y-m-d') }}" required {{ in_array($laporan->status, ['pending', 'disetujui']) || ($laporan->rppm && $laporan->rppm->status !== 'disetujui') ? 'disabled' : '' }}>
            </div>
        </div>

        <div class="lr-footer">
            <div class="lr-footer-info">
                <span>ⓘ</span> Draft terakhir disimpan {{ $laporan->updated_at ? $laporan->updated_at->diffForHumans() : 'Belum pernah disimpan' }}
            </div>
            <div class="lr-footer-actions">
                @if (!$laporan->id || in_array($laporan->status, ['draft', 'dikembalikan']))
                    @if ($laporan->rppm && $laporan->rppm->status === 'disetujui')
                        <button type="submit" name="action" value="draft" class="lr-btn lr-btn-outline">Simpan Draft</button>
                        <button type="button" value="send" data-confirm-msg="Kirim laporan ini ke Kepala Sekolah?" class="lr-btn lr-btn-dark btn-confirm-submit">Kirim Laporan ▷</button>
                    @endif
                @endif
                @if (Auth::user()->isKepalaSekolah() && $laporan->status === 'pending')
                    <button type="button" class="lr-btn" style="background:#f59e0b; color:#fff; border:none;" onclick="showKembalikanModal()">Kembalikan Laporan</button>
                    <button type="button" class="lr-btn" style="background:#10b981; color:#fff; border:none;" onclick="setujuiLaporan()">Setujui Laporan</button>
                @endif
                
                @if (in_array($laporan->status, ['pending', 'disetujui']) || (Auth::user()->role !== 'guru'))
                    <a href="{{ Auth::user()->role === 'guru' ? route('laporan_rpp') : route('validasi_laporan') }}" class="lr-btn lr-btn-outline">Kembali</a>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- Modal Kembalikan (Khusus Kepsek di Halaman Detail) -->
@if(Auth::user()->isKepalaSekolah() && $laporan->status === 'pending')
<div class="mo" id="mKembalikanDetail">
    <div class="md msm">
        <div class="mh">
            <div>
                <div class="mt2">Kembalikan Laporan RPP</div>
            </div>
            <button type="button" class="mc" onclick="$('#mKembalikanDetail').removeClass('on')">✕</button>
        </div>
        <div class="mb">
            <div class="ff mb16">
                <label style="font-size:12px;font-weight:bold;display:block;margin-bottom:8px;">Alasan Pengembalian / Catatan Revisi:</label>
                <textarea id="catatanRevisi" class="in" rows="4" placeholder="Tuliskan catatan revisi untuk guru..." style="width:100%;"></textarea>
            </div>
            <button type="button" class="btn bo" style="background:#000; color:#fff; border:none; width: 100%;" onclick="submitKembalikan()">Kirim Catatan & Kembalikan</button>
        </div>
    </div>
</div>
@endif

<script>
    function openLightbox(url) {
        Swal.fire({
            imageUrl: url,
            imageAlt: 'Preview Dokumentasi',
            width: 'auto',
            showConfirmButton: false,
            showCloseButton: true,
            background: 'transparent',
            backdrop: 'rgba(0,0,0,0.9)',
            padding: '0',
            customClass: {
                image: 'swal2-image-preview'
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const rppmSelect = document.getElementById('rppm_id');
        if (rppmSelect) {
            rppmSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                if (selected.value) {
                    document.getElementById('val-tema').textContent = selected.getAttribute('data-tema');
                    document.getElementById('val-subtema').textContent = selected.getAttribute('data-subtema');
                    document.getElementById('val-kelompok').textContent = selected.getAttribute('data-kelompok');
                    document.getElementById('val-semester').textContent = selected.getAttribute('data-semester');
                    document.getElementById('val-ta').textContent = selected.getAttribute('data-ta');
                } else {
                    document.getElementById('val-tema').textContent = '-';
                    document.getElementById('val-subtema').textContent = '-';
                    document.getElementById('val-kelompok').textContent = '-';
                    document.getElementById('val-semester').textContent = '-';
                    document.getElementById('val-ta').textContent = '-';
                }
            });
        }
        
        // Logika Slider Upload Gambar
        const photoInputs = document.querySelectorAll('.photo-input');
        
        photoInputs.forEach(input => {
            input.addEventListener('change', function(e) {
                const container = this.closest('.lr-photo-upload');
                const placeholder = container.querySelector('.lr-upload-placeholder');
                const slider = container.querySelector('.lr-slider');
                const sliderImages = container.querySelector('.lr-slider-images');
                const sliderDots = container.querySelector('.lr-slider-dots');
                const btnPrev = container.querySelector('.lr-slider-prev');
                const btnNext = container.querySelector('.lr-slider-next');
                
                let addMoreBtnId = '';
                if(input.id === 'input-bersama') addMoreBtnId = 'add-more-bersama';
                if(input.id === 'input-karya') addMoreBtnId = 'add-more-karya';
                const addMoreBtn = document.getElementById(addMoreBtnId);
                
                const files = e.target.files;
                if (files && files.length > 0) {
                    
                    const maxSizePerFile = 5 * 1024 * 1024; // 5MB
                    let overSize = false;
                    
                    Array.from(files).forEach(file => {
                        if (file.size > maxSizePerFile) overSize = true;
                    });
                    
                    if (overSize) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ukuran Terlalu Besar',
                            text: 'Ukuran foto maksimal adalah 5MB per foto. Harap perkecil ukuran foto Anda.'
                        });
                        
                        this.value = ''; // Reset input
                        container.classList.remove('has-files');
                        if(addMoreBtn) addMoreBtn.style.display = 'none';
                        placeholder.style.display = 'block';
                        slider.style.display = 'none';
                        return;
                    }

                    // Opsional: Cek total ukuran dari SEMUA input file dalam form
                    let totalFormSize = 0;
                    document.querySelectorAll('.photo-input').forEach(inp => {
                        if (inp.files) {
                            Array.from(inp.files).forEach(f => totalFormSize += f.size);
                        }
                    });
                    
                    if (totalFormSize > 8 * 1024 * 1024) { // Batas maksimal 8MB
                        Swal.fire({
                            icon: 'warning',
                            title: 'Kapasitas Penuh',
                            text: 'Total ukuran semua foto melebihi batas 8MB! Silakan kurangi jumlah foto yang diunggah secara bersamaan.'
                        });
                        
                        this.value = '';
                        container.classList.remove('has-files');
                        if(addMoreBtn) addMoreBtn.style.display = 'none';
                        placeholder.style.display = 'block';
                        slider.style.display = 'none';
                        return;
                    }

                    container.classList.add('has-files');
                    if(addMoreBtn) addMoreBtn.style.display = 'block';
                    
                    // Bersihkan pratinjau sebelumnya
                    sliderImages.innerHTML = '';
                    sliderDots.innerHTML = '';
                    
                    placeholder.style.display = 'none';
                    slider.style.display = 'block';
                    
                    let currentIndex = 0;
                    
                    Array.from(files).forEach((file, index) => {
                        // Buat Gambar
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        sliderImages.appendChild(img);
                        
                        // Buat Titik (Dot)
                        const dot = document.createElement('div');
                        dot.className = `lr-slider-dot ${index === 0 ? 'active' : ''}`;
                        sliderDots.appendChild(dot);
                    });
                    
                    const updateSlider = () => {
                        sliderImages.style.transform = `translateX(-${currentIndex * 100}%)`;
                        const dots = sliderDots.querySelectorAll('.lr-slider-dot');
                        dots.forEach((d, i) => {
                            if (i === currentIndex) d.classList.add('active');
                            else d.classList.remove('active');
                        });
                        
                        // Sembunyikan tombol jika hanya ada 1 gambar
                        if (files.length <= 1) {
                            btnPrev.style.display = 'none';
                            btnNext.style.display = 'none';
                            sliderDots.style.display = 'none';
                        } else {
                            btnPrev.style.display = 'flex';
                            btnNext.style.display = 'flex';
                            sliderDots.style.display = 'flex';
                        }
                    };
                    
                    // Pembaruan awal
                    updateSlider();
                    
                    // Fungsi Maju & Mundur
                    // Hapus listener lama untuk menghindari duplikat jika pengguna memilih file beberapa kali
                    const newBtnPrev = btnPrev.cloneNode(true);
                    const newBtnNext = btnNext.cloneNode(true);
                    btnPrev.parentNode.replaceChild(newBtnPrev, btnPrev);
                    btnNext.parentNode.replaceChild(newBtnNext, btnNext);
                    
                    newBtnPrev.addEventListener('click', (ev) => {
                        ev.preventDefault();
                        ev.stopPropagation(); // cegah pembukaan dialog file
                        currentIndex = (currentIndex > 0) ? currentIndex - 1 : files.length - 1;
                        updateSlider();
                    });
                    
                    newBtnNext.addEventListener('click', (ev) => {
                        ev.preventDefault();
                        ev.stopPropagation();
                        currentIndex = (currentIndex < files.length - 1) ? currentIndex + 1 : 0;
                        updateSlider();
                    });
                    
                } else {
                    // Jika pengguna membatalkan, peramban akan menghapus file input
                    // Kembalikan tampilan ke kondisi awal (placeholder)
                    container.classList.remove('has-files');
                    if(addMoreBtn) addMoreBtn.style.display = 'none';
                    placeholder.style.display = 'block';
                    slider.style.display = 'none';
                }
            });
        });
    });
    
    @if(Auth::user()->isKepalaSekolah() && $laporan->status === 'pending')
    function showKembalikanModal() {
        $('#catatanRevisi').val('');
        $('#mKembalikanDetail').addClass('on');
    }
    
    function submitKembalikan() {
        var catatan = $('#catatanRevisi').val();
        if (!catatan) {
            Swal.fire({
                icon: 'warning',
                title: 'Catatan Kosong',
                text: 'Harap isi alasan pengembalian/catatan revisi.'
            });
            return;
        }
        
        var id = {{ $laporan->id ?? 0 }};
        
        $.ajax({
            url: '/validasi-laporan/' + id + '/kembalikan',
            type: 'PUT',
            data: { 
                _token: '{{ csrf_token() }}',
                catatan: catatan
            }
        }).done(function(res) {
            $('#mKembalikanDetail').removeClass('on');
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message
            }).then(() => {
                window.location.href = "{{ route('validasi_laporan') }}";
            });
        }).fail(function(xhr) {
            showToast('❌ Gagal mengembalikan laporan');
        });
    }
    
    function setujuiLaporan() {
        var id = {{ $laporan->id ?? 0 }};
        window.confirmAction('Apakah Anda yakin ingin menyetujui Laporan ini?', function() {
            $.ajax({
                url: '/validasi-laporan/' + id + '/setujui',
                type: 'PUT',
                data: { _token: '{{ csrf_token() }}' }
            }).done(function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message
                }).then(() => {
                    window.location.href = "{{ route('validasi_laporan') }}";
                });
            }).fail(function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal menyetujui';
                showToast('❌ ' + msg);
            });
        });
    }
    @endif
</script>
@endsection
