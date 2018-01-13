var node = document.getElementById("some-id");
console.log("Div Selected", node);
var observer = new MutationObserver(function(mutationRecordList, mutationObserver) {
    console.log(mutationRecordList, mutationObserver);
});
var mutationObserverInit = {
    attributes: true,
    childList: true,
    characterData: true
};

var mutationObserverInitGENERIC = {
    attributes: true,
    childList: true,
    characterData: true,
    subtree: true,
    attributeOldValue: true,
    characterDataOldValue: true
};


observer.observe(node, mutationObserverInit); // this method takes in target and mutationObserverInit and returns void.

observer.observe(node.children.item(0).childNodes[0], mutationObserverInit); // this works for characterData

var observerRecords = observer.takeRecords(); // returns whatever is there inside the MutationObserver instance's record queue and empties it.
console.log(observerRecords);
// observer.disconnect(); // once disconnected no observers will observe anything.

// setTimeout(function() {
//     node.setAttribute("Custom", "value");
//     node.textContent = "Hello";
// }, 2000);
// setTimeout(function() {
//     console.log(observerRecords);
// }, 5000);


// var target = document.querySelector('#some-id').childNodes[0];

// // create an observer instance
// var observer = new MutationObserver(function(mutations) {
//   mutations.forEach(function(mutation) {
//     console.log(mutation.type);
//   });    
// });
 
// // configuration of the observer:
// var config = { attributes: true, childList: false, characterData: true };
 
// // pass in the target node, as well as the observer options
// observer.observe(target, config);

// GENERIC MUTATOR ON ALL DIVS ------ This won't work because observe expects only a single element not a collection. And hence we will not be able to bind addition and removal of elements from dom. Thats why we need CustomElementsRegistery.
var nodeDIV = document.getElementsByTagName("div").item(0);
observer.observe(nodeDIV, mutationObserverInitGENERIC);

setTimeout(function() {
    $('body').prepend("<div class='custom-div'>New Element Added</div>");
}, 3000);