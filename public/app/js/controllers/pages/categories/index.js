angular
	.module('Neaop')
	.controller('CategoriesIndexController', function($scope, $http, $translate, $filter, Api){
		$scope.categories = { 
			'load': function(){
				$http
					.get(Api.backend+'categories'+'?token='+Api.getToken())
					.success(function(data){
						$scope.categories.list = data.data;
					})
					.catch(function(response){
						console.log('Failed to retrieve data');
					});
			},
			'remove': function(branch){
				if (!confirm($filter('translate')('CONFIRM_DELETE'))) {
					toastr.warning($filter('translate')('ACTION_CANCELLED')+'!', $filter('translate')('WARNING'));
					return;
				}
				$http
					.delete(Api.backend+'categories/'+branch+'?token='+Api.getToken())
					.success(function(data){
						toastr.success($filter('translate')('DATA_REMOVED')+'!', $filter('translate')('SUCCESS'));
						$scope.categories.load();
					})
					.catch(function(data){
						toastr.error($filter('translate')('ERROR_MSG')+' [Status: '+data.status+']', $filter('translate')('ERROR'));
					});
			}
		};

		$scope.categories.load();
		$scope.list = [{
			data: {
				      "id": 1,
				      "name": "1. dragon-breath"},
	      "items": []
	    }, {
	      "id": 2,
	      "title": "2. moiré-vision",
	      "items": [{
	        "id": 21,
	        "title": "2.1. tofu-animation",
	        "items": [{
	          "id": 211,
	          "title": "2.1.1. spooky-giraffe",
	          "items": []
	        }, {
	          "id": 212,
	          "title": "2.1.2. bubble-burst",
	          "items": []
	        }],
	      }, {
	        "id": 22,
	        "title": "2.2. barehand-atomsplitting",
	        "items": []
	      }],
	    }, {
	      "id": 3,
	      "title": "3. unicorn-zapper",
	      "items": []
	    }, {
	      "id": 4,
	      "title": "4. romantic-transclusion",
	      "items": []
	    }];
	});