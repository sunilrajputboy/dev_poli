var cacheName = 'polimapper-cache-' + (self.registration ? self.registration.scope : '');

self.addEventListener('install', function(event) {
  self.skipWaiting();
});

// this is the service worker which intercepts all http requests
self.addEventListener('fetch', function fetcher (event) {
  var request = event.request;
  // check if request
  if (self.location.hostname !== 'localhost') {
    // contentful asset detected
    event.respondWith(
      caches.match(request).then(function(response) {
        if (response) {
          console.log(`returned from cache: ${request.url}`);

          fetch(request).then(function(response) {
            caches.open(cacheName).then(function(cache) {
              console.log(`adding to cache in background: ${request.url}`);
              cache.put(request.url, response.clone());
            });
          });

          return response;
        }

        console.log(`fetching: ${request.url}`);

        return fetch(request).then(function(response) {
          return caches.open(cacheName).then(function(cache) {
            cache.put(request.url, response.clone());
            return response;
          });
        });
      })
    );
  }
  // otherwise: ignore event
});
