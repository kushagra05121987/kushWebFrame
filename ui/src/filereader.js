var fileReader = new FileReader();

fileReader.onabort = function(err) {console.log("%c Abort Call ", err);}
fileReader.onerror = function(err) {console.log("%c Error Call ", err);}
fileReader.onloadStart = function(err) {console.log("%c Load Start Call ", err);}
fileReader.onload = function(err) {
    console.log("%c Load Call ", err);
    var elem = document.createElement('img');
    elem.src = fileReader.result;
    document.body.append(elem);
}
fileReader.onloadend = function(err) {console.log("%c Load End Call ", err);}
fileReader.onprogress = function(err) {console.log("%c Progress Call ", err);}

// fileReader.readAsDataURL(blob2);
fileReader.readAsDataURL(file);