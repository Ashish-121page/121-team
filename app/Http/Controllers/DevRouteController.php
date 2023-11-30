<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Proposalenquiry;
use App\Models\Team;
use App\Models\UserShop;
use Illuminate\Support\Facades\Storage;

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
<<<<<<< HEAD
=======
        // phpinfo();
>>>>>>> main
        // return;
        

        // echo decrypt("eyJpdiI6Iko3bEZKSEVmc0g3TFhnby84ZDhUdmc9PSIsInZhbHVlIjoib1B0Q3ZCN0owc3ZMcndVNERnVytOQT09IiwibWFjIjoiODhjNDI1MDgyNTNlMDhmMWU3YjVkYTEyYjEzYzNmMjdlOTczNTgwZWExZGYxMTk4NGQyZTIwMWM5NDBlMTZiNCIsInRhZyI6IiJ9");

        
        return;

        // Creating Thumbnail while Uploading
        if ($request->has('submt')) {
            $user_id = auth()->id();
            $imagePath = $request->file('images')->path();
            $thumbnailPath = storage_path("app/public/files/$user_id/thumbnail");
            // Ensure the thumbnails directory exists
            if (!file_exists($thumbnailPath)) {
                mkdir($thumbnailPath, 0755, true);
            }
            $filename = explode('.',$request->file('images')->getClientOriginalName())[0];
            // Generate the thumbnail
            Image::make($imagePath)
                ->fit(100, 100) // Adjust the dimensions as needed
                ->save($thumbnailPath . '/' . $filename . '_thumbnail.jpg');
    
            // ` Printing Image Thumbnail Path
            echo $thumbnailPath.newline(2); 
            return 'Thumbnail generated successfully!';
        }
        



        // Creating Thumbnails for Existing Uploaded Images
        if ($request->has('createthumb')) {
            // Getting File List
            $userid = auth()->id();
            echo $userid.newline(3);
            $imagePath = storage_path("app/public/files/$userid");
            $thumbnailPath = storage_path("app/public/files/$userid/thumbnail");
            if (!file_exists($imagePath)) {
                return 'Image folder not found!';
            }
            // Ensure the thumbnails directory exists
            if (!file_exists($thumbnailPath)) {
                mkdir($thumbnailPath, 0755, true);
            }
            $files = FacadesFile::allFiles($imagePath);
            foreach ($files as $file) {
                // echo mime_content_type($file);
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file);
                finfo_close($finfo);

                $supported_file = ['JPG', 'PNG', 'GIF', 'BMP' ,'WebP','jpeg','png','jpg','gif','webp'];
                if (in_array(explode('/',$mimeType)[1],$supported_file)) {
                    $image = Image::make($file->getRealPath());                
                    $thumbnailName = $file->getFilename();
                    // Generate the thumbnail
                    $image->resize(100, 100)->save($thumbnailPath . '/' . $thumbnailName);                        
                }

            }

            
            return 'Thumbnails generated successfully!';
        }
        
        return view('devloper.ashish.index');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
}