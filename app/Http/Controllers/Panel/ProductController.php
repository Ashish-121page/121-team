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
use App\Models\ProposalItem;
use App\Models\Setting;
use App\Models\UserShopItem;
use App\Models\Usertemplates;
use App\Models\CustomFields;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use phpseclib3\File\ASN1\Maps\AttributeValue;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;

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

            $delfault_cols = json_decode(Setting::where('key','bulk_sheet_upload')->first()->value) ?? [];
            $user_custom_col_list = json_decode($user->custom_attriute_columns) ?? [];

            $num = end($delfault_cols) +1;

            $new_custom_attribute = [];
            foreach ($user_custom_col_list as $key => $value) {
                $new_custom_attribute += [$value => $num];
                $num++;
            }

            $col_list = (object) array_merge((array)$delfault_cols,$new_custom_attribute);

            $ExistingTemplates = Usertemplates::where('user_id',$user->id)->get();
            $available_groups = ProductExtraInfo::where('user_id',$user->id)->groupBy('Cust_tag_group')->pluck('Cust_tag_group');
            $available_model_code = Product::where('user_id',$user->id)->groupBy('model_code')->pluck('model_code');


            if ($request->has('viewid') && $request->has('encid')) {
                $product = Product::whereId(decrypt($request->get('viewid')))->first();
                $productExtra = ProductExtraInfo::whereId(decrypt($request->get('encid')))->first();
                $arraysd = ProductExtraInfo::where('group_id',$product->sku)->pluck('attribute_id','attribute_value_id')->toArray();

                $varient_basis = countRepetitions($arraysd);
                arsort($varient_basis);
                $varient_basis_tmp = [];
                foreach ($varient_basis as $key => $value) {
                    if ($value > 1) {

                        $up = strtolower(getAttruibuteById($key)->name);
                        $up = ucwords($up);
                        array_push($varient_basis_tmp, $up);
                    }
                }

                $varient_basis = $varient_basis_tmp;

                // $attribute_value_id = ProductExtraInfo::where('product_id',$product->id)->groupBy('attribute_value_id')->pluck('attribute_value_id')->toArray();
                $attribute_value_id = ProductExtraInfo::where('group_id',$product->sku)->groupBy('attribute_value_id')->pluck('attribute_value_id')->toArray();


                $medias = Media::whereType('Product')->whereTypeId($product->id)->whereTag('Product_Image')->where('extension','!=','gif')->get();
                $medias_gif = Media::whereType('Product')->whereTypeId($product->id)->whereTag('Product_Image')->where('extension','gif')->get();
                $media_Video = Media::whereType('Product')->whereTypeId($product->id)->whereTag('Product_Video')->get();
                $mediaAssets = Media::whereType('Product')->whereTypeId($product->id)->whereTag('Product_Asset')->get();

                $mediaSize_attachment = 0;
                foreach ($mediaAssets as $key => $media) {
                    $path = str_replace("storage","public",$media->path);
                    if (Storage::exists($path)) {
                        $size_Of_File = Storage::size($path);
                        $mediaSize_attachment += $size_Of_File;
                    }
                }

                $mediaSize_video = 0;
                foreach ($media_Video as $key => $media) {
                    $path = str_replace("storage","public",$media->path);
                    if (Storage::exists($path)) {
                        $size_Of_File = Storage::size($path);
                        $mediaSize_video += $size_Of_File;
                    }
                }

                $mediaSize_gif = 0;
                foreach ($medias_gif as $key => $media) {
                    $path = str_replace("storage","public",$media->path);
                    if (Storage::exists($path)) {
                        $size_Of_File = Storage::size($path);
                        $mediaSize_gif += $size_Of_File;
                    }
                }

                $mediaSize_Image = 0;
                foreach ($medias as $key => $media) {
                    $path = str_replace("storage","public",$media->path);
                    if (Storage::exists($path)) {
                        $size_Of_File = Storage::size($path);
                        $mediaSize_Image += $size_Of_File;
                    }
                }


                $folder = "storage/files/".auth()->id();
                $medias = Media::where('path',"LIKE","%".$folder."%")->groupBy('path')->orderBy('created_at',"DESC")->paginate(10);


                $user_custom_fields = json_decode($user->custom_fields,true) ?? [];
                $fileds_sections = array_column($user_custom_fields, 'ref_section');
                $fileds_sections_names = [];
                $fileds_sections_ids = array_column($user_custom_fields, 'id');

                foreach ($fileds_sections_ids as $key => $value) {
                    array_push($fileds_sections_names, getCustomFieldValueById($value,$product->id)->value ?? '');
                }


            }else{
                $product = null;
                $productExtra = null;
                $arraysd = [];
                $varient_basis = [];
                $attribute_value_id = [];
                $folder = "storage/files/".auth()->id();
                $medias = Media::where('path',"LIKE","%".$folder."%")->groupBy('path')->orderBy('created_at',"DESC")->paginate(10);
                $media_Video = [];
                $mediaAssets = [];
                $medias_gif = [];
                $mediaSize_Image = [];
                $mediaSize_attachment = [];
                $mediaSize_gif = [];
                $mediaSize_video = [];
                $user_custom_fields = json_decode($user->custom_fields,true) ?? [];
                $fileds_sections = array_column($user_custom_fields, 'ref_section');
                $fileds_sections_names = [];
                $fileds_sections_ids = array_column($user_custom_fields, 'id');


            }

            return view('panel.products.create',compact('category','brand','colors','sizes','brand_activation','materials','prodextra','col_list','ExistingTemplates','available_model_code','available_groups','user_custom_col_list','product','productExtra','varient_basis','attribute_value_id','medias','media_Video','mediaAssets','medias_gif','mediaSize_Image','mediaSize_attachment','mediaSize_gif','mediaSize_video','fileds_sections','user_custom_fields'));

        }catch(\Exception $e){
            // return back()->with('error', 'There was an error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function downloadtemplate(Usertemplates $template) {

        try {

            $records = json_decode($template->columns_values);
            $templatename = $template->template_name;
            $user = auth()->user();
            $mytime = Carbon::now();

            $filename = "$templatename -$user->name -".$mytime->toDateTimeString();

            // ` Calling Function from Another Controller
            app('App\Http\Controllers\NewBulkController')->exportExcel($records,$filename);


            return back()->with('success',"Download Started");
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', 'There was an error: ' . $th->getMessage());
        }



    }

    public function edittemplate(Usertemplates $template) {
        $user = auth()->user();
        $delfault_cols = json_decode(Setting::where('key','bulk_sheet_upload')->first()->value);
        $user_custom_col_list = json_decode($user->custom_attriute_columns) ?? [];
        $num = end($delfault_cols) +1;
        $new_custom_attribute = [];
        foreach ($user_custom_col_list as $key => $value) {
            $new_custom_attribute += [$value => $num];
            $num++;
        }

        $col_list = (object) array_merge((array)$delfault_cols,$new_custom_attribute);




        return view('panel.products.edit-template',compact('col_list','template'));
    }
    public function updatetemplate(Request $request,Usertemplates $template) {

        try {

            $request['finalarray'] = array_merge($request->get('systemfiels'),$request->get('myfields') ?? []);

            $template->template_name = $request->template_name;
            $template->columns_values = json_encode($request->finalarray);
            $template->save();



            return back()->with('success',"Temlate Updated Successfully !!");
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error',"There was an error try again later.");
        }

    }





    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     // chk user have active package or not!
    //     return $request->all();
    //     if(AuthRole() == "User"){
    //         if(!haveActivePackageByUserId(auth()->id())){
    //             return back()->with('error','You do not have any active package!');
    //         }

    //         $user_shop = UserShop::whereUserId(request()->get('user_id'))->first();
    //           if(!$user_shop){
    //               return back()->with('error', 'No Micro site assign to your account!');
    //           }
    //     }

    //     $files_master = $request->img;
    //     $file_lock = 0;
    //     $file_lock_data = [];

    //     $this->validate($request, [
    //                     'brand_id'     => 'required',
    //                     'user_id'     => 'required',
    //                     'title'     => 'required',
    //                     'sku'     => 'sometimes | unique:products',
    //                     'category_id'     => 'required',
    //                     'sub_category'     => 'sometimes',
    //                     'is_publish'     => 'sometimes',
    //                     'manage_inventory'     => 'sometimes',
    //                     'status'     => 'required',
    //                     'stock_qty'     => 'sometimes',
    //                 ]);


    //      try{

    //         if(AuthRole() == "User"){
    //             $package = getUserActivePackage(auth()->id());
    //             $limits = json_decode($package->limit,true);
    //             $my_pro_counts = Product::where('user_id',auth()->id())->get()->count();
    //             if($limits['product_uploads'] <= $my_pro_counts){
    //                 return back()->with('error','Your Upload Products Limit exceed!');
    //             }
    //             $total_add_products = 1;
    //             if($request->get('colors') && $request->get('sizes')){
    //                 $total_add_products = count($request->get('colors')) * count($request->get('sizes'));
    //             }elseif($request->has('colors')){
    //                 $total_add_products = count($request->get('colors'));
    //             }elseif($request->has('sizes')){
    //                 $total_add_products = count($request->get('sizes'));
    //             }else{
    //                 $total_add_products = 1;
    //             }
    //             if($limits['product_uploads']-$my_pro_counts < $total_add_products){
    //                 $pros = $limits['product_uploads']-$my_pro_counts;
    //                 return back()->with('error','Total products upload including variants:'.$total_add_products.' You can add only '.$pros.' products!');
    //             }
    //         }

    //                 $request['is_publish'] = 1;


    //             if(AuthRole() == "User"){
    //                 if(!$request->sku){
    //                     $sku = 'SKU'.generateRandomStringNative(4);
    //                     $request['sku'] = $sku;
    //                 }else{
    //                     $request['sku'] = $request->sku;
    //                 }
    //             }
    //            $arr_images = [];

    //            $files = $request->file('img');

    //            $carton_details = [
    //             'standard_carton' => $request->standard_carton,
    //             'carton_weight' => $request->carton_weight,
    //             'carton_unit' => $request->carton_unit,
    //             ];

    //             $shipping =[
    //                 'height' => $request->height,
    //                 'weight' => $request->weight,
    //                 'width' => $request->width,
    //                 'length' => $request->length,
    //                 'unit' => $request->unit,
    //                 'length_unit' => $request->length_unit,
    //             ];
    //             $request['carton_details'] = json_encode($carton_details);
    //             $request['shipping'] = json_encode($shipping);

    //              // To Fullfillment of Client MRP Need
    //              $request['price'] =  $request->mrp;
    //              $request['material'] = $request->material;

    //            if($request->has('colors') && $request->has('sizes')){
    //                foreach ($request->colors as $color) {
    //                  if($request->has('sizes')){
    //                     foreach ($request->sizes as $size) {

    //                         $unique_slug  = getUniqueProductSlug($request->title);

    //                         $request['color'] = $color;
    //                         $request['size'] = $size;
    //                         $request['slug'] = $unique_slug;
    //                         $product = Product::create($request->all());
    //                         // try{
    //                             // return $request->file('img');
    //                             if($file_lock == 0){
    //                                 if(request()->has('img') && count($request->file('img')) > 0){
    //                                     foreach($files as $tempimg){
    //                                         $img = $this->uploadFile($tempimg, "products")->getFilePath();
    //                                         $filename = generateRandomStringNative(6).$tempimg->getClientOriginalName();
    //                                         $extension = pathinfo($filename, PATHINFO_EXTENSION);
    //                                         if($filename != null){
    //                                           $media =  Media::create([
    //                                                 'type' => 'Product',
    //                                                 'type_id' => $product->id,
    //                                                 'file_name' => $filename,
    //                                                 'path' => $img,
    //                                                 'extension' => $extension,
    //                                                 'file_type' => "Image",
    //                                                 'tag' => "Product_Image",
    //                                             ]);
    //                                             $file_lock_data[] =  ['m_id'=>$media->id];
    //                                             $arr_images[] = $media->id;
    //                                         }
    //                                     }
    //                                 }
    //                                 $file_lock = 1;
    //                             }else{
    //                                 if(count($file_lock_data) > 0){
    //                                     foreach ($file_lock_data as $key => $file_lock_data_item) {
    //                                         $media_old =  Media::whereId($file_lock_data_item)->first();
    //                                         $media =  Media::create([
    //                                               'type' => 'Product',
    //                                               'type_id' => $product->id,
    //                                               'file_name' => $media_old->file_name,
    //                                               'path' => $media_old->path,
    //                                               'extension' => $media_old->extension,
    //                                               'file_type' => "Image",
    //                                               'tag' => "Product_Image",
    //                                           ]);
    //                                           $arr_images[] = $media->id;
    //                                     }
    //                                   }
    //                             }

    //                         // }catch(Exception $e){

    //                         // }

    //                         // Create Microsite Item Record is self upload
    //                         if(AuthRole() == "User"){
    //                             $my_groups = Group::where('user_id',auth()->id())->get();
    //                             foreach($my_groups as $group){
    //                                 $gp = new GroupProduct();
    //                                 $gp->group_id = $group->id;
    //                                 $gp->product_id = $product->id;
    //                                 $gp->price = $product->price??0;
    //                                 $gp->save();
    //                             }
    //                            $usi = UserShopItem::create([
    //                                 'user_id' => $request->user_id,
    //                                 'user_shop_id' => $user_shop->id,
    //                                 'product_id' => $product->id,
    //                                 'is_published' => 1,
    //                                 'category_id' =>$request->category_id,
    //                                 'sub_category_id' =>$request->sub_category,
    //                                 'price' => $product->price,
    //                                 'parent_shop_id' => 0,
    //                                 'images' => count($arr_images) > 0 ? implode(',',$arr_images) : null,
    //                                 'artwork_url' => $request->artwork_url,
    //                                 'material' => $request->material,
    //                                 'inventory' => $request->manage_inventory ?? 0,
    //                             ]);

    //                             if (isset($request->manage_inventory) && $request->manage_inventory == 1) {
    //                                 Inventory::create([
    //                                     'user_shop_item_id' => $usi->id,
    //                                     'user_id' => $request->user_id,
    //                                     'product_id' => $product->id,
    //                                     'product_sku' => $product->sku,
    //                                     'tandA' => null,
    //                                     'stock' => 0,
    //                                     'stock_by_size' => null,
    //                                     'stock_by_color' => null,
    //                                     'parent_id' => null,
    //                                 ]);

    //                             }

    //                         }

    //                     }
    //                  }
    //                }

    //            }elseif($request->has('colors')){
    //                 foreach ($request->colors as $color) {
    //                     $unique_slug  = getUniqueProductSlug($request->title);

    //                     $request['color'] = $color;
    //                     $request['size'] = null;
    //                     $request['slug'] = $unique_slug;
    //                     $product = Product::create($request->all());

    //                     if($file_lock == 0){
    //                         if(request()->has('img') && count($request->file('img')) > 0){
    //                             foreach($files as $tempimg){
    //                                 $img = $this->uploadFile($tempimg, "products")->getFilePath();
    //                                 $filename = generateRandomStringNative(6).$tempimg->getClientOriginalName();
    //                                 $extension = pathinfo($filename, PATHINFO_EXTENSION);
    //                                 if($filename != null){
    //                                   $media =  Media::create([
    //                                         'type' => 'Product',
    //                                         'type_id' => $product->id,
    //                                         'file_name' => $filename,
    //                                         'path' => $img,
    //                                         'extension' => $extension,
    //                                         'file_type' => "Image",
    //                                         'tag' => "Product_Image",
    //                                     ]);
    //                                     $file_lock_data[] =  ['m_id'=>$media->id];
    //                                     $arr_images[] = $media->id;
    //                                 }
    //                             }
    //                         }
    //                         $file_lock = 1;
    //                     }else{
    //                         if(request()->has('img') && count($file_lock_data) > 0){
    //                             foreach ($file_lock_data as $key => $file_lock_data_item) {
    //                                 $media_old =  Media::whereId($file_lock_data_item)->first();
    //                                 $media =  Media::create([
    //                                       'type' => 'Product',
    //                                       'type_id' => $product->id,
    //                                       'file_name' => $media_old->file_name,
    //                                       'path' => $media_old->path,
    //                                       'extension' => $media_old->extension,
    //                                       'file_type' => "Image",
    //                                       'tag' => "Product_Image",
    //                                   ]);
    //                                   $arr_images[] = $media->id;
    //                             }
    //                           }
    //                     }
    //                         // Create Microsite Item Record is self upload
    //                     if(AuthRole() == "User"){
    //                         $my_groups = Group::where('user_id',auth()->id())->get();
    //                         foreach($my_groups as $group){
    //                             $gp = new GroupProduct();
    //                             $gp->group_id = $group->id;
    //                             $gp->product_id = $product->id;
    //                             $gp->price = $product->price??0;
    //                             $gp->save();
    //                         }

    //                        $usi =  UserShopItem::create([
    //                             'user_id' => $request->user_id,
    //                             'user_shop_id' => $user_shop->id,
    //                             'product_id' => $product->id,
    //                             'is_published' => 1,
    //                             'category_id' =>$request->category_id,
    //                             'sub_category_id' =>$request->sub_category,
    //                             'price' => $product->price,
    //                             'parent_shop_id' => 0,
    //                             'images' => count($arr_images) > 0 ? implode(',',$arr_images) : null,
    //                             'artwork_url' => $request->artwork_url,
    //                             'material' => $request->material,

    //                         ]);

    //                         if (isset($request->manage_inventory) && $request->manage_inventory == 1) {
    //                             Inventory::create([
    //                                 'user_shop_item_id' => $usi->id,
    //                                 'user_id' => $request->user_id,
    //                                 'tandA' => '',
    //                                 'product_id' => $product->id,
    //                                 'product_sku' => $product->sku,
    //                                 'stock' => 0,
    //                                 'stock_by_size' => null,
    //                                 'stock_by_color' => null,
    //                                 'parent_id' => null,
    //                             ]);

    //                         }

    //                     }
    //                 }
    //            }elseif($request->has('sizes')){
    //                 foreach ($request->sizes as $size) {
    //                     $unique_slug  = getUniqueProductSlug($request->title);

    //                     $request['color'] = null;
    //                     $request['size'] = $size;
    //                     $request['slug'] = $unique_slug;
    //                     $product = Product::create($request->all());

    //                     if($file_lock == 0){
    //                         if(request()->has('img') && count($request->file('img')) > 0){
    //                             foreach($files as $tempimg){
    //                                 $img = $this->uploadFile($tempimg, "products")->getFilePath();
    //                                 $filename = generateRandomStringNative(6).$tempimg->getClientOriginalName();
    //                                 $extension = pathinfo($filename, PATHINFO_EXTENSION);
    //                                 if($filename != null){
    //                                   $media =  Media::create([
    //                                         'type' => 'Product',
    //                                         'type_id' => $product->id,
    //                                         'file_name' => $filename,
    //                                         'path' => $img,
    //                                         'extension' => $extension,
    //                                         'file_type' => "Image",
    //                                         'tag' => "Product_Image",
    //                                     ]);
    //                                     $file_lock_data[] =  ['m_id'=>$media->id];
    //                                     $arr_images[] = $media->id;
    //                                 }
    //                             }
    //                         }
    //                         $file_lock = 1;
    //                     }else{
    //                         if(count($file_lock_data) > 0){
    //                             foreach ($file_lock_data as $key => $file_lock_data_item) {
    //                                 $media_old =  Media::whereId($file_lock_data_item)->first();
    //                                 $media =  Media::create([
    //                                       'type' => 'Product',
    //                                       'type_id' => $product->id,
    //                                       'file_name' => $media_old->file_name,
    //                                       'path' => $media_old->path,
    //                                       'extension' => $media_old->extension,
    //                                       'file_type' => "Image",
    //                                       'tag' => "Product_Image",
    //                                   ]);
    //                                   $arr_images[] = $media->id;
    //                             }
    //                           }
    //                     }
    //                         // Create Microsite Item Record is self upload
    //                     if(AuthRole() == "User"){
    //                         $my_groups = Group::where('user_id',auth()->id())->get();
    //                         foreach($my_groups as $group){
    //                             $gp = new GroupProduct();
    //                             $gp->group_id = $group->id;
    //                             $gp->product_id = $product->id;
    //                             $gp->price = $product->price??0;
    //                             $gp->save();
    //                         }
    //                         $usi = UserShopItem::create([
    //                             'user_id' => $request->user_id,
    //                             'user_shop_id' => $user_shop->id,
    //                             'product_id' => $product->id,
    //                             'is_published' => 1,
    //                             'category_id' =>$request->category_id,
    //                             'sub_category_id' =>$request->sub_category,
    //                             'price' => $product->price,
    //                             'parent_shop_id' => 0,
    //                             'images' => count($arr_images) > 0 ? implode(',',$arr_images) : null,
    //                             'artwork_url' => $request->artwork_url,
    //                             'material' => $request->material,
    //                         ]);

    //                         if (isset($request->manage_inventory) && $request->manage_inventory == 1) {
    //                             Inventory::create([
    //                                 'user_shop_item_id' => $usi->id,
    //                                 'user_id' => $request->user_id,
    //                                 'tandA' => '',
    //                                 'product_sku' => $product->sku,
    //                                 'product_id' => $product->id,
    //                                 'stock' => 0,
    //                                 'stock_by_size' => null,
    //                                 'stock_by_color' => null,
    //                                 'parent_id' => null,
    //                             ]);
    //                         }


    //                     }
    //                 }
    //            }else{

    //                 $unique_slug  = getUniqueProductSlug($request->title);

    //                 $request['color'] = null;
    //                 $request['size'] = null;
    //                 $request['slug'] = $unique_slug;
    //                 $product = Product::create($request->all());


    //                 if($request->hasFile("img")){
    //                     foreach($request->file('img') as $tempimg){
    //                         $img = $this->uploadFile($tempimg, "products")->getFilePath();
    //                         $filename = $tempimg->getClientOriginalName();
    //                         $extension = pathinfo($filename, PATHINFO_EXTENSION);
    //                         if($filename != null){
    //                             $media = Media::create([
    //                                 'type' => 'Product',
    //                                 'type_id' => $product->id,
    //                                 'file_name' => $filename,
    //                                 'path' => $img,
    //                                 'extension' => $extension,
    //                                 'file_type' => "Image",
    //                                 'tag' => "Product_Image",
    //                             ]);
    //                             $arr_images[] = $media->id;
    //                         }
    //                     }
    //                 }
    //                 // Create Microsite Item Record is self upload
    //                 if(AuthRole() == "User"){
    //                     $my_groups = Group::where('user_id',auth()->id())->get();
    //                     foreach($my_groups as $group){
    //                         $gp = new GroupProduct();
    //                         $gp->group_id = $group->id;
    //                         $gp->product_id = $product->id;
    //                         $gp->price = $product->price??0;
    //                         $gp->save();
    //                     }

    //                     $usi = UserShopItem::create([
    //                         'user_id' => $request->user_id,
    //                         'user_shop_id' => $user_shop->id,
    //                         'product_id' => $product->id,
    //                         'is_published' => 1,
    //                         'category_id' =>$request->category_id,
    //                         'sub_category_id' =>$request->sub_category,
    //                         'price' => $product->price,
    //                         'parent_shop_id' => 0,
    //                         'images' => count($arr_images) > 0 ? implode(',',$arr_images) : null,
    //                         'artwork_url' => $request->artwork_url,
    //                         'material' => $request->material,
    //                     ]);
    //                     if (isset($request->manage_inventory) && $request->manage_inventory == 1) {
    //                         Inventory::create([
    //                             'user_shop_item_id' => $usi->id,
    //                             'user_id' => $request->user_id,
    //                             'product_id' => $product->id,
    //                             'tandA' => '',
    //                             'product_sku' => $product->sku,
    //                             'stock' => 0,
    //                             'stock_by_size' => null,
    //                             'stock_by_color' => null,
    //                             'parent_id' => null,
    //                         ]);

    //                     }

    //                 }

    //            }


    //            if($request->btn1 != null && $request->btn1 == 1){
    //                 if($request->brand_id == 0){
    //                     return redirect(route('panel.products.create',['action'=>'nonbranded']))->with('success','Product created. Visit Shop > Price group to update.');
    //                 }else{
    //                     return redirect(route('panel.products.create',['action'=>'branded','id'=>$request->brand_id]))->with('success','Product created. Visit Shop > Price group to update.');
    //                 }
    //             }else{
    //                 if($request->brand_id == 0){
    //                     return redirect(route('panel.user_shop_items.create',['type'=>'direct','type_id'=>$request->user_id]))->with('success','Product created. Visit Shop > Price group to update.');
    //                 }else{
    //                     return redirect(route('panel.products.index',['action'=>'branded','id'=>$request->brand_id]))->with('success','Product created. Visit Shop > Price group to update.');
    //                 }
    //            }
    //     }catch(Exception $e){
    //         return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
    //     }
    // }


    public function store(Request $request)
    {
        // return back()->withInput($request->all());
        // $request['properties_varient'] = ['Material','Colour','Size'];


        $any_value = [];
        $substring = "any_value";

        // magicstring(request()->all());
        // return;

        foreach ($request->all() as $key => $value) {
            if (strpos($key, $substring) !== false) {
                array_push($any_value,$key);

                if (is_array($request->$key)) {
                    $request[$key] = implode("x",$request->$key);
                }



                // checking Value Exist or Not
                $attribute_name = explode("-",$key)[1];

                $chkCountAttr = ProductAttribute::where('name',$attribute_name)->where('user_id',auth()->id())->get();


                if ($chkCountAttr->count() == 0) {
                    $attribute_name = str_replace("_"," ",$attribute_name);
                    $chkCountAttr = ProductAttribute::where('name',$attribute_name)->where('user_id',auth()->id())->get();
                }


                if ($chkCountAttr->count() != 0) {
                    $attribute_id = $chkCountAttr[0]->id;
                    $received_value = $request->$key;

                    if ($received_value != null && $received_value != "" && $received_value != []) {
                        $chkatt = ProductAttributeValue::where('parent_id',$attribute_id)->where('attribute_value',$received_value)->first();

                        if ($chkatt == null) {
                            $tmparrvar = ProductAttributeValue::create([
                                'parent_id' => $attribute_id,
                                'user_id' => auth()->id() ?? null,
                                'attribute_value' => $received_value,
                            ]);

                            $request[$attribute_name] = array($tmparrvar->id);

                        }else{
                            // magicstring($chkatt);
                            $request[$attribute_name] = array($chkatt->id);

                        }
                    }
                }else{
                    echo "Else Part Will Work";
                }
            }
        }


        // return;

        // foreach ($any_value as $ashu) {
        //     $attribute_name = explode("-",$key)[1];
        //     $request[$attribute_name] = array($request->get($ashu));
        // }

        $user = auth()->user();
        $custom_attriute_columns = json_decode($user->custom_attriute_columns);

        // magicstring($custom_attriute_columns);


        // magicstring($request->all());
        // return;


        try {
            $allowed_array = ['yes',"Yes","YES",'1'];
            $count = 0;
            $file_lock = 0;
            $arr_images = [];
            $user = auth()->user();
            $user_shop = getShopDataByUserId($user->id);
            $loop1 = [];
            $loop2 = [];
            $loop3 = [];
            $product_id = '';

            $user_id = auth()->user()->id;
            $folderPath = "public/files/$user_id";

            if ($request->properties_varient != null && $request->properties_varient != []) {
                $variation_count = count($request->properties_varient);
            }else{
                $variation_count = 0;
            }

           if ($variation_count != 0) {
            foreach ($request->properties_varient as $key => $value) {
                ${'loop'.($key+1)} = $request->get(str_replace(" ","_",$value));
                unset($request[str_replace(" ","_",$value)]);
                echo $value.newline();
            }
           }


            if(AuthRole() == "User"){
                if(!$request->sku){
                    $sku = 'SKU'.generateRandomStringNative(4);
                    $request['sku'] = $sku;
                }else{
                    $request['sku'] = $request->sku;
                }
            }


            $chkexist = Product::where('model_code',$request->model_code)->get();

            if ($chkexist->count() != 0) {
                $sku_code = $chkexist[0]->sku;
            }else{
                $sku_code = $request->sku;
            }

            $price = $request->customer_price_without_gst;
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


            $custom_attriute_columns = json_decode($user->custom_attriute_columns);

            if($loop1 != [] && $loop2 != [] && $loop3 != []) {
                $Productids_array = [];
                foreach ($loop1 as $key1 => $first) {
                    foreach ($loop2 as $key2 => $second) {
                        foreach ($loop3 as $key3 => $third) {

                            echo $first."-"."$second"."-".$third.newline(2);
                            $count++;
                            $reseller_group = Group::whereUserId($user->id)->where('name',"Reseller")->first();
                            if(!$reseller_group){
                                $reseller_group = Group::create([
                                        'user_id' => $user->id,
                                        'name' => "Reseller",
                                        'type' => 0,
                                    ]);
                            }

                            $vip_group = Group::whereUserId($user->id)->where('name',"VIP")->first();
                            if(!$vip_group){
                                $vip_group =  Group::create([
                                    'user_id' => $user->id,
                                    'name' => "VIP",
                                    'type' => 0,
                                ]);
                            }

                            $unique_slug  = getUniqueProductSlug($request->title);
                            $product_obj =  [
                                'title' => $request->title,
                                'model_code' => $request->model_code,
                                'category_id' => $request->category_id,
                                'sub_category' => $request->sub_category,
                                'brand_id' => 0,
                                'user_id' => auth()->id(),
                                'sku' => $sku_code,
                                'slug' => $unique_slug,
                                'description' => $request->description,
                                'carton_details' =>  $request->carton_details,
                                'shipping' =>  $request->shipping,
                                'manage_inventory' => (in_array($request->sample_available,$allowed_array) ? '1' : '0') ?? '0',
                                'stock_qty' => 0,
                                'status' => 0,
                                // 'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                                'is_publish' => 1,
                                'price' => $request->customer_price_without_gst ?? 0,
                                'min_sell_pr_without_gst' => $request->customer_price_without_gst ?? 0,
                                'hsn' => $request->hsn ?? null,
                                'hsn_percent' => $request->hsn_percent ?? null,
                                'mrp' => $request->mrp ?? 0,
                                'video_url' => $request->video_url ?? null,
                                'search_keywords' => $request->search_keywords ?? null,
                                'artwork_url' => $request->artwork_url ?? null,
                                'exclusive' => 0,
                                'base_currency' => $request->base_currency ?? 'INR',
                                'SellingPriceUnitIndex' => $request->selling_price_unit ?? null,
                                // 'archive' => (in_array($item[$ArchiveIndex],$allowed_array)) ? 1 : 0,
                            ];

                            $product_obj = Product::create($product_obj);


                            $product = $product_obj;

                            $custom_fields = json_decode($user->custom_fields);
                            if ($custom_fields != null && count($custom_fields) > 0) {
                                foreach ($custom_fields as $key => $customfield) {

                                    $ogname = $customfield->id;
                                    $customfield = str_replace("[]",'',$customfield->id);
                                    if (is_array($request->get($customfield)) || is_html($request->get($customfield))) {

                                        echo "' $ogname ' It is an Array or HTML.".newline();
                                        $updatevalue = base64_encode(json_encode($request->get($customfield)));

                                    }else{
                                        // $customfield = str_replace("[]",'',$customfield);
                                        $updatevalue = $request->get($customfield);
                                    }

                                    $custom_field = CustomFields::where('relatation_name',$ogname)->where('product_id',$product->id)->first();
                                    if ($custom_field == null) {
                                        echo "Create New Records".newline(2);
                                        CustomFields::create([
                                            'relatation_name' => $ogname,
                                            'product_id' => $product_obj->id,
                                            'value' => $updatevalue ?? '',
                                            'user_id' => auth()->id(),
                                        ]);
                                    }else{
                                        echo "Record Are Exist Update It".newline(2);

                                        $custom_field->update([
                                            'value' => $updatevalue ?? '',
                                        ]);
                                    }
                                }
                            }



                            $product_id = $product_obj->id;
                            $parentAttribute = ProductAttributeValue::whereId($third)->first();

                            $product_extra_info_obj_user = [
                                'product_id' => $product_obj->id,
                                'user_id' => $user->id,
                                'user_shop_id' => $user_shop->id,
                                'allow_resellers' => 'no',
                                'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                                'collection_name' =>$request->collection_name ?? '',
                                'season_month' => $request->season_month ?? '',
                                'season_year' => $request->season_year ?? '',
                                'sample_available' => 0,
                                'sample_year' => $request->sample_year ?? '',
                                'sample_month' => $request->sample_month ?? '',
                                'sampling_time' => $request->sampling_time ?? '',
                                'CBM' => $request->CBM ?? '',
                                'production_time' => $request->production_time ?? '',
                                'MBQ' => $request->MBQ ?? '',
                                'MBQ_unit' => $request->MBQ_unit ?? '',
                                'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                                'vendor_price' => $request->vendor_price ?? '',
                                'product_cost_unit' => $request->product_cost_unit ?? '',
                                'vendor_currency' => $request->vendor_currency ?? '',
                                'sourcing_year' => $request->sourcing_year ?? '',
                                'sourcing_month' => $request->sourcing_month ?? '',
                                'attribute_value_id' => $third,
                                'attribute_id' => $parentAttribute->parent_id,
                                // 'attribute_value_id' => $product_att_val->attribute_value,
                                // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                'group_id' => $sku_code,
                                'Cust_tag_group' => $request->sourcing_month ?? '',
                                'remarks' =>  $request->remarks ?? '' ,
                                'brand_name' => $request->brand_name ?? '',
                            ];

                            ProductExtraInfo::create($product_extra_info_obj_user);


                            // ` Craeting Variation of Non Defined Attribute
                            foreach ($custom_attriute_columns as $key => $custom_attriute) {
                                $valueasd = '';
                                $custom_attriute = str_replace(" ","_",$custom_attriute);
                                if ($request->has($custom_attriute)) {
                                    $valueasd = $request->get($custom_attriute);
                                    $parentAttribute = ProductAttributeValue::whereId($valueasd[0])->first();

                                    $product_extra_info_obj_user = [
                                        'product_id' => $product_obj->id,
                                        'user_id' => $user->id,
                                        'user_shop_id' => $user_shop->id,
                                        'allow_resellers' => 'no',
                                        'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                                        'collection_name' =>$request->collection_name ?? '',
                                        'season_month' => $request->season_month ?? '',
                                        'season_year' => $request->season_year ?? '',
                                        'sample_available' => 0,
                                        'sample_year' => $request->sample_year ?? '',
                                        'sample_month' => $request->sample_month ?? '',
                                        'sampling_time' => $request->sampling_time ?? '',
                                        'CBM' => $request->CBM ?? '',
                                        'production_time' => $request->production_time ?? '',
                                        'MBQ' => $request->MBQ ?? '',
                                        'MBQ_unit' => $request->MBQ_unit ?? '',
                                        'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                                        'vendor_price' => $request->vendor_price ?? '',
                                        'product_cost_unit' => $request->product_cost_unit ?? '',
                                        'vendor_currency' => $request->vendor_currency ?? '',
                                        'sourcing_year' => $request->sourcing_year ?? '',
                                        'sourcing_month' => $request->sourcing_month ?? '',
                                        'attribute_value_id' => $parentAttribute->id,
                                        'attribute_id' => $parentAttribute->parent_id,
                                        // 'attribute_value_id' => $product_att_val->attribute_value,
                                        // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                        'group_id' => $sku_code,
                                        'Cust_tag_group' => $request->sourcing_month ?? '',
                                        'remarks' =>  $request->remarks ?? '' ,
                                        'brand_name' => $request->brand_name ?? '',
                                    ];
                                    ProductExtraInfo::create($product_extra_info_obj_user);
                                }
                            }

                            $usi = UserShopItem::create([
                                'user_id'=> $user->id,
                                'category_id'=> $request->category_id,
                                'sub_category_id'=> $request->category_id,
                                'product_id'=> $product_obj->id,
                                'user_shop_id'=> $user_shop->id,
                                'parent_shop_id'=> 0,
                                'is_published'=> 1,
                                'price'=> $price,
                            ]);

                            if($reseller_group){
                                // create Reseller Group record
                                $g_p =  GroupProduct::create([
                                    'group_id'=>$reseller_group->id,
                                    'product_id'=>$product_obj->id,
                                    'price'=> $request->reseller_price ?? 0,
                                ]);
                            }

                            if($vip_group){
                                // create Vip Group record
                                GroupProduct::create([
                                    'group_id'=>$vip_group->id,
                                    'product_id'=>$product_obj->id,
                                    'price'=> $request->vip_price ?? 0,
                                ]);
                            }

                            if ($request->hasFile('img')) {
                                $arr_images = [];
                                // * Start Creating Media...

                                foreach ($request->img as $key => $image) {
                                    if($image != null){
                                        // Uploading File
                                        $filename = $image->getClientOriginalName();

                                        $path = $image->storeAs($folderPath, $filename);

                                        // Creating FIle link
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $image->getClientOriginalName();
                                        $media->path = str_replace("public",'storage',$path);
                                        $media->extension = explode('.',$image->getClientOriginalName())[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                }

                                // Add images to UserShopItem
                                if(count($arr_images) > 0) {
                                    $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                    $usi->save();
                                }
                            }


                            if($request->avl_assets != null){
                                foreach (explode(",",$request->avl_assets) as $key => $value) {
                                    Media::whereId($value)->first()->replicate()->fill([
                                        'type' => 'Product',
                                        'type_id' => $product_obj->id,
                                    ])->save();
                                }
                            }


                            if($request->avl_assets != null){
                                foreach (explode(",",$request->avl_assets) as $key => $value) {
                                    Media::whereId($value)->first()->replicate()->fill([
                                        'type' => 'Product',
                                        'type_id' => $product_obj->id,
                                    ])->save();
                                }
                            }



                            if ($usi->images != null) {
                                $usi->images =  $usi->images.",".$request->exist_img.",".$request->avl_assets ?? null;
                            }else{
                                $usi->images =  $request->exist_img.",".$request->avl_assets ?? null;
                            }

                            $usi->save();
                        }

                        $parentAttribute = ProductAttributeValue::whereId($second)->first();

                        $product_extra_info_obj_user = [
                            'product_id' => $product_obj->id,
                            'user_id' => $user->id,
                            'user_shop_id' => $user_shop->id,
                            'allow_resellers' => 'no',
                            'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                            'collection_name' =>$request->collection_name ?? '',
                            'season_month' => $request->season_month ?? '',
                            'season_year' => $request->season_year ?? '',
                            'sample_available' => 0,
                            'sample_year' => $request->sample_year ?? '',
                            'sample_month' => $request->sample_month ?? '',
                            'sampling_time' => $request->sampling_time ?? '',
                            'CBM' => $request->CBM ?? '',
                            'production_time' => $request->production_time ?? '',
                            'MBQ' => $request->MBQ ?? '',
                            'MBQ_unit' => $request->MBQ_unit ?? '',
                            'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                            'vendor_price' => $request->vendor_price ?? '',
                            'product_cost_unit' => $request->product_cost_unit ?? '',
                            'vendor_currency' => $request->vendor_currency ?? '',
                            'sourcing_year' => $request->sourcing_year ?? '',
                            'sourcing_month' => $request->sourcing_month ?? '',
                            'attribute_value_id' => $second,
                            'attribute_id' => $parentAttribute->parent_id,
                            // 'attribute_value_id' => $product_att_val->attribute_value,
                            // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                            'group_id' => $sku_code,
                            'Cust_tag_group' => $request->sourcing_month ?? '',
                            'remarks' =>  $request->remarks ?? '' ,
                            'brand_name' => $request->brand_name ?? '',
                        ];

                        ProductExtraInfo::create($product_extra_info_obj_user);

                    }
                    $parentAttribute = ProductAttributeValue::whereId($first)->first();

                    $product_extra_info_obj_user = [
                        'product_id' => $product_obj->id,
                        'user_id' => $user->id,
                        'user_shop_id' => $user_shop->id,
                        'allow_resellers' => 'no',
                        'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                        'collection_name' =>$request->collection_name ?? '',
                        'season_month' => $request->season_month ?? '',
                        'season_year' => $request->season_year ?? '',
                        'sample_available' => 0,
                        'sample_year' => $request->sample_year ?? '',
                        'sample_month' => $request->sample_month ?? '',
                        'sampling_time' => $request->sampling_time ?? '',
                        'CBM' => $request->CBM ?? '',
                        'production_time' => $request->production_time ?? '',
                        'MBQ' => $request->MBQ ?? '',
                        'MBQ_unit' => $request->MBQ_unit ?? '',
                        'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                        'vendor_price' => $request->vendor_price ?? '',
                        'product_cost_unit' => $request->product_cost_unit ?? '',
                        'vendor_currency' => $request->vendor_currency ?? '',
                        'sourcing_year' => $request->sourcing_year ?? '',
                        'sourcing_month' => $request->sourcing_month ?? '',
                        'attribute_value_id' => $first,
                        'attribute_id' => $parentAttribute->parent_id,
                        // 'attribute_value_id' => $product_att_val->attribute_value,
                        // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                        'group_id' => $sku_code,
                        'Cust_tag_group' => $request->sourcing_month ?? '',
                        'remarks' =>  $request->remarks ?? '' ,
                        'brand_name' => $request->brand_name ?? '',
                    ];

                    ProductExtraInfo::create($product_extra_info_obj_user);

                    $count++;
                }

            }
            elseif($loop1 != [] && $loop2 != []) {
                $Productids_array = [];
                foreach ($loop1 as $key2 => $second) {
                    foreach ($loop2 as $key3 => $third) {

                        // echo $first."-"."$second"."-".$third.newline(2);
                        $count++;
                        $reseller_group = Group::whereUserId($user->id)->where('name',"Reseller")->first();
                        if(!$reseller_group){
                            $reseller_group = Group::create([
                                    'user_id' => $user->id,
                                    'name' => "Reseller",
                                    'type' => 0,
                                ]);
                        }

                        $vip_group = Group::whereUserId($user->id)->where('name',"VIP")->first();
                        if(!$vip_group){
                            $vip_group =  Group::create([
                                'user_id' => $user->id,
                                'name' => "VIP",
                                'type' => 0,
                            ]);
                        }

                        $unique_slug  = getUniqueProductSlug($request->title);
                        $product_obj =  [
                            'title' => $request->title,
                            'model_code' => $request->model_code,
                            'category_id' => $request->category_id,
                            'sub_category' => $request->sub_category,
                            'brand_id' => 0,
                            'user_id' => auth()->id(),
                            'sku' => $sku_code,
                            'slug' => $unique_slug,
                            'description' => $request->description,
                            'carton_details' =>  $request->carton_details,
                            'shipping' =>  $request->shipping,
                            'manage_inventory' => (in_array($request->sample_available,$allowed_array) ? '1' : '0') ?? '0',
                            'stock_qty' => 0,
                            'status' => 0,
                            // 'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                            'is_publish' => 1,
                            'price' => $request->customer_price_without_gst ?? 0,
                            'min_sell_pr_without_gst' => $request->customer_price_without_gst ?? 0,
                            'hsn' => $request->hsn ?? null,
                            'hsn_percent' => $request->hsn_percent ?? null,
                            'mrp' => $request->mrp ?? 0,
                            'video_url' => $request->video_url ?? null,
                            'search_keywords' => $request->search_keywords ?? null,
                            'artwork_url' => $request->artwork_url ?? null,
                            'exclusive' => 0,
                            'base_currency' => $request->base_currency ?? 'INR',
                            'SellingPriceUnitIndex' => $request->selling_price_unit ?? null,
                            // 'archive' => (in_array($item[$ArchiveIndex],$allowed_array)) ? 1 : 0,
                        ];

                        $product_obj = Product::create($product_obj);
                        $product_id = $product_obj->id;

                        $product = $product_obj;

                        $custom_fields = json_decode($user->custom_fields);
                        if ($custom_fields != null && count($custom_fields) > 0) {
                            foreach ($custom_fields as $key => $customfield) {

                                $ogname = $customfield->id;
                                $customfield = str_replace("[]",'',$customfield->id);
                                if (is_array($request->get($customfield)) || is_html($request->get($customfield))) {

                                    echo "' $ogname ' It is an Array or HTML.".newline();
                                    $updatevalue = base64_encode(json_encode($request->get($customfield)));

                                }else{
                                    // $customfield = str_replace("[]",'',$customfield);
                                    $updatevalue = $request->get($customfield);
                                }

                                $custom_field = CustomFields::where('relatation_name',$ogname)->where('product_id',$product->id)->first();
                                if ($custom_field == null) {
                                    echo "Create New Records".newline(2);
                                    CustomFields::create([
                                        'relatation_name' => $ogname,
                                        'product_id' => $product_obj->id,
                                        'value' => $updatevalue ?? '',
                                        'user_id' => auth()->id(),
                                    ]);
                                }else{
                                    echo "Record Are Exist Update It".newline(2);

                                    $custom_field->update([
                                        'value' => $updatevalue ?? '',
                                    ]);
                                }
                            }
                        }



                        $parentAttribute = ProductAttributeValue::whereId($third)->first();

                        $product_extra_info_obj_user = [
                            'product_id' => $product_obj->id,
                            'user_id' => $user->id,
                            'user_shop_id' => $user_shop->id,
                            'allow_resellers' => 'no',
                            'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                            'collection_name' =>$request->collection_name ?? '',
                            'season_month' => $request->season_month ?? '',
                            'season_year' => $request->season_year ?? '',
                            'sample_available' => 0,
                            'sample_year' => $request->sample_year ?? '',
                            'sample_month' => $request->sample_month ?? '',
                            'sampling_time' => $request->sampling_time ?? '',
                            'CBM' => $request->CBM ?? '',
                            'production_time' => $request->production_time ?? '',
                            'MBQ' => $request->MBQ ?? '',
                            'MBQ_unit' => $request->MBQ_unit ?? '',
                            'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                            'vendor_price' => $request->vendor_price ?? '',
                            'product_cost_unit' => $request->product_cost_unit ?? '',
                            'vendor_currency' => $request->vendor_currency ?? '',
                            'sourcing_year' => $request->sourcing_year ?? '',
                            'sourcing_month' => $request->sourcing_month ?? '',
                            'attribute_value_id' => $third,
                            'attribute_id' => $parentAttribute->parent_id,
                            // 'attribute_value_id' => $product_att_val->attribute_value,
                            // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                            'group_id' => $sku_code,
                            'Cust_tag_group' => $request->sourcing_month ?? '',
                            'remarks' =>  $request->remarks ?? '' ,
                            'brand_name' => $request->brand_name ?? '',
                        ];

                        ProductExtraInfo::create($product_extra_info_obj_user);


                        // ` Craeting Variation of Non Defined Attribute
                        foreach ($custom_attriute_columns as $key => $custom_attriute) {
                            $valueasd = '';
                            $custom_attriute = str_replace(" ","_",$custom_attriute);
                            if ($request->has($custom_attriute)) {
                                $valueasd = $request->get($custom_attriute);
                                $parentAttribute = ProductAttributeValue::whereId($valueasd[0])->first();

                                $product_extra_info_obj_user = [
                                    'product_id' => $product_obj->id,
                                    'user_id' => $user->id,
                                    'user_shop_id' => $user_shop->id,
                                    'allow_resellers' => 'no',
                                    'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                                    'collection_name' =>$request->collection_name ?? '',
                                    'season_month' => $request->season_month ?? '',
                                    'season_year' => $request->season_year ?? '',
                                    'sample_available' => 0,
                                    'sample_year' => $request->sample_year ?? '',
                                    'sample_month' => $request->sample_month ?? '',
                                    'sampling_time' => $request->sampling_time ?? '',
                                    'CBM' => $request->CBM ?? '',
                                    'production_time' => $request->production_time ?? '',
                                    'MBQ' => $request->MBQ ?? '',
                                    'MBQ_unit' => $request->MBQ_unit ?? '',
                                    'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                                    'vendor_price' => $request->vendor_price ?? '',
                                    'product_cost_unit' => $request->product_cost_unit ?? '',
                                    'vendor_currency' => $request->vendor_currency ?? '',
                                    'sourcing_year' => $request->sourcing_year ?? '',
                                    'sourcing_month' => $request->sourcing_month ?? '',
                                    'attribute_value_id' => $parentAttribute->id,
                                    'attribute_id' => $parentAttribute->parent_id,
                                    // 'attribute_value_id' => $product_att_val->attribute_value,
                                    // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                    'group_id' => $sku_code,
                                    'Cust_tag_group' => $request->sourcing_month ?? '',
                                    'remarks' =>  $request->remarks ?? '' ,
                                    'brand_name' => $request->brand_name ?? '',
                                ];
                                ProductExtraInfo::create($product_extra_info_obj_user);
                            }
                        }

                        $usi = UserShopItem::create([
                            'user_id'=> $user->id,
                            'category_id'=> $request->category_id,
                            'sub_category_id'=> $request->category_id,
                            'product_id'=> $product_obj->id,
                            'user_shop_id'=> $user_shop->id,
                            'parent_shop_id'=> 0,
                            'is_published'=> 1,
                            'price'=> $price,
                        ]);

                        if($reseller_group){
                            // create Reseller Group record
                            $g_p =  GroupProduct::create([
                                'group_id'=>$reseller_group->id,
                                'product_id'=>$product_obj->id,
                                'price'=> $request->reseller_price ?? 0,
                            ]);
                        }

                        if($vip_group){
                            // create Vip Group record
                            GroupProduct::create([
                                'group_id'=>$vip_group->id,
                                'product_id'=>$product_obj->id,
                                'price'=> $request->vip_price ?? 0,
                            ]);
                        }



                        if ($request->hasFile('img')) {
                            $arr_images = [];
                            // * Start Creating Media...
                            foreach ($request->img as $key => $image) {
                                if($image != null){
                                    // Uploading File
                                    $filename = $image->getClientOriginalName();
                                    $path = $image->storeAs($folderPath, $filename);

                                    // Creating FIle link
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $product_obj->id;
                                    $media->file_name = $image->getClientOriginalName();
                                    $media->path = str_replace("public",'storage',$path);
                                    $media->extension = explode('.',$image->getClientOriginalName())[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                            }

                            // Add images to UserShopItem
                            if(count($arr_images) > 0) {
                                $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                $usi->save();
                            }

                        }

                        if($request->avl_assets != null){
                            foreach (explode(",",$request->avl_assets) as $key => $value) {
                                Media::whereId($value)->first()->replicate()->fill([
                                    'type' => 'Product',
                                    'type_id' => $product_obj->id,
                                ])->save();
                            }
                        }


                        if ($usi->images) {
                            $usi->images =  $usi->images.",".$request->exist_img.",".$request->avl_assets ?? null;
                        }else{
                            $usi->images =  $request->exist_img.",".$request->avl_assets ?? null;
                        }

                        $usi->save();

                    }

                    $parentAttribute = ProductAttributeValue::whereId($second)->first();

                    $product_extra_info_obj_user = [
                        'product_id' => $product_obj->id,
                        'user_id' => $user->id,
                        'user_shop_id' => $user_shop->id,
                        'allow_resellers' => 'no',
                        'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                        'collection_name' =>$request->collection_name ?? '',
                        'season_month' => $request->season_month ?? '',
                        'season_year' => $request->season_year ?? '',
                        'sample_available' => 0,
                        'sample_year' => $request->sample_year ?? '',
                        'sample_month' => $request->sample_month ?? '',
                        'sampling_time' => $request->sampling_time ?? '',
                        'CBM' => $request->CBM ?? '',
                        'production_time' => $request->production_time ?? '',
                        'MBQ' => $request->MBQ ?? '',
                        'MBQ_unit' => $request->MBQ_unit ?? '',
                        'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                        'vendor_price' => $request->vendor_price ?? '',
                        'product_cost_unit' => $request->product_cost_unit ?? '',
                        'vendor_currency' => $request->vendor_currency ?? '',
                        'sourcing_year' => $request->sourcing_year ?? '',
                        'sourcing_month' => $request->sourcing_month ?? '',
                        'attribute_value_id' => $second,
                        'attribute_id' => $parentAttribute->parent_id,
                        // 'attribute_value_id' => $product_att_val->attribute_value,
                        // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                        'group_id' => $sku_code,
                        'Cust_tag_group' => $request->sourcing_month ?? '',
                        'remarks' =>  $request->remarks ?? '' ,
                        'brand_name' => $request->brand_name ?? '',
                    ];

                    ProductExtraInfo::create($product_extra_info_obj_user);

                }
            }
            elseif($loop1 != []) {
                $Productids_array = [];
                foreach ($loop1 as $key3 => $third) {

                    // echo $first."-"."$second"."-".$third.newline(2);
                    $count++;
                    $reseller_group = Group::whereUserId($user->id)->where('name',"Reseller")->first();
                    if(!$reseller_group){
                        $reseller_group = Group::create([
                                'user_id' => $user->id,
                                'name' => "Reseller",
                                'type' => 0,
                            ]);
                    }

                    $vip_group = Group::whereUserId($user->id)->where('name',"VIP")->first();
                    if(!$vip_group){
                        $vip_group =  Group::create([
                            'user_id' => $user->id,
                            'name' => "VIP",
                            'type' => 0,
                        ]);
                    }

                    $unique_slug  = getUniqueProductSlug($request->title);
                    $product_obj =  [
                        'title' => $request->title,
                        'model_code' => $request->model_code,
                        'category_id' => $request->category_id,
                        'sub_category' => $request->sub_category,
                        'brand_id' => 0,
                        'user_id' => auth()->id(),
                        'sku' => $sku_code,
                        'slug' => $unique_slug,
                        'description' => $request->description,
                        'carton_details' =>  $request->carton_details,
                        'shipping' =>  $request->shipping,
                        'manage_inventory' => (in_array($request->sample_available,$allowed_array) ? '1' : '0') ?? '0',
                        'stock_qty' => 0,
                        'status' => 0,
                        // 'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                        'is_publish' => 1,
                        'price' => $request->customer_price_without_gst ?? 0,
                        'min_sell_pr_without_gst' => $request->customer_price_without_gst ?? 0,
                        'hsn' => $request->hsn ?? null,
                        'hsn_percent' => $request->hsn_percent ?? null,
                        'mrp' => $request->mrp ?? 0,
                        'video_url' => $request->video_url ?? null,
                        'search_keywords' => $request->search_keywords ?? null,
                        'artwork_url' => $request->artwork_url ?? null,
                        'exclusive' => 0,
                        'base_currency' => $request->base_currency ?? 'INR',
                        'SellingPriceUnitIndex' => $request->selling_price_unit ?? null,
                        // 'archive' => (in_array($item[$ArchiveIndex],$allowed_array)) ? 1 : 0,
                    ];

                    $product_obj = Product::create($product_obj);

                    $product_id = $product_obj->id;

                    $product = $product_obj;

                    $custom_fields = json_decode($user->custom_fields);
                    if ($custom_fields != null && count($custom_fields) > 0) {
                        foreach ($custom_fields as $key => $customfield) {

                            $ogname = $customfield->id;
                            $customfield = str_replace("[]",'',$customfield->id);
                            if (is_array($request->get($customfield)) || is_html($request->get($customfield))) {

                                echo "' $ogname ' It is an Array or HTML.".newline();
                                $updatevalue = base64_encode(json_encode($request->get($customfield)));

                            }else{
                                // $customfield = str_replace("[]",'',$customfield);
                                $updatevalue = $request->get($customfield);
                            }

                            $custom_field = CustomFields::where('relatation_name',$ogname)->where('product_id',$product->id)->first();
                            if ($custom_field == null) {
                                echo "Create New Records".newline(2);
                                CustomFields::create([
                                    'relatation_name' => $ogname,
                                    'product_id' => $product_obj->id,
                                    'value' => $updatevalue ?? '',
                                    'user_id' => auth()->id(),
                                ]);
                            }else{
                                echo "Record Are Exist Update It".newline(2);

                                $custom_field->update([
                                    'value' => $updatevalue ?? '',
                                ]);
                            }
                        }
                    }

                    $parentAttribute = ProductAttributeValue::whereId($third)->first();

                    $product_extra_info_obj_user = [
                        'product_id' => $product_obj->id,
                        'user_id' => $user->id,
                        'user_shop_id' => $user_shop->id,
                        'allow_resellers' => 'no',
                        'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                        'collection_name' =>$request->collection_name ?? '',
                        'season_month' => $request->season_month ?? '',
                        'season_year' => $request->season_year ?? '',
                        'sample_available' => 0,
                        'sample_year' => $request->sample_year ?? '',
                        'sample_month' => $request->sample_month ?? '',
                        'sampling_time' => $request->sampling_time ?? '',
                        'CBM' => $request->CBM ?? '',
                        'production_time' => $request->production_time ?? '',
                        'MBQ' => $request->MBQ ?? '',
                        'MBQ_unit' => $request->MBQ_unit ?? '',
                        'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                        'vendor_price' => $request->vendor_price ?? '',
                        'product_cost_unit' => $request->product_cost_unit ?? '',
                        'vendor_currency' => $request->vendor_currency ?? '',
                        'sourcing_year' => $request->sourcing_year ?? '',
                        'sourcing_month' => $request->sourcing_month ?? '',
                        'attribute_value_id' => $third,
                        'attribute_id' => $parentAttribute->parent_id,
                        // 'attribute_value_id' => $product_att_val->attribute_value,
                        // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                        'group_id' => $sku_code,
                        'Cust_tag_group' => $request->sourcing_month ?? '',
                        'remarks' =>  $request->remarks ?? '' ,
                        'brand_name' => $request->brand_name ?? '',
                    ];

                    ProductExtraInfo::create($product_extra_info_obj_user);


                    // ` Craeting Variation of Non Defined Attribute
                    foreach ($custom_attriute_columns as $key => $custom_attriute) {
                        $valueasd = '';
                        $custom_attriute = str_replace(" ","_",$custom_attriute);
                        if ($request->has($custom_attriute)) {
                            $valueasd = $request->get($custom_attriute);
                            $parentAttribute = ProductAttributeValue::whereId($valueasd[0])->first();

                            // echo $valueasd[0].newline(2);

                            // // echo "parentAttribute".newline(2);
                            // // magicstring($parentAttribute);

                            // continue;


                            $product_extra_info_obj_user = [
                                'product_id' => $product_obj->id,
                                'user_id' => $user->id,
                                'user_shop_id' => $user_shop->id,
                                'allow_resellers' => 'no',
                                'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                                'collection_name' =>$request->collection_name ?? '',
                                'season_month' => $request->season_month ?? '',
                                'season_year' => $request->season_year ?? '',
                                'sample_available' => 0,
                                'sample_year' => $request->sample_year ?? '',
                                'sample_month' => $request->sample_month ?? '',
                                'sampling_time' => $request->sampling_time ?? '',
                                'CBM' => $request->CBM ?? '',
                                'production_time' => $request->production_time ?? '',
                                'MBQ' => $request->MBQ ?? '',
                                'MBQ_unit' => $request->MBQ_unit ?? '',
                                'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                                'vendor_price' => $request->vendor_price ?? '',
                                'product_cost_unit' => $request->product_cost_unit ?? '',
                                'vendor_currency' => $request->vendor_currency ?? '',
                                'sourcing_year' => $request->sourcing_year ?? '',
                                'sourcing_month' => $request->sourcing_month ?? '',
                                'attribute_value_id' => $parentAttribute->id,
                                'attribute_id' => $parentAttribute->parent_id,
                                'group_id' => $sku_code,
                                'Cust_tag_group' => $request->sourcing_month ?? '',
                                'remarks' =>  $request->remarks ?? '' ,
                                'brand_name' => $request->brand_name ?? '',
                            ];
                            ProductExtraInfo::create($product_extra_info_obj_user);
                        }
                    }

                    // return;

                    $usi = UserShopItem::create([
                        'user_id'=> $user->id,
                        'category_id'=> $request->category_id,
                        'sub_category_id'=> $request->category_id,
                        'product_id'=> $product_obj->id,
                        'user_shop_id'=> $user_shop->id,
                        'parent_shop_id'=> 0,
                        'is_published'=> 1,
                        'price'=> $price,
                    ]);

                    if($reseller_group){
                        // create Reseller Group record
                        $g_p =  GroupProduct::create([
                            'group_id'=>$reseller_group->id,
                            'product_id'=>$product_obj->id,
                            'price'=> $request->reseller_price ?? 0,
                        ]);
                    }

                    if($vip_group){
                        // create Vip Group record
                        GroupProduct::create([
                            'group_id'=>$vip_group->id,
                            'product_id'=>$product_obj->id,
                            'price'=> $request->vip_price ?? 0,
                        ]);
                    }



                    if ($request->hasFile('img')) {
                        $arr_images = [];
                        // * Start Creating Media...
                        foreach ($request->img as $key => $image) {
                            if($image != null){
                                // Uploading File
                                $filename = $image->getClientOriginalName();

                                $path = $image->storeAs($folderPath, $filename);

                                // Creating FIle link
                                $media = new Media();
                                $media->tag = "Product_Image";
                                $media->file_type = "Image";
                                $media->type = "Product";
                                $media->type_id = $product_obj->id;
                                $media->file_name = $image->getClientOriginalName();
                                $media->path = str_replace("public",'storage',$path);
                                $media->extension = explode('.',$image->getClientOriginalName())[1] ?? '';
                                $media->save();
                                $arr_images[] = $media->id;
                            }
                        }

                        // Add images to UserShopItem
                        if(count($arr_images) > 0) {
                            $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                            $usi->save();
                        }

                    }


                    if($request->avl_assets != null){
                        foreach (explode(",",$request->avl_assets[0]) as $key => $value) {
                            Media::whereId($value)->first()->replicate()->fill([
                                'type' => 'Product',
                                'type_id' => $product_obj->id,
                            ])->save();
                        }
                    }

                    if ($usi->images) {
                        if ($request->avl_assets != null) {
                            $usi->images =  $usi->images.",".$request->exist_img.",".implode(",",$request->avl_assets) ?? null;
                        }else{
                            $usi->images =  $usi->images.",".$request->exist_img ?? null;
                        }

                    }else{
                        if ($request->avl_assets != null) {
                            $usi->images =  $request->exist_img.",".implode(",",$request->avl_assets) ?? null;
                        }else{
                            $usi->images =  $request->exist_img."," ?? null;
                        }

                    }

                    $usi->save();
                }
            }
            else{



                $is_empty = true;
                $reseller_group = Group::whereUserId($user->id)->where('name',"Reseller")->first();
                if(!$reseller_group){
                    $reseller_group = Group::create([
                            'user_id' => $user->id,
                            'name' => "Reseller",
                            'type' => 0,
                        ]);
                }

                $vip_group = Group::whereUserId($user->id)->where('name',"VIP")->first();
                if(!$vip_group){
                    $vip_group =  Group::create([
                        'user_id' => $user->id,
                        'name' => "VIP",
                        'type' => 0,
                    ]);
                }

                // ` Craeting Variation of Non Defined Attribute
                foreach ($custom_attriute_columns as $key => $custom_attriute) {
                    $valueasd = '';
                    $custom_attriute = str_replace(" ","_",$custom_attriute);


                    if ($request->has($custom_attriute)) {
                        $valueasd = $request->get($custom_attriute);
                        $parentAttribute = ProductAttributeValue::whereId($valueasd[0])->first();


                        $unique_slug  = getUniqueProductSlug($request->title);
                        $product_obj =  [
                            'title' => $request->title,
                            'model_code' => $request->model_code,
                            'category_id' => $request->category_id,
                            'sub_category' => $request->sub_category,
                            'brand_id' => 0,
                            'user_id' => auth()->id(),
                            'sku' => $sku_code,
                            'slug' => $unique_slug,
                            'description' => $request->description,
                            'carton_details' =>  $request->carton_details,
                            'shipping' =>  $request->shipping,
                            'manage_inventory' => (in_array($request->sample_available,$allowed_array) ? '1' : '0') ?? '0',
                            'stock_qty' => 0,
                            'status' => 0,
                            'is_publish' => 1,
                            'price' => $request->customer_price_without_gst ?? 0,
                            'min_sell_pr_without_gst' => $request->customer_price_without_gst ?? 0,
                            'hsn' => $request->hsn ?? null,
                            'hsn_percent' => $request->hsn_percent ?? null,
                            'mrp' => $request->mrp ?? 0,
                            'video_url' => $request->video_url ?? null,
                            'search_keywords' => $request->search_keywords ?? null,
                            'artwork_url' => $request->artwork_url ?? null,
                            'exclusive' => 0,
                            'base_currency' => $request->base_currency ?? 'INR',
                            'SellingPriceUnitIndex' => $request->selling_price_unit ?? null,
                        ];

                        $product_obj = Product::create($product_obj);

                        $product_id = $product_obj->id;

                        $product = $product_obj;

                        $custom_fields = json_decode($user->custom_fields);
                        if ($custom_fields != null && count($custom_fields) > 0) {
                            foreach ($custom_fields as $key => $customfield) {

                                $ogname = $customfield->id;
                                $customfield = str_replace("[]",'',$customfield->id);
                                if (is_array($request->get($customfield)) || is_html($request->get($customfield))) {

                                    echo "' $ogname ' It is an Array or HTML.".newline();
                                    $updatevalue = base64_encode(json_encode($request->get($customfield)));

                                }else{
                                    // $customfield = str_replace("[]",'',$customfield);
                                    $updatevalue = $request->get($customfield);
                                }

                                $custom_field = CustomFields::where('relatation_name',$ogname)->where('product_id',$product->id)->first();
                                if ($custom_field == null) {
                                    echo "Create New Records".newline(2);
                                    CustomFields::create([
                                        'relatation_name' => $ogname,
                                        'product_id' => $product_obj->id,
                                        'value' => $updatevalue ?? '',
                                        'user_id' => auth()->id(),
                                    ]);
                                }else{
                                    echo "Record Are Exist Update It".newline(2);

                                    $custom_field->update([
                                        'value' => $updatevalue ?? '',
                                    ]);
                                }
                            }
                        }


                        // $product_extra_info_obj_user = [
                        //     'product_id' => $product_obj->id,
                        //     'user_id' => $user->id,
                        //     'user_shop_id' => $user_shop->id,
                        //     'allow_resellers' => 'no',
                        //     'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                        //     'collection_name' =>$request->collection_name ?? '',
                        //     'season_month' => $request->season_month ?? '',
                        //     'season_year' => $request->season_year ?? '',
                        //     'sample_available' => 0,
                        //     'sample_year' => $request->sample_year ?? '',
                        //     'sample_month' => $request->sample_month ?? '',
                        //     'sampling_time' => $request->sampling_time ?? '',
                        //     'CBM' => $request->CBM ?? '',
                        //     'production_time' => $request->production_time ?? '',
                        //     'MBQ' => $request->MBQ ?? '',
                        //     'MBQ_unit' => $request->MBQ_unit ?? '',
                        //     'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                        //     'vendor_price' => $request->vendor_price ?? '',
                        //     'product_cost_unit' => $request->product_cost_unit ?? '',
                        //     'vendor_currency' => $request->vendor_currency ?? '',
                        //     'sourcing_year' => $request->sourcing_year ?? '',
                        //     'sourcing_month' => $request->sourcing_month ?? '',
                        //     'attribute_value_id' => $parentAttribute->id,
                        //     'attribute_id' => $parentAttribute->parent_id,
                        //     'group_id' => $sku_code,
                        //     'Cust_tag_group' => $request->sourcing_month ?? '',
                        //     'remarks' =>  $request->remarks ?? '' ,
                        //     'brand_name' => $request->brand_name ?? '',
                        // ];
                        // ProductExtraInfo::create($product_extra_info_obj_user);

                    // ` Craeting Variation of Non Defined Attribute
                    foreach ($custom_attriute_columns as $key => $custom_attriute) {
                        $valueasd = '';
                        $custom_attriute = str_replace(" ","_",$custom_attriute);
                        if ($request->has($custom_attriute)) {
                            $valueasd = $request->get($custom_attriute);
                            $parentAttribute = ProductAttributeValue::whereId($valueasd[0])->first();

                            $product_extra_info_obj_user = [
                                'product_id' => $product_obj->id,
                                'user_id' => $user->id,
                                'user_shop_id' => $user_shop->id,
                                'allow_resellers' => 'no',
                                'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                                'collection_name' =>$request->collection_name ?? '',
                                'season_month' => $request->season_month ?? '',
                                'season_year' => $request->season_year ?? '',
                                'sample_available' => 0,
                                'sample_year' => $request->sample_year ?? '',
                                'sample_month' => $request->sample_month ?? '',
                                'sampling_time' => $request->sampling_time ?? '',
                                'CBM' => $request->CBM ?? '',
                                'production_time' => $request->production_time ?? '',
                                'MBQ' => $request->MBQ ?? '',
                                'MBQ_unit' => $request->MBQ_unit ?? '',
                                'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                                'vendor_price' => $request->vendor_price ?? '',
                                'product_cost_unit' => $request->product_cost_unit ?? '',
                                'vendor_currency' => $request->vendor_currency ?? '',
                                'sourcing_year' => $request->sourcing_year ?? '',
                                'sourcing_month' => $request->sourcing_month ?? '',
                                'attribute_value_id' => $parentAttribute->id,
                                'attribute_id' => $parentAttribute->parent_id,
                                'group_id' => $sku_code,
                                'Cust_tag_group' => $request->sourcing_month ?? '',
                                'remarks' =>  $request->remarks ?? '' ,
                                'brand_name' => $request->brand_name ?? '',
                            ];
                            ProductExtraInfo::create($product_extra_info_obj_user);
                        }
                    }


                        $usi = UserShopItem::create([
                            'user_id'=> $user->id,
                            'category_id'=> $request->category_id,
                            'sub_category_id'=> $request->category_id,
                            'product_id'=> $product_obj->id,
                            'user_shop_id'=> $user_shop->id,
                            'parent_shop_id'=> 0,
                            'is_published'=> 1,
                            'price'=> $price,
                            'images' => count($arr_images) > 0 ? implode(',',$arr_images) : null,
                        ]);
                        $count++;

                        if($reseller_group){
                            // create Reseller Group record
                            $g_p =  GroupProduct::create([
                                'group_id'=>$reseller_group->id,
                                'product_id'=>$product_obj->id,
                                'price'=> $request->reseller_price ?? 0,
                            ]);
                        }

                        if($vip_group){
                            // create Vip Group record
                            GroupProduct::create([
                                'group_id'=>$vip_group->id,
                                'product_id'=>$product_obj->id,
                                'price'=> $request->vip_price ?? 0,
                            ]);
                        }


                        if ($request->hasFile('img')) {
                            $arr_images = [];
                            // * Start Creating Media...

                            foreach ($request->img as $key => $image) {
                                if($image != null){
                                    // Uploading File
                                    $filename = $image->getClientOriginalName();
                                    $path = $image->storeAs($folderPath, $filename);

                                    // Creating FIle link
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $product_obj->id;
                                    $media->file_name = $filename;
                                    $media->path = str_replace("public",'storage',$path);
                                    $media->extension = explode('.',$filename)[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                            }


                            // Add images to UserShopItem
                            if(count($arr_images) > 0) {
                                $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                $usi->save();
                            }

                        }


                        if($request->avl_assets != null){
                            foreach (explode(",",$request->avl_assets[0]) as $key => $value) {
                                Media::whereId($value)->first()->replicate()->fill([
                                    'type' => 'Product',
                                    'type_id' => $product_obj->id,
                                ])->save();
                            }
                        }



                        if ($usi->images) {
                            $usi->images =  $usi->images.",".$request->exist_img.",".($request->avl_assets[0] ?? null);
                        }else{
                            $usi->images =  $request->exist_img.",".($request->avl_assets[0] ?? null);
                        }

                        $usi->save();
                        $is_empty = false;

                    }
                }


                if ($is_empty) {
                    $unique_slug  = getUniqueProductSlug($request->title);
                    $product_obj =  [
                        'title' => $request->title,
                        'model_code' => $request->model_code,
                        'category_id' => $request->category_id,
                        'sub_category' => $request->sub_category,
                        'brand_id' => 0,
                        'user_id' => auth()->id(),
                        'sku' => $sku_code,
                        'slug' => $unique_slug,
                        'description' => $request->description,
                        'carton_details' =>  $request->carton_details,
                        'shipping' =>  $request->shipping,
                        'manage_inventory' => (in_array($request->sample_available,$allowed_array) ? '1' : '0') ?? '0',
                        'stock_qty' => 0,
                        'status' => 0,
                        // 'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                        'is_publish' => 1,
                        'price' => $request->customer_price_without_gst ?? 0,
                        'min_sell_pr_without_gst' => $request->customer_price_without_gst ?? 0,
                        'hsn' => $request->hsn ?? null,
                        'hsn_percent' => $request->hsn_percent ?? null,
                        'mrp' => $request->mrp ?? 0,
                        'video_url' => $request->video_url ?? null,
                        'search_keywords' => $request->search_keywords ?? null,
                        'artwork_url' => $request->artwork_url ?? null,
                        'exclusive' => 0,
                        'base_currency' => $request->base_currency ?? 'INR',
                        'SellingPriceUnitIndex' => $request->selling_price_unit ?? null,
                        // 'archive' => (in_array($item[$ArchiveIndex],$allowed_array)) ? 1 : 0,
                    ];

                    $product_obj = Product::create($product_obj);

                    $product_id = $product_obj->id;
                    $product = $product_obj;

                    $custom_fields = json_decode($user->custom_fields);
                    if ($custom_fields != null && count( (array) $custom_fields) > 0) {
                        foreach ($custom_fields as $key => $customfield) {

                            $ogname = $customfield->id;
                            $customfield = str_replace("[]",'',$customfield->id);
                            if (is_array($request->get($customfield)) || is_html($request->get($customfield))) {

                                echo "' $ogname ' It is an Array or HTML.".newline();
                                $updatevalue = base64_encode(json_encode($request->get($customfield)));

                            }else{
                                // $customfield = str_replace("[]",'',$customfield);
                                $updatevalue = $request->get($customfield);
                            }

                            $custom_field = CustomFields::where('relatation_name',$ogname)->where('product_id',$product->id)->first();
                            if ($custom_field == null) {
                                echo "Create New Records".newline(2);
                                CustomFields::create([
                                    'relatation_name' => $ogname,
                                    'product_id' => $product_obj->id,
                                    'value' => $updatevalue ?? '',
                                    'user_id' => auth()->id(),
                                ]);
                            }else{
                                echo "Record Are Exist Update It".newline(2);

                                $custom_field->update([
                                    'value' => $updatevalue ?? '',
                                ]);
                            }
                        }
                    }

                    $product_extra_info_obj_user = [
                        'product_id' => $product_obj->id,
                        'user_id' => $user->id,
                        'user_shop_id' => $user_shop->id,
                        'allow_resellers' => 'no',
                        'exclusive_buyer_name' => $request->exclusive_buyer_name ?? '',
                        'collection_name' =>$request->collection_name ?? '',
                        'season_month' => $request->season_month ?? '',
                        'season_year' => $request->season_year ?? '',
                        'sample_available' => 0,
                        'sample_year' => $request->sample_year ?? '',
                        'sample_month' => $request->sample_month ?? '',
                        'sampling_time' => $request->sampling_time ?? '',
                        'CBM' => $request->CBM ?? '',
                        'production_time' => $request->production_time ?? '',
                        'MBQ' => $request->MBQ ?? '',
                        'MBQ_unit' => $request->MBQ_unit ?? '',
                        'vendor_sourced_from' => $request->vendor_sourced_from ?? '',
                        'vendor_price' => $request->vendor_price ?? '',
                        'product_cost_unit' => $request->product_cost_unit ?? '',
                        'vendor_currency' => $request->vendor_currency ?? '',
                        'sourcing_year' => $request->sourcing_year ?? '',
                        'sourcing_month' => $request->sourcing_month ?? '',
                        'attribute_value_id' => 1086,
                        'attribute_id' => 169,
                        // 'attribute_value_id' => $product_att_val->attribute_value,
                        // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                        'group_id' => $sku_code,
                        'Cust_tag_group' => $request->sourcing_month ?? '',
                        'remarks' =>  $request->remarks ?? '' ,
                        'brand_name' => $request->brand_name ?? '',
                    ];
                    ProductExtraInfo::create($product_extra_info_obj_user);

                    $usi = UserShopItem::create([
                        'user_id'=> $user->id,
                        'category_id'=> $request->category_id,
                        'sub_category_id'=> $request->category_id,
                        'product_id'=> $product_obj->id,
                        'user_shop_id'=> $user_shop->id,
                        'parent_shop_id'=> 0,
                        'is_published'=> 1,
                        'price'=> $price,
                        'images' => count($arr_images) > 0 ? implode(',',$arr_images) : null,
                    ]);
                    $count++;

                    if($reseller_group){
                        // create Reseller Group record
                        $g_p =  GroupProduct::create([
                            'group_id'=>$reseller_group->id,
                            'product_id'=>$product_obj->id,
                            'price'=> $request->reseller_price ?? 0,
                        ]);
                    }

                    if($vip_group){
                        // create Vip Group record
                        GroupProduct::create([
                            'group_id'=>$vip_group->id,
                            'product_id'=>$product_obj->id,
                            'price'=> $request->vip_price ?? 0,
                        ]);
                    }


                    if ($request->hasFile('img')) {
                        $arr_images = [];
                        // * Start Creating Media...
                        foreach ($request->img as $key => $image) {
                            if($image != null){
                                // Uploading File
                                $filename = $image->getClientOriginalName();

                                $path = $image->storeAs($folderPath, $filename);

                                // Creating FIle link
                                $media = new Media();
                                $media->tag = "Product_Image";
                                $media->file_type = "Image";
                                $media->type = "Product";
                                $media->type_id = $product_obj->id;
                                $media->file_name = $image->getClientOriginalName();
                                $media->path = str_replace("public",'storage',$path);
                                $media->extension = explode('.',$image->getClientOriginalName())[1] ?? '';
                                $media->save();
                                $arr_images[] = $media->id;
                            }
                        }



                        // Add images to UserShopItem
                        if(count($arr_images) > 0) {
                            $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                            $usi->save();
                        }

                    }


                    if($request->avl_assets != null){
                        foreach (explode(",",$request->avl_assets) as $key => $value) {
                            Media::whereId($value)->first()->replicate()->fill([
                                'type' => 'Product',
                                'type_id' => $product_obj->id,
                            ])->save();
                        }
                    }


                    if ($usi->images) {
                        $usi->images =  $usi->images.",".$request->exist_img.",".$request->avl_assets ?? null;
                    }else{
                        $usi->images =  $request->exist_img.",".$request->avl_assets ?? null;
                    }

                    $usi->save();

                    $count++;
                }


            }




            // magicstring($folderPath);
            // return;
            $msg =  "Product Crated with Varient $count";
            // return back()->with('success',$msg);


            // magicstring($loop1);
            // magicstring($loop2);
            // magicstring($loop3);
            // echo $msg;

            if ($request->has('in_modal') && $request->in_modal == 1) {
                return back()->with('success', $msg)->with('closemodal', "true");
            }

            return redirect(route('panel.check.display'))->with('success', $msg)->with('closemodal', "true");
            magicstring($request->all());

            return;

        } catch (\Throwable $e) {
            throw $e;
            // return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
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


            // magicstring($request->all());
            // return;
            if($request->all_products == 1){
                $scoped_items = UserShopItem::whereUserId(auth()->id())->get();
                // $product_ids = Product::whereIn('id', $scoped_items->pluck('product_id'))->groupBy('sku')->pluck('id');
                $product_ids = Product::whereIn('id', $scoped_items->pluck('product_id'))->pluck('id');
            }else{
                // $product_ids = $request->product_ids;
                $product_ids = explode(",",$request->product_ids);
            }

            if(count($product_ids) == 0){
                return back()->with('error','No Products added in your account!');
            }

            return view('panel.products.qr',compact('product_ids'));

        }catch(\Exception $e){
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

            $medias = Media::whereType('Product')->whereTypeId($product->id)->whereTag('Product_Image')->where('extension','!=','gif')->get();
            $medias_gif = Media::whereType('Product')->whereTypeId($product->id)->whereTag('Product_Image')->where('extension','gif')->get();
            $media_Video = Media::whereType('Product')->whereTypeId($product->id)->whereTag('Product_Video')->get();
            $mediaAssets = Media::whereType('Product')->whereTypeId($product->id)->whereTag('Product_Asset')->get();

            $mediaSize_attachment = 0;
            foreach ($mediaAssets as $key => $media) {
                $path = str_replace("storage","public",$media->path);
                if (Storage::exists($path)) {
                    $size_Of_File = Storage::size($path);
                    $mediaSize_attachment += $size_Of_File;
                }
            }

            $mediaSize_video = 0;
            foreach ($media_Video as $key => $media) {
                $path = str_replace("storage","public",$media->path);
                if (Storage::exists($path)) {
                    $size_Of_File = Storage::size($path);
                    $mediaSize_video += $size_Of_File;
                }
            }

            $mediaSize_gif = 0;
            foreach ($medias_gif as $key => $media) {
                $path = str_replace("storage","public",$media->path);
                if (Storage::exists($path)) {
                    $size_Of_File = Storage::size($path);
                    $mediaSize_gif += $size_Of_File;
                }
            }

            $mediaSize_Image = 0;
            foreach ($medias as $key => $media) {
                $path = str_replace("storage","public",$media->path);
                if (Storage::exists($path)) {
                    $size_Of_File = Storage::size($path);
                    $mediaSize_Image += $size_Of_File;
                }
            }

            $prodextra = ProductExtraInfo::where('product_id',$product->id)->groupBy('attribute_value_id')->first();
            $category = getProductCategory();

            $custom_attribute = ProductAttribute::where('user_id',null)->orwhere('user_id',$product->user_id)->get();

            $groupIds = ProductExtraInfo::where('product_id',$product->id)->groupBy('Cust_tag_group')->orderBy('id','ASC')->pluck('Cust_tag_group','product_id')->toArray();

            $groupIds_all = ProductExtraInfo::where('group_id',$product->sku)->groupBy('Cust_tag_group')->orderBy('id','ASC')->pluck('Cust_tag_group','product_id');

            $user = User::whereId($product->user_id)->first();
            $user_custom_col_list = json_decode($user->custom_attriute_columns) ?? [];

            $productVarients = ProductExtraInfo::where('group_id',$product->sku)->groupBy('attribute_id')->pluck('attribute_id');
            if (request()->has('type') && decrypt(request()->get('type')) == 'editmainksku') {
                $attribute_value_id = ProductExtraInfo::where('group_id',$product->sku)->groupBy('attribute_value_id')->pluck('attribute_value_id')->toArray();
            }else{
                $attribute_value_id = ProductExtraInfo::where('product_id',$product->id)->groupBy('attribute_value_id')->pluck('attribute_value_id')->toArray();
            }


            $arraysd = ProductExtraInfo::where('group_id',$product->sku)->pluck('attribute_id','attribute_value_id')->toArray();
            $varient_basis = countRepetitions($arraysd);
            arsort($varient_basis);

            $user_shop_item = UserShopItem::where('product_id',$product->id)->where('user_id',auth()->id())->first();
            $available_products = ProductExtraInfo::where('group_id',$product->sku)->groupBy('product_id')->pluck('product_id')->toArray();

            $product_variant_combo = [];
            $keysToKeep = [];
            foreach ($varient_basis as $key => $lRepeated) {
                if ($lRepeated > 1) {
                    array_push($keysToKeep, $key);
                }
            }
            foreach ($available_products as $key => $products) {
                $tmp = ProductExtraInfo::where('product_id',$products)->pluck('attribute_value_id','attribute_id')->toArray();

                $keysArray = array_flip($keysToKeep);
                $filteredArray = array_intersect_key($tmp, $keysArray);
                // $filteredArray = array_reverse($filteredArray);
                array_push($product_variant_combo, $filteredArray);

            }

            $user_custom_fields = json_decode($user->custom_fields,true) ?? [];

            $fileds_sections = array_column($user_custom_fields, 'ref_section');
            $fileds_sections_names = [];
            $fileds_sections_ids = array_column($user_custom_fields, 'id');

            foreach ($fileds_sections_ids as $key => $value) {
                array_push($fileds_sections_names, getCustomFieldValueById($value,$product->id)->value ?? '');
            }

            $months = ['January' => 'January','February' => 'February','March' => 'March','April' => 'April','May' => 'May','June' => 'June','July' => 'July','August' => 'August','September' => 'September','October' => 'October','November' => 'November','December' => 'December'];




            return view('panel.products.edit',compact('product','category','product_record','medias','colors','sizes','shipping','variations','carton_details','prodextra','custom_attribute','groupIds','groupIds_all','productVarients','user_custom_col_list','attribute_value_id','media_Video','mediaAssets','medias_gif','mediaSize_Image','mediaSize_attachment','mediaSize_gif','mediaSize_video','product_variant_combo','available_products','user_shop_item','varient_basis','user_custom_fields','fileds_sections','fileds_sections_names','fileds_sections_ids','months'));

        }catch(\Exception $e){
            // return back()->with('error', 'There was an error: ' . $e->getMessage());
            throw $e;
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


        $any_value = [];
        $newProp = [];
        $substring = "any_value";

        // magicstring(request()->all());
        // return;

        foreach ($request->all() as $key => $value) {
            if (strpos($key, $substring) !== false) {
                array_push($any_value,$key);

                if (is_array($request->$key)) {

                    $tmp = implode("x",$request->$key);
                    if ($tmp != 'xxx') {
                        $request[$key] = $tmp;
                    }else{
                        $request[$key] = '';
                    }
                }

                // checking Value Exist or Not
                $attribute_name = explode("-",$key)[1];

                $chkCountAttr = ProductAttribute::where('name',$attribute_name)->where('user_id',auth()->id())->get();


                if ($chkCountAttr->count() == 0) {
                    $attribute_name = str_replace("_"," ",$attribute_name);
                    $chkCountAttr = ProductAttribute::where('name',$attribute_name)->where('user_id',auth()->id())->get();
                }


                if ($chkCountAttr->count() != 0) {
                    $attribute_id = $chkCountAttr[0]->id;
                    $received_value = $request->$key;

                    if ($received_value != null && $received_value != "" && $received_value != []) {
                        $chkatt = ProductAttributeValue::where('parent_id',$attribute_id)->where('attribute_value',$received_value)->first();

                        if ($chkatt == null) {
                            $tmparrvar = ProductAttributeValue::create([
                                'parent_id' => $attribute_id,
                                'user_id' => auth()->id() ?? null,
                                'attribute_value' => $received_value,
                            ]);

                            $request[$attribute_name] = array($tmparrvar->id);

                            array_push($newProp,$tmparrvar->id);

                        }else{
                            // magicstring($chkatt);
                            $request[$attribute_name] = array($chkatt->id);
                            array_push($newProp,$chkatt->id);


                        }
                    }
                }else{
                    echo "Else Part Will Work";
                }
            }
        }

        // magicstring($newProp);
        $request['properties'] = array_merge($request->properties,$newProp);

        // magicstring($request->all());

        // return;

        $custom_attriute_columns = json_decode(auth()->user()->custom_fields,true) ?? [];

        if ($custom_attriute_columns != null && count($custom_attriute_columns) > 0) {
            $custom_attriute_columns = array_column($custom_attriute_columns, 'id');
        }else{
            $custom_attriute_columns = [];
        }

        $count = 0;
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

            if (!$request->has('type_main')) {
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

                $user_id  = auth()->user()->id;
                $folderPath = "public/files/$user_id";
                if($product){
                    // To Fullfillment of Client MRP Need
                    $request['price'] =  $request->mrp;
                    if($request->hasFile("img")){
                            foreach($request->file('img') as $tempimg){

                                $filename = $tempimg->getClientOriginalName();

                                $path = $tempimg->storeAs($folderPath, $filename);
                                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                                $fileType = ucfirst(explode("/",Storage::mimeType($path))[0] );
                                $fileSize = Storage::size($path);
                                $tag = '';
                                if ($fileType == 'Image') {
                                    $tag = 'Product_Image';
                                }
                                elseif ($fileType == 'Video') {
                                    $tag = 'Product_Video';
                                }else{
                                    $tag ='Product_Asset';
                                }

                                if($filename != null){
                                    Media::create([
                                        'type' => 'Product',
                                        'type_id' => $product->id,
                                        'file_name' => $filename,
                                        'path' => str_replace("public",'storage',$path),
                                        'extension' => $extension,
                                        'file_type' => $fileType ?? "Image",
                                        'tag' => $tag ?? "Product_Image",
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
                        'group_id' => $product->sku,
                        'Cust_tag_group'=> $request->get('Cust_tag_group') ?? '',
                        'brand_name' => $request->get('brand_name') ?? '',
                    ]);



                    // @ This Part Will Create New Product Extra Info Records
                    $to_clone = ProductExtraInfo::where('product_id',$product->id)->orderBy('created_at', 'desc')->first();
                    $groupId = $product->sku;
                    // return;

                    if ($request->properties != null && $request->properties != '') {
                        foreach ($request->properties as $key => $value) {
                            // return;
                            // checking Product Attribute Exist Or Not in Records
                            $attribute_record = getAttruibuteValueById($value);
                            if ($attribute_record != null) {
                                $chkwds = ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',$attribute_record->parent_id)->where('user_id',$request->user_id)->get();
                                // magicstring($chkwds);
                                // return;

                                if ($chkwds->count() != 0) {
                                    $newproduct = $chkwds[0];
                                    $newproduct->attribute_value_id = $attribute_record->id;
                                    $newproduct->attribute_id = $attribute_record->parent_id;
                                    $newproduct->save();
                                }else{
                                    // Getting Records of Attribute
                                    $attribute_record = getAttruibuteValueById($value);
                                    // $clonedProduct = $product->replicate();
                                    // $clonedProduct->created_at = Carbon::now();
                                    // $clonedProduct->save();

                                    $newproduct = $to_clone->replicate();
                                    $newproduct->product_id = $product->id;
                                    $newproduct->attribute_value_id = $attribute_record->id;
                                    $newproduct->attribute_id = $attribute_record->parent_id;
                                    $newproduct->group_id = $product->sku;
                                    $newproduct->created_at = Carbon::now();
                                    $newproduct->save();
                                }
                            }

                            // ` Create new Product Extra Info Record
                            // if ($chkwds->count() == 0) {
                            //     echo getAttruibuteValueById($value)->attribute_value;
                            //     echo " Property Does Not Exist".newline();
                            //     // Getting Records of Attribute
                            //     $attribute_record = getAttruibuteValueById($value);
                            //     // $clonedProduct = $product->replicate();
                            //     // $clonedProduct->created_at = Carbon::now();
                            //     // $clonedProduct->save();

                            //     $newproduct = $to_clone->replicate();
                            //     $newproduct->product_id = $product->id;
                            //     $newproduct->attribute_value_id = $attribute_record->id;
                            //     $newproduct->attribute_id = $attribute_record->parent_id;
                            //     $newproduct->group_id = $product->sku;
                            //     $newproduct->created_at = Carbon::now();
                            //     $newproduct->save();
                            // }
                        }
                    }

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
                        UserShopItem::where('user_id','=',$product->user_id)->where('product_id',$product->id)->update(['is_published'=>0,'price' => $request->min_sell_pr_without_gst]);
                    }else{
                        UserShopItem::where('user_id','=',$product->user_id)->where('product_id',$product->id)->update(['is_published'=>1,'price' => $request->min_sell_pr_without_gst]);
                    }

                    // magicstring($request->all());
                    // return;
                    // Creating Record of Updating of Custom Fields
                    if ($custom_attriute_columns != null && count($custom_attriute_columns) > 0) {
                        foreach ($custom_attriute_columns as $key => $customfield) {

                            $ogname = $customfield;
                            $customfield = str_replace("[]",'',$customfield);

                            if (is_array($request->get($customfield)) || is_html($request->get($customfield))) {

                                echo "' $ogname ' It is an Array or HTML.".newline();
                                $updatevalue = base64_encode(json_encode($request->get($customfield)));

                            }else{
                                // $customfield = str_replace("[]",'',$customfield);
                                $updatevalue = $request->get($customfield);
                            }

                            $custom_field = CustomFields::where('relatation_name',$ogname)->where('product_id',$product->id)->first();
                            if ($custom_field == null) {
                                CustomFields::create([
                                    'relatation_name' => $ogname,
                                    'product_id' => $product->id,
                                    'value' => $updatevalue ?? '',
                                    'user_id' => auth()->id(),
                                ]);
                            }else{
                                $custom_field->update([
                                    'value' => $updatevalue ?? '',
                                ]);
                            }
                        }
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
            }else{
                echo "This is a main product";
                if(!$request->has('is_publish')){
                    $request['is_publish'] = 0;
                }
                if(in_array($request->has('is_publish'),$allow_array)){
                    $request['is_publish'] = 1;
                }else{
                    $request['is_publish'] = 0;
                }


                $products = Product::where('sku',$product->sku)->get();

                foreach ($products as $key => $product) {
                    if ($request->get('sub_category') == null || $request->get('sub_category') == '') {
                        $request['sub_category'] = $product->sub_category;
                    }
                    if ($request->get('category_id') == null || $request->get('category_id') == '') {
                        $request['category_id'] = $product->category_id;
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


                    $user_id  = auth()->user()->id;
                    $folderPath = "public/files/$user_id";
                    if($product){
                        // To Fullfillment of Client MRP Need
                            $request['price'] =  $request->mrp;
                            if($request->hasFile("img")){
                                foreach($request->file('img') as $tempimg){

                                    $filename = $tempimg->getClientOriginalName();

                                    $path = $tempimg->storeAs($folderPath, $filename);
                                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                                    $fileType = ucfirst(explode("/",Storage::mimeType($path))[0] );
                                    $fileSize = Storage::size($path);
                                    $tag = '';
                                    if ($fileType == 'Image') {
                                        $tag = 'Product_Image';
                                    }
                                    elseif ($fileType == 'Video') {
                                        $tag = 'Product_Video';
                                    }else{
                                        $tag ='Product_Asset';
                                    }

                                    if($filename != null){
                                        Media::create([
                                            'type' => 'Product',
                                            'type_id' => $product->id,
                                            'file_name' => $filename,
                                            'path' => str_replace("public",'storage',$path),
                                            'extension' => $extension,
                                            'file_type' => $fileType ?? "Image",
                                            'tag' => $tag ?? "Product_Image",
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
                            'group_id' => $product->sku,
                            'Cust_tag_group'=> $request->get('Cust_tag_group') ?? '',
                            'brand_name' => $request->get('brand_name') ?? '',
                        ]);



                        // @ This Part Will Create New Product Extra Info Records
                        $to_clone = ProductExtraInfo::where('product_id',$product->id)->orderBy('created_at', 'desc')->first();
                        $groupId = $product->sku;
                        $newProperty = [];


                    // !=============================================================================================================================

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
                            UserShopItem::where('user_id','=',$product->user_id)->where('product_id',$product->id)->update(['is_published'=>0,'price' => $request->min_sell_pr_without_gst]);
                        }else{
                            UserShopItem::where('user_id','=',$product->user_id)->where('product_id',$product->id)->update(['is_published'=>1,'price' => $request->min_sell_pr_without_gst]);
                        }

                        // magicstring($request->all());
                        // return;
                        // Creating Record of Updating of Custom Fields
                        if ($custom_attriute_columns != null && count($custom_attriute_columns) > 0) {
                            foreach ($custom_attriute_columns as $key => $customfield) {

                                $updatevalue = base64_encode(json_encode($request->get($customfield)));
                                $custom_field = CustomFields::where('relatation_name',$customfield)->where('product_id',$product->id)->first();

                                if ($custom_field == null) {
                                    CustomFields::create([
                                        'relatation_name' => $customfield,
                                        'product_id' => $product->id,
                                        'value' => $updatevalue ?? '',
                                        'user_id' => auth()->id(),
                                    ]);
                                }else{
                                    $custom_field->update([
                                        'value' => $updatevalue ?? '',
                                    ]);
                                }
                            }
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

                        $product = UserShopItem::where('product_id',$product->id)->first();
                        $product->update([
                            'price' => $request->price
                        ]);

                    }

                    $count++;

                } // End of Products for Each Loop...




                // echo newline(2);
                // // --=======================================================================================================

                //     foreach ($request->get('properties') as $key => $value) {
                //         $prodpertyparent = getAttruibuteValueById($value)->parent_id;
                //         $chk33 = ProductExtraInfo::where('group_id',$products[0]->sku)->where('attribute_id',$prodpertyparent)->get();

                //         // @ checking New Property Exist or Not in Records
                //         if ($chk33->count() == 0) {
                //             // True Not Exist in Records...
                //             echo "Property Does Not Exist".newline();


                //                 // Getting Records of Attribute
                //                 $attribute_record = getAttruibuteValueById($value);

                //                 // @ Creating Product Record for New Property
                //                 $clonedProduct = $products[0]->replicate();
                //                 $clonedProduct->created_at = Carbon::now();
                //                 // $clonedProduct->save();

                //                 // @ Creating User Shop Item Record for New Property
                //                 $clonedUserShopItemRecord = UserShopItem::where('product_id',$products[0]->id)->orderBy('images','DESC')->first();
                //                 $clonedUserShopItem = $clonedUserShopItemRecord->replicate();
                //                 $clonedUserShopItem->created_at = Carbon::now();
                //                 $clonedUserShopItem->updated_at = Carbon::now();
                //                 $clonedUserShopItem->product_id = $clonedProduct->id ?? 0;
                //                 $clonedUserShopItem->images = $clonedUserShopItemRecord->images;
                //                 // $clonedUserShopItem->save();
                //                 // magicstring($clonedUserShopItem);


                //                 // @ Creating Product Extra Info Record for New Property
                //                 $checkProductProperty = ProductExtraInfo::where('group_id',$products[0]->sku)->groupBy('attribute_id')->get();

                //                 foreach ($checkProductProperty as $key => $checkprop) {
                //                     magicstring($checkprop);
                //                 }




                //                 // @ extra info of product
                //                 // $newproduct = $to_clone->replicate();
                //                 // $newproduct->product_id = $product->id;
                //                 // $newproduct->attribute_value_id = $attribute_record->id;
                //                 // $newproduct->attribute_id = $attribute_record->parent_id;
                //                 // $newproduct->group_id = $product->sku;
                //                 // $newproduct->created_at = Carbon::now();
                //                 // $newproduct->save();




                //         }else{
                //             continue;
                //             echo "Property Exist".newline();
                //             // checking Property Exist in Each Product

                //             foreach ($products as $key => $product) {
                //                 $checkProductProperty = ProductExtraInfo::where('product_id',$product->id)->where('attribute_value_id',$value)->orwhere('attribute_id',$prodpertyparent)->get();

                //                 if ($checkProductProperty->count() == 0) {
                //                     echo "$value New Property Came in Existence..".newline();
                //                 }else{
                //                     // echo "Property Exist in Product".newline();
                //                 }
                //             }




                //         }

                //     }

                // // --=======================================================================================================
                //     return;


                return back()->with('success',"$count Product Updated!");
            }


            return back()->with('error','Product not found')->withInput($request->all());
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param    int  $id
     * @return  \Illuminate\Http\Response
    **/

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


    public function deleteSKu(Request $request,$productid) {

        try {
            // ` Delete Product
            // ` Delete ProductExtraInfo
            // ` Delete PorposalItem
            // ` Delete UsershopItem
            // ` Delete Inventory

            $product = Product::whereId(decrypt($productid))->first();
            $productextra = ProductExtraInfo::where('product_id',decrypt($productid))->get();
            $count = 0;

            // ! Deleting Product Extra Info
            foreach ($productextra as $key => $value) {
                $value->delete();
                $count++;
            }

            // ! Deleting Proposal Items
            $proposalItems = ProposalItem::where('product_id',$product->id)->get();
            foreach ($proposalItems as $key => $proposalItem) {
                $proposalItem->delete();
            }

            // ! Deleting User Shop Items
            $user_shop_items = UserShopItem::where('product_id',$product->id)->where('user_id',auth()->id())->get();
            foreach ($user_shop_items as $key => $user_shop_item) {
                $user_shop_item->delete();
            }

            // ! Deleting Inventory
            $inventory = Inventory::where('product_id',$product->id)->where('user_id',auth()->id())->get();
            foreach ($inventory as $key => $item) {
                $item->delete();
            }

            // ! Deleting Products
            $product->delete();

            return back()->with("success","$count Property of the Product Deleted Successfully!!");

        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error',"Oops There was and Error.");
        }
    }


    public function unlinkasset($pId,$assets_path) {

        try {
            $product_id = decrypt($pId);
            $path = decrypt($assets_path);
            $count = 0;

            $chk = Media::where('type_id',$product_id)->where('path',$path)->get();

            foreach ($chk as $key => $value) {
                $value->delete();
                $count++;
            }

            return back()->with('success',"Asset Unlinked Succesfully.");

        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error',"Try again Later.");

        }


    }



    public function deletevariant($productid)
    {
        try {
            // -- This function is only call when the product is a Main/Group product
            $attributeValue_id = base64_decode(request()->get('chk_id'));
            $product = Product::whereId(decrypt($productid))->first();
            $count = 0;

            // ` Not checking UserId or Shop because it is a main product checking with received Product Id to Save Query Time
            $productExtraRecords = ProductExtraInfo::where('group_id',$product->sku)->where('attribute_value_id',$attributeValue_id)->get();
            foreach ($productExtraRecords as $i => $productExtraRecord) {
                if ($productExtraRecord->attribute_value_id == $attributeValue_id) {
                    $productExtraRecord->delete();
                    $count++;
                }
            }

            return back()->with('success',"$count Variant Deleted Succesfully.");
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('error',"Try again Later.");
        }
    }


    public function searchassets() {

        if (request()->ajax()) {

            $page = request()->get('page', 1); // Default to page 1 if not set
            $folder = "storage/files/".auth()->id();

            $medias = Media::where('path', 'LIKE', "%" . request()->get('search') . "%")
                            ->where('path',"LIKE","%".$folder."%")
                            ->groupBy('path')
                            ->orderBy('created_at',"DESC")
                            ->paginate(10, ['*'], 'page', $page);

            return view('panel.products.include.iframe.link-assets',compact('medias'));
        }

    }




}

