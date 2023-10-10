<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Media;

class MediaController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $medias = Media::query();
         
            if($request->get('search')){
                $medias->where('id','like','%'.$request->search.'%')
                                ->orWhere('type','like','%'.$request->search.'%')
                                ->orWhere('type_id','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $medias->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $medias->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $medias->orderBy($request->get('desc'),'desc');
            }
            $medias = $medias->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.medias.load', ['medias' => $medias])->render();  
            }
 
        return view('panel.medias.index', compact('medias'));
    }

    
        public function print(Request $request){
            $medias = collect($request->records['data']);
                return view('panel.medias.print', ['medias' => $medias])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.medias.create');
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
                        'type'     => 'sometimes',
                        'type_id'     => 'sometimes',
                        'file_name'     => 'sometimes',
                        'path'     => 'sometimes',
                        'extension'     => 'sometimes',
                        'file_type'     => 'sometimes',
                        'tag'     => 'sometimes',
                    ]);
        
        try{
                   
                   
            $media = Media::create($request->all());
                            return redirect()->route('panel.medias.index')->with('success','Media Created Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        try{
            return view('panel.medias.show',compact('media'));
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
    public function edit(Media $media)
    {   
        try{
            
            return view('panel.medias.edit',compact('media'));
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
    public function update(Request $request,Media $media)
    {
        
        $this->validate($request, [
                        'type'     => 'sometimes',
                        'type_id'     => 'sometimes',
                        'file_name'     => 'sometimes',
                        'path'     => 'sometimes',
                        'extension'     => 'sometimes',
                        'file_type'     => 'sometimes',
                        'tag'     => 'sometimes',
                    ]);
                
        try{
                               
            if($media){
                           
                $chk = $media->update($request->all());

                return redirect()->route('panel.medias.index')->with('success','Record Updated!');
            }
            return back()->with('error','Media not found')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        // return $media;
        try{
            if($media){
                                              
                $media->delete();
                return back()->with('success','Media deleted successfully');
            }else{
                return back()->with('error','Media not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
