// setting up web socket client to connect with remote web socket server
(function($) {
    var websocketClient = new WebSocket("ws://sysblog.local:8080/socketconnect");
    // open a new socket connection
    websocketClient.open = function() {
        // begin acknowledgement process
        console.log("%c "+encodeURI('ConnectionRequest_'+Math.random())+" ", "background: yellow; color: #000");
        websocketClient.send(encodeURI('ConnectionRequest_'.Math.random()));
    };
})(jQuery);