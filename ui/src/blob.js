var inputFile = document.getElementsByName("file").item(0);
var blob = new Blob(["<a href='#'>Click here </a><p>Right Here</p>"], {
    type: "text/html"
});

var fileReader = new FileReader();

// fileReader.onload = function(err) {
//     console.log("%c Load Call Blob", err);
//     // var node = document.createElement(fileReader.result);
//     document.body.insertAdjacentHTML("beforeend", fileReader.result);
//     console.log(fileReader.result);
// }
// fileReader.readAsText(blob); 


var blob2;
// inputFile.onchange = function(e) {
//     blob2 = new Blob([inputFile.files[0]], {
//         type: "image/png"
//     });
//     fileReader.onload = function(err) {
//         console.log("%c Load Call Blob Input", err);
//         var elem = document.createElement('img');
//         elem.src = fileReader.result;
//         // document.body.append(elem);
//     }
//     fileReader.readAsDataURL(blob2);     
// }

var blob3 = new Blob(["src/adhaar.png"], {
    type: "image/png"
});
fileReader.onload = function(err) {
    console.log("%c Load Call Blob Input 3", err);
    var elem = document.createElement('img');
    elem.src = fileReader.result;
    document.body.append(elem);
}
fileReader.readAsBinaryString(blob3);