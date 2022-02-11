<?php namespace App\Models\api\v1;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model {

	protected $table = 'role_permissions';

	protected $fillable = ['role_id', 'uri_id', 'method'];

	public function role(){
		return $this->belongsTo('App\Models\api\v1\Role');
	}

	public function uri(){
		return $this->belongsTo('App\Models\api\v1\Uri');
	}

}
