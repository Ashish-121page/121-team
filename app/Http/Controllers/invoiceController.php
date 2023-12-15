<?php

namespace App\Http\Controllers;
// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Product;
use App\Models\UserShop;
use App\Models\Media;
use App\Models\Brand;
use App\Models\AccessCatalogueRequest;

class invoiceController extends Controller
{    
    // public function index() {
    //     return view('panel.invoice.index');
    // }

    // public function secondview() {
    //     return view('panel.invoice.secondview');
    // }

    // public function thirdview() {
    //     return view('panel.invoice.thirdview');
    // }

    // public function fourthview() {
    //     return view('panel.invoice.fourthview');
    // }

    // public function Quotation() {
    //     return view('panel.invoice.Quotation');
    // }


    public function index() {
        return view('panel.Documents.index');
    }

    public function secondview() {
        return view('panel.Documents.secondview');
    }

   

    public function thirdview() {

        
        $user_id = auth()->id();
        $user = auth()->user();
        $user_shop = getShopDataByUserId($user->id);

        $user_shop = UserShop::whereUserId($user_id)->first();


        $length = request()->get('pagelength',19);
        $scoped_products = Product::whereUserId($user_id)->paginate($length);

        $supplier = User::whereId(auth()->id())->first();

        $access_data = AccessCatalogueRequest::whereUserId(auth()->id())->whereNumber($supplier->phone)->whereStatus(1)->first();

        $pinned_items = [];
        // foreach($scoped_products as $scoped_product){
        //     $scoped_product->update(['is_publish' => 1]);
        // }

        return view('panel.Documents.thirdview', compact('user_id','user','user_shop','scoped_products','access_data','pinned_items'));
    }

    public function fourthview() {
        return view('panel.Documents.fourthview');
    }

    public function Quotation() {
        return view('panel.Documents.Quotation');
    }



    
}
