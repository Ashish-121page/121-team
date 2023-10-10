<?php 
/**
 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';
    protected $guarded = [];


    public function categories()
    {
        return $this->hasMany(CourseCategory::class, 'parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(CourseCategory::class, 'parent_id')->with('categories');
    }

    public function parentCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'parent_id');
    }
}
