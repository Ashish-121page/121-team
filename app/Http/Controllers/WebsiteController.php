<?php

namespace App\Http\Controllers;
use App\Models\UserEnquiry;
use App\Models\AccessCatalogueRequest;
use App\Models\Package;
use App\Models\UserPackage;
use App\Models\Category;
use App\Models\MailSmsTemplate;
use App\Models\Faq;
use App\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\search121;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Group;

use App\Models\shorturl;
use App\Models\shorturlvisitor;
use Carbon\Carbon;


class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function planIndex()
    {
        $packages = Package::where('is_published',1)->latest()->paginate(3);
        return view('frontend.website.plan.index',compact('packages'));
    }

    public function index()
    {
       // Get Verified Customer Image Data
       $verify_customer = DB::table('user_shops')->where('demo_given','=',1)->get();
       return view('frontend.website.newhome',compact('verify_customer'));
    }

    public function demoform()
    {
        return view('frontend.website.booksession.index');
    }

     public function formjaya()

    {
        return view('frontend.website.booksession.jayaform23');
    }
    
     public function feedbackform()
    {
        return view('frontend.website.feedback.index');
    }
    
    
    public function microSiteProxy(Request $request)
    {
        
        $subdomain = $request->shop;
        $path = $request->page;
        
        $accessToken = "";

        if($request->is_scan == 1){
            $isScan = 1;
        }else{
            $isScan = 0;
        }       

        if(auth()->check()){
         
          $userId =  UserShopUserIdBySlug($request->shop);
          if($userId == auth()->id()){
            return back()->with('error','You can not scan your own scanner');
          }

            if (strpos($path, '?') !== false) {
                $accessToken = "&at=".encrypt(auth()->id())."&scan=$isScan";
            }else{
                $accessToken = "?at=".encrypt(auth()->id())."&scan=$isScan";
            } 
        }

        if($request->has('g_id') && $request->get('g_id') != null){
            $g_id = $request->get('g_id');
            
        }else{
            $g_id = 0;
        }

        if (str_contains($accessToken, '&')) { 
            $accessToken .= "&g_id=".$g_id;
        }else{
            $accessToken .= "?g_id=".$g_id;
        }

        $domain = env('APP_DOMAIN');
        $channel = env('APP_CHANNEL');
        
        $url = $channel.$subdomain.'.'.$domain.'/'.$path."$accessToken";
        if(auth()->check()){
            
          // Update Price Group
            $supplier_id = UserShopUserIdBySlug($request->shop);
            $supplier_record = User::whereId($supplier_id)->first();
            $acr_exists = AccessCatalogueRequest::where('user_id',auth()->id())->where('number',$supplier_record->phone)->exists();
            if(!$acr_exists){
                
                if($supplier_record){
                 $acr =  AccessCatalogueRequest::create([
                        'user_id' => auth()->id() ?? '0',
                        'number' => $supplier_record->phone,
                        'price_group_id' => $g_id,
                        'status' => 1,
                        'supplier_name' => $supplier_record->name,
                    ]); 
                    $acr->save();
        
                    // notification sent to Supplier
                    $onsite_notification['user_id'] =  $supplier_id;
                    $onsite_notification['title'] = "There is a new seller in your collection. Default price is assigned. To assign a price group, click here. ";
                    $onsite_notification['link'] = route('panel.seller.my_reseller.index');
                    pushOnSiteNotification($onsite_notification);
        
                    // notification sent to Seller
                    $onsite_notification['user_id'] =  auth()->id();
                    $onsite_notification['title'] = "Great! A New Supplier added to My Collections ";
                    $onsite_notification['link'] = route('panel.seller.my_supplier.index');
                    pushOnSiteNotification($onsite_notification);
        
                }
                // return $url;
                return redirect($url);
            }else{
                return back()->with('error','Request is already Sent!'); 
            }
        }else{
           return redirect($url)->with('error','Please login to add site to my collections!'); 
        }

    }



    public function checkout(Request $request, $id)
    {
        // return $request->all();
        $user = auth()->user();
        $full_name = explode(' ',$user->name);
        $firstname = array_shift($full_name);
        $lastname = implode(" ", $full_name);
        $package = Package::whereId($request->package_id)->firstOrFail();
        return view('frontend.website.plan.checkout',compact('package','firstname','lastname','user'));
    }
    public function checkoutIndex(Request $request, $id)
    {
        $user = auth()->user();
        $full_name = explode(' ',$user->name);
        $firstname = array_shift($full_name);
        $lastname = implode(" ", $full_name);
        $package = Package::whereId($request->package_id)->firstOrFail();

        return view('frontend.website.plan.checkout',compact('package','firstname','lastname','user'));
    }


    
    public function checkoutStore(Request $request, $id)
    {
        // return $id;
        if(!auth()->check()){
            return redirect(route('auth.login-index'));
        }
        if(AuthRole() == 'Admin'){
            return back()->with('error','Admin does not have permission to access this page!');
        }
        // if(auth()->user()->is_supplier != 1){
        //     return back()->with('error','You must have an seller account to purchase this package');
        // }
        
        // if(!UserAddress::whereUserId(auth()->id())->first()){
        //     return redirect(route('customer.dashboard').'?active=account&subactive=my_address')->with('error','Please add your address first!');
        // }

        $user = auth()->user();
        $full_name = explode(' ',$user->name);
        $firstname = array_shift($full_name);
        $lastname = implode(" ", $full_name);
  
        $package = Package::whereId($id)->first();
        if(!$package){
            return back()->with('error','Invalid Package');
        }

        $order = new Order();
        $order->user_id=auth()->id();
        $order->flag= 0;
        $order->type='Package';
        $order->type_id=$request->package_id;
        $order->txn_no='ORD'.rand(00000,99999);
        $order->discount=null;
        $order->tax=null;
        $order->sub_total=$package->price ?? 0;
        $order->total=$package->price ?? 0;
        $order->status=1;
        $order->payment_status=1;
        $order->payment_gateway=null;
        $order->remarks="Package Purchase";
        $order->from = invoiceFrom(); // For Invoice From details
        $order->to=null; // / For Invoice From details
        $order->date=now();
        $order->save();

        $order_item = new OrderItem();
        $order_item->item_type = "Package";
        $order_item->item_id = $request->package_id;
        $order_item->order_id = $order->id;
        $order_item->qty = 1;
        $order_item->price = $package->price;
        $order_item->save();
            
       return view('frontend.website.plan.checkout',compact('package','firstname','lastname','user', 'order'));
    }

    public function about()
    {
        return view('frontend.website.about'); 
    }

    public function contact()
    {
        return view('frontend.website.contact.index'); 
    }
    public function faq()
    {
        $categories = Category::where('category_type_id',12)->whereId(request()->get('category_id'))->get();
        $faqs = Faq::where('is_publish',1)->latest()->paginate(10);
        return view('frontend.website.faq',compact('faqs','categories'));
    }
    public function contactStore(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
            ]);
            $data = new UserEnquiry();
            $data->name=$request->name;
            $data->email=$request->email;
            $data->type='website_enquiry';
            $data->type_id=null;
            $data->status=0;
            $data->subject=$request->subject;
            $data->description=$request->description;
            $data->save();
            // Mail Admin
                 $mail_code = "user-enquiry-to-admin";

                 $mailcontent_data = MailSmsTemplate::whereCode($mail_code)->first();
                 if($mailcontent_data){
                    $mail_arr = [
                    "{name}" => $request->name,
                    "{subject}" => $request->subject,
                    "{email}" => $request->email,
                 ];
                 TemplateMail("Admin", $mail_code, getSetting('frontend_footer_email'), $mailcontent_data->type, $mail_arr,$mailcontent_data,$mailcontent_data->footer,null);
            }
            // Mail User
                 $mail_code = "enquiry-mail-to-user";

                 $mailcontent_data = MailSmsTemplate::whereCode($mail_code)->first();
                 if($mailcontent_data){
                    $mail_arr = [
                    "{name}" => $request->name,
                    "{app_name}" => getSetting('app_name'),
                 ];
                 TemplateMail($request->name, $mail_code, $request->email, $mailcontent_data->type, $mail_arr,$mailcontent_data,$mailcontent_data->footer,null);
            }

            return back()->with('success', 'Thank you for contacting us! Our team of experts
        will get in touch with you shortly.');
        } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
     public function questionStore(Request $request)
    {
        // return $request->all();
        session()->flash('start-otp');
        $phone = implode('',$request->phone);
        $otp = rand(1000,9999);
        $mailcontent_data = MailSmsTemplate::where('code','=',"otp-send")->first();
        if($mailcontent_data){
            $arr=[
                '{OTP}'=>$otp,
             ];
             $msg = DynamicMailTemplateFormatter($mailcontent_data->body,$mailcontent_data->variables,$arr);
            //  sendSms($phone,$msg,$mailcontent_data->footer);
        }
        try {
            $questions = getJoiningQuestions();
            $message = ""; 
            if($request->has('q1')){
                $message .= $questions[0]['question']." - ".$request->q1."\r\n";
            }
            if($request->has('q2')){
                $message .= $questions[1]['question']." - ".$request->q2."\r\n";
            }
            if($request->has('q3')){
                $message .= $questions[2]['question']." - ".$request->q3."\r\n";
            }
            if($request->has('q4')){
                $message .= $questions[3]['question']." - ".$request->q4."\r\n";
            }
            if($request->has('q5')){
                $message .= $questions[4]['question']." - ".$request->q5."\r\n";
            }

            $data = new UserEnquiry();
            $data->name=$request->name;
            $data->email='guest@test.com';
            $data->contact_number=$phone;
            $data->status=0;
            $data->code=$request->code;
            $data->subject='New Poll Submission';
            $data->description= $message;
            $data->save();  
            // $mailcontent_data = MailSmsTemplate::where('code','=',"book-demo")->first();
            // if($mailcontent_data){
            //     $arr=[
            //         '{at}'=>date("Y-m-d", strtotime('tomorrow')),
            //         '{for}'=>'121 Plateform Demo',
            //     ];
            //     $msg = DynamicMailTemplateFormatter($mailcontent_data->body,$mailcontent_data->variables,$arr);
            //     sendSms($phone,$msg,$mailcontent_data->footer);
            // }

            $message = array('message' => 'Success!', 'title' => 'Thank you for your response');
            return response()->json($message);

           
        } catch (\Exception $e) {
            return response(['error', 'Error: ' . $e->getMessage()],200);
        }
    }
    protected function joinValidateOTP(Request $request)
    {
        $get_otp = implode('',$request->otp);
        if (session()->get('otp') == $get_otp) {
        $phone = session()->get('phone');
        $user = User::where('phone','!=',null)->wherePhone($phone)->first();
        if ($user) {
            if(auth()->check()){
                auth()->logout();
            }

            // Setting Dynamic Session Domain for logging in

            auth()->loginUsingId($user->id);
            
            // if(AuthRole() == "User"){
            //     return redirect()->route('customer.dashboard');
            // }else{
            //     return redirect()->route('panel.dashboard');
            // }
        } else {
            return redirect(route('auth.signup'));
        }
        } else {
            return back()->with('error','The OTP entered is incorrect');
        }
    }
    public function packageStore(Request $request)
    {
        // return $request->all();
        try {
            $user = User::whereId(auth()->id())->firstOrFail();
            $package = Package::whereId($request->package_id)->firstOrFail();
            if($package->duration == null){
                $duration = 30;
            }else{
                $duration = $package->duration;
            }
            $order = Order::whereId($request->order_id)->firstOrFail();
            $address = UserAddress::whereId($request->address)->firstOrFail();
            if(!$address){
                return back()->with('error','Invalid Address, Please choose a new address');
            }
            
            // Static Order Data Creation
            $customer_details = [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ];
            $customer_details = json_encode($customer_details);

            // Address Object Prepration
            $to = json_decode($address->details);
            $to->type = $address->type;
            $to = json_encode($to);

            // POST Payment
            $order->update([
                'status' => 5, //Completed
                'payment_status' => 2, //Paid
                'customer_details' => $customer_details,
                'to' => $to,
            ]);

            $user_package = UserPackage::whereUserId(auth()->id())->first();
            if ($user_package) {
               $package_to = \Carbon\Carbon::parse($user_package->to)->addDays($duration);
                $user_package->update([
                    'user_id' => auth()->id(),
                    'package_id' => $request->package_id,
                    'order_id' => $order->id,
                    'from' => $user_package->to,
                    'to' => $package_to,
                    'limit' => $package->limit,
                ]);
                return redirect(route('panel.dashboard'))->with('success', 'Your Package! '.$package->name.' Updated.');
            } else {
                $data = new UserPackage();
                $data->user_id = auth()->user()->id;
                $data->package_id = $request->package_id;
                $data->order_id = $order->id;
                $data->from = now();
                $data->to = now()->addDays($duration);
                $data->limit = $package->limit;
                $data->save();
                return redirect(route('panel.dashboard'))->with('success', 'Payment Successfully Done! '.$package->name.' activated.');
            }
        } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    /*
    public function joinIndex()
    {
        $otp = session()->put('start_otp',rand(1000,9999));
        return view('frontend.website.join.index'); 
    }
    */

    public function joinIndex(){
        return view('frontend.website.booksession.index');
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
        //
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

    public function resendStartOTP(Request $request)
    {
        $otp = rand(1000,9999);
        $phone = $request->phone;
        $mailcontent_data = MailSmsTemplate::where('code','=',"otp-send")->first();
        if($mailcontent_data){
            $arr=[
                '{OTP}'=>$otp,
             ];
             $msg = DynamicMailTemplateFormatter($mailcontent_data->body,$mailcontent_data->variables,$arr);
             sendSms($phone,$msg,$mailcontent_data->footer);
        }

       return response([
        'otp' => $otp,
        'status' => 1,
       ]);
    }



     function shorturlrefer($id) {
        if ($data = shorturl::where('url_key',$id)->first()) {
            $current_time = Carbon::now();
            $single = $data->single_use;

            if ($data->deactivated_at != null) {
                if ($data->deactivated_at <= $current_time) {
                    echo "<font color='red' size='5rem'><center><b>Expired Link!!<b></center></font>";
                }else{
                    shorturlvisitor::create(['url_key'=>$id]);
                    if ($single) {
                        $data->deactivated_at = $current_time;
                        $data->save();
                    }
                    return redirect($data->destination_url);
                }
            }else{
                shorturlvisitor::create(['url_key'=>$id]);
                if ($single) {
                    $data->deactivated_at = $current_time;
                    $data->save();
                 }
                return redirect($data->destination_url);
            }



        }else{
            echo "<font color='red' size='5rem'><center><b>Invalied Link!! Please Check<b></center></font>";
        }
    }

    function manageurl(Request $request) {
        $short_url = shorturl::latest()->paginate(10);

        // Search url With URL KEy
        if ($request->get('searchkey')) {
            $short_url = shorturl::where('url_key','Like','%'.$request->searchkey.'%')->paginate(10);
        }

        return view("panel.short_url.index",compact("request",'short_url'));
    }

    function createurl(Request $request) {
        $url = $request->url;
        $unique_key = $request->key;

        // check Id Url Is already Exist
        $chk = shorturl::where('url_key',$unique_key)->count();
        if ($chk != 0) {
            return "The Unique Id Already Exists With Another URL";    
        }

        return shrinkurl($url,$unique_key);
    }
    
    

    function editurl($id) {
        
        $short_url = shorturl::find($id);

        return view('panel.short_url.edit',compact('short_url'));
    }

    function updateurl(Request $request, $id) {
        try {            
            $short_url = shorturl::find($id);
            $short_url->destination_url = $request->get('newurl');
            $short_url->save();
            return back()->with('success','Url Updated Successfully');
            
        } catch (\Throwable $th) {
            return back()->with('error','Error While Updating, '.$th);
        }
        


    }


    function loginasguest(){
        try {

            $id = 117;
            $user = User::find($id);

            session(['temp_user_id' => $user->id]);
            session(['at' => encrypt($user->id)]);

            // Login.
            auth()->loginUsingId($user->id);

            // Redirect.
            // return redirect(route('panel.dashboard'));
            // return back()->with('success',"Please Reopen Link");
            
            return redirect(inject_subdomain('home', getShopSlugByUserId($id) , true, true));

        
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    function deleteurl(Request $request, $id){
        try {    
            $item  = shorturl::find($id);
            $item->delete();
            return back()->with('success','URL Deleted Successfully');
        } catch (\Throwable $th) {
            return back()->with('error','Error While Deleting, '.$th);
        }        
    }

    function searchon121(Request $request) {
        
        // magicstring($request->all());

        // Getting All Records
        // $data = search121::latest()->paginate(20);
        $searchQuery = $request->searchquery;

        if ($searchQuery == null) {
            $data = [];
            return view('frontend.website.search.index',compact('request','searchQuery','data'));
        }



        $data = search121::
                where('name','LIKE','%'.$searchQuery.'%')->
                orwhere('last_name','LIKE','%'.$searchQuery.'%')->
                orwhere('entity_name','LIKE','%'.$searchQuery.'%')->
                orwhere('entity_name_middle','LIKE','%'.$searchQuery.'%')->
                orwhere('entity_name_last','LIKE','%'.$searchQuery.'%')->
                orwhere('website','LIKE','%'.$searchQuery.'%')->
                orwhere('state','LIKE','%'.$searchQuery.'%')->
                orwhere('email_primary','LIKE','%'.$searchQuery.'%')->
                orwhere('email_2','LIKE','%'.$searchQuery.'%')->
                orwhere('email_3','LIKE','%'.$searchQuery.'%')->
                orwhere('phone_primary','LIKE','%'.$searchQuery.'%')->
                orwhere('phone_2','LIKE','%'.$searchQuery.'%')->
                orwhere('phone_3','LIKE','%'.$searchQuery.'%')->
                orwhere('phone_4','LIKE','%'.$searchQuery.'%')->
                orwhere('tags','LIKE','%'.$searchQuery.'%')->
                latest()->paginate(20);


        return view('frontend.website.search.index',compact('request','searchQuery','data'));        
    }
    // Sending Request from 121 Search

    function searchreq(Request $request) {
        // magicstring($request->all());

        $passcode = $request->get('passcode');
        $passcode_2 = $request->get('passcode_2');
        $passcode_3 = $request->get('passcode_3');
        $passcode_4 = $request->get('passcode_4');

        $ask_id = $request->get('ask_id');
        $phonechk = search121::where('id',$ask_id)->first();


        if ($phonechk->phone_primary != null) {
            $chk1 = substr($phonechk->phone_primary,-4) == $passcode;
        }else{
            $chk1 = false;
        }


        if ($phonechk->phone_2 != null) {
            $chk2 = substr($phonechk->phone_2,-4) == $passcode_2;
        }else{
            $chk2 = false;
        }


        if ($phonechk->phone_3 != null) {
            $chk3 = substr($phonechk->phone_3,-4) == $passcode_3;
        }else{
            $chk3 = false;
        }


        if ($phonechk->phone_4 != null) {
            $chk4 = substr($phonechk->phone_4,-4) == $passcode_4;
        }else{
            $chk4 = false;
        }


        if ($chk1 || $chk2 || $chk3 || $chk4) {

            // Sending Request
            $number = $phonechk->phone_primary;
            $user = User::where('id','!=',auth()->id())->where('phone',$number)->first();
            if(!$user){
                $user = User::where('id','!=',auth()->id())
                ->whereJsonContains('additional_numbers',$number)
                ->first();
            }else{
                // Check duplicated
                $chk = AccessCatalogueRequest::whereUserId(auth()->id())->where('status','!=',4)->whereNumber($number)->first();
                if($chk){
                    $status = "FAILED";
                    $alert = "error";
                    $message = "Request already sent.";
                    $response_code = 400;
                    $color = "#f2a654";
                    $response = array(
                        "status" => $status ?? "",
                        "msg" => $message ?? "",
                        "code" => $response_code ?? "" ,
                        "alert" => $alert ?? "",
                        "color" => $color ?? "",
                    );  
            
                    return $response;

                }
            }


            // Checking PAckage Validity
            if(AuthRole() == "User"){
                // Check Who sent the request have package or not
                if($request->status == 0){
                    // chk user have active package or not!
                  if(!haveActivePackageByUserId(auth()->id())){
                        $status = "FAILED";
                        $alert = "error";
                        $message = "You Don't Have An Active Package";
                        $response_code = 400;
                        $color = "#f2a654";
                        $response = array(
                            "status" => $status ?? "",
                            "msg" => $message ?? "",
                            "code" => $response_code ?? "" ,
                            "alert" => $alert ?? "",
                            "color" => $color ?? "",
                        );  
                
                        return $response;

                  } 
                }     
            }
            
            // Plan Check
            $package = getUserActivePackage(auth()->id());
            $limits = json_decode($package->limit,true);
            $add_to_site = AccessCatalogueRequest::where('user_id',auth()->id())->get()->count();
            if($limits['add_to_site'] <= $add_to_site){
                $status = "FAILED";
                $alert = "error";
                $message = "Your Add to Site Limit exceed!";
                $response_code = 400;
                $color = "#f2a654";
                $response = array(
                    "status" => $status ?? "",
                    "msg" => $message ?? "",
                    "code" => $response_code ?? "" ,
                    "alert" => $alert ?? "",
                    "color" => $color ?? "",
                );  
        
                return $response;

            }

            
            $data = AccessCatalogueRequest::whereNumber($number)->where('user_id',auth()->id())->first();
            if(!$data){
                $data = new AccessCatalogueRequest();
            }
            
            $data->user_id=auth()->id();
            $data->status=0;
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
                $status = "PASS";
                $alert = "success";
                $message = "Catalogue request sent. Added in your Collection.";
                $response_code = 200;
                $color = "#f96868";
                $response = array(
                    "status" => $status ?? "",
                    "msg" => $message ?? "",
                    "code" => $response_code ?? "" ,
                    "alert" => $alert ?? "",
                    "color" => $color ?? "",
                );  
        
                return $response;
            }
            
            $status = "SENT";
            $alert = "success";
            $message = "Catalogue request sent. Added in your Collection.";
            $response_code = 200;
            $color = "#f96868";
            $response = array(
                "status" => $status ?? "",
                "msg" => $message ?? "",
                "code" => $response_code ?? "" ,
                "alert" => $alert ?? "",
                "color" => $color ?? "",
            );  
    
            return $response;

        }else{
            $status = "RETRY";
            $alert = "error";
            $message = "Incorrect Number";
            $response_code = 400;
            $color = "#f2a654";
            $response = array(
                "status" => $status ?? "",
                "msg" => $message ?? "",
                "code" => $response_code ?? "" ,
                "alert" => $alert ?? "",
                "color" => $color ?? "",
            );  
            return $response;
        }

    }



    function expired(Request $request) {
        
        return view('expired');
    }
    
    
    
}
 