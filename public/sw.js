const CACHE_NAME = 'desentra-v1.0';
const STATIC_ASSETS = [
  '/',
  '/css/app.css',
  '/manifest.json',
  '/img/icon.svg',
];

// Install: Simpan shell app dan core assets ke cache
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(STATIC_ASSETS);
    })
  );
  self.skipWaiting();
});

// Activate: Bersihkan cache lama
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys.map((key) => {
          if (key !== CACHE_NAME) {
            return caches.delete(key);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// Fetch: Strategi Network-First dengan Fallback ke Cache untuk halaman publik
self.addEventListener('fetch', (event) => {
  const request = event.request;
  const url = new URL(request.url);

  // Jangan cache POST request, API chat AI, pengaduan, atau route admin
  if (
    request.method !== 'GET' ||
    url.pathname.startsWith('/admin') ||
    url.pathname.startsWith('/api') ||
    url.pathname.includes('/tanya/ask')
  ) {
    return;
  }

  event.respondWith(
    fetch(request)
      .then((networkResponse) => {
        // Jika response valid dan merupakan halaman panduan/info desa/beranda, simpan update ke cache
        if (networkResponse && networkResponse.status === 200) {
          const responseToCache = networkResponse.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(request, responseToCache);
          });
        }
        return networkResponse;
      })
      .catch(() => {
        // Saat offline, ambil dari cache
        return caches.match(request).then((cachedResponse) => {
          if (cachedResponse) {
            return cachedResponse;
          }
          // Jika request adalah halaman HTML (bukan gambar/CSS/JS), baru fallback ke beranda
          const acceptHeader = request.headers.get('accept') || '';
          if (request.destination === 'document' || acceptHeader.includes('text/html')) {
            return caches.match('/');
          }
          return new Response('', { status: 404, statusText: 'Not Found' });
        });
      })
  );
});
