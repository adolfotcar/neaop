<?php namespace App\Http\Controllers\api\v1;

use Input;

use App\Http\Requests;
use App\Models\api\v1\Category;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CategoryController extends V1Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tree = Category::getTree();
		$this->setData($tree);
		return $this->getResult();

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tree = Category::getTree();
		return $this->endSuccess('categories', $tree);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$category = new Category(Input::all());
		$category->save();

		$parentName = '';
		if ($category->parent_id) {
			$parent = Category::find($category->parent_id);
			$parentName = $parent->name;
		}

		$this->setData($category->toArray());
		$this->setData('parent_name', $parentName);
		$tree = Category::getTree(0, $category->id);
		$this->setData('categories', $tree);
		return $this->getResult();	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$category = Category::find($id);
		if (is_null($category)) return $this->endNotFound('category_not_found');

		$parentName = '';
		if ($category->parent_id) {
			$parent = Category::find($category->parent_id);
			$parentName = $parent->name;
		}

		$this->setData($category->toArray());
		$this->setData('parent_name', $parentName);
		$tree = Category::getTree(0, $category->id);
		$this->setData('categories', $tree);
		return $this->getResult();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$category = Category::find($id);
		if (is_null($category)) return $this->endNotFound('category_not_found');

		$category->fill(Input::all());
		$category->save();

		$parentName = '';
		if ($category->parent_id) {
			$parent = Category::find($category->parent_id);
			$parentName = $parent->name;
		}

		$this->setData($category->toArray());
		$this->setData('parent_name', $parentName);
		$tree = Category::getTree(0, $category->id);
		$this->setData('categories', $tree);
		return $this->getResult();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
