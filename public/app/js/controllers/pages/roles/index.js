angular
	.module('Neaop')
	.controller('RolesIndexController', function($scope, $http, $translate, $filter, Api, Dialog){
		$scope.editUrl = '/#/role/'
		$scope.limit = 10;
		$scope.page = 1;
		$scope.last_page = 1;
		$scope.load = function(){
			$http
				.get(Api.backend+'roles'+'?token='+Api.getToken()+'&limit='+$scope.limit+'&page='+$scope.page)
				.success(function(data){
					$scope.roles = data.data.roles;
					$scope.last_page = data.data.last_page;
				})
				.catch(function(response){
					console.log('Failed to retrieve user data');
				});
		};
		$scope.remove = function(id){
			Dialog.confirm.callback = function(option){
				if (option) {
					return $http
							.delete(Api.backend+'roles/'+id+'?token='+Api.getToken())
							.success(function(data){
								toastr.success($filter('translate')('DATA_REMOVED')+'!', $filter('translate')('SUCCESS'));
								$scope.load();
							})
							.catch(function(data){
								toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
							});
				}
				return toastr.warning($filter('translate')('ACTION_CANCELLED')+'!', $filter('translate')('WARNING'));
			}
			BootstrapDialog.confirm(Dialog.confirm);
		};
		$scope.search = function(search){
			$http
				.get(Api.backend+'roles?token='+Api.getToken()+'&search='+search)
				.success(function(data){
					$scope.roles = data.data.roles;
					$scope.searching = true;
				})
				.catch(function(response){
					console.log('Failed to retrieve user data');
				});
		};

		$scope.quitSearch = function(){
			$scope.searching = false;
			$scope.query = '';
			$scope.load();
		}

		$scope.paginate = function(page) {
			switch (page){
				case 'first':
					$scope.page = 1;
					break;
				case 'last':
					$scope.page = $scope.last_page;
					break;
				default:
					$scope.page = $scope.page+page;
					break
			}
			if ($scope.page<1) 
				return $scope.page = 1;
			if ($scope.page>$scope.last_page) 
				return $scope.page = $scope.last_page;
			$scope.load();
		}

		$scope.load();
	});