<?php

namespace App\Http\Controllers;

use App\Models\Coupons;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Arrays;

class couponsController extends Controller
{
    function index() {

        $coupons = Coupons::get();
        $plans = Package::get();

        
        return view('backend.admin.coupons.index',compact('coupons','plans'));
    }

    function store(Request $request){
        // magicstring($request->all());
        $plan = json_encode($request->appplan);

        if ($request->appplan == 'all') {
            $plan = (Package::get()->pluck('id')->toArray());
        }

        if (isset($request->amtrupee) != null) {
            $amt = $request->amtrupee;
        }elseif (isset($request->amtpercent) != null) {
            $amt = $request->amtpercent;
        }elseif (isset($request->amtpercent) != null){
            $amt = $request->flat_price;
        }
        
        if (isset($request->couponcode) == null) {
            $coupons_code = '121'.''.\Str::upper(\Str::random(4)).''.$amt;
        }else{
            $coupons_code = $request->couponcode;
        }

        $data = new Coupons();
        $data->name = $request->couponsname;
        $data->coupon_code = $coupons_code;
        $data->ussage_limit = $request->appplimit ?? 100;
        $data->description = $request->desc ?? '';
        $data->discount_amt = $request->amtrupee;
        $data->discount_percent = $request->amtpercent;
        $data->flat_price = $request->flat_price;
        $data->plan_id = $plan;
        $data->save();
        return back()->with('success',"Coupon Created Success Fully");

    }


    function usecoupon(Request $request) {
        
        // magicstring($request->all());

        $chk = Coupons::where('coupon_code',$request->coupon)->first();

        $package = Package::where('id',$request->package)->first();

        if ($chk == "" || $chk == null) {
            $response = array(
                'status' => "error",
                'msg' => "Invalid Coupon",
                'newprice' => $package->price
            );    
            return $response;
        }


        // check if Coupon is terminated ir not
        if ($chk->code_terminated == 1) {
            $response = array(
                'status' => "error",
                'msg' => "Coupon Has Alreasy Expired",
                'newprice' => $package->price
            );    
            return $response;
        }

        // check if Coupon Limit is Over
        if ($chk->ussage_limit == 0) {
            $response = array(
                'status' => "error",
                'msg' => "Coupon Has Alreasy Expired",
                'newprice' => $package->price
            );    
            return $response;
        }


        // // check if Coupon Package type
        // if (json_decode($chk->plan_id) == $request->package) {
        //     $response = array(
        //         'status' => "error",
        //         'msg' => "Coupon Has Alreasy Expired",
        //         'newprice' => $package->price
        //     );    
        //     return $response;
        // }

        


        if ($chk->discount_amt != null) {
            $amount = $package->price - $chk->discount_amt;
        }elseif($chk->discount_percent != null) {
            $amount = $package->price * ($chk->discount_percent/100);
        }else{
            $amount = $chk->flat_price;
        }


        $change_limit = $chk->ussage_limit - 1;
        DB::update('update coupons set ussage_limit = ? where id = ?',[$change_limit,$chk->id]);


        $response = array(
            'status' => "Success",
            'msg' => "Coupon Applied",
            'newprice' => $amount
        );
        
        // session()->put('coupon',$amount);
        session(['coupon' => $amount]);
        session(['couponname' => $request->coupon]);
        // $request->session()->flash('coupon', $amount);

        return $response;
    }


}
