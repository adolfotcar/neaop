angular
	.module('Neaop')
	.directive('dbForm', function(){
		return {
			restrict: 'EA',
			scope: {
				backend: '@',
				idName: '@',
				formUrl: '@',
				editUrl: '@',
				mainPermission: '@',
				reload: '@',
				forceLoad: '@',
			},
			templateUrl: 'app/templates/db-form.html',
			controller: function($scope, $http, $routeParams, $filter, $location, $rootScope, Api){
				$scope.editing = $routeParams[$scope.idName];
				var url = Api.backend+$scope.backend+$scope.editing+'?token='+Api.getToken();
				if ($scope.forceLoad)
					url = Api.backend+$scope.backend+'create/?token='+Api.getToken();
				$scope.load = function(){
					if ($scope.editing || $scope.forceLoad){
						$http
							.get(url)
							.success(function(response){
								$scope.data = response.data;
							})
							.catch(function(response){
								toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+response.status+']', $filter('translate')('ERROR'));
							});
					}
				};
				$scope.save = function(form){
					var data = form;
					data.token = Api.getToken();
					var method = 'POST';
					var url = Api.backend+$scope.backend;
					if ($scope.editing){
						method = 'PUT',
						url = url+data.id;
					}
					$http({
						'method': method,
						'url': url,
						'data': data
					})
					.success(function(response){
						$scope.data = response.data;
						//in some cases will be necessary reload the entire user data
						if ($scope.reload) $rootScope.user.reload();
						if (!$scope.editing)
							$location.path($scope.editUrl+response.data.id);
						toastr.success($filter('translate')('DATA_SAVED')+'!', $filter('translate')('SUCCESS'));
					})
					.catch(function(response){
						toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+response.status+']', $filter('translate')('ERROR'));
					});
				};
			},
			link: function(scope){
				scope.load();
			}
		};
	});