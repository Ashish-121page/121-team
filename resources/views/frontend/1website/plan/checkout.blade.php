@php

class PaytmChecksum{

	private static $iv = "@@@@&&&&####$$$$";

	static public function encrypt($input, $key) {
		$key = html_entity_decode($key);

		if(function_exists('openssl_encrypt')){
			$data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, self::$iv );
		} else {
			$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
			$input = self::pkcs5Pad($input, $size);
			$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
			mcrypt_generic_init($td, $key, self::$iv);
			$data = mcrypt_generic($td, $input);
			mcrypt_generic_deinit($td);
			mcrypt_module_close($td);
			$data = base64_encode($data);
		}
		return $data;
	}

	static public function decrypt($encrypted, $key) {
		$key = html_entity_decode($key);
		
		if(function_exists('openssl_decrypt')){
			$data = openssl_decrypt ( $encrypted , "AES-128-CBC" , $key, 0, self::$iv );
		} else {
			$encrypted = base64_decode($encrypted);
			$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
			mcrypt_generic_init($td, $key, self::$iv);
			$data = mdecrypt_generic($td, $encrypted);
			mcrypt_generic_deinit($td);
			mcrypt_module_close($td);
			$data = self::pkcs5Unpad($data);
			$data = rtrim($data);
		}
		return $data;
	}

	static public function generateSignature($params, $key) {
		if(!is_array($params) && !is_string($params)){
			throw new Exception("string or array expected, ".gettype($params)." given");			
		}
		if(is_array($params)){
			$params = self::getStringByParams($params);			
		}
		return self::generateSignatureByString($params, $key);
	}

	static public function verifySignature($params, $key, $checksum){
		if(!is_array($params) && !is_string($params)){
			throw new Exception("string or array expected, ".gettype($params)." given");
		}
		if(is_array($params)){
			$params = self::getStringByParams($params);
		}		
		return self::verifySignatureByString($params, $key, $checksum);
	}

	static private function generateSignatureByString($params, $key){
		$salt = self::generateRandomString(4);
		return self::calculateChecksum($params, $key, $salt);
	}

	static private function verifySignatureByString($params, $key, $checksum){
		$paytm_hash = self::decrypt($checksum, $key);
		$salt = substr($paytm_hash, -4);
		return $paytm_hash == self::calculateHash($params, $salt) ? true : false;
	}

	static private function generateRandomString($length) {
		$random = "";
		srand((double) microtime() * 1000000);

		$data = "9876543210ZYXWVUTSRQPONMLKJIHGFEDCBAabcdefghijklmnopqrstuvwxyz!@#$&_";	

		for ($i = 0; $i < $length; $i++) {
			$random .= substr($data, (rand() % (strlen($data))), 1);
		}

		return $random;
	}

	static private function getStringByParams($params) {
		ksort($params);		
		$params = array_map(function ($value){
			return ($value == null) ? "" : $value;
	  	}, $params);
		return implode("|", $params);
	}

	static private function calculateHash($params, $salt){
		$finalString = $params . "|" . $salt;
		$hash = hash("sha256", $finalString);
		return $hash . $salt;
	}

	static private function calculateChecksum($params, $key, $salt){
		$hashString = self::calculateHash($params, $salt);
		return self::encrypt($hashString, $key);
	}

	static private function pkcs5Pad($text, $blocksize) {
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}

	static private function pkcs5Unpad($text) {
		$pad = ord($text{strlen($text) - 1});
		if ($pad > strlen($text))
			return false;
		return substr($text, 0, -1 * $pad);
	}
}

// define('PAYTM_ENVIRONMENT', 'https://securegw-stage.paytm.in');
define('PAYTM_ENVIRONMENT', 'https://securegw.paytm.in'); // For Production

/**
* Generate checksum by parameters we have
* Find your Merchant ID, Merchant Key and Website in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
*/
define('PAYTM_MID', 'xEAvFk51161745698612');
define('PAYTM_MERCHANT_KEY', 'U4TRXLzqhXFHCqr5');  

// define('PAYTM_WEBSITE', 'WEBSTAGING');	
define('PAYTM_WEBSITE', 'DEFAULT'); // for production



