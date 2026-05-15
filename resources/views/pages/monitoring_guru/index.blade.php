@extends('layout.app')

@section('page-title', 'Monitoring Guru')
@section('page-subtitle', \App\Models\DataSekolah::getData()?->name  . ' - ' . \App\Models\TahunAjaran::getActive()?->name)

@section('content')
    <div class="card">
        <div class="ch">
            <div class="ct">📈 Monitoring Semua Guru</div>
        </div>

        <div class="fb mb16">
            <input type="text" id="inputCariGuru" placeholder="🔍 Cari nama guru..." value="{{ request('cari') }}" />
            <span class="fs11 tc2">{{ $guruData->count() }} guru aktif</span>
        </div>

        @if ($guruData->isEmpty())
            <div class="card emp">
                <div class="ei">🧑‍🏫</div>
                <h3>Belum ada guru aktif</h3>
                <p>Hubungi Admin Segera.</p>
            </div>
        @else
            @foreach ($guruData as $data)
                <div class="card mb16" style="border-color:var(--g2)">
                    <div class="fl ic g12 mb16">
                        <div
                            style="width:50px;height:50px;background:var(--g6);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:20px">
                            {{ strtoupper(substr($data['guru']->name, 0, 1)) }}</div>
                        <div>
                            <div class="fw7">{{ $data['guru']->name }}</div>
                            <div class="fs11 tc2">{{ $data['kelas'] }} • @if ($data['guru']->no_telp)
                                    {{ $data['guru']->no_telp }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="g3 mb16">
                        <div class="ib">
                            <div class="ik">Total RPPM</div>
                            <div class="iv">{{ $data['rppm_total'] }}</div>
                        </div>
                        <div class="ib">
                            <div class="ik">RPPM Disetujui</div>
                            <div class="iv" style="color:var(--g6)">{{ $data['rppm_disetujui'] }}</div>
                        </div>
                        <div class="ib">
                            <div class="ik">Total RPPH</div>
                            <div class="iv">{{ $data['rpph_total'] }}</div>
                        </div>
                        <div class="ib">
                            <div class="ik">Portofolio</div>
                            <div class="iv">{{ $data['porto_total'] }}</div>
                        </div>
                        <div class="ib">
                            <div class="ik">RPPM Pending</div>
                            <div class="iv" style="color:var(--acc2)">{{ $data['rppm_pending'] }}</div>
                        </div>
                        <div class="ib">
                            <div class="ik">Progress</div>
                            <div class="iv">{{ $data['progress'] }}%</div>
                        </div>
                    </div>
                    <div class="pw">
                        <div class="pb {{ $data['progress'] >= 70 ? 'gr' : ($data['progress'] >= 40 ? 'or' : 'pk') }}"
                            style="width:{{ $data['progress'] }}%">
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
@push('scripts')
<script>
    $('#inputCariGuru').on('input', function () {
        var keyword = $(this).val().toLowerCase();

        $('.card.mb16').each(function () {
            var namaGuru = $(this).find('.fw7').first().text().toLowerCase();
            $(this).toggle(namaGuru.includes(keyword));
        });
    });
</script>
@endpush