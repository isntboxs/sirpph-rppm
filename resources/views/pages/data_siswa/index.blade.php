@extends('layout.app')

@section('page-title', 'Data Siswa')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
    <div class="card">
        <div class="ch">
            <div class="ct">👶 Data Siswa</div>
            <button class="btn bp bsm" id="btn-tambah-siswa">+ Tambah Siswa</button>
        </div>
        <div class="tw">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Tgl Lahir</th>
                        <th>JK</th>
                        <th>Portofolio</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Zaid Al-Fatih</strong></td>
                        <td>Kelas A</td>
                        <td>15/03/2019</td>
                        <td>👦 L</td>
                        <td>8 entri</td>
                        <td class="fl g8">
                            <button class="btn bo bxs">✏️</button>
                            <button class="btn bd bxs">🗑️</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Aisyah Nur Fadilah</strong></td>
                        <td>Kelas A</td>
                        <td>22/07/2019</td>
                        <td>👧 P</td>
                        <td>10 entri</td>
                        <td class="fl g8">
                            <button class="btn bo bxs">✏️</button>
                            <button class="btn bd bxs">🗑️</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Umar Hakim</strong></td>
                        <td>Kelas B</td>
                        <td>08/01/2019</td>
                        <td>👦 L</td>
                        <td>6 entri</td>
                        <td class="fl g8">
                            <button class="btn bo bxs">✏️</button>
                            <button class="btn bd bxs">🗑️</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Fatimah Az-Zahra</strong></td>
                        <td>Kelas B</td>
                        <td>30/05/2019</td>
                        <td>👧 P</td>
                        <td>9 entri</td>
                        <td class="fl g8">
                            <button class="btn bo bxs">✏️</button>
                            <button class="btn bd bxs">🗑️</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Ibrahim Khalil</strong></td>
                        <td>Kelas A</td>
                        <td>14/11/2018</td>
                        <td>👦 L</td>
                        <td>5 entri</td>
                        <td class="fl g8">
                            <button class="btn bo bxs">✏️</button>
                            <button class="btn bd bxs">🗑️</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#btn-tambah-siswa').on('click', function() {
                $('#mSiswa').addClass('on');
            });
        });
    </script>
@endpush
