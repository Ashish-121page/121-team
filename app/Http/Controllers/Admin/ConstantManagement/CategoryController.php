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
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

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
                $category_own = Category::where('category_type_id',13)
                            ->where('level',2)
                            // ->where('user_id',null)
                            ->where('user_id',auth()->id())
                            ->orderBy('name','ASC')
                            ->get()->toArray();


                $category_global = Category::where('category_type_id',13)
                            ->where('level',2)
                            ->where('user_id',null)
                            ->orderBy('name','ASC')
                            ->get()->toArray();


                $user_selected_category_id = json_decode(auth()->user()->selected_category);


                if ($user_selected_category_id != null) {
                    $user_selected_category_parent = Category::whereIn('id',$user_selected_category_id)->pluck('parent_id')->toArray() ?? [];
                    $user_selected_category = Category::whereIn('id',$user_selected_category_parent)->get()->toArray() ?? [];

                    $category =  array_merge($category_own,$user_selected_category);

                }else{
                    $category =  $category_own;
                }
                $sub_category = Category::where('level',3)->get();

            }

            return view('backend.constant-management.category.index', compact('category','industries','category_global','sub_category'));
        } catch (\Exception $e) {
            throw $e;
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function checkglobal(Request $request) {

        if ($request->ajax()) {
            $name = $request->search;
            $chk = Category::where('name',$name)->where('user_id',null)->first();


            if ($chk != null) {
                $data = Category::where('parent_id',$chk->id)->pluck('name');


                $response  = ['status'=>"SUCCESS","Message"=> "Record Exist!!","DATA" => $data,"COUNT" => $data->count()];
                $response = json_encode($response);

            }else{
                $response  = ['status'=>"FAILED","Message"=> "New Entry","DATA" => "NULL","COUNT" => 0];
                $response = json_encode($response);
            }

            return $response;
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

        if (count(explode(" > ",$request->name)) > 1) {
            $request['name'] = explode(" > ",$request->name)[1];
        }

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
                    echo "UNdefined Industry Is not Exist".newline();
                }else{
                    echo "UNdefined Industry Already Exist".newline();
                    $industry_for_user = $chk_undefined[0];
                }

                $chk_own = Category::where('name',$catname)->where('user_id',$user_id)->get();
                $chk_Default = Category::where('name',$catname)->where('user_id',null)->get();

                // Validating Category Name
                if (count($chk_own) != 0) {
                    echo "Category Already Exist in Your Account.";
                }


                if (count($chk_Default) != 0) {

                    $usrr = auth()->user();
                    $selected_category = json_decode($usrr->selected_category) ?? [];
                    if (!in_array($chk_Default[0]->id,$selected_category)) {
                        $VALUE = $chk_Default[0]->id;
                        array_push($selected_category,"$VALUE");
                    }else{
                        return back()->with('error',"Already Exist in Your Account");
                    }

                    $selected_category = json_encode($selected_category);
                    $usrr->selected_category = $selected_category;
                    $usrr->save();

                    return back()->with('success',"Added SuccessFully");
                }


                if (count($chk_own) != 0 || count($chk_Default) != 0) {
                    return back()->with('error', "Please go to settings -> category to create a new sub-category");
                }

                // Creating Category
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

        $id = decrypt($id);

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
                   return back()->with('error',"First move products to another category before deleting category");
               }



        }elseif($category->level == 3){


            if (AuthRole() == 'Admin') {
                $product = Product::whereSubCategory($id)->exists();
                $user_shop = UserShopItem::whereSubCategoryId($id)->exists();
            }else{
                $product = Product::whereSubCategory($id)->where('user_id',auth()->id())->exists();
                $user_shop = UserShopItem::whereSubCategoryId($id)->where('user_id',auth()->id())->exists();
            }


           // System Defined
               if((!$product || !$user_shop) && (!$product && !$user_shop)){

                    if ($category->user_id == auth()->id()) {
                        $category->delete();
                    }elseif (AuthRole() == 'Admin') {
                        $category->delete();
                    }else{
                        $user = auth()->user();
                        $selected_category = json_decode($user->selected_category) ?? [];

                        foreach ($selected_category as $key => $value) {

                            if ($category->id == $value) {
                                array_splice($selected_category,$key);
                            }
                        }
                        $user->selected_category = json_encode($selected_category);
                        $user->save();
                    }

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


    // ` Perform Ajax Update Only
    function updateAjax(Request $request) {

        try {

            if ($request->task == 'update_name' && $request->value != '') {
                $category_own = Category::whereId($request->id)->where('user_id',auth()->id())->first();
                // $category_system = Category::whereId($request->id)->where('user_id',auth()->id())->first();
                $category = $category_own;
                if (AuthRole() == 'Admin') {
                    $category = Category::whereId($request->id)->first();
                }
                $category->name = $request->value;

                $category->save();
                $response = ['response','Success','msg','Name of the Records are Updated Successfully'];
                return json_encode($response);
            }

            if ($request->task == 'add_new') {
                $count = 0;
                $category_own = Category::whereId($request->id)->where('user_id',auth()->id())->first();
                $category_system = Category::whereId($request->id)->where('user_id',null)->first();

                if ($category_system != null) {
                    $category = $category_system;
                }else{
                    $category = $category_own;
                }

                foreach ($request->value as $key => $value) {
                    $category_own = Category::where('name',$value)->where('parent_id',$category->id)->get();

                    if (count($category_own) != 0 && $value == '') {
                        //` This Command Will Skip This Element if Already Exist, and Value is Blank..
                        continue;
                    }

                    Category::create([
                        'name' => $value,
                        'category_type_id' => $category->category_type_id,
                        'level' => 3,
                        'parent_id' => $category->id,
                        'user_id' => $request->user_id ?? auth()->id(),
                        'type' => 0,
                        'icon' => null
                    ]);
                    $count++;
                }


                $response = ["response"=>"Success","msg"=>"$count New Records are Created Successfully"];
                return json_encode($response);

                return $request->all();
            }




        } catch (\Throwable $th) {
            //throw $th;
            $response = ['response','error','msg','Unable to perform Action Right Now.'];
            return json_encode($response);
        }



    }


    function renamecat(Request $request, User $user){
        try {
            $record = Category::whereId($request->catid)->where('user_id',$user->id)->first();

            if ($record == null) {
                return back()->with('error',"Category Not Found");
            }

            $record->name = $request->new_name;
            $record->save();

            return back()->with('success',"Updated SuccessFully.");
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error',"Unable to Update Right Now try again Later.");
        }

    }



    public function selectglobalCategory(Request $request,$user_id) {

        try {
            $user = User::whereId(decrypt($user_id))->first();
            $exist_category = json_decode($user->selected_category) ?? [];
            if (isset($exist_category)) {
                if ($exist_category != null) {
                    echo "It is not Null";
                    $count = 0;
                    $newcat = [];
                    foreach ($request->globalcategory as $key => $req) {
                        if (in_array($req,$exist_category)) {
                            continue; //- Skip That Category..
                        }else{
                            array_push($exist_category,$req);
                        }
                        $count++;
                    }
                    $user->selected_category = json_encode($exist_category);
                    $user->save();
                }else{
                    $user->selected_category = json_encode($request->globalcategory);
                    $user->save();
                }
            }

            return back()->with('success',"Categories Added !!");

        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error',"There was an Error. $th->getMessage()");
        }


    }



}
