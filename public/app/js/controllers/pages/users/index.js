angular
	.module('Neaop')
	.controller('UsersIndexController', function($scope, $http, $translate, $filter, Api){
		$scope.editUrl = '/#/user/'
		$scope.limit = 10;
		$scope.page = 1;
		$scope.last_page = 1;
		$scope.load = function(){
			$http
				.get(Api.backend+'users?token='+Api.getToken()+'&limit='+$scope.limit+'&page='+$scope.page)
				.success(function(data){
					$scope.users = data.data.users;
					$scope.last_page = data.data.last_page;
				})
				.catch(function(response){
					console.log('Failed to retrieve user data');
				});
		};
		$scope.remove = function(id){
			if (!confirm($filter('translate')('CONFIRM_DELETE'))) {
				toastr.warning($filter('translate')('ACTION_CANCELLED')+'!', $filter('translate')('WARNING'));
				return;
			}
			$http
				.delete(Api.backend+'users/'+id+'?token='+Api.getToken())
				.success(function(data){
					toastr.success($filter('translate')('DATA_REMOVED')+'!', $filter('translate')('SUCCESS'));
					$scope.load();
				})
				.catch(function(response){
					toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
				});
		};
		$scope.search = function(){
			$http
				.get(Api.backend+'users?token='+Api.getToken()+'&search='+search)
				.success(function(data){
					$scope.users = data.data.users;
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
		};
		$scope.paginate = function(){
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
		};

		$scope.load();
	});