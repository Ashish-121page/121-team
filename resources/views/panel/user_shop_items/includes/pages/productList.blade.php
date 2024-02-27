<div class="col-lg-3 col-md-4 filterable-items mb-4 border border-primary d-flex justify-content-center align-items-center skeltonbtn" style="font-size: 2vh; width: 25rem;  min-height: 13.5rem; ">
    <a href="{{ route('panel.products.create') }}?action=nonbranded" class="text-dark " style="display: block;height: 100%;width: 100%;position: absolute ;text-align: center;">
        <span style="height: 100%;display: flex;width: 100%;justify-content: center;align-items: center;">+ Add Product</span>
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
                    <span class="checkmark" ></span>
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
                <div class="d-flex justify-content-between mb-2" style="position: absolute;top: 4%;left: 85%;">
                    @if($product_exists != null)
                    {{-- <div class="ml-2 mt-2">
                            @if($product_exists->is_published == 1)
                            <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-danger"> Unpublished</span>
                            @endif
                    </div> --}}

                    {{-- @if ($scoped_product->user_id != auth()->id())
                        <a href="{{ route('panel.user_shop_items.edit',$product_exists->id) }}"><i class="fa fa-edit added-icon mt-2"></i></a>
                    @endif --}}
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
                            <input type="checkbox" name="delproducts[]" class="input-check invisible buddy" value="{{ $scoped_product->sku }}" data-record="{{ $scoped_product->id }}">
                            <span class="checkmark mr-5 mt-5" style="top: 20px !important; height: 24px !important; width: 25px !important;"></span>
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
                <span class="d-block"><b>Model Code:</b> {{ Str::limit($scoped_product->model_code, 25, '...') }}</span>
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

                        @if ($scoped_product->varient_products()->count() > 1)
                            <a href="{{ route('panel.products.edit',$scoped_product->id) }}?type={{ encrypt('editmainksku') }}" class="btn-link text-primary">Edit</a>
                        @else
                            <a href="{{ route('panel.products.edit',$scoped_product->id) }}" class="btn-link text-primary" >Edit</a>
                        @endif

                    </span>
                    {{-- @endif --}}
                </div>
                {{-- <span>Supplier Model Code -</span> <span class="fw-600 text-dark">{{ $scoped_product->model_code ?? '--' }}</span> --}}

                {{-- @if($product_exists != null)
                    @if($scoped_product->user_id != auth()->id())
                        <a href="{{ route('panel.user_shop_items.remove',[$scoped_product->id,$user_id]) }}" class="btn-block text-center btn-danger mt-2 btn-md p-2 confirm-btn" data-pid="{{$scoped_product->id }}" >Remove from Shop</a>
                    @endif
                @else
                    <a href="javascript:void(0)"
                    data-category_id="{{ $scoped_product->category_id  }}"
                    data-sub_category_id="{{$scoped_product->sub_category  }}"  data-pid="{{$scoped_product->id }}" @if(request()->get('type') == 'direct') data-price="{{ $user_shop_product->price ?? 0 }}" @else data-price="{{ $scoped_product->price ?? 0 }}"  @endif class="btn-block text-center btn-primary mt-2 btn-md p-2 addProductBtn">Add to Shop</a>
                @endif     --}}
            </div>
        </div>
    </div>
    @empty

        <div class="col-lg-8 mx-auto text-center">
            <div>No Products Yet! </div>
        </div>
@endforelse
