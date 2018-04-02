var iframe = document.getElementsByTagName('iframe')[0]

console.log(iframe.contentWindow);
// console.log(iframe.contentDocument);// not allowed in same-origin-policy

iframe.contentWindow.postMessage("Hello from parent", "http://sysblog.local:8080/");

window.addEventListener("message", function(e) {
    console.log("%c Loggin from parent ", "background: #fff444; coloe: #ccc444", e)
});