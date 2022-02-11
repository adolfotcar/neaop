<?php namespace App\Http\Controllers\api\v1;

use App\Http\Requests;
use App\Models\api\v1\Token;
use App\Models\api\v1\User;
use App\Models\api\v1\AllowedApp;
use App\Validation\api\v1\LoginValidator;
use App\Models\api\v1\Syslog;

use Input;
use Hash;
use Request;

class LoginController extends V1Controller {

	//Checks if the user and password are correct
	//checks if the token already exists for this app
	//creates/updates the token and returns it
	public function store()
	{
		//validates parameters
		$validator = new LoginValidator();
		if (!$validator->passes()){
			$this->setData($validator->errors);
			return $this->endError('login.validation_failure', 400);
		}

		$email = Input::get('email');
		$password = Input::get('password');
		$device = Request::header('User-Agent');
		$appToken = Input::get('app-token');
		$remember = Input::get('remember')=='Y';

		//validates the app token
		$app = AllowedApp::where('token', $appToken)->first();
		if (is_null($app))
			return $this->endError('login.invalid_app_token', 403);

		//validates username and password
		$user = User::where('email', $email)->first();
		if ((is_null($user))||(!$user->checkPassword($password)))
			return $this->endError('login.failure', 401);

		//deleting invalid tokens for this app and user
		//usefull to keep tokens table clean
		Token::where('device', $device)->
				where('user_id', $user->id)->
				where('expire_date', '<=', date('Y-m-d G:i:s'))->
				delete();

		$now = new \DateTime();
		//remeber token keeps it available for 1 month, else only 2 hrs
		if ($remember)
			$tokenExpires = $now->modify('+30 days');
		else
			$tokenExpires = $now->modify('+2 hours');

		//searching for a valid token
		//if doesn't exists creates a new on
		//if already exists just updates the expire_date
		$token = Token::where('device', $device)->
						where('user_id', $user->id)->
						where('expire_date', '>', date('Y-m-d G:i:s'))->
						first();
		if (is_null($token)) {			
			$tokenVal = Hash('sha1', date('y-m-d G:i:s').'-'.rand(0, 100));			
			$token = new Token(['user_id'=>$user->id, 'device'=>$device, 'app_id'=>$app->id, 'token'=>$tokenVal, 
								'ip_address' => Request::getClientIp(), 'expire_date'=>$tokenExpires
								]);
		} else {
			$token->ip_address = Request::getClientIp();
			$token->expire_date = $tokenExpires;
		}
		$token->save();

		$this->setMeta('status', 200);
		$this->setData($token->toArray());
		return $this->getResult();
	}

	public function show($reqToken)
	{
		$token = Token::selectValidToken($reqToken);
		if (is_null($token))
			return $this->endError('not_authorized', 403);

		$this->setData($token->toArray());
		return $this->getResult();
	}

	public function logout(){
		Token::where('token', Input::get('token'))
				->delete();
		$this->setData('message', 'logged_out');
		Syslog::doLog(true);
		return $this->getResult();
	}

}