@extends('layout.app')

@section('page-title', 'Portofolio Siswa')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
    <div class="card mb16">
        <div class="ch">
            <div>
                <div class="ct">📸 Portofolio Siswa Kelas A</div>
            </div>
            <button class="btn bp bsm">+ Input Portofolio</button>
        </div>

        <div class="tabs">
            <button class="tbn on" data-porto="porto-zaid">Zaid</button>
            <button class="tbn" data-porto="porto-aisyah">Aisyah</button>
            <button class="tbn" data-porto="porto-ibrahim">Ibrahim</button>
        </div>

        {{-- Portofolio Zaid --}}
        <div id="porto-zaid" class="porto-panel">
            <div class="g4 mt16">
                <div class="pfc">
                    <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">🎨</div>
                    <div class="pfb">
                        <div class="pfn">Zaid Al-Fatih</div>
                        <div class="pfd">📅 14/07/2025 — Kolase Tulisan</div>
                        <div class="pfnt">Anak sangat antusias menempel potongan kertas. Motorik halus berkembang baik...
                        </div>
                        <div class="fl fw g8 mt8">
                            <span class="ap a1">🕌</span>
                            <span class="ap a6">🎨</span>
                            <span class="ap a2">🏃</span>
                        </div>
                        <div class="fs11 tc2 mt8">💬 2 komentar</div>
                    </div>
                </div>
                <div class="pfc">
                    <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">✏️</div>
                    <div class="pfb">
                        <div class="pfn">Zaid Al-Fatih</div>
                        <div class="pfd">📅 15/07/2025 — Menebalkan Nama</div>
                        <div class="pfnt">Zaid sudah bisa menebalkan huruf namanya sendiri dengan rapi dan percaya diri...
                        </div>
                        <div class="fl fw g8 mt8">
                            <span class="ap a3">🧠</span>
                            <span class="ap a4">💬</span>
                        </div>
                    </div>
                </div>
                <div class="pfc">
                    <div class="pfp" style="background:linear-gradient(135deg,var(--g1),var(--g2))">🏃</div>
                    <div class="pfb">
                        <div class="pfn">Zaid Al-Fatih</div>
                        <div class="pfd">📅 16/07/2025 — Senam Pagi</div>
                        <div class="pfnt">Aktif mengikuti gerakan senam, semangat dan ceria bersama teman-teman
                            kelasnya...</div>
                        <div class="fl fw g8 mt8">
                            <span class="ap a2">🏃</span>
                            <span class="ap a5">❤️</span>
                        </div>
                        <div class="fs11 tc2 mt8">💬 1 komentar</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Portofolio Aisyah --}}
        <div id="porto-aisyah" class="porto-panel" style="display:none">
            <div class="g4 mt16">
                <div class="pfc">
                    <div class="pfp" style="background:linear-gradient(135deg,#fce7f3,#fbcfe8)">🌸</div>
                    <div class="pfb">
                        <div class="pfn">Aisyah Nur Fadilah</div>
                        <div class="pfd">📅 14/07/2025 — Mewarnai Bunga</div>
                        <div class="pfnt">Aisyah mewarnai dengan sangat rapi dan memilih warna yang indah...</div>
                        <div class="fl fw g8 mt8">
                            <span class="ap a6">🎨</span>
                            <span class="ap a3">🧠</span>
                        </div>
                    </div>
                </div>
                <div class="pfc">
                    <div class="pfp" style="background:linear-gradient(135deg,#fef9c3,#fde68a)">📖</div>
                    <div class="pfb">
                        <div class="pfn">Aisyah Nur Fadilah</div>
                        <div class="pfd">📅 16/07/2025 — Bercerita</div>
                        <div class="pfnt">Aisyah berani tampil di depan kelas menceritakan kisah Nabi Ibrahim...</div>
                        <div class="fl fw g8 mt8">
                            <span class="ap a4">💬</span>
                            <span class="ap a5">❤️</span>
                        </div>
                        <div class="fs11 tc2 mt8">💬 3 komentar</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Portofolio Ibrahim --}}
        <div id="porto-ibrahim" class="porto-panel" style="display:none">
            <div class="g4 mt16">
                <div class="pfc">
                    <div class="pfp" style="background:linear-gradient(135deg,#dbeafe,#bfdbfe)">🕌</div>
                    <div class="pfb">
                        <div class="pfn">Ibrahim Khalil</div>
                        <div class="pfd">📅 15/07/2025 — Praktek Wudhu</div>
                        <div class="pfnt">Ibrahim mendemonstrasikan urutan wudhu dengan baik dan benar di depan kelas...
                        </div>
                        <div class="fl fw g8 mt8">
                            <span class="ap a1">🕌</span>
                            <span class="ap a5">❤️</span>
                        </div>
                        <div class="fs11 tc2 mt8">💬 1 komentar</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $(document).on('click', '[data-porto]', function() {
                var target = $(this).data('porto');

                // Reset semua tab dalam group
                $(this).closest('.tabs').find('.tbn').removeClass('on');
                $(this).addClass('on');

                // Sembunyikan semua panel lalu tampilkan yang dipilih
                $('.porto-panel').hide();
                $('#' + target).show();
            });
        });
    </script>
@endpush
