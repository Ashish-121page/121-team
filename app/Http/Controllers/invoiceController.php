<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserAddressController;
use Illuminate\Http\Request;
use App\User;
use App\Models\Product;
use App\Models\Consignee;
use App\Models\UserShop;
use App\Models\Media;
use App\Models\Brand;
use App\Models\AccessCatalogueRequest;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\UserCurrency;
use App\Models\BuyerList;
use App\Models\Country;
use App\Models\QuoteFiles;
use App\Models\UserAddress;
use App\Models\Proposal;
use App\Models\ProposalItem;
use App\Models\ProductExtraInfo;
use Illuminate\Support\Facades\Http;

use function PHPSTORM_META\map;

class invoiceController extends Controller
{

    public function index() {
        return view('panel.Documents.index');
    }

    public function secondview() {
        return view('panel.Documents.secondview');
    }

    public function thirdview() {


        $user_id = auth()->id();
        $user = auth()->user();
        $user_shop = getShopDataByUserId($user->id);

        $user_shop = UserShop::whereUserId($user_id)->first();


        $length = request()->get('pagelength',19);
        $scoped_products = Product::whereUserId($user_id)->paginate($length);

        $supplier = User::whereId(auth()->id())->first();

        $access_data = AccessCatalogueRequest::whereUserId(auth()->id())->whereNumber($supplier->phone)->whereStatus(1)->first();

        $pinned_items = [];
        // foreach($scoped_products as $scoped_product){
        //     $scoped_product->update(['is_publish' => 1]);
        // }

        return view('panel.Documents.thirdview', compact('user_id','user','user_shop','scoped_products','access_data','pinned_items'));
    }

    public function fourthview() {
        return view('panel.Documents.fourthview');
    }

    // ` Quoation Work Start
    public function Quotation() {
        if (request()->has('sort') && request()->get('sort') != '') {
            switch (request()->get('sort')) {
                case '1':
                    $Quotation = Quotation::select('*')->where('user_id',auth()->id())->where('type_of_quote',0)
                    ->orderBy('id','DESC')
                    ->get()
                    ->groupBy(function ($item) {
                        return data_get(json_decode($item->customer_info, true), 'companyName');
                    })
                    ->map(function ($groupedResults) {
                        $resultIds = $groupedResults->pluck('id')->implode(',');
                        $fieldCount = $groupedResults->count();

                        $firstItem = $groupedResults->first();
                        $firstItem['record_ids'] = $resultIds;
                        $firstItem['record_count'] = $fieldCount;
                        return $firstItem;
                    });
                    break;
                case '2':
                    $Quotation = Quotation::select('*')->where('user_id',auth()->id())->where('type_of_quote',0)
                    ->orderByRaw('JSON_UNQUOTE(JSON_EXTRACT(customer_info,"$.companyName"))','DESC')
                    ->get()
                    ->groupBy(function ($item) {
                        return data_get(json_decode($item->customer_info, true), 'companyName');
                    })
                    ->map(function ($groupedResults) {
                        $resultIds = $groupedResults->pluck('id')->implode(',');
                        $fieldCount = $groupedResults->count();

                        $firstItem = $groupedResults->first();
                        $firstItem['record_ids'] = $resultIds;
                        $firstItem['record_count'] = $fieldCount;
                        return $firstItem;
                    });
                    break;
                case '3':
                    // $avl_pi = Quotation::where('type_of_quote',1)->where('user_id',auth()->id())->orderBy('id','DESC')->pluck('id')->toArray();
                    $avl_pi = Quotation::where('type_of_quote', 1)
                        ->where('user_id', auth()->id())
                        ->orderBy('id', 'ASC')
                        ->get()
                        ->groupBy(function ($item) {
                            return data_get(json_decode($item->customer_info, true), 'companyName');
                        })
                        ->map(function ($groupedResults) {
                            $resultIds = $groupedResults->pluck('id')->implode(',');
                            $fieldCount = $groupedResults->count();

                            $firstItem = $groupedResults->first();
                            $firstItem['record_ids'] = $resultIds;
                            $firstItem['record_count'] = $fieldCount;
                            return $firstItem;
                        })->pluck('linked_quote')->toArray();


                    $Quotation_with = Quotation::select('*')->where('user_id',auth()->id())->wherein('id',$avl_pi)
                        ->orderByRaw('JSON_UNQUOTE(JSON_EXTRACT(customer_info,"$.companyName"))','DESC')
                        ->get()
                        ->groupBy(function ($item) {
                            return data_get(json_decode($item->customer_info, true), 'companyName');
                        })
                        ->map(function ($groupedResults) {
                            $resultIds = $groupedResults->pluck('id')->implode(',');
                            $fieldCount = $groupedResults->count();

                            $firstItem = $groupedResults->first();
                            $firstItem['record_ids'] = $resultIds;
                            $firstItem['record_count'] = $fieldCount;
                            return $firstItem;
                        });

                    $Quotation_without = Quotation::select('*')->where('user_id',auth()->id())
                        ->orderByRaw('JSON_UNQUOTE(JSON_EXTRACT(customer_info,"$.companyName"))','DESC')
                        ->get()
                        ->groupBy(function ($item) {
                            return data_get(json_decode($item->customer_info, true), 'companyName');
                        })
                        ->map(function ($groupedResults) {
                            $resultIds = $groupedResults->pluck('id')->implode(',');
                            $fieldCount = $groupedResults->count();

                            $firstItem = $groupedResults->first();
                            $firstItem['record_ids'] = $resultIds;
                            $firstItem['record_count'] = $fieldCount;
                            return $firstItem;
                        });

                        $Quotation = $Quotation_with->merge($Quotation_without);

                    break;

                default:
                    $Quotation = Quotation::where('user_id',auth()->id())->where('type_of_quote',0)->orderBy('id','DESC')->get();
                    break;
            }

        }else{
            $Quotation = Quotation::select('*')->where('user_id',auth()->id())->where('type_of_quote',0)
            ->orderBy('id','DESC')
            ->get()
            ->groupBy(function ($item) {
                return data_get(json_decode($item->customer_info, true), 'companyName');
            })
            ->map(function ($groupedResults) {
                $resultIds = $groupedResults->pluck('id')->implode(',');
                $fieldCount = $groupedResults->count();

                $firstItem = $groupedResults->first();
                $firstItem['record_ids'] = $resultIds;
                $firstItem['record_count'] = $fieldCount;
                return $firstItem;
            });
        }


        if (request()->has('sort') && request()->get('sort') != '' && request()->get('access') == 'pi-data') {

            switch (request()->get('sort')) {
                case '1':
                    $pirecords = Quotation::where('user_id',auth()->id())->where('type_of_quote',1)
                    ->orderBy('id','DESC')
                    ->get()
                    ->groupBy(function ($item) {
                        return data_get(json_decode($item->customer_info, true), 'companyName');
                    })
                    ->map(function ($groupedResults) {
                        $resultIds = $groupedResults->pluck('id')->implode(',');
                        $fieldCount = $groupedResults->count();

                        $firstItem = $groupedResults->first();
                        $firstItem['record_ids'] = $resultIds;
                        $firstItem['record_count'] = $fieldCount;
                        return $firstItem;
                    });
                    break;

                case '2':

                    $pirecords = Quotation::select('*')->where('user_id',auth()->id())->where('type_of_quote',1)
                    ->orderByRaw('JSON_UNQUOTE(JSON_EXTRACT(customer_info,"$.companyName"))','DESC')
                    ->get()
                    ->groupBy(function ($item) {
                        return data_get(json_decode($item->customer_info, true), 'companyName');
                    })
                    ->map(function ($groupedResults) {
                        $resultIds = $groupedResults->pluck('id')->implode(',');
                        $fieldCount = $groupedResults->count();

                        $firstItem = $groupedResults->first();
                        $firstItem['record_ids'] = $resultIds;
                        $firstItem['record_count'] = $fieldCount;
                        return $firstItem;
                    });
                    break;
                default:
                    $pirecords = Quotation::where('user_id',auth()->id())->where('type_of_quote',1)
                    ->orderBy('id','DESC')
                    ->get()
                    ->groupBy(function ($item) {
                        return data_get(json_decode($item->customer_info, true), 'companyName');
                    })
                    ->map(function ($groupedResults) {
                        $resultIds = $groupedResults->pluck('id')->implode(',');
                        $fieldCount = $groupedResults->count();

                        $firstItem = $groupedResults->first();
                        $firstItem['record_ids'] = $resultIds;
                        $firstItem['record_count'] = $fieldCount;
                        return $firstItem;
                    });
                    break;
            }

            // return;
        }else{
            $pirecords = Quotation::where('user_id',auth()->id())->where('type_of_quote',1)
            ->orderBy('id','DESC')
            ->get()
            ->groupBy(function ($item) {
                return data_get(json_decode($item->customer_info, true), 'companyName');
            })
            ->map(function ($groupedResults) {
                $resultIds = $groupedResults->pluck('id')->implode(',');
                $fieldCount = $groupedResults->count();

                $firstItem = $groupedResults->first();
                $firstItem['record_ids'] = $resultIds;
                $firstItem['record_count'] = $fieldCount;
                return $firstItem;
            });
        }


        $buyerDetails = $Quotation->pluck('customer_info')->toArray();
        return view('panel.Documents.Quotation',compact('Quotation','pirecords','buyerDetails'));
    }





