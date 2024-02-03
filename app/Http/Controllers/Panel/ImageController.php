<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Facades\File as FacadesFile;
use App\Models\ProductAttributeValue;
use GuzzleHttp\Client;
use App\Models\MayaImage;
use App\Models\UserShopItem;
use App\Models\Media;


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

        // magicstring(request()->all());

        // return;


        // $filename = basename($oldFilePath);
        // $user_id = auth()->id();
        // $path = "storage/files/$user_id/$filename";
        // $linked = \App\Models\Media::where('path',$path)->groupBy('type_id')->pluck('type_id');
        // $models = \App\Models\Product::whereIn('id',$linked)->groupBy('model_code')->pluck('model_code');

        list($type, $data) = explode(';', $dataUrl);
        list(, $data) = explode(',', $data);


        $imageData = base64_decode($data);

        $disk = 'public';
        // $fullOldFilePath = $disk . '/' . $oldFilePath;
        $user_id = auth()->user()->id;


        $fullOldFilePath = "public/files/$user_id/".basename($oldFilePath);;

        if (Storage::exists($fullOldFilePath)) {

            if ($request->get('keepnamecheck') == 'keeporiginal') {
                // ` Keep Original File in Edited Old Folder...
                $new_move_fullOldFilePath = "public/files/$user_id/edited_old/".time().'-'.basename($oldFilePath);;
                // // Todo: Move the file or Say Keep The Original File...
                Storage::move($fullOldFilePath, $new_move_fullOldFilePath);

                // Todo: making Up the Media Table Record...
                $new_move_fullOldFilePath = str_replace('public','storage',$new_move_fullOldFilePath);

                // Todo: Finding the Media ID...
                $exits_recs = Media::where('path',str_replace('public','storage',$oldFilePath))->get();

                if ($exits_recs->count() > 0) {
                    // Todo: magicstring($exits_rec);
                    foreach ($exits_recs as $key => $exits_rec) {
                        $new_ids = [];
                        $newrecc = $exits_rec->replicate();
                        $newrecc = $newrecc->fill([
                            'path' => $new_move_fullOldFilePath,
                            'type_id' => $exits_rec->type_id,
                        ]);
                        $newrecc->save();
                        array_push($new_ids,$newrecc->id);
                    }

                    foreach ($exits_recs as $key => $exits_rec) {
                        $usi = UserShopItem::where('product_id',$exits_rec->type_id ?? '')->first();
                        if ($usi != null) {
                            $imgs = explode(",", $usi->images);
                            $imgs = array_merge($imgs,$new_ids);
                            $usi->images = implode(",",$imgs);
                            $usi->save();
                        }
                    }


                }
            }else{
                // ! Delete the old file...
                Storage::delete($fullOldFilePath);
            }

        }

        // Todo: Making New IMage...
        Storage::put($oldFilePath, $imageData, 'public');

        return response()->json(['message' => 'Image replaced successfully']);


    }

    public function photoStudio($file_path) {
        $file_path = decrypt($file_path);
        return view('panel.photo-studio.index',compact('file_path'));
    }

    public function showdesigner(){

        $colors = config('colors');

        $existing_image = MayaImage::where('user_id',auth()->user()->id)->latest()->first();


        return view('panel.photo-studio.creator',compact('colors','existing_image'));

    }

    public function generateImage(Request $request)
    {


        $typeOfProduct = $request->input('type_of_product');
        $stylePreferences = $request->input('style_preferences');
        $colorScheme = $request->input('color_scheme');
        $colorPalette = $request->input('color_palette');
        $materials = $request->input('materials');
        $remarks = $request->input('remarks');

        $textPrompt = "Type of Product: $typeOfProduct, Style Preferences: $stylePreferences, Color Scheme: $colorScheme, Color Palette: $colorPalette, Material: $materials, Remarks: $remarks";



        // Fetch environment variables
        $engineId = 'stable-diffusion-xl-1024-v1-0';
        $apiHost = env('STABILITY_API_HOST', 'https://api.stability.ai');
        $apiKey = env('STABILITY_API_KEY');

        if ($apiKey === null) {
            throw new \Exception("Missing Stability API key.");
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$apiKey}",
        ])->post("{$apiHost}/v1/generation/{$engineId}/text-to-image", [
            'text_prompts' => [
                ['text' => $textPrompt]
            ],
            'cfg_scale' => 7,
            'height' => 1024,
            'width' => 1024,
            'samples' => 1,
            'steps' => 30,
        ]);

        if ($response->status() !== 200) {
            // throw new \Exception("Non-200 response: " . $response->body());
            $errorResponse = $response->json();
            throw new \Exception("Non-200 response: " . $response->body() . ". Error: " . json_encode($errorResponse));
        }

        $data = $response->json();
        $currentTimestamp = now()->timestamp;
        foreach ($data['artifacts'] as $i => $image) {
            $base64Data = base64_decode($image['base64']);
            $filePath = "AI-generated/v1_txt2img_{$i}_{$currentTimestamp}.png";
            $this->saveImageToFile($base64Data, $filePath);
        }

        $imagePaths = session()->get('imagePaths', []);
        $imagePaths[] = asset("storage/{$filePath}");
        session(['imagePaths' => $imagePaths]);


        $media = Media::create([
            'type_id' => auth()->user()->id,
            'path' => "storage/".$filePath,
            'type' => 'PD-NEW',
            'file_name' => $filePath,
            'extension' => 'png',
            'tag' => 'AI-generated',
        ]);

        MayaImage::create([
            'user_id' => auth()->user()->id,
            'maya_path' => $filePath,
            'type_of_product' => $typeOfProduct,
            'Preferences' => $textPrompt,
            'media_id' => $media->id,
        ]);


        // return view('main', ['imagePath' => $filePath,'textPrompt' => $textPrompt]);
        return response()->json(['imagePath' => asset("storage/{$filePath}"), 'textPrompt' => $textPrompt]);
    }

    // public function generateImageFromImage(Request $request)
    // {
    //     //Input Processing
    //     $request->validate([
    //         'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
    //         'text' => 'required|string|max:255',
    //     ]);
    //     $uploadedImage = $request->file('image');
    //     $imageData = base64_encode(file_get_contents($uploadedImage->getRealPath()));

    //     //Store input image
    //     $imageName = time() . '.' . $request->image->extension();
    //     $request->image->move(public_path('images'), $imageName);
    //     $initImagePath = public_path("images/" . $imageName);

    //     //Text Prompt
    //     $textTweak = $request->input('text');
    //     // $imageData =  base64_encode(file_get_contents($initImagePath));
    //     $textPrompt = "Modifications:$textTweak";

    //     //API Setup
    //     $engineId = 'stable-diffusion-xl-1024-v1-0';
    //     $apiHost = getenv("API_HOST") ?: "https://api.stability.ai";
    //     $apiKey = getenv("STABILITY_API_KEY");
    //     if ($apiKey === null) {
    //         throw new \Exception("Missing Stability API key.");
    //     }

    //     //API call
    //     $curl = curl_init();
    //     curl_setopt_array($curl, [
    //         CURLOPT_URL => "$apiHost/v1/generation/$engineId/image-to-image",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_POSTFIELDS => [
    //             "init_image" => new \CURLFile($initImagePath),
    //             "image_strength" => 0.25,
    //             "init_image_mode" => "IMAGE_STRENGTH",
    //             "text_prompts[0][text]" => $textPrompt,
    //             "cfg_scale" => 15,
    //             "samples" => 1,
    //             "steps" => 40
    //         ],
    //         CURLOPT_HTTPHEADER => [
    //             "Accept: application/json",
    //             "Authorization: Bearer $apiKey"
    //         ],
    //     ]);

    //     //API Response
    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);

    //     //Close connection
    //     curl_close($curl);

    //     $imagePaths = [];

    //     //ERROR Message
    //     if ($err) {
    //         throw new \Exception("cURL Error #:" . $err);
    //     } else {
    //         // echo "Raw Response: " . $response; //Checking response
    //         $data = json_decode($response, true);



    //         // return response()->json($data);
    //         if ($data === null) {
    //             throw new \Exception("Invalid JSON response");
    //         }

    //         if (!isset($data["artifacts"])) {
    //             throw new \Exception("Missing artifacts in response");
    //         }

    //         $outputDir = "storage/AI-generated";
    //         if (!file_exists($outputDir)) {
    //             mkdir($outputDir, 0777, true);
    //         }



    //         foreach ($data["artifacts"] as $i => $artifact) {
    //             $timestamp = now()->timestamp;
    //             $imageData = base64_decode($artifact["base64"]);
    //             $filePath = "$outputDir/v2_$timestamp._img2img_$i.png";
    //             file_put_contents($filePath, $imageData);
    //             $imagePaths[] = $filePath;
    //         }

    //         unlink($initImagePath);
    //     }

    //     return response()->json(['imagePath' => asset("{$filePath}"), 'textPrompt' => $textPrompt]);
    //     // return view('main')->with(['imagePaths' => $imagePaths]);
    // }



    // public function generateImageFromImage(Request $request)
    // {
    //     // return response()->json(['imagePaths' => "http://localhost/project/121.page-Laravel/121.page/storage/v2_1704876661._img2img_0.png" , 'textPrompt' => 'Modifications:Change bulk color to blue', 'condition' => 'true']);
    //     // return;
    //     //Input Processing
    //     // $request->validate([
    //     //     // 'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
    //     //     'image' => 'required|string|max:255',
    //     //     'text' => 'required|string|max:255',
    //     // ]);


    //     $uploadedImage = $request->get('image');

    //     $uploadedImage = str_replace('\\/', '/', $uploadedImage);

    //     $imageData = base64_encode(file_get_contents($uploadedImage));
    //     $extension = pathinfo($uploadedImage, PATHINFO_EXTENSION);

    //     $imageName = 'AI-generated/edited/'.time() . 'AI-GENRATED-IMAGE.' . $extension;
    //     Storage::disk('public')->put($imageName, base64_decode($imageData));

    //     $initImagePath = public_path("storage/" . $imageName);

    //     //Text Prompt
    //     $textTweak = $request->input('text');
    //     // $imageData =  base64_encode(file_get_contents($initImagePath));
    //     $textPrompt = "Modifications:$textTweak";

    //     //API Setup
    //     $engineId = 'stable-diffusion-xl-1024-v1-0';
    //     $apiHost = getenv("API_HOST") ?: "https://api.stability.ai";
    //     $apiKey = getenv("STABILITY_API_KEY");
    //     if ($apiKey === null) {
    //         throw new \Exception("Missing Stability API key.");
    //     }

    //     //API call
    //     $curl = curl_init();
    //     curl_setopt_array($curl, [
    //         CURLOPT_URL => "$apiHost/v1/generation/$engineId/image-to-image",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_POSTFIELDS => [
    //             "init_image" => new \CURLFile($initImagePath),
    //             "image_strength" => 0.25,
    //             "init_image_mode" => "IMAGE_STRENGTH",
    //             "text_prompts[0][text]" => $textPrompt,
    //             "cfg_scale" => 15,
    //             "samples" => 1,
    //             "steps" => 40
    //         ],
    //         CURLOPT_HTTPHEADER => [
    //             "Accept: application/json",
    //             "Authorization: Bearer $apiKey"
    //         ],
    //     ]);

    //     //API Response
    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);

    //     //Close connection
    //     curl_close($curl);

    //     $imagePaths = [];

    //     //ERROR Message
    //     if ($err) {
    //         throw new \Exception("cURL Error #:" . $err);
    //     } else {
    //         // echo "Raw Response: " . $response; //Checking response
    //         $data = json_decode($response, true);

    //         if ($data === null) {
    //             throw new \Exception("Invalid JSON response");
    //         }

    //         if (!isset($data["artifacts"])) {
    //             throw new \Exception("Missing artifacts in response");
    //         }

    //         $outputDir = "storage";
    //         if (!file_exists($outputDir)) {
    //             mkdir($outputDir, 0777, true);
    //         }



    //         foreach ($data["artifacts"] as $i => $artifact) {
    //             $timestamp = now()->timestamp;
    //             $imageData = base64_decode($artifact["base64"]);
    //             $filePath = "$outputDir/v2_$timestamp._img2img_$i.png";
    //             file_put_contents($filePath, $imageData);
    //             $filePath = str_replace(' ','',$filePath);
    //             $imagePaths[] = asset($filePath);
    //         }

    //         unlink($initImagePath);
    //     }

    //     $condition = true;

    //     // return response()->json(['imagePaths' => $imagePaths, 'textPrompt' => $textPrompt, 'condition' => $condition]);
    // }


    public function generateImageFromImage(Request $request)
    {


        // Input Processing
        $request->validate([
            'image' => 'required|string|max:255',
            'text' => 'required|string|max:255',
        ]);

        $uploadedImage = $request->get('image');
        $uploadedImage = str_replace('\\/', '/', $uploadedImage);


        // Image Data Processing
        $imageData = base64_encode(file_get_contents($uploadedImage));
        $extension = pathinfo($uploadedImage, PATHINFO_EXTENSION);
        $imageName = 'AI-generated/edited/' . time() . 'AI-GENERATED-IMAGE.' . $extension;

        // Save the base64-encoded image data to the storage path
        Storage::disk('public')->put($imageName, base64_decode($imageData));

        // Get the path where the image is stored
        $initImagePath = storage_path("app/public/" . $imageName);

        // Text Prompt
        $textTweak = $request->input('text');
        $textPrompt = "Modifications: $textTweak";

        // API Setup
        $engineId = 'stable-diffusion-xl-1024-v1-0';
        $apiHost = env("API_HOST", "https://api.stability.ai");
        $apiKey = env("STABILITY_API_KEY");

        if ($apiKey === null) {
            return response()->json(['error' => 'Missing Stability API key'], 500);
        }

        // Create a Guzzle HTTP client
        $client = new Client();

        // API Call using Guzzle
        try {
            $response = $client->post("$apiHost/v1/generation/$engineId/image-to-image", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer $apiKey",
                ],
                'multipart' => [
                    [
                        'name' => 'init_image',
                        'contents' => fopen($initImagePath, 'r'),
                    ],
                    [
                        'name' => 'image_strength',
                        'contents' => 0.35,
                    ],
                    [
                        'name' => 'init_image_mode',
                        'contents' => 'IMAGE_STRENGTH',
                    ],
                    [
                        'name' => 'text_prompts[0][text]',
                        'contents' => $textPrompt,
                    ],
                    [
                        'name' => 'cfg_scale',
                        'contents' => 5,
                    ],
                    [
                        'name' => 'samples',
                        'contents' => 1,
                    ],
                    [
                        'name' => 'steps',
                        'contents' => 30,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data === null || !isset($data["artifacts"])) {
                return response()->json(['error' => 'Invalid or missing response data'], 500);
            }

            $outputDir = "storage/AI-generated/edited/";
            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0777, true);
            }

            $imagePaths = [];
            $filePath = [];

            foreach ($data["artifacts"] as $i => $artifact) {
                $timestamp = now()->timestamp;
                $imageData = base64_decode($artifact["base64"]);
                $filePath = "$outputDir/v2_$timestamp._img2img_$i.png";
                file_put_contents($filePath, $imageData);
                $filePath = str_replace(' ', '', $filePath);
                $imagePaths[] = asset($filePath);
            }

            unlink($initImagePath);

            $media = Media::create([
                'type_id' => auth()->user()->id,
                'path' => $filePath,
                'type' => 'PD-EDIT',
                'file_name' => $imageName,
                'extension' => 'png',
                'tag' => 'AI-generated',
            ]);

            MayaImage::create([
                'user_id' => auth()->user()->id,
                'maya_path' => $filePath,
                'type_of_product' => Null,
                'Preferences' => $textPrompt,
                'media_id' => $media->id,
            ]);



            return response()->json(['imagePaths' => $imagePaths, 'textPrompt' => $textPrompt, 'condition' => true]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    public function editImage(Request $request)
    {
        // Validate the form inputs
        // $request->validate([
        //     'editImage' => 'required|string',
        //     'editText' => 'required|string|max:255',
        // ]);

        // Retrieve inputs from the form
        $editImage = $request->input('editImage');

        echo "input: " . $editImage;
        $editText = $request->input('editText');

        // Process the image and text inputs
        $initImagePath = public_path("images/init_image.png"); // Use an appropriate path
        file_put_contents($initImagePath, file_get_contents($editImage));

        // Text Prompt
        $textTweak = $editText;
        $textPrompt = "Modifications:$textTweak";

        // API Setup (similar to your original method)
        $engineId = 'stable-diffusion-xl-1024-v1-0';
        $apiHost = getenv("API_HOST") ?: "https://api.stability.ai";
        $apiKey = getenv("STABILITY_API_KEY");
        if ($apiKey === null) {
            throw new \Exception("Missing Stability API key.");
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "$apiHost/v1/generation/$engineId/image-to-image",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                "init_image" => new \CURLFile($initImagePath),
                "image_strength" => 0.25,
                "init_image_mode" => "IMAGE_STRENGTH",
                'text_prompts' => [
                    ['text' => $textPrompt]
                ],
                "cfg_scale" => 15,
                "samples" => 1,
                "steps" => 40
            ]),
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Authorization: Bearer $apiKey"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $editPaths = [];

        // Handle the API response
        if ($err) {
            throw new \Exception("cURL Error #:" . $err);
        } else {
            echo "Raw Response: " . $response; //Checking response
            $data = json_decode($response, true);

            if ($data === null) {
                throw new \Exception("Invalid JSON response");
            }

            if (!isset($data["artifacts"])) {
                throw new \Exception("Missing artifacts in response");
            }

            $outputDir = "storage";
            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0777, true);
            }



            foreach ($data["artifacts"] as $i => $artifact) {
                $timestamp = now()->timestamp;
                $imageData = base64_decode($artifact["base64"]);
                $filePath = "$outputDir/v3_$timestamp._img2img_$i.png";
                file_put_contents($filePath, $imageData);
                $editPaths[] = $filePath;
            }

            unlink($initImagePath);
        }
        $condition = true;

        return view('main')->with(['editPaths' => $editPaths, 'condtion' => $condition]);
    }



    protected function saveImageToFile($data, $filePath)
    {
        Storage::disk('public')->put($filePath, $data);
    }




}
