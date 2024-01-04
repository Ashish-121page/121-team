<?php

namespace App\Http\Controllers;
// use App\Http\Controllers\Controller;
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
use App\Models\Country;
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

        return view('panel.Documents.Quotation',compact('Quotation'));
    }


    public function createQuotation() {

        if (request()->ajax()) {
            $user_shop = UserShopIdByUserId(auth()->id());
            $quotation_date = date('Y-m-d H:i:s');
            $currency_record = UserCurrency::where('user_id',auth()->id())->get();

            
            $user = auth()->user();
            // $user = User::whereId('174')->first();
            
            
            $userset = json_decode($user->settings);
            if ($userset != null && $userset->quotaion_mark != null && $userset->quotaion_index != null) {
                $mark = checkQuoteSlug($userset->quotaion_mark,$userset->quotaion_index,$user->id);
            }else{
                $mark = null;
            }
            
        
            $customer_name = "Quotation";

            $exchange_rate = [];
            foreach($currency_record as $currency){
                $exchange_rate[$currency->currency] = $currency->exchange;
            }
            
            $exchange_rate = json_encode($exchange_rate);


            $record = [
                'customer_info' => request()->get('buyerObj'),
                'user_id' => auth()->id(),
                'user_shop_id' => $user_shop,
                'quotation_date' => $quotation_date,
                'total_amount' => 0,
                'additional_notes' => null,
                'exchange_rate' => $exchange_rate,
                'slug' => getUniqueProposalSlug($customer_name),
                'user_slug' => $mark
            ];

            $data = Quotation::create($record);

            return response()->json([
                'status' => 'success',
                'record_id' => $data->id,
                'message' => 'Quotation Created Successfully',
            ]);
        }else{
            return response()->json([
                'status' => 'Error',
                'message' => 'Ajax Support Only',
            ]);
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

        return view('panel.Documents.quotation3', compact('products', 'QuotationItem'));
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
                $QuotationItemRecord->save();

                $TotalPrice += $trecords->Price;

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
        return view('panel.Documents.quotationpdf', compact('QuotationRecord','QuotationItemRecords','user'));
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
        $Array_headers1= array_keys((array) json_decode($tabelcontent)[1]);
        $Array_values = [[]];

        foreach (json_decode($tabelcontent) as $key => $value) {
            foreach ($value as $index => $element) {
                $Array_values[$key][$index] = $element;
            }
        }

        // magicstring($Array_headers  );

        // return;

        $url = 'https://gb.giftingbazaar.com/excel/upload';

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
            $tmp_filename = \Str::random(35).'.'.$file_extension;
            $user_id = auth()->id();

            $file_type = explode('/',$file->getMimeType())[0];

            
            $folderPath = "app/public/files/$user_id/quote_files";
            $uploaded_path = $file->move(storage_path($folderPath), $tmp_filename)->getpath();
            

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
