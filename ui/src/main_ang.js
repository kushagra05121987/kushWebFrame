var app = angular.module("my-app", []);
var module2 = angular.module("moduleNumberTwo", []);
var module3 = angular.module("moduleNumberThree", []);

module2.config(function () { console.log("inside module 2 config") });
module2.run(function () { console.log("inside module 2 run") });

module3.config(function () { console.log("inside module 3 config") });
module3.run(function () { console.log("inside module 3 run") });

$injectorModule = angular.injector(["ng", "my-app"]);
console.log("injector module ", $injectorModule);

$injector = angular.injector();
// we can use this approach to inject the modules dynamically at any time.
$injector.loadNewModules(['my-app', 'moduleNumberThree']);
$injectorModule.loadNewModules(['moduleNumberTwo', 'moduleNumberThree']);

console.log("RootScope form injector at the top", $injectorModule.get("$rootScope"));
// console.log("Provider from injector ", $injectorModule.get("$provide"));
app.provider("injectService", [function() {
    this.age = 20;
    this.$get = ["$rootScope", function($rootScope) {
        console.log("ROOTSCOPE $GET PHASE injectService ", $rootScope.$$phase);
        return {age: this.age};
    }];
}]);

app.provider("myService", ["$injector","injectServiceProvider", "$rootScopeProvider" , function($injector, injectService, $rootScopeProvider) {
    var rootscope = $rootScopeProvider.$get[3];
    console.log("Inside provider ROOT");
    console.log("ROOTSCOPE CORE PHASE ", $rootScopeProvider);
    console.log("ROOTSCOPE FROM ROOTSCOPE PROVIDER ", rootscope());
    // console.log("ROOTSCOPE FROM ROOTSCOPE PROVIDER FROM INJECTOR ", $injector.invoke(rootscope)); // instantiate or invoke don't work because of unknown providers $exceptionHandlers, $parse, $browser
    this.setValue = function(val) {this.name = val}
    this.name = "Default"
    this.$get = ["injectService", "$rootScope", function(injectService, $rootScope) {
        console.log("Inside provider GET");
        console.log("ROOTSCOPE $GET PHASE ", $rootScope.$$phase);
        console.log("ROOTSCOPE INSIDE $GET FROM ROOTSCOPE PROVIDER ", rootscope());
        return {name: this.name,age:injectService.age};
    }];
}]);

app.config(["$provide", "myServiceProvider", function ($provide, myServiceProvider) {
    console.log("PROVIDE",$provide);
    myServiceProvider.setValue("Kushagra is my name");
    /**
     * 
        constant:ƒ (key, value)
        decorator:ƒ decorator(serviceName, decorFn)
        factory:ƒ (key, value)
        provider:ƒ (key, value)
        service:ƒ (key, value)
        value:ƒ (key, value)
     */
}]);


app.provider("checkService", [function() {
    console.log("RETRIEVING CHECK SERVICE => ");
    this.z1 = 200;
    this.$get = function() {
        console.log("RETRIEVING GET OF CHECK SERVICE");
        return ({value = this.z1} = {value: 400});
    }
}])

// cannot inject $provide because its returned from $provideProvider which can only be injected inside config.
app.run(["$rootScope","$injector", function ($rootScope, $injector) {
    var $scope = $rootScope;
    // $scope.$watch('enabled', function(val) {
    //     //console.log('You are now: ' + (val ? 'enabled' : 'disabled'));
    // });
    // $scope.enabled = true;
    // $scope.enabled = false;
    // $scope.enabled = 1;
    console.log("RETRIEVED VALUE", $injector.get('checkService'));
}]);

