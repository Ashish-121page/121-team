@extends('frontend.layouts.main')

@section('meta_data')
@php
		$meta_title = 'Dashboard | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';
        $customer = 1;	
@endphp
@section('content')

<section class="section">
    <div class="container mt-5">
        {{-- Code Goes Here --}}
        <form method="POST" action="{{ route('customer.lock.enquiry.store') }}">
        @csrf
        <input type="hidden" name="user_id" value="{{auth()->id()}}">
        <input type="hidden" name="proposal_id" value="{{$proposal->id}}">
        <div class="h4 text-center my-3">Lock Enquiry</div>
            <div class="row">
                <!-- First Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="reseller_name" class="form-label">Reseller Name</label>
                        <input type="text" class="form-control" id="reseller_name" name="reseller_name" value="{{ json_decode($proposal->customer_details)->customer_name }}"
                            placeholder="Enter Reseller Name" autofocus="on">
                    </div>
                </div>
    
                <!-- Second Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="client_name" class="form-label">Client name</label>
                        <input type="text" class="form-control" id="client_name" name="client_name" value="@isset($data) {{ json_decode($data->user_info)->client_name }} @endisset" 
                            placeholder="Enter Client name">
                    </div>
                </div>
    
                <!-- third Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="@isset($data) {{$data->quantity}} @endisset"
                         placeholder="Enter Quantity">
                    </div>
                </div>
    
                <!-- fourth Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="valid_upto" class="form-label">Valid upto</label>
                        <input type="date" class="form-control" id="valid_upto" name="valid_upto" value="@isset($data) {{$data->expiry_date}} @endisset"
                            placeholder="Enter date till valid" required>
                    </div>
                </div>
    
                <!-- fifth Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <select name="city" id="city" class="form-control p-2 city"> 
                            @foreach ($city as $item)
                                <option value="{{ $item->id }}" @isset($data) @if( json_decode($data->user_info)->city == $item->id ) selected @endif @endisset>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- sixth Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Pick SKU</label>
                        {{-- <input type="" class="form-control" id="" placeholder=""> --}}
                        <select name="picked_sku[]" class="form-control" id="picked_sku" multiple>
                            @foreach ($proposal_item as $item)
                                @php
                                    $product = getProductDataById($item);
                                @endphp
                                <option value="{{ $product->id ?? '' }}">
                                    {{ $product->model_code ?? '' }} - {{ $product->title ?? 'Not Available' }} - 
                                    {{ $product->color ?? '' }} - {{ $product->size ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                                        <div class="row mt-3" id="sortable">
                                        @if($added_products->count() > 0)
                                            @foreach ($added_products as $proposal_item)
                                                    @php
                                                        $product = fetchFirst('App\Models\Product',$proposal_item->product_id);
                                                        $brand_id = getBrandRecordByProductId($proposal_item->product_id)->id ?? '--';
                                                        if($product != null){
                                                            $product_record = App\Models\UserShopItem::whereProductId($product->id)->whereUserId(auth()->id())->first() ?? null;
                                                        }else{
                                                            $product_record = null; 
                                                        }
                                                        if($product_record){
                                                            $proposal_item_record = App\Models\ProposalItem::where('proposal_id',$proposal->id)->whereProductId($product->id)->whereUserShopItemId($product_record->id)->first();
                                                        }else{
                                                            $proposal_item_record = null;
                                                        }
                                                    @endphp
                                                    <div class="col-md-3 card-drag" data-id="{{ $proposal_item->id }}">
                                                        <div class="card">
                                                            <div class="d-none d-md-block d-sm-none">
                                                                <img src="{{ asset('backend/img/move.png') }}" alt="" height="20px" style="margin-top: 15px;
                                                                margin-left: 15px;">
                                                            </div>
                                                            <img src="{{ (isset($product) && (getShopProductImage($product->id,'single') != null)  ? asset(getShopProductImage($product->id,'single')->path) : asset('frontend/assets/img/placeholder.png')) }}" alt="" class="custom-img" style="height:185px;object-fit: contain;">
                                                           
                                                            <div class="card-body text-center">
                                                                <div class="profile-pic">
                                                                    <div class="row">
                                                                        <div class="col-md-9 pt-2 text-center p-0" style="margin-top: -15px;">
                                                                            <h6 class="mb-0 ">{{$product->title??"--"}}</h6>
                                                                            {{-- @if(isset($product->category_id) || isset($product->sub_category))
                                                                            <span>{{fetchFirst('App\Models\Category',$product->sub_category,'name','--')}}</span> <br>
                                                                            @endif --}}
                                                                            @if (isset(getBrandRecordByProductId($proposal_item->product_id)->name))
                                                                                <span>Brand: {{ (getBrandRecordByProductId($proposal_item->product_id)->name ?? '--') }}</span> <br>
                                                                            @endif
                                                                            
                                                                            
                                                                            <div>
                                                                                <span> {{ $product->color ?? '' }}</span> <span> , </span><span> {{ $product->size ?? '' }}</span>
                                                                            </div>
                                                                           
                                                                            {{-- @php
                                                                                $own_shop = App\Models\UserShop::whereUserId(auth()->id())->first();
                                                                                if($product != null){
                                                                                    $usi = productExistInUserShop($product->id,auth()->id(),$own_shop->id);  
                                                                                }else{
                                                                                    $usi = null; 
                                                                                }
                                                                            @endphp --}}
                                                                            {{-- <span>{{ isset($usi) ? 'Ref Id: '.($usi->id) : 'Ref Id: ###' }}</span> <br> --}}
                                                                            <span>Model Code: {{ $product->model_code ?? '' }}</span>
                                                                            <br>
                                                                            @php
                                                                                $catelogue_author = @App\User::whereId($product->user_id)->first();
                                                                                $group_id = @App\Models\AccessCatalogueRequest::whereNumber($catelogue_author->phone)->latest()->first()->price_group_id ?? 0;
                                                                                $price =  $product->price ?? 0;
                                                                                if($group_id && $group_id != 0){
                                                                                    $price =  getPriceByGroupIdProductId($group_id,$product->id,$price);
                                                                                }
                                                                            @endphp
                                                                            Product Price:<span> {{ isset($price) ? format_price($price) : '' }}</span>
                                                                            {{-- <br> --}}
                                                                            {{-- Shop Price:<span> {{ (isset($product_record) && $product_record->price > 0) ?  format_price($product_record->price) : 'Ask for Price' }}</span> --}}
                                                                            <br>
                                                                            

                                                                            @php
                                                                                $proposal_item->margin = $proposal_item->margin ?? 0;
                                                                                if ($proposal_item->user_price == null) {
                                                                                    $price = $proposal_item->price;
                                                                                    if($proposal_item->margin < 100){
                                                                                        $margin = ($proposal_item->margin) / 100;
                                                                                        $margin_factor =  (100-$proposal_item->margin)/100;
                                                                                        $price  = $price/$margin_factor;
                                                                                    }
                                                                                    $margin = "Margin Added: ".$proposal_item->margin."%";

                                                                                }else{
                                                                                    $price = $proposal_item->user_price;
                                                                                    $margin = "Custom Price";
                                                                                }
                                                                            @endphp

                                                                            {{-- <span>Offer Price: {{ format_price($price) }}</span> --}}
                                                                            <span>Offer Price: {{ format_price($price) }}</span>

                                                                            {{-- <br> --}}
                                                                            <br>
                                                                            {{-- <span> {{ $margin }}</span> --}}

                                                                        </div>
                                                                        <div class="col-3">
                                                                       
                                                                            <button style="background: transparent;margin-left: -10px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                                <a href="{{ route('pages.proposals.destroy',$proposal_item->id) }}" class="btn remove-item mr-2">Remove</a>
                                                                                <a href="javascript:void(0)" data-product="{{ $proposal_item->product_id }}" class="btn mr-2 edit-price"  > Edit Price</a>
                                                                                </a>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="mx-auto">
                                                    <span class="mx-auto">No data available!</span>
                                                </div>
                                            @endif
                                        </div>
                                        @if($added_products->count() > 0 )
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary">Back</a>
                                                <a href="{{ request()->url()  }}{{ '?type=send' }}" class="btn btn-sm btn-outline-primary">Next</a>
                                            </div>
                                        @endif

                                        {{-- code copy from move blade --}}
                                        <div class="row mt-3" id="sortable">
                                            @if($added_products->count() > 0)
                                                @foreach ($added_products as $proposal_item)
                                                        @php
                                                            $product = fetchFirst('App\Models\Product',$proposal_item->product_id);
                                                            $brand_id = getBrandRecordByProductId($proposal_item->product_id)->id ?? '--';
                                                            if($product != null){
                                                                $product_record = App\Models\UserShopItem::whereProductId($product->id)->whereUserId(auth()->id())->first() ?? null;
                                                            }else{
                                                                $product_record = null; 
                                                            }
                                                            if($product_record){
                                                                $proposal_item_record = App\Models\ProposalItem::where('proposal_id',$proposal->id)->whereProductId($product->id)->whereUserShopItemId($product_record->id)->first();
                                                            }else{
                                                                $proposal_item_record = null;
                                                            }
                                                        @endphp
                                                        <div class="col-md-3 card-drag" data-id="{{ $proposal_item->id }}">
                                                            <div class="card">
                                                                <div class="d-none d-md-block d-sm-none">
                                                                    <img src="{{ asset('backend/img/move.png') }}" alt="" height="20px" style="margin-top: 15px;
                                                                    margin-left: 15px;">
                                                                </div>
                                                                <img src="{{ (isset($product) && (getShopProductImage($product->id,'single') != null)  ? asset(getShopProductImage($product->id,'single')->path) : asset('frontend/assets/img/placeholder.png')) }}" alt="" class="custom-img" style="height:185px;object-fit: contain;">
                                                               
                                                                <div class="card-body text-center">
                                                                    <div class="profile-pic">
                                                                        <div class="row">
                                                                            <div class="col-md-9 pt-2 text-center p-0" style="margin-top: -15px;">
                                                                                <h6 class="mb-0 ">{{$product->title??"--"}}</h6>
                                                                                {{-- @if(isset($product->category_id) || isset($product->sub_category))
                                                                                <span>{{fetchFirst('App\Models\Category',$product->sub_category,'name','--')}}</span> <br>
                                                                                @endif --}}
                                                                                @if (isset(getBrandRecordByProductId($proposal_item->product_id)->name))
                                                                                    <span>Brand: {{ (getBrandRecordByProductId($proposal_item->product_id)->name ?? '--') }}</span> <br>
                                                                                @endif
                                                                                
                                                                                
                                                                                <div>
                                                                                    <span> {{ $product->color ?? '' }}</span> <span> , </span><span> {{ $product->size ?? '' }}</span>
                                                                                </div>
                                                                               
                                                                                {{-- @php
                                                                                    $own_shop = App\Models\UserShop::whereUserId(auth()->id())->first();
                                                                                    if($product != null){
                                                                                        $usi = productExistInUserShop($product->id,auth()->id(),$own_shop->id);  
                                                                                    }else{
                                                                                        $usi = null; 
                                                                                    }
                                                                                @endphp --}}
                                                                                {{-- <span>{{ isset($usi) ? 'Ref Id: '.($usi->id) : 'Ref Id: ###' }}</span> <br> --}}
                                                                                <span>Model Code: {{ $product->model_code ?? '' }}</span>
                                                                                <br>
                                                                                @php
                                                                                    $catelogue_author = @App\User::whereId($product->user_id)->first();
                                                                                    $group_id = @App\Models\AccessCatalogueRequest::whereNumber($catelogue_author->phone)->latest()->first()->price_group_id ?? 0;
                                                                                    $price =  $product->price ?? 0;
                                                                                    if($group_id && $group_id != 0){
                                                                                        $price =  getPriceByGroupIdProductId($group_id,$product->id,$price);
                                                                                    }
                                                                                @endphp
                                                                                Product Price:<span> {{ isset($price) ? format_price($price) : '' }}</span>
                                                                                {{-- <br> --}}
                                                                                {{-- Shop Price:<span> {{ (isset($product_record) && $product_record->price > 0) ?  format_price($product_record->price) : 'Ask for Price' }}</span> --}}
                                                                                <br>
                                                                                
    
                                                                                @php
                                                                                    $proposal_item->margin = $proposal_item->margin ?? 0;
                                                                                    if ($proposal_item->user_price == null) {
                                                                                        $price = $proposal_item->price;
                                                                                        if($proposal_item->margin < 100){
                                                                                            $margin = ($proposal_item->margin) / 100;
                                                                                            $margin_factor =  (100-$proposal_item->margin)/100;
                                                                                            $price  = $price/$margin_factor;
                                                                                        }
                                                                                        $margin = "Margin Added: ".$proposal_item->margin."%";
    
                                                                                    }else{
                                                                                        $price = $proposal_item->user_price;
                                                                                        $margin = "Custom Price";
                                                                                    }
                                                                                @endphp
    
                                                                                {{-- <span>Offer Price: {{ format_price($price) }}</span> --}}
                                                                                <span>Offer Price: {{ format_price($price) }}</span>
    
                                                                                {{-- <br> --}}
                                                                                <br>
                                                                                {{-- <span> {{ $margin }}</span> --}}
    
                                                                            </div>
                                                                            <div class="col-3">
                                                                           
                                                                                <button style="background: transparent;margin-left: -10px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                                    <a href="{{ route('pages.proposals.destroy',$proposal_item->id) }}" class="btn remove-item mr-2">Remove</a>
                                                                                    <a href="javascript:void(0)" data-product="{{ $proposal_item->product_id }}" class="btn mr-2 edit-price"  > Edit Price</a>
                                                                                    </a>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="mx-auto">
                                                        <span class="mx-auto">No data available!</span>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($added_products->count() > 0 )
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary">Back</a>
                                                    <a href="{{ request()->url()  }}{{ '?type=send' }}" class="btn btn-sm btn-outline-primary">Next</a>
                                                </div>
                                            @endif


            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</section>
@endsection

@section('InlineScript')
<script src="{{ asset('backend/js/qrcode.js') }}"></script>
<script src="{{ asset('frontend/assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('frontend/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>

<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
<script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

<script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('backend/js/html2canvas.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#picked_sku").select2()
        $(".city").select2()
    });
</script>

@endsection