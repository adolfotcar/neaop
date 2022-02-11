angular
	.module('Neaop')
	.controller('LogoutController', function($location, $http, Api){
		$http.get(Api.backend+'logout/?token='+Api.getToken());
		Api.removeToken();
		$location.path('/login');
	});