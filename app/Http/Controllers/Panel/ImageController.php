<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Facades\File as FacadesFile;

class ImageController extends Controller
{
    public function removeBg(Request $request) {

        $filename = "removeBackground".time();
        $file = $request->get('image_path');

        $url = "https://gb.giftingbazaar.com/bg/process";

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
                return $url;
            }

        } else {
            // Handle errors
            $errorCode = $response->status();
        }


    }


    public function changebg() {

        function convertColorStringToArray($colorString) {
            $colorArray = [];

            // Regular expression to match rgb or rgba strings
            $pattern = "/rgba?\((\d{1,3}), (\d{1,3}), (\d{1,3})(, [\d\.]+)?\)/";

            if (preg_match($pattern, $colorString, $matches)) {
                // Extract the red, green, and blue values
                $colorArray = [
                    'r' => (int) $matches[1],
                    'g' => (int) $matches[2],
                    'b' => (int) $matches[3]
                ];

                // If alpha value is present, add it to the array
                if (isset($matches[4])) {
                    $colorArray['a'] = floatval(trim($matches[4], ', '));
                }
            }

            return $colorArray;
        }


        function changeImageBackgroundColor($originalImagePath, $newBackgroundColor, $outputImagePath) {
            $image = Image::make($originalImagePath);

            // Create a canvas with the desired background color
            $canvas = Image::canvas($image->width(), $image->height(), $newBackgroundColor);

            // Place the original image on top of the canvas
            $canvas->insert($image, 'top-left', 0, 0);

            // Check if the output file already exists
            // if (FacadesFile::exists($outputImagePath)) {
            //     // FacadesFile::delete($outputImagePath);
            //     // Storage::move($oldFilePath, $newFilePath);
            // }

            // Save the resulting image to a file, overwriting if it already exists
            $canvas->save($outputImagePath);
        }


        $bgcolor = convertColorStringToArray(request()->get('bgcolor'));
        $output_path =$path = str_replace('public','storage',request()->get('output_path'));


        changeImageBackgroundColor(request()->get('image_path'), $bgcolor,$output_path );

        $response = [
            'status' => 'success',
            'message' => 'Background Changed Successfully',
            'image_path' => $output_path
        ];
        return response()->json($response);

        // return back()->with('success','Background Changed Successfully');

    }

}
