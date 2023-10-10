<?php 
/**
 *

 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */

namespace App\Http\Controllers\Admin\ConstantManagement;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\UserShopItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type_id,Request $request)
    {
        try {
            if($request->has('level')){
                $level = $request->get('level');
            }else{
                $level = 1;
            }
            $nextlevel = $level + 1;
            if($request->has('parent_id')){
                $category = fetchGetData('App\Models\Category',['category_type_id','level','parent_id'],[$type_id,$level,$request->get('parent_id')]);
            }else{
                $category = fetchGetData('App\Models\Category',['category_type_id','level'],[$type_id,$level]);
            }
            
            if(AuthRole() != 'Admin'){
                $user = auth()->user();
                // if(!empty($user->industry_id)){
                if(!is_null($user->industry_id)){
                    if($request->has('parent_id')){
                        $self_category = Category::whereParentId($request->get('parent_id'))->whereLevel($level)->whereUserId($user->id)->whereType(0)->get();
                        $category = Category::whereParentId($request->get('parent_id'))->whereLevel($level)->whereType(1)->whereIn('id',json_decode($user->industry_id))->get();
                        $category = $self_category->merge($category);
                    }else{
                       $self_category = Category::whereLevel($level)->whereUserId($user->id)->whereType(0)->get();
                        $category = Category::whereLevel($level)->whereType(1)->whereIn('id',json_decode($user->industry_id))->get();
                        $category = $self_category->merge($category);
                    }
                }else{
                       $self_category = Category::whereLevel($level)->whereUserId($user->id)->whereType(0)->get();
                        $category = $self_category;
                }
               
            }
            return view('backend.constant-management.category.index', compact('category','level','nextlevel','type_id'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type_id,$level =1,$parent_id = null)
    {
        // $prev_level = $level - 1;
        return view('backend.constant-management.category.create',compact('type_id','level','parent_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:30',
            'level' => 'required',
            'category_type_id' => 'required',
        ]);
        //
        // return $request->all();
        try {

            if(AuthRole() == "Admin"){
                $type = 1;
            }else{
                $type = 0;
            }

            $data = new Category();
            $data->name=$request->name;
            $data->type=$type;
            $data->level=$request->level;
            $data->user_id=auth()->id();
            $data->category_type_id=$request->category_type_id;
            $data->parent_id=$request->parent_id;
            if ($request->hasFile('icon')) {
                $image = $request->file('icon');
                $path = storage_path('app/public/backend/category-icon');
                $imageName = 'category-icon' . $data->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
                $data->icon=$imageName;
            }
            $data->save();

            return redirect('panel/constant-management/category/view/'.$request->category_type_id.'?level='.$request->level.'&parent_id='.$request->parent_id)->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = Category::whereId($id)->first();
        $type_id = $category->category_type_id;
        $level = $category->level;
        $parent_id = $category->parent_id;
        return view('backend.constant-management.category.edit', compact('category','type_id','level','parent_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:30',
            'level' => 'required',
            'category_type_id' => 'required',
        ]);
        // return $request->all();
        $data = Category::findOrFail($id);
        try {
            if ($request->hasFile('icon')) {
                if ($data->icon != null) {
                    unlinkfile(storage_path() . '/app/public/backend/category-icon', $data->icon);
                }
                $image = $request->file('icon');
                $path = storage_path('app/public/backend/category-icon');
                $imageName = 'category-icon' . $data->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
                $data->icon=$imageName;
            }            
            $data->name=$request->name;
            $data->level=$request->level;
            $data->category_type_id=$request->category_type_id;
            $data->parent_id=$request->parent_id;
            $data->save();

            return redirect('panel/constant-management/category/view/'.$request->category_type_id.'?level='.$request->level.'&parent_id='.$request->parent_id)->with('success', 'Category update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return 's';
        $category = Category::whereId($id)->first();

        // Level 1
        if($category->level == 1){
            if($category){
                $category->delete();
                // deleteSubCategory($id);
                if ($category) {
                    return back()->with('success', 'Industry Deleted Successfully!');
                }
            }
        }elseif($category->level == 2){
            $product = Product::whereCategoryId($id)->exists();
            $user_shop = UserShopItem::whereCategoryId($id)->exists();
           // System Defined
               if((!$product || !$user_shop) && (!$product && !$user_shop)){
                   $category->delete();
                //    deleteSubCategory($id);
                   if ($category) {
                       return back()->with('success', 'Category Deleted Successfully!');
                   }
               }else{
                   return back()->with('error','You cannot delete this Category ID since it is linked to a product ');
               }
        }elseif($category->level == 3){
            $product = Product::whereSubCategory($id)->exists();
            $user_shop = UserShopItem::whereSubCategoryId($id)->exists();
           // System Defined
               if((!$product || !$user_shop) && (!$product && !$user_shop)){
                   $category->delete();
                //    deleteSubCategory($id);
                   if ($category) {
                       return back()->with('success', 'Sub Category Deleted Successfully!');
                   }
               }else{
                   return back()->with('error','You cannot delete this Sub Category ID since it is linked to a product ');
               }
        }
    }




    function changeshow(){
        $sub_category = Category::where('user_id','=',null)->where('parent_id','!=',null)->get();
        $category = Category::get();
        
        
        return view('backend.constant-management.category.change',compact('sub_category','category'));

    }


    function change(Request $request) {
        echo "<pre>";
        print_r($request->all());
        echo "</pre>";

        if ($request->has('chcat')) {
            // Update Subcategorises
            try {
                // Todo: Updating Value
                $countProduct = 0;
                $countUSI = 0;
              
                foreach ($request->sub_category_type_id as $subcate) {
                    $usi = DB::table('user_shop_items')->where('sub_category_id',$subcate)->get();
                    foreach ($usi as $user_items) {
                        $change_items = DB::table('user_shop_items')->where('id',$user_items->id)->first();
                        $id = $change_items->id;
                        DB::update('update user_shop_items set sub_category_id = ? where id = ?',[$request->new_category_type_id,$id]);
                        // echo "<pre>";
                        // print_r($change_items->sub_category_id);
                        // echo "<pre>";
                        $countUSI++;
                        
                    }
                }



                foreach ($request->sub_category_type_id as $subcate) {
                    $prod = DB::table('products')->where('sub_category',$subcate)->get();
                    foreach ($prod as $user_items) {
                        $change_items = DB::table('products')->where('id',$user_items->id)->first();
                        $id = $change_items->id;
                        DB::update('update products set sub_category = ? where id = ?',[$request->new_category_type_id,$id]);
                        // echo "<pre>";
                        // print_r($change_items->sub_category);
                        // echo "<pre>";

                        $countProduct++;
                    }
                }

                echo "Update Product = ".$countProduct;
                echo "Update User Shop Items = ".$countUSI;

                return back()->with('success', 'Sub Category Updated Successfully! With Product Count '.$countProduct.' And User Shop Items Count '.$countUSI.' !!');
                
            } catch (\Exception $e) {
                return back()->with('error','You cannot Update This Category has Error'. $e);
                
            }
        }


        if ($request->has('subcat')) {
            
            try {
                // Todo: Updating Value

                $countProduct = 0;
                $countUSI = 0;
                foreach ($request->old_sub_category_type_id as $subcate) {
                    $usi = DB::table('user_shop_items')->where('category_id',$subcate)->where('sub_category_id', $request->subcate)->get();
                    foreach ($usi as $user_items) {
                        $change_items = DB::table('user_shop_items')->where('id',$user_items->id)->first();
                        $id = $change_items->id;
                        DB::update('update user_shop_items set category_id = ? where id = ?',[$request->new_category_type_id_sub,$id]);
                        // echo "<pre>";
                        // print_r($change_items->sub_category_id);
                        // echo "<pre>";
                        $countUSI++;
                        
                    }
                }

                echo "New Loop Started <br><br><br><br><br>";

                foreach ($request->old_sub_category_type_id as $subcate) {
                    $prod = DB::table('products')->where('category_id',$subcate)->where('sub_category',$request->subcate)->get();
                    foreach ($prod as $user_items) {
                        $change_items = DB::table('products')->where('id',$user_items->id)->first();
                        $id = $change_items->id;
                        DB::update('update products set category_id = ? where id = ?',[$request->new_category_type_id_sub,$id]);
                        // echo "<pre>";
                        // print_r($change_items->sub_category);
                        // echo "<pre>";
                        $countProduct++;
                    }
                }
                
                echo "Update Product = ".$countProduct;
                echo "Update User Shop Items = ".$countUSI;



                return back()->with('success', 'Category Updated Successfully! With Product Count '.$countProduct.' And User Shop Items Count '.$countUSI.' !!');

            } catch (\Exception $e) {
                return back()->with('error','You cannot Update this Category ID since it is linked to a product ');   
            }

        }


 

        
    }





}
