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
use Twilio\Rest\Client;

class MailController extends Controller
{
    //
    public function index()
    {
        try {
            return view('backend.setting.mail');
        }catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function storeMail(Request $request)
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
            $s = Setting::where('group_name', '=', $request->get('group_name'))->pluck('value','key');
            foreach($s as $key => $item){
                    $data[strtoupper($key)]= $item;
            }
            $this->env_key_update($data);
      
            return back()->with('success', 'Information Updated!');
     
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }

    }
    public function storeSMS(Request $request)
    { 
        try {
            $request['group_name'] = 'sms_api';
            // return $request->all();
            foreach($request->all() as $key => $value){
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
            $s = Setting::where('group_name', '=', $request->get('group_name'))->pluck('value','key');
            foreach($s as $key => $item){
                $data[strtoupper($key)]= $item;
            }
            // return $data;
            $this->env_key_update($data);
    
            return back()->with('success', 'Information Updated!');
        }catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
  
    public function testSend(Request $request)
    {
        // return $request->all();
        if($request->type == 'Mail'){
            try {
                if(StaticMail('User',$request->email,'Test Mail','this is testing mail',config('app.name')) == "done")
                    return back()->with('success', 'Mail Sent!');
                else
                    return back()->with('error', 'Mail Credentails Wrong!');
            } catch (Exception $e) {
                return back()->with('error', 'Error: ' . $e->getMessage());
            }
        }
        if($request->type == 'Sms'){
            try {
                // manualSms($request->phone,"this is test message.");
                // $accountSid = getSetting('twilio_account_sid');
                // $authToken  = getSetting('twilio_auth_token');
                // $accountnumber  = getSetting('twilio_account_number');
                // $client = new Client($accountSid, $authToken);
                // $client->messages->create('+91'.$request->phone,
                //     array(
                //         'from' => $accountnumber,
                //         'body' => "this is test message."
                //     )
                // );
                return back()->with('success', 'SMS Sent!');
            } catch (Exception $e) {
                return back()->with('error', 'Error: ' . $e->getMessage());
            }
        }

    }
    
    /**
     * Update the API key's for other methods.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function env_key_update($data)
    {
        $file = DotenvEditor::load();
        foreach ($data as $key => $item){
            $file->setKey($key, $item);
        }
        $file->save();
    }

}
