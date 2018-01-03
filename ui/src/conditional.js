// $.ajaxSetup({
//     // dataType: 'json'
    
// });

var responseXHR;
var responseXHRLength;
var initialContentLength;
var Etag;
// var get = $.get("http://localhost/learning/rangesConditional.php");
// var ajax = $.ajax({
//     url: "http://sysblog.local:8080/rangesConditional.php",
//     type: "HEAD",
//     success: function(response, texStatus, jqXHR) {
//         console.log("success", jqXHR.getAllResponseHeaders())
//         initialContentLength = jqXHR.getResponseHeader('Content-Length')
//         Etag = jqXHR.getResponseHeader('Etag')
        
//     }
// });


var ajax = $.ajax({
    url: "http://sysblog.local:8080/rangesConditional.php",
    type: "GET",
    beforeSend: function() {
        setTimeout(function() {
            console.log("TIMEOUT");
            ajax.abort();
        }, 3000);
    },
    xhr: function() {
        var xhr = $.ajaxSettings.xhr();
        xhr.onprogress = function(e) {
            console.log(e);
            responseXHR = xhr.responseText;
            responseXHRLength = responseXHR.length
        }
        xhr.onabort = function(e) {
            console.log("Error", e);
        }
        return xhr;
    },
    success: function(response, texStatus, jqXHR) {
        console.log("success", jqXHR.getAllResponseHeaders())
        initialContentLength = jqXHR.getResponseHeader('Content-Length')
        Etag = jqXHR.getResponseHeader('Etag')
    }
});

// var req = new XMLHttpRequest();
// req.open("GET", "http://localhost/learning/rangesConditional.php", true);
// req.onreadystatechange = function(e) {
//     console.log(req.response, req.responseText, req.readyState);
//     if(req.readyState === 4) {
//         console.log(req.response, req.responseText);
//     }
// }
// req.onprogress = function(e) {
//     console.log(e);
// }
// req.send();
// get.abort();
console.log(ajax)
