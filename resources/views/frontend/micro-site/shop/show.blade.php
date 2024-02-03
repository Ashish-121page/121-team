@extends('frontend.layouts.main')
@php
    $user_shop_item = getUserShopItemByProductId($slug, $product->id);
    $image_ids = $user_shop_item->images != null ? explode(',', $user_shop_item->images) : [];
    $price = $user_shop_item->price ?? 0;
    if ($group_id && $group_id != 0) {
        $price = getPriceByGroupIdProductId($group_id, $product->id, $price);
    }
    $phone_number = getSellerPhoneBySlug($slug);

    $record = App\Models\UserCurrency::where('currency', $product->base_currency)
        ->where('user_id', $user_shop->user_id)
        ->first();
    $exhangerate = Session::get('Currency_exchange') ?? 1;
    $HomeCurrency = $record->exchange ?? 1;

    $currency_symbol = Session::get('currency_name') ?? ($product->base_currency ?? 'INR');

@endphp

@section('meta_data')
    @php
        $meta_title = $user_product->title_user ?? $product->title . ' as low at ' . format_price($user_shop_item->price) . ' | Secured By ' . getSetting('app_name');
        $meta_description = '' ?? getSetting('seo_meta_description');
        $meta_keywords = '' ?? getSetting('seo_meta_keywords');
        $meta_motto = '' ?? getSetting('site_motto');
        $meta_abstract = '' ?? getSetting('site_motto');
        $meta_author_name = '' ?? 'GRPL';
        $meta_author_email = '' ?? 'Hello@121.page';
        $meta_reply_to = '' ?? getSetting('frontend_footer_email');
        $meta_img = asset(getMediaByIds($image_ids)->path ?? asset('frontend/assets/img/placeholder.png'));
        $microsite = 1;
    @endphp
    {{-- modal --}}

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
@endsection
<style>
    .table>:not(caption)>*>* {
        padding: 3px !important;
    }

    table th {
        text-transform: capitalize;
    }

    .slider-img {
        min-width: 95px !important;
        min-height: 95px !important;
        width: 95px !important;
        height: 95px !important;
        max-width: 95px !important;
        max-height: 95px !important;
        object-fit: contain;
    }

    .slider-zoom {
        width: auto !important;
        min-height: 345px !important;
        height: 345px !important;
        max-height: 345px !important;
        object-fit: contain !important;
    }

    /* modal */
    #btn-close-modal {
        width: 100%;
        text-align: center;
        cursor: pointer;
        color: #fff;
    }

    /* Add this CSS to your stylesheet or in a <style> tag in your HTML */
    .custom-spacing {
        margin-top: 20px;
        /* Adjust the margin-top value as needed */
    }

    ul {
        list-style-type: none;
    }




    @media (min-width: 768px) and (max-width: 991.98px) {
            .col-md-6.flex-wrap {
                flex-wrap: nowrap !important;
            }
        }
</style>

