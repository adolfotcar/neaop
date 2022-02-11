<?php namespace App\Models\api\v1;

use Input;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	protected $fillable = ['name'];

	public function users(){
		return $this->belongsToMany('App\Models\api\v1\User');
	}

	public function permissions(){
		return $this->hasMany('App\Models\api\v1\RolePermission');
	}

	public function uris(){
		return $this->belongsToMany('App\Models\api\v1\Uri', 'role_permissions');
	}

	public static function checkDuplicate($name, $id){
		$role = static::where(function($query) use ($name, $id){
			$query
				->where('name', $name)
				->where('id', '<>', $id);
		})->first();
		return !(is_null($role));
	}

}
