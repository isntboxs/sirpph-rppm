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
        $(function() {
            // Modal: tombol ✕ tutup modal
            $(document).on('click', '.mc', function() {
                $(this).closest('.mo').removeClass('on');
            });

            // Modal: klik backdrop (luar modal) tutup modal 
            $(document).on('click', '.mo', function(e) {
                if ($(e.target).is('.mo')) {
                    $(this).removeClass('on');
                }
            });

            // Notifikasi: toggle dropdown bell 
            $(document).on('click', '.notif-bell', function(e) {
                e.stopPropagation();
                $('.notif-dropdown').toggleClass('show');
            });

            $(document).on('click', function() {
                $('.notif-dropdown').removeClass('show');
            });

            // Tab switching global 
            $(document).on('click', '.tabs .tbn', function() {
                $(this).closest('.tabs').find('.tbn').removeClass('on');
                $(this).addClass('on');
            });

            // Toast helper 
            window.showToast = function(msg) {
                var $t = $('#toast');
                if (!$t.length) return;
                $t.text(msg || '✅ Data berhasil disimpan').fadeIn(200);
                setTimeout(function() {
                    $t.fadeOut(400);
                }, 2500);
            };

            // Tombol simpan di modal: tutup modal + tampilkan toast
            $(document).on('click', '.mf .bp', function() {
                $(this).closest('.mo').removeClass('on');
                window.showToast();
            });

        });
    </script>
    @stack('scripts')
</body>

</html>
