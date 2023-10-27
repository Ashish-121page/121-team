@if($products->count() > 0)
@foreach ($products as $key => $product)
                  
@php
    $user_shop = App\Models\UserShop::where('user_id',(auth()->id() ?? 155))->first();
    // $usi = productExistInUserShop($product->id,auth()->id(),$user_shop->id);
    $productId= \Crypt::encrypt($product->id);
    $record = (array) json_decode($proposal->currency_record);
    $exhangerate = $record[$proposal->offer_currency] ?? 1;
    $HomeCurrency = 1;
    $currency_symbol = $proposal->offer_currency ?? 'INR';
@endphp

{{-- <div class="col-12">
    <div class="row"> --}}
            <div class="col-md-6 col-sm-6 col-12 ">
                <div class="sampleenquiry" style="position: absolute1; top: 10px;left: 10px;">
                    <input type="checkbox" name="enquir[]" id="enquir-{{ $product->id }}" value="{{ $product->id }}">
                    <label for="enquir-{{ $product->id }}" class="checkmark bi" style="position: absolute;top: -1%;right: 1%;cursor: pointer;"></label>
                </div>
                <div class="shop-image position-relative overflow-hidden rounded ">

                    <a href="{{ inject_subdomain('shop/'. $productId,$slug) }}" target="_blank" style="height: 100vh; width: 100%; object-fit: contain; gap:2; display: inherit">
                        @if( getShopProductImage($product->id,'single') != null)
                            <img src="{{ asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="" class="" style="height:70%;">
                        @else
                            <img src="{{ asset('backend/default/placeholder.jpg')  }}" class="img-fluid rounded" style="height:70%;">
                        @endif

                        <div class="sampleenquiry">
                            <label for="" data-contain="contain-{{ $product->id }}" class="deleteitem">
                                <i class="fas fa-trash" style="color: #ff0c0c;"></i>
                            </label>
                        </div>

                    </a> 
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-12 jusify-content-start">

                <a href="#" class="text-dark product-name h6" contenteditable="true">{{ $product->title }}</a>

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

                @if($product->user_id == auth()->id())
                    <span contenteditable="true">Model Code :# <span>{{ $product->model_code }}</span></span>
                @else 
                    <span>Ref ID :#{{ isset($usi) ? $usi->id : '' }}</span>
                @endif   
                <div class="d-flex justify-content-start mt-1 ">
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

                    @if($proposal->enable_price_range == 1)
                        <h6 class="text-dark small fst-italic mb-0 mt-1 w-100">
                        {{ format_price(($price)-($price*10/100)) }} - {{ format_price(($price)+ ($price*10/100)) }}</h6>
                    @else
                        <h6 class="text-dark small fst-italic mb-0 mt-1 w-100 product_price" contenteditable="true">
                            {{ $currency_symbol }}
                            {{ $price }}
                        {{ format_price($price) }}
                    </h6>
                    @endif
                </div>
                @if ($proposal_options->show_Description == 1)
                    <span contenteditable="true">
                        {!! $product->description ?? "No Description" !!}
                    </span>
                @endif                    
            </div> {{--Second column--}}
            

                @if(++$key%2==0)
                    <div class="col-12 pdf-margin d-none" style="margin-bottom: 0px">

                    </div>
                    @if($cust_details['customer_name'] != '' || $proposal->proposal_note != null)
                        <div class="row justify-content-between d-none pdf-margin">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div style="position: relative;width: fit-content">
                                    <input type="file" id="offericon" class="visually-hidden">
                                    <label for="offericon" style="position: absolute;right: 0%" class="noprint chicon" >
                                        <i class="fas fa-pencil-alt text-primary fs-5" ></i>
                                    </label>
                                    <img src="{{ asset($proposal->client_logo) }}" alt="Client Logo" id="offerLogo" style="height: 150px;width: 250px;object-fit: contain;">
                                </div>

                                <div class="ms-3">
                                    <h4 contenteditable="true">{{ $cust_details['customer_name'] }}</h4>
                                    @if ($proposal_options->Show_notes == 1)
                                        <p contenteditable="true" style="border: 1px solid grey; border-radius: 5px">{{ nl2br($proposal->proposal_note )?? '' }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 d-flex justify-content-lg-end">
                                    <div style="position: relative;width: fit-content   ">
                                        <input type="file" id="clienticon" class="visually-hidden">
                                        <label for="clienticon" style="position: absolute;right: 2%" class="noprint chicon" >
                                            <i class="fas fa-pencil-alt text-primary fs-5" ></i>
                                        </label>
                                        <img src="{{ asset('frontend/assets/img/Client_logo_placeholder.svg') }}" alt="Client Logo" id="clientLogo" style="height: 150px;width: 250px;object-fit: contain;">
                                    </div>
                            </div>
                        </div>
                    @endif
                    
                @endif
            @endforeach
            {{-- </div>
            </div><!--end col--> --}}
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
    {{-- </div>
</div> --}}