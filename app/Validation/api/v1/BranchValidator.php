<?php namespace App\Validation\api\v1;

use App\Validation\Validator;

class BranchValidator extends Validator {

    public $rules = [
        'name'		=> 'required|unique:branches',
        'title'		=> 'required|unique:branches',
    ];

}