angular
	.module('Neaop')
	.controller('RolesEditController', function($scope, $http, $routeParams, $filter, $location, Api){ 
		var editing = $routeParams.role_id;
		$scope.role = {
			'editing': editing,
			'load': function(){
				if (editing) {
					$http
						.get(Api.backend+'roles/'+$routeParams.role_id+'?token='+Api.getToken())
						.success(function(data){
							$scope.role.data = data.data;
						})
						.catch(function(data){
							toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
						});
				}
			},
			'save': function(role){
				var data = role;
				data.token = Api.getToken();
				var method = 'POST';
				var url = Api.backend+'roles/';
				if (editing) {
					method = 'PUT';
					url = url+$routeParams.role_id;
				}
				$http({
					'method': method,
					'url': url,
					'data': data
				})
				.success(function(data){
					$scope.role.data = data.data;
					if (!editing)
						$location.path('/role/'+data.data.id);
					toastr.success($filter('translate')('DATA_SAVED')+'!', $filter('translate')('SUCCESS'));
				})
				.catch(function(data){
					toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
				});
			}
		}

		$scope.role.load();
	});
	