var heroDetails = angular.module('hero-details', []);
heroDetails.component('heroDetails', {
    templateUrl: 'heroDetails.html',
    controller: function() {
      this.$routerOnActivate = function(next, previous) {
          console.log("Her Details Router On Activate => ", next, previous);
      }
      this.$routerCanReuse = function() {return true;};
      this.$routerOnReuse = function(...args) {
        console.log("Router ON Reuse => ", args);
      }
    }
  })