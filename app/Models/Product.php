<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function varient_products(){
        return Product::where('sku',$this->sku)->where('is_publish',1)->get();
    }
    
    public function product_items(){
        return $this->hasMany(UserShopItem::class);
    }
    
    public function inventory() {
        return $this->hasMany(Inventory::class);
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function subcategory(){
        return $this->belongsTo(Category::class,'sub_category','id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function medias(){
        return $this->hasMany(Media::class,'type_id','id')->where('type',"Product")->orderBy('created_at');
    }


    

    
    
}
