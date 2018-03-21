var crisis = angular.module('crisis', ['crisis-details']);
crisis.component('crisisCenter', {
    templateUrl: '/learning/ui/views/crisisDetails.html',
    controller: function () { },
    $routeConfig: [
        { path: '/crisisDetails/', name: 'CrisisCenterDetails', component: 'crisisCenterDetails', useAsDefault: true }
    ]
})