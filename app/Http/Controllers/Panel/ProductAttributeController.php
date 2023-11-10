<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\User;

class ProductAttributeController extends Controller
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
         $product_attributes = ProductAttribute::query();
         
            if($request->get('search')){
                $product_attributes->where('id','like','%'.$request->search.'%')
                ->orWhere('name','like','%'.$request->search.'%')
                ;
            }
            
            if(AuthRole() != 'Admin') {
                $product_attributes->where('user_id',auth()->id())->orWhere('user_id');
            }

            if($request->get('from') && $request->get('to')) {
                $product_attributes->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $product_attributes->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $product_attributes->orderBy($request->get('desc'),'desc');
            }
            $product_attributes = $product_attributes->paginate($length);

            if ($request->ajax()) {
                return view('panel.product_attributes.load', ['product_attributes' => $product_attributes])->render();  
                return view('panel.user_shop_items.includes.Properties', ['product_attributes' => $product_attributes])->render();  
            }
 
        return view('panel.product_attributes.index', compact('product_attributes'));
    }

        public function print(Request $request){
            $product_attributes = collect($request->records['data']);
                return view('panel.product_attributes.print', ['product_attributes' => $product_attributes])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.product_attributes.create');
        }catch(\Exception $e){            
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
        
        // return magicstring($request->all());
        $this->validate($request, [
                        'name'     => 'required',
                        'type'     => 'sometimes',
                        'value'     => 'sometimes',
                    ]);
        
        try{
            $UserRole = AuthRole();
            if ($UserRole != 'Admin') {
                // `  Start Creating Custom Attribute....
                $user = User::find(auth()->id());
                $custom_arr_old = json_decode($user->custom_attriute_columns);
                $custom_arr_new = [$request->name];

                // + creating Array for Adding in User Record
                if ($custom_arr_old != null) {
                    $upload_arr = array_merge((array) $custom_arr_old,$custom_arr_new); 
                }else{
                    $upload_arr = $custom_arr_new;
                }

                $user->custom_attriute_columns = json_encode($upload_arr);
                $user->save();
                $type = 1; // User Define Attribute
            }else{
                $type = 0; // Admin Define Attribute
            }
 
            $chkCount = ProductAttribute::where('name',$request->name)->where('user_id',$request->user_id)->get();
            if (count($chkCount) == 0) {   
                // ! Uploading Attributes
                $AttributValue = ProductAttribute::create([
                    'name' => $request->get('name'),
                    'type' => $type,
                    'value' => null,
                    'user_id' => $request->get('user_id') ?? null,
                    'user_shop_id' => $request->get('user_shop_id') ?? null,
                ]);   
                
                // - Checking Values
                foreach (explode(",",$request->value[0]) as $key => $items) {
                    ProductAttributeValue::create([
                        'parent_id' => $AttributValue->id,
                        'user_id' => $request->get('user_id') ?? null,
                        'attribute_value' => $items,
                    ]);
                }
            }else{
                return back()->with('error',"$request->name Property already exists in your Account.");
            }
                
            return redirect()->route('panel.product_attributes.index')->with('success','Product Attribute Created Successfully!');
        }catch(\Exception $e){            
            // return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
            echo $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(ProductAttribute $product_attribute)
    {
        try{
            return view('panel.product_attributes.show',compact('product_attribute'));
        }catch(\Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(ProductAttribute $product_attribute)
    {   
        try{
            
            if (AuthRole() != 'Admin') {
                if ($product_attribute->user_id != auth()->id() && $product_attribute->user_id != null) {
                    return back()->with('error',"Something went wrong.");
                }
            }
            return view('panel.product_attributes.edit',compact('product_attribute'));
        }catch(\Exception $e){            
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
    public function update(Request $request,ProductAttribute $product_attribute)
    {
        
        // $this->validate($request, [
        //         '*' => 'required|alpha_num:ascii'
        //     ]);
                
        try{
            $newrecord = 0;
            $loopcount = 0; 

            //` Create New Values
            if (request()->has('newval') && request()->get('newval') != null) {
                foreach (explode(",",request()->get('newval')) as $key => $items) {    
                    $chk = ProductAttributeValue::where('attribute_value',$items)->where('parent_id',$product_attribute->id)->get();
                    if (count($chk) == 0) {
                        echo "New Value";
                        ProductAttributeValue::create([
                            'parent_id' => $product_attribute->id,
                            'user_id' => $request->get('user_id') ?? null,
                            'attribute_value' => trim($items),
                        ]);
                        $newrecord++;
                    }
                }
            }
            
            // Updating Existing Value
            foreach ($request->except(['_token','user_id','user_shop_id','name','newval']) as $key => $value) {
                echo $value.newline();
                ProductAttributeValue::where('id',$key)->update([
                    'attribute_value' => trim($value),
                ]);
                $loopcount++; 
            }
            

            $product_attribute->visibility = $request->visibility ?? 0;
            $product_attribute->save();


            $msg = "$newrecord are Created and $loopcount are Updated !!";
            // return back()->with('success',"Product Attribute Values Updated")->withInput($request->all());
            return back()->with('success',$msg)->withInput($request->all());
        }catch(\Throwable $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
            // throw $e;
        }

    }



    public function deletevalue(Request $request,$product_attribute_value) {

        $user = auth()->user();
        $chk = ProductAttributeValue::where('user_id',$user->id)->whereId($product_attribute_value)->get();
        $name = '';
        
        if (count($chk) == 0) {
            return back()->with('error',"Value doesn't exist, or isn't linked with your account!!");
        }else{
            $name = $chk[0]->attribute_value;
            ProductAttributeValue::where('user_id',$user->id)->whereId($product_attribute_value)->delete();
        }


        return back()->with('success',"$name Deleted!!");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(ProductAttribute $product_attribute)
    {
        try{
            if($product_attribute){
                                      
                $product_attribute->delete();
                ProductAttributeValue::where('parent_id',$product_attribute->id)->delete();

                $user = User::find(auth()->id());
                $arr = json_decode($user->custom_attriute_columns);
                $index = array_search($product_attribute->name,$arr);
                
                unset($arr[$index]);
                $user->custom_attriute_columns = json_encode($arr);
                $user->save();
                return back()->with('success','Product Attribute deleted successfully');
            }else{
                return back()->with('error','Product Attribute not found');
            }
        }catch(\Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
