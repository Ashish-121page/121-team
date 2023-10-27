@extends('frontend.layouts.main')

@section('meta_data')
    @php
    $meta_title = 'Join | ' . getSetting('app_name');
    $meta_description = '' ?? getSetting('seo_meta_description');
    $meta_keywords = '' ?? getSetting('seo_meta_keywords');
    $meta_motto = '' ?? getSetting('site_motto');
    $meta_abstract = '' ?? getSetting('site_motto');
    $meta_author_name = '' ?? 'GRPL';
    $meta_author_email = '' ?? 'Hello@121.page';
    $meta_reply_to = '' ?? getSetting('frontend_footer_email');
    $meta_img = ' ';
    $no_header = 1;
    $no_footer = 1;
    @endphp
@endsection

@section('content')
    <style>
        .select2.select2-container {
            width: 100% !important;
        }

        .select2-container .select2-search--inline .select2-search__field {
            padding: 4px;
        }

        .alert-danger {
            color: #842029 !important;
            background-color: #f8d7da !important;
            border-color: #f5c2c7 !important;
        }
        .selecotr-item{
            position:relative;
            flex-basis:calc(70% / 3);
            height:75%;
            display:block;

        }
        .selecotr-item span{
            border: 1px solid;
            padding: 2px 8px;
            border-radius: 3px;
            margin-right: 7px;
        }
        .selector-item_radio{
            appearance:none;
            display:none;
        }
        .selector-item_label{
            position:relative;
            height:80%;
            width: 25%;
            border:2px solid rgb(4, 69, 175);;
            line-height: 300%;
            font-weight:900;
            transition-duration:.5s;
            transition-property:transform, color, box-shadow;
            transform:none;
            margin-top:10px;
            padding-left: 15px;
            cursor: pointer;
        }
        .selector-item_radio:checked + .selector-item_label{
            background-color:#eee;
            color:#000;
            transform:translateY(-2px);
        }
        .selector-item_radio:hover + .selector-item_label{
            background-color:#eee;
            color:#000;
            transform:translateY(-2px);
        }
        @media (max-width:480px) {
            .selector{
                width: 90%;
            }
            .selector-item_label{
                width: 60% !important;
            }
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        } 
        .verification-code {
            max-width: 300px;
            position: relative;
            margin:50px auto;
            text-align:center;
        }
        .control-label{
        display:block;
        margin:40px auto;
        font-weight:900;
        }
        .verification-code--inputs input[type=text] {
            border: 2px solid #e1e1e1;
            width: 46px;
            height: 46px;
            padding: 10px;
            text-align: center;
            display: inline-block;
        box-sizing:border-box;
        }

    </style>
    @php
        $general_array = [
            ['id'=>1,'question'=>" Import all your existing & new Supplier catalogues in 121"],
            ['id'=>2,'question'=>"Quick search of over 50,000 SKU"],
            ['id'=>3,'question'=>"Get quick replies from Suppliers"],
            ['id'=>4,'question'=>"Your own Life-time e-visiting card site"],
            ['id'=>5,'question'=>"All at 0 cost"],
        ];
        $customer_array = [
            ['id'=>1,'question'=>"Import all your existing & new Supplier catalogues in 121"],
            ['id'=>2,'question'=>"Quick search of over 50,000 SKU"],
            ['id'=>3,'question'=>"Get quick replies from Suppliers"],
            ['id'=>4,'question'=>"Your own Life-time e-visiting card site"],
            ['id'=>5,'question'=>"All at 0 cost"],
        ];
        $brand_array = [
            ['id'=>1,'question'=>"Get user analytics to reduce inventory holding cost + R&D of new products"],
            ['id'=>2,'question'=>"Easy inventory management tool for real-time business updates"],
            ['id'=>3,'question'=>"Power of over 15,000 bulk sellers in your sales team"],
        ];
        $seller_array = [
            ['id'=>1,'question'=>"Catalogue - Shortlist SKU - Add to Shop feature to < do > + Own choice domain website"],
            ['id'=>2,'question'=>"Catalogues to customers, verified by their mobile OTP"],
            ['id'=>3,'question'=>"Connect to 5,000 Suppliers of over 500 brands for bulk buying (not retail)"],
            ['id'=>4,'question'=>"Increase speed of operations"],
        ];
    @endphp

    <!-- Hero End -->
    <!-- Start -->
    <section class="">
        <form onkeydown="return event.key != 'Enter';" action="{{ route('user-enquiry.questions.store') }}" method="post" id="formSubmit" class="questions-card digit-group" style="display: none;margin: 0px 0px 0px 50px;" > 
            <div class="row">
                <input type="hidden" name="code">
                <div class="col-md-6 d-flex align-items-center " style="height: 500px !important">
                    <div class="">
                        
                            @csrf
                            <div class="" style="">
                                <div class="card-body">
                                    <ul>
                                        @php
                                            $questions = getJoiningQuestions();
                                        @endphp

                                        {{-- <li class="d-none">
                                            <div class="save-div w-100" style="display: block;">
                                                <h4>Start with 121</h4>
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label">Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter Name" id="name" name="name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="form-label d-block">Phone</label>
                                                    <div class="form-floating mb-3 text-center" style="border-style: solid;  border-radius:11px;
                                                    border-width: 1px; padding: 7px; border-color: #6666CC;">
                                                    <img src="{{ asset('frontend/assets/img/ind-flag.png') }}" width="20px">
                                                    <input required name="phone[]" class="custom-input_box" type="number" id="digit-1" data-next="digit-2" maxlength="9" max="9">
                                                    <input required name="phone[]" class="custom-input_box" type="number" id="digit-2" data-next="digit-3" data-previous="digit-1" maxlength="9" max="9">
                                                    <input required name="phone[]" class="custom-input_box" type="number" id="digit-3" data-next="digit-4" data-previous="digit-2" maxlength="9" max="9">
                                                    <input required name="phone[]" class="custom-input_box" type="number" id="digit-4" data-next="digit-5" data-previous="digit-3" maxlength="9" max="9">

                                                    <input required name="phone[]" class="custom-input_box" type="number" id="digit-5" data-next="digit-6" data-previous="digit-4" maxlength="9" max="9">
                                                    <input required name="phone[]" class="custom-input_box" type="number" id="digit-6" data-next="digit-7" data-previous="digit-5" maxlength="9" max="9">
                                                    <input required name="phone[]" class="custom-input_box" type="number" id="digit-7" data-next="digit-8" data-previous="digit-6" maxlength="9" max="9">
                                                    <input required name="phone[]" class="custom-input_box" type="number" id="digit-8" data-next="digit-9" data-previous="digit-7" maxlength="9" max="9">

                                                    <input required name="phone[]" class="custom-input_box" type="number" id="digit-9" data-next="digit-10" data-previous="digit-8" maxlength="9" max="9">
                                                    <input required name="phone[]" class="custom-input_box" type="number" id="digit-10" data-next="digit-11" data-previous="digit-9" maxlength="9" max="9">
                                                </div>
                                                <button type="button" class="btn btn-primary d-block mt-2" id="save">Save</button>
                                            </div>
                                        </li> --}}

                                        <li class="">
                                            <div class="first_que">
                                                <h4>Q.{{ $questions[0]['id'] }} {{ $questions[0]['question'] }}</h4>
                                                <div class="selector">
                                                    <div class="selecotr-item">
                                                        <input type="radio" id="yes_q1" name="q1" class="selector-item_radio first_click" value="yes">
                                                        <label for="yes_q1" class="selector-item_label">
                                                        <span>A</span>
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="selecotr-item">
                                                        <input type="radio" id="no_q1" name="q1" class="selector-item_radio first_click" value="no">
                                                        <label for="no_q1" class="selector-item_label">
                                                        <span>B</span>
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="general_tab">
                                                <p class="p-0 m-0 text-muted"> You seem to</p>
                                                <h4 class="m-0 p-0">
                                                    <strong class="text-primary">
                                                    Buyer
                                                    </strong>
                                                </h4>

                                                <h6 class="text-dark">Benefits of 121 for you:</h6>
                                                <ul class="list-unstyled mb-0 mt-3 ps-0">
                                                    @foreach ($general_array as $generals)
                                                        <li class="h6 text-dark mb-0" style="display: flex;">
                                                            <span class="icon h5 me-2">
                                                                <i class="text-success uil uil-check-circle align-middle"></i>
                                                            </span>
                                                            {{ $generals['question'] }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="my-3">
                                                    <a href="{{ url('/auth/login') }}" class="btn btn-secondary d-block" style="pointer-events: none;">Login / Signup</a>
                                                </div>
                                                <hr>
                                                {{-- <div class="mx-auto text-center">
                                                    <a href="https://calendly.com/121page/double-your-b2b-business-121-now?month=2022-05" class="btn btn btn-primary d-block">Book Demo</a>
                                                </div> --}}
                                                <a href="javascript:void(0)" data-toggle="modal" class="buyer-book-demo btn btn btn-primary d-block">Book Demo</a>
                                            </div>
                                        </li> 
                                        <li class="">
                                            <div class="second_que">
                                                <h4>Q.{{ $questions[1]['id'] }} {{ $questions[1]['question'] }}</h4>
                                                <div class="selector">
                                                    <div class="selecotr-item">
                                                        <input type="radio" id="yes_q2" name="q2" class="second_click selector-item_radio" value="yes">
                                                        <label for="yes_q2" class="selector-item_label">
                                                        <span>A</span>
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="selecotr-item">
                                                        <input type="radio" id="no_q2" name="q2" class="second_click selector-item_radio" value="no">
                                                        <label for="no_q2" class="selector-item_label">
                                                        <span>B</span>
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="customer_tab">
                                                <p class="p-0 m-0 text-muted"> You seem to</p>
                                                <h4 class="m-0 p-0">
                                                    <strong class="text-primary">
                                                    Customer
                                                    </strong>
                                                </h4>

                                                <h6 class="text-dark">Benefits of 121 for you:</h6>
                                                <ul class="list-unstyled mb-0 mt-3 ps-0">
                                                    @foreach ($customer_array as $customers)
                                                        <li class="h6 text-dark mb-0" style="display: flex;">
                                                            <span class="icon h5 me-2">
                                                                <i class="text-success uil uil-check-circle align-middle"></i>
                                                            </span>
                                                            {{ $customers['question'] }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="my-3">
                                                    <a href="{{ url('auth/login') }}" class="btn btn-secondary d-block" style="pointer-events: none;">Login / Signup</a>
                                                </div>
                                                <hr>
                                                <div class="mx-auto text-center">
                                                    <a href="javascript:void(0)" data-toggle="modal" class="buyer-book-demo btn btn btn-primary d-block">Book Demo</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="">
                                            <div class="third_que">
                                                <h4>Q.{{ $questions[2]['id'] }} {{ $questions[2]['question'] }}</h4>
                                                <div class="selector">
                                                    <div class="selecotr-item">
                                                        <input type="radio" id="yes_q3" name="q3" class="third_click selector-item_radio" value="yes">
                                                        <label for="yes_q3" class=" selector-item_label">
                                                        <span>A</span>
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="selecotr-item">
                                                        <input type="radio" id="no_q3" name="q3" class="third_click selector-item_radio" value="no">
                                                        <label for="no_q3" class="selector-item_label">
                                                        <span>B</span>
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="seller_tab">
                                                <p class="p-0 m-0 text-muted"> You seem to</p>
                                                <h4 class="m-0 p-0">
                                                    <strong class="text-primary">
                                                    Seller
                                                    </strong>
                                                </h4>


                                                <h6 class="text-dark">Benefits of 121 for you:</h6>
                                                <ul class="list-unstyled mb-0 mt-3 ps-0">
                                                    @foreach ($seller_array as $sellers)
                                                        <li class="h6 text-dark mb-0" style="display: flex;">
                                                            <span class="icon h5 me-2">
                                                                <i class="text-success uil uil-check-circle align-middle"></i>
                                                            </span>
                                                            {{ $sellers['question'] }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="mt-5">
                                                    <a href="javascript:void(0)" data-toggle="modal" class="buyer-book-demo btn btn btn-primary d-block">Book Demo</a></div>
                                            </div>
                                        </li>
                                        <li class="">
                                        <div class="fourth_que">
                                                <h4>Q.{{ $questions[3]['id'] }} {{ $questions[3]['question'] }}</h4>
                                                <div class="selector">
                                                    <div class="selecotr-item">
                                                        <input type="radio" id="yes_q4" name="q4" class="fourth_click selector-item_radio" value="yes">
                                                        <label for="yes_q4" class="selector-item_label">
                                                        <span>A</span>
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="selecotr-item">
                                                        <input type="radio" id="no_q4" name="q4" class="fourth_click selector-item_radio" value="no">
                                                        <label for="no_q4" class="selector-item_label">
                                                        <span>B</span>
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                        </div>
                                            <div class="brand_tab">
                                                <p class="p-0 m-0 text-muted"> You seem to</p>
                                                <h4 class="m-0 p-0">
                                                    <strong class="text-primary">
                                                    Brand
                                                    </strong>
                                                </h4>

                                                <h6 class="text-dark">Benefits of 121 for you:</h6>
                                                <ul class="list-unstyled mb-0 mt-3 ps-0">
                                                    @foreach ($brand_array as $brands)
                                                        <li class="h6 text-dark mb-0" style="display: flex;">
                                                            <span class="icon h5 me-2">
                                                                <i class="text-success uil uil-check-circle align-middle"></i>
                                                            </span>
                                                            {{ $brands['question'] }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="mt-5">
                                                    <a href="javascript:void(0)" data-toggle="modal" class="buyer-book-demo btn btn btn-primary d-block">Book Demo</a></div>
                                            </div>
                                        </li>
                                        <li class="">
                                            <div class="five_que">
                                                <h4>Q.{{ $questions[4]['id'] }} {{ $questions[4]['question'] }}</h4>
                                                <div class="selector">
                                                    <div class="selecotr-item">
                                                        <input type="radio" id="yes_q5" name="q5" class="fifth_click selector-item_radio" value="yes">
                                                        <label for="yes_q5" class="selector-item_label">
                                                        <span>A</span>
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="selecotr-item">
                                                        <input type="radio" id="no_q5" name="q5" class="fifth_click selector-item_radio" value="no">
                                                        <label for="no_q5" class="selector-item_label">
                                                        <span>B</span>
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="customer_tab_five">
                                            <p class="p-0 m-0 text-muted"> You seem to</p>
                                                <h4 class="m-0 p-0">
                                                    <strong class="text-primary">
                                                    Seller
                                                    </strong>
                                                </h4>


                                                <h6 class="text-dark">Benefits of 121 for you:</h6>
                                                <ul class="list-unstyled mb-0 mt-3 ps-0">
                                                    @foreach ($seller_array as $sellers)
                                                        <li class="h6 text-dark mb-0" style="display: flex;">
                                                            <span class="icon h5 me-2">
                                                                <i class="text-success uil uil-check-circle align-middle"></i>
                                                            </span>
                                                            {{ $sellers['question'] }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="my-3">
                                                    <a href="{{ url('/auth/login') }}" class="btn btn-secondary d-block" style="pointer-events: none;">Login / Signup</a>
                                                </div>
                                                <hr>
                                                <div class="mx-auto text-center">
                                                    <a href="javascript:void(0)" data-toggle="modal" class="buyer-book-demo btn btn btn-primary d-block">Book Demo</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end row-->
                            <div class="text-center mt-4 submit_btn" id="">
                                <button class="btn btn-primary" type="submit">Skip & Start</button>
                            </div>

                            
                        </div>
                    </div>
                <div class="col-md-6 d-flex justify-content-center mx-auto text-center align-items-center">
                    <div>
                        <img class="problem-image" src="{{ asset('frontend/assets/img/start/problem.png') }}" alt="">
                    </div>
                </div>
            </div>
            <!--end container-->
            @include('frontend.website.join.buyer-modal')
        </form>
    </section>
    {{-- <form id="resendOtpForm"   action="{{ route('user-enquiry.questions.store') }}" method="post"> 
        <input type="hidden" name="phone" value="">
    </form> --}}
    <!--end section-->
    <!-- End -->
@endsection
@section('InlineScript')
    <script>


        // $('#sendOTP').on('click',function(){
            
        //     $('#resendOtpForm').submit();
       
        // });
        var otp =  {{ session()->get('start_otp') }};
        var url = "{{ route('join.index') }}";

        $('#verify_otp_btn').on('click', function(){
            var digit1 = $('#digit-otp-1').val();
            var digit2 = $('#digit-otp-2').val();
            var digit3 = $('#digit-otp-3').val();
            var digit4 = $('#digit-otp-4').val();

            if(digit1 == '' || digit2 == '' || digit3 == '' || digit4 == ''){
                    alert('Please enter 4 digit OTP');
            }else{
                var complilation = digit1+''+digit2+''+digit3+''+digit4;
                if(complilation == otp){
                    // Call AJAX Here
                    saveData();

                    // Redirect
                    setTimeout(() => {
                        window.location.href = url;
                    }, 1000);
                }else{
                    alert('Please enter correct OTP.');
                    $('#digit-otp-1').val('');
                    $('#digit-otp-2').val('');
                    $('#digit-otp-3').val('');
                    $('#digit-otp-4').val('');
                }
            }
        });

        $('.second_que').addClass('d-none').fadeIn();
        $('.third_que').addClass('d-none').fadeIn();
        $('.fourth_que').addClass('d-none').fadeIn();
        $('.five_que').addClass('d-none').fadeIn();
        $('.general_tab').addClass('d-none').fadeIn();
        $('.customer_tab').addClass('d-none').fadeIn();
        $('.customer_tab_five').addClass('d-none').fadeIn();
        $('.seller_tab').addClass('d-none').fadeIn();
        $('.brand_tab').addClass('d-none').fadeIn();
        $('.submit_btn').addClass('d-none').fadeIn();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       
        function saveData(){
            formdata = $('#formSubmit').serialize();

            $.ajax({
                url: "{{ route('user-enquiry.questions.store') }}",
                method: "post",
                data: formdata,
                success: function(res){
                    console.log('Thank you. Your submission is done, Our team get back to you within 24 hours.');
                }
            })
        }
        function resendOTP(){
            
            var digitphone1 = $('#digit-1').val();
            var digitphone2 = $('#digit-2').val();
            var digitphone3 = $('#digit-3').val();
            var digitphone4 = $('#digit-4').val();
            var digitphone5 = $('#digit-5').val();
            var digitphone6 = $('#digit-6').val();
            var digitphone7 = $('#digit-7').val();
            var digitphone8 = $('#digit-8').val();
            var digitphone9 = $('#digit-9').val();
            var digitphone10 = $('#digit-10').val();

            if(digitphone1 == '' || digitphone2 == '' || digitphone3 == '' || digitphone4 == '' || digitphone5 == '' || digitphone6 == '' || digitphone7 == '' || digitphone8 == '' || digitphone9 == '' || digitphone10 == ''){
                    alert('Please enter 10 digit valid phone number');
            }else{
                timer();
                var complilation_phone = digitphone1+''+digitphone2+''+digitphone3+''+digitphone4+''+digitphone5+''+digitphone6+''+digitphone7+''+digitphone8+''+digitphone9+''+digitphone10;
                $.ajax({
                    url: "{{ route('join.resend-otp') }}",
                    method: "post",
                    data: {'phone':complilation_phone},
                    success: function(res){
                        otp =  res.otp;
                        $.toast({
                        heading: 'SUCCESS',
                        text: "OTP send successfully!",
                        showHideTransition: 'slide',
                        icon: 'success',
                        loaderBg: '#f96868',
                        position: 'top-right'
                        });
                    }
                })
            }
            
        }

        $('.verify-otp').on('click', function() {
            resendOTP();
            if($('#name').val() == ''){
                alert('Please enter your name');
                $('#name').focus()
                return true;
            }

            var digitphone1 = $('#digit-1').val();
            var digitphone2 = $('#digit-2').val();
            var digitphone3 = $('#digit-3').val();
            var digitphone4 = $('#digit-4').val();
            var digitphone5 = $('#digit-5').val();
            var digitphone6 = $('#digit-6').val();
            var digitphone7 = $('#digit-7').val();
            var digitphone8 = $('#digit-8').val();
            var digitphone9 = $('#digit-9').val();
            var digitphone10 = $('#digit-10').val();

            if(digitphone1 == '' || digitphone2 == '' || digitphone3 == '' || digitphone4 == '' || digitphone5 == '' || digitphone6 == '' || digitphone7 == '' || digitphone8 == '' || digitphone9 == '' || digitphone10 == ''){
                    alert('Please enter 10 digit valid phone number');
            }else{
                $('.form-signin').removeClass('d-none');
                $(this).hide();
                timer();
            }
        });
        
        // $('#save').on('click', function() {
        //     if($('#name').val() == '' || $('#phone').val() == ''){
        //         alert('Please Fill All Infomation');
        //     }else{
        //         $('.save-div').hide();
        //          $('.first_que').removeClass('d-none').fadeIn();
        //     }
        // });
        $('.first_click').on('click', function() {
           var value =  $(this).val();
           if(value == 'yes'){
                setTimeout(
                function() {
                    $('.first_que').hide();
                    $('.second_que').removeClass('d-none').fadeIn();
                },
                500);
           }else{
               saveData();
               $('.first_que').hide();
               $('.general_tab').removeClass('d-none').fadeIn();
           }
        });
        $('.second_click').on('click', function() {
            var value = $(this).val();
            if(value == 'yes'){
                 setTimeout(
                function() {
                    $('.second_que').addClass('d-none').fadeIn();
                    $('.third_que').removeClass('d-none').fadeIn();
                    $('.general_tab').addClass('d-none').fadeIn();
                },
                500);
            }else{
                saveData();
                $('.second_que').addClass('d-none').fadeIn();
                $('.customer_tab').removeClass('d-none').fadeIn(); 
                $('.general_tab').addClass('d-none').fadeIn();
            }
            
        });
        $('.third_click').on('click', function() {
            var value = $(this).val();
            if(value == 'yes'){
                setTimeout(
                function() {
                    $('.third_que').addClass('d-none').fadeIn();
                    $('.fourth_que').removeClass('d-none').fadeIn();
                },
                500);

            }else{
                saveData();
                $('.third_que').addClass('d-none').fadeIn();
                $('.seller_tab').removeClass('d-none').fadeIn(); 
                $('.customer_tab').addClass('d-none').fadeIn(); 
                $('.general_tab').addClass('d-none').fadeIn();
            }
            
        });
        $('.fourth_click').on('click', function() {
            var value = $(this).val();
            if(value == 'yes'){
                setTimeout(
                function() {
                    $('.fourth_que').addClass('d-none').fadeIn();
                    $('.second_que').addClass('d-none').fadeIn();
                    $('.five_que').removeClass('d-none').fadeIn();
                },
                500);
            }else{
                saveData();
                $('.fourth_que').addClass('d-none').fadeIn();
                $('.second_que').addClass('d-none').fadeIn();
                $('.brand_tab').removeClass('d-none').fadeIn(); 
                $('.customer_tab').addClass('d-none').fadeIn(); 
                $('.general_tab').addClass('d-none').fadeIn();
            }
            
        });
        $('.fifth_click').on('click', function() {
            var value = $(this).val();
            
            if(value == 'yes'){
                 saveData();
                setTimeout(
                function() {
                    $('.second_que').addClass('d-none').fadeIn();
                    $('.five_que').addClass('d-none').fadeIn();
                     $('.brand_tab').removeClass('d-none').fadeIn(); 
                },
                500);
            }else{
                saveData();
                $('.five_que').addClass('d-none').fadeIn();
                $('.fourth_que').addClass('d-none').fadeIn();
                $('.second_que').addClass('d-none').fadeIn();
                $('.brand_tab').addClass('d-none').fadeIn(); 
                $('.customer_tab').addClass('d-none').fadeIn(); 
               $('.general_tab').removeClass('d-none').fadeIn();
            }
        });

        $(document).ready(function(){
            $('.questions-card').show().fadeIn();
        });


        $('.digit-group').find('.custom-input_box').each(function() {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function(e) {
                var parent = $($(this).parent());
                
                if(e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));
                    
                    if(prev.length) {
                        $(prev).select();
                    }
                } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105)) { 
                    var next = parent.find('input#' + $(this).data('next'));
                    
                    if(next.length) {
                        $(next).select();
                    } else {
                        if(parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });
        });
       
       
        $('.digit-group').find('input[type=number]').each(function() {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function(e) {
                var parent = $($(this).parent());
                
                if(e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));
                    
                    if(prev.length) {
                        $(prev).select();
                    }
                } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                    var next = parent.find('input#' + $(this).data('next'));
                    
                    if(next.length) {
                        $(next).select();
                    } else {
                        if(parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });


        });
        $('#sendOTP').hide();

        function timer(){
            var timeLeft = 30;
                var elem = document.getElementById('Timer');

                var timerId = setInterval(countdown, 1000);

                function countdown() {
                if (timeLeft == 0) {
                    clearTimeout(timerId);
                    $('#sendOTP').show();
                    $('#Timer').hide();
                } else {
                    elem.innerHTML = timeLeft + 'seconds';
                    timeLeft--;
                }
            }
        }
            
        $('.custom-input_box').on('click keyup paste', function(){
            var input_val = $(this).val();
            console.log(input_val);
            if(input_val.length > 1){
                $(this).val(input_val.slice(0, 1));
            }
        });
        $('.buyer-book-demo').on('click',function(){
            // alert('s');
            $('#buyerBookDemoModal').modal('show');
        });
    </script>
@endsection
