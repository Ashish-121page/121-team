<?php

namespace App\Http\Controllers;

use App\Models\ExportTemplates;
use App\Models\Media;
use App\Models\UserCurrency;
use App\Models\UserShop;
use App\User;
use Illuminate\Http\Request;

class settingController extends Controller
{


    public function index(Request $request,$user) {

        $user = User::whereId(decrypt($user))->first();
        $templates = ExportTemplates::get();
        $user_shop = getShopDataByUserId($user->id);
        $currency_record = UserCurrency::where('user_id',$user->id)->get();
        $acc_permissions = json_decode($user->account_permission);

        // magicstring($acc_permissions);
        
        // return;

        return view("panel.settings.index",compact('templates','user','user_shop','currency_record','acc_permissions'));
    }
    
    
    public function makedefaultTemplate(Request $request,$user,$template) {

        try {            
            $templateRecord = ExportTemplates::where('id',$template)->first();
            magicstring($templateRecord);

            $templateRecord_all = ExportTemplates::where('user_id',auth()->id())->get();
            foreach ($templateRecord_all as $key => $value) {
                $value->default = 0;
                $value->save();
            }

            $templateRecord->default = 1;
            $templateRecord->save();

            return back()->with('success','Successfull');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error','Error While Updating');
        }
    }

    function uploadbanner(Request $request){

       try {
            magicstring($request->all());
            $user_id = decrypt($request->user_id);

            $chk = Media::where('type_id',$user_id)->where('type','OfferBanner')->get();
            
            if ($chk->count() == 0) {
                if($request->hasFile("offer_logo")){
                    $offer_logo = $this->uploadFile($request->file("offer_logo"), "user")->getFilePath();
                    $filename = $request->file('offer_logo')->getClientOriginalName();
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);

                    if($filename != null){
                        Media::create([
                            'type' => 'OfferBanner',
                            'type_id' => $user_id,
                            'file_name' => $filename,
                            'path' => $offer_logo,
                            'extension' => $extension,
                            'file_type' => "Image",
                            'tag' => "vcard",
                        ]);
                    }
                }
                    return back()->with('success','File Uploaded');

            }else{
                if($request->hasFile("offer_logo")){
                    $offer_logo = $this->uploadFile($request->file("offer_logo"), "user")->getFilePath();
                    $filename = $request->file('offer_logo')->getClientOriginalName();
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);

                    if($filename != null){
                    $chk[0]->path = $offer_logo;
                    $chk[0]->save();
                    }
                }
                return back()->with('success','File Updated');
            }
        }catch (\Throwable $th) {
            //throw $th;
            return back()->with('error','Error While Updating');
        }
        
        

    }


    
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


    function EditTemplate(ExportTemplates $template){

        return view('panel.settings.admin.edit-template',compact('template'));
    }




}