{{-- @dd($user_shop_item) --}}
@section('content')

    <section class="section">
        <ul class="nav justify-content-between">
            <div class="col-12 col-md-6 col-lg-6 col-sm-4">
                <div class="nav-item">
                    {{-- <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-0 me-2 mx-2"><i class="fas fa-chevron-left"></i> Back</a> --}}
                </div>
            </div>
            {{-- @if ($user_shop->user_id == auth()->id()) --}}
            <div class="col-12 col-md-6 col-lg-6 col-sm-8 d-flex justify-content-end">
                <li class="nav-item d-none">
                    <a class="nav-link active" aria-current="page" href="{{ route('panel.products.edit', $product->id) }}">
                        <button type="submit" class="btn btn-outline-primary mb-0 me-2"><i
                                class="far fa-edit"></i>Edit</button></a>
                </li>
            </div>
            {{-- @endif --}}

        </ul>

        <ul class="nav position-absolute end-0 px-5">
            <li><br>
                <div class="row">
                    <div class="container ">
                        <div>
                            Last update: <span>{{ now()->diffInDays(Carbon\Carbon::parse($product->updated_at)) }} Days
                                ago</span>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <div class="container my-5">
            <div class="row pt-lg-0 pt-md-3 pt-3">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                    <div class="single-pro-tab-content">
                        <div class="mb-3">
                            {{-- <button class="zoomBtn">
                                <img src="{{ asset('backend/img/move.png') }}" alt="" style="height: 30px;object-fit: contain;">
                            </button> --}}
                            {{-- <a href="{{ @asset(getMediaByIds($image_ids)->path ??'frontend/assets/img/placeholder.png') }}"  download="{{ $product->model_code }}" class="zoomBtn" style="background-color: transparent">
                                    <i class="fas fa-download text-dark fs-3"></i>
                                </a> --}}

                            @php
                                $ProductExinfo = App\Models\ProductExtraInfo::where('product_id', $product->id)->first();
                            @endphp

                            @if (($ProductExinfo->brand_name ?? '') != '')
                                <h5 class="text-muted">Brand: <span
                                        class="text-dark">{{ $ProductExinfo->brand_name }}</span> </h5>
                            @endif

                            {{-- @if (($product->material && $product->material != null) || ($user_product->materials && $user_product->materials != null))
                                    <h6 class="text-muted">Material : {{ $user_product->materials ?? $product->material }}</h6>
                                @endif --}}

                            <h6 class="text-info">
                                <a class="m-0 p-0 btn-link text-muted"
                                    href="{{ inject_subdomain('shop', $user_shop->slug) }}?sort=&category_id={{ $user_product->category_id }}&from=&to=">{{ fetchFirst('App\Models\Category', $user_product->category_id, 'name', '') }}</a>
                                /
                                <a class="m-0 p-0 btn-link text-muted"
                                    href="{{ inject_subdomain('shop', $user_shop->slug) }}?sort=&category_id={{ $user_product->category_id }}&sub_category_id={{ $user_product->sub_category_id }}&from=&to=">{{ fetchFirst('App\Models\Category', $user_product->sub_category_id, 'name', '') }}</a>
                            </h6>

                            <img class="slider-zoom zoom zoomImg"
                                src="{{ @asset(getMediaByIds($image_ids)->path ?? 'frontend/assets/img/placeholder.png') }}"
                                style="cursor: pointer;" alt="product-image">
                        </div>
                        <!-- Nav tabs -->
                        <div class="tiny-four-item">
                            @foreach (getMediaByIds($image_ids, 'all') as $media)
                                <div class="tiny-slide btn btn-link slider-zoom-selector"
                                    data-img="{{ asset($media->path) }}">
                                    <img src="{{ asset($media->path ? $media->path : 'frontend/assets/img/placeholder.png') }}"
                                        class="img-fluid slider-img rounded" alt="product-image">
                                </div>
                            @endforeach
                        </div>


                        <div class="col-12 col-sm-6 col-md-6 d-flex d-lg justify-content-between gap-3 w-100 mt-3 flex-wrap">
                            {{-- @if ($user_shop->user_id == auth()->id()) --}}
                            <a class="btn btn-outline-primary" aria-current="page"
                                href="{{ route('panel.products.edit', $product->id) }}" target="_parent">Edit</a>
                            {{-- @endif --}}
                            <a class="btn btn-outline-primary" id="sharebtn" href="#sharemodal" role="button">
                                Share
                            </a>
                            {{-- @if ($product->user_id == auth()->id()) --}}
                            <a class="btn btn-outline-primary" id="demo01" href="#animatedModal" role="button"
                                style="">Internal Details</a>
                            {{-- @endif --}}
                            {{-- <div class="row">
                                {{-- <a href="{{ @asset(getMediaByIds($image_ids)->path ??'frontend/assets/img/placeholder.png') }}"  download="{{ $product->model_code }}" class="zoomBtn" style="background-color: transparent; top: 85%! important">
                                    <i class="fas fa-download text-dark fs-3"></i>
                                </a> --}}
                            {{-- </div> --}}
                            <a href="{{ @asset(getMediaByIds($image_ids)->path ?? 'frontend/assets/img/placeholder.png') }}"
                                download="{{ $product->model_code }}" class=""
                                style="background-color: transparent; top: 85%! important">
                                <i class="fas fa-download text-dark fs-3"></i>
                            </a>

                            @if ($proposalidrequest != 0)
                                <a class="btn btn-outline-primary" id="addofferitem"
                                    href="{{ route('pages.api.store') }}?product_id={{ $product->id }}&proposal_id={{ $proposalidrequest }}&hike=0">
                                    Add in Offer
                                </a>
                            @endif



                        </div>

                    </div>
                </div>


                <div class="col-lg-7 col-md-7 col-sm-7 mt-sm-0 pt-2 pt-sm-0">
                    <div class="section-title ms-md-4 ">
                        {{-- Existing content --}}

                        <div class="row">
                            <div class="section-title col-12 col-md-12 col-sm-12 my-2">
                                <h4 class="title mb-0">

                                    @if ($user_product->title_user != null)
                                        {{ $user_product->title_user }}
                                    @else
                                        {{ $product->title }}
                                    @endif
                                </h4>
                                <span class="text-muted">{{ getProductRefIdByRole($product, $user_shop_item, 2) }}</span>

                                <div class="containe-fluid">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 justify-content-between">
                                            @if ($product->stock_qty > 0)
                                                <span>,</span>
                                                <span class="text-success" style="font-weight: 600;"><small>In
                                                        Stock</small></span>
                                            @endif
                                            <h5 class="text-muted my-2">
                                                {{ $currency_symbol . ' ' . round(exchangerate($price, $exhangerate, $HomeCurrency), 2) }}
                                                &nbsp;&nbsp;&nbsp;
                                                MRP : <strike>
                                                    {{ $currency_symbol . ' ' . round(exchangerate($product->mrp, $exhangerate, $HomeCurrency), 2) }}
                                                </strike>
                                            </h5>

                                        </div>

                                        {{-- <div class="col-12 col-sm-6 col-md-6 d-flex justify-content-end gap-3 align-items-center"> --}}
                                        {{-- <a class="btn btn-outline-primary" id="sharebtn" href="#sharemodal" role="button">
                                                Share <i class="fas fa-share"></i>
                                            </a> --}}
                                        {{-- @if ($product->user_id == auth()->id()) --}}
                                        {{-- <a class="btn btn-outline-primary" id="demo01" href="#animatedModal" role="button">Internal Details</a> --}}
                                        {{-- @endif --}}
                                        {{-- </div> --}}

                                        <div
                                            class="col-12 col-sm-6 col-md-6 d-flex justify-content-start gap-3 align-items-center">
                                            <div class="d-flex mb-2">
                                                <div class="container" id="selector"
                                                    style="width: max-content !important;">
                                                    <select class="form-control select_box w-auto" id="changeCurrency"
                                                        name="Currency">
                                                        <option aria-readonly="true" disabled>Change Currency</option>
                                                        @foreach ($currency_record as $item)
                                                            <option value="{{ $item->id }}"
                                                                @if ($item->id == (Session::get('Currency_id') ?? 'INR')) selected @endif>
                                                                {{ $item->currency }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>





                                    </div>
                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        {{-- dropdown for currency start --}}
                                        @php
                                            $currencies = App\Models\Country::get();
                                        @endphp
                                        <div class="d-none">
                                            <select class="form-select" id="currency" name="currency"
                                                style="width: max-content !important; height: 100%;">
                                                <option> Select currency
                                                </option>
                                                @foreach ($currencies as $item)
                                                    <option width="25px" value="{{ $item->currency }}">
                                                        {{ $item->currency . ' - ' . $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div class="">
                                            <a class="btn btn-outline-primary" id="demo01" href="#animatedModal" role="button">Internal Details</a>
                                        </div> --}}
                                    </div>



                                </div>
                            </div>
                        </div>

                        <form method="GET" id="searchForm">

                            {{-- color, size, material dropdowns --}}
                            <div class="d-flex gap-2 flex-wrap">
                                {{-- <div class="">
                                    <select name="selected_default[]" class="form-control form-select" id="selected_3">
                                        <option value="" @if ($result_attri != null) disabled @endif>Select Group id</option>
                                        @foreach ($groupIds as $material)
                                            <option value="{{ $material }}"
                                            >{{ $material }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="d-none">
                                    <button class="collapsed btn btn-icon btn-outline-primary p-2 rounded-circle"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#attributeval-1"
                                        aria-expanded="false" aria-controls="attributeval-1" title="Load More">
                                        {{-- <i class="fas fa-plus"></i>  --}}
                                        <i class="fas fa-angle-down"></i>
                                    </button>
                                    @if ($result_attri != null)
                                        <a href="{{ request()->url() }}"
                                            class="btn btn-outline-danger btn-icon rounded-circle" title="Reset">
                                            <i class="fas fa-undo"></i>
                                        </a>
                                    @endif
                                </div>

                                @foreach ($attributes as $key => $attribute)
                                    @php
                                        $attribute_values = App\Models\ProductExtraInfo::where('group_id', $product->sku)
                                            ->where('attribute_id', $attribute['id'])
                                            ->groupBy('attribute_value_id')
                                            ->get();
                                    @endphp

                                    @if ($attribute['name'] == '' || $attribute['name'] == null)
                                        @continue
                                    @endif


                                    @if (count($attribute_values) != 0)
                                        <div class="form-group">
                                            <label for="selected_Cust"
                                                @if (count($attribute_values) > 1) style="color:#6666cc;font-weight: bold" @endif>
                                                {{ $attribute['name'] }} @if (count($attribute_values) > 1)
                                                    *
                                                @endif </label>
                                            <select class="form-control form-select" style="width: max-content"
                                                name="selected_Cust[]">
                                                @foreach ($attribute_values as $attribute_value)
                                                    @if ($attribute_value != '')
                                                        <option value="{{ $attribute_value->attribute_value_id ?? '' }}"
                                                            @if ($result_attri != null) {{ in_array($attribute_value->attribute_value_id, request()->get('search_keywords')) ? 'Selected' : '' }}
                                                            {{ in_array($attribute_value->attribute_value_id, $result_attri) ? '' : 'disabled' }} @endif>
                                                            {{ getAttruibuteValueById($attribute_value->attribute_value_id)->attribute_value ?? '' }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                @endforeach
                            </div>


                            {{-- ` Start of first accordion for extra attributes --}}
                            {{-- <div class="accordion accordion-flush mt-3 w-lg-50" id="moreattributes"> --}}
                            {{-- Item Start --}}
                            {{-- <div class="accordion-item shadow-none">
                                    <div id="attributeval-1" class="accordion-collapse collapse show" data-bs-parent="#moreattributes">
                                        <div class="accordion-body">
                                            <div class="d-flex flex-wrap gap-3">
                                                @foreach ($attributes as $key => $attribute)
                                                    @php
                                                        $attribute_values = App\Models\ProductExtraInfo::where('group_id',$product->sku)->where('attribute_id',$attribute->id)->groupBy('attribute_value_id')->get();
                                                    @endphp
                                                    @if ($key < 3)
                                                        @continue
                                                    @endif
                                                    @if (count($attribute_values) != 0)
                                                    <div class="form-group">
                                                        <label for="selected_Cust" @if (count($attribute_values) > 1) style="color:#6666cc;font-weight: bold" @endif> {{ $attribute->name }} @if (count($attribute_values) > 1) * @endif </label>
                                                        <select class="form-control form-select" style="width: max-content"
                                                        name="selected_Cust[]">
                                                            @foreach ($attribute_values as $attribute_value)
                                                                @if ($attribute_value != '')
                                                                    <option value="{{ $attribute_value->attribute_value_id ?? ''}}"
                                                                    @if ($result_attri != null)
                                                                        {{( in_array($attribute_value->attribute_value_id,request()->get('search_keywords'))) ? 'Selected' : '' }}
                                                                        {{(in_array($attribute_value->attribute_value_id,$result_attri)) ? "" : 'disabled'}}
                                                                    @endif  >
                                                                        {{ getAttruibuteValueById($attribute_value->attribute_value_id)->attribute_value ?? ''}}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
                            {{-- Item End --}}
                            {{-- </div> --}}

                            {{-- ` End of first accordion for extra attributes  --}}

                        </form>


                        <div class="row">
                            <div class="col-lg-12 col-md-12 d-flex justify-content-between">
                                <div class="mt-2 pt-2">
                                    <form action="{{ route('pages.add-cart', [$slug, 'product_id=' . $product->id]) }}"
                                        method="POST" class="mb-0">
                                        @csrf
                                        <input type="hidden" name="unit_price" value="{{ $price }}">
                                    </form>
                                </div>
                            </div>

                            <div class="col-12 mt-1">
                                @if ($user_shop_item->description != null)
                                    <h6 class="mb-3">Description:</h6>
                                    <p class="">{!! html_entity_decode(preg_replace('/_x([0-9a-fA-F]{4})_/', '&#x$1;', $user_shop_item->description)) ?? '' !!}</p>
                                @elseif($product->description != null)
                                    <div class="row">
                                        {{-- acoordion for add info start --}}
                                        <div class="col-12">

                                            {{-- <div class="accordion" id="accordionDescription"></div> --}}
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapsedesc"
                                                        aria-expanded="false" aria-controls="collapsedesc">
                                                        Description
                                                    </button>
                                                </h2>
                                                <div id="collapsedesc" class="accordion-collapse collapse"
                                                    data-bs-parent="">
                                                    <div class="accordion-body">
                                                        {!! html_entity_decode(preg_replace('/_x([0-9a-fA-F]{4})_/', '&#x$1;', $product->description)) ?? '' !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- ` Another Part TAX --}}

                                <div class="row">
                                    {{-- acoordion for add info start --}}
                                    <div class="col-12">
                                        <div class="accordion-item mt-3">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseAdditional"
                                                    aria-expanded="false" aria-controls="collapseAdditional">
                                                    Additional Details
                                                </button>
                                            </h2>
                                            <div id="collapseAdditional" class="accordion-collapse collapse">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-12">
                                                            <table class="table table-striped mt-3 border"
                                                                style="width: 90%;">
                                                                <tbody>
                                                                    <tr>
                                                                        <img style="height: 230px;"
                                                                            src="{{ asset('frontend/assets/img/product/item.jpg') }}"
                                                                            alt="">
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Product Length</th>
                                                                        <td>{{ ($shipping_details['length'] ?? '') . ' ' . ($shipping_details['length_unit'] ?? '') ?? '--' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Product Width</th>
                                                                        <td>{{ ($shipping_details['width'] ?? '') . ' ' . ($shipping_details['length_unit'] ?? '') ?? '--' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Product Height</th>
                                                                        <td>{{ ($shipping_details['height'] ?? '') . ' ' . ($shipping_details['length_unit'] ?? '') ?? '--' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Gross Weight</th>
                                                                        <td>{{ ($shipping_details['gross_weight'] ?? '') . ' ' . ($shipping_details['unit'] ?? '') ?? '--' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Net Weight</th>
                                                                        <td>{{ ($shipping_details['weight'] ?? '') . ' ' . ($shipping_details['unit'] ?? '') ?? '--' }}
                                                                        </td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        {{-- carton table --}}

                                                        @if (
                                                            ($carton_details['standard_carton'] ?? '') == '' &&
                                                                ($carton_details['carton_unit'] ?? '') == '' &&
                                                                ($carton_details['carton_weight'] ?? '') == '')
                                                            {{-- Nothing To Show Here     --}}
                                                        @else
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <table class="table table-striped mt-3 border"
                                                                    style="width: 90%;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <img style="height: 230px;"
                                                                                src="{{ asset('frontend/assets/img/product/carton.jpg') }}"
                                                                                alt="">
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Carton Length</th>
                                                                            <td>{{ ($carton_details['carton_length'] ?? '') . ' ' . ($carton_details['Carton_Dimensions_unit'] ?? '') ?? '--' }}
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th>Carton width</th>
                                                                            <td>{{ ($carton_details['carton_width'] ?? '') . ' ' . ($carton_details['Carton_Dimensions_unit'] ?? '') ?? '--' }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Carton Height</th>
                                                                            <td>{{ ($carton_details['carton_height'] ?? '') . ' ' . ($carton_details['Carton_Dimensions_unit'] ?? '') ?? '--' }}
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th>standard carton</th>
                                                                            <td>{{ ($carton_details['standard_carton'] ?? '') . ' pcs' ?? '--' }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>carton weight actual</th>
                                                                            <td>{{ ($carton_details['carton_weight'] ?? '') . ' ' . ($carton_details['carton_unit'] ?? '') ?? '--' }}
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- accordion end --}}
                                    </div>

                                    @if ($product['hsn_percent'] != '' || $product['hsn'] != '')
                                        <div class="col-12">
                                            <div class="accordion-item mt-3">
                                                <h2 class="accordion-header ">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTax"
                                                        aria-expanded="false" aria-controls="collapseTax">
                                                        Tax
                                                    </button>
                                                </h2>
                                                <div id="collapseTax" class="accordion-collapse collapse text-bg-primary"
                                                    data-bs-parent="">
                                                    <div class="accordion-body justify-content-center">
                                                        <div class="col-12">
                                                            <table
                                                                class="table table-striped border justify-content-between"
                                                                style="width: 100% !important;">
                                                                <tbody>
                                                                    @if ($product['hsn_percent'])
                                                                        <tr>
                                                                            <th>HSN %</th>
                                                                            <td>{{ $product['hsn_percent'] ?? '' }} %</td>
                                                                        </tr>
                                                                    @endif
                                                                    @if ($product['hsn'])
                                                                        <tr>
                                                                            <th>HSN</th>
                                                                            <td>{{ $product['hsn'] ?? '' }}</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="row my-3 ">
                                    <div class="col-12">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseAssets"
                                                    aria-expanded="false" aria-controls="collapseAssets">
                                                    Assets
                                                </button>
                                            </h2>
                                            <div id="collapseAssets" class="accordion-collapse collapse"
                                                data-bs-parent="">
                                                <div class="accordion-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr style="vertical-align:middle;">
                                                                <th scope="col-1">#</th>
                                                                <th scope="col-2">Asset Name</th>
                                                                <th scope="col-3">File Size</th>
                                                                <th scope="col-4"></th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                            @php
                                                                $NotInType = ['jpg', 'jpeg', 'png', 'avif'];
                                                                // $linkedAssets = App\Models\Media::where('type_id',$product->id)->where('type','Product')->where('tag','!=','Product_Image')->get();
                                                                $linkedAssets = App\Models\Media::where('type_id', $product->id)
                                                                    ->where('type', 'Product')
                                                                    ->whereNotIn('extension', $NotInType)
                                                                    ->orderBy('file_type', 'DESC')
                                                                    ->get();
                                                            @endphp

                                                            @forelse ($linkedAssets as $item)
                                                                @php
                                                                    $path = str_replace('storage', 'public', $item->path);
                                                                    if (Storage::exists($path)) {
                                                                        $filename = basename($path);
                                                                    } else {
                                                                        continue;
                                                                    }
                                                                @endphp
                                                                <tr style="vertical-align:middle;">
                                                                    <td> {{ $loop->iteration }} </td>
                                                                    <td> {{ $filename }} </td>
                                                                    <td> {{ number_format(Storage::size($path) / (1024 * 1024), 2) }}
                                                                        MB </td>
                                                                    <td>
                                                                        <a href="{{ asset($item->path) }}"
                                                                            download="{{ $filename }}"
                                                                            class="btn btn-link">Download</a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                            @endforelse



                                                        </tbody>



                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div class="col-12 d-flex flex-wrap mt-3">
                                <div class="col-6">
                                    @if ($product->artwork_url != null || $user_shop_item->artwork_url != null)
                                        <h6 class="mb-1 mt-2">Artwork outline:</h6>
                                        <a href="{!! $product->artwork_url ?? $user_shop_item->artwork_url !!}"
                                            title="Artwork Reference of {!! $product->title ?? $user_shop_item->title !!}"
                                            class="btn btn-outline-primary my-2" target="_blank">Download</a>
                                    @endif
                                </div>
                                <div class="col-6">
                                    @if ($product->video_url != null || $user_shop_item->video_url != null)
                                        <h6 class="mb-1 mt-2">Video Url</h6>
                                        <a href="{!! $product->video_url ?? $user_shop_item->video_url !!}"
                                            title="Artwork Reference of {!! $product->title ?? $user_shop_item->title !!}"
                                            class="btn btn-outline-primary my-2" target="_blank">Watch</a>
                                    @endif
                                </div>
                            </div>





                            <div class="col-12">
                                @if ($features != null)
                                    <div class="mt-3 mb-3">
                                        <h6 class="mb-1">Features:</h6>
                                        <div class="d-flex align-items-center">
                                            <ul class="list-unstyled text-muted">
                                                @foreach (explode(PHP_EOL, $features) as $feature)
                                                    <li class="mb-1"><span class="text-primary h5 me-2"><i
                                                                class="uil uil-check-circle align-middle"></i></span>{{ $feature }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->




            <div class="col-12 d-none">

                @if (
                    ($carton_details['standard_carton'] ?? '') == '' &&
                        ($carton_details['carton_unit'] ?? '') == '' &&
                        ($carton_details['carton_weight'] ?? '') == '' &&
                        ($shipping_details['length'] ?? '') == '' &&
                        ($shipping_details['width'] ?? '') == '' &&
                        ($shipping_details['height'] ?? '') == '' &&
                        ($shipping_details['weight'] ?? '') == '')
                    {{-- <span>No Details Are Avaiable of This Product Right Now</span> --}}
                @else
                    {{-- original content --}}

                    {{-- <h5 class="mb-4">Additional Information:</h5> --}}
                    {{-- original content end --}}
                    {{-- tax badge --}}

                    <div class="row">
                        <div class="col-2">
                            <div class="accordion-item mt-3" style="margin-left: 20px;">
                                <h2 class="accordion-header ">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTax" aria-expanded="false" aria-controls="collapseTax">
                                        Tax
                                    </button>
                                </h2>
                                <div id="collapseTax" class="accordion-collapse collapse text-bg-primary"
                                    data-bs-parent="">
                                    <div class="accordion-body justify-content-center">
                                        @if (
                                            $shipping_details['length'] == '' &&
                                                $shipping_details['width'] == '' &&
                                                $shipping_details['height'] == '' &&
                                                $shipping_details['weight'] == '')
                                            {{-- if Everything is Blank Then Show NOthing --}}
                                        @else
                                            <div class="col-lg-6 col-md-6 col-12 ">

                                                <table class="table table-striped border justify-content-between"
                                                    style="width: 100% !important;">
                                                    <tbody>
                                                        @if ($product['hsn_percent'])
                                                            <tr>
                                                                <th>HSN %</th>
                                                                <td>{{ $product['hsn_percent'] ?? '' }} %</td>
                                                            </tr>
                                                        @endif
                                                        @if ($product['hsn'])
                                                            <tr>
                                                                <th>HSN</th>
                                                                <td>{{ $product['hsn'] ?? '' }}</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <button type="button" class="btn btn-primary">
                                        Tax <span class="badge text-bg-secondary"></span>
                                    </button> --}}

                        </div>
                        {{-- ` acoordion for add info start --}}
                        <div class="col-10">
                            <div class="accordion-item mt-3" style="margin-right: 50px;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseAdditional" aria-expanded="false"
                                        aria-controls="collapseAdditional">
                                        Additional Details :
                                    </button>
                                </h2>
                                <div id="collapseAdditional" class="accordion-collapse collapse" data-bs-parent="">
                                    <div class="accordion-body">
                                        <code>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <table class="table table-striped mt-3 border" style="width: 55%;">
                                                        <tbody>
                                                            <tr>
                                                                <img style="height: 230px;"
                                                                    src="{{ asset('frontend/assets/img/product/item.jpg') }}"
                                                                    alt="">
                                                            </tr>
                                                            <th>Length</th>
                                                            <td>{{ $shipping_details['length'] ?? '' }}</td>
                                                            <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Width</th>
                                                                <td>{{ $shipping_details['width'] ?? '' }}</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Height</th>
                                                                <td>{{ $shipping_details['height'] ?? '' }} </td>
                                                                <td></td>
                                                            </tr>
                                                            @if (isset($shipping_details) && @($shipping_details['length_unit'] ?? ''))
                                                                <tr>
                                                                    <th>Length unit</th>
                                                                    <td>{{ $shipping_details['length_unit'] ?? ('' ?? '') }}
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <th>Weight</th>
                                                                <td>{{ $shipping_details['weight'] ?? '' }}</td>
                                                                <td></td>
                                                            </tr>
                                                            @if (isset($shipping_details) && @$shipping_details['unit'])
                                                                <tr>
                                                                    <th>Unit</th>
                                                                    <td>{{ $shipping_details['unit'] ?? '' }}</td>
                                                                    <td></td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                @endif

                {{-- carton table --}}

                @if (
                    $carton_details['standard_carton'] == '' &&
                        $carton_details['carton_unit'] == '' &&
                        $carton_details['carton_weight'] == '')
                    {{-- Nothing To Show Here     --}}
                @else
                    <div class="col-lg-6 col-md-6 col-12">
                        <table class="table table-striped mt-3 border" style="width: 55%;">
                            <tbody>
                                <tr>
                                    <img style="height: 230px;"
                                        src="{{ asset('frontend/assets/img/product/carton.jpg') }}" alt="">
                                </tr>
                                <tr>
                                    <th>Length</th>
                                    <td>{{ $carton_details['length'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Width</th>
                                    <td>{{ $carton_details['width'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Height</th>
                                    <td>{{ $carton_details['height'] ?? '' }} </td>
                                </tr>
                                @if (isset($carton_details) && @$carton_details['length_unit'])
                                    <tr>
                                        <th>Length unit</th>
                                        <td>{{ $carton_details['length_unit'] ?? '' }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Weight</th>
                                    <td>{{ $carton_details['weight'] ?? '' }}</td>
                                </tr>
                                @if (isset($carton_details) && @$carton_details['unit'])
                                    <tr>
                                        <th>Unit</th>
                                        <td>{{ $carton_details['unit'] ?? '' }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Standard Carton</th>
                                    <td>{{ $carton_details['standard_carton'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>UMO</th>
                                    <td>{{ $carton_details['carton_unit'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Carton Actual Weight</th>
                                    <td>{{ $carton_details['carton_weight'] ?? '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
            </code>
        </div>
        </div>
        </div>
        {{-- accordion end --}}
        </div>
        {{-- ` acoordion for add info End --}}
        </div>
        @endif


        </div>
        </div><!--end row-->
        </div><!--end container-->

        @if ($related_products->count() > 0)
            <div class="container mt-100 mt-60">
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-0">Related Products</h5>
                    </div><!--end col-->
                    <div class="col-12 mt-4 mb-4">
                        <div class="row">
                            @forelse ($related_products as $related_product)
                                @php
                                    $user_shop_item = getUserShopItemByProductId($slug, $related_product->id);
                                    $image_ids = $user_shop_item->images != null ? explode(',', $user_shop_item->images) : [];
                                    if ($group_id && $group_id != 0) {
                                        $related_price = getPriceByGroupIdProductId($group_id, $related_product->id, $price);
                                    }
                                @endphp
                                <div class="tiny-slide col-lg-3 col-md-4 col-12">
                                    <div class="card shop-list border-0 position-relative m-2">
                                        <ul class="label list-unstyled mb-0">
                                            <li><a href="javascript:void(0)"
                                                    class="badge badge-link rounded-pill bg-danger">Hot</a></li>
                                        </ul>
                                        <div class="shop-image position-relative overflow-hidden rounded shadow">
                                            @php
                                                $relatedProId = \Crypt::encrypt($related_product->id);
                                            @endphp
                                            <a href="{{ route('pages.shop-show', $relatedProId) }}">
                                                <img src="{{ asset(getMediaByIds($image_ids)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                                                    class="img-fluid" alt=""
                                                    style="width: 100%;height: 145px;object-fit: contain;">
                                            </a>
                                            <ul class="list-unstyled shop-icons">
                                                <li class="mt-1"><a
                                                        href="{{ route('pages.shop-show', $relatedProId) }}"
                                                        class="btn btn-icon btn-pills btn-soft-primary"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-eye icons">
                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg></a></li>
                                                <form action="{{ route('pages.add-cart') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="unit_price"
                                                        value="{{ $related_price ?? '0' }}">
                                                    <input type="hidden" name="qty" value="1">
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $related_product->id ?? '0' }}">
                                                    {{-- <li class="mt-2">
                                                        <button type="submit" class="btn btn-icon btn-pills btn-soft-warning">
                                                            <x-icon name="shopping-cart" class="feather feather-shopping-cart icons" />
                                                        </button>
                                                    </li> --}}
                                                </form>
                                            </ul>
                                        </div>
                                        <div class="card-body content pt-4 p-2">
                                            <a href="{{ route('pages.shop-show', $relatedProId) . '?pg=' . request()->get('pg') }}"
                                                class="text-dark product-name h6">{{ \Str::limit($related_product->title, 30) }}</a>
                                            <div class="mt-1">

                                                <ul class="list-unstyled mb-0 ms-0 d-flex">
                                                    <li class="list-inline-item text-muted">
                                                        {{ $related_product->color }}
                                                    </li>
                                                    <li class="list-inline-item ms-2 text-muted">
                                                        {{ $related_product->size }}
                                                    </li>
                                                </ul>
                                                <h6 class="text-dark small fst-italic mb-0 mt-1">
                                                    @if ($user_shop_item->price)
                                                        {{ format_price($user_shop_item->price) }}
                                                    @else
                                                        <span>{{ format_price(0) }}</span>
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
                {{-- start new row to test color and size in different style --}}
                <div class="row">
                    @forelse ($items as $user_shop_item)
                        @php
                            $product = getProductDataById($user_shop_item->product_id);
                            $image_ids = $user_shop_item->images != null ? explode(',', $user_shop_item->images) : [];
                            $price = $user_shop_item->price ?? 0;
                            if ($group_id && $group_id != 0) {
                                $price = getPriceByGroupIdProductId($group_id, $product->id, $price);
                            }
                        @endphp
                        {{-- @dd($product); --}}
                        <div class="col-lg-3 col-md-4 col-12 pt-2">
                            <div class="card shop-list border-0 position-relative">
                                <div class="shop-image position-relative overflow-hidden rounded shadow">
                                    @php
                                        $productId = \Crypt::encrypt($product->id);
                                    @endphp
                                    <a target="_blank"
                                        href="{{ route('pages.shop-show', $productId) . '?pg=' . request()->get('pg') }}">
                                        <img src="{{ asset(getMediaByIds($image_ids)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                                            class="img-fluid " style="height: 150px;width: 100%;object-fit: contain;"
                                            alt="">
                                    </a>
                                    <ul class="list-unstyled shop-icons">
                                        <li class="mt-1">
                                            <a href="{{ route('pages.shop-show', $productId) . '?pg=' . request()->get('pg') }}"
                                                class="btn btn-icon btn-pills btn-soft-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-eye icons">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
                                        </li>

                                        @if ($price != 0)
                                            <form action="{{ route('pages.add-cart') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="unit_price" value="{{ $price }}">
                                                <input type="hidden" name="qty" value="1">
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                {{-- <li class="mt-2">
                                                <button type="submit" class="btn btn-icon btn-pills btn-soft-warning">
                                                    <x-icon name="shopping-cart" class="feather feather-shopping-cart icons" />
                                                </button>
                                            </li> --}}
                                            </form>
                                        @endif
                                    </ul>
                                </div>
                                <div class="card-body content pt-4 p-2 text-center">
                                    <h6 class="text-dark small fst-italic mb-0 mt-1">
                                        {{-- @dd($price); --}}
                                        @if ($price == 0)
                                            <span>{{ __('Ask For Price') }}</span>
                                        @elseif($price)
                                            {{ format_price($price) }}
                                        @else
                                            {{-- <span>{{ format_price(0) }}</span> --}}
                                            <span>{{ __('Ask For Price') }}</span>
                                        @endif
                                    </h6>
                                    <a target="_blank"
                                        href="{{ route('pages.shop-show', $productId) . '?pg=' . request()->get('pg') }}"
                                        class="text-dark product-name h6">{{ \Str::limit($product->title, 30) }}</a>
                                    <div>
                                        {{-- <span>{{ $product->color }}</span> @if (isset($product->size)) , @endif<span>{{ $product->size }}</span> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12 mx-auto text-center mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <i class="fa text-primary fa-lg fa-shopping-cart">
                                    </i>
                                    <p>Alter filter conditions, no products matching the search criteria.</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-center">
                    {{ $items->appends(request()->query())->links() }}
                </div>
            </div><!--end container-->
        @endif
        @include('frontend.micro-site.shop.include.enquiry-modal')
        @include('frontend.micro-site.shop.include.zoom-image')
        @include('frontend.micro-site.shop.include.social-share')

        {{-- @if ($user_shop->user_id == auth()->id()) --}}
        {{-- Model Include of Addional Detail of Product --}}
        @include('frontend.micro-site.shop.include.Additional_details')
        {{-- Model Include of Addional Detail of Product --}}
        {{-- @endif --}}


    </section><!--end section-->
    @include('frontend.micro-site.shop.include.bulk', ['product_id' => $product->id])
@endsection
@section('InlineScript')
    <script>
        $(document).ready(function() {
            // $("#demo01").click(); // ! Remove This After Done
            $("select").change(function(e) {
                e.preventDefault();
                $("#searchForm").submit();
            });


            $("#sharebtn").click(function(e) {
                e.preventDefault();
                $("#socialShareModal").modal('show');

            });

            $("#addofferitem").click(function(e) {
                e.preventDefault();
                var url = $(this).attr('href');

                var msg =
                    `
                <span>You can add some notes for this product in your offer.</span>
                <input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Note'>`;

                $.confirm({
                    draggable: true,
                    title: `Offer Note`,
                    content: msg,
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Add Now',
                            btnClass: 'btn-outline-primary  border border-primary',
                            action: function() {
                                let margin = $('#margin').val();
                                window.location.href = url + '&offernotes=' + margin;
                            }
                        },
                        close: function() {
                            $.alert("You Closed Modal")
                        }
                    }
                });
            });


        });
    </script>


    <script>
        $(document).ready(function() {
            // Ashish ka URl

            $('.bulkbtn').on('click', function() {
                $('#BuyBulk').modal('show');
            });
            $('.zoomImg').on('click', function() {
                var imageSrc = $('.slider-zoom').attr('src');
                $('#zoomImageContainer').attr('src', imageSrc)
                $('#zoomImageModal').modal('show');
            });
            $('.enquiryModal').on('click', function() {
                $('#enquiryModal').modal('show');
            });
            $('.slider-zoom-selector').on('click', function() {
                $('.slider-zoom').attr('src', $(this).attr('data-img'));
            });
            $('#enquiryForm').on('submit', function(e) {
                e.preventDefault();
                var price = $('#price').val();
                var pModelCode = "{{ urlencode(getProductRefIdByRole($product, $user_shop_item, 2)) }}";
                var pName = "{{ urlencode($product->title) }}";
                var colorSize = "{{ urlencode($product->color . ' ' . $product->size) }}";
                var qty = $('#enq-qty').val();
                var requiredIn = $('#requiredIn').val();
                var comment = $('#comment').val();
                var enquiry = 'Hi, I am interested in the ' + pModelCode + ' | ' + pName + ' ' + colorSize +
                    '  Could you let me know if I can buy ' + qty + ' units by ' + requiredIn +
                    ' at a price of ' + price + '₹ per unit? ';
                var url = 'https://api.whatsapp.com/send?phone={{ $phone_number }}&text=' + enquiry;
                window.location.href = url;
            });
        });
    </script>
    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
    <script>
        //demo 01
        $("#demo01").animatedModal({
            animatedIn: 'lightSpeedIn',
            animatedOut: 'bounceOutDown',
            color: '#f3f3f3',

        });
    </script>

    @if (session('success'))
        <script>
            $.toast({
                heading: 'SUCCESS',
                text: "{{ session('success') }}",
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'top-right'
            });
        </script>
    @endif


    @if (session('error'))
        <script>
            $.toast({
                heading: 'ERROR',
                text: "{{ session('error') }}",
                showHideTransition: 'slide',
                icon: 'error',
                loaderBg: '#f2a654',
                position: 'top-right'
            });
        </script>
    @endif
@endsection
