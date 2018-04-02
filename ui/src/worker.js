// var dworker = new Worker("src/dworker.js");
// dworker.onmessage = function(data) {
//     console.log("%c", "background: #333333; color: red", data);
// };
// dworker.postMessage({'name': "kushagra", "age": "30"});

// var sworker = new SharedWorker('src/sworker.js');

// sworker.port.onmessage = function(data) {
//     console.log("%c", "background: #333333; color: red", data);
// };

// // sworker.port.start(); // opens a port connection to shared worker.// not required if onmessage event is bound once onmessage event is bound on worker it opens connection to the parent on that port.
// sworker.port.postMessage("Hello shared worker. I am main script.");


// // worker.terminate(); // terminate the worker thread without closing or doing any cleanup work.

// navigator.serviceWorker.register("src/serviceworker.js").then(function(registration) {
//     console.log('Service worker registration succeeded:', registration);
// }).catch(function(error) {
//     console.log('Service worker registration failed:', error);
// });


// Generates error The path of the provided scope ('/learning/ui/') is not under the max scope allowed ('/learning/ui/src/'). Adjust the scope, move the Service Worker script, or use the Service-Worker-Allowed HTTP header to allow the scope.
// navigator.serviceWorker.register("src/serviceworker.js", {scope: "./"}).then(function(registration) {
//     console.log('Service worker registration succeeded:', registration);
// }).catch(function(error) {
//     console.log('Service worker registration failed:', error);
// });

// above can be rectified using 
console.log("inside worker");
navigator.serviceWorker.register("src/serviceworker.js", {scope: "./src/"}).then(function(registration) {
    console.log('Service worker registration succeeded:', registration);
    console.log('Service worker registered with scope: ', registration.scope);
}).catch(function(error) {
    console.log('Service worker registration failed:', error);
});

// navigator.serviceWorker.register("serviceworker.js").then(function(registration) {
//     console.log('Service worker registration succeeded:', registration);
//     console.log('Service worker registered with scope: ', registration.scope);
// }).catch(function(error) {
//     console.log('Service worker registration failed:', error);
// });