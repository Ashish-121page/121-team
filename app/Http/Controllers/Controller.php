<?php 
/**
 *

 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\CanManageFiles;
use App\Traits\HasResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, CanManageFiles, HasResponse;

    public static function getAppDomain()
    {
        return (!in_array(\App::environment(), ['local', 'production']) ? \App::environment() . '.' : '') . 'app.' . config('app.domain');
    }

    public static function getAppUrl($path = '', $secure = false)
    {
        return ($secure ? 'https' : 'http') . '://' . static::getAppDomain() . ($path ? '/' . $path : '');
    }
}
