var crisis = angular.module('crisis-state', ['crisis-details']);
crisis.component('crisisState', {
    templateUrl: 'crisis.html',
    controller: function () {
        this.$routerOnActivate = function(next, previous) {
            console.log("Crisis Router On Activate => ", next, previous);
        }
        this.goHeroes = function() {
            this.$router.navigate(['Heroes']);
        }
        this.backToHome = function() {
            this.$router.navigate(['app']);
        }
     },
    $routeConfig: [
        { path: '/crisisDetails/', name: 'CrisisStateDetails', component: 'crisisStateDetails', useAsDefault: true }
    ],
    bindings: { $router: '<' }
})
