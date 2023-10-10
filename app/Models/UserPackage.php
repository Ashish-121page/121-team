<?php
/**
 * Class UserPackage
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
use App\Models\Package;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPackage extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];

    public function package(){
        return $this->belongsTo(Package::class,'package_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'id');
    }
    public function userShop(){
        return $this->belongsTo(UserShop::class,'user_id','user_id');
    }
}
