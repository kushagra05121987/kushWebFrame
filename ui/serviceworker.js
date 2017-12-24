console.log("This is from inside service worker.");
oninstall = function(e) {
    console.log('%c Installing Service worker. ',"background: black; color: #fff", e);    
}

onactivate = function(e) {
    console.log('%c Activating Service worker. ',"background: black; color: #fff", e);    
}

onfetch = function(e) {
    console.log('%c Fetching Service worker. ',"background: black; color: #fff", e);        
}