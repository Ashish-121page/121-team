<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Proposalenquiry;
use App\Models\Team;
use Illuminate\Support\Facades\Http;
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

        // echo decrypt("eyJpdiI6Iko3bEZKSEVmc0g3TFhnby84ZDhUdmc9PSIsInZhbHVlIjoib1B0Q3ZCN0owc3ZMcndVNERnVytOQT09IiwibWFjIjoiODhjNDI1MDgyNTNlMDhmMWU3YjVkYTEyYjEzYzNmMjdlOTczNTgwZWExZGYxMTk4NGQyZTIwMWM5NDBlMTZiNCIsInRhZyI6IiJ9");
        // return;

        $data = '[{
            "modelcode": "21212",
            "productname": " Single Wall SS Bottles ",
            "description": " Single Wall Ss Bottles &amp; Shaker&lt;Br&gt;Exclusive Of Gst, Branding &amp; Transportation. ",
            "colour": "Silver",
            "size": "501 - 1000 ml",
            "material": "Steel",
            "sizedetails": "750 ml",
            "quality,finish": "Single wall",
            "price": "INR116.00",
            "image": "http://offers.localhost/project/121.page-Laravel/121.page/storage/files/174/GBI-4018.jpg"
        }, {
            "modelcode": "21212",
            "productname": " Single Wall SS Bottles ",
            "description": " Single Wall Ss Bottles &amp; Shaker&lt;Br&gt;Exclusive Of Gst, Branding &amp; Transportation. ",
            "colour": "Silver",
            "size": "501 - 1000 ml",
            "material": "Steel",
            "sizedetails": "1000 ml",
            "quality,finish": "Single wall",
            "price": "INR122.00",
            "image": "http://offers.localhost/project/121.page-Laravel/121.page/storage/files/174/GBI-4018.jpg"
        }, {
            "modelcode": "2wds",
            "productname": " Single Wall SS Bottles ",
            "description": " &lt;p&gt;Single Wall Ss Bottles &amp;amp; Shaker&lt;br /&gt;Exclusive Of Gst, Branding &amp;amp; Transportation.&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;new&amp;nbsp;&lt;/p&gt; ",
            "colour": "Silver",
            "size": "501 - 1000 ml",
            "material": "Steel",
            "sizedetails": "1000 ml",
            "quality,finish": "Single wall",
            "price": "INR232.00",
            "image": "http://offers.localhost/project/121.page-Laravel/121.page/storage/files/174/GBI-4018.jpg"
        }]';


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://gb.giftingbazaar.com/excel/', [
            'data' => $data, // Your JSON data
            'fileName' => 'YourStringData.xlsx' // Your string data
        ]);

        $result = $response->body(); // or ->json() if you expect a JSON response

        magicstring($result);

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


        $user = auth()->user();
        $user_custom_fields = json_decode($user->custom_fields,true);

        // Extracting a particular key from each array in $user_custom_fields
        $extractedValues = array_column($user_custom_fields, 'ref_section');


        print_r($extractedValues);



        magicstring($user_custom_fields);

        return;
        return view('devloper.ashish.index',compact('user_custom_fields'));
    }

    public function removebg(Request $request) {
        return view('devloper.api.rembg.index');
    }

    public function postremovebg(Request $request) {

        $filename = pathinfo($request->file('image')->getClientOriginalName())['filename'];
        $file = $request->file('image');
        $filepath = $request->file('image')->path();
        // file , Myfilename
        $url = "https://gb.giftingbazaar.com/bg/process";

        $data = [
            'file' => $filepath,
            'Myfilename' => $filename,
        ];

        $response = Http::attach(
            'file', file_get_contents($file), $filename
        )->post($url,[
            'Myfilename' => $filename,
        ]);


        if ($response->successful()) {
            // Process successful response
            if ($request->ajax()) {
                return $response->body();
            }else{
                $url = json_decode($response->body(),true)['url'];
                echo "<img src='$url'>";
            }


        } else {
            // Handle errors
            $errorCode = $response->status();
        }



    }

}
