@extends('layout.app')

@section('page-title', 'Program Semester (PROSEM)')
@section('page-subtitle')
    {{ ($taAktif->name ?? ' - ') . ' - Semester ' . ($taAktif->semester ?? ' - ') }}
@endsection

@section('content')
    <div class="card">
        <div class="tabs">
            @foreach ($tahunAjaran as $ta)
                <button class="tbn {{ $ta->active ? 'on' : '' }}">
                    {{ $ta->name }} - Sem {{ $ta->semester }}
                </button>
            @endforeach
        </div>

        <div style="overflow-x:auto">
            <table class="pt">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tema</th>
                        <th>Sub Tema</th>
                        <th>Minggu</th>
                        <th>Alokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse ($prosems as $temaId => $items)
                        @foreach ($items as $i => $prosem)
                            <tr>
                                @if ($i === 0)
                                    <td rowspan="{{ $items->count() }}"
                                        style="text-align:center;font-weight:700;border:1px solid var(--g2)">
                                        {{ $no++ }}
                                    </td>
                                    <td rowspan="{{ $items->count() }}" class="tc" style="border:1px solid var(--g2)">
                                        {{ $prosem->tema->name }}
                                    </td>
                                @endif
                                <td style="border:1px solid var(--g2)">{{ $prosem->subTema->name }}</td>
                                <td style="border:1px solid var(--g2);text-align:center">
                                    <div class="wn">{{ $prosem->minggu_ke }}</div>
                                </td>
                                <td style="border:1px solid var(--g2);text-align:center">1 Minggu</td>
                                <td style="border:1px solid var(--g2);text-align:center">
                                    <button type="button" class="btn bd bxs btn-hapus-prosem"
                                        data-id="{{ $prosem->id }}">🗑️</button>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:32px;color:var(--txt3)">
                                Belum ada data PROSEM. Klik "+ Tambah Baris" untuk mulai.
                            </td>
                        </tr>
                    @endforelse
                    @if ($prosems->isNotEmpty())
                        <tr>
                            <td colspan="5"
                                style="border:1px solid var(--g2);text-align:center;font-weight:700;background:var(--g1)">
                                JUMLAH
                            </td>
                            <td style="border:1px solid var(--g2);text-align:center;font-weight:700;background:var(--g1)">
                                {{ $prosems->flatten()->count() }} Minggu
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
