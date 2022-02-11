angular
	.module('Neaop')
	.controller('BranchesEditController', function($scope, $http, $routeParams, $filter, $location, Api){ 
		var editing = $routeParams.branch_id;
		$scope.branch = {
			'editing': editing,
			'load': function(){
				if (editing){
					$http
						.get(Api.backend+'branches/'+$routeParams.branch_id+'?token='+Api.getToken())
						.success(function(data){							
							$scope.branch.data = data.data;
						})
						.catch(function(data){
							toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
						});
				}
			},
			'save': function(branch){
				var data = branch;
				data.token = Api.getToken();
				var method = 'POST';
				var url = Api.backend+'branches/';
				if (editing){
					method = 'PUT',
					url = url+$routeParams.branch_id;
				}
				$http({
					'method': method,
					'url': url,
					'data': data
				})
				.success(function(data){
					$scope.branch.data = data.data;
					console.log(data.data.id);
					if (!editing)
						$location.path('/branch/'+data.data.id);
					toastr.success($filter('translate')('DATA_SAVED')+'!', $filter('translate')('SUCCESS'));
				})
				.catch(function(data){
					toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
				});
			}
		}

		$scope.branch.load();
	});