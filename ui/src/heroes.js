var heroes = angular.module('heroes', ['hero-details']);
heroes.component('heroes', {
    template: '<div>Hello Hero</div>'+
    '<a ng-link="[\'HeroDetails\']">Hero Details</a>'+
    '<ng-outlet></ng-outlet>',
    controller: function() {},
    $routeConfig: [
      {path: '/heroDetails', name: 'HeroDetails', component: 'heroDetails', useAsDefault: true }
    ]
  })