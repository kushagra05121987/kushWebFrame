/*! ui - v1.0.0 - 2017-12-16
* Copyright (c) 2017 ; Licensed  */
(function($) {
    $(document).ready(function() {
        var delete_cookie = function(name) {
            document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        };
        delete_cookie('testCookie');
        delete_cookie('test-cookie');
        if(!document.cookie.match("testCookie")) {
            document.cookie = "testCookie=testValue;expires=36000";
        }
        $.ajax({
            url: "http://sysblog.local:8080/index.php",
            // url: "http://localhost:9000/index.php",
            type: 'GET',
            // accept: "application/json",
            // // contentType: "text/plain",
            xhrFields: {
                withCredentials: true
             },
            crossDomain: true,
            beforeSend: function(xhr) {
                xhr.withCredentials = true;
            },
            // // converters: {
            // //     'json': function(result) {
            // //         // Do Stuff
            // //         console.log("%c Result after conversion. ", "background: darkgreen; color: white", result);
            // //     }
            // // },
            // // dataType: "json",
            // // withCredentials: true,
            headers: {
                'test-custom-header': 'test-custom-header-value',
                // 'Cookie': document.cookie // cannot set Cookie header. we can set cookies to send in different headers. We get error Refused to set unsafe header "Cookie"
            }, // we acn use this approach or chr.setRequestHeader also
            success: function(response) {
                console.log("%c Jquery ajax. ", "background: #999999; color: #333333", response);
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log("%c Jquery ajax. ", "background: red; color: black", textStatus, errorThrown);
            }
        });

        /// callback for jsonp
        function callme(arg) {return arg;}
        callme(1);

        //Making a core javascript ajax call
        var req = new XMLHttpRequest();
        req.responseType = 'json';
        
        req.open('GET', 'http://localhost:9000/resources/dummy.json?callback=callme', true); // asynchronous
        req.open('GET', 'http://localhost:9000/resources/dummy.json', false); // synchronous
        req.open('GET', 'http://sysblog.local:8080/home.php', true);
        req.withCredentials = true;

        // request headers can only be set after the request is opened
        req.setRequestHeader('Content-Type', 'text/plain');
        req.setRequestHeader('Accept', 'application/json');

        req.onabort = function(e) {console.log("%c On Abort ", "background: darkgreen; color: #ffffff", e);}; 
        req.error = function(e) {console.log("%c On Error ", "background: darkgreen; color: #ffffff", e);};
        req.onloadend = function(e) {console.log("%c On Load End ", "background: darkgreen; color: #ffffff", e);};
        req.onloadstart = function(e) {console.log("%c On Load Start ", "background: darkgreen; color: #ffffff", e);};
        req.onprogress = function(e) {console.log("%c On Progress ", "background: darkgreen; color: #ffffff", e);};
        req.onreadystatechange = function(e) {
            console.log("%c Response Headers ", "background: darkgreen; color: #ffffff", req.getAllResponseHeaders());
            console.log("%c On Readstatechange ", "background: darkgreen; color: #ffffff", e);
            console.log("%c On readyState ", "background: darkgreen; color: #ffffff", req.readyState);
            // console.log("%c On response ", "background: darkgreen; color: #ffffff", req.response);
            // console.log("%c On responseText ", "background: darkgreen; color: #ffffff", req.responseText);
            console.log("%c On responseType ", "background: darkgreen; color: #ffffff", req.responseType);
            console.log("%c On responseURL ", "background: darkgreen; color: #ffffff", req.responseURL);
            console.log("%c On responseXML ", "background: darkgreen; color: #ffffff", req.responseXML);
            console.log("%c On status ", "background: darkgreen; color: #ffffff", req.status);
            console.log("%c On statusText ", "background: darkgreen; color: #ffffff", req.statusText);
            console.log("%c On timeout ", "background: darkgreen; color: #ffffff", req.timeout);
        };
        req.ontimeout = function(e) {console.log("%c On Timeout ", "background: darkgreen; color: #ffffff", e);};


        // upload object
        console.log("%c ===================== Upload On Progress Check =================== ", "background: orange; color: #ffffff");

        req.onabort = function(e) {console.log("%c On Abort Upload ", "background: darkgreen; color: #ffffff", e);}; 
        req.error = function(e) {console.log("%c On Error Upload ", "background: darkgreen; color: #ffffff", e);};
        req.onloadend = function(e) {console.log("%c On Load End Upload ", "background: darkgreen; color: #ffffff", e);};
        req.onloadstart = function(e) {console.log("%c On Load Start Upload ", "background: darkgreen; color: #ffffff", e);};
        req.onprogress = function(e) {console.log("%c On Progress Upload ", "background: darkgreen; color: #ffffff", e);};

        req.onload = function(e) {console.log("%c On Load Upload ", "background: darkgreen; color: #ffffff", e);};

         req.ontimeout = function(e) {console.log("%c On Timeout Upload ", "background: darkgreen; color: #ffffff", e);};


        var formData = new FormData();

        formData.append("username", "Groucho");
        formData.append("accountnum", 123456); // number 123456 is immediately converted to a string "123456"

        // HTML file input, chosen by user
        // formData.append("userfile", fileInputElement.files[0]);

        // JavaScript file-like object
        var content = '<a id="a"><b id="b">hey!</b></a>'; // the body of the new file...
        var blob = new Blob([content], { type: "text/xml"});

        formData.append("webmasterfile", blob);

        var request = new XMLHttpRequest();
        request.open("POST", "http://foo.com/submitform.php");
        request.send(formData);

        req.send();
        req.timeout = -1;

        window.self.testPayload = true;
        window.tryMe = function() {}

    });
})(jQuery);

// not all the events will work in synchronous calls but for asynchronous calls all the events will work.