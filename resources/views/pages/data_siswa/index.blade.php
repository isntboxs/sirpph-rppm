@extends('layout.app')

@section('page-title', 'Data Siswa')
@section('page-subtitle',  \App\Models\DataSekolah::getData()?->name  . ' - ' . \App\Models\TahunAjaran::getActive()?->name)

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
                    @foreach ($data as $siswa)
                        <tr>
                            <td><strong>{{ $siswa->name }}</strong></td>
                            <td>{{ $siswa->kelas->name }}</td>
                            <td>{{ $siswa->tanggal_lahir_format }}</td>
                            <td>{{ $siswa->jenis_kelamin_label }}</td>
                            <td>-</td>
                            <td class="fl g8">
                                <button data-id="{{ $siswa->id }}" class="btn bo bxs edit-siswa">✏️</button>
                                <button data-id="{{ $siswa->id }}" class="btn bd bxs delete-siswa">🗑️</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal: Tambah Siswa --}}
    <div class="mo" id="mSiswa">
        <div class="md mmd">
            <div class="mh">
                <div>
                    <div class="mt2">Tambah Siswa</div>
                </div>
                <button class="mc">✕</button>
            </div>
            <div class="mb">
                <div class="fr c2">
                    <div class="ff"><label>Nama Siswa</label><input placeholder="Nama lengkap" /></div>
                    <div class="ff"><label>Kelas</label>
                        <select>
                            <option value="A">Kelas A</option>
                            <option value="B">Kelas B</option>
                        </select>
                    </div>
                </div>
                <div class="fr c2">
                    <div class="ff"><label>Tanggal Lahir</label><input type="date" /></div>
                    <div class="ff"><label>Jenis Kelamin</label>
                        <select>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mf">
                <button class="btn bo">Batal</button>
                <button id="save-siswa" class="btn bp">💾 Simpan</button>
            </div>
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
