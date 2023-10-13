<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UserShopItem;
use App\Models\UserPackage;
use App\Models\OrderItem;
use App\Models\GroupProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\MailSmsTemplate;
use App\Models\AccessCatalogueRequest;
use App\Models\BrandUser;
use App\Models\Media;
use App\User;
use App\Models\Brand;
use App\Models\changeby121;
use App\Models\ProductExtraInfo;
use App\Models\UserShop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;




class UserShopItemController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
        
         $length = 12;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $user_shop_items = UserShopItem::query();
            if($request->get('search')){
                $user_shop_items->where('id','like','%'.$request->search.'%')
                                ->orWhere('user_id.user_shop_id','like','%'.$request->search.'%')
                                ->orWhere('price','like','%'.$request->search.'%')
                                ->orWhere('is_published','like','%'.$request->search.'%')
                ;
            }
            if($request->get('from') && $request->get('to')) {
                $user_shop_items->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $user_shop_items->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $user_shop_items->orderBy($request->get('desc'),'desc');
            }
            if($request->get('is_published') == 1 || $request->get('is_published') != null){
                $user_shop_items->where('is_published',$request->get('is_published'));
            }
            if($request->get('user_id')){
                $user_shop_items->where('user_id',$request->get('user_id'));
            }
            $user_shop_items = $user_shop_items->latest()->paginate($length);
            
            if ($request->ajax()) {
                return view('panel.user_shop_items.load', ['user_shop_items' => $user_shop_items])->render();  
            }
 
        return view('panel.user_shop_items.index', compact('user_shop_items'));
    }

    
        public function print(Request $request){
            $user_shop_items = collect($request->records['data']);
                return view('panel.user_shop_items.print', ['user_shop_items' => $user_shop_items])->render();  
           
        }
    public function create(Request $request)
    {
        try{  
            if(request()->get('length')){
                $length = $request->get('length');
            }else{
                $length = 50;
            }

            $access_data = null;
            $access_id = $request->get('type_id') ?? 0;
            if($request->has('type') && $request->get('type') != null && $request->has('type_id') && $request->get('type_id') != null){
                $type = $request->get('type');
                $type_id = $request->get('type_id');
                $product = Product::query();
                $parent_shop = 0;
                // $product->where('exclusive',"!=",1);
                if($type == 'brand'){
                    // Check Access
                    $chk = BrandUser::whereUserId(auth()->id())->whereStatus(1)->first();
                    // Parent Node
                    $parent_shop = 0;
                    
                    if($request->has('search') && $request->get('search') != null){
                        $product->where('title','like', '%' . $request->get('search') . '%')
                                ->orWhere('model_code','like', '%' . $request->get('search') . '%')
                                ->orWhere('id','like', '%' . $request->get('search') . '%')
                                ->orWhereHas('product_items',function($q) use($request){
                                    $q->where('id','like', '%' . $request->get('search') . '%');
                                });   
                    }
                    if($request->has('category_id') && $request->get('category_id') != null){
                        $product->where('category_id',$request->get('category_id'));
                    }
                    
                    $scoped_products = $product->whereBrandId($type_id)->groupBy('sku')->latest()->get();
                    $qr_products = $product->whereBrandId($type_id)->latest()->get();
                    $categories = Category::whereIn('id',$scoped_products->pluck('category_id'))->groupBy('name')->get();
                    $title = getBrandRecordByBrandId($request->get('type_id'))->name ?? '';
                }elseif($type == 'direct'){
                    // Check Access
                    $supplier = User::whereId($request->type_id)->first();
                    if($request->has('phone') && auth()->user()->phone != $supplier->phone){
                        $chk = AccessCatalogueRequest::whereUserId(auth()->id())->whereNumber($supplier->phone)->whereStatus(1)->first();
                        $access_data = $chk;
                    }else{
                        // $access_data = null;
                        $access_data = null;
                    }


                    $price_group = AccessCatalogueRequest::whereUserId(auth()->id())->whereNumber($supplier->phone)->whereStatus(1)->first()->price_group_id ?? null;
                    // Parent Node
                    $scoped_items = UserShopItem::whereUserId($type_id)->orderBy('pinned','DESC')->get();
                    if($request->has('search') && $request->get('search') != null){
                        $product->where('title','like', '%' . $request->get('search') . '%')
                                ->orWhere('model_code','like', '%' . $request->get('search') . '%')
                                ->orWhere('id','like', '%' . $request->get('search') . '%') 
                                ->orWhereHas('product_items',function($q) use($request){
                                    $q->where('id','like', '%' . $request->get('search') . '%');
                                });   
                    }
                    
                    if($request->has('category_id') && $request->get('category_id') != null){
                        $product->where('category_id',$request->get('category_id'));
                    }
                    if($request->type_id != auth()->id()){
                        $product->where('is_publish',1);
                    }


                    if ($request->type_id == auth()->id()) {
                        $scoped_products = $product->whereIn('id', $scoped_items->pluck('product_id'))->groupBy('sku')->orderBy('pinned','desc')->paginate($length);
                    }else{
                        $scoped_products = $product->whereIn('id', $scoped_items->pluck('product_id'))->groupBy('sku')->paginate($length);
                    }

                    // $scoped_products = $product->whereIn('id', $scoped_items->pluck('product_id'))->groupBy('sku')->orderBy('pinned','desc')->paginate($length);

                    $qr_products = $product->whereIn('id', $scoped_items->pluck('product_id'))->latest()->paginate($length);
                    
                    $categories = Category::whereIn('id',$scoped_items->pluck('category_id'))->get();

                   
                    $parent_shop = getShopDataByUserId(@$supplier->id);
                    $title = $supplier->name ?? '';

                    $pinned_products = Product::whereUserId($request->type_id)->whereIn('id', $scoped_items->pluck('product_id'))->where('pinned',1)->orderBy('pinned','DESC')->get();
                    $pinned_items = $pinned_products->pluck('id')->toArray();



                }
            }else{
                $scoped_products = [];
                $categories = [];
                $title = "Unknown";
                $qr_products = [];
                $pinned_items = [];
            }



            $brand_record = [];
            $products = Product::query();
            $products = $products->select('*', \DB::raw('count(*) as total'))->groupBy('sku')->latest()->paginate($length);
            
            return view('panel.user_shop_items.create',compact('scoped_products','pinned_items','parent_shop','title','categories','access_data','access_id','products','qr_products','type_id','price_group'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    
    public function addpin(Request $request)
    {
        
        try{

            $proposal_item =  Product::whereUserId($request->user_id)->where('id',$request->product_id)->first();

             if($proposal_item){
                 $proposal_item->pinned = 1;
                 $proposal_item->save();
                 if($request->ajax()) {
                     return response(['message'=>"Item Pinned Successfully!"],200);
                 }     
                 return back()->with('success','Item Pinned Successfully!');
             }else{
                 if($request->ajax()) {
                     return response(['message'=>"This Item is not added by you!"],200);
                 }     
                 return back()->with('success','This Item is not added by you!');
             }
         }catch(Exception $e){  
             if($request->ajax()) {
                 return response(['msg'=>"something went wrong"],500);
             }     
             return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
         }


        print_r($request->all());

    }


    public function removepin(Request $request)
    {
        try{
            $proposal_item =  Product::whereUserId($request->user_id)->where('id',$request->product_id)->first();
             if($proposal_item){
                 $proposal_item->pinned = 0;
                 $proposal_item->save();
                 if($request->ajax()) {
                     return response(['message'=>"Item Pinned Removed Successfully!"],200);
                 }     
                 return back()->with('success','Item Pinned Removed Successfully!');
             }else{
                 if($request->ajax()) {
                     return response(['message'=>"This Item is not added by you!"],200);
                 }     
                 return back()->with('success','This Item is not added by you!');
             }
         }catch(Exception $e){  
             if($request->ajax()) {
                 return response(['msg'=>"something went wrong"],500);
             }     
             return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
         }

        

        print_r($request->all());


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
        // chk user have active package or not!
        if(!haveActivePackageByUserId($request->user_id)){
            return back()->with('error',"You don't have any active package!");
        }
        $this->validate($request, [
            'user_id'     => 'required',
            'user_shop_id'     => 'required',
            'parent_shop_id'     => 'required',
            'product_id'     => 'required',
            'price_groups'     => 'sometimes',
            'is_published'     => 'sometimes',
        ]);
        try{
            if(!$request->has('is_published')){
                $request['is_published'] = 0;
            }

             $chk = UserShopItem::whereUserId($request->user_id)->whereUserShopId($request->user_shop_id)->whereParentShopId($request->parent_shop_id)->whereProductId($request->product_id)->first();
                if($chk){
                    return back()->with('error', 'You already have this item in your micro-site');
                }



            $sku_codes = Product::whereId($request->product_id)->pluck('sku');
            $products = Product::whereIn('sku',$sku_codes)->get();

            // check package limit
                if(AuthRole() == "User"){
                    $package = getUserPackageInfo(auth()->id());
                    $limits = json_decode($package->limit,true);
                    $my_pro_ids = Product::where('user_id',auth()->id())->pluck('id');
                    // $my_site_pro_count = UserShopItem::whereUserId($request->type_id)->whereNotIn('product_id',$my_pro_ids)->get()->count();
                    $my_site_pro_count = UserShopItem::whereUserId(auth()->id())->whereNotIn('product_id',$my_pro_ids)->get()->count();
                   
                }

            // Checking Permissions
            foreach($products as $product){
                if(AuthRole() == "User"){
                     
                 $chk_child = UserShopItem::whereUserId(auth()->id())->whereParentShopId($request->parent_shop_id)->first();
                    // Already Supplier
                    if($chk_child){
                        if(+$limits['add_to_site'] <= $my_site_pro_count){
                            return back()->with('error','Your Add to my Site Limit exceed!');
                        }elseif(+$limits['add_to_site']-$my_site_pro_count < $products->count()){
                            $rem = +$limits['add_to_site']-$my_site_pro_count;
                            return back()->with('error',"Total products including variants:".$products->count()." You can add only ".$rem.' products ');
                        }
                    }
                }
            }

                foreach($products as $product){
                    $request['product_id'] = $product->id;
                    foreach($request->price_groups as $item){
                            $item;
                        if($item['group_id'] != null && $item['group_id'] != null) {
                            $group_product = GroupProduct::create([
                            'product_id' => $request->product_id,
                            'group_id' => $item['group_id'],
                            'price' => $item['price'],
                            ]);
                        }
                    }
                    $request['price_group'] = json_encode($request->price_groups);
                    $request['images'] = $product->medias->pluck('id')->count() > 0 ? implode(',',$product->medias->pluck('id')->toArray()) : null;

                    // if($request->hike){
                    //     $margin = (100 - ($request->hike)) / 100;
                    //     $request['price'] =  round($request->product_price / $margin);
                    // }
                    $request['price'] = $request->price;
                    $user_shop_item = UserShopItem::create($request->all());
                }
               


                
            if (AuthRole() != 'Admin') {
                 return back()->with('success','User Shop Item Created Successfully!');
            }elseif ($request->user_id) {
                return redirect()->route('panel.user_shop_items.index','user_id='.$request->user_id)->with('success','User Shop Item Created Successfully!');
            } else {
                return redirect()->route('panel.user_shop_items.index')->with('success','Item added to shop  Successfully!');
            }
            
        }catch(\Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    public function addBulk(Request $request)
    {

        if(!haveActivePackageByUserId($request->user_id)){
            return back()->with('error',"You don't have any active package!");
        }

        if($request->get('products')){
            $totalProductCount =  (count($request->get('products')));

        }
        
        if(!$request->has('products')){
            return back()->with('error', 'please select at least one product');
        }
        $this->validate($request, [
            'user_id'     => 'required',
            'user_shop_id'     => 'required',
            'parent_shop_id'     => 'required',
        ]);
        
        try{
            
            // if(!$request->has('is_published')){
                $request['is_published'] = 1;
                // }
                $sku_codes = Product::whereIn('id', $request->get('products'))->pluck('sku');
                $proIds = Product::whereIn('sku',$sku_codes)->pluck('id');
                $products = Product::whereIn('id', $proIds)->get();
                // check package limit
                if(AuthRole() == "User"){
                    $package = getUserPackageInfo(auth()->id());
                    $limits = json_decode($package->limit,true);
                    $productUploads = $limits['product_uploads'];
                    $my_pro_ids = Product::where('user_id',auth()->id())->pluck('id');
                    
                    // $my_site_pro_data = UserShopItem::whereUserId($request->type_id)->whereNotIn('product_id',$my_pro_ids)->groupBy('user_shop_id')->get(); 
                    $my_site_pro_data = UserShopItem::whereUserId(auth()->id())->whereNotIn('product_id',$my_pro_ids)->groupBy('user_shop_id')->get();
                    $my_site_pro_count = $my_site_pro_data->count();
                    $added_products = Product::whereIn('id', $proIds)->groupBy('sku')->get();
                }
                
                if(+$limits['add_to_site'] <= $my_site_pro_count){
                    return back()->with('error','Your Add to my Site Limit exceed!');
                }elseif((+$limits['add_to_site'] - $my_site_pro_count) < $products->count()){
                    $rem = +$limits['add_to_site'] - $my_site_pro_count;
                    return back()->with('error',"Your subscription plan does'nt allow you to add more than $productUploads Total products including variants:".$products->count()." You can add only ".$rem.' products ');
                }
                
                $supplier =  User::whereId($request->type_id)->first();
                
                foreach($products as $product){
                $user_shop_item = UserShopItem::whereProductId($product->id)
                    ->whereUserId($request->type_id)
                    ->latest()->first();
                     
                $request['images'] = null;
                $request['category_id'] = null;
                $request['sub_category_id'] = null;
                $request['price'] = null;
                $request['product_id'] = null;

                if($request->type == "direct"){
                    $supplier_item =  UserShopItem::whereUserId($request->type_id)->where('product_id', $product->id)->first();
                    
                    $price = $supplier_item->price ?? 0;

                    // Price Grouping
                    // Current USI Author ID - For Direct Only
                    $access_data = AccessCatalogueRequest::whereUserId(auth()->id())->whereNumber($supplier->phone)->whereStatus(1)->first();
                    if($access_data){
                        if($access_data->price_group_id != 0){
                            $price_group_data = \App\Models\GroupProduct::whereGroupId($access_data->price_group_id)->whereProductId($product->id)->first();

                            if($price_group_data && $price_group_data->price != null && $price_group_data->price != 0){
                                $price = $price_group_data->price;
                            }
                        }
                    }

                }elseif($request->type == "brand"){
                    $price = $product->price;
                }

               
                 $request['images'] = $product->medias->pluck('id')->count() > 0 ? implode(',',$product->medias->pluck('id')->toArray()) : null;

                // check if product already exists
                $chk = UserShopItem::whereUserId($request->user_id)->whereUserShopId($request->user_shop_id)->whereParentShopId($request->parent_shop_id)->whereProductId($product->id)->first();

                if(!$chk){
                    $request['category_id'] = $product->category_id; 
                    $request['sub_category_id'] = $product->sub_category; 
                    $price = $user_shop_item->price ?? '0';
                    if($request->bulk_hike < 100){
                        $margin = (100 - ($request->bulk_hike)) / 100;
                        $request['price'] =  round($price / $margin);
                    }elseif($request->bulk_hike > 100){
                        $request['price'] =  round((2*$request->bulk_hike*$price)/100); 
                    }elseif($request->bulk_hike == 100){
                        $margin = ($request->bulk_hike) / 100;
                        $request['price'] =  round($price * 2);   
                    }
                    // $request['price'] = round(($price/(100-$request->hike))*100); 

                    $request['product_id'] = $product->id;
                    $user_shop_item = UserShopItem::create($request->all());
                }
            }
            if (AuthRole() != 'Admin') {
                return back()->with('success',$totalProductCount.' Items added to shop  Successfully!');
            }elseif ($request->user_id) {
                return redirect()->route('panel.user_shop_items.index','user_id='.$request->user_id)->with('success',$totalProductCount.' Items added to shop  Successfully!');
            } else {
                return redirect()->route('panel.user_shop_items.index')->with('success',$totalProductCount.' Items added to shop  Successfully!');
            }
            
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    
    public function removebulk(Request $request)
    {
        try {
            $delete_request = $request->delproducts;
            $action = $request->delete_all;

            if ($action) {
                echo "Deleting All Products !! <br>";
                $result_product = DB::table('products')->where('user_id',$request->user_id)->get();
                // Starting Loop for Getting All Product Details
                foreach ($result_product as $key => $allpro) {
                    // Getting Item LIsts from User Shop Item Table
                    $usi = DB::table('user_shop_items')->where('product_id',$allpro->id)->where('parent_shop_id',0)->get();    
                    foreach($usi as $user_items){
                        $media = $user_items->images;
                        $media_arr = explode(',',$media);
                        foreach ($media_arr as $value) {
                            $media_dir = DB::table('medias')->where('id',$value)->first();
                            $del_path = str_replace('storage','public',$media_dir->path);
                            Storage::delete($del_path);
                            DB::table('medias')->where('id',$media_dir->id)->delete();
                        }
                        // ! Deleting User SHop Item Entry
                        DB::table('user_shop_items')->where('id',$user_items->id)->delete();
                    }
                    
                    // ! Deleting From Inventory
                    DB::table('inventory')->where('product_id',$allpro->id)->delete();
                    // ! Deleting From Proposal_item
                    DB::table('proposal_items')->where('product_id',$allpro->id)->delete();
                    // ! Deleting From Time and Action                     
                    DB::table('time_and_action')->where('product_id',$allpro->id)->delete();
                    // ! Deleting From Product Entry
                    DB::table('products')->where('id',$allpro->id)->delete();
                    // ! Deleting From Product extra info 
                    ProductExtraInfo::where('product_id',$allpro->id)->delete();
                }    
                return back()->with('success',count($result_product).' All Items of shop are Deleted Successfully!');                

            }else{
                echo "Deleting Selected Products !! <br>";
                foreach ($delete_request as $delproduct) {
                    $result_product = DB::table('products')->where('sku',$delproduct)->first();
                    if ($result_product->user_id != auth()->id()) {
                        return back()->with('error','These Products are not Owned by You!!');
                    }
                    
                    $usi = DB::table('user_shop_items')->where('product_id',$result_product->id)->get();    
                    foreach($usi as $user_items){
                        // Getting Image Path From User Shop Items
                        $media = $user_items->images;
                        // Makking rray of Media in Product
                        $media_arr = explode(',',$media);
                        
                        // Starting Loop for Deleting Medias
                        foreach ($media_arr as $value) {
                            // Getting File Path
                            $media_dir = DB::table('medias')->where('id',$value)->first();
                            // Converting Dir to make it deletable
                            $del_path = str_replace('storage','public',$media_dir->path);
                            // Deleting File
                            Storage::delete($del_path);
                            // Deleting Media Entry
                            DB::table('medias')->where('id',$media_dir->id)->delete();
                        }
                        // Deleting User SHop Item Entry
                        DB::table('user_shop_items')->where('id',$user_items->id)->delete();
                    }
                    DB::table('products')->where('id',$result_product->id)->delete();
                    // Deleting Product extra info 
                    ProductExtraInfo::where('product_id',$result_product->id)->delete();
                }

                return back()->with('success',count($delete_request).' Items Deleted to shop Successfully!');
            }

        } catch (\Exception $e) {
            return back()->with('error','Got an Error '.$e.'!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(UserShopItem $user_shop_item)
    {
        try{
            return view('panel.user_shop_items.show',compact('user_shop_item'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function uploadBulkImage(Request $request)
    {   
        try{
            if($request->has('category_id') && $request->has('sub_category_id')){
                $product_ids = Product::whereCategoryId($request->category_id)->whereSubCategory($request->sub_category_id)->pluck('id');
            }else{
                $product_ids = Product::whereCategoryId($request->category_id)->pluck('id');
            }
            $medias =  Media::whereType('Product')->whereIn('type_id',$product_ids)->whereTag('Product_Image')->paginate(10);

            foreach($medias as $media){
                $media->path = asset($media->path);
            }

            return response()->json(['images' => $medias], 200);
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
    public function edit(UserShopItem $user_shop_item)
    {   
        try{
            $product_id = $user_shop_item->product_id;
            $changes121 = changeby121::where('prodcut_id','=',$product_id)->first();
            
            return view('panel.user_shop_items.edit',compact('user_shop_item','changes121'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function updateMedia(Request $request)
    {  
        try{
            foreach($request->medias as $tempImg){
                $media = Media::whereId($tempImg)->first();
                if($media){
                    $extension = pathinfo($media->file_name, PATHINFO_EXTENSION);
                     Media::create([
                        'type' => 'UserShopItem',
                        'type_id' => $request->id,
                        'file_name' => $media->file_name,
                        'path' => $media->path,
                        'extension' => $extension,
                        'file_type' => "Image",
                        'tag' => "Product_Image",
                    ]);
                }else{
                    return back()->with('error','Image Not Found!');
                }
            }
            return back()->with('success','Image Updated Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function getSubcategory(Request $request)
    {   
        try{
            $html = "<option value='' readonly> Select Sub Category</option>";
            if (AuthRole() != 'Admin') {
                $self_data = Category::whereType(0)->where('parent_id',$request->id)->whereUserId(auth()->id())->get();
                $data = Category::where('parent_id',$request->id)->whereType(1)->get();
                $data = $self_data->merge($data);

            } else {
              $data = Category::where('parent_id',$request->id)->get();
            }
            if ($data) {
                foreach($data as $option){
                    $selected = "";

                    if($request->has('selected_id') && !is_null($request->get('selected_id')) && $request->get('selected_id') == $option->id){
                        $selected = "selected";
                    }
                    $html .= '<option value="'.$option->id.'" '.$selected.'>'.$option->name.'</option>';
                }

                return response($html,200);
            }
            return response(404);
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
    public function update(Request $request,UserShopItem $user_shop_item)
    {
        
        $this->validate($request, [
            'user_id'     => 'required',
            'user_shop_id'     => 'required',
            'price'     => 'sometimes',
            'product_id'     => 'required',
            'price_group'     => 'sometimes',
            'is_published'     => 'sometimes',
        ]);
                
        try{
                            
            if(!$request->has('is_published')){
                $request['is_published'] = 0;
            }

            
            $parent_shop = UserShop::whereId($user_shop_item->parent_shop_id)->first()->user_id;
            $parent_shop_status = User::whereId($parent_shop)->first()->status;

           if ($parent_shop != 0) {
            if ($parent_shop_status == 0) {
                return back()->with('error',"Couldn't Publish Because Supplier Unpublished the Product!")->withInput($request->all());
            }
           }
                    
            $parent_shop_status = User::whereId($user_shop_item->parent_shop_id)->first()->status;
            if ($parent_shop_status == 0) {
                return back()->with('error',"Couldn't Publish Because Supplier Unpublished the Product!")->withInput($request->all());
            }

            if($user_shop_item){
                if($request->has('medias') && count($request->get('medias')) > 0){
                        $request['images'] = implode(',',$request->get('medias'));
                }else{
                    $request['images'] = null;
                }
                // return  $request->all();
               $chk = $user_shop_item->update($request->all());
            }

            $product = getProductDataById($user_shop_item->product_id);
            if($product->user_id == $user_shop_item->user_id){
                
                $otherShops = UserShopItem::where('user_id','!=',$user_shop_item->user_id)->where('product_id',$user_shop_item->product_id)->get();
    
                foreach($otherShops as $other){
                        
                    // Unpublish all sellers who has this product
                    $other->is_published = 0;
                    $other->save();
    
                    $user_record =  getUserRecordByUserId($other->user_id);
                    // $product_record =  getProductRecordById($other->product_id);
                    $mailContentData = MailSmsTemplate::where('code','=',"product-unpublished")->first();
                    if($mailContentData){
                        $arr=[
                                '{name}'=>$user_record->name,
                                '{product_name}'=>$product->title,
                            ];
                        
                        TemplateMail($user_record->name,$mailContentData,$user_record->email,$mailContentData->type, $arr, $mailContentData, $chk_data = null ,$mail_footer = null, $action_button = null);
                    }
                    $onsite_notification['user_id'] =  $other->user_id;
                    $onsite_notification['title'] = NameById($product->user_id)." has made changes to their product
                     $product->title (Model-#$product->model_code) , resulting in auto unpublished from your account. To continue selling, review changes and publish." ;
                    $onsite_notification['link'] = route('panel.user_shop_items.create')."?type=direct&type_id=".$product->user_id;
                    pushOnSiteNotification($onsite_notification);
                }
            }
            return back()->with('success','Record Updated!')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }




    public function update121(Request $request,UserShopItem $user_shop_item)
    {
        
        // echo "<pre>";
        // // print_r($request->all());
        // print_r($user_shop_item);
        // echo "</pre>";



        // $this->validate($request, [
        //     'user_id'     => 'required',
        //     'user_shop_id'     => 'required',
        //     'price'     => 'sometimes',
        //     'product_id'     => 'required',
        //     'price_group'     => 'sometimes',
        //     'is_published'     => 'sometimes',
        // ]);
                


        try{
                                                  
            if($user_shop_item){
                if($request->has('medias') && count($request->get('medias')) > 0){
                        $request['images'] = implode(',',$request->get('medias'));
                }else{
                    $request['images'] = null;
                }
                // return  $request->all();

            //    $chk = $user_shop_item->update($request->all());
                $user_shop_item->update([
                    'title_user' => $request->product_title,
                    'video_url' => $request->video_url,
                    'artwork_url' => $request->artwork,
                    'materials' => $request->material,
                    'tags' => $request->tagsinp,
                    'description' => $request->description,
                    'images' => $request['images'],
                ]);
            }




            $product = getProductDataById($user_shop_item->product_id);
            if($product->user_id == $user_shop_item->user_id){
                
                $otherShops = UserShopItem::where('user_id','!=',$user_shop_item->user_id)->where('product_id',$user_shop_item->product_id)->get();
    
                foreach($otherShops as $other){
                        
                    // Unpublish all sellers who has this product
                    $other->is_published = 0;
                    $other->save();
    
                    $user_record =  getUserRecordByUserId($other->user_id);
                    // $product_record =  getProductRecordById($other->product_id);
                    $mailContentData = MailSmsTemplate::where('code','=',"product-unpublished")->first();
                    if($mailContentData){
                        $arr=[
                                '{name}'=>$user_record->name,
                                '{product_name}'=>$product->title,
                            ];
                        
                        TemplateMail($user_record->name,$mailContentData,$user_record->email,$mailContentData->type, $arr, $mailContentData, $chk_data = null ,$mail_footer = null, $action_button = null);
                    }
                    $onsite_notification['user_id'] =  $other->user_id;
                    $onsite_notification['title'] = NameById($product->user_id)." has made changes to their product
                     $product->title (Model-#$product->model_code) , resulting in auto unpublished from your account. To continue selling, review changes and publish." ;
                    $onsite_notification['link'] = route('panel.user_shop_items.create')."?type=direct&type_id=".$product->user_id;
                    pushOnSiteNotification($onsite_notification);
                }
            }
            return back()->with('success','Record Updated!')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }





    public function remove($pid,$uid)
    {   
        try{
            $sku = Product::whereId($pid)->first()->sku ??null;
            if($sku != null){
                $proIds = Product::where('sku',$sku)->pluck('id');
                $chk = UserShopItem::whereIn('product_id',$proIds)->whereUserId($uid)->delete();
                if($chk){
                    return back()->with('success','User Shop Item deleted successfully');
                }else{
                    return back()->with('error','User Shop Item not found');
                }
                return back()->with('error','Product not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function addImages(Request $request){
        // return $request->all();
       $user_shop_item = UserShopItem::find($request->id);
        $arr_images = explode(',',$user_shop_item->images);
        if($request->hasFile("image_files")){
            foreach($request->file('image_files') as $tempImg){
                $img = $this->uploadFile($tempImg, "user_shop_items")->getFilePath();
                $filename = $tempImg->getClientOriginalName();
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                if($filename != null){
                    $media = Media::create([
                        'type' => 'UserShopItem',
                        'type_id' => $request->id,
                        'file_name' => $filename,
                        'path' => $img,
                        'extension' => $extension,
                        'file_type' => "Image",
                        'tag' => "Product_Image",
                    ]);
                    $arr_images[] = $media->id;
                }
            }
        }
        $user_shop_item->images = implode(',', $arr_images);
        $user_shop_item->save();
        return back()->with('success',"Images Uploaded Successfully!");
    }   



    public function updateproductshow(Request $reqest)
    {
        try{
            $users = User::get();
            return view('panel.user_shop_items.update_product', compact('users'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(UserShopItem $user_shop_item)
    {
        try{
            $order = OrderItem::whereItemId($user_shop_item->id)->first();
            if($order){
              return back()->with('error','This product cannot be deleted because it has been ordered');
            }
            if($user_shop_item){
                $user_shop_item->delete();
                return back()->with('success','User Shop Item deleted successfully');
            }else{
                return back()->with('error','User Shop Item not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    
}
