<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PriceAskRequest;
use App\Models\PriceAskItem;
use App\User;
use App\Models\UserAddress;
use App\Models\MailSmsTemplate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserShopItem;

class PriceAskRequestController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $price_ask_requests = PriceAskRequest::query();
         
            if($request->get('search')){
                $price_ask_requests->where('id','like','%'.$request->search.'%')
                                ->orWhere('sender_id','like','%'.$request->search.'%')
                                ->orWhere('receiver_id','like','%'.$request->search.'%')
                                ->orWhere('workstream_id','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $price_ask_requests->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
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
            }

            $price_ask_requests = $price_ask_requests->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.price_ask_requests.load', ['price_ask_requests' => $price_ask_requests])->render();  
            }
 
        return view('panel.price_ask_requests.index', compact('price_ask_requests'));
    }

    
        public function print(Request $request){
            $price_ask_requests = collect($request->records['data']);
                return view('panel.price_ask_requests.print', ['price_ask_requests' => $price_ask_requests])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
       
        try{
            return view('panel.price_ask_requests.create');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function customOrderCreate($par_id)
    {
         $par_record = PriceAskRequest::whereId($par_id)->first();
         if($par_record->sender_id){
            $user_addresses  =  UserAddress::whereUserId($par_record->sender_id)->get();
         }else{
             return back()->with('error','No user found!');
         }
        try{
            return view('panel.price_ask_requests.include.custom-order',compact('par_record','user_addresses'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
                        'sender_id'     => 'required',
                        'receiver_id'     => 'required',
                        'product_id'     => 'required',
                        'price'     => 'required',
                        'qty'     => 'required',
                        'total'     => 'sometimes',
                        'comment'     => 'sometimes',
                        'till_date'     => 'sometimes',
                        'details'     => 'sometimes',
                        'status'     => 'required',
                    ]);
        
        try{
                      
            $request['product_id'] = $request->product_id;          
            $request['sender_shop_id'] = UserShopIdByUserId($request->sender_id);          
            $request['receiver_shop_id'] = UserShopIdByUserId($request->receiver_id);          
            $request['total'] =  $request->price*$request->qty;          
            $price_ask_request = PriceAskRequest::create($request->all());
            PriceAskItem::create([
                'price_ask_request_id' => $price_ask_request->id,
                'qty' => $request->qty,
                'price' => $request->price,
                'total' => $request->total,
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'comment' => $request->comment,
                'till_date' => $request->till_date,
            ]);
       
                $receiver = fetchFirst('App\User',$request->receiver_id);
             $mailcontent_data = MailSmsTemplate::where('code','=',"par-request-created")->first();
             if($mailcontent_data){
                $arr=[
                    '{name}'=> $receiver->name,
                    '{sender_name}'=> NameById($request->sender_id),
                    '{price_ask_request_id}'=> "#PAR".$price_ask_request->id,
                    '{product_id}'=> "#PRO".$request->product_id,
                ];
                TemplateMail($receiver->name,$mailcontent_data,$receiver->email,$mailcontent_data->type, $arr, $mailcontent_data);
            }
            $onsite_notification['user_id'] =  $request->receiver_id;
            $onsite_notification['title'] = auth()->user()->name." has raised a new price request #PAR".$price_ask_request->id." for ".fetchFirst('App\Models\Product',$request->product_id,'title','')." #PRO".$request->product_id;
            $onsite_notification['link'] = route('panel.price_ask_requests.show', $price_ask_request->id);
            pushOnSiteNotification($onsite_notification);
        
        return back()->with('success','Price Ask Request Created Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    public function itemStore(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
                        'sender_id'     => 'required',
                        'receiver_id'     => 'required',
                        'price'     => 'required',
                        'qty'     => 'required',
                        'total'     => 'sometimes',
                        'comment'     => 'sometimes',
                        'till_date'     => 'sometimes',
                        'status'     => 'required',
                    ]);
        
        try{
            PriceAskItem::create([
                'price_ask_request_id' => $request->price_ask_request_id,
                'qty' => $request->qty,
                'price' => $request->price,
                'total' => $request->qty*$request->price,
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'comment' => $request->comment,
                'till_date' => $request->till_date,
            ]);
        return back()->with('success','Price Ask Request Created Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    public function itemStatus($id, $s){
        // return $id;
        $item = PriceAskItem::whereId($id)->first();
        $price_ask_request = PriceAskRequest::whereId($item->price_ask_request_id)->first();
        $item->status = $s;
        $item->save();

        if($s == 1){
            $receiver = fetchFirst('App\User',$item->receiver_id);
            $mailcontent_data = MailSmsTemplate::where('code','=',"par-request-accepted")->first();
            if($mailcontent_data){
                $arr=[
                    '{name}'=> $receiver->name,
                    '{sender_name}'=> NameById($item->sender_id),
                    '{price_ask_request_id}'=> "#PAR".$item->price_ask_request_id,
                    '{product_id}'=> "#PRO".$price_ask_request->product_id,
                ];
                TemplateMail($receiver->name,$mailcontent_data,$receiver->email,$mailcontent_data->type, $arr, $mailcontent_data);
            }
            $onsite_notification['user_id'] = $item->sender_id;
            $onsite_notification['title'] = auth()->user()->name." has accepted your new price request in #PAR".$price_ask_request->id." for ".fetchFirst('App\Models\Product',$price_ask_request->product_id,'title','')." #PRO".$price_ask_request->product_id;
            $onsite_notification['link'] = route('panel.price_ask_requests.show', $price_ask_request->id);
            pushOnSiteNotification($onsite_notification);
        }else if($s == 2){
            $receiver = fetchFirst('App\User',$item->sender);
            $mailcontent_data = MailSmsTemplate::where('code','=',"par-request-rejected")->first();
            if($mailcontent_data){
                $arr=[
                    '{name}'=> $receiver->name,
                    '{sender_name}'=> NameById($item->sender_id),
                    '{price_ask_request_id}'=> "#PAR".$item->price_ask_request_id,
                    '{product_id}'=> "#PRO".$price_ask_request->product_id,
                ];
                TemplateMail($receiver->name,$mailcontent_data,$receiver->email,$mailcontent_data->type, $arr, $mailcontent_data);
            }
            $onsite_notification['user_id'] = $item->sender_id;
            $onsite_notification['title'] = auth()->user()->name." has rejected your new price request in #PAR".$price_ask_request->id." for ".fetchFirst('App\Models\Product',$price_ask_request->product_id,'title','')." #PRO".$price_ask_request->product_id;
            $onsite_notification['link'] = route('panel.price_ask_requests.show', $price_ask_request->id);
            pushOnSiteNotification($onsite_notification);
        }
        
        return back()->with('success',"Status Updated!");
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(PriceAskRequest $price_ask_request)
    {
        try{
            // return $price_ask_request;
            if($price_ask_request->sender_id == auth()->id()){
                // Reseller
                $user_shop_item = UserShopItem::whereProductId($price_ask_request->product_id)->whereUserShopId($price_ask_request->sender_shop_id)->first();
                if($user_shop_item){
                    $parent_user_shop_item = UserShopItem::whereProductId($price_ask_request->product_id)->whereUserShopId($user_shop_item->parent_shop_id)->first();
                }else{
                    $parent_user_shop_item = null;
                }

            }else{
                // Supplier
                // return $price_ask_request;
                $user_shop_item = UserShopItem::whereProductId($price_ask_request->product_id)->whereUserShopId($price_ask_request->receiver_shop_id)->first();
                if($user_shop_item){
                    $parent_user_shop_item = UserShopItem::whereProductId($price_ask_request->product_id)->whereUserShopId($user_shop_item->parent_shop_id)->first();
                }else{
                    $parent_user_shop_item = null;
                }
            }

            $product = getProductDataById($price_ask_request->product_id);

            return view('panel.price_ask_requests.show',compact('price_ask_request','user_shop_item','parent_user_shop_item','product'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(PriceAskRequest $price_ask_request)
    {   
        try{
            
            return view('panel.price_ask_requests.edit',compact('price_ask_request'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function status(PriceAskRequest $price_ask_request,Request $request)
    {   
        try{
            $price_ask_request->status = $request->status;
            $price_ask_request->save();
            return back()->with('success',"Updated Successfully!");
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request,PriceAskRequest $price_ask_request)
    {
        
        $this->validate($request, [
                        'workstream_id'     => 'required',
                        'sender_id'     => 'required',
                        'receiver_id'     => 'required',
                        'price'     => 'required',
                        'qty'     => 'required',
                        'total'     => 'sometimes',
                        'comment'     => 'sometimes',
                        'till_date'     => 'sometimes',
                        'details'     => 'sometimes',
                        'status'     => 'required',
                    ]);
                
        try{
                                  
            if($price_ask_request){
                              
                $chk = $price_ask_request->update($request->all());

                return redirect(route('panel.admin.enquiry.index')."?type=par")->with('success','Record Updated!');
            }
            return back()->with('error','Price Ask Request not found')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(PriceAskRequest $price_ask_request)
    {
        try{
            if($price_ask_request){
                                                    
                $price_ask_request->delete();
                return back()->with('success','Price Ask Request deleted successfully');
            }else{
                return back()->with('error','Price Ask Request not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function customOrder(Request $request)
       {
        //    return $request->all();
           $this->validate($request,[
               'type_id'=> 'required',
               'qty'=> 'required',
               'price'=> 'required',
           ]);
    
           $request['enquiry_id'] = 0;

           $par = PriceAskRequest::whereId($request->type_id)->first();
           if(!$par){
                return back()->with('error','Invalid Request!');
           }
           $user = User::find($par->sender_id);
           $details = [
               'name' => $user->name,
               'email' => $user->email,
           ];
           $customer_details = json_encode($details);
           $sub_total = $request->price*$request->qty ?? 0;
           $product = getProductDataById($par->product_id);
           $tax_amount = 0;
           if($product->hsn_percent){
               $tax_amount = ($request->price * $product->hsn_percent)/100;
           }

           // Address Object Prepration
           $to = null;
    
           $data = new Order();
           $data->user_id=$par->sender_id;
           $data->flag= 3;
           $data->type= 'UserShop';
           $data->type_id= UserShopIdByUserId(auth()->id());
           $data->txn_no='ORD'.rand(00000,99999);
           $data->discount=null;
           $data->tax=$tax_amount;
           $data->sub_total=$sub_total;
           $data->total= $sub_total+$tax_amount?? 0;
           $data->status=1;
           $data->payment_status=1;
           $data->payment_gateway=null;
           $data->remarks=null;
           $data->from=invoiceFrom();
           $data->to=$to;
           $data->shipping_address=$to;
           $data->date=now();
           $data->customer_details = $customer_details;
           $data->remarks=$request->remarks;
           $data->delivery_date=$request->delivery_date;
           $data->save();
    
           
           $order_item = new OrderItem();
           $order_item->item_id = $par->product_id;
           $order_item->item_type = "Product";
           $order_item->order_id = $data->id;
           $order_item->qty = $request->qty;
           $order_item->price = $request->price;
           $order_item->tax = $product->hsn_percent??0;
           $order_item->tax_amount = $tax_amount;
           $order_item->save();
    
           $par->status = 1;
           $par->save();
    
           return redirect(route('panel.admin.enquiry.index')."?type=par")->with('success','Order Created Successfully!');
       }
}
