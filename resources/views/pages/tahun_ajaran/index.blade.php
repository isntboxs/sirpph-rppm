@extends('layout.app')

@section('page-title', 'Tahun Ajaran')
@section('page-subtitle', \App\Models\DataSekolah::getData()?->name  . ' - ' . \App\Models\TahunAjaran::getActive()?->name)

@section('content')
    <div class="card">
        <div class="ch">
            <div class="ct">📅 Tahun Ajaran</div>
            <button id="btn-tambah-ajaran" class="btn bp bsm">+ Tambah</button>
        </div>
        <div class="tw">
            <table>
                <thead>
                    <tr>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr>
                            <td><strong>{{ $data->name }}</strong></td>
                            <td>Semester {{ $data->semester }}</td>
                            <td><span
                                    class="bdg {{ $data->active == 1 ? 'bok' : 'bdr' }}">{{ $data->active == 1 ? '🟢 Aktif' : '⚪ Arsip' }}</span>
                            </td>
                            @if ($data->active == 1)
                                <td><span class="fs11 tc2 ">Aktif</span></td>
                            @else
                                <td><button class="btn bp bxs set-active" data-id={{ $data->id }}>Set Aktif</button></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Ajaran --}}
    <div class="mo" id="mAjaran">
        <div class="md mmd">
            <div class="mh">
                <div>
                    <div class="mt2">Tambah Tahun Ajaran</div>
                </div>
                <button type="button" class="mc">✕</button>
            </div>
            <div class="mb">
                <div class="fr c2">
                    <div class="ff"><label>Tahun Ajaran</label><input id="name" name="name" type="text"
                            placeholder="2024/2025" required /></div>
                    <div class="ff"><label>Semester Aktif</label>
                        <select id="semester">
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mf">
                <button id="add-ajaran" class="btn bp">💾 Simpan</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#btn-tambah-ajaran').on('click', function() {
            $('#mAjaran').addClass('on');
        });

        $('#add-ajaran').on('click', function() {
            let data = {
                name: $('#name').val(),
                semester: $('#semester').val(),
            }

            $.ajax({
                url: `/tahun-ajaran`,
                type: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    location.reload();
                    showToast(res.msg);
                },
                error: function() {
                    showToast("Gagal Menambahkan Tahun Ajaran");
                }
            })
        })

        $('.set-active').on('click', function() {
            let id = $(this).data('id');

            $.ajax({
                url: `/tahun-ajaran/active/${id}`,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    location.reload();
                    showToast(res.msg);
                },
                error: function() {
                    showToast("Gagal Menambahkan Tahun Ajaran");
                }
            })
        })
    </script>
@endpush
