
@extends('frontend.layouts.main')
@section('meta_data')
    @php
        $categoryName = fetchFirst('App\Models\Category',request()->get('category_id'),'name') ?? 'All';
		$meta_title = ' | '.getSetting('app_name');
		$meta_description = getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');
		$meta_abstract = '' ?? getSetting('site_motto');
		$meta_author_name = '' ?? 'GRPL';
		$meta_author_email = '' ?? 'Hello@121.page';
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');
		$meta_img = ' ';
		$microsite = 1;
	@endphp
@endsection
@section('content')

<style>
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css");

    #selector select option {
        color: #333;
        position: relative;
        top: 5px;
    }
    #navigation{
        display: none !important;
    }

    .adwas{
        position: sticky !important;
        top: 0 !important;
        background-color: #fff !important;
        z-index: 9999 !important;
    }

        /*==================================================
        remove the original arrow in select option dropdown
        ==================================================*/

    #selector {
        margin: 5px 10%;
        width: 100%;
    }

    @media(max-width: 760px) {
        #selector {
            margin: auto;
        }

        .filterMobile {
            display: block;
        }
    }

    @media(min-width: 760px) {
        .filterMobile {
            display: none;
        }
    }

    .select_box {
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        appearance: none;
    }

    .select_box.input-lg {
        height: 50px !important;
        line-height: 25px !important;
    }

    .select_box+i.fa {
        float: right;
        margin-top: -32px;
        margin-right: 9px;
        pointer-events: none;
        background-color: #FFF;
        padding-right: 5px;
    }

    .custom-scrollbar {
        max-height: 500px;
        overflow-y: auto;
    }

    .shop-list .shop-image .overlay-work,
    .shop-list .shop-image .shop-icons {
        position: absolute;
        opacity: 1 !important;
        transition: all 0.5s ease
    }

    .checkmark {
        position: absolute;
        bottom: 10px;
        right: 5px;
        height: 25px;
        width: 25px;
        border-radius: 3px;
        background-color: #eee;
        cursor: pointer;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: block;
    }

    .custom-chk .checkmark:after {
        left: 9px;
        top: 5px;
        width: 7px;
        height: 11px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .custom-chk input:checked~.checkmark {
        background-color: #6666cc;
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

        .container-fluid {
            margin: 0;padding: 0;
            width: 30%;
            background-color: #fff;
        }

        .container-fluid img{
            height: 100px;
            width: 120px;
        }

        .container-fluid .bx{
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            margin: 5px;
            position: relative;
        }
        .container-fluid .bx .icon{
            position: absolute;
            top: -5%;
            right: -5%;
            cursor: pointer;
        }
        .container-fluid .bx .icon img::before{
            transition: 0.3s ease all;
        }

        .container-fluid .bx .icon i:hover::before{
            content: '\F622';
            color: red;
            font-weight: 800;
            height: min-content;
        }


        .container-fluid .bx span{
            font-size: 0.8pc;
            padding: 4px;
        }
        .container-fluid .bx small{
            font-weight: 500;
            text-transform: none;
        }

        .openbtn{
            position: absolute;
            right: 2%;
            top: 2%;
        }

        .row{
            width: 100%;
        }
        .eird{
            background-color: #6666cc;
            color: white;
        }
        .eird h2{
            text-align: left;
            margin-left: 5%;
            padding: 8px;
            font-size: 1.3pc;
        }
        .sidebar{
            position: relative;
        }
        .sticky-bar{
            top: 0 !important;
        }

        .col {
            width: fit-content;
            margin: 5px;
        }

        .col img {
            width: 190px !important;
            height: 150px !important;
            margin: 10px;
        }

        .ashu {
            text-align: center;
        }

        .col-3,
        .col-9 {
            margin: 10px 0;
        }

        .ydfgwej{
            position: fixed;
            right: 3%;
            bottom: 40%;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 35px;
            align-content: center;
            justify-content: center;
            /* align-items: center; */
            flex-wrap: nowrap;
        }

        .defaultscroll{
            padding: 0 0 20px 0;
        }

        .modal-content custom-spacing{
            overflow-y: hidden!important;
            overflow-x: hidden!important
        }
        /* filter alignment */
        .accordion-body {
            padding: 0 0 !important
        }

</style>

<section class="section p-0">


    {{-- Over The Layer Content --}}
    @if ( isset($proposalid) && $proposalid != -1)
        <div class="ydfgwej">
            <button class="btn btn-outline-primary d-none " type="button" id="select-all">
                <span class="d-none d-md-none d-sm-none">Select All</span>
                <span class="d-block d-md-block d-sm-block">
                    <i class="fas fa-check-double"></i>
                </span>
            </button>
            <a href="{{ route('pages.proposal.picked',['proposal' => $proposalid,'user_key' => $user_key]) }}?type=picked" class="btn btn-outline-primary" target="">
                {{-- <span class="d-none d-md-none d-sm-none">Next</span> --}}
                <span class="d-block d-md-block d-sm-block">
                    Next <i class="fas fa-chevron-right"></i>
                </span>
            </a>
        </div>
    @endif


    <div class="container mt-3">


        <div class="row bg-white wdaqd" >
            {{-- Fixed NAvigation BAr --}}
            <div class="col-12 col-md-12 bdhxzc" >
                <div class="row">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                            <div class="col-3 d-flex justify-content-start ">
                                @if ( isset($proposalid) && $proposalid != -1)
                                    <button class="btn btn-outline-secondary" id="openqr" type="button">Scan QR Codes</button>

                                @else
                                    @if ($manage_offer_guest || $manage_offer_verified)
                                        @if (auth()->id() == 155)
                                            @if ($manage_offer_guest)
                                                {{-- <a class="btn mt-2 d-block btn-outline-primary w-auto float-end makeoffer" href="{{ route('pages.proposal.create') }}?shop={{$user_shop->id}}" style="width: max-content !important;">
                                                    Make Offer
                                                </a> --}}
                                            @endif
                                        @else
                                            {{-- <a class="btn mt-2 d-block btn-outline-primary w-auto float-end makeoffer" href="{{ route('pages.proposal.create') }}?shop={{$user_shop->id}}" style="width: max-content !important;">
                                                Make Offer
                                            </a> --}}
                                        @endif
                                    @endif
                                @endif

                            </div>

                            <div class="col-9 d-flex justify-content-start">
                                <div class="input-group border rounded">
                                    <input type="text" id="quicktitle" value="{{ request()->get('title') }}" name="title" class="form-control border-0" placeholder="Quick Search : Name, Model Code, Keywords">
                                    <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i class="uil uil-search"></i></button>
                                </div>
                            </div>

                        {{-- @if (isset($proposalid) && $proposalid != -1 )
                            <div class="">
                                <button type="button" class="btn btn-outline-primary">
                                    Collection <span>4</span>
                                </button>
                            </div>
                        @endif --}}
                    </div>
                </div>
                <div class="row my-2">
                    <div class=" @if (count($currency_record) != 0) col-md-8 @else col-md-12 @endif col-12">
                        @if ($alll_searches != null)
                            @foreach ($alll_searches[0] as $key =>  $extra)
                                @if ($extra != '')
                                <span class="badge bg-primary searchabletag mb-1">
                                    {{-- {{ getAttruibuteValueById($extra)->attribute_value }} --}}
                                    <span class="badge bg-primary">
                                            @if ($loop->iteration  == 1 || $loop->iteration == 2 )
                                                {{ $key }}: {{ App\Models\Category::where('id',$extra)->first()->name ?? $extra  }}
                                            @else
                                                {{ $key }}: {{ $extra  }}
                                            @endif
                                    </span>
                                    <span class="remove-tag" data-color="{{ $extra }}" title="click to Remove ">x</span>
                                </span>
                                @endif
                            @endforeach
                        @endif

                        @foreach ($additional_attribute as $key => $item)
                            @if (request()->has("searchVal_$key") && !empty(request()->get("searchVal_$key")))
                                @foreach (request()->get("searchVal_$key") as $Color)
                                @php
                                    $name =  getAttruibuteValueById($Color)->attribute_value;
                                    // $parent =  getAttruibuteById(getAttruibuteValueById($Color)->parent_id)->name;
                                @endphp
                                    <span class="badge bg-primary searchabletag mb-1">
                                        {{-- {{ getAttruibuteValueById($Color)->attribute_value }} --}}
                                        <span class="badge bg-primary">
                                            {{ $name }}
                                        </span>
                                        <span class="remove-tag" data-color="{{ $Color }}" title="click to Remove {{$name}}">x</span>
                                    </span>
                                @endforeach
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>
            {{-- Fixed NAvigation Bar End --}}
        </div>




        <div class="row">
            {{-- Side Bar --}}
            <div class="col-md-4 col-lg-3  col-12 adwas">
                <div class="text-right pl-3 filterMobile" style="margin-top: 10%;">
                    <i title="filter" class="uil uil-bars up_arrow show_mobile_filter" style="font-size: 23px;"></i>
                    <i class="uil uil-times down_arrow close_mobile_filter" style="font-size: 23px;"></i>
                </div>

                <div class="card border-0 sidebar custom-scrollbar">
                    <form form role="search" method="GET" id="searchform" class="card-body filter-body p-0 applyFilter d-none d-md-block mobile_filter">
                        <input type="hidden" name="sort" value="" class="sortValue">
                        <h5 class="widget-title pt-3 pl-15" style="display: inline-block;">Filters
                        </h5>

                            <h6 class="widget-title mt-2">Price</h6>
                                <div class=" d-flex">
                                    <input  style="width: 70px;height: 35px;" @if(request()->has('from') && request()->get('from') != null) value="{{ request()->get('from') }}" @endif type="text" name="from" class="form-control" placeholder=" Min  ">
                                    <input style="width: 70px;height: 35px;" @if(request()->has('to') && request()->get('to') != null) value="{{ request()->get('to') }}" @endif type="text" name="to" class="form-control ms-2" placeholder=" Max ">
                                    <button class="price_go_btn ms-2" type="submit">GO</button>
                                </div>

                            {{-- categories Ashish --}}
                            <div class="widget">
                                <!-- Categories -->
                                <div class="widget bt-1 pt-3">
                                    <div class="accordion-item my-2">
                                        <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapscatrgory" aria-expanded="true" aria-controls="collapscatrgory" style="height: 25px !important;">
                                            <h6 class="widget-title mt-2">Categories</h6>
                                        </button>
                                        </h2>
                                        <div id="collapscatrgory" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                <ul class="list-unstyled mt-1 mb-0 custom-scrollbar" style="padding-left:1rem">
                                    <li>
                                        <h5 class="form-check">
                                            <input class="form-check-input" type="radio" @if(!request()->has('category_id') ||request()->get('category_id') == null ) checked @endif  value="" id="categoryAll" name="category_id">
                                            <label for="categoryAll" class="form-check-label fltr-lbl">
                                                All</label>
                                        </h5>
                                    </li>
                                    @if(!empty($categories))
                                        @foreach ($categories as $item)
                                            @php
                                            $sub_category = App\Models\Category::whereId(request()->get('sub_category_id'))->first();
                                            @endphp
                                            <li>
                                                <h5 class="form-check" style="display: flex;align-items: center;gap: 6px;">
                                                    <input class="form-check-input filterCategory" type="radio" value="{{ $item->id }}" id="category{{ $item->id }}" name="category_id" @if((request()->has('category_id') && request()->get('category_id') ==  $item->id )) checked @endif>
                                                    <label for="category{{ $item->id }}" class="form-check-label fltr-lbl mt-2">
                                                        {{$item->name}}
                                                        {{--  Category Count --}}
                                                        <span style="font-size: 11px">({{ getProductCountViaCategoryId($item->id,$user_shop->user_id) }})</span>
                                                    </label>
                                                </h5>
                                            </li>
                                            @if(request()->has('category_id') && request()->get('category_id') ==  $item->id )
                                                @php
                                                    $subcategories = getProductSubCategoryByShop($slug, $item->id, 0);
                                                @endphp
                                                    <div style="padding-left: 25px; display: flex;align-items: center;gap: 6px;">
                                                    <ul class="list-unstyled custom-scrollbar">
                                                        @foreach ($subcategories as $subcategorie)
                                                            <li>
                                                                <h5 class="form-check">
                                                                    <input class="form-check-input filterSubCategory" type="radio" value="{{ $subcategorie->id }}" id="category{{ $subcategorie->id }}" name="sub_category_id" @if(request()->has('sub_category_id') && request()->get('sub_category_id') ==  $subcategorie->id) checked @endif>
                                                                    <label for="category{{ $subcategorie->id }}" class="form-check-label fltr-lbl">
                                                                        {{$subcategorie->name}}
                                                                        {{-- Sub Category Count --}}
                                                                        <span style="font-size: 11px">
                                                                            ({{ getProductCountViaSubCategoryId($subcategorie->id,$user_shop->user_id) }})
                                                                        </span>
                                                                    </label>
                                                                </h5>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- categories Ashish --}}


                            <div class="accordion-item my-2 d-none">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesupplier" aria-expanded="true" aria-controls="collapsesupplier" style="height: 25px !important;">
                                    <h6 class="widget-title mt-2">Supplier</h6>
                                    </button>
                                </h2>
                                <div id="collapsesupplier" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @if(isset($suppliers) && $suppliers->count() >= 0)
                                            <ul class="list-unstyled mt-2 mb-0 custom-scrollbar" style="height: 60px;">
                                                <li>
                                                    <input class="form-check-input" type="checkbox" value="yes" id="ownproduct"  name="ownproduct" @if ($request->has('ownproduct') == 'yes') checked @endif>
                                                    <label for="ownproduct" class="form-check-label fltr-lbl ">Own Product</label>
                                                </li>
                                                @foreach ($suppliers as $supplier)
                                                    @if($supplier != '' || $supplier != null)
                                                    <li>
                                                        <h5 class="form-check">

                                                            <input class="form-check-input" type="checkbox" value="{{ $supplier->id }}" id="supplierid{{ $supplier->id }}"  name="supplier[]"
                                                            @if(request()->has('supplier'))
                                                                @if(isset($supplier) && in_array($supplier->id,request()->get('supplier')))
                                                                    checked
                                                                @endif
                                                            @endif >
                                                            <label for="supplierid{{ $supplier->id }}" class="form-check-label fltr-lbl ">
                                                                {{ $supplier->name }}
                                                            </label>
                                                        </h5>
                                                    </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        @if(isset($TandADeliveryPeriod) && $TandADeliveryPeriod->count() > 0)
                            <div class="accordion-item my-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDelivery" aria-expanded="true" aria-controls="collapseDelivery"  style="height: 25px !important;">
                                    <h6 class="widget-title mt-2">T&A</h6>
                                    </button>
                                </h2>
                                <div id="collapseDelivery" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                    <ul class="list-unstyled mt-2 mb-0 custom-scrollbar" style="height: 120px;">
                                            <div class="widget my-2">
                                                <input  style="height: 35px; width: 75px" @if(request()->has('quantity') && request()->get('quantity') != null) value="{{ request()->get('quantity') }}" @endif type="text" name="quantity" class="form-control" placeholder="Qty">
                                            </div>
                                        @foreach ($TandADeliveryPeriod as $color)
                                            @if($color != '' || $color != null)
                                            <li>
                                                <h5 class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $color }}" id="deliveryID{{ $color }}"  name="delivery[]"
                                                    @if(request()->has('delivery'))
                                                        @if(isset($color) && in_array($color,request()->get('delivery')))
                                                            checked
                                                        @endif
                                                    @endif >
                                                    <label for="deliveryID{{ $color }}" class="form-check-label fltr-lbl ">
                                                        {{ $color." Days" }}
                                                    </label>
                                                </h5>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                            {{-- Applying scoobooo layout in color and other attri --}}
                                @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                                    @foreach ($additional_attribute as $key => $item)
                                        @php
                                            $testchk = getAttruibuteById($item);
                                        @endphp
                                        @if ( isset($testchk) && getAttruibuteById($item)->visibility == 1)
                                            <div class="container mt-3">
                                                <!-- Collapsible Button -->
                                                <h6 class="collapsible" data-bs-toggle="collapse" data-bs-target="#AttributeList_{{$key}}" aria-expanded="false" aria-controls="AttributeList_{{$key}}">
                                                    {{ getAttruibuteById($item)->name }}
                                                <i class="fas fa-chevron-down fa-xs"></i>
                                                </h6>
                                                @php
                                                    $atrriBute_valueGet = getParentAttruibuteValuesByIds($item,$proIds);
                                                @endphp
                                                <div class="collapse" id="AttributeList_{{$key}}">
                                                    <ul class="list-unstyled mt-2 mb-0 custom-scrollbar">
                                                        @foreach ($atrriBute_valueGet as $mater)
                                                        @if($mater != '' || $mater != null)
                                                        <li>
                                                            <h5 class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ $mater }}" id="searchId{{ $mater }}"  name="searchVal_{{ $key }}[]"
                                                                @if(request()->has("searchVal_$key"))
                                                                    @if(isset($mater) && in_array($mater,request()->get("searchVal_$key")))
                                                                        checked
                                                                    @endif
                                                                @endif >
                                                                <label for="searchId{{ $mater }}" class="form-check-label fltr-lbl ">
                                                                    {{ getAttruibuteValueById($mater)->attribute_value ?? ''}}
                                                                </label>
                                                            </h5>
                                                        </li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            {{-- Applying scoobooo layout in color and other attri End --}}
                            {{-- Exclusive Products --}}

                            {{-- <h6 class="widget px-2">Exclusive Products</h6> --}}
                            <div class="mx-2 d-flex">
                                <input type="checkbox" class="form-check-input visually-hidden" name="exclusive" id="exclusive" @if ($request->get('exclusive')) checked @endif>
                                <label class="form-check-label mx-2" id="excl">Exclusive Items</label>
                                @if ($request->get('exclusive') == 'on')
                                    <div class="text-success" style="font-weight: bolder">
                                        <i class="uil-check-circle" style="font-size: 20px"></i>
                                    </div>
                                @else
                                    {{-- <div class="text-danger" style="font-weight: bolder"> OFF </div> --}}
                                @endif
                            </div>

                            <div class="mx-2 d-flex my-3">
                                <input type="checkbox" class="form-check-input " name="pinned" id="pinned" @if ($request->get('pinned')) checked @endif>
                                <label class="form-check-label mx-2" id="pinnedbtn" for="pinned">Pinned Items Only</label>
                                @if ($request->get('pinned') == 'on')
                                    <div class="text-success" style="font-weight: bolder">
                                        <i class="uil-check-circle" style="font-size: 20px"></i>
                                    </div>
                                @else
                                    {{-- <div class="text-danger" style="font-weight: bolder"> OFF </div> --}}
                                @endif
                            </div>

                            {{-- Exclusive Products --}}



                        </div>
                    </form>
                </div>
                {{-- <div class="col-md-3 col-lg-4"> --}}
                <div class="row justify-content-between">
                    <div class="col-md-6 col-lg-6">
                        <button type="submit" class="btn btn-sm mt-2 d-block btn-primary w-100" id="filterBtn" form="searchform">Filter</button>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <a class="btn btn-sm mt-2 d-block btn-primary w-100" href="{{ route('pages.shop-index')}}" id="resetButton">Reset</a>
                    </div>
                </div>
                {{-- <button type="submit" class="btn mt-2 d-block btn-primary w-100" id="filterBtn" form="searchform">Filter</button>
                @if (isset($proposalid) && $proposalid != -1 )
                    <a class="btn mt-2 d-block btn-primary w-100" href="{{ route('pages.proposal.edit',['proposal' => $proposalid,'user_key' => $user_key]) }}?margin=0" id="resetButton">Reset</a>
                @else
                    <a class="btn mt-2 d-block btn-primary w-100" href="{{route('pages.shop-index')}}" id="resetButton">Reset</a>
                @endif --}}
                {{-- </div> --}}


            </div><!--end col-->


            {{-- main Content Box --}}
            <div class="col-lg-9 col-md-8 col-12 pt-2 mt-sm-0 pt-sm-0">

                    <div class="row align-items-center">
                        <div class="col-md-4 col-6 mt-sm-0 pt-2 pt-sm-0">
                            @if (count($currency_record) != 0)
                                <div class="container" id="selector">
                                    <select class="form-control select_box" id="changeCurrency" name="Currency">
                                        <option aria-readonly="true" disabled>Change Currency</option>
                                        @foreach ($currency_record as $item)
                                            <option value="{{ $item->id }}" @if ($item->id == (Session::get('Currency_id') ?? 'INR')) selected @endif > {{ $item->currency }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="container" id="selector">
                                <select class="form-control input-lg select_box" id="productSort" name="sort">
                                    <option @if(request()->get('sort') == 2) selected @endif value="2">Price: low to high</option>
                                    <option @if(request()->get('sort') == 1) selected @endif value="1">Latest First</option>
                                    <option @if(request()->get('sort') == 3) selected @endif value="3">Price: high to low</option>
                                </select>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 d-flex justify-content-end">
                            <div class="m-2 d-flex gap-2">
                                <button id="gridview" class="btn btn-outline-primary"><i class="fas fa-th-large"></i></button>
                                <button id="card" class="btn btn-outline-primary active"> <i class="fas fa-list"></i></button>
                            </div>
                        </div>
                    </div>




                    @if (isset($proposalid) && $proposalid != -1 )
                        @include('frontend.micro-site.proposals.load')
                    @else
                        @include('frontend.micro-site.shop.loadIndex')
                    @endif


                        {{-- <div class="d-flex justify-content-center">
                            {{ $items->appends(request()->query())->links() }}
                        </div> --}}
                        <div class="row my-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-outline-primary nextpage">Show More...</button>
                                </div>
                            </div>
                            {{-- <div class="col-4">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('pages.proposal.picked',['proposal' => $proposalid,'user_key' => $user_key]) }}?type=picked" class="btn btn-outline-primary" target="">Next</a>
                                </div>
                            </div> --}}
                        </div>
            </div>


            <!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</section>

