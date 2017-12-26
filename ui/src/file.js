var inputFile = document.getElementsByName("file").item(0);
var fileReader = new FileReader();

var file = new File(["test"], "test.txt", {
    type: "text/plain"
});
fileReader.onload = function(err) {
    console.log("%c Load Call File", err);
    var elem = document.createElement('img');
    elem.src = fileReader.result;
    document.body.append(elem);
    console.log(fileReader.result);
}
fileReader.readAsArrayBuffer(file);   

var file2;
inputFile.onchange = function(e) {
    var input = e.target;
    file2 = new File([input.files[0]], ["tesimg.png"], {
        type: "image/png"
    });
    fileReader.onload = function(err) {
        console.log("%c Load Call File Input", err);
        var elem = document.createElement('img');
        elem.src = fileReader.result;
        document.body.append(elem);
    }
    fileReader.readAsDataURL(file2);     
}

var file3 = new File(["<a href='#'>Click here</a>"], ["resources/adhaar.png"], {
    type: "image/png"
});

console.log(file);
console.log(file3);