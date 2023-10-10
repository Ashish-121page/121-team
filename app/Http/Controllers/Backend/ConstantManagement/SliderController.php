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


namespace App\Http\Controllers\Backend\ConstantManagement;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path =   storage_path() . "/app/public/backend/constant-management/sliders/";
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $sliders = fetchAll('App\Models\Slider');
            return view('backend.constant-management.sliders.index',compact('sliders'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('backend.constant-management.sliders.create');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                    $this->validate($request, [
                                'title'     => 'required',
                                'image_file'     => 'required',
                            ]);
        
        try{
            if($request->hasFile('image_file')) {
                $image = $request->file('image_file');
                $path = $this->path;
                $imageName = 'image_'.rand(00000, 99999).'.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
                $request['image']=$imageName;
            } else{
                $request['image']= null; 
            }
                                                                                                                
            $slider = Slider::create($request->all());
            return redirect(route('backend.constant-management.sliders.index')."?slidertype=".$request->slider_type_id)->with('success','Slider Created Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        try{
            return view('backend.constant-management.sliders.show',compact('slider'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {   
        try{
            
            return view('backend.constant-management.sliders.edit',compact('slider'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request,Slider $slider)
    {
        $this->validate($request, [
            'title'     => 'required',
        ]);
                
        try{
            
            
            if($slider){
                if($request->hasFile('image_file')) {
                    if ($slider->image != null) {
                        unlinkfile(substr($this->path, 0, -1), $slider->image);
                    }
                    $image = $request->file('image_file');
                    $path = $this->path;
                    $imageName = 'image_'.rand(00000, 99999).'.' . $image->getClientOriginalExtension();
                    $image->move($path, $imageName);
                    $request['image']=$imageName;
                } 
                                                                                                                                                    
                $chk = $slider->update($request->all());

                return redirect(route('backend.constant-management.sliders.index')."?slidertype=".$request->slider_type_id)->with('success','Record Updated!');
            }
            return back()->with('error','Slider not found');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        try{
            
            if($slider){              
                    $slider->delete();
                    return back()->with('success', 'Record Deleted!');
            }
            return back()->with('error','Slider not found');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
