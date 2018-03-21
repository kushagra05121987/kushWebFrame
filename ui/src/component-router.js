angular.module('app', ['ngComponentRouter', 'heroes', 'crisis'])

.config(function($locationProvider) {
  $locationProvider.html5Mode(true);
})

.value('$routerRootComponent', 'app')

.component('app', {
  template:
    '<nav>\n' +
    'Home Page'+
    '</nav>\n' +
    '<ng-outlet></ng-outlet>\n',
  $routeConfig: [
    {path: '/heroes/...', name: 'Heroes', component: 'heroes', useAsDefault: true  }
  ]
});