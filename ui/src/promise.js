$(document).ready(function($){
    var src = "";
    function loadImage() {
        console.log("Image loading method");
        return new Promise(function(resolve, reject){
            $("img[name='promiseLoad']").on('load', function(e) {
                console.log("Image Loaded")
                var input = $("input[name='file']")[0];
                var file = input.files[0];
                resolve("Image Loaded");
            });
            // $("img[name='promiseLoad']").attr('src', src) 
            // $("img[name='promiseLoad']").attr('src', '')               
        });
    }
    function promiseReject() {
        return new Promise(function(resolve, reject) {
            setTimeout(function() {            
                // resolve("Second promise resolved");
                reject("Second promise rejected"); 
            }, 5000);
        });
    }

    function promiseResolve() {
        return new Promise(function(resolve, reject) {
            setTimeout(function() {            
                resolve("Second promise resolved");
                // reject("Second promise rejected"); 
            }, 5000);
        });
    }


    // nested then and catch
    // function checkTextArea() {
    //     return new Promise(function(resolve, reject) {
    //         $('textarea').on('change', function() {
    //             console.log('inside change');
    //             resolve("Resolved textarea");
    //         })
    //     });
    // }
    // checkTextArea().then(function(message) {
    //     console.log("Nested then Parent");
    //     checkTextArea().then(function(message) {
    //         console.log("Nested then Child", message); 
    //         return 1;           
    //     }).then(function(message) {
    //         console.log("Nested then Child 2", message);
    //         return 2;
    //     }).then(function(message) {
    //         console.log("Nested then Child 3", message);     
    //         return promiseReject();       
    //     });
    // }).catch(function(message) {
    //     console.log("Nested catch", message);
    // });
    // checkTextArea().then(function(message) {
    //     console.log("then Child", message); 
    //     return 1;           
    // }).then(function(message) {
    //     console.log("then Child 2", message);
    //     return 2;
    // }).then(function(message) {
    //     console.log("then Child 3", message);     
    //     return promiseReject();       
    // });
    

    $(document.body).on('change', "input[name='file']", function(e) {
        var file = this.files[0];
        src = URL.createObjectURL(file);
        $("img[name='promiseLoad']").attr('src', src);
        // console.log("%c Promise ", "background: #5555cc; color: #FFFFFF", loadImage());

        // resolve in then
        // loadImage(src).then(function(message) {
        //     console.log("%c Resolve in then ", "background: #5555cc; color: #FFFFFF");        
        //     console.log("Inside callback Resolve", message);
        //     return promiseResolve();
        // }).then(function(message) {
        //     console.log("Inside callback 2 Resolve", message);        
        // }).catch(function(message) {
        //     console.log("Inside Catch Resolve", message);        
        // }).finally(function() {
        //     console.log("Inside finally From Resolve.");
        // });

        // reject in catch
        // loadImage(src).then(function(message) {
        //     console.log("%c Reject in then ", "background: #5555cc; color: #FFFFFF");            
        //     console.log("Inside callback Reject", message);
        //     return promiseReject();
        // }).then(function(message) {
        //     console.log("Inside callback 2 Reject", message);        
        // }).catch(function(message) {
        //     console.log("Inside Catch Reject", message);        
        // }).finally(function() {
        //     console.log("Inside finally From Reject.");
        // });

        // load with no promise returned
        // loadImage(src).then(function(message) {
        //     console.log("%c Load With no promise ", "background: #5555cc; color: #FFFFFF");            
        //     console.log("Then Chain 1 without promise returned. ", message);        
        //     return 1;
        // }).then(function(message) {
        //     console.log("Then Chain 2 without promise returned. ", message);
        //     return 2;        
        // }).then(function(message) {
        //     console.log("Then Chain 3 without promise returned. ", message);
        //     return 3;
        // }).catch(function(message) {
        //     console.log("Catch Chain 1 without promise returned. ", message);
        //     return 1;
        // }).catch(function(message) {
        //     console.log("Catch Chain 2 without promise returned. ", message);
        //     return 2;        
        // }).catch(function(message) {
        //     console.log("Catch Chain 3 without promise returned. ", message);
        //     return 3;        
        // }).finally(function() {
        //     console.log("Inside finally From chain.");
        // });


        // load with no promise returned
        // loadImage(src).then(function(message) {
        //     console.log("%c Load Then Chain After catch ", "background: #5555cc; color: #FFFFFF");            
        //     console.log("Then Chain 1 After catch. ", message);        
        //     return 1;
        // }).then(function(message) {
        //     console.log("Then Chain 2 After catch. ", message);
        //     return 2;        
        // }).then(function(message) {
        //     console.log("Then Chain 3 After catch. ", message);
        //     return 3;
        // }).catch(function(message) {
        //     console.log("Catch Chain 1 After catch. ", message);
        //     return 1;
        // }).catch(function(message) {
        //     console.log("Catch Chain 2 After catch. ", message);
        //     return 2;        
        // }).catch(function(message) {
        //     console.log("Catch Chain 3 After catch. ", message);
        //     return 3;        
        // }).then(function(message) {
        //     console.log("Inside then after catch ", message);
        // }).finally(function() {
        //     console.log("Inside finally From chain after catch.");
        //     return 4;
        // }).then(function(message) {
        //     console.log("Inside then after finally ", message);
        // });

        // nested then and catch
        // loadImage().then(function(message) {
        //     console.log("Nested then Parent");
        //     loadImage().then(function(message) {
        //         console.log("Nested then Child", message); 
        //         return 1;           
        //     }).then(function(message) {
        //         console.log("Nested then Child 2", message);
        //         return 2;
        //     }).then(function(message) {
        //         console.log("Nested then Child 3", message);     
        //         return promiseReject();       
        //     });
        // }).catch(function(message) {
        //     console.log("Nested catch", message);
        // });

        // promiseResolve().then(function() {
        //     console.log('Success');
        //     return 1;
        // }, function() {
        //     console.log('Error');
        //     return 2
        // }).then(function(message) {
        //     console.log("Success chain", message);
        // });

        // promiseReject().then(function() {
        //     console.log('Success');
        //     return 1;
        // }, function() {
        //     console.log('Error');
        //     return 2;
        // }).then(function(message) {
        //     console.log("Error chain", message);
        // });
    })  
    
    // var p1 = Promise.resolve(3);
    // var p2 = promiseResolve();
    // var p3 = 12345;
    // var p4 = new Promise(function(resolve, reject) {
    //     resolve(40);
    // });
    // var p5 = promiseReject();
    // console.log(p1, p2, p3, p4);

    // // Promise all
    // Promise.all([p1,p2,p3, p4, promiseReject()]).then(function(message) {
    //     console.log("Success ", message);
    // }).catch(function(message) {
    //     console.error("Catch Error ", message);
    // });

    // function wait(callback, message) {
    //     return new Promise(function(resolve, reject) {
    //         if("resolve" == callback) {
    //             setTimeout(function() {
    //                 resolve(message);
    //             }, 5000);
    //         } else {
    //             setTimeout(function() {
    //                 reject(message);
    //             }, 5000);
    //         }
    //     });
    // }
    
    // async function resolvePromise() {
    //     var waitMessage = await wait('resolve', 'success');
    //     console.log(waitMessage)
    //     return waitMessage;
    // }

    // async function rejectPromise() {
    //     var waitMessage = await wait('reject', 'Error Fatal');
    //     console.log(waitMessage)
    //     return waitMessage;
    // }

    // resolvePromise().then(function(message) {
    //     console.log("Success ", message);
    // }).catch(function(message) {
    //     console.error("Catch Error ", message);
    // });

    // rejectPromise().then(function(message) {
    //     console.log("Success ", message);
    // }).catch(function(message) {
    //     console.error("Catch Error ", message);
    // });

    function waiting() {
        return new Promise(function(resolve, reject) {
            setTimeout(function() {
                console.log("resolved");
                resolve(30);
            }, 5000);
        });
    }
    var cld = await waiting(); // cld gets 30
    console.log(cld);
})