const cacheName = 'my-data-v43';
const resource = [
	'index.html',
	'manifest.json',
	'favicon.ico',
	'style.css',
	'pwa.js',
	'/media/CSS/bootstrap.css',
	'/media/JavaScript/jquery-3.3.1.min.js',
	'/media/JavaScript/knockout-3.4.0.js',
	'/media/images/ajax-loader.gif'
];

// install event
self.addEventListener('install', evt => {
	evt.waitUntil(
		caches.open(cacheName).then(cache => cache.addAll(resource))
	);
});

// activate event
self.addEventListener('activate', evt => {
	evt.waitUntil(
	  caches.keys().then(keys => {
	  	return Promise.all(keys.filter(key => key != cacheName).map(key => caches.delete(key)));
	  })
	);
});

// fetch event
self.addEventListener('fetch', evt => {
	evt.respondWith(caches.match(evt.request).then(cacheRes => cacheRes || fetch(evt.request)));
});