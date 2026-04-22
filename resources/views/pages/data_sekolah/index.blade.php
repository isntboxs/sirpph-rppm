@extends('layout.app')

@section('page-title', 'Data Sekolah')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
    <div class="card">
        <div class="ch">
            <div class="ct">🏫 Data Sekolah</div>
            <button class="btn bp bsm" id="btn-edit-sekolah">✏️ Edit</button>
        </div>
        <div class="ig">
            <div class="ib">
                <div class="ik">Nama Sekolah</div>
                <div class="iv">{{ $sekolah->name ?? '-' }}</div>
            </div>
            <div class="ib">
                <div class="ik">NPSN</div>
                <div class="iv">{{ $sekolah->npsn ?? '-' }}</div>
            </div>
            <div class="ib">
                <div class="ik">Kepala Sekolah</div>
                <div class="iv">{{ $kepala->name ?? '-' }}</div>
            </div>
            <div class="ib">
                <div class="ik">Telepon</div>
                <div class="iv">{{ $sekolah->no_telp ?? '-' }}</div>
            </div>
            <div class="ib">
                <div class="ik">Tahun Ajaran</div>
                <div class="iv">{{ $tahun_ajaran->name ?? '-' }}</div>
            </div>
            <div class="ib">
                <div class="ik">Semester Aktif</div>
                <div class="iv">Semester {{ $tahun_ajaran->semester ?? '-' }}</div>
            </div>
        </div>
        <div class="ib mt16" style="border-left-color:var(--acc)">
            <div class="ik">Alamat</div>
            <div class="iv">{{ $sekolah->alamat ?? '-' }}</div>
        </div>
    </div>

    {{-- Modal: Edit Data Sekolah --}}
    <div class="mo" id="mSek">
        <div class="md mmd">
            <div class="mh">
                <div>
                    <div class="mt2">🏫 Edit Data Sekolah</div>
                </div>
                <button class="mc">✕</button>
            </div>
            <form>
                <div class="mb">
                    <div class="fr c2">
                        <div class="ff">
                            <label>Nama Sekolah</label>
                            <input name="name" id="name" value="{{ $sekolah->name ?? '-' }}" />
                        </div>
                        <div class="ff">
                            <label>NPSN</label>
                            <input name="npsn" id="npsn" value="{{ $sekolah->npsn ?? '-' }}" />
                        </div>
                    </div>
                    <div class="ff mb16"><label>Alamat</label>
                        <textarea name="alamat" id="alamat" rows="2">{{ $sekolah->alamat ?? '-' }}</textarea>
                    </div>
                </div>
                <div class="mf">
                    <button class="btn bo">Batal</button>
                    <button type="submit" id="update-data" class="btn bp">💾 Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#btn-edit-sekolah').on('click', function() {
                $('#mSek').addClass('on');
            });

            $('#update-data').on('click', function() {
                let data = {
                    name: $('#name').val(),
                    npsn: $('#npsn').val(),
                    alamat: $('#alamat').val(),
                }

                $.ajax({
                    url: `/data-sekolah`,
                    type: 'PUT',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        showToast(res.msg);
                    },
                    error: function() {
                        showToast("Gagal Update Data Sekolah");
                    }
                })
            })
        });
    </script>
@endpush
