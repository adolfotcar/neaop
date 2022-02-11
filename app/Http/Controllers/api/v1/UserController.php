<?php namespace App\Http\Controllers\api\v1;

use App\Http\Requests;
use App\Models\api\v1\User;
use App\Models\api\v1\Settings;
use App\Models\api\v1\Token;
use App\Validation\api\v1\UserValidator;
use App\Validation\api\v1\UserUpdateValidator;

use Input;
use Hash;
use DB;
use Session;

class UserController extends V1Controller {

	public function index(){
		$search = Input::get('search', '');

		if ($search) {
			$users = User::where('name', 'LIKE', "%$search%")->get();
			return $this->endSuccess('list', $users->toArray());
		}

		$users = User::all();
		$limit = Input::get('limit', 0);
		$page = Input::get('page', 0);

		//doing pagination when necessary
		if ($limit && $page) {
			$page = $limit*($page-1);
			$this->setData('last_page', ceil(count($users)/$limit));
			$users = User::take($limit)->skip($page)->get();
		}
		
		return $this->endSuccess('list', $users->toArray());
	}

	public function getByToken($reqToken) {
		$user = DB::table('users')
					->leftJoin('tokens', 'tokens.user_id', '=', 'users.id')
					->leftJoin('branches', 'users.branch_id', '=', 'branches.id')
					->where('tokens.token', $reqToken)
					->select('users.id', 'users.name', 'users.surname', 'users.branch_id', 'users.email', 'users.language',
							'tokens.device', 'tokens.device_name', 
							'branches.name AS branch_name', 'branches.title AS branch_title')
					->first();
		if (is_null($user)) return $this->endNotFound('user_not_found');

		$uris = DB::table('role_permissions')
					->leftJoin('uris', 'uris.id', '=', 'role_permissions.uri_id')
					->leftJoin('role_user', 'role_user.role_id', '=', 'role_permissions.role_id')
					->where('role_user.user_id', Session::get('user_id'))
					->select('uris.friendly', 'role_permissions.method')
					->get();

		$settings = Settings::find(1, ['title']);

		$data = ['info' => $user, 'permissions' => $uris, 'conf' => $settings->toArray()];

		return $this->endSuccess($data);
	}

	//GET api/v1/users/$id
	public function show($id){
		$user = User::find($id);
		if (is_null($user)) return $this->endNotFound('user_not_found');

		return $this->endSuccess($user->toArray());
	}

	//PUT api/v1/users/$id
	//updates the user ID=$id
	public function update($id){
		//whe user is editing others data $id will be an id
		//when user is editing its own info, $id will be a token
		$user = User::find($id);
		if (is_null($user)) {
			$user = Token::getUserByToken($id);
			if (is_null($user)) return $this->endNotFound('user_not_found');
		}

		//validating data
		$validator = new UserUpdateValidator();
		if (!$validator->passes()) return $this->endValidation($validator->errors);

		$user->name = Input::get('name');
		$user->surname = Input::get('surname');
		//some fields are not mandatory, so updates only when they are passed
		$user->language = Input::get('language', $user->language);
		$user->branch_id = Input::get('branch_id', $user->branch_id);
		if (Input::get('password')) $user->password = Hash::make(Input::get('password'));

		$user->save();
		return $this->endSuccess($user->toArray());
	}

	public function store(){
		$validator = new UserValidator();
		if (!$validator->passes()) return $this->endValidation($validator->errors);

		$user = new User(Input::all());
		$user->password = Hash::make($user->password);
		$user->save();
		
		return $this->endSuccess($user->toArray());
	}

	public function destroy($id){
		$user = User::find($id);
		if (is_null($user)) return $this->endNotFound('user_not_found');

		$user->delete();
		return $this->endSuccess();
	}

	public function updateSecurity($token){
		$password = Input::get('password');

		$token = Token::selectValidToken($token);
		if (is_null($token)) 
			return $this->endNotFound('invalid_token');

		$user = $token->user()->first();
		if (!$user->checkPassword($password)) 
			return $this->endNotFound('invalid_password');		

		$newPass = Input::get('new_password');
		$confirmPass = Input::get('confirm_password');
		if ($newPass!=$confirmPass)
			return $this->endValidation('passwords_mismatch');

		if ($newPass) $user->password = Hash::make($newPass);

		$user->save();

		$remember = Input::get('remember');
		if ($remember) {
			$token->device_name = Input::get('device');
			
			//only set the token for 30 days if its not remembered yet
			if (!$this->remember) {
				$now = new \DateTime();
				$token->expire_date = $now->modify('+30 days');
			}
			$token->remember = true;
			$token->save();
		}

		return $this->getResult();
	}

}
