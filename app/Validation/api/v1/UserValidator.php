<?php namespace App\Validation\api\v1;

use App\Validation\Validator;

class UserValidator extends Validator {

    public $rules = [
        'name'		=> 'required',
        'surname'	=> 'required',
        'email'		=> 'required|unique:users|email',
        'branch_id'	=> 'required|integer'
        'password'	=> 'required|min:8'
    ];

}