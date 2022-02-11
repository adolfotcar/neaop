angular
	.module('Neaop')
	.controller('UserProfileController', function($rootScope, $scope, $http, $translate, $filter, Api){
		$scope.security = {};
		$http
			.get(Api.backend+'user/'+Api.getToken()+'?token='+Api.getToken())
			.success(function(data){
				$scope.user = data.data;
				$scope.security.device = $scope.user.info.device_name?$scope.user.info.device_name:$scope.user.info.device;
				$translate.use($scope.user.language);
			})
			.catch(function(response){
				console.log('Failed to retrieve user data');
			});

		$rootScope.saveUser = function(user){
			var data = user;
			data.token = Api.getToken();
			$http
				.put(Api.backend+'user/'+Api.getToken(), data)
				.success(function(data){
					$rootScope.user.reload();
					$translate.use(user.language);
					toastr.success($filter('translate')('DATA_SAVED')+'!', $filter('translate')('SUCCESS'));
				})
				.catch(function(data){
					toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
				});
		};

		$rootScope.updateSecurity = function(security){
			var data = security;
			data.token = Api.getToken();
			$http
				.put(Api.backend+'user/security/'+Api.getToken(), data)
				.success(function(data){
					toastr.success($filter('translate')('DATA_SAVED')+'!', $filter('translate')('SUCCESS'));
				})
				.catch(function(data){
					toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
				});
		}
	});