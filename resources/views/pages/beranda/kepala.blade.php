@extends('layout.app')

@section('page-title', 'Beranda')
@section('page-subtitle', ($sekolah->name ?? '-') . ' - ' . ($taAktif?->name ?? '-'))

@section('content')
<style>
@keyframes pulse-red {
    0% { opacity: 1; }
    50% { opacity: 0.3; }
    100% { opacity: 1; }
}
.pulse-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    background-color: #ef4444;
    border-radius: 50%;
    margin-right: 5px;
    animation: pulse-red 2s infinite ease-in-out;
}
.stat-box {
    background: var(--white);
    border: 1px solid var(--g2);
    border-radius: 8px;
    padding: 20px;
    box-shadow: var(--sh);
}
.stat-title {
    font-size: 14px;
    color: var(--txt2);
    font-weight: 600;
    margin-bottom: 5px;
}
.stat-value {
    font-size: 28px;
    font-weight: 800;
    color: var(--txt);
    margin-bottom: 10px;
}
.stat-pending {
    font-size: 12px;
    color: #ef4444;
    font-weight: 600;
    display: flex;
    align-items: center;
}
.stat-clickable {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.stat-clickable:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>

    <div class="g4 mb16" style="gap:16px; display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
        
        {{-- RPP --}}
        @if($stats['rpp']['pending'] > 0)
        <a href="{{ route('validasi_rppm') }}" class="stat-box stat-clickable" style="text-decoration:none;">
        @else
        <div class="stat-box">
        @endif
            <div class="stat-title">Total RPP</div>
            <div class="stat-value">{{ $stats['rpp']['total'] }} RPP</div>
            @if($stats['rpp']['pending'] > 0)
                <div class="stat-pending mb4">
                    <span class="pulse-dot"></span> {{ $stats['rpp']['pending'] }} RPP Menunggu Validasi
                </div>
                <div style="font-size:11px; color:var(--blue); font-weight:600;">👉 Klik untuk tinjau</div>
            @else
                <div style="font-size:12px; color:var(--g6)">Semua RPP tervalidasi</div>
            @endif
        @if($stats['rpp']['pending'] > 0) </a> @else </div> @endif

        {{-- Laporan --}}
        @if($stats['laporan']['pending'] > 0)
        <a href="{{ route('validasi_laporan') }}" class="stat-box stat-clickable" style="text-decoration:none;">
        @else
        <div class="stat-box">
        @endif
            <div class="stat-title">Total Laporan RPP</div>
            <div class="stat-value">{{ $stats['laporan']['total'] }} Laporan</div>
            @if($stats['laporan']['pending'] > 0)
                <div class="stat-pending mb4">
                    <span class="pulse-dot"></span> {{ $stats['laporan']['pending'] }} Laporan Menunggu Validasi
                </div>
                <div style="font-size:11px; color:var(--blue); font-weight:600;">👉 Klik untuk tinjau</div>
            @else
                <div style="font-size:12px; color:var(--g6)">Semua Laporan tervalidasi</div>
            @endif
        @if($stats['laporan']['pending'] > 0) </a> @else </div> @endif

        {{-- Tema --}}
        @if($stats['tema']['pending'] > 0)
        <a href="{{ route('validasi_tema') }}" class="stat-box stat-clickable" style="text-decoration:none;">
        @else
        <div class="stat-box">
        @endif
            <div class="stat-title">Total Tema</div>
            <div class="stat-value">{{ $stats['tema']['total'] }} Tema</div>
            @if($stats['tema']['pending'] > 0)
                <div class="stat-pending mb4">
                    <span class="pulse-dot"></span> {{ $stats['tema']['pending'] }} Tema Menunggu Validasi
                </div>
                <div style="font-size:11px; color:var(--blue); font-weight:600;">👉 Klik untuk tinjau</div>
            @else
                <div style="font-size:12px; color:var(--g6)">Semua Tema tervalidasi</div>
            @endif
        @if($stats['tema']['pending'] > 0) </a> @else </div> @endif

        {{-- Sub Tema --}}
        @if($stats['sub_tema']['pending'] > 0)
        <a href="{{ route('validasi_tema') }}" class="stat-box stat-clickable" style="text-decoration:none;">
        @else
        <div class="stat-box">
        @endif
            <div class="stat-title">Total Sub Tema</div>
            <div class="stat-value">{{ $stats['sub_tema']['total'] }} Sub Tema</div>
            @if($stats['sub_tema']['pending'] > 0)
                <div class="stat-pending mb4">
                    <span class="pulse-dot"></span> {{ $stats['sub_tema']['pending'] }} Sub Tema Menunggu Validasi
                </div>
                <div style="font-size:11px; color:var(--blue); font-weight:600;">👉 Klik untuk tinjau</div>
            @else
                <div style="font-size:12px; color:var(--g6)">Semua Sub Tema tervalidasi</div>
            @endif
        @if($stats['sub_tema']['pending'] > 0) </a> @else </div> @endif

    </div>

@endsection
