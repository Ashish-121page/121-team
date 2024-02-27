<?php

namespace App\Http\Controllers;
use App\Models\AccessCatalogueRequest as ACR;
use App\User;
use Illuminate\Http\Request;

class AccessCatalogueRequest extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function accessCatalogueReq(Request $request)
    {
       $accCatRequests = ACR::query();
       $user_numbers = User::get()->pluck('phone');
       if($request->has('user_type') && $request->user_type == 0){
            $accCatRequests->whereNotIn('number',$user_numbers);
        }else{
           $accCatRequests->whereIn('number',$user_numbers);
       }
       $accCatRequests = $accCatRequests->paginate(10);
        return view('backend.admin.access-requests.index',compact('accCatRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function deleteacr(Request $request ,$ACR_id)
     {
        //Delete Access Catalogue Request;

        $user_id = auth()->user()->id;
        $catalouge_request = ACR::whereId($ACR_id)->first();

        try {
            if ($request->check == 0) {
                if ($user_id == $catalouge_request->user_id) {
                    $catalouge_request->delete();
                    echo "Catalogue Request Deleted!!";
                    return back()->with('success','Catalogue Request Deleted Successfully');
                }else{
                    return back()->with('error','Catalogue Request not found');
                }
            }else{
                return back()->with('error','You already Linked Product With This Supplier, Delete Product First');
            }
        } catch(\Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
     }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            if($id){
                $catalouge_request = ACR::whereId($id)->first();
                $catalouge_request->delete();
                return back()->with('success','Request Cancelled successfully');
            }else{
                return back()->with('error','Request not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
