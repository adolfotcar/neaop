angular
	.module('Neaop')
	.controller('RolesUsersIndexController', function($scope, $http, $translate, $filter, $routeParams, Api, Dialog){
		$scope.role = {
			'load': function(){
				//loading users for the select
				$http
					.get(Api.backend+'users'+'?token='+Api.getToken())
					.success(function(data){
						$scope.role.users = data.data.data;
						console.log($scope.role.users);
					})
					.catch(function(response){
						console.log('Fail to retrieve role data');
					});

				//loading role
				$http
					.get(Api.backend+'roles/'+$routeParams.role_id+'/users?token='+Api.getToken())
					.success(function(data){
						$scope.role.role = data.data;
					})
					.catch(function(response){
						console.log('Fail to retrieve role data');
					});
			},
			'addUser2Role': function(form){
				$http
					.post(Api.backend+'roles/'+$routeParams.role_id+'/users/'+form.user_id+'?token='+Api.getToken())
					.success(function(data){
						toastr.success($filter('translate')('DATA_SAVED')+'!', $filter('translate')('SUCCESS'));
						$scope.role.load();
					})
					.catch(function(data){
						toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
					});
			},
			'removeUser': function(user_id){
				Dialog.confirm.callback = function(option){
					if (option) {
						return $http
								.delete(Api.backend+'roles/'+$routeParams.role_id+'/users/'+user_id+'?token='+Api.getToken())
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