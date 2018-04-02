angular.module('app', ['ngComponentRouter', 'heroes', 'crisis-state'])

    .config(function ($locationProvider) {
        $locationProvider.html5Mode(true);
    })

    .value('$routerRootComponent', 'app')

    .component('app', {
        template:
            '<nav>\n' +
            ' Home Page' +
            '<a ng-link="[\'Heroes\']">Get Heroes</a>' +
            '<a ng-link="[\'CrisisState\', {id: 12}]">Get Crisis</a>' +
            '</nav>\n' +
            '<ng-outlet></ng-outlet>\n',
        controller: function () {
            this.$routerOnActivate = function(next, previous) {
                console.log("App Router On Activate => ", next, previous);
            }
        },
        $routeConfig: [
            { path: '/heroes/', name: 'Heroes', component: 'heroes', useAsDefault: true },
            { path: '/crisis-state/:id/...', name: 'CrisisState', component: 'crisisState' }

        ]
    });