<?php
/**
 * Class PriceAskRequestController
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link        https://121.page/
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceAskRequest;

class PriceAskRequestController extends Controller
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

            $price_ask_requests = PriceAskRequest::query();

            $price_ask_requests = $price_ask_requests->limit($limit)->offset(($page - 1) * $limit)->get();

            return $this->success($price_ask_requests);
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try{
                
            $this->validate($request, [
                                'workstream_id'     => 'required',
                                'sender_id'     => 'required',
                                'receiver_id'     => 'required',
                                'price'     => 'required',
                                'qty'     => 'required',
                                'total'     => 'sometimes',
                                'comment'     => 'sometimes',
                                'till_date'     => 'sometimes',
                                'details'     => 'sometimes',
                                'status'     => 'required',
                            ]);
                              
            $price_ask_request = PriceAskRequest::create($request->all());

            if($price_ask_request){
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
    * @param  PriceAskRequest $price_ask_request
    * @return  \Illuminate\Http\JsonResponse
    */
    public function show(PriceAskRequest $price_ask_request)
    {
        try{
            return $this->success($price_ask_request);
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
     public function update(Request $request, PriceAskRequest $price_ask_request)
    {
        try{
                
            $this->validate($request, [
                                'workstream_id'     => 'required',
                                'sender_id'     => 'required',
                                'receiver_id'     => 'required',
                                'price'     => 'required',
                                'qty'     => 'required',
                                'total'     => 'sometimes',
                                'comment'     => 'sometimes',
                                'till_date'     => 'sometimes',
                                'details'     => 'sometimes',
                                'status'     => 'required',
                            ]);
        
                      
            $price_ask_request = $price_ask_request->update($request->all());

            return $this->success($price_ask_request, 201);
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
            $price_ask_request = PriceAskRequest::findOrFail($id);
                                             
             $price_ask_request->delete();
 
             return $this->successMessage("PriceAskRequest deleted successfully!");
         } catch(\Exception $e){
             return $this->error("Error: " . $e->getMessage());
         }
     }
    
}
