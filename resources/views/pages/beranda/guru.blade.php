@extends('layout.app')

@section('page-title', 'Beranda')
@section('page-subtitle', ($sekolah->name ?? '-') . ' - ' . ($taAktif?->name ?? '-'))

@section('content')
    <div class="card mb16">
        <div style="font-size: 16px; font-weight: bold; color: var(--g7);">
            Selamat datang, {{ Auth::user()->name }}!
        </div>
        <div style="font-size: 14px; color: var(--g5); margin-top: 4px;">
            Anda adalah Guru Kelas: <strong style="color: var(--p1);">{{ Auth::user()->kelas->name ?? 'Belum ada kelas' }}</strong>
        </div>
    </div>
    <div class="sg mb16">
        <div class="sc">
            <div class="sico bl">📋</div>
            <div>
                <div class="sv">{{ $stats['total_rppm'] }}</div>
                <div class="sl">Total RPP Semester Ini</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico pu">📸</div>
            <div>
                <div class="sv">{{ $stats['total_laporan'] }}</div>
                <div class="sl">Total Laporan RPP Semester Ini</div>
            </div>
        </div>
    </div>

@endsection
