<?php namespace App\Http\Controllers\api\v1;

use Input;
use App\Models\api\v1\Settings;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SettingsController extends V1Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//for instance only one row of the settings table will be used
		$settings = Settings::find(1);
		if (is_null($settings)) return $this->endNotFound('critical_error_no_settings');
		$settings->last_backup = new \DateTime($settings->last_backup);
		$settings->last_backup = $settings->last_backup->format('U');
		$this->setData($settings->toArray());
		return $this->getResult();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$settings = Settings::find(1);
		if (is_null($settings)) return $this->endNotFound('critical_error_no_settings');
		$settings->title = Input::get('title');
		$settings->save();
		$this->setData($settings->toArray());
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
