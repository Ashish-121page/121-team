<?php

namespace App\Http\Controllers;

use App\Models\UserCurrency;
use App\User;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class CurrencyController extends Controller
{


    public function index(Request $request) {
        // Return Index View of Page

        $user = User::whereId($request->user)->first();

        $record = UserCurrency::where('user_id',$user->id)->get();
        return view('panel.currency.index',compact('record','user'));

    }



    public function update(Request $request) {

        try {
            $currency = UserCurrency::whereId($request->crrid)->first();

            $currency->currency = $request->currencyname;
            $currency->exchange = $request->currencyvalue;
            $currency->save();

            return back()->with('success',"Record Updated Success Fully");

        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error',"Error While Upoading.");
        }


    }



    public function uploadCurrency(Request $request,User $user) {
        try {

            $user_shop = getShopDataByUserId($user->id);
            $count = 0;
            $chk = UserCurrency::where('currency',$request->nameofcr)->where('user_id',$user->id)->get();
            if (count($chk) != 0) {
                $name = $request->nameofcr;
                echo $name;
                return back()->with('error',"$name Already Exist in Your Account.");
            }else{

                UserCurrency::create([
                    'user_id' => $user->id,
                    'User_shop_id' => $user_shop->id ?? 0,
                    'currency' => $request->nameofcr,
                    'exchange' => $request->exchangerate,
                    'remark' => $request->remarks ?? '',
                    'default_currency' => 0
                ]);
                $count++;
            }

            if($request->has('ref_type')){
                return back()->json(['state'=>'success','msg'=>"$count Record are added",'code'=>200]);
            }


            return back()->with('success',"$count Record are added");
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error',"There was and some issue. Try again later.");
        }
    }


    public function makedefault(Request $request, UserCurrency $record){


        try {

            $user = auth()->user();
            if ($record->user_id != $user->id) {
                return back()->with('error',"Something went Wrong");
            }
            // Removing Previous Default Currency
            $all = UserCurrency::where('user_id',$user->id)->get();

            foreach ($all as $key => $value) {
                $old_exchange = $value->exchange;
                $record_exchange = $record->exchange;

                $res = $old_exchange/$record_exchange;

                $value->update([
                    'default_currency' => 0,
                    'exchange' => $res,
                ]);
                $value->save();
            }

            // Make Default Currency
            $record->update([
                'default_currency' => 1,
                'exchange' => 1,
            ]);
            $record->save();

            return back()->with('success',"Default Currency Changed.");
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error',"Something went Wrong, Try again later");
        }

    }



}
