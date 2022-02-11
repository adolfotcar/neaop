<?php namespace App\Models\api\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model {

	use SoftDeletes;

	protected $fillable = ['name', 'contact_name', 'phone1', 'phone2', 'nature', 'cnae', 'cnpj', 'insc_estadual', 'status_sintegra', 'email', 'observations',
							'address1', 'address2', 'address3', 'address4', 'city', 'state', 'zip_code', 'country_code', 'country', 'address_delivery',
							'address_billing', 'price_table_id'];



}
