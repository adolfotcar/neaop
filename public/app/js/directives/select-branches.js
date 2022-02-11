angular
	.module('Neaop')
	.directive('selectBranches', function($http, Api, $filter){
		return {
			link: function (scope){
				$http
					.get(Api.backend+'branches?token='+Api.getToken())
					.success(function(response){
						scope.branches = response.data.list;
					})
					.catch(function(response){
						toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+response.status+']', $filter('translate')('ERROR'));
					});
			}
		}
	});