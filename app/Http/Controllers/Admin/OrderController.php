<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UserShop;
use App\User;
use App\Models\MailSmsTemplate;

class OrderController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         $length = 50;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $orders = Order::query();

         if(AuthRole() != 'Admin'){
            if(auth()->user()->is_supplier == 1){
                $orders->where(function ($query){
                })->orWhere(function ($query) {
                    $query->where('type','UserShop')->where('type_id',UserShopIdByUserId(auth()->id())); //My Shop
                    $query->orWhere('flag',0)->where('user_id',auth()->id()); //Package
                    $query->orWhere('flag',3); // PAR Order
                });
            }else{
                $orders->whereUserId(auth()->id());
            }
        }
         
            if($request->get('search')){
                $orders->where('id','like','%'.$request->search.'%')
                    ->orWhere('txn_no','like','%'.$request->search.'%')
                    ->orWhere('amount','like','%'.$request->search.'%');
            }
          
            
            if($request->get('from') && $request->get('to')) {
                $orders->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }
            if($request->get('asc')){
                $orders->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $orders->orderBy($request->get('desc'),'desc');
            }
            if($request->get('status')){
                $orders->whereStatus($request->status);
            }

            
            // if(AuthRole() == 'Admin'){
                $orders = $orders->where('flag','!=',0)->latest()->paginate($length);
            // }else{
            //     $user_id = auth()->id();
            //     $user_shop = UserShop::whereUserId($user_id)->first();
            //     $orders = $orders->whereTypeId($user_shop->id)->where('flag','!=',0)->latest()->paginate($length); 
            // }

            if ($request->ajax()) {
                return view('backend.admin.orders.load', ['orders' => $orders])->render();  
            }
 
        return view('backend.admin.orders.index', compact('orders'));
    }

    
        public function print(Request $request){
            $orders = collect($request->records['data']);
                return view('backend.admin.orders.print', ['orders' => $orders])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('backend.admin.orders.create');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function status(Request $request)
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

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
                        'user_id'     => 'required',
                        'txn_no'     => 'required',
                        'discount'     => 'sometimes',
                        'tax'     => 'sometimes',
                        'sub_total'     => 'required',
                        'total'     => 'required',
                        'status'     => 'sometimes',
                        'payment_gateway'     => 'sometimes',
                        'remarks'     => 'sometimes',
                        'from'     => 'sometimes',
                        'to'     => 'sometimes',
                    ]);
        
        try{
                 $request['status'] = 0;      
                       
            $order = Order::create($request->all());
            return redirect()->route('panel.orders.index')->with('success','Order Created Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        try{
            return view('backend.admin.orders.show',compact('order'));
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
    public function invoice(Order $order)
    {   
        try{
            
            return view('backend.admin.orders.invoice',compact('order'));
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
    public function update(Request $request,Order $order)
    {
        
        $this->validate($request, [
                        'user_id'     => 'required',
                        'txn_no'     => 'required',
                        'discount'     => 'sometimes',
                        'tax'     => 'sometimes',
                        'sub_total'     => 'required',
                        'total'     => 'required',
                        'status'     => 'sometimes',
                        'payment_gateway'     => 'sometimes',
                        'remarks'     => 'sometimes',
                        'from'     => 'sometimes',
                        'to'     => 'sometimes',
                    ]);
                
        try{
                                   
            if($order){
                $request['status'] = 0;      
                       
                $chk = $order->update($request->all());

                return redirect()->route('panel.orders.index')->with('success','Record Updated!');
            }
            return back()->with('error','Order not found');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function updateStatus(Order $order,Request $request)
    {
        // return $request->all();
        $user = User::whereId($order->user_id)->first();
        if($request->status == 2){ // Packed
            $order->update([
                'status' => 2,
                'payment_status' => 2,
            ]);

            $action_by = getUserRecordByUserId(auth()->id());
            if($order->user_id != null){
                $mailcontent_data = MailSmsTemplate::where('code','=',"order-accepted")->first();
                if($mailcontent_data){
                    $arr=[
                        '{name}'=>$user->name,
                        '{order_id}'=>$order->id,
                        '{accepted_by}'=>$action_by->name,
                        '{product_name}'=>getProductNameByOrderId($order->id),
                    ];
                    $action_button = [
                        "label" => "Click here",
                        "link" =>  route('customer.invoice',$order->id),
                    ];
                    TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
                }
                // return 's';
                 $onsite_notification['user_id'] =  $user->id;
                $onsite_notification['title'] = "Your Order #ORD $order->id has been accepted." ;
                $onsite_notification['link'] = route('customer.invoice',$order->id);
                pushOnSiteNotification($onsite_notification);
            }
            return redirect()->route('panel.orders.index')->with('success','Order Accept Successfully!');
        }elseif($request->status == 6){
            $order->update([
                'status' => 6,
                'payment_status' => 1,
                'seller_payment_details' => null,
            ]);
            if($order->user_id != null){
                $mailcontent_data = MailSmsTemplate::where('code','=',"order-rejected")->first();
                if($mailcontent_data){
                    $arr=[
                        '{name}'=>$user->name,
                        '{order_id}'=>$order->id,
                        '{accepted_by}'=>$action_by->name,
                        '{product_name}'=>getProductNameByOrderId($order->id),
                    ];
                    $action_button = [
                        "label" => "Click here",
                        "link" =>  route('customer.invoice',$order->id),
                    ];
                    TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
                }
                // return 's';
                 $onsite_notification['user_id'] =  $user->id;
                $onsite_notification['title'] = "Your Order #ORD $order->id has been Rejected." ;
                $onsite_notification['link'] = route('customer.invoice',$order->id);
                pushOnSiteNotification($onsite_notification);
            }
            return redirect()->route('panel.orders.index')->with('success','Order Reject Successfully!');
        }elseif($request->status == 5){
            $order->update([
                'status' => 5,
                'payment_status' => 1,
                'seller_payment_details' => null,
            ]);
            if($order->user_id != null){
                $mailcontent_data = MailSmsTemplate::where('code','=',"order-complete")->first();
                if($mailcontent_data){
                    $arr=[
                        '{name}'=>$user->name,
                        '{order_id}'=>$order->id,
                        '{completed_by}'=>$action_by->name,
                        '{product_name}'=>getProductNameByOrderId($order->id),
                    ];
                    $action_button = [
                        "label" => "Click here",
                        "link" =>  route('customer.invoice',$order->id),
                    ];
                    TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
                }
                 $onsite_notification['user_id'] =  $user->id;
                $onsite_notification['title'] = "Your Order #ORD $order->id has been Completed." ;
                $onsite_notification['link'] = route('customer.invoice',$order->id);
                pushOnSiteNotification($onsite_notification);
            }
            return redirect()->route('panel.orders.index')->with('success','Order Completed Successfully!');
        }else{
            $order->update([
                'status' => $request->status,
            ]);
            return redirect()->route('panel.orders.index')->with('success','Order Updated Successfully!');
        }
    }
    
    public function reUpdateStatus(Order $order,Request $request,$status)
    {
        $order->update([
            'status' => $status,
        ]);

        return redirect()->route('panel.orders.index')->with('success','Order Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try{
            if($order){
                foreach($order->items as $item){
                    $item->delete();
                }                           
                $order->delete();
                return back()->with('success','Order deleted successfully');
            }else{
                return back()->with('error','Order not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