function getTransactionToken(){

	$generatedOrderID = "PYTM_BLINK_".time();
    
    $coupon = session()->get('coupon');


    if (isset($coupon)) {
        $gst = $coupon * 18/100;
        $amount = $coupon + $gst;
    }else{
        $og_price = App\Models\Package::whereId($_POST['package_id'])->first()->price;
        $gst = $og_price * 18/100;
        $amount = $og_price + $gst;
    }

	// $amount = "1.00";
	$callbackUrl = "http://localhost/project/121.page-Laravel/121.page/payment/status";

	$paytmParams["body"] = array(
								"requestType" 	=> "Payment",
								"mid" 			=> PAYTM_MID,
								"websiteName" 	=> PAYTM_WEBSITE,
								"orderId" 		=> $generatedOrderID,
								"callbackUrl" 	=> $callbackUrl,
								"txnAmount" 	=> array(
														"value" => $amount,
														"currency" => "INR",
													),
								"userInfo" 		=> array(
													"custId" => "CUST_".time(),
												),
							);

		$generateSignature = PaytmChecksum::generateSignature(json_encode($paytmParams['body'], JSON_UNESCAPED_SLASHES), PAYTM_MERCHANT_KEY);

		$paytmParams["head"] = array(
								"signature"	=> $generateSignature
							);

		$url = PAYTM_ENVIRONMENT."/theia/api/v1/initiateTransaction?mid=". PAYTM_MID ."&orderId=". $generatedOrderID;

		$getcURLResponse = getcURLRequest($url, $paytmParams);

		if(!empty($getcURLResponse['body']['resultInfo']['resultStatus']) && $getcURLResponse['body']['resultInfo']['resultStatus'] == 'S'){
			$result = array('success' => true, 'orderId' => $generatedOrderID, 'txnToken' => $getcURLResponse['body']['txnToken'], 'amount' => $amount, 'message' => $getcURLResponse['body']['resultInfo']['resultMsg']);
		}else{
			$result = array('success' => false, 'orderId' => $generatedOrderID, 'txnToken' => '', 'amount' => $amount, 'message' => $getcURLResponse['body']['resultInfo']['resultMsg']);
		}
		return $result;
	
	}


	function getcURLRequest($url , $postData = array(), $headers = array("Content-Type: application/json")){

		$post_data_string = json_encode($postData, JSON_UNESCAPED_SLASHES);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
		$response = curl_exec($ch);
		return json_decode($response,true);
	}

	function getSiteURL(){
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return str_replace('config.php', '', $actual_link);
	}
	$result = getTransactionToken();

@endphp

@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Plans | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';
        $website = 1;	
        $user_address = App\Models\UserAddress::whereUserId(auth()->id())->with('userShop')->get();	
        $user_shop = App\Models\UserShop::whereUserId(auth()->id())->first();
        $full_address = json_decode($user_shop->address);
        $description = explode('^^',$package->description);
        $limits = json_decode($package->limit,true);
        $days = $package->duration ?? 0	
	@endphp 
@endsection

