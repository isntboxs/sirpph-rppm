@extends('layout.app')

@section('page-title', 'Kelola Tema')
@section('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')

@section('content')
    <div class="card">
        <div class="ch">
            <div class="ct">📚 Kelola Tema</div>
            <button class="btn bp bsm" id="btn-tambah-tema">+ Tambah</button>
        </div>
        <div class="g2" style="gap:12px">
            <div class="card" style="border-color:var(--g2)">
                <div class="ch">
                    <div>
                        <div class="ct">Aku, Makhluq Allah</div>
                        <div class="cs">Semester 1 — 4 Sub Tema</div>
                    </div>
                    <button class="btn bd bxs">🗑️</button>
                </div>
                <div class="fl fw g8">
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Allah
                        Tuhanku</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Identitasku</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Tubuhku
                        / Aurat</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Panca
                        Indra</span>
                </div>
            </div>
            <div class="card" style="border-color:var(--g2)">
                <div class="ch">
                    <div>
                        <div class="ct">Tanah Airku</div>
                        <div class="cs">Semester 1 — 4 Sub Tema</div>
                    </div>
                    <button class="btn bd bxs">🗑️</button>
                </div>
                <div class="fl fw g8">
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Identitas
                        Negara</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Hari
                        Besar Nasional</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Lambang
                        Negara</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Elemen
                        Bangsa</span>
                </div>
            </div>
            <div class="card" style="border-color:var(--g2)">
                <div class="ch">
                    <div>
                        <div class="ct">Lingkunganku</div>
                        <div class="cs">Semester 1 — 4 Sub Tema</div>
                    </div>
                    <button class="btn bd bxs">🗑️</button>
                </div>
                <div class="fl fw g8">
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Rumahku</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Keluargaku</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Masjidku</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Sekolahku</span>
                </div>
            </div>
            <div class="card" style="border-color:var(--g2)">
                <div class="ch">
                    <div>
                        <div class="ct">Binatang Ciptaan Allah</div>
                        <div class="cs">Semester 2 — 5 Sub Tema</div>
                    </div>
                    <button class="btn bd bxs">🗑️</button>
                </div>
                <div class="fl fw g8">
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Binatang
                        Halal/Haram</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Binatang
                        Qurban</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Binatang
                        Buas</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Serangga</span>
                    <span
                        style="padding:4px 10px;background:var(--g0);border:1px solid var(--g2);border-radius:20px;font-size:11.5px">Binatang
                        Air & Udara</span>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#btn-tambah-tema').on('click', function() {
                $('#mTema').addClass('on');
            });
        });
    </script>
@endpush
