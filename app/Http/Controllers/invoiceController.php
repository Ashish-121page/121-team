<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserAddressController;
use Illuminate\Http\Request;
use App\User;
use App\Models\Product;
use App\Models\UserShop;
use App\Models\Media;
use App\Models\Brand;
use App\Models\AccessCatalogueRequest;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\UserCurrency;
use App\Models\BuyerList;
use App\Models\Country;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Http;

class invoiceController extends Controller
{

    // public function index() {
    //     return view('panel.invoice.index');
    // }

    // public function secondview() {
    //     return view('panel.invoice.secondview');
    // }

    // public function thirdview() {
    //     return view('panel.invoice.thirdview');
    // }

    // public function fourthview() {
    //     return view('panel.invoice.fourthview');
    // }

    // public function Quotation() {
    //     return view('panel.invoice.Quotation');
    // }


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
        $Quotation = Quotation::where('user_id',auth()->id())->get();

        $buyerDetails = $Quotation->pluck('customer_info')->toArray();
        return view('panel.Documents.Quotation',compact('Quotation'));
    }


    public function createQuotationform() {
        $user = auth()->user();

        $entities =  UserAddress::where('user_id',$user->id)->get();
        $userShop = UserShop::whereUserId($user->id)->first();
        $userset = json_decode($user->settings);
        $quotation_number = checkQuoteSlug($userset->quotaion_mark,$userset->quotaion_index,$user->id) ?? 'Quotation';

        $currency = UserCurrency::where('user_id',$user->id)->get();
        $terms_of_delivery = json_decode(getSetting('terms_of_delivery'));
        $countries = Country::get();

        return view('panel.Documents.create-quotation',compact('entities','userShop','quotation_number','currency','terms_of_delivery','countries'));
    }

    function checkslug() {
        $user = auth()->user();
        $chk = Quotation::where('user_slug',request()->get('slug'))->where('user_id',$user->id)->get()->count();
        if ($chk > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Slug Already Exist',
                'class' => 'text-danger',
            ]);
        }else{
            return response()->json([
                'status' => 'success',
                'message' => 'Slug Available',
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






            // {"buyerName":"Ashish","buyerEmail":"","companyName":"","CreatedOn":"1/5/2024, 11:40:58 AM"}


            $Buyer_obj = array_merge([
                'CreatedOn' => date('m/d/Y, h:i:s A'),
                'Buyer_Id' => $buyer->id,
                'companyName' => $buyer_detailsdb['entity_name'] ?? '',
            ], $contact_personsdb[0]);

            // $Buyer_obj = [
            //     'buyerName' => $buyer_detailsdb['entity_name'] ?? '',
            //     'buyerEmail' => $buyer_detailsdb['buyer_email'] ?? '',
            //     'companyName' => $buyer_detailsdb['entity_name'] ?? '',
            //     'CreatedOn' => date('m/d/Y, h:i:s A'),
            //     'Buyer_Id' => $buyer->id
            // ];


            // Uploading Final Data
            $record = [
                'customer_info' => json_encode($Buyer_obj),
                'user_id' => auth()->id(),
                'user_shop_id' => $user_shop_id,
                'quotation_date' => $quotation['date'],
                'total_amount' => 0,
                'additional_notes' => $internal_remarks ?? null,
                'exchange_rate' => $quotation['exchange'],
                'slug' => getUniqueProposalSlug($buyer_detailsdb['entity_name']),
                'user_slug' => $quotation['number'] ?? null,
                'additional_notes' => json_encode($quotation) ?? null,
            ];

            $data = Quotation::create($record);

            // ! Uploading Files
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
                return back()->with('success','Quotation Created Successfully');
            }else{
                $typeid =  $data->id;
                $flow = encrypt('pick_product');
                $url = ENV('APP_CHANNEL').ENV('APP_URL')."/panel/Quotation/step-3?typeId=$typeid";
                return redirect()->to($url)->with('success', 'Quotation Created Successfully');
            }

        } catch (\Throwable $th) {
            throw $th;
            return back()->with('error','Error Occurred While Creating Quotation');
        }
    }




    public function quotation2() {

        if ( request()->has('typeId') && request()->get('typeId') != '') {
            $record = Quotation::whereId(request()->get('typeId'))->first();
            $quote_flles = Media::where('type_id',$record->id)->where('type','UserShop')->where('tag','quote_files')->get();




        }else{
            return back()->with('Error occurred while retrieving the record. Please try again later.');
        }

        return view('panel.Documents.quotation2',compact('record','quote_flles'));
    }


    public function createQuotationitem() {

        if (request()->ajax()) {
            $product = Product::whereId(request()->get('precord'))->first();
            $varients = getAllPropertiesofProductById($product->id)->pluck('attribute_value_id','attribute_id');
            $varients_arr = [];
            foreach ($varients as $varient_parent => $varient) {
                array_push($varients_arr,getAttruibuteValueById($varient)->attribute_value);
            }

            $currency = request()->get('currency','INR');
            $quotation_id = request()->get('quotation_id');

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
                $quotationItem->Price = $product->mrp;
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

        }else{
            return response()->json([
                'status' => 'Error',
                'message' => 'Ajax Request Support Only.',
            ]);
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

        $products = $products->paginate($pagelength);
        $QuotationItem = QuotationItem::where('quotation_id', $quotation_id)
            ->whereIn('product_id', $products->pluck('id'))
            ->pluck('product_id')
            ->toArray();

        return view('panel.Documents.quotation3', compact('products', 'QuotationItem','QuotationRecord'));
    }




    public function quotation4() {

        $user = auth()->user();
        $pagelength = request()->get('pagelength',10);
        $quotation_id = request()->get('typeId');
        $QuotationRecord = Quotation::whereId($quotation_id)->where('user_id',$user->id)->first();
        $QuotationItems = QuotationItem::where('quotation_id',$quotation_id)->get();
        $countries = Country::get();

        return view('panel.Documents.quotation4', compact('QuotationRecord','QuotationItems','user','countries'));
    }


    public function storeQuotation(){
        // magicstring(request()->all());
        if (request()->ajax()) {
            $tablerecord = json_decode(request()->get('data'));
            $TotalPrice = 0;

            $Quotation = Quotation::whereId(request()->get('quotation_id'))->first();
            foreach ($tablerecord as $key => $trecords) {
                $QuotationItemRecord = QuotationItem::whereId($trecords->ID)->where('quotation_id',request()->get('quotation_id'))->first();
                $QuotationItemRecord->Price = $trecords->Price;
                $QuotationItemRecord->currency = $trecords->Currency ?? 'INR';
                $QuotationItemRecord->additional_notes = json_encode($trecords);

                $QuotationItemRecord->quantity = $trecords->Quantity;
                $QuotationItemRecord->unit = $trecords->Unit;

                $QuotationItemRecord->save();

                $TotalPrice += $trecords->Price ?? 0;



            }

            $Quotation->additional_notes = request()->get('additional_notes');
            $Quotation->total_amount = $TotalPrice ?? 0;
            $Quotation->status = 1;
            $Quotation->save();


            return response()->json([
                'status' => 'success',
                'message' => 'Quotation Updated Successfully',
            ]);
        }else{
            return response()->json([
                'status' => 'Error',
                'message' => 'Ajax Request Support Only.',
            ]);
        }


    }



    public function quotationpdf() {
        $user  = auth()->user();
        $QuotationRecord = Quotation::whereId(request()->get('typeId'))->first();
        $QuotationItemRecords = QuotationItem::where('quotation_id',$QuotationRecord->id)->get();

        $buyerRecord = json_decode($QuotationRecord->customer_info)->Buyer_Id;
        $buyer = BuyerList::whereId($buyerRecord)->first();
        $entity_details_id = json_decode($buyer->buyer_details)->entity_details_id;
        $entity_details = UserAddress::whereId($entity_details_id)->first();



        // magicstring(json_decode($entity_details->details)->entity_name);
        // return;




        return view('panel.Documents.quotationpdf', compact('QuotationRecord','QuotationItemRecords','user','entity_details'));
    }

    public function printexcelqt1() {
        $user= User::whereId(auth()->id())->first();

        $usershop= UserShop::whereUserId($user->id)->first();
        $quotation= Quotation::whereId(request()->get('typeId'))->first();
        $quotationitems= QuotationItem::where('quotation_id',$quotation->id)->get();


        $products= Product::whereUserId($user->id)->whereIn('id',$quotationitems->pluck('product_id')->toArray())->get();
        $userAttribute = json_decode($user->custom_attriute_columns) ?? [];
        $First_additional_notes = json_decode($quotationitems[0]->additional_notes);

        if (request()->has('debug')) {
            magicstring($userAttribute);
            magicstring(array_keys( (array) $First_additional_notes));
            return;
        }



        return view('panel.Documents.printexcelqt1',compact('user','usershop','quotation','quotationitems','products','userAttribute','First_additional_notes'));
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
            $file = $request->file('uploadFiles');
            $file_extension = $file->getClientOriginalExtension();

            $og_file_name = $file->getClientOriginalName();
            $tmp_filename = \Str::random(15).'.'.$file_extension;
            $user_id = auth()->id();

            $file_type = explode('/',$file->getMimeType())[0];


            $folderPath = "public/files/$user_id/quote_files";
            $uploaded_path = $file->storeAs($folderPath, $tmp_filename);

            $uploaded_path = str_replace('public','storage',$uploaded_path);

            $media = new Media();
            $media->file_name = $og_file_name;
            $media->path = $uploaded_path;
            $media->extension = $file_extension;
            $media->file_type = $file_type;
            $media->tag = 'quote_files';
            $media->type_id = $request->get('typeId');
            $media->type = 'UserShop';
            $media->save();

            return back()->with('success','File Uploaded Successfully');
        } catch (\Throwable $th) {
            return back()->with('error','Error Occurred While Uploading File');
            //throw $th;
        }

    }


}
