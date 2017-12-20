var dworker = new Worker("src/dworker.js");
dworker.onmessage = function(data) {
    console.log("%c", "background: #333333; color: red", data);
};
dworker.postMessage({'name': "kushagra", "age": "30"});

var sworker = new SharedWorker('src/sworker.js');

sworker.port.onmessage = function(data) {
    console.log("%c", "background: #333333; color: red", data);
};

// sworker.port.start(); // opens a port connection to shared worker.// not required if onmessage event is bound once onmessage event is bound on worker it opens connection to the parent on that port.
sworker.port.postMessage("Hello shared worker. I am main script.");


// worker.terminate(); // terminate the worker thread without closing or doing any cleanup work.