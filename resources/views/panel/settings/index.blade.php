@extends('backend.layouts.main')
@section('title', 'Settings')
@section('content')

    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">

    <link href="{{ asset('frontend/assets/css/simplebar.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">



    <!-- push external head elements to head -->
    @push('head')
    

    @endpush

    <div class="container-fluid">
        
        <div class="row">
            <div class="col-md-6 col-12 my-2">
                <div class="one" style="display: flex;align-items: center;justify-content: flex-start;">

                    <a href="{{ request()->url() }}" class="btn btn-outline-primary @if (!request()->has('open')) active @endif mx-1">
                        Templates
                    </a>

                    <a href="{{ request()->url() }}?open=offers" class="btn btn-outline-primary @if (request()->get('open') == 'offers') active @endif mx-1">
                        Currency
                    </a>

                    <a href="{{ request()->url() }}?open=team" class="btn btn-outline-primary @if (request()->get('open') == 'team') active @endif mx-1">
                        Team
                    </a>


                </div>
            </div>


            {{-- ` This Menu is Always Visible  --}}
            
            <div class="col-md-6 col-12 my-2">        
                @if (!request()->has('open')) 
                    <div class="two" style="display: flex;align-items: center;justify-content: flex-end;">
                        <a href="https://forms.gle/W7xxYt9gwzamse9TA" target="_blank" class="btn btn-outline-primary mx-1">
                            Create New
                        </a>                    
                    </div>
                @endif    
            </div>


        </div>

        <div class="row">

            @if (request()->has('open') && request()->get('open') == 'offers')
                @include('panel.settings.pages.Offers')
            @elseif (request()->has('open') && request()->get('open') == 'team')
                @include('panel.settings.pages.Team')
            @else
                @include('panel.settings.pages.Template')
            @endif
        </div>

    </div>

    
@include('frontend.customer.dashboard.includes.modal.add-currencies')
@include('frontend.customer.dashboard.includes.modal.update-currency')
@include('frontend.customer.dashboard.includes.modal.createTeam')
    
    
    
    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function () {
                $(".updatecurrencybtn").click(function (e) { 
                    e.preventDefault();

                    let crrname = $(this).data('crrname');
                    let crrid = $(this).data('crrid');
                    let crrvalue = $(this).data('crrvalue');
                    
                    $('#currencyname').val(crrname);
                    $('#crrid').val(crrid);

                    $('#currencyvalue').val(crrvalue);


                    $("#updatecurrency").modal('show')
                });

                $("#addcurrencyopen").click(function (e) { 
                    e.preventDefault();
                    $('#addcurrency').modal('show');
                });
                $("#addmember").click(function (e) {
                    e.preventDefault();
                    $("#addTeam").modal("show");
                });

                $(".select2insidemodalTeam").select2({
                    dropdownParent: $("#addTeam")
                });

                $('#otpButtonteam').on('click',function(e){
                e.preventDefault();
                    var number = $('#contact_number').val();
                    if (number != '' && number != null) {
                        $.ajax({
                            url: "{{ route('panel.user.send-otp') }}",
                            method: 'GET',
                            data: {
                                phone_no: number
                            },
                            success: function(response) {
                                if(response.title == 'Error'){
                                    $.toast({
                                        heading: response.title,
                                        text: response.message,
                                        showHideTransition: 'slide',
                                        icon: 'error',
                                        loaderBg: '#f2a654',
                                        position: 'top-right'
                                    });
                                }else{
                                    $.toast({
                                        heading: response.title,
                                        text: response.message,
                                        showHideTransition: 'slide',
                                        icon: 'success',
                                        loaderBg: '#f96868',
                                        position: 'top-right'
                                    });
                                }
                                $('.otpaction1').removeClass('d-none');
                                $('.otpaction2').removeClass('d-none');
                                $('.additionalNumber').attr('readonly',true);1
                                $('#OTP').html(response.otp)
                            }
                        });
                    }else{
                        $.toast({
                            heading: "Error",
                            text: "The number is required",
                            showHideTransition: 'slide',
                            icon: 'error',
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        });
                    }
                });

        $('#verifyOTP').on('click',function(e){
            e.preventDefault();
            $('#saveBtn').attr('disabled',false);
            $('.check-icon').removeClass('d-none');
            var verifyOTP = $('#otp_num').val();
            $.ajax({
                url: "{{ route('panel.user.verify-otp') }}",
                method: 'GET',
                data: {
                    "otp": verifyOTP
                },
                success: function(response) {
                    console.log(response);
                    if(response.title == 'Error'){
                        $.toast({
                            heading: response.title,
                            text: response.message,
                            showHideTransition: 'slide',
                            icon: 'error',
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        });
                    }else{
                        $.toast({
                            heading: response.title,
                            text: response.message,
                            showHideTransition: 'slide',
                            icon: 'success',
                            loaderBg: '#f96868',
                            position: 'top-right'
                        });
                        $(this).addClass('d-none');

                        $("#TeamForm").submit();
                    }
                }
            })
        })
            });
        </script>
    @endpush
@endsection
