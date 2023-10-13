<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Proposalenquiry;
use App\Models\Team;

class DevRouteController extends Controller
{

    public function jaya() {
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
        
        return view('devloper.Jaya.index',compact('enquiry_amt','Numbverofoffer','productcount','teams'));
    }
    
    public function jayaform(){
        return view('devloper.jaya.form-check');
    }    
}