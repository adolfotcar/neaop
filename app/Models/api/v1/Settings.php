<?php namespace App\Models\api\v1;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model {

	protected $table = 'settings';

	protected $fillable = ['title', 'last_backup'];

}
