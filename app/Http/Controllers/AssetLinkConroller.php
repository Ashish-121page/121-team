<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\UserShopItem;
use App\Models\Media;
use App\Models\Category;
use App\User;

class AssetLinkConroller extends Controller
{
    // -- Index page of Asset Link Controller
    public function index()
    {
        return json_encode([
            'status' => 'success',
            'message' => 'Asset Link Controller'
        ]);

    }

    // -- Uploading FIles to Vault
    public function storefile(Request $request){
        try {
            if ($request->hasFile('file') && $request->file('file')->isValid()){
                $user = auth()->user();
                $folder = "files/$user->id/vaults/";
                $upload_path = storage_path("app/public/$folder");
                $file = $request->file('file');

                $chk_upload_path = storage_path("app/public/$folder/").$file->getClientOriginalName();

                $file_name = $file->getClientOriginalName();
                if (!file_exists($chk_upload_path)) {
                    $path = $file->move($upload_path, $file_name);
                    return json_encode([
                        'status' => 'success',
                        'message' => 'File uploaded successfully',
                        'code' => 200 , // File uploaded successfully
                        'path' => asset('storage/'.$folder.$file_name),
                        'success' => true
                    ]);
                }else{
                    return json_encode([
                        'status' => 'error',
                        'message' => 'File Already Exists',
                        'code' => 110 , // File Already Exists
                        'path' => asset('storage/'.$folder.$file_name),
                        'success' => false
                    ]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            $msg = $th->getMessage();
            return json_encode([
                'status' => 'error',
                'message' => 'File Upload Failed! '.$msg,
                'code' => 100  // File Upload Failed
            ]);
        }
    }


    // -- Spiting Files With Delimiter via form Request
    public function splitfiles(Request $request) {
        $debug = false;
        if ($request->fileData == '') {
            return back()->with('error','No Files Found');
        }
        $File_data = json_decode($request->fileData);
        // ` Product Details....
        $all_products = Product::where('user_id', auth()->user()->id)->get();
        $all_products_modelCodes = $all_products->pluck('model_code','id')->toArray();

        $delimiter = '';
        switch ($request->delimeter_type) {
            case 1:
                $delimiter = '_';
                break;
            case 2:
                $delimiter = '-';
                break;
            case 3:
                $delimiter = '+';
                break;
            case 4:
                $delimiter = '^';
                break;
            case 5:
                $delimiter = '^^';
                break;
            case 6:
                $delimiter = ',';
                break;
            case 7:
                $delimiter = '.';
                break;
            case 8:
                $delimiter = '#';
                break;
            case 9:
                $delimiter = ' ';
                break;

            default:
                $delimiter = '.';
                break;
        }

        // ` Available SKU's for Images .......
        $available_skus = [];
        $Notavailable_skus = [];
        $Invalid_files = [];

        foreach ($File_data as $key => $value) {
            if (strpos($value->FileName, $delimiter) !== false) {
                $sku = explode($delimiter, pathinfo($value->FileName, PATHINFO_FILENAME));
                $sku = $sku[$request->get('delimeter_directiom',0)];
                $sku = trim($sku);
                if (in_array($sku, $all_products_modelCodes)) {
                    $available_skus[array_search($sku, $all_products_modelCodes)] = $sku;
                }else{
                    $Notavailable_skus[] = $sku;
                }
            }else{
                $Invalid_files[] = $value->FileName;
            }
        }

        $Notavailable_skus  = array_unique($Notavailable_skus);
        // magicstring(request()->all());
        if ($request->get('ignore_files') == 1) {
            $ignored_files = $available_skus;
            $available_skus = [];
        }else{
            $ignored_files = [];
        }

        if ($debug) {
            echo "Invalid Files".newline();
            magicstring($Invalid_files);
            echo "Not Available SKU's".newline();
            magicstring($Notavailable_skus);
            echo "Available SKU's".newline();
            magicstring($available_skus);
            return;
        }

        $vault_name = $request->vault_name;
        $delimeter_directiom = $request->get('delimeter_directiom',0);
        return view('panel.user_shop_items.includes.asset-link.create_sku',compact('File_data','delimiter','vault_name','delimeter_directiom','all_products_modelCodes','Notavailable_skus','available_skus','Invalid_files','ignored_files'));
    }

    // -- Saparate Files With Delimiter and Create Products
    public function filllater(Request $request){
        try {
            $debug = true;
            $user = auth()->user();
            // Data of Available SKU's
            $form_available_sku = json_decode(request()->get('form_available_sku'));
            $form_available_sku_files = json_decode(request()->get('form_available_sku_files'),true);
            // Data of Not Available SKU's
            $form_not_available_sku = json_decode(request()->get('form_not_available_sku'));
            $form_not_available_sku_files = json_decode(request()->get('form_not_available_sku_files'),true);

            $created_products = [];
            $delimeter_directiom = $request->get('delimeter_directiom',0);


            if ($request->has('fill_later')) {
                $count = 0;
                $exiting_products = [];

                // ` Available SKU's for Images .......
                foreach ($form_available_sku_files as $key => $form_available_sku_file) {
                    $model_code = explode($request->delimeter, pathinfo($form_available_sku_file['FileName'], PATHINFO_FILENAME));
                    $file_model_code = $model_code[$request->get('delimeter_directiom',0)];
                    $file_model_code = trim($file_model_code);
                    $product = Product::where('model_code',$file_model_code)->where('user_id',$user->id)->first();
                    array_push($exiting_products, $product->id);
                    $usi = UserShopItem::where('product_id',$product->id)->where('user_id',$user->id)->get();
                    $filename = $form_available_sku_file['FileName'];
                    $extension =  explode('.',$filename) ?? [];
                    $extension = end($extension);
                    $path = "storage/files/".$user->id."/vaults/".$filename;


                    $path_mime = storage_path("app/public/files/$user->id/vaults/".$filename);
                    $mime = mime_content_type("$path_mime");
                    $file_type = $this->checkFileType(explode("/",$mime)[0]);
                    $type = 'Product';
                    $tag = $file_type;

                    // creating Media Records
                    $media = new Media();
                    $media->tag = $tag;
                    $media->file_type = explode("/",$mime)[0] ?? 'Image';
                    $media->type = $type;
                    $media->type_id = $product->id;
                    $media->file_name = $filename;
                    $media->path = $path;
                    $media->extension = $extension;
                    $media->vault_name = $request->vault_name ?? '';
                    $media->save();

                    if ($tag == 'Product_Image') {
                        // linking image with Product
                        foreach ($usi as $key => $us) {
                            $exist_image = explode(",",$us->images);
                            if (!in_array($media->id, $exist_image)) {
                                $exist_image[] = $media->id;
                                $us->images = implode(",",$exist_image);
                                $us->save();
                                $count++;
                            }
                        }
                    }

                }


                $chk_undefined = Category::where('name','image_upload')->where('user_id',null)->get();
                if (count($chk_undefined) == 0) {
                    $category = Category::create([
                        'name' => 'image_upload',
                        'category_type_id' => 13,
                        'level' => 2,
                        'parent_id' => null,
                        'user_id' => null,
                        'type' => 1,
                        'icon' => null
                    ]);
                    echo "image_upload Industry Is not Exist".newline();
                }else{
                    echo "image_upload Industry Already Exist".newline();
                    $category = $chk_undefined[0];
                }


                $chk_undefined = Category::where('name','pending')->where('user_id',null)->get();
                if (count($chk_undefined) == 0) {
                    $sub_category = Category::create([
                        'name' => 'pending',
                        'category_type_id' => 13,
                        'level' => 3,
                        'parent_id' => $category->id,
                        'user_id' => null,
                        'type' => 1,
                        'icon' => null
                    ]);
                    echo "image_upload Industry Is not Exist".newline();
                }else{
                    echo "image_upload Industry Already Exist".newline();
                    $sub_category = $chk_undefined[0];
                }



                foreach ($form_not_available_sku_files as $key => $form_not_available_sku_file) {

                    $delimiter = $request->get('delimeter',' ') ?? ' '; // ! If Not Available then Space..
                    $model_code = explode($delimiter, pathinfo($form_not_available_sku_file['FileName'], PATHINFO_FILENAME));
                    $file_model_code = $model_code[$request->get('delimeter_directiom',0)];
                    $file_model_code = trim($file_model_code);

                    // $filename = $form_not_available_sku_file['FileName'];
                    $filename = $form_not_available_sku_file['FileName'];
                    $extension =  explode('.',$filename) ?? [];
                    $extension = end($extension);
                    $path = "storage/files/".$user->id."/vaults/".$filename;


                    $chking_products = Product::where('model_code',$file_model_code)->where('user_id',$user->id)->get();
                    if ($chking_products->count() > 0) {
                        // echo "Product Already Exist".newline();


                        array_push($exiting_products, $chking_products[0]->id);

                        foreach ($chking_products as $key => $product) {
                            $usi = UserShopItem::where('product_id',$product->id)->where('user_id',$user->id)->get();
                            $path_mime = storage_path("app/public/files/$user->id/vaults/".$form_not_available_sku_file['FileName']);
                            $mime = mime_content_type("$path_mime");
                            $file_type = $this->checkFileType(explode("/",$mime)[0]);
                            $type = 'Product';
                            $tag = $file_type;

                            $media = new Media();
                            $media->tag = $tag;
                            $media->file_type = explode("/",$mime)[0] ?? 'Image';
                            $media->type = $type;
                            $media->type_id = $product->id;
                            $media->file_name = $filename;
                            $media->path = $path;
                            $media->vault_name = $request->vault_name ?? '';
                            $media->extension = $extension;
                            $media->save();
                            array_push($created_products, $product->id);


                            // ` creating Media Records ....
                            if ($tag == 'Product_Image') {
                                foreach ($usi as $key => $us) {
                                    $exist_image = explode(",",$us->images);
                                    if (!in_array($media->id, $exist_image)) {
                                        $exist_image[] = $media->id;
                                        $us->images = implode(",",$exist_image);
                                        $us->save();
                                        $count++;
                                    }
                                }
                            }

                        }
                    }else{
                        // echo "Creating New Products".newline();
                        $product = Product::create([
                            'user_id' => $user->id,
                            'model_code' => $file_model_code,
                            'title' => $file_model_code,
                            'description' => 'Fill Later',
                            'price' => 0,
                            'quantity' => 0,
                            'status' => 1,
                            'category_id' => $category->id,
                            'sub_category'=> $sub_category->id,
                            'sku' => 'SKU'.generateRandomStringNative(6),
                            'is_publish' => 1,
                            'shipping' => '{"height":null,"weight":null,"width":null,"length":null,"unit":"kg","length_unit":"mm","gross_weight":null}',
                            'carton_details' => '{"standard_carton":null,"carton_weight":null,"carton_unit":"pc","carton_length":null,"carton_width":null,"carton_height":null,"Carton_Dimensions_unit":"mm"}'
                        ]);

                        array_push($created_products, $product->id);


                        $path_mime = storage_path("app/public/files/$user->id/vaults/".$form_not_available_sku_file['FileName']);
                        $mime = mime_content_type("$path_mime") ?? '';
                        if ($mime == '') {
                            continue;
                        }
                        $file_type = $this->checkFileType(explode("/",$mime)[0]);
                        $type = 'Product';
                        $tag = $file_type;

                        // creating Media Records
                        $media = new Media();
                        $media->tag = $tag;
                        $media->file_type = explode("/",$mime)[0] ?? 'Image';
                        $media->type = $type;
                        $media->type_id = $product->id;
                        $media->file_name = $filename;
                        $media->vault_name = $request->vault_name ?? '';
                        $media->path = $path;
                        $media->extension = $extension;
                        $media->save();


                        $usi = UserShopItem::create([
                            'user_id' => $user->id,
                            'user_shop_id' => getShopDataByUserId($user->id)->id,
                            'is_published' => 1,
                            'category_id' => $category->id,
                            'sub_category_id' => $sub_category->id,
                            'product_id' => $product->id,
                            'status' => 1,
                        ]);

                        if ($tag == 'Product_Image') {

                            $usi->images = $media->id;
                            $usi->save();
                        }
                    }
                    $count++;
                }

                return $this->finalview($created_products);

                // return json_encode([
                //     'status' => 'success',
                //     'message' => 'Creating record with Filename With Delimiter success with '.$count.' records',
                //     'code' => 200 , // Fill Later
                //     'success' => true
                // ]);

            }

            if ($request->has('fill_now')) {
                echo "The Action is Fill Now, pending to Develop";
            }

        } catch (\Throwable $th) {
            throw $th;
            return json_encode([
                'status' => 'error',
                'message' => 'Something Went Wrong',
                'code' => 100 ,
                'success' => false
            ]);
        }

    }



    public function previewPage(Request $request) {

        // ` Available SKU's for Images .......
        $vault_name = $request->vault_name;
        $debug = true;
        $available_skus = [];
        $Notavailable_skus = [];
        $Invalid_files = [];
        if ($request->fileData == '') {
            return back()->with('error','No Files Found');
        }
        $File_data = json_decode($request->fileData);

        // ` Product Details....
        $all_products = Product::where('user_id', auth()->user()->id)->get();
        $all_products_modelCodes = $all_products->pluck('model_code','id')->toArray();

        
        foreach ($File_data as $key => $value) {
            $sku = pathinfo($value->FileName, PATHINFO_FILENAME);
            $sku = trim($sku);
            if (in_array($sku, $all_products_modelCodes)) {
                $available_skus[array_search($sku, $all_products_modelCodes)] = $sku;
            }else{
                $Notavailable_skus[] = $sku;
            }
        }

        $Notavailable_skus  = array_unique($Notavailable_skus);
        if ($request->get('ignore_files') == 1) {
            $ignored_files = $available_skus;
            $available_skus = [];
        }else{
            $ignored_files = [];
        }

        $delimiter = $request->get('delimeter',' ') ?? ' '; // ! If Not Available then Space..
        $delimeter_directiom = $request->get('delimeter_directiom',0);

        // if ($debug) {
        //     magicstring(request()->all());
        //     echo "Invalid Files".newline();
        //     magicstring($Invalid_files);
        //     echo "Not Available SKU's".newline();
        //     magicstring($Notavailable_skus);
        //     echo "Available SKU's".newline();
        //     magicstring($available_skus);
        //     return;
        // }

        return view('panel.user_shop_items.includes.asset-link.create_sku',compact('File_data','available_skus','Notavailable_skus','ignored_files','delimiter','delimeter_directiom','Invalid_files','all_products_modelCodes','all_products','vault_name'));



    }


    // -- Assuming Model code is a File Name and Creating Products...
    public function modelCodeIsFilename(Request $request) {
        try {
            magicstring(request()->all());
            return;

            $fileData = json_decode($request->fileData);
            $user = auth()->user();
            $product = Product::query()->where('user_id', $user->id);
            $count = 0;
            $created_products = [];
            $test = json_decode(request()->get('fileData'));

            foreach ($test as $key => $value) {
                $path = storage_path("app/public/files/$user->id/vaults/".$value->FileName);
                $mime = mime_content_type("$path");
                $file_type = $this->checkFileType(explode("/",$mime)[0]);
                $type = 'Product';
                $tag = $file_type;
            }

            $chk_undefined = Category::where('name','image_upload')->where('user_id',null)->get();
            if (count($chk_undefined) == 0) {
                $category = Category::create([
                    'name' => 'image_upload',
                    'category_type_id' => 13,
                    'level' => 2,
                    'parent_id' => null,
                    'user_id' => null,
                    'type' => 1,
                    'icon' => null
                ]);
                echo "image_upload Industry Is not Exist".newline();
            }else{
                // echo "image_upload Industry Already Exist".newline();
                $category = $chk_undefined[0];
            }


            $chk_undefined = Category::where('name','pending')->where('user_id',null)->get();
            if (count($chk_undefined) == 0) {
                $sub_category = Category::create([
                    'name' => 'pending',
                    'category_type_id' => 13,
                    'level' => 3,
                    'parent_id' => $category->id,
                    'user_id' => null,
                    'type' => 1,
                    'icon' => null
                ]);
                echo "image_upload Industry Is not Exist".newline();
            }else{
                // echo "image_upload Industry Already Exist".newline();
                $sub_category = $chk_undefined[0];
            }

            foreach ($fileData as $key => $file) {
                if ($request->has('ignore_files') && $request->ignore_files == 1){
                    if ($file->FileCode == 110) {
                        continue;
                    }
                }

                $Received_model_code = pathinfo($file->FileName, PATHINFO_FILENAME);
                $filename = $file->FileName;

                $path = "storage/files/".$user->id."/vaults/".$filename;
                $extension =  explode('.',$filename) ?? [];
                $extension = end($extension);

                // echo $Received_model_code.newline();
                $chk_product = $product->where('model_code', $Received_model_code)->get();
                if ($chk_product->count() == 0) {
                    // echo "Creating New Products".newline();
                    $product = Product::create([
                        'user_id' => $user->id,
                        'model_code' => $Received_model_code,
                        'title' => $Received_model_code,
                        'description' => 'Fill Later',
                        'price' => 0,
                        'quantity' => 0,
                        'status' => 1,
                        'category_id' => $category->id,
                        'sub_category'=> $sub_category->id,
                        'sku' => 'SKU'.generateRandomStringNative(6),
                        'is_publish' => 1,
                        'shipping' => '{"height":null,"weight":null,"width":null,"length":null,"unit":"kg","length_unit":"mm","gross_weight":null}',
                        'carton_details' => '{"standard_carton":null,"carton_weight":null,"carton_unit":"pc","carton_length":null,"carton_width":null,"carton_height":null,"Carton_Dimensions_unit":"mm"}'
                    ]);

                    array_push($created_products, $product->id);
                    $path_mime = storage_path("app/public/files/$user->id/vaults/".$file->FileName);
                    $mime = mime_content_type("$path_mime");
                    $file_type = $this->checkFileType(explode("/",$mime)[0]);


                    $type = 'Product';
                    $tag = $file_type;

                    // creating Media Records
                    $media = new Media();
                    $media->tag = $tag;
                    $media->file_type = explode("/",$mime)[0] ?? 'Image';
                    $media->type = $type;
                    $media->type_id = $product->id;
                    $media->file_name = $filename;
                    $media->vault_name = $request->vault_name ?? '';
                    $media->path = $path;
                    $media->extension = $extension;
                    $media->save();
                    $usi = UserShopItem::create([
                        'user_id' => $user->id,
                        'user_shop_id' => getShopDataByUserId($user->id)->id,
                        'is_published' => 1,
                        'category_id' => $category->id,
                        'sub_category_id' => $sub_category->id,
                        'product_id' => $product->id,
                        'status' => 1,
                    ]);

                    if ($tag == 'Product_Image') {
                        $usi->images = $media->id;
                        $usi->save();
                    }
                    $count++;
                } else {
                    // Echo "Product Already Exist".newline();
                    foreach ($chk_product as $key => $product) {
                        $usi = UserShopItem::where('product_id',$product->id)->where('user_id',$user->id)->get();

                        $path_mime = storage_path("app/public/files/$user->id/vaults/".$file->FileName);
                        $mime = mime_content_type("$path_mime");
                        $file_type = $this->checkFileType(explode("/",$mime)[0]);
                        $type = 'Product';
                        $tag = $file_type;

                        // creating Media Records
                        $media = new Media();
                        $media->tag = $tag;
                        $media->file_type = explode("/",$mime)[0] ?? 'Image';
                        $media->type = $type;
                        $media->type_id = $product->id;
                        $media->file_name = $filename;
                        $media->path = $path;
                        $media->vault_name = $request->vault_name ?? '';
                        $media->extension = $extension;
                        $media->save();

                        // array_push($created_products, $product->id);


                        if ($tag == 'Product_Image') {
                            // ` creating Media Records ....
                            foreach ($usi as $key => $us) {
                                $exist_image = explode(",",$us->images);
                                if (!in_array($media->id, $exist_image)) {
                                    $exist_image[] = $media->id;
                                    $us->images = implode(",",$exist_image);
                                    $us->save();
                                    $count++;
                                }
                            }
                        }
                    }
                }

            }

            return $this->finalview($created_products);
            return json_encode([
                'status' => 'success',
                'message' => 'Model Code is Filename created Record: '.$count,
                'code' => 200 , // Fill Later
                'success' => true
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error','Creating Products Failed with code 100');
            return json_encode([
                'status' => 'error',
                'message' => 'Creating Products Failed',
                'code' => 100 ,
                'success' => false
            ]);
        }
    }

    // -- Assuming All File Names are Irrlevant and Creating Products o Basis
    // -- on Defined Model code index and Profix set by a Settings...
    public function irrelevantFilename(Request $request) {

        try {
            $fileData = json_decode($request->fileData);
            $user = auth()->user();
            $USer_settings = json_decode($user->settings) ?? [];
            $model_code_mark = $USer_settings->model_code_mark ?? '';
            $model_code_index = $USer_settings->model_code_index ?? 1;
            $count = 0;
            $created_products = [];

            $chk_undefined = Category::where('name','image_upload')->where('user_id',null)->get();
            if (count($chk_undefined) == 0) {
                $category = Category::create([
                    'name' => 'image_upload',
                    'category_type_id' => 13,
                    'level' => 2,
                    'parent_id' => null,
                    'user_id' => null,
                    'type' => 1,
                    'icon' => null
                ]);
                echo "image_upload Industry Is not Exist".newline();
            }else{
                // echo "image_upload Industry Already Exist".newline();
                $category = $chk_undefined[0];
            }


            $chk_undefined = Category::where('name','pending')->where('user_id',null)->get();
            if (count($chk_undefined) == 0) {
                $sub_category = Category::create([
                    'name' => 'pending',
                    'category_type_id' => 13,
                    'level' => 3,
                    'parent_id' => $category->id,
                    'user_id' => null,
                    'type' => 1,
                    'icon' => null
                ]);
                echo "image_upload Industry Is not Exist".newline();
            }else{
                // echo "image_upload Industry Already Exist".newline();
                $sub_category = $chk_undefined[0];
            }

            foreach ($fileData as $key => $file) {

                if ($request->has('ignore_files') && $request->ignore_files == 1){
                    if ($file->FileCode == 110) {
                        continue;
                    }
                }


                $avl_modelCode = $this->checkmodelCode($model_code_mark,$model_code_index,$user->id);
                $filename = $file->FileName;

                $path = "storage/files/".$user->id."/vaults/".$filename;
                $extension =  explode('.',$filename) ?? [];
                $extension = end($extension);


                $path_mime = storage_path("app/public/files/$user->id/vaults/".$filename);
                $mime = mime_content_type("$path_mime");
                $file_type = $this->checkFileType(explode("/",$mime)[0]);
                $type = 'Product';
                $tag = $file_type;



                $product = Product::create([
                    'user_id' => $user->id,
                    'model_code' => $avl_modelCode,
                    'name' => $avl_modelCode,
                    'description' => 'Fill Later',
                    'price' => 0,
                    'quantity' => 0,
                    'status' => 1,
                    'category_id' => $category->id,
                    'sub_category'=> $sub_category->id,
                    'sku' => 'SKU'.generateRandomStringNative(6),
                    'is_publish' => 1,
                    'shipping' => '{"height":null,"weight":null,"width":null,"length":null,"unit":"kg","length_unit":"mm","gross_weight":null}',
                    'carton_details' => '{"standard_carton":null,"carton_weight":null,"carton_unit":"pc","carton_length":null,"carton_width":null,"carton_height":null,"Carton_Dimensions_unit":"mm"}'
                ]);

                array_push($created_products, $product->id);

                // creating Media Records
                $media = new Media();
                $media->tag = "Product_Image";
                $media->file_type = $file_type ??  "Image";
                $media->type = "Product";
                $media->type_id = $product->id;
                $media->file_name = $filename;
                $media->vault_name = $request->vault_name ?? '';
                $media->path = $path;
                $media->extension = $extension;
                $media->save();

                $usi = UserShopItem::create([
                    'user_id' => $user->id,
                    'user_shop_id' => getShopDataByUserId($user->id)->id,
                    'is_published' => 1,
                    'category_id' => $category->id,
                    'sub_category_id' => $sub_category->id,
                    'product_id' => $product->id,
                    'images' => $media->id,
                    'status' => 1,
                ]);

                $count++;
            }


            return $this->finalview($created_products);
            return json_encode([
                'status' => 'success',
                'message' => 'Fill with Irrelevant File name create '.$count." records",
                'code' => 200 ,
                'success' => true,
                'created_products' => json_encode($created_products)
            ]);

        } catch (\Throwable $th) {
            throw $th;
            return json_encode([
                'status' => 'error',
                'message' => 'Fill with Irrelevant File name Failed',
                'code' => 100 ,
                'success' => false
            ]);
        }
    }

    // -- Showing the Final View of the Created Products
    function finalview($product = []) {
        // $product = json_decode($product);
        return view('panel.user_shop_items.includes.asset-link.final-step',compact('product'));
    }

    public function vaultrec(Request $request) {

        $user_id = auth()->user()->id;
        $vault_name = $request->get('vault_rec');
        $vault_data = Media::where('path','LIKE',"storage/files/$user_id"."%")->where('vault_name',$request->get('vault_rec'))->get();

        $pdf_rec = $vault_data->where('extension','pdf');
        $image_rec = $vault_data->where('file_type','image')->where('extension','!=','gif');
        $video_rec = $vault_data->where('file_type','video');
        $gif_rec = $vault_data->where('extension','gif');

        $group_id = array_merge($pdf_rec->pluck('id')->toArray(),$image_rec->pluck('id')->toArray(),$video_rec->pluck('id')->toArray(),$gif_rec->pluck('id')->toArray());

        $attchment_rec = $vault_data->whereNotIn('id',$group_id);
        // echo "Total Vault Record: ".$vault_data->count().newline();

        return view('panel.user_shop_items.modal.add-vault-modal-content',compact('vault_data','vault_name','pdf_rec','image_rec','video_rec','gif_rec','attchment_rec'));

    }

    // -- Private funtion to check the model code is already exist or not
    // -- Only in Irrlevant Filename Method
    private function checkmodelCode($mark, $num, $userid,$delimiter = '-') {
        $slug = $mark . $delimiter . $num;
        $chk = Product::where('user_id', $userid)->where('model_code', $slug)->first();
        if ($chk == null) {
            return $slug;
        }
        $num = $num + 1;
        return $this->checkmodelCode($mark, $num, $userid);
    }

    // -- an Private function to check the file type.
    // -- [Attachment, Image, Video, Text, Audio, Application, Other]
    private function checkFileType($item){
        switch ($item) {
            case 'application':
                $type_item = 'Product_Asset';
                break;

            case 'video':
                $type_item = 'Product_Video';
                break;

            case 'image':
                $type_item = 'Product_Image';
                break;

            case 'text':
                $type_item = 'Product_Asset';
                break;

            default:
                $type_item = 'Product_Asset';
                break;
        }

        return $type_item;
    }




}


// End of Controller
// Path: resources/views/panel/user_shop_items/includes/asset-link/final-step.blade.php
// Developed BY Ashish...
// Development is in Progress
