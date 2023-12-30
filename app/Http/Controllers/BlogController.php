<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\brand_product;
use App\Models\Group;
use App\Models\GroupProduct;
use App\Models\UserShopItem;
use App\Models\Category;
use App\Models\Media;
use App\Models\ProductAttribute;
use App\Models\CategoryType;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BulkController extends Controller
{
    public function productUpload(Request $request)
    {
        // chk user have active package or not!
        if(AuthRole() == "User"){
            if(!haveActivePackageByUserId(auth()->id())){
                return back()->with('error','You do not have any active package!');
            } 
        }    
        
        $count = 0;
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }

        $rows = array_slice($rows,4);
        $master = $rows;

        // $head = array_shift($rows);
        // $master = $rows;


        // Index Start
        $CategoryIndex = 0;
        $SubCategoryIndex = 1;
        $TitleIndex = 2;
        $ModelCodeIndex = 3;
        $ImageMainIndex = 4;
        $ImageFrontIndex = 5;
        $ImageBackIndex = 6;
        $ImageSide1Index = 7;
        $ImageSide2Index = 8;
        $ImagePosterIndex = 9;
        $VideoURLIndex = 10;
        $Tag1Index = 11;
        $Tag2Index = 12;
        $Tag3Index = 13;
        $DescriptionIndex = 14;
        $WeightIndex = 15;
        $WeightUnitIndex = 16;
        $LengthIndex = 17;
        $WidthIndex = 18;
        $HeightIndex = 19;
        $LengthUnitIndex = 20;
        $StandardCartonIndex = 21;
        $CartonWeightIndex = 22;
        $CartonUnitIndex = 23;
        $ColorIndex = 24;
        $SizeIndex = 25;
        $RateTypeIndex = 26;
        $RateIndex = 27;
        // $MinimumSellingPriceWithoutGST = 26;        //minimum selling price Removed from Bulk Sheet
        $ShopPriceIndex = 28;               //SGW GST
        $VipPriceIndex = 29;
        $ResellerPriceIndex = 30;
        $MRPIndex = 31;
        $HSNTaxIndex = 32;
        $HsnPercentIndex = 33;
        $MetaDescriptionIndex = 34;
        $MetaKeywordsIndex = 35;
        $artwork_urlIndex = 36;
        $brandid_index = 37; // Get Brand Id for Product
        
        // Index End
        // Index
        $MinimumSellingPriceWithoutGST = 0; // For No Error

        $productObj = null;
        $brandid =  $item_temp[$brandid_index] ?? $request->brand_id; // ! Get Brand Id  

        
        $master_obj = collect($master);
        if(AuthRole() == "User"){
            $scoped_category = getProductCategoryByUserIndrustry(auth()->user()->industry_id);
        }else{
            $scoped_category = getProductCategory();
        }
        $packageValidationCount = 0;
        $package = getUserPackageInfo(auth()->id());
        $chk_user = AuthRole();

        if (AuthRole() != 'Brand') {
            if(!$package){
                return back()->with('error',"You don't have an active package!");
            }else{
                $limit = json_decode($package->limit);
                $product_uploads = $limit->product_uploads;
            }
        }else{
            $product_uploads = 99999; // Give Unlimited Limit To Brand
        }
        




        // VALIDATION LOOP
        foreach ($master as $index_temp => $item_temp) {
            $row_number = $index_temp + 5;
            if ($item_temp[$TitleIndex] != null) {
                // Explode data Start
                $colors_arr = $item_temp[$ColorIndex] != null ? array_unique(explode("^^",$item_temp[$ColorIndex])) : [];
                $sizes_arr = $item_temp[$SizeIndex] != null ? array_unique(explode("^^",$item_temp[$SizeIndex])) : [];
                // $rates = $item_temp[$RateIndex] != null ? array_unique(explode("^^",$item_temp[$RateIndex])) : [];
                
                $rates = $item_temp[$RateIndex] != null ? (explode("^^",$item_temp[$RateIndex])) : [];
                $mrp = $item_temp[$MRPIndex] != null ? (explode("^^",$item_temp[$MRPIndex])) : [];

                $length_arr = $item_temp[$LengthIndex] != null ? (explode("^^",$item_temp[$LengthIndex])) : null;
                $height_arr = $item_temp[$HeightIndex] != null ? (explode("^^",$item_temp[$HeightIndex])) : null;
                $width_arr = $item_temp[$WidthIndex] != null ? (explode("^^",$item_temp[$WidthIndex])) : null;

                $rate_type = $item_temp[$RateTypeIndex] != null ? $item_temp[$RateTypeIndex] : null;

                if(count($colors_arr) > 0 && count($sizes_arr) > 0){
                    foreach ($colors_arr as $color_index => $color) { //color
                        foreach ($sizes_arr as $size_index => $size) { // size
                            // foreach ($length_arr as $length_index => $length) { // length
                                // foreach ($height_arr as $height_index => $height) { // width
                                    // foreach ($width_arr as $widdth_index => $width) { // height
                                            $packageValidationCount++;
                                    // }
                                // }
                            // }
                        }
                    }
                }elseif(count($colors_arr) > 0){
                    foreach ($colors_arr as $color_index => $color) { // color
                        $packageValidationCount++;
                    }
                }elseif(count($sizes_arr) > 0){
                    foreach ($sizes_arr as $size_index => $size) { // size
                        $packageValidationCount++;
                     }
                }elseif(count($length_arr) > 0){
                    foreach ($length_arr as $length_index => $length) { // length
                        $packageValidationCount++;
                     }
                }elseif(count($height_arr) > 0){
                    foreach ($height_arr as $height_index => $height) { // width
                        $packageValidationCount++;
                     }
                }elseif(count($width_arr) > 0){
                    foreach ($width_arr as $widdth_index => $width) { // height
                        $packageValidationCount++;
                     }
                }else{
                    $packageValidationCount++;
                }


              
                if($item_temp[$CategoryIndex] != null){
                    // Check Subcategory
                   
                    $chk = Category::whereIn('id', $scoped_category->pluck('id'))->where('name',$item_temp[$CategoryIndex])->first();
                    if(!$chk){
                        return back()->with('error',$item_temp[$CategoryIndex]." is neither found in your category nor industry categories please check spelling and try again at Row:".$row_number);
                    }else{
                        $subCategory = Category::where('parent_id', $chk->id)->where('name',$item_temp[$SubCategoryIndex])->first();
                        if(!$subCategory){
                             return back()->with('error',$item_temp[$SubCategoryIndex]." is not exists under ".$chk->name." category please check spelling and try again at Row:".$row_number);
                        }
                    }
                }else{
                     return back()->with('error',"Category field is required at Row:".$row_number);
                }
                 // Check Input color is exists or not Start
                    $colors = ProductAttribute::whereName('Color')->first();
                    if(!$colors || $colors->value == null){
                        return back()->with('error', 'Color attributes not exists. Please ask admin to add');
                    }
                    $color_collection = json_decode($colors->value);
                    $color_collection = explode(',',$color_collection[0]) ?? '';
                    foreach($colors_arr as $color_temp){
                        if (!in_array(trim($color_temp),$color_collection)) {
                             return back()->with('error',trim($color_temp).' Color is not exists at Row:'.$row_number);
                        }
                    }
                // Check Input color is exists or not End

                // Check Input size is exists or not Start
                    $sizes = ProductAttribute::whereName('Size')->first();
                    if(!$sizes || $sizes->value == null){
                         return back()->with('error','Size attributes not exists. Please ask admin to add');
                    }
                    $size_collection = json_decode($sizes->value);
                    $size_collection = explode(',',$size_collection[0]) ?? '';
                    $sizes_arr;
                    foreach($sizes_arr as $size_temp){
                        if (!in_array(trim($size_temp),$size_collection)) {
                             return back()->with('error',trim($size_temp).' Size is not exists at Row:'.$row_number);
                        }
                    }
                
                    // return dd($sizes_arr);
                if($rate_type){
                   
                    if(($rate_type == "color" || $rate_type == "Color" || $rate_type == "Colour" || $rate_type == "colour") ){
                        if(count($colors_arr) != count($rates)){
                          
                            return back()->with('error', 'Color & Rates Ratios is different at Row:'.$row_number);
                        }elseif(count($rates) == 0 || count($colors_arr) == 0){
                   
                             return back()->with('error', 'You can not select rate type if no color variant added error in Row:'.$row_number);
                        }
                    }elseif($rate_type == "size" || $rate_type == "Size"){
                        if(count($sizes_arr) != count($rates)){
                             return back()->with('error', 'Size & Rates Ratios is different at Row:'.$row_number);
                        }elseif(count($rates) == 0 || count($sizes_arr) == 0){
                             return back()->with('error', 'You cann\'t select rate type if no size varient added error in Row:'.$row_number);                            
                        }
                    }else{
                        return back()->with('error', 'Rate Type is wrong spell at Row:'.$row_number);
                    }
                }
        
                // Hsn Percent
                if (isset($item_temp[$HsnPercentIndex]) && is_numeric($item_temp[$HsnPercentIndex]) != 1) {
                     return back()->with('error', 'Please use only numeric value in Hsn Percent column'.$item_temp[$HsnPercentIndex]);
                }
            }elseif($item_temp[$TitleIndex] == null && $item_temp[$CategoryIndex] != null && $item_temp[$SubCategoryIndex] != null){
                return back()->with('error',"Title can not be empty at Row:".$row_number);
            }
            
        }

        // $productCount = UserShopItem::where('user_id',auth()->id())->get()->count();
        $productCount = Product::where('user_id',auth()->id())->get()->count();
        $packageValidationCount;
        if(($productCount +  $packageValidationCount) > $product_uploads){
            if($product_uploads > $productCount){
                $limit = $product_uploads - $productCount;
            }else{
                $limit = $productCount - $product_uploads;
            }
            return back()->with('error','Your product limit is expired!');
        }
        foreach ($master as $index => $item) {
            if ($item[$TitleIndex] != null) {
                // SKU Generation
                $sku_code = 'SKU'.generateRandomStringNative(6);
                $category = Category::whereIn('id', $scoped_category->pluck('id'))->where('name',$item[$CategoryIndex])->first();
                $subcategory = Category::where('parent_id', $category->id)->where('name',$item[$SubCategoryIndex])->first();
                $colors_arr = $item[$ColorIndex] != null ? array_unique(explode("^^",$item[$ColorIndex])) : [];
                $sizes_arr = $item[$SizeIndex] != null ? array_unique(explode("^^",$item[$SizeIndex])) : [];
                $mrp_arr = $item[$MRPIndex] != null ? array_unique(explode("^^",$item[$MRPIndex])) : [];
                $rates = $item[$RateIndex] != null ? (explode("^^",$item[$RateIndex])) : [];
                $rate_type = $item[$RateTypeIndex] != null ? $item[$RateTypeIndex] : null;

                
                $length_arr = $item_temp[$LengthIndex] != null ? (explode("^^",$item_temp[$LengthIndex])) : null;
                $height_arr = $item_temp[$HeightIndex] != null ? (explode("^^",$item_temp[$HeightIndex])) : null;
                $width_arr = $item_temp[$WidthIndex] != null ? (explode("^^",$item_temp[$WidthIndex])) : null;
    
                // Price Group
                $shop_price_arr = $item_temp[$ShopPriceIndex] != null ? (explode("^^",$item_temp[$ShopPriceIndex])) : null;
                $reseller_price_arr = $item_temp[$ResellerPriceIndex] != null ? (explode("^^",$item_temp[$ResellerPriceIndex])) : null;
                $vip_price_arr = $item_temp[$VipPriceIndex] != null ? (explode("^^",$item_temp[$VipPriceIndex])) : null;

                $reseller_group = Group::whereUserId(auth()->id())->where('name',"Reseller")->first();
                if(!$reseller_group){
                   $reseller_group = Group::create([
                        'user_id' => auth()->id(),
                        'name' => "Reseller",
                        'type' => 0,
                    ]);
                }

                $vip_group = Group::whereUserId(auth()->id())->where('name',"VIP")->first();
                 if(!$vip_group){
                  $vip_group =  Group::create([
                        'user_id' => auth()->id(),
                        'name' => "VIP",
                        'type' => 0,
                    ]);
                }
                

                $carton_details = [
                   'standard_carton' => $item[$StandardCartonIndex],
                   'carton_weight' => $item[$CartonWeightIndex],
                   'carton_unit' => $item[$CartonUnitIndex],
                ];

                $shipping = [
                    'height' => $item[$HeightIndex],
                    'weight' => $item[$WeightIndex],
                    'width' => $item[$WidthIndex],
                    'length' => $item[$LengthIndex],
                    'unit' => $item[$WeightUnitIndex],
                    'length_unit' => $item[$LengthUnitIndex],
                ];
         
                $carton_details = json_encode($carton_details);
                $shipping = json_encode($shipping);

                // color size condition on create
                if(count($colors_arr) > 0 && count($sizes_arr) > 0){
                    // return dd('a');
                    foreach ($colors_arr as $color_index => $color) {
                        foreach ($sizes_arr as $size_index => $size) {
                                $price = $item[$ShopPriceIndex] ?? 0;
                                $mrp = $item[$MRPIndex] ?? $price;
                                $length = $item[$LengthIndex]  ?? null;
                                $width = $item[$WidthIndex]  ?? null;
                                $height = $item[$HeightIndex]  ?? null;
                                $shopprice = $item[$ShopPriceIndex]  ?? $price;
                                $resellerp = $item[$ResellerPriceIndex]  ?? $price;
                                $vipp = $item[$VipPriceIndex]  ?? $price;



                                $shopprice = $item[$ShopPriceIndex] ?? $price;
                                if(count($rates) > 0 && $rate_type == "color" || $rate_type == "Color" || $rate_type == "size" || $rate_type == "Size" || $rate_type == "Colour"){
                                    // For Color Wise
                                    if($rate_type == "color" || $rate_type == "Color" || $rate_type == "Colour"){
                                        $price = $rates[$color_index] ?? $price;
                                        $mrp = $mrp_arr[$color_index] ?? $price;
                                        $length = $length_arr[$color_index] ?? $price;
                                        $width = $width_arr[$color_index] ?? $price;
                                        $height = $height_arr[$color_index] ?? $price;
                                        $shopprice = $shop_price_arr[$color_index] ?? $price;
                                        $resellerp = $reseller_price_arr[$color_index] ?? $price;
                                        $vipp = $vip_price_arr0[$color_index] ?? $price;
                                    } 
                                    // For Size Wise
                                    if($rate_type == "size" || $rate_type == "Size"){
                                        $price = $rates[$size_index] ?? $price;
                                        $mrp = $mrp_arr[$size_index] ?? $price;
                                        $length = $length_arr[$size_index] ?? $price;
                                        $width = $width_arr[$size_index] ?? $price;
                                        $height = $height_arr[$size_index] ?? $price;
                                        $shopprice = $shop_price_arr[$size_index] ?? $price;
                                        $resellerp = $reseller_price_arr[$size_index] ?? $price;
                                        $vipp = $vip_price_arr0[$size_index] ?? $price;
                                    }
                                }
                                // Create Product code
                                $unique_slug  = getUniqueProductSlug($item[$TitleIndex]);


                                $shipping = [
                                    'height' => $height ?? null,
                                    'weight' => $item[$WeightIndex],
                                    'width' => $width ?? null,
                                    'length' => $length ?? null,
                                    'unit' => $item[$WeightUnitIndex],
                                    'length_unit' => $item[$LengthUnitIndex],
                                ];

                                $shipping = json_encode($shipping);

    

                                $productObj = Product::create([
                                    'title' => $item[$TitleIndex],
                                    'model_code' => $item[$ModelCodeIndex],
                                    'category_id' => $category->id,
                                    'brand_id' => $brandid ?? 0,
                                    'user_id' => auth()->id(),
                                    'sub_category' => $subcategory->id,
                                    'sku' => $sku_code,
                                    'slug' => $unique_slug,
                                    'color' => trim($color),
                                    'size' => trim($size),
                                    'description' => $item[$DescriptionIndex],
                                    'carton_details' => $carton_details,
                                    'shipping' => $shipping,
                                    'manage_inventory' => null,
                                    'stock_qty' => 0,
                                    'status' => 0,
                                    'is_publish' => 1,
                                    'price' => trim($shopprice) ?? $price,
                                    'min_sell_pr_without_gst' => $item[$MinimumSellingPriceWithoutGST] ?? null, 
                                    'hsn' => $item[$HSNTaxIndex] ?? null,
                                    'hsn_percent' => $item[$HsnPercentIndex] ?? null,
                                    'mrp' => trim($mrp),                     
                                    'video_url' => $item[$VideoURLIndex],                         
                                    'tag1' => $item[$Tag1Index],                         
                                    'tag2' => $item[$Tag2Index],                         
                                    'tag3' => $item[$Tag3Index],                         
                                    'meta_description' => $item[$MetaDescriptionIndex],                         
                                    'meta_keywords' => $item[$MetaKeywordsIndex] ?? null,  
                                    'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                ]);

                                // Create USI Rec
                                $usi = UserShopItem::create([
                                    'user_id'=>auth()->id(),
                                    'category_id'=>$category->id,
                                    'sub_category_id'=>$subcategory->id,
                                    'product_id'=>$productObj->id,
                                    'user_shop_id'=>UserShopIdByUserId(auth()->id()),
                                    'parent_shop_id'=>0,
                                    'is_published'=>1,
                                    'price'=> $price,
                                ]);
    
                                // if($rate_type == ''){
                                    $price = $item[$ResellerPriceIndex] ?? $price;
                                // }
    
                                if($reseller_group){
    
                                    // create Reseller Group record
                                  $g_p =  GroupProduct::create([
                                        'group_id'=>$reseller_group->id,
                                        'product_id'=>$productObj->id,
                                        'price'=> $resellerp,
                                    ]);
                                }
                          
                                // if($rate_type == ''){
                                    $price = $item[$VipPriceIndex] ?? 0;
                                // }
                                if($vip_group){
                                    // create Vip Group record
                                    GroupProduct::create([
                                        'group_id'=>$vip_group->id,
                                        'product_id'=>$productObj->id,
                                        'price'=>  $vipp,
                                    ]);
                                }
                                $arr_images = [];
                                // New Create Media
                                
                                if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImageMainIndex];
                                    $media->path = "storage/files/".auth()->id()."/".$item[$ImageMainIndex];
                                    $media->extension = explode('.',$item[$ImageMainIndex])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                                if(isset($item[$ImageFrontIndex]) && $item[$ImageFrontIndex] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImageFrontIndex];
                                    $media->path = "storage/files/".auth()->id()."/".$item[$ImageFrontIndex];
                                    $media->extension = explode('.',$item[$ImageFrontIndex])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                                if(isset($item[$ImageBackIndex]) && $item[$ImageBackIndex] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImageBackIndex];
                                    $media->path = "storage/files/".auth()->id()."/".$item[$ImageBackIndex];
                                    $media->extension = explode('.',$item[$ImageBackIndex])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                                if(isset($item[$ImageSide1Index]) && $item[$ImageSide1Index] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImageSide1Index];
                                    $media->path = "storage/files/".auth()->id()."/".$item[$ImageSide1Index];
                                    $media->extension = explode('.',$item[$ImageSide1Index])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                                if(isset($item[$ImageSide2Index]) && $item[$ImageSide2Index] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImageSide2Index];
                                    $media->path = "storage/files/".auth()->id()."/".$item[$ImageSide2Index];
                                    $media->extension = explode('.',$item[$ImageSide2Index])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }   
                                if(isset($item[$ImagePosterIndex]) && $item[$ImagePosterIndex] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImagePosterIndex];
                                    $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                                    $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                                // Add images to UserShopItem
                                if(count($arr_images) > 0) {
                                    $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                    $usi->save();
                                }
                                if($productObj){
                                    ++$count;
                                }


                                // ! Create Brand Product If Not Exists
                                
                                if ($brandid != null && $brandid != 0) {
                                    // ! Check Brand Product Exist or Not.
                                    $chk_brand_product = DB::table('brand_product')->where('brand_id','=',$brandid)->where('model_code','=',$item[$ModelCodeIndex])->get(); 
                                    if ($chk_brand_product->count() == 0){
                                            // ! Adding Product to Brand Products
                                            $productObj = brand_product::create([
                                                'title' => $item[$TitleIndex],
                                                'model_code' => $item[$ModelCodeIndex],
                                                'cat_id' => $category->id,
                                                'brand_id' => $brandid ?? 0,
                                                'sub_category' => $subcategory->id,
                                                'sku' => $sku_code,
                                                'color' => trim($color),
                                                'size' => trim($size),
                                                'description' => $item[$DescriptionIndex],
                                                'carton_details' => $carton_details,
                                                'shipping' => $shipping,
                                                'manage_inventory' => null,
                                                'status' => 0,
                                                'price' => trim($shopprice) ?? $price,
                                                'min_sell_pr_without_gst' => $item[$MinimumSellingPriceWithoutGST] ?? null, 
                                                'hsn' => $item[$HSNTaxIndex] ?? null,
                                                'hsn_percent' => $item[$HsnPercentIndex] ?? null,
                                                'mrp' => trim($mrp),                     
                                                'video_url' => $item[$VideoURLIndex],                         
                                                'tag_1' => $item[$Tag1Index],                         
                                                'tag_2' => $item[$Tag2Index],                         
                                                'tag_3' => $item[$Tag3Index],                         
                                                'meta_desc' => $item[$MetaDescriptionIndex],                         
                                                'meta_key' => $item[$MetaKeywordsIndex] ?? null,  
                                                'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                            ]);

                                            // ! New Create Media
                                
                                            if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null`){
                                                $media = new Media();
                                                $media->tag = "Product_Image";
                                                $media->file_type = "Image";
                                                $media->type = "Product";
                                                $media->type_id = $productObj->id;
                                                $media->file_name = $item[$ImageMainIndex];
                                                $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageMainIndex];
                                                $media->extension = explode('.',$item[$ImageMainIndex])[1] ?? '';
                                                $media->save();
                                                $arr_images[] = $media->id;
                                            }
                                            if(isset($item[$ImageFrontIndex]) && $item[$ImageFrontIndex] != null){
                                                $media = new Media();
                                                $media->tag = "Product_Image";
                                                $media->file_type = "Image";
                                                $media->type = "Product";
                                                $media->type_id = $productObj->id;
                                                $media->file_name = $item[$ImageFrontIndex];
                                                $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageFrontIndex];
                                                $media->extension = explode('.',$item[$ImageFrontIndex])[1] ?? '';
                                                $media->save();
                                                $arr_images[] = $media->id;
                                            }
                                            if(isset($item[$ImageBackIndex]) && $item[$ImageBackIndex] != null){
                                                $media = new Media();
                                                $media->tag = "Product_Image";
                                                $media->file_type = "Image";
                                                $media->type = "Product";
                                                $media->type_id = $productObj->id;
                                                $media->file_name = $item[$ImageBackIndex];
                                                $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageBackIndex];
                                                $media->extension = explode('.',$item[$ImageBackIndex])[1] ?? '';
                                                $media->save();
                                                $arr_images[] = $media->id;
                                            }
                                            if(isset($item[$ImageSide1Index]) && $item[$ImageSide1Index] != null){
                                                $media = new Media();
                                                $media->tag = "Product_Image";
                                                $media->file_type = "Image";
                                                $media->type = "Product";
                                                $media->type_id = $productObj->id;
                                                $media->file_name = $item[$ImageSide1Index];
                                                $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageSide1Index];
                                                $media->extension = explode('.',$item[$ImageSide1Index])[1] ?? '';
                                                $media->save();
                                                $arr_images[] = $media->id;
                                            }
                                            if(isset($item[$ImageSide2Index]) && $item[$ImageSide2Index] != null){
                                                $media = new Media();
                                                $media->tag = "Product_Image";
                                                $media->file_type = "Image";
                                                $media->type = "Product";
                                                $media->type_id = $productObj->id;
                                                $media->file_name = $item[$ImageSide2Index];
                                                $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageSide2Index];
                                                $media->extension = explode('.',$item[$ImageSide2Index])[1] ?? '';
                                                $media->save();
                                                $arr_images[] = $media->id;
                                            }   
                                            if(isset($item[$ImagePosterIndex]) && $item[$ImagePosterIndex] != null){
                                                $media = new Media();
                                                $media->tag = "Product_Image";
                                                $media->file_type = "Image";
                                                $media->type = "Product";
                                                $media->type_id = $productObj->id;
                                                $media->file_name = $item[$ImagePosterIndex];
                                                $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImagePosterIndex];
                                                $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                                $media->save();
                                                $arr_images[] = $media->id;
                                            }
                                            // ! New Image Creation End
                                        
                                    }
                               }




                                
                        }   
                    } 
                }elseif(count($colors_arr) > 0){
                    // return dd('b');
                    foreach ($colors_arr as $color_index => $color) {
                        $price = $item[$ShopPriceIndex] ?? 0;

                        if(count($rates) > 0 && $rate_type == "color" || $rate_type = "Color"){
                            // For Color Wise
                            if($rate_type == "color" || $rate_type = "Color"){
                                $price = $rates[$color_index] ?? $price;
                            }
                        }
                        // Create Product code
                        $unique_slug  = getUniqueProductSlug($item[$TitleIndex]);
                        $productObj = Product::create([
                            'title' => $item[$TitleIndex],
                            'model_code' => $item[$ModelCodeIndex],
                            'category_id' => $category->id,
                            'brand_id' => $request->brand_id??0,
                            'user_id' => auth()->id(),
                            'sub_category' => $subcategory->id,
                            'sku' => $sku_code,
                            'slug' => $unique_slug,
                            'color' => trim($color),
                            'size' => null,
                            'description' => $item[$DescriptionIndex],
                            'carton_details' => $carton_details,
                            'shipping' => $shipping,
                            'manage_inventory' => null,
                            'stock_qty' => 0,
                            'status' => 0,
                            'is_publish' => 1,
                            'price' => $price,
                            'hsn' => $item[$HSNTaxIndex],
                            'min_sell_pr_without_gst' => $item[$MinimumSellingPriceWithoutGST] ?? null, 
                            'hsn_percent' => $item[$HsnPercentIndex],
                            'mrp' => $item[$MRPIndex]??null,                     
                            'video_url' => $item[$VideoURLIndex],                         
                            'tag1' => $item[$Tag1Index],                         
                            'tag2' => $item[$Tag2Index],                         
                            'tag3' => $item[$Tag3Index],                         
                            'meta_description' => $item[$MetaDescriptionIndex],                         
                            'meta_keywords' => $item[$MetaKeywordsIndex] ?? null,  
                            'artwork_url' => $item[$artwork_urlIndex] ?? null,
                        ]);


                        // ! Create Brand Product If Not Exists
                                
                        if ($brandid != null && $brandid != 0) {
                        // ! Check Brand Product Exist or Not.
                        $chk_brand_product = DB::table('products')->where('brand_id','=',$brandid)->where('model_code','=',$item[$ModelCodeIndex])->get(); 
                        if ($chk_brand_product->count() == 0){
                                // ! Adding Product to Brand Products
                                $productObj = brand_product::create([
                                    'title' => $item[$TitleIndex],
                                    'model_code' => $item[$ModelCodeIndex],
                                    'cat_id' => $category->id,
                                    'brand_id' => $brandid ?? 0,
                                    'sub_category' => $subcategory->id,
                                    'sku' => $sku_code,
                                    'color' => trim($color),
                                    'size' => trim($size),
                                    'description' => $item[$DescriptionIndex],
                                    'carton_details' => $carton_details,
                                    'shipping' => $shipping,
                                    'manage_inventory' => null,
                                    'status' => 0,
                                    'price' => $price ?? 0,
                                    'min_sell_pr_without_gst' => $item[$MinimumSellingPriceWithoutGST] ?? null, 
                                    'hsn' => $item[$HSNTaxIndex] ?? null,
                                    'hsn_percent' => $item[$HsnPercentIndex] ?? null,
                                    'mrp' => trim($mrp),                     
                                    'video_url' => $item[$VideoURLIndex],                         
                                    'tag_1' => $item[$Tag1Index],                         
                                    'tag_2' => $item[$Tag2Index],                         
                                    'tag_3' => $item[$Tag3Index],                         
                                    'meta_desc' => $item[$MetaDescriptionIndex],                         
                                    'meta_key' => $item[$MetaKeywordsIndex] ?? null,  
                                    'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                ]);

                                // ! New Create Media
                    
                                if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImageMainIndex];
                                    $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageMainIndex];
                                    $media->extension = explode('.',$item[$ImageMainIndex])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                                if(isset($item[$ImageFrontIndex]) && $item[$ImageFrontIndex] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImageFrontIndex];
                                    $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageFrontIndex];
                                    $media->extension = explode('.',$item[$ImageFrontIndex])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                                if(isset($item[$ImageBackIndex]) && $item[$ImageBackIndex] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImageBackIndex];
                                    $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageBackIndex];
                                    $media->extension = explode('.',$item[$ImageBackIndex])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                                if(isset($item[$ImageSide1Index]) && $item[$ImageSide1Index] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImageSide1Index];
                                    $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageSide1Index];
                                    $media->extension = explode('.',$item[$ImageSide1Index])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                                if(isset($item[$ImageSide2Index]) && $item[$ImageSide2Index] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImageSide2Index];
                                    $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageSide2Index];
                                    $media->extension = explode('.',$item[$ImageSide2Index])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }   
                                if(isset($item[$ImagePosterIndex]) && $item[$ImagePosterIndex] != null){
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $productObj->id;
                                    $media->file_name = $item[$ImagePosterIndex];
                                    $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImagePosterIndex];
                                    $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                                // ! New Image Creation End
                            
                        }
                        }


                        // Create USI Rec
                        $usi = UserShopItem::create([
                            'user_id'=>auth()->id(),
                            'category_id'=>$category->id,
                            'sub_category_id'=>$subcategory->id,
                            'product_id'=>$productObj->id,
                            'user_shop_id'=>UserShopIdByUserId(auth()->id()),
                            'parent_shop_id'=>0,
                            'is_published'=>1,
                            'price'=>$item[$ShopPriceIndex]??$price,
                        ]);
                        if($reseller_group){
                            // create Reseller Group record
                            GroupProduct::create([
                                'group_id'=>$reseller_group->id,
                                'product_id'=>$productObj->id,
                                'price'=>$item[$ResellerPriceIndex] ?? $price,
                            ]);
                        }
                        if($vip_group){
                            // create Vip Group record
                            GroupProduct::create([
                                'group_id'=>$vip_group->id,
                                'product_id'=>$productObj->id,
                                'price'=>$item[$VipPriceIndex]??$price,
                            ]);
                        }
                        $arr_images = [];
                        // New Create Media
                        if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageMainIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageMainIndex];
                            $media->extension = explode('.',$item[$ImageMainIndex])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }
                        if(isset($item[$ImageFrontIndex]) && $item[$ImageFrontIndex] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageFrontIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageFrontIndex];
                            $media->extension = explode('.',$item[$ImageFrontIndex])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }
                        if(isset($item[$ImageBackIndex]) && $item[$ImageBackIndex] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageBackIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageBackIndex];
                            $media->extension = explode('.',$item[$ImageBackIndex])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }
                        if(isset($item[$ImageSide1Index]) && $item[$ImageSide1Index] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageSide1Index];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageSide1Index];
                            $media->extension = explode('.',$item[$ImageSide1Index])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }
                        if(isset($item[$ImageSide2Index]) && $item[$ImageSide2Index] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageSide2Index];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageSide2Index];
                            $media->extension = explode('.',$item[$ImageSide2Index])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }   
                        if(isset($item[$ImagePosterIndex]) && $item[$ImagePosterIndex] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImagePosterIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                            $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }
                        // Add images to UserShopItem
                        if(count($arr_images) > 0) {
                        $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                        $usi->save();
                        }
                        if($productObj){
                            ++$count;
                        }
                    }
                }elseif(count($sizes_arr) > 0){
                    foreach ($sizes_arr as $size_index => $size) {
                        $price = $item[$ShopPriceIndex] ?? 0;
                        if(count($rates) > 0 && $rate_type == "size" || $rate_type == "Size"){
                            // For Size Wise
                            if($rate_type == "size" || $rate_type == "Size"){
                                $price = $rates[$size_index] ?? $price;
                            }
                        }
                        // Create Product code
                        $unique_slug  = getUniqueProductSlug($item[$TitleIndex]);
                        $productObj = Product::create([
                            'title' => $item[$TitleIndex],
                            'model_code' => $item[$ModelCodeIndex],
                            'category_id' => $category->id,
                            'brand_id' => $request->brand_id??0,
                            'user_id' => auth()->id(),
                            'sub_category' => $subcategory->id,
                            'sku' => $sku_code,
                            'slug' => $unique_slug,
                            'color' => null,
                            'size' => trim($size),
                            'description' => $item[$DescriptionIndex],
                            'carton_details' => $carton_details,
                            'shipping' => $shipping,
                            'manage_inventory' => null,
                            'stock_qty' => 0,
                            'status' => 0,
                            'is_publish' => 1,
                            'price' => $price,
                            'min_sell_pr_without_gst' => $item[$MinimumSellingPriceWithoutGST] ?? null, 
                            'hsn' => $item[$HSNTaxIndex],
                            'hsn_percent' => $item[$HsnPercentIndex],
                            'mrp' => $item[$MRPIndex]??null,                     
                            'video_url' => $item[$VideoURLIndex],                         
                            'tag1' => $item[$Tag1Index],                         
                            'tag2' => $item[$Tag2Index],                         
                            'tag3' => $item[$Tag3Index],                         
                            'meta_description' => $item[$MetaDescriptionIndex],                         
                            'meta_keywords' => $item[$MetaKeywordsIndex] ?? null,  
                            'artwork_url' => $item[$artwork_urlIndex] ?? null,
                        ]);

                        // Create USI Rec
                        $usi = UserShopItem::create([
                            'user_id'=>auth()->id(),
                            'category_id'=>$category->id,
                            'sub_category_id'=>$subcategory->id,
                            'product_id'=>$productObj->id,
                            'user_shop_id'=>UserShopIdByUserId(auth()->id()),
                            'parent_shop_id'=>0,
                            'is_published'=>1,
                            'price'=>$item[$ShopPriceIndex]??$price,
                        ]);
                        if($reseller_group){
                            // create Reseller Group record
                            GroupProduct::create([
                                'group_id'=>$reseller_group->id,
                                'product_id'=>$productObj->id,
                                'price'=>$item[$ResellerPriceIndex]??$price,
                            ]);
                        }
                        if($vip_group){
                            // create Vip Group record
                            GroupProduct::create([
                                'group_id'=>$vip_group->id,
                                'product_id'=>$productObj->id,
                                'price'=>$item[$VipPriceIndex]??$price,
                            ]);
                        }
                        $arr_images = [];
                        // New Create Media
                        if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageMainIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageMainIndex];
                            $media->extension = explode('.',$item[$ImageMainIndex])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }
                        if(isset($item[$ImageFrontIndex]) && $item[$ImageFrontIndex] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageFrontIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageFrontIndex];
                            $media->extension = explode('.',$item[$ImageFrontIndex])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }
                        if(isset($item[$ImageBackIndex]) && $item[$ImageBackIndex] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageBackIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageBackIndex];
                            $media->extension = explode('.',$item[$ImageBackIndex])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }
                        if(isset($item[$ImageSide1Index]) && $item[$ImageSide1Index] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageSide1Index];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageSide1Index];
                            $media->extension = explode('.',$item[$ImageSide1Index])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }
                        if(isset($item[$ImageSide2Index]) && $item[$ImageSide2Index] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageSide2Index];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageSide2Index];
                            $media->extension = explode('.',$item[$ImageSide2Index])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }   
                        if(isset($item[$ImagePosterIndex]) && $item[$ImagePosterIndex] != null){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImagePosterIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                            $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                        }
                        // Add images to UserShopItem
                        if(count($arr_images) > 0) {
                        $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                        $usi->save();
                        }
                        if($productObj){
                            ++$count;
                        }


                        // ! Create Brand Product If Not Exists
                                
                        if ($brandid != null && $brandid != 0) {
                        
                            // ! Check Brand Product Exist or Not.
                            $chk_brand_product = DB::table('brand_product')->where('brand_id','=',$brandid)->where('model_code','=',$item[$ModelCodeIndex])->get(); 
                            if ($chk_brand_product->count() == 0){
                                    // ! Adding Product to Brand Products
                                    $productObj = brand_product::create([
                                        'title' => $item[$TitleIndex],
                                        'model_code' => $item[$ModelCodeIndex],
                                        'cat_id' => $category->id,
                                        'brand_id' => $brandid ?? 0,
                                        'sub_category' => $subcategory->id,
                                        'sku' => $sku_code,
                                        'color' => trim($color),
                                        'size' => trim($size),
                                        'description' => $item[$DescriptionIndex],
                                        'carton_details' => $carton_details,
                                        'shipping' => $shipping,
                                        'manage_inventory' => null,
                                        'status' => 0,
                                        'price' => $price ?? 0,
                                        'min_sell_pr_without_gst' => $item[$MinimumSellingPriceWithoutGST] ?? null, 
                                        'hsn' => $item[$HSNTaxIndex] ?? null,
                                        'hsn_percent' => $item[$HsnPercentIndex] ?? null,
                                        'mrp' => trim($mrp),                     
                                        'video_url' => $item[$VideoURLIndex],                         
                                        'tag_1' => $item[$Tag1Index],                         
                                        'tag_2' => $item[$Tag2Index],                         
                                        'tag_3' => $item[$Tag3Index],                         
                                        'meta_desc' => $item[$MetaDescriptionIndex],                         
                                        'meta_key' => $item[$MetaKeywordsIndex] ?? null,  
                                        'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                    ]);

                                    // ! New Create Media
                        
                                    if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImageMainIndex];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageMainIndex];
                                        $media->extension = explode('.',$item[$ImageMainIndex])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                    if(isset($item[$ImageFrontIndex]) && $item[$ImageFrontIndex] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImageFrontIndex];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageFrontIndex];
                                        $media->extension = explode('.',$item[$ImageFrontIndex])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                    if(isset($item[$ImageBackIndex]) && $item[$ImageBackIndex] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImageBackIndex];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageBackIndex];
                                        $media->extension = explode('.',$item[$ImageBackIndex])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                    if(isset($item[$ImageSide1Index]) && $item[$ImageSide1Index] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImageSide1Index];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageSide1Index];
                                        $media->extension = explode('.',$item[$ImageSide1Index])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                    if(isset($item[$ImageSide2Index]) && $item[$ImageSide2Index] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImageSide2Index];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageSide2Index];
                                        $media->extension = explode('.',$item[$ImageSide2Index])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }   
                                    if(isset($item[$ImagePosterIndex]) && $item[$ImagePosterIndex] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImagePosterIndex];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImagePosterIndex];
                                        $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                    // ! New Image Creation End
                                
                            }
                        }



                    }
                }else{
                    // return dd('d');
                    // Use Product Price
                    $unique_slug  = getUniqueProductSlug($item[$TitleIndex]);
                    $productObj = Product::create([
                        'title' => $item[$TitleIndex],
                        'model_code' => $item[$ModelCodeIndex],
                        'category_id' => $category->id,
                        'brand_id' => $request->brand_id??0,
                        'user_id' => auth()->id(),
                        'sub_category' => $subcategory->id,
                        'sku' => $sku_code,
                        'slug' => $unique_slug,
                        'color' => null,
                        'size' => null,
                        'description' => $item[$DescriptionIndex],
                        'carton_details' => $carton_details,
                        'shipping' => $shipping,
                        'manage_inventory' => null,
                        'stock_qty' => 0,
                        'status' => 0,
                        'is_publish' => 1,
                        'min_sell_pr_without_gst' => $item[$MinimumSellingPriceWithoutGST] ?? 0, 
                        'hsn' => $item[$HSNTaxIndex],
                        'hsn_percent' => $item[$HsnPercentIndex],
                        'mrp' => $item[$MRPIndex]??null,                     
                        'video_url' => $item[$VideoURLIndex],                         
                        'tag1' => $item[$Tag1Index],                         
                        'tag2' => $item[$Tag2Index],                         
                        'tag3' => $item[$Tag3Index],                         
                        'meta_description' => $item[$MetaDescriptionIndex],                         
                        'meta_keywords' => $item[$MetaKeywordsIndex] ?? null,  
                        'artwork_url' => $item[$artwork_urlIndex] ?? null,
                    ]);

                    // Create USI Rec
                    $usi = UserShopItem::create([
                        'user_id'=>auth()->id(),
                        'category_id'=>$category->id,
                        'sub_category_id'=>$subcategory->id,
                        'product_id'=>$productObj->id,
                        'user_shop_id'=>UserShopIdByUserId(auth()->id()),
                        'parent_shop_id'=>0,
                        'is_published'=>1,
                        'price'=>$item[$ShopPriceIndex]??$productObj->price,
                    ]);
                    if($reseller_group){
                        // create Reseller Group record
                        GroupProduct::create([
                            'group_id'=>$reseller_group->id,
                            'product_id'=>$productObj->id,
                            'price'=>$item[$ResellerPriceIndex]??$productObj->price,
                        ]);
                    }
                    if($vip_group){
                        // create Vip Group record
                        GroupProduct::create([
                            'group_id'=>$vip_group->id,
                            'product_id'=>$productObj->id,
                            'price'=>$item[$VipPriceIndex]??$productObj->price,
                        ]);
                    }
                    $arr_images = [];
                    // New Create Media
                    if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $productObj->id;
                        $media->file_name = $item[$ImageMainIndex];
                        $media->path = "storage/files/".auth()->id()."/".$item[$ImageMainIndex];
                        $media->extension = explode('.',$item[$ImageMainIndex])[1] ?? '';
                        $media->save();
                        $arr_images[] = $media->id;
                    }
                    if(isset($item[$ImageFrontIndex]) && $item[$ImageFrontIndex] != null){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $productObj->id;
                        $media->file_name = $item[$ImageFrontIndex];
                        $media->path = "storage/files/".auth()->id()."/".$item[$ImageFrontIndex];
                        $media->extension = explode('.',$item[$ImageFrontIndex])[1] ?? '';
                        $media->save();
                        $arr_images[] = $media->id;
                    }
                    if(isset($item[$ImageBackIndex]) && $item[$ImageBackIndex] != null){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $productObj->id;
                        $media->file_name = $item[$ImageBackIndex];
                        $media->path = "storage/files/".auth()->id()."/".$item[$ImageBackIndex];
                        $media->extension = explode('.',$item[$ImageBackIndex])[1] ?? '';
                        $media->save();
                        $arr_images[] = $media->id;
                    }
                    if(isset($item[$ImageSide1Index]) && $item[$ImageSide1Index] != null){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $productObj->id;
                        $media->file_name = $item[$ImageSide1Index];
                        $media->path = "storage/files/".auth()->id()."/".$item[$ImageSide1Index];
                        $media->extension = explode('.',$item[$ImageSide1Index])[1] ?? '';
                        $media->save();
                        $arr_images[] = $media->id;
                    }
                    if(isset($item[$ImageSide2Index]) && $item[$ImageSide2Index] != null){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $productObj->id;
                        $media->file_name = $item[$ImageSide2Index];
                        $media->path = "storage/files/".auth()->id()."/".$item[$ImageSide2Index];
                        $media->extension = explode('.',$item[$ImageSide2Index])[1] ?? '';
                        $media->save();
                        $arr_images[] = $media->id;
                    }   
                    if(isset($item[$ImagePosterIndex]) && $item[$ImagePosterIndex] != null){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $productObj->id;
                        $media->file_name = $item[$ImagePosterIndex];
                        $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                        $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                        $media->save();
                        $arr_images[] = $media->id;
                    }
                    // Add images to UserShopItem
                    if(count($arr_images) > 0) {
                      $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                      $usi->save();
                    }
                    if($productObj){
                        ++$count;
                    }

                        // ! Create Brand Product If BNot Exists
                                
                        if ($brandid != null && $brandid != 0) {
                            // ! Check Brand Product Exist or Not.
                            $chk_brand_product = DB::table('brand_product')->where('brand_id','=',$brandid)->where('model_code','=',$item[$ModelCodeIndex])->get(); 
                            if ($chk_brand_product->count() == 0){
                                    // ! Adding Product to Brand Products
                                    $productObj = brand_product::create([
                                        'title' => $item[$TitleIndex],
                                        'model_code' => $item[$ModelCodeIndex],
                                        'cat_id' => $category->id,
                                        'brand_id' => $brandid ?? 0,
                                        'sub_category' => $subcategory->id,
                                        'sku' => $sku_code,
                                        'color' => trim($color),
                                        'size' => trim($size),
                                        'description' => $item[$DescriptionIndex],
                                        'carton_details' => $carton_details,
                                        'shipping' => $shipping,
                                        'manage_inventory' => null,
                                        'status' => 0,
                                        'price' => $price ?? 0,
                                        'min_sell_pr_without_gst' => $item[$MinimumSellingPriceWithoutGST] ?? null, 
                                        'hsn' => $item[$HSNTaxIndex] ?? null,
                                        'hsn_percent' => $item[$HsnPercentIndex] ?? null,
                                        'mrp' => trim($mrp),                     
                                        'video_url' => $item[$VideoURLIndex],                         
                                        'tag_1' => $item[$Tag1Index],                         
                                        'tag_2' => $item[$Tag2Index],                         
                                        'tag_3' => $item[$Tag3Index],                         
                                        'meta_desc' => $item[$MetaDescriptionIndex],                         
                                        'meta_key' => $item[$MetaKeywordsIndex] ?? null,  
                                        'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                    ]);

                                    // ! New Create Media
                        
                                    if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImageMainIndex];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageMainIndex];
                                        $media->extension = explode('.',$item[$ImageMainIndex])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                    if(isset($item[$ImageFrontIndex]) && $item[$ImageFrontIndex] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImageFrontIndex];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageFrontIndex];
                                        $media->extension = explode('.',$item[$ImageFrontIndex])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                    if(isset($item[$ImageBackIndex]) && $item[$ImageBackIndex] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImageBackIndex];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageBackIndex];
                                        $media->extension = explode('.',$item[$ImageBackIndex])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                    if(isset($item[$ImageSide1Index]) && $item[$ImageSide1Index] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImageSide1Index];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageSide1Index];
                                        $media->extension = explode('.',$item[$ImageSide1Index])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                    if(isset($item[$ImageSide2Index]) && $item[$ImageSide2Index] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImageSide2Index];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImageSide2Index];
                                        $media->extension = explode('.',$item[$ImageSide2Index])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }   
                                    if(isset($item[$ImagePosterIndex]) && $item[$ImagePosterIndex] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $productObj->id;
                                        $media->file_name = $item[$ImagePosterIndex];
                                        $media->path = "storage/uploads/brand_product".$brandid."/".$item[$ImagePosterIndex];
                                        $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                    // ! New Image Creation End
                                
                            }
                        }   



                }
            }
        }
        return redirect(route('panel.filemanager.index'))->with('success', 'Good News! '.$count.' records created successfully!');
    }

    public function categoryUpload(Request $request)
    {   
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = [];
        foreach ($worksheet->getRowIterator() AS $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }
        $head = array_shift($rows);
        $master = $rows;

        // Index
        $IndustryIndex = 0;
        $RemarkIndex = 1;
        $CategoryIndex = 2;
        $SubCategoryIndex = 3;
        
        // Data Tree
        $IndustryIndexobj = null;
        $CategoryIndexobj = null;
        $SubCategoryIndexobj = null;

        $IndustryArr = [];
        $CategoryArr = [];

        $master_obj = collect($master);
        
            
            foreach($master as $index => $item){
                $index = ++$index;
                // Category
                if($item[$IndustryIndex] != null){
                    $IndustryIndexobj = Category::create([
                        'name' => $item[$IndustryIndex],
                        'level' => 1,
                        'category_type_id' => 13,
                        'parent_id' => null,
                    ]);
                }
                
                //Category
                if($item[$CategoryIndex] != null){
                    $CategoryIndexobj = Category::create([
                        'name' => $item[$CategoryIndex],
                        'level' => 2,
                        'category_type_id' => 13,
                        'parent_id' =>  $IndustryIndexobj->id,
                    ]);
                }

                //SubCategory
                if($item[$SubCategoryIndex] != null){
                    $SubCategoryIndexObj = Category::create([
                    'name' => $item[$SubCategoryIndex],
                        'level' => 3,
                        'category_type_id' => 13,
                        'parent_id' => $CategoryIndexobj->id,
                    ]);
                }    
            ++$index;   
            }
            $count = $index;
            return back()->with('success', 'Done! '.$count.' records created successfully.');
    }

    public function productBulkUpdate(Request $request)
    {
   
        $count = 0;
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }
        $head = array_shift($rows);
        $master = $rows;
        // Index
        $IdIndex = 0;
        $CategoryIndex = 1;
        $SubCategoryIndex = 2;
        $TitleIndex = 3;
        $ModelCodeIndex = 4;
        $ImageMainIndex = 5;
        $ImageFrontIndex = 6;
        $ImageBackIndex = 7;
        $ImageSide1Index = 8;
        $ImageSide2Index = 9;
        $ImagePosterIndex = 10;
        $VideoURLIndex = 11;
        $Tag1Index = 12;
        $Tag2Index = 13;
        $Tag3Index = 14;
        $DescriptionIndex = 15;
        $WeightIndex = 16;
        $WeightUnitIndex = 17;
        $LengthIndex = 18;
        $WidthIndex = 19;
        $HeightIndex = 20;
        $LengthUnitIndex = 21;
        $StandardCartonIndex = 22;
        $CartonWeightIndex = 23;
        $CartonUnitIndex = 24;
        $ColorIndex = 25;
        $SizeIndex = 26;
        $MinimumSellingPriceWithoutGST = 27;
        $ShopPriceIndex = 28;
        $VipPriceIndex = 29;
        $ResellerPriceIndex = 30;
        $MRPIndex = 31;
        $HSNTaxIndex = 32;
        $HsnPercentIndex = 33;
        $MetaDescriptionIndex = 34;
        $MetaKeywordsIndex = 35;
        $artwork_urlIndex = 36;
        // $InventoryIndex = 36;
        $StockIndex = 36;
        // $StatusIndex = 37;
        $PublishIndex = 37;

        $productObj = null;
        $master_obj = collect($master);
      // Check Subcategory
        if(AuthRole() == "User"){
            $scoped_category = getProductCategoryByUserIndrustry(auth()->user()->industry_id);
        }else{
            $scoped_category = getProductCategory();
        }
        foreach ($master as $index => $item) {
            $row_number = $index + 2;
            if ($item[$TitleIndex] != null) {
                // SKU - TODO Later
                // check is User Product?
                if($item[$IdIndex]){
                    $chk = Product::whereId($item[$IdIndex])->whereUserId(auth()->id())->first();
                  
                   if(!$chk){
                      return back()->with("error",$item[$TitleIndex]." Product was not found (Possibly Deleted) at Row:".$row_number);
                   }
                }elseif($item[$IdIndex] == null){
                    return back()->with("error","ID is missing at Row:".$row_number." Please export again!");
                }


                // Check Category & sub Category 
                if($item[$CategoryIndex]){
                    $chk = Category::whereIn('id', $scoped_category->pluck('id'))->where('name',$item[$CategoryIndex])->first();
                    if(!$chk){
                        //    return $index+1;
                       return back()->with("error",$item[$CategoryIndex]."Category was not found (Possibly Deleted) at Row:".$row_number);
                    }else{
                        $subCategory = Category::where('parent_id', $chk->id)->where('name',$item[$SubCategoryIndex])->first();
                        if(!$subCategory){
                            return back()->with("error",$item[$SubCategoryIndex]." is not your sub category under ".$chk->name." category please check the data before upload at Row:".$row_number);
                        }
                    }
                }elseif($item[$CategoryIndex] != null){
                    return back()->with("error","Category not Found please check the data before upload at Row:".$row_number);
                }

                // Color
                if(trim($item[$ColorIndex]) != null){
                    $colors = ProductAttribute::whereName('Color')->first();
                    if(!$colors || $colors->value == null){
                      return back()->with("error",'Color attributes not exists. Please ask admin to add');
                    }
                    $color_collection = json_decode($colors->value);
                    $color_collection = explode(',',$color_collection[0]) ?? '';
                    if (!in_array(trim($item[$ColorIndex]),$color_collection)) {
                      return back()->with("error",'Color that you want to use is not exist. Please correct '.$item[$ColorIndex]);
                    }
                }

                // Size
                if(trim($item[$SizeIndex]) != null){
                    $sizes = ProductAttribute::whereName('Size')->first();
                    if(!$sizes || $sizes->value == null){
                       return back()->with("error",'Color attributes not exists. Please ask admin to add');
                     }
                    $size_collection = json_decode($sizes->value);
                    $size_collection = explode(',',$size_collection[0]) ?? '';
                     if (!in_array(trim($item[$SizeIndex]),$size_collection)) {
                       return back()->with("error",'Size that you want to use is not exisit. Please correct '.$item[$SizeIndex]);
                     }
                }

                // check duplication color size_collection
                if(trim($item[$ColorIndex]) && trim($item[$SizeIndex])){
                  $product = Product::whereId($item[$IdIndex])->whereUserId(auth()->id())->first();
                  $chk = Product::where('id','!=',$product->id)->where('sku','=',$product->sku)->where('color',trim($item[$ColorIndex]))->where('size',trim($item[$SizeIndex]))->first();
                  if($chk) {
                      return back()->with('error',"You already have same color and size product. Please check ".$row_number." row information.");
                  }
                }


                // Is Publish
                if ($item[$PublishIndex] != 0 && $item[$PublishIndex] != 1 && $item[$PublishIndex] != null) {
                   return back()->with("error",'Please use only 1 & 0 in Publish column'.$item[$PublishIndex]);
                }

                // Stock
                if ($item[$StockIndex] != null && is_numeric($item[$StockIndex]) != 1) {
                   return back()->with("error",'Please use only numeric value in Stock column');
                }

                // Hsn Percent
                if ($item[$HsnPercentIndex] != null && is_numeric($item[$HsnPercentIndex]) != 1) {
                   return back()->with("error",'Please use only numeric value in Hsn Percent column'.$item[$HsnPercentIndex]);
                }
            }            
        }

        foreach ($master as $index => $item) {

            $category = Category::whereIn('id', $scoped_category->pluck('id'))->where('name',$item[$CategoryIndex])->first();
            $subcategory = Category::where('parent_id', $category->id)->where('name',$item[$SubCategoryIndex])->first() ;

            if ($item[$TitleIndex] != null) { 
                $carton_details = [
                   'standard_carton' => $item[$StandardCartonIndex],
                   'carton_weight' => $item[$CartonWeightIndex],
                   'carton_unit' => $item[$CartonUnitIndex],
                ];
                $shipping = [
                    'height' => $item[$HeightIndex],
                    'weight' => $item[$WeightIndex],
                    'width' => $item[$WidthIndex],
                    'length' => $item[$LengthIndex],
                    'unit' => $item[$WeightUnitIndex],
                    'length_unit' => $item[$LengthUnitIndex],
                ];
                $carton_details = json_encode($carton_details);
                $shipping = json_encode($shipping);
                $productObj = Product::whereId($item[$IdIndex])->first();

                $usi = UserShopItem::whereUserId(auth()->id())->where('product_id',$productObj->id)->first();
                $reseller_group = Group::whereUserId(auth()->id())->where('name',"Reseller")->first();
                $vip_group = Group::whereUserId(auth()->id())->where('name',"VIP")->first();
                $reseller_group_product = GroupProduct::where('group_id',$reseller_group->id ?? 0)->where('product_id',$productObj->id)->first();
                $vip_group_product = GroupProduct::where('group_id',$vip_group->id??0)->where('product_id',$productObj->id)->first();

                 if ($productObj) {
                     $productObj->update([
                         'title' => $item[$TitleIndex],
                         'model_code' => $item[$ModelCodeIndex],
                         'category_id' => $category->id,
                         'sub_category' => $subcategory->id,
                         'user_id' => auth()->id(),
                         'color' => $item[$ColorIndex],
                         'size' => $item[$SizeIndex],
                         'description' => $item[$DescriptionIndex],
                         'carton_details' => $carton_details,
                         'shipping' => $shipping,
                         'stock_qty' => $item[$StockIndex],
                         'is_publish' => $item[$PublishIndex],
                         'min_sell_pr_without_gst' => $item[$MinimumSellingPriceWithoutGST] ?? 0,
                         'mrp' => $item[$MRPIndex]??null,
                         'hsn' => $item[$HSNTaxIndex],
                         'hsn_percent' => $item[$HsnPercentIndex],                         
                         'video_url' => $item[$VideoURLIndex],                         
                         'tag1' => $item[$Tag1Index],                         
                         'tag2' => $item[$Tag2Index],                         
                         'tag3' => $item[$Tag3Index],                         
                         'meta_description' => $item[$MetaDescriptionIndex],                         
                         'meta_keywords' => $item[$MetaKeywordsIndex] ?? null,          
                         'artwork_url' => $item[$artwork_urlIndex] ?? null,               
                    ]);

                    
                    if($usi){
                        $usi->is_published = $item[$PublishIndex];
                        $usi->price = $item[$ShopPriceIndex];
                        $usi->category_id = $category->id;
                        $usi->sub_category_id = $subcategory->id;
                        $usi->save();
                    }
                    if($reseller_group_product){
                        $reseller_group_product->price = $item[$ResellerPriceIndex];
                        $reseller_group_product->save();
                    }
                    if($vip_group_product){
                        $vip_group_product->price = $item[$VipPriceIndex]??0;
                        $vip_group_product->save();
                    }
                    
                    if(isset($productObj->medias[0]) && $productObj->medias[0]->id){
                        Media::whereId($productObj->medias[0]->id)->update([
                            'file_name' => $item[$ImageMainIndex],
                            'path' => "storage/files/".auth()->id()."/".$item[$ImageMainIndex]
                        ]);
                    }else{
                        if(isset($item[$ImageMainIndex])){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageMainIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageMainIndex];
                            $media->extension = explode('.',$item[$ImageMainIndex])[1] ?? '';
                            $media->save();
                        }
                    }

                    if(isset($productObj->medias[1]) && $productObj->medias[1]->id){
                        Media::whereId($productObj->medias[1]->id)->update([
                            'file_name' => $item[$ImageFrontIndex],
                            'path' => "storage/files/".auth()->id()."/".$item[$ImageFrontIndex]
                        ]);
                    }else{
                        if(isset($item[$ImageFrontIndex])){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageFrontIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageFrontIndex];
                            $media->extension = explode('.',$item[$ImageFrontIndex])[1] ?? '';
                            $media->save();
                        }
                    }

                    if(isset($productObj->medias[2]) && $productObj->medias[2]->id){
                        Media::whereId($productObj->medias[2]->id)->update([
                            'file_name' => $item[$ImageBackIndex],
                            'path' => "storage/files/".auth()->id()."/".$item[$ImageBackIndex]
                        ]);
                    }else{
                        if(isset($item[$ImageBackIndex])){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageBackIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageBackIndex];
                            $media->extension = explode('.',$item[$ImageBackIndex])[1] ?? '';
                            $media->save();
                        }
                    }

                    if(isset($productObj->medias[3]) && $productObj->medias[3]->id){
                        Media::whereId($productObj->medias[3]->id)->update([
                            'file_name' => $item[$ImageSide1Index],
                            'path' => "storage/files/".auth()->id()."/".$item[$ImageSide1Index]
                        ]);
                    }else{
                        if(isset($item[$ImageSide1Index])){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageSide1Index];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageSide1Index];
                            $media->extension = explode('.',$item[$ImageSide1Index])[1] ?? '';
                            $media->save();
                        }
                    }

                    if(isset($productObj->medias[4]) && $productObj->medias[4]->id){
                        Media::whereId($productObj->medias[4]->id)->update([
                            'file_name' => $item[$ImageSide2Index],
                            'path' => "storage/files/".auth()->id()."/".$item[$ImageSide2Index]
                        ]);
                    }else{
                        if(isset($item[$ImageSide2Index])){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImageSide2Index];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImageSide2Index];
                            $media->extension = explode('.',$item[$ImageSide2Index])[1] ?? '';
                            $media->save();
                        }
                    }

                    if(isset($productObj->medias[5]) && $productObj->medias[5]->id){
                        Media::whereId($productObj->medias[5]->id)->update([
                            'file_name' => $item[$ImagePosterIndex],
                            'path' => "storage/files/".auth()->id()."/".$item[$ImagePosterIndex]
                        ]);
                    }else{
                        if(isset($item[$ImagePosterIndex])){
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $productObj->id;
                            $media->file_name = $item[$ImagePosterIndex];
                            $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                            $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                            $media->save();
                        }
                    }
                    
                 }
                if($productObj){
                    ++$count;
                }
            }
        }
        return back()->with('success', 'Good News! records Updated successfully!');
    }
   
    public function productGroupBulkUpdate(Request $request)
    {
        $count = 0;
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }
        $head = array_shift($rows);
        $master = $rows;
        // Index
        $IdIndex = 0;
        $ModelCodeIndex = 1;
        $ProductIndex = 2;
        $colorIndex = 3;
        $sizeIndex = 4;
        $groupIndex = 5;
        $priceIndex = 6;
       
        $group_productObj = null;

        foreach ($master as $index => $item) {
            // return $item[$priceIndex];
            if ($item[$IdIndex] != null) {
                $group_productObj = GroupProduct::whereId($item[$IdIndex])->first();
                 if ($group_productObj) {
                     $group_productObj->update([
                        'price' => $item[$priceIndex],
                     ]);
                 }
                if($group_productObj){
                    ++$count;
                }
            }
            
        }

        return back()->with('success', 'Good News! ' .$count. ' records Updated successfully!');


    }

    public function inventoryGroupBulkUpdate(Request $request)
    {
        $count = 0;
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }
        $head = array_shift($rows);
        $master = $rows;
        // Index
        $IdIndex = 0;
        $ModelIndex = 1; // Add new field
        $ProductIndex = 2;
        $ColorIndex = 3;
        $SizeIndex = 4;
        $InventoryIndex = 5;
        $PriceIndex = 6;
        $group_productObj = null;

        foreach ($master as $index => $item) {
            if ($item[$IdIndex] != null) {
                $product = getProductDataById($item[$IdIndex]);
                if ($product) {
                    $product->update([
                        'stock_qty' => $item[$InventoryIndex],
                    ]);
                    ++$count;
                }
            }
            
        }

        return back()->with('success', 'Good News! records Updated successfully!');


    }

    public function productBulkExport($products)
    {
      
        // return $products;
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($products);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Customer_ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
 
    }

    function exportData(){

        // Non Branded 
        $products = Product::whereUserId(auth()->id())->get();
        $products_array [] = array("Id","Global Category","Global Sub Category","Product Name","Model Code","Image Main","Image Name Front","Image Name Back","Image Name Side1","Image Name Side2","Image Name Poster","Video URL","Tag 1","Tag 2","Tag 3","Description","Weight","Weight Unit","Length","Width","Height","Length Unit","Standard Carton PCs","Carton Weight","Carton Unit","Color","Size","Minimum Selling Price Without GST","Shop Price General Without GST","Shop Price VIP_Customer","Shop Price Reseller","MRP Incl Price","HSN Tax","HSN Percent","Meta Description","Meta Keywords",'artwork_url',"Stock (must be number)","Publish (it will be 0 for unpublish or 1 for publish)");
        $reseller_group = Group::whereUserId(auth()->id())->where('name',"Reseller")->first();
        $vip_group = Group::whereUserId(auth()->id())->where('name',"VIP")->first();
        foreach($products as $product)
        {
            $usi = UserShopItem::whereUserId(auth()->id())->where('product_id',$product->id)->latest()->first();
             $reseller_group_product = GroupProduct::where('group_id',$reseller_group->id??0)->where('product_id',$product->id)->latest()->first();

            $vip_group_product = GroupProduct::where('group_id',$vip_group->id??0)->where('product_id',$product->id)->latest()->first();
            
            if ( $product->shipping != null) {
                $dimensions = json_decode($product->shipping);
                $height = $dimensions->height ?? null;
                $weight = $dimensions->weight ?? null;
                $width = $dimensions->width ?? null;
                $unit = $dimensions->unit ?? null;
                $length = $dimensions->length ?? null;
                $length_unit = $dimensions->length_unit ?? null;
            } else {
                $dimensions = null ;
                $height = null ;
                $weight = null ;
                $width = null ;
                $unit = null ;
                $length = null ;
                $length_unit = null ;
            }
            if ( $product->carton_details != null) {
                $carton_details = json_decode($product->carton_details);
                $standard_carton = $carton_details->standard_carton ?? null;;
                $carton_weight = $carton_details->carton_weight ?? null;;
                $carton_unit = $carton_details->carton_unit ?? null;;
            } else {
                $carton_details = null ;
                $standard_carton = null ;
                $carton_weight = null ;
                $carton_unit = null ;
            }
            if($product->is_publish == 0){
                $usi->update([
                    'is_published' => 0
                ]);
            }
           
            $products_array[] = array(
                'Id' => $product->id,
                "Global Category"=> $product->category->name ?? "",
                "Global Sub Category"=>$product->subcategory->name ?? "",
                "Product Name"=> $product->title ?? "",
                "Model Code"=> $product->model_code,
                "Image Main"=> isset($product->medias[0]) ? ($product->medias[0]->file_name ?? "") : null,
                "Image Name Front"=>isset($product->medias[1]) ? ($product->medias[1]->file_name ?? ""): null,
                "Image Name Back"=>isset($product->medias[2]) ? ($product->medias[2]->file_name ?? ""): null,
                "Image Name Side1"=>isset($product->medias[3]) ? ($product->medias[3]->file_name ?? ""): null,
                "Image Name Side2"=>isset($product->medias[4]) ? ($product->medias[4]->file_name ?? ""): null,
                "Image Name Poster"=>isset($product->medias[5]) ? ($product->medias[5]->file_name ?? ""): null,
                "Video URL"=>$product->video_url,
                "Tag 1"=>$product->tag1,
                "Tag 2"=>$product->tag2,
                "Tag 3"=>$product->tag3,
                'Description' =>$product->description,
                'Weight' =>$weight,
                'Weight Unit' =>$unit,
                'Length' =>$length,
                'Width' =>$width,
                'Height' =>$height,
                'Length Unit' =>$length_unit,
                'Standard Carton PCs' =>$standard_carton,
                'Carton Weight' =>$carton_weight,
                'Carton Unit' =>$carton_unit,
                'Color' =>$product->color,
                'Size' =>$product->size,
                "Minimum Selling Price Without GST"=>$product->min_sell_pr_without_gst??"",
                "Shop Price General Without GST"=> $usi->price ?? "",
                "Shop Price VIP_Customer"=> $vip_group_product->price ?? "",
                "Shop Price Reseller"=> $reseller_group_product->price ?? "",
                "MRP Incl Price"=>$product->mrp,
                "HSN Tax"=>$product->hsn,
                "HSN Percent"=>$product->hsn_percent,
                "Meta Description"=>$product->meta_description,
                "Meta Keywords"=>$product->meta_keywords,
                'artwork_url' => $product->artwork_url,
                'Stock (must be number)' =>$product->stock_qty,
                'Publish (it will be 0 for unpublish or 1 for publish)' =>$product->is_publish,
            );
        }
        $this->productBulkExport($products_array);
        return back()->with('success',' Export Excel File Successfully');
    }


    public function inventoryProductBulkExport($group_products)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($group_products);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Customer_ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
 
    }
    public function groupProductBulkExport($group_products)
    {
        // return $products;
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($group_products);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Customer_ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
 
    }
    function exportProductGroupData(){
        
        $group_ids = Group::where('user_id',auth()->id())->pluck('id');
        $group_products = GroupProduct::whereIn('group_id',$group_ids)->get();
        $group_products_array [] = array("Id","Model Code","Product Name","Product Color","Product Size","Group Name","Customer Price");
        foreach($group_products as $group_product)
        {
            if($group_product->product){
                $group_products_array[] = array(
                    'Id  (Non Editable)' => $group_product->id,
                    'Model Code' => $group_product->product->model_code,
                    'Product Name  (Non Editable)' => $group_product->product->title,
                    'Product Color  (Non Editable)' => $group_product->product->color,
                    'Product Size  (Non Editable)' => $group_product->product->size,
                    'Group Name  (Non Editable)' => $group_product->group->name,
                    'Customer Price' => $group_product->price,
                );
            }
        }
        $this->groupProductBulkExport($group_products_array);
        return back()->with('success',' Export Excel File Successfully');
    }

    function exportInventoryStock(){
        
        $products = Product::where('user_id',auth()->id())->get();
        $products_array[] = array("Id","Model No.","Product Name","Product Color","Product Size","Inventory");
        foreach($products as $product)
        {
            if($product){
                $products_array[] = array(
                    'Id  (Non Editable)' =>$product->id,
                    'Model No.  (Non Editable)' =>$product->model_code,
                    'Product Name  (Non Editable)' =>$product->title,
                    'Product Color  (Non Editable)' =>$product->color,
                    'Product Size  (Non Editable)' =>$product->size,
                    'Inventory  (Non Editable)' =>$product->stock_qty,
                );
            }
        }
        $this->inventoryProductBulkExport($products_array);
        return back()->with('success',' Export Excel File Successfully');
    }

    

      
}
`