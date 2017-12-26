export function jUpload($) {
    var delete_cookie = function(name) {
        document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    };
    delete_cookie('testCookie');
    delete_cookie('test-cookie');
    if(!document.cookie.match("testCookie")) {
        document.cookie = "testCookie=testValue;expires=36000";
    }
    var xhrcomp = null
    var dataTransfer = new Object();
    dataTransfer.name = "Kushagra Mishra";
    dataTransfer.gender = "Male";
    var file = $("input[name='file']")[0];
    dataTransfer.file = file.files[0];
    var randomVar = Math.round(Math.random() * (9999999999+1) - 0.5);
    var boundary = 90000000000 + randomVar;

    $(document.body).on('change', "input[name='file']", function(e) {
        console.log(e, this, e.target)
        var formdata = new FormData();
        var file = $("input[name='file']")[0];        
        formdata.append("ufiles", file.files[0]);
        var xmlhttp = $.ajax({
            url: "http://sysblog.local:8080/home.php",
            // url: "http://sysblog.local:8080/download.php",
            // url: "http://sysblog.local:8080/index.php",
            // url: "http://localhost:9000/index.php",
            type: 'POST',
            // accept: "application/json",
            // // contentType: "text/plain",
            xhrFields: {
                withCredentials: true,
                responseType: 'blob',
                onprogress: function(e) {console.log("%c On Progress ", "background: darkgreen; color: #ffffff", e);},
            },
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                myXhr.upload.onprogress = function(e) {console.log("%c On Progress Upload ", "background: orange; color: #ffffff", e);}
                return myXhr;
            },
            // contentType: "multipart/form-data; charset=UTF-8; boundary=---------------------------" + boundary,
            processData: false,
            // mime: 'multipart/form-data',
            // contentType: "application/x-www-form-urlencoded",
            // contentType: "application/json",
            // contentType: "application/kushagra",
            // contentType: "text/plain",
            // data: JSON.stringify({name: "kushagra mishra", "age": "38"}),
            // data: {name: "kushagra", "age": "38"},
            // data: "this is a message sent from post",
            // data:dataTransfer,
            // data: "email=karizmatic.kay%40gmail.com&firstname=Kushagra&lastname=Mishra",
            data: formdata,
            crossDomain: true,
            beforeSend: function(xhr) {
                xhrcomp = xhr;
                console.log("%c XmlHttpRequest from send before","background: green; color: #FFFFFF", xhr);
                xhr.withCredentials = true;
                xhr.progress = function(e) {
                    console.log("%c progress event ", "background: #ccc666, color: #333", e)
                }
            },
            // // converters: {
            // //     'json': function(result) {
            // //         // Do Stuff
            // //         console.log("%c Result after conversion. ", "background: darkgreen; color: white", result);
            // //     }
            // // },
            // dataType: "blob",
            // // withCredentials: true,
            headers: {
                'test-custom-header': 'test-custom-header-value',
                // 'Cookie': document.cookie // cannot set Cookie header. we can set cookies to send in different headers. We get error Refused to set unsafe header "Cookie"
            }, // we acn use this approach or chr.setRequestHeader also
            async: true,
            success: function(response, textStatus, jqXHR) {
                console.log("%c jqXHR compare with xhr ","background: green; color: #FFFFFF", xhrcomp == jqXHR);            
                console.log("%c jqXHR from success ","background: green; color: #FFFFFF", jqXHR);
                console.log("%c Jquery ajax. ", "background: #999999; color: #333333", response);
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log("%c Jquery ajax. ", "background: red; color: black", textStatus, errorThrown);
            }
        });
    
        xmlhttp.progress = function(e) {
            console.log(e);
        }
    
        console.log(xmlhttp)
    
        /// callback for jsonp
        function callme(arg) {return arg;}
        callme(1);
    })
    

    // not all the events will work in synchronous calls but for asynchronous calls all the events will work.
}