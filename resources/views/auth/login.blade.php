<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SiRPPH PAUDQu AL-AULIA</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @if (file_exists(public_path('assets/custom-login.css')))
        <link rel="stylesheet"
            href="{{ asset('assets/custom-login.css') }}?v={{ filemtime(public_path('assets/custom-login.css')) }}">
    @endif
</head>

<body>
    <div id="lp">
        <div class="ll">
            <h1>Si<span>RPPH</span></h1>
            <p>Sistem Informasi Penyusunan RPPM & RPPH<br>PAUDQu AL-AULIA — Kota Serang</p>
            <div class="role-chips">
                <div class="rc">
                    <div class="rc-ico">⚙️</div>
                    <div>
                        <div class="rc-nm">Admin/Operator</div>
                        <div class="rc-ds">Kelola data master</div>
                    </div>
                </div>
                <div class="rc">
                    <div class="rc-ico">👑</div>
                    <div>
                        <div class="rc-nm">Kepala Sekolah</div>
                        <div class="rc-ds">Validasi & PROSEM</div>
                    </div>
                </div>
                <div class="rc">
                    <div class="rc-ico">🧑‍🏫</div>
                    <div>
                        <div class="rc-nm">Guru</div>
                        <div class="rc-ds">Buat RPPM & RPPH</div>
                    </div>
                </div>
                <div class="rc">
                    <div class="rc-ico">👨‍👩‍👧</div>
                    <div>
                        <div class="rc-nm">Orang Tua</div>
                        <div class="rc-ds">Pantau anak</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lr">
            <div class="lc">
                <div class="lb">
                    <div class="bm">📚</div>
                    <h2>Masuk ke SiRPPH</h2>
                    <p>PAUDQu AL-AULIA — Tahun Ajaran 2024/2025</p>
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
                    <div class="fg">
                        <label>Masuk Sebagai</label>
                        <select name="role">
                            <option value="admin">⚙️ Admin / Operator</option>
                            <option value="kepala">👑 Kepala Sekolah</option>
                            <option value="guru">🧑‍🏫 Guru</option>
                            <option value="ortu">👨‍👩‍👧 Orang Tua</option>
                        </select>
                    </div>
                    @if ($errors->any())
                        <div id="lerr" style="display:block">{{ $errors->first() }}</div>
                    @endif
                    <button type="submit" class="btn-login">🔐 Masuk ke Sistem</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function fillDemo(user, pass, role) {
            document.querySelector('input[name=username]').value = user;
            document.querySelector('input[name=password]').value = pass;
            var sel = document.querySelector('select[name=role]');
            for (var i = 0; i < sel.options.length; i++) {
                if (sel.options[i].value === role) {
                    sel.selectedIndex = i;
                    break;
                }
            }
        }
    </script>
</body>

</html>
