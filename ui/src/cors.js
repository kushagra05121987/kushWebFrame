// console.log(startWatcher());

// Followgin request will not work because no cors headers are set to allow the access to a simple request such as Access-Control-Allow-Origin.
// $.get("http://sysblog.local:8080/noCorsHeaders.php", function(message) {
//     console.log("Message ", message)
// });

// var headers = new Headers();
// headers.append("custom-x", "custom-x-value");

// // checking with credentials
// var request = new Request("http://sysblog.local:8080/noCorsHeaders.php", {
//     credentials: 'include',
//     headers: headers
// });

// fetch(request).then(function(response) {
//     console.log(response);
// }, function(err) {
//     console.log(err);
// });

// Access-Control-Expose-Headers
fetch("http://sysblog.local:8080/noCorsHeaders.php").then(function(response) {
    console.log(response);
    var headers = response.headers;
    console.log(headers.getAll()) // getall is removed
    console.log(headers.get('custom-x'));
    console.log(headers.get('custom-y')); // returns null because of Access-Control-Expose-Headers
});