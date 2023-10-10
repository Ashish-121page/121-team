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
use App\Models\Setting;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class PaymentSettingController extends Controller
{
    //
    public function index()
    {
        return view('backend.setting.payment');
    }
   
    public function storePayment(Request $request)
    {
        try {
            $activekeys = ['services_stripe_active','services_paypal_active','services_razor_pay_active','services_offline_active'];
            $keys =['api_stripe_key','api_stripe_secret','api_paypal_key','api_paypal_secret','api_razor_key','api_razor_secret','payment_offline_instruction'];
                
            foreach($keys as $key){
                $setting = Setting::where('key', '=', $key)->first();
                if ($setting) {
                    $setting->value = $request->get($key);
                    $setting->group_name = $request->get('group_name');
                    $setting->save();
                }else{
                    $data = new setting();
                    $data->key = $key;
                    $data->value = $request->get($key);
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
            foreach($activekeys as $active){
                $setting = Setting::where('key', '=', $active)->first();
                if ($setting) {
                    $setting->value = $request->get($active) ?? 0;
                    $setting->group_name = $request->get('group_name').'_active';
                    $setting->save();
                }else{
                    $data = new setting();
                    $data->key = $active;
                    $data->value = $request->get($active) ?? 0;
                    $data->group_name = $request->get('group_name').'_active';
                    $data->save();
                }
            }

            $s = Setting::where('group_name', '=', $request->get('group_name'))->pluck('value','key');
            foreach($s as $key => $item){
                if($key != 'payment_offline_instruction'){
                    $data[strtoupper($key)]= $item;
                }
            }
            $this->env_key_update($data);
      
            return redirect()->back()->with('success', "Information Updated!!");
    
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function env_key_update($data)
    {
        $file = DotenvEditor::load();
        foreach ($data as $key => $item){
            $file->setKey($key, $item);
        }
        $file->save();
    }

}
