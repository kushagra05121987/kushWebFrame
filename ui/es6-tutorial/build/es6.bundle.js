/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 328);
/******/ })
/************************************************************************/
/******/ ({

/***/ 328:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _marked = /*#__PURE__*/regeneratorRuntime.mark(idMaker),
    _marked2 = /*#__PURE__*/regeneratorRuntime.mark(yielder),
    _marked3 = /*#__PURE__*/regeneratorRuntime.mark(anotherGenerator),
    _marked4 = /*#__PURE__*/regeneratorRuntime.mark(generator),
    _marked5 = /*#__PURE__*/regeneratorRuntime.mark(logGenerator),
    _marked6 = /*#__PURE__*/regeneratorRuntime.mark(logGenerator2),
    _marked7 = /*#__PURE__*/regeneratorRuntime.mark(logGenerator3);

// let
// let can be used as a more stricter version of var. Where in let declaring the same variable multiple times is not allowed but assigning it multiple times is allowed. let variables are not hoisted. let is block scoped instead of function scoped.
var a = 20;
if (true) {
    var _a = 30;
}
console.log(a);
// let a = 40; // generates error that a has already been declared.
a = 50; // this works
console.log(a);

// const
// const is stricter form of let where in any variable initialised once using const cannot be declared or assigned again.
var s = "kushagra";
// s = "mishra" // throws error cannot assign

// but both let and const do not stop from appending to the already assigned value.
var ar = [1, 2, 3, 4, 5];
var obj = { "one": 1, two: 2, three: 3 };

obj['four'] = 4;
ar.push(6);

console.log(ar);
console.log(obj);

// Arrow functions
// Inside arrow functions the 'this' keyword remains unchanged so we dont need to use var self = this.
// Arrow function take two forms expression or body.
// we using expression a return is automatically prepended to the expression so we dont need to do return (expression).
// we cannot use new keyword with arrow functions
// Arrow functions are all anonymous.
// Arrow functions will also not get hoisted.
// Arrow functions do not have constructor or prototype property and thats why they are not allowed to be used with new keyword. ES6 has separated methods (arrow functions) and classes (Class keyword).
// Arrow functions do not have the local variable arguments as do other functions. The arguments object is an array-like object that allows developers to dynamically discover and access a function’s arguments. This is helpful because JavaScript functions can take an unlimited number of arguments. Arrow functions do not have this object.
var func1 = function func1() {
    var _this = this;

    this.f2 = function () {
        console.log("f2", _this);
        f3();
    };

    var f3 = function f3() {
        console.log("f3", _this);
    };
};
var f1o = new func1();
f1o.f2();
// inside f3 above we get this same as in f2 even though it is local function and not instance method.

var func2 = function func2() {
    console.log(this);
    this.f4 = function () {
        console.log("f4", this);
        f5();
    };

    var f5 = function f5() {
        console.log("f5", this);
    };
};
// func2(); // because we are usign webpack we will get 'this' as undefined because with webpack all the code is executed inside another scope and not in window scope. Otherwise in above example we get window as value of 'this'.
var f2o = new func2();
f2o.f4();

// If there is only one argument in arrow function then we don't even need () 
// so 
var func3 = function func3(param) {
    return { "receivedParams": param };
};
(function () {
    return console.log(func3(30));
})();

// Generators 
// using yield we can construct generators. The function in generators is replaced by function* name(){}. Generator functions are not constructible so new keyword will generate error with generator functions. yield* will call another generator function. next() will stop on first occurance of yield and then will return an object with value having the first yield.

// Generator function don't get executed immediately. When we call generator functions the return an iterator object, calling next() on this object will execute the body of the generator and will return object with value and done boolean indicating if generator is complete.

// If we return any value from generator then that means is done, anything after that won't be executed.
// Generator function should be called only once so that it will return generator object only once otherwise it will keep returning same generator object everytime

// If we any param to generator function and that argument is not receieved in function and not used anywhere then corresponding yield expression will be replaced with that argument.

// When passing values to generators from next function we need to have an yield statement ready to use it. Otherwise if there is no other yield that has been executed and pointer is not waiting at that yield then the value passed will not be replacing the yield expression using that next. Hence we will need to use another next with value in it that will replace the previous waiting yield.

// So in the below example first yield is encountered inside console.log(yield 0). Here because there was no other yield available and waiting at time of calling the next() statement the value passed does not replace anything and yield simply returns 0 and hence console.log doesnot print anything. When we call another next at that time we have previous yield from yield 0 inside console.log which gets replaced with the value passed. And hence we have console.log executed first with the value passed and then next yield inside console.log returns.

function idMaker() {
    var index;
    return regeneratorRuntime.wrap(function idMaker$(_context) {
        while (1) {
            switch (_context.prev = _context.next) {
                case 0:
                    console.log("First");
                    index = 0;

                case 2:
                    if (!(index < index + 1)) {
                        _context.next = 7;
                        break;
                    }

                    _context.next = 5;
                    return index++;

                case 5:
                    _context.next = 2;
                    break;

                case 7:
                    console.log("Now");

                case 8:
                case "end":
                    return _context.stop();
            }
        }
    }, _marked, this);
}

var gen = idMaker();

console.log(gen.next().value); // 0 // this stops on first yield and returns object with value from the first yield.
console.log(gen.next().value); // 1 // this resumes from the last yield and stops again at next yield.
console.log(gen.next().value); // 2
console.log(gen.next().value); // 3

function yielder() {
    return regeneratorRuntime.wrap(function yielder$(_context2) {
        while (1) {
            switch (_context2.prev = _context2.next) {
                case 0:
                    _context2.next = 2;
                    return 1;

                case 2:
                    _context2.next = 4;
                    return 2;

                case 4:
                    _context2.next = 6;
                    return 3;

                case 6:
                case "end":
                    return _context2.stop();
            }
        }
    }, _marked2, this);
}
var yielder = yielder();
console.log("Starting Yield .... ");
console.log(yielder.next());
console.log(yielder.next());
console.log(yielder.next());
console.log(yielder.next());

// using another generator function from another generator function.
function anotherGenerator(i) {
    return regeneratorRuntime.wrap(function anotherGenerator$(_context3) {
        while (1) {
            switch (_context3.prev = _context3.next) {
                case 0:
                    _context3.next = 2;
                    return i + 1;

                case 2:
                    _context3.next = 4;
                    return i + 2;

                case 4:
                    _context3.next = 6;
                    return i + 3;

                case 6:
                case "end":
                    return _context3.stop();
            }
        }
    }, _marked3, this);
}

function generator(i) {
    return regeneratorRuntime.wrap(function generator$(_context4) {
        while (1) {
            switch (_context4.prev = _context4.next) {
                case 0:
                    _context4.next = 2;
                    return i;

                case 2:
                    return _context4.delegateYield(anotherGenerator(i), "t0", 3);

                case 3:
                    _context4.next = 5;
                    return i + 10;

                case 5:
                case "end":
                    return _context4.stop();
            }
        }
    }, _marked4, this);
}

var gen = generator(10);

console.log(gen.next().value); // 10
console.log(gen.next().value); // 11
console.log(gen.next().value); // 12
console.log(gen.next().value); // 13
console.log(gen.next().value); // 20

//   Passing arguments into Generators
function logGenerator() {
    return regeneratorRuntime.wrap(function logGenerator$(_context5) {
        while (1) {
            switch (_context5.prev = _context5.next) {
                case 0:
                    console.log(0);
                    _context5.t0 = console;
                    _context5.next = 4;
                    return;

                case 4:
                    _context5.t1 = _context5.sent;

                    _context5.t0.log.call(_context5.t0, 1, _context5.t1);

                    _context5.t2 = console;
                    _context5.next = 9;
                    return;

                case 9:
                    _context5.t3 = _context5.sent;

                    _context5.t2.log.call(_context5.t2, 2, _context5.t3);

                    _context5.t4 = console;
                    _context5.next = 14;
                    return;

                case 14:
                    _context5.t5 = _context5.sent;

                    _context5.t4.log.call(_context5.t4, 3, _context5.t5);

                case 16:
                case "end":
                    return _context5.stop();
            }
        }
    }, _marked5, this);
}

function logGenerator2() {
    return regeneratorRuntime.wrap(function logGenerator2$(_context6) {
        while (1) {
            switch (_context6.prev = _context6.next) {
                case 0:
                    _context6.t0 = console;
                    _context6.next = 3;
                    return 1;

                case 3:
                    _context6.t1 = _context6.sent;

                    _context6.t0.log.call(_context6.t0, 1, _context6.t1);

                    _context6.t2 = console;
                    _context6.next = 8;
                    return 2;

                case 8:
                    _context6.t3 = _context6.sent;

                    _context6.t2.log.call(_context6.t2, 2, _context6.t3);

                    _context6.t4 = console;
                    _context6.next = 13;
                    return 3;

                case 13:
                    _context6.t5 = _context6.sent;

                    _context6.t4.log.call(_context6.t4, 3, _context6.t5);

                case 15:
                case "end":
                    return _context6.stop();
            }
        }
    }, _marked6, this);
}

var gen = logGenerator();
var gen2 = logGenerator2();

// the first call of next executes from the start of the function
// until the first yield statement
gen.next(); // 0
gen.next('pretzel'); // 1 pretzel
gen.next('california'); // 2 california
gen.next('mayonnaise'); // 3 mayonnaise

gen2.next(); // 0
gen2.next('pretzel'); // 1 pretzel
gen2.next('california'); // 2 california
gen2.next('mayonnaise'); // 3 mayonnaise

console.log(" ======================== Generator 3 =======================");
function logGenerator3() {
    return regeneratorRuntime.wrap(function logGenerator3$(_context7) {
        while (1) {
            switch (_context7.prev = _context7.next) {
                case 0:
                    _context7.t0 = console;
                    _context7.next = 3;
                    return 0;

                case 3:
                    _context7.t1 = _context7.sent;

                    _context7.t0.log.call(_context7.t0, _context7.t1);

                    _context7.t2 = console;
                    _context7.next = 8;
                    return 1;

                case 8:
                    _context7.t3 = _context7.sent;

                    _context7.t2.log.call(_context7.t2, 'replacing 1', _context7.t3);

                case 10:
                case "end":
                    return _context7.stop();
            }
        }
    }, _marked7, this);
}
var gen3 = logGenerator3();

console.log("++++++ First +++++++");
console.log(gen3.next('axel'));
console.log("++++++ Second +++++++");
console.log(gen3.next('pretzel'));
//   console.log("++++++ Third +++++++");
//   console.log(gen3.next('california'));

//   console.log("++++++ Fourth +++++++");
//   console.log(gen3.next('mayonnaise'));
//   console.log("++++++ Fifth +++++++");
//   console.log(gen3.next('kushagra'));
//   console.log("++++++ Sixth +++++++");
//   console.log(gen3.next('Mishra'));
var funcX = function funcX(a, b) {};
// console.log(funcX.arguments); // arguments are there but are not accessible and generates error => Exception: TypeError: 'caller', 'callee', and 'arguments' properties may not be accessed on strict mode functions or the arguments objects for calls to them at Function.remoteFunction
console.log(funcX.length);
console.log(funcX.name);
console.log(funcX.prototype); // no prototype in arrow functions
console.log(Object.create(funcX));
// console.log(new funcX()); // so no new object of arrow functions.
// arrow functions are in actual objects from Functions . Normal function are also objects but they are a different variety of objects which also represent classes. Thats why they have prototype and all other properties such as arguments available with them. But as now in ES6 classes have come in so arrow functions represent only objects similar to array or json which donot have prototype or other properties. Arrow functions only have __proto__ property assigned to them along with name, length , etc which are also available with other object such as array. The proto as in any other object contains prototype of Function.

// Default parameter
var func = function func(a) {
    var b = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 10;

    console.log(a, b);
};
func(20);
func(40);

/***/ })

/******/ });
//# sourceMappingURL=es6.bundle.js.map