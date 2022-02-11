<?php namespace App\Http\Middleware\api\v1;

use App\Models\api\v1\Token;
use App\Models\api\v1\User;

use Closure;
use Session;
use Response;
use Input;
use Request;

class AuthenticateToken {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$allowedOrigin = Request::server('SERVER_NAME');
		$headers = ['Access-Control-Allow-Origin'	=> $allowedOrigin,
					'Access-Control-Allow-Methods'	=> 'POST, GET, OPTIONS, PUT, DELETE',
					'Access-Control-Allow-Headers'	=> 'Content-Type, X-Auth-Token, Origin'];

		$reqToken = Input::get('token');
		$token = Token::authToken($reqToken);

		if (is_null($token) || !$reqToken) {
			Session::put('logMessage', 'invalid_token');
			Response::json(['Invalid Token!'], 400, $headers);
		}

		$headers['Access-Control-Allow-Origin'] = $token->app->allowed_origin;
		
		$token->touchToken();

		//this session is used in another parts of the api, VerifyPermission for example
		Session::put('user_id', $token->user_id);

		$content = $next($request);
		foreach ($headers as $header => $value) 
			$content->header($header, $value);
		return $content;

	}

}