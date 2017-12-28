(function( $ ){
    $.fn.myfunction = function() {
       console.log('hello world');
       return this;
    }; 
 })( jQuery );

var node = document.createDocumentFragment("input");
node.type = "text";
node.name = "textInput";

console.log($(node).myfunction());

