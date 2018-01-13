// $.ajaxSetup({
//     // dataType: 'json'
    
// });

var responseXHR;
var responseXHRLength;
var initialContentLength;
var Etag;
var xRequest;
// var get = $.get("http://localhost/learning/rangesConditional.php");
// conditionalAjaxCheck.php
var ajax = $.ajax({
    url: "http://localhost/learning/rangesConditional.php",
    type: "GET",
    // headers: {
    //     "Range": "bytes=100-200"
    // },
    xhr: function() {
        var xhr = xRequest = $.ajaxSettings.xhr();
        console.log("XHRRequest ", xhr);
        setTimeout(function() {
            console.log("TIMEOUT");
            xhr.abort();
        }, 10000);
        
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

// var ajax = $.ajax({
        //     url: "http://localhost/learning/rangesConditional.php",
        //     type: "GET",
        //     headers: {
        //         "Custom": "Custom-val"
        //     },
        //     xhr: function() {
        //         var xhr = xRequest = $.ajaxSettings.xhr();
        //         console.log("XHRRequest ", xhr);
        //         setTimeout(function() {
        //             console.log("TIMEOUT");
        //             xhr.onabort = function(e) {
        //                 console.log("Abort", e);
        //                 // here is where we make a ranges request
        //                 // $.ajax({
        //                 //     url: "http://localhost/learning/rangesConditional.php",
        //                 //     type: "GET",
        //                 //     headers: {
        //                 //         "Range": "bytes="+responseXHRLength+"-",
        //                 //         "If-Range": Etag,
        //                 //         "If-Match": Etag
        //                 //     },
        //                 //     success: function(response, statusText, jqXHR) {
        //                 //         if(jqXHR.status == "416") {
        //                 //             console.log("Error Occured");
        //                 //         } else {
        //                 //             console.log("Response Received");
        //                 //         }
        //                 //     }
        //                 // })
        //             }
        //             xhr.onerror = function(e) {
        //                 console.log("Error", e);
        //             }
        //             xhr.abort();
        //         }, 3000);
        //         xhr.onprogress = function(e) {
        //             console.log(e);
        //             if(e.loaded) {
        //                 responseXHRLength = e.loaded                        
        //             }
        //         }
               
        //         return xhr;
        //     },
        //     success: function(response, texStatus, jqXHR) {
        //         console.log("success", jqXHR.getAllResponseHeaders())
        //         // initialContentLength = jqXHR.getResponseHeader('Content-Length')
        //         // Etag = jqXHR.getResponseHeader('Etag')
        //     }
        // });