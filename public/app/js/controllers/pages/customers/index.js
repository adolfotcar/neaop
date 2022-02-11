angular
	.module('Neaop')
	.controller('CustomersIndexController', function($scope, $http, $translate, $filter, Api){
		$scope.customers = { 
			'limit': 10, 
			'page': 1, 
			'last_page': 1,
			'load': function(){
				//setting page value if out of range
				if ($scope.customers.page<1)
					return $scope.customers.page = 1;
				if ($scope.customers.page>$scope.customers.last_page) 
					return $scope.customers.page = $scope.customers.last_page;

				$http
					.get(Api.backend+'customers'+'?token='+Api.getToken()+'&limit='+$scope.customers.limit+'&page='+$scope.customers.page)
					.success(function(data){
						$scope.customers.customers = data.data.customers;
						$scope.customers.last_page = data.data.last_page;
					})
					.catch(function(response){
						console.log('Failed to retrieve user data');
					});
			},
			'remove': function(customer_id){
				if (!confirm($filter('translate')('CONFIRM_DELETE'))) {
					toastr.warning($filter('translate')('ACTION_CANCELLED')+'!', $filter('translate')('WARNING'));
					return;
				}
				$http
					.delete(Api.backend+'customers/'+customer_id+'?token='+Api.getToken())
					.success(function(data){
						toastr.success($filter('translate')('DATA_REMOVED')+'!', $filter('translate')('SUCCESS'));
						$scope.customers.load();
					})
					.catch(function(data){
						toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
					});
			}
		};

		$scope.customers.load();
	});