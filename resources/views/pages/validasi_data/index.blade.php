@extends('layout.app')

@section('page-title', 'Validasi Data')
@section('page-subtitle', 'Persetujuan Tema, Sub Tema, dan RPPM')

@section('content')
<div class="card" style="margin-bottom: 20px;">
    <div class="ch">
        <div class="ct">Validasi Tema Baru</div>
    </div>
    <div class="cb" style="padding: 16px;">
        @if(session('success'))
            <div class="al als" style="margin-bottom:15px">{{ session('success') }}</div>
        @endif

        <table class="tb" style="width: 100%; text-align: left;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tema</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($temaPending as $idx => $t)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $t->name }}</td>
                        <td>⏳ Menunggu</td>
                        <td>
                            <form action="{{ route('validasi_tema.tema.setujui', $t->id) }}" method="POST" style="display:inline">
                                @csrf @method('PUT')
                                <button type="submit" class="btn bp bsm">Setujui</button>
                            </form>
                            <form action="{{ route('validasi_tema.tema.kembalikan', $t->id) }}" method="POST" style="display:inline" class="form-tolak">
                                @csrf @method('PUT')
                                <button type="submit" class="btn bd bsm">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--txt3)">Tidak ada tema yang butuh validasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card" style="margin-bottom: 20px;">
    <div class="ch">
        <div class="ct">Validasi Sub Tema Baru</div>
    </div>
    <div class="cb" style="padding: 16px;">
        <table class="tb" style="width: 100%; text-align: left;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tema Induk</th>
                    <th>Nama Sub Tema</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subTemaPending as $idx => $s)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $s->tema->name }}</td>
                        <td>{{ $s->name }}</td>
                        <td>⏳ Menunggu</td>
                        <td>
                            <form action="{{ route('validasi_tema.sub_tema.setujui', $s->id) }}" method="POST" style="display:inline">
                                @csrf @method('PUT')
                                <button type="submit" class="btn bp bsm">Setujui</button>
                            </form>
                            <form action="{{ route('validasi_tema.sub_tema.kembalikan', $s->id) }}" method="POST" style="display:inline" class="form-tolak">
                                @csrf @method('PUT')
                                <button type="submit" class="btn bd bsm">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--txt3)">Tidak ada sub tema yang butuh validasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="ch">
        <div class="ct">Validasi RPPM Baru</div>
    </div>
    <div class="cb" style="padding: 16px;">
        <table class="tb" style="width: 100%; text-align: left;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Guru</th>
                    <th>Minggu Ke</th>
                    <th>Sub Tema</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rppmPending as $idx => $r)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $r->guru->name ?? '-' }}</td>
                        <td>{{ $r->minggu_ke }}</td>
                        <td>{{ $r->subTema->name ?? '-' }}</td>
                        <td>⏳ Menunggu</td>
                        <td>
                            <form action="{{ route('validasi_rppm.setujui', $r->id) }}" method="POST" style="display:inline">
                                @csrf @method('PUT')
                                <button type="submit" class="btn bp bsm">Setujui</button>
                            </form>
                            <form action="{{ route('validasi_rppm.kembalikan', $r->id) }}" method="POST" style="display:inline" class="form-tolak">
                                @csrf @method('PUT')
                                <button type="submit" class="btn bd bsm">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--txt3)">Tidak ada RPPM yang butuh validasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('.form-tolak').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            title: 'Tolak Pengajuan',
            text: 'Masukkan catatan/alasan penolakan:',
            input: 'textarea',
            inputPlaceholder: 'Tulis catatan di sini...',
            showCancelButton: true,
            confirmButtonText: 'Submit Penolakan',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Catatan tidak boleh kosong!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'catatan',
                    value: result.value
                }).appendTo(form);
                form.submit();
            }
        });
    });
</script>
@endpush
