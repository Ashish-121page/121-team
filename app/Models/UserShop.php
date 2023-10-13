<?php
/**
 * Class UserShop
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
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserShop extends Model
{
    use HasFactory;
    // use SoftDeletes;
    
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
