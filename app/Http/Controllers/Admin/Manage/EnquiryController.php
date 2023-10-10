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

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\MailSmsTemplate;
use App\Models\TicketConversation;
use App\Models\UserShop;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use App\Models\PriceAskRequest;
use App\Models\UserShopItem;
use App\Models\GroupProduct;
use App\Models\AccessCatalogueRequest;
use App\Models\Group;
use App\User;
use Illuminate\Http\Request;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
      
        if (AuthRole() != 'Admin') {
           $user_shop = getShopDataByUserId(auth()->id());
            if(!$user_shop){
                return back()->with('error', 'No shop assign to your account. Please contact 121 Help-desk.');
            }
        }

            $length = 50;
            if(request()->get('length')){
                $length = $request->get('length');
            }

                $enquiry = Enquiry::query();
                
                if($request->get('pr_from') && $request->get('pr_from') != null && $request->get('pr_to') && $request->get('pr_to') != null){
                    $enquiry->whereBetween('created_at', [\Carbon\Carbon::parse($request->get('pr_from'))->format('Y-m-d'),\Carbon\Carbon::parse($request->get('pr_to'))->format('Y-m-d')]);
                }
                if($request->has('status') && $request->get('status') != null){
                    $enquiry->whereStatus($request->status);
                }
                
                if (AuthRole() != 'Admin') {
                    $enquiry= $enquiry->whereMicroSiteId($user_shop->id);
                    $pending_enq =  $enquiry;
                    $pending_enq = $pending_enq->where('status',0)->get()->count();
                }else{
                    $pending_enq =  $enquiry;
                    $pending_enq = $pending_enq->where('status',0)->get()->count();
                }
                
                $enquiry= $enquiry->latest()->paginate($length);

                if ($request->ajax()) {
                    if($request->has('type') && $request->get('type') == "enquiry"){
                        return view('backend.admin.manage.enquiry.load', ['enquiry' => $enquiry])->render();  
                    }else{
                        return view('backend.admin.manage.enquiry.load', ['enquiry' => $enquiry])->render();
                    }
                }

                $price_ask_requests = PriceAskRequest::query();
                
                if($request->get('search')){
                    $price_ask_requests->where('id','like','%'.$request->search.'%')
                                    ->orWhere('sender_id','like','%'.$request->search.'%')
                                    ->orWhere('receiver_id','like','%'.$request->search.'%')
                                    ->orWhere('workstream_id','like','%'.$request->search.'%')
                    ;
                }
                
                if($request->get('par_from') && $request->get('par_to')) {
                    $price_ask_requests->whereBetween('created_at', [\Carbon\carbon::parse($request->par_from)->format('Y-m-d'),\Carbon\Carbon::parse($request->par_to)->format('Y-m-d')]);
                }

                if($request->get('asc')){
                    $price_ask_requests->orderBy($request->get('asc'),'asc');
                }
                if($request->get('desc')){
                    $price_ask_requests->orderBy($request->get('desc'),'desc');
                }

                if(AuthRole() == "User"){
                    $price_ask_requests->where(function ($query){
                        $query->whereReceiverId(auth()->id());
                        $query->orWhere('sender_id',auth()->id());
                    });  
                    $pending_par =  $price_ask_requests;
                    $pending_par = $pending_par->where('status',0)->get()->count();
                }else{
                    $pending_par =  $price_ask_requests;
                $pending_par = $pending_par->where('status',0)->get()->count();
                }

            $price_ask_requests = $price_ask_requests->latest()->paginate($length);

            if ($request->ajax() && $request->type == "par") {
                return view('panel.price_ask_requests.load', ['price_ask_requests' => $price_ask_requests])->render();  
            }
        return view('backend.admin.manage.enquiry.index', compact('enquiry','price_ask_requests','pending_enq','pending_par'));
    }

    public function print(Request $request){
        //    return json_decode($request->leads);
                $enquirys = collect($request->records['data']);
                return view('backend.admin.manage.enquiry.print', ['enquirys' => $enquirys])->render();  
           
       }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.admin.manage.enquiry.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
      
         try{
            $this->validate($request, [
                'client_name' => 'required',
                'client_email' => 'required',
                'title' => 'required',
                'user_id' => 'required',
                'enquiry_type_id' => 'required',
            ]);
            $data = new Enquiry();
            $data->client_name=$request->client_name;
            $data->client_email=$request->client_email;
            $data->description=$request->description;
            $data->title=$request->title;
            $data->user_id=auth()->id();
            $data->enquiry_type_id=$request->enquiry_type_id;
            $data->assigned_to=$request->assigned_to;
            $data->last_activity=$request->last_activity;
            $data->status=$request->status;
            $data->save();
            // Push On Site Notification
            $data_notification = [
                'title' => "New Enquiry raise of ".$data->title,
                'notification' => "You have a new Enquiry",
                'link' => "#",
                'user_id' => $data->user_id,
            ];
            pushOnSiteNotification($data_notification);
            // End Push On Site Notification

            // Start Dynamic mail send
            // $mail = MailSmsTemplate::whereCode('ClientTicketRise')->first();
            // $arr=[
            //     '{name}' => $data->client_name=$request->client_name,
            //     '{email}' => $data->client_email=$request->client_email,
            //     '{message}' => $data->description=$request->description,
            //     '{subject}' => $data->title=$request->title,
            //     '{app_name}'=>config('app.name'),
            // ];
            //     try{
            //         // mail send to Client 
            //         TemplateMail($data->client_name=$request->client_name, $mail->code, $data->client_email=$request->client_email, $mail->type, $arr, $mail, null, $action_button = null);
            //         // mail send to Admin 
            //         TemplateMail(auth()->user()->name, $mail->code, auth()->user()->email, $mail->type, $arr, $mail, null, $action_button = null);
            //         // End Dynamic mail send

            //     }catch(Exception $e){
                    
            //     }

            return redirect(route('panel.admin.enquiry.index'))->with('success', 'Enquiry created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $enquiry = Enquiry::whereId($id)->first();
        
        if(!$enquiry){
            return back()->with('error','This enquiry doesn\'t exists.');
        }
        
        $user_shop = UserShop::whereId($enquiry->micro_site_id)->first();
        if(!$user_shop){
            return back()->with('error','This enquiry microsite doesn\'t exists.');
        }
        if($enquiry->status == 0 && $enquiry->micro_site_id == $user_shop->id){
            $enquiry->update(['status'=>4]);
            $enquiry = Enquiry::whereId($id)->first();
        }
        $sender = UserShop::whereId($enquiry->micro_site_id)->first()->user_id;
        $receiver = $enquiry->user_id;
        $details = json_decode($enquiry->description);
        $product = getProductDataById($details->product_id);
       
        $user_shop_item = UserShopItem::whereProductId($product->id)->whereUserShopId($user_shop->id)->first();
        if(!$user_shop_item) {
            return back()->with('error','This enquiry product doesn\'t exists.');
        } 

        $parent_user_shop_item = UserShopItem::whereProductId($product->id)->whereUserShopId($user_shop_item->parent_shop_id)->first();

        $supplier = User::whereId($user_shop->user_id)->first();
        $acr = AccessCatalogueRequest::where('user_id',$enquiry->user_id)->where('number',$supplier->phone)->where('status',1)->first();
          
        if($acr &&  $acr->price_group_id != 0){
        $group_product = GroupProduct::where('group_id',$acr->price_group_id)->first();
            $cost_price = $group_product->price ?? 0; 
        }else{
            $cost_price = $parent_user_shop_item->price ?? 0;
        }
        
        if(!$product){
            return back()->with('error','This enquiry product doesn\'t exists.');
        }
        $price_ask_requests = PriceAskRequest::whereType('Enquiry')->whereTypeId($enquiry->id)->get();

        return view('backend.admin.manage.enquiry.show', compact('enquiry','sender','receiver','details','product','price_ask_requests','user_shop_item','parent_user_shop_item','user_shop','cost_price'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $enquiry = Enquiry::whereId($id)->first();
        return view('backend.admin.manage.enquiry.edit', compact('enquiry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\Enquiry $enquiry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            $data = Enquiry::whereId($id)->first();
            $data->client_name=$request->client_name;
            $data->client_email=$request->client_email;
            $data->description=$request->description;
            $data->title=$request->title;
            $data->user_id=$request->user_id;
            $data->enquiry_type_id=$request->enquiry_type_id;
            $data->assigned_to=$request->assigned_to;
            $data->last_activity=$request->last_activity;
            $data->status=$request->status;
            $data->save();
            // return $data;
            return redirect(route('panel.admin.enquiry.index'))->with('success', 'Enquiry update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function updateStatus($id, $s)
    {
        try {
            $user = Enquiry::find($id);
            $user->update(['status' => $s]);
            return redirect()->back()->with('success', 'Enquiry status Updated!');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Enquiry $enquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $chk = Enquiry::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Enquiry Deleted Successfully!');
        }
    }
    public function order(Request $request)
    {
        $this->validate($request,[
            'type_id'=> 'required',
            'qty'=> 'required',
            'price'=> 'required',
        ]);

        $request['enquiry_id'] = $request->type_id;
        $enquiry = Enquiry::whereId($request->enquiry_id)->first();
        $product = getProductDataById(json_decode($enquiry->description)->product_id);
            $tax_amount = 0;
            if($product->hsn_percent){
                $tax_amount = ($request->price * $product->hsn_percent)/100;
            }
        $user = User::find($enquiry->user_id);
        $details = [
            'name' => $user->name,
            'email' => $user->email,
        ];
        $customer_details = json_encode($details);
        $to = null;

        $data = new Order();
        $data->user_id=$enquiry->user_id;
        $data->type= 'UserShop';
        $data->flag= 2;
        $data->type_id= UserShopIdByUserId(auth()->id());
        $data->txn_no='ORD'.rand(00000,99999);
        $data->discount=null;
        $data->tax=$tax_amount;
        $data->sub_total=$request->price ?? 0;
        $data->total=$request->price+ $tax_amount?? 0;
        $data->status=1;
        $data->payment_status=1;
        $data->payment_gateway=null;
        $data->remarks=null;
        $data->from=invoiceFrom();
        $data->to=$to;
        $data->shipping_address=$to;
        $data->remarks=$request->remarks;
        $data->delivery_date=$request->delivery_date;
        $data->date=now();
        $data->customer_details = $customer_details;
        $data->save();

        
        $order_item = new OrderItem();
        $order_item->item_id = $product->id;
        $order_item->item_type = "Product";
        $order_item->order_id = $data->id;
        $order_item->qty = $request->qty;
        $order_item->price = $request->price;
        $order_item->tax = $product->hsn_percent??0;
        $order_item->tax_amount = $tax_amount;
        $order_item->save();

        $enquiry->status = 1;
        $enquiry->save();

        
        // Push On Site Notification
        $data_notification = [
            'title' => "Order has been created by ".auth()->user()->name,
            'notification' => "New Order has been created with orderId #ORD".$data->id,
            'link' => route('panel.orders.show',$data->id),
            'user_id' => $data->user_id,
        ];
        pushOnSiteNotification($data_notification);


        return redirect(route('panel.orders.show',$data->id))->with('success','Order Created Successfully!');
        // return back()->with('success','Order Created Successfully!');
    }
    
    public function token(Request $request)
    {
        $input = $request->all();
        $fcm_token = $input['fcm_token'];
        $user_id = $input['user_id'];

        $user = User::find($user_id);

        $user->fcm_token = $fcm_token;
        $user->save();

        return response("User Token Updated Successfully",200);
    }

    
    public function sendMessage(Request $request){
        // return $request->all();
            $tc = new TicketConversation();
            $tc->type_id=$request->type_id;
            $tc->enquiry_id=$request->type_id;
            $tc->type=$request->type;
            $tc->user_id=auth()->id();
            $tc->comment=$request->comment;
            $tc->save();
            $enquiry = Enquiry::find($request->type_id);

            $receiver_id = UserShop::whereId($enquiry->micro_site_id)->first()->user_id;
            if(auth()->id() == $receiver_id){
               
                $sender = User::find($receiver_id);
                $user = User::find($enquiry->user_id);
            }else{
                $user = User::find($receiver_id);
                $sender = User::find($tc->user_id);
            }
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60*20);
            $notificationBuilder = new PayloadNotificationBuilder($sender->name);
            $notificationBuilder->setBody($request->comment)
            ->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['enq_id' => $enquiry->id]);
    
            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();
            
            $token = $user->fcm_token;
            if($token){
                $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
               
               $downstreamResponse->numberSuccess();
                 $downstreamResponse->numberFailure();
                $downstreamResponse->numberModification();
               
               // return Array - you must remove all this tokens in your database
               $downstreamResponse->tokensToDelete();
               
               // return Array (key : oldToken, value : new token - you must change the token in your database)
               $downstreamResponse->tokensToModify();
               
               // return Array - you should try to resend the message to the tokens in the array
               $downstreamResponse->tokensToRetry();
               
               // return Array (key:token, value:error) - in production you should remove from your database the tokens
               $downstreamResponse->tokensWithError();
            }
          
            return response()->json(['status'=>1,'tc_id'=>$tc->id],200);

    }

}
