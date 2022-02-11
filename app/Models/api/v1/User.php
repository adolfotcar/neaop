<?php namespace App\Models\api\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash;

class User extends Model {

	use SoftDeletes;

	protected $hidden = [ 'password'];
	protected $fillable = ['email', 'password', 'name', 'surname', 'language', 'branch_id'];
	protected $dates = ['deleted_at'];	

	public function roles(){
		return $this->belongsToMany('App\Models\api\v1\Role');
	}

	public function apps(){
		return $this->belongsToMany('App\Models\api\v1\AllowedApp', 'tokens', 'user_id', 'app_id');
	}

	public function tokens(){
		return $this->hasMany('App\Models\api\v1\Token');
	}

	public function branch(){
		return $this->belongsTo('App\Models\api\v1\Branch');
	}

	public function permissions(){
		$permissions = [];
		foreach ($this->roles()->get() as $role) 
			foreach ($role->permissions()->get() as $permission)
				foreach ($permission->uri()->get() as $uri) 
					$permissions[] = $uri->uri;
		return $permissions;
	}

	public function checkPassword($password){
		return Hash::check($password, $this->password);
	}

}
