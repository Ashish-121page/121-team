<?php 
namespace App\Http\Controllers;

use App\Models\Coupons;
use Illuminate\Http\Request;
use Paytm;
use PaytmWallet;
use App\Models\UserAddress;
use App\Models\Package;
use App\Models\Order;
use App\Models\UserPackage;
use App\User;

class PaytmController  extends Controller
{
     // display a form for payment
     public function initiate()
     {
           return view('paytm');
     }
 
     public function pay(Request $request)
     {
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
         $order->update([
            'customer_details' => $customer_details,
            'to' => $to,
        ]);
        
        // if (isset($request->newprice)) {
        //     $coupanEnter = $request->newprice;
        //     $amount = $coupanEnter; //Amount to be paid after Coupon
        // }else{
        //      $amount = $package->price; //Amount to be paid
        // }
        
         $amount = 1; //Amount to be paid
         
         $userData = [
             'name' => auth()->user()->name, // Name of user
             'mobile' => auth()->user()->phone, //Mobile number of user
             'email' => auth()->user()->email, //Email of user
             'fee' => $amount,
             'order_id' => rand(1,1000) //Order id
            ];
            session()->put('order_id',$order->id);
            session()->put('package_id',$package->id);
            $payment = Paytm::with('receive');
            // $payment =  PaytmWallet::with('receive');

            $payment->prepare([
                'order' => $userData['order_id'], 
                'user' => 1,
                'mobile_number' => $userData['mobile'],
                'email' => $userData['email'], // your user email address
                'amount' => $amount, // amount will be paid in INR.
                'callback_url' => route('status') // callback URL
            ]);
            // return 's';
            $response =  $payment->receive();  // initiate a new payment
         return $response;
     }
 
     public function paymentCallback()
     {
         $transaction = Paytm::with('receive');
 
         $response = $transaction->response();

        //  dd($response);

         $order_id = $transaction->getOrderId(); // return a order id
       
         $transaction->getTransactionId(); // return a transaction id
         // update the db data as per result from api call
         if ($transaction->isSuccessful()) {
            $order = Order::find(session()->get('order_id'));
            $order->update([
                'status' => 5, //Completed
                'payment_status' => 2, //Paid
            ]);
            $package = Package::whereId(session()->get('package_id'))->firstOrFail();
            if($package->duration == null){
                $duration = 30;
            }else{
                $duration = $package->duration;
            }
            $user_package = UserPackage::whereUserId(auth()->id())->first();
            if ($user_package) {
                $user_package->update([
                    'user_id' => auth()->id(),
                    'package_id' => $package->id,
                    'order_id' => $order->id,
                    'from' => now(),
                    'to' => now()->addDays($duration),
                    'limit' => $package->limit,
                ]);
                return redirect(route('panel.dashboard'))->with('success', 'Payment Successfully Done! '.$package->name.' activated.');
            } else {
                $data = new UserPackage();
                $data->user_id = auth()->user()->id;
                $data->package_id = $package->id;
                $data->order_id = $order->id;
                $data->from = now();
                $data->to = now()->addDays($duration);
                $data->limit = $package->limit;
                $data->save();
                return redirect(route('panel.dashboard'))->with('success', 'Payment Successfully Done! '.$package->name.' activated.');
            }
             return back()->with('message', "Your payment is successfull.");
 
         } else if ($transaction->isFailed()) {
             return redirect(route('initiate.payment'))->with('message', "Your payment is failed.");
             
         } else if ($transaction->isOpen()) {
              return redirect(route('initiate.payment'))->with('message', "Your payment is processing.");
         }
         $transaction->getResponseMessage(); //Get Response Message If Available
     }
}
