<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\brand_product;
use App\Models\MailSmsTemplate;
use App\Models\Media;
use App\Models\UserShop;
use App\Models\GroupProduct;
use App\Models\Group;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductExtraInfo;
use App\Models\Setting;
use App\Models\UserShopItem;
use Illuminate\Support\Facades\Auth;
use phpseclib3\File\ASN1\Maps\AttributeValue;

class ProductController extends Controller
{
     public function index(Request $request)
     {
        
        if($request->has('action') && $request->get('action') == 'nonbranded'){
          
            $brand_activation = false;
        }else{
           
            $brand_activation = true;
        }
          
        $brand = Brand::whereId(request()->get('id'))->first();
        if(!$brand && $brand_activation == true){
            return back()->with('error', 'No brand assign to your account!');
        }

        $prodextra = ProductExtraInfo::whereId(request()->get('id'))->first();
        

         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $products = Product::query();
            if($request->get('search')){
                $products->where('id','like','%'.$request->search.'%')
                ->orWhere('title','like','%'.$request->search.'%')
                ->orWhere('status','like','%'.$request->search.'%')
                ->orWhere('stock_qty','like','%'.$request->search.'%')
                ;
            }
            if($request->get('from') && $request->get('to')) {
                $products->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $products->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $products->orderBy($request->get('desc'),'desc');
            }
            
            if($brand_activation == true){
                if($request->get('id')){
                    $products->whereBrandId($request->get('id'))->get();
                }
                $products = $products->select('*', \DB::raw('count(*) as total'))->groupBy('sku')->latest()->paginate($length);
            }else{
                $products->whereUserId(auth()->user()->id)->whereBrandId(0)->get();
                $products = $products->select('*', \DB::raw('count(*) as total'))->groupBy('sku')->latest()->paginate($length);
            }

            if ($request->ajax()) {
                return view('panel.products.load', ['products' => $products, 'brand_activation' => $brand_activation])->render();  
            }
 
            return view('panel.products.index', compact('products','brand','brand_activation','prodextra'));
     }

