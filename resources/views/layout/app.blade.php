<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Beranda') — SiRPPH</title>

    <meta name="page-title" content="@yield('page-title', 'Beranda')">
    <meta name="page-subtitle" content="@yield('page-subtitle', 'PAUDQu AL-AULIA — 2024/2025')">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap"
        rel="stylesheet">
        <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}">
    @if (file_exists(public_path('assets/custom-app.css')))
        <link rel="stylesheet"
            href="{{ asset('assets/custom-app.css') }}?v={{ filemtime(public_path('assets/custom-app.css')) }}">
    @endif
</head>

{{-- Jquery --}}
<script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

{{-- Custom --}}
<script src="{{ asset('assets/js/custom/utils.js') }}"></script>

<body>
    <div class="shell">
        @include('layout.sidebar')
        <main class="mn">
            @include('layout.topbar')
            <div class="ca" id="main-content">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- @include('layout.modals') --}}

    <div id="toast"></div>

    <script>
        $(function() {
            setActiveSidebar(window.location.pathname);

            window.history.replaceState({
                url: window.location.href
            }, '', window.location.href);

            // $(document).on('click', '.sb a.ni', function(e) {
            //     e.preventDefault();
            //     var url = $(this).attr('href');

            //     // Jangan reload kalau halaman sama
            //     if (url === window.location.href) return;

            //     // loadPage(url, true);
            //     // window.location.reload();
            // });

            $(document).on('click', '.mc', function() {
                $(this).closest('.mo').removeClass('on');
            });

            $(document).on('click', '.mo', function(e) {
                if (e.target === this) {
                    $(this).removeClass('on');
                }
            });

            $(document).on('click', '.notif-bell', function(e) {
                e.stopPropagation();
                $('.notif-dropdown').toggleClass('show');
            });

            $(document).on('click', function() {
                $('.notif-dropdown').removeClass('show');
            });

            $(document).on('click', '.tabs .tbn', function() {
                $(this).closest('.tabs').find('.tbn').removeClass('on');
                $(this).addClass('on');
            });

            window.showToast = function(msg) {
                var $t = $('#toast');
                if (!$t.length) return;
                $t.text(msg).fadeIn(200);
                setTimeout(function() {
                    $t.fadeOut(400);
                }, 2500);
            };

            $(document).on('click', '.mf .bp:not(.btn-submit-form)', function() {
                $(this).closest('.mo').removeClass('on');
                window.showToast();
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
