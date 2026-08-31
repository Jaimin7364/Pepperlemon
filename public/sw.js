const CACHE_NAME = 'pepperlemon-v3';
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

  // Use Network-First strategy for EVERYTHING to ensure fresh content is always shown when online
  event.respondWith(
    fetch(event.request)
      .then((response) => {
        // If valid response, update the cache and return
        if (response && response.status === 200 && response.type === 'basic') {
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
});
