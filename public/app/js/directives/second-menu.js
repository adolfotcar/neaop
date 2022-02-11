angular
	.module('Neaop')
	.directive('secondMenu', ['$http', 'Api', function($http, Api){
		return {
			link: function(scope, elem, attrs){
				$(elem).click(function(e){
					e.preventDefault();
					var icon = $(this).children('.more-icon');
					if (icon.hasClass('fa-plus')) icon.removeClass('fa-plus').addClass('fa-minus');
					else icon.removeClass('fa-minus').addClass('fa-plus');
				});
			}
		}
	}]);