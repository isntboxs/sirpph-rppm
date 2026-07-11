const CACHE_NAME = 'sipenaqi-pwa-cache-v1';

self.addEventListener('install', function(event) {
    self.skipWaiting();
});

self.addEventListener('activate', function(event) {
    event.waitUntil(clients.claim());
});

self.addEventListener('fetch', function(event) {
    // Basic network-first strategy to fulfill PWA installability requirements
    // while keeping data fresh for the dynamic web app.
    event.respondWith(
        fetch(event.request).catch(function() {
            return caches.match(event.request);
        })
    );
});

self.addEventListener('push', function(event) {
    let title = 'SipenaQi Notifikasi';
    let options = {
        body: 'Anda mendapat pesan baru'
    };

    if (event.data) {
        try {
            const payload = event.data.json();
            if (payload.title) title = payload.title;
            if (payload.body) options.body = payload.body;
            // KITA HAPUS ICON DAN DATA UNTUK MENGHINDARI ERROR TYPE/SERIALIZATION DI ANDROID
        } catch (e) {
            options.body = 'Pesan baru diterima (format tidak valid)';
        }
    }

    event.waitUntil(
        self.registration.showNotification(title, options).catch(function(err) {
            console.error('Error showing notification:', err);
        })
    );
});

self.addEventListener('notificationclick', function(event) {

    event.notification.close();

    if (event.notification.data && event.notification.data.url) {
        event.waitUntil(
            clients.openWindow(event.notification.data.url)
        );
    }
});