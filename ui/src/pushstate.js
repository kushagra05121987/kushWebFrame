var stateObject = {param: "3000"};
var stateObject3 = {parama: "3000aa"};
window.history.pushState(stateObject, "page1", "page1.html");
window.history.pushState(stateObject3, "page3", "page3.html");

window.addEventListener("popstate", function(e) {
    console.log("%c POPSTATE OCCURED ", "background: orange; color: fff444",e);
});