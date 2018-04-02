console.log("This is from inside service worker.");
oninstall = function(e) {
    console.log('%c Installing Service worker. ',"background: black; color: #fff", e);    
}

onactivate = function(e) {
    console.log('%c Activating Service worker. ',"background: black; color: #fff", e);    
}
self.addEventListener('fetch', function(e) {
    console.log('%c Fetching Service worker. ',"background: black; color: #fff", e);
    console.log("Request", e.request)    
    // e.respondWith(
    //     caches.match(e.request).then((response) => {
    //         console.log("Matched Initially");
    //         console.log(response);
    //         // return response;
    //     }).catch((error) => {
    //         console.log("Logging: ", e.request);
    //         caches.open("Kushagra").then((cache) => {
    //             console.log(JSON.stringify(e.request));
    //             var response = cache.add(e.request);
    //             // console.log("Inside opening cache");
    //             // cache.keys().then(function(keys) {console.log(keys);})
    //             // console.log("Matching: ");
    //             // caches.match(e.request).then(function(cache) {
    //             //     console.log("Matched: ", cache);
    //             // }).catch(function(error) {
    //             //     console.log("Couldnot match");
    //             // });
    //             // return response;
    //         });
    //     })
    // );
})
// onfetch = function(e) {
    
// }