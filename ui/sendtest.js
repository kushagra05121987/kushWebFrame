setTimeout(function() {
    console.log("send test");
    var req = new XMLHttpRequest();
    req.open("GET", "http://localhost/learning/ui/src/serviceworker.js");
    req.send();
}, 3000);