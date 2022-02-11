<?php namespace App\Http\Controllers\api\v1;

use Input;
use App\Models\api\v1\Branch;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Validation\api\v1\BranchValidator;

use Illuminate\Http\Request;

class BranchController extends V1Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//if user is searching for a value, returns a list with the search result
		//else returns a list, paged (if limit and page are passed)
		$search = Input::get('search', '');

		if ($search) {
			$branches = Branch::where('name', 'LIKE', "%$search%")->get();
			return $this->endSuccess('list', $branches->toArray());
		}

		$branches = Branch::all();
		$limit = Input::get('limit', 0);
		$page = Input::get('page', 0);

		if ($limit && $page) {
			$page = $limit*($page-1);
			$this->setData('last_page', ceil(count($branches)/$limit));
			$branches = Branch::take($limit)->skip($page)->get();
		}

		return $this->endSuccess('list', $branches->toArray());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = new BranchValidator();
		if (!$validator->passes()) return $this->endValidation($validator->errors);

		$branch = Branch::create(Input::all());
		return $this->endSuccess($branch->toArray());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$branch = Branch::find($id);
		if (is_null($branch)) return $this->endNotFound();

		return $this->endSuccess($branch->toArray());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$branch = Branch::find($id);
		if (is_null($branch)) return $this->endNotFound();

		$validator = new BranchValidator();
		$validator->rules = [
			'name'			=> "required|unique:branches,name,$id",
	        'title'			=> "required|unique:branches,title,$id"
	    ];
	    if (!$validator->passes()) return $this->endValidation($validator->errors);

	    $branch->fill(Input::all());
	    $branch->save();

	    return $this->endSuccess($branch->toArray());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$branch = Branch::find($id);
		if (is_null($branch)) return $this->endNotFound();

		$branch->delete();
		return $this->getResult();
	}

}
