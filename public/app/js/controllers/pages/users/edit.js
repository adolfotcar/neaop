angular
	.module('Neaop')
	.controller('UsersEditController', function($scope, $http, $filter, $routeParams,  $location, Api){
		$scope.arildo = 'Antonio';
		$scope.branches = [
									{
										id: 0,
										idNameme: 'Matrix'
									},
									{
										id: 1,
										name: 'Arildo'
									},
									{
										id: 2,
										name: 'Fagundes'
									},
									{
										id: 3,
										name: 'Joseph'
									}
								];
	});