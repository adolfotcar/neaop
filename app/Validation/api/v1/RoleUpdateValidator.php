<?php namespace App\Validation\api\v1;

use App\Validation\Validator;

class RoleUpdateValidator extends Validator {

    public static $rules = [
        'name'		=> 'required'
    ];

}