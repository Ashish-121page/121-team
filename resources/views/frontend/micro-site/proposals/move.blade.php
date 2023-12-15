@extends('backend.layouts.main')
@section('title', 'Proposal')
@section('content')
    @php

    $breadcrumb_arr = [['name' => 'Edit Proposal', 'url' => 'javascript:void(0);', 'class' => '']];
    $user = auth()->user();
    $proposal_options = json_decode($proposal->options);

    // $proposal_options->show_Attrbute = $proposal_options->show_Attrbute ?? 0;

    // $proposal_options->show_Description = $proposal_options->show_Description ?? 0;
    $slug_guest = getShopDataByUserId(155)->slug;
    $offer_url = inject_subdomain("shop/proposal/$proposal->slug",$slug_guest);

    $make_offer_link = inject_subdomain('proposal/create', $slug_guest, false, false)."?linked_offer=".$proposal->id."&offer_type=2&shop=".$proposal->user_shop_id;

    if ($proposal->type == 1) {
        $offer_url = $make_offer_link;
    }
// echo $proposal->id;
// return;
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    {{-- Animated modal --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">


        <style>
            /* .app-sidebar , .header-top{
                display: none !important;
            } */

            .main-content{
                padding: 0 !important;
            }
            .error {
                color: red;
            }

            #file-input{
                padding:10px;
                background-color:#6666CC;
                color: #fff;
            }
            .image-preview,.image-preview-vs{
                height: 120px;
                width: auto;
                display: block;
                padding: 5px;
                margin-top: 10px;
            }
            .cursor-pointer{
                pointer-events: none;
            }
            .product-box {
                position: relative;
                overflow: hidden;
            }
            .card-box {
                background-color: #fff;
                padding: 1.5rem;
                box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
                margin-bottom: 24px;
                border-radius: 0.25rem;
            }
            .prdct-checked {
                position: absolute;
                width: 30px;
                height: 30px;
                right: 10px;
                top: 10px;
            }

            .prdct-pinned {
                position: absolute;
                width: 30px;
                height: 30px;
                left: 10px;
                top: 10px;
            }

            .prdct-pinned input{
                visibility: hidden;
            }

            #checkmarkpin{
                position: absolute;
                top: 10px;
                left: 0;
                height: 30px;
                width: 30px;
                border-radius: 3px;
                background-color: transparent !important;
            }
            #checkmarkpin  img  {
                height: 30px;
                width: 30px;
            }

            .checkmark {
                position: absolute;
                top: 0;
                left: 0;
                height: 30px;
                width: 30px;
                border-radius: 3px;
                background-color: #eee;
            }
            .checkmark:after {
                content: "";
                position: absolute;
                display: block;
            }
            .custom-chk .checkmark:after {
                left: 12px;
                top: 5px;
                width: 7px;
                height: 16px;
                border: solid white;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
                }

                .custom-chk input:checked~.checkmark {
                    background-color: #6666cc;
                }


                .cust-display {
                    display: flex;
                }



                @media (max-width: 767px) {
                    .cust-display {
                        display: block;
                    }
                }

                .hdsjfibdsjk{
                    display: none;
                }

                @media (max-width: 575px){
                    .hdsjfibdsjk{
                        display: block;
                    }
                }

                .remove-ik-class {
                    -webkit-box-shadow: unset !important;
                    box-shadow: unset !important;
                }



                /* custome Loader */

                .lds-roller {
                    display: inline-block;
                    position: absolute;
                    z-index: 999;
                    width: 100%;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    backdrop-filter: grayscale(1) blur(5px);
                }

                .lds-roller div {
                    animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
                    transform-origin: 40px 40px;
                }

                .lds-roller div:after {
                    content: " ";
                    display: block;
                    position: absolute;
                    width: 7px;
                    height: 7px;
                    border-radius: 50%;
                    background: #111;
                    margin: -4px 0 0 -4px;
                }

                .lds-roller div:nth-child(1) {
                    animation-delay: -0.036s;
                }

                .lds-roller div:nth-child(1):after {
                    top: 63px;
                    left: 63px;
                }

                .lds-roller div:nth-child(2) {
                    animation-delay: -0.072s;
                }

                .lds-roller div:nth-child(2):after {
                    top: 68px;
                    left: 56px;
                }

                .lds-roller div:nth-child(3) {
                    animation-delay: -0.108s;
                }

                .lds-roller div:nth-child(3):after {
                    top: 71px;
                    left: 48px;
                }

                .lds-roller div:nth-child(4) {
                    animation-delay: -0.144s;
                }

                .lds-roller div:nth-child(4):after {
                    top: 72px;
                    left: 40px;
                }

                .lds-roller div:nth-child(5) {
                    animation-delay: -0.18s;
                }

                .lds-roller div:nth-child(5):after {
                    top: 71px;
                    left: 32px;
                }

                .lds-roller div:nth-child(6) {
                    animation-delay: -0.216s;
                }

                .lds-roller div:nth-child(6):after {
                    top: 68px;
                    left: 24px;
                }

                .lds-roller div:nth-child(7) {
                    animation-delay: -0.252s;
                }

                .lds-roller div:nth-child(7):after {
                    top: 63px;
                    left: 17px;
                }

                .lds-roller div:nth-child(8) {
                    animation-delay: -0.288s;
                }

                .lds-roller div:nth-child(8):after {
                    top: 56px;
                    left: 12px;
                }

                @keyframes lds-roller {
                    0% {
                        transform: rotate(0deg);
                    }

                    100% {
                        transform: rotate(360deg);
                    }
                }

                .loader-hidden {
                    display: none;
                }


                 /* modal */
                /* #btn-close-modal1{
                    width:100%;
                    text-align: center;
                    cursor:pointer;
                    color:#fff;
                } */

                #btn-close-modal2{
                    width: 80%;
                    text-align: center;
                    cursor:pointer;
                    color:#fff;
                    left: 60%
                }

                #animatedModal2{
                    overflow-y: hidden!important;
                    overflow-x: hidden!important;

                }
                .header-top {
                    display: block !important;
                    padding-left: 0px !important;
                }

        </style>
        @if (auth()->id() != 155)
        <style>
                .header-top {
                    display: block !important;
                    padding-left: 0px !important;
                }

                #back,#navbar-fullscreen{
                    display: none !important;
                }

                .main-content {
                    padding: 0 !important;
                }
        </style>
    @endif

    @endpush
