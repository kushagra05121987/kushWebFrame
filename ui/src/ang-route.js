var app = angular.module('myapp', ['ngRoute']);
app.config(["$routeProvider", function($routeProvider) {
    $routeProvider.when("/", {
        templateUrl: "views/index.html",
        resolve: {"aps": "aptService", "dS": ["delService", function(delService) {
            delService.setRemoveFromIds([1,2,4,5,6]);
            var rids = delService.getRIds();
            rids.push(200);
            rids.push("end");            
            return rids;
        }], "promService": ["$timeout", function($timeout) {
            return new Promise(function(resolve, reject) {
                $timeout(function() {
                    resolve({"status": "completed"});
                }, 5000);
            });
        }]},
        // controller: function(aps, dS) {console.log(aps, dS)},
        controller: "homeController",
        resolveAs: "deps"
    })
    .when("/page1/", {
        templateUrl: "views/page1.html",
        controller: ["$scope", "$rootScope", function($scope, $rootScope) {
            $scope.var = "This is from page one controller"
        }],
        redirectTo: "/page2/"
    })
    .when("/PAGE2", {
        templateUrl: "views/page2.html",
        controller: ["$scope", "$rootScope", function($scope, $rootScope) {
            $scope.var = "This is from page two controller"
        }],
        resolveRedirectTo: function(aptService, delService, $timeout) {
            console.log(aptService, delService);
            return new Promise(function(resolve, reject) {
                $timeout(function() {
                    // resolve({"status": "completed"});
                    resolve("/page3");                    
                }, 500);
            });
        },
        caseInsensitiveMatch: true
    })
    .when("/page3/:name/:location*", {
        templateUrl: "views/page3.html",
        controller: ["$scope", "$rootScope", "$timeout", "$location", "$route", "$routeParams", function($scope, $rootScope, $timeout, $location, $route, $routeParams) {
            console.log("running ...", $route, $routeParams);
            $scope.var = "This is from page three controller"
            $scope.changeSearch = function() {
                $location.search("age", "20");
                $location.hash("fixedit");
            }
            $scope.changeRouteParams = function() {
                $route.updateParams({
                    name: "mishra",
                    age: 900,
                    sibling: false
                });
            }
            // resolve({"status": "completed"});
            $location.search("age", "2000");
            $location.hash("fixed");
            console.log("Location", $location);
            $scope.showNChangeHash = function() {
                console.log('Location Hash', $location.hash());
                $location.hash("changeLocationHash");
                console.log('Location Hash', $location.hash());
            }
            $scope.getAbsUrl = function() {
                console.log('Location ABSURL', $location.absUrl());
            }
            $scope.getUrl = function() {
                console.log('Location URL', $location.url());
                $location.url("somepath/someotherpath");
                console.log('Location URL', $location.url());
            }
            $scope.getPath = function() {
                console.log('Location PATH', $location.path());
                $location.path('somepath/withsomeptherpath');
                console.log('Location PATH', $location.path());
            }
            $scope.getMisc = function() {
                console.log('Location PORT', $location.port());        
                console.log('Location HOST', $location.host());    
                console.log('Location PROTOCOL', $location.protocol());
            }
            $scope.setSearch = function() {
                $location.search("newSearchP", "newSearchV");
            }
        }],
        resolve: {"aps": "aptService"},
        resolveAs: "deps",
        reloadOnSearch: false
    })
    .when('/404', {
        templateUrl: "views/404.html",
        controller: function($scope, $rootScope) {
            $scope.pageMessage = "Sorry Page cannot be found. 404";
        }
    })
    .otherwise({
        templateUrl: "views/404.html",
        controller: function($scope, $rootScope) {
            $scope.pageMessage = "Sorry Page cannot be found.";
        },
        // redirectTo: '/404'
        redirectTo: undefined 
        // redirectTo: function() {
        //     throw new Error("Unable to catch fire");
        // }       
    });
}]);

app.run(["$rootScope", "$route","$routeParams", "$location",  function($rootScope, $route, $routeParams, $location) {
    // all the next previous and current are $route.current at sometime
    $rootScope.$on("$routeChangeStart", function(event, next, current, ...args) {
        console.log(arguments);
        console.log("Route Change Start", event);
        console.log("Route Change Start", next);
        console.log("Route Change Start", current);
        console.log("Route Change Start", args);
        console.log("Route Change Start", $routeParams);  
        
    });
    $rootScope.$on("$routeChangeSuccess", function(event, current, previous, ...args) {
        console.log("Route Change Success", event);
        console.log("Route Change Success", current);
        console.log("Route Change Success", previous);
        console.log("Route Change Success", args);
        console.log("Route Change Success", $routeParams);        
    });
    $rootScope.$on("$routeChangeError", function(event, current, previous, ...args) {
        console.log("Route Change Error", event);
        console.log("Route Change Error", current);
        console.log("Route Change Error", previous);
        console.log("Route Change Error", args);
        console.log("Route Change Error", $routeParams);
        
    });
    //this works when reloadOnSearch is false
    $rootScope.$on("$routeUpdate", function(...args) {
        console.log("Route Update", args);
    });

    $rootScope.$on("$locationChangeStart", function(...args) {
        console.log("Location Change Start", args);
        // args[0].preventDefault();
        // throw new Error("New error"); // this doesn't block location change success from happening as was in case of route change start where if error occurs inside route change start then route change error event occurs instead of route change success.
    });

    $rootScope.$on("$locationChangeSuccess", function(...args) {
        console.log("Location Change Success", args);
    });
}]);

app.controller('homeController', ["aps", "dS", "promService","$location",  function(aps, dS, ps, $location) {
    console.log(aps, dS, ps);

}]);

app.service("aptService", [function() {
    this.setName = function(arg) {
        this.name = arg;
    }
    this.getName = function() {
        return this.name;
    }
}]);

app.service("delService", [function() {
    this.setRemoveFromIds = function(arg) {
        this.rIds = arg;
    }
    this.getRIds = function() {
        return this.rIds;
    }
}]);