// we will be using two methods insertBefore and insertAdjacentHTML
var node = document.createDocumentFragment("div");
node.custom = "value";
node.textContent = "Hello I have been defined";
// node.setAttribute("x", "y");// doesn't work  
document.body.insertBefore(node, document.body.children[0]); // this says insert node inside document.body before document.body.children[0].

// insertAdjacentHTML uses the text passed to this function and parses it to html and inserts it to the specified position.
// positions can be of following types.
/**
 * 
    'beforebegin'
    Before the element itself.
    'afterbegin'
    Just inside the element, before its first child.
    'beforeend'
    Just inside the element, after its last child.
    'afterend'
    After the element itself.

    element.insertAdjacentHTML(position, text);
 * 
 */

var parentnode = document.getElementsByTagName("custom-element").item(0);
// node.textContent = "Custom Element"

var childNodeFrag = document.createDocumentFragment("div");
var childNodeElem = document.createElement("div");
childNodeFrag.textContent = "Hi i am a child node inside custom element fragment";
childNodeElem.textContent = "Hi i am a child node inside custom element";

parentnode.insertAdjacentHTML("afterend", "<div contenteditable='true'>Inserted Adjacent HTML</div>");

parentnode.insertAdjacentElement("afterend", childNodeElem);
// parentnode.insertAdjacentElement("afterend", childNodeFrag);// This needs to be an instance of Element and not Fragment.

// var d1 = document.getElementById('one');
// d1.insertAdjacentHTML('afterend', '<div id="two">two</div>');
