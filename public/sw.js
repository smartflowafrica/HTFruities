const CACHE_NAME = "honeytee-pwa-v1";
const FILES_TO_CACHE = [
    "/",
    "/offline.html",
    "/pwa.png",
    "/frontend/default/assets/css/vendors.css",
    "/frontend/default/assets/css/aiz-core.css",
    "/frontend/default/assets/js/vendors.js",
    "/frontend/default/assets/js/aiz-core.js"
];

// Install Event: Cache core files
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(FILES_TO_CACHE);
        })
    );
    self.skipWaiting();
});

// Activate Event: Clean up old caches
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((keyList) => {
            return Promise.all(
                keyList.map((key) => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// Fetch Event: Network First for HTML, Cache First for assets
self.addEventListener("fetch", (event) => {
    // Skip cross-origin requests
    if (!event.request.url.startsWith(self.location.origin)) {
        return;
    }

    // Identify if it's an HTML navigation request
    const isNavigation = event.request.mode === "navigate";

    if (isNavigation) {
        event.respondWith(
            fetch(event.request)
                .catch(() => {
                    return caches.match("/offline.html");
                })
        );
    } else {
        // Cache-First for static assets
        event.respondWith(
            caches.match(event.request).then((response) => {
                return response || fetch(event.request);
            })
        );
    }
});
