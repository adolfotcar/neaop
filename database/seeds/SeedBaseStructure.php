<?php

use App\Models\api\v1\User;
use App\Models\api\v1\Uri;
use App\Models\api\v1\Role;
use App\Models\api\v1\Settings;
use App\Models\api\v1\Branch;
use App\Models\api\v1\RolePermission;
use App\Models\api\v1\AllowedApp;

use Illuminate\Database\Seeder;

class SeedBaseStructure extends Seeder {

	public function run(){
		User::where('email', 'adolfotcar@gmail.com')->forceDelete();
		User::where('email', 'antonobar@yahoo.com.br')->forceDelete();
		Branch::where('name', 'Matrix')->delete();
		Role::where('name', 'developer')->forceDelete();
		Settings::where('id', 1)->delete();

		$matrix = Branch::create([
				"name"	=> "Matrix",
				"title" => "Matrix"
			]);
		
		$adolfo = 	User::create([
						"email"		=>	"adolfotcar@gmail.com",
						"password"	=> Hash::make('arildo10'),
						"name"		=> "Adolfo",
						"surname"	=>	"Carvalho",
						"language"	=>	"en",
						"branch_id"	=>	$matrix->id
					]);
		$antonio =	User::create([
						"email"		=>	"antonobar@yahoo.com.br",
						"password"	=> Hash::make('rrua123'),
						"name"		=> "Antonio",
						"surname"	=>	"Barbosa",
						"language"	=>	"pt-br",
						"branch_id"	=>	$matrix->id
					]);

		$appToken = Hash('sha1', date('y-m-d G:i:s').rand(0, 100));
		echo "The token for your app is: $appToken\n";
		AllowedApp::create([
				"name"				=>	"local",
				"allowed_origin"	=>	Request::server('SERVER_NAME'),
				"token"				=>	$appToken
			]);
		
		Role::where('name', 'developer')->forceDelete();
		$developer = Role::create(["name"=> "developer"]);

		$adolfo->roles()->attach($developer);
		$antonio->roles()->attach($developer);

		$uriAll = Uri::create(['uri' => '*', 'friendly' => '*']);

		RolePermission::create([
				"role_id"		=> $developer->id,
				"uri_id"		=> $uriAll->id,
				"method"		=> "*"
			]);

		Settings::create(['title'=>'Ne-aop']);
	}
}