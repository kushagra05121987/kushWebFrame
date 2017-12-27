function callme() {
    console.log(arguments);
    console.log(arguments.callee);
    console.log(arguments.callee.caller);
    console.log(arguments.callee.caller.name);
}

function calling() {
    callme();    
}
calling();