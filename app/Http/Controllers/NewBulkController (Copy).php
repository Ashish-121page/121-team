<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Group;
use App\Models\GroupProduct;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductExtraInfo;
use App\Models\UserShop;
use App\Models\UserShopItem;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpParser\Node\Stmt\Return_;
use Psy\TabCompletion\Matcher\ObjectMethodDefaultParametersMatcher;

class NewBulkController extends Controller
{

    public function productUpload(Request $request)
    {
        // chk user have active package or not!
        if(AuthRole() == "User"){
            if(!haveActivePackageByUserId(auth()->id())){
                return back()->with('error','You do not have any active package!');
            } 
        }    
        

        // - Configuring Important Variable
        $user = auth()->user();
        $user_shop = UserShop::where('user_id',$user->id)->first();
        $Array_saprator = "^^";
        $count = 0;
        $SampleMinYear = 1985;
        $SampleMaxYear = Carbon::now()->format('Y');
        $check_permision_array = ['yes','no',"Yes","No","YES","NO",'0','1'];
        $allowed_array = ['yes',"Yes","YES",'1'];
        $Months_array = ['January', 'February', 'March', 'April', 'May','June', 'July', 'August', 'September', 'October', 'November','December', 'january','february','march','april','may','june','july','august','september','october','november','december'];

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

        $rows = array_slice($rows,3);
        $master = $rows;

        // $head = array_shift($rows);
        $master = $rows;

        // ` Col LIst in Form of Object
        $col_list = json_decode($user->bulk_upload_Sheet);
        // ` Col LIst in Form of Array
        $main_Arr = array_keys((array) $col_list);
        
        // ` Start Indexing fo Column
        $ModelCodeIndex = $col_list->{'Model_Code'};
        $CategoryIndex = $col_list->{'Category'};
        $SubCategoryIndex = $col_list->{'Sub_Category'};
        $CurrencyIndex = $col_list->{'Base_currency'};
        $AllowResellerIndex = $col_list->{'Allow_Resellers'};
        $PublishIndex = $col_list->{'Live / Active'};
        $ExlusiveIndex = $col_list->{'Copyright/ Exclusive item'};
        $MaterialIndex = $col_list->{'Material'};
        $ColourIndex = $col_list->{'Colour'};
        $SizeIndex = $col_list->{'Size'};
        $SamepleAvailableIndex = $col_list->{'Sample / Stock available'};
        $SKUTypeIndex = $col_list->{'SKU Type'};
        $TitleIndex = $col_list->{'Product name'};
        $VideoURLIndex = $col_list->{'Video URL'};
        $CustomerPriceIndex = $col_list->{'Customer_Price_without_GST'};
        $VIPPriceIndex = $col_list->{'Shop_Price_VIP_Customer'};
        $ResellerPriceIndex = $col_list->{'Shop_Price_Reseller'};
        $MRPIndex = $col_list->{'mrpIncl tax'};
        $HSNTaxIndex = $col_list->{'HSN Tax'};
        $HSNPercentageIndex = $col_list->{'HSN_Percnt'};
        $CollectionYearIndex = $col_list->{'Theme / Collection Year'};
        $SampleYearIndex = $col_list->{'Sample Year'};
        $SampleMonthIndex = $col_list->{'Sample Month'};
        $SampleTimeIndex = $col_list->{'Sampling time'};
        $CBMIndex = $col_list->{'CBM'};
        $ProductionTimeIndex = $col_list->{'Production time (days)'};
        $MBQIndex = $col_list->{'MBQ'};
        $MBQ_unitsIndex = $col_list->{'MBQ_units'};
        $SourcingYearIndex = $col_list->{'Sourcing Year'} ;
        $SourcingMonthIndex = $col_list->{'Sourcing month'};
        $StandardCartonIndex =$col_list->{'standard_carton_pcs'};
        $CartonWeightIndex =$col_list->{'carton_weight_actual'};
        $CartonUnitIndex =$col_list->{'unit'};
        $HeightIndex = $col_list->{'Product height'};
        $WidthIndex = $col_list->{'Product width'};
        $LengthIndex = $col_list->{'Product length'};
        $LengthUnitIndex = $col_list->{'Dimensions_unit'};
        $NetWeightUnitIndex = $col_list->{'Net weight'};
        $GrossweightIndex = $col_list->{'Gross weight'};
        $WeightUnitIndex = $col_list->{'Weight_unit'};
        $Tag1Index = $col_list->{'Search keywords'};
        $artwork_urlIndex = $col_list->{'artwork_url'};
        $DescriptionIndex = $col_list->{'description'};
        $ExclusiveBuyerNameIndex = $col_list->{'Exclusive Buyer Name'};
        $Collection_NameIndex = $col_list->{'Theme / Collection Name'};
        $SeasonMonthIndex = $col_list->{'Season / Month'};
        $vendor_sourced_fromIndex = $col_list->{'Vendor Sourced from'};
        $vendor_priceIndex = $col_list->{'Vendor price'};
        $product_cost_unitIndex = $col_list->{'Product Cost_Unit'};
        $vendor_currencyIndex = $col_list->{'Vendor currency'};
        $sourcing_yearIndex = $col_list->{'Sourcing Year'};
        $VariationAttributesIndex = $col_list->{'Variation attributes'};

        // ` Image Indexig
        $ImageMainIndex = $col_list->{'Image_main'};
        $ImageFrontIndex = $col_list->{'image_name_front'};
        $ImageBackIndex = $col_list->{'image_name_back'};
        $ImageSide1Index = $col_list->{'image_name_side1'};
        $ImageSide2Index = $col_list->{'image_name_side2'};
        $ImagePosterIndex = $col_list->{'image_name_poster'};
        $ExtraImageIndex = $col_list->{'Additional Image Use ^^'};



        // ! Validating Loop
        foreach ($master as $key => $temp_item) {
            $row = $key+4;
            // ` Main Product Type 
            $main_product = ['main','Main','MAIN'];
                if (in_array($temp_item[$SKUTypeIndex],$main_product)){
                    if ($temp_item[$TitleIndex] == null || $temp_item[$TitleIndex] == '') {
                        return back()->with("error","Title Can't be Blank at Row $row");
                    }
                } # End of Main Varient Check...
            
                // ` Checking Model Code
                if ($temp_item[$ModelCodeIndex] != null && $temp_item[$ModelCodeIndex] != "") {
                    // Checking Group Id..
                    $checkSKU = Product::where('model_code',$temp_item[$ModelCodeIndex])->where('user_id',auth()->id())->first();
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

                // ` Checking Category
                if ($temp_item[$CategoryIndex] == null) {
                    return back()->with('error',"Category Is Blank at Row $row");
                }else{
                    $chk = Category::where('name',$temp_item[$CategoryIndex])->where('category_type_id',13)->get();
                    if (count($chk) > 0) {
                        $Category_id = $chk[0]->id;
                    }else{
                        return back()->with('error',"Category is Not Exist at Row $row");
                    }
                }

                // ` Checking Sub Category
                if ($temp_item[$SubCategoryIndex] == null) {
                    return back()->with('error',"Sub Category Is Blank at Row $row");
                }else{
                    $chk = Category::where('name',$temp_item[$SubCategoryIndex])->where('parent_id',$Category_id)->get();
                    if (!count($chk) > 0) {
                        return back()->with('error',"Sub category Is Matched with Category at Row $row");
                    }
                    $sub_category_id = $chk[0]->id;
                }

                // ` Checking Currency
                if ($temp_item[$CurrencyIndex] == null) {
                    $Currency = 'INR';
                }else{
                    $chk = Country::where('currency',$temp_item[$CurrencyIndex])->get();
                    if (count($chk) > 0) {
                        // echo "We Have ... $temp_item[$CurrencyIndex] <br>";
                        $Currency = $temp_item[$CurrencyIndex];
                    }else{
                        return back()->with('error',"That Currency is not Available at Row $row");
                    }
                }

                // ` Checking Allow Reseller Input
                if (!in_array($temp_item[$AllowResellerIndex],$check_permision_array)) {
                    return back()->with('error',"The Value is not MAtched in Allow Reseller at Row $row");
                }

                // ` Checking Allow Live and Publish
                if (!in_array($temp_item[$PublishIndex],$check_permision_array)) {
                    return back()->with('error',"you Didn't Select Live / Active at Row $row");
                }

                // ` Checking Exclusive Product
                if (!in_array($temp_item[$ExlusiveIndex],$check_permision_array)) {
                    return back()->with('error',"you Didn't Fill Exclusive Product Option at Row $row");
                }

                // ` Checking Sample Stock Available
                if (!in_array($temp_item[$SamepleAvailableIndex],$check_permision_array)) {
                    return back()->with('error',"you Didn't Fill Sample Availabel Option at Row $row");
                }



                // - Conditions that are Complusaory to Match...

                // ` Checking Material Value
                if ($temp_item[$MaterialIndex] != null) {
                    $Material_values = ProductAttribute::where('name','Material')->where('user_id',null)->first()->value;
                    $chk = explode(",",json_decode($Material_values)[0]);
                    $material_arr = explode($Array_saprator,$temp_item[$MaterialIndex]);
                    foreach ($material_arr as $key => $Material) {
                        if (!in_array($Material,$chk)) {
                            return back()->with('error',"Material: $Material, is Not in Array at Row $row");
                        }
                    }
                }else{
                    $material_arr = null;
                }

                // ` Checking Colour Value
                if ($temp_item[$ColourIndex] != null) {
                    $Material_values = ProductAttribute::where('name','Color')->where('user_id',null)->first()->value;
                    $chk = explode(",",json_decode($Material_values)[0]);
                    $colour_arr = explode($Array_saprator,$temp_item[$ColourIndex]);
                    foreach ($colour_arr as $key => $colour) {
                        if (!in_array($colour,$chk)) {
                            return back()->with('error',"Colour: $colour, is Not in Array at Row $row");
                        }
                    }
                }else{
                    // return back()->with("error","Colour is not Filled at Row $row");
                    $colour_arr = null;
                }

                // ` Checking Size Value
                if ($temp_item[$SizeIndex] != null) {
                    $Material_values = ProductAttribute::where('name','Size')->where('user_id',null)->first()->value;
                    $chk = explode(",",json_decode($Material_values)[0]);
                    $size_arr = explode($Array_saprator,$temp_item[$SizeIndex]);
                    foreach ($size_arr as $key => $sizes) {
                        if (!in_array($sizes,$chk)) {
                            return back()->with('error',"Size: $sizes, is Not in Array at Row $row");
                        }
                    }
                }else{
                    $size_arr = null;
                    // return back()->with("error","Size is not Filled at Row $row");
                }

                // // ` Checking Video URL
                // if ($temp_item[$VideoURLIndex] != null) {
                //     if (!isValidURL($temp_item[$VideoURLIndex])) {
                //         return back()->with('error',"Enter a Valid URL at Row $row");
                //     }
                // }

                // ` Checking Customer Price
                if ($temp_item[$CustomerPriceIndex] != null) {
                    if (!is_numeric($temp_item[$CustomerPriceIndex])) {
                        return back()->with('error',"Enter valid amount in Customer Price at Row $row");
                    }
                }

                // ` Checking VIP Price
                if ($temp_item[$VIPPriceIndex] != null) {
                    if (!is_numeric($temp_item[$VIPPriceIndex])) {
                        return back()->with('error',"Enter valid amount in VIP Price at Row $row");
                    }
                }

                // ` Checking Reseller Price
                if ($temp_item[$ResellerPriceIndex] != null) {
                    if (!is_numeric($temp_item[$ResellerPriceIndex])) {
                        return back()->with('error',"Enter valid amount in Reseller Price at Row $row");
                    }
                }

                // ` Checking MRP Price
                if ($temp_item[$MRPIndex] != null) {
                    if (!is_numeric($temp_item[$MRPIndex])) {
                        return back()->with('error',"Enter valid amount in MRP at Row $row");
                    }
                }

                // ` Checking HSN Tax Price
                if ($temp_item[$HSNTaxIndex] != null) {
                    if (!is_numeric($temp_item[$HSNTaxIndex])) {
                        return back()->with('error',"Enter valid HSN TAX at Row $row");
                    }
                }

                // ` Checking HSN Tax Price
                if ($temp_item[$HSNPercentageIndex] != null) {
                    if (!is_numeric($temp_item[$HSNPercentageIndex])) {
                        return back()->with('error',"Enter valid HSN PErcentage in Number at Row $row");
                    }
                }
            
                // ` Checking Theme / COllection Year...
                if ($temp_item[$CollectionYearIndex] != null) {
                    if ($temp_item[$CollectionYearIndex] >= $SampleMinYear && $temp_item[$CollectionYearIndex] <= $SampleMaxYear) {
                        echo "Between Theme Collection Range..".newline(5);
                    }else{
                        return back()->with('error',"Enter valid Theme / Collection Year at Row $row");
                    }
                }

                // ` Checking Sampling Year...
                if ($temp_item[$SampleYearIndex] != null) {
                    if ($temp_item[$SampleYearIndex] >= $SampleMinYear && $temp_item[$SampleYearIndex] <= $SampleMaxYear) {
                        // echo "Between Sample Year Range..".newline(5);
                    }else{
                        return back()->with('error',"Enter valid Sampling Year at Row $row");
                    }
                }


                // ` Checking Sample Month...
                if ($temp_item[$SampleMonthIndex] != null) {   
                    if (!in_array($temp_item[$SampleMonthIndex],$Months_array)) {
                        return back()->with('error',"Enter Valid Month in Sampling month at Row $row");
                    }
                }

                // ` Checking Sampling Time...
                if ($temp_item[$SampleTimeIndex] != null) {
                    if (!is_numeric($temp_item[$SampleTimeIndex])) {
                        return back()->with('error',"Enter Valid Sampling Time at Row $row");
                    }
                }

                // ` Checking CBM...
                if ($temp_item[$CBMIndex] != null) {
                    if (!is_numeric($temp_item[$CBMIndex])) {
                        return back()->with('error',"Enter Valid CBM at Row $row");
                    }
                }

                // ` Checking Production TIme...
                if ($temp_item[$ProductionTimeIndex] != null) {
                    if (!is_numeric($temp_item[$ProductionTimeIndex])) {
                        return back()->with('error',"Enter Valid Production Time at Row $row");
                    }
                }

                // ` Checking MBQ Index ...
                if ($temp_item[$MBQIndex] != null) {
                    if (!is_numeric($temp_item[$MBQIndex])) {
                        return back()->with('error',"Enter Valid MBQ unit at Row $row");
                    }
                }

                // ` Checking Sourcing Year...
                if ($temp_item[$SourcingYearIndex] != null) {
                    if ($temp_item[$SourcingYearIndex] >= $SampleMinYear && $temp_item[$SourcingYearIndex] <= $SampleMaxYear) {
                        // echo "Between Sample Year Range..".newline(5);
                    }else{
                        return back()->with('error',"Enter valid Sourcing Year at Row $row");
                    }
                }

                // ` Checking Sourcing Month...
                if ($temp_item[$SourcingMonthIndex] != null) {   
                    if (!in_array($temp_item[$SourcingMonthIndex],$Months_array)) {
                        return back()->with('error',"Enter Valid Month in Sourcing month at Row $row");
                    }
                }

                // ` Checking Extra Image
                if ($temp_item[$ExtraImageIndex] != null) {
                    $ProductextraImages = explode($Array_saprator,$temp_item[$ExtraImageIndex]);
                }else{
                    $ProductextraImages = null;
                }


                // ` Cheking Variation Value
                if ($temp_item[$VariationAttributesIndex] != null) {
                    $variationType_array = explode($Array_saprator,$temp_item[$VariationAttributesIndex]);
                    foreach ($variationType_array as $key => $variation) {
                        if (!in_array($variation,$main_Arr)) {
                            return back()->with('error',"Variation Atteributes Not Matched at Row $row.");
                        }
                        // checking Finsh Value
                        $variantion_col_temp = $col_list->{$variation};                        
                        $attribute_data = ProductAttribute::where('name',$variation)->first();
                        $attribute_value = explode(',',json_decode($attribute_data->value)[0]);
                        $receive_data = explode($Array_saprator,$temp_item[$variantion_col_temp]);
    
                        foreach ($receive_data as $key => $value) {
                            if ($value != '') {
                                if (!in_array($value,$attribute_value)) {
                                    return back()->with('error',"$value Not in Given Value at Row $row");
                                }
                            }
                        }
                    }
                    $variation_count = ($variationType_array != null) ? count($variationType_array) : 0;
                }
        }


        $modalArray = [];
        $SKUArray = [];
        // // Todo: Uploading Data to Server
        foreach ($master as $key => $item) {

            // ` Creating Price Groups 
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
           
            // - SKU CODE Generation BASED ON MODEL CODE
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

            // ` Checking Category
            if ($item[$CategoryIndex] == null) {
                return back()->with('error',"Category Is Blank at Row $row");
            }else{
                $chk = Category::where('name',$item[$CategoryIndex])->where('category_type_id',13)->get();
                if (count($chk) > 0) {
                    $Category_id = $chk[0]->id;
                }else{
                    return back()->with('error',"Category is Not Exist at Row $row");
                }
            }

            // ` Checking Sub Category
            if ($item[$SubCategoryIndex] == null) {
                return back()->with('error',"Sub Category Is Blank at Row $row");
            }else{
                $chk = Category::where('name',$item[$SubCategoryIndex])->where('parent_id',$Category_id)->get();
                if (!count($chk) > 0) {
                    return back()->with('error',"Sub category Is Matched with Category at Row $row");
                }
                $sub_category_id = $chk[0]->id;
            }
            


            $unique_slug  = getUniqueProductSlug($item[$TitleIndex]);
            // - Start Uploading Product....
            // Todo: Checking Product Exist in Database or Not..
            $product_chk = Product::where('sku',$sku_code)->get();

            if (count($product_chk) != 0) {
                $product_exist = $product_chk[0];
                       
            } # If end (Product Exist in Record)
            else{
                $product_exist = null;
            }


            $carton_details = [
                'standard_carton' => $item[$StandardCartonIndex],
                'carton_weight' => $item[$CartonWeightIndex],
                'carton_unit' => $item[$CartonUnitIndex],
             ];

             $shipping = [
                 'height' => $item[$HeightIndex],
                 'gross_weight' => $item[$GrossweightIndex],
                 'weight' => $item[$NetWeightUnitIndex],
                 'width' => $item[$WidthIndex],
                 'length' => $item[$LengthIndex],
                 'unit' => $item[$WeightUnitIndex],
                 'length_unit' => $item[$LengthUnitIndex],
             ];
      
             $carton_details = json_encode($carton_details);
             $shipping = json_encode($shipping);

             if ($item[$VariationAttributesIndex] != null) {
                $variationType_array = explode($Array_saprator,$item[$VariationAttributesIndex]);
                foreach ($variationType_array as $key => $variation) {
                    if (!in_array($variation,$main_Arr)) {
                        return back()->with('error',"Variation Atteributes Not Matched at Row $row.");
                    }
                    // checking Finsh Value
                    $variantion_col_temp = $col_list->{$variation};
                    $attribute_data = ProductAttribute::where('name',$variation)->first();                    
                    $attribute_value = explode(',',json_decode($attribute_data->value)[0]);
                    $receive_data = explode($Array_saprator,$item[$variantion_col_temp]);

                    foreach ($receive_data as $key => $value) {
                        if ($value != null) {
                            if (!in_array($value,$attribute_value)) {
                                return back()->with('error',"Not in Given Value at Row $row");
                            }
                        }
                    }
                }
                $variation_count = ($variationType_array != null) ? count($variationType_array) : 0;
            }else{
                $variationType_array = null;
            }

            if ($variationType_array != null) {
                // Get Count of 1st Element
                $colour_arr1 = array_search('Colour',$variationType_array);
                $size_arr1 = array_search('Size',$variationType_array);
                $material_arr1 = array_search('Material',$variationType_array);
    
                $color_attribut1 = $variationType_array[$colour_arr1];
                $size_attribut2 = $variationType_array[$size_arr1];
                $Material_attribut3 = $variationType_array[$material_arr1];
                
                // Get Count of Colour Element
                $itrem1 = (explode($Array_saprator,$item[array_search($color_attribut1,$main_Arr)]) != null) ? count(explode($Array_saprator,$item[array_search($color_attribut1,$main_Arr)])) : 0;
                // Get Count of Size Element
                $itrem2 = (explode($Array_saprator,$item[array_search($size_attribut2,$main_Arr)]) != null) ? count(explode($Array_saprator,$item[array_search($size_attribut2,$main_Arr)])) : 0;
                // Get Count of Material Element
                $itrem3 = (explode($Array_saprator,$item[array_search($Material_attribut3,$main_Arr)]) != null) ? count(explode($Array_saprator,$item[array_search($Material_attribut3,$main_Arr)])) : 0;
                
                $colour_arr = explode($Array_saprator,$item[$ColourIndex]);
                $size_arr = explode($Array_saprator,$item[$SizeIndex]);
                $material_arr = explode($Array_saprator,$item[$MaterialIndex]);

                if ($variation_count == 3) {
                    if($itrem1 != 0 && $itrem2 != 0 && $itrem3 != ''){
                        foreach (explode($Array_saprator,$item[array_search($variationType_array[0],$main_Arr)]) as $key => $value1) {
                            foreach (explode($Array_saprator,$item[array_search($variationType_array[1],$main_Arr)]) as $key => $value2) {
                                foreach (explode($Array_saprator,$item[array_search($variationType_array[2],$main_Arr)]) as $key => $value3) {
                                        // - Varient Based on Color and Size
                                            $price = ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->price : trim($item[$CustomerPriceIndex]);
                                            $product_obj =  Product::create([
                                            'title' => ($product_exist != null && $item[$TitleIndex] == null) ? $product_exist->title : $item[$TitleIndex],
                                            'model_code' => ($product_exist != null && $item[$ModelCodeIndex] == null) ? $product_exist->model_code : $item[$ModelCodeIndex],
                                            'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                                            'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                                            // 'brand_id' => ($product_exist != null && $item[$ModelCodeIndex] != null) ? $product_exist->brand_id : $request->brand_id ?? 0,
                                            'user_id' => $user->id,
                                            'sku' => $sku_code,
                                            'slug' => $unique_slug,
                                            'color' => ($product_exist != null && $value1 == '') ? $product_exist->color : trim($value1),
                                            'size' => ($product_exist != null && $value2 == '') ? $product_exist->size : $value2,
                                            'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->description : $item[$DescriptionIndex],
                                            'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                                            'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                                            'manage_inventory' => $item[$SamepleAvailableIndex],
                                            'stock_qty' => 0,
                                            'status' => 0,
                                            'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                                            'price' => $price ?? 0,
                                            'min_sell_pr_without_gst' => ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->min_sell_pr_without_gst : $item[$CustomerPriceIndex], 
                                            'hsn' => ($product_exist != null && $item[$HSNTaxIndex] == '') ? $product_exist->hsn : $item[$HSNTaxIndex] ?? null,
                                            'hsn_percent' => ($product_exist != null && $item[$HSNPercentageIndex] == '') ? $product_exist->hsn_percent : $item[$HSNPercentageIndex] ?? null,
                                            'mrp' => ($product_exist != null && $item[$MRPIndex] == '') ? $product_exist->mrp : trim($item[$MRPIndex]),
                                            'video_url' => ($product_exist != null && $item[$VideoURLIndex] == '') ? $product_exist->video_url : $item[$VideoURLIndex],
                                            'search_keywords' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$Tag1Index],
                                            'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                            'material' => ($product_exist != null && $value3 == '') ? $product_exist->material : $value3,
                                            'exclusive' => $item[$ExlusiveIndex] ?? 0,
                                            'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                                        ]);                    
                                        
                             
                
                                        $product_extra_info_obj = ProductExtraInfo::create([
                                            'product_id' => $product_obj->id,
                                            'user_id' => $user->id,
                                            'user_shop_id' => $user_shop->id, 
                                            'allow_resellers' => $item[$AllowResellerIndex],
                                            'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                            'collection_name' => $item[$Collection_NameIndex],
                                            'season_month' => $item[$SeasonMonthIndex],
                                            'sample_available' => $item[$SamepleAvailableIndex],
                                            'sample_year' => $item[$SampleYearIndex],
                                            'sample_month' => $item[$SampleMonthIndex],
                                            'sampling_time' => $item[$SampleTimeIndex],
                                            'CBM' => $item[$CBMIndex],
                                            'production_time' => $item[$ProductionTimeIndex],
                                            'MBQ' => $item[$MBQIndex],
                                            'MBQ_unit' => $item[$MBQ_unitsIndex],
                                            'vendor_sourced_from' => $item[$vendor_sourced_fromIndex],
                                            'vendor_price' => $item[$vendor_priceIndex],
                                            'product_cost_unit' => $item[$product_cost_unitIndex],
                                            'vendor_currency' => $item[$vendor_currencyIndex],
                                            'sourcing_year' => $item[$sourcing_yearIndex],
                                        ]);
                
                                        // Create USI Rec
                                        $usi = UserShopItem::create([
                                            'user_id'=> $user->id,
                                            'category_id'=> $Category_id,
                                            'sub_category_id'=> $sub_category_id,
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
                                                'price'=> $item[$ResellerPriceIndex],
                                            ]);
                                        }
                                    
                                        if($vip_group){
                                            // create Vip Group record
                                            GroupProduct::create([
                                                'group_id'=>$vip_group->id,
                                                'product_id'=>$product_obj->id,
                                                'price'=>  $item[$VIPPriceIndex],
                                            ]);
                                        }
                
                                        $arr_images = [];
                                        // * Start Creating Media...
                                        if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                                            $media = new Media();
                                            $media->tag = "Product_Image";
                                            $media->file_type = "Image";
                                            $media->type = "Product";
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
                                            $media->file_name = $item[$ImagePosterIndex];
                                            $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                                            $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                            $media->save();
                                            $arr_images[] = $media->id;
                                        }
                
                
                                        if ($ProductextraImages != null) {
                                            foreach ($ProductextraImages as $key => $ExtImg) {
                                                $media = new Media();
                                                $media->tag = "Product_Image";
                                                $media->file_type = "Image";
                                                $media->type = "Product";
                                                $media->type_id = $product_obj->id;
                                                $media->file_name = $item[$ImagePosterIndex];
                                                $media->path = "storage/files/".auth()->id()."/".$ExtImg;
                                                $media->extension = explode('.',$ExtImg)[1] ?? '';
                                                $media->save();
                                                $arr_images[] = $media->id;
                                            }
                                        }
                
                                        // Add images to UserShopItem
                                        if(count($arr_images) > 0) {
                                            $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                            $usi->save();
                                        }
                                            
                                        if($product_obj){
                                            ++$count;
                                        }
                                }
                            }
                        }
                    
                    }else{
                        return back()->with('error',"Attributes Can't be Blank at Row $row.");
                    }
                }elseif ($variation_count == 2) {
                
                        // ` Material and Size
                        if (in_array('Size',$variationType_array) && in_array('Material',$variationType_array)) {
                                if ($itrem2 != '' && $itrem3 != '') {
                                    // - Varient Based on Material and Size
                                    foreach (explode($Array_saprator,$item[array_search($Material_attribut3,$main_Arr)]) as $key => $material) {   
                                            foreach (explode($Array_saprator,$item[array_search($size_attribut2,$main_Arr)]) as $key => $size) {
                                                $price = ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->price : trim($item[$CustomerPriceIndex]);
                                                $product_obj =  Product::create([
                                                'title' => ($product_exist != null && $item[$TitleIndex] == null) ? $product_exist->title : $item[$TitleIndex],
                                                'model_code' => ($product_exist != null && $item[$ModelCodeIndex] == null) ? $product_exist->model_code : $item[$ModelCodeIndex],
                                                'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                                                'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                                                'brand_id' => $request->brand_id ?? 0,
                                                'user_id' => $user->id,
                                                'sku' => $sku_code,
                                                'slug' => $unique_slug,
                                                'color' => ($product_exist != null && $item[$ColourIndex] == '') ? $product_exist->color : trim($item[$ColourIndex]),
                                                'size' => ($product_exist != null && $size == '') ? $product_exist->size : $size,
                                                'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->description : $item[$DescriptionIndex],
                                                'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                                                'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                                                'manage_inventory' => $item[$SamepleAvailableIndex],
                                                'stock_qty' => 0,
                                                'status' => 0,
                                                'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                                                'price' => $price ?? 0,
                                                'min_sell_pr_without_gst' => ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->min_sell_pr_without_gst : $item[$CustomerPriceIndex], 
                                                'hsn' => ($product_exist != null && $item[$HSNTaxIndex] == '') ? $product_exist->hsn : $item[$HSNTaxIndex] ?? null,
                                                'hsn_percent' => ($product_exist != null && $item[$HSNPercentageIndex] == '') ? $product_exist->hsn_percent : $item[$HSNPercentageIndex] ?? null,
                                                'mrp' => ($product_exist != null && $item[$MRPIndex] == '') ? $product_exist->mrp : trim($item[$MRPIndex]),
                                                'video_url' => ($product_exist != null && $item[$VideoURLIndex] == '') ? $product_exist->video_url : $item[$VideoURLIndex],
                                                'search_keywords' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$Tag1Index],
                                                'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                                'material' => $material,
                                                'exclusive' => $item[$ExlusiveIndex] ?? 0,
                                                'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                                            ]);                    
                                            
                
                                            $product_extra_info_obj = ProductExtraInfo::create([
                                                'product_id' => $product_obj->id,
                                                'user_id' => $user->id,
                                                'user_shop_id' => $user_shop->id, 
                                                'allow_resellers' => $item[$AllowResellerIndex],
                                                'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                                'collection_name' => $item[$Collection_NameIndex],
                                                'season_month' => $item[$SeasonMonthIndex],
                                                'sample_available' => $item[$SamepleAvailableIndex],
                                                'sample_year' => $item[$SampleYearIndex],
                                                'sample_month' => $item[$SampleMonthIndex],
                                                'sampling_time' => $item[$SampleTimeIndex],
                                                'CBM' => $item[$CBMIndex],
                                                'production_time' => $item[$ProductionTimeIndex],
                                                'MBQ' => $item[$MBQIndex],
                                                'MBQ_unit' => $item[$MBQ_unitsIndex],
                                                'vendor_sourced_from' => $item[$vendor_sourced_fromIndex],
                                                'vendor_price' => $item[$vendor_priceIndex],
                                                'product_cost_unit' => $item[$product_cost_unitIndex],
                                                'vendor_currency' => $item[$vendor_currencyIndex],
                                                'sourcing_year' => $item[$sourcing_yearIndex],
                                            ]);
                
                                            // Create USI Rec
                                            $usi = UserShopItem::create([
                                                'user_id'=> $user->id,
                                                'category_id'=> $Category_id,
                                                'sub_category_id'=> $sub_category_id,
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
                                                    'price'=> $item[$ResellerPriceIndex],
                                                ]);
                                            }
                                        
                                            if($vip_group){
                                                // create Vip Group record
                                                GroupProduct::create([
                                                    'group_id'=>$vip_group->id,
                                                    'product_id'=>$product_obj->id,
                                                    'price'=>  $item[$VIPPriceIndex],
                                                ]);
                                            }
                
                                            $arr_images = [];
                                            // * Start Creating Media...
                                            if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                                                $media = new Media();
                                                $media->tag = "Product_Image";
                                                $media->file_type = "Image";
                                                $media->type = "Product";
                                                $media->type_id = $product_obj->id;
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
                                                $media->type_id = $product_obj->id;
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
                                                $media->type_id = $product_obj->id;
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
                                                $media->type_id = $product_obj->id;
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
                                                $media->type_id = $product_obj->id;
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
                                                $media->type_id = $product_obj->id;
                                                $media->file_name = $item[$ImagePosterIndex];
                                                $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                                                $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                                $media->save();
                                                $arr_images[] = $media->id;
                                            }
                
                
                                            if ($ProductextraImages != null) {
                                                foreach ($ProductextraImages as $key => $ExtImg) {
                                                    $media = new Media();
                                                    $media->tag = "Product_Image";
                                                    $media->file_type = "Image";
                                                    $media->type = "Product";
                                                    $media->type_id = $product_obj->id;
                                                    $media->file_name = $item[$ImagePosterIndex];
                                                    $media->path = "storage/files/".auth()->id()."/".$ExtImg;
                                                    $media->extension = explode('.',$ExtImg)[1] ?? '';
                                                    $media->save();
                                                    $arr_images[] = $media->id;
                                                }
                                            }
                
                                            // Add images to UserShopItem
                                            if(count($arr_images) > 0) {
                                                $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                                $usi->save();
                                            }
                                                
                                            if($product_obj){
                                                ++$count;
                                            }
                                        } # Size Loop End
                                    } # Material Loop End
                                }else{
                                    return  back()->with('error',"Value Can't Be Blank at Row $row");
                                }   
                        }
                        // ` Color and Size
                        if (in_array('Size',$variationType_array) && in_array('Colour',$variationType_array)) {
                            if ($itrem2 != '' && $itrem1 != '') {
                                // - Varient Based on Material and Size
                                foreach (explode($Array_saprator,$item[array_search($color_attribut1,$main_Arr)]) as $key => $color) {   
                                    foreach (explode($Array_saprator,$item[array_search($size_attribut2,$main_Arr)]) as $key => $size) {
                                            $price = ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->price : trim($item[$CustomerPriceIndex]);
                                            $product_obj =  Product::create([
                                            'title' => ($product_exist != null && $item[$TitleIndex] == null) ? $product_exist->title : $item[$TitleIndex],
                                            'model_code' => ($product_exist != null && $item[$ModelCodeIndex] == null) ? $product_exist->model_code : $item[$ModelCodeIndex],
                                            'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                                            'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                                            'brand_id' => $request->brand_id ?? 0,
                                            'user_id' => $user->id,
                                            'sku' => $sku_code,
                                            'slug' => $unique_slug,
                                            'color' => ($product_exist != null && $item[$ColourIndex] == '') ? $product_exist->color : trim($color),
                                            'size' => ($product_exist != null && $size == '') ? $product_exist->size : $size,
                                            'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->description : $item[$DescriptionIndex],
                                            'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                                            'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                                            'manage_inventory' => $item[$SamepleAvailableIndex],
                                            'stock_qty' => 0,
                                            'status' => 0,
                                            'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                                            'price' => $price ?? 0,
                                            'min_sell_pr_without_gst' => ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->min_sell_pr_without_gst : $item[$CustomerPriceIndex], 
                                            'hsn' => ($product_exist != null && $item[$HSNTaxIndex] == '') ? $product_exist->hsn : $item[$HSNTaxIndex] ?? null,
                                            'hsn_percent' => ($product_exist != null && $item[$HSNPercentageIndex] == '') ? $product_exist->hsn_percent : $item[$HSNPercentageIndex] ?? null,
                                            'mrp' => ($product_exist != null && $item[$MRPIndex] == '') ? $product_exist->mrp : trim($item[$MRPIndex]),
                                            'video_url' => ($product_exist != null && $item[$VideoURLIndex] == '') ? $product_exist->video_url : $item[$VideoURLIndex],
                                            'search_keywords' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$Tag1Index],
                                            'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                            'material' => ($product_exist != null && $item[$MaterialIndex] == '') ? $product_exist->material : $item[$MaterialIndex] ?? '',
                                            'exclusive' => $item[$ExlusiveIndex] ?? 0,
                                            'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                                        ]);                    
                                        
                
                                        $product_extra_info_obj = ProductExtraInfo::create([
                                            'product_id' => $product_obj->id,
                                            'user_id' => $user->id,
                                            'user_shop_id' => $user_shop->id, 
                                            'allow_resellers' => $item[$AllowResellerIndex],
                                            'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                            'collection_name' => $item[$Collection_NameIndex],
                                            'season_month' => $item[$SeasonMonthIndex],
                                            'sample_available' => $item[$SamepleAvailableIndex],
                                            'sample_year' => $item[$SampleYearIndex],
                                            'sample_month' => $item[$SampleMonthIndex],
                                            'sampling_time' => $item[$SampleTimeIndex],
                                            'CBM' => $item[$CBMIndex],
                                            'production_time' => $item[$ProductionTimeIndex],
                                            'MBQ' => $item[$MBQIndex],
                                            'MBQ_unit' => $item[$MBQ_unitsIndex],
                                            'vendor_sourced_from' => $item[$vendor_sourced_fromIndex],
                                            'vendor_price' => $item[$vendor_priceIndex],
                                            'product_cost_unit' => $item[$product_cost_unitIndex],
                                            'vendor_currency' => $item[$vendor_currencyIndex],
                                            'sourcing_year' => $item[$sourcing_yearIndex],
                                        ]);
                
                                        // Create USI Rec
                                        $usi = UserShopItem::create([
                                            'user_id'=> $user->id,
                                            'category_id'=> $Category_id,
                                            'sub_category_id'=> $sub_category_id,
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
                                                'price'=> $item[$ResellerPriceIndex],
                                            ]);
                                        }
                                    
                                        if($vip_group){
                                            // create Vip Group record
                                            GroupProduct::create([
                                                'group_id'=>$vip_group->id,
                                                'product_id'=>$product_obj->id,
                                                'price'=>  $item[$VIPPriceIndex],
                                            ]);
                                        }
                
                                        $arr_images = [];
                                        // * Start Creating Media...
                                        if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                                            $media = new Media();
                                            $media->tag = "Product_Image";
                                            $media->file_type = "Image";
                                            $media->type = "Product";
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
                                            $media->file_name = $item[$ImagePosterIndex];
                                            $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                                            $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                            $media->save();
                                            $arr_images[] = $media->id;
                                        }
                
                
                                        if ($ProductextraImages != null) {
                                            foreach ($ProductextraImages as $key => $ExtImg) {
                                                $media = new Media();
                                                $media->tag = "Product_Image";
                                                $media->file_type = "Image";
                                                $media->type = "Product";
                                                $media->type_id = $product_obj->id;
                                                $media->file_name = $item[$ImagePosterIndex];
                                                $media->path = "storage/files/".auth()->id()."/".$ExtImg;
                                                $media->extension = explode('.',$ExtImg)[1] ?? '';
                                                $media->save();
                                                $arr_images[] = $media->id;
                                            }
                                        }
                
                                        // Add images to UserShopItem
                                        if(count($arr_images) > 0) {
                                            $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                            $usi->save();
                                        }
                                            
                                        if($product_obj){
                                            ++$count;
                                        }
                                    } # Size Loop End
                                } # Material Loop End
                            }else{
                                return  back()->with('error',"Value Not Match in Column Colour and Size at Row $row");
                            }
                        }
                
                        // ` Color and Material
                        if (in_array('Colour',$variationType_array) && in_array('Material',$variationType_array)) {
                            echo "Yes 3rd";
                            if ($itrem1 != '' && $itrem3 != '') {
                                // - Varient Based on Material and Size
                                foreach (explode($Array_saprator,$item[array_search($color_attribut1,$main_Arr)]) as $key => $color) {   
                                    foreach (explode($Array_saprator,$item[array_search($Material_attribut3,$main_Arr)]) as $key => $material) {
                                            $price = ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->price : trim($item[$CustomerPriceIndex]);
                                            $product_obj =  Product::create([
                                            'title' => ($product_exist != null && $item[$TitleIndex] == null) ? $product_exist->title : $item[$TitleIndex],
                                            'model_code' => ($product_exist != null && $item[$ModelCodeIndex] == null) ? $product_exist->model_code : $item[$ModelCodeIndex],
                                            'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                                            'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                                            'brand_id' => $request->brand_id ?? 0,
                                            'user_id' => $user->id,
                                            'sku' => $sku_code,
                                            'slug' => $unique_slug,
                                            'color' => ($product_exist != null && $item[$ColourIndex] == '') ? $product_exist->color : trim($color),
                                            'size' => ($product_exist != null && $size == '') ? $product_exist->size : trim($item[$SizeIndex]),
                                            'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->description : $item[$DescriptionIndex],
                                            'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                                            'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                                            'manage_inventory' => $item[$SamepleAvailableIndex],
                                            'stock_qty' => 0,
                                            'status' => 0,
                                            'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                                            'price' => $price ?? 0,
                                            'min_sell_pr_without_gst' => ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->min_sell_pr_without_gst : $item[$CustomerPriceIndex], 
                                            'hsn' => ($product_exist != null && $item[$HSNTaxIndex] == '') ? $product_exist->hsn : $item[$HSNTaxIndex] ?? null,
                                            'hsn_percent' => ($product_exist != null && $item[$HSNPercentageIndex] == '') ? $product_exist->hsn_percent : $item[$HSNPercentageIndex] ?? null,
                                            'mrp' => ($product_exist != null && $item[$MRPIndex] == '') ? $product_exist->mrp : trim($item[$MRPIndex]),
                                            'video_url' => ($product_exist != null && $item[$VideoURLIndex] == '') ? $product_exist->video_url : $item[$VideoURLIndex],
                                            'search_keywords' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$Tag1Index],
                                            'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                            'material' => ($product_exist != null && $material == '') ? $product_exist->material : $material ?? '',
                                            'exclusive' => $item[$ExlusiveIndex] ?? 0,
                                            'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                                        ]);                    
                                        
                
                                        $product_extra_info_obj = ProductExtraInfo::create([
                                            'product_id' => $product_obj->id,
                                            'user_id' => $user->id,
                                            'user_shop_id' => $user_shop->id, 
                                            'allow_resellers' => $item[$AllowResellerIndex],
                                            'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                            'collection_name' => $item[$Collection_NameIndex],
                                            'season_month' => $item[$SeasonMonthIndex],
                                            'sample_available' => $item[$SamepleAvailableIndex],
                                            'sample_year' => $item[$SampleYearIndex],
                                            'sample_month' => $item[$SampleMonthIndex],
                                            'sampling_time' => $item[$SampleTimeIndex],
                                            'CBM' => $item[$CBMIndex],
                                            'production_time' => $item[$ProductionTimeIndex],
                                            'MBQ' => $item[$MBQIndex],
                                            'MBQ_unit' => $item[$MBQ_unitsIndex],
                                            'vendor_sourced_from' => $item[$vendor_sourced_fromIndex],
                                            'vendor_price' => $item[$vendor_priceIndex],
                                            'product_cost_unit' => $item[$product_cost_unitIndex],
                                            'vendor_currency' => $item[$vendor_currencyIndex],
                                            'sourcing_year' => $item[$sourcing_yearIndex],
                                        ]);
                
                                        // Create USI Rec
                                        $usi = UserShopItem::create([
                                            'user_id'=> $user->id,
                                            'category_id'=> $Category_id,
                                            'sub_category_id'=> $sub_category_id,
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
                                                'price'=> $item[$ResellerPriceIndex],
                                            ]);
                                        }
                                    
                                        if($vip_group){
                                            // create Vip Group record
                                            GroupProduct::create([
                                                'group_id'=>$vip_group->id,
                                                'product_id'=>$product_obj->id,
                                                'price'=>  $item[$VIPPriceIndex],
                                            ]);
                                        }
                
                                        $arr_images = [];
                                        // * Start Creating Media...
                                        if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                                            $media = new Media();
                                            $media->tag = "Product_Image";
                                            $media->file_type = "Image";
                                            $media->type = "Product";
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
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
                                            $media->type_id = $product_obj->id;
                                            $media->file_name = $item[$ImagePosterIndex];
                                            $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                                            $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                            $media->save();
                                            $arr_images[] = $media->id;
                                        }
                
                
                                        if ($ProductextraImages != null) {
                                            foreach ($ProductextraImages as $key => $ExtImg) {
                                                $media = new Media();
                                                $media->tag = "Product_Image";
                                                $media->file_type = "Image";
                                                $media->type = "Product";
                                                $media->type_id = $product_obj->id;
                                                $media->file_name = $item[$ImagePosterIndex];
                                                $media->path = "storage/files/".auth()->id()."/".$ExtImg;
                                                $media->extension = explode('.',$ExtImg)[1] ?? '';
                                                $media->save();
                                                $arr_images[] = $media->id;
                                            }
                                        }
                
                                        // Add images to UserShopItem
                                        if(count($arr_images) > 0) {
                                            $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                            $usi->save();
                                        }
                                            
                                        if($product_obj){
                                            ++$count;
                                        }
                                    } # Size Loop End
                                } # Material Loop End
                            }else{
                                return  back()->with('error',"Value Not Match in Column Material and Colour at Row $row");
                            }
                        }
                }elseif ($variation_count == 1) {
                    echo "echo Variation Count is 1".newline();
                
                    if (in_array('Colour',$variationType_array)) {
                        // if ($item[$ColourIndex] == '') {
                        //     return back()->with('error',"Color column is Blank at Row $row.");
                        // }

                        
                        foreach ($colour_arr as $key => $color) {   
                                $price = ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->price : trim($item[$CustomerPriceIndex]);
                                $product_obj =  Product::create([
                                'title' => ($product_exist != null && $item[$TitleIndex] == null) ? $product_exist->title : $item[$TitleIndex],
                                'model_code' => ($product_exist != null && $item[$ModelCodeIndex] == null) ? $product_exist->model_code : $item[$ModelCodeIndex],
                                'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                                'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                                // 'brand_id' => ($product_exist != null && $item[$ModelCodeIndex] != null) ? $product_exist->brand_id : $request->brand_id ?? 0,
                                'user_id' => $user->id,
                                'sku' => $sku_code,
                                'slug' => $unique_slug,
                                'color' => ($product_exist != null && $color == '') ? $product_exist->color : trim($color),
                                'size' => ($product_exist != null && $item[$SizeIndex] == '') ? $product_exist->size : $item[$SizeIndex],
                                'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->description : $item[$DescriptionIndex],
                                'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                                'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                                'manage_inventory' => $item[$SamepleAvailableIndex],
                                'stock_qty' => 0,
                                'status' => 0,
                                'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                                'price' => $price ?? 0,
                                'min_sell_pr_without_gst' => ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->min_sell_pr_without_gst : $item[$CustomerPriceIndex], 
                                'hsn' => ($product_exist != null && $item[$HSNTaxIndex] == '') ? $product_exist->hsn : $item[$HSNTaxIndex] ?? null,
                                'hsn_percent' => ($product_exist != null && $item[$HSNPercentageIndex] == '') ? $product_exist->hsn_percent : $item[$HSNPercentageIndex] ?? null,
                                'mrp' => ($product_exist != null && $item[$MRPIndex] == '') ? $product_exist->mrp : trim($item[$MRPIndex]),
                                'video_url' => ($product_exist != null && $item[$VideoURLIndex] == '') ? $product_exist->video_url : $item[$VideoURLIndex],
                                'search_keywords' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$Tag1Index],
                                'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                'material' => ($product_exist != null && $item[$MaterialIndex] == '') ? $product_exist->material : $item[$MaterialIndex],
                                'exclusive' => $item[$ExlusiveIndex] ?? 0,
                                'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                            ]);                    
                            
                
                            $product_extra_info_obj = ProductExtraInfo::create([
                                'product_id' => $product_obj->id,
                                'user_id' => $user->id,
                                'user_shop_id' => $user_shop->id, 
                                'allow_resellers' => $item[$AllowResellerIndex],
                                'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                'collection_name' => $item[$Collection_NameIndex],
                                'season_month' => $item[$SeasonMonthIndex],
                                'sample_available' => $item[$SamepleAvailableIndex],
                                'sample_year' => $item[$SampleYearIndex],
                                'sample_month' => $item[$SampleMonthIndex],
                                'sampling_time' => $item[$SampleTimeIndex],
                                'CBM' => $item[$CBMIndex],
                                'production_time' => $item[$ProductionTimeIndex],
                                'MBQ' => $item[$MBQIndex],
                                'MBQ_unit' => $item[$MBQ_unitsIndex],
                                'vendor_sourced_from' => $item[$vendor_sourced_fromIndex],
                                'vendor_price' => $item[$vendor_priceIndex],
                                'product_cost_unit' => $item[$product_cost_unitIndex],
                                'vendor_currency' => $item[$vendor_currencyIndex],
                                'sourcing_year' => $item[$sourcing_yearIndex],
                            ]);
                
                            // Create USI Rec
                            $usi = UserShopItem::create([
                                'user_id'=> $user->id,
                                'category_id'=> $Category_id,
                                'sub_category_id'=> $sub_category_id,
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
                                    'price'=> $item[$ResellerPriceIndex],
                                ]);
                            }
                        
                            if($vip_group){
                                // create Vip Group record
                                GroupProduct::create([
                                    'group_id'=>$vip_group->id,
                                    'product_id'=>$product_obj->id,
                                    'price'=>  $item[$VIPPriceIndex],
                                ]);
                            }
                
                            $arr_images = [];
                            // * Start Creating Media...
                            if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                                $media = new Media();
                                $media->tag = "Product_Image";
                                $media->file_type = "Image";
                                $media->type = "Product";
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
                                $media->file_name = $item[$ImagePosterIndex];
                                $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                                $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                $media->save();
                                $arr_images[] = $media->id;
                            }
                
                
                            if ($ProductextraImages != null) {
                                foreach ($ProductextraImages as $key => $ExtImg) {
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $product_obj->id;
                                    $media->file_name = $item[$ImagePosterIndex];
                                    $media->path = "storage/files/".auth()->id()."/".$ExtImg;
                                    $media->extension = explode('.',$ExtImg)[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                            }
                
                            // Add images to UserShopItem
                            if(count($arr_images) > 0) {
                                $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                $usi->save();
                            }
                                
                            if($product_obj){
                                ++$count;
                            }
                        } # Color Loop
                    }elseif (in_array('Size',$variationType_array)) {
                        // if ($item[$SizeIndex] == '') {
                        //     return back()->with('error',"Size column is Blank at Row $row.");
                        // }
                        foreach ($size_arr as $key => $size) {   
                            $price = ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->price : trim($item[$CustomerPriceIndex]);
                
                            $product_obj =  Product::create([
                            'title' => ($product_exist != null && $item[$TitleIndex] == null) ? $product_exist->title : $item[$TitleIndex],
                            'model_code' => ($product_exist != null && $item[$ModelCodeIndex] == null) ? $product_exist->model_code : $item[$ModelCodeIndex],
                            'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                            'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                            // 'brand_id' => ($product_exist != null && $item[$ModelCodeIndex] != null) ? $product_exist->brand_id : $request->brand_id ?? 0,
                            'user_id' => $user->id,
                            'sku' => $sku_code,
                            'slug' => $unique_slug,
                            'color' => ($product_exist != null && $item[$ColourIndex] == '') ? $product_exist->color : trim($item[$ColourIndex]),
                            'size' => ($product_exist != null && $size == '') ? $product_exist->size : $size,
                            'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->description : $item[$DescriptionIndex],
                            'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                            'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                            'manage_inventory' => $item[$SamepleAvailableIndex],
                            'stock_qty' => 0,
                            'status' => 0,
                            'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                            'price' => $price ?? 0,
                            'min_sell_pr_without_gst' => ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->min_sell_pr_without_gst : $item[$CustomerPriceIndex], 
                            'hsn' => ($product_exist != null && $item[$HSNTaxIndex] == '') ? $product_exist->hsn : $item[$HSNTaxIndex] ?? null,
                            'hsn_percent' => ($product_exist != null && $item[$HSNPercentageIndex] == '') ? $product_exist->hsn_percent : $item[$HSNPercentageIndex] ?? null,
                            'mrp' => ($product_exist != null && $item[$MRPIndex] == '') ? $product_exist->mrp : trim($item[$MRPIndex]),
                            'video_url' => ($product_exist != null && $item[$VideoURLIndex] == '') ? $product_exist->video_url : $item[$VideoURLIndex],
                            'search_keywords' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$Tag1Index],
                            'artwork_url' => $item[$artwork_urlIndex] ?? null,
                            'material' => ($product_exist != null && $item[$MaterialIndex] == '') ? $product_exist->material : $item[$MaterialIndex],
                            'exclusive' => $item[$ExlusiveIndex] ?? 0,
                            'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                            ]);                    
                        
                
                            $product_extra_info_obj = ProductExtraInfo::create([
                                'product_id' => $product_obj->id,
                                'user_id' => $user->id,
                                'user_shop_id' => $user_shop->id, 
                                'allow_resellers' => $item[$AllowResellerIndex],
                                'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                'collection_name' => $item[$Collection_NameIndex],
                                'season_month' => $item[$SeasonMonthIndex],
                                'sample_available' => $item[$SamepleAvailableIndex],
                                'sample_year' => $item[$SampleYearIndex],
                                'sample_month' => $item[$SampleMonthIndex],
                                'sampling_time' => $item[$SampleTimeIndex],
                                'CBM' => $item[$CBMIndex],
                                'production_time' => $item[$ProductionTimeIndex],
                                'MBQ' => $item[$MBQIndex],
                                'MBQ_unit' => $item[$MBQ_unitsIndex],
                                'vendor_sourced_from' => $item[$vendor_sourced_fromIndex],
                                'vendor_price' => $item[$vendor_priceIndex],
                                'product_cost_unit' => $item[$product_cost_unitIndex],
                                'vendor_currency' => $item[$vendor_currencyIndex],
                                'sourcing_year' => $item[$sourcing_yearIndex],
                            ]);
                
                            // Create USI Rec
                            $usi = UserShopItem::create([
                                'user_id'=> $user->id,
                                'category_id'=> $Category_id,
                                'sub_category_id'=> $sub_category_id,
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
                                    'price'=> $item[$ResellerPriceIndex],
                                ]);
                            }
                        
                            if($vip_group){
                                // create Vip Group record
                                GroupProduct::create([
                                    'group_id'=>$vip_group->id,
                                    'product_id'=>$product_obj->id,
                                    'price'=>  $item[$VIPPriceIndex],
                                ]);
                            }
                
                            $arr_images = [];
                            // * Start Creating Media...
                            if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                                $media = new Media();
                                $media->tag = "Product_Image";
                                $media->file_type = "Image";
                                $media->type = "Product";
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
                                $media->file_name = $item[$ImagePosterIndex];
                                $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                                $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                $media->save();
                                $arr_images[] = $media->id;
                            }
                
                
                            if ($ProductextraImages != null) {
                                foreach ($ProductextraImages as $key => $ExtImg) {
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $product_obj->id;
                                    $media->file_name = $item[$ImagePosterIndex];
                                    $media->path = "storage/files/".auth()->id()."/".$ExtImg;
                                    $media->extension = explode('.',$ExtImg)[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                            }
                
                            // Add images to UserShopItem
                            if(count($arr_images) > 0) {
                                $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                $usi->save();
                            }
                                
                            if($product_obj){
                                ++$count;
                            }
                        } # Size Loop
                    }elseif (in_array('Material',$variationType_array)) {
                        // if ($item[$MaterialIndex] == '') {
                        //     return back()->with('error',"Material column is Blank at Row $row.");
                        // }
                        foreach ($material_arr as $key => $material) {   
                            $price = ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->price : trim($item[$CustomerPriceIndex]);
                
                            $product_obj =  Product::create([
                            'title' => ($product_exist != null && $item[$TitleIndex] == null) ? $product_exist->title : $item[$TitleIndex],
                            'model_code' => ($product_exist != null && $item[$ModelCodeIndex] == null) ? $product_exist->model_code : $item[$ModelCodeIndex],
                            'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                            'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                            // 'brand_id' => ($product_exist != null && $item[$ModelCodeIndex] != null) ? $product_exist->brand_id : $request->brand_id ?? 0,
                            'user_id' => $user->id,
                            'sku' => $sku_code,
                            'slug' => $unique_slug,
                            'color' => ($product_exist != null && $item[$ColourIndex] == '') ? $product_exist->color : trim($item[$ColourIndex]),
                            'size' => ($product_exist != null && $item[$SizeIndex] == '') ? $product_exist->size : $item[$SizeIndex],
                            'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->description : $item[$DescriptionIndex],
                            'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                            'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                            'manage_inventory' => $item[$SamepleAvailableIndex],
                            'stock_qty' => 0,
                            'status' => 0,
                            'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                            'price' => $price ?? 0,
                            'min_sell_pr_without_gst' => ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->min_sell_pr_without_gst : $item[$CustomerPriceIndex], 
                            'hsn' => ($product_exist != null && $item[$HSNTaxIndex] == '') ? $product_exist->hsn : $item[$HSNTaxIndex] ?? null,
                            'hsn_percent' => ($product_exist != null && $item[$HSNPercentageIndex] == '') ? $product_exist->hsn_percent : $item[$HSNPercentageIndex] ?? null,
                            'mrp' => ($product_exist != null && $item[$MRPIndex] == '') ? $product_exist->mrp : trim($item[$MRPIndex]),
                            'video_url' => ($product_exist != null && $item[$VideoURLIndex] == '') ? $product_exist->video_url : $item[$VideoURLIndex],
                            'search_keywords' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$Tag1Index],
                            'artwork_url' => $item[$artwork_urlIndex] ?? null,
                            'material' => ($product_exist != null && $material == '') ? $product_exist->material : $material,
                            'exclusive' => $item[$ExlusiveIndex] ?? 0,
                            'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                            ]);                    
                        
                
                            $product_extra_info_obj = ProductExtraInfo::create([
                                'product_id' => $product_obj->id,
                                'user_id' => $user->id,
                                'user_shop_id' => $user_shop->id, 
                                'allow_resellers' => $item[$AllowResellerIndex],
                                'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                'collection_name' => $item[$Collection_NameIndex],
                                'season_month' => $item[$SeasonMonthIndex],
                                'sample_available' => $item[$SamepleAvailableIndex],
                                'sample_year' => $item[$SampleYearIndex],
                                'sample_month' => $item[$SampleMonthIndex],
                                'sampling_time' => $item[$SampleTimeIndex],
                                'CBM' => $item[$CBMIndex],
                                'production_time' => $item[$ProductionTimeIndex],
                                'MBQ' => $item[$MBQIndex],
                                'MBQ_unit' => $item[$MBQ_unitsIndex],
                                'vendor_sourced_from' => $item[$vendor_sourced_fromIndex],
                                'vendor_price' => $item[$vendor_priceIndex],
                                'product_cost_unit' => $item[$product_cost_unitIndex],
                                'vendor_currency' => $item[$vendor_currencyIndex],
                                'sourcing_year' => $item[$sourcing_yearIndex],                                
                            ]);
                
                            // Create USI Rec
                            $usi = UserShopItem::create([
                                'user_id'=> $user->id,
                                'category_id'=> $Category_id,
                                'sub_category_id'=> $sub_category_id,
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
                                    'price'=> $item[$ResellerPriceIndex],
                                ]);
                            }
                        
                            if($vip_group){
                                // create Vip Group record
                                GroupProduct::create([
                                    'group_id'=>$vip_group->id,
                                    'product_id'=>$product_obj->id,
                                    'price'=>  $item[$VIPPriceIndex],
                                ]);
                            }
                
                            $arr_images = [];
                            // * Start Creating Media...
                            if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                                $media = new Media();
                                $media->tag = "Product_Image";
                                $media->file_type = "Image";
                                $media->type = "Product";
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
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
                                $media->type_id = $product_obj->id;
                                $media->file_name = $item[$ImagePosterIndex];
                                $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                                $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                                $media->save();
                                $arr_images[] = $media->id;
                            }
                
                
                            if ($ProductextraImages != null) {
                                foreach ($ProductextraImages as $key => $ExtImg) {
                                    $media = new Media();
                                    $media->tag = "Product_Image";
                                    $media->file_type = "Image";
                                    $media->type = "Product";
                                    $media->type_id = $product_obj->id;
                                    $media->file_name = $item[$ImagePosterIndex];
                                    $media->path = "storage/files/".auth()->id()."/".$ExtImg;
                                    $media->extension = explode('.',$ExtImg)[1] ?? '';
                                    $media->save();
                                    $arr_images[] = $media->id;
                                }
                            }
                
                            // Add images to UserShopItem
                            if(count($arr_images) > 0) {
                                $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                $usi->save();
                            }
                                
                            if($product_obj){
                                ++$count;
                            }
                        } # Material Loop
                    }
                
                
                }
            } // - Variation Array Not Null...
            else{
                // - Varient Based on Color and Size
                echo "Receive No Argument";
                $price = ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->price : trim($item[$CustomerPriceIndex]);
                $product_obj =  Product::create([
                    'title' => ($product_exist != null && $item[$TitleIndex] == null) ? $product_exist->title : $item[$TitleIndex],
                    'model_code' => ($product_exist != null && $item[$ModelCodeIndex] == null) ? $product_exist->model_code : $item[$ModelCodeIndex],
                    'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                    'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                    'brand_id' => ($product_exist != null) ? $product_exist->brand_id : $request->brand_id ?? 0,
                    'user_id' => $user->id,
                    'sku' => $sku_code,
                    'slug' => $unique_slug,
                    'color' => ($product_exist != null && $item[$ColourIndex] == '') ? $product_exist->color : trim($item[$ColourIndex]),
                    'size' => ($product_exist != null && $item[$SizeIndex] == '') ? $product_exist->size : $item[$SizeIndex],
                    'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->size : $item[$DescriptionIndex],
                    'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                    'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                    'manage_inventory' => $item[$SamepleAvailableIndex],
                    'stock_qty' => 0,
                    'status' => 0,
                    'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                    'price' => $price ?? 0,
                    'min_sell_pr_without_gst' => ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->min_sell_pr_without_gst : $item[$CustomerPriceIndex], 
                    'hsn' => ($product_exist != null && $item[$HSNTaxIndex] == '') ? $product_exist->hsn : $item[$HSNTaxIndex] ?? null,
                    'hsn_percent' => ($product_exist != null && $item[$HSNPercentageIndex] == '') ? $product_exist->hsn_percent : $item[$HSNPercentageIndex] ?? null,
                    'mrp' => ($product_exist != null && $item[$MRPIndex] == '') ? $product_exist->mrp : trim($item[$MRPIndex]),
                    'video_url' => ($product_exist != null && $item[$VideoURLIndex] == '') ? $product_exist->video_url : $item[$VideoURLIndex],
                    'search_keywords' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$Tag1Index],
                    'artwork_url' => $item[$artwork_urlIndex] ?? null,
                    'material' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$MaterialIndex],
                    'exclusive' => $item[$ExlusiveIndex] ?? 0,
                    'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                ]);                    
                
            
                $product_extra_info_obj = ProductExtraInfo::create([
                    'product_id' => $product_obj->id,
                    'user_id' => $user->id,
                    'user_shop_id' => $user_shop->id, 
                    'allow_resellers' => $item[$AllowResellerIndex],
                    'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                    'collection_name' => $item[$Collection_NameIndex],
                    'season_month' => $item[$SeasonMonthIndex],
                    'sample_available' => $item[$SamepleAvailableIndex],
                    'sample_year' => $item[$SampleYearIndex],
                    'sample_month' => $item[$SampleMonthIndex],
                    'sampling_time' => $item[$SampleTimeIndex],
                    'CBM' => $item[$CBMIndex],
                    'production_time' => $item[$ProductionTimeIndex],
                    'MBQ' => $item[$MBQIndex],
                    'MBQ_unit' => $item[$MBQ_unitsIndex],
                    'vendor_sourced_from' => $item[$vendor_sourced_fromIndex],
                    'vendor_price' => $item[$vendor_priceIndex],
                    'product_cost_unit' => $item[$product_cost_unitIndex],
                    'vendor_currency' => $item[$vendor_currencyIndex],
                    'sourcing_year' => $item[$sourcing_yearIndex],
                ]);
            
                // Create USI Rec
                $usi = UserShopItem::create([
                    'user_id'=> $user->id,
                    'category_id'=> $Category_id,
                    'sub_category_id'=> $sub_category_id,
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
                        'price'=> $item[$ResellerPriceIndex],
                    ]);
                }
            
