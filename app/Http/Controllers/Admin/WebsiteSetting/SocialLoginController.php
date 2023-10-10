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
use App\Models\Setting;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class SocialLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return 's';
        return view('backend.website_setup.social-login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        try {
            $activekeys = ['facebook_login_active','google_login_active','linkedin_login_active','twitter_login_active'];
            $keys =['facebook_client_id','facebook_client_secret','google_client_id','google_client_secret','linkedin_client_id','linkedin_client_secret','twitter_client_id','twitter_client_secret'];
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
                $data[strtoupper($key)]= $item;
            }
            // return $data;
            $this->env_key_update($data);
            return back()->with('success','Information Updated!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
