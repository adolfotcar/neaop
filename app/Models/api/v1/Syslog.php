<?php namespace App\Models\api\v1;

use Illuminate\Database\Eloquent\Model;
use Session;
use Request;

class Syslog extends Model {

	

	//method GET doesn't need to be loged
	protected static $methods4Log = ['POST', 'PUT', 'DELETE'];

	public static function setMessage($msg) {
		$method = Request::method();
		if (in_array($method, static::$methods4Log))
			Session::put('logMessage', $msg);
	}

	//only creates logs of some methods, to prevent logging GET
	//in case is necessary log a GET request, just pass force as true
	public static function doLog($force=false){
		$method = Request::method();
		$message = Session::pull('logMessage', 'success');
		$userId = Session::get('user_id');

		if ((in_array($method, static::$methods4Log))||$force) {
			$log = new Syslog();
			$log->user_id = $userId;
			$log->url = Request::path();
			$log->method = $method;
			$log->message = $message;
			$log->ip_address = Request::getClientIp();
			$log->save();

		}
	}

}
