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

            $length = 20;
            $industries = Category::where('parent_id',null)->get();

            if (AuthRole() == 'Admin') {
                $category = Category::get();
                $sub_category = Category::where('level',3)->get();

            }else{
                $category = Category::where('user_id',auth()->id())->where('level',2)->get();
                $sub_category = Category::where('user_id',auth()->id())->where('level',3)->get();
            }



            return view('backend.constant-management.category.index', compact('category','industries','sub_category'));
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
        // $this->validate($request, [
        //     'name' => 'required|max:30',
        //     'level' => 'required',
        //     'category_type_id' => 'required',
        // ]);
        
        // return $request->all();
        try {

            if(AuthRole() == "Admin"){
                $type = 1;
            }else{
                $type = 0;
            }

            $count = 0;

            // Decrypting Data Recenvied Data
            $category_type_id = decrypt($request->category_type_id);
            $user_id = decrypt($request->user_id);
            $shop_id = decrypt($request->shop_id);
            // Conveting To Proper Case
            $catname = strtolower($request->name);
            $catname = ucwords($catname);      
            


            // Creating and CHecking FO ruNdefined Category for Users Category
            if ($request->get('parent_id') == null) {

                $chk_undefined = Category::where('name','undefined')->where('user_id',null)->get();            
                if (count($chk_undefined) == 0) {
                    $industry_for_user = Category::create([
                        'name' => 'undefined',
                        'category_type_id' => $category_type_id,
                        'level' => 1,
                        'parent_id' => null,
                        'user_id' => null,
                        'type' => 1,
                        'icon' => null
                    ]);
                    echo "UNdefined Industru Is not Exist".newline();
                }else{
                    echo "UNdefined Industru Already Exist".newline();
                    $industry_for_user = $chk_undefined[0];
                }
    
                $chk_own = Category::where('name',$catname)->where('user_id',$user_id)->get();
                $chk_Default = Category::where('name',$catname)->where('user_id',null)->get();

                // Validating Category Name
                if (count($chk_own) != 0) {
                    echo "Category Already Exist in Your Account.";
                }

                if (count($chk_Default) != 0) {
                    echo "System Category Already Exist, With Same Name.";
                }

                
                $category = Category::create([
                    'name' => $catname,
                    'category_type_id' => $category_type_id,
                    'level' => 2,
                    'parent_id' => $industry_for_user->id,
                    'user_id' => $user_id,
                    'type' => $type,
                    'icon' => null
                ]);

                foreach (explode(",",$request->value[0]) as $key => $value) {
                    // Converting TO ProperCase
                    $value = strtolower($value);
                    $value = ucwords($value);

                    Category::create([
                        'name' => $value,
                        'category_type_id' => $category_type_id,
                        'level' => 3,
                        'parent_id' => $category->id,
                        'user_id' => $user_id,
                        'type' => $type,
                        'icon' => null
                    ]);

                    $count++;
                }

            }else{


                if (AuthRole() != 'Admin') {
                    return back()->with('error',"You Don't Have Permission to Access This Page");
                }

                $chk_Default = Category::where('name',$catname)->where('user_id',null)->get();

                if (count($chk_Default) != 0) {
                    echo "System Category Already Exist, With Same Name.";
                }
                
                $category = Category::create([
                    'name' => $catname,
                    'category_type_id' => $category_type_id,
                    'level' => 2,
                    'parent_id' => $request->parent_id,
                    'user_id' => null,
                    'type' => $type,
                    'icon' => null
                ]);

                foreach (explode(",",$request->value[0]) as $key => $value) {
                    // Converting TO ProperCase
                    $value = strtolower($value);
                    $value = ucwords($value);

                    Category::create([
                        'name' => $value,
                        'category_type_id' => $category_type_id,
                        'level' => 3,
                        'parent_id' => $category->id,
                        'user_id' => null,
                        'type' => $type,
                        'icon' => null
                    ]);
                    $count++;
                }



            }


            // ` For Icon Of The Category

            // if ($request->hasFile('icon')) {
            //     $image = $request->file('icon');
            //     $path = storage_path('app/public/backend/category-icon');
            //     $imageName = 'category-icon' . $data->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
            //     $image->move($path, $imageName);
            //     $data->icon=$imageName;
            // }

            
            return redirect('panel/constant-management/category/view/13')->with('success', "1 Category and $count Sub-category created successfully.");
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



    public function bulkdelete(Request $request,$user_id) {

        try {
            
            $countcategoy = 0;
            $countSubcategoy = 0;
            $ids = explode(",",$request->delete_ids);
            
            
            
            // ! Validating ....
            foreach ($ids as $key => $value) {
                $chk = Product::where('category_id',$value)->get();
                if (count($chk) != 0) {
                    $name = $chk[0]->name;
                    // echo "You Cannot Delete $name Because it is linked with Products".newline();
                    return back()->with('error',"You Cannot Delete $name Because it is linked with Products");
                }
            }

            
            // Deleting Sub Categories
            foreach ($ids as $key => $value) {
                $record = Category::where('parent_id',$value)->get();
                foreach ($record as $key => $item) {
                    $item->delete();
                    $countSubcategoy++;
                }
                // $record->delete();
                Category::whereId($value)->delete();

                $countcategoy++;
            }
            
            

            return back()->with('success',"$countcategoy category, and $countSubcategoy are deleted Successfully.");
        } catch (\Throwable $th) {
            throw $th;
        }


    }




}
