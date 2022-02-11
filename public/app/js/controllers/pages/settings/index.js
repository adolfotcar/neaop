angular
	.module('Neaop')
	.controller('SettingsIndexController', function($http, $scope, $rootScope, $filter, Api){
		$scope.settings = {
			'load': function(){
				$http
				.get(Api.backend+'settings?token='+Api.getToken())
				.success(function(data){
					$scope.settings.conf = data.data;
				})
				.catch(function(response){
					console.log('fail');
				});
			},
			'save': function(conf){
				var data = conf;
				data.token = Api.getToken();
				$http
					.post(Api.backend+'settings', data)
					.success(function(data){
						$scope.settings.conf = data.data;
						$rootScope.user.reload();
					})
					.catch(function(response){
						console.log('Fail');
					});
			}
		};

		$scope.settings.load();
	});