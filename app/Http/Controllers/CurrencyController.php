<?php

namespace App\Http\Controllers;

use App\Models\UserCurrency;
use App\User;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{


    public function index(Request $request) {
        // Return Index View of Page
        
        $user = User::whereId($request->user)->first();

        $record = UserCurrency::where('user_id',$user->id)->get();
        return view('panel.currency.index',compact('record','user'));

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
