<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPPM - {{ $sekolah->name }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
            font-family: "Times New Roman", serif;
            color: #000;
        }

        .btn-print {
            display: block;
            margin: 0 auto 16px;
            padding: 10px 28px;
            background: #2d6a4f;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            font-family: sans-serif;
            width: fit-content;
        }

        .btn-print:hover {
            background: #1e3d2b;
        }

        .page {
            width: 1000px;
            margin: auto;
            background: #fff;
            padding: 18px 22px 40px;
        }

        .center {
            text-align: center;
        }

        .school-name {
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .school-info {
            font-size: 14px;
            margin-top: 3px;
        }

        .title {
            margin-top: 18px;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .semester {
            margin-top: 6px;
            font-size: 18px;
        }

        hr {
            border: none;
            border-top: 2px solid #000;
            margin: 18px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            border: 1px solid #000;
            padding: 10px 12px;
            font-size: 16px;
            vertical-align: top;
        }

        .info-table .label {
            width: 22%;
            font-weight: bold;
        }

        .info-table .label-right {
            width: 22%;
            font-weight: bold;
        }

        .info-table .value-right {
            width: 23%;
        }

        .schedule-table {
            margin-top: 18px;
        }

        .schedule-table th,
        .schedule-table td {
            border: 1px solid #000;
            padding: 10px;
            font-size: 15px;
            vertical-align: top;
        }

        .schedule-table th {
            text-align: center;
            font-weight: bold;
            letter-spacing: 1px;
            color: #5d7b78;
        }

        .schedule-table td:first-child {
            font-weight: bold;
            width: 80px;
            text-align: center;
            vertical-align: middle;
        }

        .signature {
            margin-top: 70px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 300px;
            text-align: center;
            font-size: 16px;
        }

        .signature-space {
            height: 90px;
        }

        .name {
            font-weight: bold;
            text-decoration: underline;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .page {
                width: 100%;
                padding: 0;
            }

            .btn-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <button class="btn-print" onclick="window.print()">🖨️ Cetak RPPM</button>

    <div class="page">

        <div class="center">
            <div class="school-name">{{ strtoupper($sekolah->name) }}</div>
            <div class="school-info">
                NPSN: {{ $sekolah->npsn }} | {{ $sekolah->alamat }}
            </div>
            <div class="title">
                Rencana Pelaksanaan Pembelajaran Mingguan (RPPM)
            </div>
            <div class="semester">
                Tahun Ajaran {{ $rppm->tahunAjaran->name }}
                - Semester {{ $rppm->tahunAjaran->semester }}
            </div>
        </div>

        <hr>

        <table class="info-table">
            <tr>
                <td class="label">Satuan PAUD</td>
                <td>{{ $sekolah->name }}</td>
                <td class="label-right">Semester / Minggu</td>
                <td class="value-right">
                    {{ $rppm->tahunAjaran->semester }} / {{ $rppm->minggu_ke }}
                </td>
            </tr>
            <tr>
                <td class="label">Nama Guru</td>
                <td>{{ $rppm->guru->name }}</td>
                <td class="label-right">Kelas / Usia</td>
                <td class="value-right">
                    {{ $rppm->guru->kelas?->name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Tema</td>
                <td>{{ $rppm->subTema->tema->name }}</td>
                <td class="label-right">Sub Tema</td>
                <td class="value-right">{{ $rppm->subTema->name }}</td>
            </tr>
            <tr>
                <td class="label">Model</td>
                <td colspan="3">{{ $rppm->model_pembelajaran ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tujuan</td>
                <td colspan="3" style="color:var(--txt2);line-height:1.5;white-space:pre-line">{{ $rppm->tujuan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Capaian</td>
                <td colspan="3" style="color:var(--txt2);line-height:1.5;white-space:pre-line">{{ $rppm->capaian ?? '-' }}</td>
            </tr>
        </table>

        <table class="schedule-table">
            <thead>
                <tr>
                    <th>HARI</th>
                    <th>KEGIATAN</th>
                    <th>BENTUK</th>
                    <th>ASPEK</th>
                    <th>ALAT &amp; BAHAN</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                    $adaKegiatan = false;
                @endphp

                @foreach ($hariList as $hari)
                    @php
                        $kegiatanHari = $rppm->rppmKegiatans->where('hari', $hari)->values();
                    @endphp

                    @if ($kegiatanHari->isNotEmpty())
                        @php $adaKegiatan = true; @endphp

                        @foreach ($kegiatanHari as $i => $rk)
                            <tr>
                                @if ($i === 0)
                                    <td rowspan="{{ $kegiatanHari->count() }}">
                                        {{ $hari }}
                                    </td>
                                @endif
                                <td>{{ $rk->kegiatan->name }}</td>
                                <td>{{ $rk->kegiatan->bentukKegiatan->name }}</td>
                                <td>
                                    {{ $rk->kegiatan->aspeks->pluck('name')->join(', ') }}
                                </td>
                                <td>
                                    {{ $rk->kegiatan->alatBahans->pluck('name')->join(', ') ?: '-' }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach

                @if (!$adaKegiatan)
                    <tr>
                        <td colspan="5" style="text-align:center;color:#888;padding:16px">
                            Belum ada kegiatan
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="signature">
            <div class="signature-box">
                Mengetahui,<br>
                <strong>Kepala Sekolah</strong>
                <div class="signature-space"></div>
                <div class="name">{{ $sekolah->kepala }}</div>
            </div>
            <div class="signature-box">
                Tangerang, ____________<br>
                <strong>Guru Kelas {{ $rppm->guru->kelas?->name ?? '' }}</strong>
                <div class="signature-space"></div>
                <div class="name">{{ $rppm->guru->name }}</div>
            </div>
        </div>

    </div>
</body>

</html>
