/* BillSync service worker: cache static files only. */
const CACHE_NAME = 'billsync-static-v1';
const STATIC_PATHS = ['/build/assets/', '/images/', '/fonts/'];
const STATIC_FILE = /\.(?:css|js|mjs|png|jpe?g|gif|svg|webp|ico|woff2?|ttf|otf)$/i;

self.addEventListener('install', (event) => {
    // No precache list: app installation should not fail if optional icons are absent.
    event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', (event) => {
    event.waitUntil((async () => {
        const cacheNames = await caches.keys();
        await Promise.all(
            cacheNames
                .filter((name) => name.startsWith('billsync-static-') && name !== CACHE_NAME)
                .map((name) => caches.delete(name))
        );
        await self.clients.claim();
    })());
});

self.addEventListener('fetch', (event) => {
    const request = event.request;
    if (request.method !== 'GET' || request.headers.has('authorization')) return;

    const url = new URL(request.url);
    if (url.origin !== self.location.origin) return;

    const isFavicon = url.pathname === '/favicon.ico';
    const isManifest = url.pathname === '/manifest.json';
    const isStaticAsset = STATIC_PATHS.some((path) => url.pathname.startsWith(path))
        && STATIC_FILE.test(url.pathname);

    // Page navigations and all Laravel routes stay network-only. Only known static files
    // can use the cache, so auth/session, dashboard, IMAP, API, and POST flows are untouched.
    if (!isFavicon && !isManifest && !isStaticAsset) return;

    event.respondWith((async () => {
        const cache = await caches.open(CACHE_NAME);

        let response;
        try {
            response = await fetch(request);
        } catch (error) {
            const cachedResponse = await cache.match(request);
            if (cachedResponse) return cachedResponse;
            throw error;
        }

        if (response.ok && response.type === 'basic' && !response.redirected) {
            // Cache write failures should never prevent a successfully fetched asset loading.
            await cache.put(request, response.clone()).catch(() => {});
        }
        return response;
    })());
});
