<?php
/**
 * Class PriceAskRequest
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

class PriceAskRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];

    public function items(){
        return $this->hasMany(PriceAskItem::class);
    }
    public function latest_item(){
        return $this->hasOne(PriceAskItem::class)->latest();
    }
}
