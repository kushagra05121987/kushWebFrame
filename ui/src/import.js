console.log("inside index")
$(document).ready(function ($) {
    var fragment = document.createDocumentFragment();
    window.linkNode = document.createElement('link');
    linkNode.rel = "import";
    linkNode.href = "/learning/ui/resources/shadow.html";
    linkNode.name = "shadowlink";
    linkNode.onload = linkOnload;
    linkNode.onerror = linkOnError;
    fragment.appendChild(linkNode);
    document.body.appendChild(fragment);
    function linkOnload() {
        if ("import" in linkNode) {
            var contentNode = linkNode.import.getElementById("contents");
            var content = contentNode.cloneNode(true);
        } else {
            var content = "Import not supported";
        }
        document.getElementById('some-id').insertAdjacentElement('afterend', content);
    }
    function linkOnError(e) {
        console.log(e)
    }
})