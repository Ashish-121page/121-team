<?php

namespace App\Http\Controllers;

use App\Models\BrandUser;
use App\Models\Brand;
use App\Models\Media;
use App\Models\MailSmsTemplate;
use Illuminate\Http\Request;

class BrandUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
    //   return   BrandUser::whereBrandId(request()->get('id'))->whereType(request()->get('status'))->get();
        // return $request->all();
         // BrandID Check
        if($request->has('id') && $request->get('id') == null){
            return back()->with('error', 'No brand assign to your account!');
        }

        // Brand Presence Check
        $brand = Brand::whereId(request()->get('id'))->first();
        if(!$brand){
              return back()->with('error', 'No brand assign to your account!');
        }

        if(AuthRole() == "User"){
            // Brand Permission Check
            $brand = BrandUser::whereBrandId(request()->get('id'))->whereUserId(auth()->id())->first();
            if(!$brand){
                return back()->with('error', 'You don\'t have permission to access!');
            }
        }

        $length = 10;
        if(request()->get('length')){
             $length = $request->get('length');
         }
         $brand_users = BrandUser::query();
            if($request->get('search')){
                $brand_users->where('id','like','%'.$request->search.'%')
                ->orWhere('status','like','%'.$request->search.'%')
                ->orWhere('name','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $brand_users->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }
            // if($request->has('status') && $request->get('status') != null){
            //     $brand_users->where('status',$request->status);
            // }

            if($request->get('asc')){
                $brand_users->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $brand_users->orderBy($request->get('desc'),'desc');
            }
           
            $brand_users = $brand_users->whereBrandId(request()->get('id'))->whereType(request()->get('status'))->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.', ['brand_users' => $brand_users])->render();  
            }
            return view('panel.authorized-seller.index',compact('brand_users','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $this->validate($request, [
                'user_id' => 'required',
                'status' => 'required',
            ]);
        try {
            $data = new BrandUser();
            $data->user_id=$request->user_id;
            $data->status=$request->status;
            $data->brand_id=$request->brand_id;
            $data->is_verified=$request->is_verified;
            $data->save();
            return back()->with('success', 'Authorized Seller Created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BrandUser  $brandUser
     * @return \Illuminate\Http\Response
     */
    public function show($brand_user_id)
    {
        $claim_record = BrandUser::whereId($brand_user_id)->first();
        $brand_id =  $claim_record->brand_id;
        $details = json_decode($claim_record->details,true);
        $brand_logo = Media::whereType('BrandLogo')->whereTypeId($claim_record->id)->first();
        $brand_user_proof = Media::whereType('BrandUserProof')->whereTypeId($claim_record->id)->first();
        return view('backend.manage-request.claim.show',compact('brand_id','claim_record','details','brand_logo','brand_user_proof'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BrandUser  $brandUser
     * @return \Illuminate\Http\Response
     */
    public function edit(BrandUser $brandUser,$id)
    {
        try{
            $brand_user = BrandUser::whereId($id)->first();
            return view('panel.authorized-seller.edit',compact('brand_user'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BrandUser  $brandUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // return $request->all();
        try {
            $data = BrandUser::whereId($id)->first();
            // $data->user_id=$request->user_id;
            $data->status=$request->status;
            // $data->brand_id=$request->brand_id;
            $data->is_verified=$request->is_verified;
            $data->save();
            return redirect()->back()->with('success', 'Authorized Seller Updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function claimBrandCreate(Request $request, $brand_id)
    {
        $brand_as_user = getBrandUserByUserId($brand_id, auth()->id(), 1);
        $brand_bo_user = getBrandUserByUserId($brand_id, auth()->id(), 0);
       return view('backend.seller.brand.claim-request.create',compact('brand_id','brand_as_user','brand_bo_user'));
    }

    public function claimBrandShow(Request $request, $brand_id)
    {
        $claim_record = BrandUser::whereBrandId($brand_id)->first();
        $details = json_decode($claim_record->details,true);
        $brand_logo = Media::whereType('BrandLogo')->whereTypeId($claim_record->brand_id)->first() ?? '';
        $brand_user_proof = Media::whereType('BrandUserProof')->whereTypeId($claim_record->brand_id)->first() ?? '';
       return view('backend.manage-request.claim.show',compact('brand_id','claim_record','details','brand_logo','brand_user_proof'));
    }

    public function claimReplyStore(Request $request, $brand_id)
    {
        $claim_record = BrandUser::whereBrandId($brand_id)->whereId($request->user_brand_id)->first();
        $brand_name = Brand::whereId($brand_id)->first()->name;
        if(!$claim_record){
            return back()->with('error','No record exist .');
        }
        $details = json_decode($claim_record->details,true);

        try{
            //  Check this for Authorize Seller
                if($claim_record->type == 1){
                    // Accept 
                    if($request->type == 1){
                        $claim_record->update([
                            'status' => 1
                        ]);
                        if($claim_record->user_id != null ){
                                $user_record =  getUserRecordByUserId($claim_record->user_id);
                                $mailcontent_data = MailSmsTemplate::where('code','=',"Authorize-request-accept")->first();
                                if($mailcontent_data){
                                    $arr=[
                                        '{name}'=> $user_record->name,
                                        ];
                                $action_button = null;
                                TemplateMail($user_record->name,$mailcontent_data,$user_record->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
                                }
                                $onsite_notification['user_id'] =  $user_record->id;
                                $onsite_notification['title'] = "Admin has accepted your request to become an authorized seller of ". $brand_name;
                                $onsite_notification['link'] = route('panel.seller.explore.index');
                                pushOnSiteNotification($onsite_notification);
                            
                        }else{
                            return back()->with('error','No user record exist');
                        }
                    }
                    // Reject
                    elseif($request->type == 0){
                        $details['rejection_reason'] = $request->rejection_reason;
                        $claim_record->update([
                            'details' => json_encode($details),
                            'status' => 2
                        ]);
            
                        if($claim_record->user_id != null){
                            if($claim_record){
                                $user_record =  getUserRecordByUserId($claim_record->user_id);
                                $mailcontent_data = MailSmsTemplate::where('code','=',"Authorize-request-reject")->first();
                                if($mailcontent_data){
                                    $arr=[
                                        '{name}'=> $user_record->name,
                                        ];
                                $action_button = null;
                                TemplateMail($user_record->name,$mailcontent_data,$user_record->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
                                }
                                $onsite_notification['user_id'] =  $user_record->id;
                                $onsite_notification['title'] = "Admin rejects your request to become an authorized seller of ". $brand_name;
                                $onsite_notification['link'] = route('panel.seller.explore.index');
                                pushOnSiteNotification($onsite_notification);
                            }else{
            
                            }
                        }else{
                            return back()->with('error','No user record exist');
                        }
                    }
                }else{
                    // Accept 
                    if($request->type == 1){
                        $claim_record->update([
                            'status' => 1
                        ]);
                        if($claim_record->user_id != null ){
                                $user_record =  getUserRecordByUserId($claim_record->user_id);
                                $mailcontent_data = MailSmsTemplate::where('code','=',"Brand-owner-request-accept")->first();
                                if($mailcontent_data){
                                    $arr=[
                                        '{name}'=> $user_record->name,
                                        ];
                                $action_button = null;
                                TemplateMail($user_record->name,$mailcontent_data,$user_record->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
                                }
                                $onsite_notification['user_id'] =  $user_record->id;
                                $onsite_notification['title'] = "Admin accept your request to become an brand owner of ". $brand_name;
                                $onsite_notification['link'] = route('panel.seller.explore.index');
                                pushOnSiteNotification($onsite_notification);
                            
                        }else{
                            return back()->with('error','No user record exist');
                        }
                    }
                    // Reject
                    elseif($request->type == 0){
                        $details['rejection_reason'] = $request->rejection_reason;
                        $claim_record->update([
                            'details' => json_encode($details),
                            'status' => 2
                        ]);
            
                        if($claim_record->user_id != null){
                            if($claim_record){
                                $user_record =  getUserRecordByUserId($claim_record->user_id);
                                $mailcontent_data = MailSmsTemplate::where('code','=',"Brand-owner-request-reject")->first();
                                if($mailcontent_data){
                                    $arr=[
                                        '{name}'=> $user_record->name,
                                        ];
                                $action_button = null;
                                TemplateMail($user_record->name,$mailcontent_data,$user_record->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
                                }
                                $onsite_notification['user_id'] =  $user_record->id;
                                $onsite_notification['title'] = "Admin rejects your request to become an brand owner of ". $brand_name;
                                $onsite_notification['link'] = route('panel.seller.explore.index');
                                pushOnSiteNotification($onsite_notification);
                            }else{
            
                            }
                        }else{
                            return back()->with('error','No user record exist');
                        }
                    } 
                }
        }catch(Exception $e){

        }
        return back()->with('success','Record updated successfully');
         
    }

    public function claimBrandStoreForAs(Request $request, $brand_id)
    {
        // return $request->all();
        
       $this->validate($request, [
           'type' => 'required',
           'proof_certificate' => 'required',
           'est_date' => 'required',
           'logo' => 'required',
           ]);
       try {

        //  Removing duplicating Records
         $data = BrandUser::where('brand_id',$brand_id)->whereUserId(auth()->id())->whereType($request->type)->first();
            if(!$data){
                $data = new BrandUser();
            }
           $data->user_id=auth()->id();
           $data->status=0;
           $data->brand_id=$brand_id;
           $data->type=$request->type;
           $data->is_verified=0;
           $arr = [
               'est_date'=>$request->est_date,
               'brand_name'=>$request->brand_name,
               'address'=>$request->address,
               'pincode'=>$request->pincode,
               'email'=>$request->email,
               'phone'=>$request->phone,
               'country'=>$request->country,
               'state'=>$request->state,
               'city'=>$request->city,
               'rejection_reason'=>null,
           ];
        //    return $request->all();
           $data->details=json_encode($arr);
           $data->save();
           

           // Store Proof Certificate
            if($request->hasFile("proof_certificate")){
               $proof_certificate = $this->uploadFile($request->file("proof_certificate"), "brand_users")->getFilePath();
               $filename = $request->file('proof_certificate')->getClientOriginalName();
               $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if($filename != null){
               Media::create([
                   'type' => 'BrandUserProof',
                   'type_id' => $data->id,
                   'file_name' => $filename,
                   'path' => $proof_certificate,
                   'extension' => $extension,
                   'file_type' => "Image",
                   'tag' => "brand_proof_certificate",
               ]);
               }
            }

            // Store Brand Logo
            if($request->hasFile("logo")){
               $logo = $this->uploadFile($request->file("logo"), "brand_users")->getFilePath();
               $filename = $request->file('logo')->getClientOriginalName();
               $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if($filename != null){
               Media::create([
                   'type' => 'BrandLogo',
                   'type_id' => $data->id,
                   'file_name' => $filename,
                   'path' => $logo,
                   'extension' => $extension,
                   'file_type' => "Image",
                   'tag' => "brand_logo",
               ]);
               }
            }
           return back()->with('success', 'Claim Requested Successfully!');
       } catch (\Exception $e) {
           return back()->with('error', 'Error: ' . $e->getMessage());
       }
      
    }
    public function claimBrandStoreForBo(Request $request, $brand_id)
    {
       
       $this->validate($request, [
           'type' => 'required',
           'proof_certificate' => 'required',
           'est_date' => 'required',
           'logo' => 'required',
           'email' => 'required',
           'phone' => 'required',
           ]);
       try {

            //  Removing Rejected Records
            $data = BrandUser::where('brand_id',$brand_id)->whereUserId(auth()->id())->whereType($request->type)->first();
            if(!$data){
                $data = new BrandUser();
            }
            
           $data->user_id=auth()->id();
           $data->status=0;
           $data->brand_id=$brand_id;
           $data->type=$request->type;
           $data->is_verified=0;
           $arr = [
               'est_date'=>$request->est_date,
               'brand_name'=>$request->brand_name,
               'address'=>$request->address,
               'pincode'=>$request->pincode,
               'email'=>$request->email,
               'phone'=>$request->phone,
               'country'=>$request->country,
               'state'=>$request->state,
               'city'=>$request->city,
               'rejection_reason'=>null,
           ];
           $data->details=json_encode($arr);
           $data->save();

           // Store Proof Certificate
            if($request->hasFile("proof_certificate")){
               $proof_certificate = $this->uploadFile($request->file("proof_certificate"), "brand_users")->getFilePath();
               $filename = $request->file('proof_certificate')->getClientOriginalName();
               $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if($filename != null){
               Media::create([
                   'type' => 'BrandUserProof',
                   'type_id' => $data->id,
                   'file_name' => $filename,
                   'path' => $proof_certificate,
                   'extension' => $extension,
                   'file_type' => "Image",
                   'tag' => "brand_proof_certificate",
               ]);
               }
            }

            // Store Brand Logo
            if($request->hasFile("logo")){
               $logo = $this->uploadFile($request->file("logo"), "brand_users")->getFilePath();
               $filename = $request->file('logo')->getClientOriginalName();
               $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if($filename != null){
               Media::create([
                   'type' => 'BrandLogo',
                   'type_id' => $data->id,
                   'file_name' => $filename,
                   'path' => $logo,
                   'extension' => $extension,
                   'file_type' => "Image",
                   'tag' => "brand_logo",
               ]);
               }
            }
           return back()->with('success', 'Claim Requested Successfully!');
       } catch (\Exception $e) {
           return back()->with('error', 'Error: ' . $e->getMessage());
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BrandUser  $brandUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $chk = BrandUser::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Authorized Seller Deleted Successfully!');
        }
    }
}
