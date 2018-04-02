window.onload = function (e){
    browserDetection1();
    console.log(window.isIE);
    // Scroll events
    // document.body.onscroll = function (e) {
    //     console.log('Scrolling inside onscroll', e);
    //     console.log(document.documentElement.scrollTop, document.documentElement.scrollLeft);
    //     if(!window.isIE) {
    //         console.log(document.getElementById('canvas-container').getBoundingClientRect());
    //     }
    // }
    // document.getElementById('scroll').onscroll = function (e) {
    //     console.log('Scrolling inside onscroll', e);
    //     console.log(e.target.scrollTop, e.target.scrollLeft);
    //     if(!window.isIE) {
    //         console.log(document.getElementById('canvas-container').getBoundingClientRect());
    //     }
    // }

    // works in firefox but not in IE
    // document.documentElement.onwheel = function(e) {
    //     console.log('Scrolling inside onwheel', e);
    // }
    // document.getElementById('scroll').onwheel = function(e) {
    //     console.log('Scrolling inside onwheel', e);
    //     console.log(e.target.scrollTop, e.target.scrollLeft);        
    // }

    // does not work on firefox and works in IE and chrome
    // document.documentElement.onmousewheel = function (e) {
    //     console.log('Scrolling inside onmousewheel', e);
    // }


    // $("#scroll").on('mousewheel',function(e) {
    //     console.log(e.originalEvent.deltaX, e.originalEvent.deltaY, e.originalEvent.wheelDeltaX,e.originalEvent.wheelDeltaY);
    // })

    $("#scroll").on('wheel',function(e) {
        console.log(e.originalEvent);
    })

    if(window.isFirefox) {
        $("#scroll").on('wheel',function(e) {
            console.log(e.originalEvent);
        })
        // Its mentioned that this event is for firefox and mousewheel will not work on firefox. This is only for firefox.
        // document.documentElement.addEventListener('DOMMouseScroll', function(e) {
        //     console.log('Scrolling inside DOMMouseScroll', e);
        //     console.log(e.target.scrollTop, e.target.scrollLeft);
        // })
    }
    

    // document.body.onmousemove = function (e) {
    //     console.log("Mouse Move Event Client", e.clientX, e.clientY);
    //     console.log("Mouse Move Event Screen", e.screenX, e.screenY);
    //     console.log("Mouse Move Event Page", e.pageX, e.pageY);
        
    // }
}

var browserDetection1 = function() {
        // Opera 8.0+
    window.isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

    // Firefox 1.0+
    window.isFirefox = typeof InstallTrigger !== 'undefined';

    // Safari 3.0+ "[object HTMLElementConstructor]" 
    window.isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

    // Internet Explorer 6-11
    window.isIE = /*@cc_on!@*/false || !!document.documentMode;

    // Edge 20+
    window.isEdge = !isIE && !!window.StyleMedia;

    // Chrome 1+
    window.isChrome = !!window.chrome && !!window.chrome.webstore;

    // Blink engine detection
    window.isBlink = (isChrome || isOpera) && !!window.CSS;
}

// Does not work for most browsers now because their userAgent string is changed.
function BrowserDetection2() {
    //Check if browser is IE
    if (navigator.userAgent.search("MSIE") >= 0) {
        // insert conditional IE code here
    }
    //Check if browser is Chrome
    else if (navigator.userAgent.search("Chrome") >= 0) {
        // insert conditional Chrome code here
    }
    //Check if browser is Firefox 
    else if (navigator.userAgent.search("Firefox") >= 0) {
        // insert conditional Firefox Code here
    }
    //Check if browser is Safari
    else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
        // insert conditional Safari code here
    }
    //Check if browser is Opera
    else if (navigator.userAgent.search("Opera") >= 0) {
        // insert conditional Opera code here
    }
}
