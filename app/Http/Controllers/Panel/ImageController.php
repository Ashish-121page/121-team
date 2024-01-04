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

        $url = ENV('REMOVE_BACKGROUND_API_URL');

        $response = Http::attach(
            'file', file_get_contents($file), $filename
        )->post($url,[
            'Myfilename' => $filename,
            'api_key' => ENV('REMOVE_BACKGROUND_API_KEY'),
        ]);


        if ($response->successful()) {
            // Process successful response
            if ($request->ajax()) {
                $reposne = json_decode($response->body());
                $data_url = ['data_url' => convertImageUrlToDataUrl(json_decode($response->body())->url)];
                $reposne = array_merge( (array) $reposne,$data_url);
                return response()->json(json_encode($reposne));
            }else{
                $url = json_decode($response->body(),true)['url'];
                return $url;
            }

        } else {
            // Handle errors
            $errorCode = $response->status();
        }


    }


    // public function changebg() {

    //     function convertColorStringToArray($colorString) {
    //         $colorArray = [];

    //         // Regular expression to match rgb or rgba strings
    //         $pattern = "/rgba?\((\d{1,3}), (\d{1,3}), (\d{1,3})(, [\d\.]+)?\)/";

    //         if (preg_match($pattern, $colorString, $matches)) {
    //             // Extract the red, green, and blue values
    //             $colorArray = [
    //                 'r' => (int) $matches[1],
    //                 'g' => (int) $matches[2],
    //                 'b' => (int) $matches[3]
    //             ];

    //             // If alpha value is present, add it to the array
    //             if (isset($matches[4])) {
    //                 $colorArray['a'] = floatval(trim($matches[4], ', '));
    //             }
    //         }

    //         return $colorArray;
    //     }


    //     function changeImageBackgroundColor($originalImagePath, $newBackgroundColor, $outputImagePath) {
    //         $image = Image::make($originalImagePath);

    //         // Create a canvas with the desired background color
    //         $canvas = Image::canvas($image->width(), $image->height(), $newBackgroundColor);

    //         // Place the original image on top of the canvas
    //         $canvas->insert($image, 'top-left', 0, 0);

    //         // Check if the output file already exists
    //         // if (FacadesFile::exists($outputImagePath)) {
    //         //     // FacadesFile::delete($outputImagePath);
    //         //     // Storage::move($oldFilePath, $newFilePath);
    //         // }

    //         // Save the resulting image to a file, overwriting if it already exists
    //         $canvas->save($outputImagePath);
    //     }


    //     $bgcolor = convertColorStringToArray(request()->get('bgcolor')) ?? 'rgb(255,255,255)';
    //     $output_path = $path = str_replace('public','storage',request()->get('output_path'));


    //     changeImageBackgroundColor(request()->get('image_path'), $bgcolor,$output_path );


    //     $response = [
    //         'status' => 'success',
    //         'message' => 'Background Changed Successfully',
    //         'image_path' => $output_path
    //     ];
    //     return response()->json($response);
    // }


    public function changebg() {
        function convertColorStringToArray($colorString) {
            $colorArray = [];

            // Add support for hex color codes
            if (preg_match('/^#?([a-f0-9]{6}|[a-f0-9]{3})$/i', $colorString)) {
                $colorString = str_replace('#', '', $colorString);
                if (strlen($colorString) == 3) {
                    $colorString = $colorString[0] . $colorString[0] . $colorString[1] . $colorString[1] . $colorString[2] . $colorString[2];
                }
                $colorArray = [
                    'r' => hexdec(substr($colorString, 0, 2)),
                    'g' => hexdec(substr($colorString, 2, 2)),
                    'b' => hexdec(substr($colorString, 4, 2))
                ];
            } else {
                // Handle RGB and RGBA colors
                $pattern = "/rgba?\((\d{1,3}), (\d{1,3}), (\d{1,3})(, [\d\.]+)?\)/";
                if (preg_match($pattern, $colorString, $matches)) {
                    $colorArray = [
                        'r' => (int) $matches[1],
                        'g' => (int) $matches[2],
                        'b' => (int) $matches[3]
                    ];
                    if (isset($matches[4])) {
                        $colorArray['a'] = floatval(trim($matches[4], ', '));
                    }
                }
            }

            return $colorArray;
        }

        function changeImageBackgroundColor($originalImagePath, $newBackgroundColor, $outputImagePath) {
            try {
                $image = Image::make($originalImagePath);

                // Create a canvas with the desired background color
                $canvas = Image::canvas($image->width(), $image->height(), $newBackgroundColor);

                // Place the original image on top of the canvas
                $canvas->insert($image, 'top-left', 0, 0);

                // Save the resulting image to a file, handling file existence
                if (FacadesFile::exists($outputImagePath)) {
                    FacadesFile::delete($outputImagePath);
                }
                $canvas->save($outputImagePath);

            } catch (Exception $e) {
                // Handle exceptions such as file not found, permission issues, etc.
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        $bgcolor = request()->get('bgcolor') ? convertColorStringToArray(request()->get('bgcolor')) : 'rgb(255,255,255)';
        $imagePath = request()->get('image_path');
        $outputPath = request()->get('output_path') ? str_replace('public', 'storage', request()->get('output_path')) : null;

        if (!$imagePath || !$outputPath) {
            return response()->json(['error' => 'Invalid input parameters'], 400);
        }

        changeImageBackgroundColor($imagePath, $bgcolor, $outputPath);

        return response()->json([
            'status' => 'success',
            'message' => 'Background Changed Successfully',
            'image_path' => $outputPath
        ]);
    }



    public function cropimage(Request $request)
    {
        $dataUrl = $request->input('image');
        $oldFilePath =$request->input('old_path');

        // $filename = basename($oldFilePath);
        // $user_id = auth()->id();
        // $path = "storage/files/$user_id/$filename";
        // $linked = \App\Models\Media::where('path',$path)->groupBy('type_id')->pluck('type_id');
        // $models = \App\Models\Product::whereIn('id',$linked)->groupBy('model_code')->pluck('model_code');

        list($type, $data) = explode(';', $dataUrl);
        list(, $data) = explode(',', $data);


        $imageData = base64_decode($data);

        $disk = 'public';
        $fullOldFilePath = $disk . '/' . $oldFilePath;


        $user_id = auth()->user()->id;
        $destinationPath = "public/files/$user_id/edited_old/".time()."-" . basename($oldFilePath);
        if (!Storage::exists($destinationPath)) {
            $data = Storage::move($oldFilePath,$destinationPath, 'public');
        }


        if (Storage::exists($fullOldFilePath)) {
            Storage::delete($fullOldFilePath);
        }


        Storage::put($oldFilePath, $imageData, 'public');
        return response()->json(['message' => 'Image replaced successfully']);


    }


    public function photoStudio($file_path) {
        $file_path = decrypt($file_path);
        return view('panel.photo-studio.index',compact('file_path'));
    }






}
