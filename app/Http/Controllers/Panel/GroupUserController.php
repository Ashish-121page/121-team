<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\GroupUser;
use App\Models\Group;

class GroupUserController extends Controller
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
         $group_users = GroupUser::query();
         
            if($request->get('search')){
                $group_users->where('id','like','%'.$request->search.'%')->orWhere('user_id','like','%'.$request->search.'%')->orWhere('group_id','like','%'.$request->search.'%');
            }
            
            if($request->get('from') && $request->get('to')) {
                $group_users->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $group_users->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $group_users->orderBy($request->get('desc'),'desc');
            }
            if($request->get('id')){
                $group_users->whereGroupId($request->id)->get();
            }
            $group_users = $group_users->latest()->paginate($length);
            $group = Group::whereId(request()->get('id'))->first();

            if ($request->ajax()) {
                return view('panel.group_users.load', ['group_users' => $group_users])->render();  
            }
 
        return view('panel.group_users.index', compact('group_users','group'));
    }

    
        public function print(Request $request){
            $group_users = collect($request->records['data']);
                return view('panel.group_users.print', ['group_users' => $group_users])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.group_users.create');
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
        // return $request->all();
        
        $this->validate($request, [
                        'group_id'     => 'required',
                        'user_id'     => 'required',
                        'user_shop_id'     => 'sometimes',
                    ]);
        
        try{
            $group_user = GroupUser::create($request->all());
            return redirect(route('panel.group_users.index','id='.$request->group_id))->with('success','Group User Created Successfully!');
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
    public function show(GroupUser $group_user)
    {
        try{
            return view('panel.group_users.show',compact('group_user'));
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
    public function edit(GroupUser $group_user)
    {   
        try{
            
            return view('panel.group_users.edit',compact('group_user'));
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
    public function update(Request $request,GroupUser $group_user)
    {
        
        $this->validate($request, [
                        'group_id'     => 'required',
                        'user_id'     => 'required',
                        'user_shop_id'     => 'sometimes',
                    ]);
                
        try{
                           
            if($group_user){
                       
                $chk = $group_user->update($request->all());

                return redirect(route('panel.group_users.index','id='.$group_user->group_id))->with('success','Record
                Updated!');
            }
            return back()->with('error','Group User not found')->withInput($request->all());
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
    public function destroy(GroupUser $group_user)
    {
        try{
            if($group_user){
                                      
                $group_user->delete();
                return back()->with('success','Group User deleted successfully');
            }else{
                return back()->with('error','Group User not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
