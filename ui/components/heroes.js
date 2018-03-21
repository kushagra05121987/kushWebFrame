var heroes = angular.module('heroes', ['hero-details']);
heroes.component('heroes', {
  template: '<div>Hello Hero</div>' +
  '<a ng-link="[\'HeroDetails\']">Open Hero Details</a>'+
  '<a ng-click="$ctrl.goCrisis()" href=""> Go To Crisis </a>'+
    '<ng-outlet></ng-outlet>',
  controller: function () { 
    this.$routerOnActivate = function(next, previous) {
        console.log("Heroes Router On Activate => ", next, previous);
        console.log("ROuter => ", this.$router);        
    }
    this.goCrisis = function() {
      this.$router.navigate(['CrisisState', {id: 22}]);
  }
  },
  $routeConfig: [
    { path: '/heroDetails/', name: 'HeroDetails', component: 'heroDetails', useAsDefault: true }
  ],
  bindings: { $router: '<' }
})