app.controller("mainController", ["$scope", "$rootScope", "$parse", "$interpolate", "$timeout","myService", function ($scope, $rootScope, $parse, $interpolate, $timeout, myService) {

    console.log("MyServiceProvider", myService);
    $scope.$watch('enabled', function (val) {
        console.log('You are now Controller: ' + (val ? 'enabled' : 'disabled'));
    });
    // Following will not trigger watcher. Because digest cycle is not started here. Digest cycle starts automatically once any controller is loaded. Live data change binding happens through watch and digest cycle. Angular builtin directives use $scope.$apply to run the event callback and start digest cycle but here we are not starting digest cycle.
    $scope.enabled = true;
    $scope.enabled = false;
    $scope.enabled = 1;
    $rootScope.df = 500;
    $root = injectorAfterAttaching.get('$rootScope'); // this gives a different object than the one on which complete application is running because this object get created as a new object from angular.injector.
    console.log("Controller 1", $root);
    var ele = angular.element(document).find('html');
    console.log("Controller 2", ele.scope().$root); // this object actaully refers to the original $rootScope that is currently being used in the application because this is taken from the element on which ng-app is defined.
    console.log("Controller 3", ele.injector().get('$rootScope')); // this object actaully refers to the original $rootScope that is currently being used in the application because this is taken from the element on which ng-app is defined.
    console.log("Controller 4", injectorAfterAttaching.get('$rootScope')); // returns same instance of rootscope as $root
    console.log("Rootscope Scope", $rootScope.scope, $rootScope.Scope);

    $scope.changeEnabled = function () {
        $scope.enabled = Boolean($scope.enabled ? 0 : 1);
        console.log("inside click", $scope.enabled);
    }

    $scope.changeWatch = function () {
        // Array change
        $scope.arrNames.push("Kushagra"); // triggers collection change
        // $scope.arrNames[0] = "Danny" // collection change
        $scope.arrNames = [1, 2, 3, 4, 5];

        // Object change
        $scope.objs.deMap.eng.push("Arts");
        $scope.objs.departs = "deleted";
        $scope.objs = "nasty";

    }

    $scope.changeWatchAgain = function () {
        // $scope.arrNames = [1,2,3,4,5];
        $scope.objs.departs = false;
    }

    // Watch vs WatchCollection vs WatchGroup
    // $scope.arrNames = ['shailendra', 'deepak', 'mohit', 'kapil'];
    // $scope.objs = {
    //     departs: ["Eng", 'Math', "Applied", "Theoretical"],
    //     deMap: {eng: ['IT', 'CS', 'MECH', "BIO"], applied: ['PHY', 'CHEM', 'ECO'], theoretical: ['PHY', 'CHEM']},
    //     teachers: {eng: 14, math: 5, applied: 10, theoretical: 20}
    // }

    // // WATCH ARRAYS    
    // $scope.$watch('arrNames', function (newVal, oldVal) {
    //     //console.log(" %c Watch TRUE === ", "background: black; color: white;", newVal, oldVal);
    // }, true);

    // $scope.$watch('arrNames', function (newVal, oldVal) {
    //     //console.log(" %c Watch FALSE === ", "background: black; color: white;", newVal, oldVal);
    // }, false);

    // $scope.$watchCollection('arrNames', function (newVal, oldVal) {
    //     //console.log(" %c Watch Collection === ", "background: black; color: white;", newVal, oldVal);
    // });

    // $scope.$watchGroup(['arrNames'], function (newVal, oldVal) {
    //     //console.log(" %c Watch Group === ", "background: black; color: white;", newVal, oldVal);
    // }, true);

    // // WATCH OBJECTS
    // $scope.$watch('objs', function (newVal, oldVal) {
    //     //console.log(" %c Watch TRUE === ", "background: black; color: white;", newVal, oldVal);
    // }, true);

    // $scope.$watch('objs', function (newVal, oldVal) {
    //     //console.log(" %c Watch FALSE === ", "background: black; color: white;", newVal, oldVal);
    // }, false);

    // $scope.$watchCollection('objs', function (newVal, oldVal) {
    //     //console.log(" %c Watch Collection === ", "background: black; color: white;", newVal, oldVal);
    // });

    // $scope.$watchGroup(['objs'], function (newVal, oldVal) {
    //     //console.log(" %c Watch Group === ", "background: black; color: white;", newVal, oldVal);
    // });

    $scope.test = "test working"
    $scope.name = "Daniels"
    $scope.subscribe = function (message) {
        alert("Inside controller method: " + message);
    }
    $scope.carmodel = "Bently"
    $scope.wheelshape = "round"
    $scope.popup = function (message) {
        alert("Inside Directive popup: " + message);
    }

    var obj = {
        a: 20,
        b: 30,
        c: 40
    };

    var d = 30;

    $scope.a = 2;
    $scope.b = 5;
    $scope.c = 10;

    // EVAL
    // //console.log(" %c ----------- EVAL OUTPUTS ---------- ", "background: orange; color: white");
    // //console.log($scope.$eval("carmodel + wheelshape"));
    // //console.log($scope.$eval("a * b"));
    // //console.log($scope.$eval("a * b + d")); // gives same as above because d is not a scope variable
    // //console.log($scope.$eval("a * b + d", {
    //     d: 30
    // }));
    // //console.log($scope.$eval("a * b + d", {
    //     a: 1,
    //     d: 30
    // })); // a gets overriden
    // //console.log($scope.$eval(function (scope, locals) {
    //     scope.carmodel = "Aston Martin" // replace ot changing the scope value inside eval
    //     scope.a = locals.a;
    //     return (scope.a * scope.b * scope.c + locals.d);
    // }, { d: 40, a: 50 }));

    // // PARSE
    // //console.log(" %c ----------- PARSE OUTPUTS ----------", "background: red; color: white");
    // var f = $parse("a * b");
    // //console.log(f)
    // //console.log(f($scope));
    // //console.log(f(obj, { // passing locals and using on object other that $scope.
    //     a: 200,
    //     b: 300
    // }));
    var f = $parse("a * b + d");
    // //console.log(f($scope));
    // //console.log(f(obj));

    var f = $parse(function (scope, locals) {
        scope.carmodel = "Aston Martin" // replace ot changing the scope value inside eval
        scope.a = locals.a;
        return (scope.a * scope.b * scope.c + locals.d);
    });
    // //console.log(f($scope, { d: 40, a: 50 }));
    // //console.log(f(obj, { d: 40, a: 50 }));

    // INTERPOLATE
    // //console.log(" %c ----------- INTERPOLATE OUTPUTS ----------", "background: yellow; color: white");
    var i = $interpolate("This is the result of calculation: {{a * b}}");
    // //console.log(i);
    // //console.log(" %c ", "border-bottom: 1px solid;", i($scope));
    // //console.log(" %c ", "border-bottom: 1px solid;", i(obj));
    // //console.log(" %c ", "border-bottom: 1px solid;", i($scope, {
    //     a: 500,
    //     c: 900,
    //     b: 300
    // })); // locals not used here . Things always picked from scope.

    // $scope.$apply(function() {
    // });
    window.scopeO = $scope;
    $scope.changeThisElement = 1900;
    console.log("PHASE ",$scope.$$phase);
    // this here executes the digest cycle.
    $timeout(function() {
        $scope.$apply(function() {
            $rootScope.df = 900;
            $scope.changeThisElement = 2200;
            console.log("Timeout Phase",$scope.$$phase);
        });
    }, 2000);
    $timeout(function() {
        $rootScope.df = 900;
        $scope.changeThisElement = 2200;
        console.log("Timeout Phase",$scope.$$phase);
    }, 2000);
    // while this will change the $scope object property value only and not execute the digest cycle.
    setTimeout(function() {
        $scope.changeThisElement = 2500;
    },0);

}]);

