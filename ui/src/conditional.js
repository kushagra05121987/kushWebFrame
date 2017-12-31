fetch("http://sysblog.local:8080/conditional.php").then(function(response) {
    console.log(response);
    // console.log(response.json());
    return response.json();
}).then(function(json) {
    $(".include_json").text(JSON.stringify(json));
});