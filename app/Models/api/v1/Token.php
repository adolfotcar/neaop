<?php namespace App\Models\api\v1;

use Illuminate\Database\Eloquent\Model;
use Request;

class Token extends Model {

	protected $hidden = [ 'id', 'user_id', 'app_id'];
	protected $fillable = ['user_id', 'device', 'app_id', 'token', 'ip_address', 'expire_date'];

	public function user(){
		return $this->belongsTo('App\Models\api\v1\User');
	}

	public function app(){
		return $this->belongsTo('App\Models\api\v1\AllowedApp', 'app_id');
	}

	public function expired(){
		$expire_date = new DateTime($this->expire_date);
		$now = new DateTime();
		return $expire_date<$now;
	}

	public static function selectValidToken($reqToken){
		$token =	static::where('token', $reqToken)
						->with('user')
						->where('device', Request::header('User-Agent'))
						->where('expire_date', '>', date('y-m-d G:i:s'))
						->first();
		return $token;
	}

	public static function authToken($reqToken){
		$token = static::with('app')
						->where('token', $reqToken)
						->where('device', Request::header('User-Agent'))
						->where('expire_date', '>', date('Y-m-d G:i:s'))
						->first();
		return $token;
	}

	public static function getUserByToken($reqToken){
		$token = static::selectValidToken($reqToken);
		$user = is_null($token)?null:$token->user;
		return $user;
	}

	public function touchToken(){
		//when the token is marked to be remembered it will have 30 days of life
		if ($this->remember) return false;

		//else it has 2hrs of life, but is updated everytime has an activity
		$now = new \DateTime();
		$this->expire_date = $now->modify('+2 hours');
		$this->save();
		return true;
	}

}
