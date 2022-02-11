angular
	.module('Neaop')
	.provider('Dialog', [function DialogProvider(){
		return {
			$get: function ($filter){
				return {
					'confirm': {
						title: $filter('translate')('CONFIRMATION'),
						message: $filter('translate')('CONFIRM_DELETE'),
						type: BootstrapDialog.TYPE_WARNING
					}
				};
			}
		};
	}]);