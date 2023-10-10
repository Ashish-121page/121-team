<?php 
/**
 *

 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailSmsTemplate;
use App\Models\Calendar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables,Auth;
use \Carbon\Carbon;

class DevController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.datatable.server-table');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getServerList()
    {
        // return 's';
        $data  = MailSmsTemplate::all();

        return Datatables::of($data)
                ->addColumn('date', function($data){
                        $date = $data->created_at->format('d M Y h:i:s');
                    return $date;
                })
                ->addColumn('type', function($data){
                        $type = $data->type == 1 ? 'mail': 'sms';
                    return $type;
                })
                ->addColumn('action', function($data){
                    if (1 == 1){
                        return '<div class="table-actions">
                                <a href="'.route('panel.constant_management.mail_sms_template.edit',$data->id).'" ><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                            </div>';
                    }else{
                        return '';
                    }
                })
                ->rawColumns(['date','type','action'])
                ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        try{
            $data = Calendar::all();
            return view('pages.calendar',compact('data'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function storeCal(Request $request)
    {
        // return $request->all();
        // return Carbon::parse($request->eventStarts)->format('Y-m-d h:i:s');
        try{
            $data = new Calendar();
            $data->event_name = $request->eventName;
            $data->start = Carbon::parse($request->eventStarts)->format('Y-m-d h:i:s');
            $data->end = Carbon::parse($request->eventEnds)->format('Y-m-d h:i:s');
            $data->color_code = $request->colorChosen;
            $data->save();
            if($request->ajax()){
                return response(['res'=>$data],200);
            }else{
                return back()->with('success','Event Added!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function updateCal(Request $request)
    {
        // return $request->all();
        // return Carbon::parse($request->eventStarts)->format('Y-m-d h:i:s');
        try{
            $data = Calendar::whereId($request->id)->first();
            $data->event_name = $request->editEname;
            $data->start = Carbon::parse($request->editStarts)->format('Y-m-d h:i:s');
            $data->end = Carbon::parse($request->editEnds)->format('Y-m-d h:i:s');
            $data->save();
            if($request->ajax()){
                return response(['res'=>$data],200);
            }else{
                return back()->with('success','Event Updated!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function deleteCal($id,Request $request)
    {
        // return $id;
        // return Carbon::parse($request->eventStarts)->format('Y-m-d h:i:s');
        try{
            $data = Calendar::whereId($id)->delete();
            if($request->ajax()){
                return response(200);
            }else{
                return back()->with('success','Event Deleted!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imageStore(Request $request)
    {
        return $request->all();
        $this->validate($request,[
            'image'=>'mimes:jpeg,jpg,png|max:10000',
        ]);
        $file = $request->file('image');

        //if upload form is submitted
        if(isset($_POST["upload"])){
            //get the file information
            $fileName = $file->getClientOriginalName();
            $fileTmp = $file->getPathName();
            $fileType = $file->getMimeType();
            $fileSize = $file->getSize();
            $fileExt = substr($fileName, strrpos($fileName, ".") + 1);
            
            //specify image upload directory
            $largeImageLoc = 'uploads/images/'.$fileName;
            $thumbImageLoc = 'uploads/images/thumb/'.$fileName;
        
            //check file extension
            if((!empty($_FILES["image"])) && ($_FILES["image"]["error"] == 0)){
                if($fileExt != "jpg" && $fileExt != "jpeg" && $fileExt != "png"){
                    $error = "Sorry, only JPG, JPEG & PNG files are allowed.";
                }
            }else{
                $error = "Select a JPG, JPEG & PNG image to upload";
            }
            
            //if everything is ok, try to upload file
            if(strlen($error) == 0 && !empty($fileName)){
                if(move_uploaded_file($fileTmp, $largeImageLoc)){
                    //file permission
                    chmod ($largeImageLoc, 0777);
                    
                    //get dimensions of the original image
                    list($width_org, $height_org) = getimagesize($largeImageLoc);
                    
                    //get image coords
                    $x = (int) $_POST['x'];
                    $y = (int) $_POST['y'];
                    $width = (int) $_POST['w'];
                    $height = (int) $_POST['h'];

                    //define the final size of the cropped image
                    $width_new = $width;
                    $height_new = $height;
                    
                    //crop and resize image
                    $newImage = imagecreatetruecolor($width_new,$height_new);
                    
                    switch($fileType) {
                        case "image/gif":
                            $source = imagecreatefromgif($largeImageLoc); 
                            break;
                        case "image/pjpeg":
                        case "image/jpeg":
                        case "image/jpg":
                            $source = imagecreatefromjpeg($largeImageLoc); 
                            break;
                        case "image/png":
                        case "image/x-png":
                            $source = imagecreatefrompng($largeImageLoc); 
                            break;
                    }
                    
                    imagecopyresampled($newImage,$source,0,0,$x,$y,$width_new,$height_new,$width,$height);

                    switch($fileType) {
                        case "image/gif":
                            imagegif($newImage,$thumbImageLoc); 
                            break;
                        case "image/pjpeg":
                        case "image/jpeg":
                        case "image/jpg":
                            imagejpeg($newImage,$thumbImageLoc,90); 
                            break;
                        case "image/png":
                        case "image/x-png":
                            imagepng($newImage,$thumbImageLoc);  
                            break;
                    }
                    imagedestroy($newImage);
                    
                    //remove large image
                    //unlink($imageUploadLoc);

                    //display cropped image
                    echo 'CROP IMAGE:<br/><img src="'.$thumbImageLoc.'"/>';
                }else{
                    $error = "Sorry, there was an error uploading your file.";
                }
            }else{
                //display error
                echo $error;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
