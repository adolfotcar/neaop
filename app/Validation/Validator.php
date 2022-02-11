<?php namespace App\Validation;

use Illuminate\Support\Facades\Input as Input;

abstract class Validator {

    protected     $data;
    public        $errors;
    public        $rules;

    public function __construct($rules=null){
        if ($rules) $this->rules = $rules;
        $this->data = Input::all();
    }

    public function passes($data = null, $rule = null, $custom_message = null){
        $validation = null;
        try {

            if (isset(static::$custom_message)) {
                $validation = \Validator::make(($data ?: $this->data), ($rule ?: $this->rules), ($custom_message ?: static::$custom_message));
            } else {
                $validation = \Validator::make(($data ?: $this->data), ($rule ?: $this->rules));
            }

            if ($validation->passes()) return true;
            $this->errors = $validation->messages();
        } catch ( \Exception $err ){
            $this->errors = 'Validation Exception';
        }
        return false;

    }

}