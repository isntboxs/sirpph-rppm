@extends('layout.app')

@section('page-title', 'Program Semester (PROSEM)')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
    <div class="card">
        <div class="ch">
            <div>
                <div class="ct">📊 Program Semester (PROSEM)</div>
                <div class="cs">PAUDQu AL-AULIA — 2024/2025</div>
            </div>
        </div>
        <div class="tabs">
            <button class="tbn on">Semester 1</button>
            <button class="tbn">Semester 2</button>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="4" style="text-align:center;font-weight:700;border:1px solid var(--g2)">1</td>
                        <td rowspan="4" class="tc" style="border:1px solid var(--g2)">Aku, Makhluq Allah</td>
                        <td style="border:1px solid var(--g2)">Allah Tuhanku</td>
                        <td style="border:1px solid var(--g2);text-align:center">
                            <div class="wn">1</div>
                        </td>
                        <td style="border:1px solid var(--g2);text-align:center">1 Minggu</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid var(--g2)">Identitasku</td>
                        <td style="border:1px solid var(--g2);text-align:center">
                            <div class="wn">2</div>
                        </td>
                        <td style="border:1px solid var(--g2);text-align:center">1 Minggu</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid var(--g2)">Tubuhku / Aurat</td>
                        <td style="border:1px solid var(--g2);text-align:center">
                            <div class="wn">3</div>
                        </td>
                        <td style="border:1px solid var(--g2);text-align:center">1 Minggu</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid var(--g2)">Panca Indra</td>
                        <td style="border:1px solid var(--g2);text-align:center">
                            <div class="wn">4</div>
                        </td>
                        <td style="border:1px solid var(--g2);text-align:center">1 Minggu</td>
                    </tr>
                    <tr>
                        <td rowspan="4" style="text-align:center;font-weight:700;border:1px solid var(--g2)">2</td>
                        <td rowspan="4" class="tc" style="border:1px solid var(--g2)">Tanah Airku</td>
                        <td style="border:1px solid var(--g2)">Identitas Negara</td>
                        <td style="border:1px solid var(--g2);text-align:center">
                            <div class="wn">5</div>
                        </td>
                        <td style="border:1px solid var(--g2);text-align:center">1 Minggu</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid var(--g2)">Hari Besar Nasional</td>
                        <td style="border:1px solid var(--g2);text-align:center">
                            <div class="wn">6</div>
                        </td>
                        <td style="border:1px solid var(--g2);text-align:center">1 Minggu</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid var(--g2)">Lambang Negara</td>
                        <td style="border:1px solid var(--g2);text-align:center">
                            <div class="wn">7</div>
                        </td>
                        <td style="border:1px solid var(--g2);text-align:center">1 Minggu</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid var(--g2)">Elemen Bangsa / Budaya</td>
                        <td style="border:1px solid var(--g2);text-align:center">
                            <div class="wn">8</div>
                        </td>
                        <td style="border:1px solid var(--g2);text-align:center">1 Minggu</td>
                    </tr>
                    <tr>
                        <td colspan="4"
                            style="border:1px solid var(--g2);text-align:center;font-weight:700;background:var(--g1)">JUMLAH
                        </td>
                        <td style="border:1px solid var(--g2);text-align:center;font-weight:700;background:var(--g1)">17
                            Minggu</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
