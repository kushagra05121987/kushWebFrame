// $.ajaxSetup({
//     // dataType: 'json'
    
// });
setTimeout(function() {
    ajax.abort();
}, 3000);
// var get = $.get("http://localhost/learning/rangesConditional.php");
var ajax = $.ajax({
    url: "http://localhost/learning/rangesConditional.php",
    type: "GET",
    xhr: function() {
        var xhr = $.ajaxSettings.xhr();
        xhr.onprogress = function(e) {
            console.log(e, xhr.responseText);
        }
        return xhr;
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
// console.log(get)
