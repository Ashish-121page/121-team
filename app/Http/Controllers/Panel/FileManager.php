<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PriceAskRequest;
use App\Models\PriceAskItem;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Storage;

class FileManager extends Controller
{
    public function index(Request $request)
    {
        // return 's';
        try{
           return view('panel.seller_files.index');
        }catch(\Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
        
    }



    public function newview(Request $request) {

        $folderPath = 'public/files/2'; // Replace 'your-folder-path' with the actual folder path

        if (Storage::exists($folderPath)) {
            $files = Storage::files($folderPath);

            
        }else{
            echo "No Path Exist";
            return;
        }

        return view('panel.Filemanager.index',compact('files'));
    }




}
