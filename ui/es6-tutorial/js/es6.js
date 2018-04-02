// let
// let can be used as a more stricter version of var. Where in let declaring the same variable multiple times is not allowed but assigning it multiple times is allowed. let variables are not hoisted. let is block scoped instead of function scoped.
let a = 20;
if (true) {
    let a = 30;
}
console.log(a);
// let a = 40; // generates error that a has already been declared.
a = 50; // this works
console.log(a);

// const
// const is stricter form of let where in any variable initialised once using const cannot be declared or assigned again.
const s = "kushagra";
// s = "mishra" // throws error cannot assign

// but both let and const do not stop from appending to the already assigned value.
const ar = [1, 2, 3, 4, 5];
const obj = { "one": 1, two: 2, three: 3 };

obj['four'] = 4;
ar.push(6);

console.log(ar)
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
let func1 = function () {
    this.f2 = () => {
        console.log("f2", this);
        f3();
    }

    var f3 = () => {
        console.log("f3", this);
    }
}
let f1o = new func1();
f1o.f2();
// inside f3 above we get this same as in f2 even though it is local function and not instance method.

var func2 = function () {
    console.log(this);
    this.f4 = function () {
        console.log("f4", this);
        f5();
    }

    var f5 = function () {
        console.log("f5", this);
    }
}
// func2(); // because we are usign webpack we will get 'this' as undefined because with webpack all the code is executed inside another scope and not in window scope. Otherwise in above example we get window as value of 'this'.
let f2o = new func2();
f2o.f4();

// If there is only one argument in arrow function then we don't even need () 
// so 
let func3 = param => ({ "receivedParams": param });
(() => console.log(func3(30)))();

// Generators 
// using yield we can construct generators. The function in generators is replaced by function* name(){}. Generator functions are not constructible so new keyword will generate error with generator functions. yield* will call another generator function. next() will stop on first occurance of yield and then will return an object with value having the first yield.

// Generator function don't get executed immediately. When we call generator functions the return an iterator object, calling next() on this object will execute the body of the generator and will return object with value and done boolean indicating if generator is complete.

// If we return any value from generator then that means is done, anything after that won't be executed.
// Generator function should be called only once so that it will return generator object only once otherwise it will keep returning same generator object everytime

// If we any param to generator function and that argument is not receieved in function and not used anywhere then corresponding yield expression will be replaced with that argument.

// When passing values to generators from next function we need to have an yield statement ready to use it. Otherwise if there is no other yield that has been executed and pointer is not waiting at that yield then the value passed will not be replacing the yield expression using that next. Hence we will need to use another next with value in it that will replace the previous waiting yield.

// So in the below example first yield is encountered inside console.log(yield 0). Here because there was no other yield available and waiting at time of calling the next() statement the value passed does not replace anything and yield simply returns 0 and hence console.log doesnot print anything. When we call another next at that time we have previous yield from yield 0 inside console.log which gets replaced with the value passed. And hence we have console.log executed first with the value passed and then next yield inside console.log returns.

function* idMaker() {
    console.log("First");
    var index = 0;
    while (index < index + 1)
        yield index++;
    console.log("Now");
}

var gen = idMaker();

console.log(gen.next().value); // 0 // this stops on first yield and returns object with value from the first yield.
console.log(gen.next().value); // 1 // this resumes from the last yield and stops again at next yield.
console.log(gen.next().value); // 2
console.log(gen.next().value); // 3

function* yielder() {
    yield 1;
    yield 2;
    yield 3;
}
var yielder = yielder();
console.log("Starting Yield .... ");
console.log(yielder.next());
console.log(yielder.next());
console.log(yielder.next());
console.log(yielder.next());


// using another generator function from another generator function.
function* anotherGenerator(i) {
    yield i + 1;
    yield i + 2;
    yield i + 3;
}

function* generator(i) {
    yield i;
    yield* anotherGenerator(i);
    yield i + 10;
}

var gen = generator(10);

console.log(gen.next().value); // 10
console.log(gen.next().value); // 11
console.log(gen.next().value); // 12
console.log(gen.next().value); // 13
console.log(gen.next().value); // 20

//   Passing arguments into Generators
function* logGenerator() {
    console.log(0);
    console.log(1, yield);
    console.log(2, yield);
    console.log(3, yield);
}

function* logGenerator2() {
    console.log(1, yield 1);
    console.log(2, yield 2);
    console.log(3, yield 3);
}


var gen = logGenerator();
var gen2 = logGenerator2();

// the first call of next executes from the start of the function
// until the first yield statement
gen.next();             // 0
gen.next('pretzel');    // 1 pretzel
gen.next('california'); // 2 california
gen.next('mayonnaise'); // 3 mayonnaise

gen2.next();             // 0
gen2.next('pretzel');    // 1 pretzel
gen2.next('california'); // 2 california
gen2.next('mayonnaise'); // 3 mayonnaise

