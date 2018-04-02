const o = {};
// o = {"p1": 500}// direct assignment of const fails
o.prop2 = 300 // but we can assign its properties
o.prop2 = 700
Object.defineProperty(o, "prop1", { // the object o must be already defined.
    configurable: true,
    enumerable: true,
    value: 200,
    writable: false
});


Object.defineProperties(o, {
    "prop6": { // the object o must be already defined.
        configurable: true,
        enumerable: true,
        value: 200,
        writable: true
    },
    "prop3": { // the object o must be already defined.
        configurable: true,
        enumerable: true,
        value: 900,
        writable: false
    },
    "prop4": { // the object o must be already defined.
        configurable: false,
        enumerable: true,
        value: {
            "one": 1,
            "two": 2
        },
        writable: true
    },
    "prop8": { // the object o must be already defined.
        configurable: true,
        enumerable: false, // this means that this property will not show up while looping over the parent object which is o in this case.
        value: {
            "one": 1,
            "two": 2
        },
        writable: true
    }
});

// Prop 3 . Below assignments wont work because writable is set to false here.
o.prop3 = {};
o.prop3 = 100;
o.prop6 = 100; // changes prop6.

// prop 4. // Below wont get deleted because its configurable is set to false.
delete o.prop4; // wont be deleted
delete o.prop1; // get deleted.
o.prop4 = 1000


// Prop 8. iterable means it should be array
for (key in o) {
    // console.log(key, " => ", o[key])
};


// console.log(o);


// object create
var f1 = function () {
    this.prop1 = { "one": 1, "two": 2 };
    this.metho2 = function () { }
}
function f2() {
    this.prop1 = { "three": 3, "four": 4 };
    this.meth3 = function () { }
}

var of1 = new Object(f1);
var of1c = Object.create(f1);

var of2 = new Object(f2);
var of2c = Object.create(f2, {
    // foo is a regular 'value property'
    foo: {
      writable: true,
      configurable: true,
      value: 'hello'
    },
    // bar is a getter-and-setter (accessor) property
    bar: {
      configurable: false,
      get: function() { return 10; },
      set: function(value) {
        console.log('Setting `o.bar` to', value);
      }
    }
  /* with ES5 Accessors our code can look like this
      get function() { return 10; },
      set function(value) {
        console.log('Setting `o.bar` to', value);
      } */
    });

var of1n = new f1();
var of2n = new f2();

// console.log("%c With Create => ", "background: orange; color: #333", of1, of1c);
// console.log("%c Without Create => ", "background: orange; color: #333", of2, of2c);
// console.log("%c Without Create => ", "background: orange; color: #333", of1n, of2n);

// Object creates a wrapper of the type of the value passed around the value passed. Hence with json string or boolean it creates specific objects of the types. In case of function the type is Function which will be passed the function given to Object and hence the Function returns the actual function because Function doesnot create the object of the function it just defines it like we normally define a function.


// Shape - superclass
function Shape() {
    console.log("inside shape");
    this.x = 0;
    this.y = 0;
}

function shapeCons() {
    console.log("inside shape cons");
}

// superclass method
Shape.prototype.move = function (x, y) {
    this.x += x;
    this.y += y;
    console.info('Shape moved.');
};

// Rectangle - subclass
function Rectangle() {
    Shape.call(this); // call super constructor.
}

// subclass extends superclass
Rectangle.prototype = Object.create(Shape.prototype);
//   Rectangle.prototype.constructor = Rectangle;

var rect = new Rectangle();

console.log('Is rect an instance of Rectangle?',
    rect instanceof Rectangle); // true
console.log('Is rect an instance of Shape?',
    rect instanceof Shape); // true
rect.move(1, 1); // Outputs, 'Shape moved.'