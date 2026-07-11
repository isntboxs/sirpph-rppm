<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPENAQI {{ $sekolah->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta name="apple-mobile-web-app-title" content="SipenaQi">
    <link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}">

    <!-- Open Graph / Link Preview Meta Tags -->
    <meta property="og:title" content="Login - SIPENAQI {{ $sekolah->name }}">
    <meta property="og:description" content="Aplikasi Raport dan RPP terpadu untuk PAUDQu AL-AULIA">
    <meta property="og:image" content="{{ asset('logo.jpeg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Login - SIPENAQI {{ $sekolah->name }}">
    <meta name="twitter:description" content="Aplikasi Raport dan RPP terpadu untuk PAUDQu AL-AULIA">
    <meta name="twitter:image" content="{{ asset('logo.jpeg') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}">
    @if (file_exists(public_path('assets/custom-login.css')))
        <link rel="stylesheet"
            href="{{ asset('assets/custom-login.css') }}?v={{ filemtime(public_path('assets/custom-login.css')) }}">
    @endif
</head>

<body>
    <div id="lp">
        <div class="ll">
            <h1>SI<span>PENAQI</span></h1>
            <p>Sistem Perencanaan Qurani Integratif<br>{{ $sekolah->name }} - Kota Tangerang, Banten</p>
        </div>
        <div class="lr">
            <div class="lc">
                <div class="lb">
                    <div class="bi" style="text-align:center;">
                        <img src="{{ asset('logo.jpeg') }}" alt="Logo"
                            style="width:100px; height:100px; object-fit:cover;">
                    </div>
                    <h2 style="text-align:center;">Masuk ke SIPENAQI</h2>
                    <p style="text-align:center;">{{ $sekolah->name }} - Tahun Ajaran {{ \App\Models\TahunAjaran::getActive()?->name }}</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="fg">
                        <label>Username</label>
                        <input name="username" placeholder="Username" value="{{ old('username') }}"
                            autocomplete="username" />
                    </div>
                    <div class="fg">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Password" autocomplete="current-password" />
                    </div>
                    @if ($errors->any())
                        <div id="lerr" style="display:block">{{ $errors->first() }}</div>
                    @endif
                    <button type="submit" class="btn-login">🔐 Masuk ke Sistem</button>
                    <div style="text-align:center; margin-top:15px; font-size:14px;">
                        <a href="javascript:void(0)" id="btnLupaPassword" style="color:var(--g5); text-decoration:none; font-weight:600;">Lupa Password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/webpush-sw.js?v=11').then(function(registration) {
                    console.log('PWA ServiceWorker registration successful');
                }).catch(function(err) {
                    console.log('PWA ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>

    <!-- Modal Lupa Password -->
    <div class="mo" id="mReset" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; justify-content:center; align-items:center;">
        <div class="mc" style="position:absolute; top:0; left:0; width:100%; height:100%;"></div>
        <div class="mw" style="background:#fff; width:90%; max-width:400px; border-radius:12px; padding:24px; position:relative; z-index:1000; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <h3 style="margin:0; font-size:18px; color:var(--txt);">Lupa Password</h3>
                <button class="mc-btn" style="background:transparent; border:none; font-size:20px; color:var(--txt3); cursor:pointer;">&times;</button>
            </div>
            <p style="font-size:14px; color:var(--txt3); margin-bottom:20px;">Masukkan username Anda dan password baru yang diinginkan.</p>
            <div class="fg" style="margin-bottom:16px;">
                <label style="display:block; margin-bottom:6px; font-size:14px; color:var(--txt2); font-weight:600;">Username</label>
                <input type="text" id="reset_username" style="width:100%; padding:10px 14px; border:1px solid #ccc; border-radius:8px;" placeholder="Username terdaftar" />
            </div>
            <div class="fg" style="margin-bottom:24px;">
                <label style="display:block; margin-bottom:6px; font-size:14px; color:var(--txt2); font-weight:600;">Password Baru</label>
                <input type="password" id="reset_password_baru" style="width:100%; padding:10px 14px; border:1px solid #ccc; border-radius:8px;" placeholder="Password baru" />
            </div>
            <div style="display:flex; justify-content:flex-end; gap:12px;">
                <button class="mc-btn" style="padding:10px 16px; background:#f4f7f5; color:var(--txt2); border-radius:8px; font-weight:600;">Batal</button>
                <button id="btnSubmitReset" style="padding:10px 16px; background:var(--g5); color:#fff; border-radius:8px; font-weight:600;">Kirim</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $('#btnLupaPassword').on('click', function() {
                $('#mReset').css('display', 'flex');
            });

            $('.mc, .mc-btn').on('click', function(e) {
                if ($(e.target).hasClass('mc') || $(e.target).hasClass('mc-btn')) {
                    Swal.fire({
                        title: 'Batalkan perubahan Password?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, batalkan',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#mReset').hide();
                            $('#reset_username').val('');
                            $('#reset_password_baru').val('');
                        }
                    });
                }
            });

            $('#btnSubmitReset').on('click', function() {
                let username = $('#reset_username').val().trim();
                let password_baru = $('#reset_password_baru').val();

                if (!username || !password_baru) {
                    Swal.fire('Error', 'Username dan Password baru wajib diisi!', 'error');
                    return;
                }

                if (password_baru.length < 4) {
                    Swal.fire('Error', 'Password baru minimal 4 karakter!', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Kirim perubahan Password ke Admin?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Kirim',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({ title: 'Memproses...', allowOutsideClick: false });
                        Swal.showLoading();
                        
                        $.ajax({
                            url: '/password-reset-request',
                            type: 'POST',
                            data: {
                                username: username,
                                password_baru: password_baru
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res) {
                                $('#mReset').hide();
                                $('#reset_username').val('');
                                $('#reset_password_baru').val('');
                                
                                Swal.fire({
                                    title: 'Berhasil!',
                                    html: 'Permintaan reset password berhasil dibuat. Silakan sebutkan kode keamanan ini ke Admin:<br><br><b style="font-size:24px; letter-spacing:2px;">[' + res.code + ']</b>',
                                    icon: 'success'
                                });
                            },
                            error: function(xhr) {
                                let errorMsg = 'Gagal mengirim permintaan';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg = xhr.responseJSON.message;
                                }
                                Swal.fire('Gagal', errorMsg, 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
