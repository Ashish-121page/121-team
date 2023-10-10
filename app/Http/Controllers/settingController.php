<?php

namespace App\Http\Controllers;

use App\Models\UserShop;
use App\User;
use Illuminate\Http\Request;

class settingController extends Controller
{

    function Update(Request $request) {
        // magicstring($request->all());
        // return;
        try {
            $update_type = $request->get('type');
            $user_shop = $request->get('user_shop');

            if ($update_type == 'setting1') {
                // magicstring($request->all());
                $chk_slug = UserShop::where('slug',$request->get('slug'))->where('id',"!=",$user_shop)->get();

                
                if (count($chk_slug) != 0) {
                    return back()->with("error","Slug Name Already Taken");
                }else{   
                    $shop_data = UserShop::find($user_shop);
                    $shop_data->slug = $request->get('slug');
                    $shop_data->auto_acr = $request->get('auto_acr');
                    $shop_data->shop_view = $request->get('shop_view');

                    $temdata = json_decode($shop_data->team);
                    if ($temdata != null) {
                        $visiblity = ["team_visiblity" => $request->public_about ?? 0,"title" => $temdata->title ?? "Team" , "description" => "","manage_offer_guest" => $request->shop_view_guest ?? 0 , "manage_offer_verified" => $request->shop_view_login ?? 0];
                    }else{
                        $visiblity = ["team_visiblity" => $request->public_about ?? 0,"title" => "Team" , "description" => "","manage_offer_guest" => 0, "manage_offer_verified" => ""];
                    }
                    
                    $shop_data->team = json_encode($visiblity);
                    $shop_data->save();
                    // magicstring($shop_data);

                    return back()->with("success","Setting Updated !");
                }
            }


            if ($update_type == 'setting2') {
                magicstring($request->all());
                $usr_shop = UserShop::where('id',$user_shop)->first();

                // All The Extra pascode That Are Updating
                $extra_passcode = json_encode(["offers_passcode" => $request->get('offers_passcode'),"reseller_pass" => $request->get('reseller_pass'),"vip_pass" => $request->vip_pass ]);

                $user_data = User::find($usr_shop->user_id);
                $user_data->exclusive_pass = $request->get('exclsive_pass');                
                $user_data->extra_passcode = $extra_passcode;                
                
                $user_data->save();
                return back()->with("success","Passcode Updated !");
                
                magicstring($extra_passcode);
            }           
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->with("error","Cannot Update ".$th);
        }





    }



}
