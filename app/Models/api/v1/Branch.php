<?php namespace App\Models\api\v1;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model {

	protected $fillable = ['name', 'title', 'phone', 'email', 'address1', 'address2', 'address3', 'address4'];

	public function users(){
		return $this->hasMany('App\Models\api\v1\users');
	}

}
