@extends('backend.layouts.main') 
@section('title', 'Custom Order')
@section('content')
@php
/**
 * Custom Order 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link        https://121.page/
 */
$breadcrumb_arr = [
    ['name'=>'Add Custom Order', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error{
            color:red;
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
                            <h5>Add Custom Order</h5>
                            <span>Create a record for Custom Order</span>
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
                        <h3>Create Custom Order</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.admin.enquiry.order') }}" method="post">
                            @csrf
                            <input type="hidden" name="type_id" value="{{ $par_record->type_id }}" id="">
                           
                            @php
                                $user_address = [];
                            @endphp 
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                        <label for="comment" class="control-label">{{ 'Qty' }}</label>
                                        <input required type="number" class="form-control" name="qty"  placeholder="Enter Qty">
                                    </div>
                                </div>
                                <div class="col-md-6 mx-auto">
                                    <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                        <label for="comment" class="control-label">{{ 'Price' }}</label>
                                        <input required type="number" class="form-control" name="price"  placeholder="Enter Price">
                                    </div>
                                </div>
                                    <hr>
                                    <h6 class="col-md-12">Choose User Address:</h6>
                                    @foreach($user_addresses as $user_address)
                                        @php
                                            $address_temp = json_decode($user_address->details);
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="card border p-2">
                                                <input style="position: absolute;right: 10px;"  id="adres{{ $user_address->id }}" name="address" value="{{ $user_address->id }}" type="radio" class="form-check-input address-check">
                                                <div class="mb-3">
                                                    <div class="text-dark">{{ $user_address->type == 0 ? "Home" : "Office" }}</div>
                                                        <div class="text-muted">{{ $address_temp->address_1 }}</div>
                                                        <div class="text-muted">{{ $address_temp->address_2}}</div>
                                                        <div class="text-muted">
                                                            {{ CountryById($address_temp->country) }},
                                                            {{ StateById( $address_temp->state) }}, 
                                                            {{ CityById( $address_temp->city) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Make</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#customOrderForm').validate();
                                                                                                                                                                                                                
    </script>
    @endpush
@endsection
