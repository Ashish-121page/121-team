@extends('frontend.layouts.main-white')
<style>
    .alert-danger {
        color: #842029 !important;
        background-color: #f8d7da !important;
        border-color: #f5c2c7 !important;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    @media(max-width: 700px){
        .custom-input_box{
            width: 25px !important;
            height: 30px;
            border: 0;
            border-bottom: 1px solid #817d7d;
        }
    }

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
@section('content')
 <section class="bg-home d-flex align-items-center position-relative" style="background: url('{{ asset('frontend/assets/img/shape01.png') }}') center;">
            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div>
                           <a href="{{url('/')}}"> <img src="{{ asset('frontend/assets/img/logo-icon.png') }}" class="avatar avatar-small mb-lg-4 mb-md-0 mb-0 d-block mx-auto" style="width: 150px;
                            object-fit: contain;" alt=""></a>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 ">
                        <div class="py-3 bg-white rounded shadow form-signin">
                            <form action="{{ route('auth.login-validate') }}" method="POST"
                            class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off" style="height: 230px;">
                                @csrf

                                <h5 class="mb-5 text-center">Register</h5>
                                <div class="form-icon position-relative {{ $errors->has('phone') ? 'has-error' : ''}}">
                                    <!-- <div class="form-floating text-center mx-2 phone-input-box" style=""> -->
                                    <div class="form-floating text-center mx-3" style="">
                                        <div class="d-flex mb-2">
                                        <img src="{{ asset('frontend/assets/img/ind-flag.png') }}" width="25px" height="20px" class="m-2">
                                            <input required name="phone" class="form-control mx-2" type="number" placeholder="Enter Your Phone Number">
                                        </div>
                                        {{-- <small class="text-muted" style="font-size: 0.65rem">Copy-paste / type. Should NOT include spaces, country code like +91, 91</small> --}}
                                        {{-- <img src="{{ asset('frontend/assets/img/ind-flag.png') }}" width="20px">
                                        <input required name="phone[]" class="custom-input_box" type="number" id="digit-1" data-next="digit-2" maxlength="1" max="9" >
                                        <input required name="phone[]" class="custom-input_box" type="number" id="digit-2" data-next="digit-3" data-previous="digit-1" maxlength="1" max="9">
                                        <input required name="phone[]" class="custom-input_box" type="number" id="digit-3" data-next="digit-4" data-previous="digit-2" maxlength="1" max="9">
                                        <input required name="phone[]" class="custom-input_box" type="number" id="digit-4" data-next="digit-5" data-previous="digit-3" maxlength="1" max="9">

                                        <input required name="phone[]" class="custom-input_box" type="number" id="digit-5" data-next="digit-6" data-previous="digit-4" maxlength="1" max="9">
                                        <input required name="phone[]" class="custom-input_box" type="number" id="digit-6" data-next="digit-7" data-previous="digit-5" maxlength="1" max="9">
                                        <input required name="phone[]" class="custom-input_box" type="number" id="digit-7" data-next="digit-8" data-previous="digit-6" maxlength="1" max="9">
                                        <input required name="phone[]" class="custom-input_box" type="number" id="digit-8" data-next="digit-9" data-previous="digit-7" maxlength="1" max="9">

                                        <input required name="phone[]" class="custom-input_box" type="number" id="digit-9" data-next="digit-10" data-previous="digit-8" maxlength="1" max="9">
                                        <input required name="phone[]" class="custom-input_box" type="number" id="digit-10" data-next="digit-11" data-previous="digit-9" maxlength="1" max="9"> --}}
                                    </div>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ 'Please Enter 10 Digit Number' }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-5" style="width:auto!important;margin:auto;display:block;"><span class="text-white"> Next </span></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center mt-1">
                    <div>
                        {{-- <a href="https://forms.gle/JKe6p6bic7gjnuJq5" target="_blank" class="btn-link">Trouble signing in?</a> --}}
                    </div>
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center mt-4">
                    <div>
                        <p class="mb-0 text-muted mt-3 text-center" style="position:relative"><span style="padding-right: 30px;">© {{ date('Y') }}</span> 121.Page</p>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('script')
    <script>
        $('.digit-group').find('input').each(function() {
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

        $('.custom-input_box').on('click keyup paste', function(){
            var input_val = $(this).val();
            console.log(input_val);
            if(input_val.length > 1){
                $(this).val(input_val.slice(0, 1));
            }
        });

    </script>
@endpush
