<?php
/**
 * Class Brand
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
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BrandUser;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];


    public function hasAuthSeller(){
        return BrandUser::whereUserId(auth()->id())->whereBrandId($this->id)->whereType(1)->whereStatus(1)->exists();
    }

    public function hasBrandOwner(){
        return BrandUser::whereUserId(auth()->id())->whereBrandId($this->id)->whereType(0)->whereStatus(1)->exists();
    }
}
