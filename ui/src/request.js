var request = new Request("http://sysblog.local:8080/home.php", {
    mehtod: "GET"
});

var headers = new Headers();
headers.append("Content-type", "application/json");
headers.append("Accept", "application/json");

fetch("https://api.randomuser.me", {
    method: "GET",
    redirect: true,
    headers: headers
}).then(function(response) {
    console.log(response)
    resp = response;
    return resp.json();
}).then(function(data) {
    console.log(data);
    dat1 = data;
}).catch(function(err) {
    console.log(err)
});

fetch(request, {
    method: "GET",
    redirect: true,
    headers: headers
}).then(function(response) {
    console.log(response)
    resp = response;
    return resp.json();
}).then(function(data) {
    console.log(data);
    dat = data;
}).catch(function(err) {
    console.log(err)
});