                if($vip_group){
                    // create Vip Group record
                    GroupProduct::create([
                        'group_id'=>$vip_group->id,
                        'product_id'=>$product_obj->id,
                        'price'=>  $item[$VIPPriceIndex],
                    ]);
                }
            
                $arr_images = [];
                // * Start Creating Media...
                if(isset($item[$ImageMainIndex]) && $item[$ImageMainIndex] != null){
                    $media = new Media();
                    $media->tag = "Product_Image";
                    $media->file_type = "Image";
                    $media->type = "Product";
                    $media->type_id = $product_obj->id;
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
                    $media->type_id = $product_obj->id;
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
                    $media->type_id = $product_obj->id;
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
                    $media->type_id = $product_obj->id;
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
                    $media->type_id = $product_obj->id;
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
                    $media->type_id = $product_obj->id;
                    $media->file_name = $item[$ImagePosterIndex];
                    $media->path = "storage/files/".auth()->id()."/".$item[$ImagePosterIndex];
                    $media->extension = explode('.',$item[$ImagePosterIndex])[1] ?? '';
                    $media->save();
                    $arr_images[] = $media->id;
                }
            
            
                if ($ProductextraImages != null) {
                    foreach ($ProductextraImages as $key => $ExtImg) {
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $item[$ImagePosterIndex];
                        $media->path = "storage/files/".auth()->id()."/".$ExtImg;
                        $media->extension = explode('.',$ExtImg)[1] ?? '';
                        $media->save();
                        $arr_images[] = $media->id;
                    }
                }
            
                // Add images to UserShopItem
                if(count($arr_images) > 0) {
                    $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                    $usi->save();
                }
                    
                if($product_obj){
                    ++$count;
                }
            }
        } // - Main Loop
        
        return back()->with('success',"$count Items are Added Successfully !!");

        // Todo: Add Record
        // Adding List in User Record
        // $newarr = [];
        // foreach ($rows[0] as $key => $value) {
        //     $newarr[$value] = $key;
        // }
        // $user->bulk_upload_Sheet = $newarr;
        // $user->save();
    }
}