setTimeout(function() {
    window.scopeO.changeThisElement = 3500;
},2000);

app.controller("setControllerOne", ["$scope", "$rootScope", function ($scope, $rootScope) {
    console.log("PHASE ",$scope.$$phase);

    $scope.name = "Controller One Set";
    $scope.age = 300;
    this.alert = function () {
        alert("Got Inside Controller One");
    }
    this.name = "Kushagra Inside Controller One";


    $scope.$broadcast("EventDOWN", "DOWN data sending parent one ....");
    $scope.$on("EventUP", function (e, data) {
        //console.log("Event UP Logged Parent Controller One", data);
    });
    $scope.$on("EventDOWN", function (e, data) {
        //console.log("Event DOWN Logged Parent Controller One", data);
    })


}]);
app.controller("innerControllerOne", ["$scope", "$rootScope", function ($scope, $rootScope) {

    $scope.$on("EventUP", function (e, data) {
        //console.log("Event UP Logged Inner Controller One", data);
    });
    $scope.$on("EventDOWN", function (e, data) {
        //console.log("Event DOWN Logged Inner Controller One", data);
    })
    $scope.$broadcast("EventDOWN", "DOWN data sending inner one ....");
    $scope.$emit("EventUP", "UP data sending inner one ....");


}]);
app.controller("innerControllerTwo", ["$scope", "$rootScope", function ($scope, $rootScope) {

    $scope.$on("EventUP", function (e, data) {
        //console.log("Event UP Logged Inner Controller Two", data);
    });
    $scope.$on("EventDOWN", function (e, data) {
        //console.log("Event DOWN Logged Inner Controller Two", data);
    })
    $scope.$broadcast("EventDOWN", "DOWN data sending inner two ....");
    $scope.$emit("EventUP", "UP data sending inner two ....");

}]);
app.controller("innerControllerTwoSibbling", ["$scope", "$rootScope", function ($scope, $rootScope) {

    $scope.$broadcast("EventDOWN", "DOWN data sending two sibling ....");
    $scope.$emit("EventUP", "UP data sending two sibling ....");
    $scope.$on("EventUP", function (e, data) {
        //console.log("Event UP Logged Inner Controller Two Sibling", data);
    });
    $scope.$on("EventDOWN", function (e, data) {
        //console.log("Event DOWN Logged Inner Controller Two Sibling", data);
    })

}]);
app.controller("innerControllerThree", ["$scope", "$rootScope", function ($scope, $rootScope) {

    $scope.name = "kushagra mishra";
    $scope.age = 30;
    $scope.persons = [
        { name: 'John', phone: '512-455-1276', age: 20, pivot: 2 },
        { name: 'John', phone: '512-455-1276', age: 90, pivot: 1 },           
        { name: 'Mary', phone: '899-333-3345', age: 10, pivot: 10 },
        { name: 'Mike', phone: '511-444-4321', age: 0, pivot: 1 },
        { name: 'Bill', phone: '145-788-5678', age: 50, pivot: 8 },
        { name: 'Ram', phone: '433-444-8765', age: 60, pivot: 4 },
        { name: 'Steve', phone: '218-345-5678', age: 7, pivot: 8, 'age-pivot': 44 }
    ]
    // the iteration count increases based on what is returned.
    $scope.customComparator = function(v1, v2) {
        console.log("CUSTOM COMPARATOR", v1, v2);
        // if(v2.value == 10) { return 1; }
        // return -1;
        if(v2.value === v1.value) {
            return 0;
        } else if(v1.value > v2.value) {
            return 1;
        } else if(v1.value < v2.value) {
            return -1;
        }
    }

     $scope.customFilterFilter = function(...args) {
        console.log("CUSTOM COMPARATOR FILTER FILTER", args);
        return 1;
    }

    // $scope.SortOrder = '+name'; // ascending
    // $scope.SortOrder = '-name'; // descending
    $scope.SortOrder = '+(age-pivot)'; // calculates age - pivot
    // $scope.SortOrder = '-(age-pivot)';
    $scope.SortOrder = 'age';

    $scope.$on("EventUP", function (e, data) {
        //console.log("Event UP Logged Inner Controller Three", data);
    });
    $scope.$on("EventDOWN", function (e, data) {
        //console.log("Event DOWN Logged Inner Controller Three", data);
    })
    $scope.$broadcast("EventDOWN", "DOWN data sending inner three ....");
    $scope.$emit("EventUP", "UP data sending inner three ....");

}]);
// app.service("testService",["$scope", "$rootScope", function($scope, $rootScope) {}]); This is not correct because services don't have scopes they are a means to share data and methods. Scope or rootscope is and instance generated from $new() of rootScope and passed only to directives and controllers. In case of services or factories we need to use providers as injectibles. Hence injecting above in controller will throw error because that service is trying to inject $scope which doesnot have any providers.
app.service("testService", [function () { this.a1 = 200; this.a2 = 200; }]);
app.factory("testServiceFactory", [function () { }]);
app.controller("setControllerTwo", ["$scope", "$rootScope", "testService", function ($scope, $rootScope, testService) {
    $scope.name = "Controller Two Set";
    $scope.age = 300;
    this.alert = function () {
        alert("Got Inside Controller Two");
    }
    this.name = "Kushagra Inside Controller two";
}]);

