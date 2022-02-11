<?php namespace App\Models\api\v1;

use Illuminate\Database\Eloquent\Model;
use App\Models\api\v1\Uri;

class Module extends Model {

	public $timestamps = false;

	public static function isUriValid($uri) {
		$uri = Uri::find($uri);
		if (is_null($uri)) return false;

		$module = static::where('url', $uri->uri)->first();
		return !is_null($module);
	}

}
