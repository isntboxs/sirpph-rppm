<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Beranda') - SiRPPH</title>

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

            window.updateBadgeCount = function(id, cnt) {
                var selector = id.startsWith('#') ? id : '#' + id;
                var $el = $(selector);
                if (!$el.length) return;

                cnt = Number(cnt) || 0;
                cnt > 0 ? $el.text(cnt).show() : $el.hide();
            };

            window.decrementBadgeCount = function(id) {
                var selector = id.startsWith('#') ? id : '#' + id;
                var $el = $(selector);
                if (!$el.length) return;

                var cnt = Math.max(0, (Number($el.text()) || 0) - 1);
                cnt > 0 ? $el.text(cnt).show() : $el.hide();
            };

            window.fetchBadgeCounts = function() {
                $.get('{{ route('badge.update') }}')
                    .done(function(data) {
                        window.updateBadgeCount('bdg-cnt-validasi-rppm', data.rppm_count);
                        window.updateBadgeCount('bdg-cnt-validasi-rpph', data.rpph_count);
                        window.updateBadgeCount('bdg-cnt-validasi-kegiatan', data.kegiatan_count);
                    });
            };

            @if (Auth::user()->isKepalaSekolah())
                window.fetchBadgeCounts();
            @endif

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
