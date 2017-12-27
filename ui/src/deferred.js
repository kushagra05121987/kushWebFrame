$.Deferred(function(deferred) {console.log("Before ",deferred)});

function returnDeferred(type) {
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
    return deferred;
}

// resolve
returnDeferred('resolve').then(function(message) {
    console.log("%c Inside then ", "background: #cccccc; color: #333333", message);
}).done(function(message) {
    console.log("%c Inside done ", "background: #cccccc; color: #333333", message);
}).fail(function(message) {
    console.log("%c Inside fail ", "background: #cccccc; color: #333333", message);
}).always(function(message) {
    console.log("%c Inside always ", "background: #cccccc; color: #333333", message);
}).progress(function(message) {
    console.log("%c Inside Progress ", "background: #cccccc; color: #333333", message);
});

// reject
returnDeferred('reject').then(function(message) {
    console.log("%c Inside then ", "background: #cccccc; color: #333333", message);
}).done(function(message) {
    console.log("%c Inside done ", "background: #cccccc; color: #333333", message);
}).fail(function(message) {
    console.log("%c Inside fail ", "background: #cccccc; color: #333333", message);
}).always(function(message) {
    console.log("%c Inside always ", "background: #cccccc; color: #333333", message);
});

returnDeferred("resolve").done().fail(); 
// above is similar to 
returnDeferred("resolve").then(function() {}, function() {}); 