     public function inventoryIndex(Request $request)
     {
        // return 's';
        if($request->has('action') && $request->get('action') == 'nonbranded'){
            $brand_activation = false;
        }else{
            $brand_activation = true;
        }

        $brand = Brand::whereId(request()->get('id'))->first();
        if(!$brand && $brand_activation == true){
                return back()->with('error', 'No brand assign to your account!');
        }
        $prodextra = ProductExtraInfo::whereId(request()->get('id'))->first();

         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $products = Product::query();
         
            if($request->get('search')){
                $products->where('id','like','%'.$request->search.'%')
                ->orWhere('title','like','%'.$request->search.'%')
                ->orWhere('status','like','%'.$request->search.'%')
                ->orWhere('qty','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $products->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $products->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $products->orderBy($request->get('desc'),'desc');
            }
            
            if($brand_activation == true){
                if($request->get('id')){
                    $products->whereBrandId($request->get('id'))->get();
                }
                $products = $products->select('*', \DB::raw('count(*) as total'))->groupBy('sku')->latest()->paginate($length);
            }else{
                $products->whereUserId(auth()->user()->id)->whereBrandId(0)->get();
                $products = $products->select('*', \DB::raw('count(*) as total'))->groupBy('sku')->latest()->paginate($length);
            }

            if ($request->ajax()) {
                return view('panel.inventory.load', ['products' => $products, 'brand_activation' => $brand_activation])->render();  
            }
 
            return view('panel.inventory.index', compact('products','brand','brand_activation','prodextra'));
     }


    public function inventoryEdit(Product $product_id) {
        $product = Product::whereId($product_id->id)->first();

        return view('panel.inventory.edit',compact('product'));
    }

     
     
     public function inventoryStore(Request $request)
     {
        $product_ids = $request->product_ids;
        foreach($product_ids as $index => $stock){
            Inventory::where('product_id',$index)->update([
                'stock' => $stock
            ]);
        }
        return back()->with('success', 'Inventory updated successfully!');
     }

     public function search(Request $request)
     {

        if($request->has('action') && $request->get('action') == 'nonbranded'){
            $brand_activation = false;
        }else{
            $brand_activation = true;
        }


         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         
         $my_product_ids = Product::whereUserId(auth()->id())->pluck('id');
         
         $products = Product::query();
         
         if($request->get('search')){
             $products
             ->whereNotIn('id',$my_product_ids)
             ->where('title','like','%'.$request->search.'%');
            }else{
                $products->whereNotIn('id',$my_product_ids);
            }
            
            if($request->get('from') && $request->get('to')) {
                $products->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $products->orderBy($request->get('asc'),'asc');
            }
            if($request->has('category_id') && $request->has('sub_category')){
                $products
                ->whereCategoryId($request->get('category_id'))
                ->whereSubCategory($request->get('sub_category'));
            }
            if($request->get('desc')){
                $products->orderBy($request->get('desc'),'desc');
            }

            $products->select('*', \DB::raw('count(*) as total'));

            // $products->whereBrandId(0)->whereIsCloned(0);
            $products->where('brand_id','!=', 0);
            $products->whereIsCloned(0);
            $products->groupBy('sku');

            // $products->get()->pluck('id');
            // echo "<pre>";
            // print_r($products->get());
            // echo "</pre>";
            
            $products = $products->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.products.searchload', ['products' => $products, 'brand_activation' => $brand_activation])->render();  
            }
 
            return view('panel.products.search', compact('products','brand_activation'));
     }

    
        public function print(Request $request){
            $products = collect($request->records['data']);
                return view('panel.products.print', ['products' => $products])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            if(AuthRole() == "User"){
                // If no indrustry
                if(auth()->user()->industry_id == null || auth()->user()->industry_id == 'null'){
                    return back()->with('error', 'your account not linked with any industry. Go to account setting and add one to proceed!');
                }

            //   $category = getProductCategoryByUserIndrustry(auth()->user()->industry_id);
                $category = getProductCategory();
            }else{
                $category = getProductCategory();
            }

            if($request->has('action') && $request->get('action') == 'nonbranded'){
                $brand_activation = false;
            }else{
                $brand_activation = true;
            }


            $user = auth()->user();

            $brand = Brand::whereId(request()->get('id'))->first();

                if(!$brand && $brand_activation == true){
                    return back()->with('error', 'No brand assign to your account!');
                }
                
            $attributes = ProductAttribute::get();
            $colors = $attributes->where('name','Color')->first();
            $sizes = $attributes->where('name','Size')->first();
            $materials = $attributes->where('name','Material')->first();
            $prodextra = ProductExtraInfo::whereId(request()->get('id'))->first();

            $delfault_cols = json_decode(Setting::where('key','bulk_sheet_upload')->first()->value);
            $user_custom_col_list = json_decode($user->custom_attriute_columns) ?? [];
            $num = end($delfault_cols) +1;
            $new_custom_attribute = [];
            foreach ($user_custom_col_list as $key => $value) {
                $new_custom_attribute += [$value => $num];
                $num++;
            }

            $col_list = (object) array_merge((array)$delfault_cols,$new_custom_attribute);
            return view('panel.products.create',compact('category','brand','colors','sizes','brand_activation','materials','prodextra','col_list'));

        }catch(\Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // chk user have active package or not!
        // return $request->all();
        if(AuthRole() == "User"){
            if(!haveActivePackageByUserId(auth()->id())){
                return back()->with('error','You do not have any active package!');
            } 

            $user_shop = UserShop::whereUserId(request()->get('user_id'))->first();
              if(!$user_shop){
                  return back()->with('error', 'No Micro site assign to your account!');
              }
        }

        $files_master = $request->img;
        $file_lock = 0;
        $file_lock_data = [];

        $this->validate($request, [
                        'brand_id'     => 'required',
                        'user_id'     => 'required',
                        'title'     => 'required',
                        'sku'     => 'sometimes | unique:products',
                        'category_id'     => 'required',
                        'sub_category'     => 'sometimes',
                        'is_publish'     => 'sometimes',
                        'manage_inventory'     => 'sometimes',
                        'status'     => 'required',
                        'stock_qty'     => 'sometimes',
                    ]);

            
         try{

            if(AuthRole() == "User"){
                $package = getUserActivePackage(auth()->id());
                $limits = json_decode($package->limit,true);
                $my_pro_counts = Product::where('user_id',auth()->id())->get()->count();
                if($limits['product_uploads'] <= $my_pro_counts){
                    return back()->with('error','Your Upload Products Limit exceed!');
                }
                $total_add_products = 1;
                if($request->get('colors') && $request->get('sizes')){
                    $total_add_products = count($request->get('colors')) * count($request->get('sizes'));
                }elseif($request->has('colors')){
                    $total_add_products = count($request->get('colors'));
                }elseif($request->has('sizes')){
                    $total_add_products = count($request->get('sizes'));
                }else{
                    $total_add_products = 1;
                }
                if($limits['product_uploads']-$my_pro_counts < $total_add_products){
                    $pros = $limits['product_uploads']-$my_pro_counts;
                    return back()->with('error','Total products upload including variants:'.$total_add_products.' You can add only '.$pros.' products!');
                }
            }
              
                    $request['is_publish'] = 1;
              
                
                if(AuthRole() == "User"){
                    if(!$request->sku){
                        $sku = 'SKU'.generateRandomStringNative(4);
                        $request['sku'] = $sku;
                    }else{
                        $request['sku'] = $request->sku;
                    }
                }
               $arr_images = [];
               
               $files = $request->file('img');

               $carton_details = [
                'standard_carton' => $request->standard_carton,
                'carton_weight' => $request->carton_weight,
                'carton_unit' => $request->carton_unit,
                ];
                 
                $shipping =[
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'width' => $request->width,
                    'length' => $request->length,
                    'unit' => $request->unit,
                    'length_unit' => $request->length_unit,
                ];
                $request['carton_details'] = json_encode($carton_details);
                $request['shipping'] = json_encode($shipping);

                 // To Fullfillment of Client MRP Need
                 $request['price'] =  $request->mrp;
                 $request['material'] = $request->material;     

               if($request->has('colors') && $request->has('sizes')){
                   foreach ($request->colors as $color) {
                     if($request->has('sizes')){
                        foreach ($request->sizes as $size) {
                            
                            $unique_slug  = getUniqueProductSlug($request->title);
                            
                            $request['color'] = $color;
                            $request['size'] = $size;
                            $request['slug'] = $unique_slug;
                            $product = Product::create($request->all());
                            // try{
                                // return $request->file('img');
                                if($file_lock == 0){
                                    if(request()->has('img') && count($request->file('img')) > 0){
                                        foreach($files as $tempimg){
                                            $img = $this->uploadFile($tempimg, "products")->getFilePath();
                                            $filename = generateRandomStringNative(6).$tempimg->getClientOriginalName();
                                            $extension = pathinfo($filename, PATHINFO_EXTENSION);
                                            if($filename != null){
                                              $media =  Media::create([
                                                    'type' => 'Product',
                                                    'type_id' => $product->id,
                                                    'file_name' => $filename,
                                                    'path' => $img,
                                                    'extension' => $extension,
                                                    'file_type' => "Image",
                                                    'tag' => "Product_Image",
                                                ]);
                                                $file_lock_data[] =  ['m_id'=>$media->id];
                                                $arr_images[] = $media->id;
                                            }
                                        }
                                    }
                                    $file_lock = 1;
                                }else{
                                    if(count($file_lock_data) > 0){
                                        foreach ($file_lock_data as $key => $file_lock_data_item) {
                                            $media_old =  Media::whereId($file_lock_data_item)->first();
                                            $media =  Media::create([
                                                  'type' => 'Product',
                                                  'type_id' => $product->id,
                                                  'file_name' => $media_old->file_name,
                                                  'path' => $media_old->path,
                                                  'extension' => $media_old->extension,
                                                  'file_type' => "Image",
                                                  'tag' => "Product_Image",
                                              ]);
                                              $arr_images[] = $media->id;
                                        }
                                      }
                                }
                                
                            // }catch(Exception $e){

                            // }

                            // Create Microsite Item Record is self upload
                            if(AuthRole() == "User"){
                                $my_groups = Group::where('user_id',auth()->id())->get();
                                foreach($my_groups as $group){
                                    $gp = new GroupProduct();
                                    $gp->group_id = $group->id;
                                    $gp->product_id = $product->id;
                                    $gp->price = $product->price??0;
                                    $gp->save();
                                }
                               $usi = UserShopItem::create([
                                    'user_id' => $request->user_id,
                                    'user_shop_id' => $user_shop->id,
                                    'product_id' => $product->id,
                                    'is_published' => 1,
                                    'category_id' =>$request->category_id,
                                    'sub_category_id' =>$request->sub_category,
                                    'price' => $product->price,
                                    'parent_shop_id' => 0,
                                    'images' => count($arr_images) > 0 ? implode(',',$arr_images) : null,
                                    'artwork_url' => $request->artwork_url,
                                    'material' => $request->material,
                                    'inventory' => $request->manage_inventory ?? 0,
                                ]);

                                if (isset($request->manage_inventory) && $request->manage_inventory == 1) {   
                                    Inventory::create([
                                        'user_shop_item_id' => $usi->id,
                                        'user_id' => $request->user_id,
                                        'product_id' => $product->id,
                                        'product_sku' => $product->sku,
                                        'tandA' => null,
                                        'stock' => 0,
                                        'stock_by_size' => null,
                                        'stock_by_color' => null,
                                        'parent_id' => null,
                                    ]);

                                }

                            }
                            
                        }  
                     }
                   }     
                   
               }elseif($request->has('colors')){
                    foreach ($request->colors as $color) {
                        $unique_slug  = getUniqueProductSlug($request->title);

                        $request['color'] = $color;
                        $request['size'] = null;
                        $request['slug'] = $unique_slug;
                        $product = Product::create($request->all());

                        if($file_lock == 0){
                            if(request()->has('img') && count($request->file('img')) > 0){
                                foreach($files as $tempimg){
                                    $img = $this->uploadFile($tempimg, "products")->getFilePath();
                                    $filename = generateRandomStringNative(6).$tempimg->getClientOriginalName();
                                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                                    if($filename != null){
                                      $media =  Media::create([
                                            'type' => 'Product',
                                            'type_id' => $product->id,
                                            'file_name' => $filename,
                                            'path' => $img,
                                            'extension' => $extension,
                                            'file_type' => "Image",
                                            'tag' => "Product_Image",
                                        ]);
                                        $file_lock_data[] =  ['m_id'=>$media->id];
                                        $arr_images[] = $media->id;
                                    }
                                }
                            }
                            $file_lock = 1;
                        }else{
                            if(request()->has('img') && count($file_lock_data) > 0){
                                foreach ($file_lock_data as $key => $file_lock_data_item) {
                                    $media_old =  Media::whereId($file_lock_data_item)->first();
                                    $media =  Media::create([
                                          'type' => 'Product',
                                          'type_id' => $product->id,
                                          'file_name' => $media_old->file_name,
                                          'path' => $media_old->path,
                                          'extension' => $media_old->extension,
                                          'file_type' => "Image",
                                          'tag' => "Product_Image",
                                      ]);
                                      $arr_images[] = $media->id;
                                }
                              }
                        }
                            // Create Microsite Item Record is self upload
                        if(AuthRole() == "User"){
                            $my_groups = Group::where('user_id',auth()->id())->get();
                            foreach($my_groups as $group){
                                $gp = new GroupProduct();
                                $gp->group_id = $group->id;
                                $gp->product_id = $product->id;
                                $gp->price = $product->price??0;
                                $gp->save();
                            }

                           $usi =  UserShopItem::create([
                                'user_id' => $request->user_id,
                                'user_shop_id' => $user_shop->id,
                                'product_id' => $product->id,
                                'is_published' => 1,
                                'category_id' =>$request->category_id,
                                'sub_category_id' =>$request->sub_category,
                                'price' => $product->price,
                                'parent_shop_id' => 0,
                                'images' => count($arr_images) > 0 ? implode(',',$arr_images) : null,
                                'artwork_url' => $request->artwork_url,
                                'material' => $request->material,

                            ]);

                            if (isset($request->manage_inventory) && $request->manage_inventory == 1) {   
                                Inventory::create([
                                    'user_shop_item_id' => $usi->id,
                                    'user_id' => $request->user_id,
                                    'tandA' => '',
                                    'product_id' => $product->id,
                                    'product_sku' => $product->sku,
                                    'stock' => 0,
                                    'stock_by_size' => null,
                                    'stock_by_color' => null,
                                    'parent_id' => null,
                                ]);

                            }
                                    
                        }
                    }  
               }elseif($request->has('sizes')){
                    foreach ($request->sizes as $size) {
                        $unique_slug  = getUniqueProductSlug($request->title);

                        $request['color'] = null;
                        $request['size'] = $size;
                        $request['slug'] = $unique_slug;
                        $product = Product::create($request->all());

                        if($file_lock == 0){
                            if(request()->has('img') && count($request->file('img')) > 0){
                                foreach($files as $tempimg){
                                    $img = $this->uploadFile($tempimg, "products")->getFilePath();
                                    $filename = generateRandomStringNative(6).$tempimg->getClientOriginalName();
                                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                                    if($filename != null){
                                      $media =  Media::create([
                                            'type' => 'Product',
                                            'type_id' => $product->id,
                                            'file_name' => $filename,
                                            'path' => $img,
                                            'extension' => $extension,
                                            'file_type' => "Image",
                                            'tag' => "Product_Image",
                                        ]);
                                        $file_lock_data[] =  ['m_id'=>$media->id];
                                        $arr_images[] = $media->id;
                                    }
                                }
                            }
                            $file_lock = 1;
                        }else{
                            if(count($file_lock_data) > 0){
                                foreach ($file_lock_data as $key => $file_lock_data_item) {
                                    $media_old =  Media::whereId($file_lock_data_item)->first();
                                    $media =  Media::create([
                                          'type' => 'Product',
                                          'type_id' => $product->id,
                                          'file_name' => $media_old->file_name,
                                          'path' => $media_old->path,
                                          'extension' => $media_old->extension,
                                          'file_type' => "Image",
                                          'tag' => "Product_Image",
                                      ]);
                                      $arr_images[] = $media->id;
                                }
                              }
                        }
                            // Create Microsite Item Record is self upload
                        if(AuthRole() == "User"){
                            $my_groups = Group::where('user_id',auth()->id())->get();
                            foreach($my_groups as $group){
                                $gp = new GroupProduct();
                                $gp->group_id = $group->id;
                                $gp->product_id = $product->id;
                                $gp->price = $product->price??0;
                                $gp->save();
                            }
                            $usi = UserShopItem::create([
                                'user_id' => $request->user_id,
                                'user_shop_id' => $user_shop->id,
                                'product_id' => $product->id,
                                'is_published' => 1,
                                'category_id' =>$request->category_id,
                                'sub_category_id' =>$request->sub_category,
                                'price' => $product->price,
                                'parent_shop_id' => 0,
                                'images' => count($arr_images) > 0 ? implode(',',$arr_images) : null,
                                'artwork_url' => $request->artwork_url,
                                'material' => $request->material,
                            ]);

                            if (isset($request->manage_inventory) && $request->manage_inventory == 1) {   
                                Inventory::create([
                                    'user_shop_item_id' => $usi->id,
                                    'user_id' => $request->user_id,
                                    'tandA' => '',
                                    'product_sku' => $product->sku,
                                    'product_id' => $product->id,
                                    'stock' => 0,
                                    'stock_by_size' => null,
                                    'stock_by_color' => null,
                                    'parent_id' => null,
                                ]);
                            }
                                    

                        }     
                    } 
               }else{

                    $unique_slug  = getUniqueProductSlug($request->title);

                    $request['color'] = null;
                    $request['size'] = null;
                    $request['slug'] = $unique_slug;
                    $product = Product::create($request->all());


                    if($request->hasFile("img")){
                        foreach($request->file('img') as $tempimg){
                            $img = $this->uploadFile($tempimg, "products")->getFilePath();
                            $filename = $tempimg->getClientOriginalName();
                            $extension = pathinfo($filename, PATHINFO_EXTENSION);
                            if($filename != null){
                                $media = Media::create([
                                    'type' => 'Product',
                                    'type_id' => $product->id,
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
                    // Create Microsite Item Record is self upload
                    if(AuthRole() == "User"){
                        $my_groups = Group::where('user_id',auth()->id())->get();
                        foreach($my_groups as $group){
                            $gp = new GroupProduct();
                            $gp->group_id = $group->id;
                            $gp->product_id = $product->id;
                            $gp->price = $product->price??0;
                            $gp->save();
                        }

                        $usi = UserShopItem::create([
                            'user_id' => $request->user_id,
                            'user_shop_id' => $user_shop->id,
                            'product_id' => $product->id,
                            'is_published' => 1,
                            'category_id' =>$request->category_id,
                            'sub_category_id' =>$request->sub_category,
                            'price' => $product->price,
                            'parent_shop_id' => 0,
                            'images' => count($arr_images) > 0 ? implode(',',$arr_images) : null,
                            'artwork_url' => $request->artwork_url,
                            'material' => $request->material,
                        ]);
                        if (isset($request->manage_inventory) && $request->manage_inventory == 1) {   
                            Inventory::create([
                                'user_shop_item_id' => $usi->id,
                                'user_id' => $request->user_id,
                                'product_id' => $product->id,
                                'tandA' => '',
                                'product_sku' => $product->sku,
                                'stock' => 0,
                                'stock_by_size' => null,
                                'stock_by_color' => null,
                                'parent_id' => null,
                            ]);

                        }
                                
                    }

               }


               if($request->btn1 != null && $request->btn1 == 1){
                    if($request->brand_id == 0){
                        return redirect(route('panel.products.create',['action'=>'nonbranded']))->with('success','Product created. Visit Shop > Price group to update.');
                    }else{
                        return redirect(route('panel.products.create',['action'=>'branded','id'=>$request->brand_id]))->with('success','Product created. Visit Shop > Price group to update.');
                    }
                }else{
                    if($request->brand_id == 0){
                        return redirect(route('panel.user_shop_items.create',['type'=>'direct','type_id'=>$request->user_id]))->with('success','Product created. Visit Shop > Price group to update.');
                    }else{
                        return redirect(route('panel.products.index',['action'=>'branded','id'=>$request->brand_id]))->with('success','Product created. Visit Shop > Price group to update.');
                    }
               }
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function clone(Request $request,$id)
    {
        
        if(AuthRole() == "User"){
             // chk user have active package or not!
            if(!haveActivePackageByUserId(auth()->id())){
                return back()->with('error','You do not have any active package!');
            } 
            $package = getUserActivePackage(auth()->id());
            $limits = json_decode($package->limit,true);
            $my_pro_counts = Product::where('user_id',auth()->id())->get()->count();
            if($limits['product_uploads'] <= $my_pro_counts){
                return back()->with('error','Your Upload Products Limit exceed!');
            }
            
        }
       
        try{
            $user_shop_record = UserShop::where('user_id',auth()->id())->firstorFail();
            $value = Product::find($id);

            // variant
            $variants = Product::whereSku($value->sku)->get();
            foreach ($variants as $key => $product) {
                
                $newProduct = $product->replicate();
                $newProduct->created_at = \Carbon\Carbon::now();
                $newProduct->user_id = auth()->id();
                $newProduct->model_code = null;
                $newProduct->is_cloned = 1;
                $newProduct->sku = 'SKU'.generateRandomStringNative(4);
                $newProduct->slug = getUniqueProductSlug($product->title);
                $newProduct->save();

                // return $newProduct;

                $user_shop_item = UserShopItem::create([
                     'user_id' => $user_shop_record->user_id,
                     'user_shop_id' => $user_shop_record->id,
                     'product_id' => $newProduct->id,
                     'is_published' => 1,
                     'category_id' =>$product->category_id,
                     'sub_category_id' =>$product->sub_category,
                     'price' => 0,
                     'parent_shop_id' => 0,
                 ]);

                $medias = Media::whereTypeId($product->id)->whereType('Product')->whereTag('Product_Image')->get();
                foreach($medias as $media){
                    $newMedia = $media->replicate();
                    $newMedia->type_id = $newProduct->id;
                    $newMedia->save();
                }
                // return $newMedia;
            }

            
            return redirect()->route('panel.products.edit',$newProduct->id)->with('success','Product Replicate  Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function getQrQuantity(Request $request)
    {
        $this->validate($request, [
            'quantity'     => 'required',
        ]);

        $product = Product::whereId($request->id)->firstorFail();
        $quantity = $request->quantity;
        $user_shop_record = UserShop::where('user_id',auth()->id())->firstorFail();
        
        return view('panel.products.include.qr-code-index',compact('product','quantity','user_shop_record'));
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        try{
            return view('panel.products.show',compact('product'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function updateProductSku(Request $request)
    {
        try{
            if($request->all_products == 1){
                    $scoped_items = UserShopItem::whereUserId(auth()->id())->get();
                    // $product_ids = Product::whereIn('id', $scoped_items->pluck('product_id'))->groupBy('sku')->pluck('id');
                    $product_ids = Product::whereIn('id', $scoped_items->pluck('product_id'))->pluck('id');
 
                }else{
                    $product_ids = $request->product_ids;
                }
                
                if(count($product_ids) == 0){
                    return back()->with('error','No Products added in your account!');
                }
                
                return view('panel.products.qr',compact('product_ids'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function qrRequestList(Product $product)
    {
        try{
            return view('panel.products.show',compact('product'));
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
    public function edit(Product $product)
    {   
        try{
            $product = Product::whereId($product->id)->first();
            $product_record = UserShopItem::where('product_id',$product->id)->first();
            $attributes = ProductAttribute::get();
            $colors = $attributes->where('name','Colour')->first();
            $sizes = $attributes->where('name','Size')->first();
            $shipping = json_decode($product->shipping);
            $carton_details = json_decode($product->carton_details);
            $variations = Product::whereSku($product->sku)->get();
            $medias = Media::whereType('Product')->whereTypeId($product->id)->whereTag('Product_Image')->get();
            // $prodextra = ProductExtraInfo::whereId(request()->get('id'))->first();


            $prodextra = ProductExtraInfo::where('product_id',$product->id)->groupBy('attribute_value_id')->first();
            
            // if(AuthRole() == "User"){
            //     $category = getProductCategoryByUserIndrustry(auth()->user()->industry_id);
            // }else{
                $category = getProductCategory();
            // }

            // magicstring(json_decode($colors->value,true));
            
            // return;


            $custom_attribute = ProductAttribute::where('user_id',null)->orwhere('user_id',$product->user_id)->get();

            $groupIds = ProductExtraInfo::where('product_id',$product->id)->groupBy('Cust_tag_group')->orderBy('id','ASC')->pluck('Cust_tag_group','product_id')->toArray();

            $groupIds_all = ProductExtraInfo::where('group_id',$product->sku)->groupBy('Cust_tag_group')->orderBy('id','ASC')->pluck('Cust_tag_group','product_id');

            return view('panel.products.edit',compact('product','category','product_record','medias','colors','sizes','shipping','variations','carton_details','prodextra','custom_attribute','groupIds','groupIds_all'));

        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function editVarient(Request $request)
    {   
        try{
            // return $request->all();
            $user_shop_record = UserShop::where('user_id',auth()->id())->firstorFail();
            $product = Product::whereId($request->product_id)->first();
            if(!$product){
                 return back()->with('error','Product not found!');
            }

            $same = Product::whereSku($product->sku)->whereColor($request->color)->whereSize($request->size)->first();
            if($same){
                 return back()->with('error','Product variant already exists!');
            }

            $new_product = Product::create([
                        'brand_id'     => $product->brand_id,
                        'user_id'     => $product->user_id,
                        'title'     => $product->title,
                        'category_id'     => $product->category_id,
                        'sub_category'     => $product->sub_category,
                        'is_publish'     => $product->is_publish,
                        'manage_inventory'     => $product->manage_inventory,
                        'status'     => $product->status,
                        'stock_qty'     => $product->stock_qty,
                        'product_type'     => $product->product_type,
                        'price'     => $product->price,
                        'sku'     => $product->sku,
                        'slug'     => $product->slug,
                        'description'     => $product->description,
                        'features'     => $product->features,
                        'shipping'     => $product->shipping,
                        'color'     => $request->color,
                        'size'     => $request->size,
            ]);

             // Create Microsite Item Record is self upload
            if(AuthRole() == "User"){
                UserShopItem::create([
                    'user_id' => $new_product->user_id,
                    'user_shop_id' => $user_shop_record->id ,
                    'product_id' => $new_product->id,
                    'is_published' => 1,
                    'category_id' =>$new_product->category_id,
                    'sub_category_id' =>$new_product->sub_category,
                    'price' => $new_product->price,
                    'parent_shop_id' => 0,
                ]);
            }
            
             return redirect(route('panel.products.edit',$new_product->id))->with('success','Variant Added Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function updateSKU(Request $request,$id)
    { 
        try{
            $products = Product::where('sku',$request->old_sku)->get();
            if ($products) {
                    foreach ($products as $product) {
                        $product->update([
                        'sku' => $request->sku,
                        ]);
                }
            }
             return back()->with('success','SKU Updated Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    

   
    public function updateVarient(Request $request,Product $product){
        $varient_products = Product::where('id','!=',$product->id)->where('sku', '=', $product->sku)->get();
        foreach ($varient_products as $v_p){
            if($v_p->color == $request->color && $v_p->size == $request->size){
                return back()->with('error','This variant already exists')->withInput();
            }
        } 
        $product->color = $request->color;
        $product->size = $request->size;
        $product->save();
        return back()->with('success','Varient Updated Successfully!');
    }

    public function update(Request $request,Product $product)
    {
        $this->validate($request, [
            'brand_id'     => 'required',
            'user_id'     => 'required',
            'title'     => 'required',
            'category_id'     => 'required',
            'sub_category'     => 'sometimes',
            'is_publish'     => 'sometimes',
            'manage_inventory'     => 'sometimes',
            'status'     => 'required',
            'stock_qty'     => 'sometimes',
        ]); 
           

        $allow_array = ['Yes','YES','yes','Hn','true',true,1,'on'];

        try{            
            if(!$request->has('is_publish')){
                $request['is_publish'] = 0;
            }


            if(in_array($request->has('is_publish'),$allow_array)){
                $request['is_publish'] = 1;
            }else{
                $request['is_publish'] = 0;
            }

            



            $usi = UserShopItem::where('user_id','=',$product->user_id)->where('product_id',$product->id)->first();
            $chk_inventroy = Inventory::where('product_id',$product->id)->where('user_id',auth()->id())->get();

            if ($request->has('manage_inventory') && $request->get('manage_inventory') == 1) {
                if (count($chk_inventroy) == 0) {
                    // magicstring($request->all());
                    Inventory::create([
                        'user_shop_item_id' => $usi->id,
                        'product_id' => $product->id,
                        'user_id' => auth()->id(),
                        'stock' => 0,
                        'product_sku' => $product->sku,
                        'parent_id' => 0,
                        'prent_stock' => 0,
                    ]);
                }else{
                    getinventoryByproductId($product->id)->update(['status'=>1]);
                }
            }else{
                if (count($chk_inventroy) != 0) {
                    getinventoryByproductId($product->id)->update(['status'=>0]);
                }
            }
            


            if($product){
                // To Fullfillment of Client MRP Need
                $request['price'] =  $request->mrp;
                if($request->hasFile("img")){
                        foreach($request->file('img') as $tempimg){
                            $img = $this->uploadFile($tempimg, "products")->getFilePath();
                            $filename = $tempimg->getClientOriginalName();
                            $extension = pathinfo($filename, PATHINFO_EXTENSION);
                            if($filename != null){
                                Media::create([
                                    'type' => 'Product',
                                    'type_id' => $product->id,
                                    'file_name' => $filename,
                                    'path' => $img,
                                    'extension' => $extension,
                                    'file_type' => "Image",
                                    'tag' => "Product_Image",
                                ]);
                            }
                        }
                    }
                $shipping = [
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'width' => $request->width,
                    'length' => $request->length,
                    'unit' => $request->unit,                  
                    'length_unit' => $request->length_unit,
                    'gross_weight' => $request->gross_weight,
                ];
                $carton_details = [
                    'standard_carton' => $request->standard_carton,
                    'carton_weight' => $request->carton_weight,
                    'carton_unit' => $request->carton_unit,
                ];

                $carton_details = [
                    'standard_carton' => $request->standard_carton,
                    'carton_weight' => $request->carton_weight,
                    'carton_unit' => $request->carton_unit,
                    'carton_length' => $request->carton_length,
                    'carton_width' => $request->carton_width,
                    'carton_height' => $request->carton_height,
                    'Carton_Dimensions_unit' => $request->Carton_Dimensions_unit,
                ];
                

                $request['shipping'] = json_encode($shipping);  
                $request['carton_details'] = json_encode($carton_details);  
                

                $chk = $product->update($request->all());
                
                

                ProductExtraInfo::where('product_id',$product->id)->update([
                    'allow_resellers' => (in_array($request->allow_resellers,$allow_array) ? 'yes' : 'no') ?? 'no',
                    'exclusive_buyer_name' => $request->get('exclusive_buyer_name') ?? '',
                    'collection_name' => $request->get('collection_name') ?? '',
                    'season_month' => $request->get('season_month') ?? '',
                    'season_year' => $request->get('season_year') ?? '',
                    'sample_available' => $request->get('sample_available') ?? '',
                    'sample_year' => $request->get('sample_year') ?? '',
                    'sample_month' => $request->get('sample_month') ?? '',
                    'sampling_time' => $request->get('sampling_time') ?? '',
                    'CBM'=> $request->get('CBM') ?? '',
                    'production_time'=> $request->get('production_time') ?? '',
                    'MBQ' => $request->get('MBQ') ?? '',
                    'MBQ_unit' => $request->get('MBQ_unit') ?? '',
                    'remarks' => $request->get('remarks') ?? '',
                    'vendor_sourced_from' => $request->get('vendor_sourced_from') ?? '',
                    'vendor_price' => $request->get('vendor_price') ?? '',
                    'product_cost_unit' => $request->get('product_cost_unit') ?? '',
                    'vendor_currency' => $request->get('vendor_currency') ?? '',
                    'sourcing_year' => $request->get('sourcing_year') ?? '',
                    'sourcing_month' => $request->get('sourcing_month') ?? '',
                    'production_type' => $request->get('production_type') ?? '',
                    'group_id' => $request->get('group_id') ?? '',
                    'Cust_tag_group'=> $request->get('Cust_tag_group') ?? '',
                    'brand_name' => $request->get('brand_name') ?? '',
                ]);


                $custom_attribute = ProductAttribute::where('user_id',null)->orwhere('user_id',$product->user_id)->get();

                // foreach ($custom_attribute as $key => $value) {
                //     $count = $key+1;
                //     echo "You are Working on $value->name Attribute".newline();

                //     $result = $request->get("custom_attri_$count");

                //     if ($request->get("custom_attri_$count") != null) {
                        
                //         echo "The value of custom_attri_$count".newline();
                //         magicstring($result);
                        
                //         $received_values = explode(",",$result);

                //         magicstring($received_values);

                //         foreach ($received_values as $receiveKey => $receive_value) {                            
                //             $productattriid = ProductAttributeValue::where('parent_id',$value->id)->where('attribute_value',$receive_value)->first();

                //             $chk = ProductExtraInfo::where('attribute_id',$value->id)->where('attribute_value_id',$productattriid->id)->where('group_id',$product->sku)->first();

                //             if ($chk == null) {
                //                 echo "$receive_value is not Exist in Record".newline();

                //                 $newitem = [
                //                     'allow_resellers' =>(in_array($request->allow_resellers,$allow_array) ? 'yes' : 'no') ?? 'no',
                //                     'exclusive_buyer_name' => $request->get('exclusive_buyer_name') ?? '',
                //                     'collection_name' => $request->get('collection_name') ?? '',
                //                     'season_month' => $request->get('season_month') ?? '',
                //                     'season_year' => $request->get('season_year') ?? '',
                //                     'sample_available' => $request->get('sample_available') ?? '',
                //                     'sample_year' => $request->get('sample_year') ?? '',
                //                     'sample_month' => $request->get('sample_month') ?? '',
                //                     'sampling_time' => $request->get('sampling_time') ?? '',
                //                     'CBM'=> $request->get('CBM') ?? '',
                //                     'production_time'=> $request->get('production_time') ?? '',
                //                     'MBQ' => $request->get('MBQ') ?? '',
                //                     'MBQ_unit' => $request->get('MBQ_unit') ?? '',
                //                     'remarks' => $request->get('remarks') ?? '',
                //                     'vendor_sourced_from' => $request->get('vendor_sourced_from') ?? '',
                //                     'vendor_price' => $request->get('vendor_price') ?? '',
                //                     'product_cost_unit' => $request->get('product_cost_unit') ?? '',
                //                     'vendor_currency' => $request->get('vendor_currency') ?? '',
                //                     'sourcing_year' => $request->get('sourcing_year') ?? '',
                //                     'sourcing_month' => $request->get('sourcing_month') ?? '',
                //                     'production_type' => $request->get('production_type') ?? '',
                //                     'group_id' => $request->get('group_id') ?? '',
                //                     'Cust_tag_group'=> $request->get('Cust_tag_group') ?? '',
                //                     'brand_name' => $request->get('brand_name') ?? '',
                //                     'attribute_id' => $value->id,
                //                     'attribute_value_id' => $productattriid->id
                //                 ];

                //                 magicstring($newitem);


                //             }
                //         }


                //     }
                // }



                $vip_group = getPriceGroupByGroupName(auth()->id(),"VIP");
                $reseller_group = getPriceGroupByGroupName(auth()->id(),"Reseller");

                // Update VIP Price Group
                GroupProduct::whereGroupId($vip_group->id)->whereProductId($product->id)->update([
                    'price' => $request->vip_group
                ]);

                // Update Reseller Price Group
                GroupProduct::whereGroupId($reseller_group->id)->whereProductId($product->id)->update([
                    'price' => $request->reseller_group
                ]);



                                
                if($request->is_publish == 0){
                    UserShopItem::where('user_id','=',$product->user_id)->where('product_id',$product->id)->update(['is_published'=>0]);
                }else{
                    UserShopItem::where('user_id','=',$product->user_id)->where('product_id',$product->id)->update(['is_published'=>1]);
                }

                $othershops = UserShopItem::where('user_id','!=',$product->user_id)->where('product_id',$product->id)->get();              
                
                
                // Mail Sent to all sellers who has this product
                foreach($othershops as $other){
                    
                    // Unpublish all sellers who has this product
                    $other->is_published = 0;
                    $other->save();

                    $user_record =  getUserRecordByUserId($other->user_id);
                    // $product_record =  getProductRecordById($other->product_id);
                    $mailcontent_data = MailSmsTemplate::where('code','=',"product-unpublished")->first();
                    if($mailcontent_data){
                        $arr=[
                                '{name}'=>$user_record->name,
                                '{product_name}'=>$product->title,
                            ];
                        
                        TemplateMail($user_record->name,$mailcontent_data,$user_record->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button = null);
                    }
                    $onsite_notification['user_id'] =  $other->user_id;
                    $onsite_notification['title'] = NameById($product->user_id)." has made changes to their product
                    $product->title (Model-#$product->model_code) , resulting in auto unpublished from your account. To continue selling, review changes and publish." ;
                    $onsite_notification['link'] = route('panel.user_shop_items.create')."?type=direct&type_id=".$product->user_id;
                    pushOnSiteNotification($onsite_notification);
                }
                   
                //   $product = UserShopItem::where('product_id',$product->id)->first();
                // $product->update([
                //     'price' => $request->price
                // ]);

                return back()->with('success','Product Updated!');
            }
            return back()->with('error','Product not found')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try{
            if($product){
                $childItems = UserShopItem::where('product_id',$product->id)
                ->where('parent_shop_id','!=',0)->where('deleted_at','!=',null)
                ->first();

                // Deleting Product extra info 
                ! ProductExtraInfo::where('group_id',$product->sku)->delete();
                
                if(!$childItems){
                    $data = $product->varient_products();
                    foreach ($data as $key => $value) {
                        $usershop_item  = UserShopItem::where('product_id',$value->id)->delete();
                        $product =  Product::find($value->id)->delete();
                    }
                    return back()->with('success','Product deleted successfully');
                }
                return back()->with('error','You can not delete this product because sellers already added to their shop. You can unpublish to stop receiving orders.');
            }else{
                return back()->with('error','Product not found');
            }
        }catch(\Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }



    public function deleteImage(Product $product,$id)
    {
        $image = Media::whereType('product')->find($id);
        $image->delete();
        return back()->with('success','Image Deleted Successfully!');
    }
}

if (!function_exists('yearDropdown'))
{
    function yearDropdown($startYear, $endYear, $id = 'year')
    {
        echo "<select id='$id' name='$id'>";

        for ($i = $startYear; $i <= $endYear; $i++) {
            echo "<option value='$i'>$i</option>";
        }

        echo "</select>";
    }
}

