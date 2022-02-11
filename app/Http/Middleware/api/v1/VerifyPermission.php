<?php namespace App\Http\Middleware\api\v1;

use Closure;
use DB;
use Input;
use Response;
use Session;
use Request;
use App\Models\api\v1\Token;
use App\Models\api\v1\User;
use App\Models\api\v1\AllowedApp;

class VerifyPermission {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		//Session['user_id'] is set on the middleware AuthenticateToken
		if (Session::get('user_id')) {
			$uris = DB::table('uris')
						->leftJoin('role_permissions', 'role_permissions.uri_id', '=', 'uris.id')
						->leftJoin('role_user', 'role_user.role_id', '=', 'role_permissions.role_id')
						->leftJoin('users', 'users.id', '=', 'role_user.user_id')
						->where('users.id', Session::get('user_id'))
						->select('uris.uri', 'role_permissions.method')
						->get();
			foreach ($uris as $uri) {
				if (static::verifyUri($uri->uri, $uri->method) && static::verifyMethod($uri->method))
					return $next($request);
			}
		}
		Session::put('logMessage', 'not_authorized');
		return Response::json(['not_authorized'], 403);
	}

	public static function verifyUri($uri, $method) {
		if ($method=='*')
			return ( (Request::is("*$uri") || Request::is("*$uri/*")) && !Request::is("*$uri/*/*") ) || $uri=='*';
		if ($method=='POST' || $method=='GET_LIST')
			return ( Request::is("*$uri") && !Request::is("*$uri/*") ) || $uri=='*';
		return ( Request::is("*$uri/*") && ( !Request::is("*$uri/*/*") ) ) || $uri=='*';
	}

	public static function verifyMethod($method) {
		$method = $method=='GET_LIST'?'GET':$method;
		return Request::method()==$method || $method=='*';
	}

}