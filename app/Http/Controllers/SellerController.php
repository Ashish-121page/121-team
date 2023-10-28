<?php

namespace App\Http\Controllers;
use App\Models\UserShop;     
use App\Models\AccessCatalogueRequest;     
use App\Models\UserEnquiry;
use App\Models\MailSmsTemplate;
use App\Models\Brand;
use App\Models\Product;
use App\Models\UserShopItem;
use App\User;
use App\Models\Category;
use App\Models\CustomAttributes;
use App\Models\Group;
use App\Models\inventory;
use App\Models\LockEnquiry;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductExtraInfo;
use App\Models\Proposal;
use App\Models\ProposalItem;
use App\Models\Setting;
use App\Models\Team;
use App\Models\TimeandActionModal;
use BaconQrCode\Encoder\QrCode;
use Carbon\Carbon;
use Defuse\Crypto\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File as FacadesFile;
use League\CommonMark\Extension\Table\Table;
use ZipArchive;

class SellerController extends Controller
{
    
    public function supplierIndex()
    {
        $pending_requests = AccessCatalogueRequest::whereNumber(auth()->user()->phone)->whereStatus(0)->latest()->get(); 
        return view('backend.seller.supplier',compact('pending_requests'));
    }
    public function mySupplierIndex()
    {
        if(AuthRole() == "User"){
            $accepted_requests_paginate = AccessCatalogueRequest::whereUserId(auth()->user()->id)->whereStatus(1)->latest()->paginate(10); 
            $requests = $accepted_requests_paginate;
            return view('backend.seller.my_supplier',compact('requests'));
        }else{
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exploreIndex()
    {
        if(AuthRole() == "User"){
            $verifyed_brands = Brand::whereStatus(1)->where('is_verified',1)->paginate(10);
            $slug = UserShop::whereUserId(auth()->id())->first()->slug ?? ''; 
            return view('backend.seller.explore',compact('slug','verifyed_brands'));
        }else{
            abort(401);
        }
    }


    public function requestIndex()
    {
       $pending_requests = AccessCatalogueRequest::whereUserId(auth()->id())->whereStatus(0)->latest()->paginate(10); 
    //    $pending_requests = AccessCatalogueRequest::paginate(50); 
       return view('backend.seller.request',compact('pending_requests'));
    }
    

    public function requestSendReminder(Request $request,$id)
    { 

        $pending_requests = AccessCatalogueRequest::whereId($id)->first();

        if($pending_requests->send_times >= 5){
            return back()->with('error','You cannot request more than 5 times');
        }else{
            $pending_requests->increment('send_times',1);
        }
 
        $user = User::whereId($pending_requests->user_id)->first();
        $guest_name = $pending_requests->supplier_name ?? 'Guest';

         $reminder_sent_seller = User::wherePhone($pending_requests->number)->first();
        $mailcontent_data = MailSmsTemplate::where('code','=',"send-reminder")->first();

            if($mailcontent_data){
                $arr=[
                    '{name}'=>$user->name ?? $guest_name,
                    '{sender}'=>auth()->user()->name,
                    ];
                TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button = null);
            }

            if($reminder_sent_seller){
                $onsite_notification['user_id'] =  $reminder_sent_seller->id;
                $onsite_notification['title'] = "$user->name has sent you a reminder to accept their request to access the catalogue items in your shop." ;
                $onsite_notification['link'] = "#";
                pushOnSiteNotification($onsite_notification);
            }
            return back()->with('success','Reminder Send Successfully!');

    }

    public function ignoreIndex()
    {
        $ignore_requests = AccessCatalogueRequest::whereNumber(auth()->user()->phone)->whereStatus(3)->paginate(9); 
        return view('backend.seller.ignore',compact('ignore_requests'));
    }
    public function myResellerIndex()
    {
        if(AuthRole() == 'User'){
            $my_resellers = AccessCatalogueRequest::whereNumber(auth()->user()->phone)->whereStatus(1)->paginate(9); 
            return view('backend.seller.my-reseller',compact('my_resellers'));
        }else{
            abort(401);
        }
    }


    public function ashish(Request $request)
    {        


        $name = "Default Template";

        echo json_encode(
            [
                'name' => $name
            ]
        );


        

        // echo "Test Function <br><br><br>";
        // $user = auth()->user();
        // magicstring(session()->all());



        // $costPrice = 500;
        // $exchangePrice = 0;

        // echo "Old exchange Price Is $exchangePrice".newline();
        // echo "Old Cost Price Is $costPrice".newline(3);

        // $doller = 85;
        // $homecr = 1;

        // $diffrence = $homecr / $doller;

        
        // $exchangePrice = $costPrice*$diffrence  ;

        // echo "New exchange Price Is $exchangePrice".newline();
        // echo "New Cost Price Is $costPrice".newline(3);
        


        
        // return view('devloper.ashish.index',compact('msg','code'));
    }



    public function userEnquiryIndex()
    {
        $user_shop_id = UserShop::where('user_id',auth()->id())->firstOrFail();
        $seller_enquiries = UserEnquiry::where('type_id',$user_shop_id->id)->paginate(9);
        return view('backend.seller.user-enquiry.index',compact('seller_enquiries'));
    }
    public function userEnquiryEdit($id)
    {
        $user_shop_id = UserShop::where('user_id',auth()->id())->firstOrFail();
        $seller_enquiries = UserEnquiry::where('type_id',$user_shop_id->id)->whereId($id)->first();
        return view('backend.seller.user-enquiry.edit',compact('seller_enquiries'));
    }
    public function updateEnquiry(Request $request,$id)
    {
        $user_enquiry =  UserEnquiry::whereId($id)->first();
        
        try{
        
        $user_enquiry->name  = $request->name;   
        $user_enquiry->status  = $request->status;   
        $user_enquiry->email  = $request->email;   
        $user_enquiry->subject  = $request->subject;   
        $user_enquiry->description  = $request->description; 
        
        $user_enquiry->save();
        return redirect(route('panel.seller.enquiry.index'))->with('success','User Enquiry Updated Successfully!');

       } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function updateRequestStatus(Request $request)
    {
        $id = $request->request_id;
        $catalogue_requests = AccessCatalogueRequest::whereId($id)->first();
        $catalogue_requests->update([
            'price_group_id' => $request->price_group_id
        ]);
        $user = User::whereId($catalogue_requests->user_id)->first();
        $seller_record = User::wherePhone($catalogue_requests->number)->first();
        //  Accepted
         if ($request->status == 1) {
            $catalogue_requests->update([
                'status' => 1,
             ]);
             if($user){
                 $mailcontent_data = MailSmsTemplate::where('code','=',"catalogue-request-accepted")->first();
                 if($mailcontent_data){
                     $arr=[
                         '{user_name}'=>$user->name,
                         '{seller_name}'=>$seller_record->name,
                         '{catalogue_id}'=>$catalogue_requests->id,
                         ];
                     TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button = null);
                 }
                // // Assign Price Group
                // if($request->price_group_id != null){
                //     $price_group_name = fetchFirst('App\Models\Group',$catalogue_requests->price_group_id,'name');
                //     $onsite_notification['user_id'] =  $user->id;
                //     $onsite_notification['title'] = $seller_record->name. " has assign you the price group of $price_group_name " ;
                //     $onsite_notification['link'] = '#';
                //     pushOnSiteNotification($onsite_notification);
                // }

                //  Request Catalogue Accepted 
                $onsite_notification['user_id'] =  $user->id;
                $onsite_notification['title'] = $seller_record->name. " has accepted your catalogue request. " ;
                $onsite_notification['link'] = route('panel.seller.my_supplier.index');
                pushOnSiteNotification($onsite_notification);
             }
             return back()->with('success', 'Catalogue request accepted successfully!');
         }
        //  Rejected
         if ($request->status == 2) {
            $catalogue_requests->update([
                 'status' => 2,
             ]);
             //  Request Catalogue Accepted 
             $onsite_notification['user_id'] =  $user->id;
             $onsite_notification['title'] = $seller_record->name. " has rejected your catalogue request. " ;
             $onsite_notification['link'] = '#';
             pushOnSiteNotification($onsite_notification);
             return back()->with('success', 'Catalogue request rejected successfully!');
         }
         //  Ignored
         elseif ($request->status == 3) {
             $catalogue_requests->update([
                 'status' => 3,
             ]);
             //  Request Catalogue Accepted 
            //  $onsite_notification['user_id'] =  $user->id;
            //  $onsite_notification['title'] = $seller_record->name. " has ignored your catalogue request. " ;
            //  $onsite_notification['link'] = '#';
            //  pushOnSiteNotification($onsite_notification);
             return back()->with('success', 'Catalogue request ignored successfully!');
         } 
         //  Connect Only
         elseif ($request->status == 4) {
             $catalogue_requests->update([
                 'status' => 4,
             ]);
             //  Request Catalogue Accepted 
             $onsite_notification['user_id'] =  $user->id;
             $onsite_notification['title'] = $seller_record->name. " has making this request connect. " ;
             $onsite_notification['link'] = '#';
             pushOnSiteNotification($onsite_notification);
             return back()->with('success', 'Catalogue connect request sent successfully!');
         } 
        //  Pending/Recovered
         elseif ($request->status == 0) {
            $catalogue_requests->update([
                 'status' => 0,
             ]);
             //  Request Catalogue Accepted 
             $onsite_notification['user_id'] =  $user->id;
             $onsite_notification['title'] = $seller_record->name. " has Recovered your catalogue request. " ;
             $onsite_notification['link'] = '#';
             pushOnSiteNotification($onsite_notification);
             return back()->with('success', 'Catalogue request recovered successfully!');
         }
          
    }
    public function updatePriceGroup(Request $request)
    {
        $id = $request->request_id;
        $catalogue_requests = AccessCatalogueRequest::whereId($id)->first();
        $catalogue_requests->update([
            'price_group_id' => $request->price_group_id
        ]);
        $user = User::whereId($catalogue_requests->user_id)->first();
        $user_shop = UserShop::where('user_id',auth()->user()->id)->first()->id;


        $seller_record = User::wherePhone($catalogue_requests->number)->first();

        $items = UserShopItem::where('user_id',$user->id)->where('parent_shop_id',$user_shop)->get();
            
        foreach($items as $item){
             // Unpublish all sellers who has this product
             $item->is_published = 0;
             $item->save();
        }

        //  Accepted
         if ($catalogue_requests->status == 1) {
             if($user){
               
                // Assign Price Group
                if($request->price_group_id != null){
                    $price_group_name = fetchFirst('App\Models\Group',$catalogue_requests->price_group_id,'name');
                    $onsite_notification['user_id'] =  $user->id;
                    // $onsite_notification['title'] = $seller_record->name. " has assign you the price group of $price_group_name , All Products are Unpublished" ;
                    $onsite_notification['title'] = $seller_record->name. " has Changed your price group So, All Products are Unpublished" ;
                    $onsite_notification['link'] = '#';
                    pushOnSiteNotification($onsite_notification);
                }    
             }

             return back()->with('success', 'Price Group Updated successfully!');

         }
       
        
          
    }
    public function updateSiteName(Request $request,$id)
    {
        // return $request->all();
        $this->validate($request,[
            'shop_name'     => 'required|unique:user_shops,slug,'.$id,
        ]);
        
            $user_shop = UserShop::whereId($id)->first();
            $user_shop_name = UserShop::whereSlug($request->shop_name)->first();
            if ($user_shop_name) {
                return back()->with('error', 'You can not use this site slug');
            } else {
                $user_shop->update([
                   'slug' => $request->shop_name,
                ]);
                return back()->with('success', 'Your Site name updated successfully!');
            }
            
    }
          
    public function requestCatalogue(Request $request)
    {
        //  return $request->all();

        //  $number = implode('',$request->phone);
        $number = $request->phone;
        if($number == auth()->user()->phone){
            return redirect()->back()->withInput()->with('error', 'Requests cannot be sent to your own number');
        }
        $user = User::where('id','!=',auth()->id())->where('phone',$number)->first();
    
        if(!$user){
            $user = User::where('id','!=',auth()->id())
            ->whereJsonContains('additional_numbers',$number)
            ->first();
        }else{
            // Check duplicated
            $chk = AccessCatalogueRequest::whereUserId(auth()->id())->where('status','!=',4)->whereNumber($number)->first();
            if($chk){
                    return redirect()->back()->withInput()->with('error', 'Request is already sent to user.' );
            }
        }


        if (strlen($number) > 10) {
            return redirect()->back()->withInput()->with('error', 'Use a number that is not less than 10 digits' );
        }
        if(AuthRole() == "User"){
            // Check Who sent the request have package or not
            if($request->status == 0){
                // chk user have active package or not!
              if(!haveActivePackageByUserId(auth()->id())){
                  return back()->with('error','You do not have any active package!');
              } 
            }     
        }

        // Send Catalogue
        if($request->status == 1 ){
            if($user){
                  $chk = AccessCatalogueRequest::where('user_id',$user->id)->where('status',1)->where('number',auth()->user()->phone)->first();
            }else{
                return back()->with('error',"This user does not exist! You cannot send catalogue to this user.");
            }

            $chk = AccessCatalogueRequest::where('user_id',$user->id)->where('status',0)->where('number',auth()->user()->phone)->first();
            if($chk){
                return back()->with('error',"You already have pending request from this user.");
            }

            $chk = AccessCatalogueRequest::where('user_id',$user->id)->where('status',3)->where('number',auth()->user()->phone)->first();
            if($chk){
                return back()->with('error',"You already have pending request from this user, that was masked ignored. Check ignore tab to recover.");
            }

            if($user->id == auth()->id()){
                return back()->with('error',"You can't sent request to yourself.");
            }
        }

        // Send to myself
        if($number == auth()->user()->phone){
                return redirect()->back()->withInput()->with('error', 'You can\'t use your own number to request.' );
        }
        
        $auto_acr = UserShop::whereUserId($user->id)->first()->auto_acr ?? 1;

        // try {
            // Request Catalogue
            if($request->status == 0){

                // Plan Check
                $package = getUserActivePackage(auth()->id());
                $limits = json_decode($package->limit,true);
                $add_to_site = AccessCatalogueRequest::where('user_id',auth()->id())->get()->count();
                if($limits['add_to_site'] <= $add_to_site){
                    return back()->with('error','Your Add to Site Limit exceed!');
                }

                $data = AccessCatalogueRequest::whereNumber($number)->where('user_id',auth()->id())->first();
                if(!$data){
                    $data = new AccessCatalogueRequest();
                }
                
                $data->user_id=auth()->id();
                
                if ($auto_acr == 1) {
                    $group_id = Group::where('user_id',$user->id)->where('name','=','customer')->first();
                    $data->price_group_id = $group_id->id;
                    $data->status=1;
                }else{
                    $data->status=0;
                }
                // return dd($user);
                if($user && $user->phone != null){
                    $data->number= $user->phone;
                }else{
                    $data->number= $number;
                }
                $data->supplier_name = $request->supplier_name;
                $data->save();

                // SEND NOTIFICATION TO SUPPLIER
                $requested_seller = User::whereId(auth()->id())->first();
                $seller_rec = User::where('id','!=',auth()->id())
                    ->where(function($query) use($number) {
                        $query->where('phone',$number)->orWhereJsonContains('additional_numbers',$number);
                    })
                    ->first();
                if($seller_rec){
                    $onsite_notification['user_id'] =  $seller_rec->id;
                    $onsite_notification['title'] = $requested_seller->name. " has sent you a connection request." ;
                    $onsite_notification['link'] = route('panel.seller.supplier.index');
                    pushOnSiteNotification($onsite_notification);
                    
                }else{
                    return back()->with('success', 'The catalog request was successfully sent, but the requested user is not yet in 121.page.!');
                }
                return back()->with('success', 'Request for catalog creation has been successfully submitted! Once the catalog has been approved by the supplier, you can access it.');
            }
            // Send Catalogue
            elseif($request->status == 1){

                if($user){
                    if(!haveActivePackageByUserId($user->id)){
                        return back()->with('error','This user does not have active package!');
                    }
                    $package = getUserActivePackage($user->id);
                    $limits = json_decode($package->limit,true);
                    $add_to_site = AccessCatalogueRequest::where('user_id',$user->id)->get()->count();
                    if($limits['add_to_site'] <= $add_to_site){
                        return back()->with('error','This user package limit is exceed!');
                    } 
                }
                else{
                    return back()->with('error','This user does not exist in 121.page!');
                }

               $data = AccessCatalogueRequest::whereNumber(auth()->user()->phone)->where('user_id',$user->id)->first();
                if(!$data){
                    $data = new AccessCatalogueRequest();
                }
                $data->user_id=$user->id;
                $data->status=1;
                $data->price_group_id= $request->price_group_id;
                $data->number= auth()->user()->phone;
                $data->supplier_name = $request->supplier_name;
                $data->save();

                // Notify User
                if($user){
                    $onsite_notification['user_id'] =  $user->id;
                    $onsite_notification['title'] = auth()->user()->name. " has sent you a catalogue." ;
                    $onsite_notification['link'] = route('panel.seller.my_supplier.index');
                    pushOnSiteNotification($onsite_notification);
                    
                }else{
                    return back()->with('success', 'The catalog request was successfully sent, but the requested user is not yet in 121.page.!');
                }
            }
            return back()->with('success', 'Catalogue request created successfully!');
        // } catch (\Exception $e) {
        //     return back()->with('error', 'Error: ' . $e->getMessage());
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apiBrandUsers(Request $request)
    {
        // return $request->all();
       $brandusers = getBrandAS($request->brand_id);
       $html = "<option> Select Users</option>";
       foreach($brandusers as $branduser){
           $html .= "<option value='".$branduser->user_id."'>".NameById($branduser->user_id)."</option>";
       }
       return response(['html'=>$html],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function copyToaster()
    {
        return back()->with('success','Your Site Url copy to clipboard');
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
    public function userEnquirydestroy(Request $request,$id)
    {
        $user_enquiry = UserEnquiry::Find($id);
        try{
            if($user_enquiry){
                $user_enquiry->delete();
                return back()->with('success','User Enquiry deleted successfully');
            }else{
                return back()->with('error','User Enquiry not found');
            }
        }catch(\Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
 
    
    
    
}
