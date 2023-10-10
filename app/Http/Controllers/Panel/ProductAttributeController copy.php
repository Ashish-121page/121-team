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
         $length = 10;
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
                $product_attributes->where('user_id',auth()->id());
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
                        'type'     => 'sometimes',
                        'value'     => 'sometimes',
                    ]);
        
        try{
            $UserRole = AuthRole();

            if ($UserRole != 'Admin') {
                $user = User::find(auth()->id());
                $old_bulk_record = array_keys((array) json_decode($user->bulk_upload_Sheet));
                array_push($old_bulk_record,$request->name);
                // Adding List in User Record
                $new_bulk_record = [];
                foreach ($old_bulk_record as $key => $value) {
                    if ($value != '') {
                        $new_bulk_record[$value] = $key;
                    }
                }
                $old_custom_attriute_columns = array_keys((array) json_decode($user->custom_attriute_columns));
                array_push($old_bulk_record,$request->name);

                $user->custom_attriute_columns = $old_custom_attriute_columns;
                $user->bulk_upload_Sheet = $new_bulk_record;

                $user->save();
                $usershop = UserShopRecordByUserId(auth()->id());
                $request['user_id'] = auth()->id() ?? null;
                $request['user_shop_id'] = $usershop->id ?? null;


            }

            $AttributValue = ProductAttribute::create([
                'name' => $request->get('name'),
                'type' => '',
                'value' => null,
                'user_id' => $request->get('user_id'),
                'user_shop_id' => $request->get('user_shop_id'),
            ]);   

            magicstring($request->all());
            
            foreach (explode(',',$request->value[0]) as $key => $value) {
                // ` Attribuite Value Does Not Exits Need to Craete
                echo $value.newline();

                ProductAttributeValue::create([
                    'parent_id' => $AttributValue->id,
                    'user_id' => $request->get('user_id') ?? null,
                    'attribute_value' => $value,
                ]);
            }
            
            return redirect()->route('panel.product_attributes.index')->with('success','Product Attribute Created Successfully!');
        }catch(\Exception $e){            
            // return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
            ECHO $e;

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
    public function edit(ProductAttribute $product_attribute)
    {   
        try{
            
            if (AuthRole() != 'Admin') {
                if ($product_attribute->user_id != auth()->id()) {
                    return back()->with('error',"Something went wrong.");
                }
            }
            return view('panel.product_attributes.edit',compact('product_attribute'));
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
    public function update(Request $request,ProductAttribute $product_attribute)
    {
    //    return $request->all(); 
        $this->validate($request, [
                        'name'     => 'required',
                        'type'     => 'sometimes',
                        'value'     => 'required',
                    ]);
                
        try{
            
            ProductAttributeValue::where('parent_id',$product_attribute->id)->delete();

            // ` Getttig Id of Product Attribute Values and Updating...
            foreach (explode(",",$request->value[0]) as $key => $value) {
                // - Creating New Records
                ProductAttributeValue::create([
                    'parent_id' => $product_attribute->id,
                    'user_id' => auth()->id(),
                    'attribute_value' => $value,
                ]);
            
            }

            // ` IF USER CHANG NAME OF ATTRIBUTE UPDATE IN HIS RECORD FOR BULK UPLOAD....
            if ($product_attribute->name != $request->get('name')) {
                $user = User::find(auth()->id());
                $OLD_CUSTOM_FIELD = $user->custom_attriute_columns;

                if ($OLD_CUSTOM_FIELD == null || $OLD_CUSTOM_FIELD == '') {
                    $push_arr = [$request->name];
                    $user->custom_attriute_columns = json_encode($push_arr);
                    $user->save();
                }else{
                    echo "Its Not Blank !!".newline(2);
                    // Todo: Checking Old Record Exist Or Not
                    if (!in_array($request->name,json_decode($OLD_CUSTOM_FIELD))) {
                        ECHO "ITS NOT EXIST".newline(2);
                        $searchIndex = array_search($product_attribute->name,json_decode($OLD_CUSTOM_FIELD));
                        $makeUnset = json_decode($OLD_CUSTOM_FIELD)[$searchIndex];
                        unset($makeUnset);                        
                        $NEW_CUSTOM_FIELDS = array_push(json_decode($OLD_CUSTOM_FIELD),$request->name);
                        $user->custom_attriute_columns = $NEW_CUSTOM_FIELDS;
                        $user->save();
                    }
                }
            

                $product_attribute->name = $request->get('name');
                $product_attribute->save();
            }

            
            return back()->with('success','Product Attribute Updated !!')->withInput($request->all());
        }catch(\Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
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
                return back()->with('success','Product Attribute deleted successfully');
            }else{
                return back()->with('error','Product Attribute not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
