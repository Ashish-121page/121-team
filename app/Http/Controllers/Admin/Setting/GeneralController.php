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

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Models\Setting;

class GeneralController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path =   storage_path() . "/app/public/backend/logos/";
    }

    //
    public function index()
    {
        return view('backend.setting.general');
    }
    public function storageLink()
    {
        return public_path('storage');
        // try{
        //     shell_exec('cd '.base_path().'/../public_html');
        //     shell_exec('rm storage');
        //     File::link(storage_path('app/public'), public_path('storage'));

        //     ini_set('memory_limit', '-1');
        //     ini_set('max_execution_time', 1000);

        //     return back()->with('success','Storage linked Successfully!');
        // }catch(\Exception $e){
        //     return back()->with('error', 'Error: ' . $e->getMessage());
        // }
    }
    public function OptimizeClear()
    {
        try{            
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            return back()->with('success','Optimization Cleared!');
        }catch(\Exception $e){
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function backup()
    {
        // return $request->all();
        try{            
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            return back()->with('success','Backup has been taken successfully!');
        }  catch(\Exception $e){
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function storeGeneral(Request $request)
    {
        // return $request->all();
        
        
        try {
            foreach($request->all() as $key => $value) {
                if ($key != '_token' && $key != 'group_name'){
                    if(!$request->hasFile($key)){
                        $setting = Setting::where('key', '=', $key)->first();
                        if ($setting) {
                            $setting->value = $value;
                            $setting->group_name = $request->get('group_name');
                            $setting->save();
                        }else{
                            $data = new setting();
                            $data->key = $key;
                            $data->value = $value;
                            $data->group_name = $request->get('group_name');
                            $data->save();
                        }
                    }
                }
            }

            if ($request->has('app_name')) {
                $this->single_env_key_update('APP_NAME',$request->get('app_name'));
            }
       
            if ($request->has('app_url')) {
                $this->single_env_key_update('APP_URL',$request->get('app_url'));
            }
       
            if ($request->hasFile('app_logo')) {
                $image = $request->file('app_logo');
                $imageName = 'logo-'.rand(000, 999). '.' . $image->getClientOriginalExtension();
                $image->move($this->path, $imageName);
                
                $logo = Setting::where('key', '=', 'app_logo')->first();
                if ($logo) {
                    unlinkfile(substr($this->path, 0, -1), $logo->value);
                    $logo->value = $imageName;
                    $logo->group_name = $request->get('group_name');
                    $logo->save();
                } elseif (!$logo) {
                    $data = new Setting();
                    $data->key ='app_logo';
                    $data->value = $imageName;
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
      
            if ($request->hasFile('app_white_logo')) {
                $wimage = $request->file('app_white_logo');
                $wimageName = 'white-logo-'.rand(000, 999). '.' . $wimage->getClientOriginalExtension();
                $wimage->move($this->path, $wimageName);
                
                $logo = Setting::where('key', '=', 'app_white_logo')->first();
                if ($logo) {
                    unlinkfile(substr($this->path, 0, -1), $logo->value);
                    $logo->value = $wimageName;
                    $logo->group_name = $request->get('group_name');
                    $logo->save();
                } elseif (!$logo) {
                    $data = new Setting();
                    $data->key ='app_white_logo';
                    $data->value = $wimageName;
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
       
            if ($request->hasFile('app_favicon')) {
                $fimage = $request->file('app_favicon');
                $fimageName = 'favicon-'.rand(000, 999). '.' . $fimage->getClientOriginalExtension();
                $fimage->move($this->path, $fimageName);
                
                $logo = Setting::where('key', '=', 'app_favicon')->first();
                if ($logo) {
                    unlinkfile(substr($this->path, 0, -1), $logo->value);
                    $logo->value = $fimageName;
                    $logo->group_name = $request->get('group_name');
                    $logo->save();
                } elseif (!$logo) {
                    $data = new Setting();
                    $data->key ='app_favicon';
                    $data->value = $fimageName;
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        
            if ($request->hasFile('app_banner')) {
                $bimage = $request->file('app_banner');
                $bimageName = 'banner-'.rand(000, 999). '.' . $bimage->getClientOriginalExtension();
                $bimage->move($this->path, $bimageName);
                
                $logo = Setting::where('key', '=', 'app_banner')->first();
                if ($logo) {
                    unlinkfile(substr($this->path, 0, -1), $logo->value);
                    $logo->value = $bimageName;
                    $logo->group_name = $request->get('group_name');
                    $logo->save();
                } elseif (!$logo) {
                    $data = new Setting();
                    $data->key ='app_banner';
                    $data->value = $bimageName;
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
            if ($request->hasFile('app_banner_i')) {
                $bimage = $request->file('app_banner_i');
                $bimageName = 'banner-'.rand(000, 999). '.' . $bimage->getClientOriginalExtension();
                $bimage->move($this->path, $bimageName);
                
                $logo = Setting::where('key', '=', 'app_banner_i')->first();
                if ($logo) {
                    unlinkfile(substr($this->path, 0, -1), $logo->value);
                    $logo->value = $bimageName;
                    $logo->group_name = $request->get('group_name');
                    $logo->save();
                } elseif (!$logo) {
                    $data = new Setting();
                    $data->key ='app_banner_i';
                    $data->value = $bimageName;
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
            
            return redirect()->back()->with('success', "Information Updated!!");
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }

    }

    
    public function storeCurrency(Request $request)
    {
        try {
            foreach($request->all() as $key => $value) {
                if($key != '_token' && $key != 'group_name'){
                    $setting = Setting::where('key', '=', $key)->first();
                    if ($setting) {
                        $setting->value = $value;
                        $setting->group_name = $request->get('group_name');
                        $setting->save();
                    }else{
                        $data = new setting();
                        $data->key = $key;
                        $data->value = $value;
                        $data->group_name = $request->get('group_name');
                        $data->save();
                    }
                }
            }
            return redirect()->back()->with('success', "Information Updated!!");
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }       

    }

    public function storeDnT(Request $request)
    {
        // return $request->all();
        
        try {
            foreach($request->all() as $key => $value) {
                if($key != '_token' && $key != 'group_name'){
                    $setting = Setting::where('key', '=', $key)->first();
                    if ($setting) {
                        $setting->value = $value;
                        $setting->group_name = $request->get('group_name');
                        $setting->save();
                    }else{
                        $data = new setting();
                        $data->key = $key;
                        $data->value = $value;
                        $data->group_name = $request->get('group_name');
                        $data->save();
                    }
                }
            }
            if($request->has('time_zone')){
               $this->single_env_key_update('TIME_ZONE', $request->get('time_zone'));
            }
            return redirect()->back()->with('success', "Information Updated!!");
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
    }
    public function storePlugin(Request $request)
    {
        // return $request->all();
        
        try {
            foreach($request->all() as $key => $value) {
                if($key != '_token' && $key != 'group_name'){
                    $setting = Setting::where('key', '=', $key)->first();
                    if ($setting) {
                        $setting->value = $value;
                        $setting->group_name = $request->get('group_name');
                        $setting->save();
                    }else{
                        $data = new setting();
                        $data->key = $key;
                        $data->value = $value;
                        $data->group_name = $request->get('group_name');
                        $data->save();
                    }
                }
            }
            return redirect()->back()->with('success', "Information Updated!!");
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
    }

    public function storeVerification(Request $request){
        // return $request->all();
       try{
            foreach($request->all() as $key => $value) {
                if($key != '_token' && $key != 'group_name'){
                    $setting = Setting::where('key', '=', $key)->first();
                    if ($setting) {
                        $setting->value = $value;
                        $setting->group_name = $request->get('group_name');
                        $setting->save();
                    }else{
                        $data = new setting();
                        $data->key = $key;
                        $data->value = $value;
                        $data->group_name = $request->get('group_name');
                        $data->save();
                    }
                }
            }
            return back()->with('success', 'Information Updated!');
       }catch (\Exception $e) {
           return back()->with('error', 'Error: ' . $e->getMessage());
       }
    }

    public function single_env_key_update($key, $value)
    {
        $file = DotenvEditor::load();
            $file->setKey($key, $value);
        $file->save();
    }
}
