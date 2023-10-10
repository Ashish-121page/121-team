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

namespace App\Http\Controllers\Admin\WebsiteSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use App\Models\Setting;

class HeaderController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path =   storage_path() . "/app/public/frontend/logos/";
    }
    //

    public function index()
    {
        return view('backend.website_setup.header');
    }
    public function storeHeader(Request $request)
    {
        // return $request->all();
        try {
            if ($request->hasFile('frontend_logo')) {
                $image = $request->file('frontend_logo');
                $imageName = 'frontend-'.rand(000, 999). '.' . $image->getClientOriginalExtension();
                $image->move($this->path, $imageName);
                
                $logo = Setting::where('key', '=', 'frontend_logo')->first();
                if ($logo) {
                    unlinkfile($this->path, $logo->value);
                    $logo->value = $imageName;
                    $logo->group_name = $request->get('group_name');
                    $logo->save();
                } elseif (!$logo) {
                    $data = new Setting();
                    $data->key ='frontend_logo';
                    $data->value = $imageName;
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
        try {
            if ($request->hasFile('frontend_white_logo')) {
                $image = $request->file('frontend_white_logo');
                $imageName = 'frontend-'.rand(000, 999). '.' . $image->getClientOriginalExtension();
                $image->move($this->path, $imageName);
                
                $logo = Setting::where('key', '=', 'frontend_white_logo')->first();
                if ($logo) {
                    unlinkfile($this->path, $logo->value);
                    $logo->value = $imageName;
                    $logo->group_name = $request->get('group_name');
                    $logo->save();
                } elseif (!$logo) {
                    $data = new Setting();
                    $data->key ='frontend_white_logo';
                    $data->value = $imageName;
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        

        
        return redirect()->back()->with('success', "Information Updated!!");
    }
}