app.directive("scopetest", function () {
    return {
        restrict: "E",
        transclude: true,
        transclude: 'element',
        replace: true,
        link: function (scope, element, attrs, controllers) {
            scope.arrNames = ['shailendra', 'deepak', 'mohit', 'kapil'];
            scope.objs = {
                departs: ["Eng", 'Math', "Applied", "Theoretical"],
                deMap: { eng: ['IT', 'CS', 'MECH', "BIO"], applied: ['PHY', 'CHEM', 'ECO'], theoretical: ['PHY', 'CHEM'] },
                teachers: { eng: 14, math: 5, applied: 10, theoretical: 20 }
            }
            console.log("DIRECTIVE PHASE ", scope.$$phase);
            // WATCH ARRAYS    
            scope.$watch('arrNames', function (newVal, oldVal) {
                //console.log(" %c Watch TRUE === ", "background: black; color: white;", newVal, oldVal);
            }, true);

            scope.$watch('arrNames', function (newVal, oldVal) {
                //console.log(" %c Watch FALSE === ", "background: black; color: white;", newVal, oldVal);
            }, false);

            scope.$watchCollection('arrNames', function (newVal, oldVal) {
                //console.log(" %c Watch Collection === ", "background: black; color: white;", newVal, oldVal);
            });

            scope.$watchGroup(['arrNames'], function (newVal, oldVal) {
                //console.log(" %c Watch Group === ", "background: black; color: white;", newVal, oldVal);
            }, true);

            // WATCH OBJECTS
            scope.$watch('objs', function (newVal, oldVal) {
                //console.log(" %c Watch TRUE === ", "background: black; color: white;", newVal, oldVal);
            }, true);

            scope.$watch('objs', function (newVal, oldVal) {
                //console.log(" %c Watch FALSE === ", "background: black; color: white;", newVal, oldVal);
            }, false);

            scope.$watchCollection('objs', function (newVal, oldVal) {
                //console.log(" %c Watch Collection === ", "background: black; color: white;", newVal, oldVal);
            });

            scope.$watchGroup(['objs'], function (newVal, oldVal) {
                //console.log(" %c Watch Group === ", "background: black; color: white;", newVal, oldVal);
            });
            // //console.log("Directive location: ", attrs.name);
            if (attrs.name == "inner") {
                window.directiveScope = scope
            } else {
                // //console.log("Inner scope: ", window.directiveScope);
                // //console.log(window.directiveScope == scope);
            }
            scope.subscribe = function (message) {
                alert("Inside Directive method: " + message);
            }
            // scope.name = "Kushagra"  // mandatory for {} isolated scope.
            scope.manufacturer = "Ferrari"
            scope.age = 200;
            scope.popup = function (message) {
                alert("Inside Directive popup: " + message);
            }
        },
        scope: {
            carmodel: '=',
            wheelshape: '@',
            subscribe: '&',
        },

        // scope: true, // even if this is in isolated scope because directive itself does not set any value (can be seen in the outer directive element) it takes the value from the parent.
        // if we modify the controller scoped element first then all the elements using that same model will be updated including directives (isolated also) but if we change the directive value and then change the controller value the changes won't be now reflected in directives. This is because angular creates a separate variable only when there is an actual need for it untill then it only refers to parent. So in case of isolated scope all the properties are kept as reference to parent properties untill there is some another value for those properties that are directive specific.

        // scope: {}, // isolated scope. Detaches the directive from controller scope. So now directive scope is having different value that controller scope. Changes to any scope variable will only be inside directives and not affect controller.
        // scope: {
        //     name: '@'
        // },
        template: "" +
            "<div>" +
            "<div class='row'>" +
            "<div class='col'>From Directive Scope</div>" +
            "<div class='col'><input type='text' name='textinput' value='{{name}}' ng-model='name' /></div>" +
            "</div>" +
            "<br />" +
            "<div class='row'>" +
            "<div class='col'>Car Model: </div>" +
            "<div class='col'><input type='text' name='carInput' value='{{carmodel}}' ng-model='carmodel' />" +
            "</div>" +
            "<br />" +
            "<div class='row'>" +
            "<div class='col'>Wheel Shape: </div>" +
            "<div class='col'><input type='text' name='carInput' value='{{wheelshape}}' ng-model='wheelshape' />" +
            "</div>" +
            "<br />" +
            "<div class='row'>" +
            "<div class='col'>Click to show info: </div>" +
            "<div class='col'><input type='button' name='showInfo' value='View Info' ng-click='subscribe(carmodel)' />" +
            "</div>" +
            "<div ng-transclude></div>" +
            "</div>",
    };
});
app.directive("controllerTestParent", function () {
    return {
        restrict: "EACM",
        // transclude: 'element',
        transclude: true,
        // replace: true,
        // replace: false,
        // scope: {},
        // require: ["^?setControllerTwo", "^?setControllerOne"],// require can be done only on directives
        controller: 'setControllerTwo',
        controllerAs: 'pController',
        compile: function (element, attributes) {
            // //console.log("Compile of parent");
            angular.element(element).append("<div>Me no man here.</div>");
            // //console.log(element.html());
            return {
                post: function (scope, element, attributes, controller, transcludeFn) {
                    console.log("DIRECTIVE PHASE 3 POST", scope.$$phase);

                    // //console.log("Post Compile Function Executed for Parent");
                    // //console.log(element.html());
                },
                pre: function (scope, element, attributes, controller, transcludeFn) {
                    console.log("DIRECTIVE PHASE 3 PRE", scope.$$phase);
                    // //console.log("Pre Compile Function Executed for Parent");
                    // //console.log(element.html());
                }
            }
        },
        // link: {
        //     post: function(scope, element, attrs, ctrl) {
        //         //console.log("Post Link Function Executed for Parent");
        //         // //console.log(element, ctrl);
        //     },
        //     pre: function(scope, element, attrs, ctrl) {
        //         //console.log("Pre Link Function Executed for Parent");
        //         // //console.log(element, ctrl);                
        //     }
        // },
        template: "<div><span>This is a div</span><span ng-transclude></span><child-ele>Transclude child content.</child-ele>{{pController.name}}</div>"
    };
});

