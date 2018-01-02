` --------------------------------- Bind used to pass the value to the method also called currying ---------------------------------`
function greet (gender, age, name) {
    console.log(this)
    // if a male, use Mr., else use Ms.
    var salutation = gender === "male" ? "Mr. " : "Ms. ";

    if (age > 25) {
        return "Hello, " + salutation + name + ".";
    }
    else {
        return "Hey, " + name + ".";
    }
}

var data = [
    {name:"Samantha", age:12},
    {name:"Alexis", age:14}
]

// var g = greet.bind(data); // returns the actual function. Hence can be called at anytime
// console.log("Bind returns 1",g);
// g();

// g = greet.bind(null, "male", 12); // no object to bind to . The other parameter are preset except the last one.
// console.log("Bind returns 2",g);
// console.log(g("Kushagra Mishra")); // the remaining parameter has become dynamic and can be passed manually at any time


// g = greet.bind(null, "female", 26, "Ekta Mishra"); // no object to bind to . The other parameter are preset except the last one.
// console.log("Bind returns 3",g);
// console.log(g()); // the remaining parameter has become dynamic and can be passed manually at any time



// ` -------------------------------------- Bind used to change the reference type of this keyword ----------------------------------`

// var data = [
//     {name:"Samantha", age:12},
//     {name:"Alexis", age:14}
// ]

// var user = {
//     // local data variable
//     data    :[
//         {name:"T. Woods", age:37},
//         {name:"P. Mickelson", age:43}
//     ],
//     showData:function (event) {
//         var randomNum = ((Math.random () * 2 | 0) + 1) - 1; // random number between 0 and 1

//         console.log (this.data[randomNum].name + " " + this.data[randomNum].age);
//     }

// }

// // Assign the showData method of the user object to a variable
// var showDataVar = user.showData;

// showDataVar (); // Samantha 12 (from the global data array, not from the local data array)

// // Bind the showData method to the user object
// var showDataVar = user.showData.bind (user);

// // Now the we get the value from the user object because the this keyword is bound to the user object
// showDataVar (); // P. Mickelson 43



// `----------------------------- Call Invocation------------------------`
var g = greet.call(data); // returns the actual function. Hence can be called at anytime
console.log("Bind returns 1",g);
// g(); // gives error g is not a function as opposed to bind which gave g as the actual function.

g = greet.call(null, "male", 12); // no object to bind to . The other parameter are preset except the last one.
console.log("Bind returns 2",g);

g = greet.call(null, "female", 26, "Ekta Mishra"); // no object to bind to . The other parameter are preset except the last one.
console.log("Bind returns 3",g);

// Apply is same as above just the way of argument passing is different which is as array.