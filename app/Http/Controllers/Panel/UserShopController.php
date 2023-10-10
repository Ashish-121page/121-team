<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UserShop;
use App\Models\UserAddress;
use App\Models\UserShopTestimonal;
use App\Models\Media;

class UserShopController extends Controller
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
         $user_shops = UserShop::query();
         
            if($request->get('search')){
                $user_shops->where('id','like','%'.$request->search.'%')
                                ->orWhere('name','like','%'.$request->search.'%')
                                ->orWhere('contact_no','like','%'.$request->search.'%')
                                ->orWhere('slug','like','%'.$request->search.'%')
                                ->orWhere('status','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $user_shops->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $user_shops->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $user_shops->orderBy($request->get('desc'),'desc');
            }
            if(AuthRole() != 'Admin'){
                $user_shops->whereUserId(auth()->id());
            }
            
            $user_shops = $user_shops->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.user_shops.load', ['user_shops' => $user_shops])->render();  
            }
 
        return view('panel.user_shops.index', compact('user_shops'));
     }

    
    public function print(Request $request)
    {
        $user_shops = collect($request->records['data']);
            return view('panel.user_shops.print', ['user_shops' => $user_shops])->render();  
        
    }

    public function updateTestimonial(Request $request)
    {
       $this->validate($request, [
            'title'     => 'required'
        ]);
        
        try{
            $user_shop = UserShop::whereId($request->user_shop_id)->first();
            $testimonial = [
                    'title' => $request->title,
                    'description' => $request->description,
                ];
            $user_shop->update([
                'testimonial' => json_encode($testimonial),
            ]);
            return redirect()->route('panel.user_shops.edit',$request->user_shop_id."?active=about-section")->with('success','Team Updated Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function updateProductsSection(Request $request,UserShop $user_shop)
    {
        
       $this->validate($request, [
            'title'     => 'required'
        ]);
        
        try{
            $user_shop = UserShop::whereId($request->user_shop_id)->first();
            $products = [
                    'title' => $request->title,
                    'description' => $request->description,
                    'label' => $request->label,
                ];
            $user_shop->update([
                'products' => json_encode($products),
            ]);
            return redirect()->route('panel.user_shops.edit',[$user_shop->id,'active'=>'products'])->with('success','Products Section Updated Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.user_shops.create');
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
            'user_id'     => 'required',
            'name'     => 'sometimes',
            'description'     => 'sometimes',
            'logo'     => 'sometimes',
            'contact_no'     => 'sometimes',
            'status'     => 'sometimes',
            'address'     => 'sometimes',
        ]);
        
        try{
            
            if($request->hasFile("img")){
                    $img = $this->uploadFile($request->file("img"), "user_shops")->getFilePath();
                    $filename = $request->file('img')->getClientOriginalName();
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                } else
                { 
                    return $this->error("Please upload an file for Banner");
                    $filename = null;
                    $extension = null;
                    $img = null;
                }
               
            if($request->hasFile("logo_file")){
                $request['logo'] = $this->uploadFile($request->file("logo_file"), "user_shops")->getFilePath();
            }
                
            $user_shop = UserShop::create($request->all());
            if($filename != null){
                Media::create([
                    'type' => 'UserShop',
                    'type_id' => $user_shop->id,
                    'file_name' => $filename,
                    'path' => $img,
                    'extension' => $extension,
                    'file_type' => "Image",
                    'tag' => "Banner",
                ]);
            }
            return redirect()->route('panel.user_shops.index')->with('success','User Shop Created Successfully!');
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
    public function show(UserShop $user_shop)
    {
        try{
            return view('panel.user_shops.show',compact('user_shop'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function updatecontact(Request $request,UserShop $user_shop)
    {
        try{
           if($user_shop){
                 
                $chk = $user_shop->update([
                    'embedded_code'  => $request->embedded_code
                ]);
                
                if (Authrole() == 'Admin') {
                    return redirect()->route('panel.user_shops.index')->with('success','Record Updated!');
                } else {
                    return back()->with('success','Record Updated!');
                }
           }
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
    public function edit(UserShop $user_shop)
   
    {  
        try{
            if (AuthRole() != 'Admin') {
                $user_shop = UserShop::whereId($user_shop->id)->first();
                if($user_shop->user_id != auth()->id()){
                    return redirect()->back();
                }
            }
            $testimonial= json_decode($user_shop->testimonial,true);
            $addresses = UserAddress::whereUserId($user_shop->user_id)->simplePaginate(10);
            $shop_address= json_decode($user_shop->address,true);
            $products= json_decode($user_shop->products,true);
            $story= json_decode($user_shop->story,true);
            $vcard = Media::whereTypeId($user_shop->user_id)->whereType('UserVcard')->whereTag('vcard')->OrderBy('id','desc')->first();
            $team= json_decode($user_shop->team,true);
            $about= json_decode($user_shop->about,true);
            $features= json_decode($user_shop->features,true) ?? '';
            $payments= json_decode($user_shop->payment_details,true);
            $media = Media::whereTypeId($user_shop->id)->whereType('UserShop')->first();
            return view('panel.user_shops.edit',compact('user_shop','media','testimonial','about','payments','story','features','team','products','shop_address','addresses','vcard'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }



    public function updatePayment (Request $request,UserShop $user_shop)
    {
        try{ 
            if($user_shop){
                if($request->hasFile("upi_code")){
                    $qr_img = $this->uploadFile($request->file("upi_code"), "QR-Images")->getFilePath();
                } else {
                    $payment_details = json_decode($user_shop->payment_details);
                    if($payment_details->upi != null){
                       $qr_img =  $payment_details->upi;
                    }else{
                        $qr_img = null;
                    }
                }
        
                $payment = [
                    'upi' => $qr_img,
                    'po' => $request->po_details,
                ];
                        
                $payment_details = json_encode($payment);
                $user_shop->update([
                   'payment_details' =>$payment_details,
                ]);
                   
                return back()->with('success','Payments Details Updated!');
                
            }
            return back()->with('error','User Shop not found')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request,UserShop $user_shop)
    {
        $this->validate($request, [
            'name'     => 'required',
            'slug'     => 'required',
            // 'slug'     => 'required|unique:user_shops,slug,'.$user_shop->id,
        ]);
        
        // magicstring($request->all());
        
        // return;
        
        try{  
            $slugChk = UserShop::where('slug',$request->slug)->where('user_id','!=',$user_shop->user_id)->exists();
            if($slugChk){
                return back()->with('error','Slug already exists');
            }

            if($user_shop){
                $chk = $user_shop->update($request->all());
                if (Authrole() == 'Admin') {
                    return redirect()->route('panel.user_shops.index')->with('success','Record Updated!');
                } else {
                    return back()->with('success','Record Updated!');
                }
            }
            return back()->with('error','User Shop not found')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }


    public function updateuserdetails(Request $request,UserShop $user_shop)
    {
        echo "Update Details of User<br><br>";

        $contact_info = json_encode(array('phone' => $request->phone,'email' =>$request->email,'whatsapp' => $request->whatsapp));

        // Social Media Link
        $fb_link = $request->social_link['fb_link'];
        $in_link = $request->social_link['in_link'];
        $tw_link = $request->social_link['tw_link'];
        $yt_link = $request->social_link['yt_link'];
        $insta_link = $request->social_link['insta_link'];
        $pint_link = $request->social_link['pint_link'];
        $social_link = json_encode(array('fb_link' => $fb_link,'in_link' => $in_link ,'tw_link' => $tw_link , 'yt_link' => $yt_link,'insta_link' => $insta_link,'pint_link' => $pint_link));
        

        if($request->hasFile("img")){
            $img = $this->uploadFile($request->file("img"), "user_shops")->getFilePath();
            $this->deleteStorageFile($user_shop->img);
            $filename = $request->file('img')->getClientOriginalName();
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $media = Media::whereType('UserShop')->whereTag('Banner')->whereTypeId($user_shop->id)->first();
            if ($media) {
                $media->update([
                    'file_name' => $filename,
                    'path' => $img,
                    'extension' => $extension,
                    'file_type' => "Image",
                ]);
            }else{
                Media::create([
                    'type' => 'UserShop',
                    'type_id' => $user_shop->id,
                    'file_name' => $filename,
                    'path' => $img,
                    'extension' => $extension,
                    'file_type' => "Image",
                    'tag' => "Banner",
                ]);
            }

            
        }
        if($request->hasFile("logo_file")){
            $logo = $request['logo'] = $this->uploadFile($request->file("logo_file"), "user_shops")->getFilePath();
            $this->deleteStorageFile($user_shop->logo);
        } else {
            $logo = $request['logo'] = $user_shop->logo;
        }


        $UserShop = UserShop::find($user_shop->id);
        $UserShop->name = $request->name;
        $UserShop->slug = $request->slug;
        $UserShop->contact_info = $contact_info;
        $UserShop->logo = $logo;
        $UserShop->social_links = $social_link;
        $chk = $UserShop->save();


        if ($chk) {
            return back()->with('success','Record Updated!');
        }else{
            return back()->with('error', 'There was an error: ');
        }



       
        
        
    }








    public function otherFiledsUpdate(Request $request,UserShop $user_shop)
    {
       
        
        try{  
            if($user_shop){
                if($request->hasFile("img")){
                    $img = $this->uploadFile($request->file("img"), "user_shops")->getFilePath();
                    $this->deleteStorageFile($user_shop->img);
                    $filename = $request->file('img')->getClientOriginalName();
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $media = Media::whereType('UserShop')->whereTag('Banner')->whereTypeId($user_shop->id)->first();
                    if ($media) {
                        $media->update([
                            'file_name' => $filename,
                            'path' => $img,
                            'extension' => $extension,
                            'file_type' => "Image",
                        ]);
                    }else{
                        Media::create([
                            'type' => 'UserShop',
                            'type_id' => $user_shop->id,
                            'file_name' => $filename,
                            'path' => $img,
                            'extension' => $extension,
                            'file_type' => "Image",
                            'tag' => "Banner",
                        ]);
                    }
                }
                    
                    if($request->hasFile("logo_file")){
                        $request['logo'] = $this->uploadFile($request->file("logo_file"), "user_shops")->getFilePath();
                        $this->deleteStorageFile($user_shop->logo);
                    } else {
                        $request['logo'] = $user_shop->logo;
                    }

                $contact_info = [
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'whatsapp' => $request->whatsapp,
                ];
                
                $request['social_links'] = json_encode($request->social_link);         
                $request['contact_info'] = json_encode($contact_info);         
                $chk = $user_shop->update($request->all());
                
                if (Authrole() == 'Admin') {
                    return redirect()->route('panel.user_shops.index')->with('success','Record Updated!');
                } else {
                    return back()->with('success','Record Updated!');
                }
            }
            return back()->with('error','User Shop not found')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    public function Addressupdate(Request $request,UserShop $user_shop)
    {
        
        try{  
            if($user_shop){
                // $address = [
                //     'flat_number' => $request->flat_number,
                //     'floor' => $request->floor,
                //     'building_name' => $request->building_name,
                //     'line_3_address' => $request->line_3_address,
                //     'country' => $request->country,
                //     'state' => $request->state,
                //     'city' => $request->city,
                // ];
                $contact_info = [
                    'location' => $request->location,
                ];

                $request['address'] = json_encode($request->address);
                $request['contact_info'] = json_encode($contact_info);
                $user_shop->update($request->all());
                
                if (Authrole() == 'Admin') {
                    return redirect()->route('panel.user_shops.index')->with('success','Record Updated!');
                } else {
                    return back()->with('success','Record Updated!');
                }
                    
            }
            return back()->with('error','User Shop not found')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    public function updateAbout(Request $request,UserShop $user_shop)
    {
        // return $request->all();
         try{

            if($user_shop){
                if($request->hasFile("img")){
                    $img = $this->uploadFile($request->file("img"), "about-shop")->getFilePath();
                } else {

                    $tempAbout = json_decode($user_shop->about,true);
                   
                    if(isset($tempAbout['img'])){
                        $img = $tempAbout['img']; 
                    }else{
                        $img = null;
                    }
                }
                $about = [
                    'title' => $request->title,
                    'content' => $request->content,
                    'img' => $img,
                ];
                 $user_shop->update([
                    'about' => json_encode($about),
                ]);

                return back()->with('success','Record Updated!');
                    
            }
            return back()->with('error','User Shop not found')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    public function updateStory(Request $request,UserShop $user_shop)
    {
        
         try{

            if($user_shop){
                if($request->hasFile("img")){
                    $img = $this->uploadFile($request->file("img"), "about-shop")->getFilePath();
                } else {
                    $img = null;
                }
                if ($request->hasFile('cta_file')) {
                    $cta_link = $this->uploadFile($request->file('cta_file'), "cate_and_price_list")->getFilePath();
                }else{
                    $cta_link = $request->cta_link ?? "";
                }

                if ($request->hasFile('prl_file')) {
                    $prl_file = $this->uploadFile($request->file('prl_file'), "cate_and_price_list")->getFilePath();
                }else{
                    $prl_file = $request->prl_link ?? "";
                }

                                
                $story = [
                    'title' => $request->title,
                    'cta_link' => $cta_link,
                    'cta_label' => $request->cta_label,
                    'prl_link' => $prl_file,
                    'prl_label'=> $request->prl_label,
                    'video_link' => $request->video_link,
                    'description' => $request->description,
                    'img' => $img,
                ];
                
                
                 $user_shop->update([
                    'story' => json_encode($story),
                ]);
                


                return back()->with('success','Record Updated!');
                    
            }
            return back()->with('error','User Shop not found')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    public function updateFeatures(Request $request,UserShop $user_shop)
    {
        // return $request->all();
        try{ 
            if($user_shop){
                $features = [
                    'feature_title' => $request->feature_title,
                    'description' => $request->description,
                    'features' => $request->features,
                ];
                $user_shop->update([
                    'features' => json_encode($features),
                ]);
                   
                return back()->with('success','Record Updated!');
                
            }
            return back()->with('error','User Shop not found')->withInput($request->all());
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
    public function destroy(UserShop $user_shop)
    {
        try{
            if($user_shop){
               $this->deleteStorageFile($user_shop->logo);
                $user_shop->delete();
                return back()->with('success','User Shop deleted successfully');
            }else{
                return back()->with('error','User Shop not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function updateShopView(Request $request ,UserShop $user_shop)
    {
        try{
            if($user_shop){
                $user_shop->update([
                    'shop_view' => $request->shop_view,
                    'auto_acr' =>  $request->auto_acr
                ]);
                return back()->with('success','Record Updated!');
            }else{
                return back()->with('error','User Shop not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function removeImage(Request $request ,UserShop $user_shop)
    {
        // return $user_shop;
        try{
            if($user_shop){
                if ($request->type == 'img') {
                    $media = Media::whereType('UserShop')->whereTag('Banner')->whereTypeId($user_shop->id)->first();
                    if ($media) {
                        $media->delete();
                    } else {
                        return back()->with('error','Img not found');
                    }
                }                         
                if ($request->type == 'logo_file') {
                    $user_shop->update([
                        'logo' => null
                    ]);
                }                         
                return back()->with('success','Image deleted successfully');
            }else{
                return back()->with('error','Image not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    
    function printqr(Request $request) {

        $qr = json_decode($request->qr);
        return view('panel.user_shops.printqr',compact('qr'));
    }




}
