<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductExtraInfo;
use App\Models\UserShopItem;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\Response;


class FileManager extends Controller
{
    public function index(Request $request){
        try{
           return view('panel.seller_files.index');
        }catch(\Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }

    }

    public function newview(Request $request) {
        $user_id = auth()->id();
        $filetypes = [];
        $filterfiles = [];

        $folderPath = "public/files/$user_id";
        $linkedItems = [];
        $sortOrder = $request->get('filtername','date'); // Specify the sort order ('name', 'date', 'size')
        $sortType = $request->get('filtertype','DESC');

        if (Storage::exists($folderPath)) {
            $files = Storage::allFiles($folderPath);

            // Filter out files from a specific folder
            $files = array_filter($files, function ($file) use ($folderPath) {
                $folderName = basename($folderPath);
                $filePath = str_replace('\\', '/', $file);
                $fileName = basename($filePath);
                $subfolderName = 'quote_files'; // Specify the subfolder name to exclude

                // Exclude the subfolder from the filtered files
                if ($fileName !== $folderName && strpos($filePath, $subfolderName) === false) {
                    return true;
                }

                return false;
            });



            // ` Ascending Order
            if ($sortType == 'ASC') {
                // Sort the files based on the specified order
                if ($sortOrder === 'name') {
                    // Sort by file name
                    usort($files, function ($a, $b) {
                        return strnatcasecmp(basename($a), basename($b));
                    });
                } elseif ($sortOrder === 'date') {
                    // Sort by modification date (oldest to newest)
                    usort($files, function ($a, $b) {
                        // return  Storage::lastModified($b) - Storage::lastModified($a);
                        return  Storage::lastModified($a) - Storage::lastModified($b);
                    });

                } elseif ($sortOrder === 'size') {
                    // Sort by file size (smallest to largest)

                    usort($files, function ($a, $b) {
                        return Storage::size($a) - Storage::size($b);
                    });
                }elseif ($sortOrder == 'attachment') {
                    foreach ($files as $key => $file) {
                        $filename = basename($file);
                        $path = "storage/files/$user_id/$filename";
                        $linked = Media::where('path',$path)->groupBy('type_id')->get()->count() ?? 0;
                        array_push($linkedItems,$linked);
                    }

                    array_multisort($linkedItems,SORT_ASC,$files);
                }
            }else{

                // Sort the files based on the specified order
                if ($sortOrder === 'name') {
                    // Sort by file name
                    usort($files, function ($a, $b) {
                        return strnatcasecmp(basename($b), basename($a));
                    });
                } elseif ($sortOrder === 'date') {
                    // Sort by modification date (oldest to newest)
                    usort($files, function ($a, $b) {
                        // return  Storage::lastModified($b) - Storage::lastModified($a);
                        return  Storage::lastModified($b) - Storage::lastModified($a);
                    });

                } elseif ($sortOrder === 'size') {
                    // Sort by file size (smallest to largest)
                    usort($files, function ($a, $b) {
                        return Storage::size($b) - Storage::size($a);
                    });
                }elseif ($sortOrder == 'attachment') {
                    foreach ($files as $key => $file) {
                        $filename = basename($file);
                        $path = "storage/files/$user_id/$filename";
                        $linked = Media::where('path',$path)->groupBy('type_id')->get()->count() ?? 0;
                        array_push($linkedItems,$linked);
                    }

                    array_multisort($linkedItems,SORT_DESC,$files);
                }
            }

            // Getting Folder Size
            $formattedSize = 0;
            $user_shop_item = UserShopItem::where('user_id',auth()->id())->pluck('product_id');
            $limit = $request->get('pageliimt',5);

            $Products = Product::whereIn('id',$user_shop_item)->paginate($limit);
            $Products_attribute = ProductExtraInfo::whereIn('product_id',$user_shop_item)->groupBy('attribute_value_id')->get();


            if ($request->ajax() && $request->workload == 'linkproductsearch') {
                // $limit = $request->get('pageliimt',5);
                $Products = Product::whereIn('id',$user_shop_item)->where('title',"LIKE","%".$request->searchCode."%")->orwhere('model_code',"LIKE","%".$request->searchCode."%")->paginate($limit);
                $Products_attribute = ProductExtraInfo::whereIn('product_id',$user_shop_item)->groupBy('attribute_value_id')->get();
                return view('panel.Filemanager.modals.ProductList',compact('Products','Products_attribute'));
            }



            foreach ($files as $file) {
                $fileSize = Storage::size($file);
                $formattedSize += $fileSize;
                $filechk = explode('/',Storage::mimeType($file))[0];
                if (!in_array($filechk,$filetypes)) {
                    array_push($filetypes,$filechk);
                }
                if ($request->has('file_type') && $request->get('file_type') != null && $request->get('file_type') != 'all') {
                    if ($filechk == $request->get('file_type')) {
                        array_push($filterfiles,$file);
                    }
                    $files = $filterfiles;
                }
            }

            $page = request()->get('page', 1);
            $perPage = 24;
            $offset = ($page - 1) * $perPage;
            $slicedFiles = array_slice($files, $offset, $perPage);
            $paginator = new LengthAwarePaginator($slicedFiles, count($files), $perPage, $page);

        }else{
            Storage::makeDirectory($folderPath);
            return redirect()->back();
            echo "No Path Exist";
            return;
        }

        return view('panel.Filemanager.index',compact('paginator','formattedSize','Products','filetypes','Products_attribute'));
    }

