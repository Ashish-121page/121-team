<div class="row gx-3 flex-wrap dfjrgd">
    @forelse ($items as $user_shop_item)
        @php
            $product = getProductDataById($user_shop_item->product_id);
            $image_ids = $user_shop_item->images != null ? explode(',',$user_shop_item->images) : [];
            $price =  $user_shop_item->price ?? 0;
            if($group_id && $group_id != 0){
                $price =  getPriceByGroupIdProductId($group_id,$product->id,$price);
            }
            
            $record = App\Models\UserCurrency::where('currency',$product->base_currency)->where('user_id',$user_shop->user_id)->first();
            $exhangerate = Session::get('Currency_exchange') ?? 1;
            $HomeCurrency = $record->exchange ?? 1;
            $currency_symbol = Session::get('currency_name') ?? 'INR';
            
            $price = exchangerate($price,$exhangerate,$HomeCurrency);


            $productId= \Crypt::encrypt($product->id);
            $search_val = '';
            if ($is_search = 1) {
                foreach ($additional_attribute as $key => $item){
                    if (request()->has("searchVal_$key") && !empty(request()->get("searchVal_$key"))){

                        foreach (request()->get("searchVal_$key") as $key => $value) {
                            $search_val .= "&selected_Cust%5B%5D=$value";
                        }
                    }
                }
            }
            
        @endphp

        @if ($product->exclusive == 1 && request()->get('exclusive') != 'off' || $product->exclusive == 1 && request()->get('exclusive') == '')
            @continue
        @endif
        
        {{-- @dd($product); --}}
                <div class="col-3">
                    <a href="{{ route('pages.shop-show',$productId)."?pg=".request()->get('pg').$search_val }}">
                        <img src="{{ asset(getMediaByIds($image_ids)->path ?? asset('frontend/assets/img/placeholder.png')) }}" class="img-fluid " style="height: 150px;width: 100%;object-fit: contain;" alt="">
                    </a>
                    <div class="ashu mb-3 d-none">
                    <div class="">{{ \Str::limit($product->title,30) }}</div>
                    <div>Model Code: {{ \Str::limit($product->model_code,30) }}</div>
                        <div class=""> 
                            {{ $currency_symbol }}
                            @if($price == 0)
                                    <span>{{ __("Ask For Price") }}</span>
                            @elseif($price)
                                {{ number_format(round($price,2)) }}
                            @else
                                <span>{{ __("Ask For Price") }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-9 send">
                    <div class="h4">{{ \Str::limit($product->title,30) }}</div>
                    <p>Model Code: {{ \Str::limit($product->model_code,30) }}</p>
                    {{-- <p>{!! \Str::limit($product->description,150) !!}</p> --}}
                    <p style="font-family: 'Nunito', sans-serif;line-height: 1.3;font-weight: 600;">
                        @php
                            $variations = App\Models\Product::whereSku($product ->sku)->get();
                        @endphp
                        Colour: @foreach (getProductColorBySku($product->sku) as $key => $variation)
                            @if($variation->color != null || $variation->size != null)
                                {{ $variation->color }} ,
                                @if ($key <= 3)
                                    @continue
                                @else
                                    & more...
                                    @break
                                @endif
                            @endif
                        @endforeach
                        <br>
                        Size: @foreach ($variations as $key => $variation)
                            @if($variation->color != null || $variation->size != null)
                                {{ $variation->size }} ,
                                @if ($key <= 3)
                                    @continue
                                @else
                                    & more...
                                    @break
                                @endif
                            @endif
                        @endforeach
                    </p>
                    <div class="h6">Material: {{ \Str::limit($product->material,30) }} </div>
                    <div class="h6">
                        {{ fetchFirst('App\Models\Category',$product->category_id,'name' ,'') }} / 
                        {{ fetchFirst('App\Models\Category',$product->sub_category,'name','') }}
                    </div>
                    <div class="h6">
                        {{ $currency_symbol }}
                        @if($price == 0)
                                <span>{{ __("Ask For Price") }}</span>
                        @elseif($price)
                            {{ number_format(round($price,2)) }}
                        @else
                            <span>{{ __("Ask For Price") }}</span>
                        @endif
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
    {{-- <div class="d-flex justify-content-center">
        {{ $items->appends(request()->query())->links() }} 
    </div> --}}
