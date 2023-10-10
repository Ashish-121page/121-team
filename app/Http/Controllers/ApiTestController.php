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
   
    private $resultLimit;

    public function __construct(){
        $this->resultLimit = 10;
    }


    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;

            $tests = Test::query();

            $tests = $tests->limit($limit)->offset(($page - 1) * $limit)->get();

            return $this->success($tests);
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try{
                        
            if($request->hasFile("test_file")){
                $request['test'] = $this->uploadFile($request->file("test_file"), "tests")->getFilePath();
            } else {
                return $this->error("Please upload an file for test");
            }

                
            $test = Test::create($request->all());

            if($test){
                return $this->success($article, 201);
            }else{
                return $this->error("Error: Record not Created!");
            }

        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }


    /**
    * Return single instance of the requested resource
    *
    * @param  Test $test
    * @return  \Illuminate\Http\JsonResponse
    */
    public function show(Test $test)
    {
        try{
            return $this->success($test);
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }
   

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
     public function update(Request $request, Test $test)
    {
        try{
            
            
            if($request->hasFile("test_file")){
                $request['test'] = $this->uploadFile($request->file("test_file"), "tests")->getFilePath();
                $this->deleteStorageFile($test->test);
            } else {
                $request['test'] = $test->test;
            }
                
            $test = $test->update($request->all());

            return $this->success($test, 201);
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */    
     public function destroy($id)
     {
         try{
            $test = Test::findOrFail($id);
             
                 $this->deleteStorageFile($test->test);
                                 
             $test->delete();
 
             return $this->successMessage("Test deleted successfully!");
         } catch(\Exception $e){
             return $this->error("Error: " . $e->getMessage());
         }
     }
    
}
