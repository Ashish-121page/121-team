@extends('frontend.layouts.main-white')
@section('content')
<style>
    /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
        <section class="bg-home d-flex align-items-center position-relative" style="background: url('images/shape01.png') center;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="form-signin p-4 bg-white rounded shadow">
                           <form action="{{ route('auth.otp-validate') }}" class="digit-group"  data-group-name="digits" data-autosubmit="false" autocomplete="off" method="post">
                            @csrf
                                <img src="{{ asset('frontend/assets/img/logo-icon.png') }}" class="avatar avatar-small mb-4 d-block mx-auto" alt="">
                                <h5 class="mb-3 text-center">Verify OTP</h5>
                                <p class="text-muted text-center">
                                    Please enter your 4-digit OTP which has been sent to your mobile number 
                                    <span class="text-primary"> {{ $phone }} 
                                        <a class="text-muted" title="Change Mobile Number?" href="{{ url('/auth/login') }}">
                                            <small class="text-primary" style="text-decoration:underline;color: #000 !important;
                                            font-weight: 600;">change</small>
                                        </a> 
                                    </span>
                                </p>
                                
                                    <div class="text-center mb-3 d-none">
                                        {{ session()->get('otp') }}
                                    </div>
                                    <div class="form-floating mb-3 text-center">
                                            <input required class="otp" type="number" min="0" max="9" id="digit-1" name="otp[]" data-next="digit-2" />
                                            <input required class="otp" type="number" min="0" max="9" id="digit-2" name="otp[]" data-next="digit-3" data-previous="digit-1" />
                                            <input required class="otp" type="number" min="0" max="9" id="digit-3" name="otp[]" data-next="digit-4" data-previous="digit-2" />

                                            <input required class="otp" type="number" min="0" max="9" id="digit-4" name="otp[]" data-next="digit-5" data-previous="digit-3" />
                                    </div>
                                  <button type="submit" class="btn btn-primary w-100 mt-2" style="width:auto!important;margin:auto;display:block;"><span class="text-white"> Verify OTP</span></button>
                                    
                                  <hr>

                                <a href="javascript:void(0)" id="sendOTP" style="text-align: center;display: block;padding-top: 5px;color: #6666cc;">Resend OTP</a>

                                <div id="Timer" class="text-muted" style="text-align: center;"></div>

                                <p class="mb-0 text-muted mt-3 text-center" style="position:relative"><span style="position:absolute;left:0;">© {{ date('Y') }}</span> 121.Page</p>
                            </form>
                        </div>
                         <form id="resendOTP" action="{{ route('auth.login-validate') }}" method="POST">
                                @csrf
                                <input type="hidden" value="1" name="resent">
                            <input required name="phone" id="phone" type="hidden" maxlength="10"  value="{{ request()->phone }}" >
                         </form>   
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('script')
    <script>
        $('input[type="number"]').each(function(){
			$(this).on('keyup',function(){
				if ($(this).val() > Number($(this).attr("max"))) {
                    val=$(this).val().slice(0, $(this).attr("max").length);
                    $(this).val(val);
                }
			});
		});

        $('.digit-group').find('input').each(function() {
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

            $('#sendOTP').on('click', function(){
                $('#resendOTP').submit();
            });


        });
        
        $('#sendOTP').hide();

                var timeLeft = 60;
                var elem = document.getElementById('Timer');

                var timerId = setInterval(countdown, 1000);

                function countdown() {
                    if (timeLeft == 0) {
                        clearTimeout(timerId);
                        $('#sendOTP').show();
                        $('#Timer').hide();
                    } else {
                        elem.innerHTML = timeLeft + ' seconds';
                        timeLeft--;
                    }   
                }
           
    </script>
@endpush