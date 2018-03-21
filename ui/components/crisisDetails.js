var crisisStateDetails = angular.module('crisis-details', []);
crisisStateDetails.component('crisisStateDetails', {
    templateUrl: 'crisisDetails.html',
    controller: function() {
      this.$routerOnActivate = function(next, previous) {
          console.log("Crisis Details Router On Activate => ", next, previous);
      }
    },
    $routeConfig: [
      { path: '/heroDetails/', name: 'HeroDetails', component: 'heroDetails' }
    ]
  })