<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Beranda') - SIPENAQI</title>

    <meta name="page-title" content="@yield('page-title', 'Beranda')">
    <meta name="page-subtitle" content="@yield('page-subtitle', 'PAUDQu AL-AULIA - 2024/2025')">
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
    @if (Auth::user()->role !== 'admin')
        <script>
            // ---------------- Notification Field ----------------
            $(document).on('click', '.notif-bell', function(e) {
                e.stopPropagation();

                var $dropdown = $('#notifDropdown');

                $dropdown.toggleClass('show');

                if ($dropdown.hasClass('show')) {
                    loadNotifikasi();
                }
            });

            $(document).on('click', function() {
                $('#notifDropdown').removeClass('show');
            });

            function loadNotifikasi() {
                $.get('/notifikasi')
                    .done(function(res) {
                        var count = res.unread_count;

                        if (count > 0) {
                            $('#notifCount')
                                .text(count > 99 ? '99+' : count)
                                .show();
                        } else {
                            $('#notifCount').hide();
                        }

                        if (res.notifikasis.length === 0) {
                            $('#notifList').html(
                                '<div style="padding:20px;text-align:center;color:var(--txt3);font-size:12px">' +
                                '✅ Tidak ada notifikasi' +
                                '</div>'
                            );
                            return;
                        }

                        var html = '';

                        $.each(res.notifikasis, function(i, n) {
                            html +=
                                '<div class="nd-item ' + (n.dibaca ? '' : 'unread') + '"' +
                                ' data-id="' + n.id + '"' +
                                ' data-url="' + n.url + '"' +
                                ' style="cursor:pointer">' +
                                '<div class="nd-title">' + n.icon + ' ' + n.judul + '</div>' +
                                '<div class="nd-msg">' + n.pesan + '</div>' +
                                '<div class="nd-time">🕐 ' + n.waktu + '</div>' +
                                '</div>';
                        });

                        $('#notifList').html(html);
                    });
            }

            $(document).on('click', '.nd-item[data-id]', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                var $el = $(this);

                $.ajax({
                        url: '/notifikasi/' + id + '/baca',
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                    })
                    .done(function() {
                        $el.removeClass('unread');

                        if (url && url !== '#') {
                            $('#notifDropdown').removeClass('show');

                            // loadPage(url, true);
                            location.href = url;
                        }
                    });
            });

            $('#btnBacaSemua').on('click', function(e) {
                e.stopPropagation();

                $.ajax({
                        url: '/notifikasi/baca-semua',
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                    })
                    .done(function() {
                        $('#notifList .nd-item').removeClass('unread');
                        $('#notifCount').hide();
                    });
            });

            $.get('/notifikasi')
                .done(function(res) {
                    var count = res.unread_count;

                    if (count > 0) {
                        $('#notifCount')
                            .text(count > 99 ? '99+' : count)
                            .show();
                    }
                });

            $(document).on('ajaxNavigationComplete', function() {
                $.get('/notifikasi')
                    .done(function(res) {
                        var count = res.unread_count;

                        count > 0 ?
                            $('#notifCount')
                            .text(count > 99 ? '99+' : count)
                            .show() :
                            $('#notifCount').hide();
                    });
            });

            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/webpush-sw.js');
            }
        </script>
    @endif
    @stack('scripts')
</body>

</html>
