<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\SiteContentManagement;

class SiteContentManagementController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path =   storage_path() . "/app/public/backend/site_content_managements/";
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return 's';
        try{
            $site_content_managements = fetchAll('App\Models\SiteContentManagement');
            return view('backend.site_content_managements.index',compact('site_content_managements'));
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
            return view('backend.site_content_managements.create');
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
                                'code'     => 'required',
                            ]);
        
        try{
                                                                                                
            $site_content_management = SiteContentManagement::create($request->all());
            return redirect()->route('backend.site_content_managements.index')->with('success','Record Created!');
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
    public function show(SiteContentManagement $site_content_management)
    {
        try{
            return view('backend.site_content_managements.show',compact('site_content_management'));
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
    public function edit(SiteContentManagement $site_content_management)
    {   
        try{
            
            return view('backend.site_content_managements.edit',compact('site_content_management'));
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
    public function update(Request $request,SiteContentManagement $site_content_management)
    {
                    $this->validate($request, [
                                'code'     => 'required',
                            ]);
                
        try{
            
            
            if($site_content_management){
                                                                                                                                
                $chk = $site_content_management->update($request->all());

                return redirect()->route('backend.site_content_managements.index')->with('success','Record Updated!');
            }
            return back()->with('error','SiteContentManagement not found');
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
    public function destroy(SiteContentManagement $site_content_management)
    {
        try{

            
            if($site_content_management){
                                     
                    $site_content_management->delete();
                    return back()->with('success', 'Record Deleted!');
                                                         
                    $site_content_management->delete();
                    return back()->with('success', 'Record Deleted!');
                                                         
                    $site_content_management->delete();
                    return back()->with('success', 'Record Deleted!');
                                                }
            return back()->with('error','SiteContentManagement not found');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