    public function createQuotationform() {
        $user = auth()->user();

        $entities =  UserAddress::where('user_id',$user->id)->get();
        $userShop = UserShop::whereUserId($user->id)->first();
        $userset = json_decode($user->settings);
        if (isset($userset->quotaion_mark)) {
            $quotation_number = checkQuoteSlug($userset->quotaion_mark,$userset->quotaion_index,$user->id) ?? 'Quotation';
        }else{
            $quotation_number = getUniqueProposalSlug('Quotation');
        }


        $currency = UserCurrency::where('user_id',$user->id)->get();
        $terms_of_delivery = json_decode(getSetting('terms_of_delivery'));
        $countries = Country::get();
        $offer_data = request()->session()->get('offer_data');


        if (request()->has('action') && request()->get('action') == 'edit') {
            $quotationRecord = Quotation::whereId(request()->get('typeId'))->first();
            $additional_notes = json_decode($quotationRecord->additional_notes);
            $customer_record = json_decode($quotationRecord->customer_info) ?? null;
            $entity_details  = BuyerList::whereId($customer_record->Buyer_Id)->first();
            $bank_details = json_decode(json_decode($entity_details->bank_details));
            $consignee_record = json_decode($quotationRecord->consignee_details) ?? [];
            $consignee_details = Consignee::whereIn('id',$consignee_record)->get() ?? [];

        }else{
            $quotationRecord = null;
            $additional_notes = null;
            $entity_details = null;
            $bank_details = [];
            $consignee_details = [];
        }


        return view('panel.Documents.create-quotation',compact('entities','userShop','quotation_number','currency','terms_of_delivery','countries','offer_data','quotationRecord','additional_notes','entity_details','bank_details','consignee_details'));
    }

