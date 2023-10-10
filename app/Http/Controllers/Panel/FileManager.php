<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PriceAskRequest;
use App\Models\PriceAskItem;
use App\Models\UserAddress;

class FileManager extends Controller
{
    public function index(Request $request)
    {
        // return 's';
        try{
           return view('panel.seller_files.index');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