app.directive("childEle", function () {
    return {
        restrict: "EACM",
        transclude: true,
        replace: true,
        // scope: {},
        require: "^controllerTestParent",
        // controller: function($scope) {
        //     //console.log("Child Controller");
        //     $scope.name = "Inner controller Parent set"
        // },
        // compile: function(element, attributes) {
        //     //console.log("Child Compiled");
        //     return {
        //         post: function(scope, element, attributes, controller, transcludeFn) {
        //             //console.log("Post Compile Function Executed for Child");
        //             //console.log(controller.name);
        //         },
        //         pre: function(scope, element, attributes, controller, transcludeFn) {
        //             //console.log("Pre Compile Function Executed for Child");
        //             //console.log(controller.name);
        //         }
        //     }
        // },
        // link: {
        //     post: function(scope, element, attrs, ctrl) {
        //         //console.log("Post Link Function Executed for Child");
        //         //console.log(element.html());
        //     },
        //     pre: function(scope, element, attrs, ctrl) {
        //         //console.log("Pre Link Function Executed for Child");
        //         //console.log(element.html());

        //     }
        // },
        // controllerAs: "vm",
        // bindToController: true,
        link: function (scope, element, attrs, ctrl) {
            console.log("DIRECTIVE PHASE 2", scope.$$phase);            
            // //console.log("Link Function Executed for Child");
            // //console.log(scope.name, ctrl.name, ctrl);
        },
        template: "<div><span>This is a child element div</span><span ng-transclude></span></div>"
    };
});

/**
 * $injector is responsible for getting the instances of services defined by providers, instantiate types, invoke methods. and loading modules
 */


// function explicit() {}

// console.log("Injector: ", $injector);
// console.log($injector.get('testService')); // calls the $get method of the given service provider in this case scopeProvider.But because services and factories are internally providers so it should ideally be able to find them but because we have taken injector instance before attaching the service or factory we get error. Also Even after if we take injector after the attachment of services or factory things won't work if we don't 
// angular.injector(['my-app']) or injector.loadNewModules(['my-app']);
function explicit(serviceA) { };
explicit.$inject = ['serviceA'];
// $injector.invoke(explicit); // here also invoke treats serviceA as a service provider. But because services and factories are internally providers so it should ideally be able to find them but because we have taken injector instance before attaching the service or factory we get error. Also Even after if we take injector after the attachment of services or factory things won't work if we don't 
// angular.injector(['my-app']) or injector.loadNewModules(['my-app']);
// $injector.invoke(['serviceA', function(serviceA){}]);
// console.log($injector.has('testService')); // false because there is no testServiceProvider because services and factories are internally providers so it should ideally be able to find them but because we have taken injector instance before attaching the service or factory we get false. Also Even after if we take injector after the attachment of services or factory things won't work if we don't 
// angular.injector(['my-app']) or injector.loadNewModules(['my-app']);
// console.log($injector.invoke(function () { console.log("Inside invoked method"); }));
// console.log($injector.invoke(mainController));
// console.log($injector.invoke(testService));

// var tmpFn = function(obfuscatedCompile, obfuscatedRootScope) {
//     // ...
//   };
// tmpFn.$inject = ['$compile', '$rootScope'];
// $injector.invoke(tmpFn);
function x() { console.log("From inside instantiate"); }
// x.$inject = ['serviceA'];
// console.log($injector.instantiate(x)); //returns the new object of the method passed while trying to inject dependencies given $inject of method or taken as argument in function.
// Annotate Returns an array of service names which the function is requesting for injection. This API is used by the injector to determine which services need to be injected into the function when the function is invoked. There are three ways in which the function can be annotated with the needed dependencies.
/** 
 * Argument names
The simplest form is to extract the dependencies from the arguments of the function. This is done by converting the function into a string using toString() method and extracting the argument names.

// Given
function MyController($scope, $route) {
  // ...
}

// Then
expect(injector.annotate(MyController)).toEqual(['$scope', '$route']);

The $inject property
If a function has an $inject property and its value is an array of strings, then the strings represent names of services to be injected into the function.

// Given
var MyController = function(obfuscatedScope, obfuscatedRoute) {
  // ...
}
// Define function dependencies
MyController['$inject'] = ['$scope', '$route'];

// Then
expect(injector.annotate(MyController)).toEqual(['$scope', '$route']);

The array notation
It is often desirable to inline Injected functions and that's when setting the $inject property is very inconvenient. In these situations using the array notation to specify the dependencies in a way that survives minification is a better choice:

// We wish to write this (not minification / obfuscation safe)
injector.invoke(function($compile, $rootScope) {
  // ...
});

// We are forced to write break inlining
var tmpFn = function(obfuscatedCompile, obfuscatedRootScope) {
  // ...
};
tmpFn.$inject = ['$compile', '$rootScope'];
injector.invoke(tmpFn);

// To better support inline function the inline annotation is supported
injector.invoke(['$compile', '$rootScope', function(obfCompile, obfRootScope) {
  // ...
}]);

// Therefore
expect(injector.annotate(
   ['$compile', '$rootScope', function(obfus_$compile, obfus_$rootScope) {}])
 ).toEqual(['$compile', '$rootScope']);
*/
var payload = ["$scope", "$rootScope", "testService", function ($scope, $rootScope, testService) { }];
// console.log($injector.annotate(payload));
// console.log($injector.invoke(payload));

