<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>RPP</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }
        .header {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: table;
        }
        .header-logo {
            display: table-cell;
            width: 100px;
            vertical-align: middle;
            text-align: center;
        }
        .header-logo img {
            width: 80px;
            height: 80px;
        }
        .header-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .header-text h1 {
            font-size: 11pt; /* Reduced to avoid 2 lines */
            margin: 0;
            padding: 0;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .header-text h2 {
            font-size: 16pt;
            margin: 0;
            padding: 0;
            font-weight: bold;
        }
        .header-text p {
            font-size: 9pt;
            margin: 3px 0 0 0;
            padding: 0;
        }
        
        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 15px;
            text-decoration: underline;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 2px 5px;
            vertical-align: top;
        }
        .info-table td:first-child {
            width: 120px;
            font-weight: bold;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .content-table th, .content-table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }
        .content-table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .signature {
            width: 100%;
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .sig-left {
            float: left;
            width: 45%;
            text-align: center;
        }
        .sig-right {
            float: right;
            width: 45%;
            text-align: center;
        }
        .sig-date {
            margin-bottom: 10px;
        }
        .sig-space {
            height: 80px;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        
        .text-bold { font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-logo">
            <!-- Using public_path to get absolute local path for DomPDF -->
            @php
                $logoPath = public_path('logo_final.jpg');
                $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
                $logoSrc = 'data:image/jpeg;base64,' . $logoData;
            @endphp
            @if($logoData)
                <img src="{{ $logoSrc }}" alt="Logo">
            @endif
        </div>
        <div class="header-text">
            <h1>LEMBAGA PENDIDIKAN ISLAM ANAK USIA DINI AL-QUR'AN</h1>
            <h2>PAUDQU AL - AULIA</h2>
            <p>Jl. Mh.Thamrin Kp.Warung Mangga Rt. 003/002 Kel. Panunggangan Kec. Pinang Kota Tangerang – Banten</p>
        </div>
    </div>

    <div class="title">RENCANA PELAKSANAAN PEMBELAJARAN (RPP)</div>

    <table class="info-table">
        <tr>
            <td style="white-space: nowrap;"><strong>Tahun Ajaran</strong></td>
            <td>: {{ $rppm->tahunAjaran->name ?? '-' }}</td>
            <td style="white-space: nowrap;"><strong>Semester</strong></td>
            <td>: {{ $rppm->tahunAjaran->semester ?? '-' }}</td>
        </tr>
        <tr>
            <td style="white-space: nowrap;"><strong>Bulan / Minggu Ke</strong></td>
            @php
                $bulan = $rppm->tanggal_dibuat ? \Carbon\Carbon::parse($rppm->tanggal_dibuat)->isoFormat('MMMM') : '-';
                $mingguKe = $rppm->minggu_ke ?? $rppm->subTema->minggu_ke ?? '-';
            @endphp
            <td style="white-space: nowrap;">: {{ $bulan }} / {{ $mingguKe }}</td>
            <td style="white-space: nowrap;"><strong>Sub Tema</strong></td>
            <td>: {{ $rppm->subTema->name ?? '-' }}</td>
        </tr>
        <tr>
            <td style="white-space: nowrap;"><strong>Tema</strong></td>
            <td colspan="3">: {{ $rppm->subTema->tema->name ?? '-' }}</td>
        </tr>
    </table>

    <table class="content-table">
        <tr>
            <th style="width: 30%">Tujuan Pembelajaran</th>
            <td>{!! nl2br(e($rppm->tujuan ?? '-')) !!}</td>
        </tr>
        <tr>
            <th>Capaian Perkembangan</th>
            <td>{!! nl2br(e($rppm->capaian ?? '-')) !!}</td>
        </tr>
        <tr>
            <th>Kegiatan Pembuka</th>
            <td>{!! nl2br(e($rppm->kegiatan_pembuka ?? '-')) !!}</td>
        </tr>
        <tr>
            <th>Kegiatan Inti</th>
            <td>{!! nl2br(e($rppm->kegiatan_inti ?? '-')) !!}</td>
        </tr>
        <tr>
            <th>Recalling</th>
            <td>{!! nl2br(e($rppm->recalling ?? '-')) !!}</td>
        </tr>
        <tr>
            <th>Kegiatan Penutup</th>
            <td>{!! nl2br(e($rppm->kegiatan_penutup ?? '-')) !!}</td>
        </tr>
        <tr>
            <th>Rencana Penilaian</th>
            <td>{!! nl2br(e($rppm->rencana_penilaian ?? '-')) !!}</td>
        </tr>
    </table>

    <div class="signature clearfix">
        <div class="sig-left">
            <div class="sig-date"><br></div>
            <div>Guru {{ $rppm->guru?->kelas?->name ?? 'Kelas' }}</div>
            <div class="sig-space"></div>
            <div class="sig-name">{{ $rppm->guru?->name ?? 'Guru' }}</div>
            <div>NUPTK. {{ $rppm->guru?->nuptk ?? '-' }}</div>
        </div>
        <div class="sig-right">
            <div class="sig-date">Tangerang, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</div>
            <div>Kepala Sekolah</div>
            <div class="sig-space"></div>
            <div class="sig-name">Badrudin, S.Pd.I,MM</div>
            <div>NIP. 197601182025211014</div>
        </div>
    </div>

</body>
</html>
