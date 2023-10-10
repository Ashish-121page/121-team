<?php
/**
 * @Developer Ashish
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link https://121.page/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalItem extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $fillable = [
        'proposal_id','product_id','user_shop_item_id','price','user_id','sequence','margin'
    ];
    
}
