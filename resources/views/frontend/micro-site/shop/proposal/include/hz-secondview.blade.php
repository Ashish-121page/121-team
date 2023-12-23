@if($products->count() > 0)
@foreach ($products as $key => $product)
                  
    @php
        $user_shop = App\Models\UserShop::where('user_id',(auth()->id() ?? 155))->first();
        // $usi = productExistInUserShop($product->id,auth()->id(),$user_shop->id);
        $productId= \Crypt::encrypt($product->id);
        $record = (array) json_decode($proposal->currency_record);
        $exhangerate = Session::get('Currency_exchange') ?? $record[$proposal->offer_currency] ?? 1;
                $HomeCurrency = 1;
                $currency_symbol = Session::get('currency_name') ?? $proposal->offer_currency ?? 'INR';
    @endphp
        


        <div class="col-md-6 col-12 my-3 justify-content-center">
            <div class="col-md-12 col-sm-6 col-12 my-3 mt-5  d-flex justify-content-center align-item-center" style="height: 430px; width: 100% object-fit: contain;">

           
    
                <div class="sampleenquiry" style="position: absolute1; top: 10px;left: 10px;">
                    <input type="checkbox" name="enquir[]" id="enquir-{{ $product->id }}" value="{{ $product->id }}">
                    <label for="enquir-{{ $product->id }}" class="checkmark bi" style="position: absolute;top: -1%;right: 1%;cursor: pointer;"></label>
                </div>
    
                    {{-- <div class="card shop-list border-10 position-relative"> --}}
                    <div class="shop-image position-relative overflow-hidden rounded ">
                        <a href="{{ inject_subdomain('shop/'. $productId,$slug) }}" target="_blank" style="min-height: 55vh; width: 100%; object-fit: contain;">
                            @if( getShopProductImage($product->id,'single') != null)
                                <img src="{{ asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="" class="" style="height:100%;">
                            @else
                                <img src="{{ asset('backend/default/placeholder.jpg')  }}" class="img-fluid rounded" style="height:100%;">
                            @endif
    
                            <div class="sampleenquiry">
                                <label for="" data-contain="contain-{{ $product->id }}" class="deleteitem">
                                    <i class="fas fa-trash" style="color: #ff0c0c;"></i>
                                </label>
                            </div>
    
                        </a> 
                    </div>
                {{-- </div> --}}
            </div>

            <div class="col-md-12 col-sm-6 col-12 mt-5 jusify-content-between text-center" style="font-size:1.5rem">
    
                <a href="#" class="text-dark product-name h4" contenteditable="true">{{ $product->title }}</a>
    
                @if (isset($product->brand->name) && isset($product->brand->name) != '')
                    <p class="mb-0" contenteditable="true"><b>Brand:</b><span>{{ $product->brand->name ?? '--' }}</span></p>
                @endif
    
                <div style="wdith:100%">
                    <small contenteditable="true" >
                        
                            @if ($proposal_options->show_color)
                                {{ $product->color ?? '' }} 
                            @endif
    
                            @if ($proposal_options->show_size)
                                @if($product->size) , @endif 
                                {{ $product->size ?? ''}}
                            @endif                                                        
                    </small>
                </div>
    
                {{-- @if($product->user_id == auth()->id()) --}}
                <span contenteditable="true">Model Code :# <span class="product-model">{{ $product->model_code }}</span></span>
                {{-- @else  --}}
                    {{-- <span>Ref ID :#{{ isset($usi) ? $usi->id : '' }}</span>
                @endif    --}}

                        @if ($selectedProp != [] && $selectedProp != null)
                            @foreach ($selectedProp as $index => $item)
                                @php
                                    $ids_attri = getParentAttruibuteValuesByIds($item,[$product->id]);
                                    $attri_count = count($ids_attri);
                                @endphp
                                
                                @if ($attri_count != 0)
                                    <span class="d-block print_content{{ $index }}" contenteditable="true">
                                            {{ getAttruibuteById($item)->name }} : 

                                        @foreach ($ids_attri as $key1 => $value)
                                            {{ getAttruibuteValueById($value)->attribute_value }}
                                            @if ($attri_count != 1 && $key1 < $attri_count-1 )
                                                , 
                                            @endif
                                        @endforeach
                                    </span>
                                @endif
                            @endforeach
                        @endif

                <div class="d-flex justify-content-between mt-1 ">
    
                    @php
                        $price = getProductProposalPriceByProposalId($proposal->id,$product->id) ?? $product->price;
                        $margin = App\Models\ProposalItem::whereProposalId($proposal->id)->where('product_id',$product->id)->first()->margin ?? 10;
                        $user_price = App\Models\ProposalItem::whereProposalId($proposal->id)->where('product_id',$product->id)->first()->user_price ?? null;
                        if ($user_price == null) {
                            $margin_factor = (100 - $margin) / 100;
                            $price = $price/$margin_factor;
                        }
                        else {
                            $price = $user_price;
                        }
    
                        $price = number_format(round(exchangerate($price,$exhangerate,$HomeCurrency)),2);
                        array_push($ppt_price,( $currency_symbol." ".$price));
                    @endphp
    
                    {{-- @if($proposal->enable_price_range == 1)
                        <h6 class="text-dark small fst-italic mb-0 mt-1 w-100">
                        {{ format_price(($price)-($price*10/100)) }} - {{ format_price(($price)+ ($price*10/100)) }}</h6>
                    @else --}}
                        <h4 class="text-dark small fst-italic mb-0 mt-1 w-100 product_price" contenteditable="true">
                            {{ $currency_symbol }}
                            {{ $price }}
    
                        {{-- {{ format_price($price) }} --}}
                        </h4>
                    {{-- @endif --}}
                    
                </div>
                @if ($proposal_options->show_Description == 1)
                <span contenteditable="true" class="product-description">
                        {!! $product->description ?? "No Description" !!}
                    </span>
    
                    
                @endif
                
            </div> {{--heading column--}}
        </div>

            @if ($key < count($products) - 1 )
                @if(++$key%4==0)
                    <div class="col-12 justify-content-center mx-auto pdf-margin mx-5 d-none" style="margin-top: 4cm ; margin-bottom: 4cm !important;">
                        <div style="position: relative;width: fit-content">
                            <input type="file" id="clienticon" class="visually-hidden">
                            <label for="clienticon" style="position: absolute;right: 2%" class="noprint chicon">
                                <i class="fas fa-pencil-alt text-primary fs-5"></i>
                            </label>
                            {{-- <img src="{{ asset('frontend/assets/img/Client_logo_placeholder.svg') }}" alt="Client Logo" id="clientLogo" style="height: 150px;width: 250px;object-fit: contain;"> --}}
                            <img src="{{ $offerbannerPath }}" alt="Client Logo" id="clientLogo" style="height:200px;width: 1100px;object-fit: contain;">
                        </div>
                    </div>
                @endif
            @endif

            
    @endforeach
@else
    <div class="col-lg-6 mx-auto text-center mt-3">
        <div class="card">
            <div class="card-body">
                
                <i class="fa text-primary fa-lg fa-shopping-cart"></i>
                <p class="mt-4">No Products added yet!</p>
                                                        
            </div>
        </div>
    </div>
@endif