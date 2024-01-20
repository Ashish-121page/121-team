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
use App\Models\QuotationItem;
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


        $data = QuotationItem::whereId(30)->first();
        $con = json_decode($data->consignee_set);
        magicstring(searchKeyMultiDiaArray($con,2,'consignee_id'));


        // magicstring($con);
        // echo "Total $count Records Updated Successfully.";
    }


    // function searchkey($multi_dia_arr,$searchval,$search_key) {
    //     foreach ($multi_dia_arr as $key => $value) {
    //         foreach ($value as $key2 => $item) {
    //             if ($item == $searchval && $key2 == $search_key) {
    //                 return $value;
    //             }
    //         }
    //     }
    // }


    public function imagestudio(Request $request){
        return view('devloper.underDev.PhotoStudio');
    }








}
