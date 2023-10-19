<?php
namespace App\Http\Controllers;
use App\Models\UserShop;
use App\Models\UserAddress;
use App\Models\UserShopItem;
use App\Models\Product;
use App\Models\Media;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\AccessCatalogueRequest;
use App\Models\AccessCode;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\TicketConversation;
use App\User;
use App\Models\Enquiry;
use App\Models\UserEnquiry;
use App\Models\MailSmsTemplate;
use App\Models\ProductAttribute;
use App\Models\ProductExtraInfo;
use App\Models\Proposal;
use App\Models\ProposalItem;
use App\Models\UserCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MicroSiteController extends Controller
{
    public function __construct(Request $request)
    {
        try {
            sessionManager($request,$request->subdomain);
            // if (Auth::check() != 1) {
            //     auth()->loginUsingId(155);
            // }
        } catch (\Throwable $th) {
            throw $th;
    }
}

   public function index(Request $request)
    {
        $slug = $request->subdomain;
        $user_shop = UserShop::whereSlug($slug)->first();
         if(!$user_shop){
            return back()->with('error', 'No micro site assign to your account!');
         }
        if(auth()->check()){
            $shop_owner_data = User::whereId($user_shop->user_id)->first();
            if(!$shop_owner_data){
                return back()->with('error', 'This Microsite Owner does not exist!');
            }
            // Catalogue Access Request Check
                $accessCode =  AccessCode::where('redeemed_user_id',auth()->id())->first();
                if($accessCode && $shop_owner_data->phone != null){
                    if($shop_owner_data->phone != auth()->user()->phone){
                        // $chk = AccessCatalogueRequest::whereUserId(auth()->id())->where('number',$shop_owner_data->phone)->where('status','!=',4)->first();
                        $acr_exists = AccessCatalogueRequest::where('user_id',auth()->id())->where('number',$shop_owner_data->phone)->exists();
                        $ar_status = 0;
                        if($request->has('g_id') && $request->get('g_id') != null){
                            $ar_status = 1;
                        }
                            // $acr = new AccessCatalogueRequest();
                            // $acr->user_id = auth()->id();
                            // $acr->number = $shop_owner_data->phone;
                            // $acr->status = $ar_status;
                            // $acr->price_group_id = $request->g_id ?? 0;
                            // $acr->save();
                    }
                }
            }
        $up = "Microsite View";
        DB::insert('insert into view_count (micro_slug,view,type) values(?,0,?)',[$slug,$up]);

        $random_products =  getProductByUserShopItemInRandomOrder($slug );
        $banner = Media::whereType('UserShop')->whereTag('Banner')->whereType('UserShop')->whereTypeId($user_shop->id)->first();
        $user = User::where('id', $user_shop->user_id)->first();
        //  $testimonial_images = Media::whereType('UserShop')->whereTag('Banner')->whereType('UserShop')->whereTypeId($user_shop->id)->first();
        $about = json_decode($user_shop->about,true);
        $story = json_decode($user_shop->story,true);
        $testimonial = json_decode($user_shop->testimonial,true);
        $products = json_decode($user_shop->products,true);
        $related_product_ids = UserShopItem::where('user_shop_id',$user_shop->id)->where('is_published',1)->inRandomOrder()->take(4)->get()->pluck('product_id');
        $related_products = Product::whereIn('id',$related_product_ids)->get();
        $group_id = getPriceGroupId($slug);
        if($group_id == 0 && $request->has('pg') && $request->get('pg')){
            $group_id = $request->get('pg');
        }
         //Share Icons
            // Share button 1
            $social = \Share::page(route('pages.index',$slug), $user_shop->title)
            ->facebook()
            ->twitter()
            ->linkedin($user_shop->description)
            ->whatsapp()
            ->getRawLinks();
            $shareButtons1 = \Share::page(route('pages.index',$slug), $user_shop->title)
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();
        return view('frontend.micro-site.index',compact('slug','banner','products','user_shop','about','testimonial','social','random_products','shareButtons1','story','related_products','group_id','user'));
    }
    public function shopCart(Request $request)
    {
        $slug = $request->subdomain;
        $author_id = UserShopUserIdBySlug($slug);
        // Check Author Access Code
        $chk_access_code = AccessCode::whereRedeemedUserId($author_id)->first();
        if(!$chk_access_code){
             return redirect(inject_subdomain('home', $slug))->with('error', 'This micro side is not offer selling at this movement. If you are a shop owner contact 121 Team for assisting you with Access Code.');
        }
        $cart_items = Cart::whereUserShopId(UserShopIdBySlug($slug))->whereUserId(auth()->id())->get();
        return view('frontend.micro-site.shop.cart',compact('slug','cart_items'));
    }

      public function wishList(Request $request)
    {
        $slug = $request->subdomain;
        return view('frontend.micro-site.wishlist.index',compact('slug'));
    }
    public function shopIndex(Request $request)
    {
        $slug = $request->subdomain;
        $is_search = 0;


        $user_shop = UserShop::whereSlug($slug)->first();
        if (!$user_shop->shop_view && $user_shop->user_id != auth()->id()) {
            return back();
        }
        

        $currency_record = UserCurrency::where('user_id',$user_shop->user_id)->get();


        $user_shop_items = Product::join('user_shop_items', 'products.id', '=', 'user_shop_items.product_id')
        ->selectRaw('products.id as products_id, products.title, products.sku ,products.model_code, products.price as product_price, user_shop_items.*');

        $proIds = UserShopItem::query()->where('user_id',$user_shop->user_id);
        if(request()->has('category_id') && request()->get('category_id') != null){
            $proIds = $proIds->where('category_id',request()->get('category_id'))->pluck('product_id');
        }else{
            $proIds = $proIds->pluck('product_id');
        }
        $additional_attribute = ProductExtraInfo::whereIn('product_id',$proIds)->groupBy('attribute_id')->pluck('attribute_id');
        
        // if(request()->has('searchVal') && request()->get('searchVal') != null){
        //     // - Getting Search Parameter
        //     $SerchParam = $request->get('searchVal'); // ! Hold Search Keywords
        //     $results = ProductExtraInfo::whereIn('product_id',$proIds)->groupby('group_id')->get(); // ! Get All Proiduct Data
        //     $dummy_arr =[]; // ! Store Unique Product Attribute Value....
        //     $NewProduct_id = []; // ! Store Result of FIna; Retrive Products....
        //     foreach ($results as $key => $result) {
        //         $dummy_arr[$result->product_id] = ProductExtraInfo::where('group_id',$result->group_id)->groupBy('attribute_value_id')->pluck('attribute_value_id');
        //     }
        //     foreach ($dummy_arr as $key => $value) {
        //         // ! CONVERT ARRIBUTE OBJECT TO ARRAY
        //         $search_arr = array_values((array) $value)[0];
        //         // ! Searching Array Elements inside Array With Help of Function
        //         if (searchArray($SerchParam,$search_arr)) {
        //             array_push($NewProduct_id,$key);
        //         }
        //     }
        //     $user_shop_items->whereIn('products.id', $NewProduct_id);
        // }
        foreach ($additional_attribute as $key => $value) {
            if (request()->has("searchVal_$key") && request()->get("searchVal_$key") != null) {
                $GetProduct = ProductExtraInfo::whereIn("attribute_value_id",request()->get("searchVal_$key"))->pluck('product_id');
                $user_shop_items->whereIn('products.id', $GetProduct);
                $is_search = 1;
            }
        }



        $alll_searches = [];
        array_push($alll_searches,[
            "Category" =>$request->get('category_id'),
            "Sub Category" => $request->get('sub_category_id'),
            "From" => $request->get('from'),
            "To" => $request->get('to')
        ]);
        
        if(request()->has('title') && request()->get('title') != null){
            $user_shop_items->where('user_shop_id',$user_shop->id)->where('products.title','like','%'.request()->get('title').'%')->orwhere('products.model_code','like','%'.request()->get('model_code').'%');
        }
        if(request()->has('category_id') && request()->get('category_id') != null){
            $user_shop_items->where('user_shop_items.category_id', request()->get('category_id'));
        }
        if(request()->has('sub_category_id') && request()->get('sub_category_id') != null){
            $user_shop_items->where('user_shop_items.sub_category_id', request()->get('sub_category_id'));
        }

        if(request()->has('brand') != null && request()->get('brand') != null){
            $user_shop_items->where('products.brand', request()->get('brand'));
        }
        if(request()->has('from')  && request()->get('from') != null &&  request()->has('to')  && request()->get('to') != null){
            if(request()->to == 10){
                $user_shop_items->where('user_shop_items.price','>=',request()->get('from'));
            }else{
                $user_shop_items->whereBetween('user_shop_items.price', [request()->get('from'), request()->get('to')]);
            }
        }

        if(request()->has('sort') && request()->get('sort') != null){
            if(request()->get('sort') == 1){
                $user_shop_items->orderBy('user_shop_items.id','DESC');
            }elseif(request()->get('sort') == 2){
                $user_shop_items->orderBy('user_shop_items.price','ASC');
            }elseif(request()->get('sort') == 3){
                $user_shop_items->orderBy('user_shop_items.price','DESC');
            }
        }

        if (request()->has('exclusive') && request()->get('exclusive') != null) {
            if (request()->get('exclusive') == 'on') {
                $user_shop_items->where('products.exclusive','1');
            }elseif (request()->get('exclusive') == 'off') {
                $user_shop_items->where('products.exclusive','0');
            }
        }else{
            $user_shop_items->where('products.exclusive','0');
        }

        $items = $user_shop_items
                ->whereIsPublished(1)
                ->where('user_shop_id',$user_shop->id)
                ->where('products.is_publish',1)
                // ->groupBy('product_id')
                ->groupBy('products.sku')
                ->orderBy('user_shop_items.created_at','DESC')
                ->where('user_shop_items.deleted_at', '=', null)
                ->paginate(21);

            
                
        $user_shop = UserShop::whereSlug($slug)->first();
        $have_access_code = AccessCode::where('redeemed_user_id',$user_shop->user_id)->first();
        if(!$have_access_code){
            return back()->with('error', 'No micro site assign to your account!');
        }
        $user_id = UserShopUserIdBySlug($slug);
        $group_id = getPriceGroupId($slug);
        if($group_id == 0 && $request->has('pg') && $request->get('pg')){
            $group_id = $request->get('pg');
        }
        // Check Author Access Code
        $chk_access_code = AccessCode::whereRedeemedUserId($user_id)->first();
        if(!$chk_access_code){
            return redirect(inject_subdomain('home', $slug))->with('error', 'This micro site does not offer selling at this moment. If you are a shop owner contact 121 Team for assisting you with Access Code.');
        }
        $categories = getProductCategoryByShop($slug,0);
        $brands_ids = $items->pluck('brand_id') ?? null;
        $brands_ids = [] ;
        $brands = Brand::whereIn('id',$brands_ids)->whereStatus(1)->get();
        $category_id = request()->get('category_id');
        $selectedcolors = request()->get('color');
        $minID = Product::whereNotNull('price')->where('user_id',$user_shop->user_id)->min("price");
        $maxID = Product::whereNotNull('price')->where('user_id',$user_shop->user_id)->max("price");
            // dd($minID);
            // dd($maxID);
            // magicstring($countattri);
            // return;


        $proposalid = -1;
        $temdata = json_decode($user_shop->team);
        $manage_offer_guest = $temdata->manage_offer_guest ?? 0;
        $manage_offer_verified = $temdata->manage_offer_verified ?? 0;
            
            
        if ($request->ajax()) {
            return view('frontend.micro-site.shop.loadIndex',compact('slug','categories','items','brands','group_id','user_shop','additional_attribute','proIds','user_shop','alll_searches','currency_record'));
        }

        // return view('frontend.micro-site.shop.index',compact('slug','categories','items','brands','group_id','user_shop','additional_attribute','proIds','minID','maxID','user_shop','alll_searches','currency_record'));
        return view('frontend.micro-site.proposals.index',compact('slug','categories','items','brands','group_id','user_shop','additional_attribute','proIds','minID','maxID','user_shop','alll_searches','currency_record','proposalid','request','manage_offer_guest','manage_offer_verified'));

    }

    public function shopPreCheckout(Request $request)
    {
        if(!auth()->check()){
            return redirect(route('auth.login-index'));
        }
        $slug = $request->subdomain;
        $user_shop = UserShop::whereSlug($slug)->first();
        return view('frontend.micro-site.shop.pre-checkout',compact('slug','user_shop'));
    }
    public function shopCategories(Request $request)
    {
        $slug = $request->subdomain;
        $user_shop = UserShop::whereSlug($slug)->first();
        $have_access_code = AccessCode::where('redeemed_user_id',$user_shop->user_id)->first();
        if(!$have_access_code){
            return back()->with('error', 'No micro site assign to your account!');
        }
        $categories = getProductCategoryByShop($slug,0);
        return view('frontend.micro-site.shop.shop-category',compact('slug','user_shop','categories'));
    }
    public function storePreCheckout(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $slug = $request->subdomain;
        $details = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        $customer_details = json_encode($details);
        $micro_site = UserShop::whereSlug($slug)->firstOrFail();
        $micro_site_cart = Cart::whereUserShopId($micro_site->id)->whereUserId(auth()->id())->get();
        $sub_total = $micro_site_cart->sum('total');
        $subtotaltax = 0;
        foreach ($micro_site_cart as $item){
           $tax_percent = 0;
           $tax_amount = 0;
           $product = getProductDataById($item->product_id);
           if($product->hsn_percent != null && $product->hsn_percent != 0){
               $tax_percent = $product->hsn_percent;
                $tax_amount = round(($item->total * $product->hsn_percent)/100,2);
           }
           $subtotaltax += $tax_amount;
        }
            $address = UserAddress::whereId($request->address)->firstOrFail();
            if(!$address){
                return back()->with('error','Invalid Address, Please choose a new address');
            }
            // Address Object Prepration
            $to = json_decode($address->details);
            $to->type = $address->type;
            $to = json_encode($to);
            if($request->has('same_as_billing') && $request->same_as_billing == "on"){
                $shipping_address = $to;
            }else{
                $shipping_address_chk = UserAddress::whereId($request->shipping_address)->firstOrFail();
                if(!$shipping_address_chk){
                    return back()->with('error','Invalid Shipping Address, Please choose a new address');
                }
                // Address Object Prepration
                $shipping_address = json_decode($shipping_address_chk->details);
                $shipping_address->type = $shipping_address_chk->type;
                $shipping_address = json_encode($shipping_address);
            }

        $data = new Order();
        $data->user_id=auth()->id();
        $data->flag= 1;
        $data->type= 'UserShop';
        $data->type_id= $micro_site->id;
        $data->txn_no='ORD'.rand(00000,99999);
        $data->discount=null;
        $data->tax=$subtotaltax;
        $data->sub_total=$sub_total ?? 0;
        $data->total=($sub_total + $subtotaltax)?? 0;
        $data->status=1;
        $data->payment_status=1;
        $data->payment_gateway=null;
        $data->remarks=$request->description;
        $data->from=invoiceFrom();
        $data->to=$to;
        $data->date=now();
        $data->customer_details = $customer_details;
        $data->shipping_address = $shipping_address;
        $data->save();
        $order_id = $data->id;
        // TODO Add address and customer details
        foreach($micro_site_cart as $cart_item){
            $tax_percent = 0;
            $tax_amount = 0;
            $product = getProductDataById($item->product_id);
            if($product->hsn_percent != null && $product->hsn_percent != 0){
                $tax_percent = $product->hsn_percent;
                    $tax_amount = round(($item->total * $product->hsn_percent)/100,2);
            }
            $order_children = new OrderItem();
            $order_children->order_id = $data->id;
            $order_children->item_type =  'Product';
            $order_children->item_id =  $cart_item->id;
            $order_children->price = $cart_item->price??0;
            $order_children->qty = $cart_item->qty;
            $order_children->tax = $tax_percent;
            $order_children->tax_amount = $tax_amount;
            $order_children->save();
        }
        foreach($micro_site_cart as $cart){
            $cart->delete();
        }
        try{
            //  // Mail sent to Customer
            // if($data->user_id != null ){
            //     $user_record =  getUserRecordByUserId($data->user_id);
            //     $mailcontent_data = MailSmsTemplate::where('code','=',"order-created-customer")->first();
            //     if($mailcontent_data){
            //         $arr=[
            //             '{name}'=> $user_record->name,
            //             '{order_id}'=> $data->id,
            //             ];
            //     $action_button = null;
            //     TemplateMail($user_record->name,$mailcontent_data,$user_record->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
            //     }
            //     $onsite_notification['user_id'] =  $user_record->id;
            //     $onsite_notification['title'] = "You have created a new order request with the order ID #ORD$data->id " ;
            //     $onsite_notification['link'] = "#";
            //     pushOnSiteNotification($onsite_notification);
            // }else{
            //     return back()->with('error','No user record exist');
            // }
            // // Mail sent to Seller
            // if($micro_site->id != null ){
            // $item_name =  getProductNameByOrderId($data->id);
            //     $user_shop_record  =  getShopDataByShopId($micro_site->id);
            //     $seller_record  =  getUserRecordByUserId($user_shop_record->user_id);
            //     $mailcontent_data = MailSmsTemplate::where('code','=',"order-created-seller")->first();
            //         if($mailcontent_data){
            //             $arr=[
            //                 '{name}' => $user_record->name,
            //                 '{seller_name}' => $seller_record->name,
            //                 '{order_id}' => $data->id,
            //                 '{order_at}' => $data->created_at,
            //                 '{item_name}' => $item_name,
            //             ];
            //         $action_button = null;
            //         TemplateMail($seller_record->name,$mailcontent_data,$seller_record->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
            //         }
            //         $onsite_notification['user_id'] =  $user_shop_record->user_id;
            //         $onsite_notification['title'] = auth()->user()->name ." has created a new order request with the order ID #ORD$data->id " ;
            //         $onsite_notification['link'] = "#";
            //         pushOnSiteNotification($onsite_notification);
            // }else{
            //     return back()->with('error','No user record exist');
            // }
        }catch(\Exception $e){
        }
        return redirect(route('pages.shop-post-checkout').'?order_id='.$data->id);
    }
    public function shopPostCheckout(Request $request)
    {
        $slug = $request->subdomain;
        $order_id = $request->order_id;
        $order = Order::find($request->order_id);
        $user_shop = UserShop::whereSlug($slug)->first();
        $details = json_decode($user_shop->payment_details,true);
        $user = User::whereId( $user_shop->user_id)->first();
        return view('frontend.micro-site.shop.checkout',compact('user','order','slug','user_shop','details','order_id'));
    }
    public function updateOrderAddress(Request $request)
    {
        $slug = $request->subdomain;
        $address = UserAddress::whereId($request->address)->first();
        if(!$address){
            return back()->with('error','Invalid Address, Please choose a new address');
        }
        $to = json_decode($address->details);
        $to->type = $address->type;
        $to = json_encode($to);
        if($request->has('same_as_billing') && $request->same_as_billing == "on"){
            $shipping_address = $to;
        }else{
            $shipping_address_chk = UserAddress::whereId($request->shipping_address)->firstOrFail();
            if(!$shipping_address_chk){
                return back()->with('error','Invalid Shipping Address, Please choose a new address');
            }
            // Address Object Prepration
            $shipping_address = json_decode($shipping_address_chk->details);
            $shipping_address->type = $shipping_address_chk->type;
            $shipping_address = json_encode($shipping_address);
        }
        $order = Order::find($request->id);
        $order->to = $to;
        $order->shipping_address = $shipping_address;
        $order->save();
        return redirect(inject_subdomain("post-checkout?order_id=".$order->id,$slug,true));
    }
    
    public function storeShopCheckout(Request $request)
    {
        // return $request->all();
        $slug = $request->subdomain;
        $order = Order::whereId($request->order_id)->first();
        if($order->seller_payment_details != null){
            return redirect(route('customer.dashboard')."?active=order")->with('error',"Payment has been made!");
        }
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
        ]);
        // Mail & notifications
             // Mail sent to Customer
                $user_record =  getUserRecordByUserId($order->user_id);
                $mailcontent_data = MailSmsTemplate::where('code','=',"order-created-customer")->first();
                if($mailcontent_data){
                    $arr=[
                        '{name}'=> $user_record->name,
                        '{order_id}'=> $order->id,
                        ];
                $action_button = null;
                TemplateMail($user_record->name,$mailcontent_data,$user_record->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
                }
                $onsite_notification['user_id'] =  $user_record->id;
                $onsite_notification['title'] = "Your Order #ORD".$order->id." has been placed Successfully!" ;
                $onsite_notification['link'] = url('/customer/dashboard?active=order');
                pushOnSiteNotification($onsite_notification);

            // Mail sent to Seller
            $item_name =  getProductNameByOrderId($order->id);
                $user_shop_record  =  getShopDataByShopId($order->type_id);
                $seller_record  =  getUserRecordByUserId($user_shop_record->user_id);
                $mailcontent_data = MailSmsTemplate::where('code','=',"order-created-seller")->first();
                if($mailcontent_data){
                    $arr=[
                        '{name}' => $user_record->name,
                        '{seller_name}' => $seller_record->name,
                        '{order_id}' => $order->id,
                        '{order_at}' => $order->created_at,
                        '{item_name}' => $item_name,
                    ];
                    $action_button = null;
                    TemplateMail($seller_record->name,$mailcontent_data,$seller_record->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
                }
            $onsite_notification['user_id'] =  $user_shop_record->user_id;
            $onsite_notification['title'] = auth()->user()->name ." has placed an order #ORD".$order->id." form your shop." ;
            $domain = env('APP_DOMAIN');
            $channel = env('APP_CHANNEL');
            $path = "panel/orders/show/".$order->id;
            $onsite_notification['link'] = $channel.$domain.'/'.$path;
            pushOnSiteNotification($onsite_notification);
        // Mail & notifications

        return redirect(route('pages.thank-you')."?order_id=".$order->id)->with('success','Your Order request sent successfully');
    }

    public function shopCategory(Request $request)
    {
        $slug = $request->subdomain;
        return view('frontend.micro-site.shop.category',compact('slug'));
    }
    public function thankYou(Request $request)
    {
        $slug = $request->subdomain;
        return view('frontend.micro-site.shop.thankyou',compact('slug'));
    }

    public function shopShow(Request $request,$id)
    {
  
        $debugingMode = 0;
        $id = crypt::decrypt($id) ?? $id;
        $show_product = $id;
        // echo "Old Id is ". $id.newline(2);        
        
        if (request()->has('selected_default') || request()->has('selected_Cust') ) {
            $request['search_keywords'] = array_merge(
                request()->get('selected_default') ?? [],
                request()->get('selected_Cust') ?? []
            );
        }
        $slug = $request->subdomain;
        $user_shop = UserShop::where('slug',$slug)->first();
        if(!$user_shop){
            return back()->with('error', 'Shop moved or does not exist!');
        }
        
        $group_id = getPriceGroupId($slug);
        if($group_id == 0 && $request->has('pg') && $request->get('pg')){
            $group_id = $request->get('pg');
        } 
        $product = Product::whereId($id)->first(); 

        if (request()->has('search_keywords') &&  request()->get('search_keywords') != '') {
            $SerchParam = request()->get('search_keywords');
            $SerchParam = array_filter($SerchParam);
            
            $result = ProductExtraInfo::whereIn('attribute_value_id',$SerchParam)->where('group_id',$product->sku)->groupBy('product_id')->pluck('product_id');

            
            
            $result_attri_tmp = ProductExtraInfo::whereIn('product_id',$result)->groupBy('attribute_value_id')->pluck('attribute_value_id');   
            $result_attri = [];
            
            foreach ($result_attri_tmp as $key => $value) {
                array_push($result_attri,$value);
            }
            if ($request->has('debug')) {
                echo "Id Is $id".newline(2);
                
                echo "SKU $product->sku".newline(2);
                Echo "Result ";
                magicstring($result);
                Echo "Result Attribute";
                magicstring($result_attri_tmp);
                Echo "Request That Received";
                magicstring($request->all());
                Echo "Search Parameters";
                magicstring($SerchParam);    
                
                return;
            }
            
            
            foreach ($result as $key => $product_info_id) {
                $gettingAttribute[$product_info_id] = ProductExtraInfo::where('product_id',$product_info_id)->groupBy('attribute_value_id')->pluck('attribute_value_id');
                $array_New_products = [];
                $dummy_arrr = [];
                foreach ($gettingAttribute as $key => $value) {
                    $search_arr = array_values((array) $value)[0];
                    // ! Searching Array Elements inside Array With Help of Function
                    if (searchArray($SerchParam,$search_arr)) {
                        array_push($array_New_products,$key);
                    }
                }
            }
            if ($array_New_products != null) {
                // `  Change Request Product id
                $product = Product::whereId($array_New_products[0])->first(); 
            }
            
        }else{
            $result_attri  = [];
        }    
        if(!$product){
            return back()->with('error', 'Product does not exist!');
        }
        $user_product = getUserShopItemByProductId($user_shop->slug, $id);
          if(!$user_product){
                    return back()->with('error', 'Item does not exist!');
            }
        $shipping_details = json_decode($product->shipping,true);
        $related_product_ids = UserShopItem::where('user_shop_id',$user_shop->id)->where('sub_category_id',$product->sub_category_id)->where('is_published',1)->where('product_id','!=',$product->id)->inRandomOrder()->take(4)->get()->pluck('product_id');
        
        $related_products = Product::whereIn('id',$related_product_ids)->groupBy('sku')->get();
        
        $carton_details = json_decode($product->carton_details,true);
        $variations = Product::whereSku($product->sku)->pluck('id');
        $scan = $request->get('scan');
        $proposalidrequest = $request->get('proposalreq') ?? 0;
        // ` Work Start Here
        $features = $product->features;
        $attributes = ProductAttribute::where('user_id',null)->orwhere('user_shop_id',$user_shop->id)->get();
        
        $colors = ProductExtraInfo::where('group_id',$product->sku)->where('attribute_id',1)->groupBy('attribute_value_id')->get();
        $sizes = ProductExtraInfo::where('group_id',$product->sku)->where('attribute_id',2)->groupBy('attribute_value_id')->get();
        $materials = ProductExtraInfo::where('group_id',$product->sku)->where('attribute_id',3)->groupBy('attribute_value_id')->get();      

        $groupIds = ProductExtraInfo::where('group_id',$product->sku)->groupBy('Cust_tag_group')->pluck('Cust_tag_group');
        
        $currency_record = UserCurrency::where('user_id',$user_shop->user_id)->get();
        

        $curretpage = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $curretpage = shrinkurl($curretpage);
        $share_msg = "Hey I got Something New on The Internet That Help You!! \n\n $curretpage \n\n You Can Use this To Groww Your Business";

        
        
        $share_msg = "$product->title. \nOffer : $product->price \nMRP : $product->mrp \n\nHere's the link for more details :   \n$curretpage";

        $shareButtons1 = \Share::page(urlencode($share_msg))
        ->facebook()
        ->twitter()
        ->linkedin()
        ->telegram()
        ->whatsapp()
        ->reddit();

        // ` Work End Here
        return view('frontend.micro-site.shop.show',compact('slug','group_id','product','user_shop','shipping_details','carton_details','user_product','related_products','variations','scan','proposalidrequest','show_product','features','attributes','colors','sizes','materials','result_attri','shareButtons1','groupIds','currency_record'));
    }

    public function contactIndex(Request $request)
    {
         $slug = $request->subdomain;
         $user_shop = UserShop::whereSlug($slug)->first();
         // Share button 1
            $social = \Share::page(route('pages.index',$slug), $user_shop->title)
            ->facebook()
            ->twitter()
            ->linkedin($user_shop->description)
            ->whatsapp()
            ->getRawLinks();
        $user = User::whereId($user_shop->id)->first();
        return view('frontend.micro-site.contact.index',compact('slug','user_shop','social','user'));
    }
    public function aboutIndex(Request $request)
    {
        $slug = $request->subdomain;
        $user_shop = UserShop::whereSlug($slug)->first();
        $story = json_decode($user_shop->story,true);
        $about = json_decode($user_shop->about,true);
        $team = json_decode($user_shop->team,true);
        $features = json_decode($user_shop->features,true);
        return view('frontend.micro-site.about.index',compact('slug','story','about','team','user_shop','features'));
    }
    public function addCart(Request $request)
    {
        if(!auth()->check()){
            return redirect(route('auth.login-index'));
        }
         $slug = $request->subdomain;
        $product = Product::whereId($request->product_id)->first();
        if(!$product){
              return back()->with('error', 'Item not found!');
        }
        if($product->user_id == auth()->id() || UserShopUserIdBySlug($slug) == auth()->id()){
              return back()->with('error', 'You can not add your own product');
        }
        $user_shop_item = getUserShopItemByProductId($slug, $product->id);
        if(!$user_shop_item){
              return back()->with('error', 'Item not found or not available currently!');
        }
        $chk =  Cart::whereUserId(auth()->id())->whereUserShopId($user_shop_item->user_shop_id)->whereProductId($product->id)->first();
        if($chk){
            $chk->update([
                'qty' => $request->qty,
                'price' => $request->unit_price,
                'total' => $request->qty*$request->unit_price,
            ]);
        }else{
            $data = new Cart();
            $data->user_id = auth()->id();
            $data->user_shop_id = $user_shop_item->user_shop_id;
            $data->product_id = $product->id;
            $data->user_shop_item_id = $user_shop_item->id;
            $data->qty = $request->qty;
            $data->price = $request->unit_price;
            $data->total = $request->qty*$request->unit_price;
            $data->save();
        }
        return back();
        // return back()->with('success', 'Item Added to cart successfully');
    }
    public function updateCart(Request $request)
    {
        try{
            $request->all();
            $cart =  Cart::find($request->id);
            // $cart_count = Cart::whereUserId(auth()->id())->whereUserShopId()
            if($request->type == "minus"){
                $qty = $cart->qty - 1;
            }elseif($request->type == "plus"){
                $qty = $cart->qty + 1;
            }
            $cart->qty = $qty;
            $cart->total = $cart->price * $qty;
            $cart->save();
            if($qty < 1){
                $cart->delete();
            }
            if($qty < 1){
                return redirect()->route('customer.dashboard',['active' => 'dashboard'])->with('success', 'Cart Updated Successfully!');
            }else{
                return back()->with('success', 'Cart Updated Successfully!');
            }
        }catch (\Exception $e) {
            return back();
        }
    }
    public function removeCart(Request $request,$cart_id)
    {
        $user_shop = UserShop::whereSlug($request->subdomain)->first();
        $cart =  Cart::whereId($cart_id)->first();
        $cart_count = $cart->whereUserId(auth()->id())->whereUserShopId($user_shop->id)->count();
        if($cart_count > 1){
            $cart->delete();
            return back();
        }else{
            $cart->delete();
            return redirect(inject_subdomain('home', $user_shop->slug, true));
        }
    }
    public function contactStore(Request $request)
    {
        // return $request->all();
        $slug = $request->subdomain;
        $user_shop_record = UserShop::whereSlug($slug)->first();
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
            ]);
            $data = new UserEnquiry();
            $data->name=$request->name;
            $data->email=$request->email;
            $data->type='microsite_enquiry';
            $data->type_id=$user_shop_record->id;
            $data->status=0;
            $data->subject=$request->subject;
            $data->description=$request->description;
            $data->save();
            //Mail send to Customer
            if($user_shop_record != null){
                $seller_record = getUserRecordByUserId($user_shop_record->user_id);
                $mail_code = "enquiry-mail-to-customer";
                $mailcontent_data = MailSmsTemplate::whereCode($mail_code)->first();
                 if($mailcontent_data){
                        $mail_arr = [
                        "{name}" => $request->name,
                        "{inq_id}" => $request->id,
                        "{shop_name}" => $seller_record->name,
                        ];
                    TemplateMail($request->name, $mail_code, $request->email, $mailcontent_data->type, $mail_arr,$mailcontent_data,$mailcontent_data->footer,null);
                 }
            }
            // Mail send to Seller
            if($user_shop_record != null){
                $seller_record = getUserRecordByUserId($user_shop_record->user_id);
                $mail_code = "new-enquiry-to-seller-shop";
                $mailcontent_data = MailSmsTemplate::whereCode($mail_code)->first();
                if($mailcontent_data){
                   $mail_arr = [
                        "{name}" => $request->name,
                        "{inq_id}" => $request->id,
                        "{seller_name}" => $seller_record->name,
                        "{subject}" => $request->subject,
                        "{email}" => $request->email,
                            ];
                        TemplateMail($seller_record->name, $mail_code, $seller_record->email, $mailcontent_data->type, $mail_arr,$mailcontent_data,$mailcontent_data->footer,null);
                }
            }
            return back()->with('Success', 'Thank you for contacting us! Our team of experts will get in touch with you shortly.');
    }
    public function storeEnquiry(Request $request)
    {
        $slug = $request->subdomain;
        $user_shop = UserShop::whereSlug($slug)->first();
        if(!$user_shop){
            return back()->with('Success', 'This shop is no longer selling on 121.');
        }
        try {
            $this->validate($request, [
                'price' => 'required',
                'qty' => 'required',
            ]);
            $enquiry = new Enquiry();
            $enquiry->client_name = auth()->user()->name;
            $enquiry->client_email = auth()->user()->email;
            $enquiry_data['qty'] = $request->qty;
            $enquiry_data['price'] = $request->price;
            $enquiry_data['required_in'] = $request->date;
            $enquiry_data['comment'] = $request->comment;
            $enquiry_data['product_id'] = $request->product_id;
            $enquiry->description = json_encode($enquiry_data);
            $enquiry->title= 'Product Enquiry';
            $enquiry->user_id = auth()->id();
            $enquiry->enquiry_type_id=null;
            $enquiry->last_activity=now();
            $enquiry->status=0; // New
            $enquiry->micro_site_id=$user_shop->id;
            $enquiry->save();
            $pending_enquiries = Enquiry::where('micro_site_id',$user_shop->id)->whereStatus(0)->count();
            $product = Product::where('id',$request->product_id)->first();
            $user_record =  getUserRecordByUserId($user_shop->user_id);
            // Send SMS
                $mailcontent_data = MailSmsTemplate::where('code','=',"send-enquiry-sms")->first();
                    if($mailcontent_data){
                        $arr=[
                            '{customer_name}'=>auth()->user()->name,
                            '{unit}'=>$request->qty,
                            '{pending_enquiries}'=> $pending_enquiries,
                        ];
                        $msg = DynamicMailTemplateFormatter($mailcontent_data->body,$mailcontent_data->variables,$arr);
                        sendSms($user_record->phone,$msg,$mailcontent_data->footer);
                    }
            // Notification For Seller Start
                $mailcontent_data = MailSmsTemplate::where('code','=',"enquiry-created-customer")->first();
                if($mailcontent_data){
                    $arr=[
                        '{name}'=> $user_record->name,
                        '{enquiry_id}'=> $enquiry->id,
                        '{product_id}'=> $request->product_id,
                        '{product_name}'=> $product->title,
                        ];
                $action_button = null;
                TemplateMail($user_record->name,$mailcontent_data,$user_record->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
                }
                $onsite_notification['user_id'] =  $user_shop->user_id;
                $onsite_notification['title'] = auth()->user()->name." Raise a new enquiry #ENQ".$enquiry->id." for ".$product->title." #PRO".$request->product_id;
                $domain = env('APP_DOMAIN');
                $channel = env('APP_CHANNEL');
                $path = "panel/admin/manage/enquiry/show/".$enquiry->id;
                $onsite_notification['link'] = $channel.$domain.'/'.$path;
                pushOnSiteNotification($onsite_notification);
            return back()->with('Success', 'Enquiry sent. You can chat with Supplier in Account ');
            // return redirect(route('customer.chat.show',$enquiry->id))->with('success', 'Your Enquiry Request Submitted Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function shopPreCheckoutStore(Request $request)
    {
         $slug = $request->subdomain;
        $product = Product::whereId($request->product_id)->first();
        $user_shop_item = getUserShopItemByProductId($slug,$product->id);
        $data = new Order();
        $data->user_id=auth()->id();
        $data->type='product';
        $data->type_id=$request->product_id;
        $data->txn_no='ORD'.rand(00000,99999);
        $data->discount=null;
        $data->tax=null;
        $data->sub_total=$request->price ?? 0;
        $data->total=$request->price ?? 0;
        $data->status=1;
        $data->payment_status=1;
        $data->payment_gateway=null;
        $data->remarks=$request->description;
        $data->from=invoiceFrom();
        $data->to=null;
        $data->date=now();
        $data->save();
        return back()->with('Success', 'Item Added to cart successfully');
    }
    public function orderHistory(Request $request)
    {
         $slug = $request->subdomain;
        return view('frontend.micro-site.order.index',compact('slug'));
    }
    function addpropitem(Request $request){
        // Adding Products Via Form
        magicstring($request->all());
        try {
            // Proposal Item Details For Upload
            $proposal_id = $request->get('proposal_details');
            $product_id = $request->get('product_id');
            $user_shop_item_id = 0;
            $price = $request->get('price');
            $sequence = null;
            $note = '';
            $user_id = $request->get('user_id');
            // Check Product Exist In Proposal or Not
            $chk1 = ProposalItem::where('product_id',$product_id)->where('proposal_id',$proposal_id)->get()->count();
            if ($chk1 != 0) {
                return back()->with('error',"Product Already Added In Offer");
            }
            ProposalItem::create([
                'proposal_id' => $proposal_id,
                'product_id' => $product_id,
                'user_shop_item_id' => $user_shop_item_id,
                'price' => $price,
                'sequence' => $sequence,
                'note' => $note,
                'user_id' => $user_id,
            ]);
            return back()->with('success',"Product Added to Proposal Successfully.");
        } catch (\Throwable $th) {
            return back()->with('error',"Error While Adding Product, ".$th);
        }
    }


    public function chagecurrency(Request $request) {
        
        if ($request->ajax()) {
            $slug = $request->subdomain;
            $user_shop = UserShop::whereSlug($slug)->first();
    
            $record = UserCurrency::whereId($request->currency_Id)->where('user_id',$user_shop->user_id)->first();
    
    
            Session::put('Currency_exchange', $record->exchange);
            Session::put('Currency_id', $record->id);
            Session::put('currency_name', $record->currency);
            Session::save();

            $crname = $record->currency;
            $response = array(['key' => 200,"Result" => "Currency Change To $crname"]);
            return json_encode($response);
        }else{
            // return "I Think You are Lost Go Back To Home";
            abort(404);
        }


    }

    
    
    

}