//You can use $injector.modules to check whether a module has been loaded into the injector, which may indicate whether the script has been executed already.
/**
 * modules
A hash containing all the modules that have been loaded into the $injector.

You can use this property to find out information about a module via the myModule.info(...) method.

For example:

var info = $injector.modules['ngAnimate'].info();
 */

// console.log("Injector for factory ", $injector.get("testServiceFactory"));
// console.log("Injector Modules => ", $injector.modules);
// console.log("Injector My Modules => ", $injectorModule.modules);
// $injectorModule.get(testServiceFactory);
// for (mod in $injector.modules) {
//     var moduleLocalCopy = $injector.modules[mod];
//     console.log(moduleLocalCopy.info(Object({})));
// }

/**
 * Using Dependency Injection
Dependency Injection is pervasive throughout AngularJS. You can use it when defining components or when providing run and config blocks for a module.

Services, directives, filters, and animations are defined by an injectable factory method or constructor function, and can be injected with "services", "values", and "constants" as dependencies.

Controllers are defined by a constructor function, which can be injected with any of the "service" and "value" as dependencies, but they can also be provided with "special dependencies". See Controllers below for a list of these special dependencies.

The run method accepts a function, which can be injected with "services", "values" and, "constants" as dependencies. Note that you cannot inject "providers" into run blocks.

The config method accepts a function, which can be injected with "providers" and "constants" as dependencies. Note that you cannot inject "services" or "values" into configuration.

The provider method can only be injected with other "providers". However, only those that have been registered beforehand can be injected. This is different from services, where the order of registration does not matter.

AngularJS invokes certain functions (like service factories and controllers) via the injector.

Inline array Notation and $inject for DI are safe to use with minification also.
someModule.controller('MyController', ['$scope', 'greeter', function($scope, greeter) {
  // ...
}]);

Implicit annotation is not minification safe
someModule.controller('MyController', function($scope, greeter) {
  // ...
});

Tools like ng-annotate let you use implicit dependency annotations in your app and automatically add inline array annotations prior to minifying. If you decide to take this approach, you probably want to use ng-strict-di.
You can add an ng-strict-di directive on the same element as ng-app to opt into strict DI mode:

<!doctype html>
<html ng-app="myApp" ng-strict-di>
<body>
  I can add: {{ 1 + 2 }}.
  <script src="angular.js"></script>
</body>
</html>
 */

/**
 * DI in angular js works in three ways
 * 1). Iniline Array ['$rootScope', '$scope', function($rootScope, $scope) {}]
 * 2). $inject property
 * 3). implicit function($rootScope, $scope) {}. This is not minification safe.
 * Because implicit way is not minification safe we may use ng-strict-di in html on the same tag as ng-app. This will stop the use of implicit injections as below and will throw errors.
 */

// app.run(function ($rootScope) {
//     var $scope = $rootScope;
// $scope.$watch('enabled', function(val) {
//     //console.log('You are now: ' + (val ? 'enabled' : 'disabled'));
// });
// $scope.enabled = true;
// $scope.enabled = false;
// $scope.enabled = 1;
// });

// or while running app manually using bootstrap also we can 
//angular.bootstrap(document, ['myApp'], {
//     strictDi: true
// });

/**
 * To prevent minifier mess up your implicit injection code we may use ng-annotate
 * Write your code without annotations and mark-up functions to be annotated with the "ngInject" directive prologue, just like you would "use strict". This must be at the beginning of your function.

$ cat source.js
angular.module("MyMod").controller("MyCtrl", function($scope, $timeout) {
    "ngInject";
    ...
});
Then run ng-annotate as a build-step to produce this intermediary, annotated, result (later sent to the minifier of choice):

$ ng-annotate -a source.js
angular.module("MyMod").controller("MyCtrl", ["$scope", "$timeout", function($scope, $timeout) {
    "ngInject";
    ...
}]);
 */

