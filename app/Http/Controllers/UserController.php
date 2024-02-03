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

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\UserLog;
use App\Models\Package;
use App\Models\Media;
use App\Models\UserPackage;
use App\Models\Proposal;
use App\Models\Product;
use App\Models\AccessCatalogueRequest;
use App\Models\UserShop;
use App\Models\UserShopItem;
use App\Models\AccessCode;
use App\Models\Group;
use App\Models\GroupProduct;
use App\Models\UserCurrency;
use App\Models\MailSmsTemplate;
use App\Models\ProposalItem;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PHPUnit\TextUI\XmlConfiguration\Groups;
use Illuminate\Support\Facades\DB;




class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $length = 50;
        if(request()->get('length')){
            $length = $request->get('length');
        }
        $roles = Role::whereIn('id', [3,2,6])->get()->pluck('name', 'id');
        $users = User::query();
        // $users->notRole(['Super Admin'])->where('id', '!=', auth()->id());
        if($request->get('role')){
            $users->role($request->get('role'));
        }
        if($request->get('search')){
            $users->where('name','like','%'.$request->get('search').'%')
                ->orWhere('email','like','%'.$request->get('search').'%')
                ->orWhere('phone','like','%'.$request->get('search').'%')
                ->orWhere('NBD_Cat_ID','like','%'.$request->get('search').'%');
        }

        if($request->has('isSupplier') && $request->get('isSupplier') != null){
             $users->where('is_supplier','=',1);
        }

        $users= $users->latest()->paginate($length);
        if ($request->ajax()) {
            return view('user.load', ['users' => $users])->render();
        }
        return view('user.index', compact('roles','users'));

        return view('user.users', compact('roles'));
    }
    public function print(Request $request){
        $users = collect($request->records['data']);
        return view('user.print', ['users' => $users])->render();
    }


    public function userShow($id=null)
    {
        if(AuthRole() == 'User'){
            if($id != auth()->id() ){
                abort(404);
            }
        }
        $user = User::whereId($id)->first();
        return view('user.users-show', compact('id', 'user'));
    }


    public function create()
    {
        try {
            $roles = Role::where('id','!=',1)->pluck('name', 'id');
            return view('user.create-user', compact('roles'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function userlog($u_id = null, $role=null)
    {
        try {
            $roles = Role::whereIn('id', [3,10])->get()->pluck('name', 'id');
            if ($role == null) {
                $userids  = User::notRole(['Super Admin','Admin'])->pluck('id');
                $user_log = UserLog::where('user_id', $u_id)->get();
            } else {
                $userids  = User::Role($role)->pluck('id');
                $user_log = UserLog::whereIn('user_id', $userids)->get();
            }
            return view('user.user-logs', compact('user_log', 'roles'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        // return $request->all();
        // create user
        $validator = Validator::make($request->all(), [
            'name'     => 'required | string ',
            'email'    => 'required | email | unique:users',
            'phone'    => 'required |min:10|max:10|unique:users',
            'password' => 'required | confirmed',
            'role'     => 'required'
        ]);
        $check = User::where('id','!=',auth()->id())
            ->whereJsonContains('additional_numbers',$request->phone)->first();
        if($check){
            return back()->with('error', 'There is already a user associated with this phone number');
        }

        if ($request->nbdcatid != null) {
            $chk_cat = User::where('NBD_Cat_ID',$request->nbdcatid)->get()->count();
            if ($chk_cat != 0) {
                return back()->with('error', 'Cat Id Already Exist With Another User.');
            }
        }

        if($request->has('access_code') && $request->get('access_code') != null){
            $chk_code = AccessCode::whereCode($request->access_code)->first();
            if(!$chk_code){
            return redirect()->back()->with('error','This access code is invalid!');
            }

            $chk_redeem = AccessCode::whereCode($request->access_code)->where('redeemed_user_id','!=',null)->first();

            //  Check already redeemed
            if($chk_redeem){
            return redirect()->back()->with('error','This access code is already redeemed!');
            }
        }

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try {
            // store user information
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'gender'    => $request->gender,
                'dob'    => $request->dob,
                'password' => Hash::make($request->password),
                'NBD_Cat_ID' => $request->nbdcatid,
            ]);

            // check role if User and industry id is not fillable then
            if($request->role == 3 && ($request->industry_id == null || $request->industry_id == '')){
                if(!$request->industry_id){
                    $user->update([
                        'industry_id' => ["186"]
                    ]);
                }
            }

            if($request->industry_id){
                $user->industry_id = json_encode($request->industry_id);
            }


            $mycustomer = $request->mycustomer;
            $Filemanager = $request->Filemanager;
            $addandedit = $request->addandedit;
            $pricegroup = $request->pricegroup;
            $bulkupload = $request->bulkupload;
            $mysupplier = $request->mysupplier;
            $manangebrands = $request->manangebrands;
            $managegroup = $request->managegroup;
            $offers = $request->offers;
            $documentaion = $request->documentaion;
            $maya = $request->maya;

            $permission_user = ["mycustomer"=>$mycustomer,"manangebrands" => $manangebrands,"Filemanager" => $Filemanager,"addandedit"=> $addandedit,"pricegroup" => $pricegroup,"bulkupload"=> $bulkupload,"mysupplier"=> $mysupplier, "managegroup" => $managegroup,"offers" => $offers,"documentaion" => $documentaion , 'maya' => $maya ];

            $user->country = $request->country;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->account_permission = $permission_user;
            $user->pincode = $request->pincode;
            $user->address = $request->address;
            $user->save();

            // assign new role to the user
            $user->syncRoles($request->role);

            if($request->role == 3){
                $contact_info = [
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'whatsapp' => $user->phone,
                ];
                $testimonial = [
                    'title' => 'Testimonials',
                    'description' => 'Our testimonial showing here',
                ];
                $products = [
                    'title' => 'Products Catalogue',
                    'description' => 'Explore our product',
                    'label' => 'Visit Shop',
                ];
                $about = [
                    'title' => 'About ME',
                    'content' => 'Bit about me',
                ];
                $story = [
                    'title' => 'About',
                ];
                $features = [
                    'title' => 'Reason to choose us',
                ];
                $team = [
                    'title' => 'Our Team',
                ];

                if($request->site_name){
                    $shop_name =  $request->site_name;
                }else{
                    $shop_name =  $request->name."'s Shop";
                }



                // return $user->id;
                $user_shop = UserShop::create([
                    'user_id' => $user->id,
                    'name'=> $shop_name,
                    // 'slug'=> slugify($shop_name), // TODO Add slugify function
                    'slug'=> $user->phone, // TODO Add slugify function
                    'description'    => null,
                    'logo' => null,
                    'contact_no' => $user->phone,
                    'status' => 0, // Active
                    'contact_info' => json_encode($contact_info),
                    'products' => json_encode($products),
                    'about' => json_encode($about),
                    'story' => json_encode($story),
                    'features' => json_encode($features),
                    'team' => json_encode($team),
                    'email' => $user->email,
                ]);
                // Create Price Groups for User
                syncSystemPriceGroups($user->id);
                    // Code Has
                    if ($request->access_code != null && $chk_code) {

                        // Update Access Code
                        $chk_code->update([
                            'redeemed_user_id' => $user->id,
                            'redeemed_at' => now()
                        ]);

                        $user->update([
                            'is_supplier' => 1,
                        ]);

                        // Assign Trial Package
                        $package = Package::whereId(1)->first();

                        if($package){
                            if($package->duration == null){
                                    $duration = 30;
                            }else{
                                $duration = $package->duration;
                            }
                            $package_child = new UserPackage();
                            $package_child->user_id = $user->id;
                            $package_child->package_id = $package->id;
                            $package_child->order_id = 0; // For Trial Order
                            $package_child->from = now();
                            $package_child->to = now()->addDays($duration);
                            $package_child->limit = $package->limit;
                            $package_child->save();
                        }

                    }else{
                        $user->update([
                            'is_supplier' => 0,
                        ]);
                    }

                    // Save VC Image
                    if($request->hasFile("img")){
                        $img = $this->uploadFile($request->file("img"), "user")->getFilePath();
                        $filename = $request->file('img')->getClientOriginalName();
                        $extension = pathinfo($filename, PATHINFO_EXTENSION);
                        if($filename != null){
                            Media::create([
                                'type' => 'UserVcard',
                                'type_id' => $user->id,
                                'file_name' => $filename,
                                'path' => $img,
                                'extension' => $extension,
                                'file_type' => "Image",
                                'tag' => "vcard",
                            ]);
                        }
                    }
            }

            $chk_UserCurrency = UserCurrency::whereUserId($user->id)->get();
            if (count(($chk_UserCurrency)) != 0) {
                UserCurrency::create([
                'user_id' => $user->id,
                    'User_shop_id' =>  0,
                    'currency' => 'INR',
                    'exchange' => 1,
                    'remark' => '',
                    'default_currency' => 1
                ]);
                UserCurrency::create([
                'user_id' => $user->id,
                    'User_shop_id' =>  0,
                    'currency' => 'USD',
                    'exchange' => 85,
                    'remark' => 'Estimated',
                    'default_currency' => 0
                ]);
            }


            if ($user) {
                return redirect('panel/users/index')->with('success', 'New user created!');
            } else {
                return redirect('panel/users/index')->with('error', 'Failed to create New user! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit($id)
    {
        try {
            $user  = User::with('roles', 'permissions')->find($id);

            $user_shop  = UserShop::whereUserId($id)->first();

            if ($user) {
                $user_role = $user->roles->first();
                $roles     = Role::where('id','!=',1)->pluck('name', 'id');

                return view('user.user-edit', compact('user', 'user_role', 'roles','user_shop'));
            } else {
                return redirect('404');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function update(Request $request, $id)
    {
        // return $request->all();
        $this->validate($request, [
                'name'     => 'required | string ',
                'email'    => 'required | email',
        ]);
        if($request->password){
            $validator = Validator::make($request->all(), [
                'password' => 'required | confirmed ',
                'password' => ' required | min:4',
            ]);

            if ($validator->fails()) {
                return back()->with('error','Password must have at least 6 characters!');
            }

            if ($request->password !== $request->confirm_password) {
                return back()->with('error', 'Password and confirm password does not match !');
            }
        }


        $mycustomer = $request->mycustomer;
        $Filemanager = $request->Filemanager;
        $addandedit = $request->addandedit;
        $pricegroup = $request->pricegroup;
        $bulkupload = $request->bulkupload;
        $mysupplier = $request->mysupplier;
        $manangebrands = $request->manangebrands;
        $managegroup = $request->managegroup;
        $offers = $request->offers;
        $documentaion = $request->documentaion;
        $maya = $request->maya;


        $permission_user = ["mycustomer"=>$mycustomer,"manangebrands" => $manangebrands,"Filemanager" => $Filemanager,"addandedit"=> $addandedit,"pricegroup" => $pricegroup,"bulkupload"=> $bulkupload,"mysupplier"=> $mysupplier, "managegroup" => $managegroup,"offers" => $offers,"documentaion" => $documentaion, 'maya' => $maya ];



        $user = User::whereId($id)->first();
        $user_shop = UserShop::whereUserId($id)->first();



        try {
            $phone = $user->phone;
            $user->password = Hash::make($request->password) ?? $user->password;
            $user->name=$request->name;
            $user->email=$request->email;
            $user->phone=$request->phone;
            if($request->is_verified == 1){
                $user->email_verified_at = now();
                $user->is_verified = 1;
            }else{
                $user->email_verified_at = null;
                $user->is_verified = 0;
            }
            $user->dob=$request->dob;
            $user->industry_id=json_encode($request->industry_id) ?? null;
            $user->gender=$request->gender;
            $user->country=$request->country;
            $user->state=$request->state;
            $user->city=$request->city;
            $user->account_permission=$permission_user;
            if($request->is_supplier == 1){
                $user->is_supplier = 1;
            }else{
                $user->is_supplier = 0;
            }

            if ($request->get('ekyc_status')) {
                $user->ekyc_status = $request->ekyc_status;
            }else{
                $user->ekyc_status = 0;
            }

            $user->pincode=$request->pincode;
            $user->address=$request->address;

            $user_shop->demo_given = $request->demo_given; // ! Update in User Shop

            $user_shop->save();
            $user->save();
            $user->syncRoles($request->role);
            if(UserRole($user->id)['name'] == "User" && $phone != $request->phone){
                $all_rec = AccessCatalogueRequest::where('number',$phone)->update([
                    'number' => $request->phone,
                ]);
            }

            return redirect('panel/users/index')->with('success', 'User information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function ekycVerify(Request $request)
    {
        // return $request->all();
        $user = User::whereId(auth()->user()->id)->first();

        if($request->hasFile("document_front_attachment")){
            $document_front = $this->uploadFile($request->file("document_front_attachment"), "kyc")->getFilePath();
        } else {
            $document_front = null;
        }

        if($request->hasFile("document_back_attachment")){
            $document_back = $this->uploadFile($request->file("document_back_attachment"), "kyc")->getFilePath();
        } else {
            $document_back = null;
        }

        $ekyc_info = [
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'document_front' => $document_front,
            'document_back' => $document_back,
            'admin_remark' => null,
            'last_site' => $request->last_site,
            'account_type' =>  $request->acc_type,
            'remarks' => $request->remarks,
        ];

        $ekyc_info = json_encode($ekyc_info);
        $user->update([
           'ekyc_info' =>$ekyc_info,
           'ekyc_status' => 3, //Submitted
        ]);

        $mailcontent_data = MailSmsTemplate::where('code','=',"Submit-KYC")->first();
        if($mailcontent_data){
            $arr=[
                '{id}'=> $user->id,
                '{name}'=>NameById( $user->id),
                ];
            $action_button = null;
            TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
        }
        $onsite_notification['user_id'] =  $user->id;
        $onsite_notification['title'] = "Your eKYC has been submitted succesfully. Our team is glad to see you and we will contact you soon.";
        $onsite_notification['link'] = route('customer.dashboard')."?active=account";
        pushOnSiteNotification($onsite_notification);

        return redirect()->back()->with('success','Your eKYC verification request has been submitted successfully!');
    }

    public function updateEkycStatus(Request $request)
    {
        $user = User::whereId($request->user_id)->firstOrFail();
        $ekyc_info = json_decode($user->ekyc_info);

        if(is_null($ekyc_info)){
            abort(404);
        }

        $new_ekyc_info = [
            'document_type' => $ekyc_info->document_type,
            'document_number' => $ekyc_info->document_number,
            'document_front' => $ekyc_info->document_front,
            'document_back' => $ekyc_info->document_back,
            'admin_remark' => $request->remark,
            'user_remark' => $ekyc_info->remarks,
            'account_type' => $ekyc_info->account_type,
            'last_site' => $ekyc_info->last_site,
        ];

        $new_ekyc_info = json_encode($new_ekyc_info);
        if($request->status == 1){
            $mailcontent_data = MailSmsTemplate::where('code','=',"Verified-KYC")->first();
            if($mailcontent_data){
            $arr=[
                '{id}'=> $user->id,
                '{name}'=>NameById( $user->id),
                ];
            $action_button = null;
            TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
            }
            $onsite_notification['user_id'] =  $user->id;
            $onsite_notification['title'] = "Your eKYC has been verified successfully!";
            $onsite_notification['link'] = route('customer.dashboard')."?active=account";
            pushOnSiteNotification($onsite_notification);
            $user->update([
            'account_type' => $ekyc_info->account_type ,
            ]);

        }

        if($request->status == 0){
            $mailcontent_data = MailSmsTemplate::where('code','=',"Rejected-KYC")->first();
            if($mailcontent_data){
            $arr=[
                '{id}'=> $user->id,
                '{name}'=>NameById( $user->id),
                ];
            $action_button = null;
            TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
            }
            $onsite_notification['user_id'] =  $user->id;
            $onsite_notification['title'] = "Re-submit KYC to finish profile";
            $onsite_notification['link'] = route('customer.dashboard')."?active=account";
            pushOnSiteNotification($onsite_notification);

        }

        $user->update([
           'ekyc_info' =>$new_ekyc_info,
           'ekyc_status' => $request->status,
        ]);

        return redirect()->back()->with('success','eKYC update successfully!');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }
    public function subscription()
    {
        $user = auth()->user();
        return view('user.subscription', compact('user'));
    }
    public function sendOTP(Request $request)
    {
        $phone = $request->phone_no;
        $check =  User::where('id','!=',auth()->id())
                    ->where(function($query) use($phone) {
                        $query->where('phone',$phone)->orWhereJsonContains('additional_numbers',$phone);
                    })
                    ->first();
        if($check){
            return response()->json([
                'message' => 'The number is associated with another user!',
                'title' => 'Error',
            ]);
        }
        if(strlen($phone) > 10 || strlen($phone) < 10){
            return response()->json([
                'message' => 'Please Enter Valid Number',
                'title' => 'Error',
            ]);
        }else{
            $otp = rand(1000,9999);
            $phone = $phone;
            session()->put('otp',$otp);
            session()->put('phone',$phone);
            User::whereId(auth()->id())->update([
                'temp_otp' => $otp
            ]);

            // ! Skip OTP Send Request In Localhost
            if(env('WORKING_AREA','production') == 'local'){
                return response()->json([
                    'message' => 'OTP Sent Successfully!',
                    'title' => 'Success',
                    'otp' => $otp,
                ]);
            }
            $mailcontent_data = MailSmsTemplate::where('code','=',"otp-send")->first();
            if($mailcontent_data){
                $arr=[
                    '{OTP}'=>$otp,
                 ];
                 $msg = DynamicMailTemplateFormatter($mailcontent_data->body,$mailcontent_data->variables,$arr);
                 sendSms($phone,$msg,$mailcontent_data->footer);
            }
            return response()->json([
                'message' => 'OTP Sent Successfully!',
                'title' => 'Success',
                'otp' => $otp,
            ]);
        }
    }

    public function verifyOTP(Request $request){
        if($request->otp){
            if($request->otp == auth()->user()->temp_otp){
                return response()->json([
                    'message' => 'OTP Verified!',
                    'title' => 'Success',
                ]);
            }else{
                return response()->json([
                    'message' => 'OTP Does not match!',
                    'title' => 'Error',
                ]);
            }
        }
    }

    public function updateProfile(Request $request, $id)
    {
        // return $request->all();

        $this->validate($request, [
                'name'     => 'required | string ',
                'email'    => 'required | email',
                'phone'    => 'sometimes',
            ]);

            try {
                $user = User::whereId($id)->first();
                // Checking Email Uniqueness
                if($user->email != $request->email){
                    $chkEmail =  User::whereEmail($request->email)->first();
                    if($chkEmail){
                        return redirect()->back()->with('This email is associated with another account');
                    }
                }

                // Checking Phone Uniqueness
                if($user->email != $request->email){
                    $chkEmail =  User::wherePhone($request->phone)->first();
                    if($chkEmail){
                        return redirect()->back()->with('This phone is associated with another account');
                    }
                }

                    $phone = $request->phone;
                    $user->name=$request->name;
                    $user->email=$request->email;
                    $user->additional_numbers=$user->additional_numbers;
                    $user->timezone=$request->timezone;
                    $user->language=$request->language;
                    $user->country=$request->country;
                    $user->industry_id=$request->industry_id != null ? json_encode($request->industry_id) : null;
                    $user->state=$request->state;
                    $user->city=$request->city;
                    $user->pincode=$request->pincode;
                    $user->gender=$request->gender;
                    $user->dob=$request->dob;
                    // Save VC Image
                    if($request->hasFile("vcard")){
                        $vcard = $this->uploadFile($request->file("vcard"), "user")->getFilePath();
                        $filename = $request->file('vcard')->getClientOriginalName();
                        $extension = pathinfo($filename, PATHINFO_EXTENSION);
                        if($filename != null){
                            Media::create([
                                'type' => 'UserVcard',
                                'type_id' => $user->id,
                                'file_name' => $filename,
                                'path' => $vcard,
                                'extension' => $extension,
                                'file_type' => "Image",
                                'tag' => "vcard",
                            ]);
                        }
                    }
                    $user->save();

                // Updating Phone Number in Access Request
                if(UserRole($user->id)['name'] == "User" && $phone != $request->phone){
                $all_rec = AccessCatalogueRequest::where('number',$phone)->whereStatus(1)->update([
                    'number' => $request->phone,
                ]);
                }
            return redirect()->back()->with('success', 'User information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function updateProfileImage(Request $request, $id)
    {
        $user = User::findOrFail($id);
        try {
            if ($request->hasFile('avatar')) {
                if ($user->avatar != null) {
                    unlinkfile(storage_path() . '/app/public/backend/users', $user->avatar);
                }
                $image = $request->file('avatar');
                $path = storage_path() . '/app/public/backend/users/';
                $imageName = 'profile_image_' . $user->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
                $user->avatar=$imageName;
            }
            $user->update(['avatar' => $imageName]);
            return back()->with('success', 'Profile image updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


    public function updateAdditionalNumber(Request $request){

        // $this->validate($request, [
        //     'additional_numbers' => 'required'
        // ]);
        $phones = [];

        // return $request->all();
        $userRecord = User::where('id',$request->user_id)->first();
        if(isset($request->userAdditionalNoUpdate) && $request->userAdditionalNoUpdate != null && $request->userAdditionalNoUpdate == 'updateByAdmin' && $request->user_id != null){

            foreach(explode(',',$request->additional_phone) as $number){
                $user = User::where('id','!=',$request->user_id)->where('phone',$number)->first();
                if(strlen($number) != 10){
                    return back()->with('error',$number.' Invalid Number Please Enter Valid Number!');
                }
                if(!$user){
                    $user = User::where('id','!=',$request->user_id)
                    ->whereJsonContains('additional_numbers',$number)
                    ->first();
                }
                if($user){
                    return back()->with('error',$number.' Number Already exists!');
                }
                if($userRecord->additional_numbers == null){
                    $phones[] = $number;
                    $userRecord->additional_numbers = json_encode($phones);
                }else{
                    $phones = json_decode($userRecord->additional_numbers, true);
                    $phones[] = $number;
                    $userRecord->additional_numbers = json_encode($phones);
                }
                $userRecord->save();
            }
            return back()->with('success','Number Updated!');
        }
        $user = User::whereId(auth()->id())->first();
        if($user->additional_numbers == null){
            $phones[] = $request->additional_phone;
            $user->additional_numbers = json_encode($phones);
        }else{
            $phones = json_decode($user->additional_numbers, true);
            $phones[] = $request->additional_phone;
            $user->additional_numbers = json_encode($phones);
        }
        // return $user;
        $user->save();
        return back()->with('success','Number Updated!');

    }

    public function deleteAdditionalNumber(Request $request,$user_id,$number){
        $user = User::whereId($user_id)->first();
        $phones = [];
        if($user){
            $existing_numbers = json_decode($user->additional_numbers, true);

            foreach($existing_numbers as $key => $ex_number){
                if($ex_number != $number){
                    $phones[] = $ex_number;
                }
            }

            $user->additional_numbers = json_encode($phones);
            $user->save();
            return back()->with('success','Number Deleted Successfully!');
        }
    }

    public function updatePassword(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required | confirmed ',
            'password' => ' required | min:4',
        ]);

        if ($validator->fails()) {
            return back()->with('error','Password must have at least 6 characters!');
        }
        $user = auth()->user();
        $data = User::find($user->id);


        if ($request->password !== $request->confirm_password) {
            return back()->with('error', 'Password and confirm password does not match !');
        }
        if (Hash::check($request->old_password, $user->password)) {

            try {
                User::find($id)->update([
                    'password' => Hash::make($request->password),
                ]);
                return back()->with('success', 'Your password updated successfully !');
            } catch (\Exception $e) {
                return back()->with('error', 'There was an error: ' . $e->getMessage());
            }
        }else{
            return back()->with('error', 'Old password does not match !');
        }
    }

    public function loginAs($id)
    {
        try {
            if ($id == auth()->id()) {
                return back()->with('error', 'Do not try to login as yourself.');
            } else {
                $user   = User::find($id);
                // ! Uncomment only if You Want to Udate Login Time in Login-as User
                // event(new \App\Events\UserAuthenticated($user));

                session(['admin_user_id' => auth()->id()]);
                session(['temp_user_id' => $user->id]);
                auth()->logout();

                // Login.
                auth()->loginUsingId($user->id);

                // Redirect.
                return redirect(route('panel.dashboard'));
            }
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }




    public function status($id, $s)
    {
        try {
            $user   = User::find($id);
            $user->update(['status' => $s]);

            // Unpublish all products.
            if($s == 0){
                $scoped_products = Product::whereUserId($id)->get();
                foreach($scoped_products as $scoped_product){
                    $scoped_product->update(['is_publish' => 0]);
                }

                // Unpublish all user shop.
                $scoped_shop_products = UserShopItem::whereUserId($id)->get();
                foreach($scoped_shop_products as $scoped_shop_product){
                    $scoped_shop_product->update(['is_published' => 0]);
                }

                $user_shop = UserShop::whereUserId($id)->first()->id;


                // Unpublish all user shop linking.
                $scoped_shop_products = UserShopItem::where('parent_shop_id',$user_shop)->get();
                foreach($scoped_shop_products as $scoped_shop_product){
                    $scoped_shop_product->update(['is_published' => 0]);
                }

            }else{
                $scoped_products = Product::whereUserId($id)->get();
                foreach($scoped_products as $scoped_product){
                    $scoped_product->update(['is_publish' => 1]);
                }

                $scoped_shop_products = UserShopItem::whereUserId($id)->get();
                foreach($scoped_shop_products as $scoped_shop_product){
                    $scoped_shop_product->update(['is_published' => 1]);
                }
            }

            return redirect('panel/users/index')->with('success', 'User status Updated!');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


    public function bulkuserimportshow (Request $request){
        return view('user.bulk-user');
    }



    public function delete($id)
    {
        // Get User Details
        $user   = User::find($id);
        $usershop = UserShop::where('user_id',$id)->first();

        $proposal = DB::table('proposals')->where('user_id', $id)->delete();

        $acr_sender = DB::table('access_catalogue_requests')->where('user_id', $id)->delete();

        $acr_receiver = DB::table('access_catalogue_requests')->where('number', $user->phone)->delete();

        // Deleting Products
        $product = DB::table('products')->where('user_id', $id)->delete();

        // ! uncomment Those Code For Sending Notifications
        // Get All USer Shop Items
        // $UserShopItem = UserShopItem::where('user_id',$id)->get();

        // $othershops = UserShopItem::where('parent_shop_id',$usershop->id)->get();
        // foreach($othershops as $other){
        //     $other->is_published = 0;
        //     $other->save();

        //     $onsite_notification['user_id'] =  $other->user_id;
        //     $onsite_notification['title'] = NameById($usershop->name)." has Been Deleted  , resulting in auto unpublished from your account. To continue selling, review changes and publish." ;
        //     $onsite_notification['link'] = route('panel.user_shop_items.create')."?type=direct&type_id=";
        //     pushOnSiteNotification($onsite_notification);
        // }

        // Delete All UserShop Items
        $UserShopItem = DB::table('user_shop_items')->where('user_id', $id)->delete();

        $groups =  DB::table('groups')->where('user_id', $id)->get();

        echo  "<pre>";
        print_r($groups);
        echo  "</pre>";


        foreach ($groups as $group) {
            // Get User Group Items and Delete
            $groups_product = DB::table('group_products')->where('group_id', $group->id)->delete();
        }

        $groups = DB::table('groups')->where('user_id', $id)->delete();

        $user_package = UserPackage::where('user_id',$id)->delete();

        $proposal_items = DB::table('proposal_items')->where('user_id', $id)->delete();

        // Delet User Media Directory
        $media_directory = "storage/files/".$id;
        $del_path = str_replace('storage','public',$media_directory);
        Storage::deleteDirectory($del_path);

        $user_shop = UserShop::where('user_id',$id)->delete();

        if ($user) {
            $user->delete();
            return redirect('panel/users/index')->with('success', 'User removed!');
        } else {
            return redirect('panel/users/index')->with('error', 'User not found');
        }
    }







}
