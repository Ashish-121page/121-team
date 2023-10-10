
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
        top: 10px;
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

</style>

<section class="section">
    <div class="container mt-3">
        <div class="row">

            {{-- Side Bar --}}
            <div class="col-lg-3 col-md-4 col-12 sticky-bar adwas">
                <div class="text-right pl-3 filterMobile" style="margin-top: 10%;">
                    <i title="filter" class="uil uil-bars up_arrow show_mobile_filter" style="font-size: 23px;"></i>
                    <i class="uil uil-times down_arrow close_mobile_filter" style="font-size: 23px;"></i>
                </div>

                @php
                    $proposal_deatail = json_decode($proposal->customer_details);
                @endphp
                <div class="d-flex align-items-center justify-content-center justify-content-md-end justify-content-sm-end flex-column">
                    <span class="text-primary my-1">Offer for {{ $proposal_deatail->customer_name }} : <br> <span id="itcont">{{ count($excape_items) }}</span> Items </span>
                    <button class="btn btn-outline-secondary" id="openqr" type="button">Scan QR Codes</button>
                </div>

                <div class="d-flex gap-2 align-items-center justify-content-center my-2">
                    {{-- <button class="btn btn-outline-primary" type="button" style="font-size: 0.8rem !important" id="select-all">Select All</button> --}}
                    <a href="{{ route('pages.proposal.picked',['proposal' => $proposalid,'user_key' => $user_key]) }}?type=picked" class="btn btn-outline-primary" target="">Next</a>
                </div>

                <div class="card border-0 sidebar sticky-bar custom-scrollbar">
                    <form form role="search" method="GET" id="" class="card-body filter-body p-0 applyFilter d-none d-md-block mobile_filter">
                        <input type="hidden" name="sort" value="" class="sortValue">
                        <h5 class="widget-title pt-3 pl-15" style="display: inline-block;">Filters
                        </h5>
                        {{-- <div class="widget px-2">
                            <div>
                                <div class="input-group mb-3 border rounded">
                                    <input type="text" id="title" value="{{ request()->get('title') }}" name="title" class="form-control border-0" placeholder="Search Product Name...">
                                    <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i class="uil uil-search"></i></button>
                                </div>
                            </div>
                        </div>    --}}
                        <!-- SEARCH -->


                            {{-- Hidden Brand --}}
                            {{-- @if(isset($brands) && $brands->count() >= 1)
                                <h6 class="widget-title mt-2">Brands</h6>
                                <ul class="list-unstyled mt-2 mb-0 custom-scrollbar">
                                    @foreach ($brands as $brand)
                                        <li>
                                            <h5 class="form-check">
                                                <input class="form-check-input" type="radio" value="{{ $brand->id }}" id="brandID" name="brand" @if(request()->has('brand') && request()->get('brand') == $brand->id) checked @endif>
                                                <label for="brandID" class="form-check-label fltr-lbl ">
                                                    {{ $brand->name }}
                                                </label>
                                            </h5>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif   --}}


                                {{-- <h6 class="widget-title mt-2">Margin</h6>
                                <div class="mx-2 d-flex">
                                    <input  style="width: 75px;height: 35px;" @if(request()->has('margin') && request()->get('margin') != null) value="{{ request()->get('margin') ?? 10}}" @endif type="text" name="margin" class="form-control" placeholder="Enter Margin %" Id="hike">
                                </div> --}}

                                {{-- Product Price Colllapsible --}}
                                <div class="container mt-3">
                                    <h6 class="collapsible" data-bs-toggle="collapse" data-bs-target="#ProductPriceList" aria-expanded="false" aria-controls="ProductPriceList">
                                        Product Price
                                       <i class="fas fa-chevron-down fa-xs"></i>
                                    </h6>
                                    {{-- <h6 class="widget-title m-3">Product Price</h6> --}}
                                    <div class="collapse" id="ProductPriceList">
                                    <div class="mx-3 d-flex">
                                        <input  style="width: 75px;height: 35px;" @if(request()->has('from') && request()->get('from') != null) value="{{ request()->get('from') }}" @endif type="number" min="0" name="from" class="form-control" placeholder=" ₹ Min">
                                        <input style="width: 75px;height: 35px;" @if(request()->has('to') && request()->get('to') != null) value="{{ request()->get('to') }}" @endif type="number" min="0" name="to" class="form-control ms-2" placeholder="₹ Max">
                                        {{-- <button class="price_go_btn ms-2" type="submit">GO</button> --}}
                                    </div>
                                </div>
                                </div>
                                {{-- Product Price Colllapsible End --}}


                                {{-- Product price Ashish --}}
                                {{-- <div class="widget">
                                    <h6 class="widget-title m-3">Product Price</h6>
                                    <div class="mx-3 d-flex">
                                        <input  style="width: 75px;height: 35px;" @if(request()->has('from') && request()->get('from') != null) value="{{ request()->get('from') }}" @endif type="number" min="0" name="from" class="form-control" placeholder=" ₹ Min">
                                        <input style="width: 75px;height: 35px;" @if(request()->has('to') && request()->get('to') != null) value="{{ request()->get('to') }}" @endif type="number" min="0" name="to" class="form-control ms-2" placeholder="₹ Max">
                                        {{-- <button class="price_go_btn ms-2" type="submit">GO</button> --}}
                                    {{-- </div>
                                </div>  --}}

                                {{-- <div class="widget"> --}}
                                    {{-- <h6 class="widget-title m-3">Quantity to Search</h6> --}}
                                    {{-- <div class="m-3 d-flex">
                                        <input  style="height: 35px; width: 75px" @if(request()->has('quantity') && request()->get('quantity') != null) value="{{ request()->get('quantity') }}" @endif type="text" name="quantity" class="form-control" placeholder="Qty">
                                    </div>
                                </div> --}}

                                {{-- categories Collapsible--}}

                                {{-- <div class="Container mt-3">
                                    <!-- Categories -->


                                            <h6 class="collapsible" data-bs-toggle="collapse" data-bs-target="#categoryList" aria-expanded="false" aria-controls="categoryList">
                                                Categories
                                              <i class="fas fa-chevron-down fa-xs"></i>
                                              </h6>
                                            <div class="collapse" id="categoryList">
                                                <ul class="list-unstyled mt-2 mb-0">
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
                                                                <h5 class="form-check">
                                                                    <input class="form-check-input filterCategory" type="radio" value="{{ $item->id }}" id="category{{ $item->id }}" name="category_id" @if((request()->has('category_id') && request()->get('category_id') ==  $item->id )) checked @endif>
                                                                    <label for="category{{ $item->id }}" class="form-check-label fltr-lbl   ">
                                                                        {{$item->name}}</label>
                                                                </h5>
                                                            </li>
                                                            @if(request()->has('category_id') && request()->get('category_id') ==  $item->id )
                                                                @php
                                                                    $subcategories = getProductSubCategoryByShop($slug, $item->id, 0);
                                                                @endphp
                                                                <div style="padding-left: 25px">
                                                                    <ul class="list-unstyled custom-scrollbar">
                                                                        @foreach ($subcategories as $subcategorie)
                                                                        <li>
                                                                            <h6 class="form-check">
                                                                                <input class="form-check-input filterSubCategory" type="radio" value="{{ $subcategorie->id }}" id="category{{ $subcategorie->id }}" name="sub_category_id" @if(request()->has('sub_category_id') && request()->get('sub_category_id') ==  $subcategorie->id) checked @endif>
                                                                                <label for="category{{ $subcategorie->id }}" class="form-check-label fltr-lbl">
                                                                                    {{$subcategorie->name}}</label>
                                                                            </h6>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>


                                </div> --}}
                                {{-- categories Collapsible End--}}

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
                                                <ul class="list-unstyled mt-2 mb-0 custom-scrollbar">
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
                                                            // $sub_categoryCount = ($sub_category != null) ? count($sub_category) : 0;
                                                            @endphp
                                                            <li>
                                                                <h5 class="form-check">
                                                                    <input class="form-check-input filterCategory" type="radio" value="{{ $item->id }}" id="category{{ $item->id }}" name="category_id" @if((request()->has('category_id') && request()->get('category_id') ==  $item->id )) checked @endif>
                                                                    <label for="category{{ $item->id }}" class="form-check-label fltr-lbl   ">
                                                                        {{$item->name}}</label>
                                                                </h5>
                                                            </li>
                                                            @if(request()->has('category_id') && request()->get('category_id') ==  $item->id )
                                                                @php
                                                                    $subcategories = getProductSubCategoryByShop($slug, $item->id, 0);
                                                                @endphp
                                                                <div style="padding-left: 25px">
                                                                    <ul class="list-unstyled custom-scrollbar">
                                                                        @foreach ($subcategories as $subcategorie)
                                                                        <li>
                                                                            <h6 class="form-check">
                                                                                <input class="form-check-input filterSubCategory" type="radio" value="{{ $subcategorie->id }}" id="category{{ $subcategorie->id }}" name="sub_category_id" @if(request()->has('sub_category_id') && request()->get('sub_category_id') ==  $subcategorie->id) checked @endif>
                                                                                <label for="category{{ $subcategorie->id }}" class="form-check-label fltr-lbl">
                                                                                    {{$subcategorie->name}}</label>
                                                                            </h6>
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


                            {{-- <h6 class="widget-title mt-2">Own Product</h6>
                            <input class="form-check-input" type="checkbox" value="yes" id="ownproduct"  name="ownproduct">
                            <label for="ownproduct" class="form-check-label fltr-lbl ">Own Product</label>
                            <br> --}}

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
                                <div class="container mt-3">
                                    <!-- Collapsible Button -->
                                    <h6 class="collapsible" data-bs-toggle="collapse" data-bs-target="#AttributeList" aria-expanded="false" aria-controls="AttributeList">
                                        {{ getAttruibuteById($item)->name }}
                                    <i class="fas fa-chevron-down fa-xs"></i>
                                    </h6>
                                    @php
                                        $atrriBute_valueGet = getParentAttruibuteValuesByIds($item,$proIds);
                                    @endphp
                                    <div class="collapse" id="AttributeList">
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
                                    @endforeach
                                @endif
                                {{-- Applying scoobooo layout in color and other attri End --}}

                        {{--` Make Filter As per SB  --}}
                        {{-- @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                           @foreach ($additional_attribute as $key => $item)
                            <h6 class="widget-title mt-2 mx-2"> {{ getAttruibuteById($item)->name }} </h6>
                            @php
                                $atrriBute_valueGet = getParentAttruibuteValuesByIds($item,$proIds);
                            @endphp
                            <ul class="list-unstyled mt-2 mb-0 custom-scrollbar mx-2" style="height: 60px;">
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
                                                {{ getAttruibuteValueById($mater)->attribute_value ?? '' }}
                                            </label>
                                        </h5>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                           @endforeach
                       @endif --}}






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

                        {{-- Exclusive Products --}}



                        </div>
                        <button type="submit" class="btn mt-2 d-block btn-primary w-100" id="filterBtn">Filter</button>
                        <a class="btn mt-2 d-block btn-primary w-100" href="{{ route('pages.proposal.edit',['proposal' => $proposalid,'user_key' => $user_key]) }}?margin=0" id="resetButton">Reset</a>
                    </form>
                </div>
            </div><!--end col-->


            {{-- main Content Box --}}
            <div class="col-lg-9 col-md-8 col-12 pt-2 mt-sm-0 pt-sm-0">

                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-7">
                            {{-- <div class="section-title">
                                <h5 class="mb-0">Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} Result</h5>
                            </div> --}}
                        </div><!--end col-->

                        <div class="col-lg-4 col-md-5 mt-sm-0 pt-2 pt-sm-0 mb-3">
                            <div class="container" id="selector">
                                <select class="form-control input-lg select_box" id="productSort" name="sort">
                                    <option @if(request()->get('sort') == 2) selected @endif value="2">Price: low to high</option>
                                    <option @if(request()->get('sort') == 1) selected @endif value="1">Latest First</option>
                                    <option @if(request()->get('sort') == 3) selected @endif value="3">Price: high to low</option>
                                </select>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-between gap-2 flex-wrap">
                        <div class="m-2 d-flex gap-2">
                            <button id="gridview" class="btn btn-outline-primary"><i class="fas fa-th-large"></i></button>
                            <button id="card" class="btn btn-outline-primary active"> <i class="fas fa-list"></i></button>
                        </div>
                        <div class="input-group mb-3 border rounded w-50">
                            <input type="text" id="quicktitle" value="{{ request()->get('title') }}" name="title" class="form-control border-0"  placeholder="Quick Search : Name or Model Code">
                            <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i class="uil uil-search"></i></button>
                        </div>

                        <div class="">
                            <a href="{{ route('pages.proposal.picked',['proposal' => $proposalid,'user_key' => $user_key]) }}?type=picked" class="btn btn-outline-primary" target="">Next</a>
                        </div>
                    </div>

                        @include('frontend.micro-site.proposals.load')
                        {{-- <div class="d-flex justify-content-center">
                            {{ $items->appends(request()->query())->links() }}
                        </div> --}}
                        <div class="row my-3">
                            <div class="col-8">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-outline-primary nextpage">Show More...</button>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('pages.proposal.picked',['proposal' => $proposalid,'user_key' => $user_key]) }}?type=picked" class="btn btn-outline-primary" target="">Next</a>
                                </div>
                            </div>
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

        $('#categoryAll').click(function(){
            url = "{{ route('pages.proposal.edit',['proposal' => $proposalid,'user_key' => $user_key]) }}?margin=0";
            window.location.href = url;
        });
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

            if (viewarea == "List") {
                // console.log("Ite is IN List View");
                $(document).find('#ajax-loading').show();
                var interval = 10;
                if($('.input-check').is(':checked')){
                    $('.input-check').click();

                    setTimeout(() => {
                            $(document).find('#ajax-loading').hide();
                    }, 5000);

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
                        }, 5000);
                    });
                }

            }else{
                // console.log("Ite is IN Grid View");
                $(document).find('#ajax-loading').show();
                var interval = 10;
                if($('.input-check1').is(':checked')){
                    $('.input-check1').click();

                    setTimeout(() => {
                            $(document).find('#ajax-loading').hide();
                    }, 5000);

                }else{
                    $('.filterable-items').each(function(){
                        if(!$(this).hasClass('d-none')){
                            setTimeout(() => {
                                $(this).find('.input-check1').trigger('click');
                            }, interval);
                            interval += 150;
                        }

                        setTimeout(() => {
                            $(document).find('#ajax-loading').hide();
                        }, 5000);
                    });
                }
            }


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




    {{-- Ajax Scroll Load --}}
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
                        if($('.input-check').is(':checked')){
                            $('.input-check').click();

                            setTimeout(() => {
                                    $(document).find('#ajax-loading').hide();
                            }, 5000);

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
                                }, 5000);
                            });
                        }
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
                        if($('.input-check').is(':checked')){
                            $('.input-check').click();

                            setTimeout(() => {
                                    $(document).find('#ajax-loading').hide();
                            }, 5000);

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
                                }, 5000);
                            });
                        }
                    });
                    // Code End

                }
            });


        });


    </script>


@endsection
