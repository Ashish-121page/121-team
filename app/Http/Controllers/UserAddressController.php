<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Session;



class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $this->validate($request, [
            'user_id' => 'required',
            'type' => 'required',
        ]);

        try {
            // magicstring(request()->all());
            // return;

                $data = new UserAddress();
                $data->user_id = auth()->id();
                $data->is_primary = $request->is_primary ?? 0;
                $data->type = $request->type;
                $arr = [
                    'address_1' => $request->address_1,
                    'address_2' => $request->address_2,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                    'gst_number' => $request->gst_number,
                    'iec_number' => $request->iec_number ?? '',
                    'entity_name' => $request->entity_name,
                    'acronym' => $request->acronym ?? ''
                ];

                $acc_deatils = [];
                foreach ($request->bank_name as $key => $bank) {
                    $tmp_acc_deatils= [
                        'bank_name' => $bank ?? '',
                        'bank_address' => $request->bank_address[$key] ?? '',
                        'swift_code' => $request->swift_code[$key] ?? '',
                        'account_number' => $request->account_number[$key] ?? '',
                        'account_holder_name' => $request->account_holder_name[$key] ?? '',
                        'account_type' => $request->account_type[$key] ?? '',
                        'ifsc_code/neft' => $request->ifsc_code[$key] ?? '',
                        'default' => $request->default[$key] ?? 0,
                    ];
                    array_push($acc_deatils, $tmp_acc_deatils);
                }

                $data->account_details = json_encode($acc_deatils);
                $data->details = json_encode($arr);
                $data->save();
                return back()->with('success', 'Address added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
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
    public function update(Request $request)
    {
        $address = UserAddress::whereId($request->id)->first();
        try {
            $arr = [
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'gst_number' => $request->gst_number,
                'entity_name' => $request->entity_name
            ];
            $details = json_encode($arr);
            $address->update([
                'type' => $request->type,
                'details'=> $details
            ]);
            // return $request->all();
                return back()->with('success', 'updated address successfully!');
            } catch (\Exception $e) {
                return back()->with('error', 'Error: ' . $e->getMessage());
            }
    }



    public function EntityGet(Request $request){


        if ($request->work == 'getEntityDetails') {
            $address = UserAddress::whereId($request->id)->first();
            $account_details = json_decode($address->account_details);

            return response()->json([
                'address' => $address,
                'account_details' => $account_details,
                'status' => 'success'
            ]);
        }


        magicstring(request()->all());
        return;

    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_address = UserAddress::find($id);
        if($user_address){
            $user_address->delete();
             return back()->with('success', 'Address deleted successfully!');
        }else{
            return back()->with('error', 'Record not found!');
        }
    }
}
