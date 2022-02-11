<?php namespace App\Validation\api\v1;

use App\Validation\Validator;

class UserUpdateValidator extends Validator {

    public $rules = [
        'name'		=> 'required',
        'surname'	=> 'required',
        'password'	=> 'min:8'
    ];

}