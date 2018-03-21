window.onload = function(e) {
    document.body.addEventListener("touchstart", function(e) {console.log("touch start", e);});
    document.body.addEventListener("touchmove", function(e) {console.log("touch move", e);});
    document.body.addEventListener("touchcancel", function(e) {console.log("touch cancel", e);});
    document.body.addEventListener("touchend", function(e) {console.log("touch end", e);});


    // not working in firefox
    window.addEventListener("orientationchange", function() {
        // Announce the new orientation number
        console.log("Orientation change => ", screen.orientation);
    }, false);
    window.addEventListener("deviceorientation", function(e) {
        // Announce the new orientation number
        console.log("Device Orientation => ",e);
    }, false)
    window.addEventListener("resize", function(e) {
        // Get screen size (inner/outerWidth, inner/outerHeight)
        console.log("Resize => ", e);
    }, false);

    // Find matches
    var mql = window.matchMedia("(orientation: portrait)");
    console.log("MQL => ", mql); // mql is MediaQueryList
    // If there are matches, we're in portrait
     // matches is a property of the media query change event
    if(mql.matches) {
        // Portrait orientation
        console.log("first -> portrait");
    } else {
        // Landscape orientation
        console.log("first -> landscape");
    }

    // Add a media query change listener
     // matches is a property of the media query change event
     // m is MediaQuertListEvent
    mql.addListener(function(m) {
        if(m.matches) {
            // Changed to portrait
            console.log("second -> portrait", m);            
        }
        else {
            // Changed to landscape
            console.log("second -> landscape", m);
        }
    });

}