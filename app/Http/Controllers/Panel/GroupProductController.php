<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\GroupProduct;
use App\Models\Group;
use App\Models\UserShop;

class GroupProductController extends Controller
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
         $group_products = GroupProduct::query();
         
            if($request->get('search')){
                $group_products->where('id','like','%'.$request->search.'%')
                ->orWhere('price','like','%'.$request->search.'%')
                ->orWhere('group_id','like','%'.$request->search.'%')
                ->orWhere('product_id','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $group_products->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('product')){
                $group_products->where('product_id',$request->get('product'));
            }
            if($request->get('asc')){
                $group_products->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $group_products->orderBy($request->get('desc'),'desc');
            }
            if($request->get('id')){
                $group_products->whereGroupId($request->get('id'));
            }
            $group_products = $group_products->latest()->paginate($length);
            if ($request->ajax()) {
                return view('panel.group_products.load', ['group_products' => $group_products])->render();  
            }
            $group = Group::whereId(request()->get('id'))->first();
 
        return view('panel.group_products.index', compact('group_products','group'));
    }

    
        public function print(Request $request){
            $group_products = collect($request->records['data']);
                return view('panel.group_products.print', ['group_products' => $group_products])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.group_products.create');
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
        $exist_record = GroupProduct::whereGroupId($request->group_id)->whereProductId($request->product_id)->exists();
        if($exist_record){
            return back()->with('error','Item already added');
        }
        $this->validate($request, [
                'group_id'     => 'required',
                'product_id'     => 'required',
                'price'     => 'required',
            ]);
        
        try{

            $group_product = GroupProduct::create($request->all());
            return back()->with('success','Group Product Created Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    public function apiQr(Request $request)
    {
        // return $request->all();
        try{
            $user_shop =  UserShop::whereUserId(auth()->id())->first();
            $url = inject_subdomain('shop?pg='.$request->group_id, $user_shop->slug);
            $html = \QrCode::size(170)->generate($url);
            return response($html,200);
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
    public function show(GroupProduct $group_product)
    {
        try{
            return view('panel.group_products.show',compact('group_product'));
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
    public function edit(GroupProduct $group_product)
    {   
        try{
            
            return view('panel.group_products.edit',compact('group_product'));
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
    public function update(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
                        'product_id'     => 'required',
                        'price'     => 'sometimes',
                    ]);
                
        try{
            $group_product = GroupProduct::find($request->id);       
            if($group_product){
                       
                $chk = $group_product->update($request->all());

                return back()->with('success','Record Updated!');
            }
            return back()->with('error','Group Product not found')->withInput($request->all());
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
    public function destroy(GroupProduct $group_product)
    {
        try{
            if($group_product){
                                      
                $group_product->delete();
                return back()->with('success','Group Product deleted successfully');
            }else{
                return back()->with('error','Group Product not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
