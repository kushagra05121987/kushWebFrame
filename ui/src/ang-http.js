var app = angular.module('myapp', ['ngResource']);
app.config(["$httpProvider", function($httpProvider) {
    console.log("HTTP Provider", $httpProvider);
    $httpProvider.interceptors.push("myhttpinterceptor");
}]);
app.controller('homeController', ["$scope", "$rootScope", "$http", "$httpParamSerializer", "$httpParamSerializerJQLike", "resourceService", "$timeout", function($scope, $rootScope, $http, $httpParamSerializer, $httpParamSerializerJQLike, resourceService, $timeout) {
    window.http = $http
    console.log("HTTP: ", $http.prototype);
    $scope.candidates = [];
    $scope.makeRequest = function(type="GET") {
        var data = {name: "kushagra", "time": new Date(), "hit": true}
        $request = $http({
            url: "/learning/ui/request.php",
            method: type,
            data: JSON.stringify(data),
            params: {"status": true, payload: {"grip": "rear"}},
            headers: {
                "Content-Type": "application/json",
                "Content-Length": "300",
                // "Content-Disposition": "inline",
                "X-Header": "X-Value"
            },
            eventHandlers: {
                load(...args) {
                    console.log("Onload Event ", args);
                },
                progress(...args) {
                    console.log("OnProgress Event ", args);                    
                }
            },
            uploadEventHandlers: {
                load(...args) {
                    console.log("Upload Onload Event ", args);
                },
                progress(...args) {
                    console.log("Upload OnProgress Event ", args);                    
                }
            },
            transformRequest: [
                function(data, headersGetter) {
                    // console.log("First Transform Request");
                    // console.log(data, headersGetter);
                    // return JSON.stringify(data);
                    data = JSON.parse(data);
                    data.append = true
                    return data;
                },
                function(data, headersGetter) {
                    // console.log("Second Transform Request");
                    // console.log(data, headersGetter);
                    // return JSON.stringify(data);
                    // data = JSON.parse(data);                    
                    data.prepend = false;
                    return JSON.stringify(data);
                }
            ],
            transformResponse: [
                function(data, headersGetter, status) {
                    // console.log("First Transform Response");
                    // console.log(data, headersGetter, status);
                    return {data, headersGetter, status}                    
                },
                function(data, headersGetter, status) {
                    // console.log("Second Transform Response");
                    // console.log(data, headersGetter, status);
                    return {data, headersGetter, status}
                }
            ],
            paramSerializer: function(params) { // whatever is returned from this function is added as a query string and to the url.
                console.log("Param Serializer ", params);
                return $httpParamSerializerJQLike(params);
                // return JSON.stringify(data);
                // return data; // this will block the get parameters from sending.
            },
            cache: true, // caches all the future requests so that only one request goes and others are served from that cache.
            timeout: "100",
            withCredentails: false,
            responseType: "json"
        });

        $request.then(function(...response) {
            console.log("Success", response);
        }).catch(function(response){
            console.log("Error", response);
        });
    }
    $scope.submitForm = function() {
        var form = $("form").get(0);
        var serializedForm = $(form).serialize()
        $request = $http({
            url: "/learning/ui/request.php",
            method: "POST",
            data: serializedForm,
            // params: {"status": true, payload: {"grip": "rear"}},
            headers: {
                "Content-Type": "multipart/form-data; boundary=----WebKitFormBoundary3vV6Mzk6fdpyMGA5",
                "Content-Length": "300",
                // "Content-Disposition": "inline",
                "X-Header": "X-Value"
            },
            eventHandlers: {
                onload(...args) {
                    console.log("Onload Event ", args);
                },
                onprogress(...args) {
                    console.log("OnProgress Event ", args);                    
                }
            },
            uploadEventHandlers: {
                onload(...args) {
                    console.log("Upload Onload Event ", args);
                },
                onprogress(...args) {
                    console.log("Upload OnProgress Event ", args);                    
                }
            },
            // transformRequest: [
            //     function(data, headersGetter) {
            //         console.log("First Transform Request");
            //         console.log(data, headersGetter);
            //         // return JSON.stringify(data);
            //         return data;                    
            //     },
            //     function(data, headersGetter) {
            //         console.log("Second Transform Request");
            //         console.log(data, headersGetter);
            //         // return JSON.stringify(data);
            //         return data;                                        
            //     }
            // ],
            // transformResponse: [
            //     function(data, headersGetter, status) {
            //         console.log("First Transform Response");
            //         console.log(data, headersGetter, status);
            //         return {data, headersGetter, status}                    
            //     },
            //     function(data, headersGetter, status) {
            //         console.log("Second Transform Response");
            //         console.log(data, headersGetter, status);
            //         return {data, headersGetter, status}
            //     }
            // ],
            timeout: "10000",
            withCredentails: false,
            // responseType: "json"
        });
    }

    $scope.submitFile = function() {
        var form = $("form").get(0);
        var formdata = new FormData(form);
        $http({
            url: "/learning/ui/request.php",
            method: "POST",
            data: formdata,
            eventHandlers: {
                loadstart(...args) {
                    console.log("Onload Start Event ", args);
                },
                load(...args) {
                    console.log("Onload Event ", args);
                },
                progress(...args) {
                    console.log("OnProgress Event ", args);                    
                }
            },
            uploadEventHandlers: {
                loadstart(...args) {
                    console.log("Upload Onload Start Event ", args);
                },
                load(...args) {
                    console.log("Upload Onload Event ", args);
                },
                progress(...args) {
                    console.log("Upload OnProgress Event ", args);                    
                }
            },
        }).then(function(...response) {
            console.log("Success", response);
        }).catch(function(response){
            conssole.log("Error", response);
        });
    }

    $resourceClass = resourceService.init()
    console.log($resourceClass);
    console.log(Object.create($resourceClass));
    $resourceInstance = new $resourceClass();
    console.log($resourceInstance);
    
    $scope.response = $response = $resourceClass.get(function(response) {
        console.log("Response inside callback", response);
        $timeout(function() {
            response.data = {clock: 1200};
            response.$save({jack: 'fruits'}, function(response) {
                console.log("After save response: ", response);
            });
        }, 2000);
    });
    $response.$promise.then(function(response) {console.log('Success', response)});
    console.log("GET Response", $response);
    
    $updateResponse = $resourceClass.update({One: 1, Two: 2, _did: 22}, function() {
        console.log("Update Resource: ", $updateResponse);
    });
    console.log("Update response outside: ", $updateResponse);

    $resourceInstance['id'] = 300;
    $resourceInstance['display'] = "HD";
    $resourceInstance.$save({size: 90}, function(response) {
        console.log("Instance Response => ", response);
    });
    $resourceInstance.$query({under: 40}, function(response) {
        console.log("Query => ", response);
    });

}]);
app.controller('CacheController', ['$scope', '$cacheFactory', function($scope, $cacheFactory) {
    $scope.keys = [];
    $scope.cache = $cacheFactory('cacheId');
    console.log("cache => ", $scope.cache);
    console.log("cache info => ", $scope.cache.info());
    $scope.put = function(key, value) {
        if (angular.isUndefined($scope.cache.get(key))) {
        $scope.keys.push(key);
        }
        $scope.cache.put(key, angular.isUndefined(value) ? null : value);
    };
}]);
app.factory("myhttpinterceptor", ["$q",function($q) {
    return {
        request(config) {
            return config;
        },
        requestError(rejection) {
            console.log(rejection);
            return $q.reject(rejection);
            // return false;
        },
        response(response) {
            return response;
        },
        responseError(rejection) {
            return $q.reject(rejection);
            // return false;
        }
    };
}]);
app.service("resourceService", ["$resource", function($resource) {
    this.init = function() {
        $resourceInstance = $resource("/learning/ui/services/user/:userId/department/:departmentId", {userId: 123, departmentId: '@_did'}, {update: {
            method: 'PUT'
        }}, {
            cancellable: false,
            stripTrailingSlashes: true
        });
        return $resourceInstance;
    }
}]);