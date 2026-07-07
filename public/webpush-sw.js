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
    let title = 'Notifikasi Baru';
    let options = {
        body: 'Anda mendapat pesan baru',
        vibrate: [200, 100, 200, 100, 200, 100, 200],
        requireInteraction: true
    };

    if (event.data) {
        try {
            const data = event.data.json();
            title = data.title || title;
            options.body = data.body || options.body;
            options.icon = data.icon || '/logo_baru.png';
            options.data = data.data || null;
        } catch (e) {
            options.body = event.data.text() || options.body;
        }
    }

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

self.addEventListener('notificationclick', function(event) {

    event.notification.close();

    if (event.notification.data.url) {
        event.waitUntil(
            clients.openWindow(event.notification.data.url)
        );
    }
});