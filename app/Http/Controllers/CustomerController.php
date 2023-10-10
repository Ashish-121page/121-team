<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use File;
use App\Models\Order;
use App\Models\UserShop;
use App\Models\AccessCatalogueRequest;
use App\Models\Enquiry;
use App\Models\AccessCode;
use App\Models\City;
use App\Models\LockEnquiry;
use App\Models\UserAddress;
use App\Models\Notification;
use App\Models\UserPackage;
use App\Models\Package;
use App\Models\Media;
use App\Models\Proposal;
use App\Models\Proposalenquiry;
use App\Models\ProposalItem;
use Illuminate\Support\Facades\DB;
use App\Models\SupportTicket;
use App\Models\survey;
use App\Models\TicketConversation;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use App\Models\Product;
use Carbon\Carbon;

use App\Models\Inventory;
use App\Models\Team;



class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chatIndex()
    {
        $user = auth()->user();
        $enquiry = Enquiry::whereUserId(auth()->id())->get();
        return view('frontend.customer.chat.index',compact('user','enquiry'));
    }
    public function ticketChatStore(Request $request)
    {
        $this->validate($request, [
            'comment'     => 'required',
            'type_id'     => 'required'
        ]);

            $data          = new TicketConversation();
            $data->user_id = auth()->id();
            $data->type    = 'Support Ticket';
            $data->type_id = $request->type_id;
            $data->comment = $request->comment;
            $data->save();

            $support_ticket = SupportTicket::whereId($request->type_id)->orderBy('created_at','DESC')->first();
            $support_ticket->update([
                'status' => 0
            ]);

            if($request->has('attachment')){
                $img = $this->uploadFile($request->file("attachment"), "support-ticket")->getFilePath();
                $filename = $request->file('attachment')->getClientOriginalName();
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
            }else{
                $filename = null;
            }
            if($filename != null){
                    Media::create([
                        'type' => 'SupportTicket',
                        'type_id' => $request->type_id,
                        'file_name' => $filename,
                        'path' => $img,
                        'extension' => $extension,
                        'file_type' => "Image",
                        'tag' => "SupportTicketAttachment",
                    ]);
                }

            return back()->with('success','Message Sent Successfully');

    }
      public function supportTicketShow(Request $request,$id)
    {

        $user = auth()->id();
        $user_shop = UserShop::whereUserId($user)->first();
        $ticket = SupportTicket::whereId($id)->whereUserId(auth()->id())->firstOrFail();
        $medias = Media::whereType('SupportTicket')->whereTypeId($id)->get();
        $conversations = TicketConversation::whereType('Support Ticket')->whereTypeId($id)->get();
        return view('frontend.customer.support-ticket.show',compact('ticket','medias','user','conversations','user_shop'));
    }
    public function scanCode()
    {
        return $request->all();
    }
    public function chatShow($id)
    {
        $user = auth()->user();
        $enquiry = Enquiry::whereId($id)->where('user_id',auth()->id())->first();
        if(!$enquiry){
            return redirect(route('customer.dashboard')."?active=enquiry")->with('error','Enquiry doesn\'t exists!');
        }
         $user_shop = UserShop::whereUserId($user->id)->first();
        if(!UserShop::whereId($enquiry->micro_site_id)->first()){
            return back()->with('error','Something went wrong!');
        }
        $micro_site = UserShop::whereId($enquiry->micro_site_id)->firstOrFail();
        $author = User::whereId($micro_site->user_id)->firstOrFail();
        $receiver = $enquiry->user_id;
        $sender = UserShop::whereId($enquiry->micro_site_id)->first()->user_id;
        $chats = TicketConversation::whereEnquiryId($id)->get();
        return view('frontend.customer.chat.show',compact('user','enquiry','sender','chats','micro_site','author','receiver','user_shop'));
    }

     public function dashboard(Request $request)
     {


        $slug = Usershop::where('user_id',auth()->user()->id)->first()->slug;
        if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id")){
            //
        }else{
            if (auth()->id() == 155 || auth()->user()->name == "GuestUser") {
                return redirect(inject_subdomain('home',$slug,true,false))->with('error',"You Have to login for Manage Profile");
            }
        }

        if(!$request->has('active')){
            $active = "dashboard";
            return redirect(route('customer.dashboard')."?active=$active");
        }


        $user = auth()->user();
        $additional_numbers = json_decode($user->additional_numbers);
        $orders = Order::whereIn('flag',[1,2])->whereUserId(auth()->id())->latest()->simplePaginate(10);

        if(!$request->has('collection_status')){
                $collections = AccessCatalogueRequest::whereUserId(auth()->id())->latest()->simplePaginate(10);
        }else if($request->get('collection_status') || $request->get('collection_status') == 0){
            $collections = AccessCatalogueRequest::whereStatus($request->get('collection_status'))->whereUserId(auth()->id())->latest()->simplePaginate(10);
        }
        $addresses = UserAddress::whereUserId(auth()->id())->simplePaginate(10);
        $tickets = SupportTicket::whereUserId(auth()->id())->simplePaginate(10);
        $vcard = Media::whereTypeId($user->id)->whereType('UserVcard')->whereTag('vcard')->first();
        $user_shop = UserShop::whereUserId($user->id)->first();


        if($user_shop){
            $story = json_decode($user_shop->story,true);
            $media = Media::whereTypeId($user_shop->id)->whereType('UserShop')->whereTag('Banner')->first();
        }
        else{
            $story = null;
            $media = null;

        }

        // ajax Search
        $search = "";
        if($request->get('search')){
            $search = $request->search;
            $collections = AccessCatalogueRequest::orwhere('supplier_name','Like','%'.$request->get('search').'%')->orWhere('number','like','%'.$request->get('search').'%')->whereUserId(auth()->id())->simplePaginate(10);

        }

        if ($request->ajax()) {
            $collections = AccessCatalogueRequest::orWhere('number','like','%'.$request->get('search').'%')
                ->whereUserId(auth()->id())
                ->get();
            return response()->json(['result'=>$collections]);
        }


        $order_by_name= $request->has('orders') ?? "";
        if($order_by_name != ""){
            $order_by_name = $request->has('order') ?? "";
            $collections = AccessCatalogueRequest::orderBy('id','DESC')->whereUserId(auth()->id())->latest()->simplePaginate(10);
        }


        $order_by_name= $request->has('orderc') ?? "";
        if ($order_by_name != "") {
            $order_by_name= $request->has('orderc') ?? "";
            $my_resellers = AccessCatalogueRequest::orderBy('id','DESC')->where("number","=",auth()->user()->phone)->simplePaginate(10);
        }


        $my_resellers = AccessCatalogueRequest::where("number","=",auth()->user()->phone)->simplePaginate(10);

        $enquiry = Enquiry::whereUserId(auth()->id())->simplePaginate(10);


        // Get Verified Customer Image Data
        $verify_customer = DB::table('user_shops')->where('demo_given','=',1)->get();


        $sortoffer = $request->get('sortoffer');
        if (isset($sortoffer)) {
            if ($sortoffer == 0) {
                // echo "sort by Default";
                $proposals = Proposal::where('user_id',auth()->id())->orwhere('relate_to',$user_shop->id)->orderBy('updated_at','DESC')->orderBy('created_at','DESC')->get();
            }
            if ($sortoffer == 1) {
                // echo "sort by Last Open";
                $proposals = Proposal::where('user_id',auth()->id())->orwhere('relate_to',$user_shop->id)->orderBy('last_opened','DESC')->get();
            }
            if ($sortoffer == 2) {
                // echo "sort by Last Used";
                $proposals = Proposal::where('user_id',auth()->id())->orwhere('relate_to',$user_shop->id)->orderBy('updated_at','DESC')->get();
            }
            if ($sortoffer == 3) {
                // echo "sort by Name";
                $proposals = Proposal::where('user_id',auth()->id())->orwhere('relate_to',$user_shop->id)->orderBy('customer_details','ASC')->get();
            }
            if ($sortoffer == 4) {
                // echo "sort by Create Date";
                $proposals = Proposal::where('user_id',auth()->id())->orwhere('relate_to',$user_shop->id)->orderBy('created_at','DESC')->get();
            }
            if ($sortoffer == 5) {
                // echo "sort by views";
                $proposals = Proposal::where('user_id',auth()->id())->orwhere('relate_to',$user_shop->id)->orderBy('view_count','ASC')->get();
            }
        }else{
            // echo "sort by Default";
            $proposals = Proposal::where('user_id',auth()->id())->orwhere('relate_to',$user_shop->id)->orderBy('updated_at','DESC')->orderBy('created_at','DESC')->get();
        }

        $PROPOSAL = Proposal::where('user_id',auth()->id())->pluck('id');
        $proposal_enquiry = Proposalenquiry::whereIn("proposal_id",$PROPOSAL)->groupBy('proposal_id')->get();
        $enquiry_amt = 0;

        foreach ($proposal_enquiry as $key => $item) {
            $value = explode("₹",$item->amount);
            $newval = str_replace(",","",$value[1]);
            $enquiry_amt = $enquiry_amt + intval($newval);
        }
        $Numbverofoffer = ($PROPOSAL != null) ? count($PROPOSAL) : 0;

        // `no of Product
        $products = Product::where('user_id',auth()->id())->pluck('id');
        $productcount = ($products != null) ? count($products) : 0;

         // member
        $usershop = getShopDataByUserId(auth()->id());
        $teams = Team::where('user_shop_id',$usershop->id)->get();

        $laststockUpdate = Inventory::where('user_id',$user->id)->latest('updated_at')->first();
        $today = Carbon::now();

        if ($laststockUpdate != null) {
            $lastupdatediffrence = $today->diffInDays($laststockUpdate->updated_at,true);
        }else {
            $lastupdatediffrence = 'never';
        }


        // dd($proposals);
        return view('frontend.customer.dashboard.index',compact('user','enquiry','search','collections','orders','addresses','tickets','vcard','user_shop','media','story','additional_numbers','my_resellers','verify_customer','proposals','request','enquiry_amt','Numbverofoffer','productcount','teams','lastupdatediffrence'));

    }

    function checksample(Request $request ,Proposal $proposal) {


        $proposal_enquiry = Proposalenquiry::where('proposal_id',$proposal->id)->first();
        $proposal_name = json_decode($proposal->customer_details)->customer_name ?? '';
        $proposal_phone = json_decode($proposal->customer_details)->customer_mob_no ?? '';
        $proposal_email = json_decode($proposal->customer_details)->customer_email ?? '';

        if ($proposal_enquiry != null) {
            $asked_sample = explode(",",$proposal_enquiry->proposal_item_id);
        }else{
            $asked_sample = [];
        }

        return view("frontend.customer.dashboard.checksample", compact('proposal','asked_sample','proposal_enquiry','proposal_name','proposal_phone','proposal_email'));
    }



     public function invoice($id)
    {
        $order = Order::whereId($id)->first();
        return view('frontend.customer.dashboard.invoice',compact('order'));
    }
     public function notification()
    {
        $notifications = Notification::whereUserId(auth()->id())->latest()->simplePaginate(10);
        return view('frontend.customer.notifications.index',compact('notifications'));
    }

     public function notificationShow($id)
    {
        $notification = Notification::whereId($id)->first();
        $notification->is_readed = 1;
        $notification->save();
        if(trim($notification->link) != '#' && $notification->link != null){
           return redirect($notification->link);
        }else{
            return redirect(route('customer.dashboard'));
        }
    }
     public function VerifyMail($user_id)
    {
        $user = App\User::whereId($user_id)->first();
        if($user){
            $user->update([
                'email_verified_at' => now()
            ]);
        }else{
            abort(404);
        }
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
    public function sendVerificationLink(EmailVerificationRequest $request)
    {

    }

    public function updateOrderStatus(Request $request)
    {
        $order = Order::whereId($request->order_id)->first();
        if($request->hasFile("transaction_file")){
            $file = $this->uploadFile($request->file("transaction_file"), "transaction_details")->getFilePath();
        } else {
            $file = null;
        }
        $details = [
            'transaction_id' => $request->transaction_id,
            'transaction_file' => $file,
        ];

        $seller_details = json_encode($details);
        $order->update([
           'seller_payment_details' =>$seller_details,
           'status' =>$request->status,
           'pyament_status' =>1,
        ]);
        return back()->with('success','Your Order appeal sent successfully');
    }

    public function ticketStatusClose(Request $request,$id,$status)
    {
        $support_ticket = SupportTicket::whereId($id)->first();
        if($support_ticket){
            if($status == 2){
                $support_ticket->update([
                   'status' =>$status,
                ]);
            }
        }else{
            abort(404);
        }

        return back()->with('success','Status updated!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function requestCatalogueCustomer(Request $request)
    {
        // $number = implode('',$request->number);
        $number = $request->number;
            if($number == auth()->user()->phone){
                return redirect()->back()->withInput()->with('error', 'Requests cannot be sent to your own number');
            }

            if (strlen($number) > 10) {
                // return redirect()->back()->withInput()->with('error', 'Use a number that is not less than 10 digits' );
                return redirect()->back()->withInput()->with('error', 'Invalid Mobile Number' );
            }

            if (strlen($number) < 10) {
                return redirect()->back()->withInput()->with('error', 'Use a number that Has 10 digits' );
            }

            // Send Catalogue
            if($request->status == 1){
                $user = User::where('phone',$number)->first();
                if(!$user){
                    return back()->with('error',"User doesn't exsist!");
                }
                $chk = AccessCatalogueRequest::where('user_id',$user->id)->where('status',1)->where('number',auth()->user()->phone)->first();
                if($chk){
                    return back()->with('error',"You already give access to this user.");
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

            // Check duplicated
            $chk = AccessCatalogueRequest::whereUserId(auth()->id())->where('status','!=',4)->whereNumber($number)->first();
            if($chk){
                 return redirect()->back()->withInput()->with('error', 'Request is already sent to user.' );
            }

        // try {
            $user = User::wherephone($number)->orwhere('additional_numbers','LIKE',"%$number%")->first() ?? $request->supplier_name;

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
                if(isset($seller_rec) && isset($requested_seller)){
                    $onsite_notification['user_id'] =  $seller_rec->id;
                    $onsite_notification['title'] = $requested_seller->name. " has sent you a connection request." ;
                    $onsite_notification['link'] = route('panel.seller.supplier.index');
                    pushOnSiteNotification($onsite_notification);
                }
            }elseif($request->status == 1){
               $data = AccessCatalogueRequest::whereNumber(auth()->user()->phone)->where('user_id',$user->id)->first();
                if(!$data){
                    $data = new AccessCatalogueRequest();
                }
                $data->user_id=$user->id;
                $data->status=1;
                $data->price_group_id=$request->price_group_id;
                $data->number=auth()->user()->phone;
                // $data->supplier_name = $request->supplier_name;
                $data->supplier_name = $user->name;
                $data->save();
            }
            return back()->with('success', 'Catalogue request created successfully!');
        // } catch (\Exception $e) {
        //     return back()->with('error', 'Error: ' . $e->getMessage());
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shopUpdate(Request $request, $id){
        $this->validate($request, [
            'name'     => 'required',
            'description'     => 'sometimes',
            'logo'     => 'sometimes',
            'contact_no'     => 'sometimes',
            'address'     => 'sometimes',
        ]);
        try {

            $contact_info = [
                'phone' => $request->phone,
                'email' => $request->email,
                'location' => $request->location,
                'whatsapp' => $request->whatsapp,
            ];
            $address = [
                'flat_number' => $request->flat_number,
                'floor' => $request->floor,
                'building_name' => $request->building_name,
                'line_3_address' => $request->line_3_address,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
            ];
            $request['social_links'] = json_encode($request->social_link);
            $request['contact_info'] = json_encode($contact_info);
            $request['address'] = json_encode($address);
            $user_shop = UserShop::whereId($id)->first();
            $user_shop->update($request->all());
            return back()->with('success', 'Catalogue request sent to user!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function updateShopAbout(Request $request,$user_shop)
    {
        try{
             $user_shop = UserShop::whereId($user_shop)->first();
            if($user_shop){
                if($request->hasFile("img")){
                    $img = $this->uploadFile($request->file("img"), "about-shop")->getFilePath();
                } else {
                    $tempabout = json_decode($user_shop->about);
                    $img = $tempabout->img;
                }
                $about = [
                    'title' => $request->title,
                    'content' => $request->content,
                    'img' => $img,
                ];
                 $user_shop->update([
                    'about' => json_encode($about),
                ]);
                    return redirect(route('customer.dashboard')."?active=account")->with('success','About Updated!');

            }
            return back()->with('error','User Shop not found')->withInput($request->all());
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    public function profileUpdate(Request $request, $id)
    {
        if($request->additional_numbers != null){
            $phone_numbers = array_column($request->additional_numbers,'phone');
            foreach($phone_numbers as $phone_number){
            $check = User::where('id','!=',auth()->id())
                ->where(function($query) use($phone_number) {
                    $query->where('phone',$phone_number)->orWhereJsonContains('additional_numbers',$phone_number);
                })
                ->first();
                if($check){
                    return back()->with('error','You have entered a number that belongs to another user.!');
                }
            }
        }else{
            $phone_numbers = null;
        }

        $validator = $this->validate($request,[
            'email' => 'required|email|unique:users,email,'.$id,
        ]);
        $user = User::whereId($id)->firstOrFail();
        $phone = $user->phone;
        // Mail send if user update their email id
        $user->name = $request->name;
        // $user->additional_numbers = $phone_numbers != null ? json_encode($phone_numbers) : $phone_numbers;
        $user->email = $request->email;

        if($user->email_verified_at == null){
            $user->email = $request->email;
            if($request->email){
                if($user->email != $request->email){
                    return back()->with('error','Email Should be unique');
                    try{
                        $request->user()->sendEmailVerificationNotification();
                    }catch (\Exception $e) {
                        return back()->with('error', 'Error: ' . $e->getMessage());
                    }
                }
            }
        }
        $user->phone = $request->phone;
        $user->exclusive_pass = $request->exclusive_pass;
        // $user->industry_id = json_encode($request->industry_id);
         // Save VC Image

        $exist = Media::where('type_id','=',auth()->user()->id)->first();


         if($request->hasFile("vcard")){
            $vcard = $this->uploadFile($request->file("vcard"), "user")->getFilePath();
            $filename = $request->file('vcard')->getClientOriginalName();
            $extension = pathinfo($filename, PATHINFO_EXTENSION);


            if ($exist === null) {
                echo "Create New Entry In Database";
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
             }else{
                echo "Update Existing Entry";
                Media::where(['type_id' =>auth()->user()->id , 'type' => 'UserVcard'])->
                update([
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

        if(UserRole($user->id)['name'] == "User" && $phone != $request->phone){
            $all_rec = AccessCatalogueRequest::where('number',$phone)->update([
                'number' => $request->phone,
            ]);
         }



        // return $request->vcard;

        return back()->with('success','Customer profile updated  successfully');
    }
    public function industryUpdate(Request $request, $id)
    {
        $user = User::whereId($id)->firstorFail();
        $user->industry_id = json_encode($request->industry_id);
        $user->save();
        return back()->with('success','Industries updated successfully');
    }


    public function validateAccessCode(Request $request)
    {

        // Check user already have AC
        $chk_existing_code = AccessCode::where('redeemed_user_id',auth()->id())->first();
        if($chk_existing_code){
             return redirect()->back()->with('error',"You already redeemed $chk_existing_code->code, You cann't use more then one access code.");
        }

        // Check AC Exisits
        $chk_code = AccessCode::whereCode($request->access_code)->first();

         $user = User::whereId(auth()->id())->first();

        // Code Has
        if ($chk_code) {
             $chk_redeem = AccessCode::whereCode($request->access_code)->where('redeemed_user_id','!=',null)->first();
            if($chk_redeem){
              return redirect()->back()->with('error','This access code is already redeemed!');
            }
        }else{
             return redirect()->back()->with('error',"This code is invalid!");
        }

         // Update Access Code
            $chk_code->update([
                'redeemed_user_id' => auth()->id(),
                'redeemed_at' => now()
            ]);

            $user->is_supplier = 1;
            $user->save();

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

        // Seller
        if ($chk_code) {
            return redirect()->route('panel.dashboard')->with('success','Welcome to 121, You have been Login Successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong!');
        }
    }



    public function survey(Request $request){
        $user_id = auth()->id();
        $response = json_encode($request->get('quest1a'));
        $question = json_encode('Where may we help ?');
        // magicstring($question);
        survey::create([
            'user_id' => $user_id,
            'question' => $question,
            'response' => $response,
        ]);

        return redirect()->back()->with('success','Welcome to 121');

    }



    public function lockEnquiry(Proposal $proposal) {
        $proposal_enquiry = Proposalenquiry::where('proposal_id',$proposal->id)->where('enquery_type','sample')->latest()->first();
        $proposal_item = ProposalItem::where('proposal_id',$proposal->id)->pluck('product_id');
        $data = LockEnquiry::where('proposal_id',$proposal->id)->first();
        $city = City::get();
        return view('frontend.customer.dashboard.lock-enquiry',compact('proposal','proposal_enquiry','proposal_item','city','data'));
    }

    public function lockEnquirystore(Request $request) {

        try {
            $user_info = json_encode(['reseller_name' => $request->get('reseller_name'),'client_name' => $request->get('client_name'),'city' => $request->get('city')]);
            $request['product_id'] = $request->get('picked_sku');
            $request['user_info'] = $user_info;
            $request['expiry_date'] = $request->get('valid_upto');

            // ` getting Record if Data Exist
            $chk = LockEnquiry::where('proposal_id',$request->get('proposal_id'))->get();
            // - magicstring(count($chk));

            if (count($chk) == 0) {
                LockEnquiry::create($request->all());
            }else{
                $chk[0]->product_id = json_encode($request->get('picked_sku'));
                $chk[0]->user_info = $user_info;
                $chk[0]->expiry_date = $request->get('valid_upto');
                $chk[0]->quantity = $request->get('quantity');
                $chk[0]->save();
            }

            return back()->with('success',"Enquiry Locked !!");
        } catch (\Throwable $th) {
            return back()->with('error',"Unable to Proceed $th");
        }


    }


    public function removeImg(Request $request, UserShop $user_shop)
    {
        // return $user_shop;
        try{
            if($request->type == 'bussiness_logo')
                if($user_shop){
                    if($user_shop->logo != null) {
                        $user_shop->update([
                            'logo' => null
                        ]);
                    }
                    return back()->with('success','Bussiness Logo deleted successfully');
                }else{
                    return back()->with('error','Bussiness Logo not found');
                }
            else{
                $banner = Media::whereTypeId($user_shop->id)->whereType('UserShop')->whereTag('Banner')->first();
                if($banner){
                    if($banner->path != null) {
                        $banner->delete();
                    }
                    return back()->with('success','Banner Image deleted successfully');
                }else{
                    return back()->with('error','Banner Image not found');
                }
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }



}
