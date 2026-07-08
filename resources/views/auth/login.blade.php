<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPENAQI {{ $sekolah->name }}</title>
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
                </form>
            </div>
        </div>
    </div>
    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/webpush-sw.js').then(function(registration) {
                    console.log('PWA ServiceWorker registration successful');
                }).catch(function(err) {
                    console.log('PWA ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>
</body>
</html>
