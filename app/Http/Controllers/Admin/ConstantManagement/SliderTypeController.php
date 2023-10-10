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


namespace App\Http\Controllers\Admin\ConstantManagement;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\SliderType;

class SliderTypeController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path =   storage_path() . "/app/public/backend/constant-management/slider_types/";
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $length = 50;
         if(request()->get('length')){
             $length = $request->get('length');
         }
        try{
            $slider_types = fetchAll('App\Models\SliderType')->paginate($length);
            if ($request->ajax()) {
                return view('backend.constant-management.slider_types.load', ['slider_types' => $slider_types])->render();  
            }
        return view('backend.constant-management.slider_types.index',compact('slider_types'));
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
            return view('backend.constant-management.slider_types.create');
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
        ]);
        try{                                                                                  
            $slider_type = SliderType::create($request->all());
            return redirect()->route('backend.constant-management.slider_types.index')->with('success','Slider Type Created Successfully!');
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
    public function show(SliderType $slider_type)
    {
        try{
            return view('backend.constant-management.slider_types.show',compact('slider_type'));
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
    public function edit(SliderType $slider_type)
    {   
        try{
            
            return view('backend.constant-management.slider_types.edit',compact('slider_type'));
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
    public function update(Request $request,SliderType $slider_type)
    {
                    $this->validate($request, [
                                'title'     => 'required',
                            ]);
                
        try{
            
            
            if($slider_type){
                                                                                                                                
                $chk = $slider_type->update($request->all());

                return redirect()->route('backend.constant-management.slider_types.index')->with('success','Record Updated!');
            }
            return back()->with('error','Slider Type not found');
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
    public function destroy(SliderType $slider_type)
    {
        try{
            
            if($slider_type){              
                    $slider_type->delete();
                    return back()->with('success', 'Record Deleted!');
            }
            return back()->with('error','Slider Type not found');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
