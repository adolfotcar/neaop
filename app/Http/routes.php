<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|*/


Route::get('/', function(){
	return View::make('app.index');
});

Route::get('/cats', ['uses' => 'api\v1\CategoryController@index']);

Route::group(['prefix'=>'api/v1'], function(){

	Route::get('/test/2', function(){
		$match = Request::is('*/test/*/*');
		//$uri = '/test';
		//$match = ( ( Request::is("*$uri") || Request::is("*$uri/*") ) && ( !Request::is("*$uri/*/*") ) );
		dd($match);
	});

	Route::resource('/login', 'api\v1\LoginController', ['only'=>['store', 'show']]);
	Route::get('/logout', ['uses'=>'api\v1\LoginController@logout']);

	Route::group(['middleware' => 'auth.token'], function(){

		Route::get('/menu', ['uses' => 'api\v1\UserController@menu']);

		Route::group(['middleware' => 'verify.perms'], function(){
			
			Route::get('/user/{token}', ['uses' => 'api\v1\UserController@getByToken']);
			Route::put('/user/{token}', ['uses' => 'api\v1\UserController@update']);
			Route::put('/user/security/{token}', ['uses' => 'api\v1\UserController@updateSecurity']);
			Route::resource('/users', 'api\v1\UserController', ['only'=>['show', 'update', 'index', 'store', 'destroy']]);

			Route::get('/roles/{id}/users', ['uses' => 'api\v1\RoleController@users']);
			Route::post('/roles/{role_id}/users/{user_id}', ['uses' => 'api\v1\RoleController@addUser']);
			Route::delete('/roles/{role_id}/users/{user_id}', ['uses' => 'api\v1\RoleController@removeUser']);
			Route::get('/roles/{id}/permissions', ['uses' => 'api\v1\RoleController@permissions']);
			Route::post('/roles/{role_id}/permissions', ['uses' => 'api\v1\RoleController@addPermission']);
			Route::delete('/roles/{role_id}/permissions', ['uses' => 'api\v1\RoleController@removePermission']);
			Route::resource('/roles', 'api\v1\RoleController', ['only'=>['index', 'show', 'update', 'destroy', 'store']]);

			Route::resource('/uris', 'api\v1\UriController', ['only' => 'index']);

			Route::resource('/settings', 'api\v1\SettingsController', ['only' => ['index', 'store']]);

			Route::resource('/customers', 'api\v1\CustomerController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

			Route::resource('/branches', 'api\v1\BranchController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

			Route::resource('/categories', 'api\v1\CategoryController', ['only' => ['index', 'show', 'update', 'create', 'store']]);

			Route::resource('/products', 'api\v1\ProductController', ['only' => ['index', 'create', 'store', 'show']]);
		});
	});
});