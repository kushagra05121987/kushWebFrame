function meth1(a, b) {
    console.log("Inside meth one", a, b);
    this.m1 = function() {console.log("inside m1");}
    this.p1 = 300;
    this.xq = {"name": "Kushagra", "gender": "M"};
}
function meth2(a, b) {
    console.log("Inside meth two", a, b);
    this.m2 = function() {console.log("inside m2");}
    this.p2 = 500;
    console.log(this.p1);
    this.xq2 = {"name": "Ekta", "gender": "F"};    
    // return [this.p2, this.m2]
}

var payload = {
    x: this,
    p1: 700
}

var pmeth1 = new Proxy(meth1, {
    get: function(target, prop, receiver) {
        console.log("%c Meth1 Proxy Get => ", "background: orange; color: #333", target, prop, receiver);
        return target[prop];
    }
});

var ppayload = new Proxy(payload, {
    get: function(target, prop, receiver) {
        console.log("%c Payload Proxy Get => ", "background: orange; color: #333", target, prop, receiver);
        return target[prop];
    }
}); 

Object.defineProperty(payload, "exquisite", {
    get: function(arg1, arg2, arg3) {
        console.log(arg1, arg2, arg3, this);
        return [1];
    },
    set: function(arg1, arg2, arg3, arg4) {
        console.log(arg1, arg2, arg3, arg4, this);
        return null;
    }
});

// apply
// Reflect.apply(meth2, payload, []); // 700

// Reflect.apply(meth2, meth1, []); // undefined

// meth1.p1 = 500;

// Reflect.apply(meth2, meth1, []); // 500

// Reflect.apply(meth2, new meth1, []); // 300

// construct
// var ometh1 = Reflect.construct(meth1, [12, 10], meth2);
// console.log(ometh1)
// var opay1 = Reflect.construct(meth2, [21,10], payload.constructor); // payload itself is not a constructor.
// console.log(opay1);

// Reflect.defineProperty
// Reflect.defineProperty(target, propertyKey, descriptors)

// get
// console.log(Reflect.get(xq, 'name', (new meth1))); // this last argument with receiver only works when using with objects which have getter or setter set or with proxy objects.

// console.log(Reflect.get(new pmeth1, "xq"));

// console.log(Reflect.get(ppayload, "p1"));

console.log(Reflect.get(payload, "exquisite", meth1));

/**
 * Reflect.apply()
Calls a target function with arguments as specified by the args parameter. See also Function.prototype.apply().
Reflect.construct()
 The new operator as a function. Equivalent to calling new target(...args).
Reflect.defineProperty()
Similar to Object.defineProperty(). Returns a Boolean.
Reflect.deleteProperty()
The delete operator as a function. Equivalent to calling delete target[name].
Reflect.get()
A function that returns the value of properties.
Reflect.getOwnPropertyDescriptor()
Similar to Object.getOwnPropertyDescriptor(). Returns a property descriptor of the given property if it exists on the object,  undefined otherwise.
Reflect.getPrototypeOf()
Same as Object.getPrototypeOf().
Reflect.has()
The in operator as function. Returns a boolean indicating whether an own or inherited property exists.
Reflect.isExtensible()
Same as Object.isExtensible().
Reflect.ownKeys()
Returns an array of the target object's own (not inherited) property keys.
Reflect.preventExtensions()
Similar to Object.preventExtensions(). Returns a Boolean.
Reflect.set()
A function that assigns values to properties. Returns a Boolean that is true if the update was successful.
Reflect.setPrototypeOf()
A function that sets the prototype of an object.
 */
