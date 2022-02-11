<?php namespace App\Validation\api\v1;

use App\Validation\Validator;

class CustomerValidator extends Validator {

    public $rules = [
        'name'		=> 'required',
        'contact_name'	=> 'required',
        'phone1'		=> 'required',
        'email'			=> 'required|unique:customers|email',
        'nature'		=> 'required',
        'cnpj'			=> 'unique:customers',
        'insc_estadual'		=> 'unique:customers'
    ];

}