<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProposalItem;
use App\Models\Proposal;
use App\Models\MailSmsTemplate;
use App\Models\Product;
use App\Models\BrandUser;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\AccessCatalogueRequest;
use App\Models\ExportTemplates;
use App\User;
use App\Models\UserShopItem;
use App\Models\UserShop;
class ProposalController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {


         $length = 12;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $proposals = Proposal::query();

            if($request->get('search')){
                $proposals->where('id','like','%'.$request->search.'%')
                                ->orWhere('customer_details','like','%'.$request->search.'%')
                ;
            }

            if($request->get('from') && $request->get('to')) {
                $proposals->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $proposals->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $proposals->orderBy($request->get('desc'),'desc');
            }
            if($request->has('status') && $request->get('status') != null){

                $proposals->where('status',$request->get('status'));
            }
            if(AuthRole() == "User" && auth()->user()->is_supplier == 1){
                $proposals->whereUserId(auth()->id());
            }elseif(AuthRole() == "Admin"){
                $proposals;
            }else{
                // False condition to don't show anything.
                $proposals->whereUserId(0);
            }

            if ($request->has('Sent')) {
                if ($request->get('Sent') == 'draft') {
                    $proposals->where('status',0);
                }elseif ($request->get('Sent') == 'sent') {
                    $proposals->where('status',1);
                }else{
                    // No Condition...
                }
            }
            if ($request->has('Buyer_name') && $request->get('Buyer_name')) {
                $proposals->where('customer_details','LIKE',"%".$request->get('Buyer_name')."%");
            }

            $proposals = $proposals->withCount('items')->orderBy('id','DESC')->paginate($length);




            if ($request->ajax()) {
                return view('panel.proposals.load', ['proposals' => $proposals])->render();
            }

