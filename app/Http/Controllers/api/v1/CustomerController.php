<?php namespace App\Http\Controllers\api\v1;

use Input;
use App\Models\api\v1\Customer;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Validation\api\v1\CustomerValidator;

use Illuminate\Http\Request;

class CustomerController extends V1Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$search = Input::get('search', '');

		//if user is searching for a value, returns a list with the search result
		//else returns a list, paged (if limit and page are passed)
		if ($search) {
			$customers = Customer::where('name', 'LIKE', "%$search%")->get();
			return $this->endSuccess('list', $customers->toArray());
		}

		$customers = Customer::all();
		$limit = Input::get('limit', 0);
		$page = Input::get('page', 0);

		if ($limit && $page) {
			$page = $limit*($page-1);
			$this->setData('last_page', ceil(count($customers)/$limit));
			$customers = Customer::take($limit)->skip($page)->get();
		}

		return $this->endSuccess('list', $customers->toArray());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = new CustomerValidator();
		if (!$validator->passes()) return $this->endValidation($validator->errors);

		$customer = Customer::create(Input::all());
		
		return $this->endSuccess($customer->toArray());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$customer = Customer::find($id);
		if (is_null($customer)) return $this->endNotFound('customer_not_found');

		return $this->endSuccess($customer->toArray());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$customer = Customer::find($id);
		if (is_null($customer)) return $this->endNotFound('customer_not_found');

		$validator = new CustomerValidator();
		$validator->rules = [
			'name'			=> "required",
	        'contact_name'	=> "required",
	        'phone1'		=> "required",
	        'email'			=> "required|unique:customers,email,$id|email",
	        'nature'		=> "required",
	        'cnpj'			=> "unique:customers,cnpj,$id",
	        'insc_estadual'	=> "unique:customers,insc_estadual,$id"
	    ];
	    if (!$validator->passes()) return $this->endValidation($validator->errors);

	    $customer->fill(Input::all());
	    $customer->save();

	    return $this->endSuccess($customer->toArray());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$customer = Customer::find($id);
		if (is_null($customer)) return $this->endNotFound('customer_not_found');

		$customer->delete();
		return $this->getResult();
	}

}
