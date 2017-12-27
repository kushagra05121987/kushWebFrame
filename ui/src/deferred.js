$.Deferred(function(deferred) {console.log("Before ",deferred)});

function returnDeferred(type, isPromiseRequired) {
    var deferred = $.Deferred();
    setTimeout(function(message) {
        console.log("Timeout executing.");
        var count = 0;
        var int = setInterval(function() {
            console.log("%c Inside setInterval : count = ", "background: green; color: #e5e5e5", count);  
            deferred.notify(count);
            if(count == 10) {
                clearInterval(int);
                if(type == "resolve") {
                    deferred.resolve(message);
                } else if(type == "reject") {
                    deferred.reject(message);            
                }
            }
            count++;
        });
    }, 3000, "success");

    if(isPromiseRequired) {
        return deferred.promise();
    }
    return deferred;
}

// resolve
// returnDeferred('resolve').then(function(message) {
//     console.log("%c Inside then ", "background: #cccccc; color: #333333", message);
// }).done(function(message) {
//     console.log("%c Inside done ", "background: #cccccc; color: #333333", message);
// }).fail(function(message) {
//     console.log("%c Inside fail ", "background: #cccccc; color: #333333", message);
// }).always(function(message) {
//     console.log("%c Inside always ", "background: #cccccc; color: #333333", message);
// }).progress(function(message) {
//     console.log("%c Inside Progress ", "background: #cccccc; color: #333333", message);
// });

// // reject
// returnDeferred('reject').then(function(message) {
//     console.log("%c Inside then ", "background: #cccccc; color: #333333", message);
// }).done(function(message) {
//     console.log("%c Inside done ", "background: #cccccc; color: #333333", message);
// }).fail(function(message) {
//     console.log("%c Inside fail ", "background: #cccccc; color: #333333", message);
// }).always(function(message) {
//     console.log("%c Inside always ", "background: #cccccc; color: #333333", message);
// });

// returnDeferred("resolve").done().fail(); 
// // above is similar to 
// returnDeferred("resolve").then(function() {}, function() {}); 


// resolve promise from inside the then method using $.Deferred
// var deferred = returnDeferred('resolve');
// deferred.done(function(message) {
//     console.log("%c Inside then ", "background: #cccccc; color: #333333", message);
// }).fail(function(message) {
//     console.log("%c Inside fail ", "background: #cccccc; color: #333333", message);
// }).progress(function(message) {
//     console.log("%c Inside Progress ", "background: #cccccc; color: #333333", message);
//     deferred.resolve("Breaking the loop");
// });

// In order to solve this we use deferred.promise()
// var deferred = returnDeferred('resolve', true);
// deferred.done(function(message) {
//     console.log("%c Inside then ", "background: #cccccc; color: #333333", message);
// }).fail(function(message) {
//     console.log("%c Inside fail ", "background: #cccccc; color: #333333", message);
// }).progress(function(message) {
//     console.log("%c Inside Progress ", "background: #cccccc; color: #333333", message);
//     deferred.resolve("Breaking the loop"); // gives error that resolved is not a function
// });

// any number of arguments can be passed to resolve and reject callbacks
// var deferred = returnDeferred('reject', false);
// deferred.done(function(arg1, arg2, arg3) {
//     console.log("%c Inside then ", "background: #cccccc; color: #333333", arg1, arg2, arg3);
// }).fail(function(arg1, arg2, arg3) {
//     console.log("%c Inside fail ", "background: #cccccc; color: #333333", arg1, arg2, arg3);
// }).progress(function(message) {
//     console.log("%c Inside Progress ", "background: #cccccc; color: #333333", message);
//     deferred.resolve("Breaking the loop", "Second Argument", "Third Argument"); // gives error that resolved is not a function
// });

// $.when is similar to Promise.all
function resolveIt() {
    var deferred = $.Deferred();
    setTimeout(deferred.resolve, 3000, "Resolved");
    return deferred;
}

function rejectIt() {
    var deferred = $.Deferred();
    setTimeout(deferred.reject, 3000, "Rejected");
    return deferred;
}

function resollveIt() {
    var deferred = $.Deferred();    
    setTimeout(deferred.resolve, 5000, "Resolved2");    
    return deferred;
}


// $.when(resolveIt(), resollveIt()).then(function(message1, message2) {
//     console.log("%c Resolved ", "background: #cccccc; color: #333333", message1, message2);
// }, function(message) {
//     console.log("%c Fails ", "background: #cccccc; color: #333333", message);        
// });

// $.when(resollveIt(), resollveIt(), rejectIt()).then(function(message1,message2, message3) {
//     console.log("%c Resolved ", "background: #cccccc; color: #333333", message1,message2, message3);
// }).done(function(message1,message2, message3) {
//     console.log("%c Done ", "background: #cccccc; color: #333333", message1,message2, message3);
// }).fail(function(message1,message2, message3) {
//     console.log("%c Fails ", "background: #cccccc; color: #333333", message1,message2, message3);        
// });

// .promise()
function animateDiv() {
    $('div:last-child').fadeOut(5000);
}
animateDiv();

var divs = $('div');
// divs.promise().then(function(message) { // runs after 5 secs when animation on div ends
//     console.log("%c success ", "background: #cccccc; color: #333333", message); 
// }, function(message) {
//     console.log("%c Fails ", "background: #cccccc; color: #333333", message); 
// });

$.when(divs).then(function(message) { // runs after 5 secs when animation on div ends and works same as .promise()
    console.log("%c success ", "background: #cccccc; color: #333333", message); 
}, function(message) {
    console.log("%c Fails ", "background: #cccccc; color: #333333", message); 
});