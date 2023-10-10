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

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path =   storage_path() . "/app/public/uploads/tests/";
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $tests = fetchAll('App\Models\Test');
            return view('manage.tests.index',compact('tests'));
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
            return view('manage.tests.create');
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
        
        try{
                         
            if(!$request->has('check')){
                $request['check'] = 0;
            }
                        
            if(!$request->has('status')){
                $request['status'] = 0;
            }
             
            
            if($request->hasFile("test_file")){
                $request['test'] = $this->uploadFile($request->file("test_file"), "tests")->getFilePath();
            } else {
                return $this->error("Please upload an file for test");
            }
                
            $test = Test::create($request->all());
            return redirect()->route('panel.tests.index')->with('success','Test Created Successfully!');
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
    public function show(Test $test)
    {
        try{
            return view('manage.tests.show',compact('test'));
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
    public function edit(Test $test)
    {   
        try{
            
            return view('manage.tests.edit',compact('test'));
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
    public function update(Request $request,Test $test)
    {
                
        try{
                         
            if(!$request->has('check')){
                $request['check'] = 0;
            }
                        
            if(!$request->has('status')){
                $request['status'] = 0;
            }
                         
            if($test){
                
                if($request->hasFile("test_file")){
                    $request['test'] = $this->uploadFile($request->file("test_file"), "tests")->getFilePath();
                    $this->deleteStorageFile($test->test);
                } else {
                    $request['test'] = $test->test;
                }
                        
                $chk = $test->update($request->all());

                return redirect()->route('panel.tests.index')->with('success','Record Updated!');
            }
            return back()->with('error','Test not found');
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
    public function destroy(Test $test)
    {
        try{
             
            $this->deleteStorageFile($test->test);
                               
            $test->delete();
            return back()->with('error','Test not found');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
