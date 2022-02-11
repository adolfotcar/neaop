angular
	.module('Neaop')
	.controller('CustomersEditController', function($scope, $http, $routeParams, $filter, $location, Api){ 
		var editing = $routeParams.customer_id;
		$scope.customer = {
			'editing': editing,
			'load': function(){
				if (editing){
					$http
						.get(Api.backend+'customers/'+$routeParams.customer_id+'?token='+Api.getToken())
						.success(function(data){
							$scope.customer.data = data.data;
						})
						.catch(function(data){
							toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
						});
				}
			},
			'save': function(customer){
				var data = customer;
				data.token = Api.getToken();
				var method = 'POST';
				var url = Api.backend+'customers/';
				if (editing){
					method = 'PUT',
					url = url+$routeParams.customer_id;
				}
				$http({
					'method': method,
					'url': url,
					'data': data
				})
				.success(function(data){
					$scope.customer.data = data.data;
					console.log(data.data.id);
					if (!editing)
						$location.path('/customer/'+data.data.id);
					toastr.success($filter('translate')('DATA_SAVED')+'!', $filter('translate')('SUCCESS'));
				})
				.catch(function(data){
					toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
				});
			}
		}

		$scope.customer.load();
	});