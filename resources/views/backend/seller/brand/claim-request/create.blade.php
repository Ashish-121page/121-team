@extends('backend.layouts.main')
@section('title', 'Claim Request')
@section('content')
    @php
    /**
     * Product
     *
     * @category  zStarter
     *
     * @ref  zCURD
     * @author    GRPL
     * @license  121.page
     * @version  <GRPL 1.1.0>
     * @link        https://121.page/
     */
    $breadcrumb_arr = [['name' => 'Claim Request', 'url' => 'javascript:void(0);', 'class' => '']];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error {
                color: red;
            }

        </style>
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Brand {{ getBrandById($brand_id)->name ?? '' }} Claim Request</h5>
                            {{-- <span>Create a record for Claim Request</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- start message area-->
                @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Claim Request</h3>
                    </div>
                    <div class="card-body">

                        {{-- For AS --}}
                        <div class="row">
                                {{-- Pending --}}
                                @if(isset($brand_as_user) && $brand_as_user->status == 0)
                                    <div class="col-12">
                                        <div class="alert alert-warning">
                                            Your request of becoming Authorize Seller has been already in progress.
                                        </div>
                                    </div>

                                {{-- Accepted --}}
                                @elseif(isset($brand_as_user) && $brand_as_user->status == 1)
                                    <div class="col-12">
                                        <div class="alert alert-success">
                                            You are a Authorize Seller of this brand.
                                        </div>
                                    </div>

                                {{-- Rejected --}}
                                @elseif(isset($brand_as_user) && $brand_as_user->status == 2)
                                    <div class="col-12">
                                        <div class="alert alert-danger">
                                            Your request of becoming Authorize Seller has been rejected. Please resubmit with correction
                                            <br>
                                           <strong> Reason:</strong>
                                            {{ json_decode($brand_as_user->details)->rejection_reason }}
                                        </div>
                                    </div>
                                @endif

                        </div>
                        <div class="row">
                            {{-- Pending --}}
                                @if(isset($brand_bo_user) && $brand_bo_user->status == 0)
                                    <div class="col-12">
                                        <div class="alert alert-warning">
                                            Your request of becoming Brand Owner has been already in progress.
                                        </div>
                                    </div>

                                {{-- Accepted --}}
                                @elseif(isset($brand_bo_user) && $brand_bo_user->status == 1)
                                    <div class="col-12">
                                        <div class="alert alert-success">
                                            You are a Brand Owner of this brand.
                                        </div>
                                    </div>

                                {{-- Rejected --}}
                                @elseif(isset($brand_bo_user) && $brand_bo_user->status == 2)
                                    <div class="col-12">
                                        <div class="alert alert-danger">
                                            Your request of becoming Brand Owner has been rejected
                                        </div>
                                    </div>
                                @endif
                        </div>

                       
                           
                        <div class="row">
                            <div class="col-md-12 form-group mb-0">
                                <div class="row form-radio">
                                    {{-- If Already AS --}}
                                    @if(isset($brand_as_user))
                                        @if($brand_as_user->status == 2)
                                                <div class="col-md-6">
                                                <div class="radio radio-inline">
                                                    <label>
                                                        <input type="radio" name="type" value="1" class="checkRequestType" @if(old('type') == '1') checked @endif>
                                                        <i class="helper"></i>{{ __('Apply as Authorized Seller') }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-md-6">
                                            <div class="radio radio-inline">
                                                <label>
                                                    <input type="radio" name="type" value="1" class="checkRequestType" @if(old('type') == '1') checked @endif>
                                                    <i class="helper"></i>{{ __('Apply as Authorized Seller') }}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    {{-- If Already BO --}}
                                    @if(isset($brand_bo_user))
                                        @if($brand_bo_user->status == 2)
                                                <div class="col-md-6">
                                                <div class="radio radio-inline">
                                                    <label>
                                                        <input type="radio" name="type" value="0" id="" class="checkRequestType" @if(old('type') == '0') checked @endif>
                                                        <i class="helper"></i>{{ __('Apply as Brand Owner') }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-md-6">
                                            <div class="radio radio-inline">
                                                <label>
                                                    <input type="radio" name="type" value="0" id="" class="checkRequestType" @if(old('type') == '0') checked @endif>
                                                    <i class="helper"></i>{{ __('Apply as Brand Owner') }}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Authorize Seller Fields --}}
                            <form class="row AuthorizeFields p-3" action="{{ route('panel.brand.claim.as.store',$brand_id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="1" name="type">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group {{ $errors->has('proof_certificate') ? 'has-error' : '' }}">
                                            <label for="proof_certificate" class="control-label">Proof of Certificate<span
                                                    class="text-danger">*</span> </label>
                                            <input required class="form-control" name="proof_certificate" type="file"
                                                id="proof_certificate">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                                            <label for="logo" class="control-label">Logo<span class="text-danger">*</span>
                                            </label>
                                            <input required class="form-control" name="logo" type="file" id="logo">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group {{ $errors->has('est_date') ? 'has-error' : '' }}">
                                            <label for="est_date" class="control-label">Established Date<span
                                                    class="text-danger">*</span> </label>
                                            <input   value="{{ old('est_date') }}" required class="form-control" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="est_date" type="date" id="est_date" >
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group {{ $errors->has('brand_name') ? 'has-error' : '' }}">
                                            <label for="brand_name" class="control-label">Brand Name<span
                                                    class="text-danger">*</span> </label>
                                            <input value="{{ old('brand_name') }}" required class="form-control" name="brand_name" type="text" id="brand_name"
                                                placeholder="Enter Brand Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                            <label for="phone" class="control-label">Address<span class="text-danger">*</span>
                                            </label>
                                            <textarea id="" cols="10" rows="5" placeholder="Enter Address" class="form-control" name="address">{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="country">{{ __('Country') }}</label>
                                            <select required name="country" id="country" class="form-control select2 country" required>
                                                <option value="" readonly>{{ __('Select Country') }}</option>
                                                @foreach (\App\Models\Country::all() as $country)
                                                    <option value="{{ $country->id }}"
                                                        @if ($country->name == 'India') selected @endif>
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>

                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="state">{{ __('State') }}</label>
                                            <select name="state" id="state" class="form-control select2 State">
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="city">{{ __('City') }}</label>
                                            <select required name="city" id="city" class="form-control select2 city">
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="city">{{ __('Pincode') }}</label>
                                            <input type="number" value="{{ old('pincode') }}" name="pincode" id="" class="form-control" placeholder="Enter Pincode">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ml-auto" id="">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Apply for AS</button>
                                        </div>
                                    </div>
                            </form>

                            {{-- Brand Owner Fields --}}
                            <form class="row brandOwnerFields p-3" action="{{ route('panel.brand.claim.bo.store',$brand_id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                 <input type="hidden" value="0" name="type">
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('proof_certificate') ? 'has-error' : '' }}">
                                        <label for="proof_certificate" class="control-label">Proof of Certificate<span
                                                class="text-danger">*</span> </label>
                                        <input required class="form-control" name="proof_certificate" type="file"
                                            id="proof_certificate">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                                        <label for="logo" class="control-label">Logo<span class="text-danger">*</span>
                                        </label>
                                        <input required class="form-control" name="logo" type="file" id="logo">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('est_date') ? 'has-error' : '' }}">
                                        <label for="est_date" class="control-label">Established Date<span
                                                class="text-danger">*</span> </label>
                                        <input  max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ old('est_date') }}" required class="form-control" name="est_date" type="date" id="est_date">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('brand_name') ? 'has-error' : '' }}">
                                        <label for="brand_name" class="control-label">Brand Name<span
                                                class="text-danger">*</span> </label>
                                        <input required class="form-control" name="brand_name" type="text" id="brand_name" placeholder="Enter Brand Name" value="{{ old('brand_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <label for="email" class="control-label">Email<span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control email" name="email" type="email" id="email"
                                            placeholder="Enter Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                        <label for="phone" class="control-label">Phone<span class="text-danger">*</span>
                                        </label>
                                        <input value="{{ old('phone') }}" class="form-control phone" name="phone" type="number" id="phone"
                                            placeholder="Enter Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                        <label for="phone" class="control-label">Address<span class="text-danger">*</span>
                                        </label>
                                        <textarea id="" cols="10" rows="5" placeholder="Enter Address" class="form-control" name="address">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="country">{{ __('Country') }}</label>
                                        <select required name="country" id="country" class="form-control select2 country" required>
                                            <option value="" readonly>{{ __('Select Country') }}</option>
                                            @foreach (\App\Models\Country::all() as $country)
                                                <option value="{{ $country->id }}"
                                                    @if ($country->name == 'India') selected @endif>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>

                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="state">{{ __('State') }}</label>
                                        <select name="state" id="state" class="form-control select2 state">
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="city">{{ __('City') }}</label>
                                        <select required name="city" id="city" class="form-control select2 city">
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="city">{{ __('Pincode') }}</label>
                                        <input type="number" value="{{ old('pincode') }}" name="pincode" id="" class="form-control" placeholder="Enter Pincode">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 ml-auto" id="">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Apply for BO</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script>
            $('.AuthorizeFields').hide();
            $('.brandOwnerFields').hide();
            $('.checkRequestType').on('click', function() {
                var value = $(this).val();
                if(value == 0){
                    $('.brandOwnerFields').show();
                    $('.AuthorizeFields').hide();
                }else{
                    $('.AuthorizeFields').show();
                    $('.brandOwnerFields').hide();
                }
            });
             $(document).ready(function(){
                $('.state, .country, .city').css('width','100%').select2();
    
                function getStates(countryId =  101) {
                    $.ajax({
                    url: '{{ route("world.get-states") }}',
                    method: 'GET',
                    data: {
                        country_id: countryId
                    },
                    success: function(res){
                        $('.state').html(res).css('width','100%').select2();
                    }
                    })
                }
                getStates(101);

                function getCities(stateId =  101) {
                    $.ajax({
                    url: '{{ route("world.get-cities") }}',
                    method: 'GET',
                    data: {
                        state_id: stateId
                    },
                    success: function(res){
                        $('.city').html(res).css('width','100%').select2();
                    }
                    })
                }
                $('.country').on('change', function(e){
                getStates($(this).val());
                })

                $('.state').on('change', function(e){
                getCities($(this).val());
                })

                // alert('s');
            });
        </script>
    @endpush
@endsection
