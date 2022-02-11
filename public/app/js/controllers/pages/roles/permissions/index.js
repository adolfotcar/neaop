angular
	.module('Neaop')
	.controller('RolesPermissionsIndexController', function($http, $routeParams, $scope, $filter, Api, Dialog){
		$scope.role = {
			'methods': Api.methods,
			'load': function(){
				//loading uris for the select
				$http
					.get(Api.backend+'uris'+'?token='+Api.getToken())
					.success(function(data){
						$scope.role.uris = data.data;
					})
					.catch(function(response){
						console.log('Fail to retrieve uris data');
					});

				//loading role
				$http
					.get(Api.backend+'roles/'+$routeParams.role_id+'/permissions?token='+Api.getToken())
					.success(function(data){
						$scope.role.permissions = data.data;
					})
					.error(function(response){
						console.log('Fail to retrieve role data');
					});
			},
			'getUri': function(uri_id){
				var friendly = '';
				angular.forEach($scope.role.permissions.uris, function(uri){
					if (uri.id==uri_id) friendly = uri.friendly;
				});
				return friendly;
			},
			'addRolePermissions': function(form){
				$http
					.post(Api.backend+'roles/'+$routeParams.role_id+'/permissions?uri_id='+form.uri_id+'&perm_method='+form.method+'&token='+Api.getToken())
					.success(function(data){
						toastr.success($filter('translate')('DATA_SAVED')+'!', $filter('translate')('SUCCESS'));
						$scope.role.load();
					})
					.catch(function(response){
						if (response.status==406)
							toastr.error($filter('translate')('DUPLICATE')+' [Status: '+response.status+']', $filter('translate')('ERROR'));
						console.log('Fail to retrieve role data');
					});
			},
			'removePermission': function(uri_id, method){
				Dialog.confirm.callback = function(option){
					if (option) {
						return $http
								.delete(Api.backend+'roles/'+$routeParams.role_id+'/permissions?uri_id='+uri_id+'&perm_method='+method+'&token='+Api.getToken())
								.success(function(data){
									toastr.success($filter('translate')('DATA_REMOVED')+'!', $filter('translate')('SUCCESS'));
									$scope.role.load();
								})
								.catch(function(data){
									toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
								});
					}
					return toastr.warning($filter('translate')('ACTION_CANCELLED')+'!', $filter('translate')('WARNING'));
				}
				BootstrapDialog.confirm(Dialog.confirm);
			}
		};

		$scope.role.load();
	});