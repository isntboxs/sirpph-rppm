@extends('layout.app')

@section('page-title', 'Beranda')
@section('page-subtitle', ($sekolah->name ?? '-') . ' - ' . ($taAktif?->name ?? '-'))

@section('content')

    <div class="sg mb16">
        <div class="sc">
            <div class="sico bl">📋</div>
            <div>
                <div class="sv">{{ $stats['total_rppm'] }}</div>
                <div class="sl">Total RPPM</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico gr">✅</div>
            <div>
                <div class="sv">{{ $stats['rppm_disetujui'] }}</div>
                <div class="sl">RPPM Disetujui</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico or">📅</div>
            <div>
                <div class="sv">{{ $stats['total_rpph'] }}</div>
                <div class="sl">Total RPPH</div>
            </div>
        </div>
        <div class="sc">
            <div class="sico pu">👶</div>
            <div>
                <div class="sv">{{ $stats['siswa_kelas'] }}</div>
                <div class="sl">Siswa {{ $kelas?->name ?? 'Kelas' }}</div>
            </div>
        </div>
    </div>

    <div class="g2" style="gap:14px;align-items:start">

        <div class="card">
            <div class="ch mb12">
                <div class="ct">📋 RPPM Terbaru</div>
                @if (!$rppmTerbaru->isEmpty())
                    <a href="{{ route('rppm') }}" class="btn bp bsm">+ Buat Baru</a>
                @endif
            </div>

            @forelse ($rppmTerbaru as $rppm)
                <div class="rc2 mb8">
                    <div class="rh">
                        <div>
                            <div class="rw">
                                Minggu ke-{{ $rppm->minggu_ke }} • {{ $taAktif?->name }}
                            </div>
                            <div class="rn">{{ $rppm->subTema->tema->name }}</div>
                            <div class="rs">{{ $rppm->subTema->name }}</div>
                        </div>
                        <span class="bdg {{ $rppm->status_badge_class }}">
                            {{ $rppm->status_label }}
                        </span>
                    </div>

                    @if ($rppm->status === 'disetujui' && $rppm->rpphs->isEmpty())
                        <div class="ract mt8">
                            <a href="{{ route('rpph') }}" class="btn bp bsm">
                                ⚡ Generate RPPH
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="emp" style="padding:24px 0">
                    <div class="ei" style="font-size:28px">📋</div>
                    <div class="fs11 tc2 mb8">Belum ada RPPM</div>
                    <a href="{{ route('rppm') }}" class="btn bp bsm">+ Buat RPPM</a>
                </div>
            @endforelse

            @if ($rppmTerbaru->hasPages())
                {{ $rppmTerbaru->links() }}
            @endif
        </div>

        <div class="card">
            <div class="ch mb12">
                <div class="ct">👶 Siswa {{ $kelas?->name ?? '-' }}</div>
                <a href="{{ route('portofolio_siswa') }}" class="btn bp bsm">Portofolio</a>
            </div>

            @if (!$kelas)
                <div class="al alw">⚠️ Anda belum terdaftar di kelas manapun.</div>
            @elseif ($siswas->isEmpty())
                <div class="emp" style="padding:24px 0">
                    <div class="ei" style="font-size:28px">👶</div>
                    <div class="fs11 tc2">Belum ada siswa di kelas ini</div>
                </div>
            @else
                <div class="tw">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>JK</th>
                                <th>Portofolio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswas as $siswa)
                                <tr>
                                    <td><strong>{{ $siswa->name }}</strong></td>
                                    <td>{{ $siswa->jenis_kelamin === 'L' ? '👦' : '👧' }}</td>
                                    <td>{{ $siswa->portofolios_count }} entri</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($siswas->hasPages())
                    {{ $siswas->links() }}
                @endif
            @endif
        </div>

    </div>

@endsection
