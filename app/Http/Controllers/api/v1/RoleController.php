<?php namespace App\Http\Controllers\api\v1;

use Input;
use DB;
use App\Models\api\v1\RolePermission;
use App\Models\api\v1\Role;
use App\Models\api\v1\User;
use App\Models\api\v1\Module;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Validation\api\v1\RoleValidator;
use App\Validation\api\v1\RoleUpdateValidator;

use Illuminate\Http\Request;

class RoleController extends V1Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */


	public function index()
	{
		$search = Input::get('search', '');

		if ($search) {
			$roles = Role::where('name', 'LIKE', "%$search%")->get();
			$this->setData('list', $roles->toArray());
		}

		$roles = Role::all();
		$limit = Input::get('limit', 0);
		$page = Input::get('page', 0);
			
		//doing pagination when necessary
		if ($limit && $page) {
			//changing page value because laravel takes a skip number, not the page
			$page = $limit*($page-1);
			$this->setData('last_page', ceil(count($roles)/$limit));
			$roles = Role::take($limit)->skip($page)->get();
		}

		$this->setData('list', $roles->toArray());
		return $this->getResult();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = new RoleValidator();
		if (!$validator->passes()) return $this->endValidation($validator->errors);
		
		$role = Role::create(Input::all());
		$this->setData($role->toArray());
		return $this->getResult();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$role = Role::find($id);
		$this->setData($role->toArray());
		return $this->getResult();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Role::checkDuplicate(Input::get('name'), $id)) {
			$this->setMeta('code', 'role_exists');
			$this->setStatus(406);
			return $this->getResult();
		}
		$role = Role::find($id);
		$role->name = Input::get('name');
		$role->save();
		$this->setData($role->toArray());
		return $this->getResult();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$role = Role::find($id);
		
		$role->delete();
		DB::table('role_user')->where('role_id', $id)->delete();
		RolePermission::where('role_id', $id)->delete();
		$this->setData(['success']);
		return $this->getResult();
	}

	public function users($id){
		$role = Role::where('id', $id)->with('users')->first();
		$this->setData($role->toArray());
		return $this->getResult();
	}

	public function addUser($role_id, $user_id){
		$relation = DB::table('role_user')->where('role_id', $role_id)->where('user_id', $user_id)->first();
		if (!is_null($relation)) {
			$this->setMeta('code', 'relation_exists');
			$this->setStatus(406);
			return $this->getResult();
		}

		$role = Role::find($role_id);
		if (is_null($role)) {
			$this->setMeta('code', 'role_not_found');
			$this->setStatus(405);
			return $this->getResult();
		}
		$user = User::find($user_id);
		if (is_null($user)) {
			$this->setMeta('code', 'user_not_found');
			$this->setStatus(405);
			return $this->getResult();
		}

		$user->roles()->attach($role);
		$this->setData('attached');
		return $this->getResult();
	}

	public function removeUser($role_id, $user_id){
		$role_user = DB::table('role_user')->where('role_id', $role_id)->where('user_id', $user_id)->delete();
		$this->setData($role_user);
		return $this->getResult();
	}

	public function permissions($id){
		$permissions = Role::where('id', $id)->with('permissions')->with('uris')->first();
		$this->setData($permissions->toArray());
		return $this->getResult();
	}

	public function addPermission($id){
		$uri_id = Input::get('uri_id');
		$method = Input::get('perm_method');

		//checks if the module is enabled
		if (!Module::isUriValid($uri_id)){
			$this->setMeta('code', 'unknow_parameters');
			$this->setStatus(403);
			return $this->getResult();
		}

		$permission = RolePermission::where(function($query) use ($id, $uri_id, $method){
			$query
				->where('role_id', $id)
				->where('uri_id', $uri_id)
				->where('method', $method);
		})->first();
		if (!is_null($permission)) {
			$this->setMeta('code', 'permission_exists');
			$this->setStatus(406);
			return $this->getResult();
		}

		$permission = RolePermission::create([
						"role_id"		=> $id,
						"uri_id"		=> $uri_id,
						"method"		=> $method
					]);
		$this->setData($permission->toArray());
		return $this->getResult();
	}

	public function removePermission($id){
		$permission = RolePermission::where(function($query) use ($id){
			$query
				->where('role_id', $id)
				->where('uri_id', Input::get('uri_id'))
				->where('method', Input::get('perm_method'));
		})->delete();
		$this->setData($permission);
		return $this->getResult();
	}

}
