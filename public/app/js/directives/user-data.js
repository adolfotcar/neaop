angular
	.module('Neaop')
	.directive('userData', function($http, $translate, $rootScope, Api){
		return {
			link: function (){
					$rootScope.languages = [
						{key: 'en', title: 'English'},
						{key: 'pt-br', title: 'Portugês - BR'},
						{key: 'es', title: 'Español'}
					];
					$rootScope.user = {
						'permissions': {
							'list': {},
							'isAllowed': function(module, method) {
								var allow = false;
								angular.forEach($rootScope.user.permissions.list, function(perm){
									if (((perm.friendly==module)&&(perm.method==method || perm.method=='*'))||((perm.friendly=='*')&&(perm.method=='*')))
										allow = true;
								});
								return allow;
							}
						},
						'info': {},
						'conf': {},
						'reload': function(){
							$http
							.get(Api.backend+'user/'+Api.getToken()+'?token='+Api.getToken())
							.success(function(data){
								$rootScope.user.info = data.data.info;
								$rootScope.user.conf = data.data.conf;
								$rootScope.user.permissions.list = data.data.permissions;
								$translate.use($rootScope.user.info.language);
							})
							.catch(function(response){
								console.log('Failed to retrieve user data');
							});
						}
					};
					$rootScope.user.reload();
			}
		}
	});