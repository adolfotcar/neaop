<?php namespace App\Models\api\v1;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{

	protected $table = 'categories';

	protected $fillable = ['id', 'name', 'parent_id'];

	public static function getTree($parent_id=0, $exclude_id=0){
		$tree = [];
		$children = static::where('parent_id', $parent_id)->where('id', '<>', $exclude_id)->get();
		if (count($children)) {
			foreach ($children as $child) {
				$tree[$child->id]['data'] = $child;
				$tree[$child->id]['children'] = static::getTree($child->id, $exclude_id);
				$tree[$child->id]['count'] = count($tree[$child->id]['children']);
			}
		}
		return $tree;
	}

}
