console.log(window.parent);

window.addEventListener("message", function(e) {
    console.log("%c Loggin from child ", "background: #fff444; coloe: #ccc444", e)
});

window.parent.postMessage("Hello from child", "http://localhost:9000/");