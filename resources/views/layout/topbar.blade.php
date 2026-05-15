<div class="tb">
    <div class="tbt">
        <h2 data-page-title>@yield('page-title', 'Beranda')</h2>
        <p data-page-subtitle>@yield('page-subtitle', \App\Models\DataSekolah::getData()?->name . ' - ' . \App\Models\TahunAjaran::getActive()?->name)</p>
    </div>
    <div class="tbr">
        <div style="position:relative">
            <div class="notif-bell">🔔 <span class="notif-count">3</span></div>
            <div class="notif-dropdown">
                <div class="nd-head">
                    <span>Notifikasi</span>
                    <button class="btn bo bxs">Tandai semua dibaca</button>
                </div>
                <div>
                    <div class="nd-item unread">
                        <div class="nd-title">📝 RPPM Baru Menunggu</div>
                        <div class="nd-msg">Guru Kelas A mengajukan RPPM "Aku, Makhluq Allah"</div>
                        <div class="nd-time">🕐 5 menit lalu</div>
                    </div>
                    <div class="nd-item unread">
                        <div class="nd-title">📄 RPPH Menunggu Validasi</div>
                        <div class="nd-msg">Guru Kelas B mengajukan RPPH hari Senin</div>
                        <div class="nd-time">🕐 1 jam lalu</div>
                    </div>
                    <div class="nd-item">
                        <div class="nd-title">RPPM Disetujui</div>
                        <div class="nd-msg">RPPM "Tanah Airku" telah disetujui</div>
                        <div class="nd-time">🕐 Kemarin</div>
                    </div>
                </div>
            </div>
        </div>
        <span class="rbdg {{ Auth::user()->roleBadge() }}">
            {{ Auth::user()->roleText() }}
        </span>
        <span style="font-size:11.5px;color:var(--txt3)">{{ now()->format('d/m/Y') }}</span>
    </div>
</div>
