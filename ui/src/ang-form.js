var app = angular.module("myapp", []);

app.controller("fController", ["$scope","$rootScope", function($scope, $rootScope) {
    $scope.bookings = [];
    $scope.currentBooking = {};
    $scope.validateForm = function() {
        $scope.bookings.push($scope.currentBooking.user);
    }
    $scope.submitForm = function(e) {
        // e.preventDefault();
    }
}]);
app.directive("phone", [function() {
    return {
        restrict: "A",
        require: "ngModel",
        link(scope, element, attrs, ctrl) {
            var phoneLength = attrs.phone;
            ctrl.$validators.phone = function(modelValue, viewValue) {
                console.log(modelValue, viewValue);
                if(phoneLength) {
                    if(viewValue && viewValue.length && viewValue.length > phoneLength) {
                        return false;
                    } else if(viewValue && viewValue.length && viewValue.length < phoneLength) {
                        return false;
                    } else if(viewValue && !viewValue.length) {
                        return false;
                    } else if(viewValue && viewValue.length && viewValue.length == phoneLength) {
                        return true;
                    } else if(!viewValue) {
                        return true;
                    }
                }
            }
        }
    };
}]);
app.directive("usernames", ["$q","$timeout",  function($q, $timeout) {
    return {
        restrict: "A",
        require: "ngModel",
        link(scope, element, attrs, ctrl) {
            var usernames = ['Jim', 'John', 'Jill', 'Jackie'];
            ctrl.$asyncValidators.usernames = function(modelValue, viewValue) {
                var defer = $q.defer();
                $timeout(function() {
                    console.log(modelValue, viewValue);
                    if(viewValue && viewValue in usernames) {
                        defer.resolve("completed");
                    } else if(viewValue && !(viewValue in usernames)) {
                        return defer.reject("rejected");
                    } else if(!viewValue) {
                        defer.resolve("completed");
                    }
                }, 5000);
                return defer.promise;
            }
        }
    };
}]);
