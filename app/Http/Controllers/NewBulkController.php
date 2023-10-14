<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Country;
use App\Models\Group;
use App\Models\GroupProduct;
use App\Models\Inventory;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductExtraInfo;
use App\Models\Setting;
use App\Models\UserShop;
use App\Models\UserShopItem;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use PhpParser\Node\Stmt\Return_;
use Psy\TabCompletion\Matcher\ObjectMethodDefaultParametersMatcher;
use stdClass;

use function GuzzleHttp\Promise\all;
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
        $common_field = ['Colour','Size','Mateial'];
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

        
        // * Start: Marging Both Array Custom And Default Attributes
        $delfault_cols = json_decode(Setting::where('key','bulk_sheet_upload')->first()->value);
        $user_custom_col_list = json_decode($user->custom_attriute_columns) ?? [];
        $num = end($delfault_cols) +1;
        $new_custom_attribute = [];
        foreach ($user_custom_col_list as $key => $value) {
            $new_custom_attribute += [$value => $num];
            $num++;
        }
        
        // ` Col LIst in Form of Object
        $col_list = (object) array_merge((array)$delfault_cols,$new_custom_attribute);
        // * End: Marging Both Array Custom And Default Attributes
        
        // ` Col LIst in Form of Array
        $main_Arr = array_keys((array) $col_list);
        
        // magicstring($col_list);
        // $variantion_col_temp = $col_list->{'One Piece Charecter'};
        // echo $variantion_col_temp;
        // return;
        // ` Start Indexing fo Column
        $ModelCodeIndex = $col_list->{'Model_Code'};
        $CategoryIndex = $col_list->{'Category'};
        $SubCategoryIndex = $col_list->{'Sub_Category'};
        $CurrencyIndex = $col_list->{'Base_currency'};
        $AllowResellerIndex = $col_list->{'Allow_Resellers'};
        // $PublishIndex = $col_list->{'Live / Active'};
        $ExlusiveIndex = $col_list->{'Copyright/ Exclusive item'};
        // $ArchiveIndex = $col_list->{'archive'};
        $MaterialIndex = $col_list->{'Material'};
        $ColourIndex = $col_list->{'Colour'};
        $SizeIndex = $col_list->{'Size'};
        // $SamepleAvailableIndex = $col_list->{'Sample / Stock available'};
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
        
        $CartonLengthIndex =$col_list->{'Carton length'};
        $CartonWidthIndex =$col_list->{'Carton width'};
        $CartonHeightIndex =$col_list->{'Carton height'};
        $CartonDimensionsUnitIndex  = $col_list->{'Carton_Dimensions_unit'};

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
        $ProductGroupIdIndex = $col_list->{'Group ID'};
        $RemarkIndex = $col_list->{'Remarks'};
        $BrandNameIndex = $col_list->{'Brand Name'};
        $SellingPriceUnitIndex = $col_list->{'Selling Price_Unit'};
        // ` Image Indexig
        $ImageMainIndex = $col_list->{'Image_main'};
        $ImageFrontIndex = $col_list->{'image_name_front'};
        $ImageBackIndex = $col_list->{'image_name_back'};
        $ImageSide1Index = $col_list->{'image_name_side1'};
        $ImageSide2Index = $col_list->{'image_name_side2'};
        $ImagePosterIndex = $col_list->{'image_name_poster'};
        $ExtraImageIndex = $col_list->{'Additional Image Use ^^'};
        // ` End of Indexing Column

        // ! Validating Loop Start
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
                // // ` Checking Allow Live and Publish
                // if (!in_array($temp_item[$PublishIndex],$check_permision_array)) {
                //     return back()->with('error',"you Didn't Select Live / Active at Row $row");
                // }
                // ` Checking Exclusive Product
                if (!in_array($temp_item[$ExlusiveIndex],$check_permision_array)) {
                    return back()->with('error',"you Didn't Fill Exclusive Product Option at Row $row");
                }
                // // ` Checking Exclusive Product
                // if (!in_array($temp_item[$ArchiveIndex],$check_permision_array)) {
                //     return back()->with('error',"Invaild Entry In Archive Product Option at Row $row");
                // }
                // ` Checking Sample Stock Available
                // if (!in_array($temp_item[$SamepleAvailableIndex],$check_permision_array)) {
                //     return back()->with('error',"you Didn't Fill Sample Availabel Option at Row $row");
                // }

                // - Conditions that are Complusaory to Match...
                // ` Checking Material Value
                if ($temp_item[$MaterialIndex] != null) {
                    // $Material_values = ProductAttribute::where('name','Material')->where('user_id',null)->first()->value;
                    // $chk = explode(",",json_decode($Material_values)[0]);
                    $tmp_chk = ProductAttributeValue::where('parent_id',3)->pluck('attribute_value')->toArray();
                    $chkm[] = '';
                    foreach ($tmp_chk as $key => $value) {
                        // echo $value.newline();
                        $value = strtolower($value);
                        $chkm[] = ucwords($value);
                        
                    }

                    $material_arr = explode($Array_saprator,$temp_item[$MaterialIndex]);
                    foreach ($material_arr as $key => $Material) {
                        $Material = strtolower($Material);
                        if (!in_array(ucwords($Material),$chkm)) {
                            return back()->with('error',"Material: $Material is Not in Array at Row $row");
                        }
                    }
                }else{
                    $material_arr = null;
                }
                // ` Checking Colour Value
                if ($temp_item[$ColourIndex] != null) {
                    // $Material_values = ProductAttribute::where('name','Color')->where('user_id',null)->first()->value;
                
                    $tmp_chk = ProductAttributeValue::where('parent_id',1)->pluck('attribute_value')->toArray();
                    $chkm[] = '';
                    foreach ($tmp_chk as $key => $value) {
                        // echo $value.newline();
                        $value = strtolower($value);
                        $chkm[] = ucwords($value);
                        
                    }
                    $colour_arr = explode($Array_saprator,$temp_item[$ColourIndex]);
                    foreach ($colour_arr as $key => $colour) {
                        $colour = strtolower($colour);

                        if (!in_array(ucwords($colour),$chkm)) {
                            return back()->with('error',"Colour: $colour is Not in Array at Row $row");
                        }
                    }
                }else{
                    // return back()->with("error","Colour is not Filled at Row $row");
                    $colour_arr = null;
                }
                // ` Checking Size Value
                if ($temp_item[$SizeIndex] != null) {
                    $Material_values = ProductAttribute::where('name','Size')->where('user_id',null)->first()->value;
                    // $chk = explode(",",json_decode($Material_values)[0]);
                    $tmp_chk = ProductAttributeValue::where('parent_id',2)->pluck('attribute_value')->toArray();
                    $chkm[] = '';
                    foreach ($tmp_chk as $key => $value) {
                        // echo $value.newline();
                        $value = strtolower($value);
                        $chkm[] = ucwords($value);
                        
                    }
                    $size_arr = explode($Array_saprator,$temp_item[$SizeIndex]);
                    foreach ($size_arr as $key => $sizes) {
                        $sizes = strtolower($sizes);
                        if (!in_array(ucwords($sizes),$chkm)) {
                            return back()->with('error',"Size: $sizes is Not in Array at Row $row");
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
                        // echo "Between Theme Collection Range..".newline(5);
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
                            return back()->with('error',"Variation $variation Attributes Not Matched at Row $row.");
                        }
                        // checking Finsh Value
                        $variantion_col_temp = $col_list->{$variation};                        
                        $attribute_data1 = ProductAttribute::where('name',$variation)->where('user_id',null)->first();
                        $attribute_data2 = ProductAttribute::where('name',$variation)->where('user_id',$user->id)->first();

                        if ($attribute_data1 != null) {
                            $attribute_data = $attribute_data1;
                        }else{
                            $attribute_data = $attribute_data2;
                            
                        }

                        $attribute_value_obj = ProductAttributeValue::where('parent_id',$attribute_data->id)->pluck('attribute_value');
                        $attribute_value = [];
                        foreach ($attribute_value_obj as $key => $value) {
                            $value = strtolower($value);
                            array_push($attribute_value, ucwords($value));
                        }

                        $receive_data = explode($Array_saprator,$temp_item[$variantion_col_temp]);
                        
                        foreach ($receive_data as $key => $value) {
                            if ($value != '') {
                            $value = strtolower($value);
                                if (!in_array(ucwords($value),$attribute_value)) {
                                    return back()->with('error',"$value Variation Value in Column $variation Mismatch at Row $row.");
                                }
                            }
                        }
                    }
                    $variation_count = ($variationType_array != null) ? count($variationType_array) : 0;


                    if ($variation_count > 3) {
                        return back()->with('error',"You Have More Than 3 Varient At Row $row. You Only Have 3 at a Row");
                    }



                }

                // Checking Custom Variation Values
                if (count($user_custom_col_list) != 0) {
                    foreach ($user_custom_col_list as $key => $attri) {
                        $variantion_col_temp = $col_list->{$attri};


                        $attribute_data_default = ProductAttribute::where('name',$attri)->where('user_id',null)->first();
                        $attribute_data_custom = ProductAttribute::where('name',$attri)->where('user_id',$user->id)->first();
                        
                        if ($attribute_data_default != null) {
                            $attribute_data = $attribute_data_default;
                        }else{
                            $attribute_data = $attribute_data_custom;
                        }
                        
                        
                        // $attribute_data = ProductAttribute::where('name',$attri)->first();
                        $attribute_value_obj = ProductAttributeValue::where('parent_id',$attribute_data->id)->pluck('attribute_value');
                        $attribute_value = [];
                        foreach ($attribute_value_obj as $key => $value) {
                            $value = strtolower($value);
                            $value = ucwords($value);
                            array_push($attribute_value,trim($value));
                        }


                        $check_arr = explode($Array_saprator,$temp_item[$variantion_col_temp]);

                        foreach ($check_arr as $key => $value) {
                            if ($value != '') {
                                $value = strtolower($value);
                                $value = ucwords($value);
                                if (!in_array($value,$attribute_value)) {
                                    return back()->with("error","$value Attribute Value in Column $attri Mismatch at Row $row.");
                                    // echo "$value Attribute Value in Column $attri Mismatch at Row $row.".newline();
                                }
                            }
                        }
                    }        
                }
                
        } // - Validation Loop End
    
        
        $modalArray = [];
        $SKUArray = [];
        $debuging_mode = 0;



        // ! Main For Uploading Data
        
        foreach ($master as $index => $item) {
            $variationType_array =[];
            $row = $index + 4;
            debugtext($debuging_mode,"Working in Debug Mode","red");
            

            $myTmp_array = [];    
            $Productids_array = [];

            // ` Cheking Variation Value
            if ($item[$VariationAttributesIndex] != null) {
                $variationType_array = explode($Array_saprator,$item[$VariationAttributesIndex]);
                foreach ($variationType_array as $key => $variation) {  
                    if (!in_array($variation,$main_Arr)) {
                        return back()->with('error',"Variation $variation Attributes Not Matched at Row $row.");
                    }
                    // checking Finsh Value
                    $variantion_col_temp = $col_list->{$variation};                        
                    // $attribute_data = ProductAttribute::where('name',$variation)->first();
                    $attribute_data1 = ProductAttribute::where('name',$variation)->where('user_id',null)->first();
                    $attribute_data2 = ProductAttribute::where('name',$variation)->where('user_id',$user->id)->first();

                    if ($attribute_data1 != null) {
                        $attribute_data = $attribute_data1;
                    }else{
                        $attribute_data = $attribute_data2;
                    }
                    
                    $attribute_value_obj = ProductAttributeValue::where('parent_id',$attribute_data->id)->pluck('attribute_value');
                    $attribute_value = [];

                    foreach ($attribute_value_obj as $key => $value) {
                        $value = strtolower($value);
                        $value = ucwords($value);
                        array_push($attribute_value,$value);
                    }
                    
                    $receive_data = explode($Array_saprator,$item[$variantion_col_temp]);

                    foreach ($receive_data as $key => $value) {
                        if ($value != '') {
                            $value = strtolower($value);
                            $value = ucwords($value);
                            if (!in_array($value,$attribute_value)) {
                                return back()->with('error',"$value Variation Value in Column $variation Mismatch at Row $row.");
                            }
                        }
                    }

                }
                $variation_count = ($variationType_array != null) ? count($variationType_array) : 0;
            }

            if ($item[$VariationAttributesIndex] != null) {
                foreach ($variationType_array as $variation) {
                    $tmp_colindex = $col_list->{$variation};
                    debugtext($debuging_mode,"The Column index of $variation is $tmp_colindex","green");
    
                    debugtext($debuging_mode,"$variation variation Column Values","green");
                    // magicstring(explode($Array_saprator,$item[$tmp_colindex]));
    
                    // ! Making Multidiamentional Array
                    array_push($myTmp_array,explode($Array_saprator,$item[$tmp_colindex]));
                    
                    // - Removing Used Variation From Array
                    foreach ($variationType_array as $key => $val) {
                        if (in_array($val,$user_custom_col_list)) {
                            $user_custom_col_list = array_diff($user_custom_col_list,[$val]);
                        }
                    }
                }
                if (isset($variationType_array[0])) {
                    $loop1 = explode($Array_saprator,$item[$col_list->{$variationType_array[0]}]) ?? [];
                }else{
                    $loop1 = [];
                }
                
                if (isset($variationType_array[1])) {
                    $loop2 = explode($Array_saprator,$item[$col_list->{$variationType_array[1]}]) ?? [];
                }else{
                    $loop2 = [];
                }
                
                if (isset($variationType_array[2])) {
                    $loop3 = explode($Array_saprator,$item[$col_list->{$variationType_array[2]}]) ?? [];
                }else{
                    $loop3 = [];
                }
            }else{
                $loop1 = [];
                $loop2 = [];
                $loop3 = [];
                $variationType_array = [];
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
            // ` Checking Currency
            if ($item[$CurrencyIndex] == null) {
                $Currency = 'INR';
            }else{
                $chk = Country::where('currency',$item[$CurrencyIndex])->get();
                if (count($chk) > 0) {
                    // echo "We Have ... $item[$CurrencyIndex] <br>";
                    $Currency = $item[$CurrencyIndex];
                }else{
                    return back()->with('error',"That Currency is not Available at Row $row");
                }
            }


            $Productids_array = [];
            $CREATED_PRODUUCT_ID = [];
            $CREATED_PRODUUCT_ID_2 = [];


            if($loop1 != [] && $loop2 != [] && $loop3 != []) {
                $Productids_array = [];
                foreach ($loop1 as $key1 => $first) {
                    foreach ($loop2 as $key2 => $second) {

                        foreach ($loop3 as $key3 => $third) {
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
                                'carton_length' => $item[$CartonLengthIndex],
                                'carton_width' => $item[$CartonWidthIndex],
                                'carton_height' => $item[$CartonHeightIndex],
                                'Carton_Dimensions_unit' => $item[$CartonDimensionsUnitIndex],
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
    
                            debugtext($debuging_mode,"Start Uploading Data","Red");
                            debugtext($debuging_mode,"1. Making Product.","Red");
    
    
                            echo $first." - ".$second." - ".$third.newline();
    
    
                            $price = ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->price : trim($item[$CustomerPriceIndex]);
                            $product_obj =  [
                                'title' => ($product_exist != null && $item[$TitleIndex] == null) ? $product_exist->title : $item[$TitleIndex],
                                'model_code' => ($product_exist != null && $item[$ModelCodeIndex] == null) ? $product_exist->model_code : $item[$ModelCodeIndex],
                                'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                                'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                                'brand_id' => ($product_exist != null) ? $product_exist->brand_id : 0,
                                'user_id' => $user->id,
                                'sku' => $sku_code,
                                'slug' => $unique_slug,
                                'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->description : $item[$DescriptionIndex],
                                'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                                'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                                'manage_inventory' =>  0,
                                'stock_qty' => 0,
                                'status' => 0,
                                // 'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                                'is_publish' => 1,
                                'price' => $price ?? 0,
                                'min_sell_pr_without_gst' => ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->min_sell_pr_without_gst : $item[$CustomerPriceIndex], 
                                'hsn' => ($product_exist != null && $item[$HSNTaxIndex] == '') ? $product_exist->hsn : $item[$HSNTaxIndex] ?? null,
                                'hsn_percent' => ($product_exist != null && $item[$HSNPercentageIndex] == '') ? $product_exist->hsn_percent : $item[$HSNPercentageIndex] ?? null,
                                'mrp' => ($product_exist != null && $item[$MRPIndex] == '') ? $product_exist->mrp : trim($item[$MRPIndex]),
                                'video_url' => ($product_exist != null && $item[$VideoURLIndex] == '') ? $product_exist->video_url : $item[$VideoURLIndex],
                                'search_keywords' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$Tag1Index],
                                'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                'exclusive' => (in_array($item[$ExlusiveIndex],$allowed_array)) ? 1 : 0,
                                'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                                'SellingPriceUnitIndex' => $item[$SellingPriceUnitIndex] ?? '',
                                // 'archive' => (in_array($item[$ArchiveIndex],$allowed_array)) ? 1 : 0,
                            ];
                                
                            $product_obj = Product::create($product_obj);
    
                            // debugtext($debuging_mode,"Printing Product Object","Red");
                            // magicstring($product_obj);
    
                            array_push($Productids_array,$product_obj->id); 
    
                            debugtext($debuging_mode,"Printing Product Ids","Red");
                            // magicstring($Productids_array);

                            $attribute = ProductAttribute::where('user_id',$user->id)->orwhere('user_id',null)->pluck('id');
                            $third = strtolower($third);
                            $third = ucwords($third);
                            $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$third)->first();
                            $vname = $product_att_val->attribute_value;
                        
                            debugtext($debuging_mode,"making Variation for $vname","Red");
    
                            if ($product_att_val != null) {
                                $product_extra_info_obj_user = [
                                    'product_id' => $product_obj->id,
                                    'user_id' => $user->id,
                                    'user_shop_id' => $user_shop->id, 
                                    'allow_resellers' => $item[$AllowResellerIndex],
                                    'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                    'collection_name' => $item[$Collection_NameIndex],
                                    'season_month' => $item[$SeasonMonthIndex],
                                    'season_year' => $item[$CollectionYearIndex],
                                    'season_year' => $item[$CollectionYearIndex],
                                    'sample_available' => 0,
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
                                    'sourcing_month' => $item[$SourcingMonthIndex],
                                    'attribute_value_id' => $product_att_val->id,
                                    'attribute_id' => $product_att_val->parent_id,
                                    // 'attribute_value_id' => $product_att_val->attribute_value,
                                    // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                    'group_id' => $sku_code,
                                    'Cust_tag_group' =>$item[$ProductGroupIdIndex],
                                    'remarks' => $item[$RemarkIndex] ?? '' ,
                                    'brand_name' => $item[$BrandNameIndex],
                                ];
        
                                ProductExtraInfo::create($product_extra_info_obj_user);
                            }
    
                            debugtext($debuging_mode,"Printing Product Variation Object of User Defined Variaition for $product_att_val->attribute_value","Red");
                            // magicstring($product_extra_info_obj_user);
    
                            debugtext($debuging_mode,"Not User Define Variations","Red");
                            // magicstring($user_custom_col_list);
                            
    
                            // - Making Varitions That are not Defined in Variation Type..
                            if (count($user_custom_col_list) != 0) {
                                foreach ($user_custom_col_list as $key => $attri) {
                                    $tmp_col = $col_list->{$attri};
                                    $col_value = $item[$tmp_col];

                                    $attribute_default = ProductAttribute::where('name',$attri)->where('user_id',null)->pluck('id');
                                    $attribute_custom = ProductAttribute::where('name',$attri)->where('user_id',$user->id)->pluck('id');

                                    if (count($attribute_default) == 0 ) {
                                        $attribute = $attribute_custom;
                                    }else{
                                        $attribute = $attribute_default;
                                    }

                                    
                                    $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$col_value)->first();


                                    // if ($product_att_val == null) {
                                    //     return back()->with('error',"$col_value is not in $col_value Exist at Row $row, remove Previous Data for prevent Deblicate.");
                                    // }

                                        
                                    if ($product_att_val != null) {
                                        $product_extra_info_obj = [
                                            'product_id' => $product_obj->id,
                                            'user_id' => $user->id,
                                            'user_shop_id' => $user_shop->id, 
                                            'allow_resellers' => $item[$AllowResellerIndex],
                                            'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                            'collection_name' => $item[$Collection_NameIndex],
                                            'season_month' => $item[$SeasonMonthIndex],
                                            'sample_available' => 0,
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
                                            'sourcing_month' => $item[$SourcingMonthIndex],
                                            'attribute_value_id' => $product_att_val->id,
                                            'attribute_id' => $product_att_val->parent_id,
                                            // 'attribute_value_id' => $product_att_val->attribute_value,
                                            // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                            'group_id' => $sku_code,
                                            'Cust_tag_group' =>$item[$ProductGroupIdIndex],
                                        ];
    
                                        ProductExtraInfo::create($product_extra_info_obj);
    
                                        debugtext($debuging_mode,"Printing Varitions That are not Defined in Variation Type..","Red");
                                        // magicstring($product_extra_info_obj);
                                    }                        
                                }
                            }
    
                            
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
                                    $media->file_name = $ExtImg;
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

                        // Creating VArition for Second VAriation
                        foreach ($Productids_array as $key => $id) {
                            if (!in_array($id,$CREATED_PRODUUCT_ID)) {
                                echo $id.newline();

                                $attribute = ProductAttribute::where('user_id',$user->id)->orwhere('user_id',null)->pluck('id');
                                $second = strtolower($second);
                                $second = ucwords($second);
                                $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$second)->first();
                                $vname = $product_att_val->attribute_value;
                                debugtext($debuging_mode,"making Variation for $vname","Red");
                                $product_extra_info_obj_user = [
                                    'product_id' => $id,
                                    'user_id' => $user->id,
                                    'user_shop_id' => $user_shop->id, 
                                    'allow_resellers' => $item[$AllowResellerIndex],
                                    'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                    'collection_name' => $item[$Collection_NameIndex],
                                    'season_month' => $item[$SeasonMonthIndex],
                                    'season_year' => $item[$CollectionYearIndex],
                                    'season_year' => $item[$CollectionYearIndex],
                                    'sample_available' => 0,
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
                                    'sourcing_month' => $item[$SourcingMonthIndex],
                                    'attribute_value_id' => $product_att_val->id,
                                    'attribute_id' => $product_att_val->parent_id,
                                    // 'attribute_value_id' => $product_att_val->attribute_value,
                                    // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                    'group_id' => $sku_code,
                                    'Cust_tag_group' =>$item[$ProductGroupIdIndex],
                                    'remarks' => $item[$RemarkIndex] ?? '' ,
                                    'brand_name' => $item[$BrandNameIndex],
                                ];

                                ProductExtraInfo::create($product_extra_info_obj_user);


                                if (!in_array($id,$CREATED_PRODUUCT_ID)) {
                                    array_push($CREATED_PRODUUCT_ID,$id);
                                }
                            }
                        }

                    }


                    // Creating VArition for first VAriation
                    foreach ($Productids_array as $key => $id) {
                        if (!in_array($id,$CREATED_PRODUUCT_ID_2)) {
                            echo $id.newline();

                            $attribute = ProductAttribute::where('user_id',$user->id)->orwhere('user_id',null)->pluck('id');                            
                            $first = strtolower($first);
                            $first = ucwords($first);
                            
                            $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$first)->first();
                            
                            $vname = $product_att_val->attribute_value;
                            debugtext($debuging_mode,"making Variation for $vname","Red");
                            $product_extra_info_obj_user = [
                                'product_id' => $id,
                                'user_id' => $user->id,
                                'user_shop_id' => $user_shop->id, 
                                'allow_resellers' => $item[$AllowResellerIndex],
                                'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                'collection_name' => $item[$Collection_NameIndex],
                                'season_month' => $item[$SeasonMonthIndex],
                                'season_year' => $item[$CollectionYearIndex],
                                'season_year' => $item[$CollectionYearIndex],
                                'sample_available' => 0,
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
                                'sourcing_month' => $item[$SourcingMonthIndex],
                                'attribute_value_id' => $product_att_val->id,
                                'attribute_id' => $product_att_val->parent_id,
                                // 'attribute_value_id' => $product_att_val->attribute_value,
                                // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                'group_id' => $sku_code,
                                'Cust_tag_group' =>$item[$ProductGroupIdIndex],
                                'remarks' => $item[$RemarkIndex] ?? '' ,
                                'brand_name' => $item[$BrandNameIndex],
                            ];

                            ProductExtraInfo::create($product_extra_info_obj_user);


                            if (!in_array($id,$CREATED_PRODUUCT_ID_2)) {
                                array_push($CREATED_PRODUUCT_ID_2,$id);
                            }
                        }
                    }

                }

                

            }
            elseif ($loop1 != [] && $loop2 != []) {
                    // ! For 2 VAriations
                    foreach ($loop1 as $key1 => $value) {
                        $Productids_array = [];
                        // CReating VAlues for Second Values
                        foreach ($loop2 as $key2 => $value2) {
                            
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
                                'carton_length' => $item[$CartonLengthIndex],
                                'carton_width' => $item[$CartonWidthIndex],
                                'carton_height' => $item[$CartonHeightIndex],
                                'Carton_Dimensions_unit' => $item[$CartonDimensionsUnitIndex],
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

                            debugtext($debuging_mode,"Start Uploading Data","Red");
                            debugtext($debuging_mode,"1. Making Product.","Red");


                            echo $value." - ".$value2.newline();


                            $price = ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->price : trim($item[$CustomerPriceIndex]);
                            $product_obj =  [
                                'title' => ($product_exist != null && $item[$TitleIndex] == null) ? $product_exist->title : $item[$TitleIndex],
                                'model_code' => ($product_exist != null && $item[$ModelCodeIndex] == null) ? $product_exist->model_code : $item[$ModelCodeIndex],
                                'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                                'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                                'brand_id' => ($product_exist != null) ? $product_exist->brand_id : 0,
                                'user_id' => $user->id,
                                'sku' => $sku_code,
                                'slug' => $unique_slug,
                                'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->description : $item[$DescriptionIndex],
                                'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                                'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                                'manage_inventory' => 0,
                                'stock_qty' => 0,
                                'status' => 0,
                                // 'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                                'is_publish' => 1,
                                'price' => $price ?? 0,
                                'min_sell_pr_without_gst' => ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->min_sell_pr_without_gst : $item[$CustomerPriceIndex], 
                                'hsn' => ($product_exist != null && $item[$HSNTaxIndex] == '') ? $product_exist->hsn : $item[$HSNTaxIndex] ?? null,
                                'hsn_percent' => ($product_exist != null && $item[$HSNPercentageIndex] == '') ? $product_exist->hsn_percent : $item[$HSNPercentageIndex] ?? null,
                                'mrp' => ($product_exist != null && $item[$MRPIndex] == '') ? $product_exist->mrp : trim($item[$MRPIndex]),
                                'video_url' => ($product_exist != null && $item[$VideoURLIndex] == '') ? $product_exist->video_url : $item[$VideoURLIndex],
                                'search_keywords' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$Tag1Index],
                                'artwork_url' => $item[$artwork_urlIndex] ?? null,
                                'exclusive' => (in_array($item[$ExlusiveIndex],$allowed_array)) ? 1 : 0,
                                'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                                'SellingPriceUnitIndex' => $item[$SellingPriceUnitIndex] ?? '',
                                // 'archive' => (in_array($item[$ArchiveIndex],$allowed_array)) ? 1 : 0,
                            ];
                                
                            $product_obj = Product::create($product_obj);

                            // debugtext($debuging_mode,"Printing Product Object","Red");
                            // magicstring($product_obj);

                            array_push($Productids_array,$product_obj->id);

                            debugtext($debuging_mode,"Printing Product Ids","Red");
                            // magicstring($Productids_array);

                            $attribute = ProductAttribute::where('user_id',$user->id)->orwhere('user_id',null)->pluck('id');
                            $value2 = strtolower($value2);
                            $value2 = ucwords($value2);
        
                            $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$value2)->first();
                            $vname = $product_att_val->attribute_value;
                        
                            debugtext($debuging_mode,"making Variation for $vname","Red");

                            $product_extra_info_obj_user = [
                                'product_id' => $product_obj->id,
                                'user_id' => $user->id,
                                'user_shop_id' => $user_shop->id, 
                                'allow_resellers' => $item[$AllowResellerIndex],
                                'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                'collection_name' => $item[$Collection_NameIndex],
                                'season_month' => $item[$SeasonMonthIndex],
                                'season_year' => $item[$CollectionYearIndex],
                                'season_year' => $item[$CollectionYearIndex],
                                'sample_available' => 0,
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
                                'sourcing_month' => $item[$SourcingMonthIndex],
                                'attribute_value_id' => $product_att_val->id,
                                'attribute_id' => $product_att_val->parent_id,
                                // 'attribute_value_id' => $product_att_val->attribute_value,
                                // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                'group_id' => $sku_code,
                                'Cust_tag_group' =>$item[$ProductGroupIdIndex],
                                'remarks' => $item[$RemarkIndex] ?? '' ,
                                'brand_name' => $item[$BrandNameIndex],
                            ];

                            ProductExtraInfo::create($product_extra_info_obj_user);

                            debugtext($debuging_mode,"Printing Product Variation Object of User Defined Variaition for $product_att_val->attribute_value","Red");
                            // magicstring($product_extra_info_obj_user);

                            debugtext($debuging_mode,"Not User Define Variations","Red");
                            // magicstring($user_custom_col_list);
                            

                            // - Making Varitions That are not Defined in Variation Type..
                            if (count($user_custom_col_list) != 0) {
                                foreach ($user_custom_col_list as $key => $attri) {
                                    $tmp_col = $col_list->{$attri};
                                    $col_value = $item[$tmp_col];
                                    // $product_att_val = ProductAttributeValue::where('attribute_value',$col_value)->first();
                                    
                                    $attribute_default = ProductAttribute::where('name',$attri)->where('user_id',null)->pluck('id');
                                    $attribute_custom = ProductAttribute::where('name',$attri)->where('user_id',$user->id)->pluck('id');

                                    if (count($attribute_default) == 0 ) {
                                        $attribute = $attribute_custom;
                                    }else{
                                        $attribute = $attribute_default;
                                    }
    
                                    $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$col_value)->first();

                                    // if ($product_att_val == null) {
                                    //     return back()->with('error',"$col_value is not Exist at Row $row, remove Previous Data for prevent Deblicate.");
                                    // }
                                        
                                    if ($product_att_val != null) {
                                        $product_extra_info_obj = [
                                            'product_id' => $product_obj->id,
                                            'user_id' => $user->id,
                                            'user_shop_id' => $user_shop->id, 
                                            'allow_resellers' => $item[$AllowResellerIndex],
                                            'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                            'collection_name' => $item[$Collection_NameIndex],
                                            'season_month' => $item[$SeasonMonthIndex],
                                            'sample_available' => 0,
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
                                            'sourcing_month' => $item[$SourcingMonthIndex],
                                            'attribute_value_id' => $product_att_val->id,
                                            'attribute_id' => $product_att_val->parent_id,
                                            // 'attribute_value_id' => $product_att_val->attribute_value,
                                            // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                            'group_id' => $sku_code,
                                            'Cust_tag_group' =>$item[$ProductGroupIdIndex],
                                        ];

                                        ProductExtraInfo::create($product_extra_info_obj);

                                        debugtext($debuging_mode,"Printing Varitions That are not Defined in Variation Type..","Red");
                                        // magicstring($product_extra_info_obj);
                                    }                        
                                }
                            }

                            
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
                                    $media->file_name = $ExtImg;
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
                        // Creating VAlue for 1st Values
                        foreach ($Productids_array as $key => $id) {
                            echo $id.newline();
                            
                            echo $value.newline();

                            $attribute = ProductAttribute::where('user_id',$user->id)->orwhere('user_id',null)->pluck('id');
                            $value = strtolower($value);
                            $value = ucwords($value);
        
                            $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$value)->first();
                            $vname = $product_att_val->attribute_value;
                            debugtext($debuging_mode,"making Variation for $vname","Red");
                            $product_extra_info_obj_user = [
                                'product_id' => $id,
                                'user_id' => $user->id,
                                'user_shop_id' => $user_shop->id, 
                                'allow_resellers' => $item[$AllowResellerIndex],
                                'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                'collection_name' => $item[$Collection_NameIndex],
                                'season_month' => $item[$SeasonMonthIndex],
                                'season_year' => $item[$CollectionYearIndex],
                                'season_year' => $item[$CollectionYearIndex],
                                'sample_available' => 0,
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
                                'sourcing_month' => $item[$SourcingMonthIndex],
                                'attribute_value_id' => $product_att_val->id,
                                'attribute_id' => $product_att_val->parent_id,
                                // 'attribute_value_id' => $product_att_val->attribute_value,
                                // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                'group_id' => $sku_code,
                                'Cust_tag_group' =>$item[$ProductGroupIdIndex],
                                'remarks' => $item[$RemarkIndex] ?? '' ,
                                'brand_name' => $item[$BrandNameIndex],
                            ];

                            ProductExtraInfo::create($product_extra_info_obj_user);
                        }
                    }
            }
            elseif ($loop1 != []) {
                foreach ($loop1 as $key2 => $value2) {

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
                        'carton_length' => $item[$CartonLengthIndex],
                        'carton_width' => $item[$CartonWidthIndex],
                        'carton_height' => $item[$CartonHeightIndex],
                        'Carton_Dimensions_unit' => $item[$CartonDimensionsUnitIndex],
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

                    debugtext($debuging_mode,"Start Uploading Data","Red");
                    debugtext($debuging_mode,"1. Making Product.","Red");


                    echo $value." - ".$value2.newline();


                    $price = ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->price : trim($item[$CustomerPriceIndex]);
                    $product_obj =  [
                        'title' => ($product_exist != null && $item[$TitleIndex] == null) ? $product_exist->title : $item[$TitleIndex],
                        'model_code' => ($product_exist != null && $item[$ModelCodeIndex] == null) ? $product_exist->model_code : $item[$ModelCodeIndex],
                        'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                        'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                        'brand_id' => ($product_exist != null) ? $product_exist->brand_id : 0,
                        'user_id' => $user->id,
                        'sku' => $sku_code,
                        'slug' => $unique_slug,
                        'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->description : $item[$DescriptionIndex],
                        'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                        'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                        'manage_inventory' => 0,
                        'stock_qty' => 0,
                        'status' => 0,
                        // 'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                        'is_publish' => 1,
                        'price' => $price ?? 0,
                        'min_sell_pr_without_gst' => ($product_exist != null && $item[$CustomerPriceIndex] == '') ? $product_exist->min_sell_pr_without_gst : $item[$CustomerPriceIndex], 
                        'hsn' => ($product_exist != null && $item[$HSNTaxIndex] == '') ? $product_exist->hsn : $item[$HSNTaxIndex] ?? null,
                        'hsn_percent' => ($product_exist != null && $item[$HSNPercentageIndex] == '') ? $product_exist->hsn_percent : $item[$HSNPercentageIndex] ?? null,
                        'mrp' => ($product_exist != null && $item[$MRPIndex] == '') ? $product_exist->mrp : trim($item[$MRPIndex]),
                        'video_url' => ($product_exist != null && $item[$VideoURLIndex] == '') ? $product_exist->video_url : $item[$VideoURLIndex],
                        'search_keywords' => ($product_exist != null && $item[$Tag1Index] == '') ? $product_exist->tag1 : $item[$Tag1Index],
                        'artwork_url' => $item[$artwork_urlIndex] ?? null,
                        'exclusive' => (in_array($item[$ExlusiveIndex],$allowed_array)) ? 1 : 0,
                        'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                        'SellingPriceUnitIndex' => $item[$SellingPriceUnitIndex] ?? '',
                        // 'archive' => (in_array($item[$ArchiveIndex],$allowed_array)) ? 1 : 0,
                    ];
                        
                    $product_obj = Product::create($product_obj);

                    // debugtext($debuging_mode,"Printing Product Object","Red");
                    // magicstring($product_obj);

                    array_push($Productids_array,$product_obj->id);

                    debugtext($debuging_mode,"Printing Product Ids","Red");
                    // magicstring($Productids_array);

                    $attribute = ProductAttribute::where('user_id',$user->id)->orwhere('user_id',null)->pluck('id');
                    $value2 = strtolower($value2);
                    $value2 = ucwords($value2);

                    $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$value2)->first();
                    $vname = $product_att_val->attribute_value;
                
                    debugtext($debuging_mode,"making Variation for $vname","Red");

                    $product_extra_info_obj_user = [
                        'product_id' => $product_obj->id,
                        'user_id' => $user->id,
                        'user_shop_id' => $user_shop->id, 
                        'allow_resellers' => $item[$AllowResellerIndex],
                        'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                        'collection_name' => $item[$Collection_NameIndex],
                        'season_month' => $item[$SeasonMonthIndex],
                        'season_year' => $item[$CollectionYearIndex],
                        'season_year' => $item[$CollectionYearIndex],
                        'sample_available' => 0,
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
                        'sourcing_month' => $item[$SourcingMonthIndex],
                        'attribute_value_id' => $product_att_val->id,
                        'attribute_id' => $product_att_val->parent_id,
                        // 'attribute_value_id' => $product_att_val->attribute_value,
                        // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                        'group_id' => $sku_code,
                        'Cust_tag_group' =>$item[$ProductGroupIdIndex],
                        'remarks' => $item[$RemarkIndex] ?? '' ,
                        'brand_name' => $item[$BrandNameIndex],
                    ];

                    ProductExtraInfo::create($product_extra_info_obj_user);

                    debugtext($debuging_mode,"Printing Product Variation Object of User Defined Variaition for $product_att_val->attribute_value","Red");
                    // magicstring($product_extra_info_obj_user);

                    debugtext($debuging_mode,"Not User Define Variations","Red");
                    // magicstring($user_custom_col_list);
                    

                    // - Making Varitions That are not Defined in Variation Type..
                    if (count($user_custom_col_list) != 0) {
                        foreach ($user_custom_col_list as $key => $attri) {
                            $tmp_col = $col_list->{$attri};
                            $col_value = $item[$tmp_col];
                            
                            $attribute_default = ProductAttribute::where('name',$attri)->where('user_id',null)->pluck('id');
                            $attribute_custom = ProductAttribute::where('name',$attri)->where('user_id',$user->id)->pluck('id');

                            if (count($attribute_default) == 0 ) {
                                $attribute = $attribute_custom;
                            }else{
                                $attribute = $attribute_default;
                            }

                            $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$col_value)->first();

                            // if ($product_att_val == null) {
                            //     return back()->with('error',"$col_value is not Exist in $col_value at Row $row, remove Previous Data for prevent Deblicate.");
                            // }
                                
                            if ($product_att_val != null) {
                                $product_extra_info_obj = [
                                    'product_id' => $product_obj->id,
                                    'user_id' => $user->id,
                                    'user_shop_id' => $user_shop->id, 
                                    'allow_resellers' => $item[$AllowResellerIndex],
                                    'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                    'collection_name' => $item[$Collection_NameIndex],
                                    'season_month' => $item[$SeasonMonthIndex],
                                    'sample_available' => 0,
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
                                    'sourcing_month' => $item[$SourcingMonthIndex],
                                    'attribute_value_id' => $product_att_val->id,
                                    'attribute_id' => $product_att_val->parent_id,
                                    // 'attribute_value_id' => $product_att_val->attribute_value,
                                    // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                    'group_id' => $sku_code,
                                    'Cust_tag_group' =>$item[$ProductGroupIdIndex],
                                ];

                                ProductExtraInfo::create($product_extra_info_obj);

                                debugtext($debuging_mode,"Printing Varitions That are not Defined in Variation Type..","Red");
                                // magicstring($product_extra_info_obj);
                            }                        
                        }
                    }

                    
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
                            $media->file_name = $ExtImg;
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
            else{
                // * echo Does Not Have Varients

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
                                'carton_length' => $item[$CartonLengthIndex],
                                'carton_width' => $item[$CartonWidthIndex],
                                'carton_height' => $item[$CartonHeightIndex],
                                'Carton_Dimensions_unit' => $item[$CartonDimensionsUnitIndex],
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

                            debugtext($debuging_mode,"Start Uploading Data","Red");
                            debugtext($debuging_mode,"1. Making Product.","Red");




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
                    'description' => ($product_exist != null && $item[$DescriptionIndex] == '') ? $product_exist->description : $item[$DescriptionIndex],
                    'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                    'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                    'manage_inventory' => 0,
                    'stock_qty' => 0,
                    'status' => 0,
                    // 'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                    'is_publish' => 1,
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
                    'SellingPriceUnitIndex' => $item[$SellingPriceUnitIndex] ?? '',
                ]);                 
                array_push($Productids_array,$product_obj->id);

                
                // ! Checking Custom attribute Variation Values Not Define Variations 
                if (count($user_custom_col_list) != 0) {
                    foreach ($user_custom_col_list as $key => $attri) {
                        $variantion_col_temp = $col_list->{$attri};
                        $chkwd = $item[$variantion_col_temp];
                        if ( $chkwd != '' && $chkwd != null) {
                            if (count(explode($Array_saprator,$chkwd)) == 1) {
                                // $product_att_val = ProductAttributeValue::where('attribute_value',$chkwd)->first();
                                // $attribute = ProductAttribute::where('user_id',$user->id)->orwhere('user_id',null)->pluck('id');
                                               
                                $attribute_default = ProductAttribute::where('name',$attri)->where('user_id',null)->pluck('id');
                                $attribute_custom = ProductAttribute::where('name',$attri)->where('user_id',$user->id)->pluck('id');

                                if (count($attribute_default) == 0 ) {
                                    $attribute = $attribute_custom;
                                }else{
                                    $attribute = $attribute_default;
                                }
                               
                                // return;
                                $chkwd = strtolower($chkwd);
                                $chkwd = ucwords($chkwd);
                                
                                $product_att_val = ProductAttributeValue::where('attribute_value',$chkwd)->whereIn('parent_id',$attribute)->first();
                                
                                if ($product_att_val == null) {
                                    // return back()->with('error',"$chkwd is not Exist in $attribute at Row $row, remove Previous Data for prevent Deblicate.");
                                    echo "$chkwd is not Exist in $attribute at Row $row, remove Previous Data for prevent Dublicate.".newline();
                                }
                                
                                $product_extra_info_obj_user = ProductExtraInfo::create([
                                    'product_id' => $product_obj->id,
                                    'user_id' => $user->id,
                                    'user_shop_id' => $user_shop->id, 
                                    'allow_resellers' => $item[$AllowResellerIndex],
                                    'exclusive_buyer_name' => $item[$ExclusiveBuyerNameIndex],
                                    'collection_name' => $item[$Collection_NameIndex],
                                    'season_month' => $item[$SeasonMonthIndex],
                                    'sample_available' => 0,
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
                                    'attribute_value_id' => $product_att_val->id,
                                    'attribute_id' => $product_att_val->parent_id,
                                    'group_id' => $sku_code,
                                    'Cust_tag_group' =>$item[$ProductGroupIdIndex],
                                ]);
                            }
                        } // *
                        
                    }
                }
                
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
                        $media->file_name = $ExtImg;
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
           
            debugtext($debuging_mode,"The Count is $count","green");
            echo newline(5);
            debugtext($debuging_mode,"Loop Stoped at First Row of Sheet");
        }


        // return back()->with('success',"$count Items are Added Successfully !!");
        return redirect(route('panel.filemanager.index'))->with('success', 'Good News! '.$count.' records created successfully!');
    }


    public function ProductSheetExport(Request $request,User $user_id)
    { 
        // Fetch All attriubutes    
        $default_attribute = (array) json_decode(Setting::where('key','bulk_sheet_upload')->first()->value);
        $custom_attributes = (array) json_decode($user_id->custom_attriute_columns) ?? ['Colours','Size','Material'];
        
        // Merging All attributes
        $merged_array = array_merge(array_keys($default_attribute),$custom_attributes); 
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($merged_array,null,'A3');
            $Excel_writer = new Xls($spreadSheet);            
            $fileName = "Product Bulk sheet of $user_id->name.xls";
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=$fileName");
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();   
        } catch (Exception $e) {
            $response = ['msg'=> "Error While Creating Excel File.. Try Again Later."];
            return $response;
        }
        return back()->with('success',"Download Started !!");
    }

    // @ This Function Will Be USe in Admin Panel For Changeing Order of Excel Sheet
    public function updateExcelShow(Request $request) {
        
        $setting = Setting::where('key','bulk_sheet_upload')->get();
        $Settingvaluekeys = array_keys((array) json_decode($setting[0]->value));
       
        
        return view('panel.Bulk_excel.index',compact('setting','Settingvaluekeys'));
    }
    
    public function updateExcel(Request $request) {
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
        $rows = array_slice($rows,2);
        $master = $rows;
        // ` Get New File Structure
        $new_arr = [];
        foreach ($master[0] as $key => $value) {
            $new_arr[$value] = $key;
        }
        $setting = Setting::where('key','bulk_sheet_upload')->first();
        $setting->value = json_encode($new_arr);
        $setting->save();
        return back()->with('success',"Bulk Sheet Updated !!");
    }

    // @ This Function Will Be USe in Admin Panel For Changeing Order of Excel Sheet

    public function productBulkExport($products){
        // return $products;
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($products,null,'A3');
            $Excel_writer = new Xls($spreadSheet);
            $fileName = "Customer_ExportedData";
            
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=$fileName.xls");
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    // Export Product Data
    function exportData(Request $request,User $user_id){
        try {
            {
                
                // $products = Product::whereUserId($user_id->id)->take('120')->get();
                $products = Product::whereUserId($user_id->id)->get();

                $products_array [] = array(
                    'Id','Model_Code','Category','Sub_Category','Group ID','Image_main','image_name_front','image_name_back','image_name_side1','image_name_side2','image_name_poster','Additional Image Use ^^','Product name','Video URL','description','Search keywords','Brand Name','Base_currency','Selling Price_Unit','Customer_Price_without_GST','Shop_Price_VIP_Customer','Shop_Price_Reseller','mrpIncl tax','HSN Tax','HSN_Percnt','Allow_Resellers','Live / Active','Copyright/ Exclusive item','Exclusive Buyer Name','Theme / Collection Name','Season / Month','Theme / Collection Year','Sample / Stock available','Sample Year','Sample Month','Sampling time','CBM','Production time (days)','MBQ','MBQ_units','Remarks','Vendor Sourced from','Vendor price','Product Cost_Unit','Vendor currency','Sourcing Year','Sourcing month','Gross weight','Net weight','Weight_unit','Product length','Product width','Product height','Dimensions_unit','Carton length','Carton width','Carton height','Carton_Dimensions_unit','standard_carton_pcs','carton_weight_actual','unit','artwork_url',
                );
        
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
                    $additional_images_tmp = [];
                    $additional_images = [];
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
                        $gross_weight = $dimensions->gross_weight ?? null;
                    } else {
                        $dimensions = null ;
                        $height = null ;
                        $weight = null ;
                        $width = null ;
                        $unit = null ;
                        $length = null ;
                        $length_unit = null ;
                        $gross_weight = null ;
                    }
                    if ( $product->carton_details != null) {
                        $carton_details = json_decode($product->carton_details);
                        $standard_carton = $carton_details->standard_carton ?? null;
                        $carton_weight = $carton_details->carton_weight ?? null;
                        $carton_unit = $carton_details->carton_unit ?? null;
                        $carton_length = $carton_details->carton_length ?? null;
                        $carton_width = $carton_details->carton_width ?? null;
                        $carton_height = $carton_details->carton_height ?? null;                        
                        $Carton_Dimensions_unit = $carton_details->Carton_Dimensions_unit ?? null;
                    } else {
                        $carton_details = null ;
                        $standard_carton = null ;
                        $carton_weight = null ;
                        $carton_unit = null ;
                        $carton_length = null;
                        $carton_width =  null;
                        $carton_height = null;
                        $Carton_Dimensions_unit = null;
                    }
                    if($product->is_publish == 0){
                        $usi->update([
                            'is_published' => 0
                        ]);
                    }
                    
                    foreach ($product->medias as $key => $value) {
                        if ($key > 5) {
                            array_push($additional_images_tmp,$value->file_name);
                        }
                    }
        
                    $additional_images = implode("^^",$additional_images_tmp);

                    // $common_attribute = ['Colour','Size','Material'];
                    $color_array = ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',1)->groupBy('attribute_value_id')->pluck('attribute_value_id');

                    $size_array = ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',2)->groupBy('attribute_value_id')->pluck('attribute_value_id');

                    $material_array = ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',3)->groupBy('attribute_value_id')->pluck('attribute_value_id');
                    
                    $extraInfoData = ProductExtraInfo::where('product_id',$product->id)->first();
        
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


                    $allowed_array = ['Yes','YES','yes',1,true,'Hn'];
                    
                    $products_array[] = array(
                        'Id' => $product->id,
                        "Model Code"=> $product->model_code,
                        "Global Category"=> $product->category->name ?? "",
                        "Global Sub-category"=>$product->subcategory->name ?? "",
                        'Cust_tag_group' =>$extraInfoData->Cust_tag_group ?? '',
                        "Image_main"=> isset($product->medias[0]) ? ($product->medias[0]->file_name ?? "") : null,
                        "image_name_front"=>isset($product->medias[1]) ? ($product->medias[1]->file_name ?? ""): null,
                        "image_name_back"=>isset($product->medias[2]) ? ($product->medias[2]->file_name ?? ""): null,
                        "image_name_side1"=>isset($product->medias[3]) ? ($product->medias[3]->file_name ?? ""): null,
                        "image_name_side2"=>isset($product->medias[4]) ? ($product->medias[4]->file_name ?? ""): null,
                        "image_name_poster"=>isset($product->medias[5]) ? ($product->medias[5]->file_name ?? ""): null,
                        "Additional Image Use ^^" => $additional_images,
                        "Product Name"=> $product->title ?? "",
                        "Video URL"=>$product->video_url ?? '',
                        'Description' =>$product->description ?? '',
                        'search_keywords' => $product->search_keywords ?? '',
                        'brand_name' => $extraInfoData->brand_name ?? '',
                        'Base_currency' => $product->base_currency ?? 'INR',
                        'Selling Price_Unit' => $product->selling_price_unit ?? '',
                        "Customer_Price_without_GST"=> $usi->price ?? "",
                        "Shop_Price_VIP_Customer"=> $vip_group_product->price ?? "",
                        "Shop_Price_Reseller"=> $reseller_group_product->price ?? "",
                        "mrp Incl tax"=>$product->mrp,
                        "HSN Tax"=>$product->hsn,
                        "HSN_Percnt"=>$product->hsn_percent,
                        'allow_resellers' => (in_array(($extraInfoData->allow_resellers ?? 'No'),$allowed_array) ? 'Yes' : 'No') ?? 'No',
                        'Publish (it will be 0 for unpublish or 1 for publish)' => (in_array($product->is_publish,$allowed_array) ? "Yes" : "No") ?? "No" ,
                        'Exclusive' => (in_array($product->exclusive,$allowed_array) ? 'Yes' : 'No') ?? 'No',
                        'exclusive_buyer_name' => $extraInfoData->exclusive_buyer_name ?? '',
                        'collection_name' => $extraInfoData->collection_name ?? '',
                        'season_month' => $extraInfoData->season_month ?? '',
                        'season_year' => $extraInfoData->season_year ?? '',
                        'sample_available' => (in_array(($extraInfoData->sample_available ?? 'No'),$allowed_array) ? "Yes" : 'No') ?? 'No',
                        'sample_year' => $extraInfoData->sample_year ?? '',
                        'sample_month' => $extraInfoData->sample_month ?? '',
                        'sampling_time' => $extraInfoData->sampling_time ?? '',
                        'CBM' => $extraInfoData->CBM ?? '',
                        'production_time' => $extraInfoData->production_time ?? '',
                        'MBQ' => $extraInfoData->MBQ ?? '',
                        'MBQ_unit' => $extraInfoData->MBQ_unit ?? '',
                        'remarks' => $extraInfoData->remarks ?? '',
                        'vendor_sourced_from' => $extraInfoData->vendor_sourced_from ?? '',
                        'vendor_price' => $extraInfoData->vendor_price ?? '',
                        'product_cost_unit' => $extraInfoData->product_cost_unit ?? '',
                        'vendor_currency' => $extraInfoData->vendor_currency ?? '',
                        'sourcing_year' => $extraInfoData->sourcing_year ?? '',
                        'sourcing_month' => $extraInfoData->sourcing_month ?? '',
                        'Gross weight' => $gross_weight,
                        'Net weight' =>$weight,
                        'weight_unit' =>$unit,
                        'Product length' =>$length,
                        'Product width' =>$width,
                        'Product height' =>$height,
                        'Dimensions_unit' =>$length_unit,
                        'Carton length' => $carton_length,
                        'Carton width' => $carton_width,
                        'Carton height' => $carton_height,
                        'Carton_Dimensions_unit' => $Carton_Dimensions_unit,
                        'standard_carton_pcs' =>$standard_carton,
                        'carton_weight_actual' =>$carton_weight,
                        'unit' =>$carton_unit,
                        'artwork_url' => $product->artwork_url,
                        'Color' => implode("^^",$color_Val) ?? '',
                        'Size' => implode("^^",$size_Val) ?? '',
                        "Material" => implode("^^",$material_Val) ?? '',
                    );
        
                    
                    foreach ($PRODUCT_ATTRIBUTE_ARRAY as $index => $value) {
                        array_push($products_array[$pkey+1],$value);                
                    }                    
                }
                
                
                
                // magicstring(array_keys($products_array[1]));
                
                $this->productBulkExport($products_array);
                // return back()->with('success',' Export Excel File Successfully');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function productBulkUpdate(Request $request) {

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $count = 0;

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
    
            $user = auth()->user();
            $custom_attributes = json_decode($user->custom_attriute_columns);

            $allowArray = ['Yes','yes','YES',1,true,"TRUE","True"];
            $debuging_mode = 0;

            $Array_saprator = "^^";
            
            $ProductidIndex = 0; 
            $Model_CodeIndex = 1;
            $CategoryIndex = 2;
            $Sub_CategoryIndex = 3;
            $GroupIDIndex = 4;
            $ImageMainIndex = 5;
            $ImageFrontIndex = 6;
            $ImageBackIndex  = 7;
            $ImageSide1Index = 8;
            $ImageSide2Index = 9;
            $ImagePosterIndex = 10;
            $AdditionalImageIndex = 11;
            $ProductnameIndex = 12;
            $VideoURLIndex = 13;
            $descriptionIndex = 14;
            $SearchkeywordsIndex = 15;
            $BrandNameIndex = 16;
            $Base_currencyIndex = 17;
            $SellingPrice_UnitIndex = 18;
            $Customer_Price_without_GSTIndex = 19;
            $Shop_Price_VIP_CustomerIndex = 20;
            $Shop_Price_ResellerIndex = 21;
            $mrpIncltaxIndex = 22;
            $HSNTaxIndex = 23;
            $HSN_PercntIndex = 24;
            $Allow_ResellersIndex = 25;
            $Live_ActiveINdex = 26;
            $Copyright_Exclusive_itemIndex = 27;
            $ExclusiveBuyerNameIndex = 28;
            $ThemeCollectionNameIndex = 29;
            $Season_MonthIndex = 30;
            $ThemeCollectionYearIndex = 31;
            $SampleStockavailable = 32;
            $SampleYearIndex = 33;
            $SampleMonthIndex = 34;
            $SamplingtimeIndex = 35;
            $CBMIndex = 36;
            $ProductiontimeIndex = 37;
            $MBQIndex = 38;
            $MBQ_unitsIndex = 39;
            $RemarksINdex = 40;
            $VendorSourcedfromIndex = 41;
            $VendorpriceIndex = 42;
            $ProductCost_UnitIndex = 43;
            $VendorcurrencyIndex = 44;
            $SourcingYearIndex = 45;
            $SourcingmonthIndex = 46;
            $GrossweightIndex = 47;
            $Netweightindex = 48;
            $Weight_unitIndex = 49;
            $ProductlengthIndex = 50;
            $ProductwidthIndex = 51;
            $ProductheightIndex = 52;
            $Dimensions_unitIndex = 53;
            $CartonlengthIndex = 54;
            $CartonwidthIndex = 55;
            $CartonheightIndex = 56;
            $Carton_Dimensions_unitIndex = 57;
            $standard_carton_pcsOIndex = 58;
            $carton_weight_actualIndex = 59;
            $unitIndex = 60;
            $artwork_urlIndex = 61;

            // * Start: Marging Both Array Custom And Default Attributes
            $delfault_cols = json_decode(Setting::where('key','bulk_sheet_upload')->first()->value);
            $user_custom_col_list = json_decode($user->custom_attriute_columns) ?? [];
            $num = end($delfault_cols) +1;
            $new_custom_attribute = [];
            foreach ($user_custom_col_list as $key => $value) {
                $new_custom_attribute += [$value => $num];
                $num++;
            }
            
            // ` Col LIst in Form of Object
            $col_list = (object) array_merge((array)$delfault_cols,$new_custom_attribute);
            // * End: Marging Both Array Custom And Default Attributes
            
            // ! Validating Loop
            foreach ($master as $key => $temp_item) {
                $row = $key+4;

                // ! Validate Product Id

                $chk_product = Product::whereId($temp_item[$ProductidIndex])->where('user_id',$user->id)->get();

                if (count($chk_product) == 0) {
                    return back()->with('error',"Product Doesn't Exist");
                }
                
                // ! Checking Category
                if ($temp_item[$CategoryIndex] == null) {
                    return back()->with('error',"category is Blank At Row $row");
                }else{
                    $chk = Category::where('name',$temp_item[$CategoryIndex])->get();
                    if (count($chk) == 0) {
                        return back()->with('error',"category is not Exist At Row $row");
                    }
                    $categoryID = $chk[0]->id;
                }
    
                // ! Checking Sub Category
                if ($temp_item[$Sub_CategoryIndex] == null) {
                    return back()->with('error',"Sub category is Blank At Row $row");
                }else{
                    $chk = Category::where('name',$temp_item[$Sub_CategoryIndex])->where('parent_id',$categoryID)->get();
    
                    if (count($chk) == 0) {
                        return back()->with('error',"Sub category is not Exist At Row $row");
                    }
                    $SubCategoryId = $chk[0]->id;
                }


                // ` Getting Custom Attribute 

                // checking Custom Attribute Values In database
                if ($custom_attributes != null) {
                    foreach ($custom_attributes as $key => $custom_attribute) {
                        echo $custom_attribute.newline();
                        // * Getting Column Number
                        $tmp_col = $col_list->{$custom_attribute} - 1;

                        // ! Checking Value if Column is Not Blank
                        if ($temp_item[$tmp_col] != null) {
                            if (count(explode($Array_saprator,$temp_item[$tmp_col])) > 1 ) {
                                return back()->with('error',"Product Sapration is Not Allowed in Product Update.");
                            }
                            
                            $attribute_record_default = ProductAttribute::where('name',$custom_attribute)->where('user_id',null)->first();
                            $attribute_record_custom = ProductAttribute::where('name',$custom_attribute)->where('user_id',$user->id)->first();
                            if ($attribute_record_default != null) {
                                $attribute_record = $attribute_record_default;
                            }else{
                                $attribute_record = $attribute_record_custom;
                            }


                            if ($attribute_record == null) {
                                return back()->with("error","Oops Something Went wrong.Try again Later!!");
                            }else{
                                $search_value = $temp_item[$tmp_col];
                                $attribute_value_record = ProductAttributeValue::where('parent_id',$attribute_record->id)->where('attribute_value',$search_value)->first();
                                
                                if ($attribute_value_record == null) {
                                    return back()->with('error',"$search_value Does Not Exist in $custom_attribute Column  at Row $row.");
                                }
                            }

                        }
                            
                    }
                }

            }           

            // ! Updating Loop
            foreach ($master as $key => $value) {
                $row = $key + 4;
                
                $categoryID  = '';
                $SubCategoryId = '';
      
                $carton_details = [
                    'standard_carton' => $value[$standard_carton_pcsOIndex],
                    'carton_weight' => $value[$carton_weight_actualIndex],
                    'carton_unit' => $value[$unitIndex],
                    'carton_length' => $value[$CartonlengthIndex],
                    'carton_width' => $value[$CartonwidthIndex],
                    'carton_height' => $value[$CartonheightIndex],
                    'Carton_Dimensions_unit' => $value[$Carton_Dimensions_unitIndex],
                 ];
                 $shipping = [
                     'height' => $value[$ProductheightIndex],
                     'gross_weight' => $value[$GrossweightIndex],
                     'weight' => $value[$Netweightindex],
                     'width' => $value[$ProductwidthIndex],
                     'length' => $value[$ProductlengthIndex],
                     'unit' => $value[$Weight_unitIndex],
                     'length_unit' => $value[$Dimensions_unitIndex],
                 ];
          
                //  magicstring($shipping);
                //  return;
                 $carton_details = json_encode($carton_details);
                 $shipping = json_encode($shipping);
    

    
                // Checking Category
                if ($value[$CategoryIndex] == null) {
                    return back()->with('error',"category is Blank At Row $row");
                }else{
                    $chk = Category::where('name',$value[$CategoryIndex])->get();
                    if (count($chk) == 0) {
                        return back()->with('error',"category is not Exist At Row $row");
                    }
                    $categoryID = $chk[0]->id;
                }
    
    
                if ($value[$Sub_CategoryIndex] == null) {
                    return back()->with('error',"Sub category is Blank At Row $row");
                }else{
                    $chk = Category::where('name',$value[$Sub_CategoryIndex])->where('parent_id',$categoryID)->get();
    
                    if (count($chk) == 0) {
                        return back()->with('error',"Sub category is not Exist At Row $row");
                    }
    
                    $SubCategoryId = $chk[0]->id;
                }
    
                // Extra Info
                ProductExtraInfo::where('product_id',$value[$ProductidIndex])->update([
                    'allow_resellers' =>  $value[$Allow_ResellersIndex] ?? '0',
                    'exclusive_buyer_name' => $value[$ExclusiveBuyerNameIndex] ?? '',
                    'collection_name' => $value[$ThemeCollectionNameIndex] ?? '',
                    'season_month' => $value[$Season_MonthIndex] ?? '',
                    'season_year' => $value[$ThemeCollectionYearIndex] ?? '',
                    'sample_available' => $value[$SampleStockavailable] ?? '',
                    'sample_year' => $value[$SampleYearIndex] ?? '',
                    'sample_month' => $value[$SampleMonthIndex] ?? '',
                    'sampling_time' => $value[$SamplingtimeIndex] ?? '',
                    'sourcing_month' => $value[$SourcingmonthIndex] ?? '',
                    'remarks' => $value[$RemarksINdex] ?? '',
                    'production_time' => $value[$ProductiontimeIndex] ?? '',
                    'CBM' => $value[$CBMIndex] ?? '',
                    'MBQ' => $value[$MBQIndex] ?? '',
                    'MBQ_unit' => $value[$MBQ_unitsIndex] ?? '',
                    'vendor_sourced_from' => $value[$VendorSourcedfromIndex] ?? '',
                    'vendor_price' => $value[$VendorpriceIndex] ?? '',
                    'product_cost_unit' => $value[$ProductCost_UnitIndex] ?? '',
                    'vendor_currency' => $value[$VendorcurrencyIndex] ?? '',
                    'sourcing_year' => $value[$SourcingYearIndex] ?? '',
                    'brand_name' => $value[$BrandNameIndex] ?? '',
                    'Cust_tag_group' => $value[$GroupIDIndex] ?? '',                    
                ]);

                // !! Updating Attribute Value !!
                // checking Custom Attribute Values In database
                if ($custom_attributes != null) {
                    foreach ($custom_attributes as $key => $custom_attribute) {
                        echo $custom_attribute.newline();
                        // * Getting Column Number
                        $tmp_col = $col_list->{$custom_attribute} - 1;

                        // ! Checking Value if Column is Not Blank
                        if ($value[$tmp_col] != null) {
                            if (count(explode($Array_saprator,$value[$tmp_col])) > 1 ) {
                                return back()->with('error',"Product Sapration is Not Allowed in Product Update.");
                            }
                            
                            $attribute_record_default = ProductAttribute::where('name',$custom_attribute)->where('user_id',null)->first();
                            $attribute_record_custom = ProductAttribute::where('name',$custom_attribute)->where('user_id',$user->id)->first();
                            if ($attribute_record_default != null) {
                                $attribute_record = $attribute_record_default;
                            }else{
                                $attribute_record = $attribute_record_custom;
                            }


                            if ($attribute_record == null) {
                                // return back()->with("error","Oops Something Went wrong.Try again Later!!");                            
                                
                            }else{
                                $search_value = $value[$tmp_col];
                                $attribute_value_record = ProductAttributeValue::where('parent_id',$attribute_record->id)->where('attribute_value',$search_value)->first();
                                
                                if ($attribute_value_record == null) {
                                    return back()->with('error',"$search_value Does Not Exist in $custom_attribute Column  at Row $row.");
                                }

                                $chk = ProductExtraInfo::where('product_id',$value[$ProductidIndex])->where('attribute_id',$attribute_record->id)->get();
                                
                                
                                if (count($chk) != 0) {
                                    ProductExtraInfo::where('product_id',$value[$ProductidIndex])->where('attribute_id',$attribute_record->id)->update([
                                        'attribute_value_id' => $attribute_value_record->id,
                                    ]);
                                }else{
                                    ProductExtraInfo::create([
                                        'product_id' => $value[$ProductidIndex],
                                        'allow_resellers' =>  $value[$Allow_ResellersIndex] ?? 'No',
                                        'exclusive_buyer_name' => $value[$ExclusiveBuyerNameIndex] ?? '',
                                        'collection_name' => $value[$ThemeCollectionNameIndex] ?? '',
                                        'season_month' => $value[$Season_MonthIndex] ?? '',
                                        'season_year' => $value[$ThemeCollectionYearIndex] ?? '',
                                        'sample_available' => $value[$SampleStockavailable] ?? '',
                                        'sample_year' => $value[$SampleYearIndex] ?? '',
                                        'sample_month' => $value[$SampleMonthIndex] ?? '',
                                        'sampling_time' => $value[$SamplingtimeIndex] ?? '',
                                        'sourcing_month' => $value[$SourcingmonthIndex] ?? '',
                                        'remarks' => $value[$RemarksINdex] ?? '',
                                        'production_time' => $value[$ProductiontimeIndex] ?? '',
                                        'CBM' => $value[$CBMIndex] ?? '',
                                        'MBQ' => $value[$MBQIndex] ?? '',
                                        'MBQ_unit' => $value[$MBQ_unitsIndex] ?? '',
                                        'vendor_sourced_from' => $value[$VendorSourcedfromIndex] ?? '',
                                        'vendor_price' => $value[$VendorpriceIndex] ?? '',
                                        'product_cost_unit' => $value[$ProductCost_UnitIndex] ?? '',
                                        'vendor_currency' => $value[$VendorcurrencyIndex] ?? '',
                                        'sourcing_year' => $value[$SourcingYearIndex] ?? '',
                                        'brand_name' => $value[$BrandNameIndex] ?? '',
                                        'Cust_tag_group' => $value[$GroupIDIndex] ?? '',     
                                        'attribute_value_id' => $attribute_value_record->id,
                                        'attribute_id' => $attribute_record->id
                                    ]);   
                                }   
                            }

                        }
                            
                    }
                }               
                
                                            
                if (in_array($value[$SampleStockavailable],$allowArray)) {
                    $chk_inventory_exist = true;
                }else{
                    $chk_inventory_exist = 0;
                }
                $need_inventory = in_array($value[$SampleStockavailable],$allowArray) ? true : false ?? false;

    
                // Product Info
                $product_obj = Product::whereId($value[$ProductidIndex])->first();
               
                Product::whereId($value[$ProductidIndex])->update(
                [
                    'title' => $value[$ProductnameIndex] ?? '',
                    'model_code' => $value[$Model_CodeIndex] ?? '',
                    'category_id' => $categoryID ?? '',
                    'sub_category' => $SubCategoryId ?? '',
                    'description' => $value[$descriptionIndex] ?? '',
                    'carton_details' => $carton_details ?? '',
                    'shipping' => $shipping ?? '',
                    'manage_inventory' => (in_array($value[$SampleStockavailable],$allowArray,true) ? 1 : 0 ) ?? 0,
                    'is_publish' => (in_array($value[$Live_ActiveINdex],$allowArray,true) ? 1 : 0 ) ?? 0,
                    'price' =>  $value[$Customer_Price_without_GSTIndex] ?? '',
                    'min_sell_pr_without_gst' => $value[$Customer_Price_without_GSTIndex] ?? '',
                    'hsn' => $value[$HSNTaxIndex] ?? '',
                    'hsn_percent' => $value[$HSN_PercntIndex] ?? '',
                    'mrp' => $value[$mrpIncltaxIndex] ?? '',
                    'video_url' => $value[$VideoURLIndex] ?? '',
                    'search_keywords' => $value[$SearchkeywordsIndex] ?? '',
                    'artwork_url' => $value[$artwork_urlIndex] ?? '',
                    'exclusive' => (in_array($value[$Copyright_Exclusive_itemIndex],$allowArray,true) ? 1 : 0) ?? 0,
                    'base_currency' =>  $value[$Base_currencyIndex] ?? '',
                    'selling_price_unit' => $value[$SellingPrice_UnitIndex] ?? '',
                ]);

                // User Shop Item Info and Price Group
                $usi = UserShopItem::whereUserId(auth()->id())->where('product_id',$value[$ProductidIndex])->first();

                // echo $value[$ProductidIndex];
                
                // magicstring($usi);
                // return;

                $reseller_group = Group::whereUserId(auth()->id())->where('name',"Reseller")->first();
                $vip_group = Group::whereUserId(auth()->id())->where('name',"VIP")->first();
                $reseller_group_product = GroupProduct::where('group_id',$reseller_group->id ?? 0)->where('product_id',$value[$ProductidIndex])->first();
                $vip_group_product = GroupProduct::where('group_id',$vip_group->id??0)->where('product_id',$value[$ProductidIndex])->first();
                $chk_inventroy = Inventory::where('product_id',$value[$ProductidIndex])->where('user_id',auth()->id())->get();
    

                if (in_array($value[$SampleStockavailable],$allowArray)) {
                    if (count($chk_inventroy) == 0) {
                        // magicstring($request->all());
                        Inventory::create([
                            'user_shop_item_id' => $usi->id,
                            'product_id' => $value[$ProductidIndex],
                            'product_sku' => $product_obj->sku,
                            'user_id' => auth()->id(),
                            'stock' => 0,
                            'parent_id' => 0,
                            'prent_stock' => 0,
                        ]);
                    }else{
                        getinventoryByproductId($product_obj->id)->update(['status'=>1]);
                    }
                }else{
                    if (count($chk_inventroy) != 0) {
                        getinventoryByproductId($product_obj->id)->update(['status'=>0]);
                    }
                }

                if($usi){
                    $usi->is_published = (in_array($value[$Live_ActiveINdex],$allowArray) ? 1 : 0 ) ?? 0;
                    $usi->price = $value[$Customer_Price_without_GSTIndex];
                    $usi->category_id = $categoryID;
                    $usi->sub_category_id = $SubCategoryId;
                    $usi->save();
                }
    
                if($reseller_group_product){
                    $reseller_group_product->price = $value[$Shop_Price_ResellerIndex] ?? 0;
                    $reseller_group_product->save();
                }
                if($vip_group_product){
                    $vip_group_product->price = $value[$Shop_Price_VIP_CustomerIndex] ?? 0;
                    $vip_group_product->save();
                }



                if(isset($product_obj->medias[0]) && $product_obj->medias[0]->id){
                    Media::whereId($product_obj->medias[0]->id)->update([
                        'file_name' => $value[$ImageMainIndex],
                        'path' => "storage/files/".auth()->id()."/".$value[$ImageMainIndex]
                    ]);
                }else{
                    if(isset($value[$ImageMainIndex])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $value[$ImageMainIndex];
                        $media->path = "storage/files/".auth()->id()."/".$value[$ImageMainIndex];
                        $media->extension = explode('.',$value[$ImageMainIndex])[1] ?? '';
                        $media->save();
                    }
                }

                if(isset($product_obj->medias[1]) && $product_obj->medias[1]->id){
                    Media::whereId($product_obj->medias[1]->id)->update([
                        'file_name' => $value[$ImageFrontIndex],
                        'path' => "storage/files/".auth()->id()."/".$value[$ImageFrontIndex]
                    ]);
                }else{
                    if(isset($value[$ImageFrontIndex])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $value[$ImageFrontIndex];
                        $media->path = "storage/files/".auth()->id()."/".$value[$ImageFrontIndex];
                        $media->extension = explode('.',$value[$ImageFrontIndex])[1] ?? '';
                        $media->save();
                    }
                }

                if(isset($product_obj->medias[2]) && $product_obj->medias[2]->id){
                    Media::whereId($product_obj->medias[2]->id)->update([
                        'file_name' => $value[$ImageBackIndex],
                        'path' => "storage/files/".auth()->id()."/".$value[$ImageBackIndex]
                    ]);
                }else{
                    if(isset($value[$ImageBackIndex])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $value[$ImageBackIndex];
                        $media->path = "storage/files/".auth()->id()."/".$value[$ImageBackIndex];
                        $media->extension = explode('.',$value[$ImageBackIndex])[1] ?? '';
                        $media->save();
                    }
                }

                if(isset($product_obj->medias[3]) && $product_obj->medias[3]->id){
                    Media::whereId($product_obj->medias[3]->id)->update([
                        'file_name' => $value[$ImageSide1Index],
                        'path' => "storage/files/".auth()->id()."/".$value[$ImageSide1Index]
                    ]);
                }else{
                    if(isset($value[$ImageSide1Index])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $value[$ImageSide1Index];
                        $media->path = "storage/files/".auth()->id()."/".$value[$ImageSide1Index];
                        $media->extension = explode('.',$value[$ImageSide1Index])[1] ?? '';
                        $media->save();
                    }
                }

                if(isset($product_obj->medias[4]) && $product_obj->medias[4]->id){
                    Media::whereId($product_obj->medias[4]->id)->update([
                        'file_name' => $value[$ImageSide2Index],
                        'path' => "storage/files/".auth()->id()."/".$value[$ImageSide2Index]
                    ]);
                }else{
                    if(isset($value[$ImageSide2Index])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $value[$ImageSide2Index];
                        $media->path = "storage/files/".auth()->id()."/".$value[$ImageSide2Index];
                        $media->extension = explode('.',$value[$ImageSide2Index])[1] ?? '';
                        $media->save();
                    }
                }

                if(isset($product_obj->medias[5]) && $product_obj->medias[5]->id){
                    Media::whereId($product_obj->medias[5]->id)->update([
                        'file_name' => $value[$ImagePosterIndex],
                        'path' => "storage/files/".auth()->id()."/".$value[$ImagePosterIndex]
                    ]);
                }else{
                    if(isset($value[$ImagePosterIndex])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $value[$ImagePosterIndex];
                        $media->path = "storage/files/".auth()->id()."/".$value[$ImagePosterIndex];
                        $media->extension = explode('.',$value[$ImagePosterIndex])[1] ?? '';
                        $media->save();
                    }
                }


                if ($value[$AdditionalImageIndex]) {
                    foreach (explode("^^",$value[$AdditionalImageIndex]) as $key => $value) {
                        foreach ($product_obj->medias as $key1 => $media) {
                            if ($key1 > 5) {

                                if (isset($product_obj->medias[$key1]) && $product_obj->medias[$key1]->id) {
                                    Media::whereId($product_obj->medias[$key1]->id)->update([
                                        'file_name' => $value,
                                        'path' => "storage/files/".auth()->id()."/".$value
                                    ]);
                                }else{
                                    
                                    if(isset($value)){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $value;
                                        $media->path = "storage/files/".auth()->id()."/".$value;
                                        $media->extension = explode('.',$value)[1] ?? '';
                                        $media->save();
                                    }

                                }


                                
                            }
                        }
            
                    }
                }
                $count++;
            }

            return back()->with("success","$count Records are Updated SuccessFully");

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    

}