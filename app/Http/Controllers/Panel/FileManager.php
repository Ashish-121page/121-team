<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Product;
use App\Models\UserShopItem;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FileManager extends Controller
{
    public function index(Request $request)
    {
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
        $sortOrder = $request->get('filtername','name'); // Specify the sort order ('name', 'date', 'size')
        $sortType = $request->get('filtertype','ASC');

        
        if (Storage::exists($folderPath)) {
            $files = Storage::allFiles($folderPath);
            
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
                }
            }
          
            // Getting Folder Size
            $formattedSize = 0;

            $user_shop_item = UserShopItem::where('user_id',auth()->id())->pluck('product_id');
            $Products = Product::whereIn('id',$user_shop_item)->get();
            

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

            // magicstring($filterfiles);
            // return;


        }else{
            Storage::makeDirectory($folderPath);
            return redirect()->back();
            echo "No Path Exist";
            return;
        }


        return view('panel.Filemanager.index',compact('paginator','formattedSize','Products','filetypes'));
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
                    Storage::delete(decrypt($filePath));
                    $count++;
                }else{
                    // return back()->with('error',"File Does Not Exit.");
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
        
        $fileName = $file->getClientOriginalName() ?? Str::random(10);
        
        
        $path = $file->storeAs($folderPath, $fileName);

        
        return response()->json(['path' => $path]);
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

    public function linkproduct(Request $request,$user_id) {
        try {
            $user_id = decrypt($user_id);
            $countProduct = 0;
            magicstring($request->all());
            foreach ($request->product_id as $key => $product_id) {
                    
                $prouduct_id = decrypt($product_id);
                $arr_images = [];
                $usi = UserShopItem::where('product_id',$prouduct_id)->where('user_id',$user_id)->first();
                $exist_image = $usi->images;
                $count = 0;
                foreach (explode(',',$request->get('images')) as $key => $value) {
                    // array_push($filePaths,decrypt($value));
                    $file = decrypt($value);
                    
                    $media = new Media();
                    $media->tag = "Product_Image";
                    $media->file_type = "Image";
                    $media->type = "Product";
                    $media->type_id = $prouduct_id;
                    $media->file_name = basename($file);
                    $media->path = "storage/files/".auth()->id()."/".basename($file);
                    $media->extension = explode('.',basename($file))[1] ?? '';
                    $media->save();
                    $arr_images[] = $media->id;
                    $count++;
                }

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