    function checkslug() {
        $user = auth()->user();
        $chk = Quotation::where('user_slug',request()->get('slug'))->where('user_id',$user->id)->get()->count();
        $checkConsignee = Consignee::where('user_id', $user->id)->get();

        foreach ($checkConsignee as $key => $value) {
            $jsoncheck = json_decode($value->consignee_details);
            if (isset($jsoncheck->p_id) && $jsoncheck->p_id == request()->get('slug')) {
                $chk = $chk + 1;
            }
        }

        if ($chk > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Duplicate number not permitted',
                'class' => 'text-danger',
            ]);
        }else{
            return response()->json([
                'status' => 'success',
                'message' => 'Available',
                'class' => 'text-success',
            ]);
        }
    }

    public function createQuotation(Request $request) {
        try {

            // -- Sets for DataBase
            $buyer_detailsdb = [];
            $shipment_detailsdb = [];
            $contact_personsdb = [];
            $payment_detailsdb = [];
            $bank_detailsdb = [];
            $user_shop_id = UserShopIdByUserId(auth()->id());



            $quotation = request()->get('quotation');
            $internal_remarks = request()->get('internal_remarks');

            $entity_array = [
                'entity_details' => request()->get('entity_details'),
                'entity_bank' => request()->get('entity_bank'),
            ];

            $buyer_detailsdb = array_merge(['entity_details_id' => request()->get('entity_details')], request()->get('buyer'));

            $shipment_detailsdb = [
                'terms_of_delivery' => request()->get('quotation')['term_of_delivery'] ?? '',
                'port_of_loading' => request()->get('quotation')['port_of_loading'] ?? '',
                'port_of_discharge' => request()->get('quotation')['port_of_discharge'] ?? '',
                'payment_terms' => request()->get('quotation')['payment_term'] ?? '',
            ];

            foreach (request()->get('person_name') as $key => $value) {
                $contact_personsdb[$key] = [
                    'person_name' => request()->get('person_name')[$key],
                    'person_email' => request()->get('person_email')[$key],
                    'person_phone' => request()->get('person_contact')[$key],
                ];
            }


            $additional_details = array_merge($quotation,['internal_remarks' => $internal_remarks]);

            // Getting Bank Details
            $tmp_request = new Request();
            $tmp_request->merge([
                'work' => 'getEntityDetails',
                'id' => request()->get('entity_details')
            ]);
            $tmp_request->setMethod('GET');
            app()->instance('request', $tmp_request);
            $UserAddress = new UserAddressController();

            $bank_detailsdb = $UserAddress->EntityGet($tmp_request)->getData()->address->account_details ?? [];


            $chk_buyer = BuyerList::where('user_id',auth()->id())->where('buyer_details',json_encode($buyer_detailsdb))->get();
            if ($chk_buyer->count() == 0) {
                $buyer = new BuyerList();
                $buyer->user_id = auth()->id();
                $buyer->user_shop_id = $user_shop_id ?? 0;
                $buyer->type = 0;
                $buyer->buyer_details = json_encode($buyer_detailsdb);
                $buyer->shipment_details = json_encode($shipment_detailsdb);
                $buyer->contact_persons = json_encode($contact_personsdb);
                $buyer->payment_details = json_encode($payment_detailsdb);
                $buyer->bank_details = json_encode($bank_detailsdb);
                $buyer->save();
            }else{
                $buyer = $chk_buyer->first();
            }
            $Buyer_obj = array_merge([
                'CreatedOn' => date('m/d/Y, h:i:s A'),
                'Buyer_Id' => $buyer->id,
                'companyName' => $buyer_detailsdb['entity_name'] ?? '',
            ], $contact_personsdb[0]);

            $proposal_id = '';
            if ($request->proposal_id != '' && $request->proposal_id != null) {
                echo "Proposal Id isn't Blank!!";
                $proposal_id = $request->proposal_id;
            }



            // Uploading Final Data
            $record = [
                'customer_info' => json_encode($Buyer_obj),
                'user_id' => auth()->id(),
                'user_shop_id' => $user_shop_id,
                'quotation_date' => $quotation['date'],
                'total_amount' => 0,
                'additional_notes' => json_encode($additional_details) ?? null,
                'exchange_rate' => $quotation['exchange'],
                'slug' => getUniqueProposalSlug($buyer_detailsdb['entity_name']),
                'user_slug' => $quotation['number'] ?? null,
                'proposal_id' => $proposal_id ?? '',
            ];

            $data = Quotation::create($record);
            $quote = $data;


            // ! Creating Quotation Items...
            if ($request->proposal_products != null && $request->proposal_products != []) {
                echo "<br>Proposal Products isn't Blank!!";
                foreach (explode(',',$request->proposal_products) as $key => $pid) {
                    $proposal_item = ProposalItem::where('product_id',$pid)->where('proposal_id',$proposal_id)->first();
                    // Create a request
                    $tmp_request = new Request();
                    $tmp_request->merge([
                        'work' => 'createQuotationItem',
                        'precord' => "$pid",
                        'quotation_id'=> $data->id,
                        'currency'=> $quotation['currency'] ?? 'INR',
                        'offer_price' => $proposal_item->user_price ?? $proposal_item->price ?? '',
                    ]);
                    // Call the createQuotationItem function
                    $response = $this->createQuotationItem($tmp_request);
                }
            }


            // ! Uploading Files...
            if ($request->hasFile('files')) {
                $files = $request->file('files');

                foreach ($files as $key => $file) {
                    $file_extension = $file->getClientOriginalExtension();
                    $og_file_name = $file->getClientOriginalName();
                    $tmp_filename = \Str::random(35).'.'.$file_extension;
                    $user_id = auth()->id();

                    $file_type = explode('/', $file->getMimeType())[0];

                    $folderPath = "public/files/$user_id/quote_files";
                    $uploaded_path = $file->storeAs($folderPath, $tmp_filename);

                    $uploaded_path = str_replace('public', 'storage', $uploaded_path);

                    $media = new Media();
                    $media->file_name = $og_file_name;
                    $media->path = $uploaded_path;
                    $media->extension = $file_extension;
                    $media->file_type = $file_type;
                    $media->tag = 'quote_files';
                    $media->type_id = $data->id;
                    $media->type = 'UserShop';
                    $media->save();
                }
            }


            if ($request->has('submitdraft')) {
                // return back()->with('success','Quotation Created Successfully');
                $typeid =  $data->id;
                $url = ENV('APP_URL')."/panel/Quotation/create?typeId=$typeid&action=edit";
                return redirect()->to($url)->with('success', 'Quotation Created Successfully');

            }else{
                $typeid =  $data->id;
                // return redirect(route('panel.Documents.thirdview',['typeId' => $quote->id]));
                $url = ENV('APP_URL')."/panel/Quotation/step-3?typeId=$typeid";
                return redirect()->to($url)->with('success', 'Quotation Created Successfully');
            }

        } catch (\Throwable $th) {
            throw $th;
            return back()->with('error','Error Occurred While Creating Quotation');
        }
    }

    function updateQuotation(Request $request, Quotation $quotation) {

        $quotationRecord = $quotation;

        try {

            // magicstring(request()->all());
            // return;
            // -- Sets for DataBase
            $buyer_detailsdb = [];
            $shipment_detailsdb = [];
            $contact_personsdb = [];
            $payment_detailsdb = [];
            $bank_detailsdb = [];
            $user_shop_id = UserShopIdByUserId(auth()->id());

            $quotation = request()->get('quotation');
            $internal_remarks = request()->get('internal_remarks');
            $additional_details = array_merge($quotation,['internal_remarks' => $internal_remarks]);

            $entity_array = [
                'entity_details' => request()->get('entity_details'),
                'entity_bank' => request()->get('entity_bank'),
            ];

            $buyer_detailsdb = array_merge(['entity_details_id' => request()->get('entity_details')], request()->get('buyer'));


            $shipment_detailsdb = [
                'terms_of_delivery' => request()->get('quotation')['term_of_delivery'] ?? '',
                'port_of_loading' => request()->get('quotation')['port_of_loading'] ?? '',
                'port_of_discharge' => request()->get('quotation')['port_of_discharge'] ?? '',
                'payment_terms' => request()->get('quotation')['payment_term'] ?? '',
            ];

            foreach (request()->get('person_name') as $key => $value) {
                $contact_personsdb[$key] = [
                    'person_name' => request()->get('person_name')[$key],
                    'person_email' => request()->get('person_email')[$key],
                    'person_phone' => request()->get('person_contact')[$key],
                ];
            }


            // Getting Bank Details
            $tmp_request = new Request();
            $tmp_request->merge([
                'work' => 'getEntityDetails',
                'id' => request()->get('entity_details')
            ]);
            $tmp_request->setMethod('GET');
            app()->instance('request', $tmp_request);
            $UserAddress = new UserAddressController();
            $bank_detailsdb = $UserAddress->EntityGet($tmp_request)->getData()->address->account_details ?? [];
            // Uploading Final Data

            $record = [
                // 'customer_info' => json_encode($Buyer_obj),
                'user_id' => auth()->id(),
                'user_shop_id' => $user_shop_id,
                'quotation_date' => $quotation['date'],
                'total_amount' => 0,
                'additional_notes' => json_encode($additional_details) ?? null,
                'exchange_rate' => $quotation['exchange'],
            ];

            $quotationRecord->additional_notes = json_encode($additional_details);
            $quotationRecord->exchange_rate = $quotation['exchange'];
            $quotationRecord->status = 0;
            $quotationRecord->save();

                // ! Uploading Files...
                if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $key => $file) {
                    $file_extension = $file->getClientOriginalExtension();
                    $og_file_name = $file->getClientOriginalName();
                    $tmp_filename = \Str::random(35).'.'.$file_extension;
                    $user_id = auth()->id();
                    $file_type = explode('/', $file->getMimeType())[0];
                    $folderPath = "public/files/$user_id/quote_files";
                    $uploaded_path = $file->storeAs($folderPath, $tmp_filename);
                    $uploaded_path = str_replace('public', 'storage', $uploaded_path);
                    $media = new Media();
                    $media->file_name = $og_file_name;
                    $media->path = $uploaded_path;
                    $media->extension = $file_extension;
                    $media->file_type = $file_type;
                    $media->tag = 'quote_files';
                    $media->type_id = $quotationRecord->id;
                    $media->type = 'UserShop';
                    $media->save();
                }
            }
            if ($request->has('submitdraft')) {
                // return back()->with('success','Quotation Updated Successfully');
                      // return back()->with('success','Quotation Created Successfully');
                      $typeid =  $quotationRecord->id;
                      $url = ENV('APP_URL')."/panel/Quotation/create?typeId=$typeid&action=edit";
                      return redirect()->to($url)->with('success', 'Quotation Created Successfully');
            }else{
                $typeid =  $quotationRecord->id;
                $flow = encrypt('pick_product');
                $url = ENV('APP_URL')."/panel/Quotation/step-3?typeId=$typeid";
                return redirect()->to($url)->with('success', 'Quotation Updated Successfully');
            }

        } catch (\Throwable $th) {
            // return back()->with('error','Error Occurred While Updating Quotation');
            throw $th;
        }


    }

    public function quotation2() {
        if ( request()->has('typeId') && request()->get('typeId') != '') {
            $record = Quotation::whereId(request()->get('typeId'))->first();

            $json_customer_info = json_decode($record->customer_info) ?? '';
            $customer_record = json_decode($record->customer_info) ?? null;

            if (isset($customer_record->Buyer_Id)) {
                $entity_details  = BuyerList::whereId($customer_record->Buyer_Id)->first() ?? null;
                $bank_details = json_decode(json_decode($entity_details->bank_details)) ?? [];
            }else{
                $entity_details = null;
                $bank_details = [];
            }



            $QuotationItem = QuotationItem::where('quotation_id', $record->id)->get();

            // Filtering Simlar Results
            $Quotation = Quotation::select('*')->where('user_id',auth()->id())->where('type_of_quote',$record->type_of_quote)
            ->get()
            ->groupBy(function ($item) {
                return data_get(json_decode($item->customer_info, true), 'companyName');
            })
            ->map(function ($groupedResults) {
                $resultIds = $groupedResults->pluck('id')->implode(',');
                $fieldCount = $groupedResults->count();

                $firstItem = $groupedResults->first();
                $firstItem['record_ids'] = $resultIds;
                $firstItem['record_count'] = $fieldCount;
                $firstItem['similar_records'] = $resultIds;
                return $firstItem;
            });

            $similar_records_ids = array_filter($Quotation->toArray(), function ($value) {
                return $value['id'] == request()->get('typeId');
            });

            if ($similar_records_ids != null && $similar_records_ids != []) {
                $similar_records_ids = explode(",", array_values($similar_records_ids)[0]['similar_records']) ?? [];
            }else{
                $similar_records_ids = [$record->id];
            }


            if (request()->has('sort') && request()->get('sort') != '') {
                switch (request()->get('sort')) {
                    case '1':
                        $similar_records = Quotation::whereIn('id',$similar_records_ids)->orderBy('id','DESC')->get();
                        break;
                    case '2':
                        $similar_records = Quotation::whereIn('id',$similar_records_ids)
                        ->orderByRaw('JSON_UNQUOTE(JSON_EXTRACT(customer_info,"$.person_name"))','DESC')
                        ->get();
                        break;
                    case '3':
                        $avl_pi = Quotation::where('type_of_quote',1)->where('user_id',$record->user_id)->orderBy('id','DESC')->pluck('id')->toArray();
                        $similar_records = Quotation::whereIn('id',$similar_records_ids)
                        ->orderByRaw('FIELD(id,'.implode(',',$avl_pi).') DESC')
                        ->get();
                        break;

                    default:
                        $similar_records = Quotation::whereIn('id',$similar_records_ids)->orderBy('id','DESC')->get();
                        break;
                }
            }else{
                $similar_records = Quotation::whereIn('id',$similar_records_ids)->orderBy('id','DESC')->get();
            }
            $quote_flles = QuoteFiles::whereIn('quote_id',$similar_records_ids)->get();


        }else{
            return back()->with('Error occurred while retrieving the record. Please try again later.');
        }

        return view('panel.Documents.quotation2',compact('record','quote_flles','json_customer_info','entity_details','bank_details','QuotationItem','similar_records'));
    }

    public function createQuotationitem(Request $request) {

        try {

            $product = Product::whereId($request->get('precord'))->first();

            if ($request->has('offer_price') && $request->get('offer_price') != '') {
                $price = $request->get('offer_price');
            }else{
                $price = $product->price;
            }


            $varients = getAllPropertiesofProductById($product->id)->pluck('attribute_value_id','attribute_id');
            if ($varients != null && $varients != []) {
                $varients_arr = [];
                foreach ($varients as $varient_parent => $varient) {
                    array_push($varients_arr,getAttruibuteValueById($varient)->attribute_value ?? null);
                }
            }

            $currency = $request->get('currency','INR');
            $quotation_id = $request->get('quotation_id');

            $chk = QuotationItem::where('product_id',$product->id)->where('quotation_id',$quotation_id)->get();


            if ($chk->count() == 0) {
                $quotationItem = new QuotationItem();
                $quotationItem->quotation_id = $quotation_id;
                $quotationItem->product_id = $product->id;
                $quotationItem->variation_id = NULL;
                $quotationItem->currency = $currency ?? 'INR';
                $quotationItem->product_name = $product->title ?? 'Not Available';
                $quotationItem->quantity = 0;
                $quotationItem->additional_notes = null;
                $quotationItem->unit = 0;
                $quotationItem->Price = $price ?? 150;
                $quotationItem->selling_price = $product->price;
                $quotationItem->save();

                return response()->json([
                    'status' => 'success',
                    'record_id' => $quotationItem->id,
                    'message' => 'Quotation Item Added Successfully',
                ]);
            }else{
                foreach ($chk as $item) {
                    $item->delete();
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Quotation Item Removed Successfully',
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Raise Support Ticket ',
            ]);
            throw $th;
        }

    }

    public function quotation3()
    {

        $user = auth()->user();
        $pagelength = request()->get('pagelength', 24);
        $quotation_id = request()->get('typeId');

        $products = Product::query()
            ->where('user_id', $user->id);

        $QuotationRecord = Quotation::whereId($quotation_id)->first();

        if (request()->has('searchProduct') && request()->get('searchProduct') != '') {
            $query = request()->get('searchProduct');
            $products->where(function ($innerQuery) use ($query) {
                $innerQuery->where('model_code', 'LIKE', '%' . $query . '%')
                    ->orWhere('title', 'LIKE', '%' . $query . '%')
                    ->orWhere('sku', 'LIKE', '%' . $query . '%');
            });
            $products = $products->paginate($pagelength);
            $QuotationItem = QuotationItem::where('quotation_id', $quotation_id)
                ->whereIn('product_id', $products->pluck('id'))
                ->pluck('product_id')
                ->toArray();

            return view('panel.Documents.pages.products', compact('products', 'QuotationItem'));
        }



        // checking Quote Item Exist or Not
        $QuotationItem = QuotationItem::where('quotation_id', $quotation_id)->get();
        if ($QuotationItem->count() != 0) {
            $showAll = true;
            request()->merge(['show_all'=> 'true']);
        }else{
            $showAll = false;
        }

        if (request()->has('show_all') && request()->get('show_all') == 'true' || $QuotationRecord->proposal_id == '') {
            $products = $products->paginate($pagelength);
            $QuotationItem = QuotationItem::where('quotation_id', $quotation_id)
                ->whereIn('product_id', $products->pluck('id'))
                ->pluck('product_id')
                ->toArray();

        }else{
            $QuotationItem = QuotationItem::where('quotation_id', $quotation_id)
            ->pluck('product_id')
            ->toArray();
            $products = $products->whereIn('id',$QuotationItem)->paginate($pagelength);
        }

        return view('panel.Documents.quotation3', compact('products', 'QuotationItem','QuotationRecord','showAll'));


    }

    private function reorderArray($originalArray, $orderArray) {
        usort($originalArray, function ($a, $b) use ($orderArray) {
            $posA = array_search($a['id'], $orderArray);
            $posB = array_search($b['id'], $orderArray);
            return $posA - $posB;
        });

        return $originalArray;
    }



    public function quotation4() {

        $user = auth()->user();
        $pagelength = request()->get('pagelength',10);
        $quotation_id = request()->get('typeId');
        $QuotationRecord = Quotation::whereId($quotation_id)->where('user_id',$user->id)->first();
        $QuotationItems = QuotationItem::where('quotation_id',$quotation_id)->get();
        $countries = Country::get();
        $custom_inputs = $user->custom_fields ?? null;
        $settings = json_decode(auth()->user()->settings);

        $consignee_record = json_decode($QuotationRecord->consignee_details) ?? [];
        $consignee_details = Consignee::whereIn('id',$consignee_record)->get();


        if ($QuotationRecord->type_of_quote == 1) {
            if (isset($settings->performa_mark) && isset($settings->performa_index)){
                $new_consignee_slug = checkQuoteSlug($settings->performa_mark, $settings->performa_index, auth()->user()->id) ?? 'Consignee-'.rand(1000,9999);
            }else{
                $new_consignee_slug = 'Consignee-'.rand(1000,9999);
            }
        }else{
            if (isset($settings->quotaion_mark) && isset($settings->quotaion_index)){
                $new_consignee_slug = checkQuoteSlug($settings->quotaion_mark, $settings->quotaion_index, auth()->user()->id) ?? 'Consignee-'.rand(1000,9999);
            }else{
                $new_consignee_slug = 'Consignee-'.rand(1000,9999);
            }
        }


        if ($custom_inputs != null) {
            $custom_inputs = json_decode($custom_inputs);
        }

        try {
            $selected_cols = array_keys((array) json_decode($QuotationItems[0]->additional_notes)) ?? [];
        } catch (\Throwable $th) {
            // throw $th;
            $selected_cols = [];
        }


        // magicstring($selected_cols);
        // return;

        return view('panel.Documents.quotation4', compact('QuotationRecord','QuotationItems','user','countries','custom_inputs','consignee_details','new_consignee_slug','selected_cols'));
    }

    public function storeQuotation(){
        if (request()->ajax()) {
            $taxes = json_decode(request()->get('taxes')) ?? [];
            $add_nots = request()->get('additional_notes');

            $charges = [
                'taxes'=> $taxes,
                'additional_notes'=>$add_nots,
            ];

            $tablerecord = json_decode(request()->get('data'));
            $TotalPrice = 0;
            $Quotation = Quotation::find(request()->get('quotation_id'));

            if (!$Quotation) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Quotation not found.',
                ]);
            }

            foreach ($tablerecord as $key => $trecords) {
                $QuotationItemRecord = QuotationItem::whereId($trecords->ID)
                    ->where('quotation_id', request()->get('quotation_id'))
                    ->first();


                if (!$QuotationItemRecord) {
                    // Handle case where QuotationItem is not found
                    continue;
                }


                // Update common fields for all QuotationItems
                $QuotationItemRecord->Price = $trecords->Price ?? 0;
                $QuotationItemRecord->currency = $trecords->Currency ?? 'INR';
                $QuotationItemRecord->additional_notes = json_encode($trecords);
                $QuotationItemRecord->quantity = $trecords->Quantity ?? 0;
                $QuotationItemRecord->unit = $trecords->Unit ?? 0;
                $QuotationItemRecord->save();

                $TotalPrice += $trecords->Price ?? 0;


            }

            // Update common fields for the Quotation
            $Quotation->total_amount = $TotalPrice;
            $Quotation->charges_info = json_encode($charges);
            $Quotation->status = 1; // Assuming 1 represents a certain status


            $Quotation->save();

            // magicstring($QuotationItemRecord);

            return response()->json([
                'status' => 'success',
                'message' => 'Quotation Updated Successfully',
            ]);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Ajax Request Support Only.',
            ]);
        }

    }

    public function quotationpdf() {
        $user  = auth()->user();
        $QuotationRecord = Quotation::whereId(request()->get('typeId'))->first();
        $QuotationItemRecords = QuotationItem::where('quotation_id',$QuotationRecord->id)->get();
        $Userrecord = json_decode($QuotationRecord->customer_info) ?? null;

        if ($QuotationRecord->type_of_quote == 1) {
            $type = 'Proforma Invoice';
        }else{
            $type = 'Quotation';
        }


        $pageTitle = $Userrecord->companyName." - ".$QuotationRecord->user_slug;
        $buyer = BuyerList::whereId($Userrecord->Buyer_Id)->first() ?? null;

        $usershop = UserShop::whereUserId($user->id)->first();


        $charges_info = json_decode($QuotationRecord->charges_info);
        return view('panel.Documents.quotationpdf', compact('QuotationRecord','QuotationItemRecords','user','Userrecord','pageTitle','buyer','type','usershop','charges_info'));
    }

    public function printexcelqt1() {
        $user= User::whereId(auth()->id())->first();

        $usershop= UserShop::whereUserId($user->id)->first();
        $quotation= Quotation::whereId(request()->get('typeId'))->first();
        $quotationitems= QuotationItem::where('quotation_id',$quotation->id)->get();
        $no_required_cols = ['ID'];

        $buyerRecord = json_decode($quotation->customer_info)->Buyer_Id;
        $Userrecord = json_decode($quotation->customer_info) ?? null;
        $buyer = BuyerList::whereId($buyerRecord)->first();

        $entity_details = $buyer->buyer_details;

        if ($quotation->type_of_quote == 1) {
            $type = 'Proforma Invoice';
        }else{
            $type = 'Quotation';
        }

        $pageTitle = $Userrecord->companyName." - ".$Userrecord->person_name." $type";
        // $time = \Carbon\Carbon::now();
        // $pageTitle = "$type {$Userrecord->companyName} {$time}";

        // $pageTitle = str_replace(" ","_",$pageTitle);
        // $pageTitle = str_replace(":","-",$pageTitle);


        return view('panel.Documents.printexcelqt1',compact('user','usershop','quotation','quotationitems','no_required_cols','entity_details','pageTitle','Userrecord','type'));
    }



    public function packinglistpdf(Request $request) {
        $user  = auth()->user();
        $usershop = UserShop::whereUserId($user->id)->first();
        $quotation_id = request()->get('typeId');
        $quotation= Quotation::whereId(request()->get('typeId'))->first();
        $customer_record = json_decode($quotation->customer_info) ?? null;


        $charges_info = json_decode($quotation->charges_info) ?? null;

        if ($customer_record != null) {
            $buyer_find  = BuyerList::whereId($customer_record->Buyer_Id)->first();
            $bank_details = json_decode(json_decode($buyer_find->bank_details)) ?? [];
        }else{
            $buyer_find  = null;
            $bank_details = [];
        }

        $buyer_details  = json_decode($buyer_find->buyer_details) ?? null;

        if ($buyer_details != null) {
            $entities =  UserAddress::where('id',$buyer_details->entity_details_id)->first();
            $entity_details = json_decode($entities->details);
        }else{
            $entities = null;
            $entity_details = null;
        }



        if (request()->has('consingee')) {
            $consignee_details = Consignee::where('id',$request->consingee)->first();
            $Consignee1 = json_decode($consignee_details->consignee_details) ?? null;
            $invoice_num = json_decode($consignee_details->consignee_details)->p_id;
        }else{
            $consignee_details = [];
            $Consignee1 = null;
            $invoice_num = $quotation->user_slug;
        }
        $quotationitems = QuotationItem::where('quotation_id',$quotation_id)->get();

        if (request()->has('debug') ){
            magicstring($quotation);
            return;
        }




        return view('panel.Documents.packinglistpdf', compact( 'entities','user','quotation','quotation_id','buyer_find','customer_record','quotationitems','usershop','buyer_details','entity_details','consignee_details','bank_details','charges_info','invoice_num','Consignee1'));



    }

    function exportexcel(Request $request){

        $tabelcontent = request()->get('tabelcontent');
        $File_name = request()->get('filename',null);

        $Array_headers = array_keys((array) json_decode($tabelcontent)[0]);
        // $Array_headers1= array_keys((array) json_decode($tabelcontent)[1]);
        $Array_values = [[]];


        // $ArrayKheader = [[]];

        foreach (json_decode($tabelcontent) as $key => $value) {
            foreach ($value as $index => $element) {
                $Array_values[$key][$index] = $element;
            }
        }


        $url = ENV('EXCEL_EXPORT_URL') ?? 'https://gb.giftingbazaar.com/excel/upload';

        if ($File_name == null) {
            $data = [
                'data' => $Array_values,
            ];
        }else{
            $File_name = str_replace(" ","_",$File_name);
            $data = [
                'data' => $Array_values,
                'fileName' => $File_name,
            ];
        }

        $response = Http::post($url, $data);
        $result = json_decode($response->body());

        if ($request->ajax()) {
            return $response;
        }else{
            return $result;
        }

    }

    function uploadFileQuote(Request $request){

        try {

            $count = 0;
            $misc_details = json_encode($request->misc_details) ?? null;
            foreach ($request->uploadFiles as $key => $file) {

                $file_extension = $file->getClientOriginalExtension();
                $og_file_name = $file->getClientOriginalName();
                $tmp_filename = \Str::random(15).'.'.$file_extension;
                $user_id = auth()->id();
                $file_type = explode('/',$file->getMimeType())[0];
                $folderPath = "public/files/$user_id/quote_files";
                $uploaded_path = $file->storeAs($folderPath, $tmp_filename);
                $uploaded_path = str_replace('public','storage',$uploaded_path);

                $media = new QuoteFiles();
                $media->file_name = $og_file_name;
                $media->quote_id = $request->get('typeId');
                $media->file_path = $uploaded_path;
                $media->file_type = $file_type;
                $media->user_id = $user_id;
                $media->misc_notes = $misc_details;
                $media->save();
                $count++;
            }

            return back()->with('success',"$count File Uploaded Successfully");

        } catch (\Throwable $th) {
            return back()->with('error','Error Occurred While Uploading File');
            //throw $th;
        }

    }

    function makequoteOffer(Proposal $proposal){

        /*
            Entity Name - name
            ID - alias
            Contact Number - Phone
            Email - Email
            Currency - Currency
            Internal Remarks - Offer Notes
            Quotation items - products
        */
        try {

            $customer_details = json_decode($proposal->customer_details);
            $Proposal_items = ProposalItem::where('proposal_id',$proposal->id)->pluck('product_id','id')->toArray();

            $rec_to_sent = [
                'name' => $customer_details->customer_name ?? '',
                'person_name' =>   $customer_details->person_name ?? '',
                'alias' => $customer_details->customer_alias ?? '',
                'Phone' => $customer_details->customer_mob_no ?? '',
                'Email' => $customer_details->customer_email ?? '',
                'Currency' => $proposal->offer_currency ?? 'INR',
                'Offer_Notes' => $proposal->proposal_note ?? '',
                'products' => implode(",",$Proposal_items) ?? [],
                'proposal_id' => $proposal->id,
            ];


            request()->session()->flash('offer_data', $rec_to_sent);
            // request()->session()->put('offer_data', $rec_to_sent);

            return redirect()->route('panel.Documents.create.Quotation.form');
        } catch (\Throwable $th) {
            return back()->with('Ops. Something Went Wrong.');
            // throw $th;
        }

    }


    function packinglist(Request $request) {
        $QuotationItem = QuotationItem::where('id',$request->get('item_id'))->first();
        $Quotation = Quotation::whereId($QuotationItem->quotation_id)->first();
        $ProductRecord = Product::whereId($QuotationItem->product_id)->first();
        $shipping = json_decode($ProductRecord->shipping);
        $consignee_details = json_decode($Quotation->consignee_details) ?? [];
        $consignee_record = Consignee::whereIn('id',$consignee_details)->get();

        $carton_details = json_decode($ProductRecord->carton_details);
        $length_uom = json_decode(getSetting('dimension_uom'));
        $quantity_uom = json_decode(getSetting('item_uom'));
        $weight_uom = json_decode(getSetting('weight_uom'));

        // magicstring($consignee_record->pluck('consignee_details','id'));
        $consign_select = [];

        foreach($consignee_record->pluck('consignee_details','id') as $key => $item){

            $consign_select[$key] = json_decode($item)->ref_id;
        }

        try {
            $avl_packinglist = array_slice(json_decode($QuotationItem->packing_list)->packing_record,0,-1);
        } catch (\Throwable $th) {
            $avl_packinglist = [];
        }

        $product_variant_combo = getProductVariantsById($ProductRecord->id) ?? [];

        if ($request->has('debug') ){
            // magicstring($ProductRecord);
            magicstring($product_variant_combo);
            // magicstring(array_slice(json_decode($QuotationItem->packing_list)->packing_record,0,-1));
            return;
        }
        return view('panel.Documents.pages.packing-list',compact('QuotationItem','ProductRecord','shipping','consignee_record','Quotation','carton_details','length_uom','quantity_uom','weight_uom','consign_select','avl_packinglist','product_variant_combo'));
    }

    function packingliststore(Request $request) {

        try {
            $summary = [
                "consignee_wise" => json_decode(request()->get('consignee-tabledata')),
                "overall" => json_decode(request()->get('summary-tabledata')),
            ];


            $record = [
                'weight' => $request->get('weight'),
                'product' => $request->get('product'),
                'packing_record' => json_decode($request->tabledata),
            ];

            $itemId = decrypt($request->quote_id_item);
            QuotationItem::whereId($itemId)->update(['packing_list' => json_encode($record),'packing_summary' => json_encode($summary)]);

            return redirect(route('panel.Documents.quotation4',['typeId' => decrypt($request->quote_id)]))->with('success','Packing List Updated Successfully');


            // return back()->with('success','Packing List Updated Successfully');
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('error','Error Occurred While Updating Packing List');
        }

    }



    function makequotePerfoma(Request $request,Quotation $quotation) {

        try {

            $count_quote = 0;
            $count_quoteItem = 0;
            $user = auth()->user();
            $entities =  UserAddress::where('user_id',$user->id)->get();
            $userShop = UserShop::whereUserId($user->id)->first();
            $userset = json_decode($user->settings);


            // PI ID Prefix
            if (isset($userset->performa_mark) && $userset->performa_mark != null && $userset->performa_mark != '') {
                $PI_number = checkQuoteSlug($userset->performa_mark,$userset->performa_index,$user->id) ?? 'Quotation';
            }else{
                $PI_number = getUniqueProposalSlug('performa-invoice');
            }

            $system_PI_slug = getUniqueProposalSlug('performa-invoice');

            // `` Replicating Quotation to Performa Invoice
            $PerfomaInvoice = $quotation->replicate();
            $PerfomaInvoice->status = 0;
            $PerfomaInvoice->type_of_quote = 1;
            $PerfomaInvoice->user_slug = $PI_number;
            $PerfomaInvoice->linked_quote = $quotation->id;
            $PerfomaInvoice->slug = $system_PI_slug;
            $PerfomaInvoice->created_at = date('Y-m-d H:i:s');
            $PerfomaInvoice->updated_at = date('Y-m-d H:i:s');
            $PerfomaInvoice->save();
            $count_quote++;

            $QuotationItems = QuotationItem::where('quotation_id',$quotation->id)->get();

            foreach ($QuotationItems as $key => $item) {
                $PerfomaInvoiceItem = $item->replicate();
                $PerfomaInvoiceItem->quotation_id = $PerfomaInvoice->id;
                $PerfomaInvoiceItem->created_at = date('Y-m-d H:i:s');
                $PerfomaInvoiceItem->updated_at = date('Y-m-d H:i:s');
                $PerfomaInvoiceItem->save();
                $count_quoteItem++;
            }



            $edit_url = route('panel.Documents.create.Quotation.form',['typeId' => $PerfomaInvoice->id,'action' => 'edit']);
            echo $edit_url;

            return redirect($edit_url)->with('success','Quotation Converted to Performa Successfully');

            // return redirect(route('panel.Documents.quotation2',['typeId' => $PerfomaInvoice->id]));
            // return redirect(route('panel.Documents.quotation2',['typeId' => $PerfomaInvoice->id]))->with('success','Quotation Converted to Performa Successfully, PI Number : '.$PI_number.' and Total Items : '.$count_quoteItem);

        } catch (\Throwable $th) {
            throw $th;
            // return back()->with('error','Error Occurred While Converting Quotation to Performa');
        }




    }


}
