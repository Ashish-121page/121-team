@extends('frontend.layouts.main')
@section('meta_data')
    @php
		$meta_title = 'Shop-Payment | '.getSetting('app_name');		
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
<style>
    .alert-danger {
        color: #842029 !important;
        background-color: #f8d7da !important;
        border-color: #f5c2c7 !important;
    }
    .alert-warning {
        color: #F2823A !important;
        background-color: #f8dfcf !important;
        border-color: #fdb588 !important;
    }
</style>
@section('content')
       <section class="bg-half-170 bg-light d-table w-100" style="padding: 50px 0;background: none;">
            <div class="container">
                <div class="row mt-0 justify-content-center">
                    <div class="col-lg-5">

                        <div class="pages-heading d-flex justify-content-center">
                            <h4 class="title mt-3 mb-0" style="line-height: 1"> Checkout </h4>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
                
                <div class="position-breadcrumb">
                    <nav aria-label="breadcrumb" class="d-inline-block">
                        <ul class="breadcrumb bg-white rounded shadow mb-0 px-4 py-2">
                            <li class="breadcrumb-item"><a href="{{ route('pages.shop-index',$slug) }}">{{ $user_shop->name }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pages.shop-pre-checkout',$slug) }}">Checkout</a></li>
                            <li class="breadcrumb-item"><a href="#">Overview</a></li>
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
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-lg-6 mx-auto">
                        <div class="card rounded shadow p-4 border-0">
                            @if($order->to == null)
                                @php
                                    $user_address = App\Models\UserAddress::whereUserId($order->user_id)->get();	
                                @endphp
                                <form action="{{ route('pages.order.update.address') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $order->id }}">
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
                                                <a href="{{route('customer.dashboard')}}{{'?active=address'}}" target="_blank" style="cursor: pointer;" id="new-address-btn"><i class="mdi mdi-plus"></i> <span>Add a new address</span></a>
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
                                                                    <input id="adres{{ $index }}" name="shipping_address" value="{{ $item->id }}" type="radio" class="form-check-input address-check">
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
                                                <input type="text" name="name" class="form-control" id="firstName" placeholder="First Name" value="{{ $order->user->name }}"
                                                required>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-append" id="basic-addon3">
                                                        <label class="input-group-text">+91</label>
                                                    </span>
                                                    <input class="form-control" name="phone" type="number" id="phone" value="{{ $order->user->phone }}" >
                                                </div>
                                                {{-- <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" id="phone" placeholder="Enter Phone" value="{{ $order->user->phone }}"
                                                required> --}}
                                            </div>
        
                                            <div class="col-12">
                                                <label for="email" class="form-label">Email <span
                                                   class="text-muted">(Optional)</span></label>
                                                <input type="email" value="{{ $order->user->email }}" class="form-control" name="email" id="email" placeholder="you@example.com">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="w-100 btn btn-primary mt-3" disabled type="submit" id="submit-btn">Proceed to Pay </button>
                                </form>
                            @else
                                @if ($details != null)
                                    <form action="{{route('pages.store.shop-checkout',$slug)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$order_id}}">
                                        <div class="">
                                            <h4 class="mb-0">Payment Method</h4>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input required id="offline" name="payment_method" type="radio" class="form-check-input" value="1">
                                                        <label class="form-check-label" for="offline">PO</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input id="online" name="payment_method" type="radio" class="form-check-input" value="2">
                                                        <label class="form-check-label" for="online">UPI</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="po d-none mt-3">
                                                        <div class="">
                                                            <span class="text-muted">{!! nl2br($details['po']) ?? 'Not added yet!'!!}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group upi d-none text-center mx-auto">
                                                        @if ($details && $details['upi'] != null)
                                                            <img id="img" src="{{ asset($details['upi']) }}" class="mt-1"
                                                            style="border-radius: 10px;width: 350px;
                                                            height: auto;" />
                                                        @else 
                                                            <div class="text-center mx-auto mt-3">
                                                                <h6 class="text-muted">They have not uploaded their UPI </h6>
                                                            </div>   
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 mt-1" id="new-address">
                                                <div class="col-sm-6">
                                                    <label for="transaction_id" class="form-label">Transaction Id <span class="text-danger">*</span></label>
                                                    <input type="text" name="transaction_id" class="form-control" id="transaction_id" placeholder="Enter Transaction Id" value=""
                                                        required>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="transaction_file" class="form-label">Transaction Attactment <span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" id="transaction_file" name="transaction_file" placeholder="First Name" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="mt-4 w-100 btn btn-primary" type="submit">Place Order</button>
                                    </form>
                                @else
                                    <div>
                                        <i class="fa text-muted fa-exclamation-triangle fa-2x" aria-hidden="true"></i>                               
                                        <h5 class="mt-3">No Payment Method Available</h5>
                                        <p>This shop hasn't added their payment details yet, you can contact them or try again after some time.</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="card rounded shadow p-4 border-0 mt-2">

                            <hr> 

                            <h6 class="text-center">
                                Contact Seller incase you face any trouble.
                                <br>
                                <a href="tel:+{{ $user_shop->contact_no ?? '' }}" class="text-center btn-sm mx-auto mt-2 btn btn-outline-success">Contact Seller</a>
                            </h6>
                        </div>

                    </div>
                    @php
                        $cart_details = App\Models\Cart::whereUserId(auth()->id())->get();
                    @endphp
                    <div class="col-lg-4 mt-lg-0 mt-md-5 mt-5">
                        <div class="table-responsive bg-white rounded shadow">
                            <table class="table table-center table-padding mb-0 bg-light">
                                <thead>
                                    <tr>
                                        <th class="border-bottom py-3 ps-4" colspan="2" style="min-width:20px ">ORDER DETAILS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="h6 ps-4 py-3">Subtotal <span>({{ $order->items->count() }} Items)</span></td>
                                        <td class="text-end fw-bold pe-4">{{ format_price($order->sub_total) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="h6 ps-4 py-3">GST</td>
                                        <td class="text-end fw-bold pe-4"> {{  format_price($order->tax) }} </td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td class="h6 ps-4 py-3">Total</td>
                                        <td class="text-end fw-bold pe-4">{{ format_price($order->total) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->
@endsection
@section('InlineScript')
    <script>
      $(document).ready(function(){
        $('.address-check').click(function() {
            if($(this).is(":checked")){
                $('#submit-btn').prop('disabled', false);
            }else{
                $('#submit-btn').prop('disabled', true);
            }
        });
        $('#same_as_billing').on('change', function() {
            if(this.checked) {
                $('.shipping-address-block').addClass('d-none');
            }else{
                $('.shipping-address-block').removeClass('d-none');
            }
        });
        $('#offline').click('on',function(){
             if($(this).is(":checked")) {
               $('.po').removeClass('d-none');
               $('.upi').addClass('d-none');
            } else {
                $('.upi').removeClass('d-none');
                $('.po').addClass('d-none');
            }
            
        }); 
        $('#online').click('on',function(){
             if($(this).is(":checked")) {
               $('.upi').removeClass('d-none')  
               $('.po').addClass('d-none');
            } else {
                $('.po').removeClass('d-none')  
                $('.upi').addClass('d-none');
            }
        }); 
      });
    </script>
@endsection