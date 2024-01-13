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
        magicstring(session()->all());
        // echo "Ashish's Function";

        $users = User::all();

        // magicstring($users);
        $count = 0;

        foreach ($users as $key => $user) {
            $chk = UserCurrency::where('user_id',$user->id)->first();
            $user_shop = UserShop::where('user_id',$user->id)->first();
            if ($chk == null) {
                UserCurrency::create([
                    'user_id' => $user->id,
                    'User_shop_id' => $user_shop->id ?? 0,
                    'currency' => 'INR',
                    'exchange' => 1,
                    'remark' => 'Default Currency',
                    'default_currency' => 1
                ]);
                $count++;
            }
        }


        echo "Total $count Records Updated Successfully.";



    }


    public function imagestudio(Request $request){
        return view('devloper.underDev.PhotoStudio');
    }








}
