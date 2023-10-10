<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    

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
         $packages = Package::query();
         
            if($request->get('search')){
                $packages->where('id','like','%'.$request->search.'%')
                                ->orWhere('name','like','%'.$request->search.'%')
                                ->orWhere('price','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $packages->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $packages->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $packages->orderBy($request->get('desc'),'desc');
            }
            $packages = $packages->latest()->paginate($length);
            
            if ($request->ajax()) {
                return view('panel.packages.load', ['packages' => $packages])->render();  
            }
 
        return view('panel.packages.index', compact('packages'));
    }

    
        public function print(Request $request){
            $packages = collect($request->records['data']);
                return view('panel.packages.print', ['packages' => $packages])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.packages.create');
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
                        'name'     => 'required',
                        'limit'     => 'sometimes',
                        'price'     => 'required',
                        'duration'     => 'sometimes',
                        'description'     => 'sometimes',
                        'is_published'     => 'sometimes',
                    ]);
        
        try{
                            
            if(!$request->has('is_published')){
                $request['is_published'] = 0;
            }
             
                  
            $package = Package::create($request->all());
                            return redirect()->route('panel.packages.index')->with('success','Package Created Successfully!');
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
    public function show(Package $package)
    {
        try{
            return view('panel.packages.show',compact('package'));
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
    public function edit(Package $package)
    {   
        try{
            $limits = json_decode($package->limit,true);
            return view('panel.packages.edit',compact('package','limits'));
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
    public function update(Request $request,Package $package)
    {
        
        $this->validate($request, [
                        'name'     => 'required',
                        'limit'     => 'sometimes',
                        'price'     => 'required',
                        'duration'     => 'sometimes',
                        'description'     => 'sometimes',
                        'is_published'     => 'sometimes',
                    ]);
                
        try{
                            
            if(!$request->has('is_published')){
                $request['is_published'] = 0;
            }
                         
            if($package){
                $limits = [
                    'add_to_site' => $request->add_to_site,
                    'custom_proposals' => $request->custom_proposals,
                    'product_uploads' => $request->product_uploads,
                ];
                $request['limit'] = json_encode($limits);
                $chk = $package->update($request->all());
                return redirect()->route('panel.packages.index')->with('success','Record Updated!');
            }
            return back()->with('error','Package not found')->withInput($request->all());
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
    public function destroy(Package $package)
    {
        try{
            if($package){
                                            
                $package->delete();
                return back()->with('success','Package deleted successfully');
            }else{
                return back()->with('error','Package not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
