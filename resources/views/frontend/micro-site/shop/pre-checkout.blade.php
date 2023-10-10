    @extends('frontend.layouts.main')
    @section('meta_data')
        @php
            $meta_title = 'Shop-Checkout | '.getSetting('app_name');		
            $meta_description = '' ?? getSetting('seo_meta_description');
            $meta_keywords = '' ?? getSetting('seo_meta_keywords');
            $meta_motto = '' ?? getSetting('site_motto');		
            $meta_abstract = '' ?? getSetting('site_motto');		
            $meta_author_name = '' ?? 'GRPL';		
            $meta_author_email = '' ?? 'Hello@121.page';		
            $meta_reply_to = '' ?? getSetting('frontend_footer_email');		
            $meta_img = ' ';	
            $microsite = 1;	
        @endphp
    @endsection
    @section('content')
    @php
        $user = auth()->user();

        $cart_details = App\Models\Cart::whereUserShopId($user_shop->id)->whereUserId(auth()->id())->get();
        $subtotaltax = 0;
        foreach ($cart_details as $item){
            $tax_percent = 0;
            $tax_amount = 0;
            $product = getProductDataById($item->product_id);
            if($product->hsn_percent != null && $product->hsn_percent != 0){
                $tax_percent = $product->hsn_percent;
                $tax_amount = round(($item->total * $product->hsn_percent)/100,2);
            }
            $subtotaltax += $tax_amount;
        }
                    
    @endphp
        <section class="bg-half-170 bg-light d-table w-100" style="padding: 50px 0;background: none;">
                <div class="container">
                    <div class="row mt-0 justify-content-center">
                        <div class="col-lg-5">

                            <div class="pages-heading d-flex justify-content-center">
                                {{-- <img src="{{ asset('frontend/assets/img/logo-dark.png') }}" style="height: auto;margin-right: 15px;align-self: center;"> --}}
                                <h4 class="title mt-3 mb-0" style="line-height: 1"> Checkouts </h4>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                    
                    <div class="position-breadcrumb">
                        <nav aria-label="breadcrumb" class="d-inline-block">
                            <ul class="breadcrumb bg-white rounded shadow mb-0 px-4 py-2">
                                <li class="breadcrumb-item"><a href="{{ route('pages.index',$slug) }}">{{ $user_shop->name }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('pages.shop-index',$slug) }}">Cart</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Checkouts</li>
                            </ul>
                        </nav>
                    </div>
                </div> <!--end container-->
            </section><!--end section-->
            <div class="position-relative">
                <div class="shape overflow-hidden text-white">
                    <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                    </svg>
                </div>
            </div>
            <!-- Hero End -->

            <!-- Start -->
            @php
                $user_address = App\Models\UserAddress::whereUserId(auth()->id())->get();
            @endphp
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7 col-lg-8">
                            <form id="pre-checkout" action="{{ route('pages.store.shop-pre-checkout',$slug) }}" method="POST" class="card rounded shadow p-4 border-0">
                                @csrf
                                <div class="">
                                    <h4 class="mb-2">Billing address</h4>
                                    <div class="row mt-0">
                                        @if($user_address->count() > 0)
                                            @foreach ($user_address as $index => $item)
                                            @php
                                                $address_temp = json_decode($item->details);
                                            @endphp
                                                @if(!is_null($address_temp))
                                                <div class="col-lg-6">
                                                    <div class="m-1 p-2 border rounded">
                                                        <div class="mb-2">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <h6 class="m-0 p-0 mb-3">{{ $item->type == 0 ? "Home" : "Office" }} Address:</h6>
                                                                <input required id="adres{{ $index }}" name="address" value="{{ $item->id }}" type="radio" class="form-check-input address-check">
                                                            </div>
                                                        </div>
                                                        <div class="pt-4 border-top">
                                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                                <div>
                                                                    <p class="h6 text-muted">{{ $address_temp->address_1 }}</p>
                                                                    <p class="h6 text-muted">{{ $address_temp->address_2}}</p>
                                                                    <p class="h6 text-muted mb-0">
                                                                        {{ CountryById($address_temp->country) }},
                                                                        {{ StateById( $address_temp->state) }}, 
                                                                        {{ CityById( $address_temp->city) }}</p>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:void(0)" data-id="{{ $item }}"  class="btn btn-primary editAddress" >Edit</a>
                                                            <a href="{{ route('customer.address.delete',$item->id) }}" class="btn btn-primary delete-item" data-original-title="delete" title="Delete Address">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="text-center">
                                            <i class="uil uil-map-marker-alt text-primary fa-2x"></i>
                                            <div class="text-muted">No Address Found!</div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row mt-3 pt-2">
                                        <div class="col-12 mb-2">
                                            {{-- <a href="{{route('customer.dashboard')}}{{'?active=account&subactive=my_address'}}" target="_blank" style="cursor: pointer;" id="new-address-btn"><i class="mdi mdi-plus"></i> <span>Add a new address</span></a> --}}
                                            <a href="{{ remove_subdomain('customer/dashboard?active=account&subactive=my_address',$user_shop->slug ?? '') }}" target="_blank" style="cursor: pointer;" id="new-address-btn"><i class="mdi mdi-plus"></i> <span>Add a new address</span></a>
                                        </div>
                                    </div>
                                    <hr>
                                    <h4 class="mb-0">Shipping address</h4>
                                    <div class="row mt-3 pt-2">
                                        <div class="col-6 mb-2">
                                            <div class="form-check">
                                                <input id="same_as_billing" name="same_as_billing" type="checkbox" class="form-check-input" checked="">
                                                <label for="">Same as billing address</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-0 shipping-address-block d-none mb-3 " >
                                        @if($user_address->count() > 0)
                                            @foreach ($user_address as $index => $item)
                                            @php
                                                $address_temp = json_decode($item->details);
                                            @endphp
                                                @if(!is_null($address_temp))
                                                <div class="col-lg-6">
                                                    <div class="m-1 p-2 border rounded">
                                                        <div class="mb-2">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <h6 class="m-0 p-0 mb-3">{{ $item->type == 0 ? "Home" : "Office" }} Address:</h6>
                                                                <input id="adres{{ $index }}" name="shipping_address" value="{{ $item->id }}" type="radio" class="form-check-input address-check shipping-check">
                                                            </div>
                                                        </div>
                                                        <div class="pt-4 border-top">
                                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                                <div>
                                                                    <p class="h6 text-muted">{{ $address_temp->address_1 }}</p>
                                                                    <p class="h6 text-muted">{{ $address_temp->address_2}}</p>
                                                                    <p class="h6 text-muted mb-0">
                                                                        {{ CountryById($address_temp->country) }},
                                                                        {{ StateById( $address_temp->state) }}, 
                                                                        {{ CityById( $address_temp->city) }}</p>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:void(0)" data-id="{{ $item }}"  class="btn btn-primary editAddress">Edit</a>
                                                            <a href="{{ route('customer.address.delete',$item->id) }}" class="btn btn-primary">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="text-center mb-3">
                                            <img src="{{ asset('frontend/assets/svg/nodata.svg') }}" style="width:50%;">  
                                            <div class="text-muted">No Address Found!</div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row g-3" id="new-address">
                                        <div class="col-sm-6">
                                            <label for="firstName" class="form-label">Full name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" id="firstName" placeholder="First Name" value="{{ auth()->user()->name }}"
                                            required>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-append" id="basic-addon3">
                                                    <label class="input-group-text">+91</label>
                                                </span>
                                                <input class="form-control" name="phone" type="number" id="phone" value="{{ auth()->user()->phone }}" >
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="email" class="form-label">Email <span
                                            class="text-muted">(Optional)</span></label>
                                            <input type="email" value="{{ auth()->user()->email }}" class="form-control" name="email" id="email" placeholder="you@example.com">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h4 class="">Item & Tax Summary</h4>
                                <div class="my-3">
                                    @foreach ($cart_details as $cart_item)
                                        @php
                                            $product = getProductDataById($cart_item->product_id);
                                        @endphp
                                        <div class="border p-3 mb-3" style="border-radius: 3px;">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div class="d-flex">
                                                        @if(isset(getShopProductImage($cart_item->product_id)->path))
                                                        <img src="{{ asset(getShopProductImage($product->id)->path) }}" class="img-fluid" style="width: 48%;border: 1px solid #f4f4f4;align-self: center;" alt="">
                                                        @else 
                                                        <img src="{{asset('frontend/assets/img/placeholder.png')}}" class="img-fluid" style="width: 48%;border: 1px solid #f4f4f4;align-self: center;" alt="">
                                                        @endif
                                                        <div class="ms-2 mt-2">
                                                            <div>
                                                                <p class="mb-0" style="line-height: 1;">SKU: <span>{{$product->sku ?? ''}}</span></p>
                                                                <p class="mb-1"><span>{{ $user_shop->name ?? '' }}</span></p>
                                                                <p class="mb-1"><span>{{ getBrandRecordByBrandId($product->brand_id)->name ?? '' }}</span></p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div>
                                                        <p class="mb-0" style="font-size: 14px;line-height: 1;"><b>Delivery date: <span style="color: green;">{{Carbon\Carbon::now()->addDays(7)->isoFormat('MMM Do YYYY')}}</span></b></p>
                                                        <p class="mb-0" style="font-size: 13px;line-height: 1;">Item despatched by: <span>{{ $user_shop->name ?? ' ' }}</span></p>
                                                        <div class="d-flex mt-2">
                                                            <p class="mb-0" style="font-size: 14px;line-height: 1;">HSN: <span>{{$product->hsn_percent}}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            
                                <button type="submit" class="btn mt-5 btn-primary" disabled id="submit-btn">Proceed to Pay</button>
                                <span class="text-danger" id="error-text">The address must be added before payment can be made.</span>
                            </form>
                        </div>
                        
                        <div class="col-lg-4 mt-lg-0 mt-md-5 mt-5">
                            <div class="table-responsive bg-white rounded shadow">
                                <table class="table table-center table-padding mb-0 bg-light">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom py-3 ps-4" colspan="2" style="min-width:20px ">PRICE DETAILS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="h6 ps-4 py-3">Subtotal <span>({{ $cart_details->count() }} Items)</span></td>
                                            <td class="text-end fw-bold pe-4">{{ format_price($cart_details->sum('total')) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="h6 ps-4 py-3">GST </td>
                                            <td class="text-end fw-bold pe-4">{{  format_price($subtotaltax) }} </td>
                                        </tr>
                                        <tr class="bg-light">
                                            <td class="h6 ps-4 py-3">Total</td>
                                            <td class="text-end fw-bold pe-4">{{ format_price($cart_details->sum('total')+$subtotaltax) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2 pt-0 text-end">
                                {{-- <button type="submit" class="btn btn-primary">Checkout</button> --}}
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!--end container-->
            </section><!--end section-->
            <!-- End -->
            @include('frontend.customer.dashboard.includes.modal.edit-address')
    @endsection
    @push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
    <script>
            $('.address-check').click(function() {
                $('#error-text').addClass('d-none');
                var chk_shipping = !$('#same_as_billing').prop('checked');
        
                if(chk_shipping){
                    if($('.shipping-check').prop('checked')){
                        $('#submit-btn').prop('disabled', false);
                        $('#error-text').addClass('d-none');
                    }else{
                        $('#submit-btn').prop('disabled', true);
                    }
                }else{
                    if($(this).is(":checked")){
                        $('#submit-btn').prop('disabled', false);
                        $('#error-text').addClass('d-none');
                    }else{
                        $('#submit-btn').prop('disabled', true);
                    }
                }
            });

        

            $('.editAddress').click(function(){
                var  address = $(this).data('id');
                if(address.type == 0){
                    $('.homeInput').attr("checked", "checked");
                    }else{
                        $('.officeInput').attr("checked", "checked");
                }
                var details = jQuery.parseJSON(address.details);
                $('#id').val(address.id);
                $('#user_id').val(address.user_id);
                $('#type').val(address.type);
                $('#address_1').val(details.address_1);
                $('#address_2').val(details.address_2);
                $('#countryEdit').val(details.country).change();
                
                setTimeout(() => {
                    $('#stateEdit').val(details.state).change();
                    setTimeout(() => {
                        $('#cityEdit').val(details.city).change();
                        }, 500);
                    }, 500);
                    $('#editAddressModal').modal('show');
                });

                function getEditStates(countryId = 101) {
                $.ajax({
                    url: "{{ route('world.get-states') }}",
                    method: 'GET',
                    data: {
                        country_id: countryId
                    },
                    success: function(res) {
                        $('#stateEdit').html(res).css('width', '100%');
                    }
                })
            }

            function getEditCities(stateId = 101) {
                $.ajax({
                    url: "{{ route('world.get-cities') }}",
                    method: 'GET',
                    data: {
                        state_id: stateId
                    },
                    success: function(res) {
                        $('#cityEdit').html(res).css('width', '100%');
                    }
                })
            }

            $(document).ready(function(){
                $('#countryEdit').on('change', function() {
                    getEditStates($(this).val());
                });

                $('#stateEdit').on('change', function() {
                    getEditCities($(this).val());
                });
                
                getStates();
            });

            $('#same_as_billing').on('change', function() {
                if(this.checked) {
                    $('.shipping-address-block').addClass('d-none');
                    if($('.address-check').prop('checked')){
                        $('#submit-btn').prop('disabled', false);
                        $('#error-text').addClass('d-none');

                    }else{
                        $('#submit-btn').prop('disabled', true);
                    }
                }else{
                    $('.shipping-address-block').removeClass('d-none');
                    if($('.shipping-check').prop('checked')){
                        $('#submit-btn').prop('disabled', false);
                        $('#error-text').addClass('d-none');
                    }else{
                        $('#submit-btn').prop('disabled', true);
                    }
                }
            });
    </script>
    @endpush