
<div class="container mt-100 mt-60" id="products">
    <div class="row align-items-end mb-3 pb-4">
        <div class="col-md-8">
            <div class="section-title text-center text-md-start">
                <!--<h6 class="text-primary">Product</h6>-->
                <h4 class="title mb-4 text-primary">{{ $products['title'] ?? ''}}</h4>
                <p class="text-muted mb-0 para-desc">{{ $products['description'] ?? ''}}</p>
            </div>
        </div><!--end col-->

        <div class="col-md-4 mt-3 mt-sm-0">
            <div class="text-center text-md-end">
                @if(checkShopView($slug) && isset($user) && $user->is_supplier == 1)
                    <a target="_blank" href="{{ route('pages.shop-index',$slug) }}" class="text-primary h6">
                        {{-- {{ $products['label'] ?? '' }}  --}}
                        @if ($products['label'] == 'Visit Shop')
                            Visit Display
                        @else
                            Visit Display
                        @endif
                        <i class="uil uil-angle-right-b align-middle"></i>
                    </a>
                @endif
            </div>
        </div><!--end col-->
    </div><!--end row-->

    <section class="">
        <div class="container">
            <div class="row justify-content-center">
                {{-- <div class="col-md-8">
                        <div class="owl-slider filters-group-wrap">
                            <div id="carousel" class="owl-carousel filters-group-wrap">
                                <div class="item fltr-mnu">
                                    <p class="list-inline-item categories-name border text-dark rounded active1" id="all-btn">All</p>
                                    
                                </div>
                                <div class="item fltr-mnu">
                                    <p class="list-inline-item categories-name border text-dark rounded" id="cat1-btn">Category-1</p>
                                    
                                </div>
                                <div class="item fltr-mnu">
                                    <p class="list-inline-item categories-name border text-dark rounded">Category-2</p>
                                </div>
                                <div class="item fltr-mnu">
                                    <p class="list-inline-item categories-name border text-dark rounded">Category-2</p>
                                </div>
                                <div class="item fltr-mnu">
                                    <p class="list-inline-item categories-name border text-dark rounded">Category-2</p>
                                </div>
                                <div class="item fltr-mnu">
                                    <p class="list-inline-item categories-name border text-dark rounded">Category-2</p>
                                </div>
                                <div class="item fltr-mnu">
                                    <p class="list-inline-item categories-name border text-dark rounded">Category-2</p>
                                </div>
                            </div>
                        </div>
                </div> --}}
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row" id="all">
                       @if($related_products->count() > 0)
                       
                            @forelse ($related_products as $related_product)
                                @php
                                    $user_shop_item = getUserShopItemByProductId($slug,$related_product->id);
                                    $price =  $user_shop_item->price ?? 0;
                                    $image_ids = $user_shop_item->images != null ? explode(',',$user_shop_item->images) : [];
                                    if($group_id && $group_id != 0){
                                        $related_price =  getPriceByGroupIdProductId($group_id,$related_product->id,$price);
                                    }
                                @endphp
                                    <div class="tiny-slide col-lg-3 col-md-4 col-12">
                                        <div class="card shop-list border-0 position-relative m-2">
                                            <div class="shop-image position-relative overflow-hidden rounded shadow">
                                                @php
                                                    $relatedProId= \Crypt::encrypt($related_product->id);
                                                @endphp
                                                <a href="{{ route('pages.shop-show',$relatedProId) }}">
                                                    <img src="{{ asset(getMediaByIds($image_ids)->path ?? asset('frontend/assets/img/placeholder.png')) }}" class="img-fluid product-catalogue"  alt="" >
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
                                                <div class="d-flex justify-content-between mt-1">
                                                    <h6 class="text-dark small fst-italic mb-0 mt-1">
                                                        @php
                                                        $supplier = \App\User::whereId($related_product->user_id)->first();
                                                        $price =  getUserShopItemByProductId($slug, $related_product->id)->price ?? 0; 
                                                        $access_data = \App\Models\AccessCatalogueRequest::whereUserId(auth()->id())->whereNumber(@$supplier->phone)->whereStatus(1)->first();

                                                        if($access_data && $access_data->price_group_id != 0){
                                                            $price =  @getPriceByGroupIdProductId($access_data->price_group_id,$related_product->id,$price);
                                                        }
                                                        @endphp
                                                        @if(checkShopView($user_shop->slug) && $user->is_supplier == 1)
                                                            @if($price) 
                                                                {{ format_price($price) }} 
                                                            @else
                                                                <span>{{ format_price(0) }}</span>
                                                            @endif
                                                        @endif
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @empty 
                                
                            @endforelse
                        @else
                        
                            <div class="text-center">
                                <p>No Products Added yet!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>


        </div><!--end container-->
    </section>
</div>