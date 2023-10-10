<?php
/**
 * Class UserShopItem
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link        https://121.page/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserShopItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'user_shop_items';

    protected $dates = ['deleted_at'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function products(){
        return $this->hasMany(Product::class,'id','product_id')->groupBy('sku');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function subcategory(){
        return $this->hasMany(CategoryType::class,'id','sub_category_id');
    }
    public function scopeWithAndWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
                    ->with([$relation => $constraint]);
    }
}
