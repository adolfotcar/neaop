<?php

use App\Models\api\v1\Uri;
use App\Models\api\v1\Module;

use Illuminate\Database\Seeder;

class SeedUris extends Seeder {

	public function run(){
		$uri = Uri::firstOrCreate(['uri' => '/user', 'friendly' => 'USERS_OWN']);
		$module = Module::firstOrCreate(['url' => '/user']);

		$uri = Uri::firstOrCreate(['uri' => '/users', 'friendly' => 'USERS']);
		$module = Module::firstOrCreate(['url' => '/users']);

		$uri = Uri::firstOrCreate(['uri' => '/roles', 'friendly' => 'ROLES']);
		$module = Module::firstOrCreate(['url' => '/roles']);

		$uri = Uri::firstOrCreate(['uri' => '/roles/*/users', 'friendly' => 'ROLES_USERS']);
		$module = Module::firstOrCreate(['url' => '/roles/*/users']);

		$uri = Uri::firstOrCreate(['uri' => '/roles/*/permissions', 'friendly' => 'ROLES_PERMISSIONS']);
		$module = Module::firstOrCreate(['url' => '/roles/*/permissions']);

		$uri = Uri::firstOrCreate(['uri' => '/settings', 'friendly' => 'SETTINGS']);
		$module = Module::firstOrCreate(['url' => '/settings']);

		$uri = Uri::firstOrCreate(['uri' => '/customers', 'friendly' => 'CUSTOMERS']);
		$module = Module::firstOrCreate(['url' => '/customers']);

		$uri = Uri::firstOrCreate(['uri' => '/branches', 'friendly' => 'BRANCHES']);
		$module = Module::firstOrCreate(['url' => '/branches']);

	}
}