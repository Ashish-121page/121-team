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

class AppearanceController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path =   storage_path() . "/app/public/backend/logos/";
    }
    //
    public function index()
    {
        return view('backend.website_setup.appearance');
    }

    public function storeTheme(Request $request)
    {
        // return $request->all();
        try {
            foreach ($request->all() as $key => $value) {
                if ($key != '_token' && $key != 'group_name') {
                    if (!$request->hasFile($key)) {
                        $setting = Setting::where('key', '=', $key)->first();
                        if ($setting) {
                            $setting->value = $value;
                            $setting->group_name = $request->get('group_name');
                            $setting->save();
                        } else {
                            $data = new setting();
                            $data->key = $key;
                            $data->value = $value;
                            $data->group_name = $request->get('group_name');
                            $data->save();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        

        return redirect()->back()->with('success', "Information Updated!!");
    }

    public function storeSeo(Request $request)
    {
        // return $request->all();
        try {
            foreach ($request->all() as $key => $value) {
                if ($key != '_token' && $key != 'group_name') {
                    if (!$request->hasFile($key)) {
                        $setting = Setting::where('key', '=', $key)->first();
                        if ($setting) {
                            $setting->value = $value;
                            $setting->group_name = $request->get('group_name');
                            $setting->save();
                        } else {
                            $data = new setting();
                            $data->key = $key;
                            $data->value = $value;
                            $data->group_name = $request->get('group_name');
                            $data->save();
                        }
                    }
                }
            }
            if ($request->hasFile('seo_meta_image')) {
                $image = $request->file('seo_meta_image');
                $imageName = 'seo_meta_image-'.rand(000, 999). '.' . $image->getClientOriginalExtension();
                $image->move($this->path, $imageName);
                
                $logo = Setting::where('key', '=', 'seo_meta_image')->first();
                if ($logo) {
                    unlinkfile($this->path, $logo->value);
                    $logo->value = $imageName;
                    $logo->group_name = $request->get('group_name');
                    $logo->save();
                } elseif (!$logo) {
                    $data = new Setting();
                    $data->key ='seo_meta_image';
                    $data->value = $imageName;
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
            return redirect()->back()->with('success', "Information Updated!!");
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function storeCookies(Request $request)
    {
        // return $request->all();
        try {
            if ($request->has('cookies_agreement_text')) {
                $cookies_agreement_text = Setting::where('key', '=', 'cookies_agreement_text')->first();
                if ($cookies_agreement_text) {
                    $cookies_agreement_text->value = $request->get('cookies_agreement_text');
                    $cookies_agreement_text->group_name = $request->get('group_name');
                    $cookies_agreement_text->save();
                } else {
                    $data = new setting();
                    $data->key = 'cookies_agreement_text';
                    $data->value = $request->get('cookies_agreement_text');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
       
            if ($request->has('show_cookies_agreement')) {
                $show_cookies_agreement = Setting::where('key', '=', 'show_cookies_agreement')->first();
                if ($show_cookies_agreement) {
                    $show_cookies_agreement->value = $request->get('show_cookies_agreement');
                    $show_cookies_agreement->group_name = $request->get('group_name');
                    $show_cookies_agreement->save();
                } else {
                    $data = new setting();
                    $data->key = 'show_cookies_agreement';
                    $data->value = $request->get('show_cookies_agreement');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
            
            return redirect()->back()->with('success', "Information Updated!!");
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function storeCustomStyles(Request $request)
    {
        // return $request->all();
        try {
            if ($request->has('custom_header_style')) {
                $custom_header_style = Setting::where('key', '=', 'custom_header_style')->first();
                if ($custom_header_style) {
                    $custom_header_style->value = $request->get('custom_header_style');
                    $custom_header_style->group_name = $request->get('group_name');
                    $custom_header_style->save();
                } else {
                    $data = new setting();
                    $data->key = 'custom_header_style';
                    $data->value = $request->get('custom_header_style');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
        try {
            if ($request->has('custom_footer_style')) {
                $custom_footer_style = Setting::where('key', '=', 'custom_footer_style')->first();
                if ($custom_footer_style) {
                    $custom_footer_style->value = $request->get('custom_footer_style');
                    $custom_footer_style->group_name = $request->get('group_name');
                    $custom_footer_style->save();
                } else {
                    $data = new setting();
                    $data->key = 'custom_footer_style';
                    $data->value = $request->get('custom_footer_style');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', "Information Updated!!");
    }
    public function storeCustomScript(Request $request)
    {
        // return $request->all();
        try {
            if ($request->has('custom_header_script')) {
                $custom_header_script = Setting::where('key', '=', 'custom_header_script')->first();
                if ($custom_header_script) {
                    $custom_header_script->value = $request->get('custom_header_script');
                    $custom_header_script->group_name = $request->get('group_name');
                    $custom_header_script->save();
                } else {
                    $data = new setting();
                    $data->key = 'custom_header_script';
                    $data->value = $request->get('custom_header_script');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
        try {
            if ($request->has('custom_footer_script')) {
                $custom_footer_script = Setting::where('key', '=', 'custom_footer_script')->first();
                if ($custom_footer_script) {
                    $custom_footer_script->value = $request->get('custom_footer_script');
                    $custom_footer_script->group_name = $request->get('group_name');
                    $custom_footer_script->save();
                } else {
                    $data = new setting();
                    $data->key = 'custom_footer_script';
                    $data->value = $request->get('custom_footer_script');
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
