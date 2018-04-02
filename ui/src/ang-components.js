var app = angular.module("myapp", ['ngAnimate']);
app.run(["$animate", function ($animate) {
    $animate.enabled(true);
}]);

app.controller("homeController", ["$scope", function ($scope) {
    $scope.message = "Message from parent controller";
    $scope.friends = [
        {
            name: "F1",
            age: 18,
            location: "india",
            parent: {
                disandant: {
                    area: "X"
                }
            }
        },
        {
            name: "F2",
            age: 38,
            location: "Australia",
            parent: {
                disandant: {
                    area: "Y"
                }
            }
        },
        {
            name: "F3",
            age: 28,
            location: "Nepal",
            parent: {
                disandant: {
                    area: "Z"
                }
            }
        },
    ];
    $scope.stars = [
        {
            name: "Alexa",
            age: 108,
            distance: 300
        },
        {
            name: "Xeno",
            age: 3800,
            distance: 900
        },
        {
            name: "Core",
            age: 208,
            distance: 200
        },
    ];
}]);
app.component("helloWorld", {
    template: `
    <span ng-transclude></span> 
    <div>{{hwController.message}}</div>
    <input type='button' ng-click='hwController.changeMessage()' value='Click me to change'/>
    Inside:
    <div class="animate" data-ng-repeat='friend in hwController.friends | parseToObject: hwController'>
    {{friend.name}},{{friend.age}},{{friend.location}},{{friend.parent.disandant.area}} 
    <input type='button' ng-click='hwController.changeDisandant($index)' value='Click me to change disandant'/>
    <input type='button' ng-click='hwController.changeName($index)' value='Click me to change name'/>
    </div>
    {{hwController.friends}}
    <div ng-repeat='star in hwController.stars'>{{star.name}},{{star.age}},{{star.distance}} </div>
    <input type='button' ng-click='hwController.testWatch()' value='Click me to change watch'/> 
    {{hwController.collection}}   
    <child-input message='hwController.message' friends='hwController.friends' test='hwController.testWatch(index)' change-d='hwController.changeDisandant(index)' change-n='hwController.changeName(index)'></child-input>
    `,
    transclude: true,
    replace: true,
    // first controller happens and then binding happens. Thats why this.message is updated to be from the parent controller rather than being Hello World.
    controller: function ($scope) {
        var self = this;
        this.message = "Hello World"
        this.collection = {
            name: "Dan",
            distance: {
                area: {
                    district: "Game"
                }
            }
        }
        this.changeMessage = function () {
            this.message = this.message + "s"
        }
        this.changeDisandant = function (index) {
            console.log(this.parsed);
            this.parsed[index].parent.disandant.area = "Changed"
        }
        this.changeName = function (index) {
            console.log(this.parsed);
            this.parsed[index].name = "Changed"
        }
        this.testWatch = function ($index) {
            console.log('test watch', $index);
            // this.collection.name = "Kushagra"
            // this.collection.distance.area.district = 300
            // this.message = "Changes"
        }
        $scope.$watch(function () {
            return self.collection;
        }, function (value) {
            console.log("Inside watch", value)
        }, true);
        $scope.$watchCollection(function () {
            return self.collection;
        }, function (value) {
            console.log("Inside watch Collection", value)
        });
    },
    controllerAs: "hwController",
    bindings: {
        message: "<",
        // message: '=',
        friends: '@',
        stars: "<"

    }
});

app.component("childInput", {
    template: `
    <div class='childEle' style='border: 1px solid; padding: 10px'>
        <input type='text' ng-model='childController.message' />
        <div class="animate" data-ng-repeat='friend in childController.friends | parseToObject: childController'>
        {{friend.name}},{{friend.age}},{{friend.location}},{{friend.parent.disandant.area}} 
        <input type='button' ng-click='childController.test({index: $index})' value='Click me to test'/>
        <input type='button' ng-click='childController.changeD({index: $index})' value='Click me to Change Disandant'/>
        <input type='button' ng-click='childController.changeN({index: $index})' value='Click me to Change Name'/>
        <input type='button' ng-click='childController.changeFriends($index)' value='Click me to Change Friends'/>
        
        </div>
    </div>
    `,
    // first controller happens and then binding happens. Thats why this.message is updated to be from the parent controller rather than being Hello World.
    require: {
        parent: '^helloWorld'
    },
    controller: function ($scope) {
        this.changeD = function ($index) {
            console.log($index)
        }
        this.$onInit = function (...args) {
            console.log("Init => ", args);
        }
        this.$onChanges = function (...args) {
            console.log("Changes => ", args);
        }
        this.$postLink = function (...args) {
            console.log("Post Link => ", args, this.parent);
        }
        this.$onDestroy = function (...args) {
            console.log("Destroy => ", args);
        }
        this.changeFriends = function($index) {
            // this.friends = "Delete Everything"
            // this.parent.friends = "delete everything"
            this.message = "delete message"
            
        }
    },
    controllerAs: "childController",
    bindings: {
        message: "<",
        // message: '=',
        friends: '<',
        test: '&',
        changeD: '&',
        changeN: '&'
    }
});

app.filter("parseToObject", function () {
    return function (args, ctrl) {
        // console.log(args, ctrl);
        // var json = JSON.parse(arg);
        // console.log(JSON.parse(arg));
        // console.log(json[index]);        
        // return json[index];

        if (typeof args == "string") {
            // console.log("Inside If", ctrl);
            if (ctrl && ctrl.parsed) {
                return ctrl.parsed;
            } else {
                ctrl.parsed = JSON.parse(args);
                return ctrl.parsed;
            }
            // var j = angular.fromJson(args);
            // return j;
            return friends;
            // return [1,2,3,4];
        } else {
            console.log("Inside Else", args);
            return args;
        }
    };
});

var friends = [
    {
        name: "F1",
        age: 18,
        location: "india"
    },
    {
        name: "F2",
        age: 38,
        location: "Australia"
    },
    {
        name: "F3",
        age: 28,
        location: "Nepal"
    },
];
