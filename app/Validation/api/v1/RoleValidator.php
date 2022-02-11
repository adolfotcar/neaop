<?php namespace App\Validation\api\v1;

use App\Validation\Validator;

class RoleValidator extends Validator {

    public $rules = [
        'name'		=> 'required|unique:roles'
    ];

}