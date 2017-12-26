export function upload($) {
    var delete_cookie = function(name) {
        document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    };
    delete_cookie('testCookie');
    delete_cookie('test-cookie');
    if(!document.cookie.match("testCookie")) {
        document.cookie = "testCookie=testValue;expires=36000";
    }

    /// callback for jsonp
    function callme(arg) {return arg;}
    callme(1);

    //Making a core javascript ajax call
    var req = new XMLHttpRequest();
    req.responseType = 'json';
    
    req.open('GET', 'http://localhost:9000/resources/dummy.json?callback=callme', true); // asynchronous
    // req.open('GET', 'http://localhost:9000/resources/dummy.json', false); // synchronous
    // req.open('GET', 'http://sysblog.local:8080/home.php', true);
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

    // req.send();
    req.timeout = -1;

    window.self.testPayload = true;
    window.tryMe = function() {}

    '----------------------------------------------------------------------------------'

    // Formdata
    var formData = new FormData();

    formData.append("username", "Groucho");
    formData.append("accountnum", 123456); // number 123456 is immediately converted to a string "123456"

    // HTML file input, chosen by user
    // formData.append("userfile", fileInputElement.files[0]);

    // JavaScript file-like object
    var content = '<a id="a"><b id="b">hey!</b></a>'; // the body of the new file...
    var blob = new Blob([content], { type: "text/xml"});

    document.getElementsByName("file").item(0).addEventListener("change", function(e) {
        // upload file
        var file = document.getElementsByName("file").item(0);
        var upload = file.files[0];
        formData.append("ufile", upload);

        formData.append("webmasterfile", blob);

        var request = new XMLHttpRequest();

        console.log("%c ===================== Upload On Progress Check without .upload start =================== ", "background: orange; color: #ffffff");
        var data = {"name": "Kushagra Mishra"};
        request.withCredentials = true;
        request.open("POST", "http://sysblog.local:8080/home.php");
        // request.setRequestHeader("Content-Type", "multipart/form-data");
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        // request.setRequestHeader("Content-Type", "application/json");
        // request.setRequestHeader("Accept", "json");
        // request.send(data); // this payload is supposed to be stringified before sending in XMLHttpRequest
        // request.send(JSON.stringify(data)); 
        // request.send(formData);
        // request.send("hello from core ajax");
        // request.send("<a href=''>hi</a>");

        // req.setRequestHeader('Content-Type', 'text/plain');
        // req.setRequestHeader('Accept', 'application/json');

        request.onabort = function(e) {console.log("%c On Abort ", "background: darkgreen; color: #ffffff", e);}; 
        request.error = function(e) {console.log("%c On Error ", "background: darkgreen; color: #ffffff", e);};
        request.onloadend = function(e) {console.log("%c On Load End ", "background: darkgreen; color: #ffffff", e);};
        request.onloadstart = function(e) {console.log("%c On Load Start ", "background: darkgreen; color: #ffffff", e);};
        request.onprogress = function(e) {console.log("%c On Progress ", "background: darkgreen; color: #ffffff", e);};
        request.onload = function(e) {console.log("%c On Load ", "background: darkgreen; color: #ffffff", e);};    
        request.onreadystatechange = function(e) {
            console.log("%c Response Headers ", "background: darkgreen; color: #ffffff", req.getAllResponseHeaders());
            console.log("%c On Readstatechange ", "background: darkgreen; color: #ffffff", e);
            console.log("%c On readyState ", "background: darkgreen; color: #ffffff", request.readyState);
            // console.log("%c On response ", "background: darkgreen; color: #ffffff", req.response);
            // console.log("%c On responseText ", "background: darkgreen; color: #ffffff", req.responseText);
            console.log("%c On responseType ", "background: darkgreen; color: #ffffff", request.responseType);
            console.log("%c On responseURL ", "background: darkgreen; color: #ffffff", request.responseURL);
            console.log("%c On responseXML ", "background: darkgreen; color: #ffffff", request.responseXML);
            console.log("%c On status ", "background: darkgreen; color: #ffffff", request.status);
            console.log("%c On statusText ", "background: darkgreen; color: #ffffff", request.statusText);
            console.log("%c On timeout ", "background: darkgreen; color: #ffffff", request.timeout);
        };
        request.ontimeout = function(e) {console.log("%c On Timeout ", "background: darkgreen; color: #ffffff", e);};

        console.log("%c ===================== Upload On Progress Check without .upload end =================== ", "background: orange; color: #ffffff");


        // upload object
        console.log("%c ===================== Upload On Progress Check with .upload =================== ", "background: orange; color: #ffffff");

        request.upload.onabort = function(e) {console.log("%c On Abort Upload ", "background: darkgreen; color: #ffffff", e);}; 
        request.upload.error = function(e) {console.log("%c On Error Upload ", "background: darkgreen; color: #ffffff", e);};
        request.upload.onloadend = function(e) {console.log("%c On Load End Upload ", "background: darkgreen; color: #ffffff", e);};
        request.upload.onloadstart = function(e) {console.log("%c On Load Start Upload ", "background: darkgreen; color: #ffffff", e);};
        request.upload.onprogress = function(e) {console.log("%c On Progress Upload ", "background: darkgreen; color: #ffffff", e);};

        request.upload.onload = function(e) {console.log("%c On Load Upload ", "background: darkgreen; color: #ffffff", e);};

        request.upload.ontimeout = function(e) {console.log("%c On Timeout Upload ", "background: darkgreen; color: #ffffff", e);};

        request.send(formData);
        
        // request.send("email=karizmatic.kay%40gmail.com&firstname=Kushagra&lastname=Mishra");
    });
}