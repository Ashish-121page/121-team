@extends('backend.layouts.main') 
@section('title', 'Product')
@section('content')
{{-- @dd(auth()->id()); --}}
@php
/**
 * Product 
 * @category  zStarter
 * @ref  zCURD
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link        https://121.page/
 */
$breadcrumb_arr = [
    ['name'=>'Add Product', 'url'=> "javascript:void(0);", 'class' => '']
];
if(AuthRole() == "User"){
    $user_id = auth()->id();
    $user = auth()->user();
}else{
    $user = App\User::find(request()->get('user_id'));
    $user_id = request()->get('user_id');
}
$user_shop = App\Models\UserShop::whereUserId($user_id)->first();
$catelogue_author = @App\User::whereId(request()->type_id)->first();
$group = @App\Models\AccessCatalogueRequest::whereNumber($catelogue_author->phone)->first()->price_group_id ?? 0;
@endphp
    <!-- push external head elements to head -->
    @push('head')
   
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error{
            color:red;
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
            #checkmarkpin{
                position: absolute;
                top: 80px;
                left: 0;
                height: 30px;
                width: 30px;
                border-radius: 3px;
                background-color: transparent !important;
            }
            
            .prdct-pinned input{
                visibility: hidden;
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
            .custom-chk input:checked ~ .checkmark {
                background-color: #6666cc;
            }
            .cust-display{
                display: flex;
            }
            @media (max-width: 767px) {
                .cust-display{
                    display: block;
                }
            }
            .remove-ik-class{
                -webkit-box-shadow: unset !important;
                box-shadow: unset !important;
            }
            .dropdown-menu.multi-level.show{
                min-width: 7rem !important;
                width: 100px !important;
                position: absolute;
                transform: translate3d(112px, 250px, 0px) !important;
                top: 0px;
                left: 0px !important;
                will-change: transform;
            }
    </style>

    @endpush 
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex" style="height: 23px;">
                            <h5>{{ $title ?? 'N/A' }}</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
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
                <div class="card">
                    <div class="card-header p-4">
                        <div class="categories-list">
                            <button class="categoryFilter btn filterable-btn @if(!request()->has('category_id') || request()->get('category_id') == null) btn-info @else btn-outline-info @endif" data-cid="0">All</button>
                            @forelse ($categories as $category)
                            
                                @if($category)
                                    @if(($category_products_count = getProductCountViaCategoryId($category->id,request()->get('type_id'))) > 0)
                                        {{-- <button id="" type="submit" data-category_id="{{ $category->id }}" class="categoryFilter btn filterable-btn btn-outline-info @if(request()->get('category_id') == $category->id) active @endif" data-cid="{{$category->id}}">{{$category->name}} ({{ $category_products_count }})</button> --}}

                                        <button id="" type="submit" data-category_id="{{ $category->id }}" class="categoryFilter btn filterable-btn btn-outline-info @if(request()->get('category_id') == $category->id) active @endif" data-cid="{{$category->id}}">{{$category->name}}</button>
                                    @endif
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </div>
                    <div class="card-body">
                        @if (request()->get('type_id') == auth()->id())
                            <form action="{{ route('panel.user_shop_items.removebulk') }}" method="post" id="removebulkform" >
                        @else
                            <form action="{{ route('panel.user_shop_items.addbulk') }}" method="post">    
                        @endif
                            @csrf
                            <input type="hidden" name="user_id"  value="{{ $user_id }}">
                            <input type="hidden" name="user_shop_id" value="{{ $user_shop->id }}">
                            <input type="hidden" name="parent_shop_id" value="{{ $parent_shop->id ?? 0 }}">
                            <input type="hidden" name="type_id" value="{{ request()->get('type_id')}}">
                            <input type="hidden" name="type" value="{{ request()->get('type')}}">
                            <input type="hidden" name="bulk_hike" class="bulkHike" value="">
                                <div class="d-flex justify-content-end mb-3">
                                    {{-- <h5>Catalogue ({{$scoped_products->count()}})</h5> --}}
                                    <div class="d-flex">
                                        <div class="d-flex">
                                            @if (request()->get('type_id') == auth()->id())
                                                <button id="delproduct_dummy" class="btn btn-sm btn-danger mr-2 validateMargin">Delete</button>
                                                <button id="delete_all_dummy"class="btn btn-outline-primary">Delete All Products</button>
                                            
                                                <button type="submit" name="delproduct" id="delproduct" class="btn btn-sm btn-danger mr-2  d-none validateMargin">Delete Products</button>
                                                {{-- Delete All Button --}}
                                                <input type="submit" name="delete_all" id="delete_all" value="Delete All Products" class="btn btn-outline-primary d-none"> 
                                            @endif
                                            <input type="text" placeholder="Type and Enter" id="searchValue" name="search" value="{{ request()->get('search') }}"  class="form-control">
                                            <div class="d-flex ml-2">
                                                {{-- <button type="submit" id="filterBtn" class="btn btn-icon btn-outline-warning " title="submit"><i class="fa fa-filter" aria-hidden="true"></i></button> --}}
                                                <a href="{{ route('panel.user_shop_items.create',['type' => request()->get('type'),'type_id' => request()->get('type_id')]) }}" class="btn btn-icon btn-outline-danger ml-2" title="Refresh"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                        @if(request()->get('type_id') == auth()->id())
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#updateQR" class="btn btn-icon btn-sm btn-outline-dark ml-2" title="Upload QR Code"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                </div>
                                @if(request()->get('type_id') != auth()->id())
                                    <div class="d-flex justify-content-end">
                                        <div class="input-group border-0">
                                            <span class="input-group-prepend">
                                                <label class="input-group-text">Mark-up on sale price</label>
                                            </span>
                                            <input type="number" required min="0" value="10" placeholder="Enter Hike %" name="hike" id="hike" style="max-width: 25%;" class="form-control">
                                            <span class="input-group-append">
                                                <label class="input-group-text">%</label>
                                            </span>
                                            <div class="d-flex ml-2">
                                                <select style="width: 140px;" name="length" id="lengthField" class="form-control">
                                                    <option  value="" aria-readonly="true">Show Products</option>
                                                    <option @if(request()->get('length') == 10) selected @endif value="10">10</option>
                                                    <option @if(request()->get('length') == 50) selected @endif value="50">50</option>
                                                    <option @if(request()->get('length') == 100) selected @endif value="100">100</option>
                                                    {{-- <option @if(request()->get('length') == 500) selected @endif value="500">500</option> --}}
                                                </select>
                                                <input type="number"  name="length" value="{{request()->get('length')}}" class="form-control" placeholder="Enter Length">
                                                <div class="ml-2">
                                                    <button type="button" class="btn btn-icon btn-outline-primary lengthSearch d-none"><i class="fa fa-filter"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <button type="button" class="btn btn-sm btn-primary ml-2" id="select-all">Select All</button>
                                        <button type="button" class="btn btn-sm btn-primary ml-2 unSelectAll" id="">UnSelect All</button>
                                        <button type="submit"  class="btn btn-sm btn-success ml-2 validateMargin">Bulk Add to Shop</button>
                                        <div>
                                            <span>
                                                <i class="ik ik-info fa-2x  ml-2 remove-ik-class" title="Selecting or unselecting will only work with selected products on this page"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                    
                            <div class="row mt-4">
                                    {{-- Todo: For On Site Product --}}
                                    @forelse ($scoped_products as $scoped_product)
                                        @php
                                        if(request()->get('type') == 'direct'){
                                            // Currect Catalogue Author Shop Data
                                            $user_shop_temp = getShopDataByUserId(request()->get('type_id'));
                                            // Show Price of USI
                                            $user_shop_product =  productExistInUserShop(@$scoped_product->id,request()->get('type_id'),$user_shop_temp->id ??'');
                                            $product_exists =  productExistInUserShop($scoped_product->id,$user_id,$user_shop->id);
                                        }else{
                                            $product_exists =  productExistInUserShop($scoped_product->id,$user_id,$user_shop->id);
                                        }
                                        $usi = productExistInUserShop($scoped_product->id,auth()->id(),$user_shop->id);
                                        // Price Grouping
                                        // Current USI Author ID - For Direct Only
                                        if($access_data != null &&  auth()->id() != $access_id){
                                            if($group != 0){
                                                $price_group_data = \App\Models\GroupProduct::whereGroupId($group)->whereProductId($scoped_product->id)->latest()->first();
                                                if($price_group_data && $price_group_data->price != null && $price_group_data->price != 0){
                                                    $user_shop_product['price'] = $price_group_data->price;
                                                }
                                            }
                                        }else{
                                        }
                                        @endphp
                                        @if (!$product_exists)
                                            <div class="text-center w-100">No Record Found</div>
                                            @continue
                                        @endif
                                        <div class="col-lg-3 col-md-4 filterable-items cid-{{$scoped_product->category_id}} mb-4">
                                            @php
                                                $proUsiExists = productExistInUserShop($scoped_product->id,$user_id,$user_shop->id)
                                            @endphp
                                            <div class="product-card product-box">
                                                
                                                @if(!$product_exists)
                                                <label class="custom-chk prdct-checked" data-select-all="boards">
                                                    <input type="checkbox" name="products[]" class="input-check d-none" value="{{ $scoped_product->id }}" >
                                                    <span class="checkmark"></span>
                                                </label>
                                                @endif
                                                    @if($scoped_product->user_id == auth()->id())
                                                        <i style="position: absolute; top: 45px;left: 5px;" class="fa fa-cart-arrow-down text-primary self-pro-img f-18" title="Self Product"></i>
                                                    @else
                                                        <i style="position: absolute; top: 45px;left: 5px;" class="fa fa-link text-primary self-pro-img f-18" title="Linked Product"></i>
                                                    @endif
                                                    @php
                                                        if(isset($proUsiExists) && $proUsiExists != null){
                                                            $route = inject_subdomain("shop/".encrypt($scoped_product->id),$user_shop->slug, true, false);
                                                        }else{
                                                            if(isset($parent_shop) && $parent_shop->user_id == auth()->id()){
                                                                $route = '#';
                                                            }else{
                                                                if ($parent_shop) {
                                                                    $route = inject_subdomain("shop/".encrypt(@$scoped_product->id),$parent_shop->slug, true, false);
                                                                
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                <div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        @if($product_exists != null)
                                                        <div class="ml-2 mt-2">
                                                                @if($product_exists->is_published == 1)
                                                                <span class="badge badge-success">Published</span>
                                                                @else
                                                                    <span class="badge badge-danger"> Unpublished</span>
                                                                @endif
                                                        </div>
                                                        
                                                        @if ($scoped_product->user_id != auth()->id())
                                                            <a href="{{ route('panel.user_shop_items.edit',$product_exists->id) }}"><i class="fa fa-edit added-icon mt-2"></i></a>
                                                        @endif
                                                    @endif

                                                    @if($scoped_product->user_id == auth()->id())
                                                        <label class="custom-chk prdct-checked" style="margin-top: 15%" data-select-all="boards">
                                                            <input type="checkbox" name="delproducts[]" class="input-check d-none" value="{{ $scoped_product->sku }}" >
                                                            <span class="checkmark mr-5 mt-5"></span>
                                                        </label>
                                                        {{-- Product Pins --}}
                                                        <label class="custom-chk prdct-pinned" data-select-all="boards">
                                                            <input type="checkbox" name="productspin[]" class="input-checkpin" value="{{ $scoped_product->id }}" @if(in_array($scoped_product->id,$pinned_items)) checked="checked" @endif>
                                                            <span  id="checkmarkpin">
                                                                @if (in_array($scoped_product->id,$pinned_items))
                                                                    <img src="{{ asset('frontend/assets/svg/bookmark_added.svg')}}" id="input-checkpinimg_{{ $scoped_product->id }}" alt="{{ $scoped_product->id }}" class="{{ $scoped_product->id }}" >
                                                                @else
                                                                    <img src="{{ asset('frontend/assets/svg/bookmark.svg')}}" id="input-checkpinimg_{{ $scoped_product->id }}" alt="{{ $scoped_product->id }}" class="{{ $scoped_product->id }}" >                                                                    
                                                                @endif
                                                            </span>
                                                        </label>
                                                    @endif
                                                </div> 
                                                </div>
                                                    <a href="{{ $route }}" target="_blank">
                                                        <img src="{{ asset(getShopProductImage($scoped_product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="" class="custom-img" style="">
                                                    </a> 
                                                
                                                <div class="product-body">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="mb-0">
                                                            <a target="_blank" href="{{ $route }}">{{ Str::limit($scoped_product->title , 40)}}
                                                            </a>
                                                        </h6>
                                                        @if($scoped_product->user_id == auth()->id())
                                                            <div style="margin-right: -10px;">
                                                                <button style="background: transparent;margin-left: -10px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="">
                                                                    @if(checkBrandProductCreate(request()->get('id')))
                                                                        <a href="{{ route('panel.products.edit', $scoped_product->id) }}"
                                                                            title="Edit Product" class="dropdown-item ">
                                                                            <li class="p-0">Edit</li>
                                                                        </a>
                                                                        <a href="{{ route('panel.products.destroy', $scoped_product->id) }}"
                                                                            title="Delete Product" class="dropdown-item  delete-item">
                                                                            <li class=" p-0">Delete</li>
                                                                        </a>
                                                                    @endif
                                                                    @if($scoped_product->user_id == auth()->id())
                                                                        <a href="{{ route('panel.group_products.index')."?product=".$scoped_product->id }}"
                                                                            title="Price Group" class="dropdown-item">
                                                                            <li class=" p-0">Price Group</li>
                                                                        </a>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <b>{{$scoped_product->category->name ?? " *Dump Product* "}}</b>     
                                                    </div>
                                                    
                                                    <span class="mb-0 d-block"><b>Brand:</b><span> {{ $scoped_product->brand->name ?? '--' }}</span></span>
                                                    <span class="mb-0 d-block"><b>Color: </b><span>{{ $scoped_product->color ?? '--' }}</span><b> Size:</b> <span></span>{{ $scoped_product->size ?? '--' }}</span>
                                                    <span class="mb-0 d-block"><b>Cost Price:</b>
                                                        @php
                                                            $price =  getUserShopItemByProductId(@$parent_shop->slug, $scoped_product->id)->price ?? 0;
                                                            if($price_group != 0){
                                                                $price =  @getPriceByGroupIdProductId($price_group,$scoped_product->id,$scoped_product->price);
                                                            }
                                                        @endphp
                                                        <span> {{  $price == 0 ? 'Ask For Price' : format_price($price)  }}</span>
                                                    </span>
                                                    <span class="d-block"><b>Model Code:</b> 
                                                        {{ ($scoped_product->model_code) }}</span>
                                                    <span class="mb-0 d-block"><b>Shop Price:</b><span> {{  isset($usi) ? format_price($usi->price) : '--' }}</span></span>
                                                    <span class="d-block"><b>Ref ID:</b> {{ $proUsiExists ? $proUsiExists->id : '###' }}</span>
                                                    <div class="">
                                                        {{-- <div>
                                                            @if(request()->has('type_id') && (request()->get('type_id') == auth()->id()))
                                                            <span class="mb-0 d-block"><b>No. of Sellers linked:</b><span> {{ getSellerLinkedCount($scoped_product->id) }}</span></span>
                                                            @endif
                                                        </div> --}}
                                                        {{-- @if($scoped_product->varient_products()->count() - 1 > 0) --}}
                                                        <span class="d-block"><b>Variants:</b> {{ $scoped_product->varient_products()->count()}} Products</span>
                                                        {{-- @endif --}}
                                                    </div>
                                                    {{-- <span>Supplier Model Code -</span> <span class="fw-600 text-dark">{{ $scoped_product->model_code ?? '--' }}</span> --}}
                                                    @if($product_exists != null)
                                                        @if($scoped_product->user_id != auth()->id())
                                                        
                                                            <a href="{{ route('panel.user_shop_items.remove',[$scoped_product->id,$user_id]) }}" class="btn-block text-center btn-danger mt-2 btn-md p-2 confirm-btn" data-pid="{{$scoped_product->id }}" >Remove from Shop</a>
                                                        @endif
                                                    @else
                                                        <a href="javascript:void(0)" 
                                                        data-category_id="{{ $scoped_product->category_id  }}" 
                                                        data-sub_category_id="{{$scoped_product->sub_category  }}"  data-pid="{{$scoped_product->id }}" @if(request()->get('type') == 'direct') data-price="{{ $user_shop_product->price ?? 0 }}" @else data-price="{{ $scoped_product->price ?? 0 }}"  @endif class="btn-block text-center btn-primary mt-2 btn-md p-2 addProductBtn">Add to Shop</a>
                                                    @endif    
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                            <div class="col-lg-8 mx-auto text-center">
                                                <div>No Products Yet! </div>
                                            </div>
                                    @endforelse
                                
                            </div> 
                            @if(request()->get('type_id') != auth()->id())
                                <div class="d-flex justify-content-end">
                                    <div class="input-group border-0">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text">Mark-up on sale price</label>
                                        </span>
                                        <input min="1" type="number" required min="0" value="10" placeholder="Enter Hike %" name="hike" id="hike" style="max-width: 15%;" class="form-control">
                                        <span class="input-group-append">
                                            <label class="input-group-text">%</label>
                                        </span>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-sm btn-success ml-2 validateMargin">Bulk Add to Shop</button>
                                    <button type="button" class="btn btn-sm btn-primary ml-2" id="select-all">Select All</button>
                                    <button type="button" class="btn btn-sm btn-primary ml-2 unSelectAll" id="">UnSelect All</button>
                                </div>
                            @endif
                        </form>
                    </div>
                    <div>
                        {{ $scoped_products->appends(request()->query())->links() }} 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form class="" action="{{ route('panel.user_shop_items.create',['type' => request()->get('type'),'type_id' => request()->get('type_id')]) }}" id="filterRecordsForm" method="GET">
        <input type="hidden" name="type" value="{{ request()->get('type') }}">
        <input type="hidden" name="type_id" value="{{ request()->get('type_id') }}">
        <input type="hidden" value="{{ request()->get('lenght') }}" name="length" id="lengthInput">
        <input type="hidden" name="search" value="" id="searchField">
        <input type="hidden" name="category_id" value="" id="categoryId">
    </form>
    @include('panel.user_shop_items.add-product')
    <div class="modal fade" id="BulkPriceGroupUpdateModal" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="addProductTitle">Bulk Group Price Update</h5>
            <div class="ml-auto">
                <a href="{{ route('panel.product.group.bulk-export') }}" class="btn btn-link"><i class="fa fa-download"></i> Export Product Price Groups</a>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.product.group.bulk-update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Upload Updated Excel Template</label>
                            <input type="file" name="file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        </div>
                    </div>
                    <div class="col-md-12 ml-auto">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="updateQR" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="addProductTitle">Select Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.products.update.qr') }}" method="get">
                    @csrf
                    <div class="form-group" id="productsDropdown">
                        <select name="product_ids[]" class="form-control select2" id="" multiple>
                            @foreach ($qr_products as $qr_product)
                                <option value="{{ $qr_product->id }}">
                                    {{-- {{ getReferenceCodeByUser(auth()->id(),$qr_product->id).' : '.$qr_product->title.' , '.$qr_product->color.' , '.$qr_product->size  }} --}}
                                    {{ "Model Code: ".$qr_product->model_code.' : '.$qr_product->title.' , '.$qr_product->color.' , '.$qr_product->size  }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check p-0">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="all_products" value="1" id="allProducts">
                            <span class="custom-control-label" style="position: absolute;">All Products</span>
                        </label>
                    </div>
                        <button class="btn btn-primary mt-3" type="submit">Generate Printable Product QR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
     <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        // Add Product To Pin
        
        $('.input-checkpin').click(function(){
            var  id = $(this).val();
            if($(this).prop('checked')){
                // var img = ;?
                var route = "{{ route('panel.user_shop_items.api.addpinonsie') }}"+"?product_id="+$(this).val()+'&user_id='+"{{ $access_id }}";
                $.ajax({
                    url: route,
                    method: "get",
                    success: function(res){
                        $("#input-checkpinimg_"+id).attr('src', "{{ asset('frontend/assets/svg/bookmark_added.svg')}}");
                    }
                });
                
            }else{
                var route = "{{ route('panel.user_shop_items.api.removepinonsie') }}"+"?product_id="+$(this).val()+'&user_id='+"{{ $access_id }}";
                $.ajax({
                    url: route,
                    method: "get",
                    success: function(res){
                        $("#input-checkpinimg_"+id).attr('src', "{{ asset('frontend/assets/svg/bookmark.svg')}}");
                    }
                });
            }
        });
        $('#hike').on('change',function(){
            var hike = $(this).val();
            $('.bulkHike').val(hike);
        })
        $('#filterBtn').on('click',function(e){
            e.preventDefault();
            var search = $('#searchValue').val();
            var length = $('#lengthField').val(); 
            $('#lengthInput').val(length);
            $('#searchField').val(search);
            $('#filterRecordsForm').submit();
        })
        $('#searchValue').keypress(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                var search = $('#searchValue').val();
                var length = $('#lengthField').val(); 
                $('#lengthInput').val(length);
                $('#searchField').val(search);
                $('#filterRecordsForm').submit();
            }
        });
        $('.bulkHike').val($('#hike').val());
        $(document).ready(function(){
            $('.addProductBtn').on('click',function(){
                var pid = $(this).data('pid');
                var category_id = $(this).data('category_id');
                var sub_category_id = $(this).data('sub_category_id');
                var price = $(this).data('price');
                var hike = $('#hike').val();
                $('.priceInput').val(price);
                $('.productID').val(pid);
                $("#category_id").attr('disabled', 'disabled');
                $("#category_id").val(category_id).change();
                $("#category_id").removeAttr('disabled', 'disabled');
                $("#sub_category_id").attr('disabled', 'disabled');
                $("#sub_cate_loader").show();
                setTimeout(() => {
                    $(document).find("#sub_category_id").val(sub_category_id).change();
                    $("#sub_category_id").removeAttr('disabled', 'disabled');
                    $("#sub_cate_loader").hide();
                }, 1500);
                $('#addProductModal').modal('show');
            });
            $('#allProducts').on('click',function(){
                $('#productsDropdown').toggle('');
            });
        })
        $('#UserShopItemForm').validate();
            $('.repeatergruop_price').repeater({
                initEmpty: false,
                defaultValues: {
                    'text-input': 'foo'
                },
                show: function() {
                    $(this).slideDown();
                    $(".select2").select2();
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function(setIndexes) {},
                isFirstItemUndeletable: true
            });  
            $(document).ready(function() {
                user_id = "{{ $user_id }}";
                console.log(user_id);
                $("#price_checkbox").click(function(event) {
                    if ($(this).is(":checked")){
                         $(".price_group").removeClass('d-none');
                        $("#group_id").attr("required", true);
                        $("#stock").attr("required", true);
                    }
                    else{
                         $(".price_group").addClass('d-none');
                        $("#group_id").attr("required", true);
                        $("#stock").attr("required", true);
                    }
                   
                });
                
            }); 
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
                            console.log(res);
                            $('#sub_category_id').html(res);
                        }
                    })
                }
            });
                                  
           
            $('#select-all').click(function(){
                if($('.input-check').is(':checked')){
                    $('.input-check').prop('checked',false);
                }else{
                    $('.filterable-items').each(function(){
                        if(!$(this).hasClass('d-none')){
                            $(this).find('.input-check').prop('checked',true);
                        }
                    });
                }
            });
            $('.unSelectAll').click(function(){
                if($('.input-check').is(':checked')){
                    $('.input-check').prop('checked',false);
                }else{
                    $('.filterable-items').each(function(){
                        if(!$(this).hasClass('d-none')){
                            $(this).find('.input-check').prop('checked',false);
                        }
                    });
                }
            });
            $('.categoryFilter').click(function(e){
               e.preventDefault();
         
                var categoryId = $(this).data('category_id');
                $('#categoryId').val(categoryId);
                var length = $('#lengthField').val();
                $('#lengthInput').val(length);
                $('#filterRecordsForm').submit();
            });    
            
            $('.lengthSearch').on('click',function(){
                var length = $('#lengthField').val();
                $('#lengthInput').val(length);
                $('#filterRecordsForm').submit();
            })
            function replaceUrlParam(paramName, paramValue) {
                var url = window.location.href;
                if (paramValue == null) {
                    paramValue = '';
                }
                var pattern = new RegExp('\\b(' + paramName + '=).*?(&|#|$)');
                if (url.search(pattern) >= 0) {
                    return url.replace(pattern, '$1' + paramValue + '$2');
                }
                url = url.replace(/[?#]$/, '');
                return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue;
            }
            $('#lengthField').on('change',function(){
                var value = $(this).val();
                window.history.pushState({}, '', replaceUrlParam('length', value));
                var length = $('#lengthField').val();
                $('#lengthInput').val(length);
                $('#filterRecordsForm').submit();
            })
            $('.validateMargin').on('click', function(e){
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
            
        $(document).on('click','#delete_all_dummy',function(e){
        e.preventDefault();
        var msg = $(this).data('msg') ?? "All Product will be Deleted, And You won't be able to revert back!";
        $.confirm({
            draggable: true,
            title: 'Are You Sure!',
            content: msg,
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Confirm',
                    btnClass: 'btn-red',
                    action: function(){
                        $("#delete_all").click();
                    }
                },
                close: function () {
                }
            }
            });
        });
        $(document).on('click','#delproduct_dummy',function(e){
        e.preventDefault();
        var msg = $(this).data('msg') ?? "You won't be able to revert back!";
        $.confirm({
            draggable: true,
            title: 'Are You Sure!',
            content: msg,
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Confirm',
                    btnClass: 'btn-red',
                    action: function(){
                        $("#delproduct").click();
                    }
                },
                close: function () {
                }
            }
            });
        });
    </script>
    @endpush
@endsection
