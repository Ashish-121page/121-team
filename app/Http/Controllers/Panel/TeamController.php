<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\UserShop;
use App\User;

class TeamController extends Controller
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
         $teams = Team::query();
         
            if($request->get('search')){
                $teams->where('id','like','%'.$request->search.'%')
                                ->orWhere('name','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $teams->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $teams->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $teams->orderBy($request->get('desc'),'desc');
            }
            $teams = $teams->paginate($length);

            if ($request->ajax()) {
                return view('panel.teams.load', ['teams' => $teams])->render();  
            }
 
        return view('panel.teams.index', compact('teams'));
    }

    
        public function print(Request $request){
            $teams = collect($request->records['data']);
                return view('panel.teams.print', ['teams' => $teams])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.teams.create');
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
    public function userShopTeamUpdate(Request $request)
    {
        try{
            $user_shop = UserShop::whereId($request->user_shop_id)->first();
            $team = [
                    'title' => $request->title,
                    'description' => $request->description,
                ];
            $user_shop->update([
                'team' => json_encode($team),
            ]);    
            // return redirect()->route('panel.user_shops.edit',$user_shop->id."?active=about-section")->with('success','Team Updated Successfully!');
            return back()->with('success','Team Updated Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    public function store(Request $request)
    {        
        try{
            if (AuthRole() != 'Admin') {
                $chk_team = Team::where('user_shop_id',$request->user_shop_id)->get();
                if (count($chk_team) > 3) {
                    return back()->with("error","Contact 121 Support to add more than 3 members");
                    // echo count($chk_team);
                }                
            }

            $user_shop = UserShop::whereId($request->user_shop_id)->first();
            $user = User::whereId($user_shop->user_id)->first();

            if($request->hasFile("image")){
                 $img = $this->uploadFile($request->file("image"), "teams")->getFilePath();
            }else{
                $img = null;
            }
            
            if ($user->additional_numbers != null && $user->additional_numbers != '') {
                $user_add = json_decode($user->additional_numbers);
            }else{
                $user_add = null;
            }



            if ($user_add == null) {
                $user_add = [$request->get('contact_number')];
            }else{
                array_push($user_add,$request->get('contact_number'));
            }

            $mail_chk = User::where('email',$request->Email)->get();
            $mail_chk1 = Team::where('email',$request->Email)->get();

            if (count($mail_chk) == 0 && count($mail_chk1) == 0) {
                $user = User::find($user->id);
                $user->additional_numbers = json_encode($user_add);
                $user->save();
                
                $team = Team::create($request->all());
                $team->image = $img;
                $team->permission = json_encode($request->teamright);
                $team->email = $request->Email;
                $team->city = $request->city;
                $team->save();
            }else{
                return back()->with('error','Email Already Exist!');
            }
                
            // // return redirect()->route('panel.user_shops.edit',$request->user_shop_id."?active=about-section")->with('success','Team Updated Successfully!');


            session()->remove('phone');
            return back()->with('success','Team Updated Successfully!');
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
    public function show(Team $team)
    {
        try{
            return view('panel.teams.show',compact('team'));
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
    public function edit(Team $team)
    {   
        try{
            
            return view('panel.teams.edit',compact('team'));
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
    public function update(Request $request,Team $team)
    {
                
        try{
                            
            if($team){
                  
                if($request->hasFile("image_file")){
                    $request['image'] = $this->uploadFile($request->file("image_file"), "teams")->getFilePath();
                    $this->deleteStorageFile($team->image);
                } else {
                    $request['image'] = $team->image;
                }
                      
                $request['permission'] = json_encode($request->teamright);
                
                $chk = $team->update($request->all());

                // return redirect()->route('panel.user_shops.edit',$request->user_shop_id."?active=about-section")->with('success','Team Updated Successfully!');
                return back()->with('success','Team Updated Successfully!');
            }
            return back()->with('error','Team not found')->withInput($request->all());
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
    public function destroy(Team $team)
    {
        try{
            if($team){                
                $user_shop = UserShop::whereId($team->user_shop_id)->first();
                $user = User::whereId($user_shop->user_id)->first();
            
                $new_phone = [];
                $addtional_num = json_decode($user->additional_numbers,true);

                foreach ($addtional_num as $key => $add_phone) {
                    if ($add_phone != $team->contact_number) {
                        $new_phone[] = $add_phone;
                    }
                }
                $user->additional_numbers = json_encode($new_phone);
                $user->save();

                $this->deleteStorageFile($team->image);              
                
                $team->delete();

                return back()->with('success','Team deleted successfully');
            }else{  
                return back()->with('error','Team not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