    function renamefile(Request $request) {

        if ($request->ajax()) {
            $countProduct = 0;

            $user_id = auth()->id();
            $oldName = $request->oldName;
            $newName = $request->newName;
            $extension = explode('.',$oldName);
            $extension = end($extension);

            if (count(explode('.',$newName)) == 1) {
                $newName = $newName.".". $extension;
            }

            $oldFilePath = "public/files/$user_id/$oldName";
            $newFilePath = "public/files/$user_id/$newName";


            $OldpathInDB = "storage/files/$user_id/$oldName";
            $NewpathInDB = "storage/files/$user_id/$newName";

            if (Storage::exists($oldFilePath)) {
                Storage::move($oldFilePath, $newFilePath);
                // Updating Linking of FIle
                $Mediarecords = Media::where('path',$OldpathInDB)->get();
                foreach ($Mediarecords as $key => $media) {
                    $media->path = $NewpathInDB;
                    $media->file_name = $newName;
                    $media->save();
                    $countProduct++;
                }

                $response = ['status'=> 'Success',"Msg" => "File has been renamed.",'FileName' => $newName,'FileUpdate' => $countProduct];
                return json_encode($response);
            } else {
                $response = ['status'=> 'Success',"Msg" => "File not found",'FileName' => $oldName,'FileUpdate' => 0];
                return json_encode($response);
            }
        } // If End
        else{
            abort(404,"Invalid Request!!");
        }
    }


    function destroyfile(Request $request) {

       try {
            $deletefiles = explode(',',$request->get('files'));
            $count = 0;


            foreach ($deletefiles as $key => $filePath) {
                if (Storage::exists(decrypt($filePath))) {

                    $path = decrypt($filePath);
                    $path = str_replace('public','storage',$path);

                    $media = Media::where('path',$path)->get();

                    foreach ($media as $key => $value) {
                        $value->delete();
                    }

                    Storage::delete(decrypt($filePath));
                    $count++;
                }else{
                    return back()->with('error',"File Does Not Exit.");
                }
            }

            return back()->with('success',"$count Files are Deleted Success Fully");
       } catch (\Throwable $th) {
            throw $th;
       }
    }


    function store(Request $request) {
        $file = $request->file('file');
        $user_id = auth()->id();
        $folderPath = "public/files/$user_id";
        $existingFile = Storage::exists("$folderPath/{$file->getClientOriginalName()}");
        $fileName = $file->getClientOriginalName() ?? Str::random(10);

        if ($existingFile) {
            return response()->json(['message' => "File Exist",'Filename' => $fileName,'path' => '']);
        }
        $path = $file->storeAs($folderPath, $fileName);

        return response()->json(['path' => $path,'Filename' => $fileName,'message' => "New File",]);
    }


    public function downloadZip(Request $request)
    {
        $filePaths = [];

        foreach (explode(',',$request->get('files')) as $key => $value) {
            array_push($filePaths,decrypt($value));
        }

        $user_id  = auth()->id();
        magicstring($filePaths);

        // Create a temporary zip file
        $zipFileName = auth()->user()->name.'-images.zip';
        $zip = new ZipArchive;
        $zip->open(storage_path("app/public/exports/" . $zipFileName), ZipArchive::CREATE);

        // Add each file to the zip archive
        foreach ($filePaths as $filePath) {
            if (Storage::exists($filePath)) {
                $zip->addFile(storage_path('app/'.$filePath));
            }
        }

        $zip->close();

        // Set the appropriate headers for a download response
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
        ];

