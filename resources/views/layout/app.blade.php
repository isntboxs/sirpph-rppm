<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Beranda') - SIPENAQI</title>

    <meta name="page-title" content="@yield('page-title', 'Beranda')">
    <meta name="page-subtitle" content="@yield('page-subtitle', 'PAUDQu AL-AULIA - 2024/2025')">
    
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta name="apple-mobile-web-app-title" content="SipenaQi">
    <link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}">

    <!-- Open Graph / Link Preview Meta Tags -->
    <meta property="og:title" content="SIPENAQI - Sistem Perencanaan Qurani Integratif">
    <meta property="og:description" content="Aplikasi Raport dan RPP terpadu untuk PAUDQu AL-AULIA">
    <meta property="og:image" content="{{ asset('logo.jpeg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SIPENAQI - Sistem Perencanaan Qurani Integratif">
    <meta name="twitter:description" content="Aplikasi Raport dan RPP terpadu untuk PAUDQu AL-AULIA">
    <meta name="twitter:image" content="{{ asset('logo.jpeg') }}">
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

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            // Hamburger menu toggle for mobile
            $(document).on('click', '#menuToggle', function(e) {
                e.stopPropagation();
                $('.sb').toggleClass('show-sidebar');
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.sb').length && !$(e.target).closest('#menuToggle').length) {
                    $('.sb').removeClass('show-sidebar');
                }
            });

            window.applyResponsiveTables = function() {
                $('table').each(function() {
                    var $table = $(this);
                    var headers = [];
                    $table.find('thead th').each(function() {
                        headers.push($(this).text().trim());
                    });
                    $table.find('tbody tr').each(function() {
                        $(this).find('td').each(function(index) {
                            if (headers[index] && !$(this).attr('data-label')) {
                                $(this).attr('data-label', headers[index]);
                            }
                        });
                    });
                });
            };

            window.applyResponsiveTables();
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

            $(document).on('click', function() {
                $('.notif-dropdown').removeClass('show');
                $('#notifDropdown').removeClass('show');
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

            window.confirmAction = function(message, callback) {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: message,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1f2937',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                    }
                });
            };

            // Handler global untuk form yang butuh konfirmasi
            $(document).on('click', '.btn-confirm-submit', function(e) {
                e.preventDefault();
                var $btn = $(this);
                var form = $btn.closest('form');
                var msg = $btn.data('confirm-msg') || 'Apakah Anda yakin?';
                var actionVal = $btn.val() || $btn.attr('value');
                
                window.confirmAction(msg, function() {
                    if (actionVal) {
                        $('<input>').attr({type: 'hidden', name: 'action', value: actionVal}).appendTo(form);
                    }
                    form.submit();
                });
            });

            $(document).on('click', '.mf .bp:not(.btn-submit-form)', function() {
                $(this).closest('.mo').removeClass('on');
                window.showToast();
            });
        });
    </script>
    @if (Auth::user()->role !== 'admin')
        <script>
            // ---------------- Kolom Notifikasi ----------------
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

            function loadNotifikasi(background = false) {
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

                        // Jika sedang tidak dibuka, jangan ubah isi list htmlnya agar tidak mengganggu kalau user pas lagi buka
                        if (background && !$('#notifDropdown').hasClass('show')) {
                            return;
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

            loadNotifikasi(true);
            setInterval(function() {
                loadNotifikasi(true);
            }, 15000);

            $(document).on('ajaxNavigationComplete', function() {
                if (typeof window.applyResponsiveTables === 'function') {
                    window.applyResponsiveTables();
                }
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


        </script>
    @endif
    <script>
        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }

        function subscribeUserToPush(registration) {
            const vapidPublicKey = '{{ config("webpush.vapid.public_key") }}';
            if (!vapidPublicKey) {
                console.warn('VAPID_PUBLIC_KEY kosong! Pastikan .env sudah terbaca.');
                return;
            }
            
            const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey);

            registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: convertedVapidKey
            })
            .then(function(subscription) {
                const subData = subscription.toJSON();
                $.ajax({
                    url: '/notifikasi/web-push',
                    type: 'POST',
                    data: {
                        endpoint: subData.endpoint,
                        keys: {
                            auth: subData.keys.auth,
                            p256dh: subData.keys.p256dh
                        },
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        console.log('Push subscription tersimpan ke server. Notifikasi siap!');
                    },
                    error: function(err) {
                        console.error('Gagal menyimpan push subscription ke server.', err);
                    }
                });
            })
            .catch(function(err) {
                console.error('Gagal berlangganan push notification: ', err);
            });
        }

        if ('serviceWorker' in navigator && 'PushManager' in window) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/webpush-sw.js?v=4')
                    .then(function(registration) {
                        console.log('Service Worker terdaftar:', registration.scope);
                        
                        // Periksa apakah izin sudah diberikan
                        if (Notification.permission === 'granted') {
                            subscribeUserToPush(registration);
                        } else if (Notification.permission !== 'denied') {
                            // Minta izin
                            Notification.requestPermission().then(function(permission) {
                                if (permission === 'granted') {
                                    subscribeUserToPush(registration);
                                }
                            });
                        }
                    })
                    .catch(function(err) {
                        console.log('Service worker gagal terdaftar:', err);
                    });
            });
        }
    </script>
    @stack('scripts')
</body>

</html>
