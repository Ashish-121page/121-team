<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ProposalItem;
use App\Models\UserShopItem;
use App\Models\Product;
use App\Models\tempProposalController as tmpproposal;

class ProposalItemController extends Controller
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
         $proposal_items = ProposalItem::query();
         
            if($request->get('search')){
                $proposal_items->where('id','like','%'.$request->search.'%')
                                ->orWhere('price','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $proposal_items->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $proposal_items->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $proposal_items->orderBy($request->get('desc'),'desc');
            }
            $proposal_items = $proposal_items->paginate($length);

            if ($request->ajax()) {
                return view('panel.proposal_items.load', ['proposal_items' => $proposal_items])->render();  
            }
 
        return view('panel.proposal_items.index', compact('proposal_items'));
    }

    
        public function print(Request $request){
            $proposal_items = collect($request->records['data']);
                return view('panel.proposal_items.print', ['proposal_items' => $proposal_items])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.proposal_items.create');
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
                        'proposal_id'     => 'required',
                        'product_id'     => 'required',
                        'user_shop_item_id'     => 'required',
                        'price'     => 'required',
                        'note'     => 'required',
                    ]);
        
        try{
                 
                 
            $proposal_item = ProposalItem::create($request->all());
                            return redirect()->route('panel.proposal_items.index')->with('success','Proposal Item Created Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }


   
    public function apiStore(Request $request)
    {
        
        try{
            $user_shop_item_id =0;
            $proposal_item = ProposalItem::whereProductId($request->product_id)->whereProposalId($request->proposal_id)->exists();
            if(!$proposal_item){
                $product = Product::whereId($request->product_id)->first();
                    //  $margin = (100 - ($request->hike)) / 100;
                    //  $cost_price = $product->price; 
                    //  $price =  ($cost_price / $margin); 

                    // Ashish

                    $price = $product->price ?? '0';
                     if($request->hike < 100){
                           $margin = ($request->hike) / 100;
                           $margin_factor =  (100-$request->hike)/100;
                          $price  = $price/$margin_factor;
                     }

                    // Ashish

                    //  elseif($request->hike > 100){
                    //      $price =  round((2*$request->hike*$price)/100); 
                    //  }elseif($request->hike == 100){
                    //      $margin = ($request->hike) / 100;
                    //      $price =  round($price * 2);   
                    //  }

                    $proposalCount = ProposalItem::count();
                   
                    if($proposalCount == 0){
                        $sequence = 1;
                    }else{
                        $pItem = ProposalItem::latest()->first();
                        $sequence = $pItem->sequence + 1;
                    }
                    $proposal_item = ProposalItem::create([
                        'proposal_id' => $request->proposal_id,
                        'product_id' => $request->product_id,
                        'user_shop_item_id' => $user_shop_item_id,
                        'price' => round($price),
                        'user_id' => auth()->id(),
                        'sequence' => $sequence,
                    ]);
             
                 if($request->ajax()) {
                     return response(['title' => 'success','message'=>"Proposal Item Added Successfully!"],200);
                 }    
                 return back()->with('success','Proposal Item Added Successfully!');
            }
           
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    public function addpin(Request $request)
    {
        
        try{
            $proposal_item =  ProposalItem::where('proposal_id',$request->proposal_id)->where('product_id',$request->product_id)->where('user_id',auth()->id())->first();
             if($proposal_item){
                 $proposal_item->pinned = 1;
                 $proposal_item->save();
                 if($request->ajax()) {
                     return response(['message'=>"Proposal Item deleted Successfully!"],200);
                 }     
                 return back()->with('success','Proposal Item deleted Successfully!');
             }else{
                 if($request->ajax()) {
                     return response(['message'=>"This Item is not added by you!"],200);
                 }     
                 return back()->with('success','This Item is not added by you!');
             }
         }catch(Exception $e){  
             if($request->ajax()) {
                 return response(['msg'=>"something went wrong"],500);
             }     
             return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
         }


        print_r($request->all());

    }


    public function removepin(Request $request)
    {
        try{
            $proposal_item =  ProposalItem::where('proposal_id',$request->proposal_id)->where('product_id',$request->product_id)->where('user_id',auth()->id())->first();
             if($proposal_item){
                 $proposal_item->pinned = 0;
                 $proposal_item->save();
                 if($request->ajax()) {
                     return response(['message'=>"Proposal Item deleted Successfully!"],200);
                 }     
                 return back()->with('success','Proposal Item deleted Successfully!');
             }else{
                 if($request->ajax()) {
                     return response(['message'=>"This Item is not added by you!"],200);
                 }     
                 return back()->with('success','This Item is not added by you!');
             }
         }catch(Exception $e){  
             if($request->ajax()) {
                 return response(['msg'=>"something went wrong"],500);
             }     
             return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
         }

        

        print_r($request->all());


    }
    
    public function setmargin(Request $request)
    {
        $mar = $request->setmargin;
        if($request->session()->put('setmargin',$mar)){
            return "Session Created";
        }else{
            return "Session Not Created";
        }
        
    }


    public function updateSequence(Request $request,$proposalId)
    {
     
        $proposal_items = ProposalItem::where('proposal_id',$proposalId)->get();
        foreach ($proposal_items as $proposal_item) {
            $proposal_item->timestamps = true; // To disable update_at field updation
            $id = $proposal_item->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    
                    $proposal_item->sequence = $order['position'];
                    $proposal_item->save();
                }
            }
        }
        
        return response('Update Successfully.', 200);
    }
    public function apiRemove(Request $request)
    {
        try{
        //    $proposal_item =  ProposalItem::where('proposal_id',$request->proposal_id)->where('product_id',$request->product_id)->where('user_id',auth()->id())->first();
           $proposal_item =  ProposalItem::where('proposal_id',$request->proposal_id)->where('product_id',$request->product_id)->first();
            if($proposal_item){
                $proposal_item->delete();
                if($request->ajax()) {
                    return response(['message'=>"Proposal Item deleted Successfully!"],200);
                }     
                return back()->with('success','Proposal Item deleted Successfully!');
            }else{
                if($request->ajax()) {
                    return response(['message'=>"This Item is not added by you!"],200);
                }     
                return back()->with('success','This Item is not added by you!');
            }
        }catch(\Exception $e){  
            if($request->ajax()) {
                return response(['msg'=>"something went wrong"],500);
            }     
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(ProposalItem $proposal_item)
    {
        try{
            return view('panel.proposal_items.show',compact('proposal_item'));
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
    public function edit(ProposalItem $proposal_item)
    {   
        try{
            
            return view('panel.proposal_items.edit',compact('proposal_item'));
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
    public function update(Request $request,ProposalItem $proposal_item)
    {
        
        $this->validate($request, [
                        'proposal_id'     => 'required',
                        'product_id'     => 'required',
                        'user_shop_item_id'     => 'required',
                        'price'     => 'required',
                        'note'     => 'required',
                    ]);
                
        try{
                             
            if($proposal_item){
                         
                $chk = $proposal_item->update($request->all());

                return redirect()->route('panel.proposal_items.index')->with('success','Record Updated!');
            }
            return back()->with('error','Proposal Item not found')->withInput($request->all());
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
    public function destroy(ProposalItem $proposal_item)
    {
        try{
            if($proposal_item){
                                          
                $proposal_item->delete();
                return back()->with('success','Proposal Item deleted successfully');
            }else{
                return back()->with('error','Proposal Item not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
