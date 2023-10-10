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

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use App\Models\MailSmsTemplate;
use App\Models\Media;
use App\Models\UserPackage;
use App\Models\Package;
use App\Models\UserShop;
use App\Models\AccessCode;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CustomerLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('frontend.login.index');
    }
    public function otp(Request $request)
    {
        $phone = $request->phone;
        return view('frontend.login.otp', compact('phone'));
    }
   
    protected function validateLogin(Request $request)
    {
        // return $request->resent;
        if($request->resent == 1){
            $phone = $request->phone;
        }else{
            // $phone = implode('',$request->phone);
            $phone = $request->phone;
            if (strlen($phone) > 10 || strlen($phone) < 10){
                return back()->with('error','Phone number should be 10 digits!');
            }
        }
        $otp = rand(1000,9999);
        $phone = $phone;
        session()->put('otp',$otp);
        session()->put('phone',$phone);
        $mailcontent_data = MailSmsTemplate::where('code','=',"otp-send")->first();
        if($mailcontent_data){
            $arr=[
                '{OTP}'=>$otp,
            ];
            $msg = DynamicMailTemplateFormatter($mailcontent_data->body,$mailcontent_data->variables,$arr);
            sendSms($phone,$msg,$mailcontent_data->footer);
        }

       return redirect(route('auth.otp-index').'?phone='.$phone);
    }
    protected function resendOTP(Request $request)
    {
        $otp = rand(1000,9999);
        $phone = session()->get('phone');
        session()->put('otp',$otp);

        if(getSetting('sms_verify')){
            $mailcontent_data = App\Models\MailSmsTemplate::where('code','=',"otp-send")->first();
            if($mailcontent_data){
                $arr=[
                    '{OTP}'=>$otp,
                    '{reason}'=>"registeration",
                    '{app_name}'=>"GRPL 121.page",
                    '{date_time}'=>\Carbon\Carbon::now()->format('d M Y,h:i'),
                 ];
                 $msg = DynamicMailTemplateFormatter($mailcontent_data->body,$mailcontent_data->variables,$arr);
                 return sendSms($data['phone'],$msg,$mailcontent_data->footer);
            }
        }else{
            $otp = null;
        }
       return redirect(route('auth.otp-index').'?phone='.$phone);
    }
    
    protected function validateOTP(Request $request)
    {
        $get_otp = implode('',$request->otp);
        if (session()->get('otp') == $get_otp) {
        $phone = session()->get('phone');
        $user = User::where('phone','!=',null)
        ->wherePhone($phone)
        ->first();
        
        $userAdd = DB::table('users')->where('additional_numbers','LIKE','%'.$phone.'%')->first() ?? "";


        if ($user) {
            if(auth()->check()){
                auth()->logout();
            }
            // Setting Dynamic Session Domain for logging in
            auth()->loginUsingId($user->id);
            
            if(AuthRole() == "User"){
                return redirect()->route('customer.dashboard');
            }else{
                return redirect()->route('panel.dashboard');
            }
        } 
        elseif (isset($userAdd->additional_numbers) != "" ) {
            if (in_array($phone,json_decode($userAdd->additional_numbers))) {
                // return redirect(route('auth.login-index'))->with('error','Account already exists. Login from Primary contact or Raise login ticket');
                // echo "Number Linked with Another account";
                // magicstring($userAdd);
                auth()->loginUsingId($userAdd->id);
                if(AuthRole() == "User"){
                    return redirect()->route('customer.dashboard');
                }else{
                    return redirect()->route('panel.dashboard');
                }                
                
                
            }
        }
        else {
            return redirect(route('auth.signup'));
        }
        } else {
            return back()->with('error','The OTP entered is incorrect');
        }
    }

    
     public function signup(Request $request)
    {
        if(session()->has('phone')){
            $phone = session()->get('phone');
            return view('frontend.login.signup',compact('phone'));
        }else{
            return redirect()->back()->with('error',"Something went wrong!");
        }
    }
   
    
    protected function validateSignup(Request $request)
    {
        $exist_user = User::whereEmail($request->email)->wherePhone($request->phone)->first();
        if($exist_user){
            return redirect(route('auth.access-code').'?user_id='.$exist_user->id);
        }
        
        $validator = Validator::make($request->all(), [
            'name'     => 'required | string ',
            'email'    => 'required | email | unique:users',
            'phone'    => 'required | unique:users',
            'password'    => 'required | min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first() );
        }
        $name = str_replace(" ", "", $request->name);
        
        // Account Creation
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'parent_id' => session()->get('parent_id'),
            // 'password' => Hash::make($request->phone."@121"),
        ]);

        
        $user->syncRoles(3);
        $contact_info = [
            'phone' => $request->phone,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        $testimonial = [
            'title' => 'Testimonials',
            'description' => 'Our testimonial showing here',
        ];
        $products = [
            'title' => 'Products Catalogue',
            'description' => 'Explore our product',
            'label' => 'Visit Display ',
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
        
        // Micro Site Creation
        $ms = UserShop::create([
            'user_id' => $user->id,
            'name'=> $request->name,
            'slug'=> $request->phone, // TODO Add slugify function
            'description'    => null,
            'logo' => null,
            'contact_no' => $request->phone,
            'status' => 0, // Active
            'contact_info' => json_encode($contact_info),
            'products' => json_encode($products),
            'about' => json_encode($about),
            'story' => json_encode($story),
            'features' => json_encode($features),
            'team' => json_encode($team),
            'email' => null,
        ]);

        return redirect(route('auth.access-code').'?user_id='.$user->id);
    }

     public function accessCode(Request $request)
    {
        $user_id = $request->user_id;
        $user_data = User::whereId($user_id)->first();

        // magicstring($user_data);
         
         
        return view('frontend.login.access-code',compact('user_id','user_data'));
    }

    public function validateCode(Request $request)
    {
        // if(count($request->industry_id) > 1 ){
        //     return redirect()->back()->with('error','You can select only one industry, Please select only one industry');
        // }
        // Already Have AC
        $chk_existing_code = AccessCode::where('redeemed_user_id',$request->user_id)->first();
        if($chk_existing_code){
            return redirect()->back()->with('error',"You already redeemed $chk_existing_code->code, You cann't use more than one access code.");
        }

        // Check if Valid
        $user = User::whereId($request->user_id)->first();
        $industry_id = json_encode($request->industry_id);

        // Code Has
        if ($request->has('access_code') && $request->get('access_code') != null) {

            $chk_code = AccessCode::whereCode($request->access_code)->first();
            if(!$chk_code){
              return redirect()->back()->with('error','This access code is invalid!');
            }

             $chk_redeem = AccessCode::whereCode($request->access_code)->where('redeemed_user_id','!=',null)->first();

            //  Check already redeemed
            if($chk_redeem){
              return redirect()->back()->with('error','This access code is already redeemed!');
            }

            // Update Access Code 
            $chk_code->update([
                'redeemed_user_id' => $request->user_id,  
                'redeemed_at' => now()
            ]);

            $user->update([
                'is_supplier' => 0, //UnApproved Seller Panel
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
                $package_child->user_id = $request->user_id;
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
        

        
        if ($request->account_type == 'reseller' || $request->account_type == 'customer') {
            $mycustomer = 'no';
            $mysupplier = 'yes';
            $Filemanager = 'yes';
            $addandedit = 'no'; 
            $bulkupload = 'no';
            $pricegroup = 'no';
            $managegroup = 'yes';
            $manangebrands = 'no';
            $offers = 'yes';

        }elseif ($request->account_type == 'supplier' && $request->account_type == 'exporter') {
            $mycustomer = 'yes';
            $mysupplier = 'no';
            $Filemanager = 'yes';
            $addandedit = 'yes'; 
            $bulkupload = 'yes';
            $pricegroup = 'yes';
            $managegroup = 'yes';
            $manangebrands = 'no';
            $offers = 'yes';
        }else{
            # If Got Some Error
            // ! Taking as A customer
            $mycustomer = 'no';
            $mysupplier = 'yes';
            $Filemanager = 'yes';
            $addandedit = 'no';  
            $bulkupload = 'no';
            $pricegroup = 'no';
            $managegroup = 'yes';
            $manangebrands = 'no';
            $offers = 'yes';
        }

        $permission_user = ["mycustomer"=>$mycustomer,"manangebrands" => $manangebrands,"Filemanager" => $Filemanager,"addandedit"=> $addandedit,"pricegroup" => $pricegroup,"bulkupload"=> $bulkupload,"mysupplier"=> $mysupplier, "managegroup" => $managegroup,"offers" => $offers ];

        // Update Industry Info
        $user->update([
            'industry_id' =>  ["186"],
            'account_permission' => $permission_user,
            'account_type' => $request->account_type,
        ]);

        // Create Price Groups for User
        syncSystemPriceGroups($request->user_id);

        // Save VC Image
        if($request->hasFile("img")){
            $img = $this->uploadFile($request->file("img"), "user")->getFilePath();
            $filename = $request->file('img')->getClientOriginalName();
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if($filename != null){
                Media::create([
                    'type' => 'UserVcard',
                    'type_id' => $request->user_id,
                    'file_name' => $filename,
                    'path' => $img,
                    'extension' => $extension,
                    'file_type' => "Image",
                    'tag' => "vcard",
                ]);
            }
        }
        // Onsite
        $onsite_notification['user_id'] = $request->user_id;
        $onsite_notification['title'] = "Welcome to 121.page";
        $onsite_notification['link'] = "#";
        $onsite_notification['notification'] = "Our team is glad to see you in.";
        pushOnSiteNotification($onsite_notification);

        // Send Welcome Mail
        $mailcontent_data = MailSmsTemplate::where('code','=',"Welcome")->first();
        if($mailcontent_data){
            $arr=[
                '{id}'=>$request->user_id,
                '{app_name}'=>'121.page',
                '{name}'=>NameById($request->user_id),
                ];
            $action_button = null;
            TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
        }
        
        $mailcontent_data = MailSmsTemplate::where('code','=',"verify-mail")->first();

        if($mailcontent_data){
            $arr=[
                '{name}'=>$user->name,
                '{email}'=>$user->email,
                '{mobile}'=>$user->phone,
                ];
            $action_button = route('customer.verify.mail',$user->id);
            $action_button_2 = route('auth.login-index');
            $subject = DynamicMailTemplateFormatter($mailcontent_data->title, $mailcontent_data->variables, $arr);
            $body =  DynamicMailTemplateFormatter($mailcontent_data->body, $mailcontent_data->variables, $arr);
            $body .= '<br><br><div class="d-flex justify-content-between">
                            <a href="'. $action_button.'" class="btn btn-primary">Verify Email</a> 
                            <a href="'.$action_button_2.'" class="btn btn-outline-primary">Verify Email Address</a> 
                        </div>';
            StaticMail($user->name,$user->email, $subject, $body, $mail_footer = null, $action_button=null, $cc = null, $bcc = null,$attachment_path = null ,$attachment_name = null ,$attachment_mime = null);
        }
        
            // LogIn User
            auth()->loginUsingId($request->user_id);

            if ($user->industry_id == null || $user->industry_id == '') {
                $user->update([
                    'industry_id' => ["186"]
                ]);
            }
            // Seller
            if ($request->has('access_code') && $request->get('access_code') != null) {

                // Seller En-role Onsite
                $onsite_notification['user_id'] = $request->user_id;
                $onsite_notification['title'] = "Your Seller Profile has been created succesfully";
                $onsite_notification['link'] = "#";
                $onsite_notification['notification'] = "Our team is glad to see you in.";
                pushOnSiteNotification($onsite_notification);

                return redirect()->route('panel.dashboard')->with('success','Welcome to 121, Seller zone is activated successfully!');
            }else{
                return redirect()->route('customer.dashboard')->with('success','Welcome to 121.');
            }
          
    }

     
}
