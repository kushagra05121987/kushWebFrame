export function download($) {
    

    // download file
    var request = new XMLHttpRequest();

    console.log("%c ===================== Download On Progress Check without .upload start =================== ", "background: orange; color: #ffffff");
    var data = {"name": "Kushagra Mishra"};
    request.withCredentials = true;
    request.open("GET", "http://sysblog.local:8080/download.php");
    // request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    // request.setRequestHeader("Accept", "json");
    request.responseType = "blob";
    request.onabort = function(e) {console.log("%c On Abort ", "background: darkgreen; color: #ffffff", e);}; 
    request.error = function(e) {console.log("%c On Error ", "background: darkgreen; color: #ffffff", e);};
    request.onloadend = function(e) {console.log("%c On Load End ", "background: darkgreen; color: #ffffff", e);};
    request.onloadstart = function(e) {console.log("%c On Load Start ", "background: darkgreen; color: #ffffff", e);};
    request.onprogress = function(e) {console.log("%c On Progress ", "background: darkgreen; color: #ffffff", e);};
    request.onload = function(e) {console.log("%c On Load ", "background: darkgreen; color: #ffffff", e);};    
    request.onreadystatechange = function(e) {
        console.log("%c Response Headers ", "background: darkgreen; color: #ffffff", request.getAllResponseHeaders());
        console.log("%c On Readstatechange ", "background: darkgreen; color: #ffffff", e);
        console.log("%c On readyState ", "background: darkgreen; color: #ffffff", request.readyState);
        console.log("%c On response ", "background: darkgreen; color: #ffffff", request.response);

        // console.log("%c On responseText ", "background: darkgreen; color: #ffffff", req.responseText);
        console.log("%c On responseType ", "background: darkgreen; color: #ffffff", request.responseType);
        console.log("%c On responseURL ", "background: darkgreen; color: #ffffff", request.responseURL);
        console.log("%c On responseXML ", "background: darkgreen; color: #ffffff", request.responseXML);
        console.log("%c On status ", "background: darkgreen; color: #ffffff", request.status);
        console.log("%c On statusText ", "background: darkgreen; color: #ffffff", request.statusText);
        console.log("%c On timeout ", "background: darkgreen; color: #ffffff", request.timeout);
    };
    request.ontimeout = function(e) {console.log("%c On Timeout ", "background: darkgreen; color: #ffffff", e);};

    console.log("%c ===================== Download On Progress Check without .upload end =================== ", "background: orange; color: #ffffff");


    // upload object
    console.log("%c ===================== Download On Progress Check with .upload =================== ", "background: orange; color: #ffffff");

    request.upload.onabort = function(e) {console.log("%c On Abort Upload ", "background: darkgreen; color: #ffffff", e);}; 
    request.upload.error = function(e) {console.log("%c On Error Upload ", "background: darkgreen; color: #ffffff", e);};
    request.upload.onloadend = function(e) {console.log("%c On Load End Upload ", "background: darkgreen; color: #ffffff", e);};
    request.upload.onloadstart = function(e) {console.log("%c On Load Start Upload ", "background: darkgreen; color: #ffffff", e);};
    request.upload.onprogress = function(e) {console.log("%c On Progress Upload ", "background: darkgreen; color: #ffffff", e);};

    request.upload.onload = function(e) {console.log("%c On Load Upload ", "background: darkgreen; color: #ffffff", e);};

    request.upload.ontimeout = function(e) {console.log("%c On Timeout Upload ", "background: darkgreen; color: #ffffff", e);};

    request.send();
}