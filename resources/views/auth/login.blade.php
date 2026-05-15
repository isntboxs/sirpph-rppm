<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPENAQI {{ $sekolah->name }}</title>
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
</body>

</html>
