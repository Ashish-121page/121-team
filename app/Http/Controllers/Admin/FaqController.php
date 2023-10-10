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

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path =   storage_path() . "/app/public/backend/constant-management/faqs/";
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $faqs = fetchAll('App\Models\Faq');
            return view('backend/constant-management.faqs.index',compact('faqs'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
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
            return view('backend/constant-management.faqs.create');
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
                                'title'     => 'required',
                                'description'     => 'required',
                            ]);
        
        try{
                                                                                                
            $faq = Faq::create($request->all());
            return redirect()->route('backend/constant-management.faqs.index')->with('success','Record Created!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        try{
            return view('backend/constant-management.faqs.show',compact('faq'));
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
    public function edit(Faq $faq)
    {   
        try{
            
            return view('backend/constant-management.faqs.edit',compact('faq'));
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
    public function update(Request $request,Faq $faq)
    {
         
                    // $this->validate($request, [
                    //             'title'     => 'requried',
                    //             'description'     => 'required',
                    //         ]);
                
        try{
            
            
            if($faq){
                if(!$request->has('is_publish')){
                    $request['is_publish'] = 0;
                }                                                                                                      
                $chk = $faq->update($request->all());

                return redirect()->route('backend/constant-management.faqs.index')->with('success','Record Updated!');
            }
            return back()->with('error','Faq not found');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        try{

            
            if($faq){
              
                    $faq->delete();
                    return back()->with('success', 'Record Deleted!');
            }
            return back()->with('error','Faq not found');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
