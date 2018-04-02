// console.log("%c inside shared worker ", "background: orange; color: #fff");

// // console.log(window); // not defined
// console.log(self);
// // console.log(window == self);
// // console.log(window.testPayload);
// console.log(self.testPayload);

// console.log(this) // this is equal to self

// importScripts('test.js');

var peers = [], count = 0;

onconnect = function(e) {
    var port = e.ports[0];
    peers.push(port);
    count++;
    port.postMessage("New shared worker connection "+count);
    port.onmessage = function(event) {
        peers.forEach(function(peer){
            peer.postMessage(event.data);
        });
        console.log("%c", "background: orange; color: #fff", "inside worker", data);
        port.postMessage("Message Received sworker");
    };
    // port.start();   // not required if onmessage event is bound once onmessage event is bound on worker it opens connection to the parent on that port.
}

// self.close(); // close the worker by itself