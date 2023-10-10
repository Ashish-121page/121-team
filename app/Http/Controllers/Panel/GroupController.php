<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
        if($request->has('user') &&  $request->get('user') != auth()->id()){
            return back()->with('error','Something went wrong');
        }
         $length = 10;
         if(request()->get('length')){
            $length = $request->get('length');
         }
         $groups = Group::query();
         
            if($request->get('search')){
                $groups->where('id','like','%'.$request->search.'%')
                >orWhere('name','like','%'.$request->search.'%')
                ->orWhere('type','like','%'.$request->search.'%');
            }
            
            if($request->get('from') && $request->get('to')) {
                $groups->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }
          

            if($request->get('asc')){
                $groups->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $groups->orderBy($request->get('desc'),'desc');
            }
                
            if($request->get('user')){
                $groups->where('user_id',[$request->get('user')]);
            }else{
                $groups->whereUserId(getAdminId()->id);
            }
            $groups = $groups->paginate($length);
            
            if ($request->ajax()) {
                return view('panel.groups.load', ['groups' => $groups])->render();  
            }
 
        return view('panel.groups.index', compact('groups'));
    }

        public function print(Request $request){
            $groups = collect($request->records['data']);
                return view('panel.groups.print', ['groups' => $groups])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.groups.create');
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
                        'user_id'     => 'required',
                        'name'     => 'required',
                        'type'     => 'sometimes',
                    ]);
        
        try{
               
               
            $group = Group::create($request->all());
            if (request()->get('user')) {
                return redirect()->route('panel.groups.index','user='.request()->get('user'))->with('success','Group Created Successfully!');
            } else {
                return redirect()->route('panel.groups.index')->with('success','Group Created Successfully!');
            }
            
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
    public function show(Group $group)
    {
        try{
            return view('panel.groups.show',compact('group'));
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
    public function edit(Group $group)
    {   
        try{
            
            return view('panel.groups.edit',compact('group'));
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
    public function update(Request $request,Group $group)
    {
        
        $this->validate($request, [
                        'user_id'     => 'required',
                        'name'     => 'required',
                        'type'     => 'sometimes',
                    ]);
                
        try{
                           
            if($group){
                $chk = $group->update($request->all());
                if (request()->get('user')) {
                    return redirect()->route('panel.groups.index','user='.request()->get('user'))->with('success','Group Updated Successfully!');
                } else {
                    return redirect()->route('panel.groups.index')->with('success','Group Updated Successfully!');
            }
            }
            return back()->with('error','Group not found')->withInput($request->all());
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
    public function destroy(Group $group)
    {
        try{
            if($group){
                                      
                $group->delete();
                return back()->with('success','Group deleted successfully');
            }else{
                return back()->with('error','Group not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
