var responseXHR;
var responseXHRLength;
var initialContentLength;
var Etag;
var xRequest;
var ajax = $.ajax({
    url: "https://jsonplaceholder.typicode.com/posts",
    type: "GET",
    // headers: {
    //     "Range": "bytes=100-200"
    // },
    xhr: function() {
        var xhr = xRequest = $.ajaxSettings.xhr();
        console.log("XHRRequest ", xhr);
        setTimeout(function() {
            // console.log("TIMEOUT");
            // xhr.abort();
        }, 10000);
        
        return xhr;
    },
    dataTYpe: "json",
    success: function(response, texStatus, jqXHR) {
        console.log("success", jqXHR.getAllResponseHeaders())
        initialContentLength = jqXHR.getResponseHeader('Content-Length')
        Etag = jqXHR.getResponseHeader('Etag')
        
    }
});