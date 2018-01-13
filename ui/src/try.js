console.log("inside importtest.html");

customElements.define('element-details',
class extends HTMLElement {
    constructor() {
        super();
        console.log('constructor');
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
        console.log('connecting');            
        var detailsNode = document.getElementById('element-details-template');
        if(typeof detailsNode != "undefined" && detailsNode != null) {
            console.log(detailsNode)
            var template = detailsNode.content;
            const shadowRoot = this.attachShadow({ mode: 'open' })
            .appendChild(template.cloneNode(true));
        }
    }

    disconnectedCallback() {
        console.log('disconnecting');            
        // window.detailsNode = document.getElementById('element-details-template');
        // console.log(detailsNode);
    }

})