/**
 * Methods
get(name, [caller]);

Return an instance of the service.

Parameters
Param	Type	Details
name	string	
The name of the instance to retrieve.

caller
(optional)
string	
An optional string to provide the origin of the function call for error messages.

Returns
*	
The instance.

invoke(fn, [self], [locals]);

Invoke the method and supply the method arguments from the $injector.

Parameters
Param	Type	Details
fn	function()Array.<(string|function())>	
The injectable function to invoke. Function parameters are injected according to the $inject Annotation rules.

self
(optional)
Object	
The this for the invoked method.

locals
(optional)
Object	
Optional object. If preset then any argument names are read from this object first, before the $injector is consulted.

Returns
*	
the value returned by the invoked fn function.

has(name);

Allows the user to query if the particular service exists.

Parameters
Param	Type	Details
name	string	
Name of the service to query.

Returns
boolean	
true if injector has given service.

instantiate(Type, [locals]);

Create a new instance of JS type. The method takes a constructor function, invokes the new operator, and supplies all of the arguments to the constructor function as specified by the constructor annotation.

Parameters
Param	Type	Details
Type	Function	
Annotated constructor function.

locals
(optional)
Object	
Optional object. If preset then any argument names are read from this object first, before the $injector is consulted.

Returns
Object	
new instance of Type.

annotate(fn, [strictDi]);

Returns an array of service names which the function is requesting for injection. This API is used by the injector to determine which services need to be injected into the function when the function is invoked. There are three ways in which the function can be annotated with the needed dependencies.

Argument names
The simplest form is to extract the dependencies from the arguments of the function. This is done by converting the function into a string using toString() method and extracting the argument names.

// Given
function MyController($scope, $route) {
 // ...
}

// Then
expect(injector.annotate(MyController)).toEqual(['$scope', '$route']);
You can disallow this method by using strict injection mode.

This method does not work with code minification / obfuscation. For this reason the following annotation strategies are supported.

The $inject property
If a function has an $inject property and its value is an array of strings, then the strings represent names of services to be injected into the function.

// Given
var MyController = function(obfuscatedScope, obfuscatedRoute) {
 // ...
}
// Define function dependencies
MyController['$inject'] = ['$scope', '$route'];

// Then
expect(injector.annotate(MyController)).toEqual(['$scope', '$route']);
The array notation
It is often desirable to inline Injected functions and that's when setting the $inject property is very inconvenient. In these situations using the array notation to specify the dependencies in a way that survives minification is a better choice:

// We wish to write this (not minification / obfuscation safe)
injector.invoke(function($compile, $rootScope) {
 // ...
});

// We are forced to write break inlining
var tmpFn = function(obfuscatedCompile, obfuscatedRootScope) {
 // ...
};
tmpFn.$inject = ['$compile', '$rootScope'];
injector.invoke(tmpFn);

// To better support inline function the inline annotation is supported
injector.invoke(['$compile', '$rootScope', function(obfCompile, obfRootScope) {
 // ...
}]);

// Therefore
expect(injector.annotate(
  ['$compile', '$rootScope', function(obfus_$compile, obfus_$rootScope) {}])
).toEqual(['$compile', '$rootScope']);
Parameters
Param	Type	Details
fn	function()Array.<(string|function())>	
Function for which dependent service names need to be retrieved as described above.

strictDi
(optional)
boolean	
Disallow argument name annotation inference.

(default: false)

Returns
Array.<string>	
The names of the services which the function requires.

loadNewModules([mods]);

This is a dangerous API, which you use at your own risk!

Add the specified modules to the current injector.

This method will add each of the injectables to the injector and execute all of the config and run blocks for each module passed to the method.

If a module has already been loaded into the injector then it will not be loaded again.

The application developer is responsible for loading the code containing the modules; and for ensuring that lazy scripts are not downloaded and executed more often that desired.
Previously compiled HTML will not be affected by newly loaded directives, filters and components.
Modules cannot be unloaded.
You can use $injector.modules to check whether a module has been loaded into the injector, which may indicate whether the script has been executed already.

Parameters
Param	Type	Details
mods
(optional)
Array<String|Function|Array>=	
an array of modules to load into the application. Each item in the array should be the name of a predefined module or a (DI annotated) function that will be invoked by the injector as a config block. See: modules

Example
Here is an example of loading a bundle of modules, with a utility method called getScript:

app.factory('loadModule', function($injector) {
 return function loadModule(moduleName, bundleUrl) {
   return getScript(bundleUrl).then(function() { $injector.loadNewModules([moduleName]); });
 };
})
Properties
modules
A hash containing all the modules that have been loaded into the $injector.

You can use this property to find out information about a module via the myModule.info(...) method.

For example:

var info = $injector.modules['ngAnimate'].info();
 */

var myModule = angular.module('myModule', []);
myModule.factory('greeter', function ($window) {
    return {
        greet: function (text) {
            $window.alert(text);
        }
    };
});
myModule.service('greeterService', function ($window) {
    this.greet = function (text) {
        $window.alert(text);
    };
});
// var injector = angular.injector(['ng', 'myModule']);
// console.log("Dummy Injector After factory => ", injector);
// we didnot get the required result above as expected because the injectors were taken before factories or service were attached to the module. 
// invoke and instantiate work only on functions or array functions . They don't instantiate or invoke any service that is already registered
// var gf = injector.get('greeter');
// var gs = injector.get('greeterService');
// var greeterServiceInstance = injector.instantiate(['greeterService', function (greeterService) { console.log("inside greeter instantiate") }]);
// var greeterServiceInvoke = injector.invoke(['greeterService', function ($scope, greeterService) { console.log("inside greeter invoke") }]);
// console.log(greeterServiceInstance);
// console.log(greeterServiceInvoke);

// If module was loaded previously it won't be loaded again.
// $injector.loadNewModules(['my-app']);
// $injector.get('testService');

