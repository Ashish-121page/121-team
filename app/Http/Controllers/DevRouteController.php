<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Proposalenquiry;
use App\Models\Team;
use App\User;
use Illuminate\Support\Facades\Http;
use App\Models\UserShop;
use App\Models\UserCurrency;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

// Using In Thumbnail Creation
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File as FacadesFile;

class DevRouteController extends Controller
{

    public function jaya() {
        return "Jaya's Function";
    }



    public function jayaform(){
        return view('devloper.jaya.form-check');
    }


    public function ashish(Request $request) {

        //` Uncomment Below Line to Check Available Sessions..
        // magicstring(session()->all());
        // echo "Ashish's Function";

        $data = '{"general_details":["Model_Code","SKU Type","Product_name","Category","Sub_Category","Group_ID","Variation attributes","Base_currency","Selling_Price_Unit","Customer_Price_without_GST","mrpIncl_tax","Brand_Name","HSN_Code","HSN_Percnt","Search_keywords","description"],"custom_input_1":[],"general_details_2":["Sample_Year","Sample_Month","Sampling_time","Exclusive_Buyer_Name","Theme_Collection_Name","Season_Month","Theme_Collection_Year"],"images":["Image_main","image_name_front","image_name_back","image_name_side1","image_name_side2","image_name_poster","Additional_Image_Use"],"custom_input_4":[],"physical_attributes":["Gross_weight","Net_weight","Weight_unit","Product_length","Product_width","Product_height","Dimensions_unit","Carton_length","Carton_width","Carton_height","Carton_Dimensions_unit","standard_carton_pcs","carton_weight_actual","unit","Vendor_Sourced_from","Vendor_price","Product_Cost_Unit","Vendor_currency","Sourcing_Year","Sourcing_month","Remarks"],"custom_input_5":[]}';

        $data2 = ['general_details_2'=> ["Sample_Year","Sample_Month","Sampling_time","Exclusive_Buyer_Name","Theme_Collection_Name","Season_Month","Theme_Collection_Year"]];


        echo json_encode($data2);



        magicstring(json_decode($data, true));

        // echo "Total $count Records Updated Successfully.";



    }


    public function imagestudio(Request $request){
        return view('devloper.underDev.PhotoStudio');
    }








}
