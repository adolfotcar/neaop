<?php namespace App\Models\api\v1;

use Illuminate\Database\Eloquent\Model;

class AllowedApp extends Model {

	protected $table = 'apps';

	public function tokens(){
		return $this->hasMany('App\Models\api\v1\Token', 'app_id');
	}

	public function users(){
		return $this->belongsToMany('App\Models\api\v1\User', 'tokens', 'user_id', 'app_id');
	}

}
