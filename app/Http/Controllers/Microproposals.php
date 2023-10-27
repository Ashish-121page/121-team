<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\ProposalItem;
use App\Models\UserShopItem;
use App\Models\AccessCatalogueRequest;
use App\Models\Brand;
use App\Models\ProductAttribute;
use App\Models\UserShop;
use App\User;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\City;
use App\Models\Inventory;
use App\Models\Media;
use App\Models\ProductExtraInfo;
use App\Models\Proposalenquiry;
use App\Models\TimeandActionModal;
use App\Models\UserCurrency;
use Carbon\Carbon;
use Carbon\Doctrine\CarbonDoctrineType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Else_;

use function GuzzleHttp\Promise\all;



class Microproposals extends Controller
{

    public function __construct(Request $request)
    {
        try {
            sessionManager($request,'*');
            // if (Auth::check() != 1) {
            //     auth()->loginUsingId(155);
            // }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    function create(Request $request) {    
        if (!Auth::check()) {
            auth()->loginUsingId(155);
        }
        

        $slug = $request->subdomain;
        $user_shop = UserShop::whereSlug($slug)->first();

        $temdata = json_decode($user_shop->team);
        $manage_offer_guest = $temdata->manage_offer_guest ?? 0;
        $manage_offer_verified = $temdata->manage_offer_verified ?? 0;



        if ($manage_offer_guest == 0) {
            if (auth()->id() == 155) {
                return back()->with('error',"You do not have access to make offer");
            }
        }
        if ($manage_offer_verified == 0) {
            if (auth()->id() != 155 && auth()->id() != $user_shop->user_id) {
                return back()->with('error',"You do not have access to make offer");
            }
        }

        try{
            if(AuthRole() == "User"){
                $package = getUserPackageInfo(auth()->id());
                if(!$package){
                    return back()->with('error','You dont have any active package');
                }
                // return Proposal::whereUserId(auth()->id())->get()->count();
                $limits = json_decode($package->limit,true);
                $current_proposals = Proposal::whereUserId(auth()->id())->get()->count();
                
                if($limits['custom_proposals'] <= $current_proposals ){
                    return  back()->with('error','Your Custom Proposals limit exceed!');
                }
            }

            $arr = [
                'customer_name'=> $request->get('offerfor'),
                'customer_mob_no'=> $request->get('offerphone') ?? "", 
                'customer_email'=> $request->get('offeremail') ?? "", 
                'offer_alias' => $request->get('offeralias') ?? "",  
            ];
            

            $proposal = new Proposal();
            $proposal->customer_details = json_encode($arr);
            $proposal->slug = getUniqueProposalSlug("proposal".auth()->id());
            $proposal->user_id = auth()->id();
            $proposal->user_shop_id = UserShopIdByUserId(auth()->id());
            $proposal->margin = $request->margin;
            $proposal->relate_to =  $request->get('shop') ?? UserShopIdByUserId(auth()->id());
            $proposal->type =  $request->get('offer_type') ?? 0;
            $proposal->linked_proposal = $request->get('linked_offer') ?? null;
            $proposal->save();
            

            // // return  redirect(route('pages.proposal.edit',$proposal->id));
            return  redirect(route('pages.proposal.edit',['proposal' => $proposal->id,'user_key' => encrypt(auth()->id())]).'?margin='.$request->margin );
            
            // magicstring($proposal);
            
        }catch(\Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


   /**
     * Show the form for editing the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    function edit(Request $request, Proposal $proposal, $user_key) {   
       
        if (!Auth::check()) {
            auth()->loginUsingId(155);
        }
        
        
        $slug = $request->subdomain;
        $user_shop = UserShop::whereSlug($slug)->first();
                
        $temdata = json_decode($user_shop->team);
        $manage_offer_guest = $temdata->manage_offer_guest ?? 0;
        $manage_offer_verified = $temdata->manage_offer_verified ?? 0;
        
        
        if ($manage_offer_guest == 0) {
            if (auth()->id() == 155) {
                return back()->with('error',"You Didn't Have Access to Make Offer");
            }
        }
        if ($manage_offer_verified == 0) {
            if (auth()->id() != 155 && auth()->id() != $user_shop->user_id) {
                return back()->with('error',"You Didn't Have Access to Make Offer");
            }
        } 
        
        
        // Show All Suppliers
        $supplier_phones = AccessCatalogueRequest::whereUserId(auth()->id())->pluck('number');
        $suppliers = User::whereIn('phone',$supplier_phones)->where('status',1)->get();
        $supplier_shop_products = UserShopItem::whereIn('user_id',$suppliers->pluck('id'))->where('is_published',1)->pluck('product_id');
        // $supplier_shop_products_list = UserShopItem::whereIn('user_id',$suppliers->pluck('id'))->where('is_published',1)->get();
        $supplier_shop_products_list = UserShopItem::whereIn('user_id',$suppliers->pluck('id'))->where('user_id',$user_shop->user_id)->where('is_published',1)->get();


        $userids = User::role('User')->pluck('id');
        $brands = Brand::whereStatus(1)->where(function($brand_query) use ($userids){
                $brand_query->where('user_id','=',auth()->id());
                    $brand_query->orWhereNotIn('user_id',$userids)->whereIsVerified(1);
                    $brand_query->orWhere('user_id','=',null)->whereIsVerified(1);
                })->get();

        $master_products = Product::query();

     

        if ($proposal->relate_to !=null) {   
            if (UserShop::whereId($proposal->relate_to)->first()->user_id != auth()->id()) {
                $related = UserShop::whereId($proposal->relate_to)->first()->user_id ?? auth()->id();
            }else{
                $related = UserShop::whereId($proposal->relate_to)->first()->user_id ?? "";
            }
        }else{
            $related = auth()->id();
        }

        if($proposal->linked_proposal != ''){
            // if ($proposal->type != 1) {
            //     echo "You Don't Have Access of This Page..";
            // }
            $ids = ProposalItem::where('proposal_id',$proposal->linked_proposal)->pluck('product_id');
            $master_products->whereIn('id',$ids);

            $proIds = ProposalItem::where('proposal_id',$proposal->linked_proposal)->get();

            // magicstring($master_products->get());
            // return;
        }else{
            $master_products->where(function($query) use($brands,$supplier_shop_products,$related){
                $query->where('user_id',$related);
                $query->orWhereIn('brand_id',$brands->pluck('id'));
                $query->orWhereIn('id',$supplier_shop_products);
            });

            $proIds = UserShopItem::query()->where('user_id',$user_shop->user_id);
        }    
        
        

        if (request()->has('exclusive') && request()->get('exclusive') != null) {
            if (request()->get('exclusive') === 'on') {
                $master_products->where('exclusive','1');
            }else{
                $master_products->where('exclusive','0');
            }
        }else{
            $master_products->where('exclusive','0');
        }



        
        $colors = Product::whereIn('id',$master_products->pluck('id'))->groupBy('color')->orderBy('color')->pluck('color');
        $sizes = Product::whereIn('id',$master_products->pluck('id'))->groupBy('size')->orderBy('size')->pluck('size');
        $material = Product::whereIn('id',$master_products->pluck('id'))->groupBy('material')->orderBy('material')->pluck('material');
        
        
        // magicstring($master_products->get());
        // return;
        
        $master_products_categories = $master_products->where('is_publish',1)->get()->pluck('category_id');
        $categories = Category::whereIn('id',$master_products_categories)->groupBy('id')->get();
        
        
        
        if(request()->has('category_id') && request()->get('category_id') != null){
            $proIds = $proIds->where('category_id',request()->get('category_id'))->pluck('product_id');
        }else{
            $proIds = $proIds->pluck('product_id');
        }

        $additional_attribute = ProductExtraInfo::whereIn('product_id',$proIds)->groupBy('attribute_id')->pluck('attribute_id');




        foreach ($additional_attribute as $key => $value) {
            if (request()->has("searchVal_$key") && request()->get("searchVal_$key") != null) {
                $GetProduct = ProductExtraInfo::whereIn("attribute_value_id",request()->get("searchVal_$key"))->pluck('product_id');
                $master_products->whereIn('id', $GetProduct);
            }
        }


        // Filter Data
        if(request()->has('title') && request()->get('title') != null || request()->has('model_code') && request()->get('model_code') != null){
            $master_products->where('title','like','%'.request()->get('title').'%')->orwhere('model_code','like','%'.request()->get('model_code').'%')->whereIn('user_id',(array) $related);
        }

        if(request()->has('category_id') && request()->get('category_id') != null){
             $master_products->where('category_id', request()->get('category_id'));
        }
        if(request()->has('sub_category_id') && request()->get('sub_category_id') != null){
             $master_products->where('sub_category', request()->get('sub_category_id'));
        }
        if( request()->has('color') &&  request()->get('color') != null){
             $master_products->whereIn('color', request()->get('color'));
        }
        if(request()->has('size') && request()->get('size') != null){
             $master_products->whereIn('size', request()->get('size'));
        }

        if(request()->has('mater') && request()->get('mater') != null){
             $master_products->where('material', request()->get('mater'));
        }

        if( request()->has('supplier') &&  request()->get('supplier') != null){
            $master_products->where('user_id', request()->get('supplier'));
        }
        
        if( request()->has('ownproduct') &&  request()->get('ownproduct') != null){
            $master_products->where('user_id', auth()->id());
        }

        if( request()->has('quantity') &&  request()->get('quantity') != null){
            $quantity = request()->get('quantity');
            // $inventory_res = Inventory::groupBy('product_sku')->selectRaw("sum(total_stock) >= '$quantity' as sum, product_sku")->pluck('sum','product_sku');
            $inventory_res = Inventory::groupBy('product_sku')->selectRaw("sum(total_stock) as sum, product_sku")->pluck('sum','product_sku');
            foreach ($inventory_res as $array_key => $array_item) {
                if ($inventory_res[$array_key] === 0) {
                  unset($inventory_res[$array_key]);
                }
            }              
            $master_products->whereIn('sku',$inventory_res->keys());
        }

        if( request()->has('delivery') &&  request()->get('delivery') != null){
            $delivery = request()->get('delivery');
            $ashu = TimeandActionModal::whereIn('product_sku',$master_products->pluck('sku'))->where('delivery_period',"<=",$delivery)->pluck('product_sku');
            $master_products->whereIn('sku',$ashu);
        }

        if( request()->has('wantstock') &&  request()->get('wantstock') != null){
            $wantstock = request()->get('wantstock');
            $ashu = TimeandActionModal::whereIn('product_sku',$master_products->pluck('sku'))->where('delivery_stock',"<=",$wantstock)->pluck('product_sku');
            $master_products->whereIn('sku',$ashu);
        }

        // if(request()->has('brand') != null && request()->get('brand') != null){
        //      $master_products->where('products.brand', request()->get('brand'));
        // }
        if(request()->has('supplier') != null && request()->get('supplier') != null){
            $master_products->where('user_id', request()->get('supplier'));
       }

        if($request->has('to') && ($request->has('from'))){
            // return dd('h');
            if($request->get('to') != null && ($request->get('from')) != null){
                $master_products->whereBetween('price',[$request->get('from'),$request->get('to')]);
            }elseif($request->get('to') == null && ($request->get('from')) != null){
                $master_products->where('price','>=',$request->get('from'));
            }elseif($request->get('to') != null && ($request->get('from')) == null){
                $master_products->where('price','<=',$request->get('to'));
            }
        }
        
        if(request()->has('sort') && request()->get('sort') != null){
            if(request()->get('sort') == 1){
                 $master_products->orderBy('id','DESC');
            }elseif(request()->get('sort') == 2){
                 $master_products->orderBy('price','ASC');
            }elseif(request()->get('sort') == 3){
                 $master_products->orderBy('price','DESC');
            }
        }

        $added_products = ProposalItem::whereProposalId($proposal->id)->orderBy('pinned','DESC')->get();
        $excape_items = $added_products->pluck('product_id')->toArray();
        
        // Filter Altributes
        $TandAStock = getDeliveyStockbyProductSKU($master_products->pluck('sku'));
        $TandADeliveryPeriod = getdeliveryAltributesbyProductSKU($master_products->pluck('sku'));
        
        
        $master_products = $master_products->where('is_publish',1)->orderBy('price','ASC')->paginate(21);
        $currency_record = UserCurrency::where('user_id',$user_shop->user_id)->get();
        



        $alll_searches = [];
        array_push($alll_searches,[
            "Category" =>$request->get('category_id'),
            "Sub Category" => $request->get('sub_category_id'),
            "From" => $request->get('from'),
            "To" => $request->get('to')
        ]);

        
        $proposalid = $proposal->id;
        $items = $master_products;
        $proposal->updated_at = Carbon::now('Asia/Kolkata');
        $proposal->save();

        if ($request->ajax()) {
            return view('frontend.micro-site.proposals.load',compact('categories','brands','slug','user_shop','colors','sizes','material','items','user_key','proposalid','excape_items','added_products','proposal','suppliers','request','TandADeliveryPeriod','TandAStock','additional_attribute','proIds','currency_record','alll_searches'));
        }else{

            return view('frontend.micro-site.proposals.index',compact('categories','brands','slug','user_shop','colors','sizes','material','items','user_key','proposalid','excape_items','added_products','proposal','suppliers','request','TandADeliveryPeriod','TandAStock','additional_attribute','proIds','currency_record','alll_searches'));

        }


    }


    // Add Productto Proposals       
    public function apiStore(Request $request)
    {
        try{
            $user_shop_item_id =0;
            $proposal_item = ProposalItem::whereProductId($request->product_id)->whereProposalId($request->proposal_id)->exists();
            if(!$proposal_item){
                $product = Product::whereId($request->product_id)->first();
                $price = $product->price ?? '0';
                $proposalCount = ProposalItem::count();
                
                if($proposalCount == 0){
                    $sequence = 1;
                }else{
                    $pItem = ProposalItem::latest()->first();
                    $sequence = $pItem->sequence + 1;
                }
                // return magicstring($request->all());
                $proposal_item = [
                    'proposal_id' => $request->proposal_id,
                    'product_id' => $request->product_id,
                    'user_shop_item_id' => $user_shop_item_id,
                    'price' => round($price),
                    'user_id' => auth()->id() ?? 155,
                    'sequence' => $sequence,
                    'margin' => $request->hike,
                ];


                // magicstring($proposal_item);
                // return;

                ProposalItem::create($proposal_item);
                $itemcount = count(ProposalItem::where('proposal_id',$request->proposal_id)->get());
                if($request->ajax()) {
                    return response(['title' => 'success','message'=>"Proposal Item Added Successfully!","count" => $itemcount],200);
                }    
                    return back()->with('success','Proposal Item Added Successfully!');
                }
           
        }catch(\Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    

    public function apiRemove(Request $request)
    {
        try{
           $proposal_item =  ProposalItem::where('proposal_id',$request->proposal_id)->where('product_id',$request->product_id)->first();
            if($proposal_item){
                $proposal_item->delete();
                $itemcount = count(ProposalItem::where('proposal_id',$request->proposal_id)->get());
                if($request->ajax()) {
                    return response(['message'=>"Proposal Item deleted Successfully!","count" => $itemcount],200);
                }     
                return back()->with('success','Proposal Item deleted Successfully!');
            }
            else{
                if($request->ajax()) {
                    return response(['message'=>"This Item is not added by you!"],200);
                }     
                return back()->with('success','This Item is not added by you!');
            }

            
        }catch(\Exception $e){  
            if($request->ajax()) {
                return response(['msg'=>"something went wrong"],500);
            }     
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }



    function picked(Request $request,Proposal $proposal, $user_key ){

        $slug = $request->subdomain;
        $user_shop = UserShop::whereSlug($slug)->first();
        if (!Auth::check()) {
            auth()->loginUsingId(155);
        }
        
        // if($proposal->user_id != auth()->id()){
        //     return back();
        // }
        
        $added_products = ProposalItem::whereProposalId($proposal->id)->orderBy('sequence','ASC')->get();
        $excape_items = $added_products->pluck('product_id')->toArray();

        $aval_atrribute = ProductExtraInfo::whereIn('product_id',$excape_items)->groupBy('attribute_id')->pluck('attribute_id')->toArray();
        
        $user = auth()->user();
        
        $my_resellers = AccessCatalogueRequest::whereNumber(auth()->user()->phone)->whereStatus(1)->get() ?? $user; 
        $offerPasscode = $proposal->password ?? json_decode($user->extra_passcode)->offers_passcode ?? "1111";

        $currency_record = UserCurrency::where('user_id',$user_shop->user_id)->get();

        
        return view('frontend.micro-site.proposals.move',compact('added_products','excape_items','proposal','slug','user','my_resellers','offerPasscode','aval_atrribute','currency_record'));


    }

    public function updatePrice(Request $request,Proposal $proposal)
    {
        // return $request->all();
        // $this->validate($request, [
        //     'price'     => 'required',
        // ]);


        $proposal_item = ProposalItem::where('proposal_id',$proposal->id)->whereProductId($request->product_id)->first();

        try{
                              
            if($proposal_item){
                $notes = array(
                    'Customise_product' => $request->Customise_product,
                    'remarks_offer' => $request->remarks_offer
                );

                $request['notes'] = json_encode($notes);


                $user_id = auth()->id();


                $path = "files/offer/$user_id";

                // magicstring($request->all());
                // return;

                if ($request->has('attachment')) {
                    $filename = $request->attachment->getClientOriginalName();
                    
                    
                    $img = $this->uploadFile($request->attachment, "$path",null,$filename)->getFilePath();
                    
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    
                    $media = new Media();
                    $media->tag = "offer_attachment";
                    $media->file_type = "file";
                    $media->type = "offer_attachment";
                    $media->type_id = $request->product_id;
                    $media->file_name = $filename;
                    $media->path = $img;
                    $media->extension = $extension ?? '';
                    $media->save();
                    $proposal_item->attachment = $media->id;
                    
                }
                
                $proposal_item->user_price = $request->price;
                $proposal_item->note = json_encode($notes);
                
                $proposal_item->save();

              
                return back()->with('success','Price Updated.');
            }
            return back()->with('error','Proposal not found')->withInput($request->all());
        }catch(\Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }




    public function update(Request $request,Proposal $proposal)
    {
        // return magicstring($request->all());
        $this->validate($request, [
            'slug'     => 'required',
            'customer_name'     => 'required',
            'user_shop_id'     => 'required'
        ]);

        


        if($request->customer_mob_no != null){
            $this->validate($request, [
                'customer_mob_no'     => 'sometimes|min:10|max:10',
            ]);
        }
            $chk = Proposal::where('id','!=',$proposal->id)->where('user_shop_id',$proposal->user_shop_id)->where('slug',$proposal->slug)->first();
            if($chk){
                return back()->with('error',"Slug Must be unique.")->withInput();
            }
        try{
            
            if($proposal){
                
                $arr = [
                    'customer_name'=> $request->customer_name ?? json_decode($proposal->customer_details)->customer_mob_no ?? "Offer",
                    'customer_mob_no'=> $request->customer_mob_no ?? json_decode($proposal->customer_details)->customer_mob_no ?? "",
                    'customer_email'=> $request->customer_email ?? json_decode($proposal->customer_details)->customer_email ?? "",
                    'sample_charge' => $request->sample_charge ?? json_decode($proposal->customer_details)->sample_charge ?? 0,
                    'customer_alias' => $request->customer_alias ?? json_decode($proposal->customer_details)->customer_alias ?? "",
                ];

                $request['customer_details'] = json_encode($arr);
                if($request->hasFile("client_logo_file")){
                    $request['client_logo'] = $this->uploadFile($request->file("client_logo_file"), "client_logo")->getFilePath();
                } else {
                    $request['client_logo'] = null;
                }

                
                if($request->hasFile("client_visiting_card")){
                    $request['visiting_card'] = $this->uploadFile($request->file("client_visiting_card"), "client_logo")->getFilePath();
                } else {
                    $request['visiting_card'] = null;
                }
                
                
                $options = $request->optionsforoffer;
                
                if ($request->get('optionsforoffer')) {
                    $show_desc = in_array("description",$request->get('optionsforoffer')) ? 1 : 0;
                    $show_notes = in_array("notes",$request->get('optionsforoffer')) ? 1 : 0;
                    $show_attrbute = array_filter($options,"is_numeric") ?? [];
                    
                }else{
                    
                    $show_desc =  0;
                    $show_notes = 0;
                    $show_attrbute =  0;
                }


                $currency_record = UserCurrency::where('user_id',$request->user_id)->get();
                $Current_currency_record = [];

                foreach ($currency_record as $key => $value) {
                    $Current_currency_record[$value->currency] = $value->exchange;
                }

                $request['currency_record'] = json_encode($Current_currency_record);                
                $request['user_shop_id'] = getShopDataByUserId(auth()->id() ?? 155)->id;

                $options_arr = ["show_Description" => $show_desc ?? 0,"Show_notes" => $show_notes ?? 0,"show_Attrbute" => $show_attrbute ?? 0];

                $request['options'] = json_encode($options_arr);
                $request['status'] = 1;
                $request['type'] = $request->get('offer_type') ?? 0;
                                
                $proposal = $proposal->update($request->all());
                // magicstring($request->all());    
                
                return back()->with('success','Preview offer and share.');
            }
            return back()->with('error','Proposal not found')->withInput($request->all());
        }catch(\Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }




    
    // function samplecheckout(Request $request) {
    //     // Function for propsal Enquiry
    //     $new_price = 0;
    //     $final_amt = 0;
        
    //     if ($request->enquir!= null && isset($request->enquir)) {      
    //         foreach ($request->enquir as $key => $value) {
    //             $price = ProposalItem::where('product_id',$value)->where('proposal_id',$request->proposal_id)->first()->price ?? null; 
    //             $margin = ProposalItem::where('product_id',$value)->where('proposal_id',$request->proposal_id)->first()->margin ?? 0;
    //             $user_price = ProposalItem::where('product_id',$value)->where('proposal_id',$request->proposal_id)->first()->user_price ?? null;
    //             $sampleCharges = json_decode(Proposal::whereId($request->proposal_id)->first()->customer_details)->sample_charge ?? 0;

    //             if ($user_price == null) {
    //                     $margin_factor = (100 - $margin) / 100;
    //                     $submit_price = $price;
    //                     $price = $price/$margin_factor;
    //                 }
    //                 else {
    //                     $submit_price = $price;
    //                     $price = $user_price;

    //                 }
    //                 $final_amt = $final_amt + $price;            
    //                 $new_price = $new_price + $submit_price;
    //             }

    //             $user_details = Proposal::whereId($request->proposal_id)->first()->customer_details; 
    //             $proposal_item_id = implode(",",$request->enquir);
    //             $enquery_type = "sample";
                
    //             $amount = $new_price;
    //             $sample_count = count($request->enquir);


    //             if ($sampleCharges != 0) {
    //                 $sample_computaion_factor = (100 - $sampleCharges) / 100;
    //                 $final_amt = $amount / $sample_computaion_factor;
    //                 $amount = $final_amt/$sample_computaion_factor; 
    //             }

    //             Proposalenquiry::create([
    //                 'user_info' => $user_details,
    //                 'proposal_id' => $request->proposal_id,
    //                 'proposal_item_id' => $proposal_item_id,
    //                 'enquery_type' => $enquery_type,
    //                 'amount' => format_price($amount),
    //                 'sample_count' => $sample_count
    //             ]);

    //             // magicstring($request->all());
                
                
    //             $onsite_notification['user_id'] =  Proposal::whereId($request->proposal_id)->first()->user_id;
    //             $onsite_notification['title'] = count($request->enquir)." Samples request for offer";
    //             $onsite_notification['link'] =  remove_subdomain("customer/checksample/$request->proposal_id" , $request->get('subdomain'));
    //             pushOnSiteNotification($onsite_notification);

    //             $og_user = Proposal::whereId($request->proposal_id)->first()->user_id;

    //             if (Proposal::whereId($request->proposal_id)->first()->relate_to != null) {
    //                 $onsite_notification['user_id'] =  UserShop::whereId(Proposal::whereId($request->proposal_id)->first()->relate_to)->first()->user_id;
    //                 $onsite_notification['title'] = count($request->enquir)." Samples request for offer";
    //                 $onsite_notification['link'] =  remove_subdomain("customer/checksample/$request->proposal_id" , $request->get('subdomain'));
    //                 pushOnSiteNotification($onsite_notification);
    //                 $og_user =  UserShop::whereId(Proposal::whereId($request->proposal_id)->first()->relate_to)->first()->user_id;
    //             }
                

    //             $user = auth()->user(); 
    //             $proposal = Proposal::whereId($request->proposal_id)->first();

    //             $city = City::get();

    //         }

    //     return view('frontend.micro-site.proposals.checkout',compact('request','final_amt','og_user','sampleCharges','user','proposal','city'));
    // }


    function samplecheckout(Request $request){

        if (Auth::check() != 1) {
            auth()->loginUsingId(155);
        }

        if ($request->has('submitform')) {
            magicstring($request->all());
            echo "It Has.";

            $proposal = Proposal::whereId($request->proposal_id)->first();
            
            $user_details = array('customer_name' => $request->get('reseller_name'),'client_name' => $request->get('client_name'),'customer_mob_no' => json_decode($proposal->customer_details)->customer_mob_no ?? '','customer_email' => json_decode($proposal->customer_details)->customer_email ?? '', 'City' => $request->get('city'),'estimate_delivery' => $request->get('estimate_delivery'));

            $proposed_items = implode(',',$request->get('color'));
            $sample_count = count((array) $request->get('quantity')) ?? 0;
            $enquery_type = 'sample';


            foreach ($request->get('color') as $key => $value) {

                $prop_item = ProposalItem::where('product_id',$value)->get();
                
                magicstring($prop_item);
            }

            

            return;

            // Proposalenquiry::create([
            //     'user_info' => $user_details,
            //     'proposal_id' => $request->proposal_id,
            //     'proposal_item_id' => $proposed_items,
            //     'enquery_type' => $enquery_type,
            //     'amount' => format_price($amount),
            //     'sample_count' => $sample_count,
            //     'price' => $amount,
            // ]);
            
            
        }
        
        
        // magicstring($request->all());
        $user = auth()->user();
        $proposal = Proposal::whereId($request->get('proposal_id'))->first();
        $proposal_item = ProposalItem::whereIn('product_id',$request->get('enquir'))->where('proposal_id',$request->get('proposal_id'))->get();
        $products = Product::whereIn('id',$request->get('enquir'))->get();
        $city = City::get();

        return view('frontend.micro-site.proposals.checkout',compact('user','proposal','proposal_item','city','products'));
    }




    // Ajax request for Margin Update
    function marginupdate(Request $request) {
        try {
            $proposal_id = $request->proposal_id;
            $margin_hike = $request->hike;

            if ($margin_hike > 100) {
                return with('error',"Margin should be less than 100 %");
            }
            
            
            $proposal = Proposal::find($proposal_id);
            $proposal->margin = $margin_hike;
            $proposal->save();
            $count = 0; 

            $proposal_items = ProposalItem::Where('proposal_id',$proposal_id)->get();
            foreach ($proposal_items as $key => $items) {
                $data = ProposalItem::find($items->id);
                $data->margin = $margin_hike;
                $data->save();                
                $count++;
            }

            return "Updated ".$count." Products with Margin: ".$margin_hike;


        } catch (\Throwable $th) {
            return $th;
        }

    }

    // Copy an Offer
    function copyoffer(Request $request,$proposal){
        $item_id = [];
        
        $proposal_data = Proposal::whereId($proposal)->first();

        $new_pro = $proposal_data->replicate();
        $new_pro->slug = getUniqueProposalSlug("proposal".auth()->id());
        $new_pro->view_count = 0;
        $new_pro->ppt_download = 0;
        $new_pro->pdf_download = 0;
        // $new_pro->user_id = auth()->id();
        $new_pro->status = 0;

        $new_pro->save();



        // Getting Porposal Items
        $old_proposalItem = ProposalItem::where('proposal_id',$proposal)->get();
        foreach ($old_proposalItem as $key => $item) {
            $newproposal_item = $item->replicate();
            $newproposal_item->proposal_id = $new_pro->id;

            $newproposal_item->save();
            array_push($item_id,$newproposal_item->id);
        }

        $user_key = encrypt(auth()->id());
        return redirect(route('pages.proposal.picked',[$new_pro,$user_key]).'?type=send')->with("success","Offer Dublicate SuccessFull");        
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(ProposalItem $proposal_item)
    {
        try{
            if($proposal_item){
                                          
                $proposal_item->delete();
                return back()->with('success','Proposal Item deleted successfully');
            }else{
                return back()->with('error','Proposal Item not found');
            }
        }catch(\Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }



    public function updateSequence(Request $request,$proposalId)
    {
     
        $proposal_items = ProposalItem::where('proposal_id',$proposalId)->get();
        foreach ($proposal_items as $proposal_item) {
            $proposal_item->timestamps = true; // To disable update_at field updation
            $id = $proposal_item->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    
                    $proposal_item->sequence = $order['position'];
                    $proposal_item->save();
                }
            }
        }
        
        return response('Update Successfully.', 200);
    }
    
    

    
    function validatepass(Request $request) {
        $slug = $request->subdomain;
        $user_shop = UserShop::whereSlug($slug)->first();
        $shop_user = User::whereId($user_shop->user_id)->first();

        // return magicstring($shop_user);
        if ($request->get('password')) {
            $pas = $request->get('password');

            $response = ['status'=>'error'];
            
            if ($shop_user->exclusive_pass == $pas) {
                return $response = ['status'=>'success'];
            }else{
                return $response = ['status'=>'Wrong Password !'];
            }
        }

    }             
    
    function ashish(Request $request){
        magicstring(session()->all());
        magicstring(auth()->user());
        // $slug = $request->subdomain;
        // $user_shop = UserShop::whereSlug($slug)->first();
        
        // echo auth()->id();
        // echo$user_shop->user_id;
        
        // if($user_shop->user_id == auth()->id()){
        //     echo "Ashish";
        // }
        

    }
    
    
    function updateDownload(Request $request,Proposal $proposal){

        // echo $proposal;
        // magicstring($request->all());

        // Update Get Values
        // 1 = PDF
        // 2 = PPT

        $updateto = $request->get('update');

        $pdf = $proposal->pdf_download;
        $ppt = $proposal->ppt_download;



        if ($updateto == 1) {
            $proposal->update([
                'pdf_download' => $pdf + 1, // Add Download Count
            ]);            
        }else{
            $proposal->update([
                'ppt_download' => $ppt + 1, // Add Download Count
            ]);           
        }
        
        $proposal->save();
        return("Record Updated!!");
    }


    
}
