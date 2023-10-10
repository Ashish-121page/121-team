<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
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
         $carts = Cart::query();
         
            if($request->get('search')){
                $carts->where('id','like','%'.$request->search.'%')
                                ->orWhere('price','like','%'.$request->search.'%')
                                ->orWhere('qty','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $carts->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $carts->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $carts->orderBy($request->get('desc'),'desc');
            }
            $carts = $carts->paginate($length);

            if ($request->ajax()) {
                return view('panel.carts.load', ['carts' => $carts])->render();  
            }
 
        return view('panel.carts.index', compact('carts'));
    }

    
        public function print(Request $request){
            $carts = collect($request->records['data']);
                return view('panel.carts.print', ['carts' => $carts])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.carts.create');
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
                        'user_shop_id'     => 'required',
                        'product_id'     => 'required',
                        'user_shop_item_id'     => 'required',
                        'qty'     => 'required',
                        'price'     => 'required',
                        'total'     => 'required',
                    ]);
        
        try{
                   
                   
            $cart = Cart::create($request->all());
                            return redirect()->route('panel.carts.index')->with('success','Cart Created Successfully!');
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
    public function show(Cart $cart)
    {
        try{
            return view('panel.carts.show',compact('cart'));
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
    public function edit(Cart $cart)
    {   
        try{
            
            return view('panel.carts.edit',compact('cart'));
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
    public function update(Request $request,Cart $cart)
    {
        
        $this->validate($request, [
                        'user_id'     => 'required',
                        'user_shop_id'     => 'required',
                        'product_id'     => 'required',
                        'user_shop_item_id'     => 'required',
                        'qty'     => 'required',
                        'price'     => 'required',
                        'total'     => 'required',
                    ]);
                
        try{
                               
            if($cart){
                           
                $chk = $cart->update($request->all());

                return redirect()->route('panel.carts.index')->with('success','Record Updated!');
            }
            return back()->with('error','Cart not found')->withInput($request->all());
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
    public function destroy(Cart $cart)
    {
        try{
            if($cart){
                                              
                $cart->delete();
                return back()->with('success','Cart deleted successfully');
            }else{
                return back()->with('error','Cart not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