@php
    $customer_details = json_decode($proposal->customer_details) ?? '';
    $customer_name = $customer_details->customer_name ?? '';

    if ($customer_name == auth()->user()->name) {
        $customer_name = "";
    }

    $customer_mob_no = $customer_details->customer_mob_no ?? '';
    $customer_email = $customer_details->customer_email ?? '';
    $customer_alias = $customer_details->offer_alias ?? '';
    $sample_charge = json_decode($proposal->customer_details)->sample_charge ?? '';
    $user_shop_record = App\Models\UserShop::whereId($proposal->user_shop_id)->first();

@endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- start message area-->
                @include('backend.include.message')
                <!-- end message area-->
                {{-- <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-sm-8 ">
                        <div class="my-2" style="background-color: red;color:whitesmoke;font-size: 2.2vh;text-align:center;">
                            <span class="p-2">These Details are Kept Private,and not shared with anyone.</span>
                        </div>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="col-md-8">

                        <div class="card">
                            <div class="card-header">
                                @if(request()->get('type') == 'search')
                                    <h6>Filter Products</h6>
                                @elseif(request()->get('type') == 'markup')
                                    <h6>Choose & Markup Products</h6>
                                @elseif(request()->get('type') == 'picked')
                                    <h6>Picked Products</h6>
                                @else
                                <h6>Send Products</h6>
                                @endif
                                <div class="ml-2 badge badge-{{ getProposalStatus($proposal->status)['color'] }}">{{ getProposalStatus($proposal->status)['name'] }}</div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade @if(request()->get('type') == "picked") show active @endif" id="product-tab" role="tabpanel" aria-labelledby="pills-products-tab">

                                        <div class="row my-2 justify-content-between">
                                            <div class="col-12 col-md-4 d-none d-sm-block d-md-block">
                                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary">Back</a>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                @if (auth()->id() != 155)
                                                    <div class="mx-2 d-flex justify-content-center align-item-center gap-2 flex-wrap">
                                                        <div class="d-flex gap-3">
                                                            <label for="magrintochnage" class="form-label">Margin: <span id="range_bar"> {{ $proposal->margin ?? 0 }} </span>%</label>
                                                            <input type="range" min="0" max="100" step="10" name="margin" class="form-range hdfhj" style="width: 150px" value="{{ $proposal->margin ?? 0 }}" id="magrintochnage">
                                                        </div>
                                                        <div class="mx-2">
                                                            <button id="hikebtn" class="btn btn-outline-primary mx-2 my-2 my-md-0 my-sm-0 ">Update</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-md-4">
                                                @if($added_products->count() > 0 )
                                                    <div class="d-flex justify-content-between justify-content-md-end justify-content-sm-end">
                                                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary hdsjfibdsjk">Back</a>
                                                        <a href="{{ request()->url()  }}{{ '?type=send' }}" class="btn btn-sm btn-outline-primary">Next</a>
                                                    </div>
                                                @endif
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

                                                            <div style="position: absolute;right: -2%; top: 2%;z-index: 1;">
                                                                <a href="{{ route('pages.proposals.destroy',$proposal_item->id) }}" class="btn remove-item mr-2">
                                                                    <i class="fas fa-trash" style="color: #ff0c0c;font-size: 3vh"></i>
                                                                </a>

                                                            </div>
                                                            <div class="card-body text-center">
                                                                <div class="profile-pic">
                                                                    <div class="row">
                                                                        <div class="col-md-12 pt-2 text-center p-0" style="margin-top: -15px;">
                                                                            <span class="mb-0 ">{{$product->title??"--"}}</span>

                                                                            <br>

                                                                            {{-- @if(isset($product->category_id) || isset($product->sub_category))
                                                                            <span>{{fetchFirst('App\Models\Category',$product->sub_category,'name','--')}}</span> <br>
                                                                            @endif --}}
                                                                            @if (isset(getBrandRecordByProductId($proposal_item->product_id)->name))
                                                                                <span>Brand: {{ (getBrandRecordByProductId($proposal_item->product_id)->name ?? '--') }}</span> <br>
                                                                            @endif


                                                                            {{-- <div>
                                                                                <span> {{ $product->color ?? '' }}</span> <span> , </span><span> {{ $product->size ?? '' }}</span>
                                                                            </div> --}}

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

                                                                                $record = App\Models\UserCurrency::where('currency',$product->base_currency)->where('user_id',$product->user_id)->first();
                                                                                $exhangerate = Session::get('Currency_exchange') ?? 1;
                                                                                $HomeCurrency = $record->exchange ?? 1;
                                                                                $currency_symbol = Session::get('currency_name') ?? 'INR';
                                                                                $price = exchangerate($price,$exhangerate,$HomeCurrency);
                                                                            @endphp
                                                                                Product Price:
                                                                                <span>
                                                                                    {{ $currency_symbol }}
                                                                                    {{ isset($price) ? number_format(round($price,2)) : '' }}
                                                                                </span>
                                                                                <br>
                                                                            {{-- Shop Price:<span> {{ (isset($product_record) && $product_record->price > 0) ?  format_price($product_record->price) : 'Ask for Price' }}</span> --}}
                                                                            {{-- <br> --}}
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
                                                                                    $userPrice = $proposal_item->user_price;
                                                                                    $margin = "Custom Price";
                                                                                }
                                                                                $price = exchangerate($price,$exhangerate,$HomeCurrency);
                                                                                // $user = session()->get('temp_user_id') ?? session()->get('user_id');
                                                                                $user = auth()->id() ?? session()->get('user_id') ?? session()->get('temp_user_id');
                                                                                $ashus = json_decode($proposal_item->note);
                                                                            @endphp

                                                                            {{-- @if ($proposal->user_id == $user) --}}
                                                                                {{-- <span>Offer Price: {{ format_price($price) }}</span> --}}
                                                                                <br>
                                                                                <span>Offer Price:
                                                                                    {{ $currency_symbol }}
                                                                                    {{  $userPrice ?? isset($price) ? number_format(round($price,2)) : '' }}
                                                                                </span>
                                                                                <a href="javascript:void(0)" data-product="{{ $proposal_item->product_id }}" data-notes="{!! $ashus->remarks_offer !!}" class="edit-price" >
                                                                                    <i class="fas fa-pencil-alt text-primary"></i>
                                                                                </a>
                                                                            {{-- @endif --}}


                                                                            @if ($proposal_item->note != null)
                                                                            <br>

                                                                                <span>Customisation: {!! $ashus->remarks_offer !!}</span>
                                                                                {{-- <br>
                                                                                <span>Customise: {!! $ashus->Customise_product !!}</span> --}}
                                                                            @endif

                                                                            @if ($proposal_item->attachment != null)
                                                                                <br>
                                                                                <span>Attachment: <a href="{{ asset(getMediaByIds([$proposal_item->attachment])->path) }}" class="btn-link text-primary">Download</a></span>
                                                                            @endif

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



                                    @if(request()->get('type') == 'send')
                                        {{-- @if($customer_name == '' && $customer_mob_no == '')
                                            <div class="alert alert-info">
                                                <p class="mb-0">Please fill the prospect information. </p>
                                            </div>
                                        @endif --}}
                                        <form action="{{ route('pages.proposal.update', $proposal->id) }}" method="post" enctype="multipart/form-data" id="ProposalForm" class="row">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ decrypt($user_key) }}">
                                            <input type="hidden" name="user_shop_id" value="{{ getShopDataByUserId(decrypt($user_key))->id }}">
                                        <div class="col-md-12 col-lg-6">
                                            <div class="col-md-12 ">
                                                <div class="d-flex justify-content-between">
                                                    <div class="">
                                                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary">Back</a>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-outline-primary">Save</button>
                                                    </div>
                                                        <div class="d-flex">
                                                                <div class="form-group">
                                                                    {{-- <button type="submit" class="btn btn-outline-primary">Next</button> --}}
                                                                    {{-- <a href="{{ url('proposal/offeroptions') }}" class="btn btn-sm btn-outline-primary">Next</a> --}}
                                                                    @if ($proposal->status == 1 && $proposal->type == 0)
                                                                        <a class="btn btn-outline-primary jaya2" id="jaya2" href="#animatedModal2" role="button">Next</a>
                                                                    @endif
                                                                </div>

                                                                {{-- commmented save and preview buttons --}}



                                                            {{-- @if ($proposal->status == 1 && $proposal->type == 0) --}}
                                                                {{-- <div class="">
                                                                    @if ($customer_mob_no != null)
                                                                        <a href="https://api.whatsapp.com/send?phone=91{{ $customer_mob_no }}&text=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%20%0A{{ urlencode($offer_url) }}" target="_blank" class="btn btn-success mx-2">
                                                                            <i class="fab fa-whatsapp" class=""></i>
                                                                        </a>
                                                                    @else
                                                                        <a href="https://api.whatsapp.com/send?text=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%20%0A{{ urlencode($offer_url) }}" target="_blank" class="btn btn-success mx-2">
                                                                            <i class="fab fa-whatsapp" class=""></i>
                                                                        </a>
                                                                    @endif

                                                                    <a href="mailto:{{ $customer_email ?? "no-reply@121.page" }}?subject=121.Page%20offer&body=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%20%0A%20%20%0A{{ urlencode($offer_url) }}" target="_blank"  class="btn btn-primary">
                                                                        <i class="far fa-envelope"></i>
                                                                    </a>
                                                                </div> --}}
                                                            {{-- @endif --}}

                                                            {{--` Share Offer for Makeing Offer --}}

                                                            {{-- @if ($proposal->status == 1 && $proposal->type == 1) --}}
                                                                {{-- <div class="">
                                                                    @if ($customer_mob_no != null)
                                                                        <a href="https://api.whatsapp.com/send?phone=91{{ $customer_mob_no }}&text=Click%20on%20link%20below%20to%20access%20latest%20in-stock%20products.%0A%0AExport%20directly%20as%20pdf%20or%20ppt%20.%0A%20%20%0A{{ urlencode($offer_url) }}" target="_blank" class="btn btn-success mx-2">
                                                                            <i class="fab fa-whatsapp" class=""></i>
                                                                        </a>
                                                                    @else
                                                                        <a href="https://api.whatsapp.com/send?text=Click%20on%20link%20below%20to%20access%20latest%20in-stock%20products.%0A%0AExport%20directly%20as%20pdf%20or%20ppt%20.%0A%20%20%0A{{ urlencode($offer_url) }}" target="_blank" class="btn btn-success mx-2">
                                                                            <i class="fab fa-whatsapp" class=""></i>
                                                                        </a>
                                                                    @endif

                                                                    <a href="mailto:{{ $customer_email ?? "no-reply@121.page" }}?subject=121.Page%20offer&body=Click%20on%20link%20below%20to%20access%20latest%20in-stock%20products.%0A%0AExport%20directly%20as%20pdf%20or%20ppt%20.%0A%20%20%0A{{ urlencode($offer_url) }}" target="_blank"  class="btn btn-primary">
                                                                        <i class="far fa-envelope"></i>
                                                                    </a>
                                                                </div> --}}
                                                            {{-- @endif --}}

                                                        </div>

                                                        {{-- @if ($proposal->type == 1)
                                                            <button class="btn btn-outline-primary btn-sm copyLInk" type="button" data-link="{{ inject_subdomain('proposal/create', $slug_guest, false, false)}}?linked_offer={{$proposal->id}}&offer_type=2&shop={{$proposal->user_shop_id}}" >Copy LInk <i class="far fa-copy"></i> </button>
                                                        @endif

                                                        @if ($proposal->status == 1 && $proposal->type == 0)
                                                            <div class="">
                                                                <div class="form-group mx-2">
                                                                    @if(proposalCustomerDetailsExists($proposal->id))
                                                                        <a href="{{inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug) }}" class="ml-auto btn-link" target="_balnk" >Preview</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif --}}
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="row justify-content-between">
                                                    <div class="col-md-12 col-12 d-none">
                                                        <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                                            <label for="slug" class="control-label">Your proposal link<span
                                                                    class="text-danger">*</span> </label>
                                                            <input required class="form-control" name="slug" type="text"
                                                                id="slug" value="{{ $proposal->slug }}">
                                                        </div>
                                                    </div>

                                                        <div class="col-md-12 col-12">
                                                            <div class="row">
                                                            <div class="col-5">
                                                                <div class="form-group {{ $errors->has('customer_name') ? 'has-error' : '' }}">
                                                                    <label for="customer_name" class="control-label">
                                                                        @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to == null  )
                                                                            Buyer Name
                                                                        @else
                                                                            Offer By
                                                                        @endif
                                                                        <span
                                                                            class="text-danger">*</span> </label>
                                                                    <input required class="form-control" name="customer_name" type="text"
                                                                        id="customer_name" value="{{ $customer_name }}" list="mycustomer" autocomplete="off" required>

                                                                    <datalist id="mycustomer">
                                                                        @if ($my_resellers != null)
                                                                            @forelse ($my_resellers as $my_reseller)
                                                                                <option value="{{ App\User::whereId($my_reseller->user_id)->first()->name ." ,".UserShopNameByUserId($my_reseller->user_id) }}">{{ App\User::whereId($my_reseller->user_id)->first()->name ." ,".UserShopNameByUserId($my_reseller->user_id) }}</option>
                                                                            @empty

                                                                            @endforelse

                                                                        @endif
                                                                    </datalist>
                                                                </div>
                                                            </div>


                                                            {{-- original alias, phone and email --}}
                                                            <div class="col-5">
                                                                <div class="form-group {{ $errors->has('customer_alias') ? 'has-error' : '' }}">
                                                                    <label for="customer_alias" class="control-label">Alias (optional)</label>
                                                                    <input class="form-control" name="customer_alias" type="text" id="customer_alias" value="{{ $customer_alias }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>

                                                    <div class="col-md-12 col-6">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <div class="form-group {{ $errors->has('customer_mob_no') ? 'has-error' : '' }}">
                                                                    <label for="customer_mob_no" class="control-label">Phone</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-prepend" id="basic-addon2">
                                                                            <label class="input-group-text">+91</label>
                                                                        </span>
                                                                        <input class="form-control" name="customer_mob_no" type="number"
                                                                        id="customer_mob_no" value="{{ $customer_mob_no }}" placeholder="(Optional)">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-5">
                                                                <div class="form-group {{ $errors->has('customer_email') ? 'has-error' : '' }}">
                                                                    <label for="customer_email" class="control-label">Email</label>
                                                                    <div class="input-group">
                                                                        <input class="form-control" name="customer_email" type="email"
                                                                        id="customer_email" value="{{ $customer_email }}" placeholder="(Optional)">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if (isset($currency_record) && count($currency_record) != 0)
                                                                <div class="col-2">
                                                                    <div class="form-group {{ $errors->has('offer_currency') ? 'has-error' : '' }}">
                                                                        <label for="customer_mob_no" class="control-label">Currency</label>
                                                                        <div class="">
                                                                            {{-- <select name="offer_currency" id="offer_currency" class="form-control" readonly>
                                                                              @foreach ($currency_record as $item)
                                                                                <option value="{{ $item->currency }}" @if ($item->currency == ($proposal->offer_currency ?? session()->get('currency_name') ?? 'INR')) selected @endif>{{ $item->currency }}</option>
                                                                              @endforeach
                                                                            </select> --}}

                                                                            <input type="text" name="offer_currency" disabled class="form-control" value="{{ $proposal->offer_currency ?? session()->get('currency_name') ?? 'INR' }}">
                                                                          </div>
                                                                        {{-- <div class="input-group">

                                                                            <select name="offer_currency" id="offer_currency" class="form-group select2">
                                                                                @foreach ($currency_record as $item)
                                                                                <option value="{{ $item->currency }}" @if ($item->currency == ($proposal->offer_currency ?? 'INR')) selected @endif > {{ $item->currency }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div> --}}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    {{-- @if ($proposal->relate_to == $proposal->user_shop_id) --}}
                                                        <div class="col-md-12 col-12">
                                                            <div class="form-group">
                                                                <label for="proposal_note" class="control-label">Offer Notes</label>
                                                                <textarea  class="form-control" rows="7" name="proposal_note" id="proposal_note"
                                                                placeholder="Enter Offer Notes">{{ $proposal->proposal_note }}</textarea>
                                                            </div>
                                                            {{-- <div>
                                                                <input type="checkbox" id="enable_price_range" name="enable_price_range" value="1" @if($proposal->enable_price_range == 1 ) checked @endif>
                                                                <label for="enable_price_range d-none">Enable Price Range</label>
                                                            </div> --}}
                                                        </div>
                                                    {{-- @endif --}}


                                                    {{-- <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="pdf_view" class="form-label">PDF View</label>
                                                            <a class="btn btn-outline-primary" id="jaya1" href="#animatedModal1" role="button">Download PDF</a>
                                                        </div>
                                                    </div> --}}



                                                    @if ($proposal->relate_to == $proposal->user_shop_id)
                                                       <div class="row d-none">
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                        <label for="">Upload Client Logo</label>
                                                                        <input type='file' id="file-input"  name="client_logo_file" />
                                                                        @if($proposal->client_logo != null)
                                                                            <div id='img_contain'>
                                                                                <img class="image-preview" src="{{ asset($proposal->client_logo) }}" alt="" title=''/>
                                                                                <a class="btn btn-icon btn-primary cross-icon delete-item" href="{{ route('panel.proposals.remove-image',$proposal->id) }}"><i class="fa fa-times"></i></a>
                                                                            </div>
                                                                        @else
                                                                            <div id='img_contain'>
                                                                                <img class="image-preview" src="" alt="" title=''/>
                                                                            </div>
                                                                        @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card-body">
                                                                    <label for="file-input">Upload Visiting Card</label>
                                                                    <br>
                                                                    <input type='file' id="file-input" class="file-input-vs"  name="client_visiting_card" />
                                                                    @if($proposal->client_logo != null)
                                                                        <div id='img_contain'>
                                                                            <img class="image-preview-vs" src="{{ asset($proposal->visiting_card) ?? "" }}" alt="" title=''/>
                                                                            {{-- <a class="btn btn-icon btn-primary cross-icon delete-item" href="{{ route('panel.proposals.remove-image',$proposal->id) }}"><i class="fa fa-times"></i></a> --}}
                                                                        </div>
                                                                    @else
                                                                        <div id='img_contain'>
                                                                            <img class="image-preview-vs" src="" alt="" title=''/>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                       </div>
                                                    @endif





                                                </div> {{-- End Of ROw --}}

                                                {{-- download buttons --}}
                                                    {{-- <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between ">
                                                        <div class="col-6">
                                                            <div class="row mt-3" style="display: flex;
                                                            align-items: center;">
                                                                <p>Download PDF:</p>
                                                                <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between align-items-center flex-wrap gap-3 my-3" style="margin-left: 100px">
                                                                <button onclick="getPDF();" class="btn btn-outline-primary " type="button" style="position: relative; right: 5rem;"><i class="fa fa-download">Download</i></button>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3" style="display: flex;
                                                            align-items: center;">
                                                                <p >Download PPT:</p>
                                                                <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between align-items-center flex-wrap gap-3 my-3" style="margin-left: 100px">
                                                                <button onclick="getPPT()" type="button" class="btn btn-outline-info" style="position: relative; right: 5rem;"><i class="fa fa-download"></i>Download</button>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3" style="display: flex;
                                                            align-items: center;">
                                                                <p style= "mt-5 !important"> Export Excel:</p>
                                                                <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between align-items-center flex-wrap gap-3 my-3 " style="margin-left: 100px">
                                                                <button class="btn btn-outline-success" style="position: relative; right: 5rem;" id="export_button" type="button"><i class="fa fa-download"></i>Download</button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                    {{-- buttons --}}
                                                    {{-- <div class="col-md-8 ">
                                                    <div class="row d-flex justify-content-center justify-content-sm-between justify-content-md-between my-3">
                                                        <button class="btn btn-outline-primary"  id="" type="button">Link</button>
                                                        <button class="btn btn-outline-success"  id="" type="button">Copy</button>
                                                        <button class="btn btn-outline-warning"  id="" type="button">W</button>
                                                        <button class="btn btn-outline-info"  id="" type="button">E</button>
                                                    </div>
                                                </div> --}}



                                                    {{--<div class="row">
                                                        <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between align-items-center flex-wrap gap-3 my-3" style="margin-left: 100px">
                                                            <div class="col-6">
                                                                <div class="row mt-3">
                                                                    <button onclick="getPDF();" class="btn btn-outline-primary " type="button" style="position: relative; right: 5rem;"><i class="fa fa-download"></i> Download</button>
                                                                </div>
                                                                <div class="row mt-3">
                                                                <button onclick="getPPT()" type="button" class="btn btn-outline-info" style="position: relative; right: 5rem;"><i class="fa fa-download"></i> Download</button>
                                                                </div>
                                                                <div class="row mt-3">
                                                                <button class="btn btn-outline-success" style="position: relative; right: 5rem;" id="export_button" type="button"><i class="fa fa-download"></i> Download</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>--}}






                                                    {{-- original custom fields --}}
                                                    {{-- <div class="col-md-6 float-start"> --}}
                                                            {{-- <div class="form-group">
                                                                <label for="passcode" class="form-label">Enter Passcode <span class="text-danger" title="This details are kept private"><i class="uil-info-circle"></i></span> </label>
                                                                <input type="text" class="form-control" placeholder="0 0 0 0" name="password" id="passcode" maxlength="4" oninvalid="alert('Enter minimum 4 digit passcode')" value="{{ $offerPasscode ?? ""}}" required>
                                                            </div> --}}

                                                    {{-- <div class="h6">Fields to include <span class="text-danger" title="This details are kept private"><i class="uil-info-circle"></i></span> </div>
                                                    <select name="optionsforoffer[]" class="select2" multiple>
                                                        <option value="description" @if (json_decode($proposal->options)->show_Description ?? 0) selected @endif>Description</option>

                                                        @if ($proposal->relate_to == $proposal->user_shop_id)
                                                            <option value="notes" @if (json_decode($proposal->options)->Show_notes ?? 0) selected @endif>Notes</option>
                                                        @endif

                                                        @foreach ($aval_atrribute as $item)
                                                            <option value="{{ $item }}"
                                                            @if ($proposal->options != null && isset(json_decode($proposal->options)->show_Attrbute))
                                                                @if (in_array($item,((array) json_decode($proposal->options)->show_Attrbute) ?? ['']))
                                                                    selected
                                                                @endif
                                                            @endif
                                                            >{{ getAttruibuteById($item)->name ?? '' }}</option>
                                                        @endforeach
                                                    </select>


                                                    @if ($proposal->relate_to == $proposal->user_shop_id)
                                                        <div class="form-group my-3">
                                                            <label class="form-label" for="valid_upto"> Offer Valid Upto </label>
                                                            <input class="form-control" type="date" id="valid_upto" name="valid_upto" value="{{ $proposal->valid_upto }}">
                                                        </div>
                                                    @endif


                                                    @if ($proposal->relate_to == $proposal->user_shop_id)
                                                        <div class="form-group my-3 d-none">
                                                            <label class="form-label" for="sample_charge"> Sample %age increase </label>
                                                            <input class="form-control" type="number" min="0" max="100" id="sample_charge" name="sample_charge" value="{{ $sample_charge }}" placeholder="% Increase">
                                                        </div>
                                                        <div class="form-group my-3">
                                                            <label class="form-label" for="sample_charge"> Weekly Update </label> --}}
                                                            {{-- <select name="offer_type" class="form-select form-control" id="offer_type">
                                                                <option value="0" @if ($proposal->type == 0) selected @endif>No</option>
                                                                <option value="1" @if ($proposal->type == 1) selected @endif>Yes</option>
                                                            </select> --}}
                                                            {{-- <br>
                                                            <input type="checkbox" name="offer_type"  value="1" @if ($proposal->type == 1) checked @endif id="weekupdate">

                                                        </div>
                                                    @endif
                                                </div> --}}



                                                <div class="col-md-12 ">
                                                    <div class="d-flex justify-content-between mt-5">
                                                        <div class="">
                                                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary">Back</a>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-outline-primary">Save</button>
                                                        </div>
                                                        <div class="d-flex">
                                                        <div class="form-group">
                                                            {{-- <button type="submit" class="btn btn-outline-primary">Next</button> --}}
                                                                @if ($proposal->status == 1 && $proposal->type == 0)
                                                                    <a class="btn btn-outline-primary jaya2" id="jaya2" href="#animatedModal2" role="button">Next</a>
                                                                @endif
                                                        </div>

                                                                {{-- commented save and preview buttons --}}

                                                                {{-- @if ($proposal->status == 1 && $proposal->type == 0) --}}
                                                                    {{-- <div class="">
                                                                        @if ($customer_mob_no != null)
                                                                            <a href="https://api.whatsapp.com/send?phone=91{{ $customer_mob_no }}&text=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%20%0A{{ urlencode($offer_url) }}" target="_blank" class="btn btn-success mx-2">
                                                                                <i class="fab fa-whatsapp" class=""></i>
                                                                            </a>
                                                                        @else
                                                                            <a href="https://api.whatsapp.com/send?text=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%20%0A{{ urlencode($offer_url) }}" target="_blank" class="btn btn-success mx-2">
                                                                                <i class="fab fa-whatsapp" class=""></i>
                                                                            </a>
                                                                        @endif

                                                                        <a href="mailto:{{ $customer_email ?? "no-reply@121.page" }}?subject=121.Page%20offer&body=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%20%0A%20%20%0A{{ urlencode($offer_url) }}" target="_blank"  class="btn btn-primary">
                                                                            <i class="far fa-envelope"></i>
                                                                        </a>
                                                                    </div> --}}
                                                                    {{-- @endif          --}}
                                                                    {{-- @if ($proposal->status == 1 && $proposal->type == 1) --}}
                                                                        {{-- <div class="">
                                                                            @if ($customer_mob_no != null)
                                                                                <a href="https://api.whatsapp.com/send?phone=91{{ $customer_mob_no }}&text=Click%20on%20link%20below%20to%20access%20latest%20in-stock%20products.%0A%0AExport%20directly%20as%20pdf%20or%20ppt%20.%0A%20%20%0A{{ urlencode($offer_url) }}" target="_blank" class="btn btn-success mx-2">
                                                                                    <i class="fab fa-whatsapp" class=""></i>
                                                                                </a>
                                                                            @else
                                                                                <a href="https://api.whatsapp.com/send?text=Click%20on%20link%20below%20to%20access%20latest%20in-stock%20products.%0A%0AExport%20directly%20as%20pdf%20or%20ppt%20.%0A%20%20%0A{{ urlencode($offer_url) }}" target="_blank" class="btn btn-success mx-2">
                                                                                    <i class="fab fa-whatsapp" class=""></i>
                                                                                </a>
                                                                            @endif

                                                                            <a href="mailto:{{ $customer_email ?? "no-reply@121.page" }}?subject=121.Page%20offer&body=Click%20on%20link%20below%20to%20access%20latest%20in-stock%20products.%0A%0AExport%20directly%20as%20pdf%20or%20ppt%20.%0A%20%20%0A{{ urlencode($offer_url) }}" target="_blank"  class="btn btn-primary">
                                                                                <i class="far fa-envelope"></i>
                                                                            </a>
                                                                        </div> --}}
                                                                    {{-- @endif
                                                            </div> --}}


                                                            {{-- @if ($proposal->type == 1)
                                                                <button class="btn btn-outline-primary btn-sm copyLInk" type="button" data-link="{{ inject_subdomain('proposal/create', $slug_guest, false, false)}}?linked_offer={{$proposal->id}}&offer_type=2&shop={{$proposal->user_shop_id}}" >Copy LInk <i class="far fa-copy"></i> </button>
                                                            @endif   --}}


                                                        {{-- @if ($proposal->status == 1 && $proposal->type == 0)
                                                            <div class="">
                                                                <div class="form-group mx-2">
                                                                    @if(proposalCustomerDetailsExists($proposal->id))
                                                                        <a href="{{inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug) }}" class="ml-auto btn-link" target="_balnk" >Preview</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ajax-loading" style="display:none;background-color: green; color: white; position: fixed; bottom: 50px; right: 25px;padding: 10px; font-weight: 700; border-radius: 35px;">
        Please Wait...
    </div>
    @include('frontend.micro-site.proposals.modal.updateprice')

    {{-- @include('frontend.micro-site.proposals.modal.change_style') --}}

    @if (request()->has('type') && request()->get('type') == 'send' && $proposal->status == 1 && $proposal->type == 0)
        @include('frontend.micro-site.proposals.offeroptions')
    @endif








    <!-- push external js -->
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script>
            $(document).ready(function () {

                $("#magrintochnage").change(function (e) {
                    e.preventDefault();
                    $("#range_bar").html($(this).val());
                });

                    // Single swithces
                    var acr_btn = document.querySelector('#weekupdate');
                    var switchery = new Switchery(acr_btn, {
                        color: '#6666CC',
                        jackColor: '#fff'
                    });



                    // Copy Text To Clipboard
                    function copyTextToClipboard(text) {
                            if (!navigator.clipboard) {
                                fallbackCopyTextToClipboard(text);
                                return;
                            }
                            navigator.clipboard.writeText(text).then(function() {
                            }, function(err) {
                            });
                            $.toast({
                                heading: 'SUCCESS',
                                text: "Offer link copied.",
                                showHideTransition: 'slide',
                                icon: 'success',
                                loaderBg: '#f96868',
                                position: 'top-right'
                            });
                    }

                    $(".copyLInk").click(function (e) {
                        e.preventDefault();
                        var link = $(this).data('link');
                        copyTextToClipboard(link);
                    });

            });
        </script>

        <script>

            var hike = $('#hike').val();

            function updateURLParam(key,val){
                var url = window.location.href;
                var reExp = new RegExp("[\?|\&]"+key + "=[0-9a-zA-Z\_\+\-\|\.\,\;]*");

                if(reExp.test(url)) {
                    // update
                    var reExp = new RegExp("[\?&]" + key + "=([^&#]*)");
                    var delimiter = reExp.exec(url)[0].charAt(0);
                    url = url.replace(reExp, delimiter + key + "=" + val);
                } else {
                    // add
                    var newParam = key + "=" + val;
                    if(!url.indexOf('?')){url += '?';}

                    if(url.indexOf('#') > -1){
                        var urlparts = url.split('#');
                        url = urlparts[0] +  "&" + newParam +  (urlparts[1] ?  "#" +urlparts[1] : '');
                    }else if(url.indexOf('&') > -1 || url.indexOf('?') > -1){
                        url += "&" + newParam;
                    } else {
                        url += "?" + newParam;
                    }
                }
                window.history.pushState(null, document.title, url);
                return url;
                    // window.history.pushState(null, document.title, url);
            }
            var checkUrlParameter = function checkUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return true;
                    }
                }
                return false;
            };



            $('#hikebtn').click(function() {
                hike = $("#magrintochnage").val();
                var route = "{{ route('pages.proposals.updatemargin') }}";
                    $.ajax({
                        url: route,
                        method: "get",
                        data: {
                            'proposal_id': {{ $proposal->id }},
                            'hike': hike,
                        },
                        success: function(res){
                            console.log(res);
                            location.reload();
                    }
                });
            });

            $('.input-check').click(function(){

                if($(this).prop('checked')){
                    var route = "{{ route('panel.proposal_items.api.store') }}"+"?product_id="+$(this).val()+'&proposal_id='+"{{ $proposal->id }}"+"&hike="+hike;
                    $.ajax({
                        url: route,
                        method: "get",
                        success: function(res){

                        }
                    });
                }else{
                    var route = "{{ route('panel.proposal_items.api.remove') }}"+"?product_id="+$(this).val()+'&proposal_id='+"{{ $proposal->id }}";
                    $.ajax({
                        url: route,
                        method: "get",
                        success: function(res){

                        }
                    });
                }
            });

            // Add Product To Pin

            $('.input-checkpin').click(function(){

                if($(this).prop('checked')){
                    var  id = $(this).val();
                    // var img = ;?
                    var route = "{{ route('panel.proposal_items.api.addpin') }}"+"?product_id="+$(this).val()+'&proposal_id='+"{{ $proposal->id }}"+"&hike="+hike;
                    $.ajax({
                        url: route,
                        method: "get",
                        success: function(res){
                            console.log(res);
                            $("img."+id).attr('src', "{{ asset('frontend/assets/svg/bookmark_added.svg')}}");
                        }
                    });

                }else{
                    $("img."+id).attr('src', "{{ asset('frontend/assets/svg/bookmark.svg')}}");
                    var route = "{{ route('panel.proposal_items.api.removepin') }}"+"?product_id="+$(this).val()+'&proposal_id='+"{{ $proposal->id }}";
                    $.ajax({
                        url: route,
                        method: "get",
                        success: function(res){
                            console.log(res);
                            $("img."+id).attr('src', "{{ asset('frontend/assets/svg/bookmark.svg')}}");
                        }
                    });
                }
            });




            $('#ProposalForm').validate();
                $('#category_id').change(function(){
                var id = $(this).val();
                if(id){
                    $.ajax({
                        url: "{{route('panel.user_shop_items.get-category')}}",
                        method: "get",
                        datatype: "html",
                        data: {
                            id:id
                        },
                        success: function(res){
                            $('#sub_category_id').html(res);
                        }
                    })
                }
            })
            $(document).ready(function() {
                    $('#suppliers').select2({
                        placeholder : "All Suppliers",
                    });
                    $('#brands').select2({
                        placeholder : "All Brands",
                    });
                    $('#size').select2({
                        placeholder : "All Size",
                    });
                    $('#color').select2({
                        placeholder : "All Color",
                    });
                    $("#materials").select2({
                        placeholder: "All Materials"
                    })
                var table = $('.table').DataTable({
                    responsive: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    scrollX: false,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': ['nosort']
                    }],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [

                    ]

                });
            });

            $(document).on('click','.nav-link',function(e){
                var type =  $(this).data('type');
                var url = "";
                if(checkUrlParameter('type')){
                    url = updateURLParam('type',type);
                }else{
                    url =  updateURLParam('type',type);
                }
                window.location.href = url;
            });
            $(document).on('click','.add-item',function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                var msg = $(this).data('msg') ?? "You won't be able to revert back!";
                $.confirm({
                    draggable: true,
                    title: 'Are You Sure!',
                    content: msg,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Add',
                            btnClass: 'btn-success',
                            action: function(){
                                    window.location.href = url;
                            }
                        },
                        close: function () {
                        }
                    }
                });
            });
            $(document).on('click','.click-send',function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                var msg = $(this).data('msg') ?? "Send sms to check the proposal !";
                $.confirm({
                    draggable: true,
                    title: 'Send sms to check the proposal!',
                    content: msg,
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Confirm',
                            btnClass: 'btn-blue',
                            action: function(){
                                    window.location.href = url;
                            }
                        },
                        close: function () {
                        }
                    }
                });
            });
            $(document).on('click','.remove-item',function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                // var msg = $(this).data('msg') ?? "You won't be able to revert back!";
                $.confirm({
                    draggable: true,
                    title: 'Remove from offer ?',
                    content: '',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Yes',
                            btnClass: 'btn-red',
                            action: function(){
                                    window.location.href = url;
                            }
                        },
                        close: function () {
                            test: "Cancel"
                        }
                    }
                });
            });

            $('.filterable-btn').on('click',function(){
                // Get the current URLSearchParams object
                const urlParams = new URLSearchParams(window.location.search);

                // Set the new parameter and its value
                const newParamName = 'category_id';
                const newParamValue = $(this).data('cid');

                // Check if the new parameter already exists in the URL
                if (urlParams.has(newParamName)) {
                // Check if the current value is different from the new value
                if (urlParams.get(newParamName) !== newParamValue) {
                    // Update the value of the existing parameter
                    urlParams.set(newParamName, newParamValue);

                    // Replace the current URL with the modified URL
                    const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
                    window.history.replaceState({}, '', newUrl);

                    // Refresh the page
                    window.location.reload();
                }
                } else {
                // Add a new parameter to the existing parameters
                urlParams.append(newParamName, newParamValue);

                // Replace the current URL with the modified URL
                const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
                window.history.replaceState({}, '', newUrl);

                // Refresh the page
                window.location.reload();
                }


                // var cid = $(this).data('cid');
                // if(cid == 0){
                //     $(".filterable-btn").removeClass('btn-info');
                //     $(this).addClass('btn-info')
                //     $('.filterable-items').removeClass('d-none');
                // }else{
                //     $('.filterable-items').addClass('d-none');
                //     $(".filterable-btn").removeClass('btn-info');
                //     $(this).addClass('btn-info')
                //     $('.cid-'+cid).removeClass('d-none');
                // }
            });
            $('#my_product').on('click',function(){
                if ($(this).is(':checked')) {
                    $('#all_supplier_brand').addClass('d-none');
                } else {
                    $('#all_supplier_brand').removeClass('d-none');
                }
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                    $('.image-preview').attr('src', e.target.result);
                    $('.image-preview').hide();
                    $('.image-preview').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#file-input").change(function() {
                readURL(this,'.image-preview');
            });

            function readURLVS(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                    $('.image-preview-vs').attr('src', e.target.result);
                    $('.image-preview-vs').hide();
                    $('.image-preview-vs').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }


            $(".file-input-vs").change(function() {
                readURLVS(this,);
            });


            $(".edit-price").click(function() {
                var product_id =$(this).data('product');
                $('.productId').val(product_id);
                let remark = $(this).data('remark');
                $("#remarks_offer").val(remark);
                $('#pickedProductEdit').modal('show');

            });

            @if(request()->get('my_product') == 1)
                setTimeout(() => {
                $('#my_product').trigger('click');
                }, 500);
            @endif


                $('#select-all').click(function(){
                    $(document).find('#ajax-loading').show();
                    var interval = 10;
                    if($('.input-check').is(':checked')){
                        $('.input-check').prop('checked',false).change();
                    }else{
                        $('.filterable-items').each(function(){
                            if(!$(this).hasClass('d-none')){
                                setTimeout(() => {
                                    $(this).find('.input-check').trigger('click');
                                }, interval);
                                interval += 150;
                            }

                            setTimeout(() => {
                                $(document).find('#ajax-loading').hide();
                            }, 9000);
                        });
                    }


                });
                $('.unSelectAll').click(function(){
                    var interval = 10;
                    if($('.input-check').is(':checked')){
                        $('.input-check').prop('checked',false).change();
                    }else{
                        $('.filterable-items').each(function(){
                            if(!$(this).hasClass('d-none')){
                                setTimeout(() => {
                                    $(this).find('.input-check').trigger('click');
                                }, interval);
                                interval += 150;
                            }
                        });
                    }
                });

                // Update Sequence
                $(function () {

                    $( "#sortable" ).sortable({
                        items: "div.card-drag",
                        cursor: 'move',
                        opacity: 0.6,
                        update: function() {
                            sendOrderToServer();
                        }
                    });

                    function sendOrderToServer() {
                    var order = [];
                    $('div.card-drag').each(function(index,element) {
                        order.push({
                            id: $(this).attr('data-id'),
                            position: index + 1
                        });
                    });
                    console.log(order);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        // url: "{{ url('pages/update/sequence') }}"+'/'+"{{$proposal->id}}",
                        url: "{{ route('pages.proposals.updateSequence',$proposal->id) }}",
                        data: {
                        order:order,
                        _token: '{{csrf_token()}}'
                        },
                        success: function(response) {
                            if (response.status == "success") {
                            console.log(response);
                            } else {
                            console.log(response);
                            }
                        }
                    });
                    }
                });

                $('#validateMargin').on('click', function(e){
                    if($('#hike').val() > 99){

                        $('#hike').val(99);

                        $.toast({
                            heading: 'ERROR',
                            text: "Margin must be less than 100",
                            showHideTransition: 'slide',
                            icon: 'error',
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        });

                        e.preventDefault();

                    }
                });


                // custom Loder

                window.addEventListener('load', () =>{
                    const cloader = $(".cloader")
                    cloader.addClass('loader-hidden');
                })

        </script>




    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>


    <script>
        $(".jaya2").animatedModal({
             animatedIn: 'lightSpeedIn',
             animatedOut: 'lightSpeedOut',
             color: 'FFFFFF',
             height: '60%',
             width: '50%',
             top: '10%',
             left: '52%',

         });

        </script>

@endpush

@endsection
