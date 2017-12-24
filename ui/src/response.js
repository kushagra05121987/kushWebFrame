var formdata = new FormData();
formdata.append("mykey", "myvalue");
formdata.append("json", "{'name': 'kushagra mishra', 'age': '24'}");

var headers = new Headers();
headers.append("Content-type", "application/json");
var response = new Response(formdata, {
    headers: headers
});