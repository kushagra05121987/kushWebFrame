var sworker = new SharedWorker('src/sworker.js');

sworker.port.onmessage = function(data) {
    console.log("%c", "background: #333333; color: red", " invoke call ", data);
};

// sworker.port.start(); // opens a port connection to shared .// not required if onmessage event is bound once onmessage event is bound on worker it opens connection to the parent on that port.
sworker.port.postMessage("Hello shared worker. I am second script.");



// window.dworker.onmessage = function(data) {
//     console.log("%c", "background: #333333; color: red", data);
// };
// window.dworker.postMessage({'name': "kushagra", "age": "3"});

// console.log(window.dworker)
// console.log(window.sworker)