@section('content')
<style type="text/css">
    #paytm-pg-spinner {margin: 5% auto 0;width: 70px;text-align: center;z-index: 999999;position: relative;}

    #paytm-pg-spinner > div {width: 10px;height: 10px;background-color: #012b71;border-radius: 100%;display: inline-block;-webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;animation: sk-bouncedelay 1.4s infinite ease-in-out both;}

    #paytm-pg-spinner .bounce1 {-webkit-animation-delay: -0.64s;animation-delay: -0.64s;}

    #paytm-pg-spinner .bounce2 {-webkit-animation-delay: -0.48s;animation-delay: -0.48s;}
    #paytm-pg-spinner .bounce3 {-webkit-animation-delay: -0.32s;animation-delay: -0.32s;}

    #paytm-pg-spinner .bounce4 {-webkit-animation-delay: -0.16s;animation-delay: -0.16s;}
    #paytm-pg-spinner .bounce4, #paytm-pg-spinner .bounce5{background-color: #48baf5;} 
    @-webkit-keyframes sk-bouncedelay {0%, 80%, 100% { -webkit-transform: scale(0) }40% { -webkit-transform: scale(1.0) }}

    @keyframes sk-bouncedelay { 0%, 80%, 100% { -webkit-transform: scale(0);transform: scale(0); } 40% { 
        -webkit-transform: scale(1.0); transform: scale(1.0);}}
    .paytm-overlay{position: fixed;top: 0px;opacity: .4;height: 100%;background: #000;}

    .select2-container--default .select2-selection--multiple {
        border: 1px solid #dee2e6;
        height: 39px !important;
        overflow-y: auto;
    }
    .select2-container .select2-selection--single {
        height: 42px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 7px;
        right: 1px;
        width: 20px;
    }

    </style>

    <div class="position-relative">
        <div class="shape overflow-hidden text-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>
        <!-- Start -->
        <section class="section">
            <div class="container">
                <div class="col-lg-12 gstAndEntityNameRequired d-none">
                    <div class="alert alert-info">
                        <p class="my-2">In order to complete the checkout, you will need to provide your tax information  <a class="text-white" style="font-weight: 900;" href="{{route('customer.dashboard')}}?active=account&subactive=my_address" class="text-white">Click here to fill out your tax information</a></p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="sticky-bar-lg col-md-5 col-lg-4 order-md-last">
                        <div class="card rounded shadow p-4 border-0 sticky-bar-lg">
                            <div class="d-flex justify-content-between align-items-center mb-3"> 
                                <span class="h5 mb-0">Package Checkout</span>
                            </div>
                            <ul class="list-group mb-3 border">
                                <li class="d-flex justify-content-between lh-sm p-3 border-bottom">
                                    <h5 class="m-0 p-0">{{ $package->name ?? ''}}</h5>
                                    <small class="pt-2">
                                        {{ $days}} Days
                                    </small>
                                </li>

                                <li>
                                    <h6 class="d-flex justify-content-between p-2 pb-0 mb-0 text-muted">Features:</h6>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <div><i class="mr-2 uil uil-check-circle align-middle"></i> Add to my Site</div>
                                    <strong>{{ $limits['add_to_site'] }}</strong>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <div><i class="mr-2 uil uil-check-circle align-middle"></i> Custom Proposals</div>
                                    <strong>{{ $limits['custom_proposals'] }}</strong>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <div><i class="mr-2 uil uil-check-circle align-middle"></i> Upload Products</div>
                                    <strong>{{ $limits['product_uploads'] }}</strong>
                                </li>

                                
                                <input type="hidden" name="gdyufgb" id="ksdhfiusdhbc">
                                <hr class="mb-2">

                                @php
                                    $coupons = session()->get('coupon');
                                    if (isset($coupons)) {
                                        $package->price = session()->get('coupon');
                                    }
                                @endphp


                                <li class="d-flex justify-content-between p-2">
                                    <span>Package Cost</span>
                                    <strong id="package_price">{{ $package->price }}</strong>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <span>GST</span>
                                    <strong id="gst_cal">{{ $package->price*18/100 }}</strong>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <span>Total</span>
                                    <strong id="totoal_pay">{{ $package->price + ($package->price*18/100) }}</strong>
                                </li>
                            </ul>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-md-7 col-lg-8">
                        <div class="card rounded shadow p-4 border-0">
                            <div class="d-flex justify-content-left mb-2">
                                <a href="{{ route('panel.subscription.index') }}"><i class="fa mr-2 fa-arrow-left" style="margin-right: 6px;"></i></a><span class="h5 mb-0"> Billing Address</span>
                            </div>
                            <p class="text-muted"><i class="fas fa-info-circle"></i> After choosing an address, proceed to the next step.</p>
                            <form action="{{ route('package.store',$package->id) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" id="order_id" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" id="package_id" name="package_id" value="{{ $package->id }}">
                                <div class="row g-3">
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
                                                                <h6 class="m-0 p-0">{{ $item->type == 0 ? "Home" : "Office" }} Address:</h6>
                                                                <input required id="adres{{ $index }}" name="address" value="{{ $item->id }}" type="radio" class="form-check-input address-check" data-gst_number="{{@$address_temp->gst_number ?? ''}}" data-entity_name="{{$address_temp->entity_name ??''}}">
                                                            </div>
                                                        </div>
                                                        <div class="pt-4 border-top">
                                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                                <div>
                                                                    <p class="h6 text-muted">{{ $address_temp->address_1 }}</p>
                                                                    <p class="h6 text-muted">{{ $address_temp->address_2}}</p>
                                                                    <p class="h6 text-muted">
                                                                        {{ CountryById($address_temp->country) }},
                                                                        {{ StateById( $address_temp->state) }}, 
                                                                        {{ CityById( $address_temp->city) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                       <div class="text-center">
                                        <i class="uil uil-map-marker-alt text-primary fa-2x"></i>
                                        <div class="text-muted">You don't have any address yet! Add one to proceed.</div>
                                       </div>
                                    @endif
                                </div>
                                <div class="row mt-3 pt-2">
                                    <div class="col-12 mb-2">
                                        {{-- <a href="{{route('customer.dashboard')}}{{'?active=account&subactive=my_address'}}" style="cursor: pointer;" id="new-address-btn"><i class="mdi mdi-plus"></i> <span>Add a new address</span></a> --}}
                                        <a href="#" style="cursor: pointer;" id="new-address-btn" class="addAddress"><i class="mdi mdi-plus"></i> <span>Add a new address</span></a>
                                    </div>
                                </div>
                               
                                {{-- <button class="w-100 btn btn-primary mt-3 submit-btn" disabled type="submit">Test pay</button> --}}
                            </form> 
                                <form action="" method="POST" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                    
                                    @if($message = Session::get('message'))
                                        <p>{!! $message !!}</p>
                                        <?php Session::forget('success'); ?>
                                    @endif

                                    <div class="couponbox">
                                        <label for="mycoupon" class="form-label">Coupon</label>
                                        <div class="form-group d-flex">    
                                            <input type="text" name="mycoupon" id="mycoupon" value="{{ session()->get('couponname') ?? "" }}" class="form-control" placeholder="Enter Coupon.."> {{-- For Coupan Input --}}
                                            <button type="button" class="btn btn-success mx-2 applycoupon">Apply</button>
                                        </div>
                                        <small class="text-danger py-2 d-none" style="font-weight: 800" id="error">Invailed Coupon</small>
                                        <small class="text-success py-2 d-none" style="font-weight: 800" id="success">Coupon Applied</small>
                                    </div>

                                    
                                    <button type="submit" disabled class="w-100 btn btn-primary mt-3 pay submit-btn">Pay now</button>
                                    <div class="check mt-2">
                                        <small for="check">
                                            <input type="checkbox" checked> I Accept <a href="{{ url('page/terms') }}" class="btn-link">Terms and Services</a></small>
                                    </div>
                                    <div id="paytm-pg-spinner" class="paytm-pg-loader" style="display: none;">
                                        <div class="bounce1"></div>
                                        <div class="bounce2"></div>
                                        <div class="bounce3"></div>
                                        <div class="bounce4"></div>
                                        <div class="bounce5"></div>
                                    </div>
                                    <div class="paytm-overlay" style="display:none;"></div>
                                </form>
                            {{-- @endif --}}
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->
        @include('frontend.website.plan.modals.add-address')
@endsection
@push('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<script src="http://localhost/project/121.page-Laravel/121.page/backend/plugins/select2/dist/js/select2.min.js"></script>

<script>
    $('#checkoutBtn').hide();
    $(document).ready(function() {
        var gst_number = $(this).data('gst_number');
        var entity_name = $(this).data('entity_name');
        if(gst_number == '' && entity_name == ''){
            $('.gstAndEntityNameRequired').removeClass('d-none');
            $('.submit-btn').addClass('d-none');
        }else{
            $('.gstAndEntityNameRequired').addClass('d-none');
            $('.submit-btn').removeClass('d-none');
        }
        if($("input[type=radio]").is(":checked") == true){
            $('.submit-btn').prop('disabled', false);
        }else{
            $('.submit-btn').prop('disabled', true);
        }
    });
    $('#paymentModeClick').on('click',function(){
        if($(this).prop('checked',true) ){
            $('#checkoutBtn').show();
        }else{
            $('#checkoutBtn').hide();
        }
    });
    $(document).ready(function(){
        var country = "{{ $user->country }}";
        var state = "{{ $user->state }}";
        var city = "{{ $user->city }}";
        if(state){
            getStateAsync([country]).then(function(data){
                $('#state').val(state).change();
                $('#state').trigger('change');
            });
        }
        if(city){
            $('#state').on('change', function(){
                if(state == $(this).val()){
                    getCityAsync([state]).then(function(data){
                        $('#city').val(city);
                    });
                }
            });
        }
    });
</script>
<script>


    function getStates(countryId = 101) {
        $.ajax({
            url: "{{ route('world.get-states') }}",
            method: 'GET',
            data: {
                country_id: countryId
            },
            success: function(res) {
                $('#state').html(res).css('width', '100%');
            }
        })
    }

    function getCities(stateId = 101) {
        $.ajax({
            url: "{{ route('world.get-cities') }}",
            method: 'GET',
            data: {
                state_id: stateId
            },
            success: function(res) {
                $('#city').html(res).css('width', '100%');
            }
        })
    }


    $("#country").change(function (e) { 
        e.preventDefault();
        getStates($(this).val());
    });

    $("#state").change(function (e) { 
        e.preventDefault();
        getCities($(this).val());
    });

    
    $(document).ready(function () {
        
        getStates($("#country").val());
        getCities($("#state").val());
        
    });

    $('#state, #country, #city').css('width','100%').select2();

    $(".select2insidemodal").select2({
        dropdownParent: $("#addAddressModal")
    });
    


</script>
<script src="{{ asset('backend/js/checkout.js') }}"></script>



 @if(env('PAYTM_ENVIRONMENT')=='production')
        <script type="application/javascript" crossorigin="anonymous" src="https:\\securegw.paytm.in\merchantpgpui\checkoutjs\merchants\<?php echo env('PAYTM_MERCHANT_ID')?>.js" ></script>
    @else
       <script type="application/javascript" crossorigin="anonymous" src="https:\\securegw-stage.paytm.in\merchantpgpui\checkoutjs\merchants\<?php echo env('PAYTM_MERCHANT_ID')?>.js" ></script>
    @endif      



    

    <script type="text/javascript">
    //function openJsCheckout(){ 
        



    function openJsCheckoutPopup(orderId, txnToken, amount) {
        var config = {
            "root": "",
            "flow": "DEFAULT",
            "data": {
                "orderId": orderId,
                "token": txnToken,
                "tokenType": "TXN_TOKEN",
                "amount": amount
            },
            "merchant": {
                "redirect": true
            },
            "handler": {
                "notifyMerchant": function (eventName, data) {
                    console.log("notifyMerchant handler function called");
                    console.log("eventName => ", eventName);
                    console.log("data => ", data);
                }
            }
        };
        if (window.Paytm && window.Paytm.CheckoutJS) {
            // initialze configuration using init method 
            window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
                // after successfully updating configuration, invoke checkoutjs
                window.Paytm.CheckoutJS.invoke();
            }).catch(function onError(error) {
                console.log("error => ", error);
            });
        }
}





    $(".pay").click(function(e){    
        var add = $('.address-check').val();
        
        if(add == "" || add == null || add== "undefined" ){
            alert("Please select address");
            return false;
        }
        e.preventDefault();
        $.ajax({
           type:'POST',
           url:'{{ route("make.payment") }}',
           data: {
            '_token':'{{ csrf_token() }}',
            'order_id': $('#order_id').val(),
            'package_id': $('#package_id').val(),
            'address': add,
            'newprice': $("#ksdhfiusdhbc").val(),
            },

           success:function(data) {
            $('.paytm-pg-loader').show();
            $('.paytm-overlay').show();
            $(".pay").addClass('d-none');
            if(data.txnToken == ""){
                    alert(data.message);
                    $('.paytm-pg-loader').hide();
                    $('.paytm-overlay').hide();
                    $(".pay").removeClass('d-none');
                    return false;
                }
                // invokeBlinkCheckoutPopup(data.orderId,data.txnToken,data.amount)
                openJsCheckoutPopup("{{ $result['orderId'] }}","{{ $result['txnToken'] }}","{{ $result['amount'] }}")
            }
            });
            e.preventDefault();
    
    });



    // function invokeBlinkCheckoutPopup(orderId,txnToken,amount){
    
    //     window.Paytm.CheckoutJS.init({
    //         "root": "",
    //         "flow": "DEFAULT",
    //         "data": {
    //             "orderId": orderId,
    //             "token": txnToken,
    //             "tokenType": "TXN_TOKEN",
    //             "amount": amount,
    //         },
    //         handler:{
    //                 transactionStatus:function(data){
    //             } , 
    //             notifyMerchant:function notifyMerchant(eventName,data){
    //                 if(eventName=="APP_CLOSED")
    //                 {
    //                   $('.paytm-pg-loader').hide();
    //                   $('.paytm-overlay').hide();
    //                   location.reload();
    //                 }
    //                 console.log("notify merchant about the payment state");
    //             } 
    //             }
    //     }).then(function(){
    //         window.Paytm.CheckoutJS.invoke();
    //     });
    // }

    $('.addAddress').click(function(){
        user_id = $(this).data('id');
        $('#userId').val(user_id);
        $('#addAddressModal').removeAttr('tabindex');
        $('#addAddressModal').modal('show');
    });


    $("#submitaddress").click(function (e) { 
        e.preventDefault();
        var gst_number = $("input[name=gst_number]").val();
        var entity_name = $("input[name=entity_name]").val();
        var address_1 = $("input[name=address_1]").val();
        var address_2 = $("input[name=address_2]").val();
        var country = $("input[name=country]").val();
        var state = $("input[name=state]").val();
        var city = $("input[name=city]").val();
        var pincode = $("input[name=pincode]").val();
        var user_id = $("input[name=user_id]").val();
        var type = $("input[name=type]").val();
        var dataarr = {
            gst_number : gst_number,
            entity_name : entity_name,
            address_1 : address_1,
            address_2 : address_2,
            country : country ,
            state : state,
            pincode : pincode,
            user_id : user_id,
            type : type
        };

        // console.log(dataarr);
        
        $.ajax({
            type: "GET",
            url: "{{ route('customer.address.storeget') }}",
            data: dataarr,
            success: function (response) {
                // console.log("data Inserted");                
            }
        });
        
        location.reload();

    });
    

</script>   

@endpush