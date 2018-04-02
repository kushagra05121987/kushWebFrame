// var customElementCopy = new CustomElementRegistry(); // creating a new instance of CustomElementRegistry like this is not allowed. Hence we need to access CustomElementRegistry using window.customElements
// the above can also be taken from window.customElement which also returns a new instance for CustomElementRegistry.
var constructorHTMLCallback = function() {
    // var htmlelement = new HTMLElement("k-button");

    // htmlelement.addEventListener("click", function() {
    //     console.log("Clicked My Custom Element");
    // });
    // htmlelement.setAttribute("contenteditable", "true");
    // // document.body.append(this);
    // htmlelement.textContent = "I am a custom defined element.";
    // document.body.insertBefore(this, document.body.children([0]));

    return Reflect.construct(HTMLElement, [], constructorHTMLCallback);
}

// constructorHTMLCallback.prototype = Object.create(HTMLElement.prototype);
// Object.setPrototypeOf(constructorHTMLCallback.prototype, HTMLElement.prototype);
// Object.setPrototypeOf(constructorHTMLCallback, HTMLElement);


// constructorHTMLCallback.prototype.connectedCallback = function () {
//     console.log( "connected" )
//     this.innerHTML = "Hello v2"
// } 

// constructorHTMLCallback.prototype.diconnectedCallback = function () {
//     console.log( "disconnected" )
//     // this.innerHTML = "Hello v2"
// } 

// constructorHTMLCallback.prototype.constructor = function () {
//     console.log( "Constructor" );
//     HTMLElement.constructor();
//     HTMLElement.prototype.constructor();
//     this.innerHTML = "Hello v1"
// }

// constructorHTMLCallback.prototype.attributeChangedCallback = function(attributeName, oldValue, newValue, namespace) {
//     console.log('attribute change');
//     console.log(attributeName, oldValue, newValue, namespace);
// }


// var node = customElements.define("k-button", constructorHTMLCallback);

// console.log(customElements.get("k-button"));

// customElements.whenDefined("k-button").then(function(arg) {
//     console.log("Element Defined ", arg);
// }).catch(function(e) {
//     console.log("Error", e);
// });

// console.log(node)

// var observer = new MutationObserver(function(mutationsList, MutationObserverO) {
//     console.log("%c Mutation Done .... ", "background:yellow: color:#333", mutationsList, MutationObserverO);
// });

// class BasicElement extends HTMLElement {
//     connectedCallback() {
//       console.log("Connected..");
//       this.textContent = 'Just a basic custom element.';
//       var node = document.getElementsByTagName("basic-element")[0];
//       observer.observe(node, {attributes: true, attributeFilter: ["custom"]});
//     }

//     constructor () {
//         console.log('Constructin’');
//         super();
//     }
      
//     disconnectedCallback () {
//         console.log('Disconnectin’');
//     }

//     static get observedAttributes() {return ['custom']; }

//     attributeChangedCallback(attributeName, oldValue, newValue, namespace) {
//         console.log('Attribute Changed');
//         console.log(attributeName, oldValue, newValue, namespace);
//     }
//   }
// customElements.define('basic-element', BasicElement);

// console.log(customElements.get("basic-element"));

// setTimeout(function() {
//     $(document.body).append("<basic-element></basic-element>");
// },3000)

// function CustomElement() {
//     return Reflect.construct(HTMLElement, [], CustomElement);
// }
// Object.setPrototypeOf(CustomElement.prototype, HTMLElement.prototype);
// Object.setPrototypeOf(CustomElement, HTMLElement);

// customElements.define('custom-element', CustomElement);