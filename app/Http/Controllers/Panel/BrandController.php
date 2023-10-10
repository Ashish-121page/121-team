<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\BrandUser;
use App\Models\SupportTicket;
use App\Models\Media;

class BrandController extends Controller
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
         $brands = Brand::query();
        
            if($request->get('search')){
                $brands->where('id','like','%'.$request->search.'%')
                                ->orWhere('status','like','%'.$request->search.'%')
                                ->orWhere('name','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $brands->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }
            if($request->has('status') && $request->get('status') == $request->status && $request->get('status') != null){
                $brands->where('status',$request->status);
            }
            if($request->has('is_verified') && $request->get('is_verified') == $request->is_verified && $request->get('is_verified') != null){
                $brands->where('is_verified',$request->is_verified);
            }
            
            if($request->get('asc')){
                $brands->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $brands->orderBy($request->get('desc'),'desc');
            }

            if(AuthRole() == 'Admin'){

            }elseif(AuthRole() == 'User' && isSeller(auth()->id())){
            //   $scope = BrandUser::whereStatus(1)->whereUserId(auth()->id())->pluck('brand_id');
                $scope = BrandUser::whereStatus(1)->whereUserId(auth()->id())->pluck('brand_id');
                $brands->where(function($query) use($scope){
                    $query->whereIn('id', $scope)->orWhere('user_id',auth()->id());
                });
            }

            $brands = $brands->latest()->paginate($length);
            // return dd($brands);

            if ($request->ajax()) {
                return view('panel.brands.load', ['brands' => $brands])->render();  
            }
 
        return view('panel.brands.index', compact('brands','request'));
    }

    
        public function print(Request $request){
            $brands = collect($request->records['data']);
                return view('panel.brands.print', ['brands' => $brands])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.brands.create');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

     public function legalDetailsUpdate(Request $request, $brand_id)
    {
        $brand_record =  BrandUser::whereId($brand_id)->first();
        try {
            $brand_record->user_id=auth()->id();
            $brand_record->status=0;
            $brand_record->brand_id=$brand_id;
            $brand_record->type=$request->type;
            $brand_record->is_verified=0;
            $arr = [
                'est_date'=>$request->est_date,
                'brand_name'=>$request->brand_name,
                'address'=>$request->address,
                'pincode'=>$request->pincode,
               'email'=>$request->email,
               'phone'=>$request->phone,
               'country'=>$request->country,
               'state'=>$request->state,
               'city'=>$request->city,
            ];
            $brand_record->details=json_encode($arr);
            
           
           // Store Proof Certificate
            if($request->hasFile("proof_certificate")){
               $proof_certificate = $this->uploadFile($request->file("proof_certificate"), "brand_users")->getFilePath();
               $filename = $request->file('proof_certificate')->getClientOriginalName();
               $extension = pathinfo($filename, PATHINFO_EXTENSION);
               $media_user_proof = Media::whereType('BrandUserProof')->whereTypeId($brand_id)->whereTag('brand_proof_certificate')->first();
               if($media_user_proof){
                  $media_user_proof->update([
                    'file_name' => $filename,
                    'path' => $proof_certificate,
                    'extension' => $extension,
                    'file_type' => "Image",
                  ]);
               }else{
                    Media::create([
                        'type' => 'BrandUserProof',
                        'type_id' => $brand_id,
                        'file_name' => $filename,
                        'path' => $proof_certificate,
                        'extension' => $extension,
                        'file_type' => "Image",
                        'tag' => "brand_proof_certificate",
                    ]);
               }
                    
            }
            // Store Brand Logo
            if($request->hasFile("logo")){
               $logo = $this->uploadFile($request->file("logo"), "brand_users")->getFilePath();
               $filename = $request->file('logo')->getClientOriginalName();
               $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if($filename != null){
               Media::create([
                   'type' => 'BrandLogo',
                   'type_id' => $brand_id,
                   'file_name' => $filename,
                   'path' => $logo,
                   'extension' => $extension,
                   'file_type' => "Image",
                   'tag' => "brand_logo",
               ]);
               }
            }
            
           $brand_record->save();
           return redirect()->route('panel.brands.edit',[$brand_id,'active' => 'legal'])->with('success', 'Brand record updated successfully!');
        //    return back()
       } catch (\Exception $e) {
           return back()->with('error', 'Error: ' . $e->getMessage());
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
                        'name'     => 'required',
                        'logo'     => 'sometimes',
                        'status'     => 'sometimes',
                        'short_text'     => 'sometimes',
                    ]);
        
        try{
             $chk = Brand::where('user_id',$request->user_id)->first();
            if($request->hasFile("logo_file")){
                $logo = $this->uploadFile($request->file("logo_file"), "brands")->getFilePath();
                $filename = $request->file('logo_file')->getClientOriginalName();
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
            } else {
                return $this->error("Please upload an file for logo");
                $filename = null;
                $extension = null;
            }

            if(AuthRole() == "Admin"){
                $request['is_verified'] = 1;
            }elseif(AuthRole() == "User"){
                $request['is_verified'] = 0;
                $request['user_id'] = auth()->id();
            }

            $brand = Brand::create($request->all());
            if($filename != null){
                Media::create([
                    'type' => 'Brand',
                    'type_id' => $brand->id,
                    'file_name' => $filename,
                    'path' => $logo,
                    'extension' => $extension,
                    'file_type' => "Image",
                    'tag' => "Logo",
                ]);
            }

            return redirect()->route('panel.brands.index')->with('success','Brand Created Successfully!');
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
    public function show(Brand $brand)
    {
        try{
            return view('panel.brands.show',compact('brand'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function sellerRequests(Brand $brand)
    {
        // return view('');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {  
      
        try{
         // BrandID Check
          if($id == null || $id == 0){
              return back()->with('error', 'Brand not exisit!');
          }
            $brand = Brand::whereId($id)->first(); 
               
            // }

          // Brand Presence Check
          if(!$brand){
                return back()->with('error', 'Brand not exisit!');
          }
          
          if(AuthRole() == "User"){
            // Check Self Brand
            if($brand->user_id == auth()->id()){

            }else{
                // Brand Permission Check
                $brand_user = BrandUser::whereBrandId($id)->whereUserId(auth()->id())->first();
                if(!$brand_user){
                      return back()->with('error', 'You don\'t have permission to access!');
                }
            }
          }
            $media = Media::whereType('Brand')->whereTypeId($brand->id)->whereTag('Logo')->first();
            return view('panel.brands.edit',compact('brand','media'));
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
    public function update(Request $request,Brand $brand)
    {
        // return $request->all();
        $this->validate($request, [
                        'name'     => 'required',
                        'logo'     => 'sometimes',
                        'status'     => 'sometimes',
                        'short_text'     => 'sometimes',
                    ]);
                
        try{      
             $chk = Brand::where('id','!=',$brand->id)->where('user_id',$request->user_id)->first();
            //   if($chk){
            //     return back()->with('error', 'This user already have a brand!')->withInput($request->all());
            //   }       
            if($brand){
                if($request->hasFile("logo_file")){
                $logo = $this->uploadFile($request->file("logo_file"), "brands")->getFilePath();
                $this->deleteStorageFile($brand->logo);
                $filename = $request->file('logo_file')->getClientOriginalName();
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                if($filename != null){
                    $media = Media::whereType('Brand')->whereTypeId($brand->id)->whereTag('Logo')->first();
                       // return $media;
                       if($media){
                           $media->update([
                               'file_name' => $filename,
                               'path' => $logo,
                               'extension' => $extension,
                               'file_type' => "Image",
                           ]);
                       }
                   }
                } else {
                 $logo = $brand->logo;
                }
                if(AuthRole() == "Admin"){
                    $request['is_verified'] = $request->is_verified;
                }else{
                    $request['is_verified'] = $brand->is_verified;
                }
                       
                $chk = $brand->update($request->all());
                $filename = null;

                return redirect()->route('panel.brands.index')->with('success','Record Updated!');
            }
            return back()->with('error','Brand not found')->withInput($request->all());
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
    public function destroy(Brand $brand)
    {
        try{
            $product = Product::whereBrandId($brand->id)->first();
            if($product){
              return back()->with('error','This brand contains a product so we are unable to remove it, you can unpublish it');
            }
            if($brand){
                $this->deleteStorageFile($brand->logo);
                $brand->delete();
                return back()->with('success','Brand deleted successfully');
            }else{
                return back()->with('error','Brand not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
