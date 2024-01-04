<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Facades\File as FacadesFile;
use App\Models\ProductAttributeValue;

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

    public function showdesigner(){
        // $colors = ProductAttributeValue::where('parent_id',1)->pluck('attribute_value')->toArray();

        // $colors = [
        //     'primary' => [
        //         'red' => '#FF0000',
        //         'blue' => '#0000FF',
        //         'yellow' => '#FFFF00',
        //     ],
        
        //     'secondary' => [
        //         'green' => '#008000',
        //         'orange' => '#FFA500',
        //         'purple' => '#800080',
        //     ],
        
        //     'tertiary' => [
        //         'yellow-orange' => '#FFC300',
        //         'red-orange' => '#FF5733',
        //         'red-purple' => '#C70039',
        //         'blue-purple' => '#6A0DAD',
        //         'blue-green' => '#0D98BA',
        //         'yellow-green' => '#9ACD32',
        //     ],
        
        //     'neutral' => [
        //         'black' => '#000000',
        //         'white' => '#FFFFFF',
        //         'gray' => '#808080',
        //         'brown' => '#A52A2A',
        //         'beige' => '#F5F5DC',
        //     ],
        
        //     'warm' => [
        //         'penn-red' => '#931D0A',
        //         'sinopia' => '#D1340B',
        //         'orange-(pantone)' => '#F65E0A',
        //         'carrot-orange' => '#F69A2C',
        //         'aureolin' => '#F7E609'
        
        //     ],
        
        //     'cool' => [
        //         'blue' => '#0000FF',
        //         'green' => '#008000',
        //         'purple' => '#800080',
        //     ],
        
        //     'metallic' => [
        //         'gold' => '#FFD700',
        //         'silver' => '#C0C0C0',
        //         'bronze' => '#CD7F32',
        //         'copper' => '#B87333',
        //     ],
        
        //     'pastel' => [
        //         'pale-pink' => '#FADADD',
        //         'soft-blue' => '#AEC6CF',
        //         'light-green' => '#77DD77',
        //         'lavender' => '#E6E6FA',
        //     ],
        
        //     'vibrant-bright' => [
        //         'neon-pink' => '#FF6EC7',
        //         'electric-blue' => '#7DF9FF',
        //         'lime-green' => '#32CD32',
        //     ],
        
        //     'earth-tones' => [
        //         'olive-green' => '#808000',
        //         'terracotta' => '#E2725B',
        //         'mustard-yellow' => '#FFDB58',
        //         'rust' => '#B7410E',
        //     ],
        
        //     'jewel-tones' => [
        //         'emerald-green' => '#50C878',
        //         'sapphire-blue' => '#0F52BA',
        //         'ruby-red' => '#9B111E',
        //         'amethyst-purple' => '#9966CC',
        //     ],
        // ];

        $colors = config('colors');


        return view('panel.photo-studio.creator',compact('colors'));

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


        // return view('main', ['imagePath' => $filePath,'textPrompt' => $textPrompt]);
        return response()->json(['imagePath' => asset("storage/{$filePath}"), 'textPrompt' => $textPrompt]);
    }

    public function generateImageFromImage(Request $request)
    {
        //Input Processing
        $request->validate([
            'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'text' => 'required|string|max:255',
        ]);
        $uploadedImage = $request->file('image');
        $imageData = base64_encode(file_get_contents($uploadedImage->getRealPath()));

        //Store input image
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $initImagePath = public_path("images/" . $imageName);

        //Text Prompt
        $textTweak = $request->input('text');
        // $imageData =  base64_encode(file_get_contents($initImagePath));
        $textPrompt = "Modifications:$textTweak";

        //API Setup
        $engineId = 'stable-diffusion-xl-1024-v1-0';
        $apiHost = getenv("API_HOST") ?: "https://api.stability.ai";
        $apiKey = getenv("STABILITY_API_KEY");
        if ($apiKey === null) {
            throw new \Exception("Missing Stability API key.");
        }

        //API call
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "$apiHost/v1/generation/$engineId/image-to-image",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => [
                "init_image" => new \CURLFile($initImagePath),
                "image_strength" => 0.25,
                "init_image_mode" => "IMAGE_STRENGTH",
                "text_prompts[0][text]" => $textPrompt,
                "cfg_scale" => 15,
                "samples" => 1,
                "steps" => 40
            ],
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Authorization: Bearer $apiKey"
            ],
        ]);

        //API Response
        $response = curl_exec($curl);
        $err = curl_error($curl);

        //Close connection
        curl_close($curl);

        $imagePaths = [];

        //ERROR Message
        if ($err) {
            throw new \Exception("cURL Error #:" . $err);
        } else {
            // echo "Raw Response: " . $response; //Checking response
            $data = json_decode($response, true);



            // return response()->json($data);
            if ($data === null) {
                throw new \Exception("Invalid JSON response");
            }

            if (!isset($data["artifacts"])) {
                throw new \Exception("Missing artifacts in response");
            }

            $outputDir = "storage/AI-generated";
            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0777, true);
            }



            foreach ($data["artifacts"] as $i => $artifact) {
                $timestamp = now()->timestamp;
                $imageData = base64_decode($artifact["base64"]);
                $filePath = "$outputDir/v2_$timestamp._img2img_$i.png";
                file_put_contents($filePath, $imageData);
                $imagePaths[] = $filePath;
            }

            unlink($initImagePath);
        }

        return response()->json(['imagePath' => asset("{$filePath}"), 'textPrompt' => $textPrompt]);
        // return view('main')->with(['imagePaths' => $imagePaths]);
    }


    protected function saveImageToFile($data, $filePath)
    {
        Storage::disk('public')->put($filePath, $data);
    }




}
