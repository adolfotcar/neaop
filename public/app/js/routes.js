angular
	.module('Neaop')
	.config(function($routeProvider){
		$routeProvider
			.when('/', {
				templateUrl: 'app/templates/pages/dashboard/index.html',
			})
			.when('/login', {
				templateUrl: 'app/templates/pages/login/index.html',
				controller: 'LoginIndexController'
			})
			.when('/profile-settings', {
				templateUrl: 'app/templates/pages/profile-settings/index.html',
				controller: 'UserProfileController'
			})
			.when('/logout', {
				templateUrl: 'app/templates/pages/login/index.html',
				controller: 'LogoutController'
			})
			.when('/roles', {
				templateUrl: 'app/templates/pages/roles/index.html',
			})
			.when('/role', {
				template: "<div class='row' x-db-form edit-url='/role/' backend='roles/' main-permission='ROLE' form-url='app/templates/pages/roles/form.html' id-name='role_id'></div>"
			})
			.when('/role/:role_id', {
				template: "<div class='row' x-db-form edit-url='/role/' backend='roles/' main-permission='ROLE' form-url='app/templates/pages/roles/form.html' id-name='role_id'></div>"
			})
			.when('/role/:role_id/users', {
				templateUrl: 'app/templates/pages/roles/users/index.html',
				controller: 'RolesUsersIndexController'
			})
			.when('/role/:role_id/permissions', {
				templateUrl: 'app/templates/pages/roles/permissions/index.html',
				controller: 'RolesPermissionsIndexController'
			})
			.when('/users', {
				template: "<div class='row' x-db-table edit-url='/#/user/' limit=10 page=1 last_page=1 backend='users/' main-permission='USERS' table-url='app/templates/pages/users/table.html'></div>"
			})
			.when('/user', {
				template: "<div class='row' x-db-form edit-url='/user/' backend='users/' main-permission='USER' form-url='app/templates/pages/users/form.html' id-name='user_id' reload='true'></div>"
			})
			.when('/user/:user_id', {
				template: "<div class='row' x-db-form edit-url='/user/' backend='users/' main-permission='USER' form-url='app/templates/pages/users/form.html' id-name='user_id' reload='true'></div>"
			})
			.when('/settings', {
				templateUrl: 'app/templates/pages/settings/index.html',
				controller: 'SettingsIndexController'
			}).when('/customers', {
				template: "<div class='row' x-db-table edit-url='/#/customer/' limit=10 page=1 last_page=1 backend='customers/' main-permission='CUSTOMERS' table-url='app/templates/pages/customers/table.html'></div>"
			}).when('/customer', {
				template: "<div class='row' x-db-form edit-url='/customer/' backend='customers/' main-permission='CUSTOMER' form-url='app/templates/pages/customers/form.html' id-name='customer_id'></div>"
			})
			.when('/customer/:customer_id', {
				template: "<div class='row' x-db-form edit-url='/customer/' backend='customers/' main-permission='CUSTOMER' form-url='app/templates/pages/customers/form.html' id-name='customer_id'></div>"
			}).when('/branches', {
				template: "<div class='row' x-db-table edit-url='/#/branch/' limit=10 page=1 last_page=1 backend='branches/' main-permission='BRANCHES' table-url='app/templates/pages/branches/table.html'></div>",
			}).when('/branch', {
				template: "<div class='row' x-db-form edit-url='/branch/' backend='branches/' main-permission='BRANCH' form-url='app/templates/pages/branches/form.html' id-name='branch_id'></div>"
			})
			.when('/branch/:branch_id', {
				template: "<div class='row' x-db-form edit-url='/branch/' backend='branches/' main-permission='BRANCH' form-url='app/templates/pages/branches/form.html' id-name='branch_id'></div>"
			})
			.when('/categories', {
				templateUrl: 'app/templates/pages/categories/index.html',
				controller: 'CategoriesIndexController'
			}).when('/category/:category_id', {
				template: "<div class='row' x-db-form edit-url='/category/' backend='categories/' main-permission='CATEGORY' form-url='app/templates/pages/categories/form.html' id-name='category_id'></div>"
			}).when('/category', {
				template: "<div class='row' x-db-form edit-url='/category/' backend='categories/' main-permission='CATEGORY' form-url='app/templates/pages/categories/form.html' id-name='category_id' force-load='true'></div>"
			})
			.when('/products', {
				template: "<div class='row' x-db-table edit-url='/#/product/' limit=10 page=1 last_page=1 backend='products/' main-permission='PRODS' table-url='app/templates/pages/products/table.html'></div>"
			})
			.when('/product', {
				template: "<div class='row' x-db-form edit-url='/#/product/' backend='products/' main-permission='PRODS' form-url='app/templates/pages/products/form.html' id-name='prod_id' force-load='true'></div>"
			})
			.when('/product/:product_id', {
				template: "<div class='row' x-db-form edit-url='/#/product/' backend='products/' main-permission='PRODS' form-url='app/templates/pages/products/form.html' id-name='product_id'></div>"
			})
			.otherwise({
				redirectTo: '/'
			});
	});