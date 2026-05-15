@extends('layout.app')

@section('page-title', 'Data Sekolah')
@section('page-subtitle', \App\Models\DataSekolah::getData()?->name  . ' - ' . \App\Models\TahunAjaran::getActive()?->name)

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
            <form id="form-sekolah">
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
                    <div class="ff mb16"><label>No. HP</label><input id="no_telp" name="no_telp" placeholder="08xx" />
                    </div>
                    <div class="ff mb16"><label>Alamat</label>
                        <textarea name="alamat" id="alamat" rows="2">{{ $sekolah->alamat ?? '-' }}</textarea>
                    </div>
                </div>
                <div class="mf">
                    <button type="submit" class="btn bp">💾 Update</button>
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

            $('#form-sekolah').on('submit', function(e) {
                e.preventDefault();

                let data = {
                    name: $('#name').val(),
                    npsn: $('#npsn').val(),
                    alamat: $('#alamat').val(),
                    no_telp: $('#no_telp').val(),
                }

                $.ajax({
                    url: `/data-sekolah/update`,
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
                });
            });
        });
    </script>
@endpush
