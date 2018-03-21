caches.open("Kushagra").then(function(cache) {
    console.log("cache opened successfully");
    var requestArray = ["http://localhost/learning/ui/img/140x100.png", "http://localhost/learning/ui/img/350x150.png", "http://localhost/learning/ui/img/200x100.png"];
    cache.addAll(requestArray);
});
caches.keys().then(function(cache) {
    console.log(cache)
});
caches.match("http://localhost/learning/ui/img/140x100.png").then(function(cache) {
    console.log("Matched");
});