// Even after if we take injector after the attachment of services or factory things won't work if we don't 
// angular.injector(['my-app']) or injector.loadNewModules(['my-app']);
app.factory("dummyService", function() {return {}});
var injectorAfterAttaching = angular.injector();
injectorAfterAttaching.loadNewModules(['ng','my-app']);
injectorAfterAttaching.get('dummyService');
// console.log("Provider from injector ", injectorAfterAttaching.get("$provide"));

/**
 * Asking for dependencies solves the issue of hard coding, but it also means that the injector needs to be passed throughout the application. Passing the injector breaks the Law of Demeter. To remedy this, we use a declarative notation in our HTML templates, to hand the responsibility of creating components over to the injector, as in this example:

<div ng-controller="MyController">
  <button ng-click="sayHello()">Hello</button>
</div>
function MyController($scope, greeter) {
  $scope.sayHello = function() {
    greeter.greet('Hello World');
  };
}
When AngularJS compiles the HTML, it processes the ng-controller directive, which in turn asks the injector to create an instance of the controller and its dependencies.

injector.instantiate(MyController);
 */
// Function that returns its fist argument.
console.log(angular.identity("Kushagra", "Mishra"));

// $compile is used to compile or parse an element which in turn returns a compilation function . This compilation function can then be used with any object to render the values in it.
// angular.element returns a jQLite instance which will not be able to find elements using element name class or other css selector we may need to use 
//angular.element(document).find(...)

//$destroy() must be called on a scope when it is desired for the scope and its child scopes to be permanently detached from the parent and thus stop participating in model change detection and listener notification by invoking.

/**
 * Life cycle: Pseudo-Code of $apply()

function $apply(expr) {
  try {
    return $eval(expr);
  } catch (e) {
    $exceptionHandler(e);
  } finally {
    $root.$digest();
  }
}

$evalAsync([expression], [locals]);

Executes the expression on the current scope at a later point in time.

The $evalAsync makes no guarantees as to when the expression will be executed, only that:

it will execute after the function that scheduled the evaluation (preferably before DOM rendering).
at least one $digest cycle will be performed after expression execution.
Any exceptions from the execution of the expression are forwarded to the $exceptionHandler service.

Note: if this function is called outside of a $digest cycle, a new $digest cycle will be scheduled. However, it is encouraged to always call code that changes the model from within an $apply call. That includes code evaluated via $evalAsync.

$applyAsync([exp]);

Schedule the invocation of $apply to occur at a later time. The actual time difference varies across browsers, but is typically around ~10 milliseconds.

This can be used to queue up multiple expressions which need to be evaluated in the same digest.
 */
$root = injectorAfterAttaching.get('$rootScope');
$root.er = 400
console.log($root);
setTimeout(function() {
    var ele = angular.element(document).find('html');
    console.log(ele.scope().$root);
    console.log(ele.injector().get('$rootScope'));
    console.log(injectorAfterAttaching.get('$rootScope')); // returns same instance of rootscope as $root
}, 0);
app.directive("digestElementDirective", function() {
    return {
        restrict: "E",
        controller: ["$scope", "$rootScope", function($scope, $rootScope) {
            console.log("Directive controller scope phase ", $scope.$$phase);
        }],
        compile: function(element, attributes) {
            return {
                pre(scope, ele, attrs, controller, trans) {
                    console.log("PRE Linking PHASE", scope.$$phase);
                },
                post(scope, ele, attrs, controller, trans) {
                    console.log("POST Linking PHASE", scope.$$phase);
                }
            }
        },
        // link: function(scope, ele, attrs, controller, trans) {
        //     console.log("Link Method Linking PHASE", scope.$$phase);
        // }
    };

});
app.directive("digestElementMultiDir", function() {
    return {
        restrict: "E",
        controller: ["$scope", "$rootScope", function($scope, $rootScope) {
            console.log("Directive controller scope phase MULTI DIR", $scope.$$phase);
        }],
        compile: function(element, attributes) {
            return {
                pre(scope, ele, attrs, controller, trans) {
                    console.log("PRE Linking PHASE MULTI DIR", scope.$$phase);
                },
                post(scope, ele, attrs, controller, trans) {
                    console.log("POST Linking PHASE MULTI DIR", scope.$$phase);
                }
            }
        },
        // link: function(scope, ele, attrs, controller, trans) {
        //     console.log("Link Method Linking PHASE", scope.$$phase);
        // }
    };

});

app.filter('getCapital', function() {
    console.log("Inside get capital");
    return function(item, controllerScope, filterScope) {
        console.log("GET CAPITAL ITEM", item, controllerScope, filterScope); // item is the property on which we apply the filter
        // filterscope or this (from UI) gives the parent controller scope if inside controller otherwise it gives rootscope.
        filterScope.name = "Daniel"; // 
        filterScope.gender = "Male";
        return item.toUpperCase();
    }
});

app.filter('getAge', function() {
    console.log("Inside get age");
    return function(item, filterScope) {
        console.log("GET AGE ITEM", item, filterScope); // item is the property on which we apply the filter
        // filterscope gives the parent controller scope.
        return item;
    }
});
app.filter("customFilter", function() {
    return function(...args) {
        console.log('CUSTOM FILTER ', args);
    }
});
// this can also be done using $provide.decorator but then that will have to be used inside a place where $provide can be injected.
app.decorator("myService", ["$delegate", function($delegate) {
    console.log("Inside decorator ", $delegate);
}]);
app.decorator("testService", ["$delegate", function($delegate) {
    console.log("Inside decorator ", $delegate);
    return null;
}]);

