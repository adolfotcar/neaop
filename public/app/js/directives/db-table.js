angular
	.module('Neaop')
	.directive('dbTable', function($location){
		return { 
			restrict: 'EA',
			scope: {
				limit: '@',
				page: '@',
				last_page: '@',
				backend: '@',
				editUrl: '@',
				data: '@',
				mainPermission: '@',
				tableUrl: '@'
			},
			templateUrl: 'app/templates/db-table.html',
			controller: function($scope, $http, $translate, $filter, $rootScope, $location, Api, Dialog){
				
				$scope.load = function(){
					$http
						.get(Api.backend+$scope.backend+'?token='+Api.getToken()+'&limit='+$scope.limit+'&page='+$scope.page, Api.httpConf)
						.success(function(response){
							$scope.data = response.data.list;
							$scope.last_page = response.data.last_page;
						})
						.catch(function(response){
							toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+response.status+']', $filter('translate')('ERROR'));
						});
				};

				$scope.remove = function(id){
					Dialog.confirm.callback = function(option){
						if (option) {
							return $http
									.delete(Api.backend+$scope.backend+id+'?token='+Api.getToken())
									.success(function(response){
										toastr.success($filter('translate')('DATA_REMOVED')+'!', $filter('translate')('SUCCESS'));
										$scope.load();
									})
									.catch(function(response){
										toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+response.status+']', $filter('translate')('ERROR'));
									});
						}
						return toastr.warning($filter('translate')('ACTION_CANCELLED')+'!', $filter('translate')('WARNING'));
					}
					BootstrapDialog.confirm(Dialog.confirm);
				};
				
				$scope.search = function(){
					$http
						.get(Api.backend+$scope.backend+'?token='+Api.getToken()+'&search='+$scope.query)
						.success(function(response){
							$scope.data = response.data.list;
							$scope.searching = true;
						})
						.catch(function(response){
							toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+response.status+']', $filter('translate')('ERROR'));
						});
				};
				
				$scope.quitSearch = function(){
					$scope.searching = false;
					$scope.query = '';
					$scope.load();
				};
				
				$scope.paginate = function(page){
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

				$scope.isAllowed = function(method) {
					if ($rootScope.user)
						return ($rootScope.user.permissions.isAllowed($scope.mainPermission, method)) || 
								($rootScope.user.permissions.isAllowed($scope.allPermission, method));
					return false;
				};
			},
			link: function(scope){
				scope.allPermission = scope.mainPermission+'_ALL';
				scope.load();
			}
		}
	});