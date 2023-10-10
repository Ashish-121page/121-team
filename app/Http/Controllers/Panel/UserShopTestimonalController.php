<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UserShopTestimonal;
use App\Models\UserShop;

class UserShopTestimonalController extends Controller
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
         $user_shop_testimonals = UserShopTestimonal::query();
         
            if($request->get('search')){
                $user_shop_testimonals->where('id','like','%'.$request->search.'%')
                                ->orWhere('name','like','%'.$request->search.'%')
                                ->orWhere('title','like','%'.$request->search.'%')
                                ->orWhere('description','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $user_shop_testimonals->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $user_shop_testimonals->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $user_shop_testimonals->orderBy($request->get('desc'),'desc');
            }
            $user_shop_testimonals = $user_shop_testimonals->paginate($length);

            if ($request->ajax()) {
                return view('panel.user_shop_testimonals.load', ['user_shop_testimonals' => $user_shop_testimonals])->render();  
            }
 
        return view('panel.user_shop_testimonals.index', compact('user_shop_testimonals'));
    }

    
        public function print(Request $request){
            $user_shop_testimonals = collect($request->records['data']);
                return view('panel.user_shop_testimonals.print', ['user_shop_testimonals' => $user_shop_testimonals])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.user_shop_testimonals.create');
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
                        'title'     => 'sometimes', 
                        'designation'     => 'sometimes',
                        'file_image'     => 'sometimes',
                        'rating'     => 'sometimes',
                        'tesimonal'     => 'sometimes',
                    ]);
        
        try{
            $user_shop = UserShop::whereId($request->user_shop_id)->first();
           if($request->hasFile("file_image")){
                    $request['image'] = $this->uploadFile($request->file("file_image"), "user_shop_testimonals")->getFilePath();
                } else {
                    $request['image'] = null;
                }
            $user_shop_testimonal = UserShopTestimonal::create($request->all());
            return redirect()->route('panel.user_shops.edit',[$user_shop->id,'active'=>'testimonial'])->with('success','Testimonial Created Successfully!');
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
    public function show(UserShopTestimonal $user_shop_testimonal)
    {
        try{
            return view('panel.user_shop_testimonals.show',compact('user_shop_testimonal'));
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
    public function edit(UserShopTestimonal $user_shop_testimonal)
    {   
        try{
            
            return view('panel.user_shop_testimonals.edit',compact('user_shop_testimonal'));
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
    public function update(Request $request,UserShopTestimonal $user_shop_testimonal)
    {
        // return $request->all();
        
        $this->validate($request, [
                        'name'     => 'required',
                        'designation'     => 'sometimes',
                        'image'     => 'sometimes',
                        'rating'     => 'sometimes',
                        'tesimonal'     => 'sometimes',
                    ]);
                
        try{
                             
            if($user_shop_testimonal){
                  
                if($request->hasFile("image_file")){
                    $request['image'] = $this->uploadFile($request->file("image_file"), "user_shop_testimonals")->getFilePath();
                    $this->deleteStorageFile($user_shop_testimonal->image);
                } else {
                    $request['image'] = $user_shop_testimonal->image;
                }
                       
                $chk = $user_shop_testimonal->update($request->all());

                  return redirect()->route('panel.user_shops.edit',[$request->user_shop_id,'active'=>'testimonial'])->with('success','Testimonial Updated Successfully!');
            }
            return back()->with('error','User Shop Testimonal not found')->withInput($request->all());
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
    public function destroy(UserShopTestimonal $user_shop_testimonal)
    {
        try{
            if($user_shop_testimonal){
                         
                $this->deleteStorageFile($user_shop_testimonal->image);
                                     
                $user_shop_testimonal->delete();
                return back()->with('success','User Shop Testimonal deleted successfully');
            }else{
                return back()->with('error','User Shop Testimonal not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
