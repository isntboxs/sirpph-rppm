<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiRPPH — PAUDQu AL-AULIA</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @if (file_exists(public_path('assets/custom-app.css')))
        <link rel="stylesheet"
            href="{{ asset('assets/custom-app.css') }}?v={{ filemtime(public_path('assets/custom-app.css')) }}">
    @endif
</head>

<body>
    <div class="shell">
        @include('layout.sidebar')
        <main class="mn">
            @include('layout.topbar')
            <div class="ca">
                @yield('content')
            </div>
        </main>
    </div>

    @include('layout.modals')

    <div id="toast">✅ Data berhasil disimpan</div>

    {{-- Jquery --}}
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <script>
        // Global: modal open/close
        document.querySelectorAll('.mc').forEach(function(btn) {
            btn.addEventListener('click', function() {
                this.closest('.mo').classList.remove('on');
            });
        });
        document.querySelectorAll('.mo').forEach(function(mo) {
            mo.addEventListener('click', function(e) {
                if (e.target === this) this.classList.remove('on');
            });
        });

        // Global: notification bell toggle
        var bell = document.querySelector('.notif-bell');
        var dropdown = document.querySelector('.notif-dropdown');
        if (bell && dropdown) {
            bell.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('show');
            });
            document.addEventListener('click', function() {
                dropdown.classList.remove('show');
            });
        }

        // Global: tab switching
        document.querySelectorAll('.tabs').forEach(function(tabGroup) {
            tabGroup.querySelectorAll('.tbn').forEach(function(btn, i) {
                btn.addEventListener('click', function() {
                    tabGroup.querySelectorAll('.tbn').forEach(function(b) {
                        b.classList.remove('on');
                    });
                    this.classList.add('on');
                });
            });
        });

        // Global: toast helper
        function showToast(msg) {
            var t = document.getElementById('toast');
            if (!t) return;
            t.textContent = (msg || '✅ Data berhasil disimpan');
            t.style.display = 'block';
            setTimeout(function() {
                t.style.display = 'none';
            }, 2500);
        }

        // Save buttons show toast
        document.querySelectorAll('.mf .bp').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var mo = this.closest('.mo');
                if (mo) {
                    mo.classList.remove('on');
                }
                showToast();
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