        // if ($zip->status !== true) {
        //     return response()->json(['error' => 'Failed to create the zip file.']);
        // }

        return response()->file(storage_path("app/public/exports/" . $zipFileName), $headers);
    }


    public function productsaperator(Request $request) {

        // magicstring($request->all());

        try {
            $dr  = $request->delimiter;
            $delimiter = '-';
            $alignment = $request->alignment;
            $count = 0;

            switch ($dr) {
                case 'underscore':
                    $delimiter = "_";
                    break;
                case 'dash':
                    $delimiter = "-";
                    break;

                case 'dot':
                    $delimiter = ".";
                    break;

                case 'hashtag':
                    $delimiter = "#";
                    break;

                default:
                    $delimiter = "_";
                    break;
            }

            // ` extracting Model Code
            $model_codes = [];
            foreach (json_decode($request->filename) as $key => $names) {
                $names = pathinfo($names)['filename'];
                $tmp_data = explode($delimiter,$names);
                array_push($model_codes,$tmp_data[$alignment]);
            }


            // Linking Product With Images
            foreach ($model_codes as $key1 => $models) {
                $products = Product::where('model_code',$models)->where('user_id',auth()->id())->get();

            if ($products->count() != 0) {
                    foreach ($products as $key => $product) {

                        $usi = UserShopItem::where('product_id',$product->id)->where('user_id',auth()->id())->first();
                        if ($usi != null) {

                            $arr_images = [];
                            $exist_image = $usi->images;

                            $file = json_decode($request->filename)[$key1];
                            $media = new Media();
                            $media->tag = "Product_Image";
                            $media->file_type = "Image";
                            $media->type = "Product";
                            $media->type_id = $product->id;
                            $media->file_name = basename($file);
                            $media->path = "storage/files/".auth()->id()."/".basename($file);
                            $media->extension = explode('.',basename($file))[1] ?? '';
                            $media->save();
                            $arr_images[] = $media->id;
                            $count++;

                            // // Add images to UserShopItem
                            if(count($arr_images) > 0) {

                                if ($exist_image == null || $exist_image = '') {
                                    $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                                }else{
                                    $usi->images =  $usi->images.','.implode(',',$arr_images) ?? null;
                                }

                                $usi->save();
                            }



                        }
                    }
            }

            }

            return back()->with('success',"$count assets linked with $count products !!");

        } catch (\Throwable $th) {
            throw $th;
        }

    }




    public function linkproduct(Request $request,$user_id) {
        try {
            $user_id = decrypt($user_id);
            $countProduct = 0;


            magicstring(request()->all());
            // return;

            foreach ($request->product_id as $key => $product_id) {

                $prouduct_id = decrypt($product_id);
                $arr_images = [];
                $usi = UserShopItem::where('product_id',$prouduct_id)->where('user_id',$user_id)->first();

                $exist_image = $usi->images;
                $count = 0;


                // magicstring(explode(",",$request->images));


                // return;
                foreach (explode(",",$request->images) as $key => $value) {
                    // array_push($filePaths,decrypt($value));
                    $file = decrypt($value);

                    // echo $file.newline();
                    $file = str_replace('public','storage',$file);

                    // echo "<img src='".asset($file)."' width='100px' height='100px'>";

                    // continue;
                    $media = new Media();
                    $media->tag = "Product_Image";
                    $media->file_type = "Image";
                    $media->type = "Product";
                    $media->type_id = $prouduct_id;
                    $media->file_name = basename($file);
                    $media->path = $file;
                    $media->extension = explode('.',basename($file))[1] ?? '';
                    $media->save();
                    $arr_images[] = $media->id;
                    $count++;
                }

                // return;

                // // Add images to UserShopItem
                if(count($arr_images) > 0) {

                    if ($exist_image == null || $exist_image = '') {
                        $usi->images =  count($arr_images) > 0 ? implode(',',$arr_images) : null;
                    }else{
                        $usi->images =  $usi->images.','.implode(',',$arr_images) ?? null;
                    }

                    $usi->save();
                }

                $countProduct++;
            }




            return back()->with('success',"$count assets linked with $countProduct products !!");
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error',"There was an error while linking assets");
        }
    }

}
