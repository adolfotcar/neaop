angular
	.module('Neaop')
	.controller('BranchesIndexController', function($scope, $http, $translate, $filter, Api){
		$scope.branches = { 
			'limit': 10, 
			'page': 1, 
			'last_page': 1,
			'load': function(){
				//setting page value if out of range
				if ($scope.branches.page<1)
					return $scope.branches.page = 1;
				if ($scope.branches.page>$scope.branches.last_page) 
					return $scope.branches.page = $scope.branches.last_page;

				$http
					.get(Api.backend+'branches'+'?token='+Api.getToken()+'&limit='+$scope.branches.limit+'&page='+$scope.branches.page)
					.success(function(data){
						$scope.branches.branches = data.data.branches;
						$scope.branches.last_page = data.data.last_page;
					})
					.catch(function(response){
						console.log('Failed to retrieve user data');
					});
			},
			'remove': function(branch){
				if (!confirm($filter('translate')('CONFIRM_DELETE'))) {
					toastr.warning($filter('translate')('ACTION_CANCELLED')+'!', $filter('translate')('WARNING'));
					return;
				}
				$http
					.delete(Api.backend+'branches/'+branch+'?token='+Api.getToken())
					.success(function(data){
						toastr.success($filter('translate')('DATA_REMOVED')+'!', $filter('translate')('SUCCESS'));
						$scope.branches.load();
					})
					.catch(function(data){
						toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
					});
			}
		};

		$scope.branches.load();
	});