console.log("%c inside dedicated worker ", "background: orange; color: #fff");
// console.log(window); // not defined
console.log(self);
// console.log(window == self);
// console.log(window.testPayload);
console.log(self.testPayload);

console.log(this) // this is equal to self

importScripts('test.js');

self.onmessage = function(data) {
    console.log("%c", "background: orange; color: #fff", "inside worker", data);
    self.postMessage("Message Received");
};

// self.close(); // close the worker by itself