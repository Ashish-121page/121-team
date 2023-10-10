@extends('backend.layouts.main') 
@section('title', 'Payment Settings')
@section('content')
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    @endpush
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Payment Setting')}}</h5>
                            <span>{{ __('This setting will be automatically updated in your website.')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        
                            <nav class="breadcrumb-container" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('panel.dashboard')}}"><i class="ik ik-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">{{ __('Setting')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('Payment')}}</li>
                                </ol>
                            </nav>
                    </div>
                </div>
                @include('backend.setting.sitemodal',['title'=>"How to use",'content'=>"You need to create a unique code and call the unique code with paragraph content helper."])
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card card-484">
                    <form class="forms-sample" action="{{ route('panel.setting.payment.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="group_name" required value="payment_method">
                            <div class="card-header"><h3>{{ __('Payment Configuration')}}</h3></div>
                                <div class="card-body">
                                    <div id="accordion">
                                        <div class="accordion-header mb-3" id="headingOne">
                                            <button type="button" class="btn accordion-button " data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Stripe Payment Method
                                            </button>
                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="accordion-body">
                                                    <div class="switch-content mt-4">
                                                        <div class="form-group row">
                                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">{{ __('Active')}}<span class="text-danger">*</label>
                                                            <div class="col-sm-9">
                                                                <input type="checkbox"   value="1" name="services_stripe_active" class="js-single switch-input stripe" @if(getSetting('services_stripe_active') == 1) checked @endif />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">{{ __('API KEY')}}<span class="text-danger">*</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="api_stripe_key" class="form-control" placeholder="Stripe API KEY"  required value="{{ getSetting('api_stripe_key') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">{{ __('Secert')}}<span class="text-danger">*</label>
                                                            <div class="col-sm-9">
                                                                <input type="password" name="api_stripe_secret" class="form-control" placeholder=" Stripe API Secert"  required value="{{ getSetting('api_stripe_secret') }}">
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="accordion-header mb-3" id="headingTwo">                            
                                          <button type="button" class="btn accordion-button collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Paypal Payment Method
                                          </button>
                                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                            <div class="accordion-body">
                                                <div class="switch-content mt-4">
                                                    <div class="form-group row">
                                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">{{ __('Active')}}</label>
                                                        <div class="col-sm-9">
                                                            <input type="checkbox" value="1" name="services_paypal_active" class="js-switch switch-input paypal" @if(getSetting('services_paypal_active') == 1) checked @endif />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">{{ __('API KEY')}}<span class="text-danger">*</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="api_paypal_key" class="form-control" placeholder="Paypal API KEY" required value="{{ getSetting('api_paypal_key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">{{ __('Secert')}}<span class="text-danger">*</label>
                                                        <div class="col-sm-9">
                                                            <input type="password" name="api_paypal_secret" class="form-control" placeholder="Paypal API Secert" required value="{{ getSetting('api_paypal_secret') }}">
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                          </div>
                                        </div>
                                        <div class="accordion-header mb-3" id="headingThree">                            
                                          <button type="button" class="btn accordion-button collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Razor Pay Payment Method
                                          </button>
                                          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="accordion-body">
                                                <div class="switch-content mt-4">
                                                    <div class="form-group row">
                                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">{{ __('Active')}}</label>
                                                        <div class="col-sm-9">
                                                            <input type="checkbox" value="1" name="services_razor_pay_active" class="js-switch switch-input razorpay" @if(getSetting('services_razor_pay_active') == 1) checked @endif />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">{{ __('Razor API KEY')}}<span class="text-danger">*</label> </label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="api_razor_key" class="form-control" placeholder="Razor API KEY" required value="{{ getSetting('api_razor_key') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">{{ __('Secert')}}<span class="text-danger">*</label></label>
                                                        <div class="col-sm-9">
                                                            <input type="password" name="api_razor_secret" class="form-control" placeholder="Razor API Secert" required value="{{ getSetting('api_razor_secret') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="accordion-header mb-3" id="headingFour">                            
                                          <button type="button" class="btn accordion-button collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            Offline Payment Method
                                          </button>
                                          <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                            <div class="accordion-body">
                                                <div class="switch-content mt-4">
                                                    <div class="form-group row">
                                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">{{ __('Active')}}</label>
                                                        <div class="col-sm-9">
                                                            <input type="checkbox" value="1" name="services_offline_active" class="js-switch switch-input razorpay" @if(getSetting('services_offline_active') == 1) checked @endif />
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 mt-0 p-0">
                                                        <span>User gets assistance for offline payment via admin</span>
                                                    </div>
                                                    <textarea name="payment_offline_instruction" class="form-control p-0" id="" cols="30" rows="5">{{ getSetting('payment_offline_instruction') }}</textarea>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary mr-2">{{ __('Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script>
       
          $('.switch-input').on('click', function (e) {
                //              e.preventDefault();
            console.log($(this));
            var content = $(this).closest('.switch-content');
            if (content.hasClass('d-none')) {
                $(this).attr('checked', 'checked');
                content.find('input').attr('required', true);
                content.removeClass('d-none');
            } else {
                content.addClass('d-none');
                content.find('input').attr('required', false);
            }
        });
    </script>
    @endpush
@endsection