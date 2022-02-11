<?php namespace App\Validation\api\v1;

use App\Validation\Validator;

class LoginValidator extends Validator{

	public $rules = [
			'email'	=> 'required|email',
			'password' 	=> 'required',
			'app-token'	=> 'required',
	];

}