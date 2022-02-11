<?php namespace App\Models\api\v1;

use Illuminate\Database\Eloquent\Model;

class Uri extends Model {

	protected $fillable = ['uri', 'friendly'];

	public function permissions(){
		return $this->hasMany('App\Models\api\v1\RolePermission');
	}

	public function roles(){
		return $this->belongsToMany('App\Models\api\v1\Role', 'role_permissions');
	}

	//returns uris different of *
	//prevent users to have acces to this special uri
	public static function onlyValids(){
		return static::where('uri', '<>', '*')->orderBy('friendly')->get();
	}

}
