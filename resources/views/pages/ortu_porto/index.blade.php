@extends('layout.app')

@section('page-title', 'Portofolio Anak')
@section('page-subtitle', 'Pantau perkembangan anak Anda')

@section('content')
    <div class="card">
        <div class="ch">
            <div>
                <div class="ct">📸 Portofolio Anak</div>
                <div class="cs">Klik foto untuk lihat detail & komentar</div>
            </div>
        </div>

        {{-- Header Anak --}}
        <div class="fl ic g12 mb16">
            <div
                style="width:50px;height:50px;border-radius:50%;background:linear-gradient(135deg,var(--g4),var(--g3));display:flex;align-items:center;justify-content:center;font-size:22px">
                👦</div>
            <div>
                <h3 style="font-size:16px;font-weight:800">Zaid Al-Fatih</h3>
                <p class="fs11 tc2">Kelas A — 8 entri portofolio</p>
            </div>
            <button class="btn bp bsm" style="margin-left:auto">🖨️ Cetak Laporan</button>
        </div>

        {{-- Grafik Aspek --}}
        <div class="card mb16" style="border-color:var(--g2)">
            <div class="fw7 fs11 mb12">📊 Grafik Aspek Perkembangan Zaid</div>
            <div class="graf-bar">
                <div class="graf-label"><span class="ap a1">🕌 Nilai Agama</span></div>
                <div class="graf-wrap">
                    <div class="graf-fill pb gr" style="width:37%"><span class="graf-val">3</span></div>
                </div>
                <div class="graf-pct">37%</div>
            </div>
            <div class="graf-bar">
                <div class="graf-label"><span class="ap a2">🏃 Fisik Motorik</span></div>
                <div class="graf-wrap">
                    <div class="graf-fill pb bl" style="width:25%"><span class="graf-val">2</span></div>
                </div>
                <div class="graf-pct">25%</div>
            </div>
            <div class="graf-bar">
                <div class="graf-label"><span class="ap a3">🧠 Kognitif</span></div>
                <div class="graf-wrap">
                    <div class="graf-fill pb ye" style="width:25%"><span class="graf-val">2</span></div>
                </div>
                <div class="graf-pct">25%</div>
            </div>
            <div class="graf-bar">
                <div class="graf-label"><span class="ap a6">🎨 Seni</span></div>
                <div class="graf-wrap">
                    <div class="graf-fill pb or" style="width:12%"><span class="graf-val">1</span></div>
                </div>
                <div class="graf-pct">12%</div>
            </div>
        </div>

        {{-- Grid Portofolio --}}
        <div class="g4">
            <div class="pfc">
                <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">🎨</div>
                <div class="pfb">
                    <div class="pfd">📅 14/07/2025</div>
                    <div class="pfn" style="font-size:13px;margin-top:4px">Kolase Tulisan</div>
                    <div class="pfnt">Anak sangat antusias menempel potongan kertas dengan rapi...</div>
                    <div class="fl fw g8 mt8">
                        <span class="ap a1">🕌</span>
                        <span class="ap a6">🎨</span>
                    </div>
                    <div class="fs11 tc2 mt8">💬 2 komentar</div>
                    <div class="kom-item">
                        <div class="kom-author">Ustadzah Siti Rahmah</div>
                        <div class="kom-text">Zaid sangat antusias dan hasilnya sangat rapi untuk usianya 🌟</div>
                        <div class="kom-time">14 Jul 2025</div>
                    </div>
                </div>
            </div>
            <div class="pfc">
                <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">✏️</div>
                <div class="pfb">
                    <div class="pfd">📅 15/07/2025</div>
                    <div class="pfn" style="font-size:13px;margin-top:4px">Menebalkan Nama</div>
                    <div class="pfnt">Zaid sudah bisa menebalkan huruf namanya sendiri dengan rapi...</div>
                    <div class="fl fw g8 mt8">
                        <span class="ap a3">🧠</span>
                        <span class="ap a4">💬</span>
                    </div>
                </div>
            </div>
            <div class="pfc">
                <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">🏃</div>
                <div class="pfb">
                    <div class="pfd">📅 16/07/2025</div>
                    <div class="pfn" style="font-size:13px;margin-top:4px">Senam Pagi</div>
                    <div class="pfnt">Aktif mengikuti gerakan senam dengan semangat dan ceria...</div>
                    <div class="fl fw g8 mt8">
                        <span class="ap a2">🏃</span>
                        <span class="ap a5">❤️</span>
                    </div>
                    <div class="fs11 tc2 mt8">💬 1 komentar</div>
                </div>
            </div>
            <div class="pfc">
                <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">🕌</div>
                <div class="pfb">
                    <div class="pfd">📅 17/07/2025</div>
                    <div class="pfn" style="font-size:13px;margin-top:4px">Praktek Shalat</div>
                    <div class="pfnt">Zaid sudah hafal bacaan surat Al-Fatihah dan gerakannya dengan baik...</div>
                    <div class="fl fw g8 mt8">
                        <span class="ap a1">🕌</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
