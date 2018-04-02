var app = angular.module("myapp", ['ngAnimate', 'ngRoute']);

app.config(["$animateProvider", "$provide", "$routeProvider", function($animateProvider, $provide, $routeProvider) {
    console.log("PROVIDE: ", $provide); // does not have animation related things because aimate needs to be injected as a separate module and when injected then only it will be available .
    // $animateProvider.classNameFilter(/animate/); // this will block the animation and allow animation on classes with animate class only. But without below customFilter code. This will block both javascript and css animations. add class and remove class both.
    // $animateProvider.customFilter(function(node, event, options) {
    //     console.log("Custom Filter Animation Blocker", node, event, options);
    //     return event === 'enter' || event === 'leave'
    // });
    $routeProvider.when("/", {
            templateUrl: 'viewAnchorHome.html'
        }).when("/profile/:id", {
            templateUrl: 'viewAnimateProfile.html',
            controller: "profileController"
        });
}]);

app.run(function($rootScope, $animate) {
    $rootScope.records = [
      { id: 1, title: 'Miss Beulah Roob' },
      { id: 2, title: 'Trent Morissette' },
      { id: 3, title: 'Miss Ava Pouros' },
      { id: 4, title: 'Rod Pouros' },
      { id: 5, title: 'Abdul Rice' },
      { id: 6, title: 'Laurie Rutherford Sr.' },
      { id: 7, title: 'Nakia McLaughlin' },
      { id: 8, title: 'Jordon Blanda DVM' },
      { id: 9, title: 'Rhoda Hand' },
      { id: 10, title: 'Alexandrea Sauer' }
    ];
    $rootScope.candidates = [ "Candidate 1", "Candidate 2" ];
    var element = angular.element('.animate').get(0).cloneNode(true);
    var parent = $rootScope.parent = angular.element('.animate-manual').get(0);
    var after = angular.element("button[removecandidates='']");
    
    console.log("ELEMENT", element);
    $animate.enter(element, parent, false, {
        from: {
            'font-size': '50px'
        },
        to: {
            'font-size': '8px'
        },
        addClass: "ng-repeat-addition-from-animate"
    });
    // binds a event listener on the given element for animate events
    $animate.on("enter", angular.element('html'), function(...args) {
        console.log("ARGUMENTS => ", args);
    });
    // $animate.off("enter");
    $animate.enabled(true) // By default angular animations don't work when application bootstraps and page loads. This setting enables that behaviour.
});

app.controller("profileController", ["$scope", "$rootScope", '$routeParams', function($scope, $rootScope, $routeParams) {
    var index = parseInt($routeParams.id);
    $scope.id = index
    $scope.record = $rootScope.records[index].title
}]);

app.controller("candidateController", ["$scope", "$rootScope", function($scope, $rootScope) {
    $scope.candidates = $rootScope.candidates;
    $scope.candidateCount = 2;
    $scope.newposition = 0;
    $scope.animateControls = 0;
}]);
app.directive("addcandidates", ["$animate", "$rootScope", function($animate, $rootScope) {
    return {
        restrict: "A",
        link(scope, element, attrs, transclusionFn){
            console.log(element);
            angular.element(element).on('click', function() {
                scope.$apply(function() {
                    if(scope.animateControls) {
                        var ele = angular.element('.animate-manual').find('.animate').get(0);
                        $animate.enter(ele, $rootScope.parent, false, {
                            from: {
                                'font-size': '50px'
                            },
                            to: {
                                'font-size': '14px'
                            },
                            addClass: "ng-repeat-addition-from-animate"
                        });
                    } else {
                        candidate = ++scope.candidateCount
                        scope.candidates.push("Candidate "+candidate);
                        console.log(scope.candidates);
                    } 
                });
                
            })
        }
    };
}]);

app.directive("removecandidates", ["$animate", "$rootScope", function($animate, $rootScope) {
    return {
        restrict: "A",
        link(scope, element, attrs, transclusionFn){
            console.log(element);
            angular.element(element).on('click', function() {
                console.log("Remove Element");
                scope.$apply(function() {
                    if(scope.animateControls) {
                        var ele = angular.element('.animate-manual').find('.animate').get(0);
                        $animate.leave(ele, {
                            from: {
                                'font-size': "50px"
                            },
                            to: {
                                'font-size': "10px"
                            }
                        });
                    } else {
                        if(scope.candidateCount) {
                            --scope.candidateCount
                        }
                        scope.candidates.pop();
                        console.log("Candidates after removing => ", scope.candidates);
                    }
                });
            })
        }
    };
}]);

app.directive("reposition", [function() {
    return {
        restrict: "A",
        link(scope, element, attrs, transclusionFn){
            console.log(element);
            angular.element(element).on('click', function() {
                scope.$apply(function() {
                    index = attrs.index;
                    newposition = scope.newposition;
                    candidates = scope.candidates;
                    candidateCount = scope.candidateCount;
                    temp = candidates[index];
                    candidates[index] = candidates[newposition];
                    candidates[newposition] = temp;
                    scope.candidates = candidates;
                    console.log("Index => ", attrs.index);
                    console.log("New Position => ", scope.newposition);
                    console.log("Candidates => ",scope.candidates);
                    console.log("New Candidate Count => ", scope.candidateCount);
                });
                
            })
        }
    };
}]);

// this overrides the css animation
app.animation(".animate", [function() {
    return {
        enter(element, done) {
            /**
                init [div.animate.ng-binding.ng-scope.ng-animate, context: div.animate.ng-binding.ng-scope.ng-animate]
                1: ƒ (result)
                2: {domOperation: ƒ, $$prepared: true, addClass: null, removeClass: null, $$domOperationFired: true}
                length: 3
             */
            // console.log(args);
            element.css("font-size", '10px');
            element.animate({fontSize: '14px'}, done);
            // element.attr('ng-class', "newClass");
            return function(isCancelled) {
                if (isCancelled) {
                    // Abort the animation if cancelled
                    // (`element.stop()` is provided by jQuery)
                    element.stop();
                }
            };
        },
        leave(element, done) {
            element.css("opacity", '0');
            element.animate({opacity: '0', fontSize:'8px'}, done);
            // element.attr('ng-class', "");            
            return function(isCancelled) {
                if (isCancelled) {
                  // Abort the animation if cancelled
                  // (`element.stop()` is provided by jQuery)
                  element.stop();
                }
              };         
        },
        move(element, done) {
            element.css('color', 'green');
            return function(isCancelled) {
                if (isCancelled) {
                  // Abort the animation if cancelled
                  // (`element.stop()` is provided by jQuery)
                  element.stop();
                }
              };
        },
        addClass(...args) {
            console.log("adding class", args)
        },
        removeClass(...args) {
            console.log("removing class", args)
        }
    }
}]);

