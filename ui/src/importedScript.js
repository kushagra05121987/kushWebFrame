console.log("inside shadow", document, document.currentScript.ownerDocument);
var ownerDoc = document.currentScript.ownerDocument;
var doc = document;
function CustomElementsLifeBindings() {
    return Reflect.construct(HTMLElement, [], CustomElementsLifeBindings);
}

CustomElementsLifeBindings.prototype = Object.create(HTMLElement.prototype);
CustomElementsLifeBindings.prototype.connectedCallback = function() {
    console.log("connected");
    var node = doc.getElementsByTagName("basic-element")[0];
    var kbutton = doc.getElementsByTagName("k-button")[0];
    var contentElement = doc.getElementsByTagName("content-element")[0];
    // window.ndJ = $("basic-element")[0];
    // console.log(nd);
    if(typeof node != 'undefined' && node != null) {
        console.log('inside connect if', node);
        // var node = ownerDoc.getElementById('contents');
        // console.log(node);
        // var template = $("#slots").get(0);    
        var template = document.getElementById("slots");
        // node.attachShadow({mode: 'open'}).appendChild($("slot[name*='slot']").get(0));
        // node.attachShadow({ mode: 'closed' }).appendChild(template.content.cloneNode(true));
        node.attachShadow({ mode: 'open' }).appendChild(template.content.cloneNode(true));
    }
    if(typeof kbutton != "undefined" && kbutton != null) {
        console.log("inside k button");
        var host = document.querySelector('k-button');
        var root = host.createShadowRoot(); // similar to host.attachShadow({mode: 'open'}); createShadowRoot is now deprecated
        var frag = document.createDocumentFragment();
        var ele = document.createElement('button');
        // root.textContent = 'こんにちは、影の世界!';
        ele.textContent = 'こんにちは、影の世界!';
        root.appendChild(ele);
        // root.innerHTML = ele;
    }
    if(typeof contentElement != "undefined" && contentElement != null) {
        console.log("inside k button");
        var host = document.querySelector('content-element');
        var root = host.createShadowRoot(); // similar to host.attachShadow({mode: 'open'}); createShadowRoot is now deprecated
        var contentTemplate = document.querySelector('template[is="content-template"]')[0];
        // root.appendChild(contentTemplate.content.cloneNode(true));
    }
}
CustomElementsLifeBindings.prototype.createdCallback = function() {
    console.log("first construct .... ");
}

CustomElementsLifeBindings.prototype.disconnectedCallback = function() {
    console.log("disconnected");
}

// basic element with custom slot based structure
customElements.define('basic-element', CustomElementsLifeBindings);


// slots
customElements.define('element-details',
    class extends HTMLElement {
        constructor() {
            super();
            // console.log('constructor');
            // var detailsNode = document.currentScript.ownerDocument.getElementById('element-details-template');
            // console.log(detailsNode);
            // if(typeof detailsNode != "undefined") {
            //     console.log(detailsNode)
            //     var template = detailsNode.content;
            //     const shadowRoot = this.attachShadow({ mode: 'open' })
            //     .appendChild(template.cloneNode(true));
            // }
        }
        connectedCallback() {
            // console.log('connecting');            
            var detailsNode = document.getElementById('element-details-template');
            if(typeof detailsNode != "undefined" && detailsNode != null) {
                // console.log(detailsNode)
                var template = detailsNode.content;
                const shadowRoot = this.attachShadow({ mode: 'open' })
                .appendChild(template.cloneNode(true));
            }
        }

        disconnectedCallback() {
            // console.log('disconnecting');            
            // window.detailsNode = document.getElementById('element-details-template');
            // console.log(detailsNode);
        }

})

// button
// customElements.define("k-button", CustomElementsLifeBindings, {
//     extends: 'button'
// });


// following section doesn't work because there is no p-button element in document and extends is not supported by browser currently.

class pbutton extends HTMLElement {
    constructor() {
        super();
        console.log('constructor p');        
        var kbutton = doc.getElementsByTagName("p-button")[0];
        this.addEventListener("click", () => {
            // Draw some fancy animation effects!
            console.log("inside pbutton click");
        });
        
        // var detailsNode = document.currentScript.ownerDocument.getElementById('element-details-template');
        // console.log(detailsNode);
        // if(typeof detailsNode != "undefined") {
        //     console.log(detailsNode)
        //     var template = detailsNode.content;
        //     const shadowRoot = this.attachShadow({ mode: 'open' })
        //     .appendChild(template.cloneNode(true));
        // }
    }
    connectedCallback() {
        console.log('connecting p');     
        var pbutton = doc.getElementsByTagName("p-button")[0];
        if(typeof pbutton != "undefined" && pbutton != null) {
            console.log("inside p button");
            var host = document.querySelector('p-button');
            var root = host.createShadowRoot(); // similar to host.attachShadow({mode: 'open'}); createShadowRoot is now deprecated
            // var frag = document.createDocumentFragment();
            // var ele = document.createElement('button');
            // root.textContent = 'こんにちは、影の世界!';
            root.textContent = 'こんにちは、影の世界!';
            // root.appendChild(ele);
            // root.innerHTML = ele;
        }
    }

    disconnectedCallback() {
        console.log('disconnecting');            
        // window.detailsNode = document.getElementById('element-details-template');
        // console.log(detailsNode);
    }

}

customElements.define('p-button',pbutton, {extends: "button"})


function CustomElementsReg() {
    return Reflect.construct(HTMLElement, [], CustomElementsReg);
}

CustomElementsReg.prototype = Object.create(HTMLElement.prototype);
CustomElementsReg.prototype.connectedCallback = function() {
    console.log("connected");
    var contentElement = doc.getElementsByTagName("content-ele")[0];
    // window.ndJ = $("basic-element")[0];
    // console.log(nd);
   
    
    if(typeof contentElement != "undefined" && contentElement != null) {
        console.log("inside k button");
        var host = contentElement;
        var root = host.createShadowRoot(); // similar to host.attachShadow({mode: 'open'}); createShadowRoot is now deprecated
        var contentTemplate = document.querySelector('template[is="content-template"]');
        root.appendChild(contentTemplate.content.cloneNode(true));
    }
}
CustomElementsReg.prototype.createdCallback = function() {
    console.log("first construct .... ");
}

CustomElementsReg.prototype.disconnectedCallback = function() {
    console.log("disconnected");
}

customElements.define("content-ele", CustomElementsReg);