console.log(" ======================== Generator 3 =======================");
function* logGenerator3() {
    console.log(yield 0);
    console.log('replacing 1', yield 1);
    // console.log('replacing 2', yield 2);
    // console.log('replacing 3', yield 3);
    // console.log("replacing 4", yield 10);
    // console.log("replacing 5",yield 4);
    // console.log("replacing 6",yield 9);
    // while(true){
    //     yield null;
    //     console.log("hi");
    // }
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
let funcX = (a, b) => { };
// console.log(funcX.arguments); // arguments are there but are not accessible and generates error => Exception: TypeError: 'caller', 'callee', and 'arguments' properties may not be accessed on strict mode functions or the arguments objects for calls to them at Function.remoteFunction
console.log(funcX.length);
console.log(funcX.name);
console.log(funcX.prototype); // no prototype in arrow functions
console.log(Object.create(funcX));
// console.log(new funcX()); // so no new object of arrow functions.
// arrow functions are in actual objects from Functions . Normal function are also objects but they are a different variety of objects which also represent classes. Thats why they have prototype and all other properties such as arguments available with them. But as now in ES6 classes have come in so arrow functions represent only objects similar to array or json which donot have prototype or other properties. Arrow functions only have __proto__ property assigned to them along with name, length , etc which are also available with other object such as array. The proto as in any other object contains prototype of Function.

// Default parameter
let func = (a, b = 10) => {
    console.log(a, b);
}
func(20);
func(20, 40); // replaces default value of b

/// default value for normal function
function funcDef(a, b = 20) {
    console.log("Default value with normal method", a, b);
}
funcDef(10);

// for of loop
// supports destructuring
let arr = [2, 3, 4, 1];
for (let value of arr) {
    console.log(value);
}

// even works with string
let string = "Javascript";
for (let char of string) {
    console.log(char);
}

// for in with string
string = "Javascript";
for (let index in string) {
    console.log(index);
}

// both key value pair
// it does not give key value pair . For of will only give value but if value sub values then those sub values can be received as array in for of.
// cannot work in normal array objects.
// for (let [index,char] of arr) {
//  console.log(index, char);
// }

// spread attributes or variable number of arguments.
// following is the normal call without spread attributes.
let SumElements = (arr) => {
    console.log(arr); // [10, 20, 40, 60, 90]
    let sum = 0;
    for (let element of arr) {
        sum += element;
    }
    console.log(sum); // 220. 
}
SumElements([10, 20, 40, 60, 90]);

SumElements = (...arr) => {
    console.log(arr); // [10, 20, 40, 60, 90]
    let sum = 0;
    for (let element of arr) {
        sum += element;
    }
    console.log(sum); // 220. 
}
SumElements(10, 20, 40, 60, 90); // Note we are not passing array here. Instead we are passing the elements as arguments.

// Maps
// Maps are used when, as suggested by others on stackoverflow, we dont know the key until run time. 
// Maps store key value pair same as objects but in maps its ordered and hence when usinf for of loop they show up in correct order in which they were inserted.
// Maps can have any type of key and any type of value and not only string type keys as in Objects.
// Maps have all indexes as unique

console.log("+++ Maps Starting +++");
var NewMap = new Map();
NewMap.set('name', 'John');
NewMap.set('id', 2345796);
NewMap.set('interest', ['js', 'ruby', 'python']);
NewMap.get('name'); // John
NewMap.get('id'); // 2345796
NewMap.get('interest'); // ['js', 'ruby', 'python']

// all indexes are unique. When assigning to same key no error will be generated stopping us from setting that key but what will happen is that it will replace the key value with new one.
var map = new Map();
map.set('name', 'John');
map.set('name', 'Andy');
map.set(1, 'number one');
map.set(NaN, 'No value');
map.get('name'); // Andy. Note John is replaced by Andy.
map.get(1); // number one
map.get(NaN); // No value

//Other useful methods used in Map
var map = new Map();
map.set('name', 'John');
map.set('id', 10);
map.size; // 2. Returns the size of the map.
map.keys(); // outputs only the keys. 
map.values(); // outputs only the values.
for (let key of map.keys()) {
    console.log(key);
}

// Iterating over map values we receive key and value both as elements of individual array.
for (let value of map) {
    console.log(value);
}
//(2) ["name", "John"]
//(2) ["id", 10]

for (let [key, value] of map) {
    console.log(key, value);
}

var arMap = [[1, 2, 3], [4, 5, 6], [7, 8, 9], [10, 11, 12], [13, 14, 15]];
for (let [v1, v2, v3] of arMap) {
    console.log(v1, v2, v3);
}


let iterable = new Map([['a', 1], ['b', 2], ['c', 3]]);

for (let entry of iterable) {
    console.log(entry);
}
// ['a', 1]
// ['b', 2]
// ['c', 3]

// example of destructing
for (let [key, value] of iterable) {
    console.log(value);
}

/**
 * Map(2) {"name" => "John", "id" => 10}
size:(...)
__proto__:Map
[[Entries]]:Array(2)
0:{"name" => "John"}
1:{"id" => 10}
length:2
 */

// Weak maps
// Weak maps are basically used for storing key values with keys only objects. Weak maps hold the keys weakly in which as soon as the reference to key is 0 or key is destroyed the corresponding reference in weak map is also removed. Which saves memory leaks.
// They are also non iterable i.e. there is no method giving you a list of the keys
/**
 * Methods
WeakMap.prototype.delete(key)
Removes any value associated to the key. WeakMap.prototype.has(key) will return false afterwards.
WeakMap.prototype.get(key)
Returns the value associated to the key, or undefined if there is none.
WeakMap.prototype.has(key)
Returns a Boolean asserting whether a value has been associated to the key in the WeakMap object or not.
WeakMap.prototype.set(key, value)
 */

var wm1 = new WeakMap(),
    wm2 = new WeakMap(),
    wm3 = new WeakMap();
var o1 = {},
    o2 = function () { },
    o3 = window;

wm1.set(o1, 37);
wm1.set(o2, 'azerty');
wm2.set(o1, o2); // a value can be anything, including an object or a function
wm2.set(o3, undefined);
wm2.set(wm1, wm2); // keys and values can be any objects. Even WeakMaps!

wm1.get(o2); // "azerty"
wm2.get(o2); // undefined, because there is no key for o2 on wm2
wm2.get(o3); // undefined, because that is the set value

wm1.has(o2); // true
wm2.has(o2); // false
wm2.has(o3); // true (even if the value itself is 'undefined')

wm3.set(o1, 37);
wm3.get(o1); // 37

wm1.has(o1); // true
wm1.delete(o1);
wm1.has(o1); // false

// this.method is priviledged method and not public. .prototype.method is public method. this.property is public property
// both var and this methods result in having their own copies in every instance.

// sets
//Sets are used to store the unique values of any type.
// if redundant value is found then that value is not shown when iterating and only unique values are shown.
// setting a duplicate value doesn't generate error.
console.log("+++ sets starting +++");

var sets = new Set();
sets.add('a');
sets.add('b');
sets.add('a'); // We are adding duplicate value. // This won't show up in iterations.
for (let element of sets) {
    console.log(element);
}

var sets = new Set([1, 5, 6, 8, 9]);
sets.size; // returns 5. Size of the size.
sets.has(1); // returns true. 
sets.has(10); // returns false.
console.log(sets)

// Static methods
class Example {
    // static a = 20; // no static variables. Only static methods.
    static Callme() {
        console.log("Static method");
        // Example.a++;
        // console.log(Example.a)
    }
}
Example.Callme()
Example.Callme()

// Weak sets
// Similar to weakmaps and sets weaksets take only objects or they are a collection of objects only. They don't interfere in garbage collection so as soon as any object inside weaksets is GC its also removed from weaksets.
// Weaksets or weak maps both can be constructed by passing any iterable object to their constructors.
// new WeakMap([Iterable]);
// new WeakSet([Iterable]);
/**
 * Methods
WeakSet.prototype.add(value)
Appends a new object with the given value to the WeakSet object.
WeakSet.prototype.delete(value)
Removes the element associated to the value. WeakSet.prototype.has(value) will return false afterwards.
WeakSet.prototype.has(value)
Returns a boolean asserting whether an element is present with the given value in the WeakSet object or not.
 */

// Getter setter
//Example without getters and setters:

class People {
    constructor(name) {
        this.name = name;
    }
    getName() {
        return this.name;
    }
    setName(name) {
        this.name = name;
    }
}
let person2 = new People("Jon Snow");
console.log(person2.getName());
person2.setName("Dany");
console.log(person2.getName());

// Example with getters and setters

class People2 {
    constructor(name) {
        this.name = name;
    }
    get Name() {
        return this.name;
    }
    set Name(name) {
        this.name = name;
    }
}
let person = new People2("Jon Snow");
console.log(person.Name);
person.Name = "Dany";
console.log(person.Name);

/// destructing
/// The destructuring assignment syntax is a JavaScript expression that makes it possible to unpack values from arrays, or properties from objects, into distinct variables.
// for multiple arguments destruct the ... variable must be the last element.
//The round braces ( ... ) around the assignment statement is required syntax when using object literal destructuring assignment without a declaration.

// {a, b} = {a: 1, b: 2} is not valid stand-alone syntax, as the {a, b} on the left-hand side is considered a block and not an object literal.

// However, ({a, b} = {a: 1, b: 2}) is valid, as is var {a, b} = {a: 1, b: 2}

// NOTE: Your ( ... ) expression needs to be preceded by a semicolon or it may be used to execute a function on the previous line.
console.log("+++ Destruct Started +++");
let name = "kushagra", gender = "male";
var destructAr = [name, gender];
var destructArMore = [name, gender, "12", "India", "S/W Developer", "Testing"];
// assignement depends on corresponding position of variable and array element.
[assignedName, assignedGender] = destructAr;
// Multiple values destruct
[assName, assGender, ...anotherFill] = destructArMore;

console.log(assignedName);
console.log(assignedGender);

console.log(assName);
console.log(assGender);
console.log(anotherFill);

var destructOb = { name, gender };
// assignement in objects depends on object names and not on their positions.
console.log("--- Destruct Ob ---", destructOb);
let desObjRet = () => {
    var nDesObjret = name;
    var genDesObjRet = gender;
    var number1 = 20;
    var number2 = 30;
    var number3 = 40;
    return { nDesObjret, number1, number2, number3, genDesObjRet };
}
var { nDesObjret, genDesObjRet } = desObjRet();
({ nDesObjret, genDesObjRet, ...others } = desObjRet());
// [assignedName, anotherFill, assignedGender]  = destructAr
console.log(nDesObjret);
console.log(genDesObjRet);
console.log(others);

({ a, b, ...rest } = { a: 10, b: 20, c: 30, d: 40 });
console.log(a); // 10
console.log(b); // 20
console.log(rest); //{c: 30, d: 40}

console.log("___Default___");
// default value assignment
// array
function retAr() {
    return [30, 40, 50, 60, 70, 80, 90];
}

[ab, ba, cd, de, ef, fg, gh, h = [20, 100]] = retAr();
console.log(ab, ba, cd, de, ef, fg, gh, h);

var { nDesObjret, genDesObjRet, defaultVal = 300 } = desObjRet();

console.log(nDesObjret, genDesObjRet, defaultVal);

// Ignoring some values.
[x, , , w, ...extra] = retAr();
console.log(x, w, extra);
// Ignoring all values
[, ,] = retAr();

// leaving the elements at begining and ending
[, x, , , w,] = retAr();
console.log(x, w);

// Assigning the value to in variable differnt from the original variable name.
//A property can be unpacked from an object and assigned to a variable with a different name than the object property.
// var foo = 300;
// var bar = 500;
var { nDesObjret: foo, genDesObjRet: bar, defaultVal = 300 } = desObjRet();
console.log(nDesObjret);
console.log(genDesObjRet);
console.log(foo);
console.log(bar);

/**
 * Assigning to new variables names and providing default values
A property can be both 1) unpacked from an object and assigned to a variable with a different name and 2) assigned a default value in case the unpacked value is undefined.
 */

var { a: aa = 10, b: bb = 5 } = { a: 3 };

console.log(aa); // 3
console.log(bb); // 5

// Rest parameters cannot have default values.
// function n(a,b,...c=[2,3]) {
//     console.log(a,b,c);

// }
/**
 * 
 * @param {*In the function signature for drawES2015Chart above, the destructured left-hand side is assigned to an empty object literal on the right-hand side: {size = 'big', cords = {x: 0, y: 0}, radius = 25} = {}. You could have also written the function without the right-hand side assignment. However, if you leave out the right-hand side assignment, the function will look for at least one argument to be supplied when invoked, whereas in its current form, you can simply call drawES2015Chart() without supplying any parameters. The current design is useful if you want to be able to call the function without supplying any parameters, the other can be useful when you want to ensure an object is passed to the function.} 
 */

// In below function when nothing is passed the expression becomes 
//{ size = 'big', cords = { x: 0, y: 0 }, radius = 25 } = {cords:{x:20, y: 40}}
// but when another object is passed the expression becomes
//{ size = 'big', cords = { x: 0, y: 0 }, radius = 25 } = {cords: { x: 18, y: 30 },radius: 30}
// LHS argument in below method just defines default values for certain variables inside any json that is passed to this method. If there is no JSON passed then those values are of no use and hence error. New json is not created but the corresponding values from the given json are picked and used for creating required variables.
function drawES2015Chart({ size = 'big', cords = { x: 0, y: 0 }, radius = 25 } = { cords: { x: 20, y: 40 } }) {
    console.log(size, cords, radius);
    // do some chart drawing
}
drawES2015Chart();
drawES2015Chart({
    cords: { x: 18, y: 30 },
    radius: 30
});

// So where ever there is a possibility to assign a variable we can use destructuring.
var metadata = {
    title: 'Scratchpad',
    translations: [
        {
            locale: 'de',
            localization_tags: [],
            last_edit: '2014-04-14T08:43:37',
            url: '/de/docs/Tools/Scratchpad',
            title: 'JavaScript-Umgebung'
        }
    ],
    url: '/en-US/docs/Tools/Scratchpad'
};

var { title: englishTitle, translations: [{ title: localeTitle }] } = metadata;

console.log(englishTitle); // "Scratchpad"
console.log(localeTitle);  // "JavaScript-Umgebung"


var people = [
    {
        name: 'Mike Smith',
        family: {
            mother: 'Jane Smith',
            father: 'Harry Smith',
            sister: 'Samantha Smith'
        },
        age: 35
    },
    {
        name: 'Tom Jones',
        family: {
            mother: 'Norah Jones',
            father: 'Richard Jones',
            brother: 'Howard Jones'
        },
        age: 25
    }
];

for (var { name: n, family: { father: f } } of people) {
    console.log('Name: ' + n + ', Father: ' + f);
}

function userId({ id }) {
    return id;
}

function whois({ displayName, fullName: { firstName: name } }) {
    console.log(displayName + ' is ' + name);
}

var user = {
    id: 42,
    displayName: 'jdoe',
    fullName: {
        firstName: 'John',
        lastName: 'Doe'
    }
};

console.log('userId: ' + userId(user)); // "userId: 42"
whois(user); // "jdoe is John"

let key = 'z';
var { [key]: foo } = { z: 'bar' };

console.log(foo); // "bar"

function defaultArr([x]) {
    console.log(x);
}
//   defaultArr(); // error same as in object
defaultArr([30]);

// Can even extract internal methods and variables
// length property from 'abc' gets extracted to len
let { length: len } = 'abc'; // len = 3
var { toString: sk } = 123; // s = Number.prototype.toString

({} = [true, false]); // OK, arrays are coercible to objects
({} = 'abc'); // OK, strings are coercible to objects

//   ({} = undefined); // TypeError
//   ({} = null); // TypeError

// picking from non valid identifiers 0, 1
({ '0': aT, '1': bT } = [true, false]);
console.log(aT, bT);

function* allNaturalNumbers() {
    for (let n = 0; ; n++) {
        yield n;
    }
}
//   The following destructuring extracts the first three elements of that infinite sequence.

let [xT, yT, zT] = allNaturalNumbers(); // x=0; y=1; z=2
console.log(xT, yT, zT);

// if value is undefined or not present then default is used otherwise if value is present and is null then null will be used instead of default.
let [xx = 1] = [undefined]; // xx = 1
let { prop: yx = 2 } = { prop: undefined }; // yx = 2
let { prop: yxz = 3 } = { prop: null }; // yx = 2
console.log(xx, yx, yxz);

var someValue = {};
function someFunc() { return {} }
var { prop: y = someFunc() } = someValue;
//   is equivalent to:
var y;
if (someValue.prop === undefined) {
    y = someFunc();
} else {
    y = someValue.prop;
}

// Default values can refer to other variables in the pattern  
// A default value can refer to any variable, including another variable in the same pattern:

var x, y;
[x = 3, y = x] = [];     // x=3; y=3
[x = 3, y = x] = [7];    // x=7; y=7
[x = 3, y = x] = [7, 2]; // x=7; y=2
//However, order matters: the variables x and y are declared from left to right and produce a ReferenceError if they are accessed before their declaration.

var { prop: x } = {}; // x = undefined

var [{ prop: x } = { prop: 123 }] = [];
console.log(x);


var [{ prop: x } = { prop: 123 }] = [];
// Because the array element at index 0 has no match on the right-hand side, destructuring continues as follows and x is set to 123.

var { prop: x } = { prop: 123 };  // x = 123
// However, x is not assigned a value in this manner if the right-hand side has an element at index 0, because then the default value isn’t triggered.

var [{ prop: x } = { prop: 123 }] = [{}];
// In this case, destructuring continues with:

var { prop: x } = {}; // x = undefined

/**
 * Don’t start a statement with a curly brace  
Because code blocks begin with a curly brace, statements must not begin with one. This is unfortunate when using object destructuring in an assignment:

{ a, b } = someObject; // SyntaxError
The work-around is to either put the pattern in parentheses or the complete expression:

({ a, b }) = someObject; // ok
({ a, b } = someObject); // ok
 */

/**
 * Destructuring return values  
Some built-in JavaScript operations return arrays. Destructuring helps with processing them:

let [all, year, month, day] =
   /^(\d\d\d\d)-(\d\d)-(\d\d)$/
   .exec('2999-12-31');
exec() returns null if the regular expression doesn’t match. Unfortunately, you can’t handle null via default values, which is why you must use the Or operator (||) in this case:

let [all, year, month, day] =
   /^(\d\d\d\d)-(\d\d)-(\d\d)$/
   .exec('2999-12-31') || [];
 */
argumentCheck();
function argumentCheck() {
    console.log(arguments)
}

function spreadCheck(a, b) {
    console.log(a, b)
}
spreadCheck(...[20, 30, 40, 50]);

new Date(...[1912, 11, 24])
console.log([1, ...[2, 3], 4]);

var x = ['a', 'b'];
var y = ['c'];
var z = ['d', 'e'];

arr = [...x, ...y, ...z]; // ['a', 'b', 'c', 'd', 'e']

/**
 * Set(5) {1, 5, 6, 8, 9}
size:5
__proto__:Set
add:ƒ add()
clear:ƒ clear()
constructor:ƒ Set()
delete:ƒ delete()
entries:ƒ entries()
forEach:ƒ forEach()
has:ƒ has()
keys:ƒ values()
size:(...)
toJSON:ƒ toJSON()
values:ƒ values()
Symbol(Symbol.iterator):ƒ values()
Symbol(Symbol.toStringTag):"Set"
get size:ƒ size()
__proto__:Object
[[Entries]]:Array(5)

There is no get method in Sets as in Maps. So in order to get the values we need to iterate through them.
.entries on sets or array or map gives an iterator object.
entries iterator inside for loop gives arrays with key at 0 position and value at 1.
example in maps 
Map(2) {"name" => "John", "id" => 10}
map.entries()
MapIterator {"name" => "John", "id" => 10}
for(entries of map.entries()) {
	console.log(entries);
}
VM13774:2 (2) ["name", "John"]
VM13774:2 (2) ["id", 10]
Sets dont have positions so they output something like
for(entries of sset.entries()) {
	console.log(entries);
}
VM13720:2 (2) [10, 10]0: 101: 10length: 2__proto__: Array(0)
VM13720:2 (2) [20, 20]
VM13720:2 (2) [30, 30]
VM13720:2 (2) [405, 405]
VM13720:2 (2) [50, 50]
 */

//The spread operator lets you convert any iterable object to an array:
set = new Set([11, -1, 6]);
arr = [...set]; // [11, -1, 6]

// Symbols
// SYmbols are a new primitive types. They are considered as Unique ID tokens
let symbol1 = Symbol();
// Symbol() has an optional string-valued parameter that lets you give the newly created symbol a description:
let symbol2 = Symbol('symbol2');
// All symbols are unique
/**
 * symbol1
Symbol()
typeof symbol1
"symbol"
symbol1 === symbol2
false
(Symbol()) === (Symbol())
false
 */

// using symbols as property keys
const MY_KEY = Symbol();
const MY_KEY_2 = Symbol();
obj2 = {};

obj2[MY_KEY] = 123;
obj2[MY_KEY_2] = 234;
console.log(obj2[MY_KEY]); // 123
console.log(obj2[MY_KEY_2]);
console.log(obj2['Symbol()']);
/**
 * obj2
{Symbol(): 123, Symbol(): 234}
Symbol():123
Symbol():234
 */

// Computed property
const varia = "mykey";
let objN = {
    [MY_KEY]: 123,
    [varia]: 345
};
// methods are object properties whos values are functions
/**
 * var obj = {
    myMethod: function () {
        ···
    }
};
is equivalent to 
let obj = {
    myMethod() {
        ···
    }
}; in es6
 */
const methodSymName = Symbol();
let objF = {
    [methodSymName]() {
        return 'bar';
    }
};

let objM = {
    myMethod() {
        console.log("inside es6 methods");
    }
};
objM.myMethod();

// Object.getOwnPropertySymbols() along with Object.getOwnPropertyNames()
// Object properties now can be either string or symbols but property names will only be string. So names can come from either symbols or strings.
let objP = {
    [Symbol('my_key')]: 1,
    enum: 2,
    nonEnum: 3
};
Object.defineProperty(objP,
    'nonEnum', { enumerable: false });
//Object.getOwnPropertyNames() ignores symbol-valued property keys
console.log(Object.getOwnPropertyNames(objP));
//Object.getOwnPropertySymbols() ignores string-valued property keys
console.log(Object.getOwnPropertySymbols(objP));
//Reflect.ownKeys() considers all kinds of keys
console.log(Reflect.ownKeys(objP));
//The name of Object.keys() doesn’t really work, anymore: it only considers enumerable property keys that are strings.
console.log(Object.keys(objP));

// Symbol.iterator
// Symbol(Symbol.iterator)
let objI = {
    data: ['hello', 'world'],
    [Symbol.iterator]() {
        const self = this;
        let index = 0;
        return {
            next() {
                if (index < self.data.length) {
                    return {
                        value: self.data[index++]
                    };
                } else {
                    return { done: true };
                }
            }
        };
    }
};
for (let x of objI) {
    console.log(x);
}
// An object is only iterable (not enumerable) when is implements a method with Symbol.iterator as its key.
// otherwise it cannot be iterated. For of loop works only on iterable objects.
// whenever iteration is needed this object method with Symbol.iterator is called.
// Iterator method must always implement no arument next() method which should always return an object with two values done and value.
// So generators are also iterator.

// overwrite what happens when your string object is iterated. Customise the required output
var someString = new String('hi');           // need to construct a String object explicitly to avoid auto-boxing

someString[Symbol.iterator] = function () {
    return { // this is the iterator object, returning a single element, the string "bye"
        next: function () {
            if (this._first) {
                this._first = false;
                return { value: 'bye', done: false };
            } else {
                return { done: true };
            }
        },
        _first: true
    };
};

var iterator = someString[Symbol.iterator](); // someString.entries()
iterator + '';                               // "[object String Iterator]"

console.log(iterator.next());                             // { value: "h", done: false }
console.log(iterator.next());                             // { value: "i", done: false }
console.log(iterator.next());

/**
 * Is a generator object an iterator or an iterable?
A generator object is both, iterator and iterable:

var aGeneratorObject = function* () {
    yield 1;
    yield 2;
    yield 3;
}();
typeof aGeneratorObject.next;
// "function", because it has a next method, so it's an iterator
typeof aGeneratorObject[Symbol.iterator];
// "function", because it has an @@iterator method, so it's an iterable
aGeneratorObject[Symbol.iterator]() === aGeneratorObject;
// true, because its @@iterator method returns itself (an iterator), so it's an well-formed iterable
[...aGeneratorObject];
// [1, 2, 3]
 */
// next and Symbol.iterator are no arument constructors

function makeIterator(array) {
    var nextIndex = 0;
    return {
        next: function () {
            return nextIndex < array.length ?
                { value: array[nextIndex++], done: false } :
                { done: true };
        }
    };
}

var it = makeIterator(['yo', 'ya']);

console.log(it.next().value); // 'yo'
console.log(it.next().value); // 'ya'
console.log(it.next().done);  // true

// attaching Symbol.iterator as a method inside function.
function makeIterator2() {
    return {
        [Symbol.iterator]: function () {
            let indexIter = 0;
            var ownProps = Object.getOwnPropertyNames(makeIterator2);
            return {
                next: function () {
                    console.log(ownProps[indexIter]);
                    if (Object.getOwnPropertyNames(makeIterator2).length > indexIter && ownProps[indexIter]) {
                        indexIter++;
                        return { done: false, value: makeIterator2[ownProps[indexIter]] };
                    } else {
                        return { done: true, value: null };
                    }
                }
            }
        }
    };
}
makeIterator2['p1'] = 300;
makeIterator2['p2'] = 500;
var mIi = makeIterator2();
var mIiSym = mIi[Symbol.iterator]();
for (props of mIi) { console.log(props) }

// attaching Symbol.iterator directly on object as a property
function m2() { }
m2[Symbol.iterator] = function () {
    let indexIter = 0;
    var ownProps = Object.getOwnPropertyNames(m2);
    return {
        next: function () {
            console.log(ownProps[indexIter]);
            if (Object.getOwnPropertyNames(m2).length > indexIter && ownProps[indexIter]) {
                indexIter++;
                return { done: false, value: m2[ownProps[indexIter]] };
            } else {
                return { done: true, value: null };
            }
        }
    };
}
var m2I = m2;
var m2Sym = m2I[Symbol.iterator]();
for (props of m2I) { console.log("Hi", props) }
console.log(Array.from(m2I));

// Cross realm symbols. Symbols in different windows i.e; one inside parent browser window and other inside and iframe or another window.
// So various objects such as Array, Boolean, String etc are different inside different realms. Different realms create different copies of the same objects even though they are same.
// Primitive types such as Boolean, String, Number move between realms easily because they don't have any identity of their own. They are matched by values and hence dont matter if their reference is different or not.
// But for Symbols which have an identity of their own, it becomes difficult to travel between different realms and maintain the same identity.Because Symbol() from one realm will be different from other realm as is case with other primitive types. But other primitive types have values associated with them which are actually matched and hence they don't bother much.
// So for symbols their is a Global registery which is used to map strings with symbols and then return that symbol. So that whenever any symbol is required that is to be used globally or between different realms , a string is passed to the registery asking for the symbol mapped to that string.
// Javascript already provides a cross realm symbol that is Symbol.iterator.
console.log("Cross Realms");
var frame = frames[0];
let symR = Symbol.for('Hello everybody!');
console.log(symR);
console.log(Symbol.keyFor(symR));
console.log(frame.Array == window.Array);
console.log(frame.Boolean == window.Boolean);
console.log(frame.String == window.String);
console.log(frame.Symbol == window.Symbol);
console.log(frame.Symbol.iterator == window.Symbol.iterator);
console.log(Symbol.for('Hello everybody!') == Symbol.for('Hello everybody!'));

console.log(typeof Symbol());

/** Cannot convert symbol to a string like below
 * "__"+Symbol();
VM20119:1 Uncaught TypeError: Cannot convert a Symbol value to a string

but can convert it using other ways such as 
 */
console.log(String(Symbol("My Symbol")));
console.log((Symbol("My Symbol")).toString());

// Array.from
///The Array.from() method creates a new Array instance from an array-like or iterable object.
/**
 * Parameters
arrayLike
An array-like or iterable object to convert to an array.
mapFn Optional
Map function to call on every element of the array.
thisArg Optional
Value to use as this when executing mapFn.
array-like objects (objects with a length property and indexed elements) or
iterable objects (objects where you can get its elements, such as Map and Set).
Array.from() ignores holes [1] in arrays, it treats them as if they were undefined elements:
 */
Array.from([0, , 2]); //[ 0, undefined, 2 ]
//  can use Array.from() to create and fill an array
Array.from(new Array(5), () => 'a'); //[ 'a', 'a', 'a', 'a', 'a' ]
// Array.prototype.fill() 
['a', 'b', 'c'].fill(7); //[ 7, 7, 7 ]
new Array(3).fill(7); //[ 7, 7, 7 ]
// can restrict where the filling starts and ends
['a', 'b', 'c'].fill(7, 1, 2); //[ 'a', 7, 'c' ]

// Array.of
// The Array.of() method creates a new Array instance with a variable number of arguments, regardless of number or type of the arguments.

//The difference between Array.of() and the Array constructor is in the handling of integer arguments: Array.of(7) creates an array with a single element, 7, whereas Array(7) creates an empty array with a length property of 7 (Note: this implies an array of 7 empty slots, not slots with actual undefined values).

Array.of(7);       // [7] 
Array.of(1, 2, 3); // [1, 2, 3]

Array(7);          // [ , , , , , , ]
Array(1, 2, 3);    // [1, 2, 3]


// Object.is checks if two objects are equal.
/**
 * Object.is() determines whether two values are the same value. Two values are the same if one of the following holds:

both undefined
both null
both true or both false
both strings of the same length with the same characters in the same order
both the same object
both numbers and
both +0
both -0
both NaN
or both non-zero and both not NaN and both have the same value
This is not the same as being equal according to the == operator. The == operator applies various coercions to both sides (if they are not the same Type) before testing for equality (resulting in such behavior as "" == false being true), but Object.is doesn't coerce either value.

This is also not the same as being equal according to the === operator. The === operator (and the == operator as well) treats the number values -0 and +0 as equal and treats Number.NaN as not equal to NaN.
 */
Object.is('foo', 'foo');     // true
Object.is(window, window);   // true

Object.is('foo', 'bar');     // false
Object.is([], []);           // false

var test = { a: 1 };
Object.is(test, test);       // true

Object.is(null, null);       // true

// Special Cases
Object.is(0, -0);            // false
Object.is(-0, -0);           // true
Object.is(NaN, 0 / 0);         // false

//Searching for array elements
// Array.find
// Array.prototype.find(predicate, thisArg?)
// Array.find loops on all the the elements are stop and returns the value at which true is returned from the callback.
[6, -5, 8].find(x => x < 0); // -5
[6, 5, 8].find(x => x < 0); // undefined

// Array.findIndex()
// Array.find is for finding values whereas Array.findIndex is for finding the index of the matching value. Where true is returned from callback.
// Array.prototype.findIndex(predicate, thisArg?)
[6, -5, 8].findIndex(x => x < 0); // 1
[6, 5, 8].findIndex(x => x < 0); // -1

// Array.findIndex usedd to find Position of NaN. Because indexOf wont work for NaN values.
// [NaN].indexOf(NaN) // -1
// Thats why we use Object.is inside findIndex()
[NaN].findIndex(y => Object.is(NaN, y))

// In ES5 methods are properties of an object that have function as their value.
objX = {
    myMethod: function () {

    }
};
//In ECMAScript 6, methods are still function-valued properties, but there is now a more compact way of defining them
objX = {
    myMethod() {
    }
};

// Getter and Setter
// Getter
// Getters are keywords that bind an object method property to a function and execute it when that property is accessed.
// Getters are useful for the properties whos value needs to be processed dynamically or for some internal properties without requiring the use of explicit method calls.
// It is not possible to simultaneously have a getter bound to a property and have that property actually hold a value.
// Which means getter properties should not have static properties assigned to them.
// Getters have some rules of definition.

/**
 * It can have an identifier which is either a number or a string;
 * It must have exactly zero parameters
 * It must not appear in an object literal with another get or with a data entry for the same property ({ get x() { }, get x() { } } and { x: ..., get x() { } } are forbidden).
 */
var methname = "system";
var objG = {
    get t1x() {
        console.log("T1");
    },
    get [methname]() {
        console.log("SYSTEM");
    },
    //Invalid Expression // Cannot do assignment with : or =
    //  get t2: function() {
    //      console.log("T2")
    //  }
    // get t2(x) {} Invalid Getter must not have any formal parameters.
}
console.log(objG);
console.log(objG.t1x);
console.log(objG[methname]);
/**
 * 
 * Log shows property values also which will be returned by the corresponding getters.
    system:undefined
    t1x:undefined
    get system:ƒ ()
    get t1x:ƒ t1x()
 */

// Following syntax is invalid. Getters cannot be defined directly inside functions . They are defined on properties only so they can be defined only for object properties and not instance properties or class functions such as priviledged and private functions.

// var funcG = function(){
//     get t1() {}
//     get function t1N() {}
//     get this.t1F = function() {}
// }

// var funcG = () => {
//     get t1() {}
//     get function t1N() {}
//     get this.t1F = function() {}
// }

// get [funcG["me"]] = function() {} Invalid

// Not working as expected
var funcG = function () { }
funcG['me'] = {
    get() { // get here is treated as method name. So funcG.me.get
        return 20;
    }
}
console.log(funcG.me)

// So We need to use Object.defineProperty() in order to set the getter property on function object. This below method maybe understood as the other way of defining getter on any object, be it a normal object or function.
Object.defineProperty(funcG, "f2", {
    get: function () {
        return 20;
    }
    // get: 20 Getter must be a function: 20
});
console.log(funcG.f2);

// Delete getter
// as getter is only a property on object it can be deleted with 'delete';
delete objG.t1x;
/**
 * system:undefined
    get system:ƒ ()
 */
delete funcG.f2;

// Setters
// Setters are used to bind an object property to a function which will be executed when an attempt to change that property is made.
// These are same as getters in terms of restrictions and rules.
// Using getters and setters we are telling compiler to automatically execute the functions bounded to the method properties
var language = {
    set current(name) {
        this.log.push(name);
    },
    log: []
}

language.current = 'EN';
language.current = 'FA';

console.log(language.log);
// expected output: Array ["EN", "FA"]

var o = { a: 0 };

Object.defineProperty(o, 'b', { set: function (x) { this.a = x / 2; } });

o.b = 10; // Runs the setter, which assigns 10 / 2 (5) to the 'a' property
console.log(o.a) // 5

// Generator functions inside an object can also be shorthanded
var objGen = {
    *generatorMeth() { }
}
//   This code is equivalent to:

objGen = {
    generatorMeth: function* () { }
};
function generatorMethods() { }

generatorMethods['*genMeth'] = () => { }

// Shorthand notation for making iterator
var objIter = {
    [Symbol.itertor]() {
        return {
            next() {

            }
        }
    }
}
// above is the shorthand notation as defined above for making an object iterable.
// below is the shorthand notation as defined above for making an object iterable with generator.
var objIter = {
    *[Symbol.itertor]() {
        yield 1;
    }
}


// Object.assign(target, source_1, source_2, ···)  
// This method merges the sources into the target: It modifies target, first copies all enumerable own properties of source_1 into it, then all own properties of source_2, etc. At the end, it returns the target.

let objMerge = { foo: 123 };
Object.assign(objMerge, { bar: true });
console.log(JSON.stringify(objMerge));
// {"foo":123,"bar":true}

/**
 * Both kinds of property keys: Object.assign() supports both strings and symbols as property keys.

Only enumerable own properties: Object.assign() ignores inherited properties and properties that are not enumerable.

Copying via assignment: Properties in the target object are created via assignment (internal operation [[Put]]). That means that if target has (own or inherited) setters, those will be invoked during copying. An alternative would have been to define new properties, an operation which always creates new own properties and never invokes setters. There originally was a proposal for a variant of Object.assign() that uses definition instead of assignment. That proposal has been rejected for ECMAScript 6, but may be reconsidered for later editions.
 */

// Use cases for Object.assign()
// You can use Object.assign() to add properties to this in a constructor
class Point {
    constructor(x, y) {
        Object.assign(this, { x, y });
    }
}
// Object.assign() is also useful for filling in defaults for missing properties. In the following example, we have an object DEFAULTS with default values for properties and an object options with data.
const DEFAULTS = {
    logLevel: 0,
    outputFormat: 'html'
};
function processContent(options) {
    options = Object.assign({}, DEFAULTS, options); // (A)
};
// Object.assign is same as jquery $.extend
// Object.assign can be used as $.fn.extend
function SomeClass() { }
Object.assign(SomeClass.prototype, {
    someMethod(arg1, arg2) {
    },
    anotherMethod() {
    }
});
// and also like a normal jquery function definition $.fn.functionname where $.fn being the prototype of jQuery
SomeClass.prototype.someMethod = function (arg1, arg2) {
};
SomeClass.prototype.anotherMethod = function () {
};

// Object.assign is the way to clone objects in javascript
function clone(orig) {
    return Object.assign({}, orig);
}

// If you want the clone to have the same prototype as the original, you can use Object.getPrototypeOf() and Object.create():

function clone(orig) {
    let origProto = Object.getPrototypeOf(orig);
    return Object.assign(Object.create(origProto), orig);
}

/**
 * var zz = {
	sr: function name() {
		console.log("hello");
	}
}
is same as 
var zz = {
	sr: function () {
		console.log("hello");
	}
}

zz.sr.name() -> wont work
zz.sr(); -> works
 */

// Function Expression
// Function expression can be named or unnamed.
// Using anonymous functions inside any expression such as 
// var dd = function() {} is called function expression
/**
 * Or var dd = { return function() {} };
   Or elem.addEventListerner("click", function() {})
   So in all using just function keyword without name inside any javascript expression is called function expression.
 */

// Function Declaration
// Defining any functions with function keyword and name is called function declaration. Example 
// function ss(q,w) {}

/**
 * 
 * var zz = {
      sr: function name() {
          console.log("hello");
      }
  }
  new zz.sr

  -------------------------

  name {}
      __proto__:
      constructor:ƒ name()
      arguments:null
      caller:null
      length:0
      name:"name"
  var zz = {
      sr: function() {
          console.log("hello");
      }
  }
  new zz.sr
  sr {}
      __proto__:
      constructor:ƒ()
      arguments:null
      caller:null
      length:0
      name:"sr"

  As we see in above case in which we used both function expression as named and unnamed. The new object when created in case of named function expression has its constructor as the named function but when using with unnamed function expression the new object has no named function as constructor, it takes sr, the property to which we assigned that unnamed function, as its constructor.

 */

// Similar to functions Classes can also be declared in both the above ways . Expression or declaration.
// Javascript classes are nothing but another special type of functions. They still work on prototype-based inheritance. They are just as syntactic sugar added over the existing prototype-based inheritance.
//The class expression is one way to define a class in ECMAScript 2015. Similar to function expressions, class expressions can be named or unnamed. If named, the name of the class is local to the class body only. JavaScript classes use prototype-based inheritance.

// When defining named function or class expression the name of function or class is available to the function or class body only and its not accessible outside anywhere.
// So var ss = function nn() {} -> nn can only be accessed from inside the nn body 
// var ss = class nn() {} -> nn can only be accessed from inside the nn body
// The individual existence of these type of classes or function is not available. They can honly be access by the variables in which they are stored.

// So Like functions, classes also have same basic structure of the object created.
/**
 * class Foos {}
new Foo
Foos {}
    __proto__:
    constructor:class Foos
        arguments:[Exception: TypeError: 'caller', 'callee', and 'arguments' properties may not be accessed on strict mode functions or the arguments objects for calls to them at Function.remoteFunction (<anonymous>:2:14)]
        caller:[Exception: TypeError: 'caller', 'callee', and 'arguments' properties may not be accessed on strict mode functions or the arguments objects for calls to them at Function.remoteFunction (<anonymous>:2:14)]
        length:0
        name:"Foos"
        prototype:{constructor: ƒ}
        __proto__:ƒ ()
    __proto__:Object
 */

var Foos = class NamedFoo {
    constructor() { }
    whoIsThere() {
        return NamedFoo.name;
    }
}
var bar = new Foos();
bar.whoIsThere(); // "NamedFoo"
// NamedFoo.name; // ReferenceError: NamedFoo is not defined
Foos.name; // "NamedFoo"

// The class declaration creates a new class with a given name using prototype-based inheritance.

class Polygon {
    constructor(height, width) {
        this.area = height * width;
    }
}

console.log(new Polygon(4, 3).area);

//You can also define a class using a class expression. But unlike the class expression, the class declaration doesn't allow an existing class to be declared again and will throw a type error if attempted. 

/**
 * 'use strict';
var Foo = class {}; // constructor property is optional
var Foo = class {}; // Re-declaration is allowed using class expression

typeof Foo; //returns "function"
typeof class {}; //returns "function"

Foo instanceof Object; // true
Foo instanceof Function; // true
class Foo {}; // Throws TypeError, doesn't allow re-declaration
 */

/**
 * In the following example, we first define a class named Polygon, then extend it to create a class named Square. Note that super(), used in the constructor, can only be used in constructors and must be called before the this keyword can be used.
 So super goes before we start using this.
 */
class PolygonG {
    constructor(height, width) {
        this.name = 'Polygon';
        this.height = height;
        this.width = width;
        function name() { }
        var method = function () { }
    }
    calculateSides() { return 300 }

    get sides() { }
}

// If there is a constructor present in sub-class, it needs to first call super() before using "this".
class Square extends PolygonG {
    constructor(length) {
        // Folowing generates error.
        // Must call super constructor in derived class before accessing 'this' or returning from derived constructor
        // this.name = 'Square';
        // super(length, length);
        var sup = super(length, length); // If extending then Calling this super is must otherwise we get error. Must call super constructor in derived class before accessing 'this' or returning from derived constructor.
        console.log("Square function super", sup);// returns Square object only. 
        console.log(sup.name);
        console.log(sup.calculateSides());
        console.log(super.calculateSides()); // used in class based classes.
        console.log(PolygonG.prototype.calculateSides()); // used in both class based and function based classes.
        this.name = 'Square';

    }
    calculateSides() { return 500 }
}
console.log(new Square(20));

// Not allowed to use getter setter in functions
// function norm() {
//     get this['methname'] () {}
// }
// but allowed in classes
// Inside class no direct assignment, or use of this or function is allowed.
// Inside a class we can only use getter, setter, constructor and methods. In Methods also ES6 syntax is allowed and the legacy syntax of propname: function is not allowed
class norm {
    // constructor is same as calling funcname(23) in function functionname(a) {}. Just because no plain code can go directly inside class constructor method is used.
    constructor(name) {
        this.name = name;
    }
    get getter() {
        return this.name;
    }
    set getter(name) {
        this.name = name;
    }
    // val = 200;
    // this.getty = 300;
    // function ano() {}
    // this.getty = function() {}
    // getty: function() {}
    getty() { }
}
norm.p1 = 300;
norm.prototype.methodProto = function () { }
norm.prototype.varproto = 200;
var n = new norm("Kushagra");
console.log(n);
console.log(n.getter);

function testing() {
    this.p1 = 300;
    this.meth1 = function () { }
}
console.log(new testing());

// Points to note here on class vs function inheritance and prototypal chain
// When we declare any property inside function it doesnot go to its prototype but when we declare it inside a class all the things that are directly declared inside class go to it prototype/ Such as methods, getters, setters.
// In function if we do prototypal inheritance then whatever we need to share should be defined on .prototype chain anything defined inside function using var or this will not be inherited by another functions unless explicitly added. Like if we set parent function prototype to child function's object. In this case prototype properties won't be shared but object properties will be.
// But in case of classes whatever we define inside class using this will be available on the child class directly as it own property.
// So now when we extend in class we are actually assigning parent class's prototype to child class's prototype.__proto__. So in present case in above example
// Square.prototype gives
/**
 * PolygonG {constructor: ƒ}
constructor:class Square
sides:(...)
__proto__:
calculateSides:ƒ calculateSides()
constructor:class PolygonG
sides:undefined
get sides:ƒ sides()
__proto__:Object
 */
// As we can see above Square.prototype is of PolygonG because after extending __proto__ of Square.prototype was replaced with PolygonG.prototype and hence its contrcutor became PolygonG.

// Type of any object is the type on __proto__.constructor
// The correct way of doing prototypal inheritance in JS is not as follows
function testing2() {
    this.testf = function () { }
    this.testVal = 200;
}

testing2.prototype.__proto__ = new testing;

// Above method is ok but it will replace all the prototype properties of testing2. So we have to follow an order in which above assignment has to be done first and then attaching methods or properties to testing2.prototype. Otherwise we need to create another property of testings.prototype and then assign new testing or testing.prototype of it.

// So instead of doing as above and saving things directly in complete prototype we need to save things inside prototype.__proto__ object.
// Any object's type is determined by its __proto__.constructor property because proto is the property that is filled when object is created and is assigned with the Parent function's prototype property which has .constrcutor property also which tells what is function used when creating object.

/**
 * Hoisting
An important difference between function declarations and class declarations is that function declarations are hoisted and class declarations are not. You first need to declare your class and then access it, otherwise code like the following will throw a ReferenceError:

var p = new Rectangle(); // ReferenceError

class Rectangle {}
Note: Class expressions also suffer from the same hoisting issues mentioned for Class declarations.
 */

//The bodies of class declarations and class expressions are executed in strict mode i.e. constructor, static and prototype methods, getter and setter functions are executed in strict mode.

// Static methods
// There are no Static properties only Static methods.
// Static methods in classes are same as defining a proprty on function as a object. Example -> 
// function try() {}; try.method1 = function() {}
// same as 
// class try { static method1() {} }
// They can be invoked directly by the class name and not by the object.

// Autoboxing 
//When a static or prototype method is called without an object valued "this", then the "this" value will be undefined inside the called function. Autoboxing will not happen. The behavior will be the same even if we write the code in non-strict mode because all the functions, methods, constructor, getters or setters are executed in strict mode. So if we do not specify this value then the this value will be undefined.
// This is same for all the method calls and 'this'. IF we don't call javascript methods with any object then 'this' becomes undefined.
class Animal {
    speak() {
        return this;
    }
    static eat() {
        return this;
    }
}

objA = new Animal();
objA.speak(); // Animal {}
speak = objA.speak;
console.log(speak()); // undefined
console.log(window.speak()); // global object -> window

Animal.eat() // class Animal
eat = Animal.eat;
console.log(eat()); // undefined
console.log(window.eat()); // global object -> window

// ------------------------

function AnimalF() { }

AnimalF.prototype.speak = function () {
    return this;
}

AnimalF.eat = function () {
    return this;
}

objAF = new AnimalF();
speak = objAF.speak;
console.log(speak()); // global object -> window

eat = AnimalF.eat;
console.log(eat()); // global object -> window

// We can even extend function based classes from class based classes.
function AnimalGlobal(name) {
    this.name = "Animal";
    this.language = "";
    this.setLanguage = function (language) { this.language = language }
    this.setName = function (name) { this.name = name };
    if (name) {
        this.setName(name);
    }
}
AnimalGlobal.prototype.getName = function () { return this.name }
AnimalGlobal.prototype.getLanguage = function () { return this.language }

class Predator extends AnimalGlobal {
    constructor() {
        super("Goldenback");
        console.log(this.name);
        this.setLanguage("Growls");
    }

    get animalProperties() {
        return `Animal's name is ${super.getName()} Dragon and it ${super.getLanguage()}`;
    }
}

var animal = new Predator();
console.log(animal.animalProperties);

// Extends keyword will not be able to extend non-constructible objects such as from Object(). In this case we can use Object.setPrototypeOf()

var AnimalO = {
    speak() {
        console.log(this.name + ' makes a noise.');
    }
};

class Dog {
    constructor(name) {
        this.name = name;
    }
}

// If you do not do this you will get a TypeError when you invoke speak
Object.setPrototypeOf(Dog.prototype, AnimalO);

var d = new Dog('Mitzie');
d.speak(); // Mitzie makes a noise.

// Symbol.species lets you overwrite the default constructor of the derived class
// It is a function valued property which is used to overwrite the default constructor and hence allows you to return desired type of object from there.
class MyArray extends Array {
    // Overwrite species to the parent Array constructor
    static get [Symbol.species]() { return Array; }
}
// Symbol.species allows to set __proto__.constructor property and hence allows us to customise the type of object retured by certain operations like map. Its not hardcoded inside the prototype.contructor property bu will be changed dynamically when using such methods.
class MyArray2 extends Array {
    // Overwrite species to the parent Array constructor
    static get [Symbol.species]() { return MyArray; }
    // static get [Symbol.species]() { return Array; }
}
var mao = new MyArray(1, 2, 3);
var mapped = mao.map(x => { console.log(x instanceof Array); return (x * x); });

console.log(mapped instanceof MyArray); // false
console.log(mapped instanceof Array);   // true

var myar = new MyArray2(1, 2, 3)
var mapp = myar.map(x => x)
mapp instanceof MyArray2; // false
mapp instanceof MyArray; // true


var calculatorMixin = Base => class extends Base {
    calc() { }
};

var randomizerMixin = Base => class extends Base {
    randomize() { }
};

class Foo { }
class Bar extends calculatorMixin(randomizerMixin(Foo)) { }

var classExtend = class extends (class {
    constructor() {
        console.log("Inside parent");
        this.name = "Death";
    }
}) {
    constructor() {
        console.log("inside child");
        super();
        console.log(this.name);
    }
}
new classExtend();

// Using super with static methods
class par extends (class {
    static callme() {
        return "I have been called.";
    }
}) {
    constructor() {
        super();
        this.name = "Kushagra";
        this.age = 400;
        // this is not accessible outside constructor block
        var calculate = function () {
            return `${this.name} is ${this.age} old.`;
        }
        function calculate() {
            return `${this.name} is ${this.age} old.`;
        }
    }
    check() {
        return 20;
    }
    // static tender = 300;// no equal to sign allowed
    static calculate() {
        // inside static this refers to same class as object so this will try to pick the properties attachecd to class like class.propertyname
        return `${this.name} is ${this.age} years old and tender is ${this.tender}`;
    }
    calcy() {
        return `${this.name} is ${this.age} years old.`;
    }
    get personDetails() {
        return [this.calcy(), par.calculate(), this.constructor.calculate(), this.constructor.callme()];
    }
}
par.name = "nity" // cannot change the internal name property by assignment.
par.age = 300
var paro = new par;
console.log(paro.personDetails);

// Calling static method from class can be done in two ways 
// Either by classname.methodname or by this.constructor.methodname

class C1 {
    constructor() { this.name = "Parent"; }
    static logNbSides() {
        return 'I have 4 sides';
    }
}
C1.prototype.name = "My Final Name";
class C2 extends C1 {
    constructor() {
        super();
        console.log("constructor", super.name, this.name);
        this.name = "me";
        this.testm = function () {
            // console.log(super.name); // cannot use super here
        }
    }
    static logDescription() {
        console.log(super.name);
        return super.logNbSides() + ' which are all equal'; // can call static method using super only from inside another static method.s
    }

    supChck() {
        // super();  // Cannot use super() except in constructor
        console.log(super.name, this.name);
    }

    methodNorm() {
        return super.logNbSides() + ' which are all equal'; // cannot call static member using super from prototype method.
    }
}
console.log(C2.logDescription());
console.log((new C2).supChck());
// console.log((new C2).testm());
// console.log((new C2).methodNorm());

/// Super and this behave differently when calling from different type of methods. If we call super from static method super or this referes to the parent or same class respectively. But when we call super or this from protptype method, super or this refer to the prototype or instance of parent or same class respectively.

class Base {
    constructor() { }
    foo() { }
}
class Derived extends Base {
    constructor() { super() }
    delete() {
        delete super.foo; // Unsupported reference to 'super'
    }
}

// new Derived().delete();

var obj1 = {
    method1() {
        console.log('method 1');
    }
}

var obj2 = {
    method2() {
        super.method1();
    }
}

Object.setPrototypeOf(obj2, obj1);
obj2.method2(); // logs "method 1"

function f1T() {
    // this.m1 = function() {
    //     console.log("Inside M1");
    // }
}
f1T.prototype.m1 = () => {
    console.log("Inside M1");
}
function f2T() {
    // this.m2 = function() {
    //     console.log("Inside M2");
    // }
}
f2T.prototype.m2 = function() {
    console.log("Inside M2");
    // super.m1(); // cannot use super inside functions
}
// Object.setPrototypeOf(f2T.prototype, new f1T);
// var f2to = new f2T;

// Super works only inside method properties thats why it works inside both class and object methods.