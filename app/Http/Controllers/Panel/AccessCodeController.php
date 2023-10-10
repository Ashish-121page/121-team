<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\AccessCode;

class AccessCodeController extends Controller
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
         $access_codes = AccessCode::query();
         
            if($request->get('search')){
                $access_codes->where('id','like','%'.$request->search.'%')
                                ->orWhere('code','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $access_codes->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $access_codes->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $access_codes->orderBy($request->get('desc'),'desc');
            }
            if(AuthRole() != "Admin"){
                $access_codes->whereCreatorId(auth()->id());
            }
            $access_codes = $access_codes->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.access_codes.load', ['access_codes' => $access_codes])->render();  
            }
 
        return view('panel.access_codes.index', compact('access_codes'));
    }

    
        public function print(Request $request){
            $access_codes = collect($request->records['data']);
                return view('panel.access_codes.print', ['access_codes' => $access_codes])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.access_codes.create');
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
                        'code'     => 'required',
                        'creator_id'     => 'required',
                    ]);
        
        try{
            $access_code = AccessCode::create($request->all());
                return redirect()->route('panel.access_codes.index')->with('success','Access Code Created Successfully!');
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
    public function show(AccessCode $access_code)
    {
        try{
            return view('panel.access_codes.show',compact('access_code'));
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
    public function edit(AccessCode $access_code)
    {   
        try{
            return view('panel.access_codes.edit',compact('access_code'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function codeGenerator(AccessCode $access_code,Request $request)
    {  
        try{ 
            if(AuthRole() == 'Admin'){
                for($i=1; $i <= $request->number_of_code; $i++){
                    $rand_code = '121'.''.\Str::upper(\Str::random(6)).''.auth()->id();
                    $code = AccessCode::create([
                        'code'     => $rand_code,
                        'creator_id'    => $request->marketer,
                    ]);
                }

                if ($code) {
                    return back()->with('success','Access Code created Successfully');
                } else {
                    return back()->with('error', 'Failed to create Access Code! Try again.');
                }
            }else{
                    for($i=1; $i <= $request->number_of_code; $i++){
                        $rand_code = '121'.''.\Str::upper(\Str::random(6)).''.auth()->id();
                        $code = AccessCode::create([
                            'code'     => $rand_code,
                            'creator_id'    => auth()->id()
                        ]);
                }
                
                if ($code) {
                    return back()->with('success','Access Code created Successfully');
                } else {
                    return back()->with('error', 'Failed to create Access Code! Try again.');
                }
            }
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
    public function update(Request $request,AccessCode $access_code)
    {
        
        $this->validate($request, [
                        'code'     => 'required',
                        'creator_id'     => 'required',
                    ]);
                
        try{
                            
            if($access_code){
                        
                $chk = $access_code->update($request->all());

                return redirect()->route('panel.access_codes.index')->with('success','Record Updated!');
            }
            return back()->with('error','Access Code not found')->withInput($request->all());
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
    public function destroy(AccessCode $access_code)
    {
        try{
            if($access_code){
                                        
                $access_code->delete();
                return back()->with('success','Access Code deleted successfully');
            }else{
                return back()->with('error','Access Code not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
