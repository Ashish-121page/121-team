@extends('backend.layouts.main')
@section('title', 'Proposal')
@section('content')
    @php
    
    $breadcrumb_arr = [['name' => 'Edit Proposal', 'url' => 'javascript:void(0);', 'class' => '']];
    $user = auth()->user();
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error {
                color: red;
            }
            
            #file-input{
                padding:10px;
                background-color:#6666CC;
                color: #fff;
            }
            .image-preview{
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



        </style>
    @endpush
@php
    $customer_details = json_decode($proposal->customer_details) ?? '';
    $customer_name = $customer_details->customer_name ?? '';
    $customer_mob_no = $customer_details->customer_mob_no ?? '';
    $user_shop_record = App\Models\UserShop::whereId($proposal->user_shop_id)->first();                
@endphp






    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex">
                            <h5>Edit #PROID{{ $proposal->id }}</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                            {{-- <span>Update a record for #PROID{{ $proposal->id }}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- start message area-->
                @include('backend.include.message')
                <!-- end message area-->

                <div class="row">
                    <div class="col-md-10 mx-auto">
                        <ul class="nav nav-pills custom-pills text-center justify-content-center mb-3" >
                            <li class="">
                                <a class="nav-link @if(request()->get('type') == "search") active @endif" data-type="search" style="cursor: pointer;">{{ __('Filter')}}</a>
                            </li>
                            <li class="">
                                <a class="nav-link @if((request()->get('type') == "markup")) active @endif"  data-type="markup" style="cursor: pointer;">{{ __('Choose & Mark-up')}}</a>
                            </li>
                            <li class="">
                                <a class="nav-link @if(request()->get('type') == "picked") active @endif" data-type="picked" style="cursor: pointer;">{{ __('Picked Products')}}</a>
                            </li>
                            <li class="">
                                <a class="nav-link @if(request()->get('type') == "send") active @endif" data-type="send" style="cursor: pointer;">{{ __('Send Products')}}</a>
                            </li>
                        </ul>
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


                                {{-- Custom Loader --}}
                                    
                                <div class="lds-roller cloader">
                                    <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
                                </div>
                                
                                {{-- Custom Loader --}}



                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade  @if(!request()->has('type') || request()->get('type') == "search") show active @endif" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <div class="card-body p-0">
                                            <form action="{{ route('panel.proposals.edit', [$proposal->id,'type' => 'markup']) }}" method="get" id='filter-form'>
                                                <input type="hidden" value="markup" name="type">
                                                <div class="form-group">
                                                    <input autocomplete="off" type="text" class="form-control" name="name" value="{{ request()->get('name') }}" placeholder="Enter Product Name">
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <select name="color" class="mx-2 form-control" multiple id="color">
                                                        @foreach (explode(',',$colors[0]) as $item)
                                                            <option {{ $item == request()->get('color') ? 'selected' :''}}  value="{{ $item }}">{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="mt-2 mr-2 ml-2">-</div>
                                                    <select name="size" class="mx-2 form-control" multiple id="size">
                                                         @foreach (explode(',',$sizes[0]) as $item)
                                                            <option {{ $item == request()->get('size') ? 'selected' :''}}  value="{{ $item }}" >{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="mt-2 mr-2 ml-2">-</div>
                                                    <select name="materials" class="mx-2 form-control" multiple id="materials">
                                                        @foreach (explode(',',$material[0]) as $item)
                                                           <option {{ $item == request()->get('material') ? 'selected' :''}}  value="{{ $item }}" >{{ $item }}</option>
                                                       @endforeach
                                                    </select>

                                                </div>
                                                <div class="d-flex justify-content-between my-3">
                                                    <div class="mt-2" title="Cost Price">Cost Price:</div>
                                                    <input type="number" name="from" class="form-control mx-2" id="" value="{{request()->get('from')}}" placeholder="From">
                                                        <div class="mt-2">-</div>
                                                    <input type="number" name="to" class="form-control mx-2" id="" value="{{request()->get('to')}}" placeholder="To">
                                                </div>
                                                <input type="checkbox" id="my_product" name="my_product" value="1" >
                                                <label for="my_product">My Products</label><br>
                                                <div class="row" id="all_supplier_brand">
                                                        <div class="col-lg-6">
                                                                <div class="d-flex"> 
                                                                    <select name="suppliers[]" class="form-control" multiple id="suppliers">
                                                                        @foreach ($suppliers as $supplier)
                                                                            <option value="{{ $supplier->id }}" @if(request()->get('suppliers')) {{ in_array($supplier->id,request()->get('suppliers')) ? 'selected' :''}} @endif>{{ getShopDataByUserId($supplier->id)->name??""}} - ({{ $supplier->name }})</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="ml-3 ">
                                                                        <span style="width: 20px; height: 20px;
                                                                        line-height: 19px;" class="btn btn-icon btn-secondary"><i class="fa fa-sm fa-info" title="Choose from all suppliers in your collections OR Only from Product added to your shop."></i></span>
                                                                    </div>
                                                                </div>
                                                            

                                                        </div>
                                                        <div class="col-lg-6 d-none">
                                                            <div class="d-flex">
                                                                <select name="brands[]" class="form-control" multiple id="brands">
                                                                    @foreach ($brands as $brand)
                                                                        <option value="{{ $brand->id }}" @if(request()->get('brands')) {{ in_array($brand->id,request()->get('brands')) ? 'selected' :''}} @endif>{{ $brand->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="ml-3 d-inline">
                                                                    <span style="width: 20px; height: 20px;
                                                                    line-height: 19px;"  class="btn btn-icon btn-secondary"><i class="fa fa-sm fa-info" title="Choose from all brands in 121.page Or Only from Brands added to your shop."></i></span>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                </div>

                                                <div class="row my-3">
                                                    <div class="col">
                                                        <div class="input-group">
                                                            <span class="input-group-prepend">
                                                                <label class="input-group-text">Mark-up on sale price</label>
                                                            </span>
                                                            <input type="number" required min="0" max="99" value="10" placeholder="Enter Hike %" name="hike" id="sethike" style="width:80px;" class="form-control">
                                                            <span class="input-group-append">
                                                                <label class="input-group-text">%</label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>



                                                {{-- <div class="d-flex justify-content-between my-3 d-none">
                                                    <div class="input-group input-group-button mr-4">
                                                        <input type="number" class="form-control" placeholder="Enter Quantity" name="qty" value="{{ request()->get('qty') }}" minlength="1" max="10000000">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" type="button" style="pointer-events: none;">Pcs</button>
                                                        </div>
                                                    </div>
                                                    <div class="input-group input-group-button">
                                                        <input type="number" class="form-control" placeholder="Enter Delivery Time" name="delivery_time" value="{{ request()->get('delivery_time') }}" min="1" max="365">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" style="pointer-events: none;">Days</button>
                                                        </div>
                                                    </div>
                                                </div> --}}


                                                
                                                <div class="d-block text-center my-3">
                                                    <button class="btn btn-outline-primary" type="submit">Filter Products</button>
                                                    <a href="{{ route('panel.proposals.edit',$proposal->id) }}" class="btn btn-outline-danger">Reset</a>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>

                                    <div class="tab-pane fade @if(request()->get('type') == "picked") show active @endif" id="product-tab" role="tabpanel" aria-labelledby="pills-products-tab">
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
                                                            <div>
                                                                <img src="{{ asset('backend/img/move.png') }}" alt="" height="20px" style="margin-top: 15px;
                                                                margin-left: 15px;">
                                                            </div>
                                                            <img src="{{ (isset($product) && (getShopProductImage($product->id,'single') != null)  ? asset(getShopProductImage($product->id,'single')->path) : asset('frontend/assets/img/placeholder.png')) }}" alt="" class="custom-img" style="height:185px;object-fit: contain;">
                                                           
                                                            <div class="card-body text-center">
                                                                <div class="profile-pic">
                                                                    <div class="row">
                                                                        <div class="col-md-9 pt-2 text-center p-0" style="margin-top: -15px;">
                                                                            <h6 class="mb-0 ">{{$product->title??"--"}} {{ $proposal_item->id }}</h6>
                                                                            @if(isset($product->category_id) || isset($product->sub_category))
                                                                            <span>{{fetchFirst('App\Models\Category',$product->sub_category,'name','--')}}</span> <br>
                                                                            @endif
                                                                            <span>Brand: {{ (getBrandRecordByProductId($proposal_item->product_id)->name ?? '--') }}</span> <br>
                                                                            
                                                                            <div>
                                                                                <span>Color:</span><span> {{ $product->color ?? '' }}</span> <span>Size:</span><span> {{ $product->size ?? '' }}</span>
                                                                            </div>
                                                                           
                                                                            @php
                                                                                $own_shop = App\Models\UserShop::whereUserId(auth()->id())->first();
                                                                                if($product != null){
                                                                                    $usi = productExistInUserShop($product->id,auth()->id(),$own_shop->id);  
                                                                                }else{
                                                                                    $usi = null; 
                                                                                }
                                                                            @endphp
                                                                            <span>{{ isset($usi) ? 'Ref Id: '.($usi->id) : 'Ref Id: ###' }}</span> <br>
                                                                            {{-- <span>Model Code: {{ $product->model_code ?? '' }}</span> --}}
                                                                            <br>
                                                                            @php
                                                                                $catelogue_author = @App\User::whereId($product->user_id)->first();
                                                                                $group_id = @App\Models\AccessCatalogueRequest::whereNumber($catelogue_author->phone)->latest()->first()->price_group_id ?? 0;
                                                                                $price =  $product->price ?? 0;
                                                                                if($group_id && $group_id != 0){
                                                                                    $price =  getPriceByGroupIdProductId($group_id,$product->id,$price);
                                                                                }
                                                                            @endphp
                                                                            Cost Price:<span> {{ isset($price) ? format_price($price) : '' }}</span>
                                                                            <br>
                                                                            
                                                                            Shop Price:<span> {{ (isset($product_record) && $product_record->price > 0) ?  format_price($product_record->price) : 'Ask for Price' }}</span>
                                                                            <br>
                                                                            
                                                                            <span>Quote Price:   {{ format_price($proposal_item->price) }}</span>
                                                                        </div>
                                                                        <div class="col-3">
                                                                       
                                                                            <button style="background: transparent;margin-left: -10px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                                <a href="{{ route('panel.proposal_items.destroy',$proposal_item->id) }}" class="btn remove-item mr-2">Remove</a>
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
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ request()->url()  }}{{ '?type=send' }}" class="btn btn-sm btn-primary">Next</a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tab-pane fade @if((request()->get('type') == "markup")) show active @endif" id="product-result-tab" role="tabpanel" aria-labelledby="product-result-tab">
                                        <div class="card-body">
                                            <div class="categories-list mb-3">
                                                <button class="btn filterable-btn @if(!request()->has('category_id') || request()->has('category_id') && request()->get('category_id') == '') btn-info @else btn-outline-info @endif" data-cid="">All</button>
                                                @forelse ($categories as $category)

                                                {{-- @if (getProposalProductCountViaCategoryId($category->id,auth()->id()) > 0) --}}
                                                    <button class="@if(request()->has('category_id') && request()->get('category_id') == $category->id) btn-info @else btn-outline-info @endif btn filterable-btn" data-cid="{{$category->id}}">
                                                        {{$category->name}}
                                                        {{-- ({{ getProposalProductCountViaCategoryId($category->id,auth()->id()) }}) --}}
                                                    </button>
                                                {{-- @endif --}}
                                                    
                                                     
                                                @empty
                                                    
                                                @endforelse
                                            </div>

                                        

                                            @if (request()->get('type') == 'markup')
                                                <div class="filter-products mt-3">
                                                   
                                                    <div class="cust-display p-0 mb-2 justify-content-between">
                                                        
                                                            <div class="d-flex">
                                                                <button type="button" class="btn btn-sm btn-primary ml-2" id="select-all">Select All</button>
                                                                <button type="button" class="btn btn-sm btn-primary ml-2 unSelectAll" id="">UnSelect All</button>
                                                            </div>
                                                            <div class="input-group d-none" style="width: 290px;">
                                                                <span class="input-group-prepend">
                                                                    <label class="input-group-text">Mark-up on sale price</label>
                                                                </span>
                                                                <input type="number" required min="0" max="99" value="{{$hike ?? 10}}" placeholder="Enter Hike %" name="hike" id="hike" style="width:80px;" class="form-control">
                                                                <span class="input-group-append">
                                                                    <label class="input-group-text">%</label>
                                                                </span>
                                                            </div>
                                                    </div>
                                                    <div class="row">
                                                            @if($main_products->count() > 0)
                                                                @foreach ($main_products as $main_product)
                                                                    {{-- ! Show Same Category Products --}}
                                                                    @php
                                                                        $catelogue_author = @App\User::whereId($product->user_id)->first();
                                                                        $group_id = @App\Models\AccessCatalogueRequest::whereNumber($catelogue_author->phone)->latest()->first()->price_group_id ?? 0;
                                                                        $price =  $product->price ?? 0;
                                                                        if($group_id && $group_id != 0){
                                                                            $price =  getPriceByGroupIdProductId($group_id,$product->id,$price);
                                                                        }
                                                                    @endphp

                                                                    {{-- @if ($price != 0) --}}

                                                                    @php
                                                                    $product_record = App\Models\UserShopItem::whereProductId($main_product->id)->whereUserId(auth()->id())->first();
                                                                    if($product_record){
                                                                        $proposal_item_record = App\Models\ProposalItem::where('proposal_id',$proposal->id)->whereProductId($main_product->id)->whereUserShopItemId($product_record->id)->first();
                                                                    }else{
                                                                        $proposal_item_record = null;
                                                                    }
                                                                    @endphp
                                                                    
                                                                    <div class="col-lg-3 px-1 filterable-items cid-{{$main_product->category_id}}">
                                                                        <div class="card-box product-box" style="padding: 10px;">
                                                                            @if($main_product->user_id == auth()->id())
                                                                            <i class="fa fa-cart-arrow-down text-primary" title="Self Product"></i>
                                                                            @endif
                                                                            <label class="custom-chk prdct-checked" data-select-all="boards">
                                                                                <input type="checkbox" name="products[]" class="input-check" value="{{ $main_product->id }}" @if(in_array($main_product->id,$excape_items)) checked="checked" @endif>
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                            {{-- Product Pins --}}
                                                                            <label class="custom-chk prdct-pinned" data-select-all="boards">
                                                                                <input type="checkbox" name="productspin[]" class="input-checkpin" value="{{ $main_product->id }}" @if(in_array($main_product->id,$pinned_items)) checked="checked" @endif>
                                                                                <span  id="checkmarkpin">

                                                                                    @if ($main_product->pinned === 1)
                                                                                        <img src="{{asset('frontend/assets/svg/bookmark_added.svg')}}" id="input-checkpinimg" alt="{{ $main_product->id }}" class="{{ $main_product->id }}" >
                                                                                    @else
                                                                                        {{-- <img src="{{asset('frontend/assets/svg/bookmark.svg')}}" id="input-checkpinimg" alt="{{ $main_product->id }}" class="{{ $main_product->id }}" >                                                                    --}}
                                                                                    @endif
                                                                                </span>
                                                                            </label>
                                                                            
                                                                            <div class="text-center">
                                                                                <img src="{{ asset(getShopProductImage($main_product->id,'single')->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="" class="custom-img" style="height:185px;">
                                                                            </div>
                                                                            <div class="row mt-2">
                                                                                <div class="col-12 text-center">
                                                                                    {{-- TODO: Add Supplier based on Direct or Chain --}} 
                                                                                    <p class="mb-0"><span> {{ \Str::words($main_product->title,10,'...') }}</span></p>
                                                                                    <div>{{ fetchFirst('App\Models\Category',$main_product->sub_category,'name') }} </div>
                                                                                    <p class="mb-0"><b>Brand</b><span> {{ $main_product->brand->name ?? '--' }}</span></p>
                                                                                    <p class="mb-0">
                                                                                        Color:<span> {{ $main_product->color }}</span> Size:<span> {{ $main_product->size }}</span>
                                                                                    </p>
                                                                                    <p class="mb-0">
                                                                                        {{-- @if($main_product->user_id == auth()->id())
                                                                                            Ref ID : {{$main_product->model_code}}
                                                                                        @else --}}
                                                                                        @php
                                                                                            $own_shop = App\Models\UserShop::whereUserId(auth()->id())->first();
                                                                                            $usi = productExistInUserShop($main_product->id,auth()->id(),$own_shop->id);  
                                                                                        @endphp
                                                                                            {{ isset($usi) ? 'Ref Id: '.($usi->id) : 'Ref Id: ###' }}
                                                                                        {{-- @endif --}}
                                                                                    </p>
                                                                                    @if(request()->has('type') && request()->get('type') == 'markup')
                                                                                    <p class="mb-0">
                                                                                        <b>Model Code:</b>
                                                                                        <span>{{($main_product->model_code) }}</span>
                                                                                    </p>
                                                                                    @endif

                                                                                   
                                                                                     @php
                                                                                        $catelogue_author = @App\User::whereId($main_product->user_id)->first();
                                                                                        $group_id = @App\Models\AccessCatalogueRequest::whereNumber($catelogue_author->phone)->latest()->first()->price_group_id ?? 0;
                                                                                        $price =  $main_product->price ?? 0;
                                                                                        if($group_id && $group_id != 0){
                                                                                            $price =  getPriceByGroupIdProductId($group_id,$main_product->id,$price);
                                                                                        }
                                                                                    @endphp
                                                                                    
                                                                                    <p class="mb-0"><b>Cost Price:</b><span> {{ format_price($price) }}</span></p>

                                                                                    <p class="mb-0">
                                                                                        <b>Shop Price:</b><span> {{ (isset($product_record) && $product_record->price > 0) ?  format_price($product_record->price) : 'Ask for Price' }}</span>
                                                                                    </p>
                                                                                    
                                                                                    @if(request()->has('type') && request()->get('type') == 'picked')
                                                                                        <p class="mb-0"><b>Quote Price:</b><span> {{ format_price($proposal_item_record->price) ?? 0 }}</span></p>
                                                                                    @endif
                                                                                    @if($main_product->brand_id)
                                                                                        <p class="mb-0"><b>Brand:</b><span> {{ fetchFirst("App\Models\Brand",$main_product->brand_id,'name') }}</span></p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{-- @endif  --}}
                                                                @endforeach
                                                            @else
                                                                <div class="text-center mx-auto mt-3">
                                                                    <h6>No Products!</h6>
                                                                </div>  
                                                            @endif
                                                            <div class="col-12">
                                                                {{ $main_products->appends(request()->query())->links() }}
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('panel.proposals.edit',[$proposal->id,'type' => 'search']) }}" class="btn btn-primary btn-md">Back</a>
                                                    <a id="validateMargin" href="{{ route('panel.proposals.edit',[$proposal->id,'type' => 'picked']) }}" class="btn btn-primary btn-md">Next</a>
                                                </div>
                                            @else  
                                                <div class="text-center ">
                                                    <p>Apply filter to get products.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if(request()->get('type') == 'send')
                                        @if($customer_name == '' && $customer_mob_no == '')
                                            <div class="alert alert-info">
                                                <p class="mb-0">Please fill the prospect information. </p>
                                            </div>
                                        @endif
                                        <form action="{{ route('panel.proposals.update', $proposal->id) }}" method="post" enctype="multipart/form-data" id="ProposalForm" class="row">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                            <input type="hidden" name="user_shop_id" value="{{ $user_shop_record->id }}">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                                            <label for="slug" class="control-label">Customize Slug<span
                                                                    class="text-danger">*</span> </label>
                                                            <input required class="form-control" name="slug" type="text"
                                                                id="slug" value="{{ $proposal->slug }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group {{ $errors->has('customer_name') ? 'has-error' : '' }}">
                                                            <label for="customer_name" class="control-label">Proposal Title<span
                                                                    class="text-danger">*</span> </label>
                                                            <input required class="form-control" name="customer_name" type="text"
                                                                id="customer_name" value="{{ $customer_name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div
                                                            class="form-group {{ $errors->has('customer_mob_no') ? 'has-error' : '' }}">
                                                            <label for="customer_mob_no" class="control-label">Proposal sent to</label>
                                                            <div class="input-group" style="width: 290px;">
                                                                <span class="input-group-prepend" id="basic-addon2">
                                                                    <label class="input-group-text">+91</label>
                                                                </span>
                                                                <input class="form-control" name="customer_mob_no" type="number"
                                                                id="customer_mob_no" value="{{ $customer_mob_no }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label for="proposal_note" class="control-label">Proposal Note</label>
                                                            <textarea  class="form-control" rows="7" name="proposal_note" id="proposal_note"
                                                                placeholder="Enter Proposal Note">{{ $proposal->proposal_note }}</textarea>
                                                        </div>
                                                        <div>
                                                         <input type="checkbox" id="enable_price_range" name="enable_price_range" value="1" @if($proposal->enable_price_range == 1 ) checked @endif>
                                                         <label for="enable_price_range">Enable Price Range</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                            <div class="col-md-12 ">
                                                <div class="d-flex justify-content-center">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                    <div class="form-group mx-2">
                                                        @if(proposalCustomerDetailsExists($proposal->id))
                                                            <a href="{{inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug) }}" target="_blank" class="ml-auto btn btn-primary" >Preview & Download</a>
                                                        @endif
                                                    </div>
                                                    <div class="">
                                                        @if(proposalCustomerDetailsExists($proposal->id))
                                                            <a id="sentProposalBtn" @if($customer_name != '') href="{{ route('panel.proposals.sent',$proposal->id)}}" class="btn btn-outline-primary mb-3 btn-block click-send" @else href="javascript:void(0);" disabled class="btn btn-outline-primary mb-3 btn-block" @endif>Click to send</a>
                                                        @endif
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
    @include('panel.proposals.inlude.proposal-edit')
    <!-- push external js -->
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
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
        $('#hike').change(function() {
            hike = $(this).val();
            var route = "{{ route('panel.proposal_items.api.setmargin') }}"+"?setmargin="+hike;
                $.ajax({
                    url: route,
                    method: "get",
                    success: function(res){
                        console.log(res);
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
            var msg = $(this).data('msg') ?? "You won't be able to revert back!";
            $.confirm({
                draggable: true,
                title: 'Are You Sure!',
                content: msg,
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Remove',
                        btnClass: 'btn-red',
                        action: function(){
                                window.location.href = url;
                        }
                    },
                    close: function () {
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
            readURL(this);
        });
        $(".edit-price").click(function() {
            var product_id =$(this).data('product');
            $('.productId').val(product_id);
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
                    url: "{{ url('panel/proposal-items/update/sequence') }}"+'/'+"{{$proposal->id}}",
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
    @endpush
@endsection
