angular
	.module('Neaop', ['ngRoute', 'pascalprecht.translate', 'ui.mask', 'ui.tree'])
	.run(function($rootScope, $http, $location, Api){
		$rootScope.$on('$routeChangeSuccess', function(){
			var req = 

			//if the token is invalid redirects to login
			$http
				.get(Api.backend+'login/'+Api.getToken(), Api.httpConf)
				.success(function(data){
					$rootScope.logged = true;
				})
				.catch(function(response){
					$rootScope.logged = false;
					$location.path('/login');
				});
		});
	})
	.controller('AppCtrl', function AppCtrl($timeout, $scope, $http, $location, Api){
		var controller = this;

		//closing splash screen
		$timeout(function(){
			$scope.hideSplash = true;
		}, 1000);
		
	});