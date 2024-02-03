<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Panel\FileManager;
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
use App\Models\Uploadrecord;
use App\Models\UserCurrency;
use App\Models\UserShop;
use App\Models\UserShopItem;
use App\Models\Usertemplates;
use App\Models\CustomFields;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use PhpParser\Node\Expr\Cast\Object_;
use PhpParser\Node\Stmt\Return_;
use Psy\TabCompletion\Matcher\ObjectMethodDefaultParametersMatcher;
use Symfony\Component\HttpFoundation\StreamedResponse;
use function GuzzleHttp\Promise\all;
use ZipArchive;



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


        if (!$request->has('file')) {
            return back()->with('error','Select excel file before Uploading');
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
        $with_header = array_slice($rows,2);
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
        $TitleIndex = $col_list->{'Product_name'};
        $VideoURLIndex = $col_list->{'Video URL'};
        $CustomerPriceIndex = $col_list->{'Customer_Price_without_GST'};
        $VIPPriceIndex = $col_list->{'Shop_Price_VIP_Customer'};
        $ResellerPriceIndex = $col_list->{'Shop_Price_Reseller'};
        $MRPIndex = $col_list->{'mrpIncl tax'};
        $HSNTaxIndex = $col_list->{'HSN Tax'};
        $HSNPercentageIndex = $col_list->{'HSN_Percnt'};
        $CollectionYearIndex = $col_list->{'Theme_Collection_Year'};
        $SampleYearIndex = $col_list->{'Sample_Year'};
        $SampleMonthIndex = $col_list->{'Sample_Month'};
        $SampleTimeIndex = $col_list->{'Sampling_time'};
        $CBMIndex = $col_list->{'CBM'};
        $ProductionTimeIndex = $col_list->{'Production time (days)'};
        $MBQIndex = $col_list->{'MBQ'};
        $MBQ_unitsIndex = $col_list->{'MBQ_units'};
        $SourcingYearIndex = $col_list->{'Sourcing_Year'} ;
        $SourcingMonthIndex = $col_list->{'Sourcing_month'};
        $StandardCartonIndex =$col_list->{'standard_carton_pcs'};
        $CartonWeightIndex =$col_list->{'carton_weight_actual'};
        $CartonunitIndex =$col_list->{'unit'};

        $CartonLengthIndex =$col_list->{'Carton_length'};
        $CartonWidthIndex =$col_list->{'Carton_width'};
        $CartonHeightIndex =$col_list->{'Carton_height'};
        $CartonDimensionsunitIndex  = $col_list->{'Carton_Dimensions_unit'};

        $HeightIndex = $col_list->{'Product_height'};
        $WidthIndex = $col_list->{'Product_width'};
        $LengthIndex = $col_list->{'Product_length'};
        $LengthunitIndex = $col_list->{'Dimensions_unit'};
        $NetWeightunitIndex = $col_list->{'Net_weight'};
        $GrossweightIndex = $col_list->{'Gross_weight'};
        $WeightunitIndex = $col_list->{'Weight_unit'};
        $Tag1Index = $col_list->{'Search keywords'};
        $artwork_urlIndex = $col_list->{'artwork_url'};
        $DescriptionIndex = $col_list->{'description'};
        $ExclusiveBuyerNameIndex = $col_list->{'Exclusive_Buyer_Name'};
        $Collection_NameIndex = $col_list->{'Theme_Collection_Name'};
        $SeasonMonthIndex = $col_list->{'Season_Month'};
        $vendor_sourced_fromIndex = $col_list->{'Vendor_Sourced_from'};
        $vendor_priceIndex = $col_list->{'Vendor_price'};
        $product_cost_unitIndex = $col_list->{'Product_Cost_Unit'};
        $vendor_currencyIndex = $col_list->{'Vendor_currency'};
        $sourcing_yearIndex = $col_list->{'Sourcing_Year'};
        $VariationAttributesIndex = $col_list->{'Variation attributes'};
        $ProductGroupIdIndex = $col_list->{'Group_ID'};
        $RemarkIndex = $col_list->{'Remarks'};
        $BrandNameIndex = $col_list->{'Brand_Name'};
        $SellingPriceunitIndex = $col_list->{'Selling Price_unit'};
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
                        return back()->with('error',"Sub category is mis-matched with Category at Row $row");
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
                // if (!in_array($temp_item[$ExlusiveIndex],$check_permision_array)) {
                //     return back()->with('error',"you Didn't Fill Exclusive Product Option at Row $row");
                // }
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
                        // return back()->with('error',"Enter valid amount in VIP Price at Row $row");
                    }
                }

                // ` Checking Reseller Price
                if ($temp_item[$ResellerPriceIndex] != null) {
                    if (!is_numeric($temp_item[$ResellerPriceIndex])) {
                        // return back()->with('error',"Enter valid amount in Reseller Price at Row $row");
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
                        array_push($attribute_value,$value);
                    }

                    $receive_data = explode($Array_saprator,$item[$variantion_col_temp]);

                    foreach ($receive_data as $key => $value) {
                        if ($value != '') {
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
                    return back()->with('error',"Sub category Is Mis-matched with Category at Row $row");
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
                                'carton_unit' => $item[$CartonunitIndex],
                                'carton_length' => $item[$CartonLengthIndex],
                                'carton_width' => $item[$CartonWidthIndex],
                                'carton_height' => $item[$CartonHeightIndex],
                                'Carton_Dimensions_unit' => $item[$CartonDimensionsunitIndex],
                            ];
                            $shipping = [
                                'height' => $item[$HeightIndex],
                                'gross_weight' => $item[$GrossweightIndex],
                                'weight' => $item[$NetWeightunitIndex],
                                'width' => $item[$WidthIndex],
                                'length' => $item[$LengthIndex],
                                'unit' => $item[$WeightunitIndex],
                                'length_unit' => $item[$LengthunitIndex],
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
                                'exclusive' => (in_array($item[$ExlusiveIndex],$allowed_array)) ? 1 : 0 ?? 0,
                                'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                                'SellingPriceunitIndex' => $item[$SellingPriceunitIndex] ?? '',
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
                                'carton_unit' => $item[$CartonunitIndex],
                                'carton_length' => $item[$CartonLengthIndex],
                                'carton_width' => $item[$CartonWidthIndex],
                                'carton_height' => $item[$CartonHeightIndex],
                                'Carton_Dimensions_unit' => $item[$CartonDimensionsunitIndex],
                            ];
                            $shipping = [
                                'height' => $item[$HeightIndex],
                                'gross_weight' => $item[$GrossweightIndex],
                                'weight' => $item[$NetWeightunitIndex],
                                'width' => $item[$WidthIndex],
                                'length' => $item[$LengthIndex],
                                'unit' => $item[$WeightunitIndex],
                                'length_unit' => $item[$LengthunitIndex],
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
                                'exclusive' => (in_array($item[$ExlusiveIndex],$allowed_array)) ? 1 : 0 ?? 0,
                                'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                                'SellingPriceunitIndex' => $item[$SellingPriceunitIndex] ?? '',
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
                        'carton_unit' => $item[$CartonunitIndex],
                        'carton_length' => $item[$CartonLengthIndex],
                        'carton_width' => $item[$CartonWidthIndex],
                        'carton_height' => $item[$CartonHeightIndex],
                        'Carton_Dimensions_unit' => $item[$CartonDimensionsunitIndex],
                    ];
                    $shipping = [
                        'height' => $item[$HeightIndex],
                        'gross_weight' => $item[$GrossweightIndex],
                        'weight' => $item[$NetWeightunitIndex],
                        'width' => $item[$WidthIndex],
                        'length' => $item[$LengthIndex],
                        'unit' => $item[$WeightunitIndex],
                        'length_unit' => $item[$LengthunitIndex],
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
                        'exclusive' => (in_array($item[$ExlusiveIndex],$allowed_array)) ? 1 : 0 ?? 0,
                        'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                        'SellingPriceunitIndex' => $item[$SellingPriceunitIndex] ?? '',
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
                                'carton_unit' => $item[$CartonunitIndex],
                                'carton_length' => $item[$CartonLengthIndex],
                                'carton_width' => $item[$CartonWidthIndex],
                                'carton_height' => $item[$CartonHeightIndex],
                                'Carton_Dimensions_unit' => $item[$CartonDimensionsunitIndex],
                            ];
                            $shipping = [
                                'height' => $item[$HeightIndex],
                                'gross_weight' => $item[$GrossweightIndex],
                                'weight' => $item[$NetWeightunitIndex],
                                'width' => $item[$WidthIndex],
                                'length' => $item[$LengthIndex],
                                'unit' => $item[$WeightunitIndex],
                                'length_unit' => $item[$LengthunitIndex],
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
                    'SellingPriceunitIndex' => $item[$SellingPriceunitIndex] ?? '',
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


    // ` Export Excel Sheet for Bulk Upload
    public function ProductSheetExport(Request $request,User $user_id){




        // echo "Working in Progress";
        // return;
        // Fetch All attriubutes
        $default_attribute = (array) json_decode(Setting::where('key','new_bulk_sheet_upload')->first()->value);
        $custom_attributes = (array) json_decode($user_id->custom_attriute_columns) ?? ['Colours','Size','Material'];
        $custom_fields = (array) json_decode($user_id->custom_fields) ?? [];
        $Export_columns = [];
        $fileName = "Exported -".$user_id->name.' - '.date('d-m-Y-h:i A').'.xlsx';

        // Getting sections custom Inputs Columns
        $custom_col1 = [];
        $custom_col4 = [];
        $custom_col5 = [];

        $custom_col_values = [];

        foreach ($custom_fields as $index => $custom_field) {
            if ($custom_field->ref_section == 1) {
                array_push($custom_col1,$custom_field->text);
            }

            if ($custom_field->ref_section == 4) {
                array_push($custom_col4,$custom_field->text);
            }

            if ($custom_field->ref_section == 5) {
                array_push($custom_col5,$custom_field->text);
            }

            if ($custom_field->value != '' && $custom_field->value != null) {
                $tmp_val = [];
                $tmp_val[$custom_field->text] = $custom_field->value;
                if ($tmp_val != '' && $tmp_val != null) {
                    array_push($custom_col_values,$tmp_val);
                }

            }
        }

        $default_attribute['custom_input_1'] = $custom_col1;
        $default_attribute['custom_input_4'] = $custom_col4;
        $default_attribute['custom_input_5'] = $custom_col5;


        foreach ($default_attribute as $key => $valueArr) {
            foreach ($valueArr as $key => $value) {
                array_push($Export_columns,$value);
            }
        }


        // Merging All attributes
        $merged_array = array_merge($Export_columns,$custom_attributes);
        $FirstSheetName = "Entry Sheet";
        $SecondSheetName = "Data Validation Sheet";

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '400M');
        try {

            $spreadsheet = new Spreadsheet();
            $actualWorkSheet = $spreadsheet->getActiveSheet();
            $actualWorkSheet->setTitle($FirstSheetName);

            $actualWorkSheet->getDefaultColumnDimension()->setWidth(20);

            $actualWorkSheet->fromArray($merged_array, null, 'A3');

            $actualWorkSheet->freezePane('B4');


            // Second Worksheet for Dropdown Values
            $dropdownSheet = $spreadsheet->createSheet();
            $dropdownSheet->setTitle($SecondSheetName);
            $dropdownSheet->getDefaultColumnDimension()->setWidth(20);
            $dropdownSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);

            $new_items = ['carton_weight_unit^^system','Weight_unit^^system','carton_weight_unit^^system','Dimensions_unit^^system','Carton_Dimensions_unit^^system','unit^^system','Product_Cost_Unit^^system','Selling_Price_Unit^^system'];

            $custom_attributes = array_merge($custom_attributes,$new_items);

            // return;
            foreach ($custom_attributes as $key => $custom_attribute) {
                $optionsArray = [];
                $index = $key + 1;
                $exploded = explode('^^',$custom_attribute);
                $custom_attribute = $exploded[0];

                if (count($exploded) == 2) {
                    $attribute_values = [];

                    if ($exploded[1] == 'system') {
                        switch ($custom_attribute) {
                            case 'carton_weight_unit':
                            case 'Weight_unit':
                            case 'carton_weight_unit':
                                $attribute_values = getSetting('weight_uom');
                                break;
                            case 'Dimensions_unit':
                            case 'Carton_Dimensions_unit':
                                $attribute_values = getSetting('dimension_uom');
                                break;
                            case 'unit':
                            case 'Product_Cost_Unit':
                            case 'Selling_Price_Unit':
                                $attribute_values = getSetting('item_uom');
                                break;
                            default:
                                $attribute_values = [];
                                break;
                        }
                    }

                    $attribute_values = json_decode($attribute_values);
                }else{
                    $attribute_rec = ProductAttribute::where('name',$custom_attribute)->where('user_id',$user_id->id)->first();
                    if ($attribute_rec == null) {
                        $attribute_rec = ProductAttribute::where('name',$custom_attribute)->where('user_id',null)->first();
                    }

                    if ($attribute_rec == null) {
                        continue;
                    }

                    $attribute_values = ProductAttributeValue::where('parent_id',$attribute_rec->id)->pluck('attribute_value')->toArray();
                }

                $dropdownSheet->setCellValue([$index,'1'],strval($custom_attribute));

                $optionsArray = array_chunk($attribute_values,1);
                $excelColumn = $this->numToExcelColumn($index);
                $startCell = $excelColumn . '2';

                $dropdownSheet->fromArray(
                    $optionsArray,
                    null,
                    $startCell
                );

                $ActualSheetColIndex = array_search($custom_attribute, $merged_array);
                $ActualSheetColIndex = $this->numToExcelColumn($ActualSheetColIndex + 1);

                $validation = new \PhpOffice\PhpSpreadsheet\Cell\DataValidation();
                $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Pick from list or Create');
                $validation->setError('Please pick value from dropdown-list OR In excel, replace cell to enter new value . Before upload on 121, update new value in Custom fields.');
                $validation->setPromptTitle('Pick from list or Create');
                $validation->setPrompt('Please pick value from dropdown-list OR In excel, replace cell to enter new value . Before upload on 121, update new value in Custom fields.');

                // Corrected the formula string
                $validation->setFormula1("'$SecondSheetName'!$" . $excelColumn . "\$2:\$" . $excelColumn . "\$" . (count($attribute_values) + 1 ));


                // Skip Validation for Any value and UOM in Custom Properties
                if ($attribute_rec->value == 'any_value' || $attribute_rec->value == 'uom') {
                    continue;
                }
                // Apply the validation to each cell in the range A1:A100
                for ($i = 1; $i <= 97; $i++) {
                    $cellCoordinate = $ActualSheetColIndex . strval($i + 3);
                    if ($ActualSheetColIndex != 'A') {
                        $actualWorkSheet->getCell($cellCoordinate)->setDataValidation(clone $validation);
                    }
                }
            }


            $ashu_arr_name = [[]];
            foreach ($custom_fields as $key => $custom_field) {
                $optionsArray = [];
                $index = $index + 1;
                $dropdownSheet->setCellValue([$index,'1'],$custom_field->text);

                if ($custom_field->value != '') {


                    $optionsArray = array_chunk(explode(',',$custom_field->value),1);

                    $excelColumn = $this->numToExcelColumn($index);
                    $startCell = $excelColumn . '2';

                    $dropdownSheet->fromArray(
                        $optionsArray,
                        null,
                        $startCell
                    );

                    $ActualSheetColIndex = array_search($custom_field->text, $merged_array);
                    $ActualSheetColIndex = $this->numToExcelColumn($ActualSheetColIndex + 1);

                    $validation->setFormula1("'$SecondSheetName'!$" . $excelColumn . "\$2:\$" . $excelColumn . "\$" . (count($optionsArray) + 1 ));

                    // Apply the validation to each cell in the range A1:A100
                    for ($i = 1; $i <= 100; $i++) {
                        $cellCoordinate = $ActualSheetColIndex . strval($i + 3);
                        // $actualWorkSheet->getCell($cellCoordinate)->setDataValidation(clone $validation);
                        if ($ActualSheetColIndex != 'A') {
                            $actualWorkSheet->getCell($cellCoordinate)->setDataValidation(clone $validation);
                        }
                    }
                }
            }

            // Prepare the response for a downloadable file
            return new StreamedResponse(function () use ($spreadsheet) {
                // Clear the output buffer
                if (ob_get_contents()) ob_end_clean();
                // Write the file to php://output
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            }, 200, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="'.$fileName.'"',
                'Cache-Control' => 'max-age=0'
            ]);

        } catch (Exception $e) {
            $response = ['msg'=> "Error While Creating Excel File.. Try Again Later."];
            return $response;
        }

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

    public function productBulkExport($products,$name = null){
        // return $products;
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '400M');
        try {

            $user_id = auth()->user();
            $FirstSheetName = "Entry Sheet";
            $SecondSheetName = "Data Validation Sheet";
            $withColumnsDropdown = true;
            $custom_attributes = (array) json_decode($user_id->custom_attriute_columns) ?? ['Colours','Size','Material'];

            // -- Add Validation and Dropdown
            if ($withColumnsDropdown == true) {
                $default_attribute = (array) json_decode(Setting::where('key','new_bulk_sheet_upload')->first()->value);
                $custom_attributes = (array) json_decode($user_id->custom_attriute_columns) ?? ['Colours','Size','Material'];
                $custom_fields = (array) json_decode($user_id->custom_fields) ?? [];
                $Export_columns = [];

                // Getting sections custom Inputs Columns
                $custom_col1 = [];
                $custom_col4 = [];
                $custom_col5 = [];

                $custom_col_values = [];

                foreach ($custom_fields as $index => $custom_field) {
                    if ($custom_field->ref_section == 1) {
                        array_push($custom_col1,$custom_field->text);
                    }

                    if ($custom_field->ref_section == 4) {
                        array_push($custom_col4,$custom_field->text);
                    }

                    if ($custom_field->ref_section == 5) {
                        array_push($custom_col5,$custom_field->text);
                    }

                    if ($custom_field->value != '' && $custom_field->value != null) {
                        $tmp_val = [];
                        $tmp_val[$custom_field->text] = $custom_field->value;
                        if ($tmp_val != '' && $tmp_val != null) {
                            array_push($custom_col_values,$tmp_val);
                        }

                    }
                }

                $default_attribute['custom_input_1'] = $custom_col1;
                $default_attribute['custom_input_4'] = $custom_col4;
                $default_attribute['custom_input_5'] = $custom_col5;


                foreach ($default_attribute as $key => $valueArr) {
                    foreach ($valueArr as $key => $value) {
                        array_push($Export_columns,$value);
                    }
                }
                $merged_array = array_merge($Export_columns,$custom_attributes);

            }

            $spreadSheet = new Spreadsheet();
            $actualWorkSheet = $spreadSheet->getActiveSheet();
            $actualWorkSheet->setTitle($FirstSheetName);
            $actualWorkSheet->getDefaultColumnDimension()->setWidth(20);

            $actualWorkSheet->fromArray($products,null,'A3');
            $actualWorkSheet->freezePane('C4');

            // Second Worksheet for Dropdown Values
            $dropdownSheet = $spreadSheet->createSheet();
            $dropdownSheet->setTitle($SecondSheetName);
            $dropdownSheet->getDefaultColumnDimension()->setWidth(20);

            $dropdownSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);

            $new_items = ['carton_weight_unit^^system','Weight_unit^^system','carton_weight_unit^^system','Dimensions_unit^^system','Carton_Dimensions_unit^^system','unit^^system','Product_Cost_Unit^^system','Selling_Price_Unit^^system'];

            $custom_attributes = array_merge($custom_attributes,$new_items);


            foreach ($custom_attributes as $key => $custom_attribute) {
                $optionsArray = [];
                $index = $key + 1;

                $exploded = explode('^^',$custom_attribute);
                $custom_attribute = $exploded[0];
                if (count($exploded) == 2) {
                    $attribute_values = [];

                    if ($exploded[1] == 'system') {
                        switch ($custom_attribute) {
                            case 'carton_weight_unit':
                            case 'Weight_unit':
                            case 'carton_weight_unit':
                                $attribute_values = getSetting('weight_uom');
                                break;
                            case 'Dimensions_unit':
                            case 'Carton_Dimensions_unit':
                                $attribute_values = getSetting('dimension_uom');
                                break;
                            case 'unit':
                            case 'Product_Cost_Unit':
                            case 'Selling_Price_Unit':
                                $attribute_values = getSetting('item_uom');
                                break;
                            default:
                                $attribute_values = [];
                                break;
                        }
                    }

                    $attribute_values = json_decode($attribute_values);
                }else{
                    $attribute_rec = ProductAttribute::where('name',$custom_attribute)->where('user_id',$user_id->id)->first();
                    if ($attribute_rec == null) {
                        $attribute_rec = ProductAttribute::where('name',$custom_attribute)->where('user_id',null)->first();
                    }

                    $attribute_values = ProductAttributeValue::where('parent_id',$attribute_rec->id)->pluck('attribute_value')->toArray();
                }
                $dropdownSheet->setCellValue([$index,'1'],$custom_attribute);
                $optionsArray = array_chunk($attribute_values,1);
                $excelColumn = $this->numToExcelColumn($index);
                $startCell = $excelColumn . '2';

                $dropdownSheet->fromArray(
                    $optionsArray,
                    null,
                    $startCell
                );


                // -- Add Validation and Dropdown
                if ($withColumnsDropdown == true) {
                    $ActualSheetColIndex = array_search($custom_attribute, $merged_array);
                    $ActualSheetColIndex = $this->numToExcelColumn($ActualSheetColIndex);

                    $validation = new \PhpOffice\PhpSpreadsheet\Cell\DataValidation();
                    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Pick from list or Create');
                    $validation->setError('Please pick value from dropdown-list OR In excel, replace cell to enter new value . Before upload on 121, update new value in Custom fields.');
                    $validation->setPromptTitle('Pick from list or Create');
                    $validation->setPrompt('Please pick value from dropdown-list OR In excel, replace cell to enter new value . Before upload on 121, update new value in Custom fields.');

                    // Corrected the formula string
                    $validation->setFormula1("'$SecondSheetName'!$" . $excelColumn . "\$2:\$" . $excelColumn . "\$" . (count($attribute_values) + 1 ));


                    // Skip Validation for Any value and UOM in Custom Properties
                    if ($attribute_rec->value == 'any_value' || $attribute_rec->value == 'uom') {
                        continue;
                    }
                    // Apply the validation to each cell in the range A1:A100
                    $dropdownlength = count($products) - 1 ?? 0;
                    for ($i = 1; $i <= $dropdownlength; $i++) {
                        $cellCoordinate = $ActualSheetColIndex . strval($i + 3);
                        if ($ActualSheetColIndex != 'A' && $ActualSheetColIndex != '') {
                            $actualWorkSheet->getCell($cellCoordinate)->setDataValidation(clone $validation);
                        }
                    }
                }
            }

            $Excel_writer = new Xlsx($spreadSheet);
            $mytime = Carbon::now();

            $user = auth()->user();
            if ($name == null) {
                $fileName = "$user->name Exported Data-".$mytime->toDateTimeString();
            }else{
                $fileName = explode(".",$name)[0];
            }

            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=$fileName.xlsx");
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            throw $e;
            return;

        }
    }

    function exportData(Request $request,User $user_id){


        // magicstring(request()->all());
        // return;
        try {

            if ($request->has('products')) {
                $ids = explode(',',$request->products);
                $products_sku = Product::whereIn('id',$ids)->whereUserId($user_id->id)->pluck('sku');
                $products = Product::whereIn('sku',$products_sku)->get();
            }elseif($request->has('choose_cat_ids')){

                $ids = explode(',',$request->choose_cat_ids);
                $products_sku = Product::whereIn('category_id',$ids)->whereUserId($user_id->id)->pluck('sku');
                $products = Product::whereIn('sku',$products_sku)->get();

            }else{
                $products = Product::whereUserId($user_id->id)->get();
            }
            $mytime = Carbon::now();

            // $filename = "Exported Data -$user_id->name -".$mytime->toDateTimeString();
            $filename = "Exported -".$user_id->name.' - '.date('d-m-Y-h:i A').'.xlsx';


            // * Start: Marging Both Array Custom And Default Attributes
            $default_attribute = (array) json_decode(Setting::where('key','new_bulk_sheet_upload')->first()->value);
            $custom_attributes = (array) json_decode($user_id->custom_attriute_columns) ?? ['Colours','Size','Material'];
            $custom_fields = (array) json_decode($user_id->custom_fields) ?? [];
            $value_to_remove = ['Variation attributes','SKU Type'];
            $custom_fields_Name = [];
            $custom_fields_id = [];

            $delfault_cols = ['id'];
            $col_index =0;

            // Getting sections custom Inputs Columns
            $custom_col1 = [];
            $custom_col4 = [];
            $custom_col5 = [];
            $custom_col_values = [];

            foreach ($custom_fields as $index => $custom_field) {
                if ($custom_field->ref_section == 1) {
                    array_push($custom_col1,$custom_field->text);
                }

                if ($custom_field->ref_section == 4) {
                    array_push($custom_col4,$custom_field->text);
                }

                if ($custom_field->ref_section == 5) {
                    array_push($custom_col5,$custom_field->text);
                }

                array_push($custom_fields_Name,$custom_field->text);
                array_push($custom_fields_id,$custom_field->id);
            }

            $default_attribute['custom_input_1'] = $custom_col1;
            $default_attribute['custom_input_4'] = $custom_col4;
            $default_attribute['custom_input_5'] = $custom_col5;

            foreach ($default_attribute as $key => $valueArr) {
                foreach ($valueArr as $value) {
                    if ($value_to_remove != null && !in_array($value,$value_to_remove)) {
                        array_push($delfault_cols,$value);
                    }
                }
            }

            $delfault_cols = array_merge($delfault_cols,$custom_attributes);
            $merged_array1 = [];

            foreach ($delfault_cols as $key => $cols) {
                $merged_array1[$cols] = $cols;
            }

            $merged_array = [$merged_array1];


            $reseller_group = Group::whereUserId(auth()->id())->where('name',"Reseller")->first();
            $vip_group = Group::whereUserId(auth()->id())->where('name',"VIP")->first();

            foreach($products as $pkey => $product){

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
                    $carton_weight_unit = $carton_details->carton_weight_unit ?? null;
                } else {
                    $carton_details = null ;
                    $standard_carton = null ;
                    $carton_weight = null ;
                    $carton_unit = null ;
                    $carton_length = null;
                    $carton_width =  null;
                    $carton_height = null;
                    $Carton_Dimensions_unit = null;
                    $carton_weight_unit = null;
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


                // Getting Custom Input Values
                $custom_fields_value = [];
                foreach ($custom_fields_Name as $keyIndex => $fields_Name) {
                    $FieldValue = CustomFields::where('product_id',$product->id)->where('relatation_name',$custom_fields_id[$keyIndex])->first();
                    $custom_fields_value[$fields_Name] = $FieldValue->value ?? '';


                    if (is_base64_encoded($FieldValue->value) && is_numeric($FieldValue->value) == false) {

                        $tmp_data = (array) json_decode(base64_decode($FieldValue->value));
                        $tmp_data_l = $tmp_data[0] ?? '';
                        $tmp_data_b = $tmp_data[1] ?? '';
                        $tmp_data_h = $tmp_data[2] ?? '';
                        $tmp_data_u = $tmp_data[3] ?? '';
                        $tmp_data = $tmp_data_l.'x'.$tmp_data_b.'x'.$tmp_data_h.'x'.$tmp_data_u;
                        if ($tmp_data == 'xxx' ) {
                            $tmp_data = '';
                        }

                        $custom_fields_value[$fields_Name] = $tmp_data;
                    }else{
                        $custom_fields_value[$fields_Name] = $FieldValue->value;
                    }
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


                $extraInfoData = ProductExtraInfo::where('product_id',$product->id)->first();
                $custom_attributes_value = [];
                foreach ($custom_attributes as $key => $value) {
                    $attr_info = getAttributeIdByName($value,$user_id->id);
                    if ($attr_info == null) {
                        $attr_info = getAttributeIdByName($value);
                    }
                    $info = ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',$attr_info)->first();
                    if ($info != null) {
                        $custom_attributes_value[$value] = getAttruibuteValueById($info->attribute_value_id)->attribute_value ?? '';
                    }else{
                        $custom_attributes_value[$value] = '';
                    }
                }

                $merged_array2 = [
                    'id' => $product->id,
                    'Model_Code' => $product->model_code,
                    'Product_name' => $product->title ?? "",
                    'Category' => $product->category->name ?? "",
                    'Sub_Category' => $product->subcategory->name ?? "",
                    'Group_ID' => $extraInfoData->Cust_tag_group ?? '',
                    'Base_currency' => $product->base_currency ?? 'INR',
                    'Selling_Price_Unit' => $product->Selling_Price_Unit ?? '',
                    'Customer_Price_without_GST' => $product->price ?? '',
                    'mrpIncl_tax' => $product->mrp,
                    'Brand_Name' => $extraInfoData->brand_name ?? '',
                    'HSN_Code' => $product->hsn,
                    'HSN_Percnt' => $product->hsn_percent,
                    'Search_keywords' => $product->search_keywords ?? '',
                    'description' => $product->description ?? '',
                    'Sample_Year' => $extraInfoData->sample_year ?? '',
                    'Sample_Month' => $extraInfoData->sample_month ?? '',
                    'Sampling_time' => $extraInfoData->sampling_time ?? '',
                    'Exclusive_Buyer_Name' => $extraInfoData->exclusive_buyer_name ?? '',
                    'Theme_Collection_Name' => $extraInfoData->collection_name ?? '',
                    'Season_Month' => $extraInfoData->season_month ?? '',
                    'Theme_Collection_Year' => $extraInfoData->season_year ?? '',
                    // Custom Inputs
                    'Image_main' => isset($product->medias[0]) ? ($product->medias[0]->file_name ?? "") : null,
                    'image_name_front' => isset($product->medias[1]) ? ($product->medias[1]->file_name ?? ""): null,
                    'image_name_back' => isset($product->medias[2]) ? ($product->medias[2]->file_name ?? ""): null,
                    'image_name_side1' => isset($product->medias[3]) ? ($product->medias[3]->file_name ?? ""): null,
                    'image_name_side2' => isset($product->medias[4]) ? ($product->medias[4]->file_name ?? ""): null,
                    'image_name_poster' => isset($product->medias[5]) ? ($product->medias[5]->file_name ?? ""): null,
                    'Additional_Image_Use' => $additional_images ?? '',
                    'Gross_weight' =>  $gross_weight ?? '',
                    'Net_weight' => $weight ?? '',
                    'Weight_unit' => $unit ?? '',
                    'Product_length' => $length ?? '',
                    'Product_width' => $width ?? '',
                    'Product_height' => $height ?? '',
                    'Dimensions_unit' => $length_unit ?? '',
                    'Carton_length' => $carton_length ?? '',
                    'Carton_width' => $carton_width ?? '',
                    'Carton_height' => $carton_height ?? '',
                    'Carton_Dimensions_unit' => $Carton_Dimensions_unit ?? '',
                    'standard_carton_pcs' => $standard_carton ?? '',
                    'carton_weight_actual' => $carton_weight ?? '',
                    'carton_weight_actual' => $carton_weight ?? '',
                    'carton_weight_unit' => $carton_weight_unit ?? '',
                    'unit' => $carton_unit ?? '',
                    'Vendor_Sourced_from' =>  $extraInfoData->vendor_sourced_from ?? '',
                    'Vendor_price' =>  $extraInfoData->vendor_price ?? '',
                    'Product_Cost_unit' =>  $extraInfoData->product_cost_unit ?? '',
                    'Vendor_currency' =>  $extraInfoData->vendor_currency ?? '',
                    'Sourcing_Year' =>  $extraInfoData->sourcing_year ?? '',
                    'Sourcing_month' =>  $extraInfoData->sourcing_month ?? '',
                    'Remarks' =>  $extraInfoData->remarks ?? '',

                    // -- Properties Goes Here....
                ];

                $merged_array2 = array_merge($merged_array2,$custom_fields_value);
                $merged_array2 = array_merge($merged_array2,$custom_attributes_value);


                foreach ($merged_array2 as $keyHeader2 => $header2) {
                    if (in_array($keyHeader2,$delfault_cols)) {
                        $index = array_search($keyHeader2,$delfault_cols);
                        $merged_array[$pkey+1][$index] = $header2;
                    }else{
                        echo "Not Found ".$keyHeader2.newline();
                    }
                    ksort($merged_array[$pkey+1]);
                }
            }

            $this->productBulkExport($merged_array,$filename);

            return back()->with('success',' Export Excel File Successfully.');

        } catch (\Throwable $th) {
            throw $th;
            return back()->with('error','Something Went Wrong.');
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

            $header = array_slice($rows,2)[0];
            $rows = array_slice($rows,3);
            $master = $rows;
            $user = auth()->user();
            $custom_attributes = json_decode($user->custom_attriute_columns);
            $allowArray = ['Yes','yes','YES',1,true,"TRUE","True"];
            $debuging_mode = 0;
            $Array_saprator = "^^";

            // ` Putting up variable in Their Index
            foreach ($header as $index => $columns) {
                ${'col_'.$columns} = $index;
            }


            // ` Validating Loop Start

            foreach ($master as $tmp_key => $tmp_item) {
                $row = $tmp_key + 4;
                // echo "Row No: ".$row.newline();

                if (${'col_Model_Code'} == null) {
                    return back()->with('error',"Model Code Column is Required");
                }

                if (${'col_Product_name'} == null) {
                    return back()->with('error',"Product Name Column is Required");
                }

                if (${'col_Category'} == null) {
                    return back()->with('error',"Category Column is Required");
                }else{
                    $chk = Category::where('name',$tmp_item[${'col_Category'} ])->get();
                    if (count($chk) == 0) {
                        return back()->with('error',"category is not Exist At Row $row");
                    }
                    $categoryID = $chk[0]->id;
                }

                if (${'col_Sub_Category'} == null) {
                    return back()->with('error',"Sub Category Column is Required");
                }else{
                    $chk = Category::where('name',$tmp_item[${'col_Sub_Category'}])->where('parent_id',$categoryID)->get();

                    if (count($chk) == 0) {
                        return back()->with('error',"Sub category is not Exist At Row $row");
                    }
                    $SubCategoryId = $chk[0]->id;
                }


                // ` Getting Custom Attribute

                if ($custom_attributes != null) {
                    foreach ($custom_attributes as $index => $custom_attribute) {

                        // Getting Attribute Records from DB....
                        $attr_Record = getAttributeIdByName($custom_attribute,$user->id,'whole');
                        if ($attr_Record == null) {
                            $attr_Record = getAttributeIdByName($custom_attribute,null,'whole');
                        }

                        if ($attr_Record == null) {
                            return back()->with('error',"Custom Attribute $custom_attribute is not Exist At Row $row");
                        }

                        // Getting Attribute Value Records from DB....
                        $search_value = $tmp_item[${'col_'.$custom_attribute}];

                        // ` Converting Input value to Proper case
                        $search_value = strtolower($search_value);
                        $search_value = ucwords($search_value);

                        if ($search_value != null) {
                            $attr_value_Record = ProductAttributeValue::where('parent_id',$attr_Record->id)->where('attribute_value',$search_value)->first();
                            if ($attr_value_Record == null) {
                                if ($attr_Record->value == 'any_value') {
                                    ProductAttributeValue::create([
                                        'parent_id' => $attr_Record->id,
                                        'user_id' => auth()->id() ?? null,
                                        'attribute_value' => $search_value,
                                    ]);
                                }elseif ($attr_Record->value == 'uom') {
                                    $pattern_without_space = '/^(\d+)\s*X\s*(\w+)$/';
                                    $pattern_decimal_without_space = '/^(\d+(?:\.\d+)?)\s*X\s*(\w+)$/';
                                    $pattern_with_space = '/^(\d+)\s*X\s*(\w+)$/';
                                    $pattern_decimal_with_space = '/^(\d+(?:\.\d+)?)\s*X\s*(\w+)$/';

                                    if (preg_match($pattern_with_space, $search_value) || preg_match($pattern_decimal_with_space, $search_value) ) {
                                        ProductAttributeValue::create([
                                            'parent_id' => $attr_Record->id,
                                            'user_id' => auth()->id() ?? null,
                                            'attribute_value' => $search_value,
                                        ]);
                                    }elseif (preg_match($pattern_without_space, $search_value) || preg_match($pattern_decimal_without_space, $search_value)) {
                                        ProductAttributeValue::create([
                                            'parent_id' => $attr_Record->id,
                                            'user_id' => auth()->id() ?? null,
                                            'attribute_value' => $search_value,
                                        ]);
                                    }
                                    else {
                                        $msg = "The $search_value does not match the pattern. The pattern should be L X unit. In column $attr_Record->name at row $row.";
                                        return back()->with('error',$msg);
                                    }

                                }else{
                                    return back()->with('error',"Custom Attribute Value $search_value is not Exist At Row $row");
                                }



                            }
                        }

                    }
                }
            }


            // magicstring($tmp_item);
            // return;
            // ` Validating Loop End

            // ` Loop For Uploading Data start

            foreach ($master as $key => $item) {
                $row = $key + 4;
                echo "Row No: ".$row.newline();

                // Getting Product Records
                $product = Product::where('id',$item[${'col_id'}])->first();
                // Getting Product Extra Info
                $product_extra_info = ProductExtraInfo::where('product_id',$item[${'col_id'}])->first();
                // Getting Product Custom Fields
                $custom_fields = CustomFields::where('product_id',$item[${'col_id'}])->get();

                // Getting New Category
                $chk = Category::where('name',$item[${'col_Category'} ])->get();
                if (count($chk) == 0) {
                    return back()->with('error',"category is not Exist At Row $row");
                }
                $categoryID = $chk[0]->id;

                $chk = Category::where('name',$item[${'col_Sub_Category'}])->where('parent_id',$categoryID)->get();

                if (count($chk) == 0) {
                    return back()->with('error',"Sub category is not Exist At Row $row");
                }
                $SubCategoryId = $chk[0]->id;

                $carton_details = [
                    'standard_carton' => $item[${'col_standard_carton_pcs'}],
                    'carton_weight' => $item[${'col_carton_weight_actual'}],
                    'carton_unit' => $item[${'col_unit'} ?? ''] ?? '',
                    'carton_length' => $item[${'col_Carton_length'}],
                    'carton_width' => $item[${'col_Carton_width'}],
                    'carton_height' => $item[${'col_Carton_height'}],
                    'Carton_Dimensions_unit' => $item[${'col_Carton_Dimensions_unit'}],
                 ];

                 $shipping = [
                     'height' => $item[${'col_Product_height'}],
                     'gross_weight' => $item[${'col_Gross_weight'}],
                     'weight' => $item[${'col_Net_weight'}],
                     'width' => $item[${'col_Product_width'}],
                     'length' => $item[${'col_Product_length'}],
                     'unit' => $item[${'col_Weight_unit'}],
                     'length_unit' => $item[${'col_Dimensions_unit'}],
                 ];

                //  magicstring($shipping);
                //  return;
                $carton_details = json_encode($carton_details);
                $shipping = json_encode($shipping);

                // ` Extra Info Update
                ProductExtraInfo::where('product_id',$item[${'col_id'}])->update([
                    'allow_resellers' => 'no',
                    'exclusive_buyer_name' => $item[${'col_Exclusive_Buyer_Name'}] ?? '',
                    'collection_name' => $item[${'col_Theme_Collection_Name'}] ?? '',
                    'season_month' => $item[${'col_Season_Month'}] ?? '',
                    'season_year' => $item[${'col_Theme_Collection_Year'}] ?? '',
                    'sample_available' => '0',
                    'sample_year' => $item[${'col_Sample_Year'}] ?? '',
                    'sample_month' => $item[${'col_Sample_Month'}] ?? '',
                    'sampling_time' => $item[${'col_Sampling_time'}] ?? '',
                    'remarks' => $item[${'col_Remarks'}] ?? '',
                    'vendor_sourced_from' => $item[${'col_Vendor_Sourced_from'}] ?? '',
                    'vendor_price' => $item[${'col_Vendor_price'}] ?? '',
                    'product_cost_unit' => $item[${'col_Product_Cost_Unit'}] ?? '',
                    'vendor_currency' => $item[${'col_Vendor_currency'}] ?? '',
                    'sourcing_year' => $item[${'col_Sourcing_Year'}] ?? '',
                    'sourcing_month' => $item[${'col_Sourcing_month'}] ?? '',
                    'brand_name' => $item[${'col_Brand_Name'}] ?? '',
                    'Cust_tag_group' => $item[${'col_Group_ID'}] ?? '',
                ]);


                // ` Getting Custom Attribute   z
                if ($custom_attributes != null) {
                    foreach ($custom_attributes as $index => $custom_attribute) {

                        // Getting Attribute Records from DB....
                        $attr_Record = getAttributeIdByName($custom_attribute,$user->id,'whole');
                        if ($attr_Record == null) {
                            $attr_Record = getAttributeIdByName($custom_attribute,null,'whole');
                        }

                        if ($attr_Record == null) {
                            return back()->with('error',"Custom Attribute $custom_attribute is not Exist At Row $row");
                        }

                        // Getting Attribute Value Records from DB....
                        $search_value = $item[${'col_'.$custom_attribute}];

                        if($search_value != null){
                            // ` Converting Input value to Proper case
                            $search_value = strtolower($search_value);
                            $search_value = ucwords($search_value);

                            echo "Attribute Name: ".$search_value.newline();
                            $checKinG_value = ProductExtraInfo::where('product_id',$item[${'col_id'}])->where('attribute_id',$attr_Record->id)->first();


                            $attribute_value_record = ProductAttributeValue::where('attribute_value',$search_value)->where('parent_id',$attr_Record->id)->first();;

                            if ($checKinG_value == null) {
                                ProductExtraInfo::create([
                                    'product_id' => $item[${'col_id'}],
                                    'attribute_id' => $attr_Record->id,
                                    'attribute_value_id' => $attribute_value_record->id,
                                    'user_id' => auth()->id() ?? null,
                                    'user_shop_id' => getShopDataByUserId(auth()->user()->id)->id ?? null,
                                    'allow_resellers' => 'no',
                                    'exclusive_buyer_name' => $item[${'col_Exclusive_Buyer_Name'}] ?? '',
                                    'collection_name' => $item[${'col_Theme_Collection_Name'}] ?? '',
                                    'season_month' => $item[${'col_Season_Month'}] ?? '',
                                    'season_year' => $item[${'col_Theme_Collection_Year'}] ?? '',
                                    'sample_available' => '0',
                                    'sample_year' => $item[${'col_Sample_Year'}] ?? '',
                                    'sample_month' => $item[${'col_Sample_Month'}] ?? '',
                                    'sampling_time' => $item[${'col_Sampling_time'}] ?? '',
                                    'remarks' => $item[${'col_Remarks'}] ?? '',
                                    'vendor_sourced_from' => $item[${'col_Vendor_Sourced_from'}] ?? '',
                                    'vendor_price' => $item[${'col_Vendor_price'}] ?? '',
                                    'product_cost_unit' => $item[${'col_Product_Cost_Unit'}] ?? '',
                                    'vendor_currency' => $item[${'col_Vendor_currency'}] ?? '',
                                    'sourcing_year' => $item[${'col_Sourcing_Year'}] ?? '',
                                    'sourcing_month' => $item[${'col_Sourcing_month'}] ?? '',
                                    'brand_name' => $item[${'col_Brand_Name'}],
                                    'Cust_tag_group' => $item[${'col_Group_ID'}],
                                ]);
                            }else{
                                $checKinG_value->attribute_id = $attr_Record->id;
                                $checKinG_value->attribute_value_id = $attribute_value_record->id;
                                $checKinG_value->save();
                            }
                        }
                    }
                }

                Product::whereId($item[${'col_id'}])->update(
                [
                    'title' => $item[${'col_Product_name'}] ?? '',
                    'model_code' => $item[${'col_Model_Code'}] ?? '',
                    'category_id' => $categoryID ?? '',
                    'sub_category' => $SubCategoryId ?? '',
                    'description' => $item[${'col_description'}] ?? '',
                    'carton_details' => $carton_details ?? '',
                    'shipping' => $shipping ?? '',
                    'price' =>  $item[${'col_Customer_Price_without_GST'}] ?? '',
                    'min_sell_pr_without_gst' => $item[${'col_Customer_Price_without_GST'}] ?? '',
                    'hsn' => $item[${'col_HSN_Code'}] ?? '',
                    'hsn_percent' => $item[${'col_HSN_Percnt'}] ?? '',
                    'mrp' => $item[${'col_mrpIncl_tax'}] ?? '',
                    'search_keywords' => $item[${'col_Search_keywords'}] ?? '',
                    'exclusive' => 0,
                    'base_currency' =>  $item[${'col_Base_currency'}] ?? '',
                    'Selling_Price_Unit' => $item[${'col_Selling_Price_Unit'}] ?? '',
                ]);


                $usi = UserShopItem::whereUserId(auth()->id())->where('product_id',$item[${'col_id'}])->first();
                $reseller_group = Group::whereUserId(auth()->id())->where('name',"Reseller")->first();
                $vip_group = Group::whereUserId(auth()->id())->where('name',"VIP")->first();
                $reseller_group_product = GroupProduct::where('group_id',$reseller_group->id ?? 0)->where('product_id',$item[${'col_id'}])->first();
                $vip_group_product = GroupProduct::where('group_id',$vip_group->id??0)->where('product_id',$item[${'col_id'}])->first();
                $chk_inventroy = Inventory::where('product_id',$item[${'col_id'}])->where('user_id',auth()->id())->get();
                if($usi){
                    $usi->is_published = 1;
                    $usi->price = $item[${'col_Customer_Price_without_GST'}];
                    $usi->category_id = $categoryID;
                    $usi->sub_category_id = $SubCategoryId;
                    $usi->save();
                }

                if($reseller_group_product){
                    $reseller_group_product->price = $item[${'col_mrpIncl_tax'}] ?? 0;
                    $reseller_group_product->save();
                }
                if($vip_group_product){
                    $vip_group_product->price = $item[${'col_mrpIncl_tax'}] ?? 0;
                    $vip_group_product->save();
                }
                $product_obj = Product::whereId($item[${'col_id'}])->first();
                if(isset($product_obj->medias[0]) && $product_obj->medias[0]->id){
                    Media::whereId($product_obj->medias[0]->id)->update([
                        'file_name' => $item[${'col_Image_main'}],
                        'path' => "storage/files/".auth()->id()."/".$item[${'col_Image_main'}]
                    ]);
                }else{
                    if(isset($item[${'col_Image_main'}])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $item[${'col_Image_main'}];
                        $media->path = "storage/files/".auth()->id()."/".$item[${'col_Image_main'}];
                        $media->extension = explode('.',$item[${'col_Image_main'}])[1] ?? '';
                        $media->save();
                    }
                }



                if(isset($product_obj->medias[1]) && $product_obj->medias[1]->id){
                    Media::whereId($product_obj->medias[1]->id)->update([
                        'file_name' => $item[${'col_image_name_front'}],
                        'path' => "storage/files/".auth()->id()."/".$item[${'col_image_name_front'}]
                    ]);
                }else{
                    if(isset($item[${'col_image_name_front'}])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $item[${'col_image_name_front'}];
                        $media->path = "storage/files/".auth()->id()."/".$item[${'col_image_name_front'}];
                        $media->extension = explode('.',$item[${'col_image_name_front'}])[1] ?? '';
                        $media->save();
                    }
                }

                if(isset($product_obj->medias[2]) && $product_obj->medias[2]->id){
                    Media::whereId($product_obj->medias[2]->id)->update([
                        'file_name' => $item[${'col_image_name_back'}],
                        'path' => "storage/files/".auth()->id()."/".$item[${'col_image_name_back'}]
                    ]);
                }else{
                    if(isset($item[${'col_image_name_back'}])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $item[${'col_image_name_back'}];
                        $media->path = "storage/files/".auth()->id()."/".$item[${'col_image_name_back'}];
                        $media->extension = explode('.',$item[${'col_image_name_back'}])[1] ?? '';
                        $media->save();
                    }
                }


                if(isset($product_obj->medias[3]) && $product_obj->medias[3]->id){
                    Media::whereId($product_obj->medias[3]->id)->update([
                        'file_name' => $item[${'col_image_name_side1'}],
                        'path' => "storage/files/".auth()->id()."/".$item[${'col_image_name_side1'}]
                    ]);
                }else{
                    if(isset($item[${'col_image_name_side1'}])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $item[${'col_image_name_side1'}];
                        $media->path = "storage/files/".auth()->id()."/".$item[${'col_image_name_side1'}];
                        $media->extension = explode('.',$item[${'col_image_name_side1'}])[1] ?? '';
                        $media->save();
                    }
                }



                // image_name_side2
                if(isset($product_obj->medias[3]) && $product_obj->medias[3]->id){
                    Media::whereId($product_obj->medias[3]->id)->update([
                        'file_name' => $item[${'col_image_name_side2'}],
                        'path' => "storage/files/".auth()->id()."/".$item[${'col_image_name_side2'}]
                    ]);
                }else{
                    if(isset($item[${'col_image_name_side2'}])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $item[${'col_image_name_side2'}];
                        $media->path = "storage/files/".auth()->id()."/".$item[${'col_image_name_side2'}];
                        $media->extension = explode('.',$item[${'col_image_name_side2'}])[1] ?? '';
                        $media->save();
                    }
                }

                // image_name_poster
                if(isset($product_obj->medias[3]) && $product_obj->medias[3]->id){
                    Media::whereId($product_obj->medias[3]->id)->update([
                        'file_name' => $item[${'col_image_name_poster'}],
                        'path' => "storage/files/".auth()->id()."/".$item[${'col_image_name_poster'}]
                    ]);
                }else{
                    if(isset($item[${'col_image_name_poster'}])){
                        $media = new Media();
                        $media->tag = "Product_Image";
                        $media->file_type = "Image";
                        $media->type = "Product";
                        $media->type_id = $product_obj->id;
                        $media->file_name = $item[${'col_image_name_poster'}];
                        $media->path = "storage/files/".auth()->id()."/".$item[${'col_image_name_poster'}];
                        $media->extension = explode('.',$item[${'col_image_name_poster'}])[1] ?? '';
                        $media->save();
                    }
                }

                if ($item[${'col_Additional_Image_Use'}]) {
                    foreach (explode("^^",$item[${'col_Additional_Image_Use'}]) as $key => $value) {
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

            // ` Loop For Uploading Data End
        } catch (\Throwable $th) {
            throw $th;
            return back()->with("error","Something Went Wrong");
        }

    }


    // Custom Fields Export Data
    public function exportDataCustom(Request $request,User $user_id) {

        $validated = $request->validate([
            'template_name' => 'required',
        ]);


        try {
            $request['finaldata'] = array_merge($request->get('systemfiels'),$request->get('myfields') ?? []);
            magicstring($request->all());
            $user_shop = getShopDataByUserId($user_id->id);
            $templatename =$request->get('template_name');
            $mytime = Carbon::now();

            $filename = "$templatename -$user_id->name -".$mytime->toDateTimeString();

            Usertemplates::create([
                'user_id' => $user_id->id,
                'user_shop_id' => $user_shop->id,
                'columns_values' => json_encode($request->finaldata),
                'template_name' => $templatename,
            ]);

            $this->exportExcel($request->finaldata,$filename);

            return back()->with('success',"File Download Success Fully..");
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('error',"There Was an Error Try Again later !!");
        }
    }


    // ` For Uploaded New Custom Excel Data
    public function UploadDataCustom(Request $request,User $user_id) {
        try {


            if (!$request->hasFile('uploadcustomfield')) {
                return back()->with('error',"Please Select Upload File");
            }

            $user_shop = UserShop::where('user_id',$user_id->id)->first();
            $Array_saprator = "^^";
            $count = 0;
            $SampleMinYear = 1985;
            $SampleMaxYear = Carbon::now()->format('Y');
            $check_permision_array = ['yes','no',"Yes","No","YES","NO",'0','1'];
            $allowed_array = ['yes',"Yes","YES",'1'];
            $Months_array = ['January', 'February', 'March', 'April', 'May','June', 'July', 'August', 'September', 'October', 'November','December', 'january','february','march','april','may','june','july','august','september','october','november','december'];
            $common_field = ['Colour','Size','Mateial'];
            $custom_attriute_columns = json_decode($user_id->custom_attriute_columns);
            $selected_custom_attribute = [];

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->uploadcustomfield);
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
            $with_header = array_slice($rows,2);
            $rows = array_slice($rows,3);
            $master = $rows;


            magicstring($with_header[0]);
            // Creating Variables
            foreach ($with_header[0] as $key => $value) {
                ${"$value"} = $key;
            }

            $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
            if ($highestRow > 100) {
                if ($highestRow > 100) {
                    return back()->with('error', "Please upload 100 rows at a time. Found $highestRow rows. No products created.");
                }
            }


            // @ Validating Loop
            foreach ($master as $tmp_key => $tmp_item) {
                    $row = $tmp_key+4;
                    // magicstring($tmp_item);

                    if (isset(${'Model_Code'})) {
                        if ($tmp_item[${'Model_Code'}] == null) {
                                return back()->with('error',"ModelCode Cannot be Blank At Row $row");
                            }
                        // ` Checking Model Code
                        if ($tmp_item[${'Model_Code'}] != null && $tmp_item[${'Model_Code'}] != "") {
                            // Checking Group Id..
                            $checkSKU = Product::where('model_code',$tmp_item[${'Model_Code'}])->where('user_id',auth()->id())->first();
                            if (empty($checkSKU)) {
                                // Group Id not Match with User
                                // Todo: Do Nothing
                            } elseif ($checkSKU->user_id != auth()->id()) {
                                // No Record found In product Need to Created New.!!
                                return back()->with('error',"Group Id Didn't Match!!");
                            } elseif ($checkSKU->user_id == auth()->id()) {
                                // Get Product and User id is Matched
                                $GroupId = $checkSKU->sku;
                            } else {
                                echo "Something Went Wrong!!";
                                return;
                            }
                        } else {
                            return back()->with('error',"Model Code Should Require Add That Field at Row $row.");
                        }
                }


                // -- Checking Product Name is null or Not
                if (isset(${'Product_name'})) {
                    // if ($tmp_item[${'Product_name'}] == null) {
                    //     return back()->with('error',"Product Name Cannot be Blank At Row $row");
                    // }
                }

                // checking Category
                if (isset(${'Category'})) {
                    if ($tmp_item[${'Category'}] == null) {
                        return back()->with('error',"Category Is Blank at Row $row");
                    }else{
                        $chk = Category::where('name',$tmp_item[${'Category'}])->where('category_type_id',13)->get();
                        if (count($chk) > 0) {
                            $Category_id = $chk[0]->id;
                        }else{
                            return back()->with('error',"Category is Not Exist at Row $row");
                        }
                    }
                }else{
                    return back()->with('error',"Category Should Require Add That Field.");
                }

                // checking Category
                if (isset(${'Sub_Category'})) {
                    if ($tmp_item[${'Sub_Category'}] == null) {
                        return back()->with('error',"Sub Category Is Blank at Row $row");
                    }else{
                        $chk = Category::where('name',$tmp_item[${'Sub_Category'}])->where('parent_id',$Category_id)->where('user_id',auth()->id())->orwhere('user_id',null)->get();

                        if ($chk->count() == 0) {
                            return back()->with('error',"Sub category Is Mis-matched with Category at Row $row");
                        }
                        $sub_category_id = $chk[0]->id;
                    }
                }else{
                    return back()->with('error',"Sub category Should Require Add That Field.");
                }

                // ` Checking Currency
                if (isset(${'Base_currency'})) {
                    if ($tmp_item[${'Base_currency'}] == null) {
                        $Currency = 'INR';
                    }else{
                        $chk = Country::where('currency',$tmp_item[${'Base_currency'}])->get();
                        if (count($chk) > 0) {
                            // echo "We Have ... $tmp_item[${'Base_currency'}] <br>";
                            $Currency = $tmp_item[${'Base_currency'}];
                        }else{
                            return back()->with('error',"That Currency is not Available at Row $row");
                        }
                    }
                }else{
                    // return back()->with('error',"CategSub category Should Require Add That Field.");
                    $Currency = 'INR';
                }


                // ` Checking Allow Reseller Input
                if (isset(${'Allow_Resellers'})) {
                    if (!in_array($tmp_item[${'Allow_Resellers'}],$check_permision_array)) {
                        return back()->with('error',"The Value is not Matched in Allow Reseller at Row $row");
                    }
                }else{
                    // return back()->with('error',"CategSub category Should Require Add That Field.");
                }

                // ` Checking Exclusive Product
                // if (isset(${'Copyright/ Exclusive item'})) {
                //     if (!in_array($tmp_item[${'Copyright/ Exclusive item'}],$check_permision_array)) {
                //         return back()->with('error',"you Didn't Fill Exclusive Product Option at Row $row");
                //     }
                // }else{
                //     // return back()->with('error',"CategSub category Should Require Add That Field.");
                // }

                // ` Checking Sample Stock Available

                if (isset(${'Sample / Stock available'})) {
                    if (!in_array($tmp_item[${'Sample / Stock available'}],$check_permision_array)) {
                        $tmp_item[${'Sample / Stock available'}] = 'No';
                    }else{
                        $tmp_item[${'Sample / Stock available'}] = 'Yes';
                    }
                }else{
                    // return back()->with('error',"CategSub category Should Require Add That Field.");
                }

                // ` Checking Selling Price_unit
                // if (isset(${'Selling_Price_Unit'})) {
                //     // ` Checking Customer Price
                //     if ($tmp_item[${'Selling_Price_Unit'}] != null) {
                //         if (!is_numeric($tmp_item[${'Selling_Price_Unit'}])){
                //             return back()->with('error',"Enter valid amount in Customer Price at Row $row");
                //         }
                //     }
                // }

                // ` Checking Customer_Price_without_GST
                if (isset(${'Customer_Price_without_GST'})) {
                    // ` Checking Customer Price
                    if ($tmp_item[${'Customer_Price_without_GST'}] != null) {
                        if (!is_numeric($tmp_item[${'Customer_Price_without_GST'}])){
                            return back()->with('error',"Enter valid amount in Customer Price without GST at Row $row");
                        }
                    }
                }

                // ` Checking Shop_Price_VIP_Customer
                if (isset(${'Shop_Price_VIP_Customer'})) {
                    // ` Checking Customer Price
                    if ($tmp_item[${'Shop_Price_VIP_Customer'}] != null) {
                        if (!is_numeric($tmp_item[${'Shop_Price_VIP_Customer'}])){
                            // return back()->with('error',"Enter valid amount in Shop VIP Customer Price at Row $row");
                            $Shop_Price_VIP_Customer = 0;
                        }
                    }
                }else{
                    $Shop_Price_VIP_Customer = 0;
                }

                // ` Checking Shop_Price_Reseller
                if (isset(${'Shop_Price_Reseller'})) {
                    // ` Checking Customer Price
                    if ($tmp_item[${'Shop_Price_Reseller'}] != null) {
                        if (!is_numeric($tmp_item[${'Shop_Price_Reseller'}])){
                            // return back()->with('error',"Enter valid amount in Shop Price Reseller at Row $row");
                            $Shop_Price_Reseller = 0;
                        }
                    }
                }else{
                    $Shop_Price_Reseller = 0;
                }

                // ` Checking mrpIncl tax
                if (isset(${'mrpIncl_tax'})) {
                    // ` Checking Customer Price
                    if ($tmp_item[${'mrpIncl_tax'}] != null) {
                        if (!is_numeric($tmp_item[${'mrpIncl_tax'}])){
                            return back()->with('error',"Enter valid amount in MRP Incl. tax Reseller at Row $row");
                        }
                        $mrp = $tmp_item[${'mrpIncl_tax'}];
                    }
                }else{
                    $mrp = 0;
                }


                // ` Checking HSN Tax
                if (isset(${'HSN_Code'})) {
                    // ` Checking Customer Price
                    if ($tmp_item[${'HSN_Code'}] != null) {
                        if (!is_numeric($tmp_item[${'HSN_Code'}])){
                            return back()->with('error',"Enter valid amount HSN Tax Reseller at Row $row");
                        }
                    }
                }

                // ` Checking HSN_Percnt
                if (isset(${'HSN_Percnt'})) {
                    // ` Checking Customer Price
                    if ($tmp_item[${'HSN_Percnt'}] != null) {
                        if (!is_numeric($tmp_item[${'HSN_Percnt'}])){
                            return back()->with('error',"Enter valid amount in HSN_Percnt Reseller at Row $row");
                        }
                    }
                }


                // ` Checking Theme / COllection Year...
                if (isset(${'Theme_Collection_Year'})) {
                    if ($tmp_item[${'Theme_Collection_Year'}] != null) {
                        if ($tmp_item[${'Theme_Collection_Year'}] >= $SampleMinYear && $tmp_item[${'Theme_Collection_Year'}] <= $SampleMaxYear) {
                            // echo "Between Theme Collection Range..".newline(5);
                        }else{
                            return back()->with('error',"Enter valid Theme / Collection Year at Row $row");
                        }
                    }
                }

                // ` Checking Sourcing Year...
                if (isset(${'Sourcing_Year'})) {
                    if ($tmp_item[${'Sourcing_Year'}] != null) {
                        if ($tmp_item[${'Sourcing_Year'}] >= $SampleMinYear && $tmp_item[${'Sourcing_Year'}] <= $SampleMaxYear) {
                            // echo "Between Theme Collection Range..".newline(5);
                        }else{
                            return back()->with('error',"Enter valid Sourcing Year at Row $row");
                        }
                    }
                }

                // ` Checking Sample Year...
                if (isset(${'Sample_Year'})) {
                    if ($tmp_item[${'Sample_Year'}] != null) {
                        if ($tmp_item[${'Sample_Year'}] >= $SampleMinYear && $tmp_item[${'Sample_Year'}] <= $SampleMaxYear) {
                            // echo "Between Theme Collection Range..".newline(5);
                        }else{
                            return back()->with('error',"Enter valid Sample Year at Row $row");
                        }
                    }
                }

                // ` Checking Sample Month...
                if (isset(${'Sample_Month'})) {
                    if ($tmp_item[${'Sample_Month'}] != null) {
                        if (!in_array($tmp_item[${'Sample_Month'}],$Months_array)) {
                            return back()->with('error',"Enter Valid Month in Sampling month at Row $row");
                        }
                    }
                }


                // ` Checking Season / Month...
                if (isset(${'Season_Month'})) {
                    if ($tmp_item[${'Season_Month'}] != null) {
                        if (!in_array($tmp_item[${'Season_Month'}],$Months_array)) {
                            return back()->with('error',"Enter Valid Month in Season / Month at Row $row");
                        }
                    }
                }


                // ` Checking Sourcing month...
                if (isset(${'Sourcing_month'})) {
                    if ($tmp_item[${'Sourcing_month'}] != null) {
                        if (!in_array($tmp_item[${'Sourcing_month'}],$Months_array)) {
                            return back()->with('error',"Enter Valid Month in Sourcing month at Row $row");
                        }
                    }
                }

                // ` Checking CBM
                if (isset(${'CBM'})) {
                    // ` Checking Customer Price
                    if ($tmp_item[${'CBM'}] != null) {
                        if (!is_numeric($tmp_item[${'CBM'}])){
                            return back()->with('error',"Enter valid CBM at Row $row");
                        }
                    }
                }


                // ` Checking Production time (days)
                if (isset(${'Production time (days)'})) {
                    // ` Checking Customer Price
                    if ($tmp_item[${'Production time (days)'}] != null) {
                        if (!is_numeric($tmp_item[${'Production time (days)'}])){
                            return back()->with('error',"Enter valid Production time (days) at Row $row");
                        }
                    }
                }

                // ` Checking MBQ
                if (isset(${'MBQ'})) {
                    // ` Checking Customer Price
                    if ($tmp_item[${'MBQ'}] != null) {
                        if (!is_numeric($tmp_item[${'MBQ'}])){
                            return back()->with('error',"Enter valid MBQ at Row $row");
                        }
                    }
                }

                // ` Checking MBQ_units
                if (isset(${'MBQ_units'})) {
                    // ` Checking Customer Price
                    if ($tmp_item[${'MBQ_units'}] != null) {
                        if (!is_numeric($tmp_item[${'MBQ_units'}])){
                            return back()->with('error',"Enter valid MBQ_units at Row $row");
                        }
                    }
                }

                // ` Getting Selected Variation Name (Values) and Columns (Key)
                foreach ($with_header[0] as $col => $item) {
                    if (in_array($item,$custom_attriute_columns)) {
                        $selected_custom_attribute[$col] = $item;
                    }
                }

                // ` Checking Up Values of Attribute Variation Column
                if (isset(${'Variation attributes'})) {

                    $receive_data = explode($Array_saprator,$tmp_item[${'Variation attributes'}]);

                    // * Checking Define Attribute Exist in Their Account Or Not
                    if ($tmp_item[${'Variation attributes'}] != null || $tmp_item[${'Variation attributes'}] != '') {
                        foreach ($receive_data as $datakey => $data) {
                            if (!in_array($data,$custom_attriute_columns)) {
                                return back()->with('error',"$data is Not Exist in Your Account at Row $row, Tmp");
                            }
                        }

                        // * Checking Define Attribute Exist in Upload file
                        foreach ($receive_data as $datakey => $data) {
                            if (!in_array($data,$selected_custom_attribute)) {
                                return back()->with('error',"$data is Not Exist in Excel at Row $row");
                            }
                        }

                    }


                    $variation_count = ($receive_data != null) ? count($receive_data) : 0;
                    if ($variation_count > 3) {
                        return back()->with('error',"You Have More Than 3 Varient At Row $row. You Only Have 3 at a Row");
                    }

                }else{
                    return back()->with('error',"Variation attributes Column is Required for Upload In Excel.");
                }



                // ` Checking Extra Image
                // if (isset(${'Additional_Image_Use'})) {
                //     if ($temp_item[${'Additional_Image_Use'}] != null) {
                //         $ProductextraImages = explode($Array_saprator,$temp_item[${'Additional_Image_Use'}]);
                //     }else{
                //         $ProductextraImages = null;
                //     }
                // }
                $ProductextraImages = null;


                // ` Checking Up Values of Attributes Column (::All::)
                foreach ($selected_custom_attribute as $tmp_col => $attribute_name) {

                    $receive_data = explode($Array_saprator,$tmp_item[$tmp_col]);


                    foreach ($receive_data as $gkey => $gvalue) {
                        $attribute_data_default = ProductAttribute::where('name',$attribute_name)->where('user_id',null)->first();
                        $attribute_data_custom = ProductAttribute::where('name',$attribute_name)->where('user_id',$user_id->id)->first();

                        if ($attribute_data_default != null) {
                            $attribute_data = $attribute_data_default;
                        }else{
                            $attribute_data = $attribute_data_custom;
                        }


                        $attribute_value_obj = ProductAttributeValue::where('parent_id',$attribute_data->id)->pluck('attribute_value');
                        $attribute_value = [];



                        foreach ($attribute_value_obj as $key => $value) {
                            $value = strtolower($value);
                            $value = ucwords($value);
                            array_push($attribute_value,trim($value));
                        }

                        // ` Converting Input value to Proper case
                        $gvalue = strtolower($gvalue);
                        $gvalue = ucwords($gvalue);

                        // ! checking Value Exist in Records or Not
                        if ($gvalue != '') {
                            if (!in_array($gvalue,$attribute_value,true)) {


                                if ($attribute_data->value == 'any_value') {
                                    magicstring($gvalue);
                                    ProductAttributeValue::create([
                                        'parent_id' => $attribute_data->id,
                                        'user_id' => auth()->id() ?? null,
                                        'attribute_value' => $gvalue,
                                    ]);
                                }elseif ($attribute_data->value == 'uom') {
                                    $pattern_without_space = '/^(\d+)\s*X\s*(\w+)$/';
                                    $pattern_decimal_without_space = '/^(\d+(?:\.\d+)?)\s*X\s*(\w+)$/';
                                    $pattern_with_space = '/^(\d+)\s*X\s*(\w+)$/';
                                    $pattern_decimal_with_space = '/^(\d+(?:\.\d+)?)\s*X\s*(\w+)$/';


                                    if (preg_match($pattern_with_space, $gvalue) || preg_match($pattern_decimal_with_space, $gvalue) ) {
                                        ProductAttributeValue::create([
                                            'parent_id' => $attribute_data->id,
                                            'user_id' => auth()->id() ?? null,
                                            'attribute_value' => $gvalue,
                                        ]);
                                    }elseif (preg_match($pattern_without_space, $gvalue) || preg_match($pattern_decimal_without_space, $gvalue)) {
                                        ProductAttributeValue::create([
                                            'parent_id' => $attribute_data->id,
                                            'user_id' => auth()->id() ?? null,
                                            'attribute_value' => $gvalue,
                                        ]);
                                    }
                                    else {
                                        $msg = "The $gvalue does not match the pattern. The pattern should be L X unit. In column $attribute_data->name at row $row.";
                                        return back()->with('error',$msg);
                                    }
                                }else{
                                    return back()->with('error',"$gvalue Not Exist in column $attribute_data->name At Row $row");
                                }
                            }
                        }






                    }
                }

            }



                // echo "Hello ";
                // return;
            // @ End of Validating Loop


            $modalArray = [];
            $SKUArray = [];
            $debuging_mode = 0;

            // ! Main For Uploading Data Start
                foreach ($master as $index => $item) {
                    $variationType_array =[];
                    $row = $index + 4;
                    $myTmp_array = [];
                    $Productids_array = [];

                    // ` Checking Up Values of Attribute Variation Column
                    if (isset(${'Variation attributes'})) {

                        $variationType_array = explode($Array_saprator,$item[${'Variation attributes'}]);

                        // * Checking Define Attribute Exist in Their Account Or Not
                        if ($item[${'Variation attributes'}] != null || $item[${'Variation attributes'}] != '') {
                            foreach ($variationType_array as $datakey => $data) {
                                if (!in_array($data,$custom_attriute_columns)) {
                                    return back()->with('error',"$data is Not Exist in Your Account at Row $row");
                                }
                            }

                            // * Checking Define Attribute Exist in Upload file
                            foreach ($variationType_array as $datakey => $data) {
                                if (!in_array($data,$selected_custom_attribute)) {
                                    return back()->with('error',"$data is Not Exist in Excel at Row $row");
                                }
                            }
                        }
                        $variation_count = ($variationType_array != null) ? count($variationType_array) : 0;


                    }else{
                        return back()->with('error',"Variation attributes Column is Required for Upload In Excel.");
                    }


                    // ` Checking Up Values of Attributes Column (::All::)
                    foreach ($selected_custom_attribute as $tmp_col => $attribute_name) {

                        $receive_data = explode($Array_saprator,$item[$tmp_col]);

                        foreach ($receive_data as $gkey => $gvalue) {
                            $attribute_data_default = ProductAttribute::where('name',$attribute_name)->where('user_id',null)->first();
                            $attribute_data_custom = ProductAttribute::where('name',$attribute_name)->where('user_id',$user_id->id)->first();

                            if ($attribute_data_default != null) {
                                $attribute_data = $attribute_data_default;
                            }else{
                                $attribute_data = $attribute_data_custom;
                            }

                            $attribute_value_obj = ProductAttributeValue::where('parent_id',$attribute_data->id)->pluck('attribute_value');
                            $attribute_value = [];

                            foreach ($attribute_value_obj as $key => $value) {
                                $value = strtolower($value);
                                $value = ucwords($value);
                                array_push($attribute_value,trim($value));
                            }

                            // ` Converting Input value to Proper case
                            $gvalue = strtolower($gvalue);
                            $gvalue = ucwords($gvalue);

                            // ! checking Value Exist in Records or Not
                            if ($gvalue != '') {
                                if (!in_array($gvalue,$attribute_value,true)) {
                                    return back()->with('error',"$gvalue Not Exist in column $attribute_data->name At Row $row");
                                }
                            }

                        }
                    }


                    if (isset(${'Video URL'})) {
                        $video_url = $item[${'Video URL'}] ?? '';
                    }else{
                        $video_url = '';
                    }

                    if (isset(${'Allow_Resellers'})) {
                        // $Allow_Resellers = $item[${'Allow_Resellers'}];
                        $Allow_Resellers = 'No';
                    }else{
                        $Allow_Resellers = 'No';
                    }


                    if (isset(${'Search_keywords'})) {
                        $search_keywords = $item[${'Search_keywords'}];
                    }else{
                        $search_keywords = '';
                    }


                    if (isset(${'Copyright/ Exclusive item'})) {
                        $exclusive_item = $item[${'Copyright/ Exclusive item'}] ?? 0;
                    }else{
                        $exclusive_item = 'No';
                    }

                    if (isset(${'Selling_Price_Unit'})) {
                        $SellingPrice_unit = $item[${'Selling_Price_Unit'}];
                    }else{
                        $SellingPrice_unit = '';
                    }



                    // * CREATING loop1,loop2 and loop3
                    if ($item[${'Variation attributes'}] != null) {
                        foreach ($variationType_array as $variation) {

                            $tmp_colindex = ${$variation};

                            $user_custom_col_list = $custom_attriute_columns;

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
                            $tmp_colindex = ${$variationType_array[0]};
                            $loop1 = explode($Array_saprator,$item[$tmp_colindex]) ?? [];
                        }else{
                            $loop1 = [];
                        }


                        if (isset($variationType_array[1])) {
                            $tmp_colindex = ${$variationType_array[1]};
                            $loop2 = explode($Array_saprator,$item[$tmp_colindex]) ?? [];
                        }else{
                            $loop2 = [];
                        }

                        if (isset($variationType_array[2])) {
                            $tmp_colindex = ${$variationType_array[2]};
                            $loop3 = explode($Array_saprator,$item[$tmp_colindex]) ?? [];
                        }else{
                            $loop3 = [];
                        }
                    }else{
                        $loop1 = [];
                        $loop2 = [];
                        $loop3 = [];
                        $variationType_array = [];
                    }


                    // ` Exploding Additional Images
                    if (isset(${'Additional_Image_Use'})) {
                        if ($item[${'Additional_Image_Use'}] != null) {
                            $ProductextraImages = explode($Array_saprator,$item[${'Additional_Image_Use'}]);
                        }else{
                            $ProductextraImages = null;
                        }
                    }



                    //` checking Category
                    if (isset(${'Category'})) {
                        if ($item[${'Category'}] == null) {
                            return back()->with('error',"Category Is Blank at Row $row");
                        }else{
                            $chk = Category::where('name',$item[${'Category'}])->where('category_type_id',13)->get();
                            if (count($chk) > 0) {
                                $Category_id = $chk[0]->id;
                            }else{
                                return back()->with('error',"Category is Not Exist at Row $row");
                            }
                        }
                    }else{
                        return back()->with('error',"Category Should Require Add That Field.");
                    }


                      // checking Category
                        if (isset(${'Sub_Category'})) {
                            if ($item[${'Sub_Category'}] == null) {
                                return back()->with('error',"Sub Category Is Blank at Row $row");
                            }else{
                                $chk = Category::where('name',$tmp_item[${'Sub_Category'}])->where('parent_id',$Category_id)->where('user_id',auth()->id())->orwhere('user_id',null)->get();

                                if ($chk->count() == 0) {
                                    return back()->with('error',"Sub category Is Mis-matched with Category at Row $row");
                                }

                                $sub_category_id = $chk[0]->id;
                            }
                        }else{
                            return back()->with('error',"Sub category Should Require Add That Field.");
                        }



                    // //` checking Category
                    // if (isset(${'Sub_Category'})) {
                    //     if ($item[${'Sub_Category'}] == null) {
                    //         return back()->with('error',"Sub Category Is Blank at Row $row");
                    //     }else{
                    //         $chk = Category::where('name',$item[${'Sub_Category'}])->where('parent_id',$Category_id)->get();
                    //         if (!count($chk) > 0) {
                    //             return back()->with('error',"Sub category Is Mis-matched with Category at Row $row");
                    //         }
                    //         $sub_category_id = $chk[0]->id;
                    //     }
                    // }else{
                    //     return back()->with('error',"Sub category Should Require Add That Field.");
                    // }


                    // ` Checking Currency
                    if (isset(${'Base_currency'})) {
                        if ($item[${'Base_currency'}] == null) {
                            $Currency = 'INR';
                        }else{
                            $chk = Country::where('currency',$item[${'Base_currency'}])->get();
                            if (count($chk) > 0) {
                                // echo "We Have ... $item[${'Base_currency'}] <br>";
                                $Currency = $item[${'Base_currency'}];
                            }else{
                                return back()->with('error',"That Currency is not Available at Row $row");
                            }
                        }
                    }else{
                        // return back()->with('error',"CategSub category Should Require Add That Field.");
                        $Currency = 'INR';
                    }



                    $Productids_array = [];
                    $CREATED_PRODUUCT_ID = [];
                    $CREATED_PRODUUCT_ID_2 = [];
                    $user = $user_id;

                    $Productids_array = [];



                    if($loop1 != [] && $loop2 != [] && $loop3 != []) {
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
                                    if ($item[${'Model_Code'}] == null && $item[${'Model_Code'}] == "") {
                                        $sku_code = 'SKU'.generateRandomStringNative(6);
                                        $item[${'Model_Code'}] = $sku_code;
                                    }elseif (isset($GroupId)) {
                                        $sku_code = $GroupId;
                                    }
                                    else{
                                        $sku_code = 'SKU'.generateRandomStringNative(6);
                                    }
                                    if (in_array($item[${'Model_Code'}],$modalArray)) {
                                        // echo "Yes Bro!";
                                        $sku_code = $SKUArray[array_search($item[${'Model_Code'}],$modalArray)];
                                    }else{
                                        array_push($modalArray,$item[${'Model_Code'}]);
                                        array_push($SKUArray,$sku_code);
                                    }
                                    $unique_slug  = getUniqueProductSlug($item[${'Product_name'}]);
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
                                        'standard_carton' => (isset(${'standard_carton_pcs'})) ? $item[${'standard_carton_pcs'}] : '',
                                        'carton_weight' => (isset(${'carton_weight_actual'})) ? $item[${'carton_weight_actual'}] : '',
                                        'carton_unit' => (isset(${'unit'})) ? $item[${'unit'}] : '',
                                        'carton_length' => (isset(${'Carton_length'})) ? $item[${'Carton_length'}] : '',
                                        'carton_width' => (isset(${'Carton_width'})) ? $item[${'Carton_width'}] : '',
                                        'carton_height' => (isset(${'Carton_height'})) ? $item[${'Carton_height'}] : '',
                                        'Carton_Dimensions_unit' => (isset(${'Carton_Dimensions_unit'})) ? $item[${'Carton_Dimensions_unit'}] : '',
                                    ];

                                    $shipping = [
                                        'height' => (isset(${'Product_height'})) ? $item[${'Product_height'}] : '',
                                        'gross_weight' =>(isset(${'Gross_weight'})) ? $item[${'Gross_weight'}] : '',
                                        'weight' => (isset(${'Net_weight'})) ? $item[${'Net_weight'}] : '',
                                        'width' => (isset(${'Product_width'})) ? $item[${'Product_width'}] : '',
                                        'length' => (isset(${'Product_length'})) ? $item[${'Product_length'}] : '',
                                        'unit' => (isset(${'Weight_unit'})) ? $item[${'Weight_unit'}] : '',
                                        'length_unit' => (isset(${'Dimensions_unit'})) ? $item[${'Dimensions_unit'}] : '',
                                    ];

                                    $carton_details = json_encode($carton_details);
                                    $shipping = json_encode($shipping);


                                    echo $first." - ".$second." - ".$third.newline();


                                    $price = ($product_exist != null && $item[${'Customer_Price_without_GST'}] == '') ? $product_exist->price : trim($item[${'Customer_Price_without_GST'}]);


                                    $product_obj =  [
                                        'title' => ($product_exist != null && $item[${'Product_name'}] == null) ? $product_exist->title : $item[${'Product_name'}],
                                        'model_code' => ($product_exist != null && $item[${'Model_Code'}] == null) ? $product_exist->model_code : $item[${'Model_Code'}],
                                        'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                                        'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                                        'brand_id' => ($product_exist != null) ? $product_exist->brand_id : 0,
                                        'user_id' => $user->id,
                                        'sku' => $sku_code,
                                        'slug' => $unique_slug,
                                        'description' => ($product_exist != null && $item[${'description'}] == '') ? $product_exist->description : $item[${'description'}],
                                        'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                                        'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                                        'manage_inventory' =>  0,
                                        'stock_qty' => 0,
                                        'status' => 0,
                                        // 'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                                        'is_publish' => 1,
                                        'price' => $price ?? 0,
                                        'min_sell_pr_without_gst' => ($product_exist != null && $item[${'Customer_Price_without_GST'}] == '') ? $product_exist->min_sell_pr_without_gst : $item[${'Customer_Price_without_GST'}],
                                        'hsn' => ($product_exist != null && $item[${'HSN_Code'}] == '') ? $product_exist->hsn : $item[${'HSN_Code'}] ?? null,
                                        'hsn_percent' => ($product_exist != null && $item[${'HSN_Percnt'}] == '') ? $product_exist->hsn_percent : $item[${'HSN_Percnt'}] ?? null,
                                        'mrp' => ($product_exist != null && $item[${'mrpIncl_tax'}] == '') ? $product_exist->mrp : trim($item[${'mrpIncl_tax'}]),
                                        'video_url' => ($product_exist != null && $item[${'Video URL'}] == '') ? $product_exist->video_url : $item[${'Video URL'}],
                                        'search_keywords' => ($product_exist != null && $item[${'Search_keywords'}] == '') ? $product_exist->tag1 : $item[${'Search_keywords'}],
                                        'artwork_url' => $item[${'artwork_url'}] ?? null,
                                        'exclusive' => (in_array($item[${'Copyright/ Exclusive item'}],$allowed_array)) ? 1 : 0 ?? 0,
                                        'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                                        'SellingPriceunitIndex' => $item[${'Selling_Price_Unit'}] ?? '',
                                        // 'archive' => (in_array($item[$ArchiveIndex],$allowed_array)) ? 1 : 0,
                                    ];

                                    $product_obj = Product::create($product_obj);
                                    $custom_fields = json_decode($user->custom_fields) ?? [];
                                    // if ($custom_fields != null && count( (array) $custom_fields) > 0) {
                                    //     foreach ($custom_fields as $key => $customfield) {

                                    //         $ogname = $customfield->id;
                                    //         // $customfieldID = str_replace("[]",'',$customfield->id);
                                    //         $customfieldID = $tmp_item[${"$customfield->text"}] ?? '';

                                    //         if (is_array($request->get($customfieldID)) || is_html($request->get($customfieldID))) {
                                    //             echo "' $ogname ' It is an Array or HTML.".newline();
                                    //             $updatevalue = base64_encode(json_encode($customfieldID));
                                    //         }else{
                                    //             // $customfield = str_replace("[]",'',$customfield);
                                    //             $updatevalue = $customfieldID;
                                    //         }

                                    //         $custom_field = CustomFields::where('relatation_name',$ogname)->where('product_id',$product->id)->first();

                                    //         if ($custom_field == null) {
                                    //             echo "Create New Records".newline(2);
                                    //             CustomFields::create([
                                    //                 'relatation_name' => $ogname,
                                    //                 'product_id' => $product_obj->id,
                                    //                 'value' => $updatevalue ?? '',
                                    //                 'user_id' => auth()->id(),
                                    //             ]);
                                    //         }else{
                                    //             echo "Record Are Exist Update It".newline(2);

                                    //             $custom_field->update([
                                    //                 'value' => $updatevalue ?? '',
                                    //             ]);
                                    //         }
                                    //     }
                                    // }

                                    if ($custom_fields != null && count( (array) $custom_fields) > 0) {
                                        foreach ($custom_fields as $key => $customfield) {

                                            $ogname = $customfield->id;
                                            if (!isset(${"$customfield->text"})) {
                                                continue;
                                            }
                                            // $customfieldID = str_replace("[]",'',$customfield->id);
                                            $customfieldID = $item[${"$customfield->text"}] ?? '';

                                            // [length] => 10
                                            // [width] => 50
                                            // [height] => 30
                                            // [unit] => mm


                                            if ($customfield->type == 'diamension') {
                                                $lenarr = explode('x',$customfieldID);
                                                if (count($lenarr) <= 1) {
                                                    $lenarr = explode('X',$customfieldID);
                                                }
                                                $request[$customfieldID] = [
                                                    'length' => $lenarr[0] ?? '',
                                                    'width' => $lenarr[1] ?? '',
                                                    'height' => $lenarr[2] ?? '',
                                                    'unit' => $lenarr[3] ??'',
                                                ];
                                                // $request[$customfieldID]
                                            }

                                            if ($customfield->type == 'uom') {
                                                $lenarr = explode('x',$customfieldID);
                                                if (count($lenarr) <= 1) {
                                                    $lenarr = explode('X',$customfieldID);
                                                }
                                                $request[$customfieldID] = [
                                                    'measument' => $lenarr[0] ?? '',
                                                    'unit' => $lenarr[3] ??'',
                                                ];
                                                // $request[$customfieldID]
                                            }

                                            // magicstring($request->get($customfieldID));
                                            // continue;


                                            if (is_array($request->get($customfieldID)) || is_html($request->get($customfieldID))) {
                                                echo "' $ogname ' It is an Array or HTML.".newline();

                                                $updatevalue = base64_encode(json_encode($request->get($customfieldID)));
                                            }else{
                                                // $customfield = str_replace("[]",'',$customfield);
                                                $updatevalue = $customfieldID;
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
                                            'allow_resellers' => $Allow_Resellers,
                                            'exclusive_buyer_name' => $item[${'Exclusive_Buyer_Name'}],
                                            'collection_name' => $item[${'Theme_Collection_Name'}],
                                            'season_month' => $item[${'Season_Month'}],
                                            'season_year' => $item[${'Theme_Collection_Year'}],
                                            'sample_year' => $item[${'Sample_Year'}],
                                            'sample_month' => $item[${'Sample_Month'}],
                                            'sampling_time' => $item[${'Sampling_time'}],
                                            'CBM' => '',
                                            'production_time' =>'',
                                            'MBQ' => '',
                                            'MBQ_unit' => '',
                                            'vendor_sourced_from' => $item[${'Vendor_Sourced_from'}],
                                            'vendor_price' => $item[${'Vendor_price'}],
                                            'product_cost_unit' => $item[${'Product_Cost_Unit'}],
                                            'vendor_currency' => $item[${'Vendor_currency'}],
                                            'sourcing_year' => $item[${'Sourcing_Year'}],
                                            'sourcing_month' => $item[${'Sourcing_month'}],
                                            'attribute_value_id' => $product_att_val->id,
                                            'attribute_id' => $product_att_val->parent_id,
                                            // 'attribute_value_id' => $product_att_val->attribute_value,
                                            // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                            'group_id' => $sku_code,
                                            'Cust_tag_group' =>$item[${'Group_ID'}],
                                            'remarks' => $item[${'Remarks'}] ?? '' ,
                                            'brand_name' => $item[${'Brand_Name'}],
                                        ];

                                        ProductExtraInfo::create($product_extra_info_obj_user);
                                    }

                                    echo "Selected In Excel File";
                                    magicstring($selected_custom_attribute);

                                    echo "Selected In Variation Column";
                                    magicstring($variationType_array);

                                    // MAking Not Define Attribute
                                    if (count($selected_custom_attribute) != count($variationType_array)) {
                                        foreach ($selected_custom_attribute as $chkkey => $checkval) {
                                            if (!in_array($checkval,$variationType_array)) {
                                                $tmp_col = ${$checkval};
                                                $attribute_default = ProductAttribute::where('name',$checkval)->where('user_id',null)->pluck('id');
                                                $attribute_custom = ProductAttribute::where('name',$checkval)->where('user_id',$user->id)->pluck('id');

                                                if (count($attribute_default) == 0 ) {
                                                    $attribute = $attribute_custom;
                                                }else{
                                                    $attribute = $attribute_default;
                                                }

                                                $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$item[$tmp_col])->first();

                                                $checkval = strtolower($checkval);
                                                $checkval = ucwords($checkval);

                                                if ($product_att_val != null) {

                                                    $product_extra_info_obj_user = [
                                                        'product_id' => $product_obj->id,
                                                        'user_id' => $user->id,
                                                        'user_shop_id' => $user_shop->id,
                                                        'allow_resellers' => $Allow_Resellers,
                                                        'exclusive_buyer_name' => $item[${'Exclusive_Buyer_Name'}],
                                                        'collection_name' => $item[${'Theme_Collection_Name'}],
                                                        'season_month' => $item[${'Season_Month'}],
                                                        'season_year' => $item[${'Theme_Collection_Year'}],
                                                        'sample_year' => $item[${'Sample_Year'}],
                                                        'sample_month' => $item[${'Sample_Month'}],
                                                        'sampling_time' => $item[${'Sampling_time'}],
                                                        'CBM' => '',
                                                        'production_time' =>'',
                                                        'MBQ' => '',
                                                        'MBQ_unit' => '',
                                                        'vendor_sourced_from' => $item[${'Vendor_Sourced_from'}],
                                                        'vendor_price' => $item[${'Vendor_price'}],
                                                        'product_cost_unit' => $item[${'Product_Cost_Unit'}],
                                                        'vendor_currency' => $item[${'Vendor_currency'}],
                                                        'sourcing_year' => $item[${'Sourcing_Year'}],
                                                        'sourcing_month' => $item[${'Sourcing_month'}],
                                                        'attribute_value_id' => $product_att_val->id,
                                                        'attribute_id' => $product_att_val->parent_id,
                                                        // 'attribute_value_id' => $product_att_val->attribute_value,
                                                        // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                                        'group_id' => $sku_code,
                                                        'Cust_tag_group' =>$item[${'Group_ID'}],
                                                        'remarks' => $item[${'Remarks'}] ?? '' ,
                                                        'brand_name' => $item[${'Brand_Name'}],
                                                    ];
                                                    ProductExtraInfo::create($product_extra_info_obj_user);
                                                }
                                            } // If End
                                        } // Loop End
                                    } // If End

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
                                            'price'=> $Shop_Price_Reseller,
                                        ]);
                                    }

                                    if($vip_group){
                                        // create Vip Group record
                                        GroupProduct::create([
                                            'group_id'=>$vip_group->id,
                                            'product_id'=>$product_obj->id,
                                            'price'=>  $Shop_Price_VIP_Customer,
                                        ]);
                                    }
                                    $arr_images = [];
                                    // * Start Creating Media...

                                    if (isset(${'Image_main'})) {
                                        if(isset($item[${'Image_main'}]) && $item[${'Image_main'}] != null){
                                            $media = new Media();
                                            $media->tag = "Product_Image";
                                            $media->file_type = "Image";
                                            $media->type = "Product";
                                            $media->type_id = $product_obj->id;
                                            $media->file_name = $item[${'Image_main'}];
                                            $media->path = "storage/files/".auth()->id()."/".$item[${'Image_main'}];
                                            $media->extension = explode('.',$item[${'Image_main'}])[1] ?? '';
                                            $media->save();
                                            $arr_images[] = $media->id;
                                        }
                                    }

                                    if (isset(${'image_name_front'}) ) {
                                        if($item[${'image_name_front'}] != null){
                                            $media = new Media();
                                            $media->tag = "Product_Image";
                                            $media->file_type = "Image";
                                            $media->type = "Product";
                                            $media->type_id = $product_obj->id;
                                            $media->file_name = $item[${'image_name_front'}];
                                            $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_front'}];
                                            $media->extension = explode('.',$item[${'image_name_front'}])[1] ?? '';
                                            $media->save();
                                            $arr_images[] = $media->id;
                                        }
                                    }

                                    if (isset(${'image_name_back'})) {
                                        if(isset($item[${'image_name_back'}]) && $item[${'image_name_back'}] != null){
                                            $media = new Media();
                                            $media->tag = "Product_Image";
                                            $media->file_type = "Image";
                                            $media->type = "Product";
                                            $media->type_id = $product_obj->id;
                                            $media->file_name = $item[${'image_name_back'}];
                                            $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_back'}];
                                            $media->extension = explode('.',$item[${'image_name_back'}])[1] ?? '';
                                            $media->save();
                                            $arr_images[] = $media->id;
                                        }
                                    }


                                    if (isset(${'image_name_side1'})) {
                                        if(isset($item[${'image_name_side1'}]) && $item[${'image_name_side1'}] != null){
                                            $media = new Media();
                                            $media->tag = "Product_Image";
                                            $media->file_type = "Image";
                                            $media->type = "Product";
                                            $media->type_id = $product_obj->id;
                                            $media->file_name = $item[${'image_name_side1'}];
                                            $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_side1'}];
                                            $media->extension = explode('.',$item[${'image_name_side1'}])[1] ?? '';
                                            $media->save();
                                            $arr_images[] = $media->id;
                                        }
                                    }


                                    if (isset(${'image_name_side2'})) {
                                        if(isset($item[${'image_name_side2'}]) && $item[${'image_name_side2'}] != null){
                                            $media = new Media();
                                            $media->tag = "Product_Image";
                                            $media->file_type = "Image";
                                            $media->type = "Product";
                                            $media->type_id = $product_obj->id;
                                            $media->file_name = $item[${'image_name_side2'}];
                                            $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_side2'}];
                                            $media->extension = explode('.',$item[${'image_name_side2'}])[1] ?? '';
                                            $media->save();
                                            $arr_images[] = $media->id;
                                        }
                                    }



                                    if (isset(${'image_name_poster'})) {
                                        if(isset($item[${'image_name_poster'}]) && $item[${'image_name_poster'}] != null){
                                            $media = new Media();
                                            $media->tag = "Product_Image";
                                            $media->file_type = "Image";
                                            $media->type = "Product";
                                            $media->type_id = $product_obj->id;
                                            $media->file_name = $item[${'image_name_poster'}];
                                            $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_poster'}];
                                            $media->extension = explode('.',$item[${'image_name_poster'}])[1] ?? '';
                                            $media->save();
                                            $arr_images[] = $media->id;
                                        }
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
                                    // // Add images to UserShopItem
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
                                            'allow_resellers' => $Allow_Resellers,
                                            'exclusive_buyer_name' => $item[${'Exclusive_Buyer_Name'}],
                                            'collection_name' => $item[${'Theme_Collection_Name'}],
                                            'season_month' => $item[${'Season_Month'}],
                                            'season_year' => $item[${'Theme_Collection_Year'}],
                                            'sample_available' => 0,
                                            'sample_year' => $item[${'Sample_Year'}],
                                            'sample_month' => $item[${'Sample_Month'}],
                                            'sampling_time' => $item[${'Sampling_time'}],
                                            'CBM' => '',
                                            'production_time' =>'',
                                            'MBQ' => '',
                                            'MBQ_unit' => '',
                                            'vendor_sourced_from' => $item[${'Vendor_Sourced_from'}],
                                            'vendor_price' => $item[${'Vendor_price'}],
                                            'product_cost_unit' => $item[${'Product_Cost_Unit'}],
                                            'vendor_currency' => $item[${'Vendor_currency'}],
                                            'sourcing_year' => $item[${'Sourcing_Year'}],
                                            'sourcing_month' => $item[${'Sourcing_month'}],
                                            'attribute_value_id' => $product_att_val->id,
                                            'attribute_id' => $product_att_val->parent_id,
                                            // 'attribute_value_id' => $product_att_val->attribute_value,
                                            // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                            'group_id' => $sku_code,
                                            'Cust_tag_group' =>$item[${'Group_ID'}],
                                            'remarks' => $item[${'Remarks'}] ?? '' ,
                                            'brand_name' => $item[${'Brand_Name'}],
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
                                        'allow_resellers' => $Allow_Resellers,
                                        'exclusive_buyer_name' => $item[${'Exclusive_Buyer_Name'}],
                                        'collection_name' => $item[${'Theme_Collection_Name'}],
                                        'season_month' => $item[${'Season_Month'}],
                                        'season_year' => $item[${'Theme_Collection_Year'}],
                                        'sample_available' => 0,
                                        'sample_year' => $item[${"Sample Year"}],
                                        'sample_month' => $item[${'Sample_Month'}],
                                        'sampling_time' => $item[${'Sampling_time'}],
                                        'CBM' => '',
                                        'production_time' =>'',
                                        'MBQ' => '',
                                        'MBQ_unit' => '',
                                        'vendor_sourced_from' => $item[${'Vendor_Sourced_from'}],
                                        'vendor_price' => $item[${'Vendor_price'}],
                                        'product_cost_unit' => $item[${'Product_Cost_Unit'}],
                                        'vendor_currency' => $item[${'Vendor_currency'}],
                                        'sourcing_year' => $item[${'Sourcing_Year'}],
                                        'sourcing_month' => $item[${'Sourcing_month'}],
                                        'attribute_value_id' => $product_att_val->id,
                                        'attribute_id' => $product_att_val->parent_id,
                                        // 'attribute_value_id' => $product_att_val->attribute_value,
                                        // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                        'group_id' => $sku_code,
                                        'Cust_tag_group' =>$item[${'Group_ID'}],
                                        'remarks' => $item[${'Remarks'}] ?? '' ,
                                        'brand_name' => $item[${'Brand_Name'}],
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
                        foreach ($loop1 as $key1 => $second) {
                            $Productids_array = [];

                            foreach ($loop2 as $key3 => $third) {
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
                                if ($item[${'Model_Code'}] == null && $item[${'Model_Code'}] == "") {
                                    $sku_code = 'SKU'.generateRandomStringNative(6);
                                    $item[${'Model_Code'}] = $sku_code;
                                }elseif (isset($GroupId)) {
                                    $sku_code = $GroupId;
                                }
                                else{
                                    $sku_code = 'SKU'.generateRandomStringNative(6);
                                }
                                if (in_array($item[${'Model_Code'}],$modalArray)) {
                                    // echo "Yes Bro!";
                                    $sku_code = $SKUArray[array_search($item[${'Model_Code'}],$modalArray)];
                                }else{
                                    array_push($modalArray,$item[${'Model_Code'}]);
                                    array_push($SKUArray,$sku_code);
                                }
                                $unique_slug  = getUniqueProductSlug($item[${'Product_name'}]);
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
                                    'standard_carton' => (isset(${'standard_carton_pcs'})) ? $item[${'standard_carton_pcs'}] : '',
                                    'carton_weight' => (isset(${'carton_weight_actual'})) ? $item[${'carton_weight_actual'}] : '',
                                    'carton_unit' => (isset(${'unit'})) ? $item[${'unit'}] : '',
                                    'carton_length' => (isset(${'Carton_length'})) ? $item[${'Carton_length'}] : '',
                                    'carton_width' => (isset(${'Carton_width'})) ? $item[${'Carton_width'}] : '',
                                    'carton_height' => (isset(${'Carton_height'})) ? $item[${'Carton_height'}] : '',
                                    'Carton_Dimensions_unit' => (isset(${'Carton_Dimensions_unit'})) ? $item[${'Carton_Dimensions_unit'}] : '',
                                ];

                                $shipping = [
                                    'height' => (isset(${'Product_height'})) ? $item[${'Product_height'}] : '',
                                    'gross_weight' =>(isset(${'Gross_weight'})) ? $item[${'Gross_weight'}] : '',
                                    'weight' => (isset(${'Net_weight'})) ? $item[${'Net_weight'}] : '',
                                    'width' => (isset(${'Product_width'})) ? $item[${'Product_width'}] : '',
                                    'length' => (isset(${'Product_length'})) ? $item[${'Product_length'}] : '',
                                    'unit' => (isset(${'Weight_unit'})) ? $item[${'Weight_unit'}] : '',
                                    'length_unit' => (isset(${'Dimensions_unit'})) ? $item[${'Dimensions_unit'}] : '',
                                ];

                                $carton_details = json_encode($carton_details);
                                $shipping = json_encode($shipping);


                                // echo $first." - ".$second." - ".$third.newline();


                                $price = ($product_exist != null && $item[${'Customer_Price_without_GST'}] == '') ? $product_exist->price : trim($item[${'Customer_Price_without_GST'}]);


                                $product_obj =  [
                                    'title' => ($product_exist != null && $item[${'Product_name'}] == null) ? $product_exist->title : $item[${'Product_name'}],
                                    'model_code' => ($product_exist != null && $item[${'Model_Code'}] == null) ? $product_exist->model_code : $item[${'Model_Code'}],
                                    'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                                    'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                                    'brand_id' => ($product_exist != null) ? $product_exist->brand_id : 0,
                                    'user_id' => $user->id,
                                    'sku' => $sku_code,
                                    'slug' => $unique_slug,
                                    'description' => ($product_exist != null && $item[${'description'}] == '') ? $product_exist->description : $item[${'description'}],
                                    'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                                    'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                                    'manage_inventory' =>  0,
                                    'stock_qty' => 0,
                                    'status' => 0,
                                    // 'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                                    'is_publish' => 1,
                                    'price' => $price ?? 0,
                                    'min_sell_pr_without_gst' => ($product_exist != null && $item[${'Customer_Price_without_GST'}] == '') ? $product_exist->min_sell_pr_without_gst : $item[${'Customer_Price_without_GST'}],
                                    'hsn' => ($product_exist != null && $item[${'HSN_Code'}] == '') ? $product_exist->hsn : $item[${'HSN_Code'}] ?? null,
                                    'hsn_percent' => ($product_exist != null && $item[${'HSN_Percnt'}] == '') ? $product_exist->hsn_percent : $item[${'HSN_Percnt'}] ?? null,

                                    'mrp' => ($product_exist != null && $mrp == '') ? $product_exist->mrp : trim($mrp),
                                    'video_url' => ($product_exist != null && $video_url == '') ? $product_exist->video_url : $video_url,

                                    'search_keywords' => ($product_exist != null && $search_keywords == '') ? $product_exist->tag1 : $search_keywords,
                                    'artwork_url' => $artwork_url ?? null,
                                    'exclusive' => (in_array($exclusive_item,$allowed_array)) ? 1 : 0,
                                    'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                                    'SellingPriceunitIndex' => $SellingPrice_unit ?? '',
                                    // 'archive' => (in_array($item[$ArchiveIndex],$allowed_array)) ? 1 : 0,
                                ];

                                $product_obj = Product::create($product_obj);
                                $custom_fields = json_decode($user->custom_fields) ?? [];
                                // if ($custom_fields != null && count( (array) $custom_fields) > 0) {
                                //     foreach ($custom_fields as $key => $customfield) {

                                //         $ogname = $customfield->id;
                                //         // $customfieldID = str_replace("[]",'',$customfield->id);
                                //         $customfieldID = $tmp_item[${"$customfield->text"}] ?? '';

                                //         if (is_array($request->get($customfieldID)) || is_html($request->get($customfieldID))) {
                                //             echo "' $ogname ' It is an Array or HTML.".newline();
                                //             $updatevalue = base64_encode(json_encode($customfieldID));
                                //         }else{
                                //             // $customfield = str_replace("[]",'',$customfield);
                                //             $updatevalue = $customfieldID;
                                //         }

                                //         $custom_field = CustomFields::where('relatation_name',$ogname)->where('product_id',$product->id)->first();
                                //         if ($custom_field == null) {
                                //             echo "Create New Records".newline(2);
                                //             CustomFields::create([
                                //                 'relatation_name' => $ogname,
                                //                 'product_id' => $product_obj->id,
                                //                 'value' => $updatevalue ?? '',
                                //                 'user_id' => auth()->id(),
                                //             ]);
                                //         }else{
                                //             echo "Record Are Exist Update It".newline(2);

                                //             $custom_field->update([
                                //                 'value' => $updatevalue ?? '',
                                //             ]);
                                //         }
                                //     }
                                // }

                                if ($custom_fields != null && count( (array) $custom_fields) > 0) {
                                    foreach ($custom_fields as $key => $customfield) {

                                        $ogname = $customfield->id;
                                        // $customfieldID = str_replace("[]",'',$customfield->id);
                                        if (!isset(${"$customfield->text"})) {
                                            continue;
                                        }
                                        $customfieldID = $item[${"$customfield->text"}] ?? '';

                                        // [length] => 10
                                        // [width] => 50
                                        // [height] => 30
                                        // [unit] => mm


                                        if ($customfield->type == 'diamension') {
                                            $lenarr = explode('x',$customfieldID);
                                            if (count($lenarr) <= 1) {
                                                $lenarr = explode('X',$customfieldID);
                                            }
                                            $request[$customfieldID] = [
                                                'length' => $lenarr[0] ?? '',
                                                'width' => $lenarr[1] ?? '',
                                                'height' => $lenarr[2] ?? '',
                                                'unit' => $lenarr[3] ??'',
                                            ];
                                            // $request[$customfieldID]
                                        }

                                        if ($customfield->type == 'uom') {
                                            $lenarr = explode('x',$customfieldID);
                                            if (count($lenarr) <= 1) {
                                                $lenarr = explode('X',$customfieldID);
                                            }
                                            $request[$customfieldID] = [
                                                'measument' => $lenarr[0] ?? '',
                                                'unit' => $lenarr[3] ??'',
                                            ];
                                            // $request[$customfieldID]
                                        }

                                        // magicstring($request->get($customfieldID));
                                        // continue;


                                        if (is_array($request->get($customfieldID)) || is_html($request->get($customfieldID))) {
                                            echo "' $ogname ' It is an Array or HTML.".newline();

                                            $updatevalue = base64_encode(json_encode($request->get($customfieldID)));
                                        }else{
                                            // $customfield = str_replace("[]",'',$customfield);
                                            $updatevalue = $customfieldID;
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
                                        'allow_resellers' => $Allow_Resellers ?? 'No',
                                        'exclusive_buyer_name' => $item[${'Exclusive_Buyer_Name'}],
                                        'collection_name' => $item[${'Theme_Collection_Name'}],
                                        'season_month' => $item[${'Season_Month'}],
                                        'season_year' => $item[${'Theme_Collection_Year'}],
                                        'sample_year' => $item[${'Sample_Year'}],
                                        'sample_month' => $item[${'Sample_Month'}],
                                        'sampling_time' => $item[${'Sampling_time'}],
                                        'CBM' => '',
                                        'production_time' =>'',
                                        'MBQ' => '',
                                        'MBQ_unit' => '',
                                        'vendor_sourced_from' => $item[${'Vendor_Sourced_from'}],
                                        'vendor_price' => $item[${'Vendor_price'}],
                                        'product_cost_unit' => $item[${'Product_Cost_Unit'}],
                                        'vendor_currency' => $item[${'Vendor_currency'}],
                                        'sourcing_year' => $item[${'Sourcing_Year'}],
                                        'sourcing_month' => $item[${'Sourcing_month'}],
                                        'attribute_value_id' => $product_att_val->id,
                                        'attribute_id' => $product_att_val->parent_id,
                                        // 'attribute_value_id' => $product_att_val->attribute_value,
                                        // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                        'group_id' => $sku_code,
                                        'Cust_tag_group' =>$item[${'Group_ID'}],
                                        'remarks' => $item[${'Remarks'}] ?? '' ,
                                        'brand_name' => $item[${'Brand_Name'}],
                                    ];

                                    ProductExtraInfo::create($product_extra_info_obj_user);
                                }

                                echo "Selected In Excel File";
                                magicstring($selected_custom_attribute);

                                echo "Selected In Variation Column";
                                magicstring($variationType_array);

                                if (count($selected_custom_attribute) != count($variationType_array)) {
                                    foreach ($selected_custom_attribute as $chkkey => $checkval) {
                                        if (!in_array($checkval,$variationType_array)) {
                                            $tmp_col = ${$checkval};
                                            $attribute_default = ProductAttribute::where('name',$checkval)->where('user_id',null)->pluck('id');
                                            $attribute_custom = ProductAttribute::where('name',$checkval)->where('user_id',$user->id)->pluck('id');

                                            if (count($attribute_default) == 0 ) {
                                                $attribute = $attribute_custom;
                                            }else{
                                                $attribute = $attribute_default;
                                            }

                                            $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$item[$tmp_col])->first();

                                            $checkval = strtolower($checkval);
                                            $checkval = ucwords($checkval);

                                            if ($product_att_val != null) {

                                                $product_extra_info_obj_user = [
                                                    'product_id' => $product_obj->id,
                                                    'user_id' => $user->id,
                                                    'user_shop_id' => $user_shop->id,
                                                    'allow_resellers' => $Allow_Resellers,
                                                    'exclusive_buyer_name' => $item[${'Exclusive_Buyer_Name'}],
                                                    'collection_name' => $item[${'Theme_Collection_Name'}],
                                                    'season_month' => $item[${'Season_Month'}],
                                                    'season_year' => $item[${'Theme_Collection_Year'}],
                                                    'sample_year' => $item[${'Sample_Year'}],
                                                    'sample_month' => $item[${'Sample_Month'}],
                                                    'sampling_time' => $item[${'Sampling_time'}],
                                                    'CBM' => '',
                                                    'production_time' =>'',
                                                    'MBQ' => '',
                                                    'MBQ_unit' => '',
                                                    'vendor_sourced_from' => $item[${'Vendor_Sourced_from'}],
                                                    'vendor_price' => $item[${'Vendor_price'}],
                                                    'product_cost_unit' => $item[${'Product_Cost_Unit'}],
                                                    'vendor_currency' => $item[${'Vendor_currency'}],
                                                    'sourcing_year' => $item[${'Sourcing_Year'}],
                                                    'sourcing_month' => $item[${'Sourcing_month'}],
                                                    'attribute_value_id' => $product_att_val->id,
                                                    'attribute_id' => $product_att_val->parent_id,
                                                    // 'attribute_value_id' => $product_att_val->attribute_value,
                                                    // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                                    'group_id' => $sku_code,
                                                    'Cust_tag_group' =>$item[${'Group_ID'}],
                                                    'remarks' => $item[${'Remarks'}] ?? '' ,
                                                    'brand_name' => $item[${'Brand_Name'}],
                                                ];
                                                ProductExtraInfo::create($product_extra_info_obj_user);
                                            }
                                        } // If End
                                    } // Loop End
                                } // If End

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
                                        'price'=> $Shop_Price_Reseller,
                                    ]);
                                }

                                if($vip_group){
                                    // create Vip Group record
                                    GroupProduct::create([
                                        'group_id'=>$vip_group->id,
                                        'product_id'=>$product_obj->id,
                                        'price'=>  $Shop_Price_VIP_Customer,
                                    ]);
                                }
                                $arr_images = [];
                                // * Start Creating Media...

                                if (isset(${'Image_main'})) {
                                    if(isset($item[${'Image_main'}]) && $item[${'Image_main'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'Image_main'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'Image_main'}];
                                        $media->extension = explode('.',$item[${'Image_main'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                }

                                if (isset(${'image_name_front'}) ) {
                                    if($item[${'image_name_front'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'image_name_front'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_front'}];
                                        $media->extension = explode('.',$item[${'image_name_front'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                }

                                if (isset(${'image_name_back'})) {
                                    if(isset($item[${'image_name_back'}]) && $item[${'image_name_back'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'image_name_back'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_back'}];
                                        $media->extension = explode('.',$item[${'image_name_back'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                }


                                if (isset(${'image_name_side1'})) {
                                    if(isset($item[${'image_name_side1'}]) && $item[${'image_name_side1'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'image_name_side1'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_side1'}];
                                        $media->extension = explode('.',$item[${'image_name_side1'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                }


                                if (isset(${'image_name_side2'})) {
                                    if(isset($item[${'image_name_side2'}]) && $item[${'image_name_side2'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'image_name_side2'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_side2'}];
                                        $media->extension = explode('.',$item[${'image_name_side2'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                }



                                if (isset(${'image_name_poster'})) {
                                    if(isset($item[${'image_name_poster'}]) && $item[${'image_name_poster'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'image_name_poster'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_poster'}];
                                        $media->extension = explode('.',$item[${'image_name_poster'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
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
                                // // Add images to UserShopItem
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
                                        'allow_resellers' => $Allow_Resellers,
                                        'exclusive_buyer_name' => $item[${'Exclusive_Buyer_Name'}],
                                        'collection_name' => $item[${'Theme_Collection_Name'}],
                                        'season_month' => $item[${'Season_Month'}],
                                        'season_year' => $item[${'Theme_Collection_Year'}],
                                        'sample_available' => 0,
                                        'sample_year' => $item[${'Sample_Year'}],
                                        'sample_month' => $item[${'Sample_Month'}],
                                        'sampling_time' => $item[${'Sampling_time'}],
                                        'CBM' => '',
                                        'production_time' =>'',
                                        'MBQ' => '',
                                        'MBQ_unit' => '',
                                        'vendor_sourced_from' => $item[${'Vendor_Sourced_from'}],
                                        'vendor_price' => $item[${'Vendor_price'}],
                                        'product_cost_unit' => $item[${'Product_Cost_Unit'}],
                                        'vendor_currency' => $item[${'Vendor_currency'}],
                                        'sourcing_year' => $item[${'Sourcing_Year'}],
                                        'sourcing_month' => $item[${'Sourcing_month'}],
                                        'attribute_value_id' => $product_att_val->id,
                                        'attribute_id' => $product_att_val->parent_id,
                                        // 'attribute_value_id' => $product_att_val->attribute_value,
                                        // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                        'group_id' => $sku_code,
                                        'Cust_tag_group' =>$item[${'Group_ID'}],
                                        'remarks' => $item[${'Remarks'}] ?? '' ,
                                        'brand_name' => $item[${'Brand_Name'}],
                                    ];

                                    ProductExtraInfo::create($product_extra_info_obj_user);


                                    if (!in_array($id,$CREATED_PRODUUCT_ID)) {
                                        array_push($CREATED_PRODUUCT_ID,$id);
                                    }
                                }
                            }






                        }
                    }
                    elseif ($loop1 != []) {

                        foreach ($loop1 as $key3 => $third) {
                                $Productids_array = [];
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
                                if ($item[${'Model_Code'}] == null && $item[${'Model_Code'}] == "") {
                                    $sku_code = 'SKU'.generateRandomStringNative(6);
                                    $item[${'Model_Code'}] = $sku_code;
                                }elseif (isset($GroupId)) {
                                    $sku_code = $GroupId;
                                }
                                else{
                                    $sku_code = 'SKU'.generateRandomStringNative(6);
                                }
                                if (in_array($item[${'Model_Code'}],$modalArray)) {
                                    // echo "Yes Bro!";
                                    $sku_code = $SKUArray[array_search($item[${'Model_Code'}],$modalArray)];
                                }else{
                                    array_push($modalArray,$item[${'Model_Code'}]);
                                    array_push($SKUArray,$sku_code);
                                }
                                $unique_slug  = getUniqueProductSlug($item[${'Product_name'}]);
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
                                    'standard_carton' => (isset(${'standard_carton_pcs'})) ? $item[${'standard_carton_pcs'}] : '',
                                    'carton_weight' => (isset(${'carton_weight_actual'})) ? $item[${'carton_weight_actual'}] : '',
                                    'carton_unit' => (isset(${'unit'})) ? $item[${'unit'}] : '',
                                    'carton_length' => (isset(${'Carton_length'})) ? $item[${'Carton_length'}] : '',
                                    'carton_width' => (isset(${'Carton_width'})) ? $item[${'Carton_width'}] : '',
                                    'carton_height' => (isset(${'Carton_height'})) ? $item[${'Carton_height'}] : '',
                                    'Carton_Dimensions_unit' => (isset(${'Carton_Dimensions_unit'})) ? $item[${'Carton_Dimensions_unit'}] : '',
                                ];

                                $shipping = [
                                    'height' => (isset(${'Product_height'})) ? $item[${'Product_height'}] : '',
                                    'gross_weight' =>(isset(${'Gross_weight'})) ? $item[${'Gross_weight'}] : '',
                                    'weight' => (isset(${'Net_weight'})) ? $item[${'Net_weight'}] : '',
                                    'width' => (isset(${'Product_width'})) ? $item[${'Product_width'}] : '',
                                    'length' => (isset(${'Product_length'})) ? $item[${'Product_length'}] : '',
                                    'unit' => (isset(${'Weight_unit'})) ? $item[${'Weight_unit'}] : '',
                                    'length_unit' => (isset(${'Dimensions_unit'})) ? $item[${'Dimensions_unit'}] : '',
                                ];

                                $carton_details = json_encode($carton_details);
                                $shipping = json_encode($shipping);



                                $price = ($product_exist != null && $item[${'Customer_Price_without_GST'}] == '') ? $product_exist->price : trim($item[${'Customer_Price_without_GST'}]);


                                $product_obj =  [
                                    'title' => ($product_exist != null && $item[${'Product_name'}] == null) ? $product_exist->title : $item[${'Product_name'}],
                                    'model_code' => ($product_exist != null && $item[${'Model_Code'}] == null) ? $product_exist->model_code : $item[${'Model_Code'}],
                                    'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                                    'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                                    'brand_id' => ($product_exist != null) ? $product_exist->brand_id : 0,
                                    'user_id' => $user->id,
                                    'sku' => $sku_code,
                                    'slug' => $unique_slug,
                                    'description' => ($product_exist != null && $item[${'description'}] == '') ? $product_exist->description : $item[${'description'}],
                                    'carton_details' =>  ($product_exist != null && $carton_details == null) ? $product_exist->carton_details : $carton_details,
                                    'shipping' =>  ($product_exist != null && $shipping == null) ? $product_exist->shipping : $shipping,
                                    'manage_inventory' =>  0,
                                    'stock_qty' => 0,
                                    'status' => 0,
                                    // 'is_publish' => (in_array($item[$PublishIndex],$allowed_array)) ? 1 : 0,
                                    'is_publish' => 1,
                                    'price' => $price ?? 0,
                                    'min_sell_pr_without_gst' => ($product_exist != null && $item[${'Customer_Price_without_GST'}] == '') ? $product_exist->min_sell_pr_without_gst : $item[${'Customer_Price_without_GST'}],
                                    'hsn' => ($product_exist != null && $item[${'HSN_Code'}] == '') ? $product_exist->hsn : $item[${'HSN_Code'}] ?? null,
                                    'hsn_percent' => ($product_exist != null && $item[${'HSN_Percnt'}] == '') ? $product_exist->hsn_percent : $item[${'HSN_Percnt'}] ?? null,
                                    'mrp' => ($product_exist != null && $item[${'mrpIncl_tax'}] == '') ? $product_exist->mrp : trim($item[${'mrpIncl_tax'}]),
                                    // 'video_url' => ($product_exist != null && $item[${'Video URL'}] == '') ? $product_exist->video_url : $item[${'Video URL'}],
                                    'search_keywords' => ($product_exist != null && $item[${'Search_keywords'}] == '') ? $product_exist->tag1 : $item[${'Search_keywords'}],
                                    // 'artwork_url' => $item[${'artwork_url'}] ?? null,
                                    // 'exclusive' => (in_array($item[${'Copyright/ Exclusive item'}],$allowed_array)) ? 1 : 0 ?? 0,
                                    'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                                    'SellingPriceunitIndex' => $item[${'Selling_Price_Unit'}] ?? '',
                                    // 'archive' => (in_array($item[$ArchiveIndex],$allowed_array)) ? 1 : 0,
                                ];

                                $product_obj = Product::create($product_obj);

                                $product = $product_obj;

                                $custom_fields = json_decode($user->custom_fields) ?? [];
                                // if ($custom_fields != null && count( (array) $custom_fields) > 0) {
                                //     foreach ($custom_fields as $key => $customfield) {

                                //         $ogname = $customfield->id;
                                //         // $customfieldID = str_replace("[]",'',$customfield->id);
                                //         $customfieldID = $tmp_item[${"$customfield->text"}] ?? '';

                                //         if (is_array($request->get($customfieldID)) || is_html($request->get($customfieldID))) {
                                //             echo "' $ogname ' It is an Array or HTML.".newline();
                                //             $updatevalue = base64_encode(json_encode($customfieldID));
                                //         }else{
                                //             // $customfield = str_replace("[]",'',$customfield);
                                //             $updatevalue = $customfieldID;
                                //         }

                                //         $custom_field = CustomFields::where('relatation_name',$ogname)->where('product_id',$product->id)->first();
                                //         if ($custom_field == null) {
                                //             echo "Create New Records".newline(2);
                                //             CustomFields::create([
                                //                 'relatation_name' => $ogname,
                                //                 'product_id' => $product_obj->id,
                                //                 'value' => $updatevalue ?? '',
                                //                 'user_id' => auth()->id(),
                                //             ]);
                                //         }else{
                                //             echo "Record Are Exist Update It".newline(2);

                                //             $custom_field->update([
                                //                 'value' => $updatevalue ?? '',
                                //             ]);
                                //         }
                                //     }
                                // }

                                if ($custom_fields != null && count( (array) $custom_fields) > 0) {
                                    foreach ($custom_fields as $key => $customfield) {

                                        $ogname = $customfield->id;
                                        // $customfieldID = str_replace("[]",'',$customfield->id);
                                        if (!isset(${"$customfield->text"})) {
                                            continue;
                                        }
                                        $customfieldID = $item[${"$customfield->text"}] ?? '';

                                        // [length] => 10
                                        // [width] => 50
                                        // [height] => 30
                                        // [unit] => mm


                                        if ($customfield->type == 'diamension') {
                                            $lenarr = explode('x',$customfieldID);
                                            if (count($lenarr) <= 1) {
                                                $lenarr = explode('X',$customfieldID);
                                            }
                                            $request[$customfieldID] = [
                                                'length' => $lenarr[0] ?? '',
                                                'width' => $lenarr[1] ?? '',
                                                'height' => $lenarr[2] ?? '',
                                                'unit' => $lenarr[3] ??'',
                                            ];
                                            // $request[$customfieldID]
                                        }

                                        if ($customfield->type == 'uom') {
                                            $lenarr = explode('x',$customfieldID);
                                            if (count($lenarr) <= 1) {
                                                $lenarr = explode('X',$customfieldID);
                                            }
                                            $request[$customfieldID] = [
                                                'measument' => $lenarr[0] ?? '',
                                                'unit' => $lenarr[3] ??'',
                                            ];
                                            // $request[$customfieldID]
                                        }

                                        // magicstring($request->get($customfieldID));
                                        // continue;


                                        if (is_array($request->get($customfieldID)) || is_html($request->get($customfieldID))) {
                                            echo "' $ogname ' It is an Array or HTML.".newline();

                                            $updatevalue = base64_encode(json_encode($request->get($customfieldID)));
                                        }else{
                                            // $customfield = str_replace("[]",'',$customfield);
                                            $updatevalue = $customfieldID;
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
                                        'allow_resellers' => $Allow_Resellers,
                                        'exclusive_buyer_name' => $item[${'Exclusive_Buyer_Name'}],
                                        'collection_name' => $item[${'Theme_Collection_Name'}],
                                        'season_month' => $item[${'Season_Month'}],
                                        'season_year' => $item[${'Theme_Collection_Year'}],
                                        'sample_year' => $item[${'Sample_Year'}],
                                        'sample_month' => $item[${'Sample_Month'}],
                                        'sampling_time' => $item[${'Sampling_time'}],
                                        'CBM' => '',
                                        'production_time' =>'',
                                        'MBQ' => '',
                                        'MBQ_unit' => '',
                                        'vendor_sourced_from' => $item[${'Vendor_Sourced_from'}],
                                        'vendor_price' => $item[${'Vendor_price'}],
                                        'product_cost_unit' => $item[${'Product_Cost_Unit'}],
                                        'vendor_currency' => $item[${'Vendor_currency'}],
                                        'sourcing_year' => $item[${'Sourcing_Year'}],
                                        'sourcing_month' => $item[${'Sourcing_month'}],
                                        'attribute_value_id' => $product_att_val->id,
                                        'attribute_id' => $product_att_val->parent_id,
                                        // 'attribute_value_id' => $product_att_val->attribute_value,
                                        // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                        'group_id' => $sku_code,
                                        'Cust_tag_group' =>$item[${'Group_ID'}],
                                        'remarks' => $item[${'Remarks'}] ?? '' ,
                                        'brand_name' => $item[${'Brand_Name'}],
                                    ];

                                    ProductExtraInfo::create($product_extra_info_obj_user);
                                }

                                echo "Selected In Excel File";
                                magicstring($selected_custom_attribute);

                                echo "Selected In Variation Column";
                                magicstring($variationType_array);

                                if (count($selected_custom_attribute) != count($variationType_array)) {
                                    foreach ($selected_custom_attribute as $chkkey => $checkval) {
                                        if (!in_array($checkval,$variationType_array)) {
                                            $tmp_col = ${$checkval};
                                            $attribute_default = ProductAttribute::where('name',$checkval)->where('user_id',null)->pluck('id');
                                            $attribute_custom = ProductAttribute::where('name',$checkval)->where('user_id',$user->id)->pluck('id');

                                            if (count($attribute_default) == 0 ) {
                                                $attribute = $attribute_custom;
                                            }else{
                                                $attribute = $attribute_default;
                                            }

                                            $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$item[$tmp_col])->first();

                                            $checkval = strtolower($checkval);
                                            $checkval = ucwords($checkval);

                                            if ($product_att_val != null) {

                                                $product_extra_info_obj_user = [
                                                    'product_id' => $product_obj->id,
                                                    'user_id' => $user->id,
                                                    'user_shop_id' => $user_shop->id,
                                                    'allow_resellers' => $Allow_Resellers,
                                                    'exclusive_buyer_name' => $item[${'Exclusive_Buyer_Name'}],
                                                    'collection_name' => $item[${'Theme_Collection_Name'}],
                                                    'season_month' => $item[${'Season_Month'}],
                                                    'season_year' => $item[${'Theme_Collection_Year'}],
                                                    'sample_year' => $item[${'Sample_Year'}],
                                                    'sample_month' => $item[${'Sample_Month'}],
                                                    'sampling_time' => $item[${'Sampling_time'}],
                                                    'CBM' => '',
                                                    'production_time' =>'',
                                                    'MBQ' => '',
                                                    'MBQ_unit' => '',
                                                    'vendor_sourced_from' => $item[${'Vendor_Sourced_from'}],
                                                    'vendor_price' => $item[${'Vendor_price'}],
                                                    'product_cost_unit' => $item[${'Product_Cost_Unit'}],
                                                    'vendor_currency' => $item[${'Vendor_currency'}],
                                                    'sourcing_year' => $item[${'Sourcing_Year'}],
                                                    'sourcing_month' => $item[${'Sourcing_month'}],
                                                    'attribute_value_id' => $product_att_val->id,
                                                    'attribute_id' => $product_att_val->parent_id,
                                                    // 'attribute_value_id' => $product_att_val->attribute_value,
                                                    // 'attribute_id' => getAttruibuteById($product_att_val->parent_id)->name,
                                                    'group_id' => $sku_code,
                                                    'Cust_tag_group' =>$item[${'Group_ID'}],
                                                    'remarks' => $item[${'Remarks'}] ?? '' ,
                                                    'brand_name' => $item[${'Brand_Name'}],
                                                ];
                                                ProductExtraInfo::create($product_extra_info_obj_user);
                                            }
                                        } // If End
                                    } // Loop End
                                } // If End

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
                                        'price'=> $Shop_Price_Reseller ?? 0,
                                    ]);
                                }

                                if($vip_group){
                                    // create Vip Group record
                                    GroupProduct::create([
                                        'group_id'=>$vip_group->id,
                                        'product_id'=>$product_obj->id,
                                        'price'=>  $Shop_Price_VIP_Customer ?? 0,
                                    ]);
                                }
                                $arr_images = [];
                                // * Start Creating Media...

                                if (isset(${'Image_main'})) {
                                    if(isset($item[${'Image_main'}]) && $item[${'Image_main'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'Image_main'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'Image_main'}];
                                        $media->extension = explode('.',$item[${'Image_main'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                }

                                if (isset(${'image_name_front'}) ) {
                                    if($item[${'image_name_front'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'image_name_front'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_front'}];
                                        $media->extension = explode('.',$item[${'image_name_front'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                }

                                if (isset(${'image_name_back'})) {
                                    if(isset($item[${'image_name_back'}]) && $item[${'image_name_back'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'image_name_back'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_back'}];
                                        $media->extension = explode('.',$item[${'image_name_back'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                }


                                if (isset(${'image_name_side1'})) {
                                    if(isset($item[${'image_name_side1'}]) && $item[${'image_name_side1'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'image_name_side1'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_side1'}];
                                        $media->extension = explode('.',$item[${'image_name_side1'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                }


                                if (isset(${'image_name_side2'})) {
                                    if(isset($item[${'image_name_side2'}]) && $item[${'image_name_side2'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'image_name_side2'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_side2'}];
                                        $media->extension = explode('.',$item[${'image_name_side2'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
                                }



                                if (isset(${'image_name_poster'})) {
                                    if(isset($item[${'image_name_poster'}]) && $item[${'image_name_poster'}] != null){
                                        $media = new Media();
                                        $media->tag = "Product_Image";
                                        $media->file_type = "Image";
                                        $media->type = "Product";
                                        $media->type_id = $product_obj->id;
                                        $media->file_name = $item[${'image_name_poster'}];
                                        $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_poster'}];
                                        $media->extension = explode('.',$item[${'image_name_poster'}])[1] ?? '';
                                        $media->save();
                                        $arr_images[] = $media->id;
                                    }
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
                                // // Add images to UserShopItem
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
                        if ($item[${'Model_Code'}] == null && $item[${'Model_Code'}] == "") {
                            $sku_code = 'SKU'.generateRandomStringNative(6);
                            $item[${'Model_Code'}] = $sku_code;
                        }elseif (isset($GroupId)) {
                            $sku_code = $GroupId;
                        }
                        else{
                            $sku_code = 'SKU'.generateRandomStringNative(6);
                        }
                        if (in_array($item[${'Model_Code'}],$modalArray)) {
                            // echo "Yes Bro!";
                            $sku_code = $SKUArray[array_search($item[${'Model_Code'}],$modalArray)];
                        }else{
                            array_push($modalArray,$item[${'Model_Code'}]);
                            array_push($SKUArray,$sku_code);
                        }
                        $unique_slug  = getUniqueProductSlug($item[${'Product_name'}]);
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
                            'standard_carton' => (isset(${'standard_carton_pcs'})) ? $item[${'standard_carton_pcs'}] : '',
                            'carton_weight' => (isset(${'carton_weight_actual'})) ? $item[${'carton_weight_actual'}] : '',
                            'carton_unit' => (isset(${'unit'})) ? $item[${'unit'}] : '',
                            'carton_length' => (isset(${'Carton_length'})) ? $item[${'Carton_length'}] : '',
                            'carton_width' => (isset(${'Carton_width'})) ? $item[${'Carton_width'}] : '',
                            'carton_height' => (isset(${'Carton_height'})) ? $item[${'Carton_height'}] : '',
                            'Carton_Dimensions_unit' => (isset(${'Carton_Dimensions_unit'})) ? $item[${'Carton_Dimensions_unit'}] : '',
                        ];

                        $shipping = [
                            'height' => (isset(${'Product_height'})) ? $item[${'Product_height'}] : '',
                            'gross_weight' =>(isset(${'Gross_weight'})) ? $item[${'Gross_weight'}] : '',
                            'weight' => (isset(${'Net_weight'})) ? $item[${'Net_weight'}] : '',
                            'width' => (isset(${'Product_width'})) ? $item[${'Product_width'}] : '',
                            'length' => (isset(${'Product_length'})) ? $item[${'Product_length'}] : '',
                            'unit' => (isset(${'Weight_unit'})) ? $item[${'Weight_unit'}] : '',
                            'length_unit' => (isset(${'Dimensions_unit'})) ? $item[${'Dimensions_unit'}] : '',
                        ];

                        $allow_carton = false;
                        foreach ($carton_details as $key => $cart) {
                            if ($cart !== '' && $cart !== null) {
                                $allow_carton = true;
                            }
                        }

                        $allow_shipping = false;
                        foreach ($shipping as $key => $ship) {
                            if ($ship !== '' && $ship !== null) {
                                $allow_shipping = true;
                            }
                        }

                        $carton_details = json_encode($carton_details);
                        $shipping = json_encode($shipping);





                        // return;
                        $price = ($product_exist != null && $item[${'Customer_Price_without_GST'}] == '') ? $product_exist->price : trim($item[${'Customer_Price_without_GST'}]);


                        $product_obj =  [
                            'title' => ($product_exist != null && $item[${'Product_name'}] == null) ? $product_exist->title : $item[${'Product_name'}],
                            'model_code' => ($product_exist != null && $item[${'Model_Code'}] == null) ? $product_exist->model_code : $item[${'Model_Code'}],
                            'category_id' => ($product_exist != null && $Category_id == '') ? $product_exist->category_id : $Category_id,
                            'sub_category' => ($product_exist != null && $sub_category_id == '') ? $product_exist->sub_category : $sub_category_id,
                            'brand_id' => ($product_exist != null) ? $product_exist->brand_id : 0,
                            'user_id' => $user->id,
                            'sku' => $sku_code,
                            'slug' => $unique_slug,
                            'description' => ($product_exist != null && $item[${'description'}] == '') ? $product_exist->description : $item[${'description'}],
                            'carton_details' => $carton_details,
                            'shipping' =>  $shipping,
                            'manage_inventory' =>  0,
                            'stock_qty' => 0,
                            'status' => 0,
                            'is_publish' => 1,
                            'price' => $price ?? 0,
                            'min_sell_pr_without_gst' => ($product_exist != null && $item[${'Customer_Price_without_GST'}] == '') ? $product_exist->min_sell_pr_without_gst : $item[${'Customer_Price_without_GST'}],
                            'hsn' => ($product_exist != null && $item[${'HSN_Code'}] == '') ? $product_exist->hsn : $item[${'HSN_Code'}] ?? null,
                            'hsn_percent' => ($product_exist != null && $item[${'HSN_Percnt'}] == '') ? $product_exist->hsn_percent : $item[${'HSN_Percnt'}] ?? null,
                            'mrp' => ($product_exist != null && $item[${'mrpIncl_tax'}] == '') ? $product_exist->mrp : trim($item[${'mrpIncl_tax'}]),
                            // 'video_url' => ($product_exist != null && $item[${'Video URL'}] == '') ? $product_exist->video_url : $item[${'Video URL'}],
                            'search_keywords' => ($product_exist != null && $item[${'Search_keywords'}] == '') ? $product_exist->tag1 : $item[${'Search_keywords'}],
                            // 'artwork_url' => $item[${'artwork_url'}] ?? null,
                            // 'exclusive' => (in_array($item[${'Copyright/ Exclusive item'}],$allowed_array)) ? 1 : 0 ?? 0,
                            'base_currency' => ($product_exist != null && $Currency == '') ? $product_exist->base_currency : $Currency,
                            'SellingPriceunitIndex' => $item[${'Selling_Price_Unit'}] ?? '',
                        ];

                        $product_obj = Product::create($product_obj);
                        $product = $product_obj;

                        // ob_clean();
                        $custom_fields = json_decode($user->custom_fields) ?? [];
                        if ($custom_fields != null && count( (array) $custom_fields) > 0) {
                            foreach ($custom_fields as $key => $customfield) {

                                $ogname = $customfield->id;
                                // $customfieldID = str_replace("[]",'',$customfield->id);
                                if (!isset(${"$customfield->text"})) {
                                    continue;
                                }

                                $customfieldID = $item[${"$customfield->text"}] ?? '';

                                // [length] => 10
                                // [width] => 50
                                // [height] => 30
                                // [unit] => mm


                                if ($customfield->type == 'diamension') {
                                    $lenarr = explode('x',$customfieldID);
                                    if (count($lenarr) <= 1) {
                                        $lenarr = explode('X',$customfieldID);
                                    }
                                    $request[$customfieldID] = [
                                        'length' => $lenarr[0] ?? '',
                                        'width' => $lenarr[1] ?? '',
                                        'height' => $lenarr[2] ?? '',
                                        'unit' => $lenarr[3] ??'',
                                    ];
                                    // $request[$customfieldID]
                                }

                                if ($customfield->type == 'uom') {
                                    $lenarr = explode('x',$customfieldID);
                                    if (count($lenarr) <= 1) {
                                        $lenarr = explode('X',$customfieldID);
                                    }
                                    $request[$customfieldID] = [
                                        'measument' => $lenarr[0] ?? '',
                                        'unit' => $lenarr[3] ??'',
                                    ];
                                    // $request[$customfieldID]
                                }

                                // magicstring($request->get($customfieldID));
                                // continue;


                                if (is_array($request->get($customfieldID)) || is_html($request->get($customfieldID))) {
                                    echo "' $ogname ' It is an Array or HTML.".newline();

                                    $updatevalue = base64_encode(json_encode($request->get($customfieldID)));
                                }else{
                                    // $customfield = str_replace("[]",'',$customfield);
                                    $updatevalue = $customfieldID;
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

                            // return;

                        array_push($Productids_array,$product_obj->id);

                        echo "Selected In Excel File";
                        magicstring($selected_custom_attribute);

                        echo "Selected In Variation Column";
                        magicstring($variationType_array);


                        if (count($selected_custom_attribute) != count($variationType_array)) {
                            foreach ($selected_custom_attribute as $chkkey => $checkval) {
                                if (!in_array($checkval,$variationType_array)) {
                                    $tmp_col = ${$checkval};
                                    $attribute_default = ProductAttribute::where('name',$checkval)->where('user_id',null)->pluck('id');
                                    $attribute_custom = ProductAttribute::where('name',$checkval)->where('user_id',$user->id)->pluck('id');

                                    if (count($attribute_default) == 0 ) {
                                        $attribute = $attribute_custom;
                                    }else{
                                        $attribute = $attribute_default;
                                    }

                                    $checkval = strtolower($checkval);
                                    $checkval = ucwords($checkval);

                                    $product_att_val = ProductAttributeValue::whereIn('parent_id',$attribute)->where('attribute_value',$item[$tmp_col])->first();

                                    if ($product_att_val != null) {
                                        $product_extra_info_obj_user = [
                                            'product_id' => $product_obj->id,
                                            'user_id' => $user->id,
                                            'user_shop_id' => $user_shop->id,
                                            'allow_resellers' => $Allow_Resellers,
                                            'exclusive_buyer_name' => $item[${'Exclusive_Buyer_Name'}],
                                            'collection_name' => $item[${'Theme_Collection_Name'}],
                                            'season_month' => $item[${'Season_Month'}],
                                            'season_year' => $item[${'Theme_Collection_Year'}],
                                            'sample_year' => $item[${'Sample_Year'}],
                                            'sample_month' => $item[${'Sample_Month'}],
                                            'sampling_time' => $item[${'Sampling_time'}],
                                            'CBM' => '',
                                            'production_time' =>'',
                                            'MBQ' => '',
                                            'MBQ_unit' => '',
                                            'vendor_sourced_from' => $item[${'Vendor_Sourced_from'}],
                                            'vendor_price' => $item[${'Vendor_price'}],
                                            'product_cost_unit' => $item[${'Product_Cost_Unit'}],
                                            'vendor_currency' => $item[${'Vendor_currency'}],
                                            'sourcing_year' => $item[${'Sourcing_Year'}],
                                            'sourcing_month' => $item[${'Sourcing_month'}],
                                            'attribute_value_id' => $product_att_val->id,
                                            'attribute_id' => $product_att_val->parent_id,
                                            'group_id' => $sku_code,
                                            'Cust_tag_group' =>$item[${'Group_ID'}],
                                            'remarks' => $item[${'Remarks'}] ?? '' ,
                                            'brand_name' => $item[${'Brand_Name'}],
                                        ];
                                        ProductExtraInfo::create($product_extra_info_obj_user);

                                    }
                                } // If End
                            } // Loop End
                        } // If End

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
                                'price'=> $Shop_Price_Reseller,
                            ]);
                        }

                        if($vip_group){
                            // create Vip Group record
                            GroupProduct::create([
                                'group_id'=>$vip_group->id,
                                'product_id'=>$product_obj->id,
                                'price'=>  $Shop_Price_VIP_Customer,
                            ]);
                        }
                        $arr_images = [];
                        // * Start Creating Media...

                        if (isset(${'Image_main'})) {
                            if(isset($item[${'Image_main'}]) && $item[${'Image_main'}] != null){
                                $media = new Media();
                                $media->tag = "Product_Image";
                                $media->file_type = "Image";
                                $media->type = "Product";
                                $media->type_id = $product_obj->id;
                                $media->file_name = $item[${'Image_main'}];
                                $media->path = "storage/files/".auth()->id()."/".$item[${'Image_main'}];
                                $media->extension = explode('.',$item[${'Image_main'}])[1] ?? '';
                                $media->save();
                                $arr_images[] = $media->id;
                            }
                        }

                        if (isset(${'image_name_front'}) ) {
                            if($item[${'image_name_front'}] != null){
                                $media = new Media();
                                $media->tag = "Product_Image";
                                $media->file_type = "Image";
                                $media->type = "Product";
                                $media->type_id = $product_obj->id;
                                $media->file_name = $item[${'image_name_front'}];
                                $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_front'}];
                                $media->extension = explode('.',$item[${'image_name_front'}])[1] ?? '';
                                $media->save();
                                $arr_images[] = $media->id;
                            }
                        }

                        if (isset(${'image_name_back'})) {
                            if(isset($item[${'image_name_back'}]) && $item[${'image_name_back'}] != null){
                                $media = new Media();
                                $media->tag = "Product_Image";
                                $media->file_type = "Image";
                                $media->type = "Product";
                                $media->type_id = $product_obj->id;
                                $media->file_name = $item[${'image_name_back'}];
                                $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_back'}];
                                $media->extension = explode('.',$item[${'image_name_back'}])[1] ?? '';
                                $media->save();
                                $arr_images[] = $media->id;
                            }
                        }


                        if (isset(${'image_name_side1'})) {
                            if(isset($item[${'image_name_side1'}]) && $item[${'image_name_side1'}] != null){
                                $media = new Media();
                                $media->tag = "Product_Image";
                                $media->file_type = "Image";
                                $media->type = "Product";
                                $media->type_id = $product_obj->id;
                                $media->file_name = $item[${'image_name_side1'}];
                                $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_side1'}];
                                $media->extension = explode('.',$item[${'image_name_side1'}])[1] ?? '';
                                $media->save();
                                $arr_images[] = $media->id;
                            }
                        }


                        if (isset(${'image_name_side2'})) {
                            if(isset($item[${'image_name_side2'}]) && $item[${'image_name_side2'}] != null){
                                $media = new Media();
                                $media->tag = "Product_Image";
                                $media->file_type = "Image";
                                $media->type = "Product";
                                $media->type_id = $product_obj->id;
                                $media->file_name = $item[${'image_name_side2'}];
                                $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_side2'}];
                                $media->extension = explode('.',$item[${'image_name_side2'}])[1] ?? '';
                                $media->save();
                                $arr_images[] = $media->id;
                            }
                        }



                        if (isset(${'image_name_poster'})) {
                            if(isset($item[${'image_name_poster'}]) && $item[${'image_name_poster'}] != null){
                                $media = new Media();
                                $media->tag = "Product_Image";
                                $media->file_type = "Image";
                                $media->type = "Product";
                                $media->type_id = $product_obj->id;
                                $media->file_name = $item[${'image_name_poster'}];
                                $media->path = "storage/files/".auth()->id()."/".$item[${'image_name_poster'}];
                                $media->extension = explode('.',$item[${'image_name_poster'}])[1] ?? '';
                                $media->save();
                                $arr_images[] = $media->id;
                            }
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
                        // // Add images to UserShopItem
                        if(count($arr_images) > 0) {
                            $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                            $usi->save();
                        }

                        if($product_obj){
                            ++$count;
                        }
                    }


                }
            // ! Main For Uploading Data End

                // return;

            // return;
            // return back()->with('success',"$count Record Are Uploaded");
            // return redirect()->route('panel.filemanager.index')->with('success', "$count Record Are Uploaded");

            return redirect(route('panel.user_shop_items.create', ['type' => 'direct', 'type_ide' => encrypt(auth()->id()),'assetsafe' => true]))->with('success', "$count Record Are Uploaded");



            // http://localhost/project/121.page-Laravel/121.page/panel/user-shop-items/create?type=direct&type_ide=eyJpdiI6Ik16b3gwZ3lTZjh2Zm95cXhUcEM0d1E9PSIsInZhbHVlIjoiYlBnMElYanFkNlIwUGNCQlRld1lodz09IiwibWFjIjoiNmQwMDIxY2RjZDg1ZWE2MTJiZmEzM2JkN2JjMmI1N2NlZDE0NWQwZTRiMGUyY2I3MzhmZDE2ZmNiODAyZDI2NCIsInRhZyI6IiJ9&assetsafe=true

        } catch (\Throwable $th) {
            throw $th;
            // return back()->with('error',"There was Error while uploading. Raise support ticket for resolution.");
        }

    }


    public function ZipMaker($fileName = null){

        $zip = new ZipArchive;

        if ($fileName == null) {
            $fileName = 'Instructions.zip';
        }
        $fileName = 'zipFile.zip';
        if ($zip->open($fileName,ZipArchive::CREATE)) {
            $files = File::files(storage_path("app/public/instructions"));

            foreach ($files as $key => $file) {
                $nameinZip = basename($file);
                $zip->addFile($file,$nameinZip);
            }
            $zip->close();
        }


        return response()->download($fileName);
        exit();
    }


    public function exportExcel($record,$filename) {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {

                // magicstring(request()->all());
                // return;

            $spreadsheet = new Spreadsheet();

            $FirstSheetName = "Entry Sheet";
            $SecondSheetName = "Data Validation Sheet";

            $actualWorkSheet = $spreadsheet->getActiveSheet();
            $actualWorkSheet->getDefaultColumnDimension()->setWidth(50);
            $actualWorkSheet->setTitle($FirstSheetName);
            $actualWorkSheet->fromArray($record,null,'A3');
            // Auto-size columns to fit content
            $actualWorkSheet->freezePane('B4');
            $actualWorkSheet->calculateColumnWidths();
            $user_id = auth()->user();
            $merged_array = request()->finaldata;


            $custom_attributes = (array) json_decode($user_id->custom_attriute_columns) ?? ['Colours','Size','Material'];

            $dropdownSheet = $spreadsheet->createSheet();
            $dropdownSheet->setTitle($SecondSheetName);
            $dropdownSheet->getDefaultColumnDimension()->setWidth(50);

            $dropdownSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);


            foreach ($custom_attributes as $key => $custom_attribute) {
                $optionsArray = [];
                $index = $key + 1;
                $dropdownSheet->setCellValue([$index,'1'],$custom_attribute);

                $attribute_rec = ProductAttribute::where('name',$custom_attribute)->where('user_id',$user_id->id)->first();
                if ($attribute_rec == null) {
                    $attribute_rec = ProductAttribute::where('name',$custom_attribute)->where('user_id',null)->first();
                }

                $attribute_values = ProductAttributeValue::where('parent_id',$attribute_rec->id)->pluck('attribute_value')->toArray();

                $optionsArray = array_chunk($attribute_values,1);
                $excelColumn = $this->numToExcelColumn($index);
                $startCell = $excelColumn . '2';

                $dropdownSheet->fromArray(
                    $optionsArray,
                    null,
                    $startCell
                );


                $ActualSheetColIndex = array_search($custom_attribute, $merged_array);
                $ActualSheetColIndex = $this->numToExcelColumn($ActualSheetColIndex + 1);

                $validation = new \PhpOffice\PhpSpreadsheet\Cell\DataValidation();
                $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Pick from list or Create');
                $validation->setError('Please pick value from dropdown-list OR In excel, replace cell to enter new value . Before upload on 121, update new value in Custom fields.');
                $validation->setPromptTitle('Pick from list or Create');
                $validation->setPrompt('Please pick value from dropdown-list OR In excel, replace cell to enter new value . Before upload on 121, update new value in Custom fields.');

                // Corrected the formula string
                $validation->setFormula1("'$SecondSheetName'!$" . $excelColumn . "\$2:\$" . $excelColumn . "\$" . (count($attribute_values) + 1 ));


                // Skip Validation for Any value and UOM in Custom Properties
                if ($attribute_rec->value == 'any_value' || $attribute_rec->value == 'uom') {
                    continue;
                }
                if ($ActualSheetColIndex != 'A') {
                    // Apply the validation to each cell in the range A1:A100
                    for ($i = 1; $i <= 97; $i++) {
                        $cellCoordinate = $ActualSheetColIndex . strval($i + 3);
                        // $actualWorkSheet->getCell($cellCoordinate)->setDataValidation(clone $validation);
                        if ($ActualSheetColIndex != 'A') {
                            $actualWorkSheet->getCell($cellCoordinate)->setDataValidation(clone $validation);
                        }
                    }
                }


            }

            $Excel_writer = new Xls($spreadsheet);
            $mytime = Carbon::now();
            $name = request()->name ?? null;

            if ($name == null) {
                $fileName = "$user_id->name Exported Data-".$mytime->toDateTimeString();
            }else{
                $fileName = $name;
            }

            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=$fileName.xls");
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();

        } catch (Exception $e) {
            throw $e;
            return;
        }

    }


    public function exportfileCurrency(){
        try {
            $filename = "Upload Currency";
            $user = auth()->user();

            $data = ["Currency","Exchange Rate","Remark"];

            $this->exportExcel($data,$filename);

            return back()->with('success',"File Download Success Fully");
        } catch (\Throwable $th) {
            return back()->with('error',"Try After Some Time.");
        }

    }

    // Upload Currency Data in Bulk
    public function uploadCurrency(Request $request,User $user){

        try {
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
            $with_header = array_slice($rows,2);
            $rows = array_slice($rows,3);
            $master = $rows;

            $count = 0;
            $user_shop = getShopDataByUserId($user->id);

            $CurrencyIndex = 0;
            $ExchangeRateIndex = 1;
            $RemarkIndex = 2;


            magicstring($with_header[0]);

            foreach ($master as $key => $item) {

                    $chk = UserCurrency::where('currency',$item[$CurrencyIndex])->where('user_id',$user->id)->get();
                    if (count($chk) != 0) {
                        $name = $item[$CurrencyIndex];
                        echo $name;
                        return back()->with('error',"$name Already Exist in Your Account.");
                    }else{

                        UserCurrency::create([
                            'user_id' => $user->id,
                            'User_shop_id' => $user_shop->id ?? 0,
                            'currency' => $item[$CurrencyIndex],
                            'exchange' => $item[$ExchangeRateIndex],
                            'remark' => $item[$RemarkIndex],
                            'default_currency' => 0
                        ]);
                        $count++;
                    }
                }
                return back()->with('success',"$count Record are added");

        } catch (\Throwable $th) {
            throw $th;
            // return back()->with('error',"There was and some issue. Try again later.");
        }


        echo "Downlaod Excel File";
    }


    // Update Existing Currency Records
    public function updateCurrency(Request $request,User $user){

        try {
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
            $with_header = array_slice($rows,2);
            $rows = array_slice($rows,3);
            $master = $rows;

            $count = 0;
            $user_shop = getShopDataByUserId($user->id);

            $IdIndex = 0;
            $CurrencyIndex = 1;
            $ExchangeRateIndex = 2;
            $RemarkIndex = 3;


            magicstring($with_header[0]);

            foreach ($master as $key => $item) {
                    $row = $key +4;

                    $chk = UserCurrency::where('id',$item[$IdIndex])->where('user_id',$user->id)->get();
                    if (count($chk) == 0) {
                        return back()->with('error',"Currency is not Exist in Your Account at $row.");
                    }else{

                        $chk[0]->update([
                            'currency' => $item[$CurrencyIndex],
                            'exchange' => $item[$ExchangeRateIndex],
                            'remark' => $item[$RemarkIndex],
                        ]);
                        $count++;
                    }

            }


            return back()->with('success',"$count Record are added");

        } catch (\Throwable $th) {
            throw $th;
            // return back()->with('error',"There was and some issue. Try again later.");
        }
    }

    public function exportrecordCurrecy(Request $request,User $user){


        try {

            $record = UserCurrency::where('user_id',$user->id)->get();

            $tempate[] = array("Id","Currency","Exchange Rate","Remark","Default");

            foreach ($record as $key => $value) {
                $tempate[] = array(
                    'Id' => $value->id,
                    'Currency' => $value->currency,
                    'Exchange Rate' => $value->exchange,
                    'Remark' => $value->remark,
                    'Default' => $value->default_currency
                );
            }

            $this->exportExcel($tempate,"Currecy ExportedData");

            return back()->with('success',"Download Started");


        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error',"Try Again later");
        }

    }


    public function testExports() {
        echo "Done";
        return;
    }


    function numToExcelColumn($num) {
        $char = '';
        while ($num > 0) {
            $remainder = ($num - 1) % 26;
            $char = chr(65 + $remainder) . $char;
            $num = floor(($num - $remainder) / 26);
        }
        return $char;
    }





}

