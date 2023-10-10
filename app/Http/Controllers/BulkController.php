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
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use App\Models\UserShop;
use App\Models\changeby121;
use App\Models\AccessCode;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\UserAddress;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Package;
use App\Models\ProductExtraInfo;
use App\Models\TimeandActionModal;
use App\Models\UserPackage;
use Illuminate\Support\Arr;
use PDO;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpParser\Node\Stmt\Return_;
use PHPUnit\Framework\Constraint\Count;

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
        $materialIndex = 15;
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
        $RateTypeIndex = 27;
        $RateIndex = 28;
        // $MinimumSellingPriceWithoutGST = 26;        //minimum selling price Removed from Bulk Sheet
        $ShopPriceIndex = 28;               // Same work as Rate
        $VipPriceIndex = 29;
        $ResellerPriceIndex = 30;
        $MRPIndex = 31;
        $HSNTaxIndex = 32;
        $HsnPercentIndex = 33;
        $MetaDescriptionIndex = 34;
        $MetaKeywordsIndex = 35;
        $artwork_urlIndex = 36;
        $exclusiveIndex = 37;
        $variantTypeIndex = 38;

        // Index End
        // Index
        $MinimumSellingPriceWithoutGST = 0; // For No Error
        $productObj = null;

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
                            $packageValidationCount++;
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
                }else{
                    $packageValidationCount++;
                }
              
                if($item_temp[$CategoryIndex] != null){
                    // Check Subcategory
                   
                    // $chk = Category::whereIn('id', $scoped_category->pluck('id'))->where('name',$item_temp[$CategoryIndex])->first();
                    $chk = Category::where('name',$item_temp[$CategoryIndex])->first();
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

                if ($item_temp[$ModelCodeIndex] != null && $item_temp[$ModelCodeIndex] != "") {
                    // Checking Group Id..
                    $checkSKU = Product::where('model_code',$item_temp[$ModelCodeIndex])->where('user_id',auth()->id())->first();
                    if (empty($checkSKU)) {
                        // Group Id not Match with User  
                        // Todo: Do Nothing

                    }elseif($checkSKU->user_id != auth()->id()){
                        // No Record found In product Need to Created New.!!
                        return back()->with('error',"Group Id Didn't Match!!");
                    }
                    elseif ($checkSKU->user_id == auth()->id()) {
                        // Get Product and User id is Matched
                        $GroupId = $checkSKU->sku;
                    }else{
                        echo "Sometyhing Went Wrong!!";
                        return;

                    }
                }
                                
                // Check Input Material is exists or not Start
                $material = ProductAttribute::whereName('Material')->first();
                if(!$material || $material->value == null){
                    return back()->with('error', 'Material attributes not exists. Please ask admin to add');
                }
                $material_collection = json_decode($material->value);
                $material_collection = explode(',',$material_collection[0]) ?? '';
                $material_temp = $item_temp[$materialIndex];

                 if ($material_temp != "") {
                    if (!in_array(trim($material_temp),$material_collection)) {
                        return back()->with('error',trim($material_temp).' Material is not exists at Row:'.$row_number);
                    }
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

        $modalArray = [];
        $SKUArray = [];
        foreach ($master as $index => $item) {

            // SKU Generation
            if ($item[$ModelCodeIndex] == null || $item[$ModelCodeIndex] == "") {
                $sku_code = 'SKU'.generateRandomStringNative(6);
                $item[$ModelCodeIndex] = $sku_code;
            }elseif (isset($GroupId)) {
                $sku_code = $GroupId;
            }
            else{
                $sku_code = 'SKU'.generateRandomStringNative(6);
            }
            
            if (in_array($item[$ModelCodeIndex],$modalArray)) {
                // echo "Yes Bro!";
                $sku_code = $SKUArray[array_search($item[$ModelCodeIndex],$modalArray)];
            }else{
                array_push($modalArray,$item[$ModelCodeIndex]);
                array_push($SKUArray,$sku_code);
            }


            // magicstring($modalArray);
            // magicstring($SKUArray);
            // // return;

            if ($item[$TitleIndex] != null) {
           
                // $category = Category::whereIn('id', $scoped_category->pluck('id'))->where('name',$item[$CategoryIndex])->first();
                $category = Category::where('name',$item[$CategoryIndex])->first();
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


                if ($item[$exclusiveIndex]== "Yes" || $item[$exclusiveIndex]== "No" || $item[$exclusiveIndex]== "yes"  || $item[$exclusiveIndex]== "no" || $item[$exclusiveIndex] == "" ) {
                    if ($item[$exclusiveIndex]== "Yes" || $item[$exclusiveIndex]== "yes" ) {
                        $exlusive = 1;
                    }else{
                        $exlusive = 0;
                    }
                }else{
                    return back()->with("error","Exclusive INdex should Has Yes or No Value, At row ".$row_number );
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
                                    'brand_id' => $request->brand_id ?? 0,
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
                                    'material' => $material_temp ?? null,
                                    'exclusive' => $exlusive ?? 0,
                                    // 'variant_type' => $item[$variantTypeIndex],
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
                            'material' => $material_temp ?? null,
                            'exclusive' => $exlusive ?? 0,
                            // 'variant_type' => $item[$variantTypeIndex],

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
                            'material' => $material_temp ?? null,
                            'exclusive' => $exlusive ?? 0,
                            // 'variant_type' => $item[$variantTypeIndex],

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
                        'material' => $material_temp ?? null,
                        'exclusive' => $exlusive ?? 0,
                        // 'variant_type' => $item[$variantTypeIndex],

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
        $materialIndex = 16;
        $WeightIndex = 17;
        $WeightUnitIndex = 18;
        $LengthIndex = 19;
        $WidthIndex = 20;
        $HeightIndex = 21;
        $LengthUnitIndex = 22;
        $StandardCartonIndex = 23;
        $CartonWeightIndex = 24;
        $CartonUnitIndex = 25;
        $ColorIndex = 26;
        $SizeIndex = 27;
        // $MinimumSellingPriceWithoutGST = 27;
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
        $StockIndex = 37; // Using as manage_inventory
        // $StatusIndex = 37;
        $PublishIndex = 38;
        $ExclusiveIndex = 39;


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
                    // $chk = Category::whereIn('id', $scoped_category->pluck('id'))->where('name',$item[$CategoryIndex])->first();
                    $chk = Category::where('name',$item[$CategoryIndex])->first();
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
                // if(trim($item[$ColorIndex]) && trim($item[$SizeIndex])){
                //   $product = Product::whereId($item[$IdIndex])->whereUserId(auth()->id())->first();
                //   $chk = Product::where('id','!=',$product->id)->where('sku','=',$product->sku)->where('color',trim($item[$ColorIndex]))->where('size',trim($item[$SizeIndex]))->first();
                //   if($chk) {
                //       return back()->with('error',"You already have same color and size product. Please check ".$row_number." row information.");
                //   }
                // }


                // Is Publish
                if ($item[$PublishIndex] != 0 && $item[$PublishIndex] != 1 && $item[$PublishIndex] != null) {
                   return back()->with("error",'Please use only 1 & 0 in Publish column'.$item[$PublishIndex]);
                }

                // Is Exclusive
                if ($item[$ExclusiveIndex] != 0 && $item[$ExclusiveIndex] != 1 && $item[$ExclusiveIndex] != null) {
                    return back()->with("error",'Please use only 1 & 0 in Exclusive column'.$item[$ExclusiveIndex]);
                }

                                 
                // // Stock
                // if ($item[$StockIndex] != null && is_numeric($item[$StockIndex]) != 1) {
                //    return back()->with("error",'Please use only numeric value in Stock column');
                // }

                // Check Manage Inventory Values
                if ($item[$StockIndex] != "Yes"  && $item[$StockIndex] != "No") {
                    return back()->with('error','Manage Inventory Value Should be Yes or No Only in Column '.$row_number);
                }
                

                // Hsn Percent
                if ($item[$HsnPercentIndex] != null && is_numeric($item[$HsnPercentIndex]) != 1) {
                   return back()->with("error",'Please use only numeric value in Hsn Percent column'.$item[$HsnPercentIndex]);
                }
            }            
        }

        foreach ($master as $index => $item) {

            // $category = Category::whereIn('id', $scoped_category->pluck('id'))->where('name',$item[$CategoryIndex])->first();
            $category = Category::where('name',$item[$CategoryIndex])->first();
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
                         'manage_inventory' => $item[$StockIndex] == 'Yes' ? 1 : 0 ?? 0,
                         'is_publish' => $item[$PublishIndex],
                        //  'min_sell_pr_without_gst' => $item[$MinimumSellingPriceWithoutGST] ?? 0,
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
                         'material' => $item[$materialIndex] ?? null,
                         'exclusive' => $item[$ExclusiveIndex] ?? 0,
                    ]);

                    if ($productObj->manage_inventory == 1) {
                        $chk_inventory_exist = true;
                    }else{
                        $chk_inventory_exist = 0;
                    }
                    $need_inventory = $item[$StockIndex] == 'Yes' ? true : false ?? false;



                    
                    $chk_inventroy = Inventory::where('product_id',$productObj->id)->where('user_id',auth()->id())->get();
                    if ($item[$StockIndex] == 'Yes') {
                        if (count($chk_inventroy) == 0) {
                            magicstring($request->all());
                            Inventory::create([
                                'user_shop_item_id' => $usi->id,
                                'product_id' => $productObj->id,
                                'product_sku' => $productObj->sku,
                                'user_id' => auth()->id(),
                                'stock' => 0,
                                'parent_id' => 0,
                                'prent_stock' => 0,
                            ]);
                        }else{
                            getinventoryByproductId($productObj->id)->update(['status'=>1]);
                        }
                    }else{
                        if (count($chk_inventroy) != 0) {
                            getinventoryByproductId($productObj->id)->update(['status'=>0]);
                        }
                    }

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

    // Export Product Data
    function exportData(Request $request)
    {
        try {
            {
                if ($request->has('id')) {
                    // Non Branded 
                    $products = Product::whereUserId($request->get('id'))->get();
                }else{
                    $products = Product::whereUserId(auth()->id())->get();
                }
                
                $products_array [] = array('Id','Model Code','Global Category','Global Sub-category','Product Name','Image_main','image_name_front','image_name_back','image_name_side1','image_name_side2','image_name_poster','Video URL','Description','Weight','weight_unit','length','width','height','length_unit','standard_carton_pcs','carton_weight_actual','unit','Customer_Price_without_GST','Shop_Price_VIP_Customer','Shop_Price_Reseller',"'mrp Incl tax'","'HSN Tax'",'HSN_Percnt','meta_description','meta_keywords','artwork_url','Manage Inventory (Yes or No Only)','Publish (it will be 0 for unpublish or 1 for publish)','Exclusive', );
        
                $custom_attribute = json_decode(auth()->user()->custom_attriute_columns);
                // $products_array = $products_array[0],$custom_attribute);
                foreach ($custom_attribute as $key => $value) {
                    array_push($products_array[0],$value);
                }
        
        
        
                unset($custom_attribute[0],$custom_attribute[1],$custom_attribute[2]);
                
        
                // magicstring($products_array);
                
                // return;
        
                $reseller_group = Group::whereUserId(auth()->id())->where('name',"Reseller")->first();
                $vip_group = Group::whereUserId(auth()->id())->where('name',"VIP")->first();
                foreach($products as $pkey => $product)
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
        
        
                    // $common_attribute = ['Colour','Size','Material'];
                    $color_array = ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',1)->groupBy('attribute_value_id')->pluck('attribute_value_id');
                    $size_array = ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',2)->groupBy('attribute_value_id')->pluck('attribute_value_id');
                    $material_array = ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',3)->groupBy('attribute_value_id')->pluck('attribute_value_id');
        
        
                    $color_Val = [];
                    if ($color_array != null) {
                        foreach ($color_array as $key => $value) {
                            $color_Val[$key] = getAttruibuteValueById($value)->attribute_value;
                        }                
                    }else{
                        $color_Val = '';
                    }
        
                    $size_Val = [];
                    if ($size_array != null) {
                        foreach ($size_array as $key => $value) {
                            $size_Val[$key] = getAttruibuteValueById($value)->attribute_value;
                        }
        
                    }else{
                        $size_Val = '';
                    }
        
                    $material_Val = [];
                    if ($material_array != null) {
                        foreach ($material_array as $key => $value) {
                            $material_Val[$key] = getAttruibuteValueById($value)->attribute_value;
                        }
                    }else{
                        $material_Val = '';
                    }
                    
                    $PRODUCT_ATTRIBUTE_ARRAY = [];
                    if ($custom_attribute != null) {
                        foreach ($custom_attribute as $attributes) {
                            $id = getAttributeIdByName($attributes,auth()->id());
                            
                            $attribute_array = ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',$id)->groupBy('attribute_value_id')->pluck('attribute_value_id');
            
                            $ashu = [];
                            if ($attribute_array != null) {
                                foreach ($attribute_array as $key => $value) {
                                    $ashu[$key] = getAttruibuteValueById($value)->attribute_value;
                                }
                            }else{
                                $ashu = '';
                            }
                            
                            $PRODUCT_ATTRIBUTE_ARRAY[$attributes] = implode("^^",$ashu);
                        }
                    }

                    $products_array[] = array(
                        'Id' => $product->id,
                        "Model Code"=> $product->model_code,
                        "Global Category"=> $product->category->name ?? "",
                        "Global Sub-category"=>$product->subcategory->name ?? "",
                        "Product Name"=> $product->title ?? "",
                        "Image_main"=> isset($product->medias[0]) ? ($product->medias[0]->file_name ?? "") : null,
                        "image_name_front"=>isset($product->medias[1]) ? ($product->medias[1]->file_name ?? ""): null,
                        "image_name_back"=>isset($product->medias[2]) ? ($product->medias[2]->file_name ?? ""): null,
                        "image_name_side1"=>isset($product->medias[3]) ? ($product->medias[3]->file_name ?? ""): null,
                        "image_name_side2"=>isset($product->medias[4]) ? ($product->medias[4]->file_name ?? ""): null,
                        "image_name_poster"=>isset($product->medias[5]) ? ($product->medias[5]->file_name ?? ""): null,
                        "Video URL"=>$product->video_url,
                        'Description' =>$product->description,
                        'Weight' =>$weight,
                        'weight_unit' =>$unit,
                        'length' =>$length,
                        'width' =>$width,
                        'height' =>$height,
                        'length_unit' =>$length_unit,
                        'standard_carton_pcs' =>$standard_carton,
                        'carton_weight_actual' =>$carton_weight,
                        'unit' =>$carton_unit,
                        "Customer_Price_without_GST"=> $usi->price ?? "",
                        "Shop_Price_VIP_Customer"=> $vip_group_product->price ?? "",
                        "Shop_Price_Reseller"=> $reseller_group_product->price ?? "",
                        "mrp Incl tax"=>$product->mrp,
                        "HSN Tax"=>$product->hsn,
                        "HSN_Percnt"=>$product->hsn_percent,
                        "meta_description"=>$product->meta_description,
                        "meta_keywords"=>$product->meta_keywords,
                        'artwork_url' => $product->artwork_url,
                        'Stock (must be number)' =>$product->manage_inventory == 1 ? "Yes" : "No",
                        'Publish (it will be 0 for unpublish or 1 for publish)' =>$product->is_publish,
                        'Exclusive' =>$product->exclusive ?? 0,
                        'Color' => implode("^^",$color_Val) ?? '',
                        'Size' => implode("^^",$size_Val) ?? '',
                        "Material" => implode("^^",$material_Val) ?? '',
                    );
        
                    foreach ($PRODUCT_ATTRIBUTE_ARRAY as $index => $value) {
                        array_push($products_array[$pkey+1],$value);                
                    }
                }
                
                
                $this->productBulkExport($products_array);
                return back()->with('success',' Export Excel File Successfully');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
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


   
    function bulkuserimportadd(Request $request) {

        
        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";


        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
        // $worksheet = $spreadsheet->getSheetByName('Upload Users');
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

        $rows = array_slice($rows,2);
        // Remove Last Element of Array
        array_pop($rows);


        $master = $rows;
        // Todo: Start Indexing of Cells
        $catIdNBDIndex = 0;
        $SlugIndex = 1;
        $NameofBusinessIndex = 2;
        $NameofUserIndex = 3;
        $BusinessDescriptionIndex = 4;
        $PhoneIndex = 5;
        $whatsappNumberIndex = 6;
        $AdditionalPhoneIndex = 7;
        $EmailIndex = 8;
        $AccountPasswordIndex = 9;
        $AccountTypeIndex = 10;
        $AccessCodeIndex = 11;
        $FacebookIndex = 12;
        $InstgramIndex = 13;
        $YoutubeIndes = 14;
        $TwitterIndex = 15;
        $LinkedinIndex = 16;
        $PinterestIndex = 17;
        $EmbededCodeIndex = 18;
        $SliderPrevIndex = 19;
        $address_1Index = 20;
        $address_2Index = 21;
        $landmarkIndex = 22;
        $countryIndex = 23;
        $stateIndex = 24;
        $cityIndex = 25;
        $pincodeIndex = 26;
        $gst_numberIndex = 27;


      

        foreach ($master as $index => $items) {
            $row_number = $index + 3;
            // magicstring($items);

            // validating Loop Data

            // checking Slugname Exist of Not
            if (UserShop::where('slug',$items[$SlugIndex])->get()->count() != 0) {
                return back()->with('error',' Slug Name Already Exist At Row '.$row_number);
            }

            // checking Phone Number
            if (User::where('phone',$items[$PhoneIndex])->get()->count() != 0) {
                return back()->with('error',' Phone Number Already Exist At Row '.$row_number);
            }
            
            // checking Email Address
            if (User::where('email',$items[$EmailIndex])->get()->count() != 0) {
                return back()->with('error',' Email Already Exist At Row '.$row_number);
            }

            // Check Fields are Empty or Not
            if ($items[$SlugIndex] == "") {
                return back()->with('error',' Slug Name Require At Row '.$row_number);
            }

            if ($items[$PhoneIndex] == "") {
                return back()->with('error',' Phone Number Require At Row '.$row_number);
            }

            if ($items[$EmailIndex] == "") {
                return back()->with('error',' Email is Require At Row '.$row_number);
            }



            // checking Access Code
            if($items[$AccessCodeIndex] != "" && $items[$AccessCodeIndex] != null){
                $chk_code = AccessCode::whereCode($items[$AccessCodeIndex])->first();
                if(!$chk_code){
                return redirect()->back()->with('error','This access code is invalid!');
                }
    
                $chk_redeem = AccessCode::whereCode($items[$AccessCodeIndex])->where('redeemed_user_id','!=',null)->first();
    
                //  Check already redeemed
                if($chk_redeem){
                    return redirect()->back()->with('error','This access code is already redeemed!');
                }
            }


            $industry = ["186"]; // Gifting
            if ($items[$AccountTypeIndex] == 'reseller' || $items[$AccountTypeIndex] == 'customer') {
                $mycustomer = 'no';
                $mysupplier = 'yes';
                $Filemanager = 'yes';
                $addandedit = 'no'; 
                $bulkupload = 'no';
                $pricegroup = 'no';
                $managegroup = 'yes';
                $manangebrands = 'no';
            }elseif ($items[$AccountTypeIndex] == 'supplier' || $items[$AccountTypeIndex] == 'Supplier') {
                $mycustomer = 'yes';
                $mysupplier = 'no';
                $Filemanager = 'yes';
                $addandedit = 'yes'; 
                $bulkupload = 'yes';
                $pricegroup = 'yes';
                $managegroup = 'yes';
                $manangebrands = 'no';
            }else{
                # If Got Some Error
                // ! Taking as A customer
                $mycustomer = 'no';
                $mysupplier = 'yes';
                $Filemanager = 'yes';
                $addandedit = 'no';  
                $bulkupload = 'no';
                $pricegroup = 'no';
                $managegroup = 'yes';
                $manangebrands = 'no';
            }
        
            $permission_user = ["mycustomer"=>$mycustomer,"manangebrands" => $manangebrands,"Filemanager" => $Filemanager,"addandedit"=> $addandedit,"pricegroup" => $pricegroup,"bulkupload"=> $bulkupload,"mysupplier"=> $mysupplier, "managegroup" => $managegroup ];

            $fb_link = trim($items[$FacebookIndex]);
            $in_link = trim($items[$InstgramIndex]);
            $tw_link = trim($items[$TwitterIndex]);
            $yt_link = trim($items[$YoutubeIndes]);
            $likedin_link = trim($items[$LinkedinIndex]);
            $pint_link = trim($items[$PinterestIndex]);
            
            $social_link = json_encode(array('fb_link' => $fb_link,'in_link' => $likedin_link ,'tw_link' => $tw_link , 'yt_link' => $yt_link,'insta_link' => $in_link,'pint_link' => $pint_link));    

            
            $name = trim($items[$NameofUserIndex]);
            $email = trim($items[$EmailIndex]);
            $phone = trim($items[$PhoneIndex]);
            $demo_given = trim($items[$SliderPrevIndex]) ?? 0;

            if ($items[$AccountPasswordIndex] != "" || $items[$AccountPasswordIndex] != null) {
                $pass = Hash::make(trim($items[$AccountPasswordIndex]));
            }else{
                $pass = $phone."@121".generateRandomStringNative(2); 
                $pass = Hash::make($pass);
            }

            
            $add_phone = json_encode(explode(',',$items[$AdditionalPhoneIndex]) );
            $catidNBD = $items[$catIdNBDIndex];

            if (isset($chk_code)) {
                $is_supplier = 1;
            }else{
                $is_supplier = 0;
            }
            
            
            //    DB::insert('insert into users (name,email,phone,gender,dob,password,demo_given,additional_numbers) values(?,?,?,?,?,?,0,?)',[$name,$email,$phone,$gender,$dob,$pass,$demo_given,$add_phone]);

            //  store user information
            $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => $pass,
                    'demo_given' => $demo_given,
                    'additional_numbers' => $add_phone,
                    'account_permission' => json_encode($permission_user),
                    'is_supplier' => $is_supplier,
                    'NBD_Cat_ID' => $catidNBD,
            ]);       
            $user->syncRoles(3);

            // Getting User By Phone If object Not Created !!
            if (!$user) {
                $user = User::where('phone',$items[$PhoneIndex])->first();
            }

            // Check Address Details
            if ($items[$countryIndex] != null) {
                $country_id = Country::where('name',$items[$countryIndex])->first()->id;
                if (!$country_id) {
                    return back()->with('error', 'Invailid Country Name ! Please Check. at Row '.$row_number);
                }
            }
            if ($items[$stateIndex] != null) {
                $state_id = State::where('name',$items[$stateIndex])->first()->id;
                if (!$state_id) {
                    return back()->with('error', 'Invailid State Name ! Please Check. at Row '.$row_number);
                }
            }
            if ($items[$cityIndex] != null) {
                $city_id = City::where('name',$items[$cityIndex])->first()->id;
                if (!$city_id) {
                    return back()->with('error', 'Invailid City Name ! Please Check. at Row '.$row_number);
                }
            }


            // Adding Address For a USer
            $data = new UserAddress();
            $data->user_id = $user->id;
            $data->is_primary = 0;
            $data->type = 0; // ! Default as A Billing addrss
            $arr = [
                'address_1' => $items[$address_1Index],
                'address_2' => $items[$address_2Index],
                'country' => $country_id ?? '101',
                'state' => $state_id,
                'city' => $city_id,
                'pincode' => $items[$pincodeIndex],
                'landmark' => $items[$landmarkIndex],
                'gst_number' => $items[$gst_numberIndex],
                'entity_name' => $items[$NameofUserIndex]
            ];

            $data->details = json_encode($arr);
            $data->save();            

            
            // assign new role to the user
            $userrole = 3;
            // $user->syncRoles($userrole);
            
            // ! DO Not Change This
            // Assign Role as a User

            if($userrole == 3){
                $contact_info = [
                    'phone' => $items[$PhoneIndex],
                    'email' => $items[$EmailIndex],
                    'whatsapp' => $items[$whatsappNumberIndex],
                ];
                $testimonial = [
                    'title' => 'Testimonials',
                    'description' => 'Our testimonial showing here',
                ];
                $products = [
                    'title' => 'Products Catalogue',
                    'description' => 'Explore our product',
                    'label' => 'Visit Shop',
                ];
                $about = [
                    'title' => 'About',
                    'content' => 'Bit about me',
                ];
                $story = [
                    'title' => 'About',
                ];
                $features = [
                    'title' => 'Reason to choose us',
                ];
                $team = [
                    'title' => 'Our Team',
                ];


                if($items[$SlugIndex]){
                    $shop_name =  $items[$SlugIndex];
                }else{
                    $shop_name =  $items[$NameofBusinessIndex]."'s Shop";
                }
            
                // return $user->id;
                                  
                $story = [
                    'title' => 'About',
                    'cta_link' => '',
                    'cta_label' => 'Download Catalogue',
                    'prl_link' => '',
                    'prl_label'=> 'Download Price List',
                    'video_link' => '',
                    'description' => $items[$BusinessDescriptionIndex],
                    'img' => '',
                ];
                
                $user_shop = UserShop::create([
                    'user_id' => $user->id,
                    'name'=> $shop_name,
                    // 'slug'=> slugify($shop_name), // TODO Add slugify function
                    'slug'=> $items[$SlugIndex], // TODO Add slugify function
                    'description' => json_encode($story),
                    'logo' => null,
                    'contact_no' => $user->phone,
                    'status' => 0, // Active
                    'contact_info' => json_encode($contact_info),
                    'products' => json_encode($products),
                    'about' => json_encode($about),
                    'story' => json_encode($story),
                    'features' => json_encode($features),
                    'team' => json_encode($team),
                    'email' => $user->email,    
                    'social_links' => $social_link,
                    'embedded_code' =>urlencode($items[$EmbededCodeIndex])
                ]);

                // Create Price Groups for User
                syncSystemPriceGroups($user->id);

                 // Code Has
                 if ($items[$AccessCodeIndex] != null && $chk_code) {

                    // Update Access Code 
                    $chk_code->update([
                        'redeemed_user_id' => $user->id,  
                        'redeemed_at' => now()
                    ]);

                    $user->update([
                        'is_supplier' => 1,
                    ]);
                    
                }else{
                    $user->update([
                        'is_supplier' => 0,
                    ]);
                }          
                
                // Assign Trial Package
                $package = Package::whereId(1)->first();
                
                if($package){
                    if($package->duration == null){
                            $duration = 30;
                    }else{
                        $duration = $package->duration;
                    }
                    $package_child = new UserPackage();
                    $package_child->user_id = $user->id;
                    $package_child->package_id = $package->id;
                    $package_child->order_id = 0; // For Trial Order
                    $package_child->from = now();
                    $package_child->to = now()->addDays($duration);
                    $package_child->limit = $package->limit;
                    $package_child->save();
                }



            }


            
        }

        if ($user_shop && $user) {
            return redirect('panel/users/index')->with('success', 'New user created!');
        } else {
            return redirect('panel/users/index')->with('error', 'Failed to create new user! Try again.');
        }
        echo "Error While Uploading Users!";
    }   


    public function UserBulkExport($products)
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
            header('Content-Disposition: attachment;filename="Users_ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
 
    }

    
    function exportUserData(Request $request){
        
        if (AuthRole() != 'Admin') {
            return back()->with("error","You Don't Have Permission to Access This Page !");
        }

        $user_array [] = array(
            'ID','CatID#','Shop URL name','Name Of Business','Name of SPOC','About the business','Phone1/ primary','Whatsapp','addition_phone','Business Email','Account Type','Facebook link','Instagram link','Youtube link','Twitter link','LinkedIn link','Pinterest link','Map Code SRC','Slider Preview','Line 1 - Flat Office Number and Floor','Line 2 - Building Name','Line 3 - Landmark, if any','Country','State','City','Pin code','gst_number','product_count'
        );

        $reseller_group = Group::whereUserId(auth()->id())->where('name',"Reseller")->first();
        $vip_group = Group::whereUserId(auth()->id())->where('name',"VIP")->first();
        
        $users = User::role('User')->get();

        foreach($users as $user)
        {
           
            $useraddress = UserAddress::where('user_id',$user->id)->first();

            if (isset($useraddress) && isset($useraddress) != "") {
                $useraddress = json_decode($useraddress->details);
                $state = State::whereId($useraddress->state)->first()->name;
                $city = City::whereId($useraddress->city)->first()->name;
                $country = Country::whereId($useraddress->country)->first()->name;
                $address_1 = $useraddress->address_1;
                $address_2 = $useraddress->address_2;
                $landmark = $useraddress->landmark ?? "";
                $gst_number = $useraddress->gst_number ?? "";
                $pincode = $useraddress->pincode;
            }else{
                $state = "";
                $city = "";
                $country = "";
                $address_1 = "";
                $address_2 = "";
                $landmark = "";
                $gst_number = "";
                $pincode = "";
            }
            
            $usershop = UserShop::where('user_id',$user->id)->first();

            if (isset($usershop)) {                
                $contact_info = json_decode($usershop->contact_info);
                $social_links = json_decode($usershop->social_links);
            }

            if (isset($usershop->embedded_code)) {
                $embedded_code = urldecode($usershop->embedded_code) ?? "";
            }else{
                $embedded_code = "";
            }


            if (isset($usershop->story)) {
                $description = json_decode($usershop->story);
            }else{
                $description = "";
            }

            $additional_numbers = [];

            if ($user->additional_numbers != "" && $user->additional_numbers != null && $user->additional_numbers != '[\"\"]') {
                foreach (json_decode($user->additional_numbers) as $number) {
                   array_push($additional_numbers,$number);
                }
            } 

            magicstring($additional_numbers);

            $product_count = Product::where('user_id',$user->id)->get()->count();

            $user_array[] = array(
                'ID' => $user->id,
                'CatID#' => $user->NBD_Cat_ID ?? "",
                'Shop URL name' => $usershop->slug ?? "",
                'Name Of Business' => $usershop->name ?? "",
                'Name of SPOC'  => $user->name ?? "",
                'About the business' => $description->description ?? "",
                'Phone1/ primary'  => $user->phone ?? "",
                'Whatsapp' => $contact_info->whatsapp ?? "" ,
                'addition_phone' => implode(", ",$additional_numbers) ?? "", 
                'Business Email' => $user->email ?? "", 
                'Account Type' => $user->account_type ?? "" ,
                'Facebook link' => $social_links->fb_link ??  "",
                'Instagram link' => $social_links->insta_link ??  "",
                'Youtube link' => $social_links->yt_link ??  "",
                'Twitter link' => $social_links->tw_link ??  "",
                'LinkedIn link' => $social_links->in_link ??  "",
                'Pinterest link' => $social_links->pint_link ??  "",
                'Map Code SRC' => $embedded_code ?? "",                
                'Slider Preview' => $user->demo_given ?? "",
                'Line 1 - Flat Office Number and Floor' => $address_1 ?? "",
                'Line 2 - Building Name' => $address_2 ?? "",
                'Line 3 - Landmark, if any' => $landmark ?? "",
                'Country' => $country ?? "",
                'State' => $state ?? "",
                'City' => $city ?? "",
                'Pin code' => $pincode ?? "",
                'gst_number'  => $gst_number ?? "",
                'product_count' => $product_count ?? 0,

            );
        }

        $this->UserBulkExport($user_array);
        return back()->with('success',' Export Excel File Successfully');
    }



    function UserBulkUpdate(Request $request) {
        // chk user have active package or not!
        if(AuthRole() == "User"){
            return back()->with('error','You do not have Permission To Access This Page!');
        }    

        try {
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

            $idIndex = 0;
            $CatIDIndex = 1;
            $ShopURLnameIndex = 2;
            $NameOfBusinessIndex = 3;
            $NameofSPOCIndex = 4;
            $AboutthebusinessIndex = 5;
            $Phone1Index = 6;
            $WhatsappIndex = 7;
            $addition_phoneIndex = 8;
            $BusinessEmailIndex = 9;
            $AccountTypeIndex = 10;
            $FacebooklinkIndex = 11;
            $InstagramlinkIndex = 12;
            $youtubelinkIndex =13;
            $twitterlinkIndex = 14;
            $LinkedinlinkIndex = 15;
            $PinterestIndex = 16;
            $EmbededCodeIndex = 17;
            $SliderPrevIndex = 18;
            $address_1Index = 19;
            $address_2Index = 20;
            $landmarkIndex = 21;
            $countryIndex = 22;
            $stateIndex = 23;
            $cityIndex = 24;
            $pincodeIndex  = 25;
            $gst_numberIndex = 26;




            foreach ($master as $key => $item) {
                $row_number = $key + 1;

                // ! USer Id
                $user_id = $item[$idIndex];

                // validating Loop Data
                if (UserShop::where('slug',$item[$ShopURLnameIndex])->where('user_id','!=',$user_id)->get()->count() != 0) {
                    return back()->with('error',' Slug Name Already Exist At Row '.$row_number);
                }

                // checking Phone Number
                if (User::where('phone',$item[$Phone1Index])->where('id','!=',$user_id)->get()->count() != 0) {
                    return back()->with('error',' Phone Number Already Exist At Row '.$row_number);
                }
                
                // checking Email Address
                if (User::where('email',$item[$BusinessEmailIndex])->where('id','!=',$user_id)->get()->count() != 0) {
                    return back()->with('error',' Email Already Exist At Row '.$row_number);
                }

                // Check Fields are Empty or Not
                if ($item[$ShopURLnameIndex] == "") {
                    return back()->with('error',' Slug Name Require At Row '.$row_number);
                }

                if ($item[$Phone1Index] == "") {
                    return back()->with('error',' Phone Number Require At Row '.$row_number);
                }

                if ($item[$BusinessEmailIndex] == "") {
                    return back()->with('error',' Email is Require At Row '.$row_number);
                }
                
                $NameofSPOC = $item[$NameofSPOCIndex];
                $phone = $item[$Phone1Index];
                $additional = explode(",",$item[$addition_phoneIndex]);
                $additional = json_encode($additional);
                $phone = $item[$Phone1Index];
                $AccountType = $item[$AccountTypeIndex];
                $demo_given = $item[$SliderPrevIndex];
                $email = $item[$BusinessEmailIndex];
                $catid = $item[$CatIDIndex];

                
                if ($item[$AccountTypeIndex] == 'reseller' || $item[$AccountTypeIndex] == 'customer') {
                    $mycustomer = 'no';
                    $mysupplier = 'yes';
                    $Filemanager = 'yes';
                    $addandedit = 'no'; 
                    $bulkupload = 'no';
                    $pricegroup = 'no';
                    $managegroup = 'yes';
                    $manangebrands = 'no';
                }elseif ($item[$AccountTypeIndex] == 'supplier' || $item[$AccountTypeIndex] == 'Supplier') {
                    $mycustomer = 'yes';
                    $mysupplier = 'no';
                    $Filemanager = 'yes';
                    $addandedit = 'yes'; 
                    $bulkupload = 'yes';
                    $pricegroup = 'yes';
                    $managegroup = 'yes';
                    $manangebrands = 'no';
                }else{
                    # If Got Some Error
                    // ! Taking as A customer
                    $mycustomer = 'no';
                    $mysupplier = 'yes';
                    $Filemanager = 'yes';
                    $addandedit = 'no';  
                    $bulkupload = 'no';
                    $pricegroup = 'no';
                    $managegroup = 'yes';
                    $manangebrands = 'no';
                }


            
                $permission_user = ["mycustomer"=>$mycustomer,"manangebrands" => $manangebrands,"Filemanager" => $Filemanager,"addandedit"=> $addandedit,"pricegroup" => $pricegroup,"bulkupload"=> $bulkupload,"mysupplier"=> $mysupplier, "managegroup" => $managegroup ];

                $permission_user = json_encode($permission_user);
    
                // Todo: Updateing User
                $user = DB::update('update users set name = ? , phone = ? , additional_numbers = ? ,email = ? ,account_type = ?,demo_given = ?,account_permission = ?,NBD_Cat_ID = ? where id = ?',[$NameofSPOC,$phone,$additional,$email,$AccountType,$demo_given,$permission_user,$catid,$user_id]);



                // Todo: Collecting Details for User shop
                $fb_link = trim($item[$FacebooklinkIndex]);
                $in_link = trim($item[$InstagramlinkIndex]);
                $tw_link = trim($item[$twitterlinkIndex]);
                $yt_link = trim($item[$youtubelinkIndex]);
                $likedin_link = trim($item[$LinkedinlinkIndex]);
                $pint_link = trim($item[$PinterestIndex]);
                
                $slug = $item[$ShopURLnameIndex];
                $NameofBusiness = $item[$NameOfBusinessIndex];
                $about = $item[$AboutthebusinessIndex];
                $contact_info = [
                    'phone' => $item[$Phone1Index],
                    'email' => $item[$BusinessEmailIndex],
                    'whatsapp' => $item[$WhatsappIndex],
                ];


                $story = json_encode([
                    'title' => 'About',
                    'cta_link' => '',
                    'cta_label' => 'Download Catalogue',
                    'prl_link' => '',
                    'prl_label'=> 'Download Price List',
                    'video_link' => '',
                    'description' => $item[$AboutthebusinessIndex],
                    'img' => '',
                ]);

                $contact_info = json_encode($contact_info);
                $social_link = json_encode(array('fb_link' => $fb_link,'in_link' => $likedin_link ,'tw_link' => $tw_link , 'yt_link' => $yt_link,'insta_link' => $in_link,'pint_link' => $pint_link)); 
                $mapcode = urlencode($item[$EmbededCodeIndex]);

                // Todo: Updateing UserShop
                $user_shop = DB::update('update user_shops set slug = ? , name = ? , description = ? ,contact_info = ?,story = ? ,social_links = ?,embedded_code = ? where user_id = ?',[$slug,$NameofBusiness,$about,$contact_info,$story,$social_link,$mapcode,$user_id]);

                // Todo: Collecting Details Address For a User
                // Check Address Details
                if ($item[$countryIndex] != null) {
                    $country_id = Country::where('name',$item[$countryIndex])->first()->id;
                    if (!$country_id) {
                        return back()->with('error', 'Invailid Country Name ! Please Check. at Row '.$row_number);
                    }
                }
                if ($item[$stateIndex] != null) {
                    $state_id = State::where('name',$item[$stateIndex])->first()->id;
                    if (!$state_id) {
                        return back()->with('error', 'Invailid State Name ! Please Check. at Row '.$row_number);
                    }
                }
                if ($item[$cityIndex] != null) {
                    $city_id = City::where('name',$item[$cityIndex])->first()->id;
                    if (!$city_id) {
                        return back()->with('error', 'Invailid City Name ! Please Check. at Row '.$row_number);
                    }
                }

                
                $user_add = [
                    'address_1' => $item[$address_1Index],
                    'address_2' => $item[$address_2Index],
                    'country' => $country_id ?? '101',
                    'state' => $state_id,
                    'city' => $city_id,
                    'pincode' => $item[$pincodeIndex],
                    'landmark' => $item[$landmarkIndex],
                    'gst_number' => $item[$gst_numberIndex],
                    'entity_name' => $item[$NameofSPOCIndex],
                ];


                $user_add = json_encode($user_add);
                // UserAddress::where('user_id', $user_id)->update(['details' => $user_add]);

                $chk_address = UserAddress::where('user_id', $user_id)->where('type',0)->get()->count();

                if ($chk_address == 0) {
                    // Adding Address For a USer
                    $data = new UserAddress();
                    $data->user_id = $user_id;
                    $data->is_primary = 0;
                    $data->details = $user_add;
                    $data->type = 0; // ! Default as A Billing addrss
                    $data->save();
                }else{
                    // Todo: Updateing UserShop
                    $user_address = DB::update('update user_addresses set details = ? where user_id = ?',[$user_add,$user_id]);
                }
                

                $count++;
            }
            
            return back()->with('success',' Data Updated with Row '.$count);

        }
         catch (\Throwable $th) {
            throw $th;
        }

        
    }



    function updateproduct121team(Request $request){
        // chk user have active package or not!
        if(AuthRole() == "User"){
            return back()->with('error','You do not have Permission To Access This Page!');
        }    
        
        try {
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

            $rows = array_slice($rows,1);
            $master = $rows;

            // Decalaring Indexes Of Columns
            $product_idIndex = 0;
            $shop_slugIndex = 1;
            $product_titleIndex = 2;
            $pro_img1 = 3;
            $pro_img2 = 4;
            $pro_img3 = 5;
            $pro_img4 = 6;
            $pro_img5 = 7;
            $pro_img6 = 9;
            $video_urlIndex = 9;
            $pro_descIndex = 10;
            $artworkIndex = 11;
            $meterialsIndex = 12;
            $notifyIndex = 13;

            foreach ($master as $key => $item) {

                $arr_images = [];

                // gettign Shop Id
                $user_id = DB::table('user_shops')->where("slug",trim($item[$shop_slugIndex]))->first()->user_id;

                if (!$user_id) {
                    return back()->with('error', 'Slug Name Not Found Please Recheck !');
                }

                // Finding Product in Product Table
                $productObj = changeby121::create([
                    'title' => $item[$product_titleIndex],
                    'prodcut_id' => $item[$product_idIndex],
                    'desription' => $item[$pro_descIndex],
                    'video_url' => $item[$product_titleIndex],
                    'meterials' => $item[$meterialsIndex],
                    'artwork' => $item[$artworkIndex],
                    'allow' => 1,
                    'video_url' => $item[$video_urlIndex],
                ]);

                if(isset($item[$pro_img1]) && $item[$pro_img1] != null){
                    $media = new Media();
                    $media->tag = "Product_Image_By_admin";
                    $media->file_type = "Image";
                    $media->type = "Product_admin";
                    $media->type_id = 'admin';
                    $media->file_name = $item[$pro_img1];
                    $media->path = "storage/files/".auth()->id()."/".$item[$pro_img1];
                    $media->extension = explode('.',$item[$pro_img1])[1] ?? '';
                    $media->save();
                    $arr_images[] = $media->id;
                }

                if(isset($item[$pro_img2]) && $item[$pro_img2] != null){
                    $media = new Media();
                    $media->tag = "Product_Image_By_admin";
                    $media->file_type = "Image";
                    $media->type = "Product_admin";
                    $media->type_id = 'admin';
                    $media->file_name = $item[$pro_img2];
                    $media->path = "storage/files/".auth()->id()."/".$item[$pro_img2];
                    $media->extension = explode('.',$item[$pro_img2])[1] ?? '';
                    $media->save();
                    $arr_images[] = $media->id;
                }
                
                if(isset($item[$pro_img3]) && $item[$pro_img3] != null){
                    $media = new Media();
                    $media->tag = "Product_Image_By_admin";
                    $media->file_type = "Image";
                    $media->type = "Product_admin";
                    $media->type_id = 'admin';
                    $media->file_name = $item[$pro_img3];
                    $media->path = "storage/files/".auth()->id()."/".$item[$pro_img3];
                    $media->extension = explode('.',$item[$pro_img3])[1] ?? '';
                    $media->save();
                    $arr_images[] = $media->id;
                }
                
                if(isset($item[$pro_img4]) && $item[$pro_img4] != null){
                    $media = new Media();
                    $media->tag = "Product_Image_By_admin";
                    $media->file_type = "Image";
                    $media->type = "Product_admin";
                    $media->type_id = 'admin';
                    $media->file_name = $item[$pro_img4];
                    $media->path = "storage/files/".auth()->id()."/".$item[$pro_img4];
                    $media->extension = explode('.',$item[$pro_img4])[1] ?? '';
                    $media->save();
                    $arr_images[] = $media->id;
                }

                if(isset($item[$pro_img5]) && $item[$pro_img5] != null){
                    $media = new Media();
                    $media->tag = "Product_Image_By_admin";
                    $media->file_type = "Image";
                    $media->type = "Product_admin";
                    $media->type_id = 'admin';
                    $media->file_name = $item[$pro_img5];
                    $media->path = "storage/files/".auth()->id()."/".$item[$pro_img5];
                    $media->extension = explode('.',$item[$pro_img5])[1] ?? '';
                    $media->save();
                    $arr_images[] = $media->id;
                }
                
                if(isset($item[$pro_img6]) && $item[$pro_img6] != null){
                    $media = new Media();
                    $media->tag = "Product_Image_By_admin";
                    $media->file_type = "Image";
                    $media->type = "Product_admin";
                    $media->type_id = 'admin';
                    $media->file_name = $item[$pro_img6];
                    $media->path = "storage/files/".auth()->id()."/".$item[$pro_img6];
                    $media->extension = explode('.',$item[$pro_img6])[1] ?? '';
                    $media->save();
                    $arr_images[] = $media->id;
                }

                // Sending Notification TO Linked Users
                if ($item[$notifyIndex] == 1) {
                    $othershops = UserShopItem::where('user_id','!=',$user_id)->where('product_id',$item[$product_idIndex])->get();
                    foreach($othershops as $other){
                        // Unpublish all sellers who has this product
                        // $other->is_published = 0;
                        // $other->save();
                        $user_record =  getUserRecordByUserId($other->user_id);
                        $onsite_notification['user_id'] =  $other->user_id;
                        $onsite_notification['title'] = "121 Team Made Change on ". NameById($user_id)." User's Product Images 
                        $item[$product_idIndex] (Model-#All Product) , resulting in Get New Changes By Team 121 , review changes and publish." ;
                        $onsite_notification['link'] = route('panel.user_shop_items.edit')."/".$othershops->id;
                        pushOnSiteNotification($onsite_notification);
                    }
                }
                   
                // Add images to UserShopItem
                if(count($arr_images) > 0) {
                    $productObj->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                    $productObj->save();
                }

                if ($productObj) {
                    ++$count;
                }
            }
         
            return redirect(route('panel.filemanager.index'))->with('success', 'Good News! '.$count.' records created successfully!');


        } catch (\Throwable $th) {
            return back()->with('error',"SomeThing Went Wrong While Trying to Upload $th");
        }

        
        
    }


    
    public function inventoryExportDownloadBulkExport($products)
    { 
        // return $products;
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        $usershop = getShopDataByUserId(auth()->id());
        try {
            $fileName = "Inventory of ".$usershop->name.".xlsx";
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($products);
            $Excel_writer = new Xlsx($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=$fileName");
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }
    
    function inventoryExportDownload(Request $request){
        try {
            $products = Inventory::where('user_id',auth()->id())->get();
            $products_array_start = array('Id','Product Name','Model Code');
            $custom_attribute = json_decode(auth()->user()->custom_attriute_columns);
            $products_array_end = array('Backup stock' , 'Own Stock' );
            $final_array[] = array_merge($products_array_start,$custom_attribute,$products_array_end);
            $used_extrainfo_ids = [];
            $tmp_val = [];


            // ! UnCommon Attribute other than colour size material....
            $uncommonAttribute = $custom_attribute;
            unset($uncommonAttribute[0],$uncommonAttribute[1],$uncommonAttribute[2]);


                foreach($products as $main_key => $product){
                    $tmpArray = [];
                    $tmpArray_uncommon = [];
                    $tmpArray_common = [];
                    $tmpValue_array_Attrbute = [];
                    $start_array = [];
                    $end_array = [];

                    $product_info = Product::whereId($product->product_id)->first();
                    $productExtra_info = ProductExtraInfo::where('product_id',$product->product_id)->groupBy('attribute_id')->pluck('attribute_value_id');

                    // ! For Uncommon
                    foreach ($uncommonAttribute as $key => $value) {
                        $tmpArray_uncommon["$value"] = getAttributeIdByName($value,auth()->id());
                    }

                    $color_array = ProductExtraInfo::where('product_id',$product->product_id)->where('attribute_id',1)->groupBy('attribute_value_id')->pluck('attribute_value_id');

                    $color_Val = [];
                    if ($color_array != null) {
                        foreach ($color_array as $key => $value) {
                            $color_Val[$key] = getAttruibuteValueById($value)->attribute_value;
                        }                
                    }else{
                        $color_Val = '';
                    }

                    $size_array = ProductExtraInfo::where('product_id',$product->product_id)->where('attribute_id',2)->groupBy('attribute_value_id')->pluck('attribute_value_id');

                    $size_Val = [];
                    if ($size_array != null) {
                        foreach ($size_array as $key => $value) {
                            $size_Val[$key] = getAttruibuteValueById($value)->attribute_value;
                        }                
                    }else{
                        $size_Val = '';
                    }


                    $material_array = ProductExtraInfo::where('product_id',$product->product_id)->where('attribute_id',3)->groupBy('attribute_value_id')->pluck('attribute_value_id');

                    $material_Val = [];
                    if ($material_array != null) {
                        foreach ($material_array as $key => $value) {
                            $material_Val[$key] = getAttruibuteValueById($value)->attribute_value;
                        }                
                    }else{
                        $material_Val = '';
                    }


                    $PRODUCT_ATTRIBUTE_ARRAY = [];
                    if ($uncommonAttribute != null) {
                        foreach ($uncommonAttribute as $attributes) {
                            $id = getAttributeIdByName($attributes,auth()->id());
                            
                            $attribute_array = ProductExtraInfo::where('product_id',$product->product_id)->where('attribute_id',$id)->groupBy('attribute_value_id')->pluck('attribute_value_id');
            
                            $ashu = [];
                            if ($attribute_array != null) {
                                foreach ($attribute_array as $key => $value) {
                                    $ashu[$key] = getAttruibuteValueById($value)->attribute_value;
                                }
                            }else{
                                $ashu = '';
                            }

                            $PRODUCT_ATTRIBUTE_ARRAY[$attributes] = implode("^^",$ashu);
                        }
                    }

                    $start_array[] = array(
                        'Id' => $product->id,
                        'Product Name' => $product_info->title ?? "",
                        'Model Code' => $product_info->model_code ?? "" ,
                        'Colour' => implode("^^",$color_Val) ?? '',
                        'Size' => implode("^^",$size_Val) ?? '',
                        'Material' => implode("^^",$material_Val) ?? '',

                    );

                    $end_array[] = array(
                        'Backup stock' => $product->prent_stock,
                        'stock' => $product->stock,
                    );

                    // ` Settign Up FInal Array to Export
                    $final_array[] = array_merge($start_array[0],$PRODUCT_ATTRIBUTE_ARRAY,$end_array[0]);

                }
                
                $this->inventoryExportDownloadBulkExport($final_array);
                return back()->with('success',' Export Excel File Successfully');
                
        } catch (\Throwable $th) {
            throw $th;
            // echo $th;
        }
    }

    
    public function inventoryGroupBulkUpdate(Request $request)
    {
   
        $count = 0;
        $row = 0;
        
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
        $idIndex = 0;
        $BackupstockIndex = 5;
        $stockIndex = 6;
        
        foreach ($master as $key => $item) {
            $TandA = [];
            $row = $key+1;
            // Checking Id Match with User or Not.
            $chk = Inventory::whereId($item[$idIndex])->first();
            
            if ($chk->user_id != auth()->id()) {
                return back()->with('error',"ID Not Match!! At Row ".$row);
            }

            // // getting Linked Inventory of Product
            // $linked_products_inventory = Inventory::whereproductId($chk->product_id)->where('user_id','!=',auth()->id())->get();
            // foreach ($linked_products_inventory as $key => $products) {
            //     $products->prent_stock = $item[$stockIndex];
            //     $products->save();
            // }
            
            // Start Updateing Inventory
            $chk->update([
                'prent_stock' => $item[$BackupstockIndex] ?? 0,
                'stock' => $item[$stockIndex] ?? 0,
            ]);
            $count++;
        }

        $msg = $count." Records Are Updated !!";
        return back()->with('success',$msg);
    }

    // T&A Export and Update

    public function DeliveryExportDownloadBulkExport($products)
    { 
        // return $products;
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        $usershop = getShopDataByUserId(auth()->id());
        try {
            $fileName = "T&A of ".$usershop->name.".xlsx";
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($products);
            $Excel_writer = new Xlsx($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=$fileName");
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    function DeliveryExportDownload(Request $request){
        try {
            $products_array [] = array('id','Product Name','Modal Code','Delivery stock (Use ^^ to Sparate)', 'Delivery Period (Use ^^ to Sparate)');

            $products = Product::where('user_id',auth()->id())->groupBy('sku')->pluck('id');
                foreach($products as $product){
                    $product_info = Product::whereId($product)->first();

                    $delivery_stock = TimeandActionModal::where('product_id',$product)->pluck('delivery_stock')->toArray();
                    $delivery_period = TimeandActionModal::where('product_id',$product)->pluck('delivery_period')->toArray();
                    
                    $products_array[] = array(
                        'Id' => $product,
                        'Product Name' => $product_info->title ?? "",
                        'Model Code' => $product_info->model_code ?? "" ,
                        'Delivery stock (Use ^^ to Sparate)' => implode("^^",$delivery_stock),
                        'Delivery Period (Use ^^ to Sparate)' =>  implode("^^",$delivery_period),
                    );
                    
                }

                $this->DeliveryExportDownloadBulkExport($products_array);
                return back()->with('success',' Export Excel File Successfully');
                
        } catch (\Throwable $th) {
            // throw $th;
            echo $th;
        }
    }

    public function DeliveryGroupBulkUpdate(Request $request)
    {
   
        $count = 0;
        $row = 0;
        
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
        $idIndex = 0;
        $ProductnameIndex = 1;
        $ModalCodeIndex = 2;
        $deliveryQuantityIndex = 3; 
        $deliveryPeriodIndex = 4; 
        
        foreach ($master as $key => $item) {
            $TandA = [];
            $row = $key+1;
        
            $chk = Product::whereId($item[$idIndex])->first();
            if ($chk->user_id != auth()->id()) {
                return back()->with('error',"Product id not match at row :".$row);
            }

            if ($item[$deliveryQuantityIndex] != null || $item[$deliveryPeriodIndex] != null) {
                // Exploding String
                $deliveryStock = explode("^^",$item[$deliveryQuantityIndex]);   
                $deliveryPeriod = explode("^^",$item[$deliveryPeriodIndex]);
                
                // Maching Count
                if (count($deliveryPeriod) != count($deliveryStock)) {
                    return back()->with('error',"Delivery Time And Stock Not MAtch At Row ".$row);
                }

                // Delelting Old Items in Time and action Delivery
                $old_delivery_info = TimeandActionModal::where('product_sku',$chk->sku)->delete();

                $usi = UserShopItem::where('product_id',$item[$idIndex])->first();

                for ($i=0; $i < count($deliveryPeriod); $i++) { 
                    TimeandActionModal::create([
                        'product_id' => $item[$idIndex],
                        'user_shop_item_id' => $usi->id,
                        'user_id' => auth()->id(),
                        'product_sku' => $chk->sku,
                        'delivery_stock' => $deliveryStock[$i],
                        'delivery_period' => $deliveryPeriod[$i],
                    ]);
                }
                $count++;
            }
        }

        $msg = $count." Records Are Updated !!";
        return back()->with('success',$msg);
    }

      
}
 