<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UserPackage;
use App\Models\Package;
use App\Models\UserShop;

class UserPackageController extends Controller
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
         $user_packages = UserPackage::query();
         
            if($request->get('search')){
                $user_packages->where('id','like','%'.$request->search.'%')
                ->orWhereHas('userShop',function($q){
                    $q->where('slug','like','%'.request()->get('search').'%');
                })
               ->orWhere('user_id','like','%'.$request->search.'%')
              
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $user_packages->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $user_packages->orderBy($request->get('asc'),'asc');
            }
            if($request->get('package_id')){
                $user_packages->whereHas('package',function($q) {
                    $q->where('id',request()->get('package_id'));
                });
            }
            if($request->get('slug')){
                $slug_user = UserShop::where('slug',$request->get('slug'))->first();
                if($slug_user){
                    $user_packages->where('user_id',$slug_user->user_id);
                }
            }
            if($request->get('desc')){
                $user_packages->orderBy($request->get('desc'),'desc');
            }
            $user_packages = $user_packages->paginate($length);

            if ($request->ajax()) {
                return view('panel.user_packages.load', ['user_packages' => $user_packages])->render();  
            }
            $packages = Package::where('is_published',1)->get();
        return view('panel.user_packages.index', compact('user_packages','packages'));
    }

    
        public function print(Request $request){
            $user_packages = collect($request->records['data']);
                return view('panel.user_packages.print', ['user_packages' => $user_packages])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.user_packages.create');
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
    //    return $request->all();
        $this->validate($request, [
                        'user_id'     => 'required',
                        'package_id'     => 'required',
                        'order_id'     => 'required',
                        'from'     => 'sometimes',
                        'to'     => 'sometimes',
                        'limit'     => 'sometimes',
                    ]);
        
        try{
                  
                  
            $user_package = UserPackage::create($request->all());
                            return redirect()->route('panel.user_packages.index')->with('success','User Package Created Successfully!');
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
    public function show(UserPackage $user_package)
    {
        try{
            return view('panel.user_packages.show',compact('user_package'));
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
    public function edit(UserPackage $user_package)
    {   
        try{
            return view('panel.user_packages.edit',compact('user_package'));
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
    public function update(Request $request,UserPackage $user_package)
    {
        
        $this->validate($request, [
                        // 'user_id'     => 'required',
                        'package_id'     => 'required',
                        'custom_proposals'     => 'required',
                        'product_uploads'     => 'required',
                        'add_to_site'     => 'required',
                        // 'order_id'     => 'required',
                        'from'     => 'sometimes',
                        'to'     => 'sometimes',
                        // 'limit'     => 'sometimes',
                    ]);

        $add_to_site = $request->add_to_site;
        $custom_proposals = $request->custom_proposals;
        $product_uploads = $request->product_uploads;

        $package = json_encode(array('add_to_site' => $add_to_site,'custom_proposals' => $custom_proposals ,'product_uploads' => $product_uploads ));
    
        try{
                              
            if($user_package){

                $UserPackage = UserPackage::find($request->user_id);
                $UserPackage->from = $request->from;
                $UserPackage->to = $request->to;
                $UserPackage->limit = $package;
                $UserPackage->package_id = $request->package_id;
                $UserPackage->save();


                echo "<pre>";
                print_r($request->all());
                echo "</pre>";



                return redirect()->route('panel.user_packages.index')->with('success','Record Updated!');
            }
            return back()->with('error','User Package not found')->withInput($request->all());
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
    public function destroy(UserPackage $user_package)
    {
        try{
            if($user_package){
                                            
                $user_package->delete();
                return back()->with('success','User Package deleted successfully');
            }else{
                return back()->with('error','User Package not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
