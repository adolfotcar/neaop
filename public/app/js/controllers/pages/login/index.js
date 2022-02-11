angular
	.module('Neaop')
	.controller('LoginIndexController', function($scope, $http, $location, Api){
		$http
			.get(Api.backend+'login/'+Api.getToken())
			.success(function(data){
				$location.path('/');
			})
			.catch(function(response){
				$scope.error = false;

				$scope.submit = function(){
					var data = {
						'app-token': Api.appToken,
						'email': $scope.email,
						'password': $scope.password
					}
					$http.post(Api.backend+'login', data)
					.success(function(data){
						Api.setToken(data.data.token);
						$location.path('/');
					})
					.error(function(data, status){
						$scope.error = true;
						switch (status) {
							case 400:
								$scope.errorTitle = 'INVALID_FIELDS';
								$scope.errorMessage = 'FILL_FIELDS';
								break;
							case 401:
								$scope.errorTitle = 'LOGIN_FAILURE';
								$scope.errorMessage = 'VERIFY_LOGIN';
								break;
							default:
								$scope.errorTitle = 'UNKNOWN_ERROR';
								$scope.errorMessage = 'UNKNOWN_ERROR_MSG';
								break;
						} 
					});
				};
			});

	});