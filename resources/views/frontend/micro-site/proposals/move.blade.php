@extends('backend.layouts.main')
@section('title', '2. Customisation / Notes for Buyer Offer')
@section('content')
    @php

        $breadcrumb_arr = [['name' => 'Edit Proposal', 'url' => 'javascript:void(0);', 'class' => '']];
        $user = auth()->user();
        $proposal_options = json_decode($proposal->options);
        $slug_guest = getShopDataByUserId(155)->slug;
        $offer_url = inject_subdomain("shop/proposal/$proposal->slug", $slug_guest);

        $make_offer_link = inject_subdomain('proposal/create', $slug_guest, false, false) . '?linked_offer=' . $proposal->id . '&offer_type=2&shop=' . $proposal->user_shop_id;

        if ($proposal->type == 1) {
            $offer_url = $make_offer_link;
        }
    @endphp
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
        <style>
            .main-content {
                padding: 0 !important;
            }

            .error {
                color: red;
            }

            #file-input {
                padding: 10px;
                background-color: #6666CC;
                color: #fff;
            }

            .image-preview,
            .image-preview-vs {
                height: 120px;
                width: auto;
                display: block;
                padding: 5px;
                margin-top: 10px;
            }

            .cursor-pointer {
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

            .card-body::-webkit-scrollbar {
                width: 4px
            }

            .card-body::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            .card-body::-webkit-scrollbar-thumb {
                background: #6666CC;
                border-radius: 5px;
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

            .prdct-pinned input {
                visibility: hidden;
            }

            #checkmarkpin {
                position: absolute;
                top: 10px;
                left: 0;
                height: 30px;
                width: 30px;
                border-radius: 3px;
                background-color: transparent !important;
            }

            #checkmarkpin img {
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


            .appendlogo {
                height: 70px;
                object-fit: contain;
                position: absolute;
                top: 87px;
                left: 94px;
                border-radius: 0;
            }

            @media (max-width: 767px) {
                .cust-display {
                    display: block;
                }
            }

            .hdsjfibdsjk {
                display: none;
            }

            @media (max-width: 575px) {
                .hdsjfibdsjk {
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
            .fa-lg {
                line-height: 1em !important;
            }

            #btn-close-modal2 {
                width: 80%;
                text-align: center;
                cursor: pointer;
                color: #fff;
                left: 60%
            }

            #animatedModal2 {
                overflow-y: hidden !important;
                overflow-x: hidden !important;

            }

            .header-top {
                display: block !important;
                padding-left: 0px !important;



            }


            @media (min-width: 768px) and (max-width: 991.98px) {
                #animatedModal2 {
                    position: fixed !important;
                    height: 45% !important;
                    width: 80% !important;
                    top: 15% !important;
                    left: 20% !important;
                    /* background-color: transparent !important;  */
                }
            }
        </style>
        @if (auth()->id() != 155)
            <style>
                .header-top {
                    display: block !important;
                    padding-left: 0px !important;
                }

                #back,
                #navbar-fullscreen {
                    display: none !important;
                }

                .main-content {
                    padding: 0 !important;
                }
            </style>

            <style>
                .icon-container1 {
                    display: none;
                }

                #oneljmls:hover .icon-container1 {
                    display: flex;
                    color: #6666cc;
                    margin-right: 2.5rem;
                }

                #twojjlw:hover .icon-container1 {
                    display: flex;
                    color: #6666cc;
                    margin-right: 4rem;
                }

                #threelljlkn:hover .icon-container1 {
                    display: flex;
                    color: #6666cc;
                    margin-right: 4rem;
                }

                #fourmmb:hover .icon-container1 {
                    display: flex;
                    color: #6666cc;
                    margin-right: 2.5rem;
                }


                #fivelja:hover .icon-container1 {
                    display: flex;
                    color: #6666cc;
                    margin-right: 4rem;
                }

                #sixkhik:hover .icon-container1 {
                    display: flex;
                    color: #6666cc;
                    margin-right: 4rem;
                }

                .btn-link.active {
                    border-bottom: 2px solid #6666cc;
                    border-bottom-left-radius: 0;
                    border-bottom-right-radius: 0;
                }
            </style>
        @endif

    @endpush
    @php
        $customer_details = json_decode($proposal->customer_details) ?? '';
        $customer_name = $customer_details->customer_name ?? '';
        $offer_name = $customer_details->offer_name ?? '';

        if ($customer_name == auth()->user()->name) {
            $customer_name = '';
        }

        $customer_mob_no = $customer_details->customer_mob_no ?? '';
        $customer_email = $customer_details->customer_email ?? '';
        $customer_alias = $customer_details->customer_alias ?? '';
        $person_name = $customer_details->person_name ?? '';
        $sample_charge = json_decode($proposal->customer_details)->sample_charge ?? '';
        $user_shop_record = App\Models\UserShop::whereId($proposal->user_shop_id)->first();
        $user_key = encrypt(auth()->id());
        $slug = $user_shop_record->slug;

    @endphp

    <div class="container-fluid" style="overflow:hidden;">
        <div class="row  d-flex align-items-center  justify-content-center  ">
            <div class="col-md-10">
                <!-- start message area-->
                @include('backend.include.message')

                <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-center"
                        style="position: fixed;left:0%;z-index: 88;padding: 0 0 25px 0 !important;background-color: #fff;">
                        <a href="{{ inject_subdomain('proposal/edit/' . $proposal->id . '/' . $user_key, $slug, false, false) }}?margin={{ $proposal->margin ?? 10 }}"
                            class="btn btn-link text-primary mx-2">1. Selection</a>
                        <a href="#one" class="btn btn-link text-primary mx-2 active ">2. Notes</a>
                        <a href="{{ inject_subdomain('proposal/export/' . $proposal->id . '/' . $user_key, $slug, false, false) }}"
                            class="btn btn-link text-primary mx-2">3. Generate</a>
                    </div>
                    Filters
                    <div class="col-md-12 col-lg-12 mt-4">

                        <div class="card">
                            <div class="card-header">
                                @if (request()->get('type') == 'search')
                                    <h6>Filter Products</h6>
                                @elseif(request()->get('type') == 'markup')
                                    <h6>Choose & Markup Products</h6>
                                @elseif(request()->get('type') == 'picked')
                                    <h6>Picked Products</h6>
                                @else
                                    <h6>Send Products</h6>
                                @endif
                                <div class="ml-2 badge badge-{{ getProposalStatus($proposal->status)['color'] }}">
                                    {{ getProposalStatus($proposal->status)['name'] }}</div>
                            </div>


                            <form action="{{ route('pages.proposal.update', $proposal->id) }}" method="post"
                                enctype="multipart/form-data" id="ProposalForm" class="row">
                                @csrf


                                <input type="hidden" name="user_id" value="{{ decrypt($user_key) }}">
                                <input type="hidden" name="user_shop_id"
                                    value="{{ getShopDataByUserId(decrypt($user_key))->id }}">
                                    <div class="row" style="padding-left: 25px;">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="offer_name" class="control-label">Offer Name <span class="text-danger">*</span></label>
                                                <input class="form-control" name="offer_name" type="text" id="offer_name" value="{{ $offer_name }}" autocomplete="off" >
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group {{ $errors->has('customer_name') ? 'has-error' : '' }}">
                                                <label for="customer_name" class="control-label">Buyer Entity <span class="text-danger">*</span></label>
                                                <input required class="form-control" name="customer_name" type="text" id="customer_name" value="{{ $customer_name }}" list="mycustomer" autocomplete="off" required>
                                                <datalist id="mycustomer">
                                                    @if ($my_resellers != null)
                                                        @forelse ($my_resellers as $my_reseller)
                                                            <option value="{{ App\User::whereId($my_reseller->user_id)->first()->name . ' ,' . UserShopNameByUserId($my_reseller->user_id) }}">
                                                                {{ App\User::whereId($my_reseller->user_id)->first()->name . ' ,' . UserShopNameByUserId($my_reseller->user_id) }}
                                                            </option>
                                                        @empty
                                                        @endforelse
                                                    @endif
                                                </datalist>
                                            </div>
                                            {{-- <div class="form-group">
                                                <label for="buyer_entity" class="control-label" style="background-color: #ff0c0c">Buyer Entity <span class="text-danger">*</span></label>
                                                <input required class="form-control" name="buyer_entity" type="text" id="buyer_entity" value="" autocomplete="off" >
                                            </div> --}}
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group {{ $errors->has('customer_alias') ? 'has-error' : '' }}">
                                                <label for="customer_alias" class="control-label">Alias (optional)</label>
                                                <input class="form-control" name="customer_alias" type="text" placeholder="Alias" id="customer_alias" value="{{ $customer_alias }}">
                                            </div>
                                        </div>
                                    </div>



                                <div class="accordion w-100" id="proposalAccordion">
                                    <div class="cardd">
                                        <div class="card-header" id="proposalHeading" style="padding-top:0px !important;">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link text-primary " type="button"
                                                    data-toggle="collapse" data-target="#proposalCollapse"
                                                    aria-expanded="true" aria-controls="proposalCollapse">
                                                    {{-- Proposal Details --}}
                                                    More...
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="proposalCollapse" class="collapse" aria-labelledby="proposalHeading"
                                            data-parent="#proposalAccordion">
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="row justify-content-between">
                                                        <div class="col-md-12 col-12 d-none">
                                                            <div
                                                                class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                                                <label for="slug" class="control-label">Your proposal
                                                                    link<span class="text-danger">*</span> </label>
                                                                <input required class="form-control" name="slug"
                                                                    type="text" id="slug"
                                                                    value="{{ $proposal->slug }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-12">
                                                            <div class="row">
                                                                {{-- Person Name --}}
                                                                <div class="col-12 col-md-6 col-lg-4">
                                                                    <div
                                                                        class="form-group {{ $errors->has('person_name') ? 'has-error' : '' }}">
                                                                        <label for="person_name"
                                                                            class="control-label">Person Name</label>
                                                                        <input class="form-control" name="person_name"
                                                                            type="text" id="person_name"
                                                                            value="{{ $person_name }}"
                                                                            placeholder="Enter Person Name">
                                                                    </div>
                                                                </div>
                                                                {{-- original, phone and email --}}
                                                                <div class="col-12 col-md-6 col-lg-4">
                                                                    <div
                                                                        class="form-group {{ $errors->has('customer_mob_no') ? 'has-error' : '' }}">
                                                                        <label for="customer_mob_no"
                                                                            class="control-label">Phone</label>
                                                                        <div class="input-group">
                                                                            <input class="form-control"
                                                                                name="customer_mob_no" type="number"
                                                                                id="customer_mob_no"
                                                                                value="{{ $customer_mob_no }}"
                                                                                placeholder="(Optional)">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-6 col-lg-4">
                                                                    <div
                                                                        class="form-group {{ $errors->has('customer_email') ? 'has-error' : '' }}">
                                                                        <label for="customer_email"
                                                                            class="control-label">Email</label>
                                                                        <div class="input-group">
                                                                            <input class="form-control"
                                                                                name="customer_email" type="email"
                                                                                id="customer_email"
                                                                                value="{{ $customer_email }}"
                                                                                placeholder="(Optional)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> {{-- End Of Row --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade @if (request()->get('type') == 'picked') show active @endif"
                                            id="product-tab" role="tabpanel" aria-labelledby="pills-products-tab">
                                            <div class="row mt-3" id="sortable">
                                                @if ($added_products->count() > 0)
                                                    @foreach ($added_products as $proposal_item)
                                                        @php
                                                            $product = fetchFirst('App\Models\Product', $proposal_item->product_id);
                                                            $brand_id = getBrandRecordByProductId($proposal_item->product_id)->id ?? '--';
                                                            if ($product != null) {
                                                                $product_record =
                                                                    App\Models\UserShopItem::whereProductId($product->id)
                                                                        ->whereUserId(auth()->id())
                                                                        ->first() ?? null;
                                                            } else {
                                                                $product_record = null;
                                                            }
                                                            if ($product_record) {
                                                                $proposal_item_record = App\Models\ProposalItem::where('proposal_id', $proposal->id)
                                                                    ->whereProductId($product->id)
                                                                    ->whereUserShopItemId($product_record->id)
                                                                    ->first();
                                                            } else {
                                                                $proposal_item_record = null;
                                                            }
                                                        @endphp
                                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 card-drag justify-content-center   d-flex align-items-center "
                                                            data-id="{{ $proposal_item->id }}">
                                                            <div class="card d-flex align-items-center  "
                                                                style="width: max-content;padding: 10px">
                                                                <div class="d-none d-md-block d-sm-none">
                                                                    <img src="{{ asset('backend/img/move.png') }}"
                                                                        alt="" height="20px"
                                                                        style="margin-top: 15px;margin-left: 15px;position: absolute;top: 0;left: 0;">
                                                                </div>
                                                                <img src="{{ isset($product) && getShopProductImage($product->id, 'single') != null ? asset(getShopProductImage($product->id, 'single')->path) : asset('frontend/assets/img/placeholder.png') }}"
                                                                    alt="" class="custom-img"
                                                                    style="height:185px;object-fit: contain;width: 185px">

                                                                <div
                                                                    style="position: absolute;right: -2%; top: 2%;z-index: 1;">
                                                                    <a href="{{ route('pages.proposals.destroy', $proposal_item->id) }}"
                                                                        class="btn remove-item mr-2">
                                                                        <i class="fas fa-trash"
                                                                            style="color: #ff0c0c;font-size: 3vh"></i>
                                                                    </a>

                                                                </div>
                                                                <div class="card-body text-center"
                                                                    style="overflow: hidden;overflow-y: auto;height: 200px;;">
                                                                    <div class="profile-pic">
                                                                        <div class="row">
                                                                            <div class="col-md-12 pt-2 text-center p-0"
                                                                                style="margin-top: -15px;">



                                                                            {{-- @if ($item->vault_type === 'asset')

                                                                                {{ $item->vault_name }} <br>
                                                                                Vault Name: {{ $item->vault_name }} <br>
                                                                                File Name: {{ $item->file_name }}
                                                                            @else --}}

                                                                                <span title="{{ $product->title }}"
                                                                                    class="mb-0 ">{{ Str::limit($product->title, 30, '...') ?? '--' }}</span>

                                                                                <br>

                                                                                {{-- @if (isset($product->category_id) || isset($product->sub_category))
                                                                                <span>{{fetchFirst('App\Models\Category',$product->sub_category,'name','--')}}</span> <br>
                                                                                @endif --}}
                                                                                @if (isset(getBrandRecordByProductId($proposal_item->product_id)->name))
                                                                                    <span>Brand:
                                                                                        {{ getBrandRecordByProductId($proposal_item->product_id)->name ?? '--' }}</span>
                                                                                    <br>
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
                                                                                <span>Model Code:
                                                                                    {{ $product->model_code ?? '' }}</span>
                                                                                <br>
                                                                                @php
                                                                                    $catelogue_author = @App\User::whereId($product->user_id)->first();
                                                                                    $group_id =
                                                                                        @App\Models\AccessCatalogueRequest::whereNumber($catelogue_author->phone)
                                                                                            ->latest()
                                                                                            ->first()->price_group_id ?? 0;
                                                                                    $price = $product->price ?? 0;
                                                                                    if ($group_id && $group_id != 0) {
                                                                                        $price = getPriceByGroupIdProductId($group_id, $product->id, $price);
                                                                                    }

                                                                                    $record = App\Models\UserCurrency::where('currency', $product->base_currency ?? 'INR')
                                                                                        ->where('user_id', $product->user_id ?? 0)
                                                                                        ->first();
                                                                                    $exhangerate = Session::get('Currency_exchange') ?? 1;
                                                                                    $HomeCurrency = $record->exchange ?? 1;
                                                                                    $currency_symbol = Session::get('currency_name') ?? 'INR';
                                                                                    $price = exchangerate($price, $exhangerate, $HomeCurrency);
                                                                                @endphp
                                                                                Product Price:
                                                                                <span>
                                                                                    {{ $currency_symbol }}
                                                                                    {{ isset($price) ? number_format($price, 2) : '' }}
                                                                                </span>
                                                                                <br>
                                                                                {{-- Shop Price:<span> {{ (isset($product_record) && $product_record->price > 0) ?  format_price($product_record->price) : 'Ask for Price' }}</span> --}}
                                                                                {{-- <br> --}}
                                                                                @php
                                                                                    $proposal_item->margin = $proposal_item->margin ?? 0;
                                                                                    if ($proposal_item->user_price == null) {
                                                                                        $price = $proposal_item->price;
                                                                                        if ($proposal_item->margin < 100) {
                                                                                            $margin = $proposal_item->margin / 100;
                                                                                            $margin_factor = (100 - $proposal_item->margin) / 100;
                                                                                            $price = $price / $margin_factor;
                                                                                        }
                                                                                        $margin = 'Margin Added: ' . $proposal_item->margin . '%';
                                                                                        $userPrice = null;
                                                                                    } else {
                                                                                        $price = $proposal_item->user_price;
                                                                                        $userPrice = $proposal_item->user_price;
                                                                                        $margin = 'Custom Price';
                                                                                    }
                                                                                    $price = exchangerate($price, $exhangerate, $HomeCurrency);
                                                                                    // $user = session()->get('temp_user_id') ?? session()->get('user_id');
                                                                                    $user = auth()->id() ?? (session()->get('user_id') ?? session()->get('temp_user_id'));
                                                                                    $ashus = json_decode($proposal_item->note);
                                                                                @endphp

                                                                                {{-- @if ($proposal->user_id == $user) --}}
                                                                                {{-- <span>Offer Price: {{ format_price($price) }}</span> --}}
                                                                                <hr
                                                                                    class="bg-primary border border-primary ">
                                                                                <span>Offer Price:
                                                                                    {{ $currency_symbol }}
                                                                                    @if ($userPrice != null)
                                                                                        {{ number_format($userPrice, 2) }}
                                                                                    @else
                                                                                        {{ number_format($userPrice, 2) ?? isset($price) ? number_format($price, 2) : '' }}
                                                                                    @endif
                                                                                </span>
                                                                                <a href="javascript:void(0)"
                                                                                    data-product="{{ $proposal_item->product_id }}"
                                                                                    data-notes="{!! $ashus->remarks_offer ?? '' !!}"
                                                                                    data-price="{{ $userPrice ?? ($price ?? '') }}"
                                                                                    class="edit-price">
                                                                                    <i
                                                                                        class="fas fa-pencil-alt text-primary"></i>
                                                                                </a>
                                                                                {{-- @endif --}}

                                                                                <br>
                                                                                @if ($proposal_item->attachment != null)
                                                                                    <span>
                                                                                        <a href="{{ asset(getMediaByIds([$proposal_item->attachment])->path) }}"
                                                                                            class="btn-link text-primary">Download</a>
                                                                                    </span>
                                                                                @else
                                                                                    <br>
                                                                                @endif


                                                                                @if ($ashus->remarks_offer != null)
                                                                                    <div class="accordion"
                                                                                        id="accordionExample">
                                                                                        <div class="accordion-item">

                                                                                            <h2 class="accordion-header">
                                                                                                <button
                                                                                                    class="btn text-primary collapsed"
                                                                                                    style="background-color: transparent;"
                                                                                                    type="button"
                                                                                                    data-bs-toggle="collapse"
                                                                                                    data-bs-target="#accor_{{ $proposal_item->id }}"
                                                                                                    aria-expanded="false"
                                                                                                    aria-controls="collapseThree">
                                                                                                    <span
                                                                                                        class="text-dark ">{{ Str::limit($ashus->remarks_offer, 20) }}</span>
                                                                                                    <span
                                                                                                        title="{{ $ashus->remarks_offer }}"
                                                                                                        class="btn-link">More</span>
                                                                                                </button>
                                                                                            </h2>

                                                                                            <div id="accor_{{ $proposal_item->id }}"
                                                                                                class="accordion-collapse collapse"
                                                                                                data-bs-parent="#{{ $proposal_item->id }}">
                                                                                                <div
                                                                                                    class="accordion-body">
                                                                                                    {!! $ashus->remarks_offer !!}
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>

                                                                                    </div>
                                                                                @endif
                                                                            {{-- @endif --}}
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

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-6 d-nosne">
                                    <div class="row">
                                        @if (isset($currency_record) && count($currency_record) != 0)
                                            <div class="col-2 d-none">
                                                <div
                                                    class="form-group {{ $errors->has('offer_currency') ? 'has-error' : '' }}">
                                                    <label for="customer_mob_no" class="control-label">Currency</label>
                                                    <div class="">
                                                        <input type="text" name="offer_currency" disabled
                                                            class="form-control"
                                                            value="{{ $proposal->offer_currency ?? (session()->get('currency_name') ?? 'INR') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="proposal_note" class="control-label">Offer
                                                    Notes</label>
                                                <textarea class="form-control" rows="7" name="proposal_note" id="proposal_note"
                                                    placeholder="Enter Offer Notes">{{ $proposal->proposal_note }}</textarea>
                                            </div>
                                        </div>
                                        {{-- <div class="col-6">
                                            <div class="form-group">
                                                <label for="proposal_note"
                                                    class="control-label text-danger ">Attachments</label>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>

                                <div class="row d-none">
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <label for="">Upload Client Logo</label>
                                            <input type='file' id="file-input" name="client_logo_file" />
                                            @if ($proposal->client_logo != null)
                                                <div id='img_contain'>
                                                    <img class="image-preview" src="{{ asset($proposal->client_logo) }}"
                                                        alt="" title='' />
                                                    <a class="btn btn-icon btn-primary cross-icon delete-item"
                                                        href="{{ route('panel.proposals.remove-image', $proposal->id) }}"><i
                                                            class="fa fa-times"></i></a>
                                                </div>
                                            @else
                                                <div id='img_contain'>
                                                    <img class="image-preview" src="" alt=""
                                                        title='' />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <label for="file-input">Upload Visiting
                                                Card</label>
                                            <br>
                                            <input type='file' id="file-input" class="file-input-vs"
                                                name="client_visiting_card" />
                                            @if ($proposal->client_logo != null)
                                                <div id='img_contain'>
                                                    <img class="image-preview-vs"
                                                        src="{{ asset($proposal->visiting_card) ?? '' }}" alt=""
                                                        title='' />
                                                </div>
                                            @else
                                                <div id='img_contain'>
                                                    <img class="image-preview-vs" src="" alt=""
                                                        title='' />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-center align-items-center ">
                                    <button class="btn btn-outline-primary mx-2" type="submit">save</button>
                                    <a href="{{ inject_subdomain('proposal/export/' . $proposal->id . '/' . $user_key, $slug, false, false) }}"
                                        class="btn btn-outline-primary ">Next</a>

                                    <button type="button" class="btn btn-outline-danger mx-2" data-bs-toggle="modal"
                                        data-bs-target="#logofymodal" id="logofybtn">
                                        Logo-fy
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ajax-loading"
        style="display:none;background-color: green; color: white; position: fixed; bottom: 50px; right: 25px;padding: 10px; font-weight: 700; border-radius: 35px;">
        Please Wait...
    </div>
    @include('frontend.micro-site.proposals.modal.updateprice')
    @include('frontend.micro-site.proposals.modal.logo-fy')

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"
            integrity="sha512-CeIsOAsgJnmevfCi2C7Zsyy6bQKi43utIjdA87Q0ZY84oDqnI0uwfM9+bKiIkI75lUeI00WG/+uJzOmuHlesMA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        {{-- ` Script for LogoFy --}}
        <script>
            $(document).ready(function() {
                // Initialize Fabric.js canvas
                const canvas = new fabric.Canvas('logofycanvas');

                // Function to change canvas background color
                function Addcolor(color) {
                    canvas.backgroundColor = color;
                    canvas.renderAll();
                }

                // Function to load and adjust image size to fit the canvas
                function loadImageAndAdjustSize(imageURL) {
                    fabric.Image.fromURL(imageURL, function(img) {
                        var imgAspectRatio = img.width / img.height;
                        var canvasAspectRatio = canvas.width / canvas.height;
                        var scaleToUse = (canvasAspectRatio > imgAspectRatio) ? (canvas.height / img.height) : (
                            canvas.width / img.width);

                        img.set({
                            scaleX: scaleToUse,
                            scaleY: scaleToUse,
                            top: 0,
                            left: 0,
                            originX: 'left',
                            originY: 'top'
                        });

                        // canvas.clear();
                        canvas.add(img);
                        canvas.centerObject(img);
                        canvas.renderAll();
                    });
                }

                $("#chagebglogofy").on('input', function(e) {
                    e.preventDefault();
                    Addcolor($(this).val());
                })

                // Load Image to Canvas
                $("#uploadfiletologofy").change(function(e) {
                    e.preventDefault();
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        loadImageAndAdjustSize(event.target.result);
                        $("#logofyimagepreview").attr('src', event.target.result);

                    }
                    reader.readAsDataURL(e.target.files[0]);
                });

                // Update to apply filters more flexibly
                function applyFilter(index, filterType, value) {
                    const obj = canvas.getActiveObject();
                    if (!obj) return;

                    // Remove existing filter of the same type to prevent duplicates
                    obj.filters = obj.filters.filter(filter => !(filter instanceof filterType));

                    // Add new filter
                    let filter = new filterType(value);
                    obj.filters.push(filter);

                    obj.applyFilters();
                    canvas.renderAll();
                }

                // Image Filters - Adjusted to use applyFilter function
                $("#invert").on('input', function() {
                    // Invert doesn't support percentages; toggle based on value
                    const invertValue = parseFloat($(this).val()) > 0.5 ? {
                        invert: true
                    } : {}; // Example toggle logic
                    applyFilter(0, fabric.Image.filters.Invert, invertValue);
                });

                $("#brightness").on('input', function() {
                    const brightnessValue = {
                        brightness: parseFloat($(this).val())
                    };
                    applyFilter(1, fabric.Image.filters.Brightness, brightnessValue);
                });

                $("#saturation").on('input', function() {
                    const saturationValue = {
                        saturation: parseFloat($(this).val())
                    };
                    applyFilter(2, fabric.Image.filters.Saturation, saturationValue);
                });

                $('#addTextButton').click(function() {
                    const textVal = $('#textInput').val();
                    const fontVal = $('#fontSelect').val();
                    const colorVal = $('#textColorInput').val();
                    const sizeVal = parseInt($('#textSizeInput').val(), 10);

                    const text = new fabric.IText(textVal, {
                        fontFamily: fontVal,
                        fill: colorVal,
                        fontSize: sizeVal
                    });

                    canvas.add(text);
                    canvas.renderAll();
                });

                fabric.Image.filters.Emboss = fabric.util.createClass(fabric.Image.filters.BaseFilter, {
                    type: 'Emboss',
                    applyTo2d: function(options) {
                        // Implement emboss effect using options.imageData
                        // This is where you'd apply the convolution matrix for the emboss effect
                    }
                });
                fabric.Image.filters.Sharpen = fabric.util.createClass(fabric.Image.filters.BaseFilter, {
                    type: 'Sharpen',
                    applyTo2d: function(options) {
                        // Implement sharpen effect
                    }
                });

                function chnageeffect(imageUrl) {
                    fabric.Image.fromURL(imageUrl, function(img) {
                        img.set({
                            left: 50, // Horizontal position
                            top: 50, // Vertical position
                            // scaleX: 0.5, // Scale horizontally (optional)
                            // scaleY: 0.5, // Scale vertically (optional)
                        });
                        // Add the image to the canvas
                        canvas.add(img);
                        // Render the canvas to display the newly added image
                        canvas.renderAll();
                    });
                }

                $(".chnageeffect").click(function(e) {
                    e.preventDefault();
                    let imageUrl = $(this).attr('src');
                    loadImageAndAdjustSize(imageUrl);
                });

                function getDataCanvas() {
                    // Assuming your Fabric.js canvas instance is named 'canvas'
                    var dataURL = canvas.toDataURL({
                        format: 'png', // Specify the image format. Options include 'png', 'jpeg', etc.
                        quality: 1 // For JPEG format, determines the quality. Range is from 0 (low) to 1 (high).
                    });
                    return dataURL;
                }

                $(".modify-logoapply").change(function (e) {
                    e.preventDefault();
                    let height = $("#modifylogo-height").val();
                    let width = $("#modifylogo-width").val();
                    let top = $("#modifylogo-top").val();
                    let bottom = $("#modifylogo-bottom").val();
                    let border_radius = $("#modifylogo-border_radius").val();
                    let objectfit = $("#modifylogo-objectfit").val();
                    let css = {
                        "height": `${height}px`,
                        "width": `${width}px`,
                        "object-fit": `${objectfit}`,
                        "position": "absolute",
                        "top": `${top}px`,
                        "left": `${bottom}px`,
                        "border-radius": `${border_radius}px`,
                    }
                    $(".appendlogo").css(css);
                });

                $("#pills-visualise-tab").click(function (e) {
                    $.each($(".appendlogo"), function (indexInArray, valueOfElement) {
                        $(this).attr('src', getDataCanvas());
                    });
                });


            });
        </script>

        <script>
            $(document).ready(function() {

                $("#magrintochnage").change(function(e) {
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
                    navigator.clipboard.writeText(text).then(function() {}, function(err) {});
                    $.toast({
                        heading: 'SUCCESS',
                        text: "Offer link copied.",
                        showHideTransition: 'slide',
                        icon: 'success',
                        loaderBg: '#f96868',
                        position: 'top-right'
                    });
                }

                $(".copyLInk").click(function(e) {
                    e.preventDefault();
                    var link = $(this).data('link');
                    copyTextToClipboard(link);
                });

            });
        </script>

        <script>
            var hike = $('#hike').val();

            function updateURLParam(key, val) {
                var url = window.location.href;
                var reExp = new RegExp("[\?|\&]" + key + "=[0-9a-zA-Z\_\+\-\|\.\,\;]*");

                if (reExp.test(url)) {
                    // update
                    var reExp = new RegExp("[\?&]" + key + "=([^&#]*)");
                    var delimiter = reExp.exec(url)[0].charAt(0);
                    url = url.replace(reExp, delimiter + key + "=" + val);
                } else {
                    // add
                    var newParam = key + "=" + val;
                    if (!url.indexOf('?')) {
                        url += '?';
                    }

                    if (url.indexOf('#') > -1) {
                        var urlparts = url.split('#');
                        url = urlparts[0] + "&" + newParam + (urlparts[1] ? "#" + urlparts[1] : '');
                    } else if (url.indexOf('&') > -1 || url.indexOf('?') > -1) {
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
                    success: function(res) {
                        console.log(res);
                        location.reload();
                    }
                });
            });

            $('.input-check').click(function() {

                if ($(this).prop('checked')) {
                    var route = "{{ route('panel.proposal_items.api.store') }}" + "?product_id=" + $(this).val() +
                        '&proposal_id=' + "{{ $proposal->id }}" + "&hike=" + hike;
                    $.ajax({
                        url: route,
                        method: "get",
                        success: function(res) {

                        }
                    });
                } else {
                    var route = "{{ route('panel.proposal_items.api.remove') }}" + "?product_id=" + $(this).val() +
                        '&proposal_id=' + "{{ $proposal->id }}";
                    $.ajax({
                        url: route,
                        method: "get",
                        success: function(res) {

                        }
                    });
                }
            });

            // Add Product To Pin

            $('.input-checkpin').click(function() {

                if ($(this).prop('checked')) {
                    var id = $(this).val();
                    // var img = ;?
                    var route = "{{ route('panel.proposal_items.api.addpin') }}" + "?product_id=" + $(this).val() +
                        '&proposal_id=' + "{{ $proposal->id }}" + "&hike=" + hike;
                    $.ajax({
                        url: route,
                        method: "get",
                        success: function(res) {
                            console.log(res);
                            $("img." + id).attr('src',
                                "{{ asset('frontend/assets/svg/bookmark_added.svg') }}");
                        }
                    });

                } else {
                    $("img." + id).attr('src', "{{ asset('frontend/assets/svg/bookmark.svg') }}");
                    var route = "{{ route('panel.proposal_items.api.removepin') }}" + "?product_id=" + $(this).val() +
                        '&proposal_id=' + "{{ $proposal->id }}";
                    $.ajax({
                        url: route,
                        method: "get",
                        success: function(res) {
                            console.log(res);
                            $("img." + id).attr('src', "{{ asset('frontend/assets/svg/bookmark.svg') }}");
                        }
                    });
                }
            });




            $('#ProposalForm').validate();
            $('#category_id').change(function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: "{{ route('panel.user_shop_items.get-category') }}",
                        method: "get",
                        datatype: "html",
                        data: {
                            id: id
                        },
                        success: function(res) {
                            $('#sub_category_id').html(res);
                        }
                    })
                }
            })
            $(document).ready(function() {
                $('#suppliers').select2({
                    placeholder: "All Suppliers",
                });
                $('#brands').select2({
                    placeholder: "All Brands",
                });
                $('#size').select2({
                    placeholder: "All Size",
                });
                $('#color').select2({
                    placeholder: "All Color",
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

            $(document).on('click', '.nav-link', function(e) {
                var type = $(this).data('type');
                var url = "";
                if (checkUrlParameter('type')) {
                    url = updateURLParam('type', type);
                } else {
                    url = updateURLParam('type', type);
                }
                window.location.href = url;
            });
            $(document).on('click', '.add-item', function(e) {
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
                            action: function() {
                                window.location.href = url;
                            }
                        },
                        close: function() {}
                    }
                });
            });
            $(document).on('click', '.click-send', function(e) {
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
                            action: function() {
                                window.location.href = url;
                            }
                        },
                        close: function() {}
                    }
                });
            });
            $(document).on('click', '.remove-item', function(e) {
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
                            action: function() {
                                window.location.href = url;
                            }
                        },
                        close: function() {
                            test: "Cancel"
                        }
                    }
                });
            });

            $('.filterable-btn').on('click', function() {
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
            $('#my_product').on('click', function() {
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
                readURL(this, '.image-preview');
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
                readURLVS(this, );
            });


            $(".edit-price").click(function() {
                var product_id = $(this).data('product');
                var remark = $(this).data('notes');
                var price = $(this).data('price');

                $('.productId').val(product_id);
                $("#remarks_offer").val(remark);
                $("#price").val(price);
                $('#pickedProductEdit').modal('show');

            });

            @if (request()->get('my_product') == 1)
                setTimeout(() => {
                    $('#my_product').trigger('click');
                }, 500);
            @endif


            $('#select-all').click(function() {
                $(document).find('#ajax-loading').show();
                var interval = 10;
                if ($('.input-check').is(':checked')) {
                    $('.input-check').prop('checked', false).change();
                } else {
                    $('.filterable-items').each(function() {
                        if (!$(this).hasClass('d-none')) {
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
            $('.unSelectAll').click(function() {
                var interval = 10;
                if ($('.input-check').is(':checked')) {
                    $('.input-check').prop('checked', false).change();
                } else {
                    $('.filterable-items').each(function() {
                        if (!$(this).hasClass('d-none')) {
                            setTimeout(() => {
                                $(this).find('.input-check').trigger('click');
                            }, interval);
                            interval += 150;
                        }
                    });
                }
            });

            // Update Sequence
            $(function() {

                $("#sortable").sortable({
                    items: "div.card-drag",
                    cursor: 'move',
                    opacity: 0.6,
                    update: function() {
                        sendOrderToServer();
                    }
                });

                function sendOrderToServer() {
                    var order = [];
                    $('div.card-drag').each(function(index, element) {
                        order.push({
                            id: $(this).attr('data-id'),
                            position: index + 1
                        });
                    });
                    console.log(order);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        // url: "{{ url('pages/update/sequence') }}"+'/'+"{{ $proposal->id }}",
                        url: "{{ route('pages.proposals.updateSequence', $proposal->id) }}",
                        data: {
                            order: order,
                            _token: '{{ csrf_token() }}'
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

            $('#validateMargin').on('click', function(e) {
                if ($('#hike').val() > 99) {

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

            window.addEventListener('load', () => {
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
