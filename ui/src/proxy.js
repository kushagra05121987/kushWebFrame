var a = {1:2, 2:3, 3:4};
var b = {};
var c = [1,2,3,4,5];
var e = {s: function() {console.log("inside s");}};
function d() {
    console.log("Hello inside d");
    this.m1 = function() {console.log("inside m1");}
    this.m2 = function() {console.log("inside m2");}
    m3 = function() {console.log("inside m3");}
    localProp1 = 200;
    this.globalProp1 = 300;
}

var handler = {
    getPrototypeOf: function(target) {
        console.log("Inside proxy getPrototypeOf");
        return Object.getPrototypeOf(target);
    },
    setPrototypeOf: function(target) {
        console.log("Inside proxy setPrototypeOf");        
        return Object.setPrototypeOf(target, [1,2,455]);
    },
    isExtensible: function(target) {
        console.log("Inside proxy isExtensible");
        return Object.isExtensible(target);
    },
    preventExtensions: function(target) {
        console.log("Inside proxy preventExtensions");
        return Object.preventExtensions(true);
    },
    getOwnPropertyDescriptor: function(target, prop) {
        console.log("Inside proxy getOwnPropertyDescriptor");
        return Object.getOwnPropertyDescriptor(target, prop);
    },
    defineProperty: function(target, property, descriptor) {
        console.log("Inside proxy defineProperty");
        Object.defineProperty(target, property, descriptor);
    },
    has: function(target, prop) {
        console.log("Inside proxy has");
        return Object.hasOwnProperty(prop);
    },
    get: function(target, property, receiver) {
        console.log("Inside proxy get");
        console.log(receiver);
        console.log(typeof property);
        // eval("var resp = " + target[property]);
        console.log(property);        
        if(typeof resp == "function"){
            return resp;
        }
        return target[property]
    },
    set: function(target, property, value, receiver) {
        console.log("Inside proxy set");
        console.log(receiver);
        target[property] = value;
        return true;
    },
    deleteProperty: function(target, property) {
        console.log("inside proxy deleteProperty");
        Object.deleteProperty(target, property);
    },
    ownKeys: function(target) {
        console.log("inside proxy ownKeys");        
        return Object.getOwnPropertyNames();
    },
    apply: function(target, thisArg, argumentsList) {
        console.log("inside proxy apply");
        console.log(argumentsList);
        console.log(thisArg);
        console.info(target);
        return argumentsList;
    },
    construct: function(target, argumentsList, newTarget) {
        console.log("inside proxy construct");
        console.log(argumentsList);
        console.log(newTarget);
        console.log(target);
        return {"name": "Kushagra Mishra", "Gender": "Male"};
    }
};

function f() {
    console.log("Hello inside f");
    this.m1 = function() {console.log("inside m1");}
    this.m2 = function() {console.log("inside m2");}
    m3 = function() {console.log("inside m3");}
    localProp1 = 200;
    this.globalProp1 = 300;
}

var pa  = new Proxy(a, handler);
var pb  = new Proxy(b, handler);
var pc  = new Proxy(c, handler);
var pd  = new Proxy(d, handler);
var pe  = new Proxy(e, handler);
var pf = Proxy.revocable(f, handler);
console.info(pa, pb, pc, pd, pe, pf);