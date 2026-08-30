const CACHE_NAME = 'pepperlemon-v2';
const ASSETS_TO_CACHE = [
  '/',
  '/manifest.json',
  '/images/icons/icon-192x192.png',
  '/images/icons/icon-512x512.png',
  '/images/logo.jpeg'
];

// Install Event - cache core shell assets and force immediate activation
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        return cache.addAll(ASSETS_TO_CACHE);
      })
      .then(() => {
        return self.skipWaiting();
      })
  );
});

// Activate Event - clean up old caches and claim active client pages immediately
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheName !== CACHE_NAME) {
            console.log('[Service Worker] Deleting old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    }).then(() => {
      return self.clients.claim();
    })
  );
});

// Fetch Event
self.addEventListener('fetch', (event) => {
  // Only handle GET requests
  if (event.request.method !== 'GET') {
    return;
  }

  const url = new URL(event.request.url);

  // Dynamic/authenticated routes that should bypass SW caching entirely
  const bypassRoutes = [
    '/admin',
    '/api',
    '/cart',
    '/checkout',
    '/dashboard',
    '/orders',
    '/profile',
    '/addresses',
    '/payment-methods',
    '/webhook',
    '/login',
    '/logout',
    '/register'
  ];

  const shouldBypass = bypassRoutes.some(route => url.pathname.startsWith(route));

  if (shouldBypass) {
    return; // Let the browser handle these normally (network only)
  }

  // Network-First strategy for HTML navigation requests (HTML pages)
  if (event.request.mode === 'navigate' || (event.request.headers.get('accept') && event.request.headers.get('accept').includes('text/html'))) {
    event.respondWith(
      fetch(event.request)
        .then((response) => {
          // If valid response, update the cache and return
          if (response && response.status === 200) {
            const responseClone = response.clone();
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(event.request, responseClone);
            });
          }
          return response;
        })
        .catch(() => {
          // Fallback to cache if offline
          return caches.match(event.request);
        })
    );
    return;
  }

  // Stale-While-Revalidate strategy for static assets (images, CSS, JS, fonts)
  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      const fetchPromise = fetch(event.request).then((networkResponse) => {
        if (networkResponse && networkResponse.status === 200) {
          const responseClone = networkResponse.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, responseClone);
          });
        }
        return networkResponse;
      }).catch(() => {
        // Ignore network errors for static files if they fail (e.g. offline)
      });

      return cachedResponse || fetchPromise;
    })
  );
});