        return view('panel.proposals.index', compact('proposals'));
    }


    public function print(Request $request){
        $proposals = collect($request->records['data']);
        return view('panel.proposals.print', ['proposals' => $proposals])->render();
    }
    public function sent(Request $request,Proposal $proposal){
        $cust_details = json_decode($proposal->customer_details);
        $mailcontent_data = MailSmsTemplate::where('code','=',"send-proposal")->first();
        if($mailcontent_data){
            $arr=[
                '{customer_name}'=>$cust_details->customer_name,
            ];
            $msg = DynamicMailTemplateFormatter($mailcontent_data->body,$mailcontent_data->variables,$arr);
            sendSms($cust_details->customer_mob_no,$msg,$mailcontent_data->footer);
        }
       $proposal->status = 1;
       $proposal->save();
       return back()->with('success','Proposal Sent!');
    }


    public function shopProposalIndex(Request $request, $proposal_slug)
    {

        $slug = $request->subdomain;
        $user_shop = UserShop::whereSlug($slug)->first();
        $proposal = Proposal::where('slug',$proposal_slug)->first();

        $product_ids = ProposalItem::whereProposalId($proposal->id)->orderBy('sequence','ASC')->get()->pluck('product_id')->toArray();
        if ($product_ids == null) {
            $response = ["response"=> "Theire is 0 Product in This Offer.","code" => 200];
            // return $response;
            return abort(404);
        }

        $products = Product::whereIn('id',$product_ids)
        ->where('is_publish',1)
        ->orderByRaw('FIELD(id, '.implode(", " , $product_ids).')')
        ->get();

        // Check Proposal Is Expired of Not
        $today = \Carbon\Carbon::now();
        if ($proposal->valid_upto != null) {
            if ($proposal->valid_upto < $today) {
                // Redirect to 404 Page
                return view('expired');
            }
        }

        if ($proposal->user_shop_id != UserShopIdByUserId(auth()->id())) {
            $proposal->view_count = $proposal->view_count + 1;
            $proposal->last_opened = $today;
            $proposal->save();
        }

        $newimag = [];
        for ($i=0; $i < count($product_ids); $i++) {
            $image_path = getShopProductImage($product_ids[$i],'multi');
            $tmp_img = [];
            for ($j=0; $j < 4; $j++) {
                if (isset($image_path[$j]) && $image_path[$j] != "") {
                    array_push($tmp_img,asset($image_path[$j]->path));
                }else{
                    // $nullpoint = asset("frontend/assets/img/placeholder.png");
                    $nullpoint = '';

                    array_push($tmp_img,$nullpoint);
                }
            }
            array_push($newimag,$tmp_img);
        }

        $product_title = Product::whereIn('id',$product_ids)->get()->pluck('title')->toArray();
        $product_model = Product::whereIn('id',$product_ids)->get()->pluck('model_code')->toArray();
        $product_color = Product::whereIn('id',$product_ids)->get()->pluck('color')->toArray();
        $product_size = Product::whereIn('id',$product_ids)->get()->pluck('size')->toArray();
        $product_desc = Product::whereIn('id',$product_ids)->get()->pluck('description')->toArray();

        $pptTesmplate = '';

        $usertemplates_ppt = ExportTemplates::where('user_id',$proposal->user_id)->where('type','ppt')->where('default',1)->get();
        $systemtemplates_ppt = ExportTemplates::where('user_id',null)->where('type','ppt')->get();

        if (count($usertemplates_ppt) == 0) {
            $pptTesmplate = $systemtemplates_ppt;
        }else{
            $pptTesmplate = $usertemplates_ppt;
        }

        $cust_details = json_decode($proposal->customer_details,true);

        if ($request->has('optionsforoffer') && $request->get('optionsforoffer') != null) {
            $selectedProp = [];
            $selectedProp = $request->get('optionsforoffer');
        }else{
            $selectedProp = [];
        }


        $pagetitle = '';
        if (request()->has('download') && request()->get('download') == 'ppt'){
            $pagetitle = 'PPT Preview';
        } elseif (!request()->has('download') || request()->get('download') == null) {
            $pagetitle = 'PDF Preview';
        } elseif (request()->has('download') && request()->get('download') == 'excel'){
            $pagetitle = 'Excel Preview';                        
        } else {
            $pagetitle = 'Shop';
        }




        // magicstring($newimag);
        // return;



        return view('frontend.micro-site.shop.proposal.index',compact('slug','products','user_shop','cust_details','proposal','proposal_slug','product_ids','product_title','product_model','product_color','product_size','product_desc','newimag','pptTesmplate','selectedProp','pagetitle'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            if(AuthRole() == "User"){
                $package = getUserPackageInfo(auth()->id());
                if(!$package){
                    return back()->with('error','You dont have any active package');
                }
                // return Proposal::whereUserId(auth()->id())->get()->count();
                $limits = json_decode($package->limit,true);
                $current_proposals = Proposal::whereUserId(auth()->id())->get()->count();

                if($limits['custom_proposals'] <= $current_proposals ){
                    return  back()->with('error','Your Custom Proposals limit exceed!');
                }
            }
            $arr = [
                'customer_name'=> '',
                'customer_mob_no'=> '',
            ];
            $proposal = new Proposal();
            $proposal->customer_details = json_encode($arr);
             $proposal->slug = getUniqueProposalSlug("proposal".auth()->id());
             $proposal->user_id = auth()->id();
             $proposal->user_shop_id = UserShopIdByUserId(auth()->id());
             $proposal->save();
            return redirect(route('panel.proposals.edit',$proposal->id));
            // return view('panel.proposals.create');
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

        $this->validate($request, [
            'customer_name'     => 'required',
            'user_shop_id'     => 'required',
        ]);

        try{
            $arr = [
                'customer_f'=> '',
                'customer_mob_no'=> '',
            ];
            $request['customer_details'] = json_encode($arr);
            $request['slug'] = getUniqueProposalSlug($request->customer_name);
            $proposal = Proposal::create($request->all());

            return redirect()->route('panel.proposals.edit',$proposal->id)->with('success','Proposal Created Successfully!');
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
    public function show(Proposal $proposal)
    {
        try{
            return view('panel.proposals.show',compact('proposal'));
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
    public function edit(Request $request, Proposal $proposal)
    {

        // return $request->all();
        if($request->has('direct')){
            return redirect(route('panel.proposals.edit',$proposal->id)."?type=picked");
        }elseif(!$request->has('type')){
            return redirect(route('panel.proposals.edit',$proposal->id)."?type=search");
        }

        if($proposal->user_id != auth()->id()){
            return back();
        }
        $attributes = ProductAttribute::get();
        $colors = $attributes->where('name','Color')->first();
        $sizes = $attributes->where('name','Size')->first();
        $Material = $attributes->where('name','Material')->first();
        $Delivery = $attributes->where('name','Delivery')->first();
        $colors = json_decode($colors->value,true);
        $sizes = json_decode($sizes->value,true);
        $material = json_decode($Material->value,true);
        // $delperiod = json_decode($Delivery->value,true);
        // $supplier_phones = AccessCatalogueRequest::whereUserId(auth()->id())->whereStatus(1)->pluck('number');
        // Show All Suppliers
        $supplier_phones = AccessCatalogueRequest::whereUserId(auth()->id())->pluck('number');
        $suppliers = User::whereIn('phone',$supplier_phones)->where('status',1)->get();
        $supplier_shop_products = UserShopItem::whereIn('user_id',$suppliers->pluck('id'))->where('is_published',1)->pluck('product_id');
        $supplier_shop_products_list = UserShopItem::whereIn('user_id',$suppliers->pluck('id'))->where('is_published',1)->get();

        $userids = User::role('User')->pluck('id');
        $brands = Brand::whereStatus(1)->where(function($brand_query) use ($userids){
                    $brand_query->where('user_id','=',auth()->id());
                    $brand_query->orWhereNotIn('user_id',$userids)->whereIsVerified(1);
                    $brand_query->orWhere('user_id','=',null)->whereIsVerified(1);
                })->get();

        $master_products = Product::query();

        $master_products->where(function($query) use($brands,$supplier_shop_products){
            $query->where('user_id',auth()->id());
            $query->orWhereIn('brand_id',$brands->pluck('id'));
            $query->orWhereIn('id',$supplier_shop_products);
        });

        $master_products_categories = $master_products->where('is_publish',1)->get()->pluck('category_id');
        $categories = Category::whereIn('id',$master_products_categories)->groupBy('id')->get();

        if($request->has('name') && $request->get('name') != null){
            $product_ids = $master_products->where('title','LIKE',"%".$request->get('name')."%")->pluck('id');
            $user_shop_item =  UserShopItem::whereIn('product_id',$product_ids)->pluck('product_id');
            $master_products->whereIn('id',$user_shop_item);
        }

        if($request->has('color') && $request->get('color') != null){
            $master_products->where('color', $request->get('color'));
        }

        if($request->has('materials') && $request->get('materials') != null){
            $master_products->where('material', $request->get('materials'));
        }
        if($request->has('my_product') && $request->get('my_product') != null){
            $master_products->where('user_id', auth()->id());
        }
        if($request->has('size') && $request->get('size') != null){
            $master_products->where('size', $request->get('size'));
        }
        if($request->has('qty') && $request->get('qty') != null){
            $master_products->where('stock_qty','>=',$request->get('qty'));
        }
         if(request()->has('category_id') && $request->get('category_id') != ''){
        //  if(request()->has('category_id') && request()->has('sub_category_id')){
            $master_products->where('category_id',$request->category_id);
            // ->where('sub_category',$request->sub_category_id);
        }
        if($request->has('to') && ($request->has('from'))){
            // return dd('h');
            if($request->get('to') != null && ($request->get('from')) != null){
                $master_products->whereBetween('price',[$request->get('from'),$request->get('to')]);
            }elseif($request->get('to') == null && ($request->get('from')) != null){
                $master_products->where('price','>=',$request->get('from'));
            }elseif($request->get('to') != null && ($request->get('from')) == null){
                $master_products->where('price','<=',$request->get('to'));
            }
        }
        if($request->has('suppliers') && $request->get('suppliers') != null){
            $supplier_shop_products = UserShopItem::whereIn('user_id',$request->get('suppliers'))->where('is_published',1)->pluck('product_id');
            $master_products->whereIn('id',$supplier_shop_products);
        }

        if($request->has('brands') && $request->get('brands') != null){
            $master_products->whereIn('brand_id',$request->get('brands'));
        }

        $master_products = $master_products->where('is_publish',1)->orderBy('pinned','DESC')->orderBy('price', 'ASC')->groupBy('id')->paginate(45);
        $added_products = ProposalItem::whereProposalId($proposal->id)->orderBy('pinned','DESC')->get();
        $excape_items = $added_products->pluck('product_id')->toArray();

        $pinned_products = ProposalItem::whereProposalId($proposal->id)->where('pinned',1)->orderBy('sequence','ASC')->get();
        $pinned_items = $pinned_products->pluck('product_id')->toArray();

        $main_products = $master_products;
        $hike = $request->hike;


        return view('panel.proposals.edit',compact('proposal','suppliers','brands','excape_items','colors','sizes','main_products','added_products','supplier_shop_products_list','categories','hike','pinned_items','material'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request,Proposal $proposal)
    {
        // return $request->all();
        $this->validate($request, [
            'slug'     => 'required',
            'customer_name'     => 'required',
            'user_shop_id'     => 'required'
        ]);

        if($request->customer_mob_no != null){
            $this->validate($request, [
                'customer_mob_no'     => 'sometimes|min:10|max:10',
            ]);
        }
            $chk = Proposal::where('id','!=',$proposal->id)->where('user_shop_id',$proposal->user_shop_id)->where('slug',$proposal->slug)->first();
            if($chk){
                return back()->with('error',"Slug Must be unique.")->withInput();
            }
        try{

            if($proposal){
                $arr = [
                'customer_name'=> $request->customer_name,
                'customer_mob_no'=> $request->customer_mob_no,
                ];
                $request['customer_details'] = json_encode($arr);
                if($request->hasFile("client_logo_file")){
                    $request['client_logo'] = $this->uploadFile($request->file("client_logo_file"), "client_logo")->getFilePath();
                } else {
                    $request['client_logo'] = null;
                }

                $proposal = $proposal->update($request->all());

                return back()->with('success','Proposal Updated!');
            }
            return back()->with('error','Proposal not found')->withInput($request->all());
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }
    public function updatePrice(Request $request,Proposal $proposal)
    {
        // return $request->all();
        $this->validate($request, [
            'price'     => 'required',
        ]);
            $proposal_item = ProposalItem::where('proposal_id',$proposal->id)->whereProductId($request->product_id)->first();
        try{

            if($proposal_item){

                $proposal_item->update([
                    'price' => $request->price
                ]);

                return back()->with('success','Proposal Updated!');
            }
            return back()->with('error','Proposal not found')->withInput($request->all());
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
    public function destroy(Proposal $proposal)
    {
        try{
            if($proposal){

                $ProposalItem = ProposalItem::where('proposal_id','=',$proposal->id)->delete();
                $proposal->delete();

                return back()->with('success','Proposal deleted successfully');
            }else{
                return back()->with('error','Proposal not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function removeImage(Request $request ,Proposal $proposal)
    {
        try{
            if($proposal){
                if($proposal->client_logo != null) {
                    $client_logo = $proposal->client_logo;
                    $proposal->update([
                        'client_logo' => null
                    ]);
                }
                return back()->with('success','Client Logo deleted successfully');
            }else{
                return back()->with('error','Client Logo not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


    public function adminView(Request $request){
        // echo "This is Porposal Function";

            $length = 50;

            if(request()->get('length')){
                $length = $request->get('length');
            }
            $article = ProposalItem::query();
            //   return $request->all();

             if($request->get('from') && $request->get('to'))
             {
            //  return explode(' - ', $request->get('date')) ;
             $article->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
             }

            // if($request->get('type')){
            //     $article->where('category_id','=',$request->type);
            // }
            $article->groupBy('proposal_id')->sortBy('id','ASC');

            $article= $article->paginate($length);
            if ($request->ajax()) {
                return view('backend.constant-management.proposals.load', ['article' => $article])->render();
            }

        return view('backend.constant-management.proposals.index', compact('request','article'));
    }


    public function deleteDrafts(Request $request, $userId){

        if (AuthRole() != 'Admin') {
            return back()->with('error',"You Don't Have Permission to Access this Page");
        }

        $count = 0;

        try {
            $draft_offers = Proposal::where('user_id',$userId)->where('status',0)->pluck('id');
            $blank_offers = [];
            foreach ($draft_offers as $key => $value) {
                if (count(ProposalItem::where('proposal_id',$value)->get()) == 0) {
                    array_push($blank_offers,$value);
                }
            }

            // ! Deleting Draft Offers
            // foreach ($draft_offers as $key => $value) {
            //     $draft_offers = Proposal::find($value);
            //     $proposal_item = ProposalItem::where('proposal_id',$value)->delete();
            //     $draft_offers->delete();
            //     $count++;
            // }

            // ! Deleting Blank Offers
            foreach ($blank_offers as $key => $value) {
                $blank_offers = Proposal::find($value);
                $proposal_item = ProposalItem::where('proposal_id',$value)->delete();
                $blank_offers->delete();
                $count++;
            }


            $msg =  "$count Offer Deleted Succesfully";
            return back()->with('success',$msg);

        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error',"There was an Error While Deleteing Offer $th");
        }
    }





}