{{-- Custom Loader --}}

<div class="lds-roller cloader">
    <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
</div>

{{-- Custom Loader --}}

<div id="ajax-loading" style="display:none;background-color: green; color: white; position: fixed; bottom: 50px; right: 25px;padding: 10px; font-weight: 700; border-radius: 35px;">
    Please Wait...
</div>
@endsection

@include('frontend.micro-site.proposals.modal.scanQR')
@include('frontend.micro-site.proposals.modal.openoffer')

<script src="{{ asset('backend/js/qrcode.js') }}"></script>
@section('InlineScript')


    @if (isset($proposalid) && $proposalid != -1 )

        <script>
            let viewarea = "List";

            $(document).ready(function () {
                $("#openqr").click(function (e) {
                    e.preventDefault();
                    html5QrcodeScanner.render(onScanSuccess);
                    $("#barCodeModal").modal('show');
                });
            });

            var resultContainer = document.getElementById('qr-reader-results');
            var lastResult, countResults = 0;

            function onScanSuccess(decodedText, decodedResult) {
                var url = decodedText+"&proposalreq={{ $proposal->id }}";
                var slug = "{{getShopSlugByUserId(auth()->id())}}";
                $("#myofferproduct").attr('src',url);
                $("#openoffer").modal('show');
                $("#barCodeModal").modal('hide');
            }

            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", {
                    fps: 10,
                    qrbox: 250
                });

            $(document).on('hide.bs.modal', '#barCodeModal', function () {
                html5QrcodeScanner.clear();
            });

        </script>

    @endif

    <script>

        $(document).ready(function () {
            $("#gridview").click();
        });

        // LISt View
        $("#gridview").click(function (e) {
            e.preventDefault();
            // Change Class of Columns
            $(".col-3").addClass("col-4");
            $(".col-3").removeClass("col-3");

            // UnHide Text Below Image
            $(".ashu").removeClass("d-none")
            // Hide Second Colummn
            $(".send").addClass("d-none")
            $(".ashu1").addClass("d-none")

            // Add or remove Active Class
            $(this).addClass('active');
            $("#card").removeClass('active')
            viewarea = "Grid";
        });


        $("#card").click(function (e) {
            e.preventDefault();
            $(".col-4").addClass("col-3");
            $(".col-4").removeClass("col-4");
            $(".send").removeClass("d-none")
            $(".ashu").addClass("d-none")
            $(".ashu1").removeClass("d-none")


            // Add or remove Active Class
            $(this).addClass('active');
            $("#gridview").removeClass('active')
            viewarea = "List";

        });
    </script>

    <script>
        var active_category = "{{request()->get('category_id') }}";
        var active_sub_category = "{{request()->get('sub_category_id') }}";
            $('.down_arrow').addClass('d-none');

            $('.filterCategory').on('click', function(){
                if(active_category == $(this).val()){
                    $(this).val(null);
                    $(document).find('.filterSubCategory').val(null);
                }else{
                    $(document).find('.filterSubCategory').val(null);
                }
                $('.applyFilter').submit();
        });

            $('.filterSubCategory').on('click', function(){
                if(active_sub_category == $(this).val()){
                    $(this).val(null);
                }
                $('.applyFilter').submit();
        });

        $('#productSort').on('change', function(){
                var value = $(this).val();
                $('.sortValue').val(value);
                $('.applyFilter').submit();
        });
        $('.show_mobile_filter').on('click',function(){
                $('.up_arrow').addClass('d-none');
                $('.down_arrow').removeClass('d-none');
                $('.mobile_filter').removeClass('d-none');
        });
        $('.close_mobile_filter').on('click',function(){
                $('.up_arrow').removeClass('d-none');
                $('.down_arrow').addClass('d-none');
                $('.mobile_filter').addClass('d-none');
        });

        @if (isset($proposalid) && $proposalid != -1 )
            $('#categoryAll').click(function(){
                url = "{{ route('pages.proposal.edit',['proposal' => $proposalid,'user_key' => $user_key]) }}?margin=0";
                window.location.href = url;
            });
        @else
            $('#categoryAll').click(function(){
                url = "{{route('pages.shop-index')}}";
                window.location.href = url;
            });
        @endif
    </script>



    <script>
        $(document).on('click','#excl',function(e){
            $(this).attr('checked',false);
            $.confirm({
                title: 'Password!',
                content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Enter Password for Exlusive</label>' +
                '<input type="text" placeholder="Your name" class="name form-control" name="password" required />' +
                '</div>' +
                '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function () {
                            var name = this.$content.find('.name').val();
                            if(!name){
                                $.alert('provide a valid name');
                                return false;
                            }

                            $.ajax({
                                type: "GET",
                                url: "{{ route('pages.proposal.validatepass') }}",
                                data: {
                                    'password' :name,
                                },
                                success: function (response) {
                                    if (response['status'] == 'success') {
                                        $("#exclusive").attr('checked',true);
                                        $("#filterBtn").click();
                                    }else{
                                        $("#exclusive").attr('checked',false);
                                        $.alert("Wrong Password");
                                        $("#resetButton").click();
                                    }
                                    // console.log(response['status']);
                                },
                                // error: function (e) {
                                //     console.log(e);
                                // }
                            });
                        }
                    },
                    cancel: function () {
                        //close
                    },
                },
                onContentReady: function () {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });

    </script>

     {{-- Api Group --}}

     <script>
        $('.input-check').click(function(){
            if($(this).prop('checked')){
                var route = "{{ route('pages.api.store') }}"+"?product_id="+$(this).val()+'&proposal_id='+"{{ $proposalid }}"+"&hike=0";
                console.log(route);
                $.ajax({
                    url: route,
                    method: "get",
                    success: function(res){
                        $("#itcont").html(res['count']);
                        console.table(res);
                        console.log(url);
                        $('.ashu').css('background-color', 'red');
                    },error: function (res) {
                        console.log(res);
                    }
                });
            }else{
                var route = "{{ route('pages.api.remove') }}"+"?product_id="+$(this).val()+'&proposal_id='+"{{ $proposalid }}";
                $.ajax({
                    url: route,
                    method: "get",
                    success: function(res){
                        $("#itcont").html(res['count']);
                        console.table(res);
                        console.log(url);
                    }
                });
            }
        });


        $('.input-check1').click(function () {
            // console.log("You Cliked Me! 1")
            if ($(this).prop('checked')) {
                var route = "{{ route('pages.api.store') }}" + "?product_id=" + $(this).val() + '&proposal_id=' + "{{ $proposalid }}" + "&hike=0";
                console.log(route);
                $.ajax({
                    url: route,
                    method: "get",
                    success: function (res) {
                        $("#itcont").html(res['count']);
                        console.table(res);
                        console.log(url);
                    }
                });
            } else {
                var route = "{{ route('pages.api.remove') }}" + "?product_id=" + $(this).val() + '&proposal_id=' + "{{ $proposalid }}";
                $.ajax({
                    url: route,
                    method: "get",
                    success: function (res) {
                        $("#itcont").html(res['count']);
                        console.table(res);
                        console.log(url);
                    }
                });
            }


        });

        $('#select-all').click(function(){

            $(document).find('#ajax-loading').show();
            var interval = 10;
            $('.filterable-items').each(function(){
                if(!$(this).hasClass('d-none')){
                    setTimeout(() => {
                        $(this).find('.input-check').trigger('click');
                    }, interval);
                    interval += 150;
                }
                setTimeout(() => {
                    $(document).find('#ajax-loading').hide();
                }, 5000);
            });
        });



        $('.unSelectAll').click(function(){
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


        // custom Loder

        window.addEventListener('load', () =>{
            const cloader = $(".cloader")
            cloader.addClass('loader-hidden');
        })

        $(document).ready(function () {
            const cloader = $(".cloader")
            cloader.addClass('loader-hidden');
        });


    </script>





    @if (isset($proposalid) && $proposalid != -1 )
        {{-- Ajax Scroll Load Proposal--}}
        <script>
            var URL = "{{ route('pages.proposal.edit',['proposal' => $proposalid,'user_key' => $user_key]) }}";
            var crr_page = 1;
            var total_page = {{ $items->lastPage() }};
            var contianer = $("#dfjrgd");
            var qsearch = false;

            $(".nextpage").click(function (e) {
                e.preventDefault();
                if (qsearch === false) {
                    if (total_page >= crr_page+1) {
                        getData(crr_page+1)
                    }else{
                        $(".nextpage").addClass('d-none')
                    }
                }
            });


            function getData(pages) {
                $.ajax({
                    type: "get",
                    url: URL,
                    data: {
                        'page':pages,
                    },
                    success: function (response) {
                        $(".dfjrgd").append(response);
                        crr_page++;
                        if (viewarea == 'List') {
                            $("#card").click()
                        }else{
                            $("#gridview").click();
                        }


                        // Code Start

                        $('.input-check').click(function(){
                            //
                            if($(this).prop('checked')){
                                var route = "{{ route('pages.api.store') }}"+"?product_id="+$(this).val()+'&proposal_id='+"{{ $proposalid }}"+"&hike=0";
                                console.log(route);
                                $.ajax({
                                    url: route,
                                    method: "get",
                                    success: function(res){
                                        $("#itcont").html(res['count']);
                                        // console.table(res);
                                        // console.log(url);
                                    },error: function (res) {
                                        // console.log(res);
                                    }
                                });
                            }else{
                                var route = "{{ route('pages.api.remove') }}"+"?product_id="+$(this).val()+'&proposal_id='+"{{ $proposalid }}";
                                $.ajax({
                                    url: route,
                                    method: "get",
                                    success: function(res){
                                        $("#itcont").html(res['count']);
                                        // console.table(res);
                                        // console.log(url);
                                    }
                                });
                            }
                        });

                        $('#select-all').click(function(){
                            $(document).find('#ajax-loading').show();
                            var interval = 10;
                            $('.filterable-items').each(function(){
                                if(!$(this).hasClass('d-none')){
                                    setTimeout(() => {
                                        $(this).find('.input-check').trigger('click');
                                    }, interval);
                                    interval += 150;
                                }
                                setTimeout(() => {
                                    $(document).find('#ajax-loading').hide();
                                }, 5000);
                            });
                        });
                        // Code End
                    }
                });
            }


            // ! OnKey Up Load Ajax...
            $("#quicktitle").keyup(function (e) {
                let thisval = this.value;

                if (thisval == '') {
                    qsearch = false;
                    $(".nextpage").removeClass('d-none')
                    crr_page = 1;
                }else{
                    qsearch = true;
                    $(".nextpage").addClass('d-none')
                }

                $.ajax({
                    type: "get",
                    url: URL,
                    data: {
                        'title':this.value,
                        'model_code':this.value,
                        'exclusive': "{{ request()->get('exclusive') ?? 'off' }}",
                    },
                    success: function (response) {
                        $(".dfjrgd").empty() .html(response);
                        if (viewarea == 'List') {
                            $("#card").click()
                        }else{
                            $("#gridview").click();
                        }

                        // Code Start
                        $('.input-check').click(function(){

                            if($(this).prop('checked')){
                                var route = "{{ route('pages.api.store') }}"+"?product_id="+$(this).val()+'&proposal_id='+"{{ $proposalid }}"+"&hike=0";
                                console.log(route);
                                $.ajax({
                                    url: route,
                                    method: "get",
                                    success: function(res){
                                        $("#itcont").html(res['count']);
                                        // console.table(res);
                                        // console.log(url);
                                    },error: function (res) {
                                        // console.log(res);
                                    }
                                });
                            }else{
                                var route = "{{ route('pages.api.remove') }}"+"?product_id="+$(this).val()+'&proposal_id='+"{{ $proposalid }}";
                                $.ajax({
                                    url: route,
                                    method: "get",
                                    success: function(res){
                                        $("#itcont").html(res['count']);
                                        // console.table(res);
                                        // console.log(url);
                                    }
                                });
                            }
                        });


                        $('#select-all').click(function(){
                            $(document).find('#ajax-loading').show();
                            var interval = 10;
                            $('.filterable-items').each(function(){
                                if(!$(this).hasClass('d-none')){
                                    setTimeout(() => {
                                        $(this).find('.input-check').trigger('click');
                                    }, interval);
                                    interval += 150;
                                }
                                setTimeout(() => {
                                    $(document).find('#ajax-loading').hide();
                                }, 5000);
                            });
                        });
                        // Code End

                    }
                });


            });


        </script>
    @else
    {{-- Ajax Load --}}
    <script>
        var URL = "{{ url('/') }}/shop";
        var crr_page = 1;
        var total_page = {{ $items->lastPage() }};
        var contianer = $("#dfjrgd");
        var qsearch = false;

        $(".nextpage").click(function (e) {
            e.preventDefault();
            if (qsearch === false) {
                if (total_page >= crr_page+1) {
                    getData(crr_page+1)
                }else{
                    $(".nextpage").addClass('d-none')
                }
            }
        });

        function getData(pages) {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);

            $.ajax({
                type: "get",
                url: URL,
                data: {
                    'page':pages,
                    'title': urlParams.get('title'),
                    // ! Uncomment this to Enable search by Curren Filters/
                    // 'model_code': urlParams.get('model_code'),
                    // 'category_id': urlParams.get('category_id'),
                    // 'sub_category_id': urlParams.get('sub_category_id'),
                    // 'brand': urlParams.get('brand'),
                    // 'from': urlParams.get('from'),
                    // 'to': urlParams.get('to'),
                    // 'exclusive': urlParams.get('exclusive') ?? 'off',
                    @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                        @foreach ($additional_attribute as $key => $item)
                            'searchVal_{{$key}}' : urlParams.getAll("searchVal_{{$key}}[]"),
                        @endforeach
                    @endif
                },
                success: function (response) {
                    $(".dfjrgd").append(response);
                    crr_page++;
                    if (viewarea == 'List') {
                        $("#card").click()
                    }else{
                        $("#gridview").click();
                    }
                }
            });
        }
        // ! OnKey Up Load Ajax...
        $("#quicktitle").keyup(function (e) {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            let thisval = this.value;
            if (thisval == '') {
                qsearch = false;
                $(".nextpage").removeClass('d-none')
                crr_page = 1;
            }else{
                qsearch = true;
                $(".nextpage").addClass('d-none')
            }
            console.log(urlParams.get('exclusive') ?? 'off');

            $.ajax({
                type: "get",
                url: URL,
                data: {
                    'title':this.value,
                    'model_code':this.value,
                    // 'exclusive': urlParams.get('exclusive') ?? 'off',
                    // 'category_id': urlParams.get('category_id'),
                    // 'sub_category_id': urlParams.get('sub_category_id'),
                    // 'brand': urlParams.get('brand'),
                    // 'from': urlParams.get('from'),
                    // 'to': urlParams.get('to'),
                    @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                        @foreach ($additional_attribute as $key => $item)
                            'searchVal_{{$key}}' : urlParams.getAll("searchVal_{{$key}}[]"),
                        @endforeach
                    @endif

                },
                success: function (response) {
                    $(".dfjrgd").empty().html(response);
                    if (viewarea == 'List') {
                        $("#card").click()
                    }else{
                        $("#gridview").click();
                    }
                }
            });


        });


    </script>


    @endif





    <script>
        $(document).ready(function () {
            //  Add a click event handler to all the remove-tag elements
            $(".remove-tag").click(function () {
                // Get the color value associated with the tag
                var color = $(this).data("color");
                var filterdata = $(`input[value=${color}]`)

                if (filterdata.attr('type') == 'text' || filterdata.attr('type') == 'number') {
                    filterdata.val('');
                }
                $(this).parent().remove();
                filterdata.click()
                $("#searchform").submit()

            });
        });
    </script>


    <script>

        $(".makeoffer").click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            // var msg = "<input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Name'> <br> <input type='text' id='offeremail' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Email (Optional)'> <br> <input type='number' maxlength='10' id='offerphone' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Phone (Optional)'>";
            var msg = "<input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Buyer Name'> <br> <input type='text' id='alias' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Alias (optional)'> <br> <input type='text' id='offeremail' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Email (Optional)'> <br> <input type='number' maxlength='10' id='offerphone' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Phone (Optional)'>";



            $.confirm({
                draggable: true,
                title: 'Offer for',
                content: msg,
                type: 'blue',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Next',
                        btnClass: 'btn-primary',

                        action: function(){
                                let margin = $('#margin').val();
                                let offeremail = $('#offeremail').val();
                                let offerphone = $('#offerphone').val();

                                let alias = $('#alias').val();
                                let personname = $('#offerpersonname').val();

                                if (!margin) {
                                    $.alert('provide a valid name');
                                    return false;
                                }
                                url = url+"&offerfor="+margin+"&offerphone="+offerphone+"&offeremail="+offeremail+"&offeralias="+alias+"&offerpersonname="+personname;
                                window.location.href = url;
                                // console.log(url);
                        }
                    },
                    close: function () {
                    }
                }
            });
        });
        // confirm


    </script>




@endsection
