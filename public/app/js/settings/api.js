angular
	.module('Neaop')
	.provider('Api', function ApiProvider(){
		//this is the login token, do not confuse with the appToken
		var token = localStorage.token || '0';

		return {
			$get: function (){
				return {
					'backend': '/api/v1/',
					'uri': '/api/v1/',
					'appToken': '3f20dda774015fc5e6725ccf71779149035e43ef',
					'methods': [ '*', 'GET_LIST', 'GET', 'POST', 'PUT', 'DELETE'],
					setToken: function (value){
						localStorage.token = value;
						token = value;
					},
					removeToken: function(){
						token = '0';
						localStorage.removeItem('token');
					},
					getToken: function(){
						return token;
					}
				};
			}
		};
	});
