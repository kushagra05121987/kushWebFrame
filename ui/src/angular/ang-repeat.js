var app = angular.module("myapp", ['ngAnimate']);

app.run(["$animate", function ($animate) {
    $animate.enabled(true);
}]);

app.controller('homeController', ["$scope", function ($scope) {
    $scope.repeatItems = [
        {
            id: 1,
            name: "Kushagra",
            location: "India",
            distance: 300
        },
        {
            id: 2,
            name: "Jak",
            location: "Germany",
            distance: 700
        },
        {
            id: 3,
            name: "Onk",
            location: "Japan",
            distance: 190
        },
        {
            id: 4,
            name: "Peter",
            location: "England",
            distance: 200
        },
        {
            id: 5,
            name: "Dan",
            location: "France",
            distance: 800
        }
    ];
    $scope.changeitems = function () {
        $scope.repeatItems.push(
            // {
            //     id: 6,
            //     name: "Tom",
            //     location: "Autralia",
            //     distance: 800
            // }
            // following generates error because of duplicate id 5
            {
                id: 5,
                name: "Tom",
                location: "Autralia",
                distance: 800
            }
        );
    }
    $scope.replace = function () {
        // $scope.repeatItems = [
        //     {
        //         id: 4,
        //         name: "Kushagra"
        //     },
        //     {
        //         id: 1,
        //         name: "Jak"
        //     },
        //     {
        //         id: 3,
        //         name: "Onk"
        //     },
        //     {
        //         id: 5,
        //         name: "Peter"
        //     },
        //     {
        //         id: 2,
        //         name: "Dan"
        //     }
        // ];
        // $scope.repeatItems = [
        //     {
        //         id: 2,
        //         name: "Jak",
        //         location: "Germany",                
        //         distance: 300
        //     },
        //     {
        //         id: 1,
        //         name: "Kushagra",
        //         location: "India",                
        //         distance: 700
        //     },
        //     {
        //         id: 3,
        //         name: "Onk",
        //         location: "Japan",
        //         distance: 190
        //     },
        //     {
        //         id: 4,
        //         name: "Petersssssssssssssssssssssssssssssssssss",
        //         location: "Englansssssssssd",
        //         distance: 200
        //     },
        //     {
        //         id: 5,
        //         name: "Dan",
        //         location: "France",
        //         distance: 800
        //     }
        // ];
        $scope.repeatItems = [
            {
                id: 2,
                name: "Jak",
                location: "Germansssssssssssssssy",
                distance: 700
            },
            {
                id: 1,
                name: "Kushagra",
                location: "India",
                distance: 300
            },
            {
                id: 3,
                name: "Onk",
                location: "Japan",
                distance: 190
            },
            {
                id: 4,
                name: "Peter",
                location: "Englandssssssssssss",
                distance: 200
            },
            {
                id: 5,
                name: "Dan",
                location: "France",
                distance: 800
            }
        ];
    }
    $scope.changeName = function (name, $index) {
        $scope.repeatItems[$index].name = name;
    };
    $scope.$watchCollection("repeatItems", function (oldV, newV) {
        console.log("Collection triggered");
    });
}]);

app.controller('repeatController', function ($scope) {
    var friends = [
        { name: 'John', age: 25 },
        { name: 'Mary', age: 40 },
        { name: 'Peter', age: 85 }
    ];

    $scope.removeFirst = function () {
        $scope.friends.shift();
    };

    $scope.updateAge = function () {
        $scope.friends.forEach(function (el) {
            el.age = el.age + 5;
        });
    };

    $scope.copy = function () {
        $scope.friends = angular.copy($scope.friends);
    };

    $scope.reset = function () {
        $scope.friends = angular.copy(friends);
    };

    $scope.reset();

    $scope.items = ['one','two','three','four'];
    $scope.selectedItem = 1;
    $scope.options = ['var1', 'var2', 'var3'];
    $scope.itemsNested = [{
        id: 4,
        label: 'aLabel',
        subItem: { name: 'aSubItem' }
      }, {
        id: 5,
        label: 'bLabel',
        subItem: { name: 'bSubItem' }
      }];
});