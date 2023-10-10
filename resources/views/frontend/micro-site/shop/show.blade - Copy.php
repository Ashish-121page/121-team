@extends('frontend.layouts.main')
@php
    $user_shop_item = getUserShopItemByProductId($slug,$product->id);
    $image_ids = $user_shop_item->images != null ? explode(',',$user_shop_item->images) : [];
    $price =  $user_shop_item->price ?? 0;
    if($group_id && $group_id != 0){
        $price =  getPriceByGroupIdProductId($group_id,$product->id,$price);
    }
    $phone_number = getSellerPhoneBySlug($slug);
@endphp

@section('meta_data')
    @php
        $meta_title =   $user_product->title_user ?? $product->title. ' as low at '.format_price($user_shop_item->price).' | Secured By ' .getSetting('app_name');		
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
@endsection
<style>
    .table>:not(caption)>*>* {
        padding: 3px !important;
    }
    .slider-img{
        min-width:95px !important;
        min-height:95px !important;
        width:95px !important;
        height:95px !important;
        max-width:95px !important;
        max-height:95px !important;
        object-fit: contain;
    }
    .slider-zoom{
        width: auto !important;
        min-height: 345px !important;
        height: 345px !important;
        max-height: 345px !important;
        object-fit: contain !important;
    }
</style>

{{-- @dd($user_shop_item) --}}
@section('content')

    <section class="section">
        <div class="container my-5">
            
            <div class="row pt-lg-0 pt-md-3 pt-3">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                    <div class="single-pro-tab-content">
                        <div class="mb-3">
                            {{-- <button class="zoomBtn">
                                <img src="{{ asset('backend/img/move.png') }}" alt="" style="height: 30px;object-fit: contain;">
                            </button> --}}
                            <img class="slider-zoom zoom zoomImg" src="{{ @asset(getMediaByIds($image_ids)->path ??'frontend/assets/img/placeholder.png') }}" style="cursor: pointer;" alt="product-image">
                        </div>
                        <!-- Nav tabs -->
                        <div class="tiny-four-item">
                            @foreach (getMediaByIds($image_ids,'all') as $media)
                                <div class="tiny-slide btn btn-link slider-zoom-selector" data-img="{{ asset($media->path) }}">
                                    <img src="{{ asset($media->path ? $media->path:'frontend/assets/img/placeholder.png') }}" class="img-fluid slider-img rounded" alt="product-image">
                                </div>
                            @endforeach
                        </div>
                    </div> 
                </div>


                <div class="col-lg-7 col-md-7 col-sm-7 mt-sm-0 pt-2 pt-sm-0">
                    <div class="section-title ms-md-4">
                        <h4 class="title mb-0">
                            @if ($user_product->title_user != null)
                                {{ $user_product->title_user }}
                            @else
                                {{ $product->title }}
                            @endif
                        </h4>
                        <span class="text-muted">{{ getProductRefIdByRole($product,$user_shop_item, 2)}}</span>
                        {{-- @if($product->user_id == auth()->id()) 
                        <span class="text-muted">{{getMicrositeItemSKU($product->model_code)}}</span>
                        @else
                        <span class="text-muted">{{getMicrositeItemSKU($user_shop_item->id)}}</span>
                        @endif --}}
                        
                            @if($product->stock_qty > 0) 
                                <span>,</span>
                                <span class="text-success" style="font-weight: 600;"><small>In Stock</small></span>
                            @endif
                        <h5 class="text-muted my-2">{{ format_price($price) }}</h5>
                        @if($product->mrp &&  $product->mrp != 0)
                            <h6 class="text-muted">MRP : {{ format_price($product->mrp )}}</h6>
                        @endif    
                        @if(getBrandRecordByBrandId($product->brand_id))
                            <h5 class="text-muted">Brand: <span class="text-dark">{{ getBrandRecordByBrandId($product->brand_id)->name }}</span>  </h5>
                        @endif

                        @if($product->material &&  $product->material != null || $user_product->materials && $user_product->materials != null)
                            <h6 class="text-muted">Material : {{ $user_product->materials ?? $product->material }}</h6>
                        @endif   

                        <h6 class="text-info">
                            <a class="m-0 p-0 btn-link text-muted" href="">{{ fetchFirst('App\Models\Category',$user_product->category_id,'name' ,'') }}</a>
                            / 
                            <a class="m-0 p-0 btn-link text-muted" href="">{{ fetchFirst('App\Models\Category',$user_product->sub_category_id,'name','') }}</a>
                        </h6>
                        @php
                            $features = $product->features;
                            $product = App\Models\Product::whereId($product->id)->first();
                            $attributes = App\Models\ProductAttribute::get();
                            $colors = App\Models\Product::where('color','!=',null)->whereSku($product->sku)->get()->pluck('color');
                            $sizes = App\Models\Product::where('size','!=',null)->whereSku($product->sku)->get()->pluck('size');
                        @endphp





                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="d-flex align-items-center">
                                    <ul class="list-unstyled mb-0 ms-0 g-5">


                                        @foreach ($variations as $variation)
                                        @php
                                            $variationId= \Crypt::encrypt($variation->id);
                                        @endphp
                                        @if ($scan == 1)
                                            @php
                                                $url = route('pages.shop-show', $variationId)."?proposalreq=".$proposalidrequest."&scan=1";
                                            @endphp
                                        @else
                                            @php
                                                $url = route('pages.shop-show', $variationId);
                                            @endphp
                                            
                                        @endif

                                            @if($variation->variant_type == null)
                                                <li class="list-inline-item  ">
                                                    <a href="{{ $url }}" class="btn variant-btn btn-outline-primary active-size @if($product->id == $variation->id) active @endif" style="font-size: .8rem">
                                                        @php
                                                            $type = $variation->variant_type;
                                                        @endphp
                                                        {{ $variation->color }} - {{ $variation->size }}
                                                        {{-- @if($variation->manage_inventory == 1) {{ $variation->stock ?? 0 }} @else  @endif   --}}
                                                    </a>
                                                </li>
                                            @elseif($variation->color != null || $variation->size != null)
                                                <li class="list-inline-item  ">
                                                    <a href="{{ $url }}" class="btn variant-btn btn-outline-primary active-size @if($product->id == $variation->id) active @endif" style="font-size: .8rem">
                                                        @php
                                                            $type = $variation->variant_type;
                                                        @endphp
                                                        {{ $variation->variant_type }} - {{ $variation->variant_value }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-lg-12 col-md-12 d-flex justify-content-between">
                                <div class="mt-2 pt-2">
                                    <form action="{{ route('pages.add-cart',[$slug,'product_id='.$product->id]) }}" method="POST" class="mb-0">
                                        @csrf
                                        <input type="hidden" name="unit_price" value="{{ $price }}">
                                        
                                        @if(\Auth::id() != $user_shop->user_id)
                                            @if ($scan == 1)
                                                {{-- Do Something Here... --}}
                                            @else
                                                <div class="form-group">
                                                    <label class="mr-2">Quantity:</label>
                                                    <input class="form-control" type="number" name="qty" id="qty" value="1" min="1">
                                                </div>
                                            @endif
                                        @endif

                                      

                                        <div class="mt-4 d-flex">

                                            @php
                                            if ($user_shop_item['parent_shop_id'] != 0 ) {
                                                $user_shop_item['parent_shop_id'] = "Ashish";
                                                $product->video_url = '';
                                            }
                                            @endphp                                             

                                            @if(\Auth::check())
                                            @if(\Auth::id() != $user_shop->user_id)
                                                    @if($chk =  App\Models\Cart::whereUserId(auth()->id())->whereUserShopId($user_shop->id)->whereProductId($product->id)->first())
                                                    <a href="{{ route('pages.remove-cart',$chk->id) }}" class="btn btn-danger mb-0 me-2"><i class="fa fa-shopping-cart"></i> Remove From Cart</a>
                                                    @else
                                                        @if($price > 0)
                                                            @if ($scan != 1)
                                                                <button type="submit" class="btn btn-outline-primary mb-0 me-2"><i class="fa fa-shopping-cart"></i>Add to Cart</button>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    @if ($scan != 1)
                                                        <button type="button" class="btn btn-outline-primary  mb-0 enquiryModal me-2"><i class="fa fa-comments"></i> Enquiry</button>
                                                    @endif
                                                    
                                                    @if($product->video_url != null || $user_product->video_url != null)
                                                        <a href="{{  $user_product->video_url ?? $product->video_url }}" target="_blank" class="btn btn-outline-primary "><i class="fa fa-play-circle fa-lg"></i> Watch Video</a>
                                                    @endif
                                                    
                                                @else   
                                                    @if($product->video_url != null || $user_product->video_url != null)
                                                        <a href="{{  $user_product->video_url ?? $product->video_url }}" target="_blank" class="btn btn-outline-primary "><i class="fa fa-play-circle fa-lg"></i> Watch Video</a>
                                                    @endif
                                                @endif
                                            @else


                                                <div class="d-flex justify-content-between">

                                                    @if ($scan == 1)
                                                        {{-- Do Something Here.. --}}
                                                    @else
                                                        <div>
                                                            <a href="{{ url('/auth/login') }}" class="btn btn-outline-primary mb-0 ms-2"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                                                            {{-- <a href="{{ url('/auth/login') }}" class="btn ms-2 btn-outline-primary mb-0 me-2"> <i class="fa fa-comments"></i> Enquiry</a> --}}
                                                            <button type="button" class="btn btn-outline-primary  mb-0 enquiryModal me-2"><i class="fa fa-comments"></i> Enquiry</button>
                                                        </div>
                                                    @endif



                                                    @if($product->video_url != null || $user_product->video_url != null)
                                                        <a href="{{  $user_product->video_url ?? $product->video_url }}" target="_blank" class="btn btn-outline-primary "><i class="fa fa-play-circle fa-lg"></i> Watch Video</a>
                                                    @endif



                                                </div>
                                            @endif
                                        </div>
                                    </form>
                                    @if ($scan == 1)
                                    @php
                                        $user_id = auth()->id();
                                        $proposals = App\Models\Proposal::where('user_id',$user_id)->get();
                                    @endphp
                                        <form action="{{ route('pages.proposals.addpropitem') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="price" value="{{ $price }}">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group my-3">
                                                        {{-- <label class="mr-2">Add in Proposal :</label> --}}
                                                        <select name="proposal_details" id="proposal_details" class="form-select d-none">
                                                            <option>Choose Offer To Add</option>
                                                            @foreach ($proposals as $proposal)
                                                                <option value="{{ $proposal->id }}" @if ($proposalidrequest == $proposal->id) selected @endif>{{ json_decode($proposal->customer_details)->customer_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button class="btn btn-primary mt-3" type="submit">Add to Offer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
    
                                </div>
                                
                            </div>
                            <div class="col-md-12 mt-4 d-none">
                                @php
                                    $user_tags = explode(',',$user_shop_item->tags);
                                @endphp

                                @if ($user_tags != null)
                                    <h6 class="mb-1">Tags:</h6>
                                    <div class="text-muted mb-2">
                                        @foreach ($user_tags as $tag)
                                            <div style="font-size:14px;">{{ $tag }}</div>                                            
                                        @endforeach
                                    </div>
                                @elseif($product->tag1 != null || $product->tag2 != null || $product->tag3 != null)
                                    <h6 class="mb-1">Tags:</h6>
                                    <div class="text-muted mb-2">
                                        <div style="font-size:14px;">{{ $product->tag1 }}</div>
                                        <div style="font-size:14px;">{{ $product->tag2 }}</div>
                                        <div style="font-size:14px;">{{ $product->tag3 }}</div>
                                    </div>
                                @endif


                                
                            </div>
                            <div class="col-12  mt-5">
                                @if ($user_shop_item->description != null)
                                    <h6 class="mb-1">Description:</h6>
                                    <p class="">{!!  html_entity_decode(preg_replace('/_x([0-9a-fA-F]{4})_/', '&#x$1;', $user_shop_item->description)) ?? '' !!}</p>
                                @elseif($product->description != null)
                                    <h6 class="mb-1">Description:</h6>
                                    <p class="">{!!  html_entity_decode(preg_replace('/_x([0-9a-fA-F]{4})_/', '&#x$1;', $product->description)) ?? '' !!}</p>
                                    
                                @endif


                            </div>


                            <div class="col-12 mt-3">
                                @if ($product->artwork_url != null ||  $user_shop_item->artwork_url != null )
                                    <h6 class="mb-1 mt-2">Artwork outline:</h6>
                                    <a href="{!! $product->artwork_url ?? $user_shop_item->artwork_url !!}" title="Artwork Reference of {!! $product->title ?? $user_shop_item->title !!}" class="btn btn-outline-primary my-2" target="_blank">Download</a>
                                @endif
                            </div>



                            
                            <div class="col-12">
                                @if($features != null)
                                    <div class="mt-3 mb-3">
                                        <h6 class="mb-1">Features:</h6>
                                        <div class="d-flex align-items-center">
                                            <ul class="list-unstyled text-muted">
                                                @foreach (explode(PHP_EOL,$features) as $feature)
                                                
                                                        <li class="mb-1"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>{{ $feature }}</li>
                                    
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif    
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
                <div class="col-12">

                    @if  ($carton_details['standard_carton'] == '' && $carton_details['carton_unit'] == '' && $carton_details['carton_weight'] == '' && $shipping_details['length'] == '' && $shipping_details['width'] == '' && $shipping_details['height'] == '' && $shipping_details['weight'] == '')
                        {{-- <span>No Details Are Avaiable of This Product Right Now</span> --}}
                    @else
                        <h5 class="mb-4">Additional Information:</h5>
                    @endif


                    <div class="row">

                        @if ($shipping_details['length'] == '' && $shipping_details['width'] == '' && $shipping_details['height'] == '' && $shipping_details['weight'] == '')
                            {{-- if Everything is Blank Then Show NOthing --}}
                        @else
                            <div class="col-lg-6 col-md-6 col-12">
                                <img style="height: 230px;" src="{{ asset('frontend/assets/img/product/item.jpg') }}" alt="">
                                <table class="table table-striped" style="width: 35%;">
                                    <tbody>
                                        <tr>
                                            <th>Length</th>
                                            <td>{{ $shipping_details['length'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Width</th>
                                            <td>{{ $shipping_details['width'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Height</th>
                                            <td>{{ $shipping_details['height'] ?? '' }} </td>
                                        </tr>
                                        @if(isset($shipping_details) && @$shipping_details['length_unit'])
                                        <tr>
                                            <th>Length unit</th>
                                            <td>{{ $shipping_details['length_unit'] ?? '' }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Weight</th>
                                            <td>{{ $shipping_details['weight'] ?? '' }}</td>
                                        </tr>
                                        @if(isset($shipping_details) && @$shipping_details['unit'])
                                        <tr>
                                            <th>Unit</th>
                                            <td>{{ $shipping_details['unit'] ?? '' }}</td>
                                        </tr>
                                        @endif
                                        @if($product['hsn_percent'])
                                        <tr>
                                            <th>HSN Percent</th>
                                            <td>{{ $product['hsn_percent'] ?? '' }} %</td>
                                        </tr>
                                        @endif
                                        @if($product['hsn'])
                                        <tr>
                                            <th>HSN</th>
                                            <td>{{ $product['hsn'] ?? '' }}</td>
                                        </tr>
                                        @endif
                                    
                                    </tbody>
                                </table>
                            </div>
                        @endif




                        @if ($carton_details['standard_carton'] == '' && $carton_details['carton_unit'] == '' && $carton_details['carton_weight'] == '')
                            {{-- Nothing To Show Here     --}}
                        @else
                                
                            <div class="col-lg-6 col-md-6 col-12">
                                <img style="height: 230px;" src="{{ asset('frontend/assets/img/product/carton.jpg') }}" alt="">
                                <table class="table table-striped mt-3" style="width: 35%;">
                                    <tbody>
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
                </div>
            </div><!--end row-->
        </div><!--end container--> 

        @if($related_products->count() > 0)
            <div class="container mt-100 mt-60">
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-0">Related Products</h5>
                    </div><!--end col-->
                    <div class="col-12 mt-4 mb-4">
                        <div class="row">
                            @forelse ($related_products as $related_product)
                                @php
                                    $user_shop_item = getUserShopItemByProductId($slug,$related_product->id);
                                    $image_ids = $user_shop_item->images != null ? explode(',',$user_shop_item->images) : [];
                                    if($group_id && $group_id != 0){
                                        $related_price =  getPriceByGroupIdProductId($group_id,$related_product->id,$price);
                                    }
                                @endphp
                                <div class="tiny-slide col-lg-3 col-md-4 col-12">
                                    <div class="card shop-list border-0 position-relative m-2">
                                        <ul class="label list-unstyled mb-0">
                                            <li><a href="javascript:void(0)" class="badge badge-link rounded-pill bg-danger">Hot</a></li>
                                        </ul>
                                        <div class="shop-image position-relative overflow-hidden rounded shadow">
                                            @php
                                                $relatedProId= \Crypt::encrypt($related_product->id);
                                            @endphp
                                            <a href="{{ route('pages.shop-show',$relatedProId) }}">
                                                <img src="{{ asset(getMediaByIds($image_ids)->path ?? asset('frontend/assets/img/placeholder.png')) }}" class="img-fluid" alt="" style="width: 100%;height: 145px;object-fit: contain;">
                                            </a>
                                            <ul class="list-unstyled shop-icons">
                                                <li class="mt-1"><a href="{{ route('pages.shop-show',$relatedProId) }}" class="btn btn-icon btn-pills btn-soft-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye icons"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a></li>
                                                <form action="{{ route('pages.add-cart')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="unit_price" value="{{ $related_price ?? '0' }}">
                                                    <input type="hidden" name="qty" value="1">
                                                    <input type="hidden" name="product_id" value="{{ $related_product->id ?? '0' }}">
                                                    {{-- <li class="mt-2">
                                                        <button type="submit" class="btn btn-icon btn-pills btn-soft-warning">
                                                            <x-icon name="shopping-cart" class="feather feather-shopping-cart icons" />
                                                        </button>
                                                    </li> --}}
                                                </form>
                                            </ul>  
                                        </div>
                                        <div class="card-body content pt-4 p-2">
                                            <a href="{{ route('pages.shop-show',$relatedProId)."?pg=".request()->get('pg') }}" class="text-dark product-name h6">{{ \Str::limit($related_product->title,30) }}</a>
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
                                                    @if($user_shop_item->price)
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
            </div><!--end container-->
        @endif
        @include('frontend.micro-site.shop.include.enquiry-modal')
        @include('frontend.micro-site.shop.include.zoom-image')
    </section><!--end section-->
        @include('frontend.micro-site.shop.include.bulk',['product_id' => $product->id])
@endsection
@section('InlineScript')


    <script>
        
        $(document).ready(function(){
            // Ashish ka URl
            console.log("{{$url}}");
            $('.bulkbtn').on('click',function(){
                $('#BuyBulk').modal('show');
            });
            $('.zoomImg').on('click',function(){
                var imageSrc = $('.slider-zoom').attr('src');
                $('#zoomImageContainer').attr('src',imageSrc)
                $('#zoomImageModal').modal('show');
            });
            $('.enquiryModal').on('click',function(){
                $('#enquiryModal').modal('show');
            });
            $('.slider-zoom-selector').on('click',function(){
                $('.slider-zoom').attr('src',$(this).attr('data-img'));
            });
            $('#enquiryForm').on('submit',function(e){
                e.preventDefault();
                var price =  $('#price').val();
                var pModelCode = "{{urlencode( getProductRefIdByRole($product,$user_shop_item, 2))}}";
                var pName = "{{urlencode($product->title)}}";
                var colorSize = "{{urlencode($product->color.' '.$product->size)}}";
                var qty =  $('#enq-qty').val();
                var requiredIn = $('#requiredIn').val();
                var comment = $('#comment').val();
                var enquiry = 'Hi, I am interested in the '+pModelCode+' | '+pName+' '+colorSize+'  Could you let me know if I can buy '+qty+' units by '+requiredIn+' at a price of '+price+'₹ per unit? ';
               var url = 'https://api.whatsapp.com/send?phone={{$phone_number}}&text='+enquiry;
                window.location.href = url;
            });
        });
    </script>
@endsection