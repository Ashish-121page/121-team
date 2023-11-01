{{-- @ Old Style Product View --}}

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
                            <button type="submit" name="delproduct" id="delproduct" class="btn btn-sm btn-danger mr-2  d-none validateMargin">Delete Products</button>
                            {{-- Delete All Button --}}
                            <input type="submit" name="delete_all" id="delete_all" value="Delete All Products" class="btn btn-outline-primary d-none"> 
                        @endif
                        {{-- <a href="{{ asset('instructions/instructions.pdf') }}" download="instructions.pdf" class="btn btn-outline-primary m-1">Download Instruction</a> --}}
                        <input type="text" placeholder="Type and Enter" id="searchValue" name="search" value="{{ request()->get('search') }}"  class="form-control">
                        <div class="d-flex ml-2">
                            {{-- <button type="submit" id="filterBtn" class="btn btn-icon btn-outline-warning " title="submit"><i class="fa fa-filter" aria-hidden="true"></i></button> --}}
                            <a href="{{ route('panel.user_shop_items.create',['type' => request()->get('type'),'type_id' => request()->get('type_id')]) }}" class="btn btn-icon btn-outline-danger ml-2" title="Refresh"><i class="fa fa-redo" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    @if(request()->get('type_id') == auth()->id())
                        {{-- <a href="javascript:void(0);" data-toggle="modal" data-target="#updateQR" class="btn btn-icon btn-sm btn-outline-dark ml-2" title="Upload QR Code"><i class="fa fa-qrcode" aria-hidden="true"></i></a> --}}
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
                
        @if (request()->has('category_id') && request()->get('category_id') != '')
            <h1> {{ App\Models\Category::whereId(request()->get('category_id'))->first()->name }} </h1>
        @endif
        <div class="row mt-4">

            <div class="col-lg-3 col-md-4 filterable-items mb-4 border border-primary d-flex justify-content-center align-items-center skeltonbtn" style="font-size: 2vh">
                <a href="{{ route('panel.products.create') }}?action=nonbranded">
                    + Add Product
                </a>
            </div>


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
                        {{-- <div class="text-center w-100">No Record Found</div> --}}
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
                                {{-- @if($scoped_product->user_id == auth()->id())
                                    <i style="position: absolute; top: 45px;left: 5px;" class="fa fa-cart-arrow-down text-primary self-pro-img f-18" title="Self Product"></i>
                                @else
                                    <i style="position: absolute; top: 45px;left: 5px;" class="fa fa-link text-primary self-pro-img f-18" title="Linked Product"></i>
                                @endif --}}
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
                                <div class="d-flex justify-content-between mb-2" style="position: absolute;top: 4%;left: 78%;">
                                    @if($product_exists != null)
                                    {{-- <div class="ml-2 mt-2">
                                            @if($product_exists->is_published == 1)
                                            <span class="badge badge-success">Published</span>
                                            @else
                                                <span class="badge badge-danger"> Unpublished</span>
                                            @endif
                                    </div> --}}
                                    
                                    @if ($scoped_product->user_id != auth()->id())
                                        <a href="{{ route('panel.user_shop_items.edit',$product_exists->id) }}"><i class="fa fa-edit added-icon mt-2"></i></a>
                                    @endif
                                @endif

                                @if($scoped_product->user_id == auth()->id())
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
                                {{-- <a href="{{ $route }}" target="_blank"> --}}
                                <a href="{{ route('panel.view.product',encrypt($scoped_product->id)) }}" target="_blank">
                                    <img src="{{ asset(getShopProductImage($scoped_product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="" class="custom-img" style="">
                                </a> 
                            
                            <div class="product-body">
                                <div class="d-flex justify-content-between">
                                    {{-- <h6 class="mb-0">
                                        <a target="_blank" href="{{ $route }}">{{ Str::limit($scoped_product->title , 40)}}</a>
                                    </h6> --}}
                                    @if($scoped_product->user_id == auth()->id())
                                        {{-- <div style="margin-right: -10px;">
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
                                        </div> --}}

                                        <label class="custom-chk prdct-checked" data-select-all="boards">
                                            <input type="checkbox" name="delproducts[]" class="input-check d-none" value="{{ $scoped_product->sku }}" data-record="{{ $scoped_product->id }}">
                                            <span class="checkmark mr-5 mt-5"></span>
                                        </label>
                                    @endif
                                </div>
                                
                                {{-- <div>
                                    <b>{{$scoped_product->category->name ?? " *Dump Product* "}}</b>
                                </div> --}}
                                
                                {{-- <span class="mb-0 d-block"><b>Brand:</b><span> {{ $scoped_product->brand->name ?? '--' }}</span></span> --}}
                                {{-- <span class="mb-0 d-block"><b>Color: </b><span>{{ $scoped_product->color ?? '--' }}</span><b> Size:</b> <span></span>{{ $scoped_product->size ?? '--' }}</span> --}}
                                {{-- <span class="mb-0 d-block"><b>Cost Price:</b> --}}
                                    {{-- @php
                                        $price =  getUserShopItemByProductId(@$parent_shop->slug, $scoped_product->id)->price ?? 0;
                                        if($price_group != 0){
                                            $price =  @getPriceByGroupIdProductId($price_group,$scoped_product->id,$scoped_product->price);
                                        }
                                    @endphp --}}
                                    {{-- <span> {{  $price == 0 ? 'Ask For Price' : format_price($price)  }}</span> --}}
                                <span class="d-block"><b>Model Code:</b> {{ ($scoped_product->model_code) }}</span>
                                {{-- <span class="mb-0 d-block"><b>Shop Price:</b><span> {{  isset($usi) ? format_price($usi->price) : '--' }}</span></span> --}}
                                {{-- <span class="d-block"><b>Ref ID:</b> {{ $proUsiExists ? $proUsiExists->id : '###' }}</span> --}}
                                <div class="">
                                    {{-- <div>
                                        @if(request()->has('type_id') && (request()->get('type_id') == auth()->id()))
                                        <span class="mb-0 d-block"><b>No. of Sellers linked:</b><span> {{ getSellerLinkedCount($scoped_product->id) }}</span></span>
                                        @endif
                                    </div> --}}
                                    {{-- @if($scoped_product->varient_products()->count() - 1 > 0) --}}
                                    <span class="d-flex justify-content-between w-85">
                                        <span><b>Variants:</b> {{ $scoped_product->varient_products()->count()}} Products </span>
                                        <a href="{{ route('panel.products.edit',$scoped_product->id) }}" class="btn-link text-primary">Edit</a>
                                    </span>
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

<form method="get" action="{{ route('panel.bulk.product.bulk-export',auth()->id()) }}" id="products_exportform">
    <input type="hidden" name="products" id="products_export" value="">
</form>