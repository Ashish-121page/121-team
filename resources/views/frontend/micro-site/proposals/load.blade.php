<div class="row gx-3 flex-wrap dfjrgd">

    
    @forelse ($items as $products)
        @php
            // $image_ids = App\Models\UserShopItem::where('product_id',$products->id)->images != null ? explode(',',$products->images) : [];
            $user = App\Models\UserShop::where('user_id',$products->user_id)->first();
            $image_ids = getUserShopItemByProductId($user->slug,$products->id);
            if ( isset($image_ids->images) && $image_ids->images != null) {
                // If Not Empty
                $image_ids = explode(',',$products->images);
            }else{
                $image_ids = [];
            }
            $price =  $products->price ?? 0;
            $product_record = App\Models\UserShopItem::whereProductId($products->id)->whereUserId(auth()->id())->first();
            if($product_record){
                $proposal_item_record = App\Models\ProposalItem::where('proposal_id',$proposalid)->whereProductId($products->id)->whereUserShopItemId($product_record->id)->first();
            }else{
                $proposal_item_record = null;
            }
            $productId= \Crypt::encrypt($products->id);


            $record = App\Models\UserCurrency::where('currency',$products->base_currency)->where('user_id',$user_shop->user_id)->first();
            $exhangerate = Session::get('Currency_exchange') ?? 1;
            $HomeCurrency = $record->exchange ?? 1;
            $currency_symbol = Session::get('currency_name') ?? $product->base_currency ?? 'INR';
            $price = exchangerate($price,$exhangerate,$HomeCurrency);

            
        @endphp

            <div class="col-3">
                <div class="shop-image position-relative overflow-hidden rounded">
                    {{-- <a href="{{ route('pages.shop-show',$productId)."?pg=".request()->get('pg') }}"> --}}
                        <img src="{{ ( (getShopProductImage($products->id,'single') != null)  ? asset(getShopProductImage($products->id,'single')->path) : asset('frontend/assets/img/placeholder.png')) }}" class="img-fluid " style="height: 250px;width: 100%;object-fit: contain;" alt="">
                    {{-- </a> --}}
                    <ul class="list-unstyled shop-icons filterable-items ashu d-none">
                        <li class="mt-1">
                            <label class="custom-chk prdct-checked" data-select-all="boards" data-value="unselect">
                                <input type="checkbox" name="products[]" class="input-check visually-hidden" value="{{ $products->id }}" @if(in_array($products->id,$excape_items)) checked="checked" @endif>
                                <span class="checkmark"></span>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="ashu mb-2 d-none">
                    <div class="    ">{{ \Str::limit($products->title,30) }}</div>
                    <div>
                        <a href="{{ route('pages.shop-show',$productId)."?pg=".request()->get('pg') }}">
                            Model Code: {{ \Str::limit($products->model_code,30) }}
                        </a>
                    </div>
                    @if ($request->has('quantity') && $request->get('quantity') != null && $request->get('quantity') != 0)
                            <p class="mb-0"> 
                            <b>In Stock </b>
                            <span> 
                               @if (getinventoryByproductId($products->id) != null)
                                    @if (getinventoryByproductId($products->id)->total_stock != null && getinventoryByproductId($products->id)->total_stock != 0 )
                                            <i class="fa fa-check-circle fa-sm text-success"></i>    
                                        @else
                                            <i class="fa fa-times-circle fa-sm text-danger"></i>
                                        @endif
                               @endif
                            </span>
                            {{-- <br> --}}, 
                            @php
                                $sku = [$products->sku];
                                $avalable_stock = (getinventoryByproductId($products->id) != null) ? getinventoryByproductId($products->id)->total_stock : 0 ?? 0;
                                $search_quantity = $request->get('quantity');
                            @endphp
                            @if ($avalable_stock < $search_quantity)
                                {{-- <b>Available : </b> --}}
                                <span>
                                    @if (getTandA($sku,$avalable_stock,$search_quantity)['Key'] ==  "On Request")
                                        On Request
                                    @else
                                        {{ getTandA($sku,$avalable_stock,$search_quantity)['Key']}} Days (approx)
                                    @endif
                                </span>
                                <br>
                            @endif
                        </p>
                    @endif
                    {{-- <div class="h5">{{ \Str::limit($products->title,30) }}</div> --}}
             
                    <div class="">
                        {{ $currency_symbol }}
                        @if($price == 0)
                                <span>{{ __("Ask For Price") }}</span>
                        @elseif($price)
                            {{-- {{ number_format(round($price,2)) }} --}}
                            {{ round($price,2) }}
                        @else
                            {{-- <span>{{ format_price(0) }}</span> --}}
                            <span>{{ __("Ask For Price") }}</span>
                        @endif
                    </div>
                    {{-- <p style="font-family: 'Nunito', sans-serif;line-height: 1.3;font-weight: 600;">
                        Colour: {{ $products->color }} ; Size: {{ $products->size }}
                    </p> --}}
                </div>
            </div>
            
            <div class="col-9 send">
                <a href="{{ route('pages.shop-show',$productId)."?pg=".request()->get('pg') }}" >
                    <div class="h4">{{ \Str::limit($products->title,30) }}</div>
                </a>
                <p>
                    <a href="{{ route('pages.shop-show',$productId)."?pg=".request()->get('pg') }}">
                        Model Code: {{ \Str::limit($products->model_code,30) }} ;
                    </a>
                    <div class="ashu1">
                        @if ($request->has('quantity') && $request->get('quantity') != null && $request->get('quantity') != 0)
                                In Stock 
                                <span> 
                                    @if (getinventoryByproductId($products->id)->total_stock != null && getinventoryByproductId($products->id)->total_stock != 0)
                                        <i class="fa fa-check-circle fa-sm text-success"></i>    
                                    @else
                                        <i class="fa fa-times-circle fa-sm text-danger"></i>
                                    @endif
                                </span>, 
                                @php
                                    $sku = [$products->sku];
                                    // $avalable_stock = getinventoryByproductId($products->id)->total_stock;
                                    $avalable_stock = (getinventoryByproductId($products->id) != null) ? getinventoryByproductId($products->id)->total_stock : 0;
                                    $search_quantity = $request->get('quantity');
                                    $now = Carbon\Carbon::now();
                                    $lockresult = App\Models\LockEnquiry::where('product_id','LIKE','%'.$products->id.'%')->where('user_id',$user->id)->where('expiry_date','<=',$now)->first();
                                @endphp
                                @if ($avalable_stock < $search_quantity)
                                    <b>Available : </b>
                                    <span>
                                        @if ($lockresult != null)
                                            Not Available
                                        @elseif(getTandA($sku,$avalable_stock,$search_quantity)['Key'] ==  "On Request")
                                            On Request
                                        @else
                                            {{ getTandA($sku,$avalable_stock,$search_quantity)['Key']}} Days (approx)
                                        @endif
                                    </span>
                                    <br>
                                @endif
                        @endif
                    </div>
                </p>
                {{-- <p>{!! \Str::limit($products->description,150) !!}</p> --}}
                <div class="h6">
                    {{ $currency_symbol }}
                    @if($price == 0)
                            <span>{{ __("Ask For Price") }}</span>
                    @elseif($price)
                        {{-- {{ number_format(round($price,2)) }} --}}
                        {{ round($price,2) }}
                    @else
                        {{-- <span>{{ format_price(0) }}</span> --}}
                        <span>{{ __("Ask For Price") }}</span>
                    @endif
                </div>
                <p style="font-family: 'Nunito', sans-serif;line-height: 1.3;font-weight: 600;">
                    Colour: {{ $products->color }} ;
                    Size: {{ $products->size }}
                </p>
                <div class="h6">Material: {{ \Str::limit($products->material,30) }} </div>
                <ul class="list-unstyled shop-icons filterable-items ashu1">
                    <label class="custom-chk prdct-checked" data-select-all="boards">
                        <input type="checkbox" name="products[]" class="input-check mycheck1 visually-hidden" value="{{ $products->id }}" @if(in_array($products->id,$excape_items)) checked="checked" @endif>
                        <span class="checkmark"></span>
                    </label>
                </ul>
            </div>
            <div class="ashu1" style="border-bottom: 2px solid #6666cc"></div>
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