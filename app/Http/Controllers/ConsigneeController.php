<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consignee;
use App\Models\Quotation;



class ConsigneeController extends Controller
{
    public function store(Request $request){

        // magicstring(request()->all());
        // return;
        try {
            $decrypt_quote_id = decrypt($request->get("quote_id"));
            $QuotationItemRecord = Quotation::whereId($decrypt_quote_id)->first();

            $chkConsignee = Consignee::where('quote_id',$QuotationItemRecord->id)->get();
            foreach ($chkConsignee as $key => $chkConsignee) {
                $jsoncheck = json_decode($chkConsignee->consignee_details);
                magicstring($jsoncheck);

                if ($jsoncheck->ref_id == $request->get('consignee')['ref_id']) {
                    return redirect()->back()->with('error', 'Consignee ID Already Exist');
                }
            }

            $consignee_person = [];
            foreach ($request->get('consignee_person_name') as $key => $consignee_person_name) {
                $consignee_person[$key] = [
                    'person_name' => $consignee_person_name,
                    'person_email' => $request->get('consignee_person_email')[$key] ?? Null,
                    'person_phone' => $request->get('consignee_person_contact')[$key] ?? Null,
                ];
            }

            $record = [
                'quote_id' => $decrypt_quote_id,
                'person_info' => json_encode($consignee_person),
                'consignee_details' => json_encode($request->get('consignee')),
                'user_id' => auth()->user()->id,
                'misc_details' => Null
            ];

            $ConsigneeRec = Consignee::create($record);


            if ($QuotationItemRecord->consignee_details != null) {
                $exist = json_decode($QuotationItemRecord->consignee_details);
                array_push($exist, $ConsigneeRec->id);
            }else{
                $exist =  [$ConsigneeRec->id];
            }

            $QuotationItemRecord->update([
                'consignee_details' => json_encode($exist)
            ]);

            return redirect()->back()->with('success', 'Consignee Added Successfully');